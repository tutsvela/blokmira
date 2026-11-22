# Kadence limitations, compatibility, security practices and open checks

Purpose: one consolidated list of native limits, compatibility notes, security practices, version gaps, doc-versus-code conflicts and every `[unverified]` item, with how to check each one in the admin.

Versions studied: Kadence Theme 1.6.0, Theme Kit Pro 1.2.6, Kadence Blocks 3.9.1, Kadence Blocks Pro 2.8.16, Creative Kit 1.1.4.

Contents
1. How to use this file
2. Native limitations by product
3. Compatibility notes (cross-product)
4. Security practices
5. Version gaps (installed vs latest)
6. Conflicts between docs and code
7. Open `[unverified]` items and how to check them
8. Items resolved across files

Ref codes as in `recipes.md` section 1 (TH, GD, TKP, BI, BP, DC, CK, RA, RR). Tags: `[code]`, `[runtime]`, `[docs]`, `[unverified]`. Paths are relative to each product folder.

---

## 1. How to use this file

Before writing custom code, find the requirement in `recipes.md`, then confirm the limit here. If the limit is listed with `[code]`, it is a proven native gap and custom code is justified (record it as `decision-framework.md` asks). If it is `[unverified]`, run the check in section 7 first.

## 2. Native limitations by product

### 2.1 Kadence Theme 1.6.0
- Author box, tags and related posts are hard-wired to post type `post`; CPTs need an Element or Query Loop (TH 4.2) `[code]`.
- Post navigation shows only for `post` or types with `has_archive` (TH 4.2) `[code]`.
- `left_center` / `right_center` header zones print only when `center` has items (TH 2.1) `[code]`.
- A CPT whose `transparent_header_{post_type}` was never saved is treated as disabled (TH 2.5) `[code]`.
- No native dark mode and no `prefers-color-scheme` rules (GD 8) `[code]`.
- No form input controls; inputs use static CSS on palette slots (GD 5) `[code]`.
- No global shadow or radius scale (GD 6) `[code]`.
- `--global-h1-font-family` .. `--global-button-font-family` are commented out (GD 3) `[code]`.
- theme.json is not read unless `theme_json_mode` or FSE mode is on; core spacing presets then missing (TH 1.4) `[code]`.
- The theme alone has no upload UI for custom fonts; it offers only filters (GD 3) `[code]`. The separate Kadence Custom Fonts plugin (with Theme Kit Pro or a plan) adds uploads and Adobe Typekit, stored as post type `kt_font` `[docs]` (`official-docs.md` §4).
- Static CSS uses 719/720 px while generated CSS uses 767/768 px (RA 1) `[code]`.
- No reduced-motion handling for smooth scroll, header reveal/shrink, dropdown and off-canvas transitions (RA 12) `[code]`.
- Custom PHP on header row hooks needs separate desktop and mobile hooks and shows in the Customizer only after a full refresh (TH 7) `[code]`.
- FSE mode is Alpha, needs WordPress 7.1+, and moves palette, widths, fonts and buttons to the Site Editor (TH 1.5) `[code]`.

### 2.2 Theme Kit Pro 1.2.6
- Theme: the header search modal (`Kadence\search_modal`, `wp_footer` priority 20) prints only `get_search_form()` with no action inside; the off-canvas drawer header has no hook (only `kadence_before_mobile_navigation_popup` / `kadence_after_mobile_navigation_popup` inside the content). Header Builder items can be placed once, so the logo cannot also go in the popup (Theme 1.6.0) `[code]`.
- All modules are off by default; a module that is off is not loaded at all (TKP 2) `[code]`.
- Elements: no start date, only expiry (TKP 4.8) `[code]`.
- Elements: no custom field display condition; use `kadence_element_display` (TKP 4.7, 9) `[code]`.
- Elements: device rules are CSS only and switch at 719/720 px (TKP 4.8, RA 4) `[code]`.
- Elements: one single/archive replacement and one loop replacement per request (lowest Order wins); Replace Header and Replace Footer have no such guard, so two can print (TKP 4.5) `[code]`.
- Elements: publishing with no Show On rule shows nothing (TKP 4.13) `[code]`.
- Elements: "Replace Post Meta" is commented out (TKP 4.5) `[code]`.
- Elements: max 533 elements queried per request (TKP 4.12) `[code]`.
- Elements: WooCommerce "Before/After Single Product Image" placements do not enqueue Kadence block styles (TKP 4.11) `[code]`.
- Elements: HTML Editor elements skip Kadence block CSS and are not visually editable (TKP 4.13) `[code]`.
- Elements: there is no "hide from role" list (Conditional Headers have one) (TKP 4.8) `[code]`.
- No Conditional Footers (TKP 5) `[code]`.
- Infinite Scroll and Archive Custom Settings affect only the theme's own archive loop (TKP 3.7, 3.10) `[code]`.
- Header Addons items must be dragged into a row; HTML 2 is a text field, not blocks (TKP 3.1) `[code]`.
- Dark mode: hex colours never switch; with page cache, a visitor can see a brief flash of the wrong palette (TKP 6) `[code]`.
- Ultimate Menu applies only to menus printed with `mega_support` (TKP 7) `[code]`.
- Header/Footer Scripts print for everyone, with no consent check, and are not versioned (TKP 3.4) `[code]`.
- No reduced-motion handling anywhere in Theme Kit Pro (RA 12) `[code]`.

### 2.3 Kadence Blocks 3.9.1 (free)
- Row Layout: max 6 columns, no sticky, no entrance animation (BI 3.1) `[code]`.
- Hide on device only on Row Layout, Section, Spacer, Countdown, and only with CSS (BI 4.3) `[code]`.
- Section sticky has no device toggle and sets `#wrapper.site { overflow: clip }` (RA 7) `[code]`.
- Collapse order "Reverse" works only on stacked layouts (RA 3) `[code]`.
- Posts block: no pagination, filters, carousel or custom card (BI 3.14) `[code]`.
- Custom CSS box only on Row, Section, Header Row (BI 4.2) `[code]`.
- Block Defaults apply at insert time only (BI 4.5) `[code]`.
- No hover transforms on any block (RA 10) `[code]`.
- Parallax (jarallax), video backgrounds, Lottie and progress bars have no reduced-motion handling (RA 12) `[code]`.
- Fixed and parallax backgrounds fall back to scroll on tablets unless `kadence_blocks_attachment_fixed_on_mobile` returns true (RA 6) `[code]`.
- Lottie default `fileUrl` is an external lottiefiles.com URL (RA 9) `[code]`.
- Off canvas exists only inside Header (Adv); no general off-canvas block (BI 3.31) `[code]`.
- No before/after image comparison, timeline or pricing table block (BI 2.2) `[code]`.
- Site Styles (Global Styles for Kadence blocks) only work in the theme's FSE mode (BI 4.4) `[code]`.
- Row Layout and Section print their wrapper markup only when `kbVersion` is 2 or more (`class-kadence-blocks-row-layout-block.php` `build_html`; column block `$is_version_two`). The editor sets it on insert; blocks made with `wp.blocks.createBlock()` get an empty `kbVersion` and render without wrappers. Set `kbVersion: 2` when generating markup (Blocks 3.9.1.1) `[code]` `[runtime]`.
- Section (`kadence/column`, kbVersion 2) prints `column-gap`/`row-gap` from `gutterVariable`/`rowGapVariable` (presets such as `sm`). The pixel `gutter`/`rowGap` values are used only when the matching variable is `'custom'` (class-kadence-blocks-column-block.php, `render_row_gap`). A Section built with `createBlock` and pixel values alone gets the 16px `sm` column gap and no row gap. Set `gutterVariable: ['custom','custom','custom']` and `rowGapVariable` the same whenever you author pixel gaps (3.9.1.2) `[code][runtime]`.
- Section direction set explicitly to `vertical` on mobile outputs a high-specificity rule that centres children with a max width (`margin-left/right: auto`), which block margins cannot beat; the tablet `vertical` rule does not. Leave the mobile direction empty so phones inherit the tablet stack (3.9.1.1) `[runtime]`.
- Section `verticalAlignment` has one value for all devices; `bottom` becomes `align-items: flex-end` when the row stacks, pushing children to the right. For header rows (heading + button) keep the phone direction horizontal with wrap and a 100 % phone flex basis instead (3.9.1.1) `[runtime]`.
- Advanced Buttons store margins as `margin[0].desk/tablet/mobile`; there is no `mobileMargin` attribute (3.9.1.1) `[code]`.
- Icon List: `listGap` is a single number (`tabletListGap`, `mobileListGap` are separate); an array value outputs no gap. A list item's `showIcon: false` inserts the list icon instead of hiding it; for a list with no icon set the list `icon` to an empty string. `listLabelGap: 0` is never output (`! empty()`), and an empty icon wrapper keeps the 10px default margin (3.9.1.1) `[code]` `[runtime]`.
- Style Library token values accept CSS variables such as `var(--global-palette9)`, but tokens are declared on `:root`, so the variable resolves there. A dark palette declared on `body` (Theme Kit Pro Color Switch) is never picked up: keep preset tokens to shape (radius, border width, padding, shadow) and set colours as palette slots on each block. The theme presets ("Theme Base", "Theme Secondary") mirror the Customizer buttons as fixed light-palette values, and `kbPreset: ''` falls back to the Default preset. `PUT presets/kadence/singlebtn` replaces the whole preset map (send every user preset), and new keys become user presets (`userCreated`) (3.9.1.1) `[runtime]`.
- Advanced Text (`kadence/advancedheading`) `lineHeight` with `lineType: ''` is output in px; use `lineType: 'em'` for a unitless ratio (3.9.1.1) `[runtime]`.

### 2.4 Kadence Blocks Pro 2.8.16
- Dynamic content: Before/After print even when the value is empty (DC 7) `[code]`.
- Only the first post of a relationship field is used (DC 8.6) `[code]`.
- Archive ACF fields read the queried term, not a term in a loop (DC 13) `[code]`.
- Flexible content and nested repeaters are not supported (DC 13) `[code]`.
- Conditions cannot use relationship sources (DC 9) `[code]`.
- No per-block date format; Time group uses server timezone (DC 4) `[code]`.
- Dynamic Advanced Image prints no `srcset` (DC 11) `[code]`.
- Core blocks have no Kadence block-level dynamic support (DC 5) `[code]`.
- Advanced Button wrapper has no dynamic support; use each Single Button (DC 5) `[runtime]`.
- Without Pro active, inline dynamic spans keep their saved preview text (DC 13) `[code]`.
- Animate on Scroll: no per-device choice, no child stagger (except Split Content parts), no scroll-scrubbed motion; global `once` default is false (RA 8) `[code]`.
- Animate on Scroll hides animated content (`opacity:0`) until its script runs, with no no-JS fallback. Delayed or failed JavaScript leaves it invisible. Never animate above-the-fold content; exclude the AOS script from JS delay (RA 8) `[code]`.
- Splide AutoScroll has no own reduced-motion check (RA 12) `[code]`.
- Post Grid / Portfolio Grid: fixed card anatomy, no ACF in cards (BP 3.2) `[code]`.
- User Info shows the logged-in user, not the post author (BP 3.2) `[code]`.

### 2.5 Creative Kit 1.1.4
- Only front-end feature with Blocks Pro active: Marquee (Adv) (CK 1) `[code]`.
- Marquee: no reduced-motion check, no off-screen pause, no resize re-measure, clones stay in the tab order, orientation/direction/speed not responsive, no per-device disable (CK 3) `[code]`.
- Marquee adds GSAP core (about 70 KB) and multiplies DOM nodes (CK 3) `[code]`.
- AOS fallback only runs without Blocks Pro, has no reduced-motion check and does not scan Elements (CK 5) `[code]`.
- Page Wizard is beta only and not registered (CK 6) `[code]`.
- No sliders, scroll effects, hover tilt, custom cursor or text animation (CK 2) `[code]`.

## 3. Compatibility notes (cross-product)

- **Breakpoints**: generated CSS in all products uses 1024/767 px through the same filters; static theme CSS and Element device rules use 719/720 px. Test 720 to 767 px (RA 1, 4) `[code]`.
- **Theme header switch** `header_mobile_switch` (default 1024) is separate from block breakpoints; Header (Adv) has its own `mobileBreakpoint` (RA 1, BI 3.19) `[code]`.
- **Translucent palette colours in the Customizer**: Theme `render_color()` turns any value that contains "palette" into `var(--global-<value>)`, so `color-mix(… var(--global-palette1) …)` typed into a Customizer colour (for example a button shadow) breaks. A plain custom property such as `var(--my-shadow)` passes through unchanged; define it from the palette in child-theme CSS `[code]` Theme 1.6.0 `inc/class-kadence-css.php:686-694`, `[runtime]`.
- **Vector SVG fills**: a `kadence_vector` saved through REST keeps `style="fill:var(--global-paletteN)"` on paths, and the front end renders those fills, so a two-tone SVG can follow the palette and the dark palette `[runtime]` Blocks 3.9.1.
- **Palette**: Style Library tokens override theme slots on the front end but not in Customizer live preview; dark mode reads `second-palette` and is left alone unless a slot has the same colour in both sets (BI 4.4) `[code]`.
- **Blocks 3.9.1 with Pro 2.8.16**: newer free Blocks with an older Pro. No official compatibility statement found `[docs]` (RR 3). Check for PHP notices and missing controls (section 7).
- **Creative Kit AOS** switches itself off when Blocks Pro is active; the Pro AOS is used (CK 5) `[code]`.
- **Conditional Headers** button is hidden when "Enable Block Header" is on (TKP 5) `[code]`.
- **Element replacements** stop Infinite Scroll and Archive Custom Settings from applying (TKP 3.7, 3.10, 9 #13) `[code]`.
- **Page cache**: Element role/login rules, Row login rules and Conditional Display user rules need a cache that varies by login; Element expiry needs a purge (TKP 4.12) `[code]`; cache behaviour itself `[unverified]`.
- **Dark mode and page cache**: body class from the cookie can be wrong in cached HTML until the script corrects it (TKP 6) `[code]`.
- **Performance Optimizer** (Blocks) and a cache plugin's own lazy load or critical CSS may overlap `[unverified]` (BI 4.5).
- **FSE mode**: classic Header/Footer Builders, Elements placements and theme hooks are classic-mode features (TH 1.5) `[code]`.
- **WooCommerce-only** features (Product Carousel, WooCommerce Addons, Woo Element placements) do not load without WooCommerce (BP 3.1, TKP 3.6) `[code]`.

## 4. Security practices

This public edition gives general safety rules only. Report suspected vulnerabilities in Kadence products to the vendor (Nexcess) privately, not in issues or skill files.

- **Hiding is not access control.** Element device rules and block hide-on-device are CSS only; the HTML is still sent. Never use them for private content; use Conditional Display, Element user rules or real access control.
- **Scripts print everywhere they match.** Header/Footer Scripts, HTML Editor Elements and per-post Page Scripts print for every matching visitor with no consent check. Put tracking behind the site's consent tool, and keep project CSS and JS in versioned theme or plugin files.
- **Editors can inject code.** Per-post CSS/JS, HTML Elements and dynamic text output are editor-level powers. Keep editor and author roles tight, and review content from untrusted users.
- **REST and meta writes.** Kadence registers post and Element settings as REST-visible meta; WordPress still checks the user's edit rights on the post. Do not widen capabilities or open extra REST routes in custom code.
- **Dynamic Content option reads.** Keep the built-in guard that blocks sensitive options; never widen it.
- **API keys** for captcha, maps and mail services are stored as options. Never print or commit them, and do not expose them through custom REST routes.
- **Maintenance Mode "Entire Site"** takes the site offline (503) for everyone except the "User Exceptions" roles. Read the sidebar before publishing.
- **Third-party embeds** (Google Maps, YouTube or Vimeo popups) load external content. Test them with the consent tool.
- **Stay updated.** Kadence ships security fixes regularly (see the official changelogs). Re-run the inventory after updates.

## 5. Version gaps (installed vs latest)

From official changelogs, 17 Nov 2026 `[docs]` (RR 3).

| Product | Installed | Latest seen | What the gap contains |
|---|---|---|---|
| Kadence Blocks | 3.9.1 | 3.9.1.1 | Security only: Advanced Form default field values, Design Library imported content |
| Kadence Blocks Pro | 2.8.16 | 2.9.1 | 2.8.17 slider editor fix; 2.8.18 Query Loop Limit by Taxonomy for non-public taxonomies and accessible pagination names and landmark; 2.8.19 to 2.8.20.1 output escaping; 2.8.20 array URL parameter fatal fix and licence popup; 2.9.0 FSE support and stricter SVG sanitising; 2.9.1 synced pattern fatal and infinite scroll on WP 7.1 |
| Theme Kit Pro | 1.2.6 | 1.3.0 | 1.2.7 HTML Element code editor in the WP 7.1 iframed editor; 1.3.0 dark mode in FSE mode, WP 6.6 minimum |
| Kadence Theme | 1.6.0 | 1.6.0 | Current |
| Creative Kit | 1.1.4 | 1.1.4 | Current |

Notes: Blocks 3.9.x shipped with Pro 2.9.x; the installed pair is older Pro on newer free Blocks. Accessible Query Loop pagination names are missing in 2.8.16 by the changelog `[docs]`.

## 6. Conflicts between docs and code

| # | Topic | Official docs say | Installed code shows | Verdict |
|---|---|---|---|---|
| 1 | Style Library palette | Customizer palette is imported into the Style Library on update, then edited there (RR 2, source #11) | Nothing is copied; the Style Library reads the theme option live and overrides slots at read time; the theme option stays the stored source (BI 4.4) `[code]` | Follow code |
| 2 | Dark palette location | Define palettes in Customizer > General > Colors (RR 3, source #28) | Dark mode reads `second-palette` from the theme option; Style Library leaves non-active sets alone (BI 4.4, TKP 6) `[code]` | Follow code |
| 3 | Conditional Display blocks | Includes Accordion panes, Tabs, Testimonials (RR 2) | Runtime `ktdynamic` list has `testimonial` (child), not accordion, pane, tabs or tab (BP 5.2) `[runtime]` | Check in editor (section 7) |
| 4 | Dynamic content on core blocks | Paragraph, Heading, Quote, Table, Button and others supported (RR 2) | Core blocks have no Kadence block-level dynamic support; inline format may still apply (DC 5) `[code]` | Check in editor |
| 5 | Dynamic Advanced Button | Listed as supported (RR 2) | Wrapper lacks `ktdynamic`; set on each Single Button (DC 5) `[runtime]` | Follow code |
| 6 | Creative Kit and AOS | Older snippet: Creative Kit unlocks AOS in free Blocks (RR 2) | Creative Kit AOS registers only when Blocks Pro is absent (CK 5) `[code]` | Both true; with Pro, Pro owns AOS |
| 7 | AOS site defaults | Defaults apply only to new blocks `[docs]` (RR 2) | Front end reads defaults from `kadence_blocks_config_blocks` key `kadence/aos` (RA 8) `[code]` | Unclear; test (section 7) |
| 8 | "Enable Block Header" location | Customizer Header > General (RR 2) | Control `blocks_header` in section Header Layout `kadence_customizer_header_layout` (TH 2) `[runtime]` | Label difference only |
| 9 | Theme hook `kadence_replace_header` | Listed in the official hook list (RR 2) | Not in the theme 1.6.0 hook list; Replace Header is the Element placement value `replace_header` (TH 6, TKP 4.5) `[code]` | Follow code |
| 10 | Element in-content placements | Documented as working (RR 2) | Insertion check reads as inverted (TKP 4.6) `[code]` | Test |
| 11 | Design Library palette mapping | Full docs text: one page says Light/Dark/Highlight = palette 9/3/1 (customize-design-library-color-palette, with a filter), another says 1/2/9 (access-the-design-library, kadence-ai-powered-design-library) | Not studied | Open; check the preview at runtime |
| 12 | Community hook name `Kadence_entry_header` | Capital K in a 2022 blog (RR 3) | Theme fires `kadence_entry_header` (TH 6.2) `[code]` | Typo in source |
| 13 | Block titles | Inserter shows JS titles | Several `block.json` titles are wrong (`kadence/userinfo` "Image Overlay", query children "No Results") (BI 2.1, BP 3.1) `[code]` | Cosmetic |
| 14 | Header container block names | n/a | JS registers `kadence/header-desktop-container`, block.json says `kadence/header-container-desktop` (BI 2.3) `[code]` | Check saved markup |
| 15 | Vector block name | "Vector Illustration" (2025 changelog) vs "Vector Graphic" (doc) (RR 3) | Block is `kadence/vector`, title "Vector SVG" (BI 2.2) `[runtime]` | Same block |
| 16 | FSE status | Older docs: Kadence has no FSE theme (RR 3) | Theme 1.6.0 has an Alpha FSE mode, off by default (TH 1.5) `[code]` | Docs outdated |
| 17 | ACF relationship snippet | Official snippet hardcodes a loop ID and sets empty `post__in` when the field is empty (returns all posts) (RR 3) | n/a | Guard empty values and look up by slug |

## 7. Open `[unverified]` items and how to check them

De-duplicated across all files. Run checks on a staging or local copy only, never on production.

### 7.1 Kadence Theme
| # | Item | How to check in the admin | Source |
|---|---|---|---|
| T1 | Each public CPT gets "{CPT} Layout" and "{CPT} Archive" sections | Customize > Posts/Pages Layout, look for the CPT sections | TH 4.6, 8 |
| T2 | Unsaved CPT transparent toggle is treated as disabled | Customize > Header > Transparent Header, save the CPT toggle off, view a CPT item | TH 2.5 |
| T3 | Spacing preset slider absent when `theme_json_mode` is off | Core Group block > spacing panel with Customize > General > Performance "Enable Optimized Group Block" off, then on | TH 1.4, 8 |
| T4 | `_kad_post_navigation` has no panel control | Open a post's Kadence settings panel | TH 5, 8 |
| T5 | UI for choosing the active palette set | Customize > Colors & Fonts > Colors, palette control | GD 11 |
| T6 | FSE mode behaviour on WordPress 7.1+ | Dashboard > Updates for WP version; Appearance > Kadence for the FSE toggle (do not turn on without approval) | TH 8, RR 5 |
| T7 | Theme hero backgrounds offer a gradient option | Customize > Posts/Pages Layout > a title background control | styling-layers 4 |

### 7.2 Theme Kit Pro
| # | Item | How to check | Source |
|---|---|---|---|
| K1 | Element in-content placements ("After First Paragraph" etc.) insert content | Draft Element at After First Paragraph for one test post; view source for `<!-- [element-ID] -->` | TKP 4.6, 11 |
| K2 | Fixed Section width choice list (`_kad_element_fixed_width`) | Element of type Fixed Section > Width options | TKP 4.4 |
| K3 | Maintenance Mode user rule meaning | Appearance > Maintenance Mode > edit a page, read sidebar labels before publishing | TKP 3.11 |
| K4 | Page cache varies by login for role and logged-in rules | Cache plugin settings, then test a role-limited Element logged out and logged in | TKP 4.12 |
| K5 | Element block CSS is cached with Kadence Blocks CSS file output | View page source for element styles with cache on | TKP 4.12 |
| K6 | Kadence block styles at WooCommerce product image placements | Only if WooCommerce is used | TKP 4.11 |
| K7 | WooCommerce Addons Customizer sections | Only if WooCommerce is active | TKP 11 |
| K8 | HTML Element code editor on WP 7.1 (fixed in 1.2.7) | Open an HTML Editor Element on the installed WP version | RR 5 |

### 7.3 Kadence Blocks
| # | Item | How to check | Source |
|---|---|---|---|
| B1 | Inserter titles differ from wrong `block.json` titles | Open the inserter, search "User Info", "Sort" | BI 2.1 |
| B2 | Saved header container block names | Kadence > Headers, open a header in the code editor | BI 2.3, 5 |
| B3 | Progress Bar shape names (circle, semicircle) | Progress Bar sidebar, bar type options | BI 3.23 |
| B4 | Video Popup `youtubeCookies` off switches to the no-cookie domain | Toggle it off, view the front-end link URL | BI 3.27 |
| B5 | Site Identity uses Advanced Image inside | Insert Site Identity, check List View | BI 3.30 |
| B6 | `uniqueID` class changes when a block is duplicated | Duplicate a block, compare `uniqueID` in the code editor | BI 4.6 |
| B7 | Performance Optimizer conflicts with cache plugin lazy load or critical CSS | Enable on one page with the cache plugin on, compare output | BI 4.5 |
| B8 | Google Maps embed and consent tool | Load a page with the map before and after consent | BI 3.22 |
| B9 | Exact inspector panel names (taken from block.json and editor strings) | Open each block in the editor when writing editor instructions | BI 5 |
| B10 | Style Library button tokens and Customizer button colours "reverting" | Set a button colour in the Customizer, then in the Style Library, then reset the token | BI 4.4, RR 5 |
| B11 | Brand SVGs accepted by the 3.8.0 sanitiser | Upload one brand SVG to Vector SVG and Custom SVG | RR 5 |
| B12 | A general absolute-position control on any block | Check Advanced panels of Row, Section, Image | styling-layers 3.9 |

### 7.4 Kadence Blocks Pro
| # | Item | How to check | Source |
|---|---|---|---|
| P1 | Animate on Scroll panel placement and Defaults modal location | Select a Section, Advanced tab; Kadence Blocks Controls for defaults | BP 5.3, 9 |
| P2 | AOS site defaults apply to existing blocks or only new ones | Change "Animate On Scroll Defaults", reload a page with an animated block that has no own values | RA 8, RR 2 |
| P3 | Conditional Display on Accordion panes and Tabs | Select a Pane or Tab, look for Advanced > Conditional Display | section 6 #3 |
| P4 | Dynamic content on core blocks (inline format) | Select a core Paragraph, look for "Insert Dynamic Content" in the rich text toolbar | section 6 #4 |
| P5 | Editor keeps a plain leading space in Before/After | Type one, save, check the code editor; use a no-break space regardless | DC 7 |
| P6 | ACF group sub field read as `<group>_<sub>` | Test one group field per project | DC 8.4 |
| P7 | Many related posts through Query Loop related or custom query | Query Loop settings with an ACF relationship field | DC 8.6 |
| P8 | Which post the Query Card editor previews | Open a Query Card in the editor | DC 10 |
| P9 | `srcset` / `loading` on dynamic Advanced Image inside Element hooks | Inspect front-end HTML | DC 11 |
| P10 | Worked examples' editor wording and placement | Click through each in the editor | DC 15 |
| P11 | Licence expiry affects updates only | Non-production test | BP 7, 9 |
| P12 | Slider, Post Grid and Portfolio Grid keyboard and pause behaviour | Keyboard test on the front end | BP 9 |
| P13 | Pro 2.8.16 with Blocks 3.9.1: PHP notices or missing controls | Debug log on a test site while editing Pro blocks | RR 5 |
| P14 | Query Loop array filter URL parameter fatal (fixed in 2.8.20) | Do not test on shared sites; treat as present until updated | RR 5 |
| P15 | Search results page with Query Loop `inherit` inside a Replace Archive Content Element | Build on a test page, run a search | recipes 13 |

### 7.5 Creative Kit
| # | Item | How to check | Source |
|---|---|---|---|
| C1 | Premium Design Library items depend on the Creative Kit licence | Open the Design Library modal and look for premium items | CK 2 |
| C2 | Marquee Item `textColor`, `linkColor`, `linkHoverColor` have no visible control | Marquee Item sidebar | CK 4 |

### 7.6 Research questions still open
| # | Item | How to check | Source |
|---|---|---|---|
| R1 | Design Library palette mapping (Light, Dark, Highlight slots) | Insert a Design Library pattern and compare colours with the palette | RR 5 #11 |
| R2 | Header (Adv) mobile breakpoint vs design breakpoints | Header (Adv) `mobileBreakpoint` setting | RR 5 #14 |
| R3 | Whether to update to the latest Blocks, Pro and Theme Kit Pro | Owner decision | RR 5 #15 |

## 8. Items resolved across files

These were `[unverified]` in one file and confirmed in another. Use the confirmed version.

| Item | Was unverified in | Resolved by |
|---|---|---|
| Kadence Blocks palette storage format (`paletteN` > `var(--global-paletteN)`) | GD 2.4, 11 | BI 4.1 `[code]` |
| Kadence Blocks breakpoints follow theme filters | GD 4, 11 | RA 1 `[code]` |
| Kadence block palette colours follow a dark palette | BI 4.1 | TKP 6 (dark mode redefines `--global-paletteN`) `[code]` |
| How Theme Kit Pro dark mode reads the second set | BI 4.4 | TKP 6, GD 8 `[code]` |
| Customizer palette panel name | BI 4.4 | GD 1 (Colors & Fonts > Colors) `[runtime]` |
| Navigation (Adv) mega menu needs Pro | BI 3.18, 5 | BP 4 `[code]` |
| Form field conditional logic UI needs Pro | BI 3.2, 3.17, 4.2 | BP 4 `[code]` |
| How the classic theme uses a block header | BI 3.19 | TH 1.5 (`blocks_header`) `[code]` |
| Archive description as a dynamic source | TKP 9 #4 | DC 4 (`archive|archive_description`) `[code]` |
| Dynamic "current" source in Elements reads the rendered post | TKP 4.10 | DC 3 (`get_the_ID()` at render) `[code]`; still test once (TKP 11) |
| Elements display rules include custom field conditions | DC 9 | TKP 4.7 (full rule list, none for custom fields) `[code]` |
| Before/After and saved markup in Pro 2.8.16 | RR 5 #7 | DC 6, 7 `[code]` |
| Kadence post type names (queries, cards, headers, navigation) | RR 5 #9 | runtime capture, BI 4.5, BP 3.2 `[runtime]` |
| Creative Kit gating of AOS | RR 5 #12 | CK 5 `[code]` |
| Element placement hook names | RR 5 #10 | TKP 4.3 `[code]` |
