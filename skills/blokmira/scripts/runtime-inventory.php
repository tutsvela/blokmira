<?php
defined( 'WP_CLI' ) || exit; // Read-only: prints the runtime Kadence inventory. Writes nothing.
require_once ABSPATH . 'wp-admin/includes/plugin.php';
$t = wp_get_theme( 'kadence' ); echo "THEME kadence " . $t->get( 'Version' ) . " active=" . ( get_template() === 'kadence' ? 'yes' : 'no' ) . "\n";
foreach ( get_plugins() as $f => $d ) { if ( stripos( $f, 'kadence' ) !== false ) echo "PLUGIN $f | {$d['Name']} | {$d['Version']} | active=" . ( is_plugin_active( $f ) ? 'yes' : 'no' ) . "\n"; }
// Licence status only (never keys).
global $wpdb;
foreach ( $wpdb->get_results( "SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name LIKE 'stellarwp_uplink_license_key_status_%' AND option_name NOT LIKE '%timeout'" ) as $r ) echo "LICENCE {$r->option_name} = {$r->option_value}\n";
// Blocks.
$reg = WP_Block_Type_Registry::get_instance()->get_all_registered(); $n = 0;
foreach ( $reg as $name => $bt ) { if ( preg_match( '#^kadence/|^kb-|kadence#', $name ) ) { $n++; echo "BLOCK $name | " . ( $bt->title ?: '-' ) . " | parent=" . wp_json_encode( $bt->parent ) . " | ancestor=" . wp_json_encode( $bt->ancestor ?? null ) . " | render=" . ( $bt->render_callback ? 'php' : 'static' ) . " | attrs=" . count( (array) $bt->attributes ) . " | supports=" . wp_json_encode( array_keys( (array) $bt->supports ) ) . "\n"; } }
echo "BLOCK_COUNT $n of " . count( $reg ) . "\n";
echo "OTHER_BLOCK_NS " . wp_json_encode( array_count_values( array_map( function ( $k ) { return strtok( $k, '/' ); }, array_keys( $reg ) ) ) ) . "\n";
foreach ( get_block_categories( get_post( 0 ) ?: new WP_Post( (object) [ 'ID' => 0, 'post_type' => 'post' ] ) ) as $c ) echo "BLOCKCAT {$c['slug']} | {$c['title']}\n";
$pat = WP_Block_Patterns_Registry::get_instance()->get_all_registered(); echo "PATTERNS " . count( $pat ) . " kadence=" . count( array_filter( $pat, function ( $p ) { return stripos( $p['name'], 'kadence' ) !== false; } ) ) . "\n";
foreach ( get_post_types( [], 'objects' ) as $pt ) if ( stripos( $pt->name, 'kadence' ) !== false || stripos( $pt->name, 'kb_' ) === 0 ) echo "POSTTYPE {$pt->name} | {$pt->label} | show_ui=" . var_export( $pt->show_ui, true ) . "\n";
// Theme Kit Pro modules (defaults after reset).
echo "PRO_CONFIG " . wp_json_encode( get_option( 'kadence_pro_theme_config' ) ) . "\n";
if ( class_exists( 'Kadence_Theme_Pro' ) ) echo "PRO_CLASS yes\n";
// Customizer.
require_once ABSPATH . WPINC . '/class-wp-customize-manager.php';
wp_set_current_user( 1 );
$GLOBALS['wp_customize'] = $m = new WP_Customize_Manager();
do_action( 'customize_register', $m );
foreach ( $m->panels() as $id => $p ) echo "CPANEL $id | " . wp_strip_all_tags( $p->title ) . " | prio={$p->priority}\n";
foreach ( $m->sections() as $id => $s ) echo "CSECTION $id | " . wp_strip_all_tags( $s->title ) . " | panel={$s->panel} | type={$s->type}\n";
$types = []; foreach ( $m->controls() as $id => $c ) { $types[ $c->type ] = ( $types[ $c->type ] ?? 0 ) + 1; echo "CCONTROL $id | section={$c->section} | type={$c->type} | " . wp_strip_all_tags( (string) $c->label ) . "\n"; }
echo "CCONTROL_TYPES " . wp_json_encode( $types ) . " total=" . count( $m->controls() ) . " settings=" . count( $m->settings() ) . "\n";
