# Kadence research references

Web research done on 17 Nov 2026. No WordPress site was opened and no login was used. Everything here is from public pages. Treat it as a map to verify against the installed code, not as proof of how the installed versions behave.

Installed versions being compared: Kadence Theme 1.6.0, Theme Kit Pro 1.2.6, Kadence Blocks 3.9.1, Kadence Blocks Pro 2.8.16, Creative Kit 1.1.4.

Update 22 Nov 2026: all 386 current Kadence pages on docs.nexcess.com were read in full; the digest is `official-docs.md`. Latest releases listed by the Nexcess changelogs that day: Blocks 3.9.1.2, Blocks Pro 2.9.1.1, Theme Kit Pro 1.3.0, Creative Kit 1.1.4.1. The skill is version-agnostic: runtime scripts (`environment-check.md` §3) decide what a given site has.

## Important context about the sources

- kadencewp.com now redirects. `kadencewp.com/help-center/` goes to `docs.nexcess.com/software/kadence/`, and `kadencewp.com/kadence-blocks/`, `/kadence-theme/` and `/blog/` go to liquidweb.com. Kadence is now a Liquid Web / Nexcess product line, so docs.nexcess.com is the current official documentation host. Some old kadencewp.com doc URLs give a 404 (for example `/help-center/docs/kadence-theme/`).
- Almost every Nexcess Kadence doc shows "Last updated July 2, 2026". This looks like a bulk migration date, not a content review. Several pages still describe older behaviour (see "Version differences and outdated material").
- The official changelogs on docs.nexcess.com and the wordpress.org readme are the most reliable sources for what changed and when.

## 1. Sources reviewed

| # | Title | URL | Type | Date / version shown | What it covers | Reliability note |
|---|---|---|---|---|---|---|
| 1 | Kadence Blocks on wordpress.org | https://wordpress.org/plugins/kadence-blocks/ | Changelog / official listing | 3.9.1.1, 16 Nov 2026; needs WP 6.6, PHP 7.4 | Free block list, Style Library, full changelog 3.8.0 to 3.9.1.1 | High. Readme by the vendor. The "Blocks" section count on the page is wrong (says 1 block). |
| 2 | Kadence theme on wordpress.org | https://wordpress.org/themes/kadence/ | Official listing | 1.6.0, 6 Nov 2026 | Feature summary, link to Trac log | High, but no changelog text on the page |
| 3 | Kadence changelog index (Nexcess) | https://docs.nexcess.com/software/changelogs/kadence/ | Changelog | Lists Blocks 3.9.1, Blocks Pro 2.9.1, Theme 1.6.0, Theme Kit Pro 1.3.0, Creative Kit 1.1.4 | Latest version of every Kadence product | High. Index lags wordpress.org by one patch for Blocks. |
| 4 | Kadence Blocks changelog (Nexcess) | https://docs.nexcess.com/software/changelogs/kadence/kadence-blocks/ | Changelog | 3.7.11.1 to 3.9.1 | Security and feature entries | High; page excerpt did not show 3.5 to 3.7.10 |
| 5 | Kadence Blocks Pro changelog | https://docs.nexcess.com/software/changelogs/kadence/kadence-blocks-pro/ | Changelog | 2.8.16 (1 Jun 2026) to 2.9.1 (11 Nov 2026) | Query Loop fixes, security, FSE support | High |
| 6 | Kadence Theme changelog | https://docs.nexcess.com/software/changelogs/kadence/kadence/ | Changelog | 1.4.5 to 1.6.0 (5 Nov 2026) | FSE mode (Alpha), WP minimum | High |
| 7 | Theme Kit Pro changelog | https://docs.nexcess.com/software/changelogs/kadence/kadence-theme-pro/ | Changelog | 1.1.19 to 1.3.0 (5 Nov 2026) | Dark mode fixes, WP 7.1 fix | High |
| 8 | Creative Kit changelog | https://docs.nexcess.com/software/changelogs/kadence/kadence-creative-kit/ | Changelog | 1.0.0 (16 Jan 2025) to 1.1.4 (28 May 2026) | Marquee block history | High |
| 9 | stellarwp/kadence-blocks | https://github.com/stellarwp/kadence-blocks | GitHub | Stable tag 3.9.1.1, branch `master` | Source of free Kadence Blocks; `src`, `includes`, `changelog`, an `AGENTS.md` and `CLAUDE.md` in the repo | High for free Blocks code. Pro plugins are not public. |
| 10 | Kadence docs home (Nexcess) | https://docs.nexcess.com/software/kadence/ | Official doc index | n/a | Category entry points | Navigation only |
| 11 | How to Use the Kadence Style Library | https://docs.nexcess.com/software/kadence/blocks/how-to-use-the-kadence-style-library/ | Official doc | 14 Oct 2026, updated 15 Oct 2026; needs Blocks 3.8.0 | Style Library tokens, presets, palette import | High and current |
| 12 | Kadence Elements category, pages 1 and 2 | https://docs.nexcess.com/category/kadence-theme/kadence-elements/ | Official doc index | n/a | 20 Elements articles | Navigation |
| 13 | The Four Types of Kadence Elements | https://docs.nexcess.com/software/kadence/theme/types-of-elements/ | Official doc | 29 Apr 2022, updated 2 Jul 2026 | Content Section, Fixed Section, Template, HTML Editor | Medium-high |
| 14 | Kadence Content Section Hooked Elements | https://docs.nexcess.com/software/kadence/theme/content-section-hooked-elements/ | Official doc | 28 Jun 2025, updated 2 Jul 2026 | Placement hook list, display, user, device, expiry, preview | High |
| 15 | Kadence Template Hooked Elements | https://docs.nexcess.com/software/kadence/theme/create-a-template-element/ | Official doc | updated 2 Jul 2026 | Replace single content, replace archive loop, preview | High |
| 16 | Kadence Element Settings | https://docs.nexcess.com/software/kadence/theme/element-settings/ | Official doc | updated 2 Jul 2026 | Preview, placement, priority, language, devices, expiry | High |
| 17 | Programmatically Display Kadence Hook Elements | https://docs.nexcess.com/software/kadence/theme/display-kadence-hook-elements/ | Official doc | 14 Aug 2025 | `kadence_element_display` filter | High |
| 18 | Replace the Archive Loop Item Content | https://docs.nexcess.com/software/kadence/theme/replace-archive-loop-item-content/ | Official doc | 16 Jun 2023 | Template Element for loop items | High |
| 19 | Build CPTs with Template Elements | https://docs.nexcess.com/software/kadence/theme/build-custom-post-types-with-template-elements-in-kadence.md | Official tutorial | 18 Sep 2025 | ACF CPT + Template Element + Dynamic Content | High; single template only |
| 20 | Theme hooks | https://docs.nexcess.com/software/kadence/theme/theme-hooks.md | Official doc | 11 Dec 2020, updated 2 Jul 2026 | Full theme action hook list | Medium. Old list; verify against theme 1.6.0 code. |
| 21 | Dynamic Content | https://docs.nexcess.com/software/kadence/dynamic-content/ | Official doc | updated 2 Jul 2026 | Supported blocks, sources, inline vs replace mode | High |
| 22 | Repeater block | https://docs.nexcess.com/software/kadence/repeater.md | Official doc | 16 Aug 2023, updated 11 Aug 2026 | ACF repeater, Use Repeater Context | High |
| 23 | Dynamic List block | https://docs.nexcess.com/software/kadence/dynamic-list-block.md | Official doc | 28 Apr 2023 | Taxonomy or multi-value meta lists | High |
| 24 | Query Loop (Adv) block | https://docs.nexcess.com/software/kadence/blocks/advanced-query-loop-block/ | Official doc | updated 7 Oct 2026 | Loops and cards as CPTs, filters, pagination, no results | High and recently edited |
| 25 | Custom queries for Query Loop (Adv) | https://docs.nexcess.com/software/kadence/blocks/custom-queries-advanced-query-loop/ | Official doc | updated 2 Jul 2026 | `kadence_blocks_pro_query_loop_query_vars` | High |
| 26 | Display ACF relationship fields in Query Loop (Adv) | https://docs.nexcess.com/software/kadence/blocks/display-acf-relationship-fields-query-loop-adv-block/ | Official tutorial | 19 May 2025 | Relationship field to `post__in` | High; snippet hardcodes an ID |
| 27 | Conditional Display | https://docs.nexcess.com/software/kadence/conditional-display/ | Official doc | updated 2 Jul 2026 | Condition list, AND/OR, supported blocks | High |
| 28 | Color Palette Switch (Dark Mode) | https://docs.nexcess.com/software/kadence/theme/color-palette-switch-dark-mode/ | Official doc | 22 Sep 2021, updated 2 Jul 2026 | Dark mode setup, `color-switch-dark` class | Medium. Predates Style Library. |
| 29 | Theme Kit Pro category | https://docs.nexcess.com/category/kadence-theme/theme-kit-pro.md | Official doc index | n/a | 18 Theme Kit Pro module articles | Navigation |
| 30 | Conditional Headers | https://docs.nexcess.com/software/kadence/theme/conditional-headers.md | Official doc | 5 Aug 2022 | Extra Customizer headers by condition | High |
| 31 | How to Customize the Kadence Header | https://docs.nexcess.com/software/kadence/theme/customize-kadence-header.md | Official doc | 1 Nov 2020, updated 2 Jul 2026 | Header builder rows, off canvas, Enable Block Header, sticky, transparent | High |
| 32 | The Kadence Header (Adv) Block | https://docs.nexcess.com/software/kadence/blocks/kadence-header-adv-block/ | Official doc | 12 Sep 2024 | Visual builder, breakpoint, sticky, transparent | High |
| 33 | Advanced Header Best Practices | https://docs.nexcess.com/software/kadence/advanced-header-best-practices/ | Official doc | updated 2 Jul 2026 | Classic vs FSE use, performance | High |
| 34 | Headers and Footers in FSE with Kadence Blocks | https://docs.nexcess.com/software/kadence/blocks/headers-footers-full-site-editing/ | Official doc | 12 Sep 2024 | Header (Adv) in a block theme | Outdated: says Kadence has no FSE theme |
| 35 | Create Advanced Headers Easily (blog) | https://www.liquidweb.com/blog/kadence-advanced-headers/ | Blog (vendor) | Blocks 3.3.0 / Pro 2.5.0; modified 30 Aug 2026 | Header, Navigation, Navigation Link, Search, Site Identity blocks; free vs Pro | Medium-high; launch post |
| 36 | Kadence Conditional Logic (blog) | https://www.liquidweb.com/blog/kadence-conditional-logic/ | Blog (vendor) | modified 27 Sep 2026 | Conditional display examples, URL conditions | Medium-high |
| 37 | Access the Design Library | https://docs.nexcess.com/software/kadence/blocks/access-the-design-library/ | Official doc | 5 Jul 2022, updated 2 Jul 2026 | By Design / With AI, Pattern Hub connections, palette pickers, role access | Medium; no Style Library mention |
| 38 | Classic Wireframes, Starter Packs, Sections | https://docs.nexcess.com/software/kadence/blocks/wireframes-starter-packs-sections-design-library/ | Official doc | updated 2 Jul 2026 | Restoring legacy library content via Cloud Connect | High |
| 39 | Customize the Design Library color palette | https://docs.nexcess.com/software/kadence/blocks/customize-design-library-color-palette/ | Official doc (seen via search snippet only) | n/a | Mapping of light, dark, highlight to palette slots | Low-medium; conflicts with #37 |
| 40 | Lottie Animation block | https://docs.nexcess.com/software/kadence/blocks/lottie-animation/ | Official doc | updated 2 Jul 2026 | Local JSON, scroll and view playback, fixed ratio | High |
| 41 | Vector Graphic block | https://docs.nexcess.com/software/kadence/vector-graphic-block.md | Official doc (search snippet) | n/a | Paste SVG, saved vector library | Medium; not fetched in full |
| 42 | Using Custom SVG Icons with Kadence Blocks Pro | https://www.liquidweb.com/?p=445480 | Official doc (search snippet) | n/a | Icon manager upload/paste, IcoMoon JSON route, fill icons only | Medium; not fetched in full |
| 43 | Animate on Scroll guide | https://docs.nexcess.com/?p=58604 | Official doc (search snippet) | n/a | AOS location, supported blocks, defaults | Medium; not fetched in full |
| 44 | Kadence Creative Kit doc | https://docs.nexcess.com/software/kadence/kadence-creative-kit/ | Official doc | updated 3 Nov 2026 | What Creative Kit includes | High and current |
| 45 | Creative Kit (second doc) | https://docs.nexcess.com/software/kadence/creative-kit-2/ | Official doc | 30 Jan 2025, updated 3 Nov 2026 | Same scope, plan availability | High |
| 46 | Advanced Form: FluentCRM, webhooks, submit-actions filter, upload directory | https://docs.nexcess.com/software/kadence/blocks/fluentcrm-form-advanced-block/ ; https://docs.nexcess.com/software/kadence/blocks/webhooks-form-adv-block.md ; https://www.liquidweb.com/help-docs/software/kadence/blocks/advanced/form-submit-actions-filter/ ; https://docs.nexcess.com/software/kadence/blocks/custom-upload-directory-form-adv-block/ | Official docs (search snippets) | n/a | Actions after submit, filters | Medium; read via snippets |
| 47 | Advanced Kadence hooks for blocks | https://wpbarista.com/advanced-kadence-hooks-for-blocks/ | Community dev blog | 11 Dec 2022, modified 22 Apr 2025 | Post block, single and archive hooks | Medium; older, verify names |
| 48 | Create a team members page with Kadence | https://docs.metabox.io/tutorials/create-team-members-page-with-kadence/ | Community (third-party vendor) | about 2025 | CPT + Query Card + dynamic fields, no code | Medium; uses Meta Box not ACF |
| 49 | Visual Hook Guide for Kadence (plugin readme) | https://cdn.jsdelivr.net/wp/plugins/visual-hook-guide-for-kadence/trunk/readme.txt | Community plugin | n/a | Shows theme hooks on a page | Low; third-party plugin, not on our allowlist, for reference only |
| 50 | Liquid Web Kadence Blocks product page | https://www.liquidweb.com/software/kadence/blocks/ | Marketing | n/a | Block marketing list | Low; marketing, no free/Pro labels |
| 51 | Search results on Kadence FSE status | https://glamsydesigns.com/kadence-theme-review ; https://www.kadencewp.com/?p=310305 | Community review / old blog | 2025 / 2022 | Said Kadence had no FSE theme yet | Outdated by theme 1.6.0 |

Not found or not public: an official Kadence Facebook group summary (the group is not publicly readable), a full Theme 1.6.0 FSE mode doc page, a Style Library page on the vendor blog, and any official "build a documentation site" or "education site" tutorial.

## 2. Key documented facts by topic

### Elements (Theme Kit Pro)
- Four types: Content Section (blocks hooked anywhere), Fixed Section (fixed top or bottom, on load or on scroll), Template (replaces header, hero, single content, archive content or loop item, sidebar, footer, 404), HTML Editor (raw HTML or scripts). Source #13.
- Hooked Elements must be enabled under Appearance > Kadence, and require Theme Kit Pro. Dynamic Content in an Element needs Blocks Pro. Sources #15, #21.
- Content Section placements include Before/After Site Wrapper, Before/After/Replace Header, Before/After All Content, hero areas, Before/After Content and Sidebar, Replace Sidebar, eight single inner content positions, after first heading or after paragraphs 1 to 4, comments, archive inner title, Before/After/Replace Footer, 404, off-canvas, account login modal, and a Custom Hook. Each placement has a Priority. Source #14.
- Template placements include Replace Single Post Content, Replace Archive Loop Item Content, Archive Content, Above Content Hero, Header, Sidebar, Footer, 404. Template Elements work for posts, pages and CPTs, not WooCommerce products. Sources #15, #18.
- Display rules: show on many targets (Entire Site, Front Page, singular and archive types, single CPT with All, Individual or Grouped by term) plus Exclude rules. User rules: all, logged in, logged out, roles. Device: desktop, tablet, mobile. Expires date. Target Language appears only with a multilingual plugin. Sources #14, #16, #19.
- Preview settings (editor only): editor width in px, preview post type, preview post. If dynamic blocks show "No Content", set a matching preview post. A Repeater inside an Element needs a preview post that has the repeater field. Sources #16, #22.
- Developer filter `kadence_element_display( $display, $element, $meta )` overrides display; docs advise setting the Element's display to None when code controls it. Source #17.
- Each Element has a shortcode by ID, and Elements can be imported and exported. Sources #12 (article list).

### Theme hooks
- Official list covers body, header (for example `kadence_before_header`, `kadence_after_header`, `kadence_replace_header`), content wrap, hero (`kadence_entry_hero`, `kadence_hero_header`), content and sidebar, single inner content (`kadence_single_before_entry_content`, `kadence_single_after_entry_content`), comments, archive, footer, 404, mobile off canvas, login modal, WooCommerce, Events Calendar, post loop and Post Grid/Carousel hooks. Source #20.
- Docs say the Element placement dropdown lists common hooks only; the theme folder is the full source (search for `do_action`). Source #20 and search results.

### Dynamic content and ACF (Blocks Pro)
- Supported Kadence blocks: Dynamic HTML, Advanced Text, Advanced Button, Advanced Image, Advanced Gallery, Dynamic List, Image Overlay, Split Content, Video Popup, Row Layout, Section, Icon, Icon List, Info Box, several Advanced Form fields. Core: Paragraph, Heading, Quote, Preformatted, Pullquote, Table, Verse, Media and Text, Button. Source #21.
- Sources: Post, Archive, Site, Media, Author, Meta Relationship (first related post only), Current User, Time, and custom fields from ACF, Pods or Meta Box. ACF group sub-fields use `group_subfield`. Source can be switched from Current Post to another post. Source #21.
- Inline mode (dynamic text beside static text) is the default outside Query Loop (Adv); replacement mode is the default inside loops. Use Dynamic HTML for multi-line or HTML values. Source #21.
- Repeater block shows ACF Repeater or Meta Box cloneable groups, including from an ACF Options page. Child blocks use "Use Repeater Context". Requires Blocks Pro plus ACF Pro or Meta Box Group. Source #22.
- Dynamic List shows taxonomy terms or a multi-value meta field (checkbox or multi-select), with optional term links. Source #23.
- The docs do not describe Before/After or fallback fields in text; our project standards already require them from the editor UI. Verify in code (see open questions).

### Query Loop (Adv) (Blocks Pro)
- Built from a Query Loop (stored as a CPT) plus a Query Card (also a CPT, or a Template Element, or a Woo product template). Edits sync everywhere; duplicate for variants. Source #24.
- Query: multiple post types, limit by taxonomy, order by date, modified, title, menu order, custom field (key plus type text, number or date) or random; offset; sticky; per page; specific posts; infinite scroll; inherit from template; related posts (posts and products only). Source #24.
- Filters: Search (title and content only), Dropdown, Checkbox, Buttons (taxonomy or post meta, optional counts), Date, Range, Rating, Swatches, Reset. Each filter can have a URL slug. AND or OR across filters. Pagination and a No Results block. Source #24.
- CPTs must be publicly queryable; filtering uses admin-ajax.php (Source #24); the troubleshooting doc says it relies on the REST endpoint `/wp-json/wp/v2/kadence_query/query`. Both appear in current docs; allow both through firewalls and check which one the front end calls.
- Custom args via `kadence_blocks_pro_query_loop_query_vars( $query, $ql_query_meta, $ql_id )`. Source #25.

### Conditional display (Blocks Pro)
- Conditions: Post Custom Field, Post Title, URL, ID, Date, Modified, Featured Image URL, Post Type, Status, Has Taxonomy, Repeater Custom Field, Archive Title, URL and Custom Field, Author fields, Comments Count, URL Path, Full URL, Query Param, User Logged-In, Role (by slug), names, User Custom Field. AND or OR. Source #27.
- Supported on Image (Adv), Text (Adv), Section, Row Layout, Slider slides, Accordion panes, Tabs, Icon, Icon List items, Buttons (Adv), Info Box, Testimonials. Source #27.
- The vendor blog recommends always giving a fallback so no empty gap shows. Source #36.

### Design Library and Style Library
- Design Library opens from the editor toolbar or a Row Layout. "By Design" (Patterns, Pages) and "With AI". Pattern Hub connections need a URL and access key. Premium patterns and Starter Templates need Creative Kit, or Blocks Pro and Theme Kit Pro licensed with the same key (docs study 2026-11-22). Role access is set in Kadence Block Controls. Sources #37, #38, #44.
- Old wireframes, starter sections and starter packs are no longer shown by default; they can be re-added through Cloud Connect. Source #38.
- Style Library (Kadence > Style Library, Blocks 3.8.0+): named color palettes (multiple palettes, assignable per block), six text sizes plus favourite fonts (font families are not tokens), eight radius steps, three border widths, ten spacing steps, three icon sizes, three shadows. Source #11.
- Block presets for Button, Advanced Image, Row Layout, Section, Icon, Advanced Text. Lookup order is block, then preset, then theme default. A red dot shows an override. Info Box has no presets yet. Source #11.
- On Kadence Theme sites the Customizer palette is imported into the Style Library as the Default palette when Blocks is updated; after that the palette is edited in the Style Library. A known issue can reset theme button colors after the update. Reset in the Library panel resets everything. Source #11.
- Hand-picked custom values are not linked to tokens. Column Gutter and Vertical Gap still use NONE/SM/MD/LG. Source #11.

### Customizer, global palette, dark mode, typography
- Global palette has slots referenced as `--global-palette1` and up; palette colors 10 to 15 exist (Theme Kit Pro 1.2.4 and Blocks 3.9.1 fixed them). Sources #7, #1.
- Typography: base font plus per-heading settings under Colors and Fonts > Typography; palettes are exported and imported as pasted JSON in the Customizer (Colors & Fonts > Colors > folder icon > Export/Import tab) `[docs]`, confirmed by the full docs study (2026-11-22). The whole Customizer exports to `kadence-theme-export.dat` through Customize > Import/Export, which the Starter Templates plugin provides. For scripted palette changes use `customizer-automation.md` §5.
- Dark mode (Theme Kit Pro module): enable under Appearance > Kadence, settings in Customizer > General > Color Switch (Dark Mode). Options: default light or dark, OS aware, which palette is dark, dark logo and mobile dark logo, a header or footer builder switch item, or a fixed floating switch (type, style, alignment, offsets, device visibility). It adds `color-switch-dark` to body. It does not generate dark CSS; anything not using palette variables will not switch. Source #28.

### Header and Footer
- Customizer Header Builder: top, main, bottom rows with sections, Tablet/Mobile tab with Off Canvas area (Trigger plus Mobile Navigation). Sticky options per device (main row, top and main, whole header, top only, bottom only), reveal on scroll up, shrink, sticky logo. Transparent header per page type, overridable per post. Sticky styles win over transparent once sticky. Source #31.
- "Enable Block Header" in Customizer Header > General swaps the theme header for a chosen Header (Adv). Source #31.
- Conditional Headers (Theme Kit Pro): extra Customizer headers with display, user and expiry rules; user default is "none". Source #30.
- Header (Adv) block (Blocks 3.3.0+): headers managed under a Kadence Headers screen; Top, Middle, Bottom rows with five sections each; separate tablet/mobile version; default switch at 1024px; sticky per row, reveal on scroll up, shrink; transparent with Auto Spacing Under; backdrop blur. Sources #32, #35.
- Navigation (Adv) and Navigation Link blocks: sub menus free; mega menus, highlight labels, link images and icon library are Pro. Best practice: avoid heavy blocks (Query Loop with filters) in mega menus; limit AOS and media in headers. Sources #33, #35.
- Classic Kadence theme sites can use Header (Adv) inside a Template Element that replaces the header, or via Enable Block Header. Sources #31, #33.

### Advanced Form
- Form (Adv) arrived in Blocks 3.1. Adds File, Time, Date, Accept, Hidden fields; CAPTCHA block (reCAPTCHA, Turnstile, hCaptcha). Conditional fields are Pro. Webhook action is Pro. FluentCRM action works in free. Uploads go to `uploads/kadence_form/` and can be moved with `kadence_blocks_advanced_form_upload_directory`. Actions can be filtered with `kadence_blocks_advanced_form_actions`. Source #46.
- On sites that standardise on another form plugin (for example Fluent Forms), treat Advanced Form as reference only.

### Creative Kit
- Includes: the Marquee (Adv) block, access to select premium starter templates (Acta and Waypoint), and premium Design Library items. A search snippet of an older doc also says it unlocks Animate on Scroll in free Kadence Blocks. It does not include Theme Kit Pro or Blocks Pro. Sources #44, #45, #8.
- Marquee: added in 1.1.0 (Oct 2025), inner blocks allowed from 1.1.2, GSAP engine and editor preview from 1.1.4. Source #8.

### Animations, Lottie, vectors, icons
- AOS settings live in a block's Advanced tab. Supported blocks include Section, Button, Text (Adv), Form, Image (Adv), Video Popup, Image Overlay, Split Content; wrap anything else in a Section. Site defaults under Kadence Block Controls apply only to new blocks. One setting for all screen sizes. Source #43.
- Lottie block (free): remote URL or local JSON upload, managed under Kadence Blocks > Settings > Manage Lottie Animations; autoplay, play on scroll (with frame range), play when in view, loop with delay and count, bounce, speed; "use fixed ratio" to avoid layout shift. Source #40.
- Vector Graphic block (free): paste SVG, name it, saved into a vector library managed in Kadence settings. Changelog called it a Vector Illustration block in March 2025. Source #41.
- Custom SVG icons (Pro): upload or paste in the icon picker ("My Icons"); works in Kadence blocks only, not theme icons; use fill icons so color controls apply; sanitise first; older IcoMoon JSON route under Kadence Blocks > Custom Icons. Sources #42, #1 (3.8.0 rejects SVGs it cannot clean).

### Responsive controls
- Kadence blocks offer desktop, tablet, mobile values for spacing, typography and alignment. Header (Adv) has its own breakpoint setting that affects only the header block. AOS has no per-device setting. Sources #1, #32, #43.

## 3. Version differences and outdated material

### Installed versus latest (from official changelogs)

| Product | Installed | Latest seen | Gap that matters |
|---|---|---|---|
| Kadence Blocks | 3.9.1 (11 Nov 2026) | 3.9.1.1 (16 Nov 2026) | Security only: Advanced Form default field values, Design Library imported content |
| Kadence Blocks Pro | 2.8.16 (1 Jun 2026) | 2.9.1 (11 Nov 2026) | 2.8.17 slider editor fix; 2.8.18 Query Loop applies Limit by Taxonomy to non-public taxonomies, and pagination links get screen reader names and a labelled landmark; 2.8.19, 2.8.19.1, 2.8.20.1 output escaping (security); 2.8.20 fatal error fix when a filter/search/sort URL parameter is an array, plus licence popup; 2.9.0 FSE mode support and stricter SVG sanitising; 2.9.1 synced pattern fatal fix and Query Loop infinite scroll on WP 7.1 |
| Theme Kit Pro | 1.2.6 (14 Oct 2026) | 1.3.0 (5 Nov 2026) | 1.2.7 fixes the HTML Element code editor in the WP 7.1 iframed editor; 1.3.0 dark mode in FSE mode (Alpha), WP 6.6 minimum |
| Kadence Theme | 1.6.0 | 1.6.0 | Current |
| Creative Kit | 1.1.4 | 1.1.4 | Current |

Note: Blocks 3.9.x was released together with Pro 2.9.x and Theme Kit Pro 1.3.0. The installed mix (Blocks 3.9.1 with Pro 2.8.16) is older Pro on newer free Blocks. No official compatibility statement was found. Updating plugins is an owner decision and is not part of this research.

### New in the installed versions
- Blocks 3.8.0 (13 Oct 2026): Style Library and design tokens; stricter SVG import sanitising. 3.8.0.1: design tokens stopped overriding non-active palette reads, which had broken Theme Kit Pro dark mode. 3.8.0.2: token libraries read once per request; fixed admin files loading on every request. 3.8.1: Lottie source handling (security). 3.9.0 (5 Nov 2026): site-wide block styles in the theme's FSE mode under Appearance > Editor > Styles; color controls and widths follow Global Styles in FSE mode. 3.9.1: palette colors 10 to 15 shown in a new Extended group in the Style Library; transparent Header (Adv) auto spacing on WP 7.1; synced pattern fatal fix. Source #1.
- Theme 1.6.0 (5 Nov 2026): optional "Full Site Editing mode (Alpha)", off by default, under Appearance > Kadence; header, footer and templates become Site Editor templates; Kadence palette, fonts and buttons appear in Global Styles. Also fixes outline button padding in the editor to match the front end. WP 6.6 minimum. Source #6.
- Theme Kit Pro 1.2.4: dark mode now covers palette colors 10 to 15. 1.2.6: licensing page and admin banner only. Source #7.
- Creative Kit 1.1.4: Marquee on GSAP with editor preview. Source #8.

### Docs that are outdated or need care
- "Kadence does not provide an FSE theme" (source #34) and third-party reviews saying the same are outdated since theme 1.6.0 added an Alpha FSE mode. Alpha means it should not be used for production without owner approval.
- The Dark Mode doc (source #28) still says to define palettes under Customizer > General > Colors and cites Kadence Pro 1.0.3. Since Blocks 3.8.0 the Style Library says palette edits move to the Style Library on Kadence Theme sites (source #11). Which screen is now the source of truth for the dark palette, and whether Customizer edits still sync, must be checked in code.
- Design Library palette mapping conflicts: source #37 says Light = palette 1, Dark = palette 2, Highlight = palette 9; a snippet of source #39 says Dark = palette 3, Highlight = palette 1, Light = palette 9. Treat both as unverified.
- Older Design Library content (wireframes, starter packs, sections) is hidden by default now (source #38). Old tutorials that point to those tabs are outdated.
- Many Nexcess docs still say "Kadence Pro" for what is now "Theme Kit Pro"; the changelog index also lists an old "Theme Kit Pro (to remove)" entry stuck at 1.1.19.
- The Advanced Header launch post (source #35) is about Blocks 3.3.0 / Pro 2.5.0. Settings names may have moved since.
- WPBarista hook list (source #47) is from 2022; one hook is written with a capital K (`Kadence_entry_header`), which is a typo or outdated. Verify every hook against the theme.
- The ACF relationship snippet (source #26) hardcodes a loop ID, and when the ACF field is empty it sets `post__in` to an empty array, which in WP_Query returns all posts rather than none. The Meta Box variant guards with `[0]`. Hardcoded IDs also break our portability standard.
- Vector "Illustration" (2025 changelog) versus "Vector Graphic" (current doc) look like the same block under two names.
- The Creative Kit plan scope differs between sources (Express plan vs all plans). The current docs (Nov 2026) say all plans.

## 4. Community techniques worth verifying

1. CPT single template with ACF: ACF post type and field group, then a Template Element on Replace Single Post Content, Show On the CPT, preview set to a real post, Advanced Text with dynamic fields, Dynamic List for terms, Dynamic HTML for post content so the body is not lost. Source #19 (official tutorial). Fits our "Kadence first" standard.
2. Archive cards with a Template Element on Replace Archive Loop Item Content, then reuse the same Element as a Query Loop (Adv) card source, so archive pages and home sections share one card design. Sources #18, #24.
3. Resource library or directory with Query Loop (Adv): taxonomy Buttons or Checkbox filters with URL slugs, a Search filter, Reset, pagination, and a styled No Results block. Note search ignores meta and taxonomy text. Sources #24, #25.
4. Related items through an ACF Relationship field and `kadence_blocks_pro_query_loop_query_vars`, but look the loop up by a stable value (for example the query post slug) instead of a hardcoded ID, and return no posts when the field is empty. Source #26 plus our portability rule.
5. Team or people grid built entirely in a Query Card with dynamic image, dynamic icon links and Dynamic HTML, no code. Source #48 (Meta Box based; the same steps should work with ACF). Our copy rules forbid invented team members, so use only for real content types.
6. Logged-in or campaign-specific blocks with Conditional Display (User Logged-In, Query Param), always paired with a fallback block. Source #36.
7. Dark mode styling: keep every color on palette slots; use `.color-switch-dark` only for exceptions that palette slots cannot handle. Source #28.
8. Header performance: single-row header where possible, no AOS or heavy media in headers, no filtered Query Loop in mega menus. Source #33.
9. Hide an Element by code with `kadence_element_display` only when the editor rules cannot express the condition, and set its Display to None so rules do not fight. Source #17.
10. Lottie: host JSON locally, use "Don't play until in view" and "Use fixed ratio" to avoid layout shift. Source #40.
11. Hook discovery: search the theme for `do_action` rather than trusting lists; a community Visual Hook Guide plugin exists but is not on our allowlist. Sources #20, #49.

## 5. Open questions to verify against installed code

1. Style Library and the theme palette: on Blocks 3.9.1 with Theme 1.6.0, which option stores the palette after the 3.8.0 import, and do Customizer palette edits still change the front end? Where does the Theme Kit Pro 1.2.6 dark palette now live?
2. Does the Style Library known issue (theme button colors reverting) affect our site? Compare current button settings to the last export.
3. Is Blocks Pro 2.8.16 fully compatible with Blocks 3.9.1 (Style Library tokens, presets on Pro blocks, Query Loop)? Check for PHP notices or missing controls.
4. Query Loop (Adv) on Pro 2.8.16: does an array-valued filter URL parameter cause a fatal error (fixed in 2.8.20)? Do pagination links have accessible names (added in 2.8.18)? Both matter for our accessibility and security standards.
5. Theme Kit Pro 1.2.6 HTML Element editor on WP 7.1 (fixed in 1.2.7): check which WordPress version the site runs.
6. Check that the theme FSE mode (Alpha) is off on production-bound sites unless a rebuild is planned.
7. Dynamic Content Before/After and fallback: confirm attribute names and the saved markup (`kb-inline-dynamic` span and `kadenceDynamic`) in Blocks Pro 2.8.16.
8. Which Kadence blocks in 2.8.16 support Conditional Display and Use Repeater Context, compared with the doc list?
9. Exact storage of Query Loops, Query Cards, Headers and Navigations (post type names) for export and portability lookups by slug.
10. Element placement hook names in Theme 1.6.0 versus the doc list (for example the single inner content positions).
11. Design Library palette mapping (slots 1, 2, 3, 9) in Blocks 3.9.1.
12. Does Creative Kit 1.1.4 still gate Animate on Scroll in free Blocks, or is AOS now always available with Blocks Pro? Check which plugin registers the AOS controls.
13. Custom SVG icons and Vector Graphic: with the 3.8.0 SVG sanitiser, are our existing brand SVGs accepted, and where are they stored?
14. Header (Adv) mobile breakpoint (1024px default) versus the theme breakpoints used by the v3 design.
15. Security fixes in Blocks 3.9.1.1 and Pro 2.8.19 to 2.9.1: decide with the site owner whether to update before more build work.
