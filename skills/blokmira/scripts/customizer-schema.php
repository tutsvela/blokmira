<?php
/**
 * Kadence Customizer schema export (read-only).
 *
 * Prints every Kadence Theme (and Theme Kit Pro) Customizer setting as JSON:
 * key, control type, section, panel, label, default, choices, responsive flag,
 * visibility context, transport and where the value is stored. Writes nothing.
 *
 * Usage (WP-CLI):
 *   wp eval-file customizer-schema.php > kadence-customizer-schema.json
 * Optional: also load Theme Kit Pro module settings in memory only
 *   wp eval-file customizer-schema.php all-modules > kadence-customizer-schema.json
 *
 * The JSON is the machine-readable contract an agent or MCP tool uses to read
 * and validate Customizer values. Regenerate it after every Kadence update.
 */

defined( 'WP_CLI' ) || exit;

if ( 'kadence' !== get_template() ) {
	WP_CLI::error( 'Kadence is not the active parent theme.' );
}

// Optional: pretend every Theme Kit Pro module is on, for this run only.
if ( in_array( 'all-modules', (array) ( $args ?? [] ), true ) ) {
	add_filter(
		'pre_option_kadence_pro_theme_config',
		function () {
			$keys = [ 'elements', 'conditional_headers', 'header_addons', 'mega_menu', 'dark_mode', 'scripts', 'infinite', 'archive_meta', 'localgravatars', 'adv_pages', 'woocommerce_addons' ];
			return wp_json_encode( array_fill_keys( $keys, true ) );
		}
	);
}

require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
$admins = get_users( [ 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ] );
wp_set_current_user( $admins ? (int) $admins[0] : 0 );
$GLOBALS['wp_customize'] = $manager = new WP_Customize_Manager();
do_action( 'customize_register', $manager );

if ( ! class_exists( '\Kadence\Theme_Customizer' ) ) {
	WP_CLI::error( 'Kadence Theme_Customizer class not found.' );
}

$theme       = \Kadence\kadence();
$option_type = method_exists( $theme, 'get_option_type' ) ? $theme->get_option_type() : 'theme_mod';
$option_name = method_exists( $theme, 'get_option_name' ) ? $theme->get_option_name() : 'kadence_settings';
$contexts    = \Kadence\Theme_Customizer::$settings;

// Map WP section ids to panels and titles.
$sections = [];
foreach ( $manager->sections() as $id => $section ) {
	$sections[ $id ] = [
		'title' => wp_strip_all_tags( (string) $section->title ),
		'panel' => (string) $section->panel,
	];
}
$panels = [];
foreach ( $manager->panels() as $id => $panel ) {
	$panels[ $id ] = wp_strip_all_tags( (string) $panel->title );
}

/**
 * Reduce an input_attrs/options array to stable, small choice data.
 *
 * @param mixed $attrs Control input attributes.
 * @return array
 */
$choices_of = function ( $attrs ) {
	$out = [];
	if ( ! is_array( $attrs ) ) {
		return $out;
	}
	foreach ( [ 'options', 'layout' ] as $k ) {
		if ( isset( $attrs[ $k ] ) && is_array( $attrs[ $k ] ) ) {
			foreach ( $attrs[ $k ] as $value => $meta ) {
				$out[ (string) $value ] = is_array( $meta ) ? wp_strip_all_tags( (string) ( $meta['name'] ?? $meta['tooltip'] ?? '' ) ) : wp_strip_all_tags( (string) $meta );
			}
		}
	}
	return $out;
};

$rows = [];
foreach ( \Kadence\Theme_Customizer::$settings as $key => $setting ) {
	$type = $setting['control_type'] ?? '';
	// Tabs, titles and dividers are interface only: no stored value.
	$has_value = ! ( isset( $setting['settings'] ) && false === $setting['settings'] ) && ! in_array( $type, [ 'kadence_tab_control', 'kadence_title_control', 'kadence_blank_control' ], true );
	$section   = $setting['section'] ?? '';
	$sec_id    = isset( $sections[ $section ] ) ? $section : 'kadence_customizer_' . $section;
	$panel_id  = $sections[ $sec_id ]['panel'] ?? '';
	$attrs     = $setting['input_attrs'] ?? [];
	$row       = [
		'key'        => (string) $key,
		'control'    => $type,
		'section'    => $section,
		'section_title' => $sections[ $sec_id ]['title'] ?? '',
		'panel'      => $panel_id,
		'panel_title' => $panels[ $panel_id ] ?? '',
		'label'      => wp_strip_all_tags( (string) ( $setting['label'] ?? '' ) ),
		'stores_value' => $has_value,
		'transport'  => $setting['transport'] ?? 'postMessage',
		'priority'   => $setting['priority'] ?? null,
	];
	if ( $has_value ) {
		$row['default'] = method_exists( $theme, 'default' ) ? $theme->default( $key ) : ( $setting['default'] ?? null );
		$row['current'] = $theme->option( $key );
		$row['is_default'] = ( wp_json_encode( $row['current'] ) === wp_json_encode( $row['default'] ) );
		$row['storage'] = ( 'option' === $option_type ) ? "option:{$option_name}[{$key}]" : "theme_mod:{$key}";
	}
	if ( is_array( $attrs ) ) {
		$choices = $choices_of( $attrs );
		if ( $choices ) {
			$row['choices'] = $choices;
		}
		foreach ( [ 'responsive', 'units', 'min', 'max', 'step', 'allowedTypes' ] as $k ) {
			if ( isset( $attrs[ $k ] ) ) {
				$row[ $k ] = $attrs[ $k ];
			}
		}
	}
	if ( ! empty( $setting['context'] ) ) {
		$row['visible_when'] = $setting['context'];
	}
	if ( ! empty( $setting['settings'] ) && is_array( $setting['settings'] ) ) {
		$row['sub_settings'] = array_values( $setting['settings'] );
	}
	$rows[] = $row;
}

usort(
	$rows,
	function ( $a, $b ) {
		return [ $a['panel'], $a['section'], $a['priority'] ?? 0, $a['key'] ] <=> [ $b['panel'], $b['section'], $b['priority'] ?? 0, $b['key'] ];
	}
);

$theme_obj = wp_get_theme( 'kadence' );
echo wp_json_encode(
	[
		'generated'   => gmdate( 'c' ),
		'kadence'     => $theme_obj->get( 'Version' ),
		'kadence_pro' => defined( 'KTP_VERSION' ) ? KTP_VERSION : null,
		'all_modules_simulated' => in_array( 'all-modules', (array) ( $args ?? [] ), true ),
		'option_type' => $option_type,
		'option_name' => $option_name,
		'palette_option' => 'kadence_global_palette',
		'count'       => count( $rows ),
		'settings'    => $rows,
	],
	JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
) . "\n";
