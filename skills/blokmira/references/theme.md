# Kadence Theme (free parent theme): architecture, builders, layouts and hooks

Purpose: a verified reference for picking the right native Kadence Theme setting, template override or hook before writing any custom code.

Versions studied: Kadence Theme 1.6.0 (`themes/kadence/`), with Theme Kit Pro 1.2.6 (`plugins/kadence-pro/`) only where it hooks into the theme. Runtime data: the runtime capture (Pro modules at default) and the runtime capture with all Theme Kit Pro modules on (all Pro modules on).

Contents
1. Architecture
2. Header Builder
3. Footer Builder
4. Page, post, archive, search, 404 and CPT layouts
5. Per-post overrides (editor meta panel)
6. Theme hooks reference
7. Custom PHP on hooks vs Theme Kit Pro Elements
8. Gaps and how to check them

Tag legend: `[code]` installed source (paths relative to `themes/kadence/` unless they start with `kadence-pro/` or `kadence-blocks/`), `[runtime]` Customizer capture, `[Theme Kit Pro]` needs Theme Kit Pro, `[unverified]` not confirmed. For global colors, fonts, widths and CSS variables see `theme-global-design.md`. For Pro header items and Elements details see `theme-kit-pro-elements.md`.

---

## 1. Architecture

### 1.1 Boot sequence
- `functions.php:12` defines `KADENCE_VERSION` 1.6.0. Minimum WordPress 6.6 and PHP 7.4 (`functions.php:13-14`); below that it loads `inc/back-compat.php` only [code].
- `functions.php:22-31` loads the prefixed vendor autoloader, `inc/wordpress-shims.php`, `inc/class-theme.php` and `inc/functions.php` [code].
- `inc/class-theme.php:295-322` builds the theme from components. Each component is a class in `inc/components/<name>/component.php` that implements `Component_Interface` and can expose template tags through `kadence()->method()` [code].
- Core components, in load order (`inc/class-theme.php:297-322`): Options, Localization, Base_Support, Editor, Accessibility, Image_Sizes, AMP, Microdata, Comments, Nav_Menus, Custom_Header, Custom_Footer, Custom_Logo, Color_Palette, Styles, Scripts, Breadcrumbs, Template_Parts, Clean_Frontend, Icons, Layout, Entry_Title, Archive_Title, Third_Party, Style_Guide [code].
- Integration components load only when the plugin is present (`inc/class-theme.php:325-385`): Elementor, Elementor Pro, Beaver, Beaver Themer, TutorLMS, WooCommerce, Heroic KB, Jetpack, LifterLMS, LearnDash, Essential Real Estate, Restrict Content Pro, Estatik, bbPress, BuddyBoss, Polylang, Rank Math, The Events Calendar, Give, Zoom Recipe Card, SureCart [code].

### 1.2 Key components and what they own
| Component | File | Owns |
|---|---|---|
| Options | `inc/components/options/component.php` | All defaults (`kadence_theme_options_defaults` filter at :260), option storage (theme_mod by default, `kadence_theme_option_type` :226, name `kadence_settings` via `kadence_theme_option_name` :241), the global palette (:4930-5050) [code] |
| Styles | `inc/components/styles/component.php` | Front-end CSS files (:4506), inline dynamic CSS (`kadence_dynamic_css` :125), header CSS (:728), footer CSS (:378), base and global vars (:1702), editor CSS (:3202), Google fonts (:4699) [code] |
| Editor | `inc/components/editor/component.php` | Block editor support, theme.json handling, admin body classes for layout preview [code] |
| Color_Palette | `inc/components/color_palette/component.php` | `kadence_global_palette` setting and the `editor-color-palette` theme support [code] |
| Layout | `inc/components/layout/component.php` | Sidebars, per-page layout resolution (`check_conditionals` :486), body classes (:884) [code] |
| Custom_Header / Custom_Footer | `inc/components/custom_header/component.php`, `inc/components/custom_footer/component.php` | Rendering builder rows and columns [code] |
| Entry_Title / Archive_Title | `inc/components/entry_title/component.php`, `inc/components/archive_title/component.php` | Rendering title area elements in configured order [code] |
| Breadcrumbs | `inc/components/breadcrumbs/component.php` | Built-in breadcrumbs, or Rank Math / Yoast / SEOPress output (:103-115) [code] |
| Meta | `inc/meta/class-theme-meta.php` | Per-post layout meta and the editor sidebar panel [code] |
| Customizer | `inc/customizer/class-theme-customizer.php` + `inc/customizer/options/*.php` | Panels, sections, controls (one options file per section) [code] |

### 1.3 How templates are assembled
The root templates are thin. Almost everything is printed by functions attached to theme actions in `inc/template-hooks.php` [code].

| Request | Root file | Chain |
|---|---|---|
| Any page | `header.php` | `kadence_before_wrapper` (:33) > `#wrapper` > `kadence_before_header` (:42) > `kadence_header` (:49, prints `header_markup`) > `kadence_after_header` (:51) > `<main id="inner-wrap">` > `kadence_before_content` (:59) [code] |
| Single, page, 404 | `single.php:20`, `page.php:20`, `404.php:22` | `kadence_single` > `single_markup()` (`inc/template-functions/single-functions.php:18`) > `template-parts/content/single.php` > `kadence_hero_header` (title above content) > `#primary .content-container.site-container` > `kadence_before_main_content` > `kadence_single_content` (or `kadence_404_content`) > `kadence_after_main_content` > `get_sidebar()` [code] |
| Single entry | `template-parts/content/single-entry.php` | featured image above/behind > `<article>` > `kadence_single_before_inner_content` (:19) > in-content title (`entry_header`) > image below > `entry_content` > tags footer > `kadence_single_after_inner_content` (:33) > `kadence_single_after_content` (:42) > author box, post navigation, related posts, comments [code] |
| Archives, blog, search | `index.php:20` | `kadence_archive` > `archive_markup()` (`inc/template-functions/archive-functions.php:17`) > `template-parts/content/archive.php` > `kadence_hero_header` > `kadence_before_main_content` > in-content archive title > `<ul id="archive-container">` with `kadence_loop_entry` per post > pagination > `kadence_after_main_content` > sidebar [code] |
| Footer | `footer.php` | `kadence_after_content` (:21) > `</main>` > `kadence_before_footer` (:25) > `kadence_footer` (:31) > `kadence_after_footer` (:33) > `</div>#wrapper` > `kadence_after_wrapper` (:36) [code] |

Template part names include the post type: `get_template_part( 'template-parts/content/single', get_post_type() )` (`single-functions.php:19`), `single-entry` (:26), `archive` (`archive-functions.php:18`), `entry` (:178). A child theme can therefore add `template-parts/content/single-entry-{post_type}.php` to change one CPT without touching others [code]. Use this sparingly: it forks the template and misses future theme fixes.

Off-canvas and modal markup is printed in `wp_footer`: mobile drawer `navigation_popup()` (`inc/template-functions/header-functions.php:502`), search modal (:1050), cart popup (:798, :900), scroll-to-top (`inc/template-hooks.php:277`) [code].

### 1.4 theme.json role
- `theme.json` (version 3) defines 15 palette slots that point at `var(--global-paletteN)`, `contentSize`/`wideSize` from `--global-calc-content-width` / `--global-calc-wide-content-width`, spacing presets `xs`..`xxl` mapped to `--global-*-spacing`, font sizes `small`..`xxlarge` mapped to `--global-font-size-*`, viewports 767px/1024px, and turns off core button element styles (`theme.json:94-201`) [code].
- By default the file is NOT read. `disable_json_optionally()` redirects WordPress to a missing file unless FSE mode or the Customizer option `theme_json_mode` ("Enable Optimized Group Block", General > Performance) is on (`inc/components/editor/component.php:289-300`; label `inc/customizer/options/general-performance-options.php:39`) [code][runtime].
- Instead, `edit_theme_json()` injects a version 2 data set through `wp_theme_json_data_theme` (`inc/components/editor/component.php:44`, `:90-283`). It has the same palette, layout and font sizes, but no `spacingSizes` presets [code]. Practical effect: the spacing preset slider (`xs`..`xxl`) in core blocks appears only when `theme_json_mode` is on [code; check in editor to confirm UI].
- Values in both versions are CSS variables, so changing the Customizer palette updates every block that uses a palette slot without touching theme.json [code].

### 1.5 Block editor compatibility
- Theme supports: `post-thumbnails`, `editor-styles`, `align-wide`, `custom-spacing`, and `block-templates` unless filtered off with `kadence-theme-block-templates-support` (`inc/components/editor/component.php:436-450`). The theme deliberately does not add `wp-block-styles` (:444) [code].
- Editor stylesheet: `assets/css/editor/editor-styles.min.css` via `add_editor_style` (`inc/components/styles/component.php:4338-4341`) [code].
- Editor dynamic CSS: `generate_editor_css()` (`styles/component.php:3202`) builds the same `--global-*` variables, fonts and button styles for `.editor-styles-wrapper`. It is attached to an inline style `kadence-editor-global` (:4359-4363), which is added as a dependency of `wp-block-library` so it loads in the editor iframe (:4382-4399) [code].
- Google fonts load in the editor too (`google_font_add_editor_styles`, `editor/component.php:304-323`) [code].
- How the palette reaches the editor: (1) `add_theme_support( 'editor-color-palette' )` with 15 `theme-paletteN` slugs whose color is the resolved hex (`inc/components/color_palette/component.php:147-226`); (2) theme.json palette entries whose color is `var(--global-paletteN)`; (3) `:root .has-theme-paletteN-color` and `-background-color` classes in front-end and editor CSS (`styles/component.php:3275+`, `assets/css/global.min.css`) [code].
- Layout preview in the editor: `filter_admin_body_class()` adds the resolved post layout (sidebar, title position, boxed, vertical padding) as admin body classes so the canvas width matches the front end (`editor/component.php:340-430`) [code].
- Full Site Editing mode (Alpha, new in 1.6.0) [code]:
  - Stored in the site option `kadence_fse_mode` with values `enabled` / `disabled`; absent means off (`src/FSE/Mode.php:22-36`, `:74-76`). It also needs WordPress 7.1 or later, otherwise `is_enabled()` is false (`Mode.php:43`, `:52-54`). Changelog: "off by default. Turned on in Appearance > Kadence" (`changelog.txt:2`).
  - Toggled from the Kadence dashboard through REST routes `kadence/v1/fse-mode` and `kadence/v1/fse-repair`, capability `edit_theme_options` (`src/FSE/Rest.php:27-48`, `:98-133`, `:183`).
  - When off, only a "classic shield" runs so saved block templates cannot replace the classic PHP templates (`src/FSE/FSE_Provider.php:30-38`, `src/FSE/Classic_Shield.php`).
  - When on: core treats the theme as a block theme (`Block_Theme_Index.php`, points at `fse/site-templates/index.html`); block templates `fse/site-templates/` (index, single, page, archive, search, 404), parts `fse/parts/` (header, footer, navigation-overlay) and patterns `fse/patterns/` (several headers and footers, loop entry, entry meta, 404, no results) are served to the Site Editor (`src/FSE/Templates.php`); the Site Editor owns the 15 palette colors (`Palette_Shim.php`: `--global-paletteN` becomes `var(--wp--preset--color--theme-palette-N)`), content and wide widths (`Layout_Widths.php`), fonts (`Font_Families.php`, `Typography_Feed.php`) and button styles (`Button_Styles.php`); the Customizer hides sections that no longer apply (`Customizer_Sections.php`); a repair checklist lists what to rebuild in the Site Editor (`Repair.php`). The Customizer palette control is replaced with a notice (`color_palette/component.php:87-115`).
  - Practical: the Header and Footer Builders, Elements placements and theme hooks described in this file are the classic mode. Do not switch a built classic site to FSE mode without a full rebuild plan.
- Kadence Blocks design tokens (Blocks 3.8.0+): the theme has no sync code of its own (searched for `design_tokens`, `palette_sync`, `kadence_blocks` in the theme; only the block header and editor width hooks were found, `inc/components/editor/component.php:39-41`) [code]. The integration lives in Kadence Blocks: it reads the theme option `kadence_global_palette` with `get_option()` (`kadence-blocks/includes/resources/Design_Tokens/Theme_Style_Guide/Style_Guide_Reader.php:30`, `:117`) and overrides palette colors at read time through the theme filter `kadence_palette_option` (`kadence-blocks/includes/resources/Design_Tokens/Projection/Kadence_Option/Provider.php:44`, `Palette_Filter.php`), without writing the theme option [code]. See `theme-global-design.md` section 2.6.
- Block header alternative: Header Layout section control `blocks_header` ("Enable Block Header") and `blocks_header_id` replace the whole builder header with a Kadence Blocks Advanced Header post (`kadence_header` post type). Only offered when Kadence Blocks 3.3.0 or later is active (`inc/customizer/options/header-builder-options.php:361-391`; render `inc/template-functions/header-functions.php:21-27`) [code][runtime].

---

## 2. Header Builder

Location: Customizer > Header (panel `kadence_customizer_header`) [runtime]. Builder and layout sections: `kadence_customizer_header_builder` (controls `header_desktop_items`, `header_mobile_items`) and `kadence_customizer_header_layout` (`header_desktop_available_items`, `header_mobile_available_items`, `header_transparent_link`, `header_sticky_link`, `header_wrap_background`, `header_mobile_switch`, `blocks_header`, `blocks_header_id`) [runtime]. Options are stored under these keys in theme mods.

### 2.1 Rows and columns
- Desktop rows: `top`, `main`, `bottom`. Each row has 5 zones: `left`, `left_center`, `center`, `right_center`, `right`, saved as `top_left`, `main_center` etc. (`inc/customizer/options/header-builder-options.php:104-130`) [code].
- Mobile rows: `top`, `main`, `bottom` with 3 zones each (`left`, `center`, `right`) plus a `popup` row with one zone `popup_content` (the off-canvas drawer) (`header-builder-options.php:225-252`) [code].
- Default layout: desktop logo in `main_left`, primary navigation in `main_right`; mobile logo in `main_left`, trigger in `main_right`, mobile navigation in `popup_content` (`inc/components/options/component.php:899-921`, `:1051-1070`) [code].
- Gotcha: `left_center` and `right_center` print only when the row's `center` zone has items (`template-parts/header/header-row.php:28-90`). A row prints only if left, center or right has items (`inc/components/custom_header/component.php:95-103`) [code]. Put something in center, or use left/right.
- Each item is rendered with `get_template_part( 'template-parts/header/' . $item )`, filterable with `kadence_header_elements_template_path` (`custom_header/component.php:205-213`) [code].
- Row sections (both desktop and mobile share them): `kadence_customizer_header_top`, `_main`, `_bottom`. Controls per row: `header_{row}_layout` (standard / fullwidth / contained), `header_{row}_height`, `header_{row}_background`, `header_{row}_border`, `header_{row}_trans_background`, `header_{row}_padding` [runtime].
- Mobile switch point: `header_mobile_switch` (range, default empty, meaning the tablet breakpoint) (`header-builder-options.php:334`, default `options/component.php:894`) [code][runtime].

### 2.2 Desktop items (free theme)
Choices from `header-builder-options.php:74-102`, plus Cart when WooCommerce is active (`inc/customizer/class-theme-customizer.php:249-264`) [code].

| Item key | Name | Customizer section | Main controls [runtime] |
|---|---|---|---|
| `logo` | Logo | `title_tagline` (Site Identity) | `logo_width`, `use_mobile_logo`, `mobile_logo`, `use_logo_icon`, `logo_icon`, `logo_layout`, `brand_typography`, `brand_typography_color`, `brand_tag_typography`, `header_logo_padding`, `custom_logo` |
| `navigation` | Primary Navigation (menu location `primary`) | `kadence_customizer_primary_navigation` | `primary_navigation_spacing`, `_open_type`, `_stretch`, `_fill_stretch`, `_style`, `_vertical_spacing`, `_color`, `_background`, `_parent_active`, `_typography`, `primary_dropdown_link` |
| `navigation-2` | Secondary Navigation (location `secondary`) | `kadence_customizer_secondary_navigation` | same pattern with `secondary_` prefix |
| (dropdowns) | Dropdown Navigation | `kadence_customizer_dropdown_navigation` (+ `_design`) | `dropdown_navigation_reveal`, `_width`, `_vertical_spacing`, `_color`, `_background`, `_divider`, `_border_radius`, `_typography`, `_shadow` |
| `search` | Search (icon opens full-screen modal) | `kadence_customizer_header_search` | `header_search_label`, `_label_visiblity`, `_icon`, `_style`, `_border`, `_icon_size`, `_color`, `_background`, `_typography`, `_padding`, `_margin`, `header_search_modal_color`, `header_search_modal_background` |
| `button` | Button | `kadence_customizer_header_button` (+ `_design`) | `header_button_label`, `_link`, `_target`, `_nofollow`, `_sponsored`, `_download`, `_style`, `_visibility`, `_size`, `_padding`, `_color`, `_background`, `_border_colors`, `_border`, `_radius`, `_typography`, `_shadow`, `_shadow_hover`, `_margin` |
| `social` | Social | `kadence_customizer_header_social` (+ `_design`) | `header_social_items`, `_show_label`, `_item_spacing`, `_style`, `_icon_size`, `_brand`, `_color`, `_background`, `_border`, `_border_radius`, `_typography`, `_margin`. URLs come from General > Social Links (`kadence_customizer_general_social`) |
| `html` | HTML | `kadence_customizer_header_html` (+ `_design`) | `header_html_content` (editor), `header_html_wpautop`, `header_html_typography`, `_link_style`, `_link_color`, `_margin` |
| `cart` | Cart (WooCommerce only) | `kadence_customizer_cart` | see WooCommerce options |

### 2.3 Mobile items (free theme)
Choices from `header-builder-options.php:192-224` [code].

| Item key | Section | Main controls [runtime] |
|---|---|---|
| `mobile-logo` | `title_tagline` | uses Site Identity logo settings |
| `mobile-navigation` (location `mobile`) | `kadence_customizer_mobile_navigation` | `mobile_navigation_color`, `_background`, `_divider`, `_typography`, `_vertical_spacing`, `_collapse`, `_parent_toggle` |
| `search` | `kadence_customizer_header_search` | shared with desktop |
| `mobile-button` | `kadence_customizer_mobile_button` (+ `_design`) | `mobile_button_style`, `_size`, `_label`, `_link`, `_target`, `_nofollow`, `_sponsored`, `_visibility`, colors, border, radius, typography, shadow, margin |
| `mobile-social` | `kadence_customizer_mobile_social` (+ `_design`) | `header_mobile_social_items`, `_show_label`, `_item_spacing`, `_style`, `_icon_size`, `_brand`, colors, border, typography, margin |
| `mobile-html` | `kadence_customizer_mobile_html` | `mobile_html_content`, `_wpautop`, `_typography`, `_link_color`, `_link_style`, `_margin` |
| `popup-toggle` | `kadence_customizer_mobile_trigger` (+ `_design`) | `mobile_trigger_label`, `_icon`, `mobile_trigger_drawer_link`, `_style`, `_border`, `_icon_size`, `_color`, `_background`, `_typography`, `_padding` |
| `mobile-cart` | `kadence_customizer_mobile_cart` (WooCommerce only) | |

### 2.4 Mobile drawer (off-canvas)
- Section `kadence_customizer_header_popup` "Header Off Canvas" (+ `_design`) [runtime].
- Controls: `header_popup_layout` (fullwidth / sidepanel), `header_popup_side` (left / right), `header_popup_width`, `header_popup_content_max_width`, `enable_popup_body_animate`, `header_popup_animation` (fade / scale / slice), `header_popup_content_align`, `header_popup_vertical_align`, `header_popup_background`, `header_popup_close_icon_size`, `_close_color`, `_close_background`, `_close_padding` (`inc/customizer/options/header-popup-options.php:48`, `:78`, `:229`) [code][runtime].
- Markup: `#mobile-drawer` with hooks `kadence_before_mobile_navigation_popup` and `kadence_after_mobile_navigation_popup` around the `popup_content` items (`inc/template-functions/header-functions.php:554-597`) [code].
- Any mobile item can go into the drawer by dragging it to the Off Canvas zone [code: zone `popup_content`].

### 2.5 Transparent header
- Section `kadence_customizer_transparent_header` (+ `_design`) [runtime].
- Global: `transparent_header_enable`; "Disable" toggles `transparent_header_archive` (search and archives), `transparent_header_page`, `transparent_header_post`; `transparent_header_device` (desktop/mobile); custom logos `transparent_header_custom_logo`, `transparent_header_logo`, `transparent_header_logo_width`, `transparent_header_custom_mobile_logo`, `transparent_header_mobile_logo` (`inc/customizer/options/transparent-header-options.php:48-140`) [code][runtime].
- Per CPT: one "Disable on {CPT}?" toggle per public CPT, key `transparent_header_{post_type}` (`transparent-header-options.php:870`). Excluded types: `get_transparent_post_types_to_ignore()`, filter `kadence_transparent_post_type_ignore_array` (`inc/components/base_support/component.php:615`) [code].
- Gotcha: for a CPT whose `transparent_header_{post_type}` value has never been saved, the value is null and the theme treats it as disabled (`inc/components/layout/component.php:537-547`). Save the toggle once (off) in the Customizer if you want the transparent header on that CPT [code; verify on staging by toggling].
- Per post: `_kad_post_transparent` = `default` / `enable` / `disable` overrides everything (`layout/component.php:536-538`) [code].
- Design controls: `transparent_logo_icon_color`, `transparent_header_site_title_color`, `_navigation_color`, `_navigation_background`, `_button_color`, `_social_color`, `_html_color`, `_background`, `_bottom_border`; and per row `header_{row}_trans_background` [runtime].

### 2.6 Sticky header
- Section `kadence_customizer_header_sticky` (+ `_design`) [runtime].
- `header_sticky`: `no`, `main`, `top_main`, `top_main_bottom`, `top`, `bottom` (`inc/customizer/options/header-sticky-options.php:48-75`) [code]. Also `header_reveal_scroll_up`, `header_sticky_shrink`, `header_sticky_main_shrink`, `header_sticky_custom_logo`, `header_sticky_logo`, `header_sticky_logo_width` [runtime].
- Mobile: `mobile_header_sticky`, `mobile_header_reveal_scroll_up`, `mobile_header_sticky_shrink`, `mobile_header_sticky_main_shrink`, `header_sticky_custom_mobile_logo`, `header_sticky_mobile_logo` [runtime].
- Design: `header_sticky_site_title_color`, `_logo_icon_color`, `_navigation_color`, `_navigation_background`, `_button_color`, `_social_color`, `_html_color`, `_background`, `_bottom_border`, `_box_shadow` [runtime].

### 2.7 Header items added by Theme Kit Pro
Only appear when the Header Addons, Dark Mode or Conditional Headers modules are on. Sections found only in the runtime capture with all Theme Kit Pro modules on [runtime][Theme Kit Pro]:
- Header Addons: `header_button2`, `header_html2`, `header_account`, `header_contact`, `header_search_bar`, `header_divider`/`2`/`3`, `header_toggle_widget` (with widget areas `header1`, `header2`), `tertiary_navigation`, `quaternary_navigation`; mobile `mobile_button2`, `header_mobile_html2`, `header_mobile_account`, `header_mobile_contact`, `header_mobile_search_bar`, `header_mobile_divider`/`2`, `mobile_secondary_navigation` (sections are `kadence_customizer_` + key). Added through `kadence_theme_customizer_control_choices` and `kadence_theme_customizer_sections` (`kadence-pro/dist/header-addons.php:104-106`) and rendered on `kadence_header_*` actions (`kadence-pro/dist/header-addons/hooks.php:40-1200`) [code].
- Dark Mode: `kadence_customizer_header_dark_mode`, `_mobile_dark_mode`, `_footer_dark_mode`, `_dark_mode` [runtime].
- Conditional Headers: `kadence_customizer_conditional_header` (`kadence-pro/dist/conditional-headers.php:608-612`) [code].
Details: `theme-kit-pro-elements.md`.

---

## 3. Footer Builder

Location: Customizer > Footer (panel `kadence_customizer_footer`) [runtime].

- Builder: section `kadence_customizer_footer_builder`, control `footer_items` (`inc/customizer/options/footer-builder-options.php:47`) [code][runtime].
- Rows: `top`, `middle`, `bottom`, each with up to 5 columns (`top_1` .. `top_5` etc., `footer-builder-options.php:96-117`) [code].
- Items (`footer-builder-options.php:54-92`) [code]:

| Item key | Name | Section | Main controls [runtime] |
|---|---|---|---|
| `footer-navigation` | Footer Navigation (menu location `footer`) | `kadence_customizer_footer_navigation` | `footer_navigation_spacing`, `_stretch`, `_vertical_spacing`, `_align`, `_vertical_align`, `_color`, `_background`, `_typography` |
| `footer-social` | Social | `kadence_customizer_footer_social` (+ `_design`) | `footer_social_title`, `_items`, `_show_label`, `_item_spacing`, `_align`, `_vertical_align`, `_style`, `_icon_size`, `_brand`, colors, border, radius, typography, margin |
| `footer-html` | Copyright | `kadence_customizer_footer_html` | `footer_html_content` (editor), `_align`, `_vertical_align`, `_typography`, `_link_color`, `_link_style`, `_margin` |
| `footer-widget1`..`footer-widget6` | Widget 1-6 (widget areas `footer1`..`footer6`) | `kadence_customizer_sidebar-widgets-footer1`..`6` | `footer_widget{N}_align`, `footer_widget{N}_vertical_align` |

- Widget areas registered by the theme: `sidebar-primary`, `sidebar-secondary`, `footer1`..`footer6` (`inc/components/layout/component.php:76-100`) [code]. Widget areas accept blocks, so Kadence blocks can be placed in footer widgets.
- Menu locations: `primary`, `secondary`, `mobile`, `footer` (`inc/components/nav_menus/component.php:32-35`, `:83-86`) [code].
- Row sections `kadence_customizer_footer_top`, `_middle`, `_bottom` (bottom also `_design`). Per row controls: `footer_{row}_contain`, `_columns` (1-5), `_layout` (row layout control, values include `equal`, `left-golden`, `right-golden`, `left-forty`, `right-forty`, `left-half`, `right-half`, `center-half`, `center-wide`, `row`, `first-row`, `last-row`; responsive), `_collapse` (normal / rtl), `_direction` (row / column), `_column_spacing`, `_widget_spacing`, `_top_spacing`, `_bottom_spacing`, `_height`, `_widget_title`, `_widget_content`, `_link_colors`, `_link_style`, `_background`, `_column_border`, `_border` [runtime; layout values from `inc/customizer/react/src/row-layout/row-layout-component.js`, code].
- Default middle row layout: desktop `equal`, mobile `row` (`inc/components/options/component.php:2171-2175`) [code].
- Footer Layout section `kadence_customizer_footer_layout`: `footer_available_items`, `footer_wrap_background`, `enable_footer_on_bottom` [runtime].
- Item templates load from `template-parts/footer/` and are filterable with `kadence_footer_elements_template_path` (`inc/components/custom_footer/component.php:81`) [code].
- Scroll to top: General > Scroll To Top, `scroll_up`, `scroll_up_icon`, `_icon_size`, `_side`, `_side_offset`, `_bottom_offset`, `_visiblity`, `_style`, colors, border, radius, padding [runtime].

---

## 4. Page, post, archive, search, 404 and CPT layouts

Panel `kadence_customizer_all_posts` "Posts/Pages Layout" and `kadence_customizer_general` [runtime].

### 4.1 Resolution order
`Layout::check_conditionals()` (`inc/components/layout/component.php:486-878`) resolves, for the current request, an array with keys `layout`, `boxed`, `feature`, `feature_position`, `comments`, `navigation`, `title`, `transparent`, `side`, `sidebar`, `vpadding`, `sidebar_id`, `footer`, `header`, `content`. Order: per-post meta (`_kad_post_*`) first, then the Customizer option for that post type (`{post_type}_layout`, `{post_type}_title` etc.), then theme defaults. Filter the final array with `kadence_post_layout` (applied in every getter, `layout/component.php:175-476`) [code].

The result becomes body classes: `content-title-style-{above|normal|hide}`, `content-width-{normal|narrow|fullwidth|left|right}`, `content-style-{boxed|unboxed}`, `content-vertical-padding-{show|hide|top|bottom}`, transparent classes, `has-sidebar`, `has-left-sidebar`, `has-sticky-sidebar`, `no-header`, `no-footer`, and the per-post `_kad_post_classname` (`layout/component.php:884-920`) [code].

### 4.2 Single post and page settings
Sections: `kadence_customizer_page_layout` (Page Layout), `kadence_customizer_post_layout` and `_design` (Single Post Layout) [runtime].

| Setting | Post control | Page control | Values [code `inc/customizer/options/post-layout-options.php`] |
|---|---|---|---|
| Show title | `post_title` | `page_title` | on/off |
| Title position | `post_title_layout` | `page_title_layout` | `normal` (in content) / `above` (hero above content) (:74-95) |
| Hero container | `post_title_inner_layout` | `page_title_inner_layout` | `standard` / `fullwidth` / `contained` (:100) |
| Title align, height | `post_title_align`, `post_title_height` | `page_title_align`, `page_title_height` | responsive |
| Title elements (sortable) | `post_title_elements` default `breadcrumb, categories, title, meta, excerpt` | `page_title_elements` default `title, breadcrumb, meta` | each with `{type}_title_element_{item}` enabled flag (`options/component.php:2649`, `:2827`) |
| Hero background, overlay, border | `post_title_background`, `post_title_featured_image`, `post_title_overlay_color`, `post_title_border` | `page_title_*` same | |
| Layout width | `post_layout` default `narrow` | `page_layout` default `normal` | `normal` / `narrow` / `fullwidth` / `left` / `right` (sidebar) (:663; defaults `options/component.php:2566`, `:2678`) |
| Sidebar | `post_sidebar_id` | `page_sidebar_id` | `sidebar-primary` / `sidebar-secondary` |
| Content style | `post_content_style` | `page_content_style` | `boxed` / `unboxed` (:708; default boxed) |
| Vertical padding | `post_vertical_padding` | `page_vertical_padding` | `show` / `hide` / `top` / `bottom` (:737) |
| Featured image | `post_feature`, `post_feature_position` (`above` / `behind` / `below`, default `behind`), `post_feature_width` (`wide` / `full`), `post_feature_caption`, `post_feature_ratio` (`inherit`, `1-1`, `3-4`, `2-3`, `9-16`, `1-2`) | `page_feature`, `page_feature_position`, `page_feature_ratio` | (:779, :808, :860) |
| Post footer | `post_tags`, `post_footer_area_boxed`, `post_author_box`, `post_author_box_style` (`normal` / `center`), `post_author_box_link`, `post_navigation` | `page_comments` | |
| Related posts | `post_related`, `post_related_columns` (2/3/4), `post_related_title`, `post_related_orderby`, `post_related_order`, `post_related_carousel_loop`, `post_related_carousel_dots` | n/a | posts only (`single-entry.php`) |
| Comments | `post_comments`, `post_comments_date` | `page_comments` | General > Comments: `comment_form_before_list`, `comment_form_remove_web` |
| Backgrounds | `post_background`, `post_content_background` | `page_background`, `page_content_background` | |

Notes [code `template-parts/content/single-entry.php`]: author box, tags and related posts are hard-wired to post type `post`. Post navigation shows for `post` or any type with `has_archive`. For a CPT that needs related items or an author box, use an Element or a Kadence Blocks Query Loop.

### 4.3 Archives (blog, categories, CPT archives) and search
- Sections `kadence_customizer_post_archive` (+ `_design`), `kadence_customizer_search` (+ `_design`) [runtime].
- Archive controls: `post_archive_title`, `_title_layout`, `_title_inner_layout`, `_title_align`, `_title_height`, `_title_elements`, `post_archive_layout` (normal / narrow / fullwidth / left / right), `_sidebar_id`, `_content_style` (boxed / unboxed), `_columns` (1-4, default 3), `_item_image_placement` (beside / above), `_item_vertical_alignment`, `_elements` (sortable: default `feature, categories, title, meta, excerpt, readmore`), plus title, category and meta fonts/colors and backgrounds [runtime; code `post-archive-layout-options.php:466-651`, defaults `options/component.php:2926-2932`].
- Search uses the same pattern with `search_archive_` prefix [runtime].
- Archive description shows on taxonomy archives by default; filter `kadence_show_archive_description` (`template-parts/archive-title/description.php:10`) [code].
- Infinite scroll is a Theme Kit Pro module (`kadence_customizer_infinite_scroll`) [runtime][Theme Kit Pro].

### 4.4 404
Section `kadence_customizer_general_404` (+ `_design`): `404_layout`, `404_sidebar_id`, `404_content_style`, `404_vertical_padding`, `404_background`, `404_content_background` [runtime]. Content comes from `template-parts/content/error-404.php` between `kadence_404_before_inner_content` and `kadence_404_after_inner_content` (:18, :29) [code]. Theme Kit Pro Elements can replace it (`replace_404`) [Theme Kit Pro].

### 4.5 Global layout, sidebar, breadcrumbs
- General > Layout `kadence_customizer_general_layout`: `content_width` (default 1290px), `content_edge_spacing`, `content_spacing`, `content_narrow_width` (default 842px), `boxed_spacing`, `boxed_shadow`, `boxed_border_radius`, `boxed_grid_spacing`, `boxed_grid_shadow`, `boxed_grid_border_radius` [runtime; defaults `options/component.php:263-330`].
- General > Sidebar: `sidebar_width`, `sidebar_widget_spacing`, `sidebar_sticky`, `sidebar_sticky_last_widget`, plus design controls [runtime].
- General > Breadcrumbs: `breadcrumb_engine` (default built-in, `rankmath`, `yoast`, `seopress`), `breadcrumb_home_icon` [runtime; `inc/customizer/options/general-breadcrumb-options.php:22-33`, `inc/components/breadcrumbs/component.php:103-115`]. With Rank Math active, choose `rankmath` so the theme prints Rank Math's breadcrumb (with its schema) in the title area.

### 4.6 Custom post types
- Any post type that is `public`, not built-in, and not in the ignore list (`get_post_types_to_ignore()`, filter `kadence_customizer_post_type_ignore_array`, `inc/components/base_support/component.php:563`) automatically gets four Customizer sections: `{cpt}_layout`, `{cpt}_layout_design`, `{cpt}_archive`, `{cpt}_archive_design`, titled "{Label} Layout" and "{Label} Archive", in the Posts/Pages Layout panel, plus a "Custom Post Types" heading section `custom_posts_placeholder` (`inc/customizer/class-theme-customizer.php:1333-1385`) [code]. In the runtime capture the placeholder control `info_custom_post_types_placehoder` is present but CPT sections are not listed [runtime]; check in the Customizer UI that each CPT appears.
- Controls per CPT (`inc/customizer/options/custom-layout-options.php:30-1920`) [code]: single `{cpt}_title`, `_title_layout`, `_title_inner_layout`, `_title_align`, `_title_height`, `_title_elements`, title fonts/colors, `_title_background`, `_title_featured_image`, `_title_overlay_color`, `_title_top_border`, `_title_bottom_border`, `{cpt}_layout`, `_sidebar_id`, `_content_style`, `_vertical_padding`, `_background`, `_content_background`; archive `{cpt}_archive_title`, `_archive_title_layout`, `_archive_title_inner_layout`, `_archive_title_align`, `_archive_title_height`, `_archive_title_elements`, colors, `_archive_layout`, `_archive_sidebar_id`, `_archive_content_style`, `_archive_columns`, `_archive_elements`, `_archive_item_image_placement`, item fonts, backgrounds.
- Title elements for CPTs include one sortable entry per taxonomy of that CPT (`custom-layout-options.php:21-28`) [code].
- The editor meta panel is added to these CPTs too (section 5) [code].
- Requirements for a CPT to appear: `public => true` and (for the meta panel in the block editor) `show_in_rest`. The theme adds `custom-fields` support to public CPTs automatically (`inc/meta/class-theme-meta.php:431-439`) [code].

---

## 5. Per-post overrides (editor meta panel)

Block editor: open the post, then the Kadence "{Post type} Settings" sidebar panel (React panel `inc/meta/react/src/layout.js`, enqueued on `enqueue_block_editor_assets`, `inc/meta/class-theme-meta.php:57`, `:556-629`). Classic editor gets a meta box with a subset (`class-theme-meta.php:76-170`) [code].

| Meta key | Type | UI label | Values [code `inc/meta/react/src/layout.js:28-150`] |
|---|---|---|---|
| `_kad_post_transparent` | string | Transparent Header | `default`, `enable`, `disable` |
| `_kad_post_title` | string | Title | `default`, `hide`, `normal` (in content), `above` |
| `_kad_post_layout` | string | Layout | `default`, `normal`, `narrow`, `fullwidth`, `left`, `right` |
| `_kad_post_sidebar_id` | string | Sidebar | sidebar ID or `default` |
| `_kad_post_content_style` | string | Content Style | `default`, `boxed`, `unboxed` |
| `_kad_post_vertical_padding` | string | Content Vertical Spacing | `default`, `show`, `hide`, `top`, `bottom` |
| `_kad_post_feature` | string | Show Featured Image | `default`, `show`, `hide` |
| `_kad_post_feature_position` | string | Featured image position | `default`, `above`, `behind`, `below` |
| `_kad_post_header` | boolean | Disable Header | true / false |
| `_kad_post_footer` | boolean | Disable Footer | true / false |
| `_kad_post_classname` | string | Additional CSS class(es) | added to body class (`layout/component.php:905-908`) |
| `_kad_post_navigation` | read only | (no UI found) | read by editor preview (`editor/component.php:361`) [unverified UI] |

All keys are registered with `register_post_meta( '', ... )` for every post type, `show_in_rest => true` (`inc/meta/class-theme-meta.php:441-555`) [code]. Users who can edit the post can set them through REST; WordPress checks `edit_post` on the post itself [code; core behaviour].

Setting these keys from a script (for example during a migration) is the same as using the panel, because the theme only reads post meta.

---

## 6. Theme hooks reference

Found with `rg "(do_action|apply_filters)\(\s*'kadence_"` over the theme, excluding third-party integration components [code]. "Elements" column: `list` = offered in the Theme Kit Pro Elements hook dropdown (`kadence-pro/dist/elements/elements-init.php:2747-3001`); `custom` = not in the list but reachable with the Elements "Custom Hook" option (`elements-init.php:3340-3350`, render `:800`); `no` = filter or internal, not suitable for Elements. All `[code]`.

### 6.1 Page wrapper and header
| Hook | Type | File:line | Args | Default callbacks / use | Elements |
|---|---|---|---|---|---|
| `kadence_before_wrapper` | action | `header.php:33` | none | right after `wp_body_open`; skip links, banners | list |
| `kadence_before_header` | action | `header.php:42` | none | above header; announcement bar | list |
| `kadence_header` | action | `header.php:49` | none | `header_markup` (`template-hooks.php:20`); Elements "Replace Header" removes it | list (`replace_header`) |
| `kadence_after_header` | action | `header.php:51` | none | below header; page notices | list |
| `kadence_before_content` | action | `header.php:59` | none | first inside `<main>` | list |
| `kadence_top_header` / `kadence_main_header` / `kadence_bottom_header` | action | `template-parts/header/base.php:43, 49, 59` | none | row renderers (`template-hooks.php:29-31`) | custom |
| `kadence_mobile_header` | action | `template-parts/header/base.php:69` | none | `mobile_header` | custom |
| `kadence_mobile_top_header` / `_main_` / `_bottom_` | action | `template-parts/header/mobile.php:42, 48, 58` | none | mobile row renderers | custom |
| `kadence_render_header_column` | action | `template-parts/header/header-row.php:37-90` | `$row`, `$column` | renders items of a zone | custom (receives args) |
| `kadence_render_mobile_header_column` | action | `template-parts/header/mobile-header-row.php:36-77` | `$row`, `$column` | same for mobile | custom |
| `kadence_site_branding` | action | `template-parts/header/logo.php:18` | none | logo/title | custom |
| `kadence_primary_navigation`, `kadence_secondary_navigation` | action | `template-parts/header/navigation.php:18`, `navigation-2.php:18` | none | menus | custom |
| `kadence_header_html`, `kadence_header_button`, `kadence_header_cart`, `kadence_header_social`, `kadence_header_search` | action | `template-parts/header/html.php:18`, `button.php:18`, `cart.php:18`, `social.php:18`, `search.php:18` | none | item output | custom |
| `kadence_mobile_site_branding`, `kadence_navigation_popup_toggle`, `kadence_mobile_navigation`, `kadence_mobile_html`, `kadence_mobile_button`, `kadence_mobile_cart`, `kadence_mobile_social` | action | `template-parts/header/mobile-logo.php:18`, `popup-toggle.php:18`, `mobile-navigation.php:18`, `mobile-html.php:18`, `mobile-button.php:18`, `mobile-cart.php:18`, `mobile-social.php:18` | none | mobile item output | custom |
| `kadence_before_mobile_navigation_popup`, `kadence_after_mobile_navigation_popup` | action | `inc/template-functions/header-functions.php:588, 590` | none | inside off-canvas drawer | list |

### 6.2 Title area (hero and in-content)
| Hook | Type | File:line | Args | Use | Elements |
|---|---|---|---|---|---|
| `kadence_hero_header` | action | `template-parts/content/single.php:13`, `archive.php:13` | none | `hero_title` (`template-hooks.php:110`) prints the above-content hero | list (`replace_hero_header`) |
| `kadence_entry_hero` | action | `template-parts/content/entry_hero.php:30` | `$post_type`, `'above'` | renders title elements at priority 10; use priority for before/after | list |
| `kadence_entry_header` | action | `template-parts/content/entry_header.php:27` | `$post_type`, `'normal'` | in-content title elements | custom |
| `kadence_single_before_entry_header`, `kadence_single_after_entry_header` | action | `entry_header.php:21, 29` | none | around in-content title | list |
| `kadence_single_before_entry_title`, `kadence_single_after_entry_title` | action | `template-parts/content/entry_title.php:10, 12`; `template-parts/title/title.php:10, 12` | none | around the H1 | list |
| `kadence_single_title_info_area` | action | `template-parts/title/info.php:10` | none | info element | custom |
| `kadence_before_entry_meta`, `kadence_after_entry_meta` | action | `template-parts/title/meta.php:78, 301`; `content/entry_meta.php:78, 299` | none | around post meta line | custom |
| `kadence_entry_archive_hero` | action | `template-parts/content/archive_hero.php:33` | `$slug.'_archive'`, `'above'` | archive hero title elements | list |
| `kadence_entry_archive_header` | action | `template-parts/content/archive_header.php:30` | `$slug.'_archive'`, `'normal'` | in-content archive title | custom |
| `kadence_archive_before_entry_header`, `kadence_archive_after_entry_header` | action | `archive_header.php:24, 32` | none | around in-content archive title | list |

### 6.3 Content, single and sidebar
| Hook | Type | File:line | Args | Use | Elements |
|---|---|---|---|---|---|
| `kadence_single` | action | `single.php:20`, `page.php:20`, `404.php:22` | none | `single_markup` | custom |
| `kadence_before_main_content`, `kadence_after_main_content` | action | `template-parts/content/single.php:22, 45`; `archive.php:22, 47` | none | inside `#main`, before/after content | list |
| `kadence_single_content` | action | `template-parts/content/single.php:34` | none | `single_content` | list (`replace_single_content`) |
| `kadence_404_content` | action | `single.php:27` | none | `get_404_content` | list (`replace_404`) |
| `kadence_single_before_inner_content`, `kadence_single_after_inner_content` | action | `template-parts/content/single-entry.php:19, 33` | none | inside `<article>` | list |
| `kadence_single_before_entry_content`, `kadence_single_after_entry_content` | action | `template-parts/content/entry_content.php:14, 37` | none | around `the_content` | list |
| `kadence_single_after_featured_image` | action | `template-parts/content/entry_thumbnail.php:38` | none | under single image | custom |
| `kadence_single_after_content` | action | `single-entry.php:42` | none | after `</article>`, before author box/nav/related | custom |
| `kadence_404_before_inner_content`, `kadence_404_after_inner_content` | action | `template-parts/content/error-404.php:18, 29` | none | 404 body | list |
| `kadence_before_sidebar`, `kadence_after_sidebar` | action | `sidebar.php:28, 34` | none | around widgets | list (also `kadence_replace_sidebar`) |
| `kadence_before_comments`, `kadence_comments`, `kadence_after_comments` | action | `comments.php:31, 38, 40` | none | `kadence_comments` prints list and form (`template-hooks.php:154-165`) | list (before/after) |
| `kadence_before_comments_list`, `kadence_after_comments_list` | action | `template-parts/content/comments-list.php:13, 39` | none | around comment list | list |
| Inside-the-content positions | pseudo | Elements only | | before first H1, after first H1, after paragraph 1-4 | list (`kadence_inside_the_content_*`, Theme Kit Pro filters `the_content`) |

### 6.4 Archive loop
| Hook | Type | File:line | Args | Use | Elements |
|---|---|---|---|---|---|
| `kadence_archive` | action | `index.php:20` | none | `archive_markup` | list (`replace_archive_content`) |
| `kadence_loop_entry` | action | `template-parts/content/archive.php:35` | none | `loop_entry` per post | list (`replace_loop_content`) |
| `kadence_loop_entry_thumbnail` | action | `template-parts/content/entry.php:19` | none | card image | custom |
| `kadence_loop_entry_content` | action | `entry.php:30` | none | header (10), summary (20), footer (30) (`template-hooks.php:192-204`) | custom |
| `kadence_loop_entry_header` | action | `template-parts/content/entry_loop_header.php:21` | none | taxonomies (10), title (20), meta (30) | custom |
| `kadence_before_loop_entry_meta`, `kadence_after_loop_entry_meta` | action | `template-parts/content/entry_loop_meta.php:106, 327` | none | around card meta | custom |
| `kadence_loop_after_featured_image` | action | `entry_thumbnail.php:75` | none | under card image | custom |

### 6.5 Footer
| Hook | Type | File:line | Args | Use | Elements |
|---|---|---|---|---|---|
| `kadence_after_content` | action | `footer.php:21` | none | last inside `<main>` | list |
| `kadence_before_footer`, `kadence_after_footer` | action | `footer.php:25, 33` | none | around footer | list |
| `kadence_footer` | action | `footer.php:31` | none | `footer_markup` | list (`replace_footer`) |
| `kadence_after_wrapper` | action | `footer.php:36` | none | after `#wrapper`, before `wp_footer` | list |
| `kadence_top_footer`, `kadence_middle_footer`, `kadence_bottom_footer` | action | `template-parts/footer/base.php:24, 30, 36` | none | row renderers | custom |
| `kadence_render_footer_column` | action | `template-parts/footer/footer-row.php:39` | `$row`, `$column` | renders column items | custom |
| `kadence_footer_html`, `kadence_footer_navigation`, `kadence_footer_social` | action | `template-parts/footer/footer-html.php:28`, `footer-navigation.php:27`, `footer-social.php:29` | none | item output | custom |

### 6.6 Admin and dashboard actions
`kadence_theme_admin_menu` (`inc/dashboard/class-theme-dashboard.php:77`), `kadence_theme_dash_side_panel` (:317). Not for front-end output.

### 6.7 Filters (filter-only, not Elements targets)
Grouped by purpose. All `[code]`.

| Group | Filter (file:line) | Use |
|---|---|---|
| Layout | `kadence_post_layout` (`inc/components/layout/component.php:175` and every getter to :476; editor `editor/component.php:355`) | change resolved layout array per request |
| Layout | `kadence_dynamic_sidebar_content` (`layout/component.php:166`), `kadence_widget_area_args` (:90, :112) | sidebar HTML, widget wrappers |
| Header/footer/title parts | `kadence_header_elements_template_path` (`custom_header/component.php:210`), `kadence_footer_elements_template_path` (`custom_footer/component.php:81`), `kadence_title_elements_template_path` (`entry_title/component.php:63`, `archive_title/component.php:117`) | swap an item's template file |
| Header | `kadence-header-row-class-string` (`header-functions.php:122`, hyphenated), `kadence_logo_url` (:176, :458), `kadence_custom_logo` (:373), `kadence_extra_custom_logo` (:312), `kadence_custom_logo_args` (`custom_logo/component.php:44`), `kadence_social_link_target` (`header-functions.php:949, 1013`; `footer-functions.php:137`), `kadence_mobile_allow_mega_support` (`nav_menus/component.php:237`; `header-functions.php:619`), `kadence_theme_the_content` (`header-functions.php:26`) | header details |
| Single | `kadence_entry_content_class` (`content/entry_content.php:12`), `kadence_single_featured_image_size` (`entry_thumbnail.php:27`), `kadence_post_navigation_args` (`single-entry.php:54`), `kadence_related_posts_args` (`single-functions.php:97`), `kadence_related_posts_use_tags` (:39), `kadence_related_posts_carousel_columns` (:154), `kadence_related_posts_columns_class` (`entry_related.php:21`), `kadence_related_posts_carousel_args` (:23), `kadence_single_post_similar_posts_title` (:34), `kadence_single_post_similar_posts_carousel_autoplay` (:36), `kadence_single_post_comments_title` (`comments-list.php:28`), `kadence_comment_fields` (`comments/component.php:163`), `kadence_comment_args` (:177), `kadence_author_meta_output`, `kadence_author_use_profile_link` (`title/meta.php`, `content/entry_meta.php`, `entry_loop_meta.php`) | single output |
| Archive | `kadence_archive_container_classes` (`archive-functions.php:118, 162`), `kadence_archive_hero_classes` (:33), `kadence_archive_title_classes` (:77), `kadence_archive_post_type_slug` (:61), `kadence_archive_infinite_attributes` (:172), `kadence_show_archive_description` (`archive-title/description.php:10`), `kadence_pagination_args` (`content/pagination.php:11`) | archive output |
| Breadcrumbs | `kadence_local_breadcrumb_args` (`breadcrumbs/component.php:134`), `kadence_breadcrumb_args` (:155), `kadence_breadcrumb_delimiter` (:164), `kadence_breadcrumb_post_types` (:174), `kadence_breadcrumbs_after_home` (:258), `kadence_breadcrumb_html` (:310) | built-in breadcrumb only |
| Post types | `kadence_customizer_post_type_ignore_array` (`base_support/component.php:563`), `kadence_transparent_post_type_ignore_array` (:615), `kadence_public_post_type_ignore_array` (:657), `kadence_public_post_type_array` (:682), `kadence_public_post_type_objects` (:702), `kadence_classic_meta_box_post_types` (`meta/class-theme-meta.php:90`) | which CPTs get Customizer sections and meta |
| Styles | `kadence_dynamic_css` (`styles/component.php:125`), `kadence_editor_dynamic_css` (:4362), `kadence_css_files` (:4595), `kadence_preloading_styles_enabled` (:4480), `kadence_mobile_media_query` / `kadence_tablet_media_query` / `kadence_desktop_media_query` (:1705-1707 and 4 more places), `kadence_root_css_selector` (:1708), `kadence_body_css_selector` (:1709), `kadence_align_wide_array` (:1710), `kadence_narrow_width_align_wide_array` (:1719), `kadence_editor_body_colors` (:3522), `kadence_theme_enable_comment_css` (:4539), `kadence_theme_enable_author_box_css` (:4551) | CSS output |
| Fonts | `kadence_theme_google_fonts_array` (:4700), `kadence_print_google_fonts` (:4704), `kadence_display_swap_google_fonts` (:4753), `kadence_theme_google_fonts_query_args` (:4756), `kadence_local_fonts_preload` (:208, :240), `kadence_theme_global_typography_fallback` (:1794), `kadence_theme_global_display_typography_fallback` (:1795), `kadence_theme_font_family_string` (`class-kadence-css.php:466`), `kadence_theme_custom_fonts` (`customizer/class-theme-customizer.php:1973`), `kadence_theme_add_custom_fonts` (:201), `kadence_font_pairs_array` (:1976) | font loading |
| Palette | `kadence_global_palette_defaults` (`options/component.php:4940`), `kadence_active_palette` (:5035), `kadence_palette_option` (:5050), `kadence_site_palette_option` (:5015), `kadence_palette_complement_color` (:5043), `kadence_palette_customizer_capability` (`color_palette/component.php:57`), `kadence_theme_palette_presets` (`class-theme-customizer.php:1974`), `kadence_style_guide_color_palette` (`style_guide/component.php:85`) | palette |
| Options/Customizer | `kadence_theme_options_defaults` (`options/component.php:260`), `kadence_theme_option_name` (:241), `kadence_theme_option_type` (:226), `kadence_settings_key_custom_mapping` (several), `kadence_theme_customizer_sections` (`class-theme-customizer.php:1388`), `kadence_theme_customizer_control_choices` (:1839), `kadence_theme_customizer_control_contexts` (:2081), `kadence_theme_customizer_live_control_data` (:2092), `kadence_theme_customizer_capability` (:1403), `kadence_settings_extra_source` (:1977) | Theme Kit Pro uses these to add sections and items |
| Misc | `kadence_svg_icon` (`icons/component.php:1826`), `kadence_svg_icons_have_title` (:60), `kadence_microdata` (`microdata/component.php:71`), `kadence_{context}_schema` (:151), `kadence_html_itemtype` (:102), `kadence_article_itemtype` (:119), `kadence_maybe_wrap_embed_patterns` (`base_support/component.php:466`), `kadence_scroll_to_id_additional_offset` (`scripts/component.php:161`), `kadence_add_ie11_support` (:43), `kadence-theme-block-templates-support` (`editor/component.php:449`) | |

Third-party only actions (fire only with that plugin's templates): `kadence_before_archive_content` (`inc/components/third_party/component.php:83`), plus WooCommerce, LearnDash, Events Calendar etc. hooks in their components [code].

Theme Kit Pro adds its own actions that the theme does not fire, for example `kadence_header_account`, `kadence_header_button2`, `kadence_header_html2`, `kadence_header_dark_mode`, `kadence_before_account_login_popup` (`kadence-pro/dist/header-addons/hooks.php`, `dark-mode/hooks.php`) [code][Theme Kit Pro].

---

## 7. Custom PHP on hooks vs Theme Kit Pro Elements

Elements (post type `kadence_element`, Appearance > Kadence > Elements) [Theme Kit Pro] let an editor build content with blocks, pick a placement from the hook list or type any custom hook, set priority, and set display conditions and user roles. Details in `theme-kit-pro-elements.md`.

| Topic | Custom PHP on a theme hook | Elements |
|---|---|---|
| Who can edit | Developer only | Editor in the block editor |
| Layout | Markup in PHP (breaks "no layouts in PHP" style rules) | Kadence blocks, palette slots, global typography |
| Conditions | Hand-written `is_*` checks | Built-in display conditions, devices, roles, schedule |
| Replace header/footer/hero/content | Must `remove_action` the theme callback at the right time | Built-in `replace_*` placements remove the theme callback (`elements-init.php:820-925`) |
| Survives theme update | Yes if only hooks are used; breaks if hook names or markup change | Yes |
| Performance | Lowest overhead | One extra query plus block rendering per Element; cached by page cache |

Risks of custom PHP on these hooks:
- Hook timing: header and footer hooks fire inside `wp_body_open` and `get_footer`. Removing theme callbacks (for example `remove_action( 'kadence_header', 'Kadence\header_markup' )`) must run after the theme adds them (`inc/template-hooks.php` loads at theme setup) [code].
- Customizer partial refresh: header and footer items are re-rendered by selective refresh callbacks such as `Kadence\header_markup` (`header-builder-options.php:69-73`). PHP output on row or column hooks will show in the live preview only after a full refresh [code].
- Mobile and desktop headers are separate markup. Output on `kadence_main_header` does not appear on mobile; you need `kadence_mobile_main_header` too [code].
- `kadence_render_header_column` runs for every zone. A callback that ignores `$row` and `$column` prints in every zone [code].
- `kadence_post_layout` runs many times per request (each getter, `layout/component.php:175-476`) and is cached in a static after the first call. Keep the callback cheap and deterministic [code].
- Arguments: hooks with arguments (`kadence_entry_hero`, `kadence_entry_header`, `kadence_render_*_column`) need the right accepted-args count in `add_action` [code].
- Custom output bypasses palette and typography controls unless it uses the theme classes and `--global-*` variables.

When custom PHP is justified: data rendering that blocks cannot express, small filters (for example `kadence_post_layout` for a computed rule, `kadence_breadcrumb_post_types`, `kadence_related_posts_args`), and behaviour such as adding a class. Presentational content belongs in Elements or Kadence blocks.

---

## 8. Gaps and how to check them
- CPT Customizer sections were not in the runtime capture because the test site had no public CPT. The docs confirm "{CPT} Layout" and "{CPT} Archive" appear under Posts/Pages Layout for each public CPT [docs] (post-page-archive-layout-settings).
- Whether the spacing preset slider is missing when `theme_json_mode` is off. Check: open a core Group block spacing panel with the option off, then on [unverified UI].
- `_kad_post_navigation` has no visible panel control in 1.6.0 sources; only the editor preview reads it [unverified].
- FSE mode needs WordPress 7.1+; not tested here [code only].
