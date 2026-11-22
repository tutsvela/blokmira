# Kadence responsive and motion reference

Purpose: one cross-product reference for breakpoints, responsive controls, sticky behaviour, entrance animation, hover effects, parallax and reduced-motion support across the Kadence stack, with the native gaps that still need custom code.

Versions studied: Kadence Theme 1.6.0, Kadence Theme Kit Pro 1.2.6, Kadence Blocks 3.9.1, Kadence Blocks Pro 2.8.16, Kadence Creative Kit 1.1.4.

Contents
1. Breakpoints (exact values and where defined)
2. Responsive attribute patterns in Kadence Blocks
3. Row Layout columns: stacking and collapse order
4. Hide on device (blocks, theme header/footer, Elements)
5. Responsive typography and spacing
6. Responsive backgrounds
7. Sticky behaviour (theme header, Header (Adv), Section, Elements)
8. Entrance animation: the Animate on Scroll system
9. Other motion features (typed text, counters, Lottie, sliders, marquee, menus)
10. Native hover effects
11. Parallax, transforms and motion effects
12. Reduced-motion support per product
13. Checklist: polished interactions without custom code
14. Native gaps where custom CSS/JS is genuinely required

Path roots: `themes/kadence/`, `plugins/kadence-blocks/`, `plugins/kadence-blocks-pro/`, `plugins/kadence-pro/` (Theme Kit Pro), `plugins/kadence-creative-kit/`, all under `wp-content/`. Built JS and minified CSS are one line, so those citations give the file only.

## 1. Breakpoints

### Dynamic (generated) CSS
All products use the same filterable media queries for CSS they generate from settings.

| State | Query | Filter | Source |
|---|---|---|---|
| desktop (base, no query) | rules written without a media query | | [code] `kadence-blocks/includes/class-kadence-blocks-css.php:155, 547-549` |
| desktop (when a desktop-only rule is needed) | `(min-width: 1025px)` | `kadence_desktop_media_query` | [code] `kadence-blocks/includes/class-kadence-blocks-css.php:421` |
| tablet | `(max-width: 1024px)` | `kadence_tablet_media_query` | [code] `.../class-kadence-blocks-css.php:419` |
| mobile | `(max-width: 767px)` | `kadence_mobile_media_query` | [code] `.../class-kadence-blocks-css.php:418` |
| tabletOnly | `(min-width: 768px) and (max-width: 1024px)` | `kadence_tablet_only_media_query` | [code] `.../class-kadence-blocks-css.php:424` |
| mobileReverse | `(min-width: 768px)` | `kadence_mobile_reverse_media_query` | [code] `.../class-kadence-blocks-css.php:422` |
| tabletPro / tabletOnlyPro | tablet query plus iPad Pro landscape (`min-device-width:1024px` to `1366px`, `hover:none`) | `kadence_tablet_pro_media_query`, `kadence_tablet_only_pro_media_query` | [code] `.../class-kadence-blocks-css.php:420, 423` |

- The theme uses the same three filters and values for its Customizer CSS [code] `kadence/inc/components/styles/component.php:294-296, 381-383, 731-733`.
- Creative Kit copies the same filters [code] `kadence-creative-kit/inc/KadenceCreativeKit/Blocks/Minified_CSS.php:384-390`.
- Model: desktop-first. Desktop values are the base; tablet (max 1024) overrides them and also applies to phones unless a mobile value (max 767) overrides again [code] `class-kadence-blocks-css.php:515-550`.

### Theme header switch (separate setting)
- Customizer > Header > "Screen size to switch to mobile header" (`header_mobile_switch`, px) [code] `kadence/inc/customizer/options/header-builder-options.php:334-360`. Default empty, which means 1024 [code] `kadence/inc/components/scripts/component.php:75-78`.
- When set, header CSS uses `max-width: (value - 1)px` for tablet and `min-width: value px` for desktop [code] `kadence/inc/components/styles/component.php:734-739`, and the navigation script receives `kadenceConfig.breakPoints.desktop` = that value, `tablet` = 768 [code] `kadence/inc/components/scripts/component.php:157-160`.

### Static (shipped) CSS: watch the 720 to 767 px band
Static stylesheets do not all use 767/768.

| Stylesheet group | Main queries found | Source |
|---|---|---|
| Theme `assets/css/*.min.css` | `max-width:719px` (25), `max-width:1024px` (23), `min-width:1025px` (21), `min-width:768px` (16), `min-width:767px` (11), `720px to 1024px` (5) | [code] count of `@media` in `kadence/assets/css/*.min.css` |
| Kadence Blocks `dist/style-*.css` | `max-width:767px` (14), `720px to 1024px` (12), `min-width:1025px` (12), `max-width:719px` (12), `768px to 1024px` (6) | [code] count in `kadence-blocks/dist/style-*.css` |
| Blocks Pro `dist/*.css` | mostly `max-width:767px` and `max-width:1024px`, plus grid steps 544, 768, 992, 1200, 1500 | [code] count in `kadence-blocks-pro/dist/*.css` |

Practical effect: some static styles change at 719/720 px while generated block settings change at 767/768 px. Always test widths 720 to 767 px.

## 2. Responsive attribute patterns in Kadence Blocks

Four patterns coexist. Check `block.json` before writing attributes by hand.

| Pattern | Example | Source |
|---|---|---|
| Three-value array `[desktop, tablet, mobile]` | `fontSize`, `fontHeight` (Text (Adv)); `stickyOffset` (Section); Marquee `height`, `transitionDistance` | [code] `kadence-blocks/dist/blocks/advancedheading/block.json`; `kadence-blocks/dist/blocks/column/block.json` |
| Separate attributes per device | `size`, `tabSize`, `mobileSize`; `topPadding`, `topPaddingT`, `topPaddingM` (older layout) | [code] `advancedheading/block.json`; `column/block.json` |
| Four-side arrays with device prefix | `padding`, `tabletPadding`, `mobilePadding` (each `[top, right, bottom, left]`) plus `paddingUnit`; same for `margin`, `borderRadius` | [code] `kadence-blocks/dist/blocks/rowlayout/block.json` |
| Device objects with an enable flag | Row Layout `tabletBackground`, `mobileBackground`, `tabletOverlay`, `mobileOverlay` (`[{"enable": false, ...}]`) | [code] `rowlayout/block.json` |

Values can be numbers with a unit attribute, or preset slugs that become CSS variables (section 5).

## 3. Row Layout columns: stacking and collapse order

Editor: select Row Layout > General tab > layout chooser with device tabs.

| Attribute | Default | Values | Source |
|---|---|---|---|
| `colLayout` (desktop) | `""` | `equal`, `left-golden` (66/33), `right-golden` (33/66), `left-half` (50/25/25), `right-half` (25/25/50), `center-half` (25/50/25), `center-wide` (20/60/20), `center-exwide` (15/70/15), `left-forty`, `right-forty`, `first-row`, `last-row`, `two-grid`, `three-grid`, `row` | [code] `kadence-blocks/dist/blocks-rowlayout.js` (option list) |
| `tabletLayout` | `inherit` | same family; `inherit` keeps desktop | [code] `rowlayout/block.json`; PHP fallback `class-kadence-blocks-row-layout-block.php:594-601` |
| `mobileLayout` | `row` ("Collapse to Rows") | same family | [code] `rowlayout/block.json`; `class-kadence-blocks-row-layout-block.php:658-662` |
| `collapseOrder` | `left-to-right` ("Normal") | `right-to-left` ("Reverse") | [code] `blocks-rowlayout.js`; `rowlayout/block.json` |
| `collapseOrderTablet` | `""` | as above | [code] `rowlayout/block.json` |
| Per-device column widths | | `firstColumnWidth` ... `sixthColumnWidth`, plus `...Tablet`, `...Mobile` | [code] `rowlayout/block.json` |
| Gutters | `columnGutter` `default`, `collapseGutter` `default` | presets or custom px per device (`customGutter`, `customRowGutter`) | [code] `rowlayout/block.json`; gap presets `class-kadence-blocks-css.php:255-262` |

How reverse works: the layout is a CSS grid; when `collapseOrder` is not `left-to-right` and the device layout is a stacking layout (`row`, `two-grid`, `three-grid`, `last-row`, `first-row`), the PHP writes CSS `order` values in reverse for each column (up to four rows of columns) [code] `class-kadence-blocks-row-layout-block.php:546, 556-575, 603, 633, 664`. Reverse therefore only affects stacked layouts. Typical use: image left / text right on desktop, text first on phones.

The editor also offers "Bento & Grid" and "Off-Grid" toggles [code] `blocks-rowlayout.js` (labels); study the Row Layout reference for details.

## 4. Hide on device

### Kadence Blocks
- "Hide on Desktop / Tablet / Mobile" toggles exist only on **Row Layout, Section, Spacer and Countdown** [code] `kadence-blocks/dist/blocks-{rowlayout,column,spacer,countdown}.js` (labels); attributes `vsdesk`, `vstablet`, `vsmobile` [code] `rowlayout/block.json`, `column/block.json`.
- Row Layout output: `display:none !important` inside the desktop (min 1025), tabletOnly (768 to 1024) and mobile (max 767) queries, plus classes `kb-v-lg-hidden`, `kb-v-md-hidden`, `kb-v-sm-hidden` [code] `class-kadence-blocks-row-layout-block.php:1294-1308, 1746-1754`. Utility classes `kvs-lg-false`, `kvs-md-false`, `kvs-sm-false` use the same 767/768/1024/1025 boundaries [code] `kadence-blocks/dist/style-blocks-rowlayout.css`.
- This is CSS hiding. The HTML is still sent and images may still load.
- For any other block, put it inside a Section and hide the Section.
- Blocks Pro conditional display (`kadenceConditional`) is about post data, not devices [code] `kadence-blocks-pro/includes/dynamic-content/class-kadence-blocks-pro-dynamic-content.php:561-563`.

### Theme header and footer
- The header builder has separate Desktop and Mobile layouts switched at `header_mobile_switch` (section 1). Put device-specific items in the right layout.
- Header button: "Button Visibility" (`header_button_visibility`, `mobile_button_visibility`); search label visibility; scroll-to-top "Visibility" (`scroll_up_visiblity`) [runtime] the runtime capture.
- Transparent header "Enable for:" device choice (`transparent_header_device`) [runtime] the runtime capture.

### Elements (Theme Kit Pro)
- Element settings sidebar > "Device Settings" > "Show on Device" [code] `kadence-pro/build/meta.js` (labels); stored in post meta `_kad_element_device_conditionals` [code] `kadence-pro/dist/elements/elements-init.php:2233-2234`.
- Output wraps the Element in `div.kadence-element-wrap` with `vs-lg-false`, `vs-md-false`, `vs-sm-false` classes [code] `elements-init.php:1642-1658`. These classes are defined by the **theme** with `max-width: 719px`, `720px to 1024px`, `min-width: 1025px` [code] `kadence/assets/css/global.min.css`.
- So Element "mobile" hiding switches at 719/720 px while block "mobile" hiding switches at 767/768 px. Content is still rendered (CSS only).

## 5. Responsive typography and spacing

### Kadence Blocks
- Font size, line height, letter spacing on text blocks have desktop / tablet / mobile values (for example Text (Adv) `fontSize` `[d, t, m]`, `tabletLetterSpacing`, `mobileLetterSpacing`) [code] `advancedheading/block.json`.
- Preset font sizes `sm`, `md`, `lg`, `xl`, `xxl`, `3xl` map to `var(--global-kb-font-size-*)` [code] `class-kadence-blocks-css.php:244-251`. In 3.9.1 these presets are **fluid by default** (`clamp()`): sm 0.8 to 0.9rem, md 1.1 to 1.25rem, lg 1.75 to 2rem, xl 2.25 to 3rem, xxl 2.5 to 4rem, xxxl 2.75 to 6rem [code] `kadence-blocks/includes/resources/Design_Tokens/Registry/Baseline/baseline.json:180-253`; emitted on `:root` [code] `kadence-blocks/includes/init.php:103-112`; filter `kadence_blocks_variable_font_sizes` [code] `init.php:108`. A preset therefore scales with the viewport without separate tablet/mobile values.
- Spacing presets `none`, `xxs` (0.5rem), `xs` (1rem), `sm` (1.5rem), `md` (2rem), `lg` (3rem), `xl` (4rem), `xxl` (5rem), `3xl` (6.5rem), `4xl` (8rem), `5xl` (10rem), `ss-auto` map to `var(--global-kb-spacing-*)` (fallback values shown) [code] `class-kadence-blocks-css.php:228-239`, emitted from the token baseline [code] `init.php:146-150`.
- Gutter presets: `none`, `skinny` (1rem), `narrow` (20px), `default` (2rem), `wide` (40px), `wider` (4rem), `widest` (80px) [code] `class-kadence-blocks-css.php:255-262`.

### Theme
- Customizer typography settings store size and line height per device (`size` / `lineHeight` objects keyed `desktop`, `tablet`, `mobile`), for example `base_font` desktop 17px / 1.6 [code] `kadence/inc/components/options/component.php:751-757`.

## 6. Responsive backgrounds

- Row Layout: desktop background (colour, image, size, position, attachment, repeat), gradient, slider or video, plus `tabletBackground` / `mobileBackground` and `tabletOverlay` / `mobileOverlay` with an enable flag [code] `rowlayout/block.json`; CSS per device in `class-kadence-blocks-row-layout-block.php:855-1010`.
- `background-attachment: fixed` (and the CSS fallback for "Parallax") is switched back to `scroll` on tablets and iPad Pro unless the filter `kadence_blocks_attachment_fixed_on_mobile` returns true [code] `class-kadence-blocks-row-layout-block.php:876-880`.
- Section (`kadence/column`): background and overlay with separate hover versions (`backgroundHover`, `backgroundImgHover`, `overlayHover`, `gradientHover`) but no per-device background objects [code] `column/block.json`.

## 7. Sticky behaviour

### Theme header (Customizer > Header > Sticky Header)
| Control | Key | Values | Source |
|---|---|---|---|
| Enable Sticky Header? | `header_sticky` | `no`, `main`, `top_main`, `top_main_bottom` (whole header), `top`, `bottom`; default `no` | [code] `kadence/inc/customizer/options/header-sticky-options.php:48-79`; `inc/components/options/component.php:1879` |
| Enable Reveal Sticky on Scroll up | `header_reveal_scroll_up` | switch | [runtime] the runtime capture |
| Enable Main Row Shrinking / Main Row Shrink Height | `header_sticky_shrink`, `header_sticky_main_shrink` | switch, px | [runtime] `:632-633` |
| Different logo when stuck | `header_sticky_custom_logo`, `header_sticky_logo`, `header_sticky_logo_width` | | [runtime] `:634-636` |
| Mobile equivalents | `mobile_header_sticky`, `mobile_header_reveal_scroll_up`, `mobile_header_sticky_shrink`, `mobile_header_sticky_main_shrink`, `header_sticky_custom_mobile_logo` | | [runtime] `:638-643` |
| Sticky design | colours for title, nav, buttons, social, HTML; background, bottom border, box shadow | | [runtime] `:644-653` |

Output: `data-reveal-scroll-up`, `data-shrink`, `data-shrink-height` attributes read by `navigation.min.js` [code] `kadence/template-parts/header/base.php:17-32`, `template-parts/header/mobile-header-row.php:17-20`.

### Header (Adv) block (Kadence Blocks)
Attributes `isSticky`, `isStickyTablet`, `isStickyMobile`, `stickySection` (+ tablet, mobile), `revealScrollUp`, `shrinkMain`, `shrinkMainHeight` (+ tablet, mobile), `isTransparent` (+ tablet, mobile) and sticky / transparent styling [code] `kadence-blocks/includes/blocks/class-kadence-blocks-header-block.php:288-313`.

### Section sticky (Kadence Blocks)
- Section > "Sticky Settings" > "Make sticky", "Sticky Header Offset" [code] `kadence-blocks/dist/blocks-column.js` (labels). Attributes `sticky`, `stickyOffset` `[d, t, m]`, `stickyOffsetUnit` [code] `column/block.json`.
- CSS `position: sticky` with `top: calc(admin bar + --kb-section-setting-offset)` [code] `kadence-blocks/dist/style-blocks-column.css`; per-device offset variables [code] `class-kadence-blocks-column-block.php:150-168`.
- Side effect: enabling it sets `#wrapper.site { overflow: clip }` [code] `class-kadence-blocks-column-block.php:150-152`.
- No "disable sticky on mobile" toggle exists [code] (no device attribute for `sticky`). A sticky Section in a stacked mobile layout usually has nothing to stick against, but test it.
- Row Layout itself has no sticky option [code] `rowlayout/block.json`.

### Elements fixed placements (Theme Kit Pro)
Hook choices under "Fixed": Fixed On Top, Fixed Above Transparent Header, Fixed Top After Scroll, Fixed Bottom After Scroll (with or without space below footer), Fixed On Bottom, Fixed Bottom (no space below footer) [code] `kadence-pro/dist/elements/elements-init.php:2530-2559`. Uses `kadence-pro-sticky.css` / `.min.js` [code] `elements-init.php:474-475, 1070-1195`.

## 8. Entrance animation: the Animate on Scroll system

### Who provides it
- **Kadence Blocks Pro** provides the editor panel and front-end script on a full stack [code] `kadence-blocks-pro/dist/blocks.js` (filter `editor.BlockEdit` namespace `kadence/animateonscroll`); `kadence-blocks-pro/includes/class-kadence-blocks-pro-frontend.php:142-154` [Pro].
- Creative Kit has an identical fallback that runs only without Blocks Pro (see `creative-kit.md` section 5) [Creative Kit].
- Kadence Blocks free writes the `data-aos` attributes for its PHP-rendered blocks [code] `kadence-blocks/includes/helper-functions.php:138-163`, but the script comes from Pro or Creative Kit.
- Library: the AOS library (scroll listener, throttled 99 ms, debounced 50 ms on resize, MutationObserver for new nodes), not IntersectionObserver and not GSAP [code] `kadence-blocks-pro/includes/assets/js/aos.min.js`.

### Which blocks get it
Blocks that declare support `ktanimate`: Section (`kadence/column`), Advanced Image, Single Button, Text (Adv), Form, Video Popup, Image Overlay [Pro], Split Content [Pro] [code] `block.json` `supports` of each; [runtime] the runtime capture BLOCK lines. **Row Layout and Info Box do not** [runtime]. To animate them, wrap content in a Section.

### Editor location
Select the block > Advanced tab > "Animate on Scroll" panel. Shown only if the "kadence/aos" control is allowed for the user role in Kadence Blocks settings [code] `kadence-blocks-pro/dist/blocks.js` (check `h("show","kadence/aos")`). Site-wide defaults: "Animate On Scroll Defaults" modal [code] `kadence-blocks-pro/dist/blocks.js` (labels), stored in option `kadence_blocks_config_blocks` key `kadence/aos` [code] `class-kadence-blocks-pro-frontend.php:144-154`. A "Play Animation" button previews it in the editor (`ktanimatepreview`).

### Attributes
- `kadenceAnimation` (string) and `kadenceAOSOptions` (array of one object: `duration`, `offset`, `easing`, `once`, `delay`, `delayOffset`) [code] `kadence-blocks-pro/dist/early-filters.js` (filter `blocks.registerBlockType`, `kadence/animation`).
- Saved as `data-aos`, `data-aos-offset`, `data-aos-duration`, `data-aos-easing`, `data-aos-delay`, `data-aos-once` on the block wrapper [code] `helper-functions.php:139-158`; static blocks via `blocks.getSaveContent.extraProps` for `ktanimateadd` blocks [code] `kadence-blocks-pro/dist/blocks.js`.

### Animation names (all verified in the editor option lists)
| Group | Values | Availability |
|---|---|---|
| Fade | `fade`, `fade-up`, `fade-down`, `fade-left`, `fade-right`, `fade-up-right`, `fade-up-left`, `fade-down-right`, `fade-down-left` | all `ktanimate` blocks |
| Flip | `flip-up`, `flip-down`, `flip-left`, `flip-right` | all |
| Slide | `slide-up`, `slide-down`, `slide-left`, `slide-right` | all |
| Zoom | `zoom-in`, `zoom-in-up`, `zoom-in-down`, `zoom-in-left`, `zoom-in-right`, `zoom-out`, `zoom-out-up`, `zoom-out-down`, `zoom-out-left`, `zoom-out-right` | all |
| Slide Reveal | `reveal-up`, `reveal-down`, `reveal-left`, `reveal-right` | blocks with `ktanimatereveal`: Text (Adv) only |
| Cover Swipes | `swipe-up`, `swipe-down`, `swipe-left`, `swipe-right` | blocks with `ktanimateswipe`: Section, Form, Video Popup, Image Overlay |
| Parts | `fade-out-in`, `fade-center-out`, `slide-out-in`, `slide-center-out` | blocks with `ktanimatepartsoptions`: Split Content [Pro] |

Source: [code] `kadence-blocks-pro/dist/blocks.js` (arrays of `{value,label}`); CSS selectors for all single-element names in [code] `kadence-blocks-pro/includes/assets/css/aos.min.css`.

### Options
| Option (label) | Key | Range / values | Global default |
|---|---|---|---|
| Animation Duration | `duration` | 50 to 3000 ms, step 50 | 400 [code] `class-kadence-blocks-pro-frontend.php:150` |
| Animation Ease | `easing` | `linear`, `ease`, `ease-in`, `ease-out`, `ease-in-out`, `ease-in-back`, `ease-out-back`, `ease-in-out-back`, `ease-in-sine`, `ease-out-sine`, `ease-in-out-sine`, `ease-in-quad`, `ease-out-quad`, `ease-in-out-quad`, `ease-in-cubic`, `ease-out-cubic`, `ease-in-out-cubic`, `ease-in-quart`, `ease-out-quart`, `ease-in-out-quart` | `ease` [code] `:151` |
| Start Delay | `delay` | 50 to 3000 ms | 0 [code] `:152` |
| Only show once per page load? | `once` | Default / True / False | **false** [code] `:153`. With false, elements animate again each time they re-enter the viewport |
| Pixel offset for when animation triggers | `offset` | -300 to 300 px | 120 [code] `:149` |
| Offset Delay for each part | `delayOffset` | 50 to 3000 ms | parts animations only |

Ranges: [code] `kadence-blocks-pro/dist/blocks.js`. CSS supports durations and delays up to 3000 ms in 50 ms steps [code] `aos.min.css`.

### Not available
- No per-device animation choice and no "disable on mobile" option (AOS `disable` is passed only the reduced-motion result) [code] `kadence-blocks-pro/includes/assets/js/aos.min.js` (`initAOS`).
- No stagger for children except Split Content parts.
- No scroll-scrubbed (progress-linked) animation.
- Loading: AOS JS/CSS are enqueued only when a block with `kadenceAnimation` is found in post content or rendered (including Elements and dynamic content) [code] `class-kadence-blocks-pro-frontend.php:242-243, 310-312`; `dynamic-content/class-kadence-blocks-pro-dynamic-content.php:1286-1292`. AOS refreshes after masonry layout, Splide mount and Query Loop loads [code] `aos.min.js`.

### Content stays hidden if the script does not run
- `aos.min.css` starts animated blocks invisible: `[data-aos^=fade]` and `[data-aos^=zoom]` set `opacity:0`, and fade-up and similar add an offset `transform`. Only the script's `.aos-animate` class shows them. The CSS has no `no-js` guard [code] `kadence-blocks-pro/includes/assets/css/aos.min.css`.
- The content stays invisible when:
  - JavaScript is off;
  - the script fails;
  - a performance plugin delays JavaScript until user interaction (common with "delay JS" options);
  - a crawler or screenshot tool renders without scrolling.
- The Kadence theme removes the `no-js` class from `<html>` with a tiny inline script [code] `inc/components/base_support/component.php:754-759`. That class is reliable only for "JavaScript off", not for a failed or delayed AOS script.
- What to do:
  1. Never animate the LCP element or anything above the fold (hero heading, hero image, main call to action).
  2. Exclude `kadence-blocks-pro/includes/assets/js/aos.min.js` from "delay JS" and "defer JS" options in optimisation plugins, then test with the cache bypass parameter.
  3. If the design must stay readable with JavaScript off, add one small scoped rule in the child theme. Explain it in the CSS comment as "native AOS has no no-JS fallback": `.no-js [data-aos]{opacity:1;transform:none;transition:none}`.
  4. Verify by loading the page with JavaScript disabled and with the optimiser on, at desktop and mobile widths.


| Feature | Where | Notes | Source |
|---|---|---|---|
| Typed text | Text (Adv) rich-text format "Typed Text": Type Speed, Cursor, Loop Typing, Smart Backspace, Shuffle Strings | Uses typed.js; skipped entirely when reduced motion is on | [code] `kadence-blocks/includes/blocks/class-kadence-blocks-advanced-heading-block.php:509, 695-696`; `includes/assets/js/kb-advanced-heading.min.js` |
| Count up | Count Up block | Shows the end value at once for reduced motion | [code] `includes/assets/js/kb-countup.min.js` |
| Countdown | Countdown block, `revealOnLoad` | Reacts to reduced-motion changes; CSS removes transitions | [code] `kb-countdown.min.js`; `dist/style-blocks-countdown.css` |
| Lottie | Lottie Animations block: `autoplay`, `loop`, `onlyPlayOnHover`, `onlyPlayOnScroll`, `waitUntilInView`, `startFrame`, `endFrame`, `bouncePlayback`, `playbackSpeed`, `loopLimit`, `delay`, `showControls` | No reduced-motion check. Default `fileUrl` points to an external lottiefiles.com URL; replace it with a local file | [code] `kadence-blocks/dist/blocks/lottie/block.json`; `includes/assets/js/lottie-interactivity.min.js` |
| Carousels | Gallery, Testimonials, Row background slider (Blocks); Advanced Slider, Post Grid/Carousel, Product Carousel, Portfolio Grid [Pro] | Splide with `reducedMotion: {speed:0, rewindSpeed:0, autoplay:"pause"}` | [code] `kadence-blocks/includes/assets/js/splide.min.js` |
| Auto-scroll carousels | Post Grid / Product Carousel `autoScroll`, `autoScrollSpeed` (0.4), `autoScrollPause` [Pro] | Splide AutoScroll extension pauses on hover/focus; no own reduced-motion check | [code] `kadence-blocks-pro/dist/blocks/postgrid/block.json`; `includes/assets/js/splide-auto-scroll.min.js` |
| Marquee | Marquee (Adv) [Creative Kit] | GSAP; no reduced-motion check | see `creative-kit.md` |
| Modal | Modal block `modalAnimateIn`: `fade`, `fadeup`, `fadedown`, `fadeleft`, `faderight`, `slideup`, `slidedown`, `slideleft`, `slideright`, `zoomin`; `modalAnimateOut` [Pro] | | [code] `kadence-blocks-pro/dist/blocks-modal.js` |
| Theme dropdowns | Customizer > Dropdown Reveal (`dropdown_navigation_reveal`): none, fade, fade-up, fade-down | | [code] `kadence/inc/customizer/options/header-dropdown-options.php:233-262` |
| Theme off-canvas | Customizer > Header popup Animation (`header_popup_animation`): fade, scale, slice | | [code] `kadence/inc/customizer/options/header-popup-options.php:229-268` |
| Smooth anchor scroll / scroll to top | `enable_scroll_to_id`, `scroll_up` | `behavior:"smooth"` in JS, no reduced-motion check | [code] `kadence/inc/customizer/options/general-performance-options.php:41`; `general-scroll-to-top-options.php:49`; `assets/js/navigation.min.js` |

## 10. Native hover effects

| Block | Hover controls | Source |
|---|---|---|
| Single Button (Advanced Buttons) | Hover text colour, background (colour or gradient), border style and radius per device, icon colour, hover shadow; separate transparent-header and sticky-header hover states; "Icon Reveal on Hover" (icon slides in, 0.3s) | [code] `kadence-blocks/dist/blocks/singlebtn/block.json`; `dist/style-blocks-advancedbtn.css` |
| Section | "Hover Styles" tab: background, background image, gradient, overlay (colour/image/gradient, opacity, blend mode), border (width, radius, style per device), shadow, text and link colours | [code] `column/block.json` (`*Hover*` attributes); `dist/blocks-column.js` labels |
| Info Box | Container hover background and border, title and text hover colour, hover shadow per device, border hover radius; Icon or Image "Hover Animation": `none`, `grayscale` (to colour), `drawborder` (border spin in), `grayscale-border-draw`, `flip` (to a second icon/image) | [code] `kadence-blocks/dist/blocks/infobox/block.json`; `dist/blocks-infobox.js` |
| Advanced Gallery | Caption styles `bottom-hover`, `cover-hover`, `below`; `hoverStyle` (default `dark`); hover shadow; `mobileForceHover` (show hover captions on touch); static image filters `grayscale`, `sepia`, `saturation`, `vintage`, `earlybird`, `toaster`, `mayfair` | [code] `dist/blocks/advancedgallery/block.json`; `includes/blocks/class-kadence-blocks-advancedgallery-block.php:721, 762-767`; `dist/style-blocks-advancedgallery.css` |
| Advanced Image | Static `imageFilter` (same filter list); no hover transform | [code] `dist/blocks/image/block.json`; `dist/style-blocks-image.css` |
| Image Overlay [Pro] | "On Hover Img": `static`, `zoomin`, `slide`, `grayscale`, `blur`; overlay hover opacity | [code] `kadence-blocks-pro/dist/blocks-imageoverlay.js`; `dist/blocks/imageoverlay/block.json` |
| Portfolio Grid [Pro] | `imgAnimation` (default `zoomout`), `contentAnimation` (default `zoomin`), hover content background and border | [code] `kadence-blocks-pro/dist/blocks/portfoliogrid/block.json` |
| Text (Adv) | Link hover colour, icon hover colour | [code] `advancedheading/block.json` |
| Tabs, Accordion, Table, Navigation link, Count Up | Hover colours and borders | [code] respective `block.json` |
| Theme buttons | Customizer hover colours and "Button Hover State Shadow" | [runtime] the runtime capture |

Not native: hover translate/lift, scale on cards, 3D tilt, magnetic buttons, hover underline animations beyond colour [code] (no `transform` hover attributes in any `block.json`).

## 11. Parallax, transforms and motion effects

- **Row Layout background "Parallax"**: set Background > image > Attachment to Parallax (`bgImgAttachment: "parallax"`, also for the overlay image). Adds class `kt-jarallax` and loads `jarallax.min.js` plus `kt-init-parallax.min.js` [code] `class-kadence-blocks-row-layout-block.php:72-73, 1761-1762, 1873-1874`. Speed comes from filter `kadence_blocks_parallax_speed` (default -0.1) [code] `:1875-1880`. CSS fallback is `background-attachment: fixed`, turned off on tablets [code] `:863-880`. No reduced-motion handling in jarallax or the init script [code] `kadence-blocks/includes/assets/js/jarallax.min.js`, `kt-init-parallax.min.js`.
- **Fixed backgrounds**: Attachment "Fixed", disabled on tablets/iPad by default (filter above).
- **Transforms / motion effects (rotate, translate on scroll, mouse track)**: not present in any studied product [code] (no transform or scroll-effect attributes; Creative Kit has none either).
- **Shape dividers**: Row Layout top/bottom separators with per-device height and width [code] `rowlayout/block.json` (`topSep*`, `bottomSep*`).
- **Video backgrounds** on Row Layout: autoplay loop, no reduced-motion check [code] `kadence-blocks/includes/assets/js/kb-init-html-bg-video.min.js`.

## 12. Reduced-motion support per product

| Product / feature | Handles `prefers-reduced-motion`? | Source |
|---|---|---|
| Blocks Pro AOS | Yes: `AOS.init({ disable: true })` when reduced, which removes the `data-aos` attributes so content shows immediately | [code] `kadence-blocks-pro/includes/assets/js/aos.min.js` |
| Creative Kit AOS fallback | No | [code] `kadence-creative-kit/assets/js/aos.min.js` |
| Creative Kit Marquee | No | [code] `kadence-creative-kit/assets/js/kb-marquee-init.min.js` |
| Kadence Blocks typed text | Yes (skips typing) | [code] `kb-advanced-heading.min.js` |
| Kadence Blocks Count Up | Yes (prints end value) | [code] `kb-countup.min.js` |
| Kadence Blocks Countdown | Yes (JS and CSS) | [code] `kb-countdown.min.js`, `dist/style-blocks-countdown.css` |
| Splide carousels (Blocks, Blocks Pro, theme) | Yes (speed 0, autoplay paused) | [code] each `splide.min.js` |
| Splide AutoScroll [Pro] | No own check | [code] `splide-auto-scroll.min.js` |
| Row parallax (jarallax), video background, Lottie, progress bars | No | [code] `jarallax.min.js`, `kb-init-html-bg-video.min.js`, `lottie-*.min.js`, `kb-progress-bars.min.js` |
| Theme (smooth scroll, header reveal/shrink, dropdown and popup transitions) | No (only its bundled Splide) | [code] search of `kadence/` returns only `assets/js/splide.min.js` |
| Theme Kit Pro | No matches | [code] search of `kadence-pro/` |

## 13. Checklist: polished interactions without custom code

1. Set layouts per device in Row Layout (tablet layout, mobile layout, collapse order "Reverse" for media-first rows).
2. Use Kadence spacing and font-size presets; the font presets are fluid `clamp()` values, so many headings need no tablet/mobile overrides.
3. Use per-device padding, margin, gap and max width instead of hiding duplicate sections.
4. Hide whole areas per device with Section or Row Layout "Hide on" toggles; for header items use the separate mobile header layout.
5. Entrance motion: Section > Advanced > Animate on Scroll, `fade-up` or `fade`, duration 400 to 600, offset 80 to 120, set "Only show once" to True (global default is false, which replays).
6. Stagger a row of cards by giving each Section a larger Start Delay (for example 0, 100, 200 ms).
7. Hover polish: Single Button hover colours and shadow; Section "Hover Styles" for card background, border and shadow; Info Box hover background/shadow and icon hover animation; Image Overlay zoom for image cards [Pro].
8. Sticky: theme sticky header with reveal on scroll up and shrink; Section "Make sticky" for a sidebar or table of contents (check the `overflow: clip` side effect).
9. Logo strips: Marquee (Adv) with Fade Edges, Pause on Hover and the Pause Button [Creative Kit].
10. Background depth: Row Layout background image with Parallax, overlay gradient and shape dividers.
11. Small per-section CSS that has no control (for example a hover lift on one Section) can go in the Row Layout or Section "Custom CSS" box using the `selector` placeholder [code] `class-kadence-blocks-row-layout-block.php:1346-1347`, `class-kadence-blocks-column-block.php:953-954` (only these two blocks support `kbcss` [code] `block.json` files). Follow the project's own rules on where CSS may live.
12. Test at 375, 720 to 767 (the mismatch band), 768, 1024, 1025 and 1366 px, and once with reduced motion turned on in the OS.

## 14. Native gaps where custom CSS/JS is genuinely required

1. **Reduced motion for the Creative Kit marquee, Row parallax, Lottie, video backgrounds, Splide AutoScroll and theme smooth scroll.** None check the preference (section 12). A small `@media (prefers-reduced-motion: reduce)` rule or script is the only way to stop them.
2. **Hover transforms** (lift, scale, tilt, magnetic). No block has transform hover attributes.
3. **Scroll-linked effects** (progress-scrubbed motion, sticky scroll stories, scroll-driven counters). AOS only triggers once per entry; GSAP ScrollTrigger is not bundled.
4. **Per-device animation** (for example no animation on phones). AOS has no device option in the Kadence UI.
5. **Hide on device for blocks other than Row Layout, Section, Spacer and Countdown**, unless they are wrapped in a Section. Also, hiding is CSS only; server-side device removal needs code.
6. **Consistent mobile breakpoint.** Element device conditions and some theme CSS switch at 719/720 px, block settings at 767/768 px. Aligning them needs the `kadence_*_media_query` filters or custom CSS.
7. **Disabling a sticky Section on mobile.** No device toggle.
8. **Marquee resize and keyboard issues** (re-init on resize, `inert` on clones). See `creative-kit.md` section 10.
9. **Custom cursor and cursor-following effects.** Not in any Kadence product studied.
