# Kadence Theme global design system: palette, typography, widths, buttons and CSS variables

Purpose: show where each global design value lives in the Kadence Theme, which CSS variable it becomes, and how blocks inherit it, so designs are built from global slots instead of hard-coded values.

Versions studied: Kadence Theme 1.6.0 (`themes/kadence/`), with notes on Theme Kit Pro 1.2.6 and Kadence Blocks 3.9.1 where they touch the theme palette.

Contents
1. Where global settings live
2. Palette (15 slots, 3 palettes, CSS variables, editor, design tokens)
3. Typography and font loading
4. Content widths and spacing
5. Buttons, links, form inputs
6. Borders, radius, shadows, backgrounds, images
7. Custom CSS
8. Dark mode
9. CSS custom properties the theme outputs
10. How blocks inherit, and mistakes that break inheritance
11. Gaps

Tags as in `theme.md`: `[code]` paths relative to `themes/kadence/` unless prefixed, `[runtime]` from the runtime capture.

---

## 1. Where global settings live
Customizer > Colors & Fonts (panel `kadence_customizer_design`) [runtime]:
- Colors: section `kadence_customizer_general_colors`, controls `kadence_color_palette`, `site_background`, `content_background`, `above_title_background`, `above_title_overlay_color`, `link_color`.
- Typography: `kadence_customizer_general_typography`, controls `base_font`, `load_base_italic`, `heading_font`, `h1_font`..`h6_font`, `title_above_font`, `title_above_breadcrumb_font`, `font_rendering`, `google_subsets`.
- Buttons: `kadence_customizer_general_buttons` (Base Button Styles), `kadence_customizer_secondary_button`, `kadence_customizer_outline_button`.
Customizer > General: Layout (`kadence_customizer_general_layout`), Images (`image_border_radius`), Performance (`load_fonts_local`, `preload_fonts_local`, `enable_preload`, `theme_json_mode`, `lightbox`, `enable_scroll_to_id`, `microdata`, `disable_sitemap`) [runtime].

Storage: theme options are theme mods by default (`kadence_theme_option_type`, `inc/components/options/component.php:226`); the palette is a separate site option `kadence_global_palette` (JSON) (`inc/components/color_palette/component.php:51-61`, read at `options/component.php:5028`) [code].

All CSS is printed inline after `kadence-global` (`inc/components/styles/component.php:102-125`, `wp_add_inline_style`), generated in `generate_base_css()` (:1702), `generate_header_css()` (:728), `generate_footer_css()` (:378). It is server-side, so it works with page caching [code].

---

## 2. Palette

### 2.1 Slots and names
15 slots, defaults in `inc/components/options/component.php:4936-4990`; editor names in `inc/components/color_palette/component.php:147-226` and `theme.json:13-90` [code].

| Slot | CSS variable | Editor name | Default | Default role in theme |
|---|---|---|---|---|
| palette1 | `--global-palette1` | Accent | #2B6CB0 | link color, button background |
| palette2 | `--global-palette2` | Accent - alt | #215387 | link hover, button hover background |
| palette3 | `--global-palette3` | Strongest text | #1A202C | headings h1-h6 color |
| palette4 | `--global-palette4` | Strong Text | #2D3748 | body text color |
| palette5 | `--global-palette5` | Medium text | #4A5568 | input text, meta |
| palette6 | `--global-palette6` | Subtle Text | #718096 | subtle text, input focus border |
| palette7 | `--global-palette7` | Subtle Background | #EDF2F7 | subtle backgrounds |
| palette8 | `--global-palette8` | Lighter Background | #F7FAFC | site background |
| palette9 | `--global-palette9` | White or offwhite | #ffffff | content background, button text, input background |
| palette10 | `--global-palette10` | Accent - Complement | #FfFfFf (special) | computed complement of palette1 |
| palette11 | `--global-palette11` | Notices - Success | #13612e | notices |
| palette12 | `--global-palette12` | Notices - Info | #1159af | notices |
| palette13 | `--global-palette13` | Notices - Alert | #b82105 | notices |
| palette14 | `--global-palette14` | Notices - Warning | #f7630c | notices |
| palette15 | `--global-palette15` | Notices - Rating | #f5a524 | star ratings |

Role defaults come from option defaults: body `base_font.color = palette4` (`options/component.php:751-765`), headings `palette3` (:771-797), `link_color` highlight `palette1` / alt `palette2` (:425-429), buttons color `palette9` and background `palette1`/`palette2` (:509-516), site background `palette8`, content background `palette9` (:347-356) [code].

Palette10 rule: when its stored color is exactly `#FfFfFf`, the theme outputs an `oklch(from var(--global-palette1) ...)` complement instead (filter `kadence_palette_complement_color`, `options/component.php:5041-5044`) [code]. If you set palette10 to a real color, that color is used.

### 2.2 Three palettes and the active one
The stored JSON has `palette`, `second-palette`, `third-palette` (each 15 slots) and `active` (`options/component.php:4938-4988`) [code]. The Customizer palette control lets you edit the three sets and choose which is active; only the active set is output (`customizer_palette_option()`, `options/component.php:5021-5050`, filter `kadence_active_palette`) [code]. This is a "palette switch" for the whole site, not a visitor toggle. Theme Kit Pro Dark Mode uses a second set for its visitor toggle (section 8).

### 2.3 How the variables are generated
- `generate_base_css()` writes `:root { --global-palette1 ... --global-palette15 }` from `kadence()->palette_option()` (`inc/components/styles/component.php:1740-1755`) [code]. Root selector filterable (`kadence_root_css_selector`, :1708).
- Also `--global-palette9rgb` (r,g,b of palette9, used in rgba overlays) (:1757-1758) and `--global-palette-highlight`, `-highlight-alt`, `-highlight-alt2` from `link_color` (:1759-1761) [code].
- Any Customizer color control that stores `paletteN` is rendered as `var(--global-paletteN)` (`inc/class-kadence-css.php:686-694`, `render_color`) [code]. This is why choosing a palette swatch in any Kadence control keeps the setting linked to the palette.
- Palette classes: `:root .has-theme-paletteN-color` / `-background-color` (and `theme-palette-N` variants) map to the variables (front end `assets/css/global.min.css`; editor `styles/component.php:3275+`) [code].
- Editor: same variables in `generate_editor_css()` (`styles/component.php:3202-3230`), plus `editor-color-palette` theme support with resolved hex values (`color_palette/component.php:147-226`) and the theme.json palette with `var()` values (section 1.4 of `theme.md`) [code].

### 2.4 Palette in the editor
- Core blocks: picking "Accent" etc. stores slug `theme-palette1`, giving class `has-theme-palette1-color`, which resolves to `var(--global-palette1)`. Change the palette later and the block follows [code].
- Kadence Blocks: color pickers offer the same palette; selected palette colors are saved as `palette1`..`palette15` references and rendered as `var(--global-paletteN)` (Kadence Blocks behaviour, see the blocks docs) [unverified here; check a saved block's attributes].
- Customizer palette editing uses postMessage live preview (`color_palette/component.php:41`) [code].

### 2.5 Full Site Editing mode
In FSE mode (off by default, option `kadence_fse_mode`) the Site Editor owns the palette: presets hold real colors and `--global-paletteN` is redefined as `var(--wp--preset--color--theme-palette-N)` (`src/FSE/Palette_Shim.php:14-31`). The Customizer palette control is replaced with a notice (`color_palette/component.php:87-115`) and saving the palette in the Customizer is refused (`validate_palette`, :131-136) [code]. See `theme.md` section 1.5.

### 2.6 Kadence Blocks design tokens and the theme palette
- The theme itself has no design-token or palette-sync code (search for `design_tokens`, `palette_sync`, `kadence_blocks` in the theme found none related) [code].
- Kadence Blocks 3.8.0+ reads the theme's `kadence_global_palette` option as the Style Guide baseline (`kadence-blocks/includes/resources/Design_Tokens/Theme_Style_Guide/Style_Guide_Reader.php:30`, `:117`) [code].
- It then overrides palette colors at read time by hooking the theme filter `kadence_palette_option` (`kadence-blocks/includes/resources/Design_Tokens/Projection/Kadence_Option/Provider.php:44`, `Palette_Filter.php`). The stored theme option is never written; tokens win wherever the theme prints a palette color, for whichever set is active [code, from the class docblock].
- Known limit stated in that docblock: the Customizer live preview writes the control value straight to `--global-paletteN`, so while editing the palette in the Customizer you see the theme color, and the token color returns on the next full page load [code].
- Practical rule: if Kadence Blocks design tokens are active on a site, decide one place to edit colors (the Blocks Style Library) and avoid editing the same slots in the Customizer, or the two will disagree until reload. Check the blocks study for where the Style Library UI lives.

---

## 3. Typography and font loading
- Controls (section `kadence_customizer_general_typography`): `base_font` (family, weight, size, line height, letter spacing, color, responsive), `heading_font` (family only, inherited by h1-h6), `h1_font`..`h6_font` (size, line height, weight, color, responsive), `title_above_font` (hero H1), `title_above_breadcrumb_font` (`inc/customizer/options/general-typography-options.php:21-249`) [code][runtime].
- Defaults: system font stack, 17px, line height 1.6, color palette4; h1 32px, h2 28px, h3 24px, h4 22px ..., weight 700, color palette3 (`options/component.php:751-830`) [code].
- Output: `body, input, select, optgroup, textarea` get the base font; `h1,h2,h3,h4,h5,h6 { font-family: var(--global-heading-font-family) }`; each heading gets its own size/weight/color; tablet and mobile sizes are printed in `(max-width: 1024px)` and `(max-width: 767px)` queries (`styles/component.php:1840-1900`) [code].
- Font variables: `--global-body-font-family`, `--global-heading-font-family`, `--global-primary-nav-font-family`, `--global-fallback-font`, `--global-display-fallback-font` (:1782-1795). `--global-h1-font-family` .. `--global-button-font-family` exist only as commented-out lines in 1.6.0 (:1784-1793), so do not rely on them [code].
- Font size presets (core "Small".."XX-Large"): `--global-font-size-small`, `-medium`, `-large`, `-larger`, `-xxlarge`, defined as `clamp()` fluid values in `assets/css/global.min.css` and mapped in theme.json `fontSizes` (`theme.json:140-168`) [code]. Using these presets in blocks keeps text fluid and global.
- Google fonts: chosen fonts are collected and loaded from Google by default; `load_fonts_local` downloads and serves them locally (`styles/component.php:207-213`, `inc/class-local-gfonts.php`), `preload_fonts_local` preloads them (:208). Subsets via `google_subsets`. Filters `kadence_theme_google_fonts_array`, `kadence_display_swap_google_fonts` (`styles/component.php:4700-4756`) [code]. For privacy and performance, turn on local loading.
- Custom (uploaded) fonts: filter `kadence_theme_custom_fonts` / `kadence_theme_add_custom_fonts` add them to the font list (`inc/customizer/class-theme-customizer.php:201`, `:1973`) [code].
- Editor: the same Google font URL is added with `add_editor_style` (`inc/components/editor/component.php:304-323`) and as a `wp-block-library` dependency (`styles/component.php:4359-4399`) [code].

---

## 4. Content widths and spacing
- Controls (General > Layout): `content_width` (default 1290px), `content_narrow_width` (842px), `content_edge_spacing` (1.5rem desktop, responsive), `content_spacing` (vertical space above/below content: 5/3/2 rem), `boxed_spacing` (padding inside boxed content: 2/2/1.5 rem), `boxed_shadow`, `boxed_border_radius`, `boxed_grid_spacing`, `boxed_grid_shadow`, `boxed_grid_border_radius` (`options/component.php:263-330`) [code][runtime].
- Variables (`styles/component.php:1796-1808`): `--global-content-width`, `--global-content-wide-width` (content width + 230px for px units, filter `kadence_align_wide_array`), `--global-content-narrow-width`, `--global-content-edge-padding`, `--global-content-boxed-padding`, `--global-calc-content-width` (width minus both edge paddings), and in classic mode `--wp--style--global--content-size: var(--global-calc-content-width)`. `--global-vw` on `.wp-site-blocks` [code].
- Editor variant: the editor uses `+160px` for wide width (`--global-calc-wide-content-width`, `--global-content-narrow-wide-width` +260px) (`styles/component.php:3254-3262`) [code]. Wide blocks can look slightly narrower in the editor than on the front end.
- theme.json maps `contentSize` and `wideSize` to these variables (`theme.json:94-97`) [code].
- Spacing scale (static, `assets/css/global.min.css`): `--global-xs-spacing: 1em`, `--global-sm-spacing: 1.5rem`, `--global-md-spacing: 2rem`, `--global-lg-spacing: 2.5em`, `--global-xl-spacing: 3.5em`, `--global-xxl-spacing: 5rem`, `--global-edge-spacing: 1.5rem`, `--global-boxed-spacing: 2rem` [code]. These are not Customizer settings. They appear as core spacing presets only when `theme_json_mode` is on (`theme.json:103-138`; not in the injected data, `editor/component.php:192-203`) [code].
- Breakpoints: mobile `(max-width: 767px)`, tablet `(max-width: 1024px)`, desktop `(min-width: 1025px)`, filterable (`styles/component.php:1705-1707`) [code]. Kadence Blocks uses the same breakpoints by default [unverified here].

---

## 5. Buttons, links, form inputs

### Buttons
- Base buttons (`kadence_customizer_general_buttons`): `buttons_color`, `buttons_background`, `buttons_border_colors`, `buttons_border`, `buttons_border_radius`, `buttons_typography`, `buttons_padding`, `buttons_shadow`, `buttons_shadow_hover`. Secondary: `buttons_secondary_*`. Outline: `buttons_outline_*` [runtime].
- Variables: `--global-palette-btn-bg`, `-btn-bg-hover`, `-btn`, `-btn-hover`; `--global-palette-btn-sec-bg`, `-sec-bg-hover`, `-sec`, `-sec-hover`; `--global-palette-btn-out-bg`, `-out-bg-hover`, `-out`, `-out-hover` (`styles/component.php:1763-1779`) [code].
- Selectors styled by the global button: `button, .button, .wp-block-button__link, .wp-element-button, input[type=button|reset|submit]` (`assets/css/global.min.css`) [code]. Outline: `.wp-block-button.is-style-outline`, `.button-style-outline`, `.kb-btn-global-outline`. Secondary: `.button-style-secondary` [code].
- Kadence Blocks Advanced Button "inherit" styles add `kb-btn-global-inherit` (and `button-style-secondary` or `kb-btn-global-outline`) so they follow these settings (`kadence-blocks/includes/blocks/class-kadence-blocks-singlebtn-block.php:85-87`) [code].
- theme.json disables core button element color, typography, padding and border controls in Global Styles so the Customizer stays the single source (`theme.json:174-201`; `editor/component.php:237-260`) [code].

### Links
- `link_color` with `highlight` (palette1), `highlight-alt` (palette2), `highlight-alt2` (palette9), and `style` (`standard` and others) (`options/component.php:425-429`) [code]. CSS: `a { color: var(--global-palette-highlight) }`, hover/focus `var(--global-palette-highlight-alt)` (`assets/css/global.min.css`) [code].
- Separate link colors and styles exist per area: header HTML, footer rows, sidebar, footer HTML (`*_link_color`, `*_link_style`) [runtime].

### Form inputs
- No Customizer controls for form fields in the free theme [code: no input options in `options/component.php`]. Inputs use static CSS: text `var(--global-palette5)`, border `1px solid var(--global-gray-400)`, radius 3px, background `var(--global-palette9)`; focus changes color to palette3 and border to palette6 (`assets/css/global.min.css`) [code]. They follow the palette automatically. Form plugins with their own styles (for example Fluent Forms) need their own style settings or a small CSS layer that uses the palette variables.

---

## 6. Borders, radius, shadows, backgrounds, images
- Content boxes: `boxed_shadow`, `boxed_border_radius`; archive cards: `boxed_grid_shadow`, `boxed_grid_border_radius` [runtime].
- Backgrounds: `site_background` (palette8), `content_background` (palette9) printed on `body` and `.content-bg, body.content-style-unboxed .site`, responsive (`styles/component.php:1811-1838`) [code]. Per post type: `{type}_background`, `{type}_content_background`; hero: `{type}_title_background`, `_overlay_color`, `above_title_background`, `above_title_overlay_color` [runtime].
- Images: `image_border_radius` (General > Images) [runtime].
- Static helpers: `--global-gray-400: #CBD5E0`, `--global-gray-500: #A0AEC0` (`assets/css/global.min.css`). These are fixed greys, not palette slots, and do not change with the palette [code].
- No global shadow or radius scale variables exist; shadows and radii are per control.

---

## 7. Custom CSS
- Core Additional CSS (section `custom_css`) is available [runtime]. The theme adds no own custom CSS box.
- Theme Kit Pro adds Custom Scripts (`kadence_customizer_scripts`), for header/footer scripts, not CSS [runtime: pro-modules capture][Theme Kit Pro].
- Prefer palette variables in any custom CSS: `color: var(--global-palette3)`, never a hex.

---

## 8. Dark mode
- Free theme: no native dark mode. No `prefers-color-scheme` rules in theme CSS (`assets/css/*.min.css`), and no visitor toggle [code]. You can switch the whole site to a darker second or third palette with the active palette choice (section 2.2), but that is a site-wide change.
- Theme Kit Pro Dark Mode module ("Color Switch"): options `dark_mode_enable`, `dark_mode_default` (light), `dark_mode_os_aware`, `dark_mode_dark_palette` (default `second-palette`), switch display settings, dark logos (`kadence-pro/dist/dark-mode.php:219-239`); adds body classes `color-switch-dark` / `color-switch-light` (:194-201) and header, mobile and footer switch items (sections `kadence_customizer_dark_mode`, `_header_dark_mode`, `_mobile_dark_mode`, `_footer_dark_mode`) [code][runtime: pro-modules capture][Theme Kit Pro].
- Why palette discipline matters: the Pro switch works by swapping the 15 palette values. Anything styled with a palette slot follows; anything with a hex, an rgba literal or `--global-gray-*` does not. Check contrast for both palettes (4.5:1).

---

## 9. CSS custom properties the theme outputs

Dynamic (from Customizer, `inc/components/styles/component.php`) [code]:
| Variable | Line | Source |
|---|---|---|
| `--global-palette1` .. `--global-palette15` | 1741-1755 | active palette |
| `--global-palette9rgb` | 1758 | palette9 as `r, g, b` |
| `--global-palette-highlight`, `-highlight-alt`, `-highlight-alt2` | 1759-1761 | `link_color` |
| `--global-palette-btn-bg`, `-btn-bg-hover`, `-btn`, `-btn-hover` | 1764-1767 | base buttons |
| `--global-palette-btn-sec-bg`, `-sec-bg-hover`, `-sec`, `-sec-hover` | 1770-1773 | secondary buttons |
| `--global-palette-btn-out-bg`, `-out-bg-hover`, `-out`, `-out-hover` | 1776-1779 | outline buttons |
| `--global-body-font-family`, `--global-heading-font-family`, `--global-primary-nav-font-family` | 1782-1789 | fonts |
| `--global-fallback-font`, `--global-display-fallback-font` | 1794-1795 | filters |
| `--global-content-width`, `--global-content-wide-width`, `--global-content-narrow-width`, `--global-content-edge-padding`, `--global-content-boxed-padding`, `--global-calc-content-width` | 1796-1801 | layout |
| `--wp--style--global--content-size` | 1804 | classic mode only |
| `--global-vw` | 1808 | `.wp-site-blocks` |
| `--global-calc-wide-content-width`, `--global-content-narrow-wide-width` | 3256-3261 | editor CSS |

Static (`assets/css/global.min.css`) [code]: `--global-xs-spacing`, `--global-sm-spacing`, `--global-md-spacing`, `--global-lg-spacing`, `--global-xl-spacing`, `--global-xxl-spacing`, `--global-edge-spacing`, `--global-boxed-spacing`, `--global-font-size-small`, `-medium`, `-large`, `-larger`, `-xxlarge`, `--global-gray-400`, `--global-gray-500`.

---

## 10. How blocks inherit, and mistakes that break inheritance

How inheritance works:
- Text in blocks inherits `body` font, size and color (palette4) and headings inherit h1-h6 settings, because the theme styles the elements themselves, not block classes [code].
- Colors chosen from the palette are stored as slot references (`theme-paletteN` classes in core, `paletteN` in Kadence controls) and rendered as `var(--global-paletteN)` [code].
- Buttons inherit from the global button variables when they use core Button or Kadence Advanced Button with the inherit style [code].
- Widths follow `--global-calc-content-width` for constrained layouts and the wide width for `alignwide` [code].

Common mistakes:
1. Picking a custom hex in a color picker instead of a palette swatch. The value is stored literally and will not follow palette changes or the Pro dark palette.
2. Typing `#hex` or `rgb()` in custom CSS instead of `var(--global-paletteN)`.
3. Setting a fixed px font size on a block or heading when the global h1-h6 sizes or the `--global-font-size-*` presets would do. It overrides responsive sizes from the Customizer.
4. Setting font family on each block instead of leaving it to `--global-body-font-family` / heading font.
5. Choosing a non-inherit style on Kadence Advanced Buttons, then restyling every button by hand.
6. Using `--global-gray-400/500` or `--global-palette9rgb` overlays and expecting them to change with a dark palette (`gray` never changes; `palette9rgb` follows palette9 only).
7. Relying on `--global-h1-font-family` etc., which are not output in 1.6.0.
8. Assuming core spacing presets exist: they show only with `theme_json_mode` on.
9. Editing the palette in two places (Customizer and Kadence Blocks Style Library tokens) at once (section 2.6).
10. Overriding Customizer-generated CSS with `!important` in child theme CSS. Change the Customizer value or use a filter instead.

---

## 11. Gaps
- Exact Kadence Blocks attribute format for palette colors was not checked here; see the blocks study [unverified].
- Whether Kadence Blocks breakpoints follow the theme's media query filters was not checked [unverified].
- Customizer UI for choosing the active palette set was read from options code only, not seen in the UI [code; check in Customizer > Colors].
