# From design to Kadence settings

Purpose: turn a screenshot, Figma frame, design canvas or written layout into native Kadence blocks and settings. The result must render correctly and stay editable in the WordPress editor.

Verified against Kadence Blocks 3.9.1 and Blocks Pro 2.8.16. The attribute value formats in section 5 were confirmed by building and saving a real section in the block editor and checking that every block passed validation after a reload.

## Contents
1. The ten-step workflow
2. Reading a design: section anatomy to blocks
3. Mapping visual properties to native controls
4. Responsive plan
5. Attribute value formats (for the editor's block API)
6. Building it so it stays editable
7. Verification checklist
8. Worked example: two-column hero with feature card

## 1. The ten-step workflow
1. **Analyse the structure.** List the sections top to bottom. Note what repeats (cards, list items), what is site-wide (header, footer, banners) and what changes per post (titles, images, fields).
2. **Break it into components.** For each section, name the wrapper, the columns and each element inside: eyebrow, heading, text, buttons, icon, list, image, card.
3. **Pick the Kadence block** for each component (section 2 and `recipes.md`). Check that the block exists on this site (`environment-check.md`).
4. **Pick the native styling controls** for every visual property (section 3, `styling-layers.md`).
5. **Plan the responsive behaviour** for desktop, tablet and mobile (section 4, `responsive-animation.md`).
6. **Map colours and type to global tokens.** Each colour becomes a palette slot (`palette1` to `palette9`, more if the site uses them). Each font size becomes a preset (`sm` to `xxl`) or the global heading size. Add a palette colour in the Customizer before using a one-off hex value.
7. **Find dynamic content.** Anything that changes per post or comes from ACF uses Dynamic Content `[Pro]` (`dynamic-content-acf.md`). Repeated post cards use Query Loop (Adv) `[Pro]` or the Posts block.
8. **Choose the placement.**
   - Page content goes in the page itself.
   - Content repeated on many pages, conditional content or template content goes in an Element `[TKP]` (`theme-kit-pro-elements.md` §4).
   - Header and footer changes go in the Customizer builders (`theme.md` §2-3).
9. **Build** with native controls only (section 6). Record a reason for any custom code, using `decision-framework.md`.
10. **Verify** both the front end and editability (section 7).

## 2. Reading a design: section anatomy to blocks

| Design pattern | Kadence block | Notes |
|---|---|---|
| Full-width band with background | Row Layout (`kadence/rowlayout`), `align` full, `htmlTag` `section` | `inheritMaxWidth` true keeps the content at the theme width |
| Columns | Row Layout `columns` + `colLayout` | Each column is a Section (`kadence/column`) |
| Card, panel or box | Section with background, border, radius, shadow and padding | Section is the only free block with full box styling, hover state and sticky |
| Small label above a heading (eyebrow) | Advanced Text (`kadence/advancedheading`) with `htmlTag` `p` | Uppercase via `textTransform`, letter spacing, small preset |
| Heading | Advanced Text, `level` 1-6 | One H1 per page. If the theme title is hidden, the section heading becomes the H1 |
| Paragraph | Advanced Text with `htmlTag` `p` | There is no separate "Advanced Text" block; it is the same block |
| One coloured word in a heading | Advanced Text highlight format (`<mark class="kt-highlight">`), styled in "Advanced Highlight Settings" (`markColor`, `markBG`, ...) | No CSS needed |
| Buttons | Advanced Buttons (`kadence/advancedbtn`) with Single Buttons (`kadence/singlebtn`) | `inheritStyles`: `inherit` (theme button), `inherit-secondary`, `fill`, `outline` |
| Icon above a card title | Icon (`kadence/icon`) with Single Icon (`kadence/single-icon`), `style` `stacked` | Background, colour, radius and padding are on the Single Icon |
| Feature list with icons | Icon List (`kadence/iconlist`) with List items (`kadence/listitem`) | Per-item icon; the list sets style, colours and size |
| Icon + title + text card | Info Box (`kadence/infobox`), or a Section with Icon and Advanced Text | Info Box cannot animate on scroll; a Section can |
| FAQ | Accordion with `faqSchema` | Pane title tag sets the heading level |
| Grid of posts or CPT cards | Query Loop (Adv) `[Pro]`, or Posts (free, fixed layout) | `recipes.md` §7 |
| Scrolling logo strip | Marquee (Adv) `[CK]`, or an Advanced Gallery carousel | Marquee has accessibility limits (`creative-kit.md`) |

## 3. Mapping visual properties to native controls

| Property | Where it is set | Prefer |
|---|---|---|
| Text colour | Block colour controls | A palette slot, so it follows palette changes and dark mode |
| Background | Row background or Section background, gradient or image | A palette slot. Gradients take palette colours |
| Font size | Block typography | A preset (`sm`, `md`, `lg`, `xl`, `xxl`). These are fluid `clamp()` values |
| Font family | Leave empty | Inherits the theme's global typography |
| Weight, line height, letter spacing, transform | Block typography | Set per device only when the design needs it |
| Spacing | Padding and margin arrays per device | Spacing presets (`xs` to `xxl`) or numbers with a unit |
| Column gap | Row `columnGutter`; stacked gap `collapseGutter` | Presets: `none`, `skinny`, `narrow`, `default`, `wide`, `wider`, `widest` |
| Corners | `borderRadius` array (top-left, top-right, bottom-right, bottom-left) with a unit | Same radius across a component family |
| Border | `borderStyle` object per side: colour, style, width | Palette colour |
| Shadow | `displayShadow` + `shadow`; `displayHoverShadow` + `shadowHover` (Section, Single Button) | Soft, low opacity |
| Hover state | Section Hover tab; Single Button hover colours and shadow | Native hover only. Transforms such as lift or scale need CSS (`limitations.md`) |
| Width limit | Advanced Text `maxWidth`; Section `maxWidth` | Per device |
| Visibility per device | Row, Section, Countdown and Spacer only (`vsdesk`, `vstablet`, `vsmobile`) | CSS only; the HTML still loads |
| Entrance animation | Animate on Scroll `[Pro]`, on blocks that support `ktanimate` | Set `once` true. Row Layout and Info Box are not supported, so wrap them in a Section |

## 4. Responsive plan
- **Breakpoints.** Kadence Blocks switches to tablet at 1024 px and to mobile at 767 px. Element device rules and some theme CSS switch at 719/720 px (`responsive-animation.md`).
- **Row columns.** Set `colLayout` for desktop, then `tabletLayout` (for example `equal`, or `row` to stack) and `mobileLayout` (`row` stacks). Change the stacking order with `collapseOrder`.
- **Per-device arrays.** Typography and spacing arrays are ordered desktop, tablet, mobile. Padding has separate `padding`, `tabletPadding` and `mobilePadding` arrays, each ordered top, right, bottom, left.
- **Buttons.** Advanced Buttons `hAlign`, `thAlign` and `mhAlign` set alignment per device. Buttons wrap naturally on small screens.
- **Fluid sizes.** Font size presets are fluid, so they need fewer per-device overrides than px values.

## 5. Attribute value formats (Blocks 3.9.1)
Use these when inserting blocks through the editor's own block API (`wp.blocks.createBlock` and `wp.data.dispatch('core/block-editor')`), or to read what the editor saved. They mirror the inspector controls exactly.

- **Colour:** `'palette1'` to `'palette9'`, a hex string, or `''` for inherit. Kadence outputs palette values as `var(--global-paletteN, fallback)`.
- **Font size:**
  - Advanced Text: `fontSize: ['xxl','xl','lg']` (desktop, tablet, mobile), presets or numbers with `sizeType`.
  - Line height: `fontHeight: [1.1,1.15,1.2]` with `fontHeightType: ''` (unitless).
  - Weight: `fontWeight: '800'`.
- **Spacing arrays:** `padding: ['xxl','sm','xxl','sm']` (top, right, bottom, left) take presets or numbers. Advanced Text uses `margin: ['', '', 'sm', '']`.
- **Row Layout:**
  - Layout: `columns: 2`, `colLayout: 'left-golden'`, `tabletLayout: 'equal'`, `mobileLayout: 'row'`.
  - Gaps: `columnGutter: 'wider'`, `tabletGutter: 'wide'`, `collapseGutter: 'lg'`.
  - Other: `verticalAlignment: 'middle'`, `bgColor: 'palette8'`, `inheritMaxWidth: true`, `align: 'full'`, `htmlTag: 'section'`.
- **Section card:**
  - Fill and shape: `background: 'palette9'`, `borderRadius: [20,20,20,20]`, `borderRadiusUnit: 'px'`.
  - Border: `borderStyle: [{top:['palette7','solid',1], right:[...], bottom:[...], left:[...], unit:'px'}]`.
  - Shadow: `displayShadow: true`, `shadow: [{color:'#1A202C', opacity:0.08, spread:0, blur:40, hOffset:0, vOffset:16, inset:false}]`, and the same pair for hover.
- **Single Button:** `inheritStyles: 'inherit' | 'inherit-secondary' | 'fill' | 'outline'`, `sizePreset: 'small' | 'standard' | 'large' | ...`, `icon: 'fe_arrowRight'`, `iconSide: 'right'`, and `borderRadius` as above.
- **Single Icon:** `icon: 'fe_layers'`, `size: 28`, `style: 'stacked'`, `color`, `background`, `borderRadius` (a number), `padding: [14,14,14,14]`.
- **Icon List:**
  - List: `style: 'stacked'`, `color`, `background`, `iconSize: [16,16,16]`, `listGap: 14`.
  - Item text: `listStyles: [{size:[16,16,15], weight:'600', color:'palette4', ...}]`.
  - Each `kadence/listitem` has `icon` and `text`.
- **Icon names:** line icons use the `fe_` (Feather) and `ic_` prefixes (`kadence-blocks/includes/icons-ico-array.php`). Font Awesome style icons use `fas_`, `fa_` and similar (`icons-array.php`). Custom uploaded icons live in the `kb_icon` post type `[Pro]`. Confirm a name exists before using it.
- **Block names in List View:** set `metadata: {name: 'Hero: left column'}` so the structure reads clearly.
- **Unique IDs:** `uniqueID` is assigned by Kadence when the block mounts in the editor. Never invent one.

## 6. Building it so it stays editable
- **Build in the block editor.** Either use the inspector by hand, or insert blocks through the editor's block API in the open editor, then save with the editor's Save button. Either way the editor serializes the markup.
- **Never hand-write saved block markup** and import it with SQL or WP-CLI. If an attribute shape is wrong, the block shows the "unexpected content" recovery prompt and stops being editable.
- **Per-page layout** belongs in Kadence's Page Settings panel in the editor, not in global settings. The stored meta keys are:
  - `_kad_post_title` (`hide`);
  - `_kad_post_layout` (`fullwidth`, `narrow`, ...);
  - `_kad_post_content_style` (`unboxed`);
  - `_kad_post_vertical_padding` (`hide`).

  Use these when a full-bleed design sits on a page, so the theme's boxed content area and title do not frame it.
- **Never use** a Custom HTML block, shortcode or inline `style` attribute for design.

## 7. Verification checklist
- After saving, reload the editor. Every block reports `isValid` (no recovery prompts) and its Kadence inspector panels open.
- The saved content has no `style=` attributes and no `wp:html`, `wp:shortcode` or `<script>`.
- The front end, previewed at 1366, 768 and 375 px widths:
  - matches the design;
  - has no horizontal scroll;
  - stacks as planned;
  - has one H1;
  - meets 4.5:1 text contrast.
- Changing a palette colour in the Customizer preview changes the section, which proves it inherits the global tokens.
- Anything not done natively is listed with its reason, as `decision-framework.md` requires.

## 8. Worked example: two-column hero with feature card
**Design:** on the left, an eyebrow, a large heading with one highlighted word, a description and two buttons. On the right, a white card with an icon, a title, text and a three-item icon list.

**Build (all native, 17 blocks):**
- **Row Layout:** `colLayout` `left-golden`; tablet `equal`; mobile `row`.
  - Background `palette8`, padding `xxl`/`xl`/`lg` per device, `columnGutter` `wider`, `collapseGutter` `lg`, `verticalAlignment` middle, full width with `inheritMaxWidth`.
- **Left Section:**
  - Eyebrow: Advanced Text `p`, `palette1`, `sm`, weight 700, letter spacing 2.
  - Heading: Advanced Text H1, `palette3`, sizes `xxl`/`xl`/`lg`, weight 800, with the highlight `markColor` `palette1`.
  - Description: Advanced Text `p`, `palette5`, `md`, line height 1.7, `maxWidth` 560 px.
  - Buttons: Advanced Buttons, a Single Button with fill and right arrow icon, and a Single Button with outline. Both large with a 10 px radius; the fill button has a soft shadow and hover shadow.
- **Right Section (the card):**
  - Box: background `palette9`, 1 px `palette7` border, 20 px radius, shadow plus hover shadow, padding `lg` on desktop and `md` on tablet and mobile.
  - Contents: an Icon with a stacked Single Icon (`palette1` background, `palette9` glyph, 14 px radius), an Advanced Text H3 in `lg`, an Advanced Text `p` in `sm`, and an Icon List (stacked icons on `palette7`, item text weight 600 in `palette4`).
- **Page Settings:** title hidden, full width, unboxed, vertical padding hidden. The heading is then the page's only H1.

**Result:**
- At 1366 px: 66/33 columns.
- At 768 px: two equal columns.
- At 375 px: the columns stack, the heading is 28 px and there is no horizontal scroll.
- No custom CSS, JavaScript, HTML or inline styles.
