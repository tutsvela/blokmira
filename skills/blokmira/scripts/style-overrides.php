<?php
/**
 * Style override scan (read-only).
 *
 * Before planning Customizer or palette changes, find CSS outside the
 * Customizer that can override them: child theme stylesheets, Additional CSS
 * (Customizer > Additional CSS) and a child theme.json. Reports font families,
 * hard-coded colours, redefined Kadence variables and !important rules, with
 * file and line. Writes nothing.
 *
 * Usage (WP-CLI):
 *   wp eval-file style-overrides.php            # summary plus findings
 *   wp eval-file style-overrides.php json       # machine-readable
 */

defined( 'WP_CLI' ) || exit;

$as_json  = in_array( 'json', (array) ( $args ?? [] ), true );
$child    = get_stylesheet_directory();
$parent   = get_template_directory();
$findings = [];
$sources  = [];

/**
 * Scan one CSS text and add findings.
 *
 * @param string $label  Source label.
 * @param string $css    CSS text.
 */
$scan = function ( $label, $css ) use ( &$findings, &$sources ) {
	$sources[ $label ] = strlen( $css );
	$lines             = preg_split( '/\R/', $css );
	foreach ( $lines as $i => $line ) {
		$n = $i + 1;
		if ( preg_match( '/--global-(palette\d+|[a-z-]*font[a-z-]*|content-width|[a-z-]*spacing)\s*:/i', $line, $m ) ) {
			$findings[] = [ 'source' => $label, 'line' => $n, 'type' => 'redefines Kadence variable', 'match' => trim( $m[0] ) ];
		}
		if ( preg_match( '/font-family\s*:\s*([^;}{]+)/i', $line, $m ) && ! preg_match( '/var\(--global-/i', $m[1] ) && ! preg_match( '/^\s*(inherit|initial|unset)\s*$/i', $m[1] ) ) {
			$findings[] = [ 'source' => $label, 'line' => $n, 'type' => 'hard-coded font-family', 'match' => trim( $m[1] ) ];
		}
		if ( preg_match_all( '/(?<![\w-])(color|background(?:-color)?|border(?:-color)?|fill|stroke)\s*:\s*[^;}{]*?(#[0-9a-f]{3,8}\b|rgba?\([^)]*\)|hsla?\([^)]*\))/i', $line, $mm, PREG_SET_ORDER ) ) {
			foreach ( $mm as $m ) {
				$findings[] = [ 'source' => $label, 'line' => $n, 'type' => 'hard-coded colour', 'match' => $m[1] . ': ' . $m[2] ];
			}
		}
		if ( false !== stripos( $line, '!important' ) ) {
			$findings[] = [ 'source' => $label, 'line' => $n, 'type' => '!important', 'match' => trim( substr( $line, 0, 140 ) ) ];
		}
	}
};

// 1. Child theme stylesheets (only when a child theme is active).
if ( $child !== $parent ) {
	$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $child, FilesystemIterator::SKIP_DOTS ) );
	foreach ( $it as $file ) {
		$path = $file->getPathname();
		if ( preg_match( '/\.css$/i', $path ) && ! preg_match( '#/(node_modules|vendor)/#', $path ) && ! preg_match( '/\.min\.css$/i', $path ) ) {
			$scan( 'child-theme:' . ltrim( str_replace( $child, '', $path ), '/' ), (string) file_get_contents( $path ) );
		}
	}
	if ( is_readable( $child . '/theme.json' ) ) {
		$findings[] = [ 'source' => 'child-theme:theme.json', 'line' => 0, 'type' => 'child theme.json present', 'match' => 'can redefine palette, fonts and layout presets' ];
	}
}

// 2. Additional CSS from the Customizer.
$custom_css = (string) wp_get_custom_css();
if ( '' !== trim( $custom_css ) ) {
	$scan( 'customizer:additional-css', $custom_css );
}

// 3. Enqueued front-end stylesheets that are not Kadence, core or the child theme (names only).
$others = [];
do_action( 'wp_enqueue_scripts' );
foreach ( wp_styles()->queue as $handle ) {
	$src = (string) ( wp_styles()->registered[ $handle ]->src ?? '' );
	if ( '' !== $src && ! preg_match( '#/(themes/kadence|plugins/kadence-|wp-includes)/#', $src ) && false === strpos( $src, basename( $child ) ) ) {
		$others[] = $handle . ' ' . $src;
	}
}

$summary = [];
foreach ( $findings as $f ) {
	$summary[ $f['type'] ] = ( $summary[ $f['type'] ] ?? 0 ) + 1;
}

if ( $as_json ) {
	echo wp_json_encode(
		[
			'child_theme'   => $child !== $parent ? get_stylesheet() : null,
			'sources'       => $sources,
			'summary'       => $summary,
			'findings'      => $findings,
			'other_styles'  => $others,
		],
		JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
	) . "\n";
	return;
}

WP_CLI::log( 'Child theme: ' . ( $child !== $parent ? get_stylesheet() : 'none (parent theme active)' ) );
WP_CLI::log( 'Scanned: ' . ( $sources ? implode( ', ', array_keys( $sources ) ) : 'nothing' ) );
foreach ( $summary as $type => $count ) {
	WP_CLI::log( sprintf( '%-28s %d', $type, $count ) );
}
foreach ( $findings as $f ) {
	WP_CLI::log( "{$f['source']}:{$f['line']}  {$f['type']}  {$f['match']}" );
}
if ( $others ) {
	WP_CLI::log( 'Other enqueued stylesheets (check them too): ' . implode( '; ', $others ) );
}
WP_CLI::log( $findings ? 'Customizer font or colour changes may not show where these rules apply. Plan with the owner before changing either side.' : 'No overrides found.' );
