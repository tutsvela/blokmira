# Kadence Theme Kit Pro: modules and Elements

Purpose: a verified reference for every Theme Kit Pro module, with Kadence Elements in depth, so a builder can pick the native route before writing custom code.

Versions studied: Kadence Theme Kit Pro 1.2.6 (`kadence-pro/`), Kadence Theme 1.6.0 (`kadence/`), with cross-checks in Kadence Blocks 3.9.1 and Kadence Blocks Pro 2.8.16.

Contents
1. How to read this file
2. Module switchboard (option, defaults, where to switch on)
3. Module reference (each module)
4. Kadence Elements in depth
5. Conditional Headers in depth
6. Color Palette Switch (Dark Mode) in depth
7. Ultimate Menu (mega menu) and extra header items
8. Hooks and filters Theme Kit Pro exposes
9. Practical recipes
10. Licence notes
11. Gaps and how to check them

---

## 1. How to read this file

- Paths are relative to the product folder: `kadence-pro/...` for Theme Kit Pro, `kadence/...` for the theme, `kadence-blocks/...` and `kadence-blocks-pro/...` for the block plugins.
- Tags: `[code]` seen in installed source, `[runtime]` seen in the runtime capture, `[docs]` official docs only, `[unverified]` not confirmed.
- `[runtime, modules on]` means the fact comes from the runtime capture with all Theme Kit Pro modules on, which was captured with every Theme Kit Pro module switched on in memory only. The normal capture (the runtime capture) has all modules off, so Pro sections are missing there.
- Everything in this file needs Theme Kit Pro `[Theme Kit Pro]`, plus the named module.

---

## 2. Module switchboard

### Where the switch lives

| Item | Value | Source |
|---|---|---|
| Option name | `kadence_pro_theme_config` | `[code]` kadence-pro/class-kadence-theme-pro.php:125 |
| Storage format | A JSON string. Each module key is `true` when on. | `[code]` class-kadence-theme-pro.php:125, 174-186 (registered as a REST-visible string setting) |
| Default | Empty string, so **every module is off** until switched on. | `[code]` class-kadence-theme-pro.php:183; `[runtime]` normal capture has no Pro sections |
| When modules load | `after_setup_theme` priority 4 (bootstrap), files included only for modules set to `true` | `[code]` kadence-pro/kadence-pro.php:153; class-kadence-theme-pro.php:122-163 |
| Admin screen | Appearance > Kadence (menu slug `kadence`, capability filter `kadence_admin_settings_capability`, default `manage_options`). The Theme Kit Pro module cards are drawn by `kadence-pro/build/dashboard.js`, enqueued only on `?page=kadence`. | `[code]` kadence/inc/dashboard/class-theme-dashboard.php:75; kadence-pro/includes/uplink/Connect.php:200-235 |
| Theme hook for Pro admin pages | `kadence_theme_admin_menu` (Elements and Maintenance Mode add their submenu here) | `[code]` class-theme-dashboard.php:77 |

A module switched off is not loaded at all. Its Customizer sections, post type and hooks do not exist. Settings already saved stay in the database and come back when the module is switched on again `[code]` (no cleanup code found in class-kadence-theme-pro.php).

### Module list

All defaults are off. The "Card title" and "Open link" come from the dashboard card definitions in `kadence-pro/build/dashboard.js` `[code]`.

| Config key | Card title | Card description (short) | Card opens | Loads file |
|---|---|---|---|---|
| `header_addons` | Header Addons | Adds 19 elements to the header builder | Customizer panel `kadence_customizer_header` | dist/header-addons.php |
| `conditional_headers` | Conditional Headers | Extra headers shown by condition | Customizer section `kadence_customizer_conditional_header` | dist/conditional-headers.php |
| `mega_menu` | Ultimate Menu | Mega menus, highlight tags, icons | `nav-menus.php` (Appearance > Menus) | dist/mega-menu/mega-menu.php |
| `scripts` | Header/Footer Scripts | Script boxes in the Customizer | Customizer section `kadence_customizer_scripts` | dist/scripts-addon.php |
| `elements` | Hooked Elements | Add content anywhere, by condition | `edit.php?post_type=kadence_element` | dist/elements/elements-init.php (+ duplicate, import/export) |
| `woocommerce_addons` | WooCommerce Addons | Extra WooCommerce Customizer options | Customizer panel `woocommerce` | dist/woocommerce-addons.php (only if WooCommerce is active, class-kadence-theme-pro.php:144) |
| `infinite` | Infinite Scroll | Infinite scroll for archives | Customizer section `kadence_customizer_infinite_scroll` | dist/infinite-scroll.php |
| `dark_mode` | Color Palette Switch (Dark Mode) | Palette switch for a dark mode | Customizer section `kadence_customizer_dark_mode` | dist/dark-mode.php |
| `localgravatars` | Local Gravatars | Serve Gravatars from your own server | none | dist/local-gravatars.php |
| `archive_meta` | Archive Custom Settings | Per-term display settings | none (term edit screens) | dist/archive-meta.php |
| `adv_pages` | Maintenance Mode | Maintenance and coming soon pages | `edit.php?post_type=kadence_adv_page` | dist/advanced-pages/advanced-pages-init.php |

Always on, whatever the switches: the `[kadence_breadcrumbs]` shortcode (front end only, attribute `show_title`) `[code]` class-kadence-theme-pro.php:200-220, and the REST route `ktp/v1/post-select` (requires `edit_posts`) `[code]` dist/elements/post-select-rest-controller.php:52-84.

Note: the theme's own upsell list (`kadence/inc/dashboard/react/src/pro-extension.js`) uses different keys (`header_addon`, `hooks`, `woocommerce`, `infinite_scroll`, `local_gravatars`, `archive_custom`). Those are marketing links only. The real keys are the ones in the table above `[code]`.

---

## 3. Module reference

### 3.1 Header Addons (`header_addons`)

What it does: adds new items to the Customizer Header Builder, plus their settings sections, extra menu locations and widget areas `[code]` dist/header-addons.php:103-132.

Header Builder items added `[code]` dist/header-addons.php:2166-2250:

| Builder | Item key | Name | Customizer section |
|---|---|---|---|
| Desktop | `account` | Account | `kadence_customizer_header_account` |
| Desktop | `html2` | HTML 2 | `kadence_customizer_header_html2` |
| Desktop | `navigation-3` | Third Navigation | `kadence_customizer_tertiary_navigation` |
| Desktop | `navigation-4` | Fourth Navigation | `kadence_customizer_quaternary_navigation` |
| Desktop | `divider`, `divider2`, `divider3` | Divider 1 to 3 | `kadence_customizer_header_divider`, `_divider2`, `_divider3` |
| Desktop | `search-bar` | Search Bar | `kadence_customizer_header_search_bar` |
| Desktop | `widget1` | Widget area | `sidebar-widgets-header1` |
| Desktop | `contact` | Contact | `kadence_customizer_header_contact` |
| Desktop | `button2` | Button 2 | `kadence_customizer_header_button2` |
| Desktop and mobile | `toggle-widget` | Toggle Widget Area | `kadence_customizer_header_toggle_widget` |
| Mobile | `mobile-nav2` | Mobile Navigation 2 | `kadence_customizer_mobile_secondary_navigation` |
| Mobile | `mobile-account` | Account | `kadence_customizer_header_mobile_account` |
| Mobile | `mobile-html2` | HTML 2 | `kadence_customizer_header_mobile_html2` |
| Mobile | `mobile-divider`, `mobile-divider2` | Divider 1 and 2 | `kadence_customizer_header_mobile_divider`, `_divider2` |
| Mobile | `mobile-button2` | Button 2 | `kadence_customizer_mobile_button2` |
| Mobile | `mobile-contact` | Contact | `kadence_customizer_header_mobile_contact` |
| Mobile | `mobile-search-bar` | Search Bar | `kadence_customizer_header_mobile_search_bar` |

Most items also have a `..._design` section `[runtime, modules on]`. The module adds colour controls for these items inside the Transparent Header and Sticky Header design sections (`kadence_customizer_transparent_header_design`, `kadence_customizer_header_sticky_design`), for example `transparent_header_button2_color`, `header_sticky_button2_color` `[runtime, modules on]`.

Extra menu locations: `tertiary` (Third), `quaternary` (Fourth), `mobile-secondary`, `account` (Logged Out Account), `inaccount` (Logged In Account) `[code]` dist/header-addons.php:~935-945.
Extra widget areas: `header1` (Header Area) and `header2` (Header Off Canvas) `[code]` dist/header-addons.php:2433-2445.

Account item: adds the login modal and its hooks `kadence_before_account_login_popup`, `kadence_before_account_login_inner_popup`, `kadence_account_login_form`, `kadence_after_account_login_inner_popup`, `kadence_after_account_login_popup` `[code]` dist/header-addons/hooks.php:910-916. The Element placements in the "Header Account Login Modal" group only fire when this module is on and the Account item is in the header.

Template override: each item renders a template through `kadence_pro_get_template` `[code]` header-addons.php:1096, and fires an action such as `kadence_header_html2`, `kadence_header_button2` (list in section 8).

Use it when: a second button, second HTML area, search field, contact block, a third or fourth menu, or a login/account link is needed in the header. These replace custom header PHP completely.
Common mistakes: enabling the module and expecting the items to appear in the header automatically. They only appear in the Header Builder's available items list; you must drag them into a row. HTML 2 is a Customizer text field, not a block area; for block content in the header use an Element (Before Header / After Header) or the theme's block header.

### 3.2 Conditional Headers (`conditional_headers`)

See section 5.

### 3.3 Ultimate Menu (`mega_menu`)

See section 7.

### 3.4 Header/Footer Scripts (`scripts`)

What it does: three code boxes in Customizer > Custom Scripts (`kadence_customizer_scripts`, top level) `[runtime, modules on]`:

| Control | Printed on | Priority | Source |
|---|---|---|---|
| `header_scripts` | `wp_head` | 50 | `[code]` dist/scripts-addon/hooks.php:16-21 |
| `after_body_scripts` | `wp_body_open` | 50 | `[code]` hooks.php:27-32 |
| `footer_scripts` | `wp_footer` | 50 | `[code]` hooks.php:38-43 |

Use it when: a site-wide third-party snippet has no plugin integration. For a snippet on some pages only, use an Element of type HTML Editor (section 4) because it has display conditions.
Common mistakes: putting consent-dependent tracking here. These boxes print for everyone with no consent check; consent tools must handle blocking. Code here is not versioned in the repository.

### 3.5 Hooked Elements (`elements`)

See section 4.

### 3.6 WooCommerce Addons (`woocommerce_addons`)

Loads only when WooCommerce is active `[code]` class-kadence-theme-pro.php:144. Adds Customizer options for: add to cart behaviour (cart popout on add, single product ajax add to cart), free shipping notice in the cart popout, custom shop page content, active filters at the top of the shop, an off canvas shop sidebar with a toggle, and a sticky add to cart bar `[code]` dist/woocommerce-addons/*.php option labels. Not captured in runtime because WooCommerce is not active `[runtime, modules on]` (no WooCommerce sections listed).

### 3.7 Infinite Scroll (`infinite`)

Customizer > General > Infinite Scroll (`kadence_customizer_infinite_scroll`) `[runtime, modules on]`. Controls: `infinite_posts`, `infinite_search`, `infinite_products`, `infinite_custom` (custom post types), `infinite_end_of_content` (text).

How it works: filters the theme's archive attributes (`kadence_archive_infinite_attributes`, `kadence_product_archive_infinite_attributes`) and adds a loader after the theme pagination template part `[code]` dist/infinite-scroll/hooks.php:23-71.
Limit: it only affects the **theme's own archive loop** (blog, search, CPT archives rendered by the theme). It does not affect a Kadence Blocks Query Loop, Posts block or an Element that replaces archive content `[code]` (hooks only attach to theme template parts). For block-built archives use the Query Loop's own pagination or load-more settings (see the Blocks study).

### 3.8 Color Palette Switch (Dark Mode) (`dark_mode`)

See section 6.

### 3.9 Local Gravatars (`localgravatars`)

What it does: filters `get_avatar`, downloads each Gravatar image to `wp-content/gravatars` and rewrites the `src` and `srcset` to the local copy `[code]` dist/local-gravatars.php:10-30, 206, 223. A scheduled event cleans the folder (`delete_gravatars_folder`, frequency filter `get_local_gravatars_cleanup_frequency`) `[code]` local-gravatars.php:146, 243-245.
Use it when: comments or author boxes show Gravatars and you want no third-party image request (privacy, performance). No settings screen.

### 3.10 Archive Custom Settings (`archive_meta`)

What it does: adds two fields to the term edit screen of public taxonomies: "Above Header Background Image" (term meta `kwp-tax-image-id`) and "Archive Columns" (term meta `kwp-tax-columns`, Default or 1 to 4) `[code]` dist/archive-meta.php:197-204, 214-269. On that term's archive the image becomes the archive hero background (via `kadence_dynamic_css`) and the column count overrides the theme mod `{post_type}_archive_columns` `[code]` archive-meta.php:84, 100-140. Taxonomy list filter: `kadence-pro-archive-image-taxonomies` `[code]` archive-meta.php:181.
Limit: only affects the theme's archive hero and loop. If an Element replaces archive content, these settings no longer show.

### 3.11 Maintenance Mode (`adv_pages`)

Post type `kadence_adv_page` (runtime label "Maintenance Mode Pages") `[code]` dist/advanced-pages/advanced-pages-init.php:18; `[runtime, modules on]`. Admin: Appearance > Maintenance Mode `[code]` advanced-pages-init.php:~290. Types: "Under Maintenance" and "Coming Soon" `[code]` advanced-pages-init.php:240-243. Display conditions, user rules, expiry and language like Elements. It replaces the template at `template_include` priority `PHP_INT_MAX`. The default (maintenance) type sends HTTP 503 with `Retry-After` (filter `kadence_adv_page_retry_after`, default 86400) `[code]` advanced-pages-init.php:85, 299-366.
Warning: a published page with "Entire Site" takes the whole site offline for matching visitors. The default user rule when none is saved is `administrator` `[code]` advanced-pages-init.php:487; the docs call it "User Exceptions": the roles listed see the live site instead of the maintenance page, so by default logged-in administrators bypass it and need a private window to check it `[docs]` (maintenance-mode). The docs name the types "Maintenance Mode" and "Coming Soon Mode" and the menu Kadence > Maintenance Mode; the code registers the admin under Appearance.

---

## 4. Kadence Elements in depth

### 4.1 Basics

| Item | Value | Source |
|---|---|---|
| Post type | `kadence_element` | `[code]` dist/elements/elements-init.php:35 |
| Admin | Appearance > Elements (`edit.php?post_type=kadence_element`, registered with `add_theme_page`), capability `edit_theme_options`. The docs call it Appearance > Kadence > Elements; the menu appears only after the Hooked Elements module is on and the page is refreshed `[docs]` | `[code]` elements-init.php:502-509 |
| Capabilities | Custom type `kadence_element`/`kadence_elements`, all mapped to `edit_theme_options` | `[code]` elements-init.php:3592-3672 |
| Public | `public` and `publicly_queryable` default true (filter `kadence_element_public_cpt`), `rewrite` false, `exclude_from_search` true, `has_archive` false | `[code]` elements-init.php:3618-3631 |
| Direct view | Non-editors (no `edit_posts`) are 301-redirected to the home page | `[code]` elements-init.php:493-500 |
| Supports | title, editor, custom-fields, revisions, page-attributes (Order) | `[code]` elements-init.php:3636-3642 |
| Order | Front-end query is `orderby menu_order ASC`, max 533 elements, status `publish` only | `[code]` elements-init.php:771-784 |
| Shortcode | `[kadence_element id="123"]`. Runs the same display conditions. Skips unpublished and password-protected elements. Shown in the list table "Shortcode" column. | `[code]` elements-init.php:161, 656-680, 3850 |
| Admin bar | Front end shows "Elements (n)" listing every element active on the current page, with edit links. "New > Element" in the admin bar. | `[code]` elements-init.php:3884-3936 |
| List table | Columns Type, Placement, Display On, Visible To, Shortcode, Status (one-click publish/draft toggle); tabs per type; Duplicate; bulk Export and Import | `[code]` elements-init.php:200-211, 315-366, 3698-3858; duplicate-elements.php; class-kadence-pro-cpt-import-export.php:44-60 |
| Editor layout | When editing or viewing an element the theme layout is forced to full width, unboxed, no title, header, footer, sidebar or padding | `[code]` elements-init.php:3859-3882 |

### 4.2 Element types

Stored in `_kad_element_type` `[code]` elements-init.php:37. Chosen in the editor's "Choose Element Type" modal `[code]` build/meta.js strings.

| Value | Editor label | List tab | Placement list offered | Notes |
|---|---|---|---|---|
| `default` (or empty) | Content Section | Sections | Hook list (4.3) | Normal block content. |
| `fixed` | Fixed Section | Fixed Items | Fixed list (4.4) | Adds fixed/sticky wrappers and the `kadence-pro-sticky` CSS/JS. |
| `template` | Template | Templates | Template list (4.5) | Replaces theme parts. |
| `script` | HTML Editor | HTML code | Scripts group (`wp_head`, `wp_body_open`, `wp_footer`) plus the full hook list | Editor locked to one `kadence-pro/ace-html` block (or `core/html` if filter `kadence-pro-use-ace-block` returns false). Output skips `wptexturize`, `wp_filter_content_tags`. |

Sources: `[code]` elements-init.php:513-567 (ace block), 617-654 (template lock), 1666-1671 (script output via `ktp_code_the_content`), 2602-2627 (code hooks); build/meta.js (type map and which list each type uses).

There is no separate "content" or "hook" type beyond these four in 1.2.6 `[code]`.

### 4.3 Placement list for Content Sections

From `get_hook_options()` `[code]` elements-init.php:2747-3351. Theme lines are where the theme fires the hook `[code]` in `kadence/`.

| Group | Label | Value (hook) | Fires in theme |
|---|---|---|---|
| Body | Before Site Wrapper | `kadence_before_wrapper` (wrapped in `div.kadence-before-wrapper-item`) | header.php:33 |
| Body | After Site Wrapper | `kadence_after_wrapper` | footer.php:36 |
| Header | Before Header | `kadence_before_header` | header.php:42 |
| Header | After Header | `kadence_after_header` | header.php:51 |
| Header | Replace Header | `replace_header` (template behaviour) | see 4.5 |
| Content Wrap | Before All Content | `kadence_before_content` | header.php:59 |
| Content Wrap | After All Content | `kadence_after_content` | footer.php:21 |
| Above Content Hero Title | SINGLE: Above Title Content | `kadence_entry_hero` | template-parts/content/entry_hero.php:30 |
| Above Content Hero Title | ARCHIVE: Above Title Content | `kadence_entry_archive_hero` | template-parts/content/archive_hero.php:33 |
| Above Content Hero Title | Replace Above Content Hero | `replace_hero_header` | see 4.5 |
| Content and Sidebar | Before Content | `kadence_before_main_content` | template-parts/content/single.php:22, archive.php:22 |
| Content and Sidebar | After Content | `kadence_after_main_content` | single.php:45, archive.php:47 |
| Content and Sidebar | Before Sidebar | `kadence_before_sidebar` | sidebar.php:28 |
| Content and Sidebar | Replace Sidebar | `kadence_replace_sidebar` | see 4.5 |
| Content and Sidebar | After Sidebar | `kadence_after_sidebar` | sidebar.php:34 |
| Single Inner Content | Before Inner Content | `kadence_single_before_inner_content` | template-parts/content/single-entry.php:19 |
| Single Inner Content | Before Inner Title Area | `kadence_single_before_entry_header` | entry_header.php:21 |
| Single Inner Content | Before Inner Title | `kadence_single_before_entry_title` | template-parts/title/title.php:10 |
| Single Inner Content | After Inner Title | `kadence_single_after_entry_title` | title.php:12 |
| Single Inner Content | After Inner Title Area | `kadence_single_after_entry_header` | entry_header.php:29 |
| Single Inner Content | Before Entry Content | `kadence_single_before_entry_content` | entry_content.php:14 |
| Single Inner Content | After Entry Content | `kadence_single_after_entry_content` | entry_content.php:37 |
| Single Inner Content | After Inner Content | `kadence_single_after_inner_content` | single-entry.php:33 |
| Inside the Content | Before First Heading Tag | `kadence_inside_the_content_before_h1` | `the_content` filter (4.6) |
| Inside the Content | After First Heading Tag | `kadence_inside_the_content_after_h1` | `the_content` filter |
| Inside the Content | After First/Second/Third/Fourth Paragraph | `kadence_inside_the_content_after_p1` to `_p4` | `the_content` filter |
| Comments | Before Comments | `kadence_before_comments` | comments.php:31 |
| Comments | Before Comments List | `kadence_before_comments_list` | comments-list.php:13 |
| Comments | After Comments List | `kadence_after_comments_list` | comments-list.php:39 |
| Comments | After Comments | `kadence_after_comments` | comments.php:40 |
| Archive Inner Content | Before Archive Inner Title | `kadence_archive_before_entry_header` | template-parts/content/archive_header.php:24 |
| Archive Inner Content | After Archive Inner Title | `kadence_archive_after_entry_header` | archive_header.php:32 |
| Footer | Before Footer | `kadence_before_footer` | footer.php:25 |
| Footer | After Footer | `kadence_after_footer` | footer.php:33 |
| Footer | Replace Footer | `replace_footer` | see 4.5 |
| 404 Page | Before 404 Page Content | `kadence_404_before_inner_content` | template-parts/content/error-404.php:18 |
| 404 Page | After 404 Page Content | `kadence_404_after_inner_content` | error-404.php:29 |
| 404 Page | Replace 404 Page Content | `replace_404` | see 4.5 |
| Mobile Menu Off Canvas Area | Before / After Mobile Off Canvas Content | `kadence_before_mobile_navigation_popup`, `kadence_after_mobile_navigation_popup` | inc/template-functions/header-functions.php:588, 590 |
| Header Account Login Modal | Left of / Before / After / Right of Login Form, Replace Login Modal | `kadence_before_account_login_popup`, `kadence_before_account_login_inner_popup`, `kadence_after_account_login_inner_popup`, `kadence_after_account_login_popup`, `replace_login_modal` | Theme Kit Pro header-addons/hooks.php:910-916 (needs Header Addons) |
| WooCommerce groups | Content, Product, Archive, Account, Cart, Side Cart, Checkout, Order Received, Shop Widget Toggle Off Canvas | standard `woocommerce_*` hooks plus `kadence-before-side-cart`, `kadence-after-side-cart`, `kadence_before/after_product_off_canvas_filter`, and special `woocommerce_before/after_single_product_image` | Only listed when WooCommerce is active `[code]` elements-init.php:3007-3247 |
| LearnDash groups | Focus Mode, Course, Group hooks | only when LearnDash is active `[code]` 3249-3303 |
| The Events Calendar | Events before/after content, single event hooks (classic mode only) | only when TEC is active `[code]` 3305-3337 |
| Custom | Custom Hook | `custom` + `_kad_element_hook_custom` holds any action name | `[code]` elements-init.php:800-808 |

Priority: `_kad_element_hook_priority`, a number, default 10 `[code]` elements-init.php:3401-3411. It is the normal WordPress action priority. Theme callbacks on the same hook run at their own priorities, so use priority to land before or after them (the hero hooks say "Use Priority for Before/After Placement").

Custom hook: any action name works, including hooks from other plugins. The element is attached with `add_action( custom, ..., priority )` `[code]` 800-808. Custom hook `kadence_blocks_post_loop_content` is special: its Kadence Blocks CSS is rendered inline so it works inside a loop `[code]` elements-init.php:75-78, 1774-1780.

### 4.4 Fixed placements

`[code]` elements-init.php:2527-2566 (labels), 1068-1216 (output).

| Label | Value | Attached to | Behaviour |
|---|---|---|---|
| Fixed On Top | `fixed_above_header` | `kadence_before_header` | Fixed bar above the header. |
| Fixed Above Transparent Header | `fixed_above_trans_header` | `kadence_before_wrapper` | For pages with a transparent header. |
| Fixed Top After Scroll | `fixed_on_header` | `kadence_after_wrapper` | Appears after scrolling `_kad_element_hook_scroll` px (default 300). |
| Fixed Bottom After Scroll (no space below footer) | `fixed_on_footer_scroll` | `kadence_after_wrapper` | Appears after scroll, no spacer. |
| Fixed Bottom After Scroll | `fixed_on_footer_scroll_space` | `kadence_after_wrapper` | Appears after scroll, with spacer. |
| Fixed On Bottom | `fixed_below_footer` | `kadence_after_footer` | Fixed bottom bar with spacer. |
| Fixed Bottom (no space below footer) | `fixed_on_footer` | `kadence_after_wrapper` | Fixed bottom, no spacer. |

Extra fixed settings (meta): `_kad_element_fixed_width` (empty = full width; any value adds position classes; `fixed` also applies the max width; the exact choice list is `[unverified]`), `_kad_element_width` (px, default 300), `_kad_element_fixed_position` (left/right), `_kad_element_xposition`, `_kad_element_yposition` (px from edge). Editor labels: Width, Position, X Distance from Edge, Y Distance from Edge, Scroll Down Distance till Appear `[code]` elements-init.php:2245-2262, 3503-3555; build/meta.js. Assets `kadence-pro-sticky` CSS/JS load only when a fixed element prints `[code]` 473-476, 1074-1075.

### 4.5 Template placements (type Template)

`[code]` elements-init.php:2629-2674 (labels, filter `kadence_pro_element_template_hooks_options`), 822-956 (behaviour).

| Label | Value | What it removes | What it outputs | Notes |
|---|---|---|---|---|
| Replace Header | `replace_header` | `Kadence\header_markup` from `kadence_header` | Element on `kadence_header` | Only if the page has a header (`kadence()->has_header()`). Site title, nav, mobile header, sticky and transparent behaviour all go; you build them in blocks. |
| Replace Above Content Hero | `replace_hero_header` | `Kadence\hero_title` from `kadence_hero_header` | Element on `kadence_hero_header` | `kadence_hero_header` fires at the top of every theme single and archive template (template-parts/content/single.php:13, archive.php:13), so the element shows even when the title layout is "normal". Turn the inner title off if you do not want two titles. |
| Replace Single Post Content | `replace_single_content` | `Kadence\single_content` from `kadence_single_content` | Element inside `#primary .content-wrap`, wrapped in `div.entry-content.element-single-replace.single-content` (filter `kadence_elements_single_content_replace_class`) | Replaces the whole article: inner title, featured image, content, meta, author box, navigation, related posts, comments. Hero above and sidebar stay. Works for any singular type the condition matches, including pages and CPTs. Password-protected posts show the password form first `[code]` 717-728. |
| Replace Archive Content | `replace_archive_content` | `Kadence\archive_markup` from `kadence_archive` | Element on `kadence_archive` | `kadence_archive` is the whole body of index.php (index.php:20), so this replaces the archive hero, loop, pagination and sidebar. Build all of it with blocks. |
| Replace Archive Loop Item Content | `replace_loop_content` | `Kadence\loop_entry` from `kadence_loop_entry` | Element inside `div.custom-archive-loop-item.entry` with post classes, once per post in the theme loop | Dynamic blocks in it are rendered inline per item `[code]` 1774-1780. Theme grid columns still apply. |
| Replace Sidebar | `kadence_replace_sidebar` | widget output, through the `kadence_dynamic_sidebar_content` filter | Element where the widgets would be | The layout must still have a sidebar enabled. |
| Replace Footer | `replace_footer` | `Kadence\footer_markup` from `kadence_footer` | Element on `kadence_footer`, after printing content, sidebar and footer styles | Only if the page has a footer. |
| Replace 404 Page Content | `replace_404` | `Kadence\get_404_content` | Element on `kadence_404_content`; layout forced unboxed with no vertical padding | Only on 404 requests. |
| (Replace Post Meta) | `replace_meta` | commented out in 1.2.6 | none | Not available `[code]` 2655. |

Only one single or archive replacement per request: the first matching element (lowest Order) wins; `replace_single_content` and `replace_archive_content` share one flag. Same for `replace_loop_content` `[code]` 894-927. Other replacements (header, footer) do not have that guard, so two matching Replace Header elements would both print `[code]` 822-845 (inference from code; avoid overlapping conditions).

### 4.6 Inside the content

Elements on `kadence_inside_the_content_*` are injected with a `the_content` filter at the element priority `[code]` 967-1066. Insertion uses PHP DOM (`DOMXPath`) when the `dom` extension exists, else a simple string split (or force the simple method with `kadence_pro_inject_content_simple_method`) `[code]` 1242-1330. "Heading" means any of h1 to h4 by default (filter `kadence-headlines-for-element-in-content`) `[code]` 1326. It skips excerpts, admin, nested `the_content` calls and element posts `[code]` 1242-1257. "After First Heading Tag" is wrapped in `div.kadence-pro-in-content-element` `[code]` 1004-1010.
`[unverified]` The callbacks only insert when `apply_in_content_filter()` returns false (`if ( ! self::apply_in_content_filter( $post ) )`, 973), while that function returns true for normal singular views (1540-1556). Read literally that looks inverted. Test on a staging post before relying on these placements; fall back to "After Entry Content" or a block in the post if it does not appear. The filter `kadence_pro_run_in_the_content_filter` can change the result.

### 4.7 Display conditions ("Show On")

Saved as JSON in `_kad_element_show_conditionals` `[code]` elements-init.php:2213-2215. Options come from `get_display_options()` `[code]` 2409-2522 (filter `kadence_pro_element_display_options`). Page conditions are computed in `get_current_page_conditions()` `[code]` 1900-1958.

General group:

| Label | Rule value | True when |
|---|---|---|
| Entire Site | `general|site` | always |
| Front Page | `general|front_page` | `is_front_page()` |
| Blog Page | `general|home` | `is_home()` (also adds `general|archive` and `post_type_archive|post`) |
| Search Results | `general|search` | `is_search()` |
| Not Found (404) | `general|404` | `is_404()` |
| All Singular | `general|singular` | `is_singular()` |
| All Archives | `general|archive` | `is_archive()` or blog page |
| Author Archives | `general|author` | author archive |
| Date Archives | `general|date` | date archive |
| Paged | `general|paged` | `is_paged()` (page 2 and later) |
| (WooCommerce) | `general|woocommerce`, `general|product_search` | WooCommerce pages, product search |

Per post type group (one group per public, REST-enabled post type from `kadence()->get_post_types()`, so posts, pages and public CPTs with `show_in_rest`) `[code]` 2456-2502; kadence/inc/components/base_support/component.php:668-686:

| Label | Rule value |
|---|---|
| Single {Plural} | `singular|{post_type}` |
| {Taxonomy} Archives | `tax_archive|{taxonomy}` (public taxonomies with UI, not post_format) |
| {Plural} Archive | `post_type_archive|{post_type}` (only if `has_archive`) |

Sub-selection for `singular|...` and `tax_archive|...` rules (editor labels from build/meta.js; logic `[code]` 1985-2045):

| Select | Editor label | Matches |
|---|---|---|
| `all` | All | every item of that type or taxonomy archive |
| `author` | Author | single item whose author is the chosen user (users with `edit_posts`) |
| `tax` | Group (Select Taxonomy, Select Terms) | single item that has any chosen term, **including child terms** of a chosen term. "Must Match all Groups" (`mustMatch`) makes a non-match fail the whole element. |
| `ids` | Individually (Select Items) | single item with one of the chosen IDs (strict compare) |
| `individual` | Archive By (Select Terms) | the archive of one of the chosen terms (`tax_archive` rules) |

"All show rules must be true?" (`_kad_element_all_show`) switches from OR to AND across rules `[code]` 1981, 2045-2047.

Exclusion ("Hide On") uses the same rule list in `_kad_element_hide_conditionals` and is checked after Show `[code]` 2050-2110. Difference: exclusion by term group does **not** include child terms (only `has_term`) `[code]` 2066-2079.

Rules for 'tutor' lessons and LearnDash "assigned course" appear only when those plugins are active `[code]` 2499-2516, 2700-2740.

### 4.8 User, device, expiry, language

| Setting | Meta key | Behaviour | Source |
|---|---|---|---|
| User Settings ("Visible to") | `_kad_element_user_conditionals` (JSON list of `role`) | Options: All Users (`public`), Logged out Users, Logged in Users, then each editable role. Element shows if the visitor matches any listed value. There is no "hide from role" list for Elements (Conditional Headers have one). | `[code]` 2112-2127, 2162-2181, 2370-2404 |
| Device Settings ("Show on Device") | `_kad_element_device_conditionals` (Desktop, Tablet, Mobile) | Not server-side. Output is wrapped in `div.kadence-element-wrap` with `vs-lg-false`, `vs-md-false`, `vs-sm-false` classes, hidden by theme CSS (`display:none !important`). The HTML is still in the page. | `[code]` 1641-1656; kadence/assets/css/global.min.css |
| Expires Settings | `_kad_element_enable_expires`, `_kad_element_expires` | Hides the element after the date and time. There is **no start date**. | `[code]` 2129-2136 |
| Display on language | `_kad_element_language` | Compares with Polylang or WPML current language. Options only appear if one of them is active. | `[code]` 2138-2158, 2343-2366 |

Final filter: `kadence_element_display` (bool, element post, meta) can override the result for any element `[code]` 675, 751, 787.

### 4.9 All element meta keys

Registered with `register_post_meta`, `show_in_rest` true `[code]` elements-init.php:3368-3590.

| Key | Type | Default | Purpose |
|---|---|---|---|
| `_kad_element_type` | string | | default, fixed, template, script |
| `_kad_element_hook` | string | | placement value |
| `_kad_element_hook_custom` | string | | custom action name when hook is `custom` |
| `_kad_element_hook_priority` | number | 10 | action priority |
| `_kad_element_hook_scroll` | number | 300 | scroll distance for "after scroll" fixed items |
| `_kad_element_show_conditionals` | string (JSON) | | Show On rules |
| `_kad_element_all_show` | boolean | | all show rules must be true |
| `_kad_element_hide_conditionals` | string (JSON) | | Hide On rules |
| `_kad_element_user_conditionals` | string (JSON) | | Visible to |
| `_kad_element_device_conditionals` | string (JSON) | | devices |
| `_kad_element_enable_expires` | boolean | | expiry on |
| `_kad_element_expires` | string | | expiry date |
| `_kad_element_language` | string | | language slug or code |
| `_kad_element_fixed_width` | string | | fixed item width mode |
| `_kad_element_width` | number | 300 | fixed item max width |
| `_kad_element_fixed_position` | string | | left or right |
| `_kad_element_xposition` | number | 0 | x offset |
| `_kad_element_yposition` | number | 0 | y offset |
| `_kad_element_preview_post` | string (JSON `{id,name}`) | | editor preview post |
| `_kad_element_preview_post_type` | string | | editor preview post type |
| `_kad_element_preview_width` | string | '' | editor max width ("Editor Width (px)") |

Note: writes need edit rights on the element, which map to `edit_theme_options` `[code]` 3368-3590, 3652-3672.

When scripting element setup, write these meta keys exactly as the editor does (JSON strings for the conditional lists). Check a real element's saved meta first; the JSON row shape (`rule`, `select`, `subRule`, `subSelection[{value,label}]`, `ids`, `mustMatch`) is what `check_element_conditionals()` reads `[code]` 1977-2047.

### 4.10 Preview post and dynamic content in the editor

- Sidebar "Preview Settings": "Select Preview Posts Type", "Select Preview Post" ("Optionally define which post is used for dynamic content while previewing in the gutenberg editor"), "Editor Width (px)" `[code]` build/meta.js strings.
- Saved to `_kad_element_preview_post` and `_kad_element_preview_post_type`. If none is set, the latest post is used `[code]` elements-init.php:2275-2291.
- Passed to the editor as `kadenceElementParams.previewPostID` and `previewPostType` (filters `kadence_elements_dynamic_content_preview_post` and `..._post_type`) `[code]` 2292-2311. The sidebar also keeps the choice in a `kadence/elements-data` data store `[code]` build/meta.js.
- Kadence Blocks and Blocks Pro detect an element (`kbpData.isKadenceE`) and fetch dynamic values for that post instead of the element itself `[code]` kadence-blocks-pro/includes/init.php:124; kadence-blocks/dist/components.js and kadence-blocks-pro/dist/blocks.js read `kadenceElementParams.previewPostID` and the `kadence/elements-data` store.
- On the front end, Dynamic Content with the default "current" source reads the queried post, so the same element shows the right data on every post it is attached to `[unverified]` (Kadence Blocks dynamic content behaviour; see the Blocks study). Inside "Replace Archive Loop Item Content" each loop item is rendered with that post as current `[code]` 916-927 (theme loop sets up each post).
- Query Loop templates: Blocks Pro re-marks blocks as in-query when a Query Card template is an element `[code]` kadence-blocks-pro/includes/query/query-rest-api.php:1143-1150; the element editor has a separate preview query ID for Template elements `[code]` build/meta.js (`previewQueryID`).

Practical rule: always set the Preview Post to a real post of the target type before building dynamic content. Otherwise the editor shows the latest blog post's data, which is wrong for CPT templates.

### 4.11 CSS and assets for element content

`enqueue_element_styles()` runs for every displayed element `[code]` elements-init.php:1731-1851:
- Blocks content: calls `Kadence_Blocks_Frontend::frontend_build_css( $element )` and the Blocks Pro equivalent, so Kadence block CSS for the element is generated and enqueued like a normal post `[code]` 1771-1795; kadence-blocks/includes/class-kadence-blocks-frontend.php:439.
- Blocks with Dynamic Content inside a loop context (`replace_loop_content` or custom hook `kadence_blocks_post_loop_content`) get their CSS rendered inline so each item is styled `[code]` 1774-1780, 1853-1872.
- Per-post Custom CSS and JS from Kadence Blocks Pro (`_kad_blocks_custom_css`, `_kad_blocks_head_custom_js`, `_kad_blocks_body_custom_js`, `_kad_blocks_footer_custom_js`) on the element are printed in `wp_head` (priority 30), `wp_body_open` and `wp_footer` `[code]` 1736-1770; kadence-blocks-pro/includes/init.php:390.
- Element content goes through `ktp_the_content` (blocks, shortcodes, embeds, texturize, responsive image tags, smilies; no `wpautop`) `[code]` 686-701.
- Elementor, Beaver Builder, Brizy and SiteOrigin content is also supported `[code]` 1672-1702, 1875-1898.
- Gap: the special WooCommerce placements "Before/After Single Product Image" do not call `enqueue_element_styles()` `[code]` 929-956. Kadence block styles might be missing there `[unverified]`.

Output markers: elements print HTML comments `<!-- [element-ID] -->`, which helps when debugging cached pages `[code]` 1711-1716.

### 4.12 Performance and caching notes

- Each front-end request runs one `get_posts` for up to 533 published elements at `wp` priority 99 and checks each one's conditions in PHP `[code]` 767-788. Keep element count reasonable and use precise conditions.
- All conditions except device are evaluated server-side. A full-page cache stores the result. Role and logged-in rules work only if the cache varies by login state (LiteSpeed normally serves logged-in users separately `[unverified]`, check LiteSpeed Cache settings). Expiry only takes effect on the next cache rebuild, so purge the page cache after an element expires.
- Device visibility is CSS only, so hidden HTML still counts toward page weight and the DOM.
- Element CSS is built per request through Kadence Blocks; with Kadence Blocks CSS file output it is cached like any post `[unverified]`.

### 4.13 Common Elements mistakes

1. Publishing with no Show On rule. Nothing displays (`show` starts false) `[code]` 1979-1983. The list shows "[UNSET]".
2. Picking "Entire Site" for a template element. A single-content replacement then hits pages too. Use `Single {type}` rules.
3. Two template elements competing. Only the lowest Order wins for single/archive/loop replacements. Set Order (page attributes) on purpose.
4. Expecting an Element to change the title. "Replace Single Post Content" leaves the hero title. Use "Replace Above Content Hero" or turn the title off in Customizer or the post's Kadence meta.
5. Building dynamic content without a Preview Post. The editor shows the wrong data.
6. Using Custom Hook for theme hooks that already have a named placement. The named placement is clearer in the list table.
7. Using an Element of type HTML Editor for markup that should be blocks. HTML elements skip Kadence block CSS and are not visually editable.
8. Forgetting Order when several Content Sections share one hook. They run by priority first, then by Order (menu_order) because the query is sorted that way.

---

## 5. Conditional Headers in depth

Module `conditional_headers` `[Theme Kit Pro]`.

Where: Customizer > Header > Conditional Headers (`kadence_customizer_conditional_header`). Controls: `current_header_preview` ("Current Previewing Header") and `conditional_headers` (the list editor). Header Layout gets a "Previewing Header:" heading and a "Conditional Header" button `[runtime, modules on]`; `[code]` dist/conditional-headers/conditional-header-options.php. The button is hidden when the theme's "Enable Block Header" (`blocks_header`) is on `[code]` conditional-header-options.php (context `blocks_header != true`).

How a header is stored: the list (`conditional_headers.items[]`) holds `id` (for example `kadence_conditional_header_01`), `label`, `enabled`, `show`, `all_show`, `hide`, `user`, `user_hide`, `enable_expires`, `expires`, `language` `[code]` conditional-headers.php:1534-1560, 1217-1436. The header's design settings live in a separate WordPress option named by its `id`. Creating a header can copy the current header settings from theme mods into that option (`wp_ajax_kadence_pro_header_default`) `[code]` 619-662. Headers can be exported and imported as files `[code]` 616-622, 763-826.

How the active header is chosen `[code]` conditional-headers.php:1172-1212:
1. In the Customizer preview, the "Current Previewing Header" wins, so you edit that header's settings in the normal Header Builder.
2. On the front end, items are checked in list order; the **first enabled header whose conditions pass** is used. Later matches are ignored.
3. The plugin then hooks the theme filter `kadence_settings_key_custom_mapping` so every key in its header key list reads from that header's option instead of the main theme settings `[code]` 1198-1210; kadence/inc/components/options/component.php:4803, 4498-4507.
4. If none match, the normal header is used.

Header keys that switch (about 500) include the logo (`custom_logo`), all `header_*` builder rows and items, mobile navigation, primary to fourth navigation, dropdown, transparent header settings (`transparent_header_*`) and sticky settings (`header_sticky*`) `[code]` conditional-headers.php:59-572. So one conditional header can have its own logo, layout, transparent and sticky behaviour.

Conditions: same rule set as Elements (general, singular with author/group/individual, taxonomy archive, post type archive) plus user roles to show, user roles to hide (`user_hide`, which Elements lack), expiry and language `[code]` 1217-1436. Filters: `kadence_conditional_header_display`, `kadence_pro_conditional_header_display_options`, `..._taxonomies`, `..._authors`, `..._user_options`, `..._languages` (section 8).

Header variation choices:

| Need | Native route |
|---|---|
| Same header, transparent on some pages | Theme: Transparent Header settings plus per-page Kadence meta (theme study) |
| Different logo, menu or layout on some pages | Conditional Headers |
| No header on a landing page | Theme per-page layout meta (disable header) |
| Header built from blocks on some pages | Element type Template, Replace Header, with conditions |
| Header built from blocks everywhere | Theme "Enable Block Header" (`blocks_header`, `blocks_header_id`) `[runtime]` |

There is **no Conditional Footers** feature in 1.2.6 `[code]` (no matching code in dist/ or build/). Footer variations use Element "Replace Footer" or "Before Footer".

---

## 6. Color Palette Switch (Dark Mode) in depth

Module `dark_mode` `[Theme Kit Pro]`.

Customizer `[runtime, modules on]`:
- General > Color Switch (Dark Mode) (`kadence_customizer_dark_mode`): `dark_mode_enable`, `dark_mode_default` (light or dark), `dark_mode_os_aware`, `dark_mode_dark_palette`, `dark_mode_custom_logo` + `dark_mode_logo`, `dark_mode_mobile_custom_logo` + `dark_mode_mobile_logo`, fixed switch (`dark_mode_switch_show`, type, style, position, offsets, icons, size, colours, typography, tooltip, titles, visibility).
- Header > Color Switch (Dark Mode) (`kadence_customizer_header_dark_mode`) and mobile (`kadence_customizer_mobile_dark_mode`): a header builder item; Footer > Color Switch (Dark Mode) (`kadence_customizer_footer_dark_mode`): a footer builder item. Each says "*You must Enable Dark Mode".
- Shortcode `[kadence_dark_mode]` prints the switch (only when enabled and the fixed switch is on) `[code]` dist/dark-mode.php:99, 114-130.

Defaults: off, default palette light, dark palette `second-palette`, OS aware off, fixed switch on, icon type, switch style, right `[code]` dark-mode.php:217-240.

How it changes colours `[code]` dark-mode.php:421-499:
- Adds `color-scheme: light dark` on `:root`.
- Under `body.color-switch-dark` it redefines `--global-palette1` to `--global-palette15` with the values of the chosen palette (Palette 2 or Palette 3 from the theme's palette sets), points `--wp--preset--color--theme-palette-1..15` at them, sets `--global-palette9rgb`, highlight and button variables, gray tokens and The Events Calendar tokens.
- So anything coloured through palette slots (Kadence blocks, theme settings) switches automatically. Hard-coded hex colours do not.

Switching `[code]` dark-mode.php:189-212, 693-699; dist/dark-mode/src/dark-mode.js:14-84:
- Body class `color-switch-light` or `color-switch-dark`, and `has-dark-logo` when a dark logo is set.
- The choice is stored in a cookie named `{12-char site hash}-paletteCookie` with value `light` or `dark`, path `/`.
- PHP reads the cookie to print the body class. On `DOMContentLoaded` the script corrects the class from the cookie, or from `prefers-color-scheme` when OS aware is on and no cookie exists.
- Filter `kadence_dark_mode_enable` can turn it off per request (used for LearnDash lesson-only mode) `[code]` 104-110.

Caching note: with full-page caching, the cached HTML carries whatever body class was rendered first. The script fixes it after DOM load, so a visitor can see a brief flash of the wrong palette `[code]` (inference from the PHP and JS flow). A custom solution is only justified if that flash is unacceptable; test first.

When to use: if the design needs a user-controlled light/dark switch for the whole site. If the design only needs OS-based dark mode with no toggle, the theme palette plus this module with OS aware on still avoids custom CSS. Keep all colours on palette slots so both palettes stay readable (check 4.5:1 contrast in both).

---

## 7. Ultimate Menu (mega menu) and extra header items

Module `mega_menu` `[Theme Kit Pro]`. Settings live in Appearance > Menus, a settings button per menu item (added through `wp_nav_menu_item_custom_fields`, saved by ajax) `[code]` dist/mega-menu/mega-menu.php:70-82.

Applies only to menus printed with `mega_support`: primary, secondary and mobile menus in the theme, and the Pro extra navigations `[code]` kadence/inc/components/nav_menus/component.php:230-285; dist/header-addons/hooks.php:30-96 (filter `kadence_mobile_allow_mega_support`). Nav menu widgets get basic support through `kadence_ultimate_menu_addon_widget_nav` `[code]` mega-menu.php:95-103.

Per-item options (menu item meta) `[code]` mega-menu.php:113-600:

| Feature | Meta keys | Where it applies |
|---|---|---|
| Mega menu on/off, width (content, full, custom px), columns, column layout | `_kad_mega_menu`, `_kad_mega_menu_width`, `_kad_mega_menu_custom_width`, `_kad_mega_menu_columns`, `_kad_mega_menu_layout` | top level items |
| Dropdown background, shadow, padding, item colours, item background, item padding, dividers | `_kad_menu_dropdown_*`, `_kad_mega_menu_padding`, `_kad_mega_menu_item_padding` | top level items |
| Hide label | `_kad_menu_label` (adds `kadence-menu-hidden-title`) | any item |
| Disable link | `_kad_menu_link` (empties `href`) | any item |
| Show description | `_kad_menu_description` | any item |
| Icon (SVG), side, size, colour | `_kad_menu_icon_svg`, `_kad_menu_icon_side`, `_kad_menu_icon_size`, `_kad_menu_icon_color` | any item |
| Highlight tag (text, icon, colours) | `_kad_menu_highlight`, `_kad_menu_highlight_icon_svg`, `_kad_menu_highlight_color`, `_kad_menu_highlight_background` | any item |
| Replace item with an Element | `_kad_menu_item_custom`, `_kad_menu_item_custom_element` | second-level items (depth 1), outputs `[kadence_element id=...]` |
| Divider line | `_kad_menu_item_custom_divider` | second-level items |

Per-item CSS is printed in `wp_footer` priority 1 `[code]` mega-menu.php:81. The mega menu script loads only when an item uses it `[code]` 214-216.

Practical use: a mega menu column with images, buttons or a featured post is built as an Element (content in blocks, usually with no display conditions needed beyond what the menu shows) and placed in the menu by "Replace item with an Element". That needs both the `mega_menu` and `elements` modules. No custom walker is needed.

Extra header and footer items Pro adds: see the Header Addons table in 3.1, plus the dark mode switch for header, mobile header and footer (section 6). No extra footer items besides the dark mode switch were found `[code]` (dark-mode.php `add_customizer_header_footer_choices`; header-addons only adds header choices).

---

## 8. Hooks and filters Theme Kit Pro exposes

All `[code]`. Paths under `kadence-pro/`.

Elements:

| Name | Type | Location | Use |
|---|---|---|---|
| `kadence_element_display` | filter (bool, post, meta) | dist/elements/elements-init.php:675, 751, 787 | Final say on whether an element shows. Best place for a condition Kadence cannot evaluate. |
| `kadence_pro_element_main_query_args` | filter | elements-init.php:735, 772 | Change the element query. |
| `kadence_pro_element_hooks_options` | filter | 3351 | Add placements to the dropdown (for example a CPT plugin hook). |
| `kadence_pro_element_template_hooks_options` | filter | 2674 | Add template placements. |
| `kadence_pro_element_display_options` | filter | 2522 | Add display rules (needs matching logic via `kadence_element_display`). |
| `kadence_pro_element_display_taxonomies` | filter | 2742 | Taxonomies in rule pickers. |
| `kadence_pro_element_display_authors` | filter | 2584 | Author list. |
| `kadence_pro_element_user_options` | filter | 2403 | User options. |
| `kadence_pro_element_display_languages` | filter | 2365 | Language options. |
| `kadence_pro_post_types` | filter | 2338 | Post types for selectors. |
| `kadence_pro_post_select_allowed_post_types` | filter | dist/elements/post-select-rest-controller.php:363 | Post types allowed in the post-select REST route. |
| `kadence_elements_dynamic_content_preview_post` / `_post_type` | filter | 2309, 2310 | Override editor preview post. |
| `kadence_elements_single_content_replace_class` | filter (bool) | 1706 | Turn off the `entry-content single-content` wrapper. |
| `kadence_pro_inject_content_simple_method` | filter (bool) | 1258 | Force string method for in-content insertion. |
| `kadence-headlines-for-element-in-content` | filter | 1326 | Which heading tags count. |
| `kadence_pro_run_in_the_content_filter` | filter | 1555 | In-content insertion switch (see 4.6). |
| `kadence-pro-use-ace-block` | filter (bool) | 515 | Use `core/html` instead of the Ace HTML block. |
| `kadence_element_public_cpt` | filter | 3618-3619 | Make the CPT non-public. |
| `ktp_the_content`, `ktp_code_the_content` | filter | 1621, 1660-1701, 1667 | Content pipelines for element output. |
| `kadence_elements_duplicate_post`, `kadence_elements_duplicate_post_exclude_list`, `kadence_elements_duplicate_meta_keys`, `kadence_duplicate_post_capability` | filter | dist/elements/duplicate-elements.php:44, 117, 144, 155 | Duplicate behaviour. |

Conditional headers: `kadence_conditional_header_display` (1189), `kadence_pro_conditional_header_display_options` (1126), `..._display_taxonomies` (985), `..._display_authors` (1005), `..._user_options` (1164), `..._display_languages` (917), all in dist/conditional-headers.php.

Dark mode: `kadence_dark_mode_enable` (dist/dark-mode.php:122, 190, 422; dist/dark-mode/hooks.php:19-95); actions `kadence_header_dark_mode`, `kadence_mobile_dark_mode`, `kadence_footer_dark_mode` (dist/dark-mode/templates/*.php:18, 27).

Header addons actions (fired inside each item template, dist/header-addons/templates/*.php:18-20): `kadence_header_account`, `kadence_header_mobile_account`, `kadence_header_html2`, `kadence_header_mobile_html2`, `kadence_header_button2`, `kadence_mobile_button2`, `kadence_header_contact`, `kadence_header_mobile_contact`, `kadence_header_search_bar`, `kadence_header_mobile_search_bar`, `kadence_header_divider`, `kadence_header_divider2`, `kadence_header_divider3`, `kadence_header_mobile_divider`, `kadence_header_mobile_divider2`, `kadence_header_toggle_widget`, `kadence_tertiary_navigation`, `kadence_quaternary_navigation`, `kadence_mobile_secondary_navigation`. Login modal actions: see 3.1.

Shared: `kadence_pro_get_template` (dark-mode.php:822, header-addons.php:1096, woocommerce-addons.php:524) to override a Pro template file; `kadence_mobile_allow_mega_support` (header-addons/hooks.php:30, 62, 96); `kadence_ultimate_menu_addon_widget_nav` (mega-menu.php:101); `kadence_pro_faico_json` (mega-menu.php:519).

Other modules: `kadence_related_posts_infinite_args` (infinite-scroll/hooks.php:83); `kadence-pro-archive-image-taxonomies` (archive-meta.php:181); `get_local_gravatars_cleanup_frequency`, `get_local_gravatars_max_process_time`, `get_local_gravatars_fallback_url` (local-gravatars.php:245, 326, 339); WooCommerce: `kadence_enable_single_ajax_add_to_cart` (woocommerce-addons.php:482), `kadence_single_product_ajax_added_to_cart` action (187), `kadence-pro-sticky-show-single-add-to-cart` (woocommerce-addons/hooks.php:145, 164), `kadence_pro_woo_active_filters_widget` (117), `kadence_pro_woocommerce_shop_page_content` (woocommerce-addons/templates/archive-product.php:31), actions `kadence_before_product_off_canvas_filter` / `kadence_after_product_off_canvas_filter` (hooks.php:94, 98); Maintenance Mode: `kadence_adv_page_display` (advanced-pages-init.php:337), `kadence_adv_page_retry_after` (362), `kadence_pro_adv_page_main_query_args` (321, 375), `kadence_pro_adv_page_display_options` (778), `..._user_options` (659), `..._display_authors` (799), `..._display_languages` (621), `kadence_adv_page_public_cpt` (932-933), duplicate filters in duplicate-advanced-pages.php:44, 117, 144, 155; plugin: `ktp_languages_directory` (kadence-pro.php:282).

Theme hooks Theme Kit Pro relies on: `kadence_theme_admin_menu`, `kadence_theme_options_defaults`, `kadence_theme_customizer_sections`, `kadence_theme_customizer_control_choices`, `kadence_settings_key_custom_mapping`, `kadence_settings_extra_source`, `kadence_post_layout`, `kadence_dynamic_css`, `kadence_dynamic_sidebar_content` `[code]` (see constructors cited above).

---

## 9. Practical recipes

All need the `elements` module unless stated. "Native" means no custom code.

| # | Goal | Element type | Placement | Conditions | Native? |
|---|---|---|---|---|---|
| 1 | Custom hero on specific pages | Template | Replace Above Content Hero (`replace_hero_header`) | Show: Single Pages > Individually > pick pages. Turn the page title off (Customizer `page_title` or the page's Kadence title setting) so the inner title does not repeat. | Yes |
| 2 | Reusable notice (site-wide bar) | Content Section, or Fixed Section for a sticky bar | Before Header, or Fixed On Top | Entire Site; optional Expires; optional Visible to Logged out | Yes |
| 3 | Banner for one post type | Content Section | SINGLE: Above Title Content (`kadence_entry_hero`) or Before Content | Show: Single {CPT} > All | Yes (CPT must be public and `show_in_rest`) |
| 4 | Archive intro text | Content Section | ARCHIVE: Above Title Content (hero layout) or Before Archive Inner Title (normal layout) or Before Content | Show: {Taxonomy} Archives > Archive By > terms, or {CPT} Archive. Use Dynamic Content "archive description" if one element must show each term's own text `[unverified]` (check Kadence Blocks dynamic source list). | Yes |
| 5 | Author box | Prefer theme setting `post_author_box` (Customizer > Single Post Layout) `[runtime]`. For a custom design: Content Section with Dynamic Content author fields. | After Entry Content | Single Posts > All, or by Author | Yes |
| 6 | Content before or after posts | Content Section | Before Entry Content / After Entry Content (or After Inner Content for below comments area) | Single Posts > All; exclude chosen IDs with Hide On | Yes |
| 7 | CTA by category | Content Section | After Entry Content | Show: Single Posts > Group > Category > terms (children included). Use "Must Match all Groups" for strict matching. Exclusions do not include child terms. | Yes |
| 8 | Header variation per page | Conditional Headers module (no element needed), or Element Template > Replace Header for a block header | n/a | Conditional header rules (first match wins), or element Show rules | Yes |
| 9 | Footer variation | Template | Replace Footer (or Before Footer to add above it) | Show rules as needed. No conditional footers module exists. | Yes |
| 10 | Dynamic content section | Content Section | Any single placement | Set Preview Post to a real post of the target type first; use block Dynamic Content | Yes |
| 11 | Reusable promo in several places | Content Section with no hook, inserted with `[kadence_element id=""]` in a Shortcode block, or as a menu item (Ultimate Menu), or several elements | Shortcode / menu | Element conditions still apply to the shortcode | Mostly. For in-content reuse, a synced pattern is the core alternative; choose one and document it. |
| 12 | Custom single layout for a CPT | Template | Replace Single Post Content | Show: Single {CPT} > All. Set Preview Post to a CPT item. Hero, sidebar and layout come from the theme's CPT layout settings (theme study); disable the title there if the element shows it. | Yes |
| 13 | Custom archive for a CPT | Template | Replace Archive Content (whole archive) with a Query Loop; or Replace Archive Loop Item Content to keep the theme archive and change each card | {CPT} Archive or taxonomy archives | Yes. Infinite Scroll and Archive Custom Settings stop applying with full archive replacement. |
| 14 | Different content for logged-in users | Content Section | any | Visible to: Logged in Users or a role | Yes, but needs a cache that varies by login |
| 15 | Third-party script on some pages | HTML Editor | Header - Inside head tag (`wp_head`) or Footer | Show rules | Yes |

When custom code is really needed:
- A condition Kadence cannot express (for example an ACF field value, a repeater row, a date start window): add a small filter on `kadence_element_display` in a functional plugin, keyed by element slug or title, not ID. There is no start date, so "show from date X" needs this filter or manual publishing.
- A placement the theme does not fire: use Custom Hook with an existing hook from another plugin before writing a new hook.
- Data rendering that blocks cannot do (complex player, computed lists): a custom block or renderer, placed by an Element.

---

## 10. Licence notes

- Module loading has no licence check: modules load from `kadence_pro_theme_config` only `[code]` class-kadence-theme-pro.php:122-163.
- The plugin uses StellarWP Uplink for licensing and updates `[code]` includes/uplink/Connect.php:59-135. On the Appearance > Kadence page it validates the licence (cached for a week in a transient) and passes `activated` to the dashboard script `[code]` Connect.php:200-235. In 1.2.6 `build/dashboard.js` does not read `activated` `[code]` (only `adminURL`, `settings`, `ajax_url`, `ajax_nonce` are referenced). So the module switches are not gated in this version; updates are.
- A "Harbor" provider reports legacy licences and suppresses an inactive-licence notice `[code]` includes/resources/Harbor/Harbor_Provider.php:24-41. A banner provider adds admin notices `[code]` includes/resources/Banner/Banner_Provider.php:17-21.
- Kadence Starter Templates and Blocks Pro have their own licences; not covered here.

---

## 11. Gaps and how to check them

| Gap | How to check |
|---|---|
| In-content placements (4.6) may not insert because of the negated check | Create a draft element on a test site at "After First Paragraph" for one test post, view the post, look for `<!-- [element-ID] -->` |
| LiteSpeed cache variation for logged-in and role rules | LiteSpeed Cache > Cache settings, then test logged out vs logged in with a role-limited element |
| Maintenance Mode user rule meaning | Open a Maintenance Mode page editor and read the sidebar labels before publishing anything |
| WooCommerce Addons Customizer sections | Not captured (WooCommerce inactive); read dist/woocommerce-addons/*-options.php if ever needed |
| Front-end dynamic content source in elements | See the Kadence Blocks dynamic content study; test one element with a post title field on two posts |
| Kadence block styles at WooCommerce product image placements | Not needed unless WooCommerce is used |
