# Kadence Blocks Pro reference

Purpose: list every block and feature that Kadence Blocks Pro adds, where it lives in the editor, and what it is good for, so a builder can pick the native option before writing code.

Versions studied: Kadence Blocks Pro 2.8.16, Kadence Blocks 3.9.1, Kadence Theme Kit Pro 1.2.6, Kadence Creative Kit 1.1.4 (source copy plus a read-only runtime capture of registered blocks).

Contents
1. How to read this file
2. How Pro loads and what it needs
3. Pro-only blocks (cross-checked with the runtime block list)
4. Pro extensions of free blocks
5. Global Pro features (dynamic content, conditional display, animate on scroll, custom icons, page scripts)
6. Settings screen and option keys
7. Licence gating
8. Blocks that look Pro but are not (free or Creative Kit)
9. Gaps and how to check them

Paths are relative to the plugin folder, for example `kadence-blocks-pro/includes/init.php:77`. The dynamic content system is documented separately in `dynamic-content-acf.md`.

## 1. How to read this file

| Tag | Meaning |
|---|---|
| `[code]` | Confirmed in installed source, with `path:line` |
| `[runtime]` | Confirmed in the runtime block list (`BLOCK` lines) |
| `[docs]` | Only in official documentation |
| `[unverified]` | Not confirmed; the check is named |
| `[Pro]` | Needs Kadence Blocks Pro |

Feature classes used below: **Block** (its own block), **Extension** (extra controls or output on a free block), **Global** (plugin setting or site-wide system), **Editor-only** (only changes the editing UI), **Frontend** (only changes output or scripts).

## 2. How Pro loads and what it needs

- Pro needs Kadence Blocks active. It checks `KADENCE_BLOCKS_VERSION` and shows an admin notice if Blocks is missing `[code] kadence-blocks-pro/kadence-blocks-pro.php:99-107, 168-174`.
- Pro boots on `plugins_loaded` priority 4 `[code] kadence-blocks-pro/kadence-blocks-pro.php:197`.
- All Pro files are loaded from one list. "Pro features for free blocks" are table and video popup `[code] kadence-blocks-pro/class-kadence-blocks-pro.php:228-230`. The query system loads at line 233. The Product Carousel only loads when WooCommerce is active `[code] kadence-blocks-pro/class-kadence-blocks-pro.php:235-240`.
- Editor attributes are added early by `dist/early-filters.js` with `blocks.registerBlockType` filters `[code] kadence-blocks-pro/dist/early-filters.js` (filters `kadence/animation`, `kadence/dynamic`, `kadence/blockConditional`, `kadence/blockFieldConditional`, `kadence/formpro`, `kadence/queryFilters`, `kadence/tablepro`, `kadence/columnpro`).
- Block supports flags drive which blocks get Pro features:
  - `ktdynamic` adds `kadenceDynamic` and `kadenceConditional` attributes.
  - `ktanimate` adds `kadenceAnimation` and `kadenceAOSOptions`.
  - `ktfieldconditional` adds `kadenceFieldConditional` (form fields).
  - Source: `[code] kadence-blocks-pro/dist/early-filters.js` (`hasBlockSupport` checks); support lists per block `[runtime]`.

## 3. Pro-only blocks

All of these are **Block** class and **Pro-only** `[Pro]`. Inserter titles come from the block JS where the `block.json` title is wrong (several `block.json` titles are copy errors, see notes).

### 3.1 Block list cross-check

`block.json` files: `kadence-blocks-pro/dist/blocks/**/block.json` (29 files). Runtime has 27 Pro blocks registered. The two that are not registered by Pro: `kadence/productcarousel` (WooCommerce not active) and `kadence/videopopup` (Pro copy only registers for Blocks older than 3.4.4; the free block owns it now) `[code] kadence-blocks-pro/includes/blocks/class-kadence-blocks-pro-videopopup-block.php:342-347`.

| Block name | Inserter title | Runtime | Parent / context | Render |
|---|---|---|---|---|
| `kadence/dynamichtml` | Dynamic HTML | yes `[runtime]` | uses `postId`, `queryId`, `kadence/dynamicSource`, `kadence/repeaterRow(Data)` | PHP |
| `kadence/dynamiclist` | Dynamic List | yes `[runtime]` | uses `postId`, `queryId` | PHP |
| `kadence/imageoverlay` | Image Overlay | yes `[runtime]` | | PHP |
| `kadence/modal` | Modal | yes `[runtime]` | | PHP |
| `kadence/portfoliogrid` | Portfolio Grid/Carousel | yes `[runtime]` | | PHP |
| `kadence/postgrid` | Post Grid/Carousel | yes `[runtime]` | | PHP |
| `kadence/productcarousel` | Product Carousel | no (needs WooCommerce) | | PHP |
| `kadence/repeater` | Repeater | yes `[runtime]` | provides `kadence/dynamicSource`, `kadence/previewSource` | PHP |
| `kadence/repeatertemplate` | Repeater Template (shown as "Repeater Layout") | yes `[runtime]` | parent `kadence/repeater` | PHP |
| `kadence/query` | Query Loop (Adv) | yes `[runtime]` | provides `queryId`, `queryBlockId` | PHP |
| `kadence/query-card` | Query Loop Card | yes `[runtime]` | parent `kadence/query` or `kadence/column` | PHP |
| `kadence/query-filter` | Filter - Dropdown | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-filter-buttons` | Filter - Buttons | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-filter-checkbox` | Filter - Checkbox | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-filter-date` | Filter - Date | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-filter-range` | Filter - Range | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-filter-rating` | Filter - Rating | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-filter-reset` | Query Filter Reset | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-filter-search` | Filter - Search | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-filter-woo-attribute` | Filter - Swatch | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-noresults` | No Results | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-pagination` | Pagination | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-result-count` | Result Count | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/query-sort` | Sort | yes `[runtime]` | ancestor `kadence/query` | PHP |
| `kadence/slider` | Advanced Slider | yes `[runtime]` | | PHP |
| `kadence/slide` | Slide | yes `[runtime]` | not in inserter (`inserter` support) | PHP |
| `kadence/splitcontent` | Split Content | yes `[runtime]` | | PHP |
| `kadence/userinfo` | User Info | yes `[runtime]` | | PHP |

Notes on titles: runtime shows `kadence/userinfo` titled "Image Overlay" and several query children titled "No Results" or "Pagination". These are wrong `block.json` titles; the editor shows the JS titles listed above `[code] kadence-blocks-pro/dist/blocks-userinfo.js` ("User Info"), `kadence-blocks-pro/dist/blocks-query.js` ("Filter - Dropdown", "Result Count", "Sort", "Query Loop (Adv)").

### 3.2 Block details

**Dynamic HTML** (`kadence/dynamichtml`) `[Pro]`
- What: renders one dynamic field as HTML (post content, excerpt, title, dates, custom fields incl. ACF WYSIWYG, archive description, author bio, user fields).
- Settings `[code] kadence-blocks-pro/dist/blocks/dynamichtml/block.json`: `field`, `source`, `metaField`, `customMeta`, `relate`, `relcustom`, `useRepeaterContext`, `wrapTag`, `innerWrap`, per heading typography `h1Typography`..`h6Typography` with `enableH1..H6`, link colours, `limitWords` + `maxWords` + `showEllipsis`, `stripHTML`.
- Render: `type => 'html'` through the dynamic content class; word limit with `wp_trim_words`; strip tags option `[code] kadence-blocks-pro/includes/blocks/class-kadence-blocks-pro-dynamichtml-block.php:604-633`.
- Loop guard: `post|post_content` of the same post is rendered once; a second time returns empty (or a debug message with WP_DEBUG_DISPLAY) `[code] ...dynamichtml-block.php:579-593`.
- Use for: full post content inside a single-post Element, ACF WYSIWYG or textarea output, author bio.

**Dynamic List** (`kadence/dynamiclist`) `[Pro]`
- What: a styled list of taxonomy terms of a post (`type` "tax", optional term links) or of a multi-value custom field (`type` meta, ACF select/checkbox).
- Settings: `type`, `source`, `tax`, `metaField`, `customMeta`, `listDirection`, `listStyle`, `divider`, `enableLink`, `linkStyle`, colours, typography `[code] kadence-blocks-pro/dist/blocks/dynamiclist/block.json`.
- Render: terms via `get_the_terms()`, links via `get_term_link()`; meta via dynamic content `type => 'list'` `[code] kadence-blocks-pro/includes/blocks/class-kadence-blocks-pro-dynamiclist-block.php:178-202, 271`.
- Use for: topic/tag chips on a tutorial card, a checkbox field shown as pills.

**Image Overlay** (`kadence/imageoverlay`) `[Pro]`
- What: linked image with overlay title, subtitle, divider, hover opacity, border.
- Dynamic: image (`imgURL`), `link`, `title`, `subtitle` `[code] kadence-blocks-pro/dist/blocks-imageoverlay.js` (`dynamicAttribute` values).
- Animate on scroll and swipe animations `[runtime]` supports `ktanimate`, `ktanimateswipe`.

**Modal** (`kadence/modal`) `[Pro]`
- What: a popup that holds any blocks. Built-in trigger link/button (`displayModalLink`, `modalLink`, `modalLinkStyles`) or an external trigger.
- External trigger: any element with class `modal-trigger` and `href="#<customID>"` opens the modal with id `customID` `[code] kadence-blocks-pro/includes/assets/js/kt-modal-init.min.js` (`initializeMicroModal`). Default id is `kt-target-modal<uniqueID>` `[code] kadence-blocks-pro/includes/blocks/class-kadence-blocks-pro-modal-block.php:424`.
- `loadFooter` moves modal markup to `wp_footer` `[code] ...modal-block.php:367-383`. Filter `kadence_blocks_pro_modal_footer_output`.
- Close button gets `aria-label="Close Modal"` if missing `[code] ...modal-block.php:455-457`.
- Settings: animate in/out, alignment, size, overlay colour/opacity, close icon position/size/colours, `modalLabel` (accessible name) `[code] kadence-blocks-pro/dist/blocks/modal/block.json`.
- Filter blocks can sit inside a Modal (`kadence/query-filter*` parent includes `kadence/modal`) `[runtime]`.

**Post Grid/Carousel** (`kadence/postgrid`) and **Portfolio Grid/Carousel** (`kadence/portfoliogrid`) `[Pro]`
- What: older, settings-driven post listings (no inner blocks). Layouts grid, masonry, carousel; portfolio adds fluid carousel `[code] kadence-blocks-pro/dist/blocks-portfoliogrid.js`.
- Post Grid query: `queryType` (default "query" or individual posts `postIds`), `postType`, `categories`, `tags`, `authors`, `postTax`, `excludeTax`, `offsetQuery`, `allowSticky`, `excludeCurrent`, `showUnique`, `pagination`, filter bar (`displayFilter`) `[code] kadence-blocks-pro/dist/blocks/postgrid/block.json`.
- Limits: fixed card anatomy (image, above-title taxonomy, title, meta, excerpt, read more, footer). No per-card blocks and no ACF fields in the card. Prefer Query Loop (Adv) when the card needs custom layout or dynamic fields.

**Product Carousel** (`kadence/productcarousel`) `[Pro]`, needs WooCommerce `[code] kadence-blocks-pro/class-kadence-blocks-pro.php:235-240`.

**Repeater** (`kadence/repeater`) + **Repeater Template** (`kadence/repeatertemplate`) `[Pro]`
- What: loops the rows of an ACF repeater (or Meta Box group/repeater) and renders the inner template once per row, wrapped in `<li>` `[code] kadence-blocks-pro/includes/blocks/class-kadence-blocks-pro-repeatertemplate-block.php:97-133`.
- Settings: `source`, `repeaterSlug`, `columns`, gaps, padding/margin, `tagName`, `previewSource` `[code] kadence-blocks-pro/dist/blocks/repeater/block.json`.
- Inner blocks read row values with "Use Repeater Context". Details and limits in `dynamic-content-acf.md` section 8.

**Query Loop (Adv)** (`kadence/query`) and children `[Pro]`
- What: the advanced loop. The query itself is a `kadence_query` post; the card layout is a `kadence_query_card` post. Both are listed under the Kadence Blocks admin menu `[code] kadence-blocks-pro/includes/query/query-cpt.php:141`, `query-card-cpt.php:139`; `[runtime]` `POSTTYPE kadence_query`, `kadence_query_card`.
- Query settings live in post meta `_kad_query_query` with keys `perPage`, `pages`, `offset`, `postType`, `taxonomy`, `order`, `orderBy`, `orderMetaKey`, `orderMetaKeyType`, `author`, `search`, `exclude`, `sticky`, `inherit`, `taxQuery`, `parents`, `comparisonLogic`, `infiniteScroll` `[code] kadence-blocks-pro/includes/query/query-cpt.php:323-366`. Other meta: `_kad_query_facets`, `_kad_query_related`, `_kad_query_animation`, `_kad_query_masonryLayout`, `_kad_query_specificPosts` and styling keys.
- Card meta: `_kad_query_card_columns`, gaps, background, border, `_kad_query_card_preview_post_type`, `_kad_query_card_template_post_type` and more `[code] kadence-blocks-pro/includes/query/query-card-cpt.php:260-590`.
- Rendering: each result runs `the_post()`, sets `postId`/`postType` block context, then `do_blocks` + `do_shortcode` on the card template `[code] kadence-blocks-pro/includes/query/query-rest-api.php:320-345`. Each item is `<li class="kb-query-item ...">`.
- A card template can be a Kadence Element or Woo template; Pro re-adds `inQueryBlock` to its Kadence blocks `[code] kadence-blocks-pro/includes/query/query-rest-api.php:1142-1150`.
- Current post is excluded on singular pages by default; filter `kadence_blocks_pro_query_loop_block_exclude_current` `[code] kadence-blocks-pro/includes/query/query-rest-api.php:433`. Query vars filter: `kadence_blocks_pro_query_loop_query_vars` (line 727). Item classes filter: `kadence-blocks-pro-query-post-classes` (line 148).
- Filters/facets use an index table `kbp_query_index` `[code] kadence-blocks-pro/tables/KbpQueryIndex.php:26` built by a background process; manual reindex through `?kbp-reindex-facets=<n>` for users with `edit_posts` `[code] kadence-blocks-pro/kadence-blocks-pro.php:152-159`.
- Filter sources default to taxonomy, WordPress fields (date) or WooCommerce `[code] kadence-blocks-pro/dist/early-filters.js` (`kadence/queryFilters`). Custom field filters accept text, number, select, checkbox, radio, true/false, date, colour and more (`type` "filter") `[code] kadence-blocks-pro/includes/class-kadence-blocks-dynamic-content-controller.php:2046-2073`.

**Advanced Slider** (`kadence/slider`) + **Slide** (`kadence/slide`) `[Pro]`
- Each slide holds blocks over a background (image, gradient, overlay). Slider settings: height type/ratio, autoplay, speed, fade, arrows/dots (custom colours), columns, loop type, pause button, `ariaLabel` `[code] kadence-blocks-pro/dist/blocks/slider/block.json`, `slide/block.json`. Uses Splide `[code] kadence-blocks-pro/includes/class-kadence-blocks-pro-frontend.php:156-159`.
- Slide supports `ktdynamic` (dynamic background, conditional display) `[runtime]`.

**Split Content** (`kadence/splitcontent`) `[Pro]`
- Media one side, inner content other side; media `mediaUrl` and `link` can be dynamic `[code] kadence-blocks-pro/dist/blocks-splitcontent.js`. Part animations `ktanimatepartsoptions` `[runtime]`.

**User Info** (`kadence/userinfo`) `[Pro]`
- Shows the logged-in user's avatar, name and registration date; outputs nothing when logged out `[code] kadence-blocks-pro/includes/blocks/class-kadence-blocks-pro-userinfo-block.php:422-461`. Not an author box. For post author info use dynamic content (see the other file).

## 4. Pro extensions of free blocks

All rows are **Pro-only** `[Pro]`. The free block shows the option disabled or labelled "(pro)" unless noted.

| Free block | Pro addition | Class | Editor location | Source |
|---|---|---|---|---|
| Advanced Gallery | Layouts Thumbnail Slider, Tiles, Mosaic (free: Masonry, Grid, Carousel, Fluid Carousel, Slider) | Extension | Gallery settings, layout type | free list disables them `[code] kadence-blocks/dist/blocks-advancedgallery.js` (`thumbslider`, `tiles`, `mosaic` `isDisabled:!0`); Pro enables `[code] kadence-blocks-pro/dist/blocks.js` filter `kadence.galleryTypes`; Pro styles `dist/style-gallery-styles.css` |
| Advanced Gallery | Arrow position, size, margin, custom arrow and dot colours | Extension | Carousel settings | `[code] kadence-blocks-pro/dist/blocks.js` filters `kadence.galleryArrowsStyle`, `kadence.galleryArrowsPosition`, `kadence.galleryDotStyle`, `kadence.galleryArrowsBlockOptions` |
| Advanced Gallery | Dynamic Gallery (images from ACF gallery or similar) | Extension | Gallery image area, dynamic icon | `[code] kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php:849-1090` |
| Countdown | Evergreen timer type; end actions Hide, Replace with Content, Redirect (free: date timer, "show timer at zero") | Extension + Frontend | Countdown settings | free disables `[code] kadence-blocks/dist/blocks-countdown.js`; Pro enables `[code] kadence-blocks-pro/dist/blocks.js` (`kadence.countdownTypes`, `kadence.countdownActions`); evergreen AJAX `[code] kadence-blocks-pro/includes/class-kadence-blocks-pro-frontend.php:43-47`; storage table `includes/countdown/` |
| Form (legacy `kadence/form`) | Actions Auto Respond Email, Database Entry, Brevo, Mailchimp, Webhook (free: Email, Redirect, MailerLite, FluentCRM) | Extension | Form actions | free list `[code] kadence-blocks/dist/blocks-form.js`; Pro `[code] kadence-blocks-pro/dist/blocks.js` (`kadence.actionOptions`, `kadence.formGeneralControls`) |
| Advanced Form | Actions ActiveCampaign, Auto Respond Email, Brevo, Kit (ConvertKit), Database Entry, GetResponse, Mailchimp, Webhook (free: Email, Redirect, MailerLite, FluentCRM) | Extension | Form block, Actions | free list `[code] kadence-blocks/dist/blocks-advanced-form.js`; Pro `kadence.actionOptionsAdvancedForm`; entries tables `includes/form/admin/` |
| Advanced Form fields | Field conditional logic (`kadenceFieldConditional`) | Extension | Field sidebar, "Enable Conditional Field" | `[code] kadence-blocks-pro/dist/early-filters.js` (`kadence/blockFieldConditional`); frontend `includes/assets/js/kb-conditional-fields.min.js`, `includes/form/kbp-form-conditional.php` |
| Advanced Form | Form analytics (views, conversions) | Extension | Form settings | `[code] kadence-blocks/includes/blocks/class-kadence-blocks-advanced-form-block.php:435` (only when Pro class exists); `kadence-blocks-pro/includes/advanced-form/kbp-advanced-form-analytics.php`, table `kbp_form_events` |
| Advanced Form fields | Default value from dynamic content (`defaultValue`) | Extension | Field settings, dynamic icon | `[code] kadence-blocks/dist/blocks-advanced-form.js` (`dynamicAttribute:"defaultValue"`) |
| Video Popup | Self Hosted video type, mobile video, poster video, extra ratios (4:3, 16:9, 3:4, 9:16), pop animation, play icon styles, overlay gradient | Extension | Video Popup settings | free disables "Self Hosted (pro)" `[code] kadence-blocks/dist/blocks-videopopup.js`; Pro filters `kadence.videoPopupPro*` `[code] kadence-blocks-pro/dist/blocks.js`; Pro CSS `[code] kadence-blocks-pro/includes/free-blocks/class-kadence-blocks-pro-videopopup-block.php`, called from `kadence-blocks/includes/blocks/class-kadence-blocks-videopopup-block.php:69-70` |
| Table (Adv) | Sticky first row, sticky first column (needs max height / max width) | Extension + Frontend | Table settings, "Sticky Settings" | `[code] kadence-blocks-pro/includes/free-blocks/class-kadence-blocks-pro-table-block.php:31-43`, called from `kadence-blocks/includes/blocks/class-kadence-blocks-table-block.php:76-77` |
| Section (`kadence/column`) | Backdrop filter (blur etc.) | Extension | Section style | free shows "Add a backdrop filter with Kadence Blocks Pro!" `[code] kadence-blocks/dist/blocks-column.js`; Pro `kadence.styleControlsBackdropFilter`, attributes from `kadence/columnpro` `[code] kadence-blocks-pro/dist/early-filters.js` |
| Header (Adv) | Backdrop filter | Extension | Header style | `[code] kadence-blocks/includes/blocks/class-kadence-blocks-header-block.php:96`; Pro `kadence.headerBackdropFilter` |
| Navigation link (Adv) | Mega menu (enable, width default/container/content/full/custom, dropdown alignment); per-link styles incl. transparent and sticky states | Extension | Navigation link sidebar, "Sub Menu Settings" | panel only shows when the Pro filter exists `[code] kadence-blocks/dist/blocks-navigation-link.js` (`hasFilter("kadence.megaMenuControlsNavigationLink")`); Pro `kadence.megaMenuControlsNavigationLink`, `kadence.styleControlsNavigationLink` |
| Row Layout, Section, Advanced Text, Single Button, Image, Info Box, Icon, Icon List, Gallery, Google Maps, Video Popup, Testimonial, Navigation link, Header row | Dynamic content (text, link, image, background, gallery) | Extension | Toolbar "Dynamic Content" or dynamic icon next to the field | see `dynamic-content-acf.md` |
| Every block with `ktdynamic` support (list in 5.2) | Conditional Display | Extension + Frontend | Block sidebar, Advanced tab, "Conditional Display" | see 5.2 |
| Section, Advanced Text, Single Button, Form, Image, Video Popup, Image Overlay, Split Content | Animate on scroll | Extension + Frontend | Block sidebar, "Animate on Scroll" | see 5.3 |

## 5. Global Pro features

### 5.1 Dynamic content `[Pro]`
Global system, documented in full in `dynamic-content-acf.md`. Key class `Kadence_Blocks_Pro_Dynamic_Content` `[code] kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php:102-133`. Shortcode `[kb-dynamic]` (line 116). Some free features call into it when Pro is active: Table of Contents `[code] kadence-blocks/includes/class-kadence-blocks-table-of-contents.php:440-444`, gallery `[code] kadence-blocks/includes/blocks/class-kadence-blocks-advancedgallery-block.php:1097-1098`.

### 5.2 Conditional Display (block visibility by data) `[Pro]`
- Class: Extension (editor panel) + Frontend (block removed in `render_block`).
- Attribute: `kadenceConditional.postData` = `{ enable, logic: AND|OR, conditions: [ { source, field, custom, para, compare, condition } ] }` `[code] kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php:561-611`.
- Which blocks: every block with `ktdynamic` support that does not also have `ktfieldconditional` `[code] kadence-blocks-pro/dist/blocks.js` (ConditionalDisplayControls checks both supports). From runtime: `kadence/rowlayout`, `column`, `advancedgallery`, `singlebtn`, `advancedheading`, `googlemaps`, `icon`, `single-icon`, `iconlist`, `listitem`, `infobox`, `image`, `testimonial`, `navigation-link`, `header`, `header-row`, `imageoverlay`, `slide`, `splitcontent`, `videopopup` `[runtime]`. Core blocks (paragraph, group) do not get it.
- Editor location: block sidebar, Advanced tab, panel "Conditional Display", toggle "Enable Conditional Display", "Add Condition", "Logic Operator" when more than one condition `[code] kadence-blocks-pro/dist/blocks.js`. Blocks with conditions get the editor class `kadence-has-conditional-display` (filter `kadence/conditionalIndicators`).
- Who sees the panel: set in "Conditional Display Defaults" (all users or minimum role contributor/author/editor), saved to `kadence_blocks_settings_blocks` key `kadence/conditional` `[code] kadence-blocks-pro/dist/blocks.js` (`saveSetting("kadence/conditional")`).
- Fields and compare types: see `dynamic-content-acf.md` section 9.
- Frontend: `render_blocks()` returns an empty string when conditions fail; skipped in `is_admin()` `[code] ...dynamic-content.php:686-701`.
- Free alternative: Row Layout only has logged-in / logged-out / role visibility (`loggedIn`, `loggedInUser`, `loggedInShow`, `loggedOut`) and Restrict Content Pro rules `[code] kadence-blocks/includes/class-kadence-blocks-frontend.php:101-169`. That is free, not Pro.

### 5.3 Animate on scroll `[Pro]`
- Class: Extension + Frontend. Attribute `kadenceAnimation` (animation name) and `kadenceAOSOptions` (`duration`, `offset`, `easing`, `once`, `delay`, `delayOffset`) `[code] kadence-blocks-pro/dist/early-filters.js`.
- Blocks: support `ktanimate` (Section, Single Button, Advanced Text, Form, Advanced Image, Video Popup, Image Overlay, Split Content) `[runtime]`. Extra variants: `ktanimateswipe` (cover swipes) on Section, Form, Video Popup, Image Overlay; `ktanimatereveal` (slide reveal) on Advanced Text `[runtime]`.
- Animation names: fade (up, down, left, right, diagonals, center-out, out-in), flip (up, down, left, right), slide (up, down, left, right, center-out, out-in), zoom in/out (all directions), plus reveal and swipe variants `[code] kadence-blocks-pro/dist/blocks.js`.
- Output: `data-aos`, `data-aos-offset`, `-duration`, `-easing`, `-delay`, `-once` on the wrapper `[code] kadence-blocks/includes/helper-functions.php:138-158`.
- Script and defaults: AOS registered by Pro; site defaults read from option `kadence_blocks_config_blocks` key `kadence/aos` (offset 120, duration 400, easing ease, delay 0, once false) `[code] kadence-blocks-pro/includes/class-kadence-blocks-pro-frontend.php:142-153`. Script enqueued only when a block has an animation `[code] ...dynamic-content.php:1286-1293`.
- Reduced motion: the bundled AOS script checks `prefers-reduced-motion: reduce` `[code] kadence-blocks-pro/includes/assets/js/aos.min.js`.
- Editor location: block sidebar "Animate on Scroll"; site defaults in "Animate On Scroll Defaults" `[code] kadence-blocks-pro/dist/blocks.js` strings. Exact panel placement `[unverified]` (open a Section block and check the Advanced tab).

### 5.4 Custom icons and custom SVGs `[Pro]`
- Custom Icons: post type `kb_icon`, admin menu Kadence Blocks > Custom Icons (`manage_options`) `[code] kadence-blocks-pro/includes/class-kadence-blocks-pro-custom-icons.php:181-190, 463`. Accepts an IcoMoon `selection.json` (upload or pasted JSON); icons are added to all Kadence icon pickers via filter `kadence_svg_icons` `[code] ...custom-icons.php:109, 116-175`.
- Custom SVGs: post type `kadence_custom_svg` (`show_ui` false) `[code] kadence-blocks-pro/includes/custom-svg/kadence-svg-cpt.php:12, 71-72`; `[runtime]`. REST routes to upload, search a cloud SVG library and add from search; all need `edit_others_pages`; SVGs are sanitised before saving `[code] kadence-blocks-pro/includes/class-kadence-blocks-custom-svg-controller.php:86-118, 188-189, 238`.
- Use for: brand icons that must appear in Icon, Icon List, Info Box and button icon pickers.

### 5.5 Page scripts (per post CSS and JS) `[Pro]`
- Editor-only UI + Frontend output. Panel "Page Scripts", button "Custom CSS and JS", only on viewable post types `[code] kadence-blocks-pro/dist/blocks.js`.
- Post meta: `_kad_blocks_custom_css`, `_kad_blocks_head_custom_js`, `_kad_blocks_body_custom_js`, `_kad_blocks_footer_custom_js` `[code] kadence-blocks-pro/includes/init.php:387-429`. Printed raw on singular views in `wp_head` (30), `wp_body_open` (10), `wp_footer` (20) `[code] kadence-blocks-pro/includes/init.php:434-477`.
- Caution: treat Page Scripts as editor-level code injection: whatever an editor saves is printed on the page. Prefer theme or plugin files under version control for project CSS/JS.

### 5.6 Block defaults and settings modals `[Pro]`
"Block Defaults" / "Modify Block Defaults" buttons exist in each Pro block `[code] kadence-blocks-pro/dist/blocks-*.js` strings. Defaults are stored in `kadence_blocks_config_blocks`; panel visibility per role in `kadence_blocks_settings_blocks` `[code] kadence-blocks/includes/settings/class-kadence-blocks-settings.php:910-931`, `kadence-blocks-pro/dist/blocks.js` (`saveSetting`, `saveConfig`).

## 6. Settings screen and option keys

- Pro has no menu of its own. It removes the extra free menu options (`kadence_blocks_admin_menu_options` returns false) and points the settings URL to `admin.php?page=kadence-blocks` `[code] kadence-blocks-pro/includes/class-kadence-blocks-pro-backend.php:43-44, 122-124`.
- Pro blocks are added to the free enable/disable list via `kadence_blocks_enable_disable_array`: Image Overlay, Split Content, Post Grid/Carousel, Modal, Product Carousel, Portfolio Grid/Carousel `[code] ...backend.php:133-170`. Disabled blocks are stored in `kt_blocks_unregistered_blocks` `[code] kadence-blocks/includes/settings/class-kadence-blocks-settings.php:672-675`.
- Pro API option keys (all `register_setting`, `show_in_rest`, sanitised with `sanitize_text_field`) `[code] ...backend.php:49-118`:
  - `kadence_blocks_send_in_blue_api`
  - `kadence_blocks_mail_chimp_api`
  - `kadence_blocks_getresponse_api_key`, `kadence_blocks_getresponse_api_endpoint` (default `https://api.getresponse.com/v3`)
  - `kadence_blocks_activecampaign_api_key`, `kadence_blocks_activecampaign_api_base`
- Also read by Pro: `kadence_blocks_convertkit_api`, `kadence_blocks_config_blocks`, `kadence_blocks_settings_blocks`, `kbp_is_installed`, `kbp-facts-manual-reindex` `[code]` (grep of `get_option` in `kadence-blocks-pro/includes`).
- Admin menus added under Kadence Blocks: Custom Icons, Query, Query Card `[code]` (see 3.2 and 5.4).

## 7. Licence gating

- Licensing uses StellarWP Uplink, slug `kadence-blocks-pro`, registered on `kadence_blocks_uplink_loaded` `[code] kadence-blocks-pro/includes/uplink/Connect.php:57-95`. The licence field renders in the Kadence Blocks dashboard side panel (`kadence_blocks_dash_side_panel`) and a network License page on multisite `[code] Connect.php:138-143, 196-202`.
- Missing or invalid licence triggers an admin notice (cached in transient `kadence_blocks_pro_license_status_check`) `[code] Connect.php:403-430`.
- Block registration and frontend features are not gated by licence checks. The only runtime use of the key outside licensing is the cloud SVG library search `[code] kadence-blocks-pro/includes/class-kadence-blocks-custom-svg-controller.php:129-170` (grep found no other `is_authorized` or `get_license_key` calls in `includes/`). Updates and the pattern library depend on the licence `[unverified]`; check Uplink update behaviour with an expired key on a test site.

## 8. Blocks that look Pro but are not

| Block | Product | Source |
|---|---|---|
| `kadence/videopopup` Video Popup | Free since Blocks 3.4.4 (Pro adds options, section 4) | `[code] kadence-blocks/includes/blocks/class-kadence-blocks-videopopup-block.php` |
| `kadence/vector` Vector SVG | Free | `[code] kadence-blocks/includes/blocks/class-kadence-blocks-vector-block.php` |
| `kadence/lottie` Lottie Animations | Free | `[code] kadence-blocks/includes/blocks/class-kadence-blocks-lottie-block.php` |
| `kadence/marquee`, `kadence/marquee-item` | Creative Kit `[Creative Kit]` | `[code] kadence-creative-kit/inc/KadenceCreativeKit/Blocks/Marquee_Block.php` |
| Row Layout user visibility (logged in/out, roles) | Free | `[code] kadence-blocks/includes/class-kadence-blocks-frontend.php:101-169` |
| `kadence/posts` Posts | Free (simple post list) | `[runtime]` |

## 9. Gaps and how to check them

- Exact sidebar tab for Animate on Scroll and the Defaults modals `[unverified]`: open the editor and inspect a Section block.
- Whether licence expiry disables updates only `[unverified]`: test on a non-production site.
- Slider, Post Grid and Portfolio Grid accessibility details (keyboard, pause) were not audited beyond `showPauseButton` and `ariaLabel` attributes.
- Product Carousel not exercised (WooCommerce inactive at runtime).
