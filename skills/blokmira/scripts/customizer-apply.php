<?php
/**
 * Kadence Customizer apply / revert (dry run by default).
 *
 * Changes Kadence Theme Customizer values from a JSON file, the same way the
 * Customizer stores them, after validating every key against the live
 * Customizer registry. Default is a dry run that prints the diff only.
 *
 * Usage (WP-CLI):
 *   wp eval-file customizer-apply.php changes.json                     # dry run, prints diff
 *   wp eval-file customizer-apply.php changes.json apply backup.json   # writes, saves previous values first
 *   wp eval-file customizer-apply.php backup.json revert               # restores a backup
 *
 * changes.json:
 *   {
 *     "settings": { "<setting key>": <value or partial value>, ... },
 *     "palette":  { "palette1": "#D9480F", ... },   // optional, edits the active palette set
 *     "palette_active": "palette",                   // optional: palette | second-palette | third-palette
 *     "merge": true                                   // optional, default true: deep-merge objects into the stored value
 *   }
 *
 * Changing global Customizer settings is a site-wide change: get the site
 * owner's consent, run on staging or a local copy first, keep the backup.
 */

defined( 'WP_CLI' ) || exit;

$argv_in = array_values( (array) ( $args ?? [] ) );
$file    = $argv_in[0] ?? '';
$mode    = $argv_in[1] ?? 'dry-run';
$backup  = $argv_in[2] ?? '';

if ( 'kadence' !== get_template() ) {
	WP_CLI::error( 'Kadence is not the active parent theme.' );
}
if ( ! $file || ! is_readable( $file ) ) {
	WP_CLI::error( 'Pass a readable JSON file as the first argument.' );
}
$input = json_decode( (string) file_get_contents( $file ), true );
if ( ! is_array( $input ) ) {
	WP_CLI::error( 'The JSON file is not valid JSON.' );
}

$theme       = \Kadence\kadence();
$option_type = $theme->get_option_type();
$option_name = $theme->get_option_name();

/** Raw stored value (null when never saved). */
$read_raw = function ( $key ) use ( $option_type, $option_name ) {
	if ( 'option' === $option_type ) {
		$all = get_option( $option_name, [] );
		return is_array( $all ) && array_key_exists( $key, $all ) ? $all[ $key ] : null;
	}
	return get_theme_mod( $key, null );
};
/** Write or delete (null) a stored value. */
$write_raw = function ( $key, $value ) use ( $option_type, $option_name ) {
	if ( 'option' === $option_type ) {
		$all = get_option( $option_name, [] );
		$all = is_array( $all ) ? $all : [];
		if ( null === $value ) {
			unset( $all[ $key ] );
		} else {
			$all[ $key ] = $value;
		}
		update_option( $option_name, $all );
		return;
	}
	null === $value ? remove_theme_mod( $key ) : set_theme_mod( $key, $value );
};
$sanitize_deep = function ( $value ) use ( &$sanitize_deep ) {
	if ( is_array( $value ) ) {
		$out = [];
		foreach ( $value as $k => $v ) {
			$out[ is_int( $k ) ? $k : (string) $k ] = $sanitize_deep( $v );
		}
		return $out;
	}
	if ( is_bool( $value ) || is_int( $value ) || is_float( $value ) || null === $value ) {
		return $value;
	}
	return (string) $value;
};
$merge = function ( $base, $patch ) use ( &$merge ) {
	if ( ! is_array( $base ) || ! is_array( $patch ) || array_keys( $patch ) === range( 0, count( $patch ) - 1 ) ) {
		return $patch;
	}
	foreach ( $patch as $k => $v ) {
		$base[ $k ] = ( isset( $base[ $k ] ) && is_array( $base[ $k ] ) && is_array( $v ) ) ? $merge( $base[ $k ], $v ) : $v;
	}
	return $base;
};

// Revert mode: restore a backup written by apply mode.
if ( 'revert' === $mode ) {
	if ( empty( $input['previous'] ) || ! is_array( $input['previous'] ) ) {
		WP_CLI::error( 'Not a backup file (no "previous" map).' );
	}
	foreach ( $input['previous'] as $key => $value ) {
		if ( '__palette' === $key ) {
			null === $value ? delete_option( 'kadence_global_palette' ) : update_option( 'kadence_global_palette', $value );
		} else {
			$write_raw( (string) $key, $value );
		}
		WP_CLI::log( "reverted {$key}" );
	}
	WP_CLI::success( 'Backup restored.' );
	return;
}

// Load the live registry so keys and choices are validated against this install.
require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
$admins = get_users( [ 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ] );
wp_set_current_user( $admins ? (int) $admins[0] : 0 );
$GLOBALS['wp_customize'] = $manager = new WP_Customize_Manager();
do_action( 'customize_register', $manager );
$registry = \Kadence\Theme_Customizer::$settings;

$do_merge = ! isset( $input['merge'] ) || false !== $input['merge'];
$errors   = [];
$planned  = [];

foreach ( (array) ( $input['settings'] ?? [] ) as $key => $value ) {
	$key = (string) $key;
	if ( ! isset( $registry[ $key ] ) || ( isset( $registry[ $key ]['settings'] ) && false === $registry[ $key ]['settings'] ) ) {
		$errors[] = "{$key}: not a Kadence Customizer setting on this site (check the module is on and the plugin it needs is active).";
		continue;
	}
	$setting = $registry[ $key ];
	$value   = $sanitize_deep( $value );
	$default = $theme->default( $key );
	// Shape check: object settings need objects, scalar settings need scalars.
	if ( is_array( $default ) !== is_array( $value ) && ! ( null === $default ) ) {
		$errors[] = "{$key}: expected " . ( is_array( $default ) ? 'an object/array' : 'a scalar' ) . ' like the default ' . wp_json_encode( $default );
		continue;
	}
	// Choice check for select/radio style controls.
	$options = $setting['input_attrs']['options'] ?? ( $setting['input_attrs']['layout'] ?? null );
	if ( is_array( $options ) && $options && ! in_array( $setting['control_type'] ?? '', [ 'kadence_sorter_control', 'kadence_builder_control' ], true ) ) {
		$allowed = array_map( 'strval', array_keys( $options ) );
		$check   = is_array( $value ) ? array_filter( array_intersect_key( $value, array_flip( [ 'desktop', 'tablet', 'mobile' ] ) ), 'is_scalar' ) : [ $value ];
		foreach ( $check as $v ) {
			if ( '' !== (string) $v && ! in_array( (string) $v, $allowed, true ) ) {
				$errors[] = "{$key}: '{$v}' is not one of " . implode( ', ', $allowed );
			}
		}
	}
	$before  = $read_raw( $key );
	$current = null === $before ? $default : $before;
	$new     = $do_merge ? $merge( $current, $value ) : $value;
	if ( wp_json_encode( $new ) === wp_json_encode( $current ) ) {
		continue;
	}
	$planned[ $key ] = [ 'before' => $before, 'after' => $new ];
}

// Palette edits.
$palette_before = get_option( 'kadence_global_palette', null );
$palette_after  = null;
if ( ! empty( $input['palette'] ) || ! empty( $input['palette_active'] ) ) {
	$pal = json_decode( (string) $theme->get_palette_for_customizer(), true );
	if ( ! empty( $input['palette_active'] ) ) {
		if ( ! in_array( $input['palette_active'], [ 'palette', 'second-palette', 'third-palette' ], true ) ) {
			$errors[] = 'palette_active must be palette, second-palette or third-palette.';
		} else {
			$pal['active'] = $input['palette_active'];
		}
	}
	$set = $pal['active'] ?? 'palette';
	foreach ( (array) ( $input['palette'] ?? [] ) as $slug => $color ) {
		$color = sanitize_hex_color( (string) $color ) ?: ( preg_match( '/^rgba?\([0-9.,\s%]+\)$/', (string) $color ) ? (string) $color : '' );
		if ( '' === $color ) {
			$errors[] = "palette.{$slug}: not a hex or rgb(a) colour.";
			continue;
		}
		$found = false;
		foreach ( $pal[ $set ] as $i => $row ) {
			if ( ( $row['slug'] ?? '' ) === $slug ) {
				$pal[ $set ][ $i ]['color'] = $color;
				$found                      = true;
			}
		}
		if ( ! $found ) {
			$errors[] = "palette.{$slug}: no such slot in {$set}.";
		}
	}
	$palette_after = wp_json_encode( $pal );
}

if ( $errors ) {
	foreach ( $errors as $e ) {
		WP_CLI::warning( $e );
	}
	WP_CLI::error( count( $errors ) . ' problem(s). Nothing was written.' );
}

echo wp_json_encode(
	[
		'mode'    => $mode,
		'storage' => 'option' === $option_type ? "option:{$option_name}" : 'theme_mods_' . get_stylesheet(),
		'changes' => $planned,
		'palette' => null === $palette_after ? null : [ 'before' => $palette_before, 'after' => $palette_after ],
	],
	JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
) . "\n";

if ( 'apply' !== $mode ) {
	WP_CLI::success( 'Dry run only. Add "apply <backup.json>" to write.' );
	return;
}
if ( ! $backup ) {
	WP_CLI::error( 'Apply needs a backup file path as the third argument.' );
}
$previous = [];
foreach ( $planned as $key => $row ) {
	$previous[ $key ] = $row['before'];
}
if ( null !== $palette_after ) {
	$previous['__palette'] = $palette_before;
}
if ( false === file_put_contents( $backup, wp_json_encode( [ 'created' => gmdate( 'c' ), 'previous' => $previous ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) ) ) {
	WP_CLI::error( "Could not write backup to {$backup}. Nothing was written." );
}
foreach ( $planned as $key => $row ) {
	$write_raw( $key, $row['after'] );
}
if ( null !== $palette_after ) {
	update_option( 'kadence_global_palette', $palette_after );
}
WP_CLI::success( count( $planned ) . ' setting(s) written' . ( null !== $palette_after ? ' and palette updated' : '' ) . ". Backup: {$backup}" );
