# Kadence Blocks inventory and shared component layer

Purpose: a verified map of every registered `kadence/*` block, what the free Kadence Blocks plugin offers per block, and the shared settings, tokens and CSS layer, so a builder can pick the native block and setting before considering custom code.

Versions studied: Kadence Blocks 3.9.1 (free), with attribution checks against Kadence Blocks Pro 2.8.16 and Kadence Creative Kit 1.1.4. Runtime list from the runtime capture (the runtime capture).

Contents
1. How to read this file
2. Master table of the 88 registered blocks (plus client-only inner blocks)
3. Detailed sections for the free top-level blocks
4. Shared component layer (controls, palette, tokens, defaults, settings, CSS generation)
5. Gaps and how to check them

---

## 1. How to read this file

- Paths are relative to the plugin folder: `kadence-blocks/...` for the free plugin, `kadence-blocks-pro/...` for Pro, `kadence-creative-kit/...` for Creative Kit.
- Tags: `[code]` source confirmed, `[runtime]` seen in the runtime capture, `[docs]` official docs only, `[unverified]` not confirmed. `[Pro]` means Kadence Blocks Pro is needed. `[Creative Kit]` means Kadence Creative Kit.
- "Responsive" means the attribute stores desktop, tablet and mobile values. Kadence uses two naming styles: an array `[desktop, tablet, mobile]` (for example `padding` = 4 sides, with `tabletPadding` and `mobilePadding`), or separate keys with a `Tablet`/`Mobile` (or `T`/`M`) suffix. Both appear in the same block.
- Breakpoints used by the CSS builder: tablet `(max-width: 1024px)`, mobile `(max-width: 767px)`, desktop `(min-width: 1025px)`, all filterable (`kadence_tablet_media_query`, `kadence_mobile_media_query`, `kadence_desktop_media_query`) `[code]` `kadence-blocks/includes/class-kadence-blocks-css.php:418`.

## 2. Master table

### 2.1 How attribution was done

- Runtime shows 88 `kadence/*` blocks registered on the server (`BLOCK_COUNT 88 of 212`) `[runtime]`.
- Free blocks register through the abstract class with `register_block_type( KADENCE_BLOCKS_PATH . 'dist/blocks/<name>/block.json' )` `[code]` `kadence-blocks/includes/blocks/class-kadence-blocks-abstract-block.php:163`. Form fields register from `dist/blocks/advanced-form/fields/<name>/block.json` `[code]` `kadence-blocks/includes/blocks/form/class-kadence-blocks-advanced-form-input-block.php:52`. Header children and table children have their own `register_block_type` calls `[code]` `kadence-blocks/includes/blocks/header/*.php:63`, `class-kadence-blocks-table-row-block.php:59`, `class-kadence-blocks-table-data-block.php:59`.
- Pro blocks register from `KBP_PATH . 'dist/blocks/<name>/block.json'` `[code]` `kadence-blocks-pro/includes/blocks/class-kadence-blocks-pro-abstract-block.php:63`; query children from `dist/blocks/query/children/<name>/block.json` `[code]` `kadence-blocks-pro/includes/blocks/query/class-kadence-blocks-pro-query-children-block.php:47`.
- Creative Kit registers the marquee blocks `[code]` `kadence-creative-kit/inc/KadenceCreativeKit/Blocks/Abstract_Block.php:118`.
- `kadence/videopopup` moved from Pro to free in Blocks 3.4.4. The free plugin registers it; Pro only re-registers it when free is older than 3.4.4, and otherwise adds Pro styles to the free block `[code]` `kadence-blocks-pro/includes/init.php:94-96`, `kadence-blocks/includes/blocks/class-kadence-blocks-videopopup-block.php:69`.

"Render" column: every runtime block reports `render=php` (a PHP render callback) `[runtime]`. The table says whether the free PHP class rebuilds the markup (`build_html` override, "PHP markup") or only adds CSS and scripts to the saved HTML ("saved HTML + PHP CSS"). Classes without a `build_html` override: advancedbtn, icon, iconlist, infobox, spacer, tabs `[code]` (default `build_html` returns the saved content, `class-kadence-blocks-abstract-block.php:384`). For Pro and Creative Kit blocks see the Pro study; they are marked "PHP callback".

Several block.json titles are wrong or duplicated in the source (for example `kadence/userinfo` says "Image Overlay", `kadence/query-filter` and `kadence/query-sort` say "No Results", `kadence/table-row` says "Table (Adv)"). The editor JavaScript may show different names `[unverified]`: check the inserter.

### 2.2 The 88 server-registered blocks

| # | Block name | Title (runtime) | Plugin | Parent / ancestor | Render | Purpose |
|---|---|---|---|---|---|---|
| 1 | kadence/rowlayout | Row Layout | Blocks | top level | PHP markup | Section with 1 to 6 columns, backgrounds, overlays, dividers |
| 2 | kadence/column | Section | Blocks | top level in registry; used inside rowlayout and many containers | PHP markup | Column or free-standing flex/grid container |
| 3 | kadence/accordion | Accordion | Blocks | top level | PHP markup | Collapsible panes, optional FAQ schema |
| 4 | kadence/advancedgallery | Advanced Gallery | Blocks | top level | PHP markup | Image gallery: masonry, grid, carousels, slider |
| 5 | kadence/advancedbtn | Advanced Button | Blocks | top level | saved HTML + PHP CSS | Button group wrapper |
| 6 | kadence/singlebtn | Single Button | Blocks | parent: advancedbtn | PHP markup | One button |
| 7 | kadence/advancedheading | Advanced Text | Blocks | top level | PHP markup | Headings, paragraphs, span or div text |
| 8 | kadence/countdown | Countdown | Blocks | top level | PHP markup | Date or evergreen countdown |
| 9 | kadence/countup | Count Up | Blocks | top level | PHP markup | Animated number counter |
| 10 | kadence/form | Form | Blocks | top level, hidden from inserter (`inserter:false`) | PHP markup | Legacy simple form |
| 11 | kadence/googlemaps | Google Maps | Blocks | top level | PHP markup | Map embed or JS API map |
| 12 | kadence/icon | Icon | Blocks | top level | saved HTML + PHP CSS | Icon group wrapper |
| 13 | kadence/single-icon | Single Icon | Blocks | parent: icon | PHP markup | One SVG icon |
| 14 | kadence/iconlist | Icon List | Blocks | top level | saved HTML + PHP CSS | List with icons |
| 15 | kadence/listitem | List item | Blocks | parent: iconlist | PHP markup | One icon list item |
| 16 | kadence/infobox | Info Box | Blocks | top level | saved HTML + PHP CSS | Icon/image/number + title + text + learn more |
| 17 | kadence/image | Advanced Image | Blocks | top level | PHP markup | Image with ratio, mask, overlay, tooltip |
| 18 | kadence/lottie | Lottie Animations | Blocks | top level | PHP markup | Lottie player |
| 19 | kadence/identity | Site identity | Blocks | top level (meant for headers) | PHP markup | Logo, site title, tagline |
| 20 | kadence/posts | Posts | Blocks | top level | PHP markup | Simple post list/grid |
| 21 | kadence/progress-bar | Progress Bar | Blocks | top level | PHP markup | Line, circle or semicircle progress |
| 22 | kadence/search | Search (Adv) | Blocks | top level | PHP markup | Search form, standard or modal |
| 23 | kadence/show-more | Show More | Blocks | top level | PHP markup | Collapsed content with a toggle button |
| 24 | kadence/spacer | Spacer / Divider | Blocks | top level | saved HTML + PHP CSS | Vertical space with optional divider line |
| 25 | kadence/table | Table (Adv) | Blocks | top level | PHP markup | Block-based table |
| 26 | kadence/table-row | Table (Adv) (row) | Blocks | parent: table | PHP markup | Table row |
| 27 | kadence/table-data | Table Data | Blocks | parent: table-row | PHP markup | Table cell (holds inner blocks) |
| 28 | kadence/tableofcontents | Table of Contents | Blocks | top level | PHP markup | Auto table of contents |
| 29 | kadence/tabs | Tabs | Blocks | top level | saved HTML + PHP CSS | Tabs, vertical tabs or accordion on small screens |
| 30 | kadence/testimonials | Testimonials | Blocks | top level | PHP markup | Testimonial grid or carousel |
| 31 | kadence/testimonial | Testimonial | Blocks | parent: testimonials | PHP markup | One testimonial |
| 32 | kadence/navigation | Navigation (Adv) | Blocks | top level | PHP markup | Menu stored in a `kadence_navigation` post |
| 33 | kadence/navigation-link | Kadence Navigation Link | Blocks | ancestor: navigation or core/navigation | PHP markup | Menu item, dropdown, mega menu |
| 34 | kadence/header | Header (Adv) | Blocks | top level | PHP markup | Block header stored in a `kadence_header` post |
| 35 | kadence/videopopup | Video Popup | Blocks (Pro adds options) | top level | PHP markup | Poster image that opens a video lightbox |
| 36 | kadence/vector | Vector SVG | Blocks | top level | PHP markup | Inline SVG stored in a `kadence_vector` post |
| 37 | kadence/advanced-form | Advanced Form | Blocks | top level | PHP markup | Form stored in a `kadence_form` post |
| 38 | kadence/advanced-form-text | (none) | Blocks | parent: advanced-form or column; ancestor: advanced-form | PHP markup | Text field |
| 39 | kadence/advanced-form-textarea | (none) | Blocks | same as above | PHP markup | Textarea |
| 40 | kadence/advanced-form-email | (none) | Blocks | same | PHP markup | Email field |
| 41 | kadence/advanced-form-number | (none) | Blocks | same | PHP markup | Number field |
| 42 | kadence/advanced-form-hidden | (none) | Blocks | same | PHP markup | Hidden field |
| 43 | kadence/advanced-form-date | (none) | Blocks | same | PHP markup | Date field |
| 44 | kadence/advanced-form-time | (none) | Blocks | same | PHP markup | Time field |
| 45 | kadence/advanced-form-telephone | (none) | Blocks | same | PHP markup | Telephone field |
| 46 | kadence/advanced-form-file | (none) | Blocks | parent: advanced-form only | PHP markup | File upload |
| 47 | kadence/advanced-form-radio | (none) | Blocks | parent: advanced-form only | PHP markup | Radio group |
| 48 | kadence/advanced-form-select | (none) | Blocks | parent: advanced-form or column | PHP markup | Select (optional multi) |
| 49 | kadence/advanced-form-checkbox | (none) | Blocks | parent: advanced-form or column | PHP markup | Checkbox group |
| 50 | kadence/advanced-form-captcha | Captcha | Blocks | parent: advanced-form or column | PHP markup | reCAPTCHA v2/v3, Turnstile, hCaptcha |
| 51 | kadence/advanced-form-accept | (none) | Blocks | parent: advanced-form or column | PHP markup | Consent checkbox |
| 52 | kadence/advanced-form-submit | Submit Button | Blocks | parent: advanced-form or column | PHP markup | Submit button |
| 53 | kadence/header-container-desktop | Desktop Header | Blocks | parent: header | PHP markup | Desktop layout container |
| 54 | kadence/header-container-tablet | Tablet Header | Blocks | parent: header | PHP markup | Tablet/mobile layout container |
| 55 | kadence/header-section | Header Section | Blocks | parent: header | PHP markup | Section inside a header row |
| 56 | kadence/header-row | Header Row | Blocks | parent: header | PHP markup | Top, middle or bottom row |
| 57 | kadence/header-column | Header Column | Blocks | parent: header | PHP markup | Left/center/right column area |
| 58 | kadence/off-canvas | (none) | Blocks | parent: header | PHP markup | Off-canvas (mobile) drawer |
| 59 | kadence/off-canvas-trigger | (none) | Blocks | ancestor: header | PHP markup | Hamburger trigger |
| 60 | kadence/dynamichtml | Dynamic HTML | Blocks Pro | top level | PHP callback | Outputs a dynamic field as HTML |
| 61 | kadence/dynamiclist | Dynamic List | Blocks Pro | top level | PHP callback | List of terms or meta values |
| 62 | kadence/imageoverlay | Image Overlay | Blocks Pro | top level | PHP callback | Image with hover overlay text |
| 63 | kadence/modal | Modal | Blocks Pro | top level | PHP callback | Popup triggered by link, button or load |
| 64 | kadence/portfoliogrid | Portfolio Grid | Blocks Pro | top level | PHP callback | Post-type grid with filter |
| 65 | kadence/postgrid | Post Grid | Blocks Pro | top level | PHP callback | Advanced post grid/carousel |
| 66 | kadence/repeater | Repeater | Blocks Pro | top level | PHP callback | Loops ACF repeater rows |
| 67 | kadence/repeatertemplate | Repeater Template | Blocks Pro | parent: repeater | PHP callback | Template for one repeater row |
| 68 | kadence/query | Query | Blocks Pro | top level | PHP callback | Query Loop (Adv), stored in `kadence_query` |
| 69 | kadence/query-card | Query (card) | Blocks Pro | parent: query or column; ancestor: query | PHP callback | Card template, stored in `kadence_query_card` |
| 70 | kadence/query-filter | (title says No Results) | Blocks Pro | parent: query, column or modal; ancestor: query | PHP callback | Dropdown filter |
| 71 | kadence/query-filter-checkbox | Filter - Checkbox | Blocks Pro | same | PHP callback | Checkbox filter |
| 72 | kadence/query-filter-buttons | Filter - Buttons | Blocks Pro | same | PHP callback | Button filter |
| 73 | kadence/query-filter-date | Query Filter Date | Blocks Pro | same | PHP callback | Date filter |
| 74 | kadence/query-filter-rating | Filter - Rating | Blocks Pro | same | PHP callback | Rating filter |
| 75 | kadence/query-filter-range | (title says No Results) | Blocks Pro | same | PHP callback | Range filter |
| 76 | kadence/query-filter-reset | Query Filter Reset | Blocks Pro | same | PHP callback | Reset filters button |
| 77 | kadence/query-filter-search | Query Filter Search | Blocks Pro | same | PHP callback | Search filter |
| 78 | kadence/query-filter-woo-attribute | Filter - Swatch | Blocks Pro | same | PHP callback | WooCommerce attribute swatches |
| 79 | kadence/query-noresults | No Results | Blocks Pro | parent: query or column; ancestor: query | PHP callback | Empty-state content |
| 80 | kadence/query-pagination | Pagination | Blocks Pro | same | PHP callback | Pagination |
| 81 | kadence/query-result-count | (title says Pagination) | Blocks Pro | parent: query, column or modal | PHP callback | "Showing x of y" |
| 82 | kadence/query-sort | (title says No Results) | Blocks Pro | parent: query or column | PHP callback | Sort control |
| 83 | kadence/slider | Advanced Slider | Blocks Pro | top level | PHP callback | Slider of slides |
| 84 | kadence/slide | Slide | Blocks Pro | top level in registry (inserter hidden), used in slider | PHP callback | One slide |
| 85 | kadence/splitcontent | Split Content | Blocks Pro | top level | PHP callback | Image + content split layout |
| 86 | kadence/userinfo | (title says Image Overlay) | Blocks Pro | top level | PHP callback | Current/author user info |
| 87 | kadence/marquee | Marquee (Adv) | Creative Kit | top level | PHP callback | Scrolling marquee |
| 88 | kadence/marquee-item | Marquee Item | Creative Kit | parent: marquee | PHP callback | One marquee item |

Count check: 59 free + 27 Pro + 2 Creative Kit = 88, matching the runtime list `[runtime]`.

### 2.3 Kadence blocks that exist but are not in the runtime list

| Block | Plugin | Why it is not in the runtime list |
|---|---|---|
| kadence/pane | Blocks | Accordion pane. Registered only in JavaScript (`registerBlockType("kadence/pane")` in `dist/blocks-accordion.js`); its `dist/blocks/accordion/pane/block.json` has no `name` key `[code]` |
| kadence/tab | Blocks | Tab panel inside Tabs. JS-only registration (`dist/blocks-tabs.js`); has `dist/blocks/tabs/tab/block.json` but no PHP registration `[code]` |
| kadence/countdown-inner, kadence/countdown-timer | Blocks | Countdown children, JS-only `[code]` `dist/blocks-countdown.js` |
| kadence/productcarousel | Blocks Pro | Loaded only when WooCommerce is active `[code]` `kadence-blocks-pro/class-kadence-blocks-pro.php:235-240` |
| kadence/page-wizard | Creative Kit | Registered only when `KADENCE_CREATIVE_KIT_BETA` is defined `[code]` `kadence-creative-kit/inc/KadenceCreativeKit/Blocks/Provider.php:31-33` |

Note: the header JavaScript registers `kadence/header-desktop-container` and `kadence/header-tablet-container` while the PHP block.json names are `kadence/header-container-desktop` and `kadence/header-container-tablet` `[code]` (`dist/blocks-header.js`, `dist/blocks/header/children/container-*/block.json`). Saved markup uses whatever the editor wrote; check a saved header post before scripting against these names `[unverified]`.

### 2.4 Inner-block relationships at a glance

- Row Layout > Section (`kadence/column`) is created by the row template; Section can also be inserted anywhere as a container `[code]` (no `parent` in `column/block.json`).
- Advanced Button > Single Button; Icon > Single Icon; Icon List > List item; Testimonials > Testimonial; Accordion > Pane; Tabs > Tab; Table > Table row > Table data; Countdown > Countdown Content / Countdown Timer `[code]` block.json `parent`.
- Advanced Form > fields; most fields also accept `kadence/column` as parent so they can sit in Sections inside a form (file and radio cannot) `[code]` field block.json files.
- Header > desktop/tablet containers > rows > sections > columns; off-canvas is a child of the header; off-canvas-trigger must be inside a header (ancestor) `[code]`.
- Navigation > Navigation Link (also allowed inside `core/navigation`) `[code]` `navigation-link/block.json`.
- Show More uses a template: a Section with class `kb-show-more-content` plus an Advanced Button with locked Single Buttons `[code]` `dist/blocks-show-more.js`.
- Search (Adv) uses an Advanced Button as its button template `[code]` `dist/blocks-search.js`.
- Query Loop children are Pro; see the Pro study.

## 3. Detailed sections (free top-level blocks)

Common support flags (from block.json `supports`, explained in section 4.2): `kbMetadata` (block name in List View), `ktdynamic` (dynamic content `[Pro]`), `ktanimate*` (scroll animation `[Pro]`), `kbcss` (Custom CSS box), `kbPreset`/`kbPalette` (Style Library presets and palette override).

### 3.1 Row Layout (`kadence/rowlayout`)

Purpose: the main section block. 170 attributes in block.json, 174 at runtime `[code]` `[runtime]`. Supports anchor, ktdynamic, kbcss, kbMetadata, kbPreset, kbPalette; no ktanimate on the row itself (animate a Section instead) `[code]` `rowlayout/block.json`.

Layout
- `columns` 1 to 6 (default 2); custom widths through `firstColumnWidth` ... `sixthColumnWidth` with Tablet and Mobile variants `[code]`.
- Preset layouts `colLayout` (desktop), `tabletLayout` (default `inherit`), `mobileLayout` (default `row`, meaning stacked). PHP handles values `equal`, `left-golden`, `right-golden`, `left-half`, `right-half`, `left-forty`, `right-forty`, `center-half`, `center-wide`, `center-exwide`, `first-row`, `last-row`, `two-grid`, `three-grid`, `grid-layout`, `row` `[code]` `class-kadence-blocks-row-layout-block.php:141-320`. The columns are a CSS grid (`grid-template-columns`) on `.kt-row-column-wrap` `[code]` same file.
- Collapse order: `collapseOrder` (default `left-to-right`) and `collapseOrderTablet` `[code]` block.json.
- Gaps: column gap `columnGutter` (`default`, `none`, `skinny`, `narrow`, `wide`, `wider`, `widest`, or custom via `customGutter` per device + `gutterType` unit); row gap `collapseGutter` / `tabletRowGutter` / `mobileRowGutter` / `customRowGutter` `[code]` block.json; gap keywords map to `--global-kb-gap-*` variables `[code]` `class-kadence-blocks-css.php:256-266`.
- Vertical alignment: `verticalAlignment` (default `top`), output as class `kt-row-valign-<value>` `[code]` `row-layout-block.php:1771`. "Inner column height 100%" is `columnsInnerHeight` (class `kt-inner-column-height-full`) `[code]`.
- Min height: `minHeight` (+ `minHeightTablet`, `minHeightMobile`, `minHeightUnit`) `[code]`.
- Inner content width: `maxWidth` + `maxWidthUnit` + `responsiveMaxWidth`; or `inheritMaxWidth` = use the theme content width (class `kb-theme-content-width`, max-width from the Kadence content width) `[code]` `row-layout-block.php:416`, `kadence-blocks/includes/init.php:115-137`.
- Breakout: with full width alignment, theme content width and 2 columns, `breakoutLeft` / `breakoutRight` let one column bleed to the screen edge `[code]` `row-layout-block.php:687-735`.
- HTML tag: `htmlTag` in `div`, `header`, `section`, `article`, `main`, `aside`, `footer` `[code]` `row-layout-block.php:43`.
- Alignment: `align` (none/wide/full) adds `align<value>` class `[code]` `row-layout-block.php:1745`.
- `zIndex` `[code]` block.json.
- Sticky: no sticky option on Row Layout in 3.9.1 (Section has one) `[code]` (no sticky attribute in `rowlayout/block.json`).

Background
- Types via `backgroundSettingTab`: `normal` (colour `bgColor`, image `bgImg` with size, position, repeat, attachment including `parallax`), `gradient` (`gradient`), `slider` (`backgroundSlider`, `backgroundSliderSettings`), `video` (`backgroundVideo`, `backgroundVideoType` `local`/`youtube`/`vimeo`) `[code]` `row-layout-block.php:72-83, 863-886, 1593-1612`.
- Separate tablet/mobile backgrounds: `tabletBackground`, `mobileBackground`, `tabletBackgroundType`, `mobileBackgroundType` `[code]`.
- Parallax is turned into `fixed` attachment, and fixed is turned off on mobile unless the `kadence_blocks_attachment_fixed_on_mobile` filter returns true `[code]` `row-layout-block.php:863-876`.

Overlay
- `overlay`, `overlaySecond`, `overlayFirstOpacity`, `overlaySecondOpacity`, gradient type/angle/location, `overlayGradient`, `overlayBgImg` with size/position/attachment/repeat, `overlayOpacity`, `overlayBlendMode`, `tabletOverlay`, `mobileOverlay` `[code]` block.json. Rendered as a `div.kt-row-layout-overlay` `[code]` `row-layout-block.php:1805`.

Shape dividers
- `topSep` / `bottomSep` with colour, flip, height (per device + unit) and width (per device). Built-in shapes: `ct`, `cti`, `ctd`, `ctdi`, `sltl`, `sltli`, `sltr`, `sltri`, `crv`, `crvi`, `crvl`, `crvli`, `crvr`, `crvri`, `wave`, `wavei`, `waves`, `wavesi`, `mtns`, `littri`, `littrii`, `threelevels`, `threelevelsi`. Add your own SVG paths with the `kadence_blocks_row_divider_paths` filter `[code]` `row-layout-block.php:1357-1382`.

Border, radius, shadow, spacing
- `borderStyle` (+ tablet/mobile), `borderRadius` (+ tablet/mobile, unit), `borderRadiusOverflow` (default true, clips content), `displayBoxShadow` + `boxShadow` `[code]` block.json.
- `padding` (default `["sm","","sm",""]`, so top/bottom use the spacing scale), `tabletPadding`, `mobilePadding`, `paddingUnit`, `margin`, `tabletMargin`, `mobileMargin`, `marginUnit` `[code]` block.json. Older top/bottom keys (`topPadding`, `topPaddingM`, ...) are legacy.

Colour
- `textColor`, `linkColor`, `linkHoverColor`, `bgColorClass` (palette class) `[code]`.

Visibility
- Hide on device: `vsdesk`, `vstablet`, `vsmobile`. Row outputs both classes `kb-v-lg-hidden` etc. and CSS `display:none !important` inside desktop-only, tablet-only and mobile media queries `[code]` `row-layout-block.php:1294-1307, 1746-1755`.
- Logged in / logged out and role rules (`loggedIn`, `loggedInUser`, `loggedInShow`, `loggedOut`) and Restrict Content Pro (`rcpAccess`, `rcpMembership`, `rcpMembershipLevel`) are evaluated in free on `render_block` `[code]` `kadence-blocks/includes/class-kadence-blocks-frontend.php:86, 101-140`. This is row-only. General conditional display for other blocks is `kadenceConditional` `[Pro]` `kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php:562`.

CSS hooks
- Classes: outer `kb-row-layout-wrap kb-row-layout-id<uniqueID> align<x>`, inner `kt-row-column-wrap kt-has-<n>-columns kt-row-layout-<colLayout> kt-tab-layout-<x> kt-mobile-layout-<x>` `[code]` `row-layout-block.php:1744-1770`. Generated selector `.kb-row-layout-id<uniqueID>` (old rows without `kbVersion` > 1 use `#kt-layout-id<uniqueID>`) `[code]` `row-layout-block.php:340-349`.
- Custom CSS box (kbcss): the word `selector` is replaced by the row selector `[code]` `row-layout-block.php:1346-1347`.
- Filters: `kadence_blocks_row_wrapper_args`, `kadence_blocks_row_slider_attrs`, `kadence_blocks_row_video_attrs`, `kadence_blocks_rowlayout_prevent_preload_for_mobile` `[code]` same file lines 1831, 1552, 1659, 1582.

Limits
- Max 6 columns per row `[code]`. Use nested rows or Section flex/grid for more.
- Row has no sticky and no entrance animation; put them on a Section `[code]`.

### 3.2 Section (`kadence/column`)

Purpose: column inside a row, or a stand-alone container anywhere. 132 attributes `[code]`.

- Layout: `direction` per device (`vertical`, `horizontal`, `vertical-reverse`, `horizontal-reverse`), `justifyContent`, `wrapContent`, `gutter`/`gutterVariable` (gap between items), `rowGap`/`rowGapVariable`, `verticalAlignment` (+ Tablet, Mobile), `flexBasis`, `flexGrow` (per device), `gridArea` `[code]` block.json, `class-kadence-blocks-column-block.php:69-96, 321-364`.
- Size: `maxWidth` (+ per-device units), `height`/`heightUnit` `[code]`.
- Sticky: `sticky`, `stickyOffset` (per device), `stickyOffsetUnit`; output as `--kb-section-setting-offset` `[code]` `column-block.php:150-167`.
- Whole-section link: `link`, `linkTarget`, `linkNoFollow`, `linkSponsored`, `linkTitle` `[code]`.
- Background normal/hover: `background`, `backgroundImg`, `backgroundType`, `gradient`, plus hover versions; overlay normal/hover with gradient and blend mode `[code]`.
- Border/radius/shadow normal and hover: `borderStyle`, `borderHoverStyle`, `borderRadius`, `borderHoverRadius`, `displayShadow`, `shadow`, `displayHoverShadow`, `shadowHover` (all with tablet/mobile where relevant) `[code]`.
- Spacing: `padding`, `tabletPadding`, `mobilePadding`, `margin`, ... `[code]`.
- Text: `textAlign`, `textColor`, `linkColor`, `linkHoverColor`, hover variants `[code]`.
- HTML tag: `htmlTag` (default `div`) `[code]`.
- Visibility: `vsdesk`, `vstablet`, `vsmobile` (saved class `kvs-lg-false` etc.; CSS in `dist/style-blocks-column.css`) `[code]`.
- `zIndex`, `collapseOrder` (order when the row collapses) `[code]`.
- Animation: ktanimate support, `[Pro]` (see 4.2).
- `kadenceFieldConditional`: conditional logic when the Section is inside an Advanced Form `[code]` block.json (form logic UI: `[unverified]` whether Pro).
- Custom CSS: `selector` maps to `.kadence-column<uniqueID>` `[code]` `column-block.php:953-954`. Inner wrapper `.kt-inside-inner-col` `[code]` `column-block.php:83`.

Common uses: cards (border, radius, shadow, hover), sticky sidebars, horizontal button/icon rows, linked cards.

### 3.3 Advanced Text (`kadence/advancedheading`)

There is no separate "Advanced Text" block; the Advanced Heading block is titled "Advanced Text" in 3.9.1 `[code]` `advancedheading/block.json`, `[runtime]`.

- Tag: `htmlTag` = `heading` (then `level` 1-6, default 2), `p`, `span` or `div` `[code]` `class-kadence-blocks-advanced-heading-block.php:52, 520`.
- Typography: `typography`, `googleFont`, `fontWeight`, `fontStyle`, `textTransform`, sizes `fontSize` (responsive array) and legacy `size`/`tabSize`/`mobileSize`, line height, `letterSpacing` per device `[code]`.
- Colour: `color`, `colorClass`, `background`, `linkColor`, `linkHoverColor`, `linkStyle`; text gradient `enableTextGradient` + `textGradient`; `textShadow` per device `[code]`.
- Highlight ("mark") styling: full set of `mark*` attributes (font, colour, background, gradient, padding, border, radius) `[code]`.
- Icon: `icon`, `iconSide`, `iconSize`, colours, `iconTooltip` `[code]`.
- Inline image: `inlineImageWidth`, borders, vertical align `[code]`.
- Link: `link`, `linkTarget`, `linkNoFollow`, `linkSponsored` `[code]`.
- Layout: `align` per device, `maxWidth`, `maxHeight`, `textOrientation` (vertical text), `useRatio`/`ratio` `[code]`.
- Spacing: `padding`, `margin` per device; border and radius `[code]`.
- Typed text effect: content with `kt-typed-text` loads `typed.min.js` `[code]` `advanced-heading-block.php:509, 695`.
- Reveal animations `reveal-left/right/up/down` wrap the text; the `kadenceAnimation` attribute itself comes from Pro `[code]` `advanced-heading-block.php:524`, `[Pro]`.
- Selector: `.wp-block-kadence-advancedheading.kt-adv-heading<uniqueID>` `[code]` `advanced-heading-block.php:77`.
- Supports kbPreset and kbPalette (Style Library text presets) `[code]`.

Use: every heading and styled paragraph where you need per-device typography or palette colours. Use core Paragraph for long body copy if you want theme typography only.

### 3.4 Advanced Button (`kadence/advancedbtn`) and Single Button (`kadence/singlebtn`)

- Group: `hAlign`/`thAlign`/`mhAlign`, `vAlign` per device, `orientation` per device, `gap` per device, `widthType`, `collapseFullwidth`, padding/margin `[code]` `advancedbtn/block.json`. Selector `.wp-block-kadence-advancedbtn.kt-btns<uniqueID>` `[code]` `class-kadence-blocks-advancedbtn-block.php:65`.
- Single button: `text`, `link`, `target`, `noFollow`, `sponsored`, `download`, `buttonRole` (renders a button role), `inheritStyles` (`fill` default, `outline`, `inherit` = theme button style, `inherit-secondary`), `sizePreset` (class `kt-btn-size-<preset>`, default `standard`), `widthType`/`width` `[code]` `class-kadence-blocks-singlebtn-block.php:85-87, 440-499`, block.json.
- Styles normal and hover: colour, background or gradient, text gradient, border per device, radius per device, shadow; separate sticky-header and transparent-header states (`*Sticky`, `*Transparent`) for use inside the Kadence header `[code]` block.json.
- Icon: `icon`, `iconSide`, `iconHover`, `onlyIcon` per device, `iconReveal`, `iconSize`, `iconPadding` `[code]`.
- Typography `typography` `[code]`. Tooltip `tooltip`, `tooltipPlacement` `[code]`.
- Classes: `kb-button kt-button button kb-btn<uniqueID> kt-btn-size-<x> kb-btn-global-<style>` `[code]` `singlebtn-block.php:440-453`.
- Animation: ktanimate `[Pro]`. Dynamic link/text: ktdynamic `[Pro]`.

### 3.5 Icon (`kadence/icon`) and Single Icon (`kadence/single-icon`)

- Group: alignment per device, `wrapIcons`, `verticalAlignment`, `gap` `[code]`.
- Single icon: `icon`, `link`, `target`, `size` per device, `width` (stroke), `style` (`default` or stacked), `color`, `background`, `border`, `borderRadius`, `borderWidth`, `padding`/`margin` per device, hover `hColor`/`hBackground`/`hBorder`, `tooltip` `[code]` `single-icon/block.json`.
- Selector `.kt-svg-item-<uniqueID>` `[code]` `class-kadence-blocks-single-icon-block.php:65`.
- Icons are SVG from the bundled sets (`includes/icons-array.php`, `icons-ico-array.php`) `[code]`; custom SVG upload is Pro (`kadence_custom_svg` post type) `[Pro]` `[runtime]`.

### 3.6 Icon List (`kadence/iconlist`) and List item (`kadence/listitem`)

- List: `columns` per device, `listGap`, `columnGap`, `listLabelGap` per device, `iconAlign`, global `icon`, `iconSize`, `color`, `background`, `border`, `style`, `listStyles` (typography), `linkUnderline`, link colours, margin/padding per device `[code]`.
- Item: own `icon`, `showIcon`, `link`, `text`, `level` (indent), `tooltip`, colours, highlight (`mark*`) attributes `[code]`.
- Selector `.wp-block-kadence-iconlist.kt-svg-icon-list-items<uniqueID>` `[code]` `class-kadence-blocks-icon-list-block.php:72`.
- Use for feature lists, checklists, contact lists. Dynamic text per item `[Pro]`.

### 3.7 Info Box (`kadence/infobox`)

- `mediaType` (`icon` default, `image`, `number`, `none`), `mediaAlign` per device (`top` default, left, right), `mediaVAlign`, `mediaIcon`/`mediaImage`/`mediaNumber` style objects including hover animations (`drawborder`, `grayscale-border-draw`, ...) `[code]` `class-kadence-blocks-infobox-block.php:242, 427`.
- Title (`title`, `titleTagType`, `titleFont`, colours, `titleMinHeight`), text (`contentText`, `textFont`, colours, `textMinHeight`), learn more (`displayLearnMore`, `learnMore`, `learnMoreStyles`) `[code]`.
- Link: `link`, `linkProperty` (`box` default or learn more only), `target`, `linkNoFollow`, `linkSponsored`, `linkTitle` `[code]`.
- Container normal/hover: background, border, radius per device, shadow per device, padding/margin, `maxWidth` per device, `fullHeight` `[code]`.
- Selector `.kt-info-box<uniqueID>` (older: `#kt-info-box<uniqueID>`) `[code]` `infobox-block.php:64-66`.

### 3.8 Tabs (`kadence/tabs`) with Tab (`kadence/tab`)

- `layout` (`tabs` default, `vtabs` vertical), `tabletLayout`, `mobileLayout` (can switch to `accordion`) `[code]` block.json, `dist/blocks-tabs.js`.
- `titles` array (text, icon, subtitle, anchor), `startTab`, `tabAlignment`, `widthType` (`normal` or `percent` with `tabWidth`), `verticalTabWidth`, `gutter` `[code]`.
- Title styles normal/hover/active: colour, background, border, radius, padding, margin per device; typography; `enableSubtitle` + `subtitleFont`; icon size per device `[code]`.
- Content: `contentBgColor`, border styles per device, radius per device, `innerPadding` per device, `minHeight` and `maxWidth` per device `[code]`.
- `linkPaneCollapse` `[code]`. Selector `.kt-tabs-id<uniqueID>` `[code]` `class-kadence-blocks-tabs-block.php:91`.
- Each tab holds any blocks.

### 3.9 Accordion (`kadence/accordion`) with Pane (`kadence/pane`)

- `paneCount`, `openPane`, `startCollapsed`, `linkPaneCollapse` (one open at a time, default true), `showIcon`, `iconStyle` (default `basic`), `iconSide`, `iconColor` `[code]` block.json.
- Title styles (`titleStyles`, border normal/hover/active per device, radius per device), content background/border/radius/padding per device, `columnLayout` + `columnGap` (multi-column accordion) `[code]`.
- FAQ schema: `faqSchema` outputs one `FAQPage` JSON-LD script in the head `[code]` `class-kadence-blocks-accordion-block.php:296-300`, `class-kadence-blocks-frontend.php:84`.
- Pane: `title`, `titleTag`, `icon`, `iconSide`, `hideLabel`, `ariaLabel`; dynamic content support `[code]` `accordion/pane/block.json`.
- Selector `.kt-accordion-id<uniqueID>` `[code]` `accordion-block.php:61`.

### 3.10 Advanced Gallery (`kadence/advancedgallery`)

- `type`: `masonry` (default), `grid`, `carousel`, `fluidcarousel`, `slider` in free; `thumbslider` (Thumbnail Slider), `tiles` and `mosaic` are disabled in the free UI and need Pro `[code]` `dist/blocks-advancedgallery.js` ("(Pro addon)"/"(Pro only)" labels), `[Pro]`.
- Columns per breakpoint (`columns`, `columnControl`), `gap`/`gutter` per device, `imageRatio`, `thumbSize`/`lightSize`, `mosaicRowHeight`, `carouselHeight`, `thumbnailRatio`/`thumbnailColumns` `[code]`.
- Links and lightbox: `linkTo` (`none`, `media`, `attachment`, `custom`), `lightbox`, `lightboxCaption` `[code]`.
- Captions: `showCaption`, `captionStyle`, `captionStyles`, `captionAlignment`; hover style; `imageFilter`; radius per device; shadow and hover shadow `[code]`.
- Carousel: `autoPlay`, `autoSpeed`, `transSpeed`, `slidesScroll`, `slideType`, `arrowStyle`, `dotStyle`, `arrowPosition` (several positions are Pro only), custom arrow/dot colours, `showPauseButton`, `carouselAlign` `[code]`.
- `lazyLoad`, `overflow`, `mobileForceHover` `[code]`.
- Dynamic images (`imagesDynamic`, ACF gallery fields) need Pro dynamic content `[code]` `class-kadence-blocks-advancedgallery-block.php:1097`, `[Pro]`.
- Selector `.kb-gallery-id-<uniqueID>` `[code]` `advancedgallery-block.php:418`.

### 3.11 Testimonials (`kadence/testimonials`) with Testimonial

- `layout` `grid` (default) or carousel; `carouselType` default `loop`; `style` (`basic` default, `card`, `bubble`, `inlineimage`); `columns` 6 breakpoint values `[code]` block.json, `class-kadence-blocks-testimonials-block.php:83, 317, 715, 834`.
- Display toggles: media (image or icon), title, content, name, occupation, rating, icon `[code]`.
- Styles for container (background, border per device, radius per device, padding), media, title, content, name, occupation, rating, icon; `containerMinHeight`, `containerVAlign` `[code]`.
- Carousel: `autoPlay`, `autoSpeed`, `transSpeed`, `slidesScroll`, `arrowStyle`, `dotStyle`, `showPauseButton` `[code]`.
- `useBlockQuoteTags` `[code]`. Testimonial child supports dynamic content `[code]`.
- Selector `.kt-blocks-testimonials-wrap<uniqueID>` `[code]` `testimonials-block.php:90`.

### 3.12 Countdown (`kadence/countdown`)

- `countdownType` `date` (default) or evergreen `[Pro]`; `date`, `timezone`, `timestamp` `[code]` block.json, `dist/blocks-countdown.js` ("Evergreen (Pro addon)").
- `expireAction` default `none`; Hide, Redirect and Replace with Content are Pro `[code]` JS labels, `[Pro]`.
- `units` (days/hours/minutes/seconds), `timerLayout` (`block` default, `inline`), labels, `countdownDivider`, `timeNumbers` `[code]`.
- Number/label/pre/post label fonts and colours, item background/border/radius/padding per device, container background/border/padding/margin per device `[code]`.
- Visibility `vsdesk`, `vstablet`, `vsmobile` `[code]`. Pause button `enablePauseButton` `[code]`.
- Evergreen config passes through the `kadence_blocks_countdown_evergreen_config` filter, which Pro implements `[code]` `class-kadence-blocks-countdown-block.php:616`, `kadence-blocks-pro/includes/class-kadence-blocks-pro-frontend.php`.

### 3.13 Count Up (`kadence/countup`)

- `start`, `end`, `startDecimal`, `endDecimal`, `prefix`, `suffix`, `duration`, `separator`, `decimal`, `decimalSpaces` `[code]` block.json.
- Title and number fonts, colours, hover colours, padding/margin per device, alignment, min height `[code]`.
- Selector `.kb-count-up-<uniqueID>` `[code]` `class-kadence-blocks-countup-block.php:79`.

### 3.14 Posts (`kadence/posts`)

- Simple query: `postType`, `postTax`, `taxType`, `categories`, `tags`, `excludeTax`, `order`, `orderBy`, `postsToShow` (6), `offsetQuery`, `allowSticky`, `showUnique` `[code]` block.json.
- `columns` (3) with `tabletColumns`, `mobileColumns`; `loopStyle` (`boxed` default) `[code]`.
- Image, categories, meta (author, date, updated date, categories, comments), excerpt length, read more `[code]`.
- Uses the Kadence theme loop markup (`.entry.loop-entry`) `[code]` `class-kadence-blocks-posts-block.php:68`.
- Limits: no pagination, no filters, no carousel, no custom card layout. Use Query Loop (Adv) `[Pro]` or Post Grid `[Pro]`, or core Query Loop, when you need those.

### 3.15 Query Loop (`kadence/query`) and Query Card

Pro only. The block stores its settings in a `kadence_query` post and its card layout in a `kadence_query_card` post `[code]` `kadence-blocks-pro/includes/query/query-cpt.php:14`, `query-card-cpt.php:12`; both post types show in the admin `[runtime]`. Children: filters, sort, pagination, result count, no results (table 2.2). See the Pro study for details.

### 3.16 Table of Contents (`kadence/tableofcontents`)

- `allowedHeaders` (h1-h6 toggles), `columns`, `listStyle` (`disc` default), `linkStyle`, `enableTitle`, `title`, `enableToggle`, `startClosed`, `toggleIcon`, `enableTitleToggle` `[code]` block.json.
- `enableScrollSpy` + `contentActiveColor`, `enableSmoothScroll` + `smoothScrollOffset` `[code]`.
- `enableDynamicSearch` (scan rendered page) and `enableTemplateSearch` (include template blocks) `[code]`.
- Title/content typography, colours, container padding/margin/border/radius/shadow per device, `maxWidth` per device `[code]`.
- Accordion panes are skipped by default (`kadence_toc_inner_block_ignore_array` filter) `[code]` `kadence-blocks/includes/class-kadence-blocks-table-of-contents.php:295`.
- Selector `.kb-table-of-content-nav.kb-table-of-content-id<uniqueID>` `[code]` `class-kadence-blocks-table-of-contents-block.php:72`.

### 3.17 Advanced Form (`kadence/advanced-form`) and legacy Form (`kadence/form`)

Advanced Form
- The block holds only `id`, `uniqueID`, `legacyMigration`; the form itself is a `kadence_form` post (admin menu under Kadence) with all settings in post meta `_kad_form_*` (fields, actions, email, redirect, messages, styles, recaptcha, `browserValidation`, `submitHide`, `enableAnalytics`, ...) `[code]` `kadence-blocks/includes/advanced-form/advanced-form-cpt.php:6, 128-177`, `[runtime]`.
- Fields: text, textarea, email, number, hidden, date, time, telephone, file, radio, select, checkbox, accept, captcha, submit (table 2.2). Field attributes include `label`, `showLabel`, `placeholder`, `required`, `requiredMessage`, `errorMessage`, `helpText`, `ariaDescription`, `inputName`, `defaultValue` + `defaultParameter` (prefill from URL parameter), `auto` (autocomplete), `maxWidth`/`minWidth` `[code]` field block.json files.
- Field conditional logic: `ktfieldconditional` support on most fields `[code]`; the docs say conditional fields need Blocks Pro `[docs]` (advanced-form-block); confirm in the field's Advanced panel without Pro.
- Captcha types: Google v2, Google v3, Turnstile, hCaptcha `[code]` `advanced-form-ajax.php:82-94`. Keys can come from Kadence settings options (`kadence_blocks_recaptcha_site_key`, `kadence_blocks_turnstile_site_key`, `kadence_blocks_hcaptcha_site_key`, ...) `[code]` `settings/class-kadence-blocks-settings.php:977-1043`.
- Submit actions in free: `email`, `redirect`, `mailerlite`, `fluentCRM` `[code]` `advanced-form-ajax.php:210-230`. Pro adds Database Entry, Auto Respond Email, WebHook, MailChimp, Brevo, ActiveCampaign, Kit (ConvertKit), GetResponse `[code]` `dist/blocks-advanced-form.js` labels, `kadence-blocks-pro/includes/form/kbp-form-actions.php:51-578`, `[Pro]`.
- Hooks: `kadence_blocks_advanced_form_actions`, `kadence_blocks_advanced_form_processed_fields`, `kadence_blocks_advanced_form_submission_reject`, `kadence_blocks_advanced_form_submission` (action), `kadence_blocks_advanced_form_submission_success`, `kadence_blocks_advanced_form_submission_messages`, `kadence_blocks_advanced_form_redirect`, `kadence_blocks_advanced_form_upload_directory`, `kadence_advanced_form_actions` `[code]` `advanced-form-ajax.php:108-139, 210-228, 732`.
- Selector `.wp-block-kadence-advanced-form<uniqueID>` `[code]` `class-kadence-blocks-advanced-form-block.php:103`.

Legacy Form
- `kadence/form` is hidden from the inserter (`supports.inserter:false`) and kept for old content. Actions: email, redirect, mailerlite, fluentcrm in free; others Pro `[code]` `dist/blocks/form/block.json`, `dist/blocks-form.js`.

### 3.18 Navigation (Adv) (`kadence/navigation`) and Navigation Link

- The block stores `id` of a `kadence_navigation` post; all styling is post meta `_kad_navigation_*`: `orientation` per device, `style` per device, `spacing`, link padding/margin, colours normal/hover/active plus sticky and transparent header states, dropdown width/reveal/shadow/border, `collapseSubMenus`, `parentTogglesMenus`, `stretchFill`, `horizontalLayout`/`horizontalGrid`, `divider`, `enableScrollSpy` + offsets, descriptions `[code]` `kadence-blocks/includes/navigation/class-kadence-navigation-cpt.php:166-196`.
- Navigation Link: 304 attributes. Label, URL, `description`, `opensInNewTab`, `disableLink`, `highlightLabel` (badge), media (icon or image), `isMegaMenu` with `megaMenuWidth`/`megaMenuCustomWidth` per device, dropdown alignment/width/typography, per-state colours including sticky and transparent, `dropdownClick` `[code]` `navigation-link/block.json`. Mega menu, link media and highlight labels are Blocks Pro features `[docs]` (navigation-link-block-tips, advanced-header-navigations); confirm in the editor without Pro.
- `kadenceConditional` on links and sections is Pro conditional display `[code]` `[Pro]`.
- Selector `.wp-block-kadence-navigation<uniqueID>` `[code]` `class-kadence-blocks-navigation-block.php:86`.

### 3.19 Header (Adv) (`kadence/header`) block header builder

- The block stores `id` of a `kadence_header` post. Settings in meta `_kad_header_*`: `isSticky`/`isStickyTablet`/`isStickyMobile`, `stickySection` per device, `revealScrollUp`, `shrinkMain` + heights, `isTransparent` per device, `autoTransparentSpacing`, `inheritPostTransparent`, `disableTransparentOverrides`, `mobileBreakpoint`, `headerTag`, background normal/sticky/transparent, border and radius per state and device, typography, link colours, height/width `[code]` `kadence-blocks/includes/header/class-kadence-header-cpt.php:196-227`.
- Inner structure: desktop container and tablet container, each with header rows (`layout`, `minHeight`, `maxWidth`, `itemGap`, `vAlign`, `sectionPriority`, background, border, padding per device), sections and columns; Off Canvas (slide from, width, background, page overlay colour, close icon) and Off Canvas Trigger (hamburger icon, colours, border per device) `[code]` header children block.json.
- Pieces made for headers: Site identity (`kadence/identity`), Advanced Image sticky/transparent logo variants (`urlSticky`, `urlTransparent`, ...), Single Button sticky/transparent styles, Navigation (Adv), Search (Adv) `[code]` block.json files, `usesContext` `kadence/headerIsSticky`, `kadence/headerIsTransparent`.
- Header backdrop filter is Pro (`pro_backdropFilterString`) `[code]` `class-kadence-blocks-header-block.php:96`, `[Pro]`.
- Custom CSS box on Header Row (kbcss) `[code]` `header/class-kadence-blocks-header-row-block.php:177`.
- When to use: block themes or layouts that place a header block in a template. With the classic Kadence theme, its Customizer Header Builder is the usual choice; order of precedence `[docs]`: the Customizer "Enable a Block Header" setting (`blocks_header`, `blocks_header_id`) sets the global Header (Adv); a Hooked Element with "Replace Header" wins where its conditions match; the free manual route is Disable Header per page plus a header block (use-advanced-headers-globally-conditionally).

### 3.20 Advanced Image (`kadence/image`)

- Ratio crop (`useRatio`, `ratio`), `imgMaxWidth` per device, `sizeSlug`, `imagePosition` (object position), `align` `[code]`.
- Link (`link`, `linkTarget`, `linkNoFollow`, `linkSponsored`, `linkTitle`, `linkClass`) `[code]`.
- Border width/style/colour and radius per device, box shadow, drop shadow, `imageFilter` `[code]`.
- Mask: `maskSvg` (default `none`), `maskUrl`, `maskSize`, `maskPosition`, `maskRepeat`; built-in masks in `includes/assets/images/masks/` `[code]` block.json, `class-kadence-blocks-editor-assets.php` (`svgMaskPath`).
- Overlay: `overlay`, `overlayOpacity`, `overlayType` (`normal` default or gradient), `overlayGradient`, `overlayBlendMode` `[code]`.
- Caption (`showCaption`, `captionStyles`), `tooltip`, `preventLazyLoad`, `globalAlt` (use media library alt), `zIndex` `[code]`.
- Sticky/transparent header image variants `[code]`.
- Selector `.wp-block-kadence-image.kb-image<uniqueID>` `[code]` `class-kadence-blocks-image-block.php:65`.

### 3.21 Spacer / Divider (`kadence/spacer`)

- `spacerHeight` (60 px default) with tablet/mobile and units; `dividerEnable`, `dividerStyle` (`solid` default), `dividerColor`, `dividerOpacity`, `dividerWidth` and `dividerHeight` per device, `rotate`, `strokeWidth`, `strokeGap`, `hAlign` per device `[code]` block.json.
- Visibility `vsdesk`, `vstablet`, `vsmobile` `[code]`.
- Selector `.wp-block-kadence-spacer.kt-block-spacer-<uniqueID>` `[code]` `class-kadence-blocks-spacer-block.php:69`.

### 3.22 Google Maps (`kadence/googlemaps`)

- `apiType` `embed` (default, no key) or JavaScript API (needs the key stored in `kadence_blocks_google_maps_api`) `[code]` block.json, `settings/class-kadence-blocks-settings.php:1065`.
- `location`, `lat`, `lng`, `zoom`, `mapType`, `mapStyle`, `customSnazzy`, `mapFilter` + amount, `showMarker`, `showControls`, height and width per device, margin/padding per device `[code]`.
- Privacy: the embed loads Google content; consent handling is up to your consent tool `[unverified]`.

### 3.23 Progress Bar (`kadence/progress-bar`)

- `barType` (`line` default; circle and semicircle `[unverified]` names, check the editor), `progressAmount`, `progressMax`, `duration`, `easing`, `delayUntilInView`, `showMaxProgressOnPageLoad` `[code]`.
- Label: `label`, `displayLabel`, `labelLayout` (`lp`, `pl`, `lt`, `lb`), `labelPosition` (above/below), fonts; number prefix/suffix, `displayPercent`, `decimal`, `numberIsRelative` `[code]` block.json, `dist/blocks-progress-bar.js`.
- Colours, opacity, `progressWidth` per device, `containerMaxWidth` per device, `progressBorderRadius`, mask SVG, `ariaLabel` `[code]`.
- No `supports` block (no List View naming support) `[code]`, `[runtime]`.

### 3.24 Show More (`kadence/show-more`)

- `heightDesktop` (250), `heightTablet`, `heightMobile`, `heightType`; `defaultExpandedDesktop/Tablet/Mobile`; `enableFadeOut`, `fadeOutSize`; `showHideMore` (show the "less" button) `[code]` block.json.
- Template: a Section with the content and an Advanced Button with two locked buttons `[code]` `dist/blocks-show-more.js`.
- Selector `.kb-block-show-more-container<uniqueID>` `[code]` `class-kadence-blocks-show-more-block.php:72`.

### 3.25 Table (Adv) (`kadence/table`)

- `columns`, `isFirstRowHeader`, `isFirstColumnHeader`, `columnSettings`, `evenOddBackground` + even/odd colours and hover colours, `columnBackgrounds`, borders per device, `borderOnRowOnly`, `cellPadding` per device, header/data/caption typography, alignment per device, `rowMinHeight` per device, `maxWidth`, `maxHeight`, `overflowXScroll`, caption `[code]` block.json.
- Cells (`kadence/table-data`) are containers for blocks `[code]`.
- Pro adds extra table styles through `Kadence_Blocks_Pro_Table_Block` `[code]` `class-kadence-blocks-table-block.php:76`, `kadence-blocks-pro/includes/free-blocks/class-kadence-blocks-pro-table-block.php`, `[Pro]`.
- Selector `.kb-table-container<uniqueID>` `[code]` `table-block.php:81`.

### 3.26 Search (Adv) (`kadence/search`)

- `displayStyle` `standard` (default) or `modal`; `showButton`, `buttonSide`, `searchProductsOnly`, `inputPlaceholder`, `label` `[code]` block.json, `dist/blocks-search.js`.
- Input colours (normal and focus, background types including gradients), placeholder colour, border styles per device, radius per device, padding/margin per device, typography, min/max width; icons and close icon for modal; modal background `[code]`.
- Selector `.kb-search<uniqueID>` `[code]` `class-kadence-blocks-search-block.php:69`.

### 3.27 Video Popup (`kadence/videopopup`)

- `type` `iframe` (default, YouTube/Vimeo URL) or local video (label "Video (Pro addon)") `[code]` block.json, `dist/blocks-videopopup.js`, `[Pro]`.
- `url`, `urlMobile` (separate mobile video), poster `media`/`mediaPoster`, `ratio`, `mediaRatio`, `playBtn` styles, popup settings (`popup` object: overlay colour, close button), `youtubeCookies` (default true; false uses the no-cookie domain `[unverified]`), `isVimeoPrivate`, `maxWidth`, border/radius/shadow, padding/margin `[code]`.
- Uses GLightbox scripts `[code]` `class-kadence-blocks-videopopup-block.php:62-64`.
- Selector `.kadence-video-popup<uniqueID>` `[code]` line 83.

### 3.28 Lottie Animations (`kadence/lottie`)

- `fileSrc` `url` (default) or local file; uploaded animations are stored as `kadence_lottie` posts `[code]` block.json, `kadence-blocks/includes/init.php:552`, `[runtime]`.
- Playback: `autoplay`, `loop`, `loopLimit`, `onlyPlayOnHover`, `onlyPlayOnScroll`, `waitUntilInView`, `startFrame`, `endFrame`, `bouncePlayback`, `playbackSpeed`, `delay`, `showControls` `[code]`.
- Size `width`, `ratio`/`useRatio`; padding/margin per device; `label` (accessible name) `[code]`.
- Uploads are sanitised by `class-kadence-blocks-lottie-sanitizer.php` `[code]`.

### 3.29 Vector SVG (`kadence/vector`)

- Stores `id` of a `kadence_vector` post (inline SVG), plus `maxWidth`, padding/margin per device, `align` left/right `[code]` block.json, `init.php:587`, `[runtime]`.
- Selector `.kb-vector-container<uniqueID>` `[code]` `class-kadence-blocks-vector-block.php:77`.
- Good for brand graphics as editable inline SVG without custom HTML.

### 3.30 Site identity (`kadence/identity`)

- Logo (the docs say the block uses the core site logo, title and tagline blocks inside `[docs]`, site-identity-block), `showSiteTitle`, `showSiteTagline`, `layout`, `linkToHomepage`, `titleTypography`, `taglineTypography`, padding/margin per device, sticky/transparent logo variants `[code]` block.json.

### 3.31 Blocks asked about that do not exist in free 3.9.1

| Asked | Finding |
|---|---|
| Separate "Advanced Text" block | No. It is `kadence/advancedheading` titled "Advanced Text" `[code]` |
| Modal | Pro (`kadence/modal`) `[code]` |
| Off canvas | Only as a header child (`kadence/off-canvas`), not a general popup `[code]` |
| Video popup | Free since 3.4.4; local video type Pro `[code]` |
| Query loop | Pro `[code]` |
| Slider | Pro `kadence/slider`; free has gallery slider and row background slider `[code]` |
| Marquee | Creative Kit `[code]` |
| Counter | Yes: `kadence/countup` `[code]` |

## 4. Shared component layer

### 4.1 Common attribute patterns

- `uniqueID`: every block. Drives the generated selector and the style id `kb-<block><uniqueID>` `[code]` `class-kadence-blocks-abstract-block.php:302-345`.
- Responsive values: see section 1. The CSS builder writes tablet and mobile rules inside the media queries in section 1 `[code]` `class-kadence-blocks-css.php:410-427`.
- Units: separate `*Unit`/`*Type` attributes (`px`, `em`, `rem`, `%`, `vw`, `vh` depending on control) `[code]` block.json files.
- Spacing scale: padding/margin values can be keywords instead of numbers: `ss-auto`, `none`, `xxs`, `xs`, `sm`, `md`, `lg`, `xl`, `xxl`, `3xl`, `4xl`, `5xl`, output as `var(--global-kb-spacing-<key>, <rem fallback>)` `[code]` `class-kadence-blocks-css.php:228-240`. The values are printed on `:root` from the design-token baseline `[code]` `kadence-blocks/includes/init.php:146-150`.
- Font size scale: `sm`, `md`, `lg`, `xl`, `xxl`, `3xl` map to `var(--global-kb-font-size-*)` (fluid `clamp()` values from the token baseline; filter `kadence_blocks_variable_font_sizes`) `[code]` `class-kadence-blocks-css.php:245-250`, `init.php:103-112`.
- Gap scale: `none`, `skinny`, `narrow`, `default`, `wide`, `wider`, `widest`, `xs`, `sm`, `md`, `lg` map to `--global-kb-gap-*` or fixed px `[code]` `class-kadence-blocks-css.php:256-266`.
- Colours: palette references are stored as `palette1` ... `palette15`. `render_color()` turns `paletteN` into `var(--global-paletteN, <fallback hex>)`; a hex with opacity becomes rgba `[code]` `class-kadence-blocks-css.php:1205-1252`. The Kadence theme defines `--global-palette1..15`, so palette colours follow the theme palette, including a dark palette switch when the theme provides one `[unverified]` for dark mode (see Theme study).
- Typography objects (`typography` arrays with family, weight, style, size per device, line height, letter spacing, transform) are rendered by `render_typography()`; Google fonts are queued by `maybe_add_google_font()` `[code]` method list in `class-kadence-blocks-css.php`.
- Borders: newer blocks use `borderStyle` objects per device (top/right/bottom/left with colour, style, width, unit) rendered by `render_border_styles()` `[code]`.
- Shadows: `shadow`/`boxShadow` arrays (`color`, `opacity`, `hOffset`, `vOffset`, `blur`, `spread`, `inset`) via `render_shadow()` `[code]`.
- `inQueryBlock`: set when the block is inside a Query Loop card `[code]`.
- `noCustomDefaults`: skip Block Defaults when inserted `[code]`.
- `kbVersion`: markup version; selectors change between versions (Row Layout example above) `[code]`.

### 4.2 Support flags (custom `supports` keys)

| Flag | Effect | Product |
|---|---|---|
| `kbMetadata` | Adds `metadata.name` so the block can be named in List View | Blocks `[code]` `dist/early-filters.js` |
| `kbContentLabel` | Uses a content attribute (title, text, label) as the List View label | Blocks `[code]` same |
| `kbcss` | Adds a Custom CSS box (Advanced panel). `selector` is replaced by the block selector. Only on rowlayout, column and header-row | Blocks `[code]` `dist/extension-block-css.js`, `row-layout-block.php:1346`, `column-block.php:953` |
| `ktanimate`, `ktanimateadd`, `ktanimatepreview`, `ktanimateswipe`, `ktanimatereveal` | Scroll animation attributes (`kadenceAnimation` etc.); front end adds `data-aos` | Pro `[code]` `kadence-blocks-pro/includes/blocks/kadence-animate-on-scroll.php:65-66` |
| `ktdynamic` | Dynamic content (post fields, ACF, repeater row data) | Pro `[code]` `kadence-blocks-pro/includes/dynamic-content/` |
| `ktfieldconditional` | Form field conditional logic | Blocks attribute; UI ownership `[unverified]` |
| `kbPreset`, `kbPalette` | Style Library preset class and palette override | Blocks 3.8+ `[code]` (see 4.4) |

Blocks with `kbPreset`: rowlayout, column, advancedheading, singlebtn, single-icon, image `[runtime]` (matches `Design_Tokens/Registry/declarations.php` block entries `[code]`).

### 4.3 Hide on device and visibility

- Only rowlayout, column, countdown and spacer have `vsdesk`/`vstablet`/`vsmobile` in free `[code]` block.json files. Row uses inline CSS plus classes; Section, Countdown and Spacer save `kvs-lg-false`/`kvs-md-false`/`kvs-sm-false` classes whose CSS is in each block stylesheet `[code]` `dist/style-blocks-column.css`, `dist/style-blocks-spacer.css`.
- Hidden blocks are still in the HTML (CSS `display:none`). Row background videos are not preloaded on hidden devices (`kadence_blocks_rowlayout_prevent_preload_for_mobile`) `[code]`.
- User-role display: Row Layout only in free (section 3.1). Other blocks: Pro conditional display `[Pro]`.
- "Block Settings Visibility" in the editor controls which settings panels each user role sees. It does not hide blocks on the site. Stored in option `kadence_blocks_settings_blocks` `[code]` `settings/class-kadence-blocks-settings.php:922`, labels "Block Settings Visibility", "Minimum User Role ..." in `dist/plugin-kadence-control.js`.

### 4.4 Style Library, design tokens and site styles (new in 3.8 and 3.9)

Style Library (design tokens), since 3.8.0 `[code]`
- Admin page: Kadence > Style Library, slug `kadence-blocks-style-library`, capability `edit_theme_options` (filter `kadence_blocks_style_library_capability`) `[code]` `kadence-blocks/includes/resources/Design_Tokens/Admin/Style_Library/Menu.php:21, 30, 245-253, 281`.
- Storage: custom tables `{prefix}kb_design_tokens` and `{prefix}kb_design_tokens_history`; option `kadence_blocks_design_tokens_active_library` `[code]` `Design_Tokens/Database/Token_Table.php:32`, `Token_History_Table.php:36`, `Active_Token_Library_Store.php:29`. History limit filter `kadence_blocks_design_tokens_history_limit`.
- Tokens follow the DTCG format (`Design_Tokens/Schema/dtcg.schema.json`) `[code]`. Palette tokens claim the 15 Kadence slots: `primitive.color.brand.primary` = palette1, `brand.secondary` = palette2, `neutral.900/700/600/500/100/50/0` = palette3-9, `extended.complement/success/info/alert/warning/rating` = palette10-15 `[code]` `Design_Tokens/Registry/declarations.php:202-216`.
- Projection: tokens become CSS variables (`--kb-token--...`, `--global-kb-spacing-*`, `--global-kb-gap-*`, `--global-kb-font-size-*`), preset classes (`kb-preset--<slug>`), `[data-kb-palette="<id>"]` palette scopes, and block default CSS `[code]` `Design_Tokens/Projection/*`, `Projection/Preset/Style.php:49-57`.
- Tokens also sync into the old `kadence_blocks_colors` option `[code]` `Projection/Kadence_Option/Projector.php:39`.

#### Palette ownership between the Kadence theme and the Style Library (Blocks 3.9.1)

Where things are stored
- The theme palette stays in the theme option `kadence_global_palette`. It holds three sets, `palette`, `second-palette` and `third-palette`, plus an `active` pointer naming the set the site renders (fallback `palette`) `[code]` `Design_Tokens/Theme_Style_Guide/Style_Guide_Mapper.php:12, 28-37, 246-248`, `Style_Guide_Reader.php:30, 116-117`.
- The second set is what a dark mode reads: the source notes that "Kadence Pro's dark mode asks for second-palette while the site renders palette" `[code]` `Projection/Kadence_Option/Palette_Filter.php:25-27`. How Theme Kit Pro wires dark mode is outside this file (see the Theme Kit Pro study) `[unverified]` here.
- Style Library values live in the custom tables `{prefix}kb_design_tokens` and `{prefix}kb_design_tokens_history`, with the active library in option `kadence_blocks_design_tokens_active_library` `[code]` (paths above).
- Option `kadence_blocks_design_tokens_palette_sync` is only a short "plugin version : library slug : effective version" marker that lets the sync skip work when nothing changed. It holds no colours `[code]` `Projection/Kadence_Option/Projector.php:42-49, 178, 203`.

What "import" really means in 3.9.1
- Nothing is copied from the Customizer into the token tables. On a Kadence theme site the Style Library reads the theme's active palette set live (a per-request "Style Guide overlay") and uses it as the baseline value of the 15 palette tokens `[code]` `Theme_Style_Guide/Style_Guide_Reader.php:10-19`, `Theme_Style_Guide/Provider.php` (overlay flushed on `add_option_`/`update_option_`/`delete_option_kadence_global_palette` and `customize_preview_init`).
- So with no Style Library edits, a Customizer palette change still flows through to blocks and the theme on the next page load `[code]` same, and `Kadence_Option/Provider.php` (memo cleared on the same hooks).

Which value wins on the front end
- The theme renders `--global-palette1..15` through its `palette_option()` accessor, which ends in the `kadence_palette_option` filter. Blocks hooks that filter and returns the resolved token colour for each claimed slot `[code]` `Kadence_Option/Provider.php:44`, `Palette_Filter.php:15-23, 136-152`.
- Result: a colour set in the Style Library overrides the Customizer colour for that slot. A slot never set in the Style Library resolves to the Customizer value (baseline). Resetting a token in the Style Library gives the Customizer colour back, because `kadence_global_palette` is never written `[code]` `Palette_Filter.php:17-23`, `Projector.php:19-21`.
- Reads for a non-active set (for example `second-palette` used by dark mode) are detected by value and left alone, so dark-mode colours stay owned by the theme option. Known limit: if a slot has the same colour in both sets, the dark read also gets the token colour `[code]` `Palette_Filter.php:25-27, 170-195`.
- Since 3.9.1 a theme value built on CSS variables (the palette10 "complement" formula) is left alone unless the site set that colour in the Style Library `[code]` `Palette_Filter.php:136-140, 197-230`, `Style_Guide_Reader.php:54, 73-80`.
- The Customizer live preview does not pass through the filter: while editing a palette colour in the Customizer, a slot overridden in the Style Library shows the Customizer colour until the next full page load `[code]` `Palette_Filter.php:32-35`.
- The whole layer is fail-closed/fail-open guarded: if the token registry is inactive or the stored document is corrupt, the theme value is returned untouched `[code]` `Palette_Filter.php:37-38, 145-147`.

Theme buttons
- The Style Library offers the theme's Customizer button styles (base and secondary) as class-painted presets; they read the Customizer settings for display only and follow every Customizer change `[code]` `Design_Tokens/Theme_Buttons/Kadence_Button_Styles.php:13-16`, flushed on `customize_save_after` and theme-mod option hooks `Theme_Buttons/Provider.php:57-66`.
- Button colour tokens claim the theme's button slots `palette-btn-bg`, `palette-btn`, `palette-btn-bg-hover`, `palette-btn-hover`, and radius drives `--kb-btn-radius` `[code]` `Registry/declarations.php:612-635`. A value set there therefore overrides the Customizer button colour in the same way as palette slots. A reported issue of theme button colours "reverting" is consistent with two places editing the same slot, but this study did not reproduce it `[unverified]`; test by setting a button colour in the Customizer, then in the Style Library, then resetting the token.

Who owns the palette, and what a builder should edit
- Owner: the theme option `kadence_global_palette` remains the stored source (all three sets and the active pointer). The Style Library is an override layer on top of the active set only `[code]` (above).
- Admin locations: theme palette in Appearance > Customize > Colors (Global Palette) `[unverified]` exact panel name, see the Theme study; Style Library in Kadence > Style Library (`admin.php?page=kadence-blocks-style-library`, needs `edit_theme_options`) `[code]` `Admin/Style_Library/Menu.php:21, 30, 245-253, 281`.
- Builder rule: edit palette colours in one place. If a site uses a dark/second palette, keep palette edits in the Customizer and leave the Style Library palette tokens unset, so both sets stay in the theme option and the light and dark values cannot drift. Use the Style Library only for tokens the theme does not own (presets, spacing and font-size scales). Before any palette change, check whether the Style Library has stored values for palette or button tokens (Kadence > Style Library, or rows in `{prefix}kb_design_tokens`), and reset them if the Customizer should own the colour.
- REST namespace for tokens is under the Design_Tokens Rest controllers; capability filter `kadence_blocks_design_tokens_capability` `[code]` `Design_Tokens/Rest/V1/Contracts/Controller.php:91`.
- Render: each block adds `data-kb-palette` and preset classes to its root (`wp-block-kadence-<name>`) at render time `[code]` `class-kadence-blocks-abstract-block.php:406-470`.

Site Styles (Global Styles for Kadence blocks), since 3.9.0 `[code]`
- Only when the Kadence theme runs its Full Site Editing mode (`kadence_blocks_is_fse_mode()`, filter `kadence_blocks_is_fse_mode`) `[code]` `kadence-blocks/includes/helper-functions.php:31-42`.
- Adds core supports/selectors to 18 blocks so they appear in Site Editor > Styles > Blocks: advancedbtn, singlebtn, icon, single-icon, spacer, show-more, column, rowlayout, countup, infobox, countdown, table, posts, progress-bar, testimonials, testimonial, tableofcontents, advancedheading `[code]` `resources/Site_Styles/Site_Styles_Provider.php:40-62`, `Block_Supports.php`.
- Values come from `settings.custom.kadence.<slug>` in the user Global Styles post and are merged into each instance before render; an instance's own value wins per leaf `[code]` `Site_Styles/Store.php`, `Overlay.php:11-22`.
- On a classic (non-FSE) Kadence theme setup this layer is off.

### 4.5 Block Defaults, editor controls and settings options

Editor: "Kadence Blocks Controls" sidebar (the Kadence icon in the editor top bar) `[code]` `dist/plugin-kadence-control.js` strings. Sections: Block Visibility (disable blocks), Block Settings Visibility (per role), Block Defaults (per block), Color Palette, Font Family Options, Editor Width, Design Library / Starter Packs / Kadence Library access by role, Pexels image picker, Performance Optimizer, Import/Export of defaults and visibility, "Set Advanced Text as default block", Custom CSS indicator.

| Option key | Holds | Source |
|---|---|---|
| `kadence_blocks_config_blocks` | Block Defaults (JSON string, per block name). Applied in the editor when a block is inserted, so defaults are copied into the post content | `[code]` `settings/class-kadence-blocks-settings.php:911`, passed to the editor as `configuration` in `class-kadence-blocks-editor-assets.php:345` |
| `kt_blocks_config_blocks` | Older defaults store, still passed as `config` | `[code]` `editor-assets.php:344` |
| `kadence_blocks_settings_blocks` | Block Settings Visibility by role | `[code]` settings `:922`, editor-assets `:346` |
| `kadence_blocks_settings` | General editor settings JSON (`performance_optimizer_enabled`, `enable_image_picker`, editor width keys ...) | `[code]` settings `:933`, `resources/Optimizer/State.php:12-21`, `class-kadence-blocks-image-picker.php:67-75` |
| `kadence_blocks_colors` | Kadence Blocks extra colour palette | `[code]` settings `:955` |
| `kadence_blocks_global` | Global settings | `[code]` settings `:966` |
| `kt_blocks_unregistered_blocks` | Blocks disabled in "Block Visibility" (unregistered in the editor by a script) | `[code]` settings `:672-690, 1700-1718` |
| `kt_blocks_editor_width` | Editor width settings | `[code]` settings `:228` |
| `kadence_blocks_font_settings` | `load_fonts_local`; this setting only appears when the Kadence theme is not active | `[code]` settings `:1171-1173` |
| `kadence_blocks_prophecy` | Kadence AI data | `[code]` settings `:944` |
| `kadence_blocks_cloud` | Cloud library connections | `[code]` settings `:1076` |
| `kadence_blocks_recaptcha_*`, `kadence_blocks_turnstile_*`, `kadence_blocks_hcaptcha_*`, `kadence_blocks_google_maps_api`, `kadence_blocks_mailerlite_api` | API keys | `[code]` settings `:977-1065` |
| `kadenceblocks_data_settings` | Internal debug data (db version, version history) for Site Health. Not an editor setting | `[code]` `settings/class-kadence-blocks-site-health.php:81, 135` |
| `kadence_blocks_design_tokens_active_library` | Active Style Library | `[code]` (4.4) |

Admin pages: Kadence > Home (`kadence-blocks-home`), Kadence > Settings (`kadence-blocks`), Style Library; Forms, Headers, Navigation post types also sit under the Kadence menu (`show_in_menu => kadence-blocks`). Capability filter `kadence_blocks_admin_settings_capability` `[code]` `settings/class-kadence-blocks-settings.php:717-736`, CPT files above.

Design Library and AI
- Design Library button in the editor (patterns, pages, wireframes, cloud libraries) `[code]` filters `kadence_blocks_design_library_enabled`, `kadence_blocks_cloud_enabled`, `kadence_blocks_wireframe_library_enabled`, `kadence_blocks_custom_prebuilt_libraries` in `class-kadence-blocks-editor-assets.php:377-385`.
- Kadence AI can be switched off with the `KADENCE_BLOCKS_AI_DISABLED` constant or the `kadence_blocks_ai_disabled` filter `[code]` `helper-functions.php:445-458`.
- Runtime shows 11 registered patterns, 0 from Kadence `[runtime]` (`PATTERNS 11 kadence=0`): the library is remote and inserts content on demand.

Performance Optimizer (free)
- Off by default. Turned on in Kadence Blocks Controls (`performance_optimizer_enabled`). It analyses a page in the browser, stores results in `{prefix}kb_optimizer` and `{prefix}kb_optimizer_viewport_hashes`, then on later requests sets lazy loading, `content-visibility` for below-the-fold sections, image `sizes` and resource hints `[code]` `resources/Optimizer/README.md`, `State.php`, `Database/Optimizer_Table.php:18`. Per-post exclude and bulk actions in the post list (`kb_optimize_posts`, `kb_optimize_remove`) `[code]`. If a page cache plugin also does lazy loading and critical CSS, test both together before enabling `[unverified]`.

### 4.6 How CSS is generated and loaded

- Per-block CSS is built in PHP from attributes by each block class `build_css()`, using `Kadence_Blocks_CSS` `[code]` `class-kadence-blocks-abstract-block.php:302-345`.
- Head output: on `wp_enqueue_scripts`, the plugin parses the current post's blocks and builds their CSS early; it is printed as inline style handle `kadence_blocks_css` (and `kadence_blocks_custom_css` for Custom CSS boxes) `[code]` `class-kadence-blocks-frontend.php:81, 424-447`, `class-kadence-blocks-css.php:293-320`.
- Blocks rendered outside the main post content (templates, theme Elements, widgets, reusable blocks rendered later) get a `<style>` tag printed just before the block, or in the footer for some blocks (`kadence_blocks_render_styles_footer`) `[code]` `abstract-block.php:330-366`.
- Block stylesheets (`kadence-blocks-<name>`) and scripts are only enqueued when the block is used `[code]` `abstract-block.php:278-295`.
- Global variables (`--global-kb-font-size-*`, `--global-kb-spacing-*`, `--global-kb-gutter-*`, `--global-row-edge-*`, content width for rows and headers) are printed as inline style `kadence-blocks-global-variables` on the front end and `kadence-blocks-global-editor-styles` in the editor `[code]` `kadence-blocks/includes/init.php:103-200, 260-262`.
- Useful filters: `kadence_blocks_<slug>_render_block_attributes` (change attributes before CSS/markup), `kadence_blocks_render_inline_css`, `kadence_blocks_render_head_css`, `kadence_blocks_force_render_inline_css_in_content`, `kadence_blocks_build_render_unique_id`, `kadence_blocks_block_default_attributes` `[code]` `abstract-block.php:264-325, 659`.
- Targeting a block from your own CSS: use the block's unique class (table below) or add an Additional CSS class in the block's Advanced panel. A custom class is portable; the unique id class changes if the block is duplicated `[unverified]` for duplication behaviour, check by duplicating a block and comparing `uniqueID`.

| Block | Generated class/selector |
|---|---|
| Row Layout | `.kb-row-layout-id<id>` (old: `#kt-layout-id<id>`) |
| Section | `.kadence-column<id>` and `.kt-inside-inner-col` |
| Advanced Text | `.kt-adv-heading<id>` |
| Buttons | `.kt-btns<id>`, `.kb-btn<id>` |
| Single Icon | `.kt-svg-item-<id>` |
| Icon List | `.kt-svg-icon-list-items<id>` |
| Info Box | `.kt-info-box<id>` |
| Tabs | `.kt-tabs-id<id>` |
| Accordion | `.kt-accordion-id<id>` |
| Gallery | `.kb-gallery-id-<id>` |
| Image | `.kb-image<id>` |
| Spacer | `.kt-block-spacer-<id>` |
| Testimonials | `.kt-blocks-testimonials-wrap<id>` |
| Countdown | `.kb-countdown-container-<id>` |
| Count Up | `.kb-count-up-<id>` |
| Progress Bar | `.kb-progress-bar-container<id>` |
| Show More | `.kb-block-show-more-container<id>` |
| Table | `.kb-table-container<id>` |
| Table of Contents | `.kb-table-of-content-id<id>` |
| Posts | `.kb-posts-id-<id>` |
| Lottie | `.kb-lottie-container<id>` |
| Search | `.kb-search<id>` |
| Site identity | `.kb-identity<id>` |
| Google Maps | `.kb-google-maps-container<id>` |
| Video Popup | `.kadence-video-popup<id>` |
| Navigation | `.wp-block-kadence-navigation<id>` |
| Header | `.wp-block-kadence-header<id>` |
| Advanced Form | `.wp-block-kadence-advanced-form<id>` |
| Vector | `.kb-vector-container<id>` |

All `[code]`, from the `set_selector()` calls in each `includes/blocks/class-kadence-blocks-*-block.php` (line numbers in section 3).

### 4.7 When custom code is really needed (free 3.9.1)

- Hiding blocks other than row/section/countdown/spacer per device, or showing by condition: Pro conditional display, or a wrapping Section with hide flags.
- Scroll animations: Pro.
- Dynamic data in blocks (post fields, ACF, repeaters): Pro.
- Query loops with filters and pagination: Pro, or core Query Loop.
- Form submissions saved to the database, webhooks, autoresponders: Pro.
- More than 6 columns in one row, or CSS grid areas beyond Section `gridArea`: nest rows or use Custom CSS on a Row/Section.
- Styling states Kadence does not expose (for example `:focus-visible` on some controls): small CSS targeted at the block's custom class.

## 5. Gaps and how to check them

- Row Layout sticky: confirmed absent in block.json; Kadence docs may describe sticky through Section only. `[code]`
- Mega menu, form field conditional logic and progress bar shape names: check in the editor with Pro deactivated on a local copy (never on a shared site without approval).
- Header container block name mismatch (JS vs block.json): inspect a saved `kadence_header` post's content.
- Kadence theme dark palette and Style Library palette interplay: see the Theme study and test in the Customizer and on the front end, since the Customizer preview bypasses the token filter.
- Exact UI location of each setting was taken from block.json and editor strings, not from screenshots. Confirm panel names in the editor when writing editor instructions.
