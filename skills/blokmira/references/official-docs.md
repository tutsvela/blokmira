# Official Kadence documentation: digest

Study of the official Kadence documentation, now published by Nexcess at https://docs.nexcess.com/software/kadence/. On 22 Nov 2026 the sitemap listed 2,218 Kadence pages. This study read all 386 that cover the current Kadence Theme, Theme Kit Pro, Blocks, Blocks Pro, Creative Kit, Conversions, Insights, Shop Kit, AI, Starter Templates and related tools. It left out Restrict Content Pro / Kadence Memberships, Solid, Iconic add-ons and the legacy classic themes (Virtue, Ascend, Pinnacle).

How to use this file:
- Facts are tagged with the doc slug in brackets. The page URL is `https://docs.nexcess.com/software/kadence/<slug with __ replaced by />/`.
- Docs describe the UI and are often older than the code; most pages show a bulk "Last updated July 2, 2026" migration date. When a doc and the installed code disagree, the code and the runtime scripts win. Conflicts are listed in §9.
- Paraphrased, not copied. Read the page itself before quoting it.

## Contents
1. Vendor, licensing and where things live now
2. Product map
3. Theme, Customizer and Theme Kit Pro
4. Blocks and Blocks Pro guides
5. Kadence's own custom CSS and JS places
6. Automation facts: storage, import and export, filters, JS events, post types
7. Block-by-block control map
8. Starter Templates, Design Library, AI, Conversions, Insights, Shop Kit, troubleshooting
9. Conflicts between docs and this skill, and how they were resolved
10. Features newer than the code baseline

## 1. Vendor, licensing and where things live now

### 1.1 From the general docs
- Docs are hosted by Nexcess. Licensing: "Nexcess Software manages your licensing through the Nexcess Portal" [install-activate-kadence-conversions; same line in shop-kit, insights, reading-time, simple-share, white-label, child-theme-builder, creative-kit].
- Pro downloads: Nexcess Software Account > Subscription > Manage > Downloads (Theme Kit Pro, Blocks Pro, Starter Templates) [getting-started-guide]. Older pages still say "Kadence Account Downloads & Licenses page" [kadence-ai-credits, page-transitions (Classic Plugins tab), troubleshoot-kadence-pro-update-failed...].
- Memberships: SolidWP "part of the Liquid Web / StellarWP family" manages licensing for Kadence Memberships; add-ons from account.solidwp.com; licence in Settings > SolidWP Licensing with the SolidWP username, not email [how-to-install-...memberships-pro].
- Renames: Solid Security becoming Kadence Security; Solid Backups becoming Kadence Backups ("You may see both names used") [_index]; Restrict Content Pro renamed Kadence Memberships [how-to-install-...memberships-pro]; Theme Kit Pro still called "Kadence Pro" and "Kadence Theme Pro" in several pages [add-google-tag-manager..., fixing-phone-numbers..., waypoint-...]; Pattern Hub is also "Kadence Cloud" (text domain `kadence-cloud`) [categories-and-search-terms, change-any-text-on-your-site].
- Backup doc still says Solid Backups is "part of the SolidWP suite" [backup-site].
- Support: premium technical support nearly around the clock except Friday 5 PM to Sunday 5 PM US Central; account services weekdays 9 to 5 Central [getting-started-guide]. Free and premium tickets exist [troubleshoot-updating-page-failed-offline-error].
- Kadence AI uses partner LLMs; status pages for Kadence AI and OpenAI are the first check [kadence-ai-languages, troubleshoot-kadence-ai].
- Old KB domain kb.kadencethemes.com still linked in a legacy page [theme-options-wont-save].

### 1.2 From the theme docs
- Every page title ends "Nexcess Documentation". The docs live at docs.nexcess.com/software/kadence/.
- Licensing has two wordings:
  - Theme Kit Pro: "Nexcess Software manages your licensing through the Nexcess Portal" (see "How to Activate Your License"). [theme-kit-pro-plugin]
  - Custom Fonts: "Liquid Web Software manages your licensing through the Liquid Web Portal" and "How to Activate a Unified License". [custom-fonts]
- Renames, from "Related" teasers on these pages (boilerplate, but vendor-relevant):
  - "Restrict Content Pro is becoming Kadence Memberships".
  - "Solid Security is becoming Kadence Security".
  - "Solid Central is becoming Kadence Central". Both names are in use during the transition. Teasers also mention "Solid Security Pro WP-CLI Integration".
- Plans named: Kadence Plus Plan, Kadence Ultimate and Lifetime Plans ("Ultimate/Lifetime"), and "Kadence Express Plus" (CPT doc).
  - Theme Kit Pro is in Plus and Ultimate, or sold separately.
  - Plus includes Theme Kit Pro and Blocks Pro; Template Elements with dynamic content need "Plus Plan or greater".
- The product naming is inconsistent inside the docs: Kadence Theme Kit Pro, Kadence Pro, Kadence Theme Pro, Kadence Pro Addon, Kadence Pro (Theme add-on). StellarWP is not mentioned in the theme group.
- Other products named: Kadence Shop Kit (WooCommerce templates, Product Brand display rules), Kadence Simple Share, Kadence WooCommerce Email Designer, Kadence Custom Fonts, Kadence Starter Templates.
- Legacy themes Virtue and Pinnacle are mentioned (favicon in Theme Options > Misc Settings). [set-site-favicon]

## 2. Product map
| Product | What it does | Features that matter for building designs | Free/paid |
|---|---|---|---|
| Kadence Theme | Site-wide layout, header/footer builder, global palette and typography, page/post/archive/Woo layouts [introducing-kadence-theme] | Customizer header/footer rows (desktop layout, tablet+mobile share another); sticky/transparent header; global palette and fonts used by theme, Blocks and Design Library; optional Full Site Editing (Alpha) mode in 1.6.0, off by default, toggled in Appearance > Kadence [introducing-kadence-theme] | Free |
| Kadence Blocks | Blocks in a Kadence Blocks inserter category; Row Layout, Section, accordions, tabs, forms etc.; Style Library; Design Library; Pexels picker [introducing-kadence-theme, pexels-integration] | Loads CSS/JS only for blocks used; most settings per device; Style Library (Kadence > Style Library) holds colours, typography, spacing, borders, shadows, block presets [introducing-kadence-theme] | Free |
| Kadence Theme Kit Pro (docs also say "Kadence Pro", "Kadence Theme Pro") | Theme add-on modules turned on in Appearance > Kadence [introducing-kadence-theme] | More header elements, conditional headers, mega menus, Hooked Elements, Woo add-ons (sticky add-to-cart, off-canvas filter sidebar), dark mode palette switch, maintenance mode, Custom Scripts boxes [introducing-kadence-theme, fixing-phone-numbers..., getting-started-guide] | Paid |
| Kadence Blocks Pro | Extra blocks and features [introducing-kadence-theme] | Advanced Slider, Modal, Image Overlay, Portfolio Grid, Post Grid, Product Carousel, Query Loop (Adv) with filters, dynamic content, Custom CSS per block with an indicator icon, Conditional Display with an "if" badge [introducing-kadence-theme, waypoint-starter-template-...] | Paid |
| Kadence Creative Kit | Premium Starter Templates Acta and Waypoint, Marquee (Adv) block; also ships Animate on Scroll files [kadence-creative-kit, troubleshooting-optimization-caching-plugins] | Marquee (Adv); with Express plan it unlocks premium Starter Templates and designs [kadence-ai-powered-starter-templates] | Paid, "included across all plans" [kadence-creative-kit] |
| Starter Templates ("AI Powered Starter Templates by Kadence", "Starter Templates by Kadence") | Imports complete sites (pages, menus, header, footer, theme settings, widgets, sample posts/products) [introducing-kadence-theme, pre-designed-starter-templates] | Works only with the Kadence Theme; includes Site Assist and the Customizer Import/Export settings; adds social URL fields to user profiles [kadence-starter-templates, starter-templates-faqs-troubleshooting] | Free plugin (wordpress.org); premium templates need a plan |
| Kadence Site Assist | Setup checklist inside the Starter Templates plugin [kadence-site-assist] | Walks through AI, starter site, logo, palette, header, footer, typography, buttons, layouts, SMTP, security, performance | Free |
| Design Library | Part of Kadence Blocks; patterns and full pages, "By Design" and "With AI", Pattern Hub connections [introducing-kadence-theme, kadence-ai-powered-design-library] | Patterns use site palette and fonts; colour style preview (Light/Dark/Highlight) | Free; premium items need Creative Kit or Pro add-ons |
| Kadence AI | Content generation for Starter Templates, Design Library and Advanced Text inline [what-is-kadence-ai] | Needs Kadence account connection; credits | Free 250 lifetime credits; plans add more [kadence-ai-credits] |
| Kadence Pattern Hub (Kadence Cloud) | Host your own pattern library for other sites [categories-and-search-terms, getting-started-guide] | Categories, keywords, access keys, thumbnails, pro/locked filters | Paid (in plans; not stated precisely) |
| Kadence Conversions | Popups, slide-ins, banners built in the block editor with targeting, triggers, scheduling, analytics [install-activate-kadence-conversions] | Needs Kadence Blocks | Paid |
| Kadence Insights | A/B testing CPT and A/B Testing block [setup-kadence-insights] | Variants on pages, posts, Elements, Conversions | Paid |
| Kadence Shop Kit | WooCommerce extras [install-activate-kadence-shop-kit] | WooTemplates (single product and archive builders) + Woo Template Blocks, variation swatches, product gallery, quick view, checkout editor, size charts, global tabs, snackbar notices, cart banners, coupon modal, brands, affiliate options | Paid |
| Kadence Child Theme Builder | Packages a site as a child theme ZIP importable through Starter Templates [child-theme-builder] | Bundles Customizer config, layouts, pages, taxonomies, required plugins, optional Pattern Hub access | Paid, in the "Kadence Full Plan" [starter-templates-faqs-troubleshooting] |
| Kadence White Label | Rebrands Kadence Theme and Blocks admin [white-label] | Can also disable AI for all users | Paid |
| Kadence Custom Fonts | Upload fonts or use Adobe Typekit [add-custom-fonts-to-kadence] | Fonts appear in Kadence font lists; CPT `kt_font` [reserved-slugs-and-terms] | Paid (with Theme Kit Pro or a plan) |
| Kadence Page Transitions | Animated transitions between pages [page-transitions] | Settings in Appearance > Kadence > Page Transitions | Paid, Ultimate or Lifetime Ultimate plan only |
| Kadence Reading Time | Estimated reading time [reading-time] | Auto insert or `[kt_reading_time]` | Paid |
| Kadence Simple Share | Social share icons [simple-share] | Placement options, `[kadence_simple_share]` | Paid |
| Kadence Galleries | Mentioned as a Conversions targeting source and a product [target-pages, getting-started-guide] | n/a | Paid |
| Kadence Memberships / Memberships Pro (formerly Restrict Content Pro) | Membership plugin; legacy RCP add-ons stay separate plugins [how-to-install-...-kadence-memberships-pro] | n/a | Paid |
| Kadence Security (formerly Solid Security), Kadence Backups (formerly Solid Backups) | "Coming soon" renames [_index] | n/a | Paid |
| Solid Mail, Solid Performance, Solid Security | Installed from Site Assist for SMTP, caching/lazy load and security [kadence-site-assist] | n/a | Solid Security also offered as an optional plugin in template import |
| Kadence WooCommerce Email Designer | Optional plugin offered during template import [pre-designed-starter-templates] | n/a | n/a |
| Kadence Captcha | Captcha plugin for comment forms [remove-all-spam-comments] | n/a | n/a |
| Plans | Express, Plus, Ultimate, Ultimate Lifetime [kadence-ai-credits]; also named "Kadence Full Plan", "Lifetime Full Plan" [page-transitions, troubleshoot-kadence-pro-update-failed...], "Kadence Pro or Kadence Elite" unified plans [how-to-install-...memberships-pro] | Premium templates: Express needs Creative Kit; plans above Express need Blocks Pro + Theme Kit Pro [kadence-ai-powered-starter-templates] | Paid |

### 2.1 Products and blocks found on the block pages
Kadence Shop Kit (separate premium plugin, formerly WooExtras; "Kadence WooExtras" name still appears in one page). Admin: Dashboard > Shop Kit tabs. Not covered in the skill except a product-map line in `official-docs.md`.
- Woo Templates (Shop Kit > Product Templates; Products > Woo Templates, a custom post type): four types, Single Product (3 prebuilt layouts), Product Archive, Product Catalog Loop Item (also usable as Query Loop (Adv) card), Quickview. Settings: Template Type, Show On rules, Visible To roles, Expires; Preview Settings > Select Preview Product. [product-templates, build-single-product-template, product-archive-woo-templates, product-catalog-loop-item-woo-templates, product-for-preview]
- Woo Template blocks: Product: Add to Cart, Additional Information, Brand, Custom Actions, Description, Gallery, Image, Meta, Notice, Price, Quickview Button, Rating, Related, Reviews, Short Description, Tabs, Title, Upsell, Breadcrumbs, Archive: Main Query (controls in section 2). [product-*-block pages, archive-main-query-block, woo-template-breadcrumbs-block]
- Product archive with Query Loop (Adv): Loop Item template as card, query with Product post type, enable "Inherit Query From Template", place in Product Archive template. Archive: Main Query instead follows Customizer WooCommerce Product Catalog settings. [product-archive-woo-templates]
- Product Badges (Products > Badges): Image, Custom Image, Custom Text, Custom HTML; position, Max Width / Max Width Loop, visibility rules, Order attribute for priority, placeholders `{quantity}`, `{sale-percentage}`; option Disable WooCommerce Sale Flash. In Query cards badges need Product: Image, not Image (Adv) + dynamic. [product-badges]
- Product Quickview: auto insert with 8 placements or shortcode `[kt_quickview_button]` / `[kt_quickview_button id="16"]`; icon Play/Eye/Click; Allow Scrolling; custom Quickview Woo Template; separate "Quickview Block" toggle. [product-quickview, product-quickview-button-block]
- Product Brands taxonomy "Product Brands" (slug `/product-brands/`), separate from WooCommerce core "Brands" (WooCommerce 9.4); single and archive output positions; re-save permalinks. [product-brands]
- Product Gallery (slider, fade/slide, zoom, lightbox for YouTube/Vimeo videos, shortcode override metabox) and Variation Galleries (depend on it). [product-galleries]
- Global Tabs (Products > Product Tabs, block-editor content, display rules, priority; Description 10, Reviews 30). [enable-and-add-global-tabs]
- Advanced Reviews (titles, voting, overview chart, featured, load more, conversion of old reviews; disabling hides reviews created with it). [advanced-reviews]
- Conditional Cart Banners (WooCommerce > Cart Banners; `{cart_difference}`, `{cart_total}`), Checkout Coupon Modal (classic checkout only), Size Charts, Affiliate Product Options (new tab), Variation price display (range, lowest, highest). [conditional-cart-banners, checkout-coupon-modal, size-charts, open-affiliate-external-products-in-new-tab, set-variation-options]

Kadence Blocks / Pro / Creative Kit items to check against the baseline (docs carry no version numbers, so "newer" cannot be proved from them):
- Gallery (Adv) Mosaic type with Row Height and Gutter (Pro) and Thumbnail Slider; skill already lists `mosaic` and `thumbslider`. [advanced-gallery-block]
- Product Carousel "Do Not Loop" and "Show Pause Button"; Testimonials "Rewind" carousel type; Navigation "Activate Anchor on Scroll". Skill has the related attributes (`enableScrollSpy`, `showPauseButton`) but not "Do Not Loop" or "Rewind". Treat as possibly newer than 3.9.1 / 2.8.16 until checked. [product-carousel-block, testimonial-block, kadence-navigation-advanced-block]
- Kadence CAPTCHA (separate premium plugin) and Kadence Custom Fonts plugin. [cloudflare-turnstile-form-adv-block, custom-fonts-kadence-blocks]
- Third-party: GiveWP Form block (GiveWP plugin, not Kadence). [form-block]

## 3. Theme, Customizer and Theme Kit Pro
Checked by grep against `SKILL.md` and `references/*.md`. Items the skill already holds (for example `header_mobile_switch` 1024, fixed placement values, `kadence_element_display`, palette option names) are left out.

##### 2.1 Customizer panels and paths
- Theme Kit Pro Header/Footer Scripts: Customize > Custom Scripts has three fields: Header, after the opening body tag, Footer. Code must be wrapped in `<script>` tags. [add-custom-css-and-scripts-using-kadence, add-scripts-in-header-footer]
- Customize > General > Comments: "Move Comments input above comment list" and "Remove Comments Website field". [customize-kadence-comment-form]
- Customize > General > Sidebar > "Enable Sticky Sidebar", plus an option to make only the last widget sticky. [sticky-sidebars]
- Customize > General > Scroll To Top: "Enable Scroll To Top", with a Design tab. [scroll-to-top]
- Customize > General > Social Links holds the URLs. The network list includes Bluesky, Threads, Mastodon, X, Google Reviews, Rumble, Facebook Group, Phone and Email, plus Custom 1-3 (the footer doc says Custom 1-4). [social-media-icons-header, customize-the-kadence-footer]
- Customize > General > Breadcrumbs. Other breadcrumb engines: Yoast, RankMath, SEOPress (the plugin must be installed). [theme-breadcrumb-settings]
- Customize > General > Layout holds Content Max Width, Narrow Layout Content Max Width and Archive Grid Boxed Spacing. [archive-layout-customizer-settings]
- Posts/Pages Layout > Single Post Layout: "Show Post Author Box?", style Normal or Center, "Use Author Archive Link". Shows on single posts only. Social links come from the user profile section "Extra profile information for author box". [add-author-box-to-posts]
- Per-category colours: set on the category edit screen; they apply only to the Post Item Category element. Uncoloured terms inherit the Customizer colours. [archive-layout-customizer-settings]
- Archive, Search and Page title "Title Elements" can be shown, hidden and dragged into a new order. [page-layout-customizer-settings]
- Page Layout extras: Content Vertical Spacing; Featured Image Position Above, Behind or Below; "Use Featured Image for Background?" (Above Content layout only). [page-layout-customizer-settings]
- Post item image ratios: Inherit, 1:1, 4:3, 3:2, 16:9, 2:1, 4:5, 3:4, 2:3. Category styles: Normal, Pill, Underline. [archive-layout-customizer-settings, search-results-customizer-settings]
- The Excerpt Word Count is ignored when a post has a manual excerpt. [archive-layout-customizer-settings]
- Header > Primary (or Secondary) Navigation > "Dropdown Options" sets dropdown general and design settings. The same navigation section has an "Open on" setting (hover or click) for mega menus. [style-dropdown-menu, mega-multicolumn-menu]
- Customize > Header > Sticky Header > Mobile Sticky holds the tablet/mobile sticky settings. [sticky-header]
- Disabling the page title removes the page H1, so add an H1 block. Per page: Page Settings > Page Title > DISABLE or ENABLE. [remove-the-page-title]
- Site icon: Customizer > Site Identity > Site Icon, at least 512x512. [theme-style-guide, set-site-favicon]

##### 2.2 Header and footer builder
- Header Addons item list in the doc (13): Account, HTML 2, Third Navigation, Fourth Navigation, Divider, Divider 2, Divider 3, Search Bar, Widget area, Contact, Button 2, Toggle Widget Area, Mobile Navigation 2. Not every item exists in both the desktop and the mobile builder. [header-addons]
- Account item: Account Label, "Label/Icon/Image URL", a menu in the Logged In Account location, and a LOGGED OUT VIEW tab. [add-a-login-and-account-menu]
- Toggle Widget Area (Pro): a desktop-only hamburger that opens an off-canvas widget area, with a "Trigger Menu" text. [add-toggle-open-menu-for-desktop]
- Cart item (free): "Cart Click Action" Link, Popout Cart or Dropdown Cart. Pro adds a free-shipping notice: "Amount needed for Free Shipping" and "Cart Notice Message" with the `{cart_difference}` placeholder. The notice only displays; it does not enable free shipping. [add-mini-cart-to-header]
- The header can hold up to 4 menus on desktop and 2 on mobile. Menu locations: Primary, Secondary, Mobile, Footer. Pro adds Third, Fourth, Mobile Secondary, Logged Out Account and Logged In Account. [add-edit-wordpress-menus]
- A Header Button item can choose the Base, Secondary or Outline global style. [style-buttons]
- Mobile Navigation item: Select Menu, Items Vertical Spacing, "Collapse sub menu items?", "Entire parent menu item expands sub menu". Its Item Divider style "X" means no divider. [customize-mobile-navigation-area]
- Trigger item: Menu Label, 3 icon choices, Trigger Style Default or Bordered. [customize-mobile-navigation-area]
- Off Canvas: Layout Fullwidth (animation Fade, Scale or Slice) or Side Panel (Slide-Out Side, "Move Body with toggle?", which the doc warns can hurt mobile performance), Panel Width, Content Max Width, Content Align, Content Vertical Align, Close icon size, colours and padding. [customize-mobile-navigation-area]
- In the sticky state, sticky styles override transparent styles. The doc gives the full transparent and sticky colour lists (Contact, Search Bar, Button2, Divider 1-3, HTML2, Account, Toggle Widget, and others). [customize-kadence-header]
- The Transparent Header has per-page-type disable toggles, and per-post "Transparent Header" Default, Disable or Enable; the per-post value wins. [customize-kadence-header, use-transparent-header]
- The transparent header wrapper is `header#masthead.site-header`. Offset it with Container Min Height (Above Content title) or with top padding on the first block. [prevent-transparent-header-from-overlapping-content]
- Footer Design tab has an option to keep the footer at the bottom of the screen. Footer rows: Number of Columns, Layout per device, Column Direction (Column or Row), Column Spacing, Widget Spacing, Top and Bottom Spacing, Link Style, Column Border. [customize-the-kadence-footer]
- Footer Copyright placeholders: `{copyright}`, `{year}`, `{site-title}`, `{theme-credit}`. They do not render in a Replace Footer Element; use Dynamic Content "Current Year" and "Site Title" there instead. [customize-the-kadence-footer, replace-the-footer]
- Footer widget area "Footer N" in the builder is "Widget N"; Appearance > Widgets lists Footer Widgets 1-6. [customize-the-kadence-footer]
- Social item design: Social Style Filled or Outline; Brand Colors yes, no, on hover or until hover; a custom SVG or image can replace an icon. [customize-the-kadence-footer]

##### 2.3 Layouts
- The theme uses layout settings instead of page templates. CPTs get "{CPT} Layout" and "{CPT} Archive" sections with the same structure as posts. [post-page-archive-layout-settings]
- The Theme Kit Pro term edit screen adds "Above Header Background Image" (needs Above Content title) and "Archive Columns". [archive-custom-settings]
- The Hero/Title section is set globally under Posts/Pages Layout and per post with "Show Page Title" or "Show Post Title" Disable. A custom hero built in content does not work on archives; use an Element there. [control-the-hero-or-title-section-sitewide-and-per-page]

##### 2.4 Typography, palette, buttons, dark mode
- Customizer typography Clamp: Colors & Fonts > Typography > Font Size > toggle icon > "Clamp Settings". It has a Font Size Range (min/max, px or rem) and a Screen Size Range (min/max, px only), and the theme generates the `clamp()` (example `clamp(16px, 0.75rem + 0.8333vw, 22px)`). It is available on Base Font, headings and Buttons. [css-clamp]
- Palette groups in the UI: Accent (Accent, Accent - Alt, Accent - Complement), Contrast (Strongest, Strong, Medium, Subtle Text), Base (Subtle Background, Lighter Background, White or Offwhite), Notices (Success, Info, Alert, Warning, Rating). [theme-color-palette]
- Accent - Complement is linked to Accent by default and shows an outline while linked; an "Unlink Color" button makes it independent. [theme-color-palette]
- The black folder icon next to the palette opens Selectable Palettes (they overwrite the current colours) and an Export/Import tab. [theme-color-palette]
- Default example hexes: Accent #40645c, Alt #253b35, Complement #5a7d74; Contrast #1a202c/#2d3748/#4a5568/#718096; Base #edf2f7/#f7fafc/#ffffff; Success #38a169, Info #3182ce, Alert #e53e3e, Warning #dd6b20, Rating #ecc94b. [theme-color-palette]
- Style Guide: an icon at the top left of the Customizer. It has five sections (Site Title & Logo, Site Icon, Colors, Typography, Buttons), and hovering an item shows a pencil that jumps to its setting. [theme-style-guide]
- Buttons: Customizer > Colors & Fonts > Buttons. Each style has Button Shadow and Hover Shadow (colour, X, Y, blur, spread). Secondary inherits the Base shadow until its "Disable Box Shadow" toggle is turned off. Secondary/Outline Font and Padding must be enabled with a toggle. [style-buttons]
- Advanced Button "Button Inherit Styles": Fill (only text and background from Base), Outline, Theme Base, Theme Secondary. Overriding one property keeps the other inherited ones. A core Button gets Fill or Outline. [style-buttons]
- Dark mode settings labels: Enable Color Palette Switch, Default Color Palette, OS Aware, Dark Color Palette, "Different Logo for Dark Mode?" (Dark Mode Header Logo, "Different Logo for Mobile?"), "Show Fixed Switch?" (Switch Type, Switch Style Switch or Button, Align, Side and Bottom Offset, Light and Dark Mode Icon, Switch Colors, Text Label Font, Light and Dark Palette Title, Visibility). [color-palette-switch-dark-mode]
- The dark mode module does not generate dark CSS. Unpaletted plugin styles need `.color-switch-dark .x {}` CSS. [color-palette-switch-dark-mode]
- The footer builder has a "Dark Mode Toggle" item (Pro) with Light and Dark Palette Title fields, described as helping accessibility. [customize-the-kadence-footer]
- Kadence Custom Fonts plugin: Appearance > Kadence > Custom Fonts > "Add A New Custom Font".
  - Font Type "Upload File": Font Family Name, Font Specific Style Name, woff2/woff files (optional ttf/eot/svg), Fallback Font Stack, Font Weight, Font Style, "Load Display Swap?".
  - Font Type "Adobe Type Kit": Project ID.
  - A variable font is stored as one static weight per entry.
  - CJK Typekit fonts need Adobe's script added through Pro Custom Scripts (footer). [custom-fonts]
- Typography "Inherit" means the element follows the Base Font or the Heading Font Family. [typography-settings]

##### 2.5 Elements: types, placements, conditions
- Content Section placement groups as labelled in the UI: BODY, HEADER, CONTENT WRAP, ABOVE CONTENT HERO TITLE, CONTENT AND SIDEBAR, SINGLE INNER CONTENT, INSIDE THE CONTENT, COMMENTS, ARCHIVE INNER CONTENT, FOOTER, 404 PAGE, MOBILE MENU OFF CANVAS AREA, HEADER ACCOUNT LOGIN MODAL, CUSTOM. [content-section-hooked-elements]
- HTML Editor element adds a "Scripts" group: Header (inside `<head>`), After body tag opens, Footer (before `</body>`). [html-editor-hooked-elements]
- Fixed Section width options: 100% (default), auto, or fixed (px). Position and X/Y Distance From Edge apply only to auto or fixed. "Scroll Down Distance Till Appear" defaults to 300 and accepts 0-30,000. [fixed-section-hooked-elements]
- "Fixed On Bottom" is always full width and can block clicks and hovers at the bottom of the page. [fixed-section-hooked-elements]
- Display "Show On" list in the UI: Entire Site, Front Page, Blog Page, Search Results, Not Found (404), All Singular, All Archives, Author Archives, Date Archives, Paged, Single Post, Category Archives, Tag Archives, Single Pages, Single Products, Brand Archive, Product Category/Tag Archives, Product Brand Archives (Shop Kit), Events Archive, Single Events, Events Category Archives, Products Archives, Products Search. [content-section-hooked-elements]
- For a CPT, "Select CPT By" offers All (default), Individual or Grouped (by taxonomy term). [build-custom-post-types-with-template-elements-in-kadence]
- A tag or category appears under "Select Posts By:" only if at least one published post has it. [use-element-hooks]
- Priority: a higher number on the same hook prints later. [use-element-hooks]
- Preview Setup: without a preview post type and post, dynamic text shows "No Content" in the editor. [element-settings]
- The Admin Toolbar shows the number of Elements on the current page; hovering lists them with edit links. [use-element-hooks]
- The Element type can be switched later from "Element Type"; recheck placement and display after a switch. [switching-element-types]
- Template Elements do not override WooCommerce loop items, single products or product archives; that needs Kadence Shop Kit. [create-a-template-element]
- Replace Archive Content overrides title plus loop and most Archive Layout settings; Replace Archive Loop Content keeps the title area. [create-a-template-element]
- Query Loop (Adv) "Show Related Posts" works only for Posts with categories/tags. [create-a-template-element]
- "Replace Sidebar" does nothing unless the post type uses a sidebar layout. [replace-post-sidebar]
- The Replace Footer doc recommends a Row Layout with Structure Settings HTML tag `<footer>`, a Site Identity block and Advanced Navigation. Footer builder settings do not apply to a replaced footer. [create-a-template-element, replace-the-footer]
- A mega menu needs a Content Section Element with Display "Entire Site". Steps: Menu Item Settings > Mega Settings (columns, Dropdown Background), then on a child item "Enable Custom Content" and choose the Element. The settings button may appear only after saving the menu. [mega-multicolumn-menu]
- Ultimate Menu "Disable Link" removes `href`. The PageSpeed Insights warning that results is expected and can be ignored. [mega-multicolumn-menu]
- Dynamic Content "Page Title" on a search page outputs "Search Results For: <term>". [dynamic-search-results-title]
- Dynamic Content support: official support for ACF and Meta Box; it often also reads other field plugins. [build-custom-post-types-with-template-elements-in-kadence]

##### 2.6 Hooks and filters (exact names)
- Hooks missing from the skill: `before_kadence_logo_output`, `before_kadence_mobile_logo_output`, `kadence_main_footer`, `kadence_mobile_bottom_header`, `kadence_woocommerce_before_shop_loop_top_row`, `kadence_woocommerce_after_shop_loop_top_row`, `kadence_tribe_events_header`, `kadence_tribe_events_before_main_tag`, `kadence_tribe_events_after_main_tag`. [theme-hooks]
- Blocks Pro Post Grid/Carousel hooks: `kadence_blocks_post_loop_start`, `_header`, `_header_meta`, `_content`, `_footer_start`, `_footer_end`, `_end`. An Element on Custom Hook `kadence_blocks_post_loop_content` replaces each loop item. To target one grid, use `add_action('kadence_blocks_post_loop_start', fn($attributes) ...)`, check `$attributes['className']`, then echo the element shortcode. [post-grid-carousel-using-kadence-element]
- `kadence_woomail_order_body_text` ($body, $order), priority 15, 2 args: custom placeholders in Kadence WooCommerce Email Designer. [common-code-snippets-for-kadence-users]
- `theme_mod_post_related` (core `theme_mod_{name}` filter): return false to disable related posts on chosen post IDs. [common-code-snippets-for-kadence-users]
- `kadence_post_navigation_args`: `in_same_term` = true, and `prev_text`/`next_text` with `%thumb` plus `previous_post_link`/`next_post_link` filters for thumbnails. Uses `Kadence\kadence()->get_icon('arrow-left-alt')`. [common-code-snippets-for-kadence-users, add-thumbnails-to-next-previous-post-navigation]
- `kadence_pagination_args` passes args to `the_posts_pagination()` (`prev_text`, `next_text`, `mid_size`, `screen_reader_text`). [customize-pagination-using-kadence_pagination_args]
- Related posts default: up to 6, sharing categories or tags, random order, current post excluded. `kadence_related_posts_args` takes WP_Query args (`tax_query`, `author`, `post_type` array, `category__not_in`). [customize-related-posts-with-kadence_related_posts_args]
- `kadence_svg_icon` ($output, $icon, $icon_title, $base), priority 10, 4 args; icon class pattern `kadence-<name>-svg`. [change-theme-icon-to-something-custom]
- `kadence_scroll_to_id_additional_offset` ($offset int, default 0) changes only the offset, not the speed. [adjust-kadence-themes-scroll-offset-using-a-filter]
- `kadence_microdata` with `__return_false` overrides the Customizer toggle; the code lives in `inc/components/microdata/component.php`. [disable-default-kadence-theme-schema-markup]
- `kadence_post_layout`: `$value['transparent'] = 'enable'` on `is_404()` forces the transparent header on 404 (off there by default). [enable-transparent-header-on-404-page]
- JS event `kadenceJSInitReload` fires on `document` after Kadence reloads content (infinite scroll). Re-bind observers on it. [extend-kadence-infinite-scroll-with-dynamic-post-content]
- `kadence_element_display` examples use priority 20 with 3 args (subcategory, `$_GET` value, date window). [display-kadence-hook-elements]
- Custom Hook placement only attaches to an existing hook; it does not create one. [use-element-hooks]

##### 2.7 Officially recommended snippets (PHP, CSS, JS)
- Code goes in a child theme `functions.php` or the Code Snippets plugin; the docs repeatedly link "How to add a custom filter or function with Code Snippets".
- PHP: after paragraph N, use `the_content` with `explode('</p>')` and `do_shortcode('[kadence_element id="N"]')`, counting positions from 0. [add-elements-after-specified-paragraphs]
- PHP: `register_taxonomy_for_object_type('category'|'post_tag','page')` on `init` adds categories and tags to pages. [enable-categories-and-tags-for-pages]
- PHP: `comments_open`/`pings_open` `__return_false`, and `comments_array` `__return_empty_array`, turn comments off. [turn-off-comments]
- CSS: Kadence is desktop-first; tablet `@media (max-width:1024px)`, mobile `@media (max-width:767px)`. [specify-different-css-styles-for-mobile-tablet-and-pc-layouts]
- JS: WooCommerce `added_to_cart` and `removed_from_cart` jQuery events on `document.body`. [track-woocommerce-cart-actions-with-javascript]
- Block CSS: Row/Section Advanced > Custom CSS uses the `selector` keyword and has an "Edit In Modal" button. Blocks Pro "Page Scripts" (K icon) takes CSS without `<style>` but scripts need `<script>`. [add-custom-css-and-scripts-using-kadence]

##### 2.8 Performance (Customize > General > Performance)
- "Enable Optimized Group Block" was introduced in Theme 1.2.1. The doc describes it as exposing extra layout controls on the core Group block. [performance-settings]
- "Enable Lightbox" adds lightbox behaviour to the core Image, core Gallery and Kadence Image (Adv) blocks. [performance-settings]
- "Enable CSS Preload" loads CSS earlier and reduces flashes of unstyled content; the doc says to test it with other performance tools. [performance-settings]
- Local Google Fonts: a one-time fetch, then served locally. "Preload Local Fonts" is optional; a "Flush Local Font Files" button re-downloads them. The docs frame it as helping GDPR and CLS. [host-google-fonts-locally]
- Maintenance doc: Customizer > Performance > "Disable Default Sitemap" (re-enable it at launch). [maintenance-mode]

##### 2.9 Theme Kit Pro modules
- The addon list as worded: Header Addons ("Adds 20 elements"), Conditional Headers, Ultimate Menu, Header/Footer Scripts, Hooked Elements, WooCommerce Addons, Infinite Scroll, Color Palette Switch (Dark Mode), Local gravatars, Archive custom settings. Maintenance Mode is not listed there but has its own doc. [theme-kit-pro-plugin]
- Conditional Headers: a new header is created with Start Basic, Copy Default or Import. User Settings default to none, so the header shows to no one until set. Expires has a reset link. Menus are global, so give each header its own menu. [conditional-headers]
- Infinite Scroll: Customize > General > Infinite Scroll has "for Blog", "for Search", "for Products", "for Custom Post Types" and "End of Content Text". [infinite-scroll]
- Maintenance Mode:
  - The admin page is Dashboard > Kadence > Maintenance Mode.
  - The Maintenance type returns 503 and Coming Soon returns 200. Start from a template or Start Blank (doc tip: Row Layout min height 100vh).
  - Settings: Page Background Color; Display Priority (the highest shows); User Exceptions (roles who see the live site; default Administrators; logged-in or logged-out based); Expires.
  - It skips the Header/Footer Scripts, does not hide the WooCommerce Store Notice, and needs the block editor (not the Classic Editor). [maintenance-mode]
- WooCommerce Addons:
  - Catalog Off Canvas Sidebar (also a widget area in Appearance > Widgets) and its Settings.
  - Add to Cart Behavior: "Show the cart popout on add to cart?" (needs the header Cart set to popout) and "Single Product Ajax Add to Cart".
  - Single Product: Sticky Add To Cart. Product Catalog: Custom Shop Page. [woocommerce-addons, open-side-cart-when-product-is-added-to-cart]

##### 2.10 WooCommerce theme settings (Customizer > WooCommerce; none of this is in the skill)
- Single Product Layout:
  - Above Content Layout: breadcrumbs, nothing, or Extra Title Area (with title container width, align, min height and Above Elements Breadcrumbs/Category/Above Title).
  - Product Layout Normal, Narrow, Fullwidth or Sidebar; Content Style; Content Vertical Spacing.
  - Product Elements: Category, Title, Rating, Price (with a shipping statement), Excerpt, Add to cart (size normal, medium-large or large), Extras (icon features), Payments (display only: Stripe, Visa, Mastercard, Amex, Discover, Link, Paypal, Apple Pay, Google Pay; inherit or gray), Product Meta, Share (Kadence Simple Share).
  - Use Custom Quantity Plus and Minus; Product Variation Display horizontal or vertical; Tab Style normal or center; show default tab headings; Weight and Dimensions; Related Products and its columns. [woocommerce-customizer-settings]
- Product Catalog:
  - Title settings; Align Button at Bottom.
  - Shop Page display and Category Display (Products, Categories, or both).
  - Default Product Sorting: Popularity, Average Rating, Most Recent, Price ASC or DESC.
  - Products Per Row; Rows Per Page; Custom Shop Page.
  - Archive Active Filters: add active filters to the shop, and a remove-all button.
  - Add Off Canvas Widget Area (Toggle Icon, Toggle Label).
  - Mobile Columns Layout 1 or 2.
  - Archive button colours, border, font and shadow. [woocommerce-customizer-settings]
- Product Catalog > Product Image Hover Switch: Fade, Slide, Zoom, Flip; uses the first gallery image. [add-image-switch-on-hover-for-product-archives]
- Store Notice: text; Enable; Placement (hang over top, above, bottom); Disable Dismiss Button; font and background colour. [woocommerce-customizer-settings]
- Product Images: Main Image Width, Thumbnail Width, Thumbnail Cropping (1:1, custom or uncropped). [woocommerce-customizer-settings]
- Checkout: company, address line 2 and phone fields each optional, hidden or required; asterisk on required fields; Privacy Policy page; Terms page; privacy text. [woocommerce-customizer-settings]
- My Account Layout: Show User Name and Avatar; Navigation Layout left, above or right. [woocommerce-customizer-settings]

## 4. Blocks and Blocks Pro guides
##### Query Loop (Adv) [Pro]
- Filter `kadence_blocks_pro_query_block_split_character` (no args, returns a string) changes the character that splits filter values (default `,`), for example to `|` for values such as "Paris, France". It applies to every Query Loop on the site. The new character must not appear in field values [split-character-filter-query-loop-adv-block].
- JS event `kb-query-loaded` fires on `document` after AJAX loads, pagination, filter apply or reset, infinite scroll and sort changes. The event has a `qlID` property that identifies the loop [run-javascript-when-query-loop-adv-updates].
- REST endpoint `/wp-json/wp/v2/kadence_query/query`. Whitelist it in security plugins and WAFs (Cloudflare, Sucuri) [troubleshoot-query-loop-adv-filters-and-search].
- To exclude the Query Loop script from JS delay or defer, exclude `/wp-content/plugins/kadence-blocks-pro/dist/query.js` [troubleshoot-query-loop-adv-filters-and-search].
- Page caches must not ignore Query Loop URL parameters (for example `?author=1&category=32`). Whitelist the parameters or exclude the page from the cache [troubleshoot-query-loop-adv-filters-and-search].
- UI reindex: Dashboard > Kadence > Queries > "Force Reindex" button. Use it when taxonomies or custom fields are missing from filters [troubleshoot-query-loop-adv-filters-and-search].
- Query Loop (Adv) cannot use indexing on password-protected pages [advanced-query-loop-block].
- Duplicate loops and cards with the Duplicate row action under Kadence > Queries and Kadence > Query Cards. Both are synced CPTs, so you need a duplicate to make an independent variant [advanced-query-loop-block].
- The Query Card source can be a new card, an existing card, an Element (Template Element) or a Woo Template (Product Loop) [advanced-query-loop-block].
- General controls: Description, "Inherit query from template", "Show Related Posts" (same category; posts and Woo products only), Post Types (multi), Limit by Taxonomy, Order By, Offset Starting Item, Allow Sticky Posts (sticky stops applying once filters are used), results per page, Select Specific Posts, Infinite Scroll, "Compare Multiple Filters With" and/or [advanced-query-loop-block].
- Order By values: Newest to Oldest, Oldest to Newest, Modified Asc/Desc, A–Z, Z–A, Menu Order (+Reversed), Custom Field (+Reversed; then Custom Field Key and Data Type Text/Number/Date), Random. Menu Order does not apply to posts [advanced-query-loop-block].
- Style controls: Loading Animation (Overlay, Loader, Flip, Cover, Shrink, None), Masonry, and shared Filter Fields, Filter Labels and Filter Radio/Checkbox Labels style groups with Input Size S/M/L [advanced-query-loop-block].
- Query Card controls: Columns with Row Gap and Column Gap per device; background, border and radius in Normal and Hover; "Block Name" in Advanced [advanced-query-loop-block].
- Filter blocks: Filter – Search, Filter – Dropdown, Filter – Checkboxes, Filter – Buttons, Filter – Date, Filter – Range, Filter – Rating, Filter – Swatches, Reset Filters, Pagination, Result Count, No Results [advanced-query-loop-block].
- Filter Source is Taxonomy (include and exclude terms) or Post Meta (Post Type, Post Date, Post Modified Date, Post Title, Post author) [advanced-query-loop-block].
- Dropdown Order By: Name, Total Results, Term Order. Checkboxes and Buttons: Name, Total Results [advanced-query-loop-block].
- Display toggles: Show Result Count, Hide Items when Result Count is Zero, Display Inline, Limit Dropdown Items, Show Children, Hierarchical [advanced-query-loop-block].
- Filter – Buttons styles: Button Inherit Styles (Pill, Outline, Underline), size preset, width Auto/Fixed/Full, row and column gap [advanced-query-loop-block].
- Filter – Date logic "Display Posts": Before, Before or on, After, After or on, On Selection [advanced-query-loop-block].
- Filter – Range takes numeric values only. Sources: Taxonomy, Post Meta, or WooCommerce (Price, Sale Price, Regular Price, Average Rating, Stock Status, Sale Status). Display: Fields, Slider or Both. Slider Values Type: Below or None [advanced-query-loop-block].
- Filter – Rating has a rating icon, After Text, and Single or List icon display. Icon colour, selected colour, stroke colour and width [advanced-query-loop-block].
- Filter – Swatches filters by WooCommerce attributes. Swatch size per device; swatch border in Normal, Hover and Active [advanced-query-loop-block].
- Reset Filters: Inherit Styles (Fill, Outline, Theme), and "Show Icon and Text" or icon only [advanced-query-loop-block].
- Pagination: Results Per Page works only with "Inherit query from template" off. With it on, Settings > Reading "Blog pages show at most" applies. Prev/Next as Text or Icon; colours for Normal, Hover and Active [advanced-query-loop-block].
- Result Count: Include Search Value, Before Count, Count Through, Between Count ("of"), After Count, Thousands Separator [advanced-query-loop-block].
- No Results: shows "No Results Found" by default and hides cards and pagination while it shows. A toolbar Show/Hide Content toggle works in the editor. Only layout and content blocks are supported inside [advanced-query-loop-block].
- Filter Slug (Advanced tab of each filter) sets the URL parameter name. Without it the parameter is a hash such as `1140731708=1`. Set slugs to make shareable pre-filtered links [advanced-query-loop-block].
- A Modal block placed inside the Query Loop works only inside a Section that is inside the main Query Loop. Show the filters with "Show Modal Content". Recipe: a sidebar layout with the filters in one Section (Hide On Mobile) and a Modal in another Section (Hide on Tablet and Desktop) [popup-modal-filters-advanced-query-loops].
- Search results template: a Template Element with Placement "Replace Archive Content", Show On "Search Results", and Query Loop (Adv) set to "Inherit query from template" [custom-search-page-hooked-elements-advanced-query-loop].
- The "All" button text in Button filters comes from the `kadence-blocks-pro` text domain. Change it with `gettext` (match `'All'` and that domain) [change-the-query-loop-adv-all-button-text].
- Find `$ql_id` by hovering the edit link under Kadence Blocks > All Queries [custom-queries-advanced-query-loop].
- Recipes on `kadence_blocks_pro_query_loop_query_vars` (`$query, $ql_query_meta, $ql_id`, priority 10, 3 args): tax_query, date_query, meta key/value, comment_count, category__not_in, author/author__in, related by custom taxonomy, in-stock (`_stock_status`), on-sale (`wc_get_product_ids_on_sale()`, `post__in [0]` when empty), and Relevanssi (`$query_args['relevanssi']=true` when `s` is set) [custom-queries-advanced-query-loop].
- Relationships: ACF `get_field()` gives `post__in` plus `orderby post__in`. Metabox uses `MB_Relationships_API::get_connected(['id'=>…,'to'=>get_the_ID()])` and `post__in [0]` when empty [display-acf-relationship-fields-query-loop-adv-block].

##### Posts, Post Grid/Carousel and Portfolio Grid
- Free Posts block: filter `kadence_blocks_posts_query_args` (`$args`, 1 arg). The examples target a page with `get_the_ID() === PAGE_ID` [custom-queries-for-posts-block].
- Post Grid/Carousel [Pro]: filter `kadence_blocks_pro_posts_grid_query_args` (`$args, $attributes`, 2 args). Target one instance with a class in `$attributes['className']` (Advanced > Additional CSS class(es)) [show-multiple-post-types-post-grid-carousel-block, use-a-post-grid-carousel-block-as-related-posts].
- Portfolio Grid/Carousel [Pro]: filter `kadence_blocks_pro_portfolio_grid_query_args` (`$args, $attributes`) [custom-queries-for-portfolio-grid-carousel-block].
- Action `kadence_blocks_post_loop_header` (`$atts`). Priority 25 prints after the title in Post Grid items (shown with `tribe_events_event_schedule_details`) [showing-events-post-grid-carousel-block].
- Related-posts recipe: hide theme related posts (Customizer > Post/Pages Layout > Single Post Layout > Show Related Posts), then add a Content Section Element with Post Grid, hooked Before Comments on Single Posts. The filter copies theme logic: category OR tag tax_query, exclude current, same post type, `orderby rand` [use-a-post-grid-carousel-block-as-related-posts].

##### Form (Adv) and Form
- JS events: Form (Adv) uses `kb-advanced-form-success` on `document.body`, with `event.detail.uniqueId`; the form element has class `wp-block-kadence-advanced-form<uniqueId>`. Legacy Form uses `kb-form-success`, with `event.detail` as the id and class `kadence-form-<id>`. Use the HTML Anchor to target one form [run-javascript-after-form-submitted, google-analytics-form-adv-block].
- Officially recommended GA4 pattern: listen to the success event, match the anchor, then `gtag('event','form_submission',…)`. Add the script with Code Snippets (footer) or a Theme Kit Pro HTML Element [google-analytics-form-adv-block].
- Reject filter signature: `apply_filters( 'kadence_blocks_advanced_form_submission_reject', false, $form_args, $processed_fields, $post_id )`. Return true to stop the submission. Set the message with the nested filter `kadence_blocks_advanced_form_submission_reject_message` (`$message`). Rejected submissions are not saved and not emailed [set-conditions-for-form-adv-submissions, form-adv-block-disallowed-comment-keys].
- `$processed_fields` items carry `name`, `value` and `type`. Match by field name (Advanced > Extra Settings > Field Name, attribute `inputName`), not by label [set-conditions-for-form-adv-submissions, form-adv-submit-actions-filter].
- Submit action keys for `kadence_blocks_advanced_form_actions` (`$actions, $form_args, $processed_fields, $post_id`, 4 args): `mailerlite`, `fluentCRM`, `sendinblue` (Brevo), `mailchimp`, `convertkit`, `getresponse`, `activecampaign`, `webhook`. Remove with `array_search` plus `unset`; limit by `$post_id` [form-adv-submit-actions-filter].
- Options for select, radio and checkbox fields cannot use Dynamic Content. The official workaround is core `render_block_data` (3 args, priority 20): when `$block['attrs']['inputName']` matches, set `$parsed_block['attrs']['options']` to an array of `['value'=>…,'label'=>…]` [populate-field-values-programmatically-form-adv].
- Upload directory filter `kadence_blocks_advanced_form_upload_directory` receives a `$param` shaped like WP `upload_dir` (path, url, subdir, basedir, baseurl). The default is `uploads/kadence_form/YYYY/MM/` [custom-upload-directory-form-adv-block].
- Email template override: copy `kadence-blocks/includes/templates/form-email.php` (header `@version 1.7.0`) to `yourtheme/kadence-blocks/form-email.php`. The folder name must be exactly `kadence-blocks`. Styles stay inline [override-form-email-template].
- Database Entry [Pro]: enabled per form. Entry Settings: Form Name (legacy Form only), Save User IP Address and Save User Device, both on by default. View entries under Kadence > Form Entries (Filter By Form, Export CSV, View, Trash) [database-entries-form-adv-block].
- Auto Respond Email [Pro] fields: Email Subject, Email Message, From Email, From Name, Reply To, Cc, Bcc, "Send as HTML email?", and "Override Email to Address" (blank sends to the submitter) [auto-responder-form-adv-block].
- Webhook [Pro]: Webhook URL plus Map Fields. Form (Adv) adds it under Submit Actions; legacy Form uses "Actions After Submit" [webhooks-form-adv-block].
- FluentCRM (free): Select List, Select Tags, Map Fields, optional Double Opt In [fluentcrm-form-advanced-block].
- MailerLite: API token, Group, field mapping [mailerlite-form-advanced-block]. Brevo [Pro]: API key, List, attribute mapping [brevo-form-adv-block]. Mailchimp [Pro]: API key, Audience, Tags, Groups, fields [mailchimp-form-adv-block]. Kit [Pro]: V3 API key, Form or Sequence, Tag, fields [kit-form-adv-block].
- hCaptcha is free: add a CAPTCHA block from the Misc tab inside Form (Adv). CAPTCHA TYPE hCaptcha takes a Site Key and Secret Key; Style offers Light/Dark theme and Normal/Compact size [hcaptcha-form-adv-block].

##### Kadence CAPTCHA (separate plugin, Nexcess licence)
- Settings > CAPTCHA. API Keys tab: CAPTCHA Type Google v2, Google v3 or Turnstile; Verify button. reCAPTCHA URL google.com or recaptcha.net; forced language; v3 Score Threshold 0.0–1.0 [captcha].
- Form Settings tab protects comments, login, lost password, registration, Woo checkout and Woo reviews. Design Settings: Light/Dark theme and Left/Center/Right alignment [captcha].

##### Row Layout, Section, spacing and units
- Divider filter `kadence_blocks_row_divider_paths` (`$paths`, keyed array). A value is a string of `<path>` elements only, with no `<svg>` wrapper (it shares `viewBox="0 0 1000 100" preserveAspectRatio="none"`), no gradients, masks, `<defs>` or external refs, and may use inline `style` opacity. The editor still shows the original shape; only the front end changes [add-modify-row-layout-svg-dividers].
- Global padding: adding a background to a Row Layout or Section applies the theme "Content Left/Right Edge Spacing" (Customizer > General > Layout) as left and right padding, but only if no padding was set before. The fields then show "Global"; reset restores it. Avoid it by setting padding None and saving as Block Default [block-padding-and-margin].
- A background on Text (Adv) auto-adds padding top 1.25em, bottom 2.375em [block-padding-and-margin].
- Sticky top overlay: an outer Section with two nested Sections; first Section Advanced > Sticky Settings > enable sticky [make-top-section-sticky-kadence-blocks].
- Section flex: Flex Direction (Vertical default, Horizontal, Vertical Reverse, Horizontal Reverse); Alignment (Start, Center, End, Stretch); Vertical Alignment (Top, Middle, Bottom, Space Between, Space Around, Space Evenly; it becomes left-to-right spacing in horizontal); Vertical Gap or Horizontal Gap; Wrap Content (Inherit, No Wrap, Wrap, Wrap Reverse); Flex Basis [flexbox-layouts-with-section-blocks].
- Flex Grow is under Section > Advanced > Structure Settings. It is set on child Sections (0, 1, 2) [flexbox-layouts-with-section-blocks].
- Row Layout vs Section: Row columns share height and support the theme Content Max Width; Section flex sizes to content [flexbox-layouts-with-section-blocks].
- Tooltips overlap: tooltips stay inside their parent container for screen readers. Set z-index on sibling Sections (Advanced > Structure Settings), for example 2 and 1 [tooltips-kadence-blocks].
- 100vh on phones may exceed the visible area; use about 90vh in mobile settings [units-of-measure].
- Presets are separate per category: an SM gap is not an SM font [units-of-measure].

##### Text (Adv)
- HTML Tag options: H1–H6, Paragraph, Span, Div. Link Style: Unset, None, Underline, Underline on Hover. Dynamic link has new tab, nofollow and sponsored [advanced-heading-block].
- Text Orientation: Horizontal, Stacked Vertically, Sideways Down, Sideways Up (CSS `writing-mode`) [advanced-heading-block].
- Font sizes are capped, so very large values are limited [advanced-heading-block].
- Icon in text: location, vertical alignment (Unset, Baseline, Center, End, Start), size, colours, padding, and "Title for Screen Readers" [advanced-heading-block].
- Highlight: Text Gradient and Background Gradient are mutually exclusive [advanced-heading-block].
- Screen Reader Text toolbar format hides the text visually but keeps it in the markup [advanced-heading-block].
- Typed Text: apply bold or italic before adding Typed Text, or it may break. Options: loop, shuffle, smart backspace, speed [advanced-heading-block].
- AI inline presets: Improve Writing, Fix Spelling & Grammar, Make Shorter, Make Longer, Simplify, Change Tone [advanced-heading-block].

##### Tooltips
- Supported blocks: Text (Adv) (toolbar format on selected text), Button (Adv), Icon, Icon List (bubble icon in the toolbar) [tooltips-kadence-blocks].
- Settings: Tooltip Placement; Link Settings (Text only); "Only Apply Tooltip To" Icon, Text or whole item (Icon List only); "Show Indicator Underline" (Icons and Icon List only; always on for Text) [tooltips-kadence-blocks].
- Tooltips have no SEO effect either way [tooltips-kadence-blocks].

##### Lottie
- Advanced: Max Width; "Use fixed ratio (prevents layout shift)" plus Size Ratio (%); Save as default. "Only Play on Page Scroll" overrides autoplay, speed, bounce, loop and hover, and does not preview in the editor [lottie-animation].

##### Google Maps
- The block ships a built-in key. Multiple markers need your own key (Maps JavaScript API plus Maps Embed API), a Map ID, and JS in Page Scripts (Footer) that targets `.wp-block-kadence-googlemaps` with `AdvancedMarkerElement`. Free users can use a Custom HTML block instead [multiple-markers-google-maps-block].

##### Kadence Block Controls (editor "K" icon)
- Sections: Color Palette ("Use Only Custom Colors" removes the theme palette from the editor; reload after enabling), Block Visibility (per-role setting visibility), Default Editor Block (Advanced Text as the default paragraph, preset to `p`), Import/Export Block Settings, Reset Block Defaults, Pexels Library Search toggle, Custom CSS Indicator (orange CSS icon on blocks that have custom CSS), Dynamic Content Settings "Always Show All Fields" [Pro], Page Scripts [Pro], Performance Optimizer, Design Library component access [block-controls, kadence-performance, access-the-design-library].
- Export lets you choose Block Defaults, Block Visibility Settings, or both, then "Download Export". Import uses "import settings from an export file". Reset uses the same two checkboxes plus the red Reset text [block-controls].
- Page Scripts [Pro] opens a modal with post or page Custom CSS and scripts for Head, Body and Footer. It works on CPTs too (Elements, Conversions, WooTemplates) [block-controls].

##### Performance Optimizer (free)
- Workflow: enable it in Block Controls, then use "Run Optimizer" per item in the post list and "Remove Optimization" to undo. Bulk actions optimise or unoptimise. An "Optimizer Status" list filter shows Optimized, Outdated, Excluded or Not Optimized. "Exclude this post from optimization" is set in the editor [kadence-performance].
- Re-optimises automatically when the post is updated. A post becomes Outdated after header or footer, Element or template, or global layout changes; fix it with remove and run again [kadence-performance].
- Supported: single posts, pages, Woo products, CPTs. Not supported: Hooked Elements, WooTemplates and other outside sources [kadence-performance].
- Features: lazy-load background images, smart image sizes, lazy-load HTML below the fold [kadence-performance].

##### Design Library
- Allow-list model: patterns load only from approved locations (Kadence's own, saved Pattern Hub connections, and code-registered ones). Otherwise you get the error "Invalid Request, Unknown Library" [add-a-custom-design-library].
- `kadence_blocks_custom_prebuilt_libraries`: each entry is an array of `slug` (lowercase, no spaces), `title`, `url`, `key`, `pages` (bool). It adds the tab and approves the URL; merge into the existing array [add-a-custom-design-library].
- `kadence_blocks_allowed_library_urls` (`$urls`) approves or removes a URL without adding a tab [add-a-custom-design-library].
- URL matching is by host: it covers all paths and subdomains, accepts only http/https, rejects look-alikes, and ignores trailing slashes and case [add-a-custom-design-library].
- Registration must run on every request (the library loads through background requests). Do not wrap it in `is_admin()`, `admin_init` or `current_screen`. The doc recommends an mu-plugin; snippets must be set to "Run Everywhere" [add-a-custom-design-library].
- Images from a private or logged-in library do not import [add-a-custom-design-library].
- Old content through Cloud Connect: wireframes `https://wire.kadenceblocks.com` key `wire`; starter sections `https://cloud.kadenceblocks.com/` key `section`; starter packs by role in Block Controls > Design Library [wireframes-starter-packs-sections-design-library].
- Filter `kadence_blocks_pattern_global_colors` returns an array of `--global-palette1..9` => hex for non-Kadence themes [customize-design-library-color-palette].
- Sync fails when the REST API is blocked or when outbound HTTPS or cURL is missing. Use the "Sync with cloud" refresh icon first [unable-to-access-library-database-error].
- Pattern categories: Hero, Cards, Columns, Media and Text, Counter or Stats, Form, Gallery, Accordion, Image, List, Location, Logo Farm, Team, Post Loop, Pricing Table, Slider, Tabs, Testimonials, Text, Title or Header, Menu, Video, Product Loop, Featured Products, Divider, Table of Contents. Filters: Layout, Components, Sort By. Page categories: Home, About, Contact, Services, Portfolio [access-the-design-library].
- Advanced settings: disable Custom Image Selection (wireframe images only) and disable Live Preview (image previews). Image Collections ("Use Images From", "Make My Own Collection", "Update My Design Library") [access-the-design-library].
- Role controls: "Show Design Library Button" and "Starter Packs Library" by role, under Block Controls > Components [access-the-design-library].

##### Header (Adv), Navigation (Adv), Navigation Link, Off Canvas
- Header and Section blocks (Top/Middle/Bottom Row; Left/Center/Right Section) are locked. The docs say unlocking can break the header [kadence-header-adv-block, advanced-header-navigations].
- General: Selected Header; Sticky and Transparent per device; Auto Spacing Under; Sticky Section (whole header or one row); Reveal On Scroll Up; Shrink Main Row; Min Height; Max Width [kadence-header-adv-block].
- Advanced: "Screen Size to Switch to mobile Header" (default 1024; Advanced > Structure Settings); Header Tag `<header>` or `<div>`; HTML Anchor; classes [kadence-header-adv-block, advanced-header-navigations].
- The switch applies only to the header. Inner blocks keep the Kadence breakpoints, so a nav reused in desktop and mobile with a custom switch can render vertically on desktop. Fix: duplicate the Navigation (Kadence > Navigations) and use the copy in Off Canvas [advanced-header-navigations].
- Backdrop Filter works only on transparent or semi-transparent colour or gradient backgrounds (set opacity in the colour picker). Options: Blur, Brightness, Contrast, Greyscale, Hue Rotate, Invert, Saturate, Sepia [kadence-header-adv-block].
- Header Row: Layout Config "Header Row" (Left, Center Left, Center, Center Right, Right) or "Single Container" (one container that can hold a Row Layout); Layout Width Standard, Full Width or Contained; Min Height; Item Gap; Vertical Alignment; Container Width; Conditional Display [Pro] on rows [kadence-header-adv-block, visual-builder-off-canvas-settings].
- Visual Builder: a toolbar toggle, Move to Top/Bottom, a Hide (X) button, and Desktop, Tablet/Mobile and Off Canvas tabs. A row gear opens Row settings [visual-builder-off-canvas-settings].
- Only one Off Canvas area per header, shared by all triggers. It appears only when a Trigger exists, and Navigation (Adv) alone has none [visual-builder-off-canvas-settings, advanced-header-navigations].
- Off Canvas controls: "Show Off Canvas Content in Editor When Not Selected"; Slide In From Left/Right; Content Width Partial/Full; Max Width; Content Max Width; Content Alignment and Vertical Alignment; close icon and size; Page Background overlay (opacity); close trigger styles; Close Trigger Spacing [visual-builder-off-canvas-settings].
- Trigger: icon (custom SVG is Pro), Icon Size, Icon Line Width, "Button Label Attribute for Accessibility", Normal and Hover colours and border [visual-builder-off-canvas-settings].
- Navigation Builder: opens when a nav is created, or later with "Open Navigation Builder". Tabs for post types, Add to Menu, + Custom Link, Add Sub Menu Link, drag to nest, Done. Desktop Orientation and Tablet/Mobile Orientation (mobile can be split in block settings) [kadence-navigation-builder, advanced-navigation-sub-menus-mega-menus].
- Toolbar icons on a Navigation Link: sub menu (arrow to three lines) and mega menu (arrow to rectangle). List View nesting also creates sub menus [advanced-navigation-sub-menus-mega-menus].
- Mega Menu, link Media (icon or image) and Highlight Labels are Pro; sub menus are free. Mega Menu Width options: Default, Content Width, Full Width, Menu Container Width, Custom Width. Pre-styled mega menu templates or Start Blank [navigation-link-block-tips, advanced-header-navigations].
- Highlight label is under Nav Link > Style > Highlight (Text or Icon). Description text sits under the label [navigation-link-block-tips].
- Do not use dropdowns or mega menus in navs outside a header (sidebar, footer) [advanced-header-blocks-vs-theme-builder].
- Migration: copy blocks from a theme mega-menu Element (List View, shift-select, Copy) into a Nav Link with Mega Menu, Start Blank, then paste [advanced-navigation-sub-menus-mega-menus].
- Header precedence: the Customizer "Enable a Block Header" / "Use Block Header" sets the global default (one only). A Hooked Element (Content Section, Placement "Replace Header") wins where its conditions match. The free manual method puts a Header (Adv) block first and turns on Post/Page Settings > "Disable Header" [use-advanced-headers-globally-conditionally].
- Duplicate headers from the Headers list with a hover action; name conditional ones clearly, for example "Header (Logged-In)" [use-advanced-headers-globally-conditionally].
- FSE themes: the header pattern editor offers "Replace with Kadence Header" [headers-footers-full-site-editing].

##### Misc
- SCRIPT_DEBUG true can make Kadence blocks render as HTML, break taxonomy limits in Post Grid, and give Row Layout extra columns (1 becomes 3). Fix: set it to false [block-errors-when-script-debug-is-enabled].
- Each Element has a shortcode, listed under Appearance > Kadence > Elements [insert-shortcodes].
- Gradient border needs CSS: `border-image` (no radius) or a two-layer background with `padding-box` and `border-box` (keeps radius) [gradient-border-section-block].
- Anchor IDs use letters, numbers, hyphens and underscores only [creating-anchor-links].

### 4.1 Extra facts from the individual block pages
Checked by grep against the skill references; "not in skill" means no matching term was found.

- Section Backdrop Filter options named: Blur, Brightness, Contrast, Greyscale, Hue Rotate, Invert, Saturate, Sepia + size slider; it needs a transparent or semi-transparent Section over content such as a Row image background. (Skill already has the feature as Pro in `blocks-pro.md:162`; the doc page does not mark it Pro.) [section-block]
- Section has an "Overlay Link" that makes the whole Section clickable (skill names the `link` attribute but not the UI label or its location in General > Flex Settings). [section-block]
- Section sticky fails with the "Collapse to Rows" row layout, with a vertical alignment set on the Section, or with parent Row "Inner Column Height 100%"; sticky CSS sits on an inner div. [section-block]
- Row Layout background "Force Background Image Inline" and "Row Content Only Editing" (replaces settings with a content selector; Modify returns to settings). [row-layout-block]
- Equal-height Info Boxes: Info Box A > Set Height to 100% plus parent Row A > Structure > Inner Column Height 100%. [info-box-block]
- Info Box SVG colour works only when the SVG is inline: SVG Support plugin Advanced Mode, target class `kt-info-svg-image`, Force Inline SVG; colours show on the front end only. [info-box-block]
- Info Box is not recommended inside Advanced Headers or mega menus; Navigation Link (title, icon, description) is the lighter replacement. Avoid Query Loop (Adv), Post Grid, galleries, heavy AOS and Typed Text in headers. [advanced-header-best-practices]
- Navigation Link Style Settings (link colours, typography, sub menu styles) need Blocks Pro, not only mega menus, media and highlight labels. [kadence-navigation-link-block]
- Navigation (Adv) imports a WordPress menu as a one-way copy (new links); edits do not change the WP menu. Navigations are managed at Kadence > Navigations. [kadence-navigation-advanced-block]
- Navigation (Adv) "Activate Anchor on Scroll" with Activation Offset Auto/Manual (per device) gives scroll-spy on anchor links. [kadence-navigation-advanced-block]
- Mega Menu Width options: Default (full), Menu Container Width, Content (header content width, or theme Max Width outside a header), Full, Custom Width. [kadence-navigation-link-block]
- Accordion FAQ schema allowed tags filter `kadence_blocks_faq_schema_allowed_tags` (string of tags; default a, strong, br, h2-h5, ul, li, ol, p; return '' to strip all). [accordion-block]
- Accordion pane HTML anchor makes `#anchor` URLs open that pane; Pane "Button Label Attribute" gives an accessible name for icon-only panes. [accordion-block]
- TOC excludes headings with class `toc-ignore`; filter `kadence_toc_exclude_classes_array`; Testimonial and Image Overlay titles are skipped by default; TOC block CSS sets a 30px bottom margin. [table-of-contents-block]
- Modal custom trigger needs both `href="#<Custom Open ID>"` and class `modal-trigger` on e.g. a Single Button; IDs must be unique; "Show Link" off hides the built-in trigger; clicking outside always closes. [modal-block]
- Post Grid/Carousel pagination colours: bg palette9, active bg palette4, text palette5, active text palette9, 2px border palette5; selectors `.kt-blocks-page-nav .nav-links>a|span|.current`. [post-grid-carousel-block]
- Post Grid/Carousel query filter `kadence_blocks_pro_posts_grid_query_args( $args, $attributes )`; target one block by `$attributes['className']`. [custom-queries-post-grid-carousel-block]
- Post Grid "random" order is blocked on WP Engine unless ORDER_BY_RAND is enabled; page cache freezes the order. Offset disables pagination; pagination disables Display Filter. [post-grid-carousel-block]
- Posts block: "Enable Custom Kadence Archive Colors" uses per-category colours set in Posts > Categories. [posts-block]
- Gallery (Adv) per-screen column steps: >1500, 1200-1499, 992-1199, 768-991, 544-767, <543 px. [advanced-gallery-block]
- Gallery (Adv) Lightbox link trigger requires the theme lightbox (Customizer > General > Performance). [advanced-gallery-block]
- Dynamic gallery: gallery must be empty; ACF Pro / SCF Pro gallery fields, or Meta Box "Image Advanced" field. [advanced-gallery-block]
- Image (Adv) caption is detected only if set in the media library before the image is inserted; re-select the image after adding a caption. [advanced-image]
- GIFs animate only at Image File Size "Full" (Image (Adv), Row background, Image Overlay, Gallery). [gifs-and-lottie-animations]
- AOS site-wide defaults path in UI: Kadence Blocks Controls > Block Visibility > Animate on Scroll; defaults affect new blocks only. [animate-on-scroll-effects]
- Dynamic Content: use Dynamic HTML, not Advanced Text, for multi-line or HTML fields. [dynamic-content]
- Dynamic Content Custom Input meta key rules: spaces become underscores; ACF group subfield key is `group_subfield`. [dynamic-content]
- Global "Always show all fields" toggle: Kadence Blocks Controls > Dynamic Content Settings. [dynamic-content-show-fields-all-post-types]
- Dynamic Content "Time" group: Current Year, Current Month, Current Day of the Week. [dynamic-content]
- Theme Kit Pro taxonomy image is term meta `kwp-tax-image-id`; not a built-in dynamic option; documented workaround filter on `kadence_dynamic_content_render` returning `[url, w, h, _, alt, id]` for Custom Input; use Archive > Archive Custom Field > Custom Input. [use-category-and-taxonomy-images-with-kadence-dynamic-content]
- Google Maps ACF Google Map field must be entered through Custom Input with the field name. [google-maps-block]
- Repeater in an Element needs the Element Preview Post set to a post that has the repeater field. Repeater source can be an ACF Options page or Meta Box Settings page. [repeater]
- Vector graphics are managed at Dashboard > Kadence > Settings > Manage Vector Graphics (rename, delete). [vector-graphic-block]
- Custom SVG icons: icon colour applies only to fill-based SVGs; convert strokes to fills. Built-in icon manager works in blocks only; theme icon pickers need IcoMoon `.json` uploaded at Kadence Blocks > Custom Icons (option "show only these icons"). Recommended size 24x24. [custom-icons]
- Default icon name prefixes: Line set `fe_` and `kb_*-outline`; Solid set `fa_`, `fas_`, `ic_`, `kb_`. [default-icon-selections]
- Kadence Blocks custom fonts filter `kadence_blocks_add_custom_fonts` (name => fallback, weights, label) plus own `@font-face`. [custom-fonts-kadence-blocks]
- Block Defaults: Save as Default, then Modify Attributes or Reset Defaults; global reset and import/export in Kadence Block Controls > Reset Block Defaults (also resets Block Visibility). [set-block-defaults]
- Gutenberg Copy/Paste Styles works between Kadence blocks; Navigation Link toolbar also has it. [duplicate-block-styles][kadence-navigation-link-block]
- Search (Adv) submit button inherits theme button padding, box shadow and radius; it is a nested Single Button named "Search". [search-advanced-block]
- Site Identity inner blocks are core global blocks: changing the logo or title changes it everywhere; use Image (Adv) for a one-off header logo. [site-identity-block]
- Marquee Show Pause Button uses theme button colours; Fade Edges uses the marquee background colour. [marquee-adv-block]
- Countdown Pro "Replace with content" adds a Countdown Content inner block. [countdown-block]
- Splide sliders (Gallery, Advanced Slider) disable autoplay when the OS reduce-motion setting is on; this is by design. [autoplay-problems-in-advanced-slider-gallery-blocks]
- Form (Adv) analytics (loaded, started, submitted) shown at Kadence > Forms > View Analytics. Toggle to disable Form Styles exists for fully custom styling. [advanced-form-block]
- Form (Adv) placeholders `{field_name}` (from Field Name) in Email To, Subject and Message; `{page_title}` in Subject; accept field supports `{privacy_policy}` in its label and "Show Policy Link". [advanced-form-block][add-privacy-policy-link-to-kadence-form]
- Form deliverability advice: From matches site domain and WP admin email, Reply-To equals From, non-empty subject, few CC/BCC, SPF/DKIM/DMARC, SMTP plugin. [troubleshoot-kadence-form-adv-email-delivery]
- Kadence CAPTCHA is a separate premium plugin covering forms site-wide including login. [cloudflare-turnstile-form-adv-block][blocks]
- Kadence Blocks Pro feature list includes "Page Specific Scripts" (tracking scripts per post in the editor). [kadence-blocks-pro-plugin]
- Editor device preview uses core preview widths, not Kadence's exact ranges; test real breakpoints in browser devtools. [responsive-breakpoints]
- Extra-space diagnosis order: Customizer Post/Page Layout Content Vertical Spacing (Disable / Top Only / Bottom Only), General > Layout content spacing, Boxed vs Unboxed, per-post Page Settings, empty paragraphs, block margins, gutters, Post Grid gaps. [eliminate-empty-space-on-posts-pages-archives]
- Enable the block editor for WooCommerce products: `use_block_editor_for_post_type`, `show_in_rest` for product_cat/product_tag, and unset `template` in `woocommerce_register_post_type_product`. [add-gutenberg-editor-to-woocommerce]

## 5. Kadence's own custom CSS and JS places
| Option | Where | Scope | Source |
|---|---|---|---|
| Block Custom CSS box with the `selector` placeholder | Row Layout or Section > Advanced > Custom CSS | That block; the docs suggest Customizer Additional CSS or the child theme for repeated styles | block-level-custom-css |
| Custom CSS Indicator | Block Controls toggle | Orange CSS badge on blocks with custom CSS | block-controls |
| Page Scripts [Pro] | Block Controls > Page Scripts modal | Post or page CSS plus JS in Head, Body and Footer; works on Elements, Conversions, WooTemplates | block-controls, multiple-markers-google-maps-block |
| Additional CSS class(es) and HTML Anchor | Each block > Advanced > Advanced | Targeting for CSS, JS and PHP filters (Post Grid uses `className`) | many |
| Theme Kit Pro HTML Element | Appearance > Kadence > Elements | Site-wide or conditional scripts | google-analytics-form-adv-block |
| Core Shortcode block, Custom HTML block | Gutenberg | Free fallback for scripts | insert-shortcodes, multiple-markers-google-maps-block |
| JS events | `kb-query-loaded` (document, `qlID`); `kb-advanced-form-success` and `kb-form-success` (document.body) | Hook custom JS to Kadence AJAX | run-javascript-* pages |
| Template override | `yourtheme/kadence-blocks/form-email.php` | Form emails | override-form-email-template |
| PHP filters | Section 2 (query args, dividers, font sizes, libraries, forms) | Site-wide, targeted by ID, class or `inputName` | various |

## 6. Automation facts: storage, import and export, filters, JS events, post types

### 6.1 Theme and Customizer
- **Customizer export/import/reset needs the Starter Templates plugin.** Appearance > Customize > Import/Export:
  - Export downloads `kadence-theme-export.dat`.
  - Import: Choose File, then Import; the browser refreshes.
  - Reset restores all theme settings to defaults.
  - The docs do not describe the file format; inspect a real export. [import-export-reset-theme-customizer-settings]
- **Palette JSON:** Colors & Fonts > Colors > folder icon > Export/Import tab. Copy the JSON from the text area; import by pasting and clicking Import (bottom). Selectable Palettes overwrite the current colours until published; refresh to discard. [theme-color-palette]
- **Elements export/import:** Kadence > Elements has an "Export All" button, or select rows and use Bulk Actions > Export, which gives a ZIP. Import button > Upload & Import a ZIP brings in content and settings. [importing-exporting-elements]
- **Element IDs and shortcodes:** shown in Appearance > Kadence > Elements, in the "Shortcode" column (`[kadence_element id="123"]`). The shortcode still obeys Display, User and Device rules; set Entire Site for universal use. [hooked-element-shortcodes, display-kadence-hook-elements]
- **Programmatic display:** `kadence_element_display` (bool $display, WP_Post $element, array $meta). The docs advise setting the editor Display Settings to None when code decides. [display-kadence-hook-elements]
- **Settings are theme mods:** the doc's `theme_mod_post_related` filter shows Kadence options are read through core `get_theme_mod` (key `post_related`). This matches the skill's "theme_mod by default". [common-code-snippets-for-kadence-users]
- **Per-request layout override:** filter `kadence_post_layout` returns an array with at least the key `transparent` (values like `enable`). [enable-transparent-header-on-404-page]
- **Precedence:** a filter beats its Customizer toggle (for example `kadence_microdata`); the per-post meta (Transparent Header, Page Title, Layout) beats the global Customizer value. [disable-default-kadence-theme-schema-markup, use-transparent-header]
- **Term-level data** lives on term edit screens: category colours (theme), and Above Header Background Image and Archive Columns (Pro Archive custom settings). Read and write them as term meta. [archive-layout-customizer-settings, archive-custom-settings]
- **Module toggles** are on Appearance > Kadence (Pro Addons section), and a licence must be entered first. The Elements submenu appears only after Hooked Elements is enabled and the page is refreshed. [use-hook-elements-inside-post-or-page-content, theme-kit-pro-plugin]
- **Header/Footer Scripts** are global Customizer fields (Custom Scripts section), skipped by Maintenance Mode pages. [add-scripts-in-header-footer, maintenance-mode]
- **Local fonts cache:** the "Flush Local Font Files" button deletes and refetches fonts. An automation should flush after changing typography if local fonts are on. [host-google-fonts-locally]
- **Front-end JS hook:** the `kadenceJSInitReload` event fires after Kadence reloads content; listen for it when injecting behaviour into infinite-scroll pages. [extend-kadence-infinite-scroll-with-dynamic-post-content]
- **Hook discovery:** the docs say to grep `do_action` and filters in `/wp-content/themes/kadence/`; their hook list is not exhaustive. [theme-hooks]
- **Not in the theme docs:** no WP-CLI command, REST endpoint, option name or JSON schema for Kadence Theme settings; the only CLI mention is a Solid Security teaser. The `.dat` format, the palette JSON shape and the Elements ZIP layout must be learned from code or a real export.

### 6.2 Blocks
- **Headers and Navigations** are CPTs edited in the block editor (Kadence > Headers, Kadence > Navigations). Bulk "Export" and "Export All" produce a **ZIP**, and the Import button takes that ZIP. Custom icons and images are not exported and must be moved by hand [import-export-advanced-headers-navigation, advanced-header-blocks-vs-theme-builder].
- Headers and Navigations behave like synced patterns: editing one updates every instance [advanced-header-navigations, advanced-navigation-sub-menus-mega-menus].
- **Queries and Query Cards** are CPTs, synced everywhere they are used. Target one with `$ql_id`, the query post ID [advanced-query-loop-block, custom-queries-advanced-query-loop].
- **Block Defaults and Block Visibility** export to a file (Block Controls > Import/Export, Download Export) and import from it. Defaults apply only to new blocks; Lottie and the filter blocks have "Save as default" [block-controls, lottie-animation].
- **Style Library** (Kadence > Style Library): libraries are named, with one Active plus "New Library"; Reset restores the whole library. Tokens hold the token name on the block, so editing a token restyles everything linked; custom values are unlinked. Deleting a palette sends its blocks back to Default. A site-wide active palette can be switched. Presets resolve block, then preset, then theme. Switching presets clears block edits [how-to-use-the-kadence-style-library].
- Style Library defaults (for seeding and diffing):
  - Colours, non-Kadence theme: Accent Main 1 #2B6CB0, Main 2 #215387, Main 3 #ED8936, Button #3633E1, Button Hover #2F2FFC; Contrast Strongest #1A202C, Strong #2D3748, Medium #718096, Subtle #CBD5E0, Border #E2E8F0; Background Strongest #EDF2F7, Strong #F7FAFC, Medium #FFFFFF; Notices Success #38A169, Warning #DD6B20, Error #E53E3E, Info #3182CE.
  - Text sizes: Small 0.9rem, Medium 1.25rem, Large 2rem, XL 3rem, 2XL 4rem, 3XL 6rem.
  - Radius (heading "Corner Radius"): XS 0.125rem, S 0.25rem, M 0.375rem, L 0.5rem, XL 0.75rem, 2XL 1rem, 3XL 1.5rem, Full 9999px.
  - Border Width: S 1px, M 2px, L 4px (the editor adds None).
  - Spacing: 2XS 0.5rem, XS 1rem, S 1.5rem, M 2rem, L 3rem, XL 4rem, 2XL 5rem, 3XL 6.5rem, 4XL 8rem, 5XL 10rem. Old SM/MD/LG labels link to these.
  - Icon Sizes: S 1rem, M 1.5rem, L 2.25rem.
  - Shadows: XS, S, M (M is X0 Y2 Blur8 Spread0).
  - Button preset: radius 0.1875rem, border 1px, padding 0.4em 1em [how-to-use-the-kadence-style-library].
- Presets exist for 6 blocks with these editor names: Single Button, Image (Adv), Row Layout, Section, Single Icon, Text (Adv). The Add buttons read: Add Button, Add Image Style, Add Row Style, Add Section Style, Add Icon Style, Add Text Style. The quick-reference table of linked controls per block is a useful automation map (for example, Row and Section link only Background Color and Border Radius) [how-to-use-the-kadence-style-library].
- Column Gutter (Row) and Vertical Gap (Section) still use NONE/SM/MD/LG rather than tokens. The Font Family label "Theme default" can still mean the preset value applies [how-to-use-the-kadence-style-library].
- **Fluid font sizes** filter `kadence_blocks_variable_font_sizes` returns keys `sm, md, lg, xl, xxl, xxxl` with clamp values. It does not sync with core `--wp--preset--font-size--*`. The doc's core override snippet is front-end only [variable-font-sizes].
- **Design Library sources** are registered in code (`kadence_blocks_custom_prebuilt_libraries`, `kadence_blocks_allowed_library_urls`) or saved through Cloud Connect (URL plus access key). Sync uses the WP REST API and outbound HTTPS [add-a-custom-design-library, unable-to-access-library-database-error].
- **Lottie** uploads are managed and deleted under Kadence Blocks > Settings > Manage Lottie Animations [lottie-animation].
- **Form entries**: Kadence > Form Entries (CSV export) [database-entries-form-adv-block].
- **Form field options** can be injected at render through `render_block_data` keyed on `inputName`. This is the only documented way to automate options [populate-field-values-programmatically-form-adv].
- **Performance Optimizer** state per post is visible through the Optimizer Status list filter. The run, remove and bulk actions are list-row actions [kadence-performance].
- **Query Loop URL state** uses Filter Slugs, so automation can build pre-filtered links (`?category=1`) [advanced-query-loop-block].
- **Theme related**: the Customizer "Enable a Block Header" plus a header select picks the global Header (Adv) [use-advanced-headers-globally-conditionally].

### 6.3 Products, templates and conversions
Post types and storage
- Kadence CPT slugs: `kadence_element` (Elements), `kadence_adv_page` (Maintenance Mode pages), `kadence_form`, `kadence_navigation`, `kadence_header`, `kadence_custom_svg`, `kadence_query`, `kadence_query_card`, `kadence_conversions` (Conversion items), `kadence_ab_test` (A/B tests), `kadence_lottie`, `kadence_vector`, `kt_font` (Custom Fonts), `kb_icon` (Custom Icons), `kadence_wootemplate`, `kt_reviews`, `kt_cart_notice`, `kt_woo_badge`, `kt_product_tabs` [reserved-slugs-and-terms]. So Conversions, A/B tests and fonts can be listed and created through post APIs; their settings are block attributes or meta (not documented here).
- Pattern Hub taxonomy `kadence-cloud-categories`; items are posts whose featured image is the thumbnail [offer-free-items-show-premium-items, generating-preview-thumbnails].
- A/B variant selection by URL `?ab-test=<post ID>&ab-variant=<letter>` (useful for screenshot QA of each variant) [create-your-first-ab-test].
- Conditional Display Query Parameter rule pattern (`submitted` is empty) for form success states [waypoint-starter-template-...].

Filters and constants
- `kadence_theme_add_custom_fonts` (array keyed by family: `fallback`, `weights`) [add-custom-fonts-to-kadence].
- `kadence_customizer_post_type_ignore_array` (post types the Customizer ignores; remove entries to allow reserved slugs like `product`, `course`, `lesson`) [reserved-slugs-and-terms].
- `kadence_starter_site_assist_enabled` (return false hides Site Assist) [kadence-site-assist].
- `kadence_starter_templates_disable_ai` (return false at priority 99 shows AI for legacy licences) [kadence-ai-for-legacy-licenses].
- `KADENCE_BLOCKS_AI_DISABLED` constant in wp-config disables AI [disable-kadence-ai].
- `kadence_blocks_show_image_picker` filter or `KADENCE_BLOCKS_DISABLE_IMAGE_SEARCH` constant disables Pexels [pexels-integration].
- Pattern Hub: `kadence_cloud_post_is_pro`, `kadence_cloud_rest_request_extras` (gets the REST `key` param), `kadence_cloud_post_is_locked` [offer-free-items-show-premium-items]. Pattern Hub uses REST with URL + access key [no-connection-data-error].
- `kadence_staff_post_slug` is legacy classic-theme only [change-staff-slug].
- White Label hidden page returns with `&show_white_label=true` on the theme settings URL [white-label].

Import, export, packaging
- Headers and Navigations: ZIP export/import in wp-admin (no icons or images) [import-export]. No CLI or REST route documented.
- Customizer settings: Import/Export UI comes from the Starter Templates plugin [starter-templates-faqs-troubleshooting]. Format not documented in this group.
- Child Theme Builder (Dashboard > Child Builder): tabs Child Theme Config (name, slug, author, required 1200x900 screenshot, version), Demo Import Config (template name, preview URL, preview image, brand name, logo), Pattern Hub Library Config (name, access URL, access key), Generate Child Theme ZIP. Import via Appearance > Themes upload, then Site Assist > brand dropdown > demo card with "Import Customizer Settings" (palette, typography, header/footer). Premium plugins must be licensed on the target first. Importer fetches full-size images only and rewrites only the root URL, so use full-size images in exported layouts [child-theme-builder]. This is the only documented vendor way to package a whole Kadence design system (palette, fonts, header/footer, pages) for reuse.
- Starter Template import is a wizard only; no CLI documented. It needs cURL out to Kadence and XMLReader [starter-templates-faqs-troubleshooting].

Settings locations (admin, for UI automation)
- Theme Kit Pro modules and licence: Appearance > Kadence. Blocks settings and Blocks Pro licence: Kadence > Settings. Kadence AI, credits, connection: Kadence > Home [troubleshoot-kadence-pro-update-failed..., kadence-ai-credits].
- Page Transitions, Reading Time: Appearance > Kadence > (tab) [page-transitions, reading-time].
- Conversions: Conversions > Add New / Dashboard. Insights: Insights > A/B Tests / Settings. Shop Kit: Shop Kit menu; checkout fields under WooCommerce > Checkout Manager [install-activate-kadence-conversions, setup-kadence-insights, customize-checkout].
- Reading Time defaults: 250 WPM, label "Reading Time:", postfix "Minutes"/"Minute"; shortcode `[kt_reading_time]` [reading-time].
- Simple Share shortcode `[kadence_simple_share]`; networks enabled by drag between Disabled and Enabled columns [simple-share].
- Search-replace on migration must handle serialized data in `_postmeta` and `_options` (Better Search Replace does) [bulk-update-links-and-text]; relevant for moving Kadence settings between domains.

### 6.4 From the block pages
- Navigations, Headers, Forms (Adv), Queries and Woo Templates are stored entities managed in admin lists: Kadence > Navigations, Kadence > Forms, Kadence > Queries, Products > Woo Templates. Blocks reference them; editing the block edits the stored entity. [kadence-navigation-advanced-block, advanced-form-block, product-archive-woo-templates]
- Vector graphics are a library edited at Kadence > Settings > Manage Vector Graphics; Lottie local files are uploaded through the block. [vector-graphic-block, gifs-and-lottie-animations]
- Custom icons: built-in manager (blocks only) vs IcoMoon `.json` upload at Kadence Blocks > Custom Icons. [custom-icons]
- Block Defaults are global and apply to new blocks only; reset and import/export live in Kadence Block Controls. AOS defaults: Kadence Blocks Controls > Block Visibility > Animate on Scroll. [set-block-defaults, animate-on-scroll-effects]
- PHP hooks named in the docs: `kadence_blocks_faq_schema_allowed_tags`, `kadence_toc_exclude_classes_array`, `kadence_blocks_pro_posts_grid_query_args`, `kadence_blocks_add_custom_fonts`, `kadence_dynamic_content_render` (9 args), `woocommerce_shop_loop_item_title` with `KadenceTheme::instance()->components['woocommerce']`, `use_block_editor_for_post_type`, `woocommerce_register_post_type_product`. [accordion-block, table-of-contents-block, custom-queries-post-grid-carousel-block, custom-fonts-kadence-blocks, use-category-and-taxonomy-images-with-kadence-dynamic-content, change-woocommerce-product-loop-title-tags, add-gutenberg-editor-to-woocommerce]
- Dynamic Content Custom Input value sent to PHP as `$para === 'kb_custom_input'` with the key in `$custom`; image results are arrays `[url, width, height, ?, alt, id]`. [use-category-and-taxonomy-images-with-kadence-dynamic-content]
- Theme Kit Pro term meta key `kwp-tax-image-id` holds the archive image ID. [use-category-and-taxonomy-images-with-kadence-dynamic-content]
- Form (Adv) URL prefill via "Populate With Parameter"; email placeholders `{field_name}`, `{page_title}`. [advanced-form-block]
- Shop Kit shortcodes: `[kt_quickview_button]`, `[kt_quickview_button id="N"]`. Badge placeholders `{quantity}`, `{sale-percentage}`. Cart banner variables `{cart_difference}`, `{cart_total}`. [product-quickview, product-badges, conditional-cart-banners]
- Shop Kit features must be enabled, saved and the page refreshed before dependent menus appear (Product Templates, Advanced Reviews conversion). Product Brands needs a permalink re-save. [product-templates, advanced-reviews, product-brands]
- Modal opens from any link `href="#id"` with class `modal-trigger`. [modal-block]
- Block recovery: invalid-content blocks come from Code Editor edits, pasted HTML, content-filtering snippets or version changes; "Attempt recovery" or Convert to HTML/Classic. Relevant to any tool that writes block markup. [recover-a-broken-block]
- Breakpoints for Kadence Blocks: Desktop > 1024, Tablet 768-1024, Mobile < 768; no UI to change. Theme mobile header switch is a separate Customizer setting. [responsive-breakpoints]
- Hide Kadence blocks from the inserter per user via Preferences > Blocks (existing content unaffected). [hide-kadence-blocks]

## 7. Block-by-block control map
Conventions: G = General tab, S = Style tab, A = Advanced tab. "resp" = desktop/tablet/mobile values. "n/h/a" = normal/hover/active states. Every Kadence block page lists Advanced > HTML Anchor and Additional CSS Class(es) unless noted; it is omitted below. Pro = Kadence Blocks Pro.

##### Row Layout [row-layout-block, equal-column-heights-row-layout-block, set-custom-widths-in-multi-column-row-layout-blocks]
- Layout tab: Columns (max 6); Layout presets (column widths; drag handle between columns shows %, single-row layouts only; tablet/mobile widths via Layout resp icons); Collapse Order Normal / Reverse; Column and Row Gutters; Inherit Max Width From Theme (Customizer General > Layout); Custom Content Max Width resp; Top and Bottom Dividers (colour, height, width).
- S Background (each device can have its own): Classic (colour from palette, image, Image Focus point + Left/Top %, Image File Size, Size Cover/Contain/Auto/custom H x W, Repeat, Force Background Image Inline, Attachment Scroll/Fixed/Parallax; focus ignored under Parallax), Gradient (Linear/Radial, angle, stops), Slider (item count, per-slide colour or image, size, position, repeat, autoplay, speed, transition Fade/Slide, arrow style, dot style), Video (Local MP4 or HTML5 URL, YouTube, Vimeo; mute, loop, show mute/unmute, show play/pause, bg colour, poster; decorative only).
- S Overlay resp: opacity, type colour/gradient, overlay image, Blend Mode. Border colour/width, Border Radius, Box Shadow, Text Color + link colour n/h.
- A: Padding, Margin, Container HTML Tag (Div, Section, Article, Footer, Header, Main, Aside), Minimum Height, Z-Index, Inner Column Height 100% (equal column heights), Visibility (hide desktop/tablet/mobile, logged-in/logged-out), Custom CSS (`selector`), Row Content Only Editing.

##### Section [section-block]
- G Flex Settings: Direction Vertical (default) / Horizontal / Reverse Vertical / Reverse Horizontal. Vertical: Alignment Start/Center/End/Stretch, Vertical Alignment Top/Middle/Bottom/Space Between/Around/Evenly, Vertical Gap, Text Alignment, Overlay Link (whole section clickable). Horizontal: Alignment Start/Center/End/Space Between/Around/Evenly, Vertical Alignment, Horizontal Gap, Vertical Gap, Wrap Content inherit/wrap/wrap reverse/no wrap, Flex Basis.
- S: Background n/h (type colour/gradient, image with dynamic content), Backdrop Filter (Pro per skill; Blur, Brightness, Contrast, Greyscale, Hue Rotate, Invert, Saturate, Sepia, with size slider; needs a transparent or semi-transparent section over content), Border n/h, Radius, Box Shadow, Text / Link / Link Hover colours n/h.
- A: Padding, Margin, Container HTML Tag (div, header, section, article, main, aside, footer), Min Height, Flex Grow, Z Index, Mobile Collapse Order, Sticky (offset for header), Visibility (devices, logged-in/out), Block Defaults, Custom CSS (selector, Edit in Modal). Animate on Scroll (Pro/Creative Kit), Conditional Display (Pro).

##### Buttons (Adv) and Single Button [advanced-buttons]
- Parent G: alignment, vertical alignment, orientation, button gap (resp). A: padding, margin (resp).
- Single G: link (+ same tab / new tab / Video Popup; nofollow, sponsored, download), Button Inherit Styles (Fill, Outline, Theme Base, Theme Secondary), size, width.
- Single S: text and background solid or gradient, border, border colour, radius, box shadow, Hover Styles toggle (hover colours), Icon (icon only or with text, location, size, colour, padding), Typography (size, line height, case, family, weight, letter spacing).
- Single A: aria-label, padding/margin resp, Block Defaults, Animate on Scroll (Pro or Creative Kit), Conditional Display (Pro).

##### Accordion and Pane [accordion-block]
- G: close panes when another opens, start collapsed, Initial Open Accordion, Pane Trigger Icon (on/off, icon, Icon Side, Icon Color n/h/a).
- S: Pane Title colour and background n/h/a; Title Border resp and n/h/a; Border Radius resp; Title font size resp, family, weight, letter spacing; Inner Content text, link, link hover colours, background, border and radius resp.
- A: Pane Title Sizing padding, Pane Space Between, Inner Content Padding, Title Tag (default div, heading allowed), Structure: Content Minimum Height, Max Width; Enable FAQ Schema; Block Defaults.
- Pane: Pane Title Icon + side (overrides parent), Show Only the Icon, Button Label Attribute (aria), anchor (link to `#anchor` opens pane), classes; Conditional Display (Pro) per pane.

##### Tabs [tabs-block]
- Number of tabs, horizontal/vertical; reorder with tab-title toolbar arrows, delete with X; inner tab blocks are locked and cannot be unlocked.
- Content: background, border, padding. Tab Title colours bg + border n/h/a; title spacing and border style; title font family, size, line height, spacing; icon per tab.
- A: padding/margin, content minimum height, max width, Block Defaults. Conditional Display (Pro) per tab.

##### Info Box [info-box-block]
- G: preset layouts; Link (post search, URL, dynamic/ACF); Title (aria-label for link); Link Content Entire Box / Only Learn More Text (text links only work with the second); Content Align resp.
- S Container n/h: background, border resp, radius resp, box shadow (presets/custom). Media: Align Top/Left/Right; Type None/Icon/Image/Number. Icon: picker, size, line width, border, radius, Hover Animation, colour, background, border colour, padding, margin. Image: picker, max width, alt, ratio, hover animation, border, radius, background. Number: size, family, weight, border, radius, hover animation, colour, background.
- S Title: show, colour n/h, HTML Tag, size (preset/custom resp), line height resp, case, family, weight, letter spacing, padding, margin, Min Height. Text: same set. Learn More: show, text/bg/border colour n/h, border width, radius, typography, padding, margin, min height.
- A: padding/margin (preset or custom resp), Max Width (px/%/vw) resp, Set Height to 100%. Conditional Display (Pro).

##### Icon and Icon List [advanced-icon-block-2, icon-list-block]
- Icon: one icon by default, "Add Another Icon" in toolbar; edit each single icon from List View (page gives no further control names). Conditional Display (Pro) on single icons.
- Icon List parent G: List Columns 1/2/3 resp, Column Gap, Vertical Spacing, Horizontal Icon and Label Spacing, Icon Align top/center/bottom. S: default icon, Icon Size px (blank = text size), Line Width, Icon Color, Icon Style Stacked (bg, border colour, border size, radius, padding); Text (colour, size, line height, case, family, weight, letter spacing); Link colour n/h, Underline Inherit/Underline/Underline on Hover/None.
- List item G: Link (whole item), Hide icon, Select Icon, icon title for screen readers. S: icon size, line width, colour, Icon Style Inherit/Default/Stacked. Conditional Display (Pro) per item.

##### Image (Adv) [advanced-image]
- G Image: image (media library or Pexels), file size (Full needed for GIF animation), fixed ratio, Max Image Width (hidden at wide/full alignment), alt, title, Dynamic Alt Text switch, dynamic image (Pro). Link: URL, new tab, nofollow, sponsored, link title, dynamic link (Pro).
- S: background colour, border and radius resp, box shadow, drop shadow, Mask (presets + custom), Caption (colour, size, line height, letter spacing, transform, family, weight), Image Filter, Overlay Color (solid/gradient + blend mode).
- A: padding/margin resp, Block Defaults, Animate on Scroll (Pro), Conditional Display (Pro).

##### Gallery (Adv) [advanced-gallery-block]
- G: Gallery Type (Masonry, Grid, Carousel, Fluid Carousel, Slider, Thumbnail Slider, Tiles Pro, Mosaic Pro with Row Height and Gutter), Image Ratio, Thumbnail Image Sizes, Reverse Image Order, Columns (linked, or per screen: >1500, 1200-1499, 992-1199, 768-991, 544-767, <543).
- Carousel types: Auto Play (Autoplay Speed, Slide Transition Speed), Sides To Scroll, Image Lazy Load, Enable Carousel Overflow (Carousel only).
- Links: Link To attachment/media/custom (per image); Link Triggers Media File URL/Lightbox/Custom/None (Lightbox needs theme Customizer > General > Performance lightbox).
- Captions: show, placement (Bottom on hover, Bottom always, Below always, Cover on hover), Force Hover Effect Always For Mobile, colour + bg, font.
- S: Image Style radius + filter, Image Shadow (colour, X, Y, blur, spread, presets), Arrow Style (4 presets free, Custom Pro), Main Arrow Position (Center free; 10 more Pro), Arrow Size, Arrow Margin.
- A: padding, margin, Block Defaults, Conditional Display (Pro). Toolbar Dynamic Gallery icon (Pro).

##### Image Overlay [image-overlay-block]
- G: image (dynamic), file size, link, max width resp, hover animation static/zoom in/slide/grayscale/blur, overlay opacity, preserve ratio.
- S: overlay colour, overlay hover opacity, border colour/style/width/radius/position from edge, text align vertical (top/center/opposite) and horizontal (left/center/right/opposite), Title (toggle, colour, bg, HTML tag, typography, padding, margin), Subtitle (same + hidden until hover or always visible), Title/Subtitle Divider (solid/dashed/dotted/double, colour, height, width).
- A: padding/margin resp (linkable).

##### Video Popup [video-popup-block]
- G: Video Type YouTube/Vimeo/VideoPress URL (press the Submit arrow to save) or Self-Hosted (Pro); dynamic URL (Pro); Video Ratio 4:3 / 16:9 default / 3:4 / 9:16; Use Mobile Video + mobile ratio; Embed YouTube with No Cookies; Auto Play (If Able); Aria Label; Poster Type Image or Video; Poster Background Color; Poster Ratio (1:1, 3:4, 1:2, 4:3, 16:9, 2:1, Inherit From Image).
- S free: Max Video Width resp (px/vw/%), Popup Background Color, Popup Close Background Color, Popup Close Color. S Pro: Pop Animation (Zoom, Zoom Out, Slide Right, Slide Left, Flip), Play Icon (icon, Default/Stacked, size px, colour n/h, stacked bg/border n/h, border width px, radius %, padding, title), Image Overlay (opacity n/h, solid/gradient, 12 blend modes), Border resp, Shadow n/h.
- A: padding/margin resp, Max-Width, Block Defaults, Animate on Scroll (Pro/CK), Conditional Display (Pro).

##### Form (Adv) [advanced-form-block, cloudflare-turnstile-form-adv-block, mailerlite-form-adv-block, activecampaign-form-adv-block, add-privacy-policy-link-to-kadence-form, troubleshoot-kadence-form-adv-email-delivery]
- Setup: select existing form or create; Form Layout; Initial Style; Title/Description.
- Fields: standard Text, Email, Text Area, Select, Radio, Telephone, Checkbox, Number; advanced File, Time, Date, Accept, Hidden; layout blocks Paragraph, Advanced Text, Section, Row Layout, Spacer/Divider; misc Captcha (reCAPTCHA v2/v3, Turnstile, hCaptcha; Turnstile style Light/Dark, Normal/Compact), Submit (styled as a button).
- Field G: required, label, Show Label, description (help text), placeholder, Default Value (Date `today`, Time `00:00:00`). Field A: Field Width max/min resp, Field Name, Field Auto Fill, Input Aria Description, required error message, Populate With Parameter. Conditional Fields (Pro): Show/Hide, field, compare (Not Empty, Empty, =, !=, Contains, Does Not Contain, Begins With, Does Not Begin With, Ends With, Does Not End With).
- Form G: Selected Form, Form Description, Submit Actions (free Email, Redirect, MailerLite, FluentCRM; Pro Kit, ActiveCampaign, Auto Respond Email, Database Entry, Brevo, Mailchimp, Webhook), hide form after submit, Email Settings (To, Subject, From Email default admin email, From Name, Reply To, CC, Bcc, Send as HTML), Database Entry (save IP, save device), Messages (Success, Pre Submit Form Validation Error, Error).
- Form S: Input Fields (Field Row Gap, Input Size S/M/L, Normal and Focus colours: input, placeholder, background type, background, box shadow; border px/colour/radius; size, line height; advanced case, family, weight, letter spacing, input padding); Labels (Normal / In-Field Label / Float Label, colour, required asterisk + colour, typography, padding, margin); Radio/Checkbox Labels; Help Text; Message Styling (text/bg, border resp, error colour/bg/border, typography, radius, padding, margin); form background classic or gradient.
- Form A: padding, margin, max width (resp), Validation (Browser Validation toggle), Analytics (loaded/started/submitted; view at Kadence > Forms), enable Form Styles toggle.

##### Navigation (Adv) and Navigation Link [kadence-navigation-advanced-block, kadence-navigation-link-block, advanced-header-best-practices]
- Nav G: Selected Navigation, Create a New Navigation, Open Navigation Builder, Orientation, Horizontal/Vertical Item Spacing, Stretch Menu, Fill and Center Menu Items, Make Parent of Current Menu Item Active; Vertical: Entire Item Expands Vertical Sub Menu, Collapse Vertical Sub Menus; Horizontal Layout Standard / Stretch (Standard or Fill and Center) / Grid (Horizontal Grid Columns); Activate Anchor on Scroll + Activation Offset Auto/Manual resp.
- Nav S: Style Standard / Full Height / Underline / Full Height Underline; Nav Link Styles n/h/a (colour, bg Color/Gradient, border, radius, box shadow); Divider (colour, width); Typography; Sub Menu Styles (Reveal Animation Fade/Fade Up/Fade Down/None, Dropdown Horizontal Alignment, Dropdown Width, Vertical Spacing, border/radius, shadow, padding/margin); Sub Menu Links (colours n/h/a, divider, link padding/margin, alignment resp, typography); Sub Menu Descriptions; Description Styles.
- Nav A: padding/margin, Nav Link Padding, Nav Link Margin.
- Link toolbar: Copy/Paste Styles, Add Navigation Link, Add Sub Menu (free), Add Mega Menu (Pro). Enter key adds a link.
- Link G: Alignment resp, Label, Hide Label, Disable Link, Open in New Tab, URL, Rel Attribute, Description, Open Dropdown On hover/click, Mega Menu (Pro), Mega Menu Width Default / Menu Container Width / Content / Full / Custom Width.
- Link S (all Pro per doc): Link Styles n/h/a, reset icon to inherit, Typography, Sub Menu Styles (colour/bg n/h/a, width, vertical spacing, typography), Highlight Label (Pro: text, colours n/h/a, border/radius, typography, icon, Align Icon, Align Label, vertical spacing, Link Gap, padding), Media (Pro: Icon/Image, position Top/Bottom/Left/Right, image max width/alt/ratio/bg/border; icon colours, size, line width, radius; Media Spacing, Media Padding, Title for Screen Readers), Description Styles (align with title or icon, spacing, colour n/h/a, typography).
- Link A: padding/margin, Block Defaults, Conditional Display (Pro).

##### Search (Adv) [search-advanced-block]
- G: Search Style Standard/Modal, Show Submit Button (off by default; inherits theme button padding, shadow, radius), Search Products Only. Submit button is a nested Buttons (Adv) Single Button named Search.
- S: Input Icon (custom SVG Pro), line width, colour n/h; Close Icon (modal) size, line width, colour n/h; Input Style max/min width, text colour, placeholder colour, placeholder text, typography, radius, input padding/margin; Modal Style bg colour/gradient.
- A: padding/margin, Aria Label, Block Defaults.

##### Site Identity [site-identity-block]
- Inner blocks are core Site Logo, Site Title, Site Tagline. G: Show Site Title, Show Site Tagline (needs title), Layout, Text Vertical Alignment, Link to Homepage (custom URL). S: Title and Tagline font family, weight, style. A: padding/margin, Block Defaults.
- Colours and font size come from the inner core blocks (core Color, Typography, Dimensions panels; logo width, rounded style, duotone, Use as Site Icon).

##### Table (Adv) [table-advanced-block]
- Structure: Table > Table Row > Table Data (each cell holds blocks). Row: Background, Hover Background, Row Height resp (px/em/vh). Data: Padding resp.
- G: Rows, Columns, First Row is Header, First Column is Header; Column Widths Use Auto Width or custom (% or px, per device, slider or on-canvas adjusters); Sticky (Pro) First Row (needs Max Height) / First Column (needs Max Width); Table Sizing Max Width, Max Height, Overflow-x Scroll.
- S: Borders colour/size resp + Only apply To Rows; Cell Padding; Cell Typography (align, colour, size, line height, case, family, weight, letter spacing); Header Typography; Even/Odd Backgrounds n/h; Column Backgrounds; Row Height.
- A: padding/margin, Block Defaults.

##### Table of Contents [table-of-contents-block]
- G: Allowed Headers H1-H6; Collapsible (Enable Collapsible Content, Start Collapse, Icon Style, title toggles too).
- S: Title (text default "Table of Contents"), List, Container settings.
- A: padding/margin (block CSS adds 30px bottom margin; set 0 to remove), Enable Smooth Scroll to ID, Highlighting Heading when scrolling (+ Active colour), Search for Headings in Non static post content?, Search for Headings in Template? (Theme Kit Pro Elements).

##### Testimonials [testimonial-block]
- G: Grid or Carousel, columns, gap; Carousel Type Infinite Loop/Rewind, Auto Play + speed, Slide Transition Speed, Slides to Scroll One/All, Arrow Style, Dot Style.
- S: container; Icon, Title (HTML tag, size), Rating (colour, icon size), Content, Media, Name & Occupation sections.
- A: individual padding, Container Max Width px, Container Min height, Wrapper padding/margin. Individual testimonial: media Image/Icon, rating; Conditional Display (Pro).

##### Countdown [countdown-block]
- G: expiration date/time; Action on Expire (free: stay at zero; Pro: Hide, Replace with content via Countdown Content block, Redirect); Evergreen (Pro: hours/minutes, reset after days); Alignment resp; Layout block (divider) or inline; pre text, post text, unit labels.
- S: Count Item bg, border colour/width/radius, padding (some resp); Number, Label, Pre Text, Post Text typography and colour.

##### Count Up [count-up-block]
- Starting number, ending number, prefix, suffix, animation duration, thousand separator; Title show/hide + typography; Number typography.

##### Progress Bar [progress-bar-block]
- G: three layouts, Progress Thickness, Border Radius, Progress, Max Progress, Number show/prefix/suffix, Animation Duration, Wait until visible to animate, Type linear/ease in/ease out/ease in out.
- S: label position above/inside/below, Text Alignment resp, Text Layout (Label then %, % then Label, Label above %, Label below %), show label, show number, Progress Color + Progress Background Color, Text Styling (colour, size resp, line height, case, family, weight, letter spacing, padding resp), Number Styling.
- A: margin, Max Width.

##### Show More [show-more-block]
- Section + Buttons (Adv) group. G: Display hide button once expanded, Maximum Preview Height resp, Fade out preview, Fade Size. A: padding/margin resp, Expand Settings (default state per device), Block Defaults.

##### Spacer/Divider [spacer-divider-block]
- Height; divider Solid/Dotted/Dashed (colour, height, width) or Stripe (colour, angle, stripe width, gap, height, width); divider off. A: Visibility per device, Block Defaults.

##### Google Maps [google-maps-block]
- G: Map Location (address or place name), Zoom, Map Type Road/Satellite, Map Filter Grayscale/Invert/Saturation/Sepia; API Settings: custom key + Use Javascript API unlocks Show Marker, Map Style and coordinates. Dynamic location (Pro, text field or ACF Google Map via Custom Input).
- S: Height (default 450px) resp, Max Width resp. A: padding, margin, Block Defaults, Conditional Display (Pro).

##### Dynamic HTML (Pro) [dynamic-html-block]
- G: Source, HTML Content (Post Title/Content/Excerpt/Date/Modified/Custom Field; Archive Title/Description/Custom Field; Site Title/Tagline/URL/Page Title/Current User Display Name/Custom Setting; Author fields; Meta Relationship Title/Content/Excerpt/Custom Field), Container HTML Tag (header, section, article, main, aside, footer), Use Inner Tag Wrap (H1-H6 apply global heading styles), Content Modification Max Word Count, Strip HTML.
- S: Content Alignment resp, Text Color, Heading Color, Link Color n/h, Link Style Unset/None/Underline/Underline on Hover, font size (preset or px/em/rem resp), line height resp, case, family, weight, letter spacing resp, per-heading-tag typography (size, line height, letter spacing per device).
- A: padding, margin (resp, per side), Block Defaults.

##### Dynamic List (Pro) [dynamic-list-block]
- Source current/other post; Source Type Taxonomy (Enable Link) or Custom Post Meta (checkbox or multi-select field). Style: alignment resp; Direction Horizontal (Basic: divider, item colour, link style; Pill: item colour, item bg, link style) or Vertical (Bullet / Number List / None). Typography (size and line height resp). A: padding/margin resp.

##### Repeater (Pro) [repeater]
- Wizard: source, starter layout. G: Source (post, ACF Options Page, Meta Box Settings Page), Repeater Field, Columns, Column Gap, Row Gap (resp). A: padding/margin resp, Save as Default. Inner blocks bind with the dynamic icon and "Use Repeater Context".

##### Posts (free) [posts-block]
- G: Post Type, Order By (newest, oldest, modified asc/desc, A-Z, Z-A, menu order, random), Number, Offset, Filter by Category/Tag include/exclude, taxonomy, Show Unique, Allow Sticky Posts.
- Layout: Columns desktop/tablet (mobile 1), Style Boxed/Unboxed.
- S: Title HTML tag, size resp, line height, case; Image show, ratio, size; Category Show Above Title + Enable Custom Kadence Archive Colors (per-category colour from Posts > Categories).
- A: Meta (author name, image, image size, link, label; modified date + label; category + label; comments), Content (excerpt, custom length, max words, Show Read More + text), Block Defaults, Open Post Links in new Tab.

##### Post Grid/Carousel and Portfolio Grid/Carousel (Pro) [post-grid-carousel-block, portfolio-grid-carousel-block, custom-queries-post-grid-carousel-block]
- G: Post Type, Select Posts By query/individual (selection order kept), Order By (8 incl. random), Number, Offset (disables pagination), Pagination (disables Display Filter), Filter by Category/Tag include/exclude, taxonomy, Exclude Current, Show Unique, Allow Sticky Posts.
- Layout Grid / Masonry Grid / Carousel. Carousel: Auto Play, Auto Scroll, Scroll Speed, Slide Transition Speed, Sides To Scroll, Arrow Style (White on Dark, Black on Light, Outline Black, Outline White, None), Dot Style (Dark, Light, Outline Dark, Outline Light, None), Columns Linked/Individual, Column Gap resp. Grid/Masonry: Columns, Column Gap resp, Row Gap resp.
- Image: show, align top/left, ratio, link, padding resp, radius, Force Image to Height of Container, Respect Aspect Ratio.
- S: Text Alignment resp, bg, Container Padding resp, border, radius resp, shadow; Header, Content, Footer section bg/padding/margin; footer border colour/width.
- A: Display Filter (taxonomy, All label, alignment, border width/radius, item padding/margin, colours n/h/a, typography), Above Title Categories (divider, colours, typography), Title (show, link, colour n/h, HTML Tag, typography), Below Title Meta (date, modified date, author, category, each with pre-text), Meta Divider, meta colours and typography, Excerpt (colour, typography, custom length, max words), Read More (text, align bottom, border, colours n/h, typography, padding/margin), Footer Meta (align bottom, date, categories, tags, author icon, comment count, colours, typography), Block Defaults, Open Post Links in new Tab.

##### Product Carousel (Pro, WooCommerce) [product-carousel-block]
- G: Select Products By Standard/On Sale/Best Selling/Top Rated/Individually; Order By (Menu Order, newest, oldest, price low-high, price high-low, sales, title A-Z/Z-A); Number of Items; Filter by Category; Columns.
- S: Product Style Boxed/Unboxed, Text Alignment, Auto Play, Autoplay Speed (ms), Auto Scroll, Show Pause Button, Slide Transition Speed, Slides to Scroll, Arrow Style, Dot Style, Column Gap, Do Not Loop.
- A: padding, margin, Block Defaults (content not included).

##### Modal (Pro) [modal-block]
- G: Horizontal Align center/left/right, Vertical Align middle/top/bottom, Height Fit to Content / Fixed Minimum Height / Full Screen Height, Width % resp, Max Width px, Show Link.
- S: Overlay Background Color, Open Animation, Close Animation; Close Button (on/off, inside/outside, size resp, X colour and bg n/h, Close Button Aria Label); Modal Box (inner H/V alignment, bg, border colour/size resp, radius resp, padding/margin resp); box shadow; Link Styling (inherit theme or custom n/h link/bg/border colours, shadow, border width/radius, icon left/right/only, typography).
- A: Load Content After Footer, Custom Open ID.

##### Split Content (Pro) [split-content-block]
- G: min height resp, media image, media side left/right, media size auto/cover/contain, media link. S: media bg, content bg, Content Style (vertical center/top/bottom, horizontal center/left/right, max width resp), Content Shadow (colour, blur, spread, offsets). A: padding/margin resp, Block Defaults, AOS, Conditional Display.

##### User Info (Pro) [user-info-block]
- G: Enable Avatar, Enable Name, Before Name Text, Name HTML Tag, Enable Registered Date, Before Registered Date Text. S: Content Alignment resp, Container Background, Container Border, Box Shadow, Avatar Styles (width, radius, padding, gap), Name Styles and Register Styles (colour, typography, padding, margin).

##### Vector Graphic (free) [vector-graphic-block]
- Select Vector Graphic > Add New Vector Graphic (name + pasted SVG code, saved to a reusable library); Max Width; toolbar alignment Left/Right/None (None centres). A: padding/margin.

##### Marquee (Adv) and Marquee Item (Creative Kit) [marquee-adv-block]
- Parent toolbar: Edit/Preview mode, + adds item. G: Orientation Horizontal (Direction left/right, Item Height) or Vertical (Direction up/down, Container Height, Item Width), Item Count, Speed, Pause on Hover, Show Pause Button (theme button colours). S: Fade Edges (uses marquee bg colour), Fade Width px, Background Type solid/gradient, Background, Item Gap. A: padding, margin, Z-Index.
- Item: Background Type/colour/gradient, padding, margin.

##### Lottie Animation [gifs-and-lottie-animations]
- G: File Source Remote URL (Lottie Animation URL) or Local File (Animation Title + upload). Other settings referred to a separate Lottie page not in this group.

##### Animate on Scroll panel (Pro or Creative Kit) [animate-on-scroll-effects]
- A > Animate on Scroll: Animation (Fade, Flip, Slide, Zoom, Cover groups), Duration 50-3000 ms (default 400), Ease (blank = none), Start Delay 50-3000 ms (default 0), Only Show Once Per Page Load, Pixel offset -300..300 (doc: default 0), play preview. Blocks: Section, Single Button, Text (Adv), Form, Image (Adv), Video Popup, Image Overlay, Split Content. Same on all screen sizes.

##### Conditional Display panel (Pro) [conditional-display]
- A > Conditional Display: Conditional (Post Custom Field, Post Title, URL, ID, Date, Last Modified Date, Featured Image URL, Post Type, Post Status, Post Has Taxonomy, Repeater Custom Field, Archive Title/URL/Custom Field, Author Display/First/Last Name/Custom Field, Comments Count, URL Path, Full URL, Query Param; User Logged-In, User Role, User Display/First/Last Name, User Custom Field), Conditional Source (pencil to pick a post), Compare Type (Not Empty, Empty, True, False, =, !=, >=, <=, >, <), Add Condition, Logic Operator AND/OR.
- Listed blocks: Image (Adv), Text (Adv), Section, Row Layout, Slider slides, Accordion panes, Tabs tabs, single Icons, Icon List items, single Buttons, Info Box, individual Testimonials; other pages add Gallery (Adv), Google Maps, Navigation Link, Video Popup, Split Content.

##### Shop Kit Woo Template blocks (need Shop Kit > Product Templates enabled) [product-*-block, archive-main-query-block, woo-template-breadcrumbs-block]
- All: Spacing Settings padding/margin resp; Advanced classes (Add to Cart also anchor).
- Product: Add to Cart: Show Quantity (single template only; adds Quantity Input styles), Alignment, Force Button FullWidth; button text/bg/border colours n/h, border width/radius, typography, padding.
- Product: Title, Price: alignment resp; colour, size, line height, letter spacing, transform, family, weight.
- Product: Description, Short Description: alignment; colour and typography.
- Product: Meta: alignment; text, link, link hover colours; Link Typography.
- Product: Rating: alignment resp; colours, typography resp (needs WooCommerce reviews on). Product: Reviews: layout inherit/single/two column resp.
- Product: Gallery: Sale Tag settings. Product: Image: force fill container, alignment.
- Product: Additional Information: Info List Style (colour, bg, typography resp), Info Label Style (alignment resp, width, typography).
- Product: Related: heading toggle, columns, limit; title colour, product bg, title typography. Product: Upsell: remove "You may also like..." heading, columns resp, limit; title/bg colour, typography.
- Product: Tabs: remove headings, accordion style, alignment; Enabled Tabs (disable + priority slider); Tab Title Styles; Tab Content Styles; Additional Information Styles; Container Spacing.
- Product: Notice: text, bg, border colours, border width/radius resp, typography; View Cart button colours/bg/border n/h, width/radius resp, typography.
- Product: Brand: spacing only. Product: Custom Actions: Custom Type Do Function / Do Action + name. Product: Breadcrumbs: alignment resp, page title toggle, colours text/link/hover, typography.
- Product: Quickview Button: Product ID when used outside loops. Archive: Main Query: Columns 1-6 resp.

## 8. Starter Templates, Design Library, AI, Conversions, Insights, Shop Kit, troubleshooting
The skill has almost nothing on Starter Templates, Site Assist, Conversions, Insights, Shop Kit, White Label, Child Theme Builder, Page Transitions, Reading Time, Simple Share or AI. Everything below is new unless stated.

Starter Templates and Site Assist
- Starter Templates live at Site Assist > Starter Templates; if Site Assist is disabled, at Kadence > Starter Templates [kadence-site-assist, starter-templates-faqs-troubleshooting].
- The plugin works only with the Kadence Theme [kadence-starter-templates].
- Premium templates need either Creative Kit licensed (Express plan up) or Blocks Pro and Theme Kit Pro licensed "using the same license key for both plugins" (Plus plan up) [kadence-starter-templates].
- Import wizard steps: Style (palette set or highlight colour, font pair), Content (full site or selected pages; advanced: Import Customizer Settings, Import Widgets, example posts/products, footer widgets), Plugins (required plus optional WooCommerce, GiveWP, The Events Calendar, Event Tickets, Orderable, Kadence WooCommerce Email Designer, Solid Security), then "Finish and Launch" [pre-designed-starter-templates, kadence-ai-powered-starter-templates].
- Import overrides theme settings and adds pages, menus, sample content; try on staging first [introducing-kadence-theme, pre-designed-starter-templates].
- Reimport offers "Delete previously imported content?", which deletes imported pages including edits; to reset one page use Design Library > Starter Packs [pre-designed-starter-templates].
- Removing the Starter Templates plugin after import also removes user-profile social URLs (used by the author box) and the Customizer Import/Export settings [starter-templates-faqs-troubleshooting].
- Server minimums for import: PHP memory 512MB, max post 50MB, WP memory 256/512MB, upload 50MB, max input vars 2500, max execution about 300; cURL allowed; XMLReader extension enabled [starter-templates-faqs-troubleshooting]. The AI page says WP memory 128/256MB [troubleshoot-kadence-ai].
- Broken template styles or failed premium imports: resync the cloud with the refresh icon on the Starter Templates page [starter-templates-faqs-troubleshooting, pre-designed-starter-templates].
- Timeouts: reimport repeatedly without "Delete previously imported" to finish media in batches [starter-templates-faqs-troubleshooting].
- Hostinger CDN security level blocks imports; set it to "Essentially off" during import, then restore [fix-kadence-starter-templates-hostinger].
- Pre-designed library has over 80 templates; categories Business, Course, Event, E-commerce, Nonprofit, Photography, Blog, Political, Membership [starter-templates-ai-powered-vs-pre-designed, pre-designed-starter-templates].
- Some templates need third-party premium plugins (for example LearnDash); import still works with partial content [pre-designed-starter-templates].
- Site Assist covers title/tagline, icon, logo (Customizer > Header > Site Identity), language, timezone, colours (Customize > Colors & Fonts > Colors; Site Background shows only with boxed content), header, footer, typography, buttons (Colors & Fonts > Buttons), post/page/archive layouts, SMTP (Solid Mail), security (Solid Security, 2FA), performance (Solid Performance caching and lazy load) [kadence-site-assist].
- Waypoint template anatomy: Block Header edited under Kadence > Header; footer is a Hooked Element "Replace Footer" so Customizer footer changes do nothing; archives use a Template Element "Replace Archive Content" with Dynamic Content `archive|archive_title` H1 and Query Loop (Adv) with "Inherit Query from Template"; duplicated sections switch between static and Marquee with Visibility Settings per device; faux shadows by nested sections; contact form hidden by Conditional Display Query Parameter `submitted` "is empty" [waypoint-starter-template-...].
- Waypoint palette advice: no dark mode; Accent 1 very light saturated, Base 3 white; palette 10 named "Accent Complement" [waypoint-starter-template-...].
- Editing a Query Loop (Adv) card changes every page that uses that query template [waypoint-starter-template-...].

Design Library and AI
- Open from the editor top bar next to List View or from a new Row Layout [kadence-ai-powered-design-library].
- Colour style preview: Light = palette 1, Dark = palette 2, Highlight = palette 9 [kadence-ai-powered-design-library].
- Settings menu: Advanced lets you disable Custom Image Selection (wireframe images only) and Live Preview (static previews) [kadence-ai-powered-design-library].
- Design Library visibility per role: Kadence Block Controls > Components > Design Library ("Show Design Library Button", "Starter Packs Library") [kadence-ai-powered-design-library].
- Old prebuilt layouts are no longer shown by default [prebuilt-layouts].
- Image collections: Featured and Background groups; premade (Pexels-powered, plus "AI Search Collection") and "My Collections" [design-library-change-ai-image-collections].
- Kadence Blocks extra colours (Kadence Blocks Controls palette, "Use only Kadence Blocks Colors?") are not variables; blocks using them do not update when changed. Use the theme palette for anything global [define-color-palette].
- AI is off until a Kadence account is connected; disconnect at Kadence > Home [disable-kadence-ai]. Credits: free 250 lifetime; Blocks Pro standalone 1,200/yr; Express 1,250/yr; Plus 4,000/yr; Ultimate 8,000/yr; Ultimate Lifetime 16,000 lifetime. Initial content about 70; a Design Library context 1 to 10 (full library about 100); inline 1 [kadence-ai-credits].
- AI supports Latin-script languages only, no RTL yet; WordPress site language does not affect AI language [kadence-ai-languages].
- Inline AI is on Advanced Text only (toolbar star icon) [kadence-ai-powered-inline-content].
- Pexels picker (Blocks 3.1.16+) imports the original and all WordPress thumbnail sizes, sets alt text and a title from the uploader's name [pexels-integration, pexels-picker]. Agents should rewrite those alt texts.

Conversions
- Types: Popup, Slide In, Banner; chosen on the root Conversion block [conversion-settings, install-activate-kadence-conversions].
- Settings are on the "Conversion Item" in List View [kadence-conversion-item-settings].
- One launch trigger per item: time delay, exit intent, scroll distance, end of content, on load, custom link [launch-triggers]. The install doc adds "user click" and gives units differently (see Conflicts).
- Goals: Form Submission (any form, including third-party) or Button Click with a Goal-Specific Button Class; optional Close Conversion on Goal Event [conversion-settings].
- A non-button goal (for example an image) needs the goal class plus `kt-button` [conversion-settings].
- Analytics: Total Views, Total Conversions, Conversion Rate at Conversions > Dashboard [conversion-settings].
- Targeting: pages (default all; rules per single page, group, author; Woo product/category/tag/archive/search; Events Calendar; Kadence Galleries; exclusion rules), visitors (logged in/out, any registered role incl. Woo and LearnDash roles; roles only work for logged-in users), devices (desktop, tablet, mobile toggles), requests (query strings one per line, AND; referrer domain; exact cookie name; minimum page views) [target-pages, target-visitors, target-devices, target-requests]. Install doc also lists WooCommerce cart totals [install-activate-kadence-conversions].
- Scheduling: range (start, expires) and recurring (days and hours); can be combined [scheduling-kadence-conversions].
- Start points: Pre-Built Library or Blank Canvas [install-activate-kadence-conversions].

Insights (A/B)
- A/B Test is a CPT; create at Insights > A/B Tests or from any block's toolbar "Create A/B Test" (copies it to variants A and B) [create-your-first-ab-test].
- Variants assigned randomly and evenly per browser session, sticky for the user [kadence-insights-faq].
- Goal metrics: Link/Button Click (goal class; target inside block or anywhere), Submit Form, Time Spent On Page (1 to 200 s), WooCommerce Sales, SureCart Sales [setup-kadence-insights].
- Preview a variant: `?ab-test=<ID>&ab-variant=a` [create-your-first-ab-test].
- Picking a winner (star icon) converts the block back to a normal block and removes losing variants on that page [create-your-first-ab-test].
- Analytics local or Google Analytics (events under category "Kadence"; GA must already be installed) at Insights > Settings [setup-kadence-insights].
- Control variant A is served for SEO; Bayesian statistics; vendor claims no cookies or PII [kadence-insights-faq].
- Vendor advice: test small parts (CTAs), not whole pages or headers [create-your-first-ab-test].

Fonts, palette, theme
- Custom fonts: Kadence Custom Fonts plugin (uploads or Adobe Typekit), available with Theme Kit Pro or a plan [add-custom-fonts-to-kadence].
- Code route: filter `kadence_theme_add_custom_fonts` with `fallback` and `weights`, plus your own `@font-face` [add-custom-fonts-to-kadence] (filter already in skill).
- Custom scripts (GTM, meta tags) go in Customize > Custom Scripts with Theme Kit Pro; without it, child theme hooks `wp_head` / `wp_body_open` [add-google-tag-manager..., fixing-phone-numbers...].
- iOS Safari auto-links phone numbers; fix with `<meta name="format-detection" content="telephone=no">` or set a link colour [fixing-phone-numbers...].
- OG share images come from the SEO plugin, not the theme [fix-incorrect-share-images-on-social-media].
- Full-screen landing: disable header/footer and set full width per page, Row Layout min height 100vh, inner column height 100%, vertical centre [full-screen-landing-page].
- Header (Adv): Transparent toggle adds "Auto Spacing Under"; sticky options Sticky Section (whole or one row), Reveal On Scroll Up, Shrink Middle Row; per-link sticky/transparent styles override the Navigation (Adv) styles; translucent states via colour opacity [sticky-transparent-adv-headers].
- Advanced Headers and Navigations export/import as ZIP from Kadence > Headers and Kadence > Navigations (Export All or bulk Export; Import button); custom icons and images are not included [import-export].
- Text domains: `kadence`, `kadence-pro`, `kadence-blocks`, `kadence-blocks-pro`, `kadence-starter-templates`, `kadence-cloud` [change-any-text-on-your-site].
- Kadence reserved CPT slugs (full list in §6) [reserved-slugs-and-terms].
- Theme accessibility claim: built to WCAG 2.0; overlay links, Advanced Text and Advanced Button links have accessible-name settings [what-is-page-speed-insights]. (Skill targets WCAG 2.2; doc is older baseline.)

Troubleshooting an agent will hit
- "Updating failed. You're probably offline." means the REST API is blocked: check Site Health, WAF rules, PCRE, SSL [troubleshoot-updating-page-failed-offline-error].
- Blank editor/Customizer: clear all caches, then conflict test with only Kadence plugins and a default theme [white-blank-screens-in-editor-or-customizer].
- Broken styles with optimisers: test with `?nocache=1` (LiteSpeed `?LSCWP_CTRL=before_optm`, WP Rocket `?nowprocket`, etc.); exclude the Kadence file by name without `?ver=`; delayed JS for the header is a known cause [clear-website-cache, troubleshooting-optimization-caching-plugins].
- Theme Kit Pro licence is in Appearance > Kadence; Blocks Pro licence in Kadence > Settings; "Update failed: Service Unavailable" is usually an old licence key [troubleshoot-kadence-pro-update-failed...].
- Pattern Hub host must be public, not use Plain permalinks, allow CORS, valid SSL [no-connection-data-error, generating-preview-thumbnails].
- LCP: do not lazy-load above-the-fold images; keep DOM under about 1,500 nodes; use Shift+Enter line breaks instead of many paragraph blocks; fewer Post Grid/Carousel blocks [largest-contentful-paint-lcp].
- Shop Kit custom checkout fields need the `[woocommerce_checkout]` shortcode, not the Checkout block; field names need prefixes `billing_`, `shipping_`, `additional_` [customize-checkout].
- Snackbar notices do not show when AJAX add to cart is on [snackbar-style-notices]. Variation Gallery needs Product Gallery enabled and at least one main gallery image [variation-swatches].

## 9. Conflicts between docs and this skill, and how they were resolved
The skill's references were updated on 22 Nov 2026 for the items marked as settled.

### 9.1 Theme docs
1. **Custom fonts UI.** `references/limitations.md:37` says "Uploaded custom fonts have no UI; only filters". `recipes.md:61` says "Uploaded (non-Google) fonts have no theme UI; needs filter". The docs describe the separate **Kadence Custom Fonts** plugin, with a full UI at Appearance > Kadence > Custom Fonts (upload or Adobe Type Kit). It is true for the theme alone, but the skill should name the plugin. [custom-fonts]
2. **Maintenance Mode location and labels.** `theme-kit-pro-elements.md:162` gives the admin as "Appearance > Maintenance Mode" and the types "Under Maintenance" and "Coming Soon". The docs say "Dashboard > Kadence > Maintenance Mode" and call the types "Maintenance Mode" and "Coming Soon Mode". [maintenance-mode]
3. **Maintenance user rule (resolves an open item).** `theme-kit-pro-elements.md:163` and `limitations.md:142` mark the meaning of the default `administrator` rule `[unverified]`. The docs say "User Exceptions" are the roles that **see the live site instead**; the default is Administrators, so a logged-in admin needs a private window to see the page. [maintenance-mode]
4. **Header Addons count.** `theme-kit-pro-elements.md:52` says "Adds 19 elements to the header builder". The theme-kit-pro-plugin doc says "Adds 20 elements", and header-addons lists 13 items. Treat the code count as authoritative and note that the docs differ. [theme-kit-pro-plugin, header-addons]
5. **Elements admin path.** The skill mixes paths: `theme-kit-pro-elements.md:174` and `recipes.md:93,103,113,120-126,139,282` say "Appearance > Elements", while `theme.md:366` says "Appearance > Kadence > Elements". The docs consistently say Appearance > Kadence > Elements (also "Dashboard > Kadence > Elements"). [installing-creating-elements, importing-exporting-elements]
6. **Dark palette location.** `limitations.md:167` and `research-references.md:167` cite the doc's "Customizer > General > Colors". The dark-mode doc still says that (and "Appearance > Customize > General > Color Switch (Dark Mode)" for the switch), but every other theme doc uses Colors & Fonts > Colors. Settled: the colours panel is Colors & Fonts > Colors; only the dark-mode switch section sits under General. [color-palette-switch-dark-mode, theme-color-palette, customize-the-kadence-footer]
7. **Optimized Group Block meaning.** `theme.md:61` ties `theme_json_mode` to reading theme.json and spacing presets. The performance doc presents it only as "exposing layout controls" on the Group block. This is not contradictory, but the docs understate the side effect (theme.json loading). [performance-settings]
8. **Fixed Section width (resolves an open item).** `theme-kit-pro-elements.md:269` marks the `_kad_element_fixed_width` choice list `[unverified]`. The docs give 100% (default), auto and fixed (px). The docs give the 300 default as the scroll distance, while the skill also lists `_kad_element_width` default 300 (px width); check which is which. [fixed-section-hooked-elements]
9. **CPT Customizer sections (resolves an open item).** `theme.md:391` marks "{CPT} Layout"/"{CPT} Archive" `[unverified]`. The docs confirm that CPT Layouts and CPT Archives appear under Posts/Pages Layout. [post-page-archive-layout-settings]
10. **Palette JSON export.** `research-references.md:117` says "palettes can be exported and imported as JSON. Source: search snippets... (not fetched in full)". It is now confirmed: a folder icon > Export/Import tab with a JSON text area, then an Import button. [theme-color-palette]
11. **Template Element for HTML.** The html-editor doc says to "select the Template Element type to begin creating a new HTML Element". This is a doc error: the skill and the other docs have a separate HTML Editor type. Do not copy it. [html-editor-hooked-elements]
12. **Contact item.** The add-contact-information doc says to drag the "Social" item to add contact information. This looks like a doc error (the item is "Contact"). [add-contact-information]
13. **Placement label drift inside the docs.** "Replace Archive Page Content" vs "Replace Archive Content"; "Replace Archive Loop Item" vs "Replace Archive Loop Item Content"; "Fixed On Bottom After Scroll (No Space Below Footer)" vs the skill's "Fixed Bottom After Scroll (no space below footer)". The skill's code labels should win. [create-a-custom-archive-template, extend-kadence-infinite-scroll-with-dynamic-post-content, fixed-section-hooked-elements]
14. **Related posts for CPTs.** `theme.md:209` says related posts are hard-wired to post type `post`. The doc's `kadence_related_posts_args` example sets `post_type` to `array('post','news','article')`. That changes only the query, so related posts still render only on single `post` views. Not a real conflict, but worth a note. [customize-related-posts-with-kadence_related_posts_args]

### 9.2 Blocks guides
1. **Design Library colour mapping (skill marks it open).** LIM:176 says "Two docs disagree … | Not studied | Open"; RR:55 says it was "seen via search snippet only". Full text: customize-design-library-color-palette says Light = `--global-palette9`, Dark = `palette3`, Highlight = `palette1`, and it has a code filter. access-the-design-library says Light #1, Dark #2, Highlight #9. The filter page is more specific, but the conflict needs a runtime check (LIM R1) [customize-design-library-color-palette, access-the-design-library].
2. **Style Library palette import.** LIM:166 already records the docs/code conflict. The docs still say the palette "is imported … From then on, you manage your color palette in the Style Library" (updated 15 Oct 2026). No change; the skill's code verdict stands [how-to-use-the-kadence-style-library].
3. **Custom CSS box scope.** SL:29 and BI:494 say Row Layout, Section and Header Row. The docs name only "Row Layout and Section blocks". The skill is a superset from code; no fix needed. Optionally note that the docs omit Header Row [block-level-custom-css].
4. **Query Loop transport.** RR:99 says "filtering uses admin-ajax.php". The troubleshooting doc says the block "relies heavily on the WordPress REST API" with endpoint `/wp-json/wp/v2/kadence_query/query`. The main doc still mentions admin-ajax.php. Record both and verify which one front-end filtering calls [troubleshoot-query-loop-adv-filters-and-search, advanced-query-loop-block].
5. **Reindex method.** BP:132 gives only `?kbp-reindex-facets=<n>`. The docs give the UI button Kadence > Queries > Force Reindex. This is a complement, not a contradiction [troubleshoot-query-loop-adv-filters-and-search].
6. **Mega menu Pro status.** BI:371 says "Whether mega menu needs Pro: `[unverified]`". The docs say mega menus, link media and highlight labels are Pro [navigation-link-block-tips, advanced-header-navigations].
7. **Header choice on the classic theme.** BI:382 says "this study does not cover how the theme picks one over the other `[unverified]`". The docs give the order Customizer block header (global), then Element "Replace Header" (wins on match), then manual Disable Header plus block [use-advanced-headers-globally-conditionally].
8. **FSE.** headers-footers-full-site-editing still says "Kadence does not provide an FSE theme". The skill already records this as outdated (LIM:181, RR:166). No change.
9. **Header admin path naming.** Docs use both "Kadence -> Advanced Headers" and "Kadence -> Headers" / "Kadence Headers". The skill uses the Headers post type under the Kadence menu. Cosmetic only.

### 9.3 General docs
1. `references/limitations.md:37` "Uploaded custom fonts have no UI; only filters" and `references/recipes.md:61` "Uploaded (non-Google) fonts have no theme UI; needs filter". Docs: a separate Kadence Custom Fonts plugin gives an upload and Adobe Typekit UI with Theme Kit Pro or a plan [add-custom-fonts-to-kadence]; CPT `kt_font` [reserved-slugs-and-terms]. True for the theme alone, but the skill should name the plugin before the PHP filter (Kadence-first order).
2. `references/research-references.md:108` "Premium patterns need Creative Kit or Blocks Pro". Docs: premium Starter Templates and designs need Creative Kit, or Blocks Pro AND Theme Kit Pro on the same licence key [kadence-starter-templates, kadence-ai-powered-starter-templates]; "Creative Kit or the Pro add-ons" [introducing-kadence-theme]. Blocks Pro alone is not stated as enough.
3. `references/research-references.md:168` treats the Design Library palette mapping as conflicting (1/2/9 vs 3/1/9). This group's current page repeats Light = palette 1, Dark = palette 2, Highlight = palette 9 [kadence-ai-powered-design-library]. Still unverified in code; one more doc for the 1/2/9 side.
4. `references/research-references.md:117` "palettes can be exported and imported as JSON" (search snippet). This group never mentions palette JSON; the documented import/export is the Starter Templates plugin's "Customizer Import/Export settings" (lost if the plugin is removed) [starter-templates-faqs-troubleshooting] and Header/Navigation ZIPs [import-export]. Verify in code before relying on palette JSON.
5. `references/research-references.md:112` / `limitations.md:166` (Customizer palette imported into Style Library on update). Not contradicted here; [introducing-kadence-theme] (20 Nov 2026) still says palette and fonts are set "in the global palette and typography settings" and the theme, Blocks and Design Library all use that same palette, consistent with the skill's code finding that the Customizer stays the source.
6. Internal doc conflict to record, not a skill conflict: Conversions trigger units. [launch-triggers] says time delay in milliseconds and scroll distance in pixels, six triggers including end of content and on load; [install-activate-kadence-conversions] (Nov 2026) says seconds and percentage scrolled, and lists "user click". Check the installed Conversions UI.
7. Internal skill inconsistency noticed while checking (not from docs): `references/recipes.md:59` names the palette option `kadence_color_palette`; `references/environment-check.md` and `blocks-inventory.md:543` say `kadence_global_palette`. Worth fixing.
8. `references/research-references.md:161` / `limitations.md:41` say FSE mode needs WordPress 7.1+. [introducing-kadence-theme] mentions FSE (Alpha) in 1.6.0, off by default, Customizer settings kept so you can switch back; it gives no WP version. No conflict, but "settings stay saved, switch back any time" is a new point.
9. Waypoint guide calls Theme Kit Pro "Kadence Theme Pro" and says Blocks Pro adds "Advanced Navigation" [waypoint-starter-template-...]; the skill treats Navigation (Adv) sub menus as free (`research-references.md` Header section). Marketing wording; trust the code.

### 9.4 Block pages
1. AOS offset default. Skill `responsive-animation.md:191`: "Pixel offset ... | 120 [code]". Doc: offset slider "Default/empty is 0". Code default (120) is probably what applies when empty; the doc describes the field value. [animate-on-scroll-effects]
2. AOS ease default. Skill `responsive-animation.md:188` lists `ease` as global default. Doc: "leave blank for no easing". [animate-on-scroll-effects]
3. Row parallax. Skill `blocks-inventory.md:180`: "Parallax is turned into `fixed` attachment". Doc says parallax is JavaScript-driven (image enlarged, position handled while scrolling; focus ignored). Skill's own `responsive-animation.md:237` (jarallax) agrees with the doc, so line 180 is the outlier or describes only the CSS fallback. [row-layout-block]
4. Logged-in visibility. Skill `blocks-inventory.md:506`: "User-role display: Row Layout only in free". Doc Section page: Section can also be hidden "from logged-in and logged-out users" in Visibility Settings. Needs an editor check. [section-block]
5. Site Identity logo. Skill `blocks-inventory.md:455`: "Logo (uses Advanced Image inside `[unverified]`)". Doc: inner blocks are core Site Logo, Site Title and Site Tagline. [site-identity-block]
6. Conditional Display on Accordion panes and Tabs. Skill `limitations.md:168` says the runtime `ktdynamic` list lacks accordion, pane, tabs, tab. Doc lists "Accordion Block (Individual Panes)" and "Tabs Block (Individual Tabs)". Still needs the editor check the skill already plans. [conditional-display]
7. Form field conditional logic. Skill `blocks-inventory.md:359`: "whether the UI is Pro: `[unverified]`". Doc: Conditional Fields are "a feature available in Kadence Blocks Pro". [advanced-form-block]
8. Posts block mobile columns. Skill `blocks-inventory.md:336`: "`columns` (3) with `tabletColumns`, `mobileColumns`". Doc: columns are set for Desktop and Tablet; "Mobile displays as 1 column". The attribute may exist without a UI control. [posts-block]
9. Navigation Link Pro scope. Skill `blocks-inventory.md:371` says mega menu, link media and highlight labels are Pro. Doc adds that all Navigation Link Style Settings require Blocks Pro. [kadence-navigation-link-block]
10. Video Popup tier. Skill `blocks-inventory.md:464`: "Free since 3.4.4; local video type Pro". The Video Popup page agrees, but the Blocks Pro feature list names "Video Popup Block" as a Pro feature. The docs disagree with each other; the skill's code-based answer is better supported. [video-popup-block][kadence-blocks-pro-plugin]
11. Video Popup cookies. Skill `blocks-inventory.md:436` marks the no-cookie behaviour `[unverified]`. Doc: "Embed YouTube with No Cookies" loads without tracking cookies until Play. [video-popup-block]
12. Progress Bar label position. Skill `blocks-inventory.md:410`: `labelPosition` (above/below). Doc: text can go above, inside or below the bar. [progress-bar-block]
13. Conditional compare list. Skill `dynamic-content-acf.md:220` includes Contains / Doesn't Contain. Doc table stops at `<`. Doc probably incomplete; no change needed. [conditional-display]
14. Google Maps key. Skill `blocks-inventory.md:403`: embed "(default, no key)". Doc: the block "automatically includes an API key" (Kadence default key), and a custom key is required for the JavaScript API. Wording only. [google-maps-block]
15. Button inherit styles. Skill `blocks-inventory.md:252`: `fill` default, `inherit` = theme button style. Doc: Fill takes text and background colours from the theme Base Button Styles, other properties from the block; there is a separate "Theme Base" option. Fill is not purely block-styled. [advanced-buttons]
16. Breakpoint changes. Skill `blocks-inventory.md:21` says breakpoints are "all filterable". Doc: "there are no settings to change the breakpoints", use media queries. No real conflict (no UI setting vs PHP filter); worth one line in the skill. [responsive-breakpoints]
17. Marquee inner blocks. Skill `creative-kit.md:118` lists core paragraph and more from code; doc lists only Text (Adv), Image (Adv), Icon, core Heading, core Image. Doc list is shorter, code wins. [marquee-adv-block]

## 10. Features newer than the code baseline
### 10.1 Theme docs
Version numbers in the theme docs: only "Kadence Pro version 1.0.3" (dark mode) and "Kadence Theme version 1.2.1" (Optimized Group Block). No page states a current Theme or Theme Kit Pro version, so nothing proves a feature is post-1.6.0. These items are absent from the skill and worth checking on the installed version:
- Customizer Typography **Clamp Settings** (Font Size Range, Screen Size Range). The doc says the theme "now includes" it, so it may be newer than 1.6.0. [css-clamp]
- **Accent - Complement linking** (Unlink Color) and the four named palette groups with "Rating". [theme-color-palette]
- **Secondary button "Disable Box Shadow"** toggle and the Button/Hover Shadow controls. [style-buttons]
- **Style Guide** five-section live preview with pencil jumps (the skill only lists the `Style_Guide` component). [theme-style-guide]
- **Enable CSS Preload** UI wording (the skill has the key `enable_preload` only). [performance-settings]
- Social networks **Bluesky, Threads, Rumble, Google Reviews**. [social-media-icons-header]
- Element **Target Language** (the skill has `_kad_element_language`), the **Admin Toolbar element count**, and Elements **ZIP import/export**. [element-settings, use-element-hooks, importing-exporting-elements]
- **Display options for events and brands**: Events Archive, Single Events, Events Category Archives, Brand Archive, Product Brand Archives (Shop Kit). [content-section-hooked-elements]
- All WooCommerce Customizer settings in section 2.10 and the Pro WooCommerce Addons (Sticky Add To Cart, Single Product Ajax Add to Cart, Catalog Off Canvas Sidebar, Custom Shop Page). [woocommerce-customizer-settings, woocommerce-addons]
- Pro cart **free-shipping notice** with `{cart_difference}`. [add-mini-cart-to-header]
- Products named in the docs but not in the skill: Kadence Custom Fonts, Kadence Shop Kit, Kadence Simple Share, Kadence WooCommerce Email Designer, and the Starter Templates plugin's Customizer Import/Export.

### 10.2 Blocks guides
- No doc in this group names a version above the baseline. Versions seen: Style Library "version 3.8.0" (in baseline); Kadence Blocks 3.0 moved sizes to variables (variable-font-sizes); `form-email.php` `@version 1.7.0`.
- Possibly newer, or simply not in the skill (verify against installed code): the Design Library allow-list ("Invalid Request, Unknown Library", `kadence_blocks_allowed_library_urls`, and `get_allowed_library_urls()` in `includes/resources/Traits/API_Url_Trait.php`). The page has no MODIFIED date and reads as new, so it may belong to a release after 3.9.1 [add-a-custom-design-library].
- Captcha doc updated 22 Oct 2026; Kadence CAPTCHA is licensed through the Nexcess Portal [captcha].
- Related teasers (not in this group) mention "Solid Security is becoming Kadence Security" and Kadence Insights A/B testing; those come from other doc groups.
- Style Library details that the skill has only in summary: full default token tables, listed in section 6 below.
