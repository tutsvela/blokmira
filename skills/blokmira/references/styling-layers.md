# Kadence styling layers: who owns what

Purpose: list every place a Kadence site can be styled, which product owns each setting, and the order of precedence, so styling stays editable, global and consistent.

Versions studied: Kadence Theme 1.6.0, Theme Kit Pro 1.2.6, Kadence Blocks 3.9.1, Kadence Blocks Pro 2.8.16, Creative Kit 1.1.4.

Contents
1. The layers, from most global to most local
2. Palette ownership (theme vs Style Library)
3. Layer details
4. Ownership table
5. Safest way to keep a site editable and consistent
6. Common mistakes that stop blocks following global design

Ref codes as in `recipes.md` section 1 (TH, GD, TKP, BI, BP, DC, CK, RA, RR). Tags: `[code]`, `[runtime]`, `[docs]`, `[unverified]`.

---

## 1. The layers, from most global to most local

| # | Layer | Owner | Stored in | Scope | Ref |
|---|---|---|---|---|---|
| 1 | Customizer global tokens: palette, typography, buttons, layout widths, link colours | Theme | `kadence_global_palette` option (palette); theme mods (rest) | Whole site, printed as `--global-*` variables | GD 1, 9 [code] |
| 2 | Style Library design tokens and presets | Kadence Blocks 3.8+ | `{prefix}kb_design_tokens` tables, `kadence_blocks_design_tokens_active_library` | Overrides palette and button slots it sets; adds spacing, font-size, radius scales and block presets | BI 4.4 [code] |
| 3 | Theme Kit Pro modules (dark palette, conditional header settings, mega menu item styles) | Theme Kit Pro | Module options, menu item meta | Swaps values per visitor or per page | TKP 5, 6, 7 [code] |
| 4 | Block Defaults | Kadence Blocks (and Pro blocks) | `kadence_blocks_config_blocks` | Copied into a block when it is inserted | BI 4.5 [code] |
| 5 | Block-level controls (per block, per device, per state) | Kadence Blocks, Blocks Pro | Block attributes in post content | One block | BI 3, 4.1 [code] |
| 6 | Custom class and anchor | Core block Advanced panel | Block attributes | One block, targetable from CSS | BI 4.6 [code] |
| 7 | Per-block Custom CSS box (`kbcss`) | Kadence Blocks | Block attribute | Row Layout, Section, Header Row only | BI 4.2 [code] |
| 8 | Per-post Custom CSS and JS ("Page Scripts") | Blocks Pro | Post meta `_kad_blocks_custom_css` etc. | One post or Element | BP 5.5 [code] |
| 9 | Core Additional CSS | WordPress core | Customizer `custom_css` | Whole site | GD 7 [runtime] |
| 10 | Child theme or plugin CSS files | Developer | Version control | Whole site | (decision framework level 5) |

Precedence in practice: block-level values beat Style Library presets, which beat theme defaults (lookup order "block, then preset, then theme default") `[docs]` (RR 2). A Style Library palette token beats the Customizer value for the same slot on the front end `[code]` (BI 4.4). Custom CSS layers (7 to 10) win by normal CSS specificity and load order.

## 2. Palette ownership (theme vs Style Library)

- The stored source is always the theme option `kadence_global_palette`: three sets (`palette`, `second-palette`, `third-palette`) and an `active` pointer (BI 4.4, GD 2.2) `[code]`.
- Kadence Blocks 3.9.1 does not copy the Customizer palette into its tables. It reads the active set live as the baseline, then overrides slots at read time through the theme filter `kadence_palette_option` (BI 4.4, GD 2.6) `[code]`.
- A slot set in the Style Library wins on the front end. A slot never set there, or reset, uses the Customizer value (BI 4.4) `[code]`.
- Non-active sets (for example `second-palette`, used by Theme Kit Pro dark mode) are left alone, except when a slot has the same colour in both sets (BI 4.4) `[code]`.
- Customizer live preview bypasses the filter, so an overridden slot shows the Customizer colour until a full reload (GD 2.6) `[code]`.
- Button colour tokens claim the theme's `palette-btn-*` slots the same way (BI 4.4) `[code]`.
- In the theme's FSE mode (Alpha, off by default) the Site Editor owns the palette instead (GD 2.5) `[code]`.

Rule: choose one owner for colours. When a dark palette is used, keep palette and button colours in the Customizer and leave the Style Library palette and button tokens unset. Use the Style Library for scales and presets the theme does not own (BI 4.4) `[code]`.

## 3. Layer details

### 3.1 Theme Customizer and global tokens
- Colours & Fonts: palette, typography, Base/Secondary/Outline buttons (GD 1) `[runtime]`.
- General > Layout: content widths, edge spacing, boxed shadows and radii (GD 4) `[code]`.
- Header, Footer, Posts/Pages Layout, per CPT sections: every builder item has its own colour, typography, border and spacing controls (TH 2 to 4) `[runtime]`.
- Output: inline CSS after `kadence-global`, server-side, cache-friendly (GD 1) `[code]`.
- Static helpers that never change with the palette: `--global-gray-400`, `--global-gray-500` (GD 6) `[code]`.
- No global shadow or radius scale in the theme (GD 6) `[code]`.

### 3.2 Style Library (Kadence Blocks 3.8+)
- Kadence > Style Library, capability `edit_theme_options` (BI 4.4) `[code]`.
- Tokens: palettes, six text sizes, eight radius steps, three border widths, ten spacing steps, three icon sizes, three shadows `[docs]` (RR 2).
- Output: `--kb-token--…`, `--global-kb-spacing-*`, `--global-kb-gap-*`, `--global-kb-font-size-*`, preset classes `kb-preset--<slug>`, `[data-kb-palette]` scopes (BI 4.4) `[code]`.
- Block presets (`kbPreset`): Row Layout, Section, Advanced Text, Single Button, Single Icon, Advanced Image (BI 4.2) `[runtime]`. Info Box has none `[docs]` (RR 2).
- Hand-picked values are not linked to tokens `[docs]` (RR 2).

### 3.3 Block-level styling
- Colour controls store `palette1`..`palette15` and render `var(--global-paletteN, fallback)`; a custom hex is stored literally (BI 4.1) `[code]`.
- Typography objects per device; Google fonts queued per block (BI 4.1) `[code]`.
- Font size presets `sm`..`3xl` are fluid `clamp()` values (RA 5) `[code]`.
- Spacing presets `xxs`..`5xl`, gap presets `skinny`..`widest` (RA 5) `[code]`.
- Responsive patterns: three-value arrays, separate device keys, four-side arrays with device prefix, device objects with enable flag (RA 2) `[code]`.

### 3.4 Block Defaults
- Kadence Blocks Controls (editor top bar) > Block Defaults; Pro blocks have "Block Defaults" buttons (BI 4.5, BP 5.6) `[code]`.
- Applied at insert time only. Changing a default later does not update existing blocks (BI 4.5) `[code]`. `noCustomDefaults` skips them (BI 4.1) `[code]`.

### 3.5 Custom class and anchor
- Advanced panel "Additional CSS class(es)" and HTML anchor on most blocks; Marquee supports `anchor` (BI 4.6, CK 3) `[code]`.
- A custom class is portable. The generated `uniqueID` class may change when a block is duplicated `[unverified]` (BI 4.6).
- Page-level class: post meta `_kad_post_classname` adds a body class (TH 5) `[code]`.

### 3.6 Per-block Custom CSS (free)
- `kbcss` support exists only on Row Layout, Section and Header Row. The word `selector` is replaced by the block selector (BI 4.2) `[code]`.
- Printed as `kadence_blocks_custom_css` inline style (BI 4.6) `[code]`.
- Lives in post content, so it is not versioned and is easy to forget. Every use should say why it is not a block setting.

### 3.7 Blocks Pro per-post CSS and JS
- Editor > "Page Scripts" > "Custom CSS and JS" on viewable post types `[Pro]` (BP 5.5) `[code]`.
- Meta `_kad_blocks_custom_css`, `_kad_blocks_head_custom_js`, `_kad_blocks_body_custom_js`, `_kad_blocks_footer_custom_js`, printed raw on singular views and for Elements (BP 5.5, TKP 4.11) `[code]`.
- Security: see `limitations.md` section 4. Prefer versioned files.

### 3.8 Core Additional CSS
- Customize > Additional CSS (`custom_css`). The theme adds no CSS box of its own; Theme Kit Pro Custom Scripts is for scripts, not CSS (GD 7) `[runtime]`.

### 3.9 States, effects and layout
- **Hover**: Section Hover Styles (background, image, gradient, overlay, border, radius, shadow, text and link colours); Single Button hover colours, gradient, border, shadow, icon reveal; Info Box hover; Gallery hover captions; Image Overlay hover `[Pro]`; theme button hover colours and hover shadow (RA 10) `[code]`.
- **Active**: Tabs title active style; Accordion active border; Navigation (Adv) active colours; theme `primary_navigation_parent_active` (BI 3.8, 3.9, 3.18, TH 2.2) `[code]`.
- **Focus**: theme input focus colours (static CSS); Search (Adv) focus colours. No general `:focus-visible` control (GD 5, BI 3.26, 4.7) `[code]`.
- **Sticky and transparent header states**: Single Button, Advanced Image, Navigation (Adv) have separate sticky and transparent styles inside Header (Adv); theme Sticky and Transparent Header design sections (BI 3.4, 3.19, TH 2.5, 2.6) `[code]`.
- **Gradients**: Row background and overlay, Section background and overlay (with hover), Advanced Text text gradient, Single Button background and text gradient, Marquee background, Search (Adv) input background (BI 3.1 to 3.4, 3.26, CK 3) `[code]`.
- **Background images and overlays**: Row Layout (per device, slider, video, parallax, blend mode); Section (normal and hover); theme hero backgrounds per post type (BI 3.1, 3.2, GD 6) `[code]`.
- **Borders and radius**: per-device `borderStyle` objects and radius on most blocks; Row `borderRadiusOverflow` clips content (BI 3.1, 4.1) `[code]`.
- **Shadows**: `boxShadow` / `shadow` arrays on Row, Section (with hover), Info Box, Gallery, Image, buttons (BI 4.1) `[code]`.
- **Backdrop filter**: Section and Header (Adv) `[Pro]` (BP 4) `[code]`.
- **Flex, grid, alignment**: Row Layout is a CSS grid with preset layouts, gutters, vertical alignment, "Bento & Grid" toggles; Section has `direction`, `justifyContent`, `wrapContent`, `gutter`, `rowGap`, `flexBasis`, `flexGrow`, `gridArea`; Advanced Buttons orientation and gap per device (BI 3.1, 3.2, 3.4, RA 3) `[code]`.
- **Z-index and positioning**: `zIndex` on Row, Section, Advanced Image, Marquee (adds `position:relative`) (BI 3.1, 3.2, 3.20, CK 3) `[code]`. Fixed positioning: Element Fixed Sections `[TKP:elements]` (TKP 4.4) `[code]`. A general absolute-position control was not found in the attributes studied `[unverified]`.
- **Sticky**: theme sticky header; Header (Adv) sticky; Section "Make sticky" (sets `#wrapper.site { overflow: clip }`); sidebar `sidebar_sticky`; Table (Adv) sticky row/column `[Pro]` (RA 7, TH 4.5, BP 4) `[code]`.
- **Visibility**: device hiding on Row, Section, Spacer, Countdown (CSS only); Element device rules (CSS only, 719/720 px); Row user rules (server); Conditional Display `[Pro]` (server); Element Show/Hide/user rules `[TKP:elements]` (server) (RA 4, BI 4.3, DC 9) `[code]`.
- **Animation**: Animate on Scroll `[Pro]` on `ktanimate` blocks; theme dropdown and off-canvas animations; Modal animate in/out `[Pro]` (RA 8, 9) `[code]`.
- **Transforms**: none native (no transform or hover-transform attributes in any block) (RA 10, 11) `[code]`.

## 4. Ownership table

| Setting | Theme | Kadence Blocks | Blocks Pro | Theme Kit Pro | Notes |
|---|---|---|---|---|---|
| Palette colours | Owner: 15 slots, 3 sets, active set | Style Library can override active slots | none | Dark Mode swaps to a second set | Edit in one place (section 2) |
| Typography (body, headings) | Owner: `base_font`, `h1_font`..`h6_font` | Per-block typography; Style Library text sizes | none | none | Leave block font family empty to inherit |
| Font size scale | `--global-font-size-*` (core presets) | `--global-kb-font-size-*` fluid presets | none | none | Two scales exist; pick one per project |
| Spacing scale | Static `--global-*-spacing`; core presets only with `theme_json_mode` | `--global-kb-spacing-*` presets | none | none | Kadence presets work without theme.json |
| Content widths | Owner: `content_width`, narrow, edge spacing | Row `inheritMaxWidth` uses theme width | none | none | Editor wide width differs slightly |
| Buttons | Owner: Base, Secondary, Outline | Single Button `inheritStyles`; Style Library button tokens | none | Header Button 2 item | Inherit, do not restyle each button |
| Links | `link_color`, per-area link colours | Block link and hover colours | none | none | Palette slots |
| Form inputs | Static CSS on palette slots, no controls | Advanced Form field styles | Form pro options | none | Third-party forms need their own styling |
| Block colours | n/a | Palette picker (stores `paletteN`) | none | none | Hex breaks dark mode |
| Block Defaults | n/a | Owner (`kadence_blocks_config_blocks`) | Defaults for Pro blocks | none | Insert time only |
| Block presets | n/a | Style Library `kbPreset` (6 blocks) | none | none | Info Box not covered |
| Custom class / anchor | Body class via `_kad_post_classname` | Advanced panel | none | none | Prefer class over `uniqueID` |
| Per-block Custom CSS | n/a | Row, Section, Header Row only | none | none | `selector` placeholder |
| Per-post CSS / JS | n/a | n/a | Owner (Page Scripts) | Element outputs Pro meta too | Unescaped, unversioned |
| Site CSS | Core Additional CSS | n/a | n/a | Custom Scripts (scripts only) | Prefer versioned files |
| Hover states | Theme buttons, nav, dropdown | Section, buttons, Info Box, Gallery, text links | Image Overlay, Portfolio Grid | Mega menu item colours | No hover transforms |
| Active / focus states | Nav parent active; input focus (static) | Tabs, Accordion, Navigation active; Search focus | none | none | `:focus-visible` needs CSS |
| Gradients | Hero background `[unverified]` | Row, Section, text, buttons, Search | none | none | Gradient stops can be palette slots |
| Background images, overlays | Site, content, hero backgrounds | Row (per device), Section (hover) | Dynamic backgrounds | Archive term hero image (`archive_meta`) | Fixed attachment off on tablets |
| Borders, radius | Boxed and grid radius, image radius | Per-device borders and radius on most blocks | none | none | No global radius scale in theme; Style Library radius steps `[docs]` |
| Shadows | Boxed, grid, button shadows | Row, Section, Info Box, Image, buttons | none | none | Style Library three shadows `[docs]` |
| Backdrop filter | none | none | Section, Header (Adv) | none | |
| Flex / grid / alignment | Footer row layouts | Row grid, Section flex/grid, button group | none | none | Max 6 Row columns |
| Z-index / positioning | none | `zIndex` on Row, Section, Image | none | Fixed Sections | Creative Kit Marquee also `zIndex` |
| Sticky | Header, mobile header, sidebar | Header (Adv), Section | Table sticky row/column | Fixed Sections | Section sticky has no mobile toggle |
| Visibility by device | Header desktop/mobile builders, item visibility | Row, Section, Spacer, Countdown (CSS) | none | Element device rules (CSS, 719/720) | Not for private content |
| Visibility by user or data | Per-post disable header/footer | Row logged-in/role rules | Conditional Display | Elements, Conditional Headers | Server-side; needs cache variation for login |
| Animation | Dropdown, off-canvas, smooth scroll | Typed text, counters, carousels, parallax | Animate on Scroll, Modal | none | Creative Kit AOS only without Pro |
| Transforms | none | none | none | none | Custom CSS only |
| Dark mode | Palette set switch (site-wide) | Follows `--global-paletteN` | none | Visitor toggle | Hex and gray helpers do not switch |
| Site Styles (Global Styles) | FSE mode only | 18 blocks in Site Editor > Styles in FSE mode | none | none | Off on classic sites |

## 5. Safest way to keep a site editable and consistent

1. **Tokens first.** Set the palette, typography, buttons and widths in the Customizer before building pages (GD 1).
2. **One colour owner.** Keep palette and button colours in the Customizer when a dark palette is used; leave Style Library palette and button tokens unset, and check them before any palette change (BI 4.4).
3. **Palette slots only.** Pick swatches, never a custom hex, in every block and Customizer control (GD 10).
4. **Presets over numbers.** Use Kadence font size and spacing presets; they are fluid and global (RA 5).
5. **Inherit buttons.** Single Button `inheritStyles` `inherit` or `inherit-secondary` (GD 5).
6. **Set Block Defaults early.** They only apply to new blocks (BI 4.5).
7. **Name blocks in List View** (`kbMetadata`) so the structure is clear without reading code (BI 4.2).
8. **Reuse through Elements or synced patterns**, with conditions in Elements, rather than copying sections (TKP 9).
9. **Responsive values together.** Set desktop, tablet and mobile in one pass, then test 720 to 767 px (RA 1).
10. **Custom CSS last.** Scope it to a custom class, use `var(--global-*)` tokens, keep it in versioned files, and record why no native control exists (decision framework).
11. **Editor matches front end.** Theme variables and fonts load in the editor iframe; Element and Query Card previews need a real preview post (TH 1.5, TKP 4.10).

## 6. Common mistakes that stop blocks following global design

1. Custom hex in a colour picker or CSS: does not follow palette changes or dark mode (GD 10).
2. Fixed px font sizes where global heading sizes or presets would do (GD 10).
3. Setting a font family on each block (GD 10).
4. Non-inherit button styles, then restyling buttons one by one (GD 10).
5. Using `--global-gray-400/500` or `--global-palette9rgb` and expecting them to switch with dark mode (GD 10).
6. Relying on `--global-h1-font-family` etc.; not output in 1.6.0 (GD 3).
7. Assuming core spacing presets exist without `theme_json_mode` (GD 4).
8. Editing the same palette slot in the Customizer and the Style Library (BI 4.4).
9. Overriding Customizer CSS with `!important` instead of changing the setting (GD 10).
10. Expecting a changed Block Default to update existing blocks (BI 4.5).
11. Targeting the generated `uniqueID` class from CSS instead of a custom class (BI 4.6).
12. Putting project CSS in Page Scripts or per-block CSS boxes, where it is unversioned and invisible (BP 5.5).
13. Hiding content per device and assuming it is gone; it is CSS only (RA 4).
14. Building with HTML Editor Elements instead of blocks; they skip Kadence block CSS and are not visually editable (TKP 4.13).
15. Switching a classic site to FSE mode without a rebuild plan; ownership of palette, widths, fonts and buttons moves to the Site Editor (TH 1.5).
