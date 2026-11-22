<?php
/**
 * Kadence block schema export (read-only).
 *
 * Prints every registered Kadence block (free, Pro, Creative Kit, Shop Kit and
 * any other `kadence/` block) with its attributes, defaults, parents, supports
 * and render type, as JSON. This is the version-independent source for block
 * attribute names: trust it over any static reference. Writes nothing.
 *
 * Usage (WP-CLI):
 *   wp eval-file block-schema.php > kadence-block-schema.json
 *   wp eval-file block-schema.php kadence/rowlayout   # one block only
 */

defined( 'WP_CLI' ) || exit;

$only = (string) ( ( $args ?? [] )[0] ?? '' );
$out  = [];
foreach ( WP_Block_Type_Registry::get_instance()->get_all_registered() as $name => $type ) {
	if ( 0 !== strpos( $name, 'kadence/' ) || ( $only && $only !== $name ) ) {
		continue;
	}
	$attrs = [];
	foreach ( (array) $type->attributes as $key => $def ) {
		$row = [ 'type' => $def['type'] ?? null ];
		if ( array_key_exists( 'default', $def ) ) {
			$row['default'] = $def['default'];
		}
		if ( isset( $def['enum'] ) ) {
			$row['enum'] = $def['enum'];
		}
		if ( isset( $def['source'] ) ) {
			$row['source'] = $def['source'];
		}
		$attrs[ $key ] = $row;
	}
	$out[ $name ] = [
		'title'      => $type->title,
		'category'   => $type->category,
		'parent'     => $type->parent,
		'ancestor'   => $type->ancestor ?? null,
		'render'     => $type->render_callback ? 'dynamic (PHP)' : 'static (saved markup)',
		'supports'   => $type->supports,
		'uses_context' => $type->uses_context,
		'attributes' => $attrs,
	];
}
ksort( $out );

$plugins = [];
if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
foreach ( get_plugins() as $file => $data ) {
	if ( false !== stripos( $file, 'kadence' ) && is_plugin_active( $file ) ) {
		$plugins[ $file ] = $data['Version'];
	}
}

echo wp_json_encode(
	[
		'plugins' => $plugins,
		'count'   => count( $out ),
		'blocks'  => $out,
	],
	JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
) . "\n";
