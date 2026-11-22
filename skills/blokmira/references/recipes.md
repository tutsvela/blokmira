# Kadence native solution matrix (recipes)

Purpose: answer "I need to build this section or feature: which Kadence component, which settings, where" with the native route first and the exact point where custom code becomes necessary.

Versions studied: Kadence Theme 1.6.0, Theme Kit Pro 1.2.6, Kadence Blocks 3.9.1, Kadence Blocks Pro 2.8.16, Creative Kit 1.1.4.

Contents
1. How to read this file
2. Global and layout
3. Header and navigation
4. Footer
5. Hero and marketing sections
6. Content and article
7. Cards, grids and queries
8. Dynamic and ACF
9. Conditional and reusable content
10. Interactive components
11. Media
12. Motion and animation
13. Forms and search
14. Accessibility and performance
15. Detailed recipes (12)

---

## 1. How to read this file

This file is a synthesis. Every row points to the source section in another file of this knowledge base, where the `path:line` evidence lives. Nothing here is new research; the tag in the Ref cell is the strongest tag found in that source.

Ref abbreviations:

| Code | File |
|---|---|
| TH | `theme.md` |
| GD | `theme-global-design.md` |
| TKP | `theme-kit-pro-elements.md` |
| BI | `blocks-inventory.md` |
| BP | `blocks-pro.md` |
| DC | `dynamic-content-acf.md` |
| CK | `creative-kit.md` |
| RA | `responsive-animation.md` |
| RR | `research-references.md` (official docs, `[docs]`) |
| LIM | `limitations.md` |

Product tags: `[Pro]` needs Kadence Blocks Pro. `[TKP:module]` needs Theme Kit Pro with that module switched on in Appearance > Kadence (all modules are off by default, TKP 2). `[CK]` needs Creative Kit. No tag means free Theme or free Blocks.

Verification tags: `[code]` installed source, `[runtime]` runtime capture, `[docs]` official docs only, `[unverified]` not confirmed (see `limitations.md` section 7 for how to check).

Column meanings: **Responsive** = has desktop, tablet and mobile values. **Global styles** = follows palette slots, theme typography or Kadence presets when you pick them. **Dynamic** = can take post, ACF or other dynamic data.

Breakpoints to remember: blocks and theme settings switch at 1024/767 px; Element device rules and some static theme CSS switch at 719/720 px (RA 1, RA 4) `[code]`.

---

## 2. Global and layout

| Requirement | Native route (product, block or Element, key settings) | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Site colour palette | Theme global palette, 15 slots (option `kadence_global_palette`), three sets plus an active pointer | Customize > Colors & Fonts > Colors | n/a | Is the global layer (`--global-palette1..15`) | n/a | Style Library tokens override a slot if set there; edit colours in one place only | GD 2, BI 4.4 [code] |
| Global typography | `base_font`, `heading_font`, `h1_font`..`h6_font` | Customize > Colors & Fonts > Typography | Yes (size, line height per device) | Sets `--global-body-font-family`, `--global-heading-font-family` | n/a | `--global-h1-font-family` etc. are not output in 1.6.0 | GD 3 [code] |
| Custom fonts | Google fonts from the typography controls; serve locally with `load_fonts_local`, `preload_fonts_local` | Customize > General > Performance | n/a | Yes | n/a | Uploaded or Adobe fonts: Kadence Custom Fonts plugin first (plan or Theme Kit Pro, post type `kt_font`) `[docs]`; without it, filter `kadence_theme_add_custom_fonts` / `kadence_theme_custom_fonts` (small PHP). Style Library "favourite fonts" `[docs]` | GD 3 [code], RR 2 |
| Content width and page layout | `content_width` (1290px), `content_narrow_width` (842px), `content_edge_spacing`; per type `{type}_layout` | Customize > General > Layout; Posts/Pages Layout | Edge spacing yes | `--global-content-width` etc. | n/a | Editor wide width uses +160px, front end +230px | GD 4, TH 4.5 [code] |
| Full-width landing page, no title | Post meta panel: Title `hide`, Layout `fullwidth`, Content Style `unboxed`, Vertical Spacing `hide`; optional Disable Header/Footer | Editor sidebar > "{Post type} Settings" | n/a | n/a | n/a | None | TH 5 [code] |
| Button styles | Base, Secondary and Outline button controls; Single Button `inheritStyles` `inherit` / `inherit-secondary` / `outline` | Customize > Colors & Fonts > Buttons; block sidebar | Padding yes | `--global-palette-btn-*` | n/a | Style Library button tokens can override Customizer values (LIM 3) | GD 5, BI 3.4 [code] |
| Spacing scale | Kadence Blocks presets `xxs`..`5xl` (`--global-kb-spacing-*`), gap presets `skinny`..`widest` | Any Kadence spacing control | Yes | Yes (token baseline) | n/a | Core spacing presets show only with `theme_json_mode` on | BI 4.1, RA 5, GD 4 [code] |
| Responsive columns | Row Layout `columns` 1 to 6, `colLayout`, `tabletLayout`, `mobileLayout`, `collapseOrder` | Row Layout > General > layout chooser with device tabs | Yes | Gutter presets | No | Max 6 columns; reverse order only on stacked layouts | RA 3, BI 3.1 [code] |
| Sidebar layout | `{type}_layout` `left`/`right`, `{type}_sidebar_id`; `sidebar_width`, `sidebar_sticky` | Customize > Posts/Pages Layout; General > Sidebar | n/a | Sidebar design controls | n/a | Widget areas accept blocks | TH 4.2, 4.5 [code] |
| Section dividers | Row Layout `topSep`/`bottomSep` (23 shapes, per-device height/width); Spacer/Divider `dividerEnable` | Row Layout > Style; Spacer block | Yes | Divider colour can be a palette slot | No | New shapes need filter `kadence_blocks_row_divider_paths` | BI 3.1, 3.21 [code] |
| Site-wide block look | Style Library presets (`kbPreset`) on Row, Section, Advanced Text, Single Button, Single Icon, Image | Kadence > Style Library | Yes | Yes | n/a | Info Box has no presets `[docs]` | BI 4.4 [code], RR 2 |

## 3. Header and navigation

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Standard header | Header Builder rows `top`/`main`/`bottom`, five zones each; mobile rows plus Off Canvas | Customize > Header > Header Builder | Separate desktop and mobile builders | Item colour controls take palette slots | No | `left_center`/`right_center` print only when `center` has items | TH 2.1 [code] |
| Sticky navigation | `header_sticky` (`main`, `top_main`, `top_main_bottom`...), `header_reveal_scroll_up`, `header_sticky_shrink`, sticky logo; mobile equivalents | Customize > Header > Sticky Header | Mobile set separately | Sticky design colours | No | No reduced-motion handling for reveal/shrink | TH 2.6, RA 7 [code]; Detailed 15.3 |
| Transparent header on one page | Leave global off; on that page set Transparent Header `enable` (`_kad_post_transparent`) | Page editor > Kadence settings panel | `transparent_header_device` | Transparent design colours | No | For a CPT never saved, the theme treats the toggle as disabled; save it once | TH 2.5, 5 [code] |
| Different header per page | Conditional Headers: list of headers, first match wins, own logo, layout, sticky, transparent | Customize > Header > Conditional Headers `[TKP:conditional_headers]` | Yes | Yes | No | No conditional footers exist | TKP 5 [code] |
| Mega menu | Ultimate Menu per menu item: `_kad_mega_menu`, width, columns; column content via "Replace item with an Element" | Appearance > Menus, item settings `[TKP:mega_menu]` (+ `elements` for Element columns) | Mobile menu mega support filterable | Dropdown colour options | Element content can be dynamic `[Pro]` | Only menus printed with `mega_support` | TKP 7 [code] |
| Mega menu in a block header | Navigation (Adv) link `isMegaMenu`, `megaMenuWidth` | Navigation Link sidebar > Sub Menu Settings `[Pro]` | Width per device | Yes | No | Panel shows only with Pro | BP 4 [code], BI 3.18 |
| Mobile menu / drawer | Mobile Navigation item in `popup_content`; `header_popup_layout`, `_side`, `_animation` | Customize > Header > Header Off Canvas | Mobile only | Yes | No | Any mobile item can go in the drawer | TH 2.3, 2.4 [code] |
| Extra header items (Button 2, HTML 2, Search Bar, Account, Contact, 3rd/4th menu) | Header Addons items, then drag into a row | Customize > Header `[TKP:header_addons]` | Desktop and mobile items | Yes | No | HTML 2 is a text field, not blocks | TKP 3.1 [code] |
| Dark mode toggle | Color Palette Switch: `dark_mode_enable`, `dark_mode_os_aware`, `dark_mode_dark_palette` (`second-palette`), header/footer switch item or fixed switch, `[kadence_dark_mode]` | Customize > General > Color Switch (Dark Mode) `[TKP:dark_mode]` | Switch visibility per device | Swaps all 15 palette values | No | Hex colours do not switch; cookie plus page cache can flash the wrong palette | TKP 6, GD 8 [code] |
| Breadcrumbs | Title element `breadcrumb` in `{type}_title_elements`; `breadcrumb_engine` (built-in, `rankmath`, `yoast`, `seopress`) | Customize > General > Breadcrumbs; Posts/Pages Layout | n/a | `title_above_breadcrumb_font` | n/a | Elsewhere: `[kadence_breadcrumbs]` shortcode (Theme Kit Pro, always on) in a Shortcode block | TH 4.5, TKP 2 [code] |
| Block-built header | "Enable Block Header" `blocks_header` + `blocks_header_id` with Header (Adv) | Customize > Header > Header Layout | Header (Adv) own `mobileBreakpoint` | Yes | Header row `[Pro]` | Hides the Conditional Header button; whole builder header replaced | TH 1.5, BI 3.19, TKP 5 [code] |

## 4. Footer

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Footer columns | Footer Builder `footer_items`; rows top/middle/bottom; `footer_{row}_columns` 1 to 5, `_layout`, `_collapse`, `_direction` | Customize > Footer | `_layout` responsive | Row colour and link controls | No | None | TH 3 [code] |
| Footer content in blocks | Widget 1 to 6 areas (accept blocks); or Element Before Footer / Replace Footer | Appearance > Widgets; Elements `[TKP:elements]` | Block controls | Yes | In Elements `[Pro]` | Replace Footer prints only where the page has a footer | TH 3, TKP 4.5 [code] |
| Footer variation per page | Element type Template, Replace Footer, with Show On rules | Appearance > Elements `[TKP:elements]` | Block controls | Yes | Yes `[Pro]` | No Conditional Footers module; two matching Replace Footer elements may both print | TKP 4.5, 5 [code] |
| Current year in footer | Block footer (Element) with Advanced Text, Dynamic Content Time > current year `time_current_year` | Toolbar > Dynamic Content `[Pro]` | n/a | Yes | Yes | Uses server timezone (PHP `date()`) | DC 4 [code] |
| Back to top | `scroll_up`, `_icon`, `_side`, offsets, `_visiblity` | Customize > General > Scroll To Top | Visibility per device | Colour controls | n/a | Smooth scroll has no reduced-motion check | TH 3, RA 9 [code] |

## 5. Hero and marketing sections

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Responsive hero | Row Layout full width, `minHeight` per device, background with `tabletBackground`/`mobileBackground`, overlay gradient, `inheritMaxWidth`; Advanced Text H1; Advanced Buttons | Block editor | Yes | Palette, font presets | Background `[Pro]` | Row has no entrance animation; animate inner Sections | BI 3.1, RA 6 [code]; Detailed 15.1 |
| Hero on posts/pages from settings | `{type}_title_layout` `above`, `_title_height`, `_title_background`, `_title_featured_image`, `_title_overlay_color` | Customize > Posts/Pages Layout | Height and align | Yes | Featured image | Fixed title element set | TH 4.2 [code] |
| Custom hero on chosen pages | Element Template, Replace Above Content Hero (`replace_hero_header`) | Appearance > Elements `[TKP:elements]` | Block controls | Yes | `[Pro]` | Shows even when title layout is normal; hide the inner title | TKP 4.5, 9 #1 [code] |
| Feature grid | Row Layout 3 columns, tablet `two-grid`, mobile `row`; Info Box or Section card per column | Block editor | Yes | Yes | Info Box image/link `[Pro]` | None | BI 3.1, 3.7 [code]; Detailed 15.2 |
| Icon feature list | Icon List `columns` per device, `listGap`, icon per item | Block editor | Yes | Palette | Item text `[Pro]` | Brand icons need Custom Icons `[Pro]` | BI 3.6, BP 5.4 [code] |
| Stats counter | Count Up `start`, `end`, `prefix`, `suffix`, `duration` | Block editor | Spacing | Fonts, palette | No | Shows end value for reduced motion | BI 3.13, RA 9 [code] |
| Timeline / steps | No timeline block. Info Box `mediaType` `number` in a Row Layout, or Icon List | Block editor | Yes | Yes | `[Pro]` | A connecting line needs Section borders or small CSS | BI 3.7 [code] |
| Pricing table | No pricing block. Row Layout + Section cards (border, radius, shadow, hover) + Advanced Text + Icon List + Advanced Button | Block editor | Yes | Yes | `[Pro]` | Feature matrix: Table (Adv); sticky first row/column `[Pro]` | BI 3.2, 3.25, BP 4 [code] |
| Testimonials slider | Testimonials `layout` carousel, `style`, `autoPlay`, `showPauseButton` | Block editor | Columns per breakpoint | Yes | Testimonial child `[Pro]` | Splide pauses for reduced motion | BI 3.11, RA 9 [code] |
| Logo carousel / animated logo strip | Marquee (Adv) with Image (Adv) items, Fade Edges, Pause on Hover, Show Pause Button | Inserter > Marquee (Adv) `[CK]` | Gap, height, fade width | Background palette | No | No reduced motion, no resize re-measure, clones stay in tab order. Alternative: Advanced Gallery carousel / fluidcarousel (free) | CK 3, 10 [code]; Detailed 15.7 |
| Call to action band | Row Layout + Advanced Text + Advanced Buttons; reuse through an Element or synced pattern | Block editor; Elements `[TKP:elements]` | Yes | Yes | `[Pro]` | Pick one reuse method and document it | TKP 9 #11 [code] |
| Countdown offer | Countdown `date`; evergreen and expire actions (Hide, Redirect, Replace) | Block editor; expire actions `[Pro]` | Spacing | Yes | No | Free has date timer only | BI 3.12, BP 4 [code] |
| Notice / announcement bar | Element Content Section at Before Header, or Fixed Section "Fixed On Top"; Expires | Appearance > Elements `[TKP:elements]` | Device rules (CSS only) | Yes | `[Pro]` | No start date | TKP 4.4, 9 #2 [code] |

## 6. Content and article

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Single post layout from settings | `post_title_layout`, `post_feature_position`, `post_author_box`, `post_related`, `post_navigation` | Customize > Posts/Pages Layout > Single Post Layout | Title height/align | Yes | n/a | Author box and related posts are hard-wired to post type `post` | TH 4.2 [code] |
| Reusable article layout | Element Template, Replace Single Post Content, Show On Single {type} > All, Preview Post set; dynamic blocks inside | Appearance > Elements `[TKP:elements]` `[Pro]` | Block controls | Yes | Yes | One single replacement per request (lowest Order wins) | TKP 4.5, DC 15.6 [code]; Detailed 15.5 |
| CPT single template | Same as above with Show On Single {CPT}; CPT must be `public` and `show_in_rest` | Appearance > Elements | Yes | Yes | Yes | Hero and sidebar still come from `{cpt}_layout` settings | TKP 9 #12, TH 4.6 [code] |
| Table of contents | Table of Contents `allowedHeaders`, `enableScrollSpy`, `enableSmoothScroll` + `smoothScrollOffset`, `enableToggle` | Block editor | Spacing, max width | Yes | No | Skips accordion panes by default | BI 3.16 [code] |
| Author box for a CPT | Element Content Section, After Entry Content, Show On Single {CPT}; Advanced Image `author|author_image`, Advanced Text `author|author_name`, `author|author_info` | Appearance > Elements `[TKP:elements]` `[Pro]` | Yes | Yes | Yes | Author fields need a published post and post type `author` support | DC 15.5, DC 3 [code] |
| Related content for a CPT | Query Loop (Adv) of the same type, Limit by Taxonomy; current post excluded by default | Block editor (Element after content) `[Pro]` | Card columns | Yes | Yes | "Related" query is documented for posts and products only `[docs]`; ACF relationship lists need `kadence_blocks_pro_query_loop_query_vars` (PHP) | BP 3.2, DC 8.6 [code], RR 2 |
| Content after paragraph N | Element at "After First/Second/Third/Fourth Paragraph" | Appearance > Elements `[TKP:elements]` | Yes | Yes | `[Pro]` | Insertion check reads as inverted `[unverified]`; fall back to After Entry Content | TKP 4.6 |
| Content before/after posts | Element at Before/After Entry Content, Hide On chosen IDs | Appearance > Elements | Yes | Yes | `[Pro]` | None | TKP 9 #6 [code] |
| Read more collapse | Show More `heightDesktop`/`Tablet`/`Mobile`, `enableFadeOut` | Block editor | Yes | Yes | No | None | BI 3.24 [code] |
| Conditional affiliate disclosure | Section with Conditional Display: Post Custom Field `acf_meta|<flag>` is True | Section > Advanced > Conditional Display `[Pro]` | Yes | Yes | Yes | Core Paragraph cannot take conditions | DC 15.8 [code]; Detailed 15.12 |
| Comparison table | Table (Adv) with block cells, `overflowXScroll`, even/odd colours; sticky row/column | Block editor; sticky `[Pro]` | Padding, alignment | Yes | No | Sticky needs max height or width | BI 3.25, BP 4 [code] |

## 7. Cards, grids and queries

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Dynamic article card | Query Loop (Adv) + Query Card with Advanced Image, Advanced Text (dynamic link), Dynamic List | Block editor `[Pro]` | Card columns, gaps | Yes | Yes | Card is a shared `kadence_query_card` post; edits sync everywhere | BP 3.2, DC 12 [code]; Detailed 15.4 |
| Simple latest posts | Posts block (`postsToShow`, `columns` per device) | Block editor | Yes | Theme loop markup | No | No pagination, filters or custom card | BI 3.14 [code] |
| Post grid or carousel without card editing | Post Grid/Carousel or Portfolio Grid/Carousel | Block editor `[Pro]` | Columns | Yes | No | Fixed card anatomy, no ACF in card | BP 3.2 [code] |
| CPT archive grid (settings) | `{cpt}_archive_columns`, `_archive_elements`, `_archive_item_image_placement`; per term columns via Archive Custom Settings | Customize > Posts/Pages Layout > {CPT} Archive; term edit `[TKP:archive_meta]` | Columns | Yes | No | CPT sections appear only for public CPTs `[unverified on a live site]` | TH 4.6, TKP 3.10 [code] |
| CPT archive grid (custom card) | Element Template, Replace Archive Loop Item Content, dynamic blocks; theme grid kept | Appearance > Elements `[TKP:elements]` `[Pro]` | Theme columns | Yes | Yes | One loop replacement per request | TKP 4.5, DC 15.7 [code] |
| CPT archive (fully custom) | Element Replace Archive Content + Query Loop (Adv) with `inherit` main query | Elements + block editor | Yes | Yes | Yes | Infinite Scroll and Archive Custom Settings stop applying | TKP 9 #13, DC 12 [code] |
| Category filter on a listing | Query Loop filters: Buttons, Checkbox, Dropdown, Search, Reset, URL slugs | Inside the Query Loop `[Pro]` | Yes | Yes | n/a | Search filter covers title and content only `[docs]`; array URL parameter fatal fixed only in 2.8.20 (LIM 5) | BP 3.2 [code], RR 2 |
| Pagination / infinite scroll | Query Loop Pagination block; `infiniteScroll` in `_kad_query_query`. Theme archives: Infinite Scroll module | Query Loop; Customize > General > Infinite Scroll `[TKP:infinite]` | n/a | Yes | n/a | Infinite Scroll module affects the theme loop only. A "load more" button was not verified | BP 3.2, TKP 3.7 [code] |
| Portfolio / masonry | Portfolio Grid `[Pro]`; Query Loop masonry (`_kad_query_masonryLayout`) | Block editor | Columns | Yes | Query Loop yes | None | BP 3.2 [code] |

## 8. Dynamic and ACF

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Dynamic ACF button | Single Button > Link > Dynamic Link > Post Custom Field `acf_meta|<url_field>`; hide with Conditional Display Not Empty | Single Button sidebar `[Pro]` | n/a | Button inherit style | Yes | Set on Single Button, not the Advanced Button wrapper; ACF Link title/target ignored | DC 15.4, DC 5 [code]; Detailed 15.8 |
| ACF text in a template | Advanced Text > Dynamic Content > Post Custom Field; Before/After/Fallback | Toolbar > Dynamic Content `[Pro]` | Text controls | Yes | Yes | Before/After print even when empty; use a no-break space, not a plain leading space | DC 6, 7 [code] |
| ACF or featured image | Advanced Image dynamic image; Image Size in Advanced; or Row/Section dynamic background | Image dynamic icon `[Pro]` | Image controls | n/a | Yes | Dynamic Advanced Image prints no `srcset` | DC 15.2, 11 [code] |
| ACF WYSIWYG or full post content | Dynamic HTML block (`field`, `metaField`, `limitWords`, `stripHTML`) | Block editor `[Pro]` | Heading typography | Yes | Yes | Same post's content renders once (loop guard) | BP 3.2 [code] |
| Downloads list from ACF repeater | Repeater + Repeater Template; "Use Repeater Context" on each inner block | Block editor `[Pro]` | Columns, gaps | Yes | Yes | No nested repeaters; flexible content unsupported | DC 8.7, 13 [code]; Detailed 15.11 |
| Taxonomy chips | Dynamic List `type` tax, `enableLink` | Block editor `[Pro]` | n/a | Yes | Yes | None | BP 3.2 [code] |
| Site-wide values (options page) | Site > Site Custom Setting or `acf_option|name` | Dynamic picker `[Pro]` | n/a | n/a | Yes | Typed `custom_setting` keys need `manage_options` to save | DC 8.5, 4 [code] |
| Archive intro (term description) | Theme shows taxonomy description by default; custom: Element at ARCHIVE Above Title Content or Before Archive Inner Title with Dynamic HTML `archive|archive_description` | Elements `[TKP:elements]` `[Pro]` | Yes | Yes | Yes | Archive fields read the queried term, not a term in a loop | TH 4.3, TKP 9 #4, DC 4, 13 [code] |
| Hero image from featured image | Row Layout dynamic background `post|post_featured_image_url` | Row background dynamic icon `[Pro]` | Per-device backgrounds | n/a | Yes | None | DC 15.2 [code] |

## 9. Conditional and reusable content

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Conditional promotional banner | Element Content Section with Show On / Hide On rules and Expires; or Section Conditional Display (for example `url_query_param`) | Elements `[TKP:elements]`; Section > Advanced `[Pro]` | Device rules CSS only | Yes | Yes | No start date; page cache keeps an expired banner until purged | TKP 4.7, 4.8, DC 9 [code]; Detailed 15.6 |
| Custom content placement | Element Content Section on a named hook or Custom Hook, with Priority | Elements `[TKP:elements]` | Yes | Yes | Yes | Hook must be fired by the theme or a plugin | TKP 4.3 [code]; Detailed 15.10 |
| Show content to logged-in users | Row Layout `loggedIn`/`loggedOut`/roles (free); Element "Visible to"; Conditional Display `user_logged_in`, `user_role` `[Pro]` | Row sidebar; Elements; Advanced tab | n/a | Yes | n/a | Needs a page cache that varies by login `[unverified]` | BI 3.1, TKP 4.8, DC 9 [code] |
| Schedule-expiring promo | Element Expires (`_kad_element_expires`); Conditional Headers `expires`; Countdown Hide action `[Pro]` | Elements; Customizer; block | n/a | Yes | n/a | No start date: needs `kadence_element_display` filter or manual publish | TKP 4.8, 9 [code] |
| Content by category | Element Show On Single Posts > Group > Category (child terms included); "Must Match all Groups" | Elements | n/a | n/a | n/a | Hide On by term does not include children | TKP 4.7 [code] |
| Same section in many places | Element with `[kadence_element id="…"]` in a Shortcode block, or core synced pattern | Elements; block editor | Yes | Yes | Yes | Shortcode uses an ID (environment-specific) | TKP 4.1, 9 #11 [code] |
| Third-party script on some pages | Element type HTML Editor on `wp_head` / `wp_footer` with Show rules; site-wide: Header/Footer Scripts | Elements; Customize > Custom Scripts `[TKP:scripts]` | n/a | n/a | n/a | No consent check; not versioned | TKP 3.4, 9 #15 [code] |
| Condition Kadence cannot evaluate (ACF value, start date) | Filter `kadence_element_display` keyed by slug, or a computed meta flag for Conditional Display | Functional plugin code | n/a | n/a | n/a | Custom code is justified here | TKP 9, DC 13 [code] |
| Maintenance / coming soon | Maintenance Mode page, types "Under Maintenance" (503) / "Coming Soon" | Appearance > Maintenance Mode `[TKP:adv_pages]` | Yes | Yes | Yes | "Entire Site" takes the site offline for matching visitors | TKP 3.11 [code] |

## 10. Interactive components

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| FAQ accordion | Accordion `faqSchema`, `linkPaneCollapse`, `startCollapsed`; Pane `titleTag` | Block editor | Borders, padding per device | Yes | Pane `[Pro]` | One FAQPage JSON-LD per page; check SEO plugin overlap | BI 3.9 [code]; Detailed 15.9 |
| Tabs | Tabs `layout` `tabs`/`vtabs`, `mobileLayout` `accordion`, title normal/hover/active styles | Block editor | Yes | Yes | No | None | BI 3.8 [code] |
| Modal / popup | Modal: built-in trigger or any link with class `modal-trigger` and `href="#<customID>"`; `modalLabel`; `loadFooter` | Block editor `[Pro]` | Size | Yes | No | None | BP 3.2 [code] |
| Content slider | Advanced Slider + Slide (Splide), `ariaLabel`, pause; free: Row background slider | Block editor `[Pro]` | Height per device | Yes | Slide background `[Pro]` | Keyboard behaviour not audited | BP 3.2, 9 [code] |
| Progress bar | Progress Bar `progressAmount`, `delayUntilInView`, `ariaLabel` | Block editor | Width per device | Yes | No | No reduced-motion handling | BI 3.23, RA 12 [code] |
| Map | Google Maps `apiType` embed (no key) or JS API | Block editor | Height per device | n/a | `location` `[Pro]` | Consent handling is your consent tool's job `[unverified]` | BI 3.22 [code] |

## 11. Media

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Video in lightbox | Video Popup `type` iframe (YouTube/Vimeo), poster, `urlMobile`, play button styles | Block editor (free since 3.4.4); self-hosted `[Pro]` | Ratio, max width | Yes | Poster, URL `[Pro]` | None | BI 3.27, BP 4 [code] |
| Cookie-free YouTube | Video Popup `youtubeCookies` off; the popup script accepts `youtube-nocookie.com` URLs (`kadence-blocks/includes/assets/js/kb-init-video-popup.min.js`) | Video Popup sidebar | n/a | n/a | n/a | Exact effect of the toggle `[unverified]`; no Kadence block for an inline (non-popup) YouTube embed | BI 3.27 |
| Image gallery with lightbox | Advanced Gallery `type` masonry/grid/carousel, `linkTo` `media`, `lightbox`, `lightboxCaption` | Block editor | Columns per breakpoint | Yes | ACF gallery `[Pro]` | Thumbnail slider, tiles, mosaic are `[Pro]` | BI 3.10, BP 4 [code] |
| Before/after image comparison | No native block in any studied product | n/a | n/a | n/a | n/a | Custom code needed | BI 2.2, 3.31 [code] |
| Background video | Row Layout `backgroundVideoType` `local`/`youtube`/`vimeo` | Row Layout > Background | Not preloaded on hidden devices | n/a | Local video `[Pro]` | No reduced-motion handling | BI 3.1, RA 11 [code] |
| Lottie animation | Lottie block, local file (`kadence_lottie`), `waitUntilInView`, `label` | Block editor | Width | n/a | No | Default URL is external; no reduced-motion check | BI 3.28, RA 9 [code] |
| Brand SVG graphic | Vector SVG (`kadence_vector`); icons: Custom Icons / Custom SVGs `[Pro]` | Block editor; Kadence Blocks > Custom Icons | Max width | Fill colour from icon controls | No | SVGs are sanitised; check brand files are accepted `[unverified]` | BI 3.29, BP 5.4 [code] |
| Image with mask, ratio or overlay | Advanced Image `useRatio`, `maskSvg`, `overlay`, `imageFilter` | Block editor | Max width per device | Overlay palette | Image `[Pro]` | No hover transform | BI 3.20 [code] |

## 12. Motion and animation

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Entrance animations | Animate on Scroll: `kadenceAnimation` + duration, offset, easing, `once`, delay | Block > Advanced > Animate on Scroll `[Pro]` | No per-device choice | Site defaults in "Animate On Scroll Defaults" | n/a | Only Section, Advanced Text, Single Button, Form, Advanced Image, Video Popup, Image Overlay, Split Content; Row and Info Box need a wrapping Section | RA 8 [code] |
| Staggered cards | Same, with a larger Start Delay per Section (0, 100, 200 ms) | Block > Advanced | No | n/a | n/a | No child stagger except Split Content parts | RA 8, 13 [code] |
| Parallax | Row Layout image Attachment "Parallax" (jarallax), speed filter `kadence_blocks_parallax_speed` | Row Layout > Background | Off on tablets | n/a | Background `[Pro]` | No reduced-motion handling | RA 11 [code] |
| Hover effects | Section "Hover Styles"; Single Button hover; Info Box hover + icon Hover Animation; Image Overlay `[Pro]` | Block sidebar | Borders per device | Palette | n/a | No hover transforms (lift, scale, tilt) | RA 10 [code] |
| Typed text | Advanced Text rich text format "Typed Text" | Text toolbar | n/a | Yes | n/a | Skipped for reduced motion | RA 9 [code] |
| Reduced motion | Native in Pro AOS, typed text, Count Up, Countdown, Splide | Automatic | n/a | n/a | n/a | Not handled: marquee, parallax, Lottie, video background, AutoScroll, theme smooth scroll; CSS/JS needed | RA 12, 14 [code] |
| Scroll-linked effects, custom cursor | None | n/a | n/a | n/a | n/a | Custom code needed | RA 14 [code] |

## 13. Forms and search

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| Contact form | Advanced Form (`kadence_form` post), fields, captcha (reCAPTCHA, Turnstile, hCaptcha), actions email, redirect, MailerLite, FluentCRM | Block editor; Kadence > Forms | Field widths | Inputs follow palette | Field defaults `[Pro]` | Conditional fields, database entries, webhooks are `[Pro]`. On sites that standardise on another form plugin, use that plugin's block | BI 3.17, BP 4 [code], RR 2 |
| Newsletter section placement | Element Content Section (After Entry Content or Before Footer) holding the form block; Show On rules | Elements `[TKP:elements]` | Block controls | Yes | n/a | Form plugins with their own styles need their own style settings | TKP 9 #6, GD 5 [code] |
| Header search | Search item (full-screen modal) or Search Bar `[TKP:header_addons]` | Customize > Header | Desktop and mobile items | Yes | n/a | None | TH 2.2, TKP 3.1 [code] |
| Search form in content | Search (Adv) `displayStyle` standard or modal | Block editor | Padding, width | Yes | n/a | None | BI 3.26 [code] |
| Search results layout | `search_archive_*` controls; infinite scroll `infinite_search` | Customize > Search Results; `[TKP:infinite]` | Columns | Yes | n/a | Custom design: Element Replace Archive Content on "Search Results" + Query Loop `inherit` `[unverified]` | TH 4.3, TKP 3.7, 4.7 |
| 404 page design | `404_layout`, `404_content_style`, backgrounds; or Element Replace 404 Page Content / Before 404 | Customize > General > 404 Page Layout; Elements `[TKP:elements]` | Yes | Yes | n/a | Replace 404 forces unboxed, no padding | TH 4.4, TKP 4.5 [code] |

## 14. Accessibility and performance

| Requirement | Native route | Where | Responsive | Global styles | Dynamic | Limits / custom code needed? | Ref |
|---|---|---|---|---|---|---|---|
| One H1 per page | Theme title is the H1; when the title is hidden or replaced, set Advanced Text `htmlTag` heading, `level` 1 | Post Kadence panel; block toolbar | n/a | Global h1 settings | Title `[Pro]` | Replace Single Content leaves the hero title; avoid two H1s | TH 5, TKP 4.13, DC 15.1 [code] |
| Accessible names | Modal `modalLabel`, Lottie `label`, Progress Bar `ariaLabel`, Slider `ariaLabel`, Pane `ariaLabel`, Video Popup `ariaLabel` (`kadence-blocks/dist/blocks/videopopup/block.json`) | Block sidebars | n/a | n/a | n/a | Fill them in; not automatic | BP 3.2, BI 3.9, 3.23, 3.28 [code] |
| Focus states | Theme input focus (palette3/palette6); Search (Adv) focus colours | Static theme CSS; block | n/a | Palette | n/a | `:focus-visible` is not exposed on most controls: small CSS on a custom class | GD 5, BI 3.26, 4.7 [code] |
| Contrast in light and dark | Palette slots everywhere; check both palettes at 4.5:1 | Customizer; every colour control | n/a | Yes | n/a | Hex and `--global-gray-*` never switch | GD 8, 10 [code] |
| Font privacy and speed | `load_fonts_local`, `preload_fonts_local` | Customize > General > Performance | n/a | n/a | n/a | None | GD 3 [code] |
| Gravatar privacy | Local Gravatars (no settings) | Appearance > Kadence `[TKP:localgravatars]` | n/a | n/a | n/a | None | TKP 3.9 [code] |
| Page weight | Block assets load only when used; Performance Optimizer (off by default) | Kadence Blocks Controls | n/a | n/a | n/a | Hide-on-device is CSS only; test the Optimizer with your cache plugin `[unverified]` | BI 4.5, 4.6 [code] |
| Layout shift (Lottie) | "Use fixed ratio" (`useRatio`/`ratio`) and "Don't play until in view" | Lottie sidebar | n/a | n/a | n/a | None | BI 3.28 [code], RR 2 |
| Motion safety for marquee | Show Pause Button, low speed | Marquee sidebar `[CK]` | n/a | n/a | n/a | Reduced-motion stop and `inert` clones need small JS | CK 3, 10 [code] |
| Breakpoint testing | Test 375, 720 to 767, 768, 1024, 1025, 1366 px and once with reduced motion on | Browser | n/a | n/a | n/a | Aligning 719/767 needs `kadence_*_media_query` filters or CSS | RA 1, 13, 14 [code] |

---

## 15. Detailed recipes

Steps use the setting names found in the source files. Editor labels come from editor strings and block attributes, not from screenshots; click-through in a live editor was not done for this study `[unverified UI]` unless stated.

### 15.1 Responsive hero
1. Insert Row Layout, 1 column, alignment full (`align` full) and `htmlTag` `section` (BI 3.1) `[code]`.
2. Turn on `inheritMaxWidth` so inner content follows the theme content width (BI 3.1) `[code]`.
3. Set `minHeight` with `minHeightTablet` and `minHeightMobile` and a unit (BI 3.1) `[code]`.
4. Background: image (`bgImg`) with size and position. For a different crop on phones, enable `mobileBackground` (and `tabletBackground`) (RA 6) `[code]`. For a featured image hero, use the dynamic background `post|post_featured_image_url` `[Pro]` (DC 15.2) `[code]`.
5. Overlay: `overlay` colour as a palette slot, or `overlayGradient`, with `overlayOpacity`; set `tabletOverlay`/`mobileOverlay` when needed (BI 3.1) `[code]`.
6. Heading: Advanced Text, `htmlTag` heading, `level` 1 only if no theme title shows on the page; font size preset `xl` or `xxl` (fluid `clamp()`, no per-device values needed) (RA 5) `[code]`.
7. Buttons: Advanced Buttons, each Single Button with `inheritStyles` `inherit` or `inherit-secondary` (GD 5) `[code]`.
8. Motion (optional): put the text in a Section and set Animate on Scroll `fade-up`, `once` True `[Pro]` (RA 8, 13) `[code]`.
9. On a page, hide the theme title in the Kadence panel (Title `hide`) (TH 5) `[code]`.

### 15.2 Responsive feature grid
1. Row Layout, `columns` 3, `colLayout` `equal`, `tabletLayout` `two-grid`, `mobileLayout` `row` (RA 3) `[code]`.
2. Gaps: `columnGutter` preset (for example `wide`) and `collapseGutter` for stacked spacing (BI 3.1) `[code]`.
3. In each column use Info Box (`mediaType` icon, `mediaAlign` top, title, text, optional learn more) or a Section card with border, radius, shadow and "Hover Styles" (BI 3.2, 3.7, RA 10) `[code]`.
4. Use palette slots for every colour and font size presets for titles (GD 10) `[code]`.
5. Optional stagger: Info Box has no animation support, so wrap each in a Section and set Start Delay 0, 100, 200 ms `[Pro]` (RA 8, 13) `[code]`.
6. If the whole card must be a link: Info Box `linkProperty` `box`, or Section `link` (BI 3.2, 3.7) `[code]`.

### 15.3 Sticky navigation
1. Customize > Header > Sticky Header: `header_sticky` = `main` (or `top_main` to include the top row) (TH 2.6) `[code]`.
2. Optional: `header_reveal_scroll_up` (show on scroll up), `header_sticky_shrink` with `header_sticky_main_shrink` height (RA 7) `[runtime]`.
3. Set `header_sticky_custom_logo` + `header_sticky_logo` if the stuck logo differs (TH 2.6) `[runtime]`.
4. Mobile: `mobile_header_sticky` and its reveal/shrink options; the switch point is `header_mobile_switch` (default 1024) (RA 1, 7) `[code]`.
5. Sticky design section: background, bottom border, box shadow, nav colours as palette slots (TH 2.6) `[runtime]`.
6. With a transparent header, sticky styles win once the header is stuck `[docs]` (RR 2).
7. Block header alternative: Header (Adv) `isSticky`/`isStickyTablet`/`isStickyMobile`, `stickySection`, `revealScrollUp`, `shrinkMain` (RA 7) `[code]`.

### 15.4 Dynamic article card
1. Insert Query Loop (Adv) `[Pro]`. Query settings: `postType`, `perPage`, `taxQuery`, `orderBy`; on archive templates use `inherit` (BP 3.2, DC 12) `[code]`.
2. Edit the Query Card (`kadence_query_card`). Set its card columns and gaps (BP 3.2) `[code]`.
3. Image: Advanced Image, dynamic image Post > Featured Image (`post|post_featured_image`), Image Size in Advanced (DC 15.2) `[code]`.
4. Terms: Dynamic List, `type` tax, `enableLink` on (BP 3.2) `[code]`.
5. Title: Advanced Text, Dynamic Content Post > Post Title, and Dynamic Link Post > Post URL; Replace mode is forced on inside cards (DC 6, 12) `[code]`.
6. Excerpt or ACF field: Advanced Text, Post > Post Excerpt or Post Custom Field `acf_meta|<name>` (DC 15.3) `[code]`.
7. Card frame: wrap in a Section with border, radius, shadow, hover styles (RA 10) `[code]`.
8. Add Pagination and No Results children if needed (BP 3.2) `[code]`.
9. Compare editor preview with the front end; the editor uses REST previews (DC 10) `[code]`.

### 15.5 Reusable article layout (single template for posts or a CPT)
1. Switch on Elements in Appearance > Kadence `[TKP:elements]` (TKP 2) `[code]`.
2. Appearance > Elements > Add New, type Template, placement Replace Single Post Content (`replace_single_content`) (TKP 4.5) `[code]`.
3. Show On: Single {type} > All (never Entire Site) (TKP 4.13) `[code]`.
4. Preview Settings: Select Preview Posts Type and Select Preview Post = a real item of that type (TKP 4.10) `[code]`.
5. Build with blocks, all dynamic with Source Current Post: Advanced Text title, Advanced Image featured image, Dynamic List terms, Dynamic HTML `post|post_content` for the body (so the content is not lost) (DC 15.1, BP 3.2) `[code]`, (RR 4 #1) `[docs]`.
6. The theme hero, sidebar and width still come from `{type}_layout` and title settings; turn off the theme title if the Element prints its own H1 (TKP 4.5) `[code]`.
7. Set Order on purpose if other template Elements could match; lowest Order wins (TKP 4.5) `[code]`.
8. Author box and related items for a CPT go in separate Content Section Elements (After Entry Content) because the theme versions only work for `post` (TH 4.2) `[code]`.

### 15.6 Conditional promotional banner
1. Element type Content Section `[TKP:elements]`, placement for example After Header or SINGLE: Above Title Content (TKP 4.3) `[code]`.
2. Show On: the rule set needed (for example Single Posts > Group > Category > terms); add Hide On for exclusions (child terms are not excluded) (TKP 4.7) `[code]`.
3. Visible to: Logged out Users if the offer is for visitors (TKP 4.8) `[code]`; make sure the page cache varies by login `[unverified]`.
4. Expires Settings: end date and time. There is no start date (TKP 4.8) `[code]`.
5. Device Settings only hide with CSS; do not use them for private content (TKP 4.8) `[code]`.
6. For a data-based rule on one block instead (for example a URL parameter), use Section > Advanced > Conditional Display, field URL > `url_query_param` `[Pro]` (DC 4, 9) `[code]`.
7. Purge the page cache after expiry (TKP 4.12) `[code]`.

### 15.7 Animated logo strip
1. Insert Marquee (Adv) `[CK]`; orientation horizontal, direction left (CK 3) `[code]`.
2. Speed 15 to 25 (25 is about 60 px/s), Item Height 48 to 64 px, Item Gap per device (CK 3) `[code]`.
3. Fade Edges on, Fade Width per device; Pause on Hover on; Show Pause Button on (CK 3) `[code]`.
4. One Image (Adv) per Marquee Item, real logo files at the right size, alt text set (CK 3) `[code]`.
5. Avoid links in items: clones are `aria-hidden` but stay in the tab order (CK 3) `[code]`.
6. Custom code still needed for: stopping on `prefers-reduced-motion`, re-init on resize (`window.kbMarquee.init()`), `inert` on `.kb-marquee-clone` (CK 10) `[code]`.
7. No-motion alternative: Advanced Gallery `carousel` with `autoPlay` and `showPauseButton`; Splide pauses for reduced motion (BI 3.10, RA 12) `[code]`.

### 15.8 Dynamic ACF button
1. ACF: a URL or Link field on the post type (DC 15.4).
2. Advanced Buttons > select the Single Button (the wrapper has no dynamic support) (DC 5) `[runtime]`.
3. Link field > Dynamic Link > Post > Post Custom Field > `acf_meta|<url_field>` `[Pro]` (DC 15.4) `[code]`.
4. Set "open in new tab", `noFollow`, `sponsored` in the button's own link settings; ACF Link title and target are not used (DC 8.3) `[code]`.
5. Button text can also be dynamic (`text` slug) (DC 5) `[code]`.
6. Hide when empty: Single Button > Advanced > Conditional Display, Post Custom Field `acf_meta|<url_field>`, Not Empty (DC 15.4) `[code]`.
7. Stored: the link attribute holds a `[kb-dynamic …]` shortcode and `kadenceDynamic.link` holds the settings; scripts must write both exactly (DC 6) `[code]`.

### 15.9 FAQ accordion
1. Insert Accordion; set `paneCount`, `startCollapsed`, `linkPaneCollapse` (one open at a time) (BI 3.9) `[code]`.
2. Each Pane: `title`, `titleTag` (keep heading order logical), icon style and side (BI 3.9) `[code]`.
3. Turn on `faqSchema` to print one FAQPage JSON-LD script in the head (BI 3.9) `[code]`. If an SEO plugin also outputs FAQ schema, keep only one.
4. Style titles normal/hover/active and content padding per device with palette slots (BI 3.9) `[code]`.
5. Table of Contents skips accordion panes by default (filter `kadence_toc_inner_block_ignore_array`) (BI 3.16) `[code]`.

### 15.10 Custom content placement
1. Find the position in the Element hook list (TKP 4.3) or the theme hook table (TH 6) `[code]`.
2. Element type Content Section, placement = that hook; Priority below or above the theme callback (for hero hooks the theme renders at 10) (TKP 4.3) `[code]`.
3. If the hook is not listed, choose Custom Hook and type the action name (any plugin hook works) (TKP 4.3) `[code]`.
4. Header/footer row hooks need both desktop and mobile hooks (`kadence_main_header` and `kadence_mobile_main_header`) (TH 7) `[code]`.
5. Several Elements on one hook run by priority, then by Order (TKP 4.13) `[code]`.
6. Debug with the admin bar "Elements (n)" list and `<!-- [element-ID] -->` comments (TKP 4.1, 4.11) `[code]`.

### 15.11 Downloads list from an ACF repeater
1. ACF repeater on the post type with sub fields, for example title, file URL, size (DC 8.7).
2. Insert Repeater `[Pro]`; source `current|acf_repeater|<name>`; set `columns`, gaps and `tagName` (BP 3.2, DC 8.7) `[code]`.
3. In the Repeater Template add Advanced Text (title) and a Single Button (file link). On each dynamic control turn on "Use Repeater Context" and pick the sub field (`acf_repeater|<sub>`) (DC 8.7) `[code]`.
4. Per-row hiding: Conditional Display > Repeater > `repeater_custom_field` with the sub field key (DC 8.7) `[code]`.
5. In an Element, set a Preview Post that has repeater rows (RR 2) `[docs]`.
6. Limits: no nested repeaters; flexible content is not supported (DC 13) `[code]`. If downloads are their own post type instead, use Query Loop (Adv).

### 15.12 Conditional affiliate disclosure
1. ACF true/false field on the post type, for example `has_affiliate_links` (DC 15.8).
2. Put the disclosure text in a Section (core Paragraph cannot take conditions) (DC 15.8) `[code]`.
3. Section > Advanced > Conditional Display > Enable; Source Current Post; Field Post > Post Custom Field; Custom Field `acf_meta|has_affiliate_links`; Conditional Type True `[Pro]` (DC 15.8) `[code]`.
4. Unset or false prints nothing (server side, not CSS) (DC 9) `[code]`.
5. To place it on every post without editing posts, put the Section in an Element at Before Entry Content, Show On Single Posts > All `[TKP:elements]` (TKP 9 #6) `[code]`.
