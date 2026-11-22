# Kadence Creative Kit: what it really provides

Purpose: a verified, code-based account of what Kadence Creative Kit adds to a Kadence site, so builders know what it can and cannot replace.

Versions studied: Kadence Creative Kit 1.1.4, with Kadence Blocks 3.9.1 and Kadence Blocks Pro 2.8.16 for the dependency and overlap checks.

Contents
1. Summary
2. Feature inventory (present and not present)
3. Marquee (Adv) block
4. Marquee Item block
5. Animate on Scroll add-on (only when Blocks Pro is absent)
6. Page Wizard (beta only, not registered)
7. Design library and AI REST routes
8. Dependency on Kadence Blocks and Blocks Pro
9. Licence gating approach
10. When Creative Kit replaces custom code, and when it does not

Paths are relative to `wp-content/plugins/`. Built JavaScript is minified to one line, so those citations give the file only.

## 1. Summary

- The plugin describes itself as "Premium Designs, AI Page Generator" [code] `kadence-creative-kit/kadence-creative-kit.php:4`.
- In 1.1.4 the only front-end feature that loads on a site that also runs Blocks Pro is the **Marquee (Adv)** block (`kadence/marquee`) with its child **Marquee Item** (`kadence/marquee-item`) [code] `kadence-creative-kit/inc/KadenceCreativeKit/Blocks/Provider.php:36-42` [runtime] the runtime capture-96`.
- It also ships an **Animate on Scroll** add-on, but it only registers when Kadence Blocks Pro is not active (`KBP_VERSION` undefined) [code] `kadence-creative-kit/inc/KadenceCreativeKit/Blocks/Provider.php:44-49`. With Blocks Pro active, Blocks Pro provides the same feature (see `responsive-animation.md`).
- Most "creative" effects people expect from a kit (scroll-linked motion, text animation, custom cursor, hover tilt, Lottie, SVG) are **not** in Creative Kit. Some of them exist in Kadence Blocks itself (Lottie, Vector SVG, typed text).

## 2. Feature inventory

| Feature | Status in Creative Kit 1.1.4 | Where it actually lives, if anywhere |
|---|---|---|
| Marquee / ticker / logo strip | **Present**: `kadence/marquee` [code] `kadence-creative-kit/build/blocks/marquee/block.json:4` | |
| Sliders / carousels | Not present as a block. The plugin ships Splide files (`assets/js/splide.min.js`, `kb-splide-init.min.js`, `splide-auto-scroll.min.js`) but no PHP registers or enqueues them in 1.1.4 [code] (search of `inc/` for `splide.min`, `kb-splide-init` returns nothing). They are leftovers from the pre-1.1.4 Splide marquee (`readme.txt:32`). | Kadence Blocks (Gallery carousel, Testimonials, Row background slider), Blocks Pro (Advanced Slider, Post Grid/Carousel, Product Carousel) |
| Entrance (scroll reveal) animations | Present only as a fallback when Blocks Pro is absent [code] `Blocks/Provider.php:44-49` | Blocks Pro AOS (same attributes) |
| Scroll-linked / parallax motion effects | Not present [code] (no scroll handlers except AOS) | Kadence Blocks Row Layout background "Parallax" (jarallax) |
| Hover interactions (tilt, lift, magnetic) | Not present | Native hover colours, borders and shadows in Kadence Blocks (see `responsive-animation.md`) |
| Text animations | Not present | Kadence Blocks Text (Adv) typed text format and "Slide Reveal" AOS |
| Custom cursor | Not present | None in any Kadence product studied |
| Image effects (filters, hover zoom) | Not present | Kadence Blocks image filters; Blocks Pro Image Overlay hover zoom/slide/grayscale/blur |
| SVG / vector | Not present in Creative Kit | `kadence/vector` is a Kadence Blocks block [code] `kadence-blocks/includes/blocks/class-kadence-blocks-vector-block.php` [runtime] the runtime capture |
| Lottie | Not present in Creative Kit | `kadence/lottie` is a Kadence Blocks block [code] `kadence-blocks/includes/blocks/class-kadence-blocks-lottie-block.php` [runtime] the runtime capture |
| GSAP | **Bundled** (core GSAP 3.12.5 only, no ScrollTrigger plugin file) and used only by the marquee [code] `kadence-creative-kit/assets/js/gsap.min.js` header; `Blocks/Marquee_Block.php:456-469` | |
| Global settings page | Not present. The plugin only adds a licence panel to the Kadence Blocks home screen [code] `Admin/Provider.php:34`, `Admin/Settings.php:30-38` | |
| Premium design library / AI page generator | Back end only: REST routes that proxy to the Kadence cloud [code] `Admin/Designs_REST_Controller.php:36-42, 57-106`. The editor UI for it is not in this plugin. | Kadence Blocks design library [unverified]: check the Design Library modal while the Creative Kit licence is active |

## 3. Marquee (Adv) block

### Registration
- Block name `kadence/marquee`, title "Marquee (Adv)", category `kadence-blocks`, API version 3, supports `anchor`, no HTML editing [code] `kadence-creative-kit/build/blocks/marquee/block.json:3-17`.
- Registered from `block.json` in PHP on `init` (priority 20 via the abstract class) with a PHP render callback [code] `Blocks/Abstract_Block.php:81, 88-130`. Rendered by PHP [runtime] the runtime capture.
- Editor script is `build/blocks-marquee.js`, not the `index.js` named in `block.json`, because the PHP passes its own handles [code] `Blocks/Abstract_Block.php:91-124`.
- Only child allowed: `kadence/marquee-item` [code] `build/blocks-marquee.js` (allowedBlocks list). Default template: three items [code] `block.json:264-283`.

### Editor location
Inserter > Kadence Blocks category > "Marquee (Adv)". The block toolbar has a Preview / Edit toggle ("Switch to Preview Mode", "Switch to Edit Mode") so the animation can run in the editor, and an "Add Marquee Item" action [code] `build/blocks-marquee.js` (labels). Editor preview of the animation was added in 1.1.4 [code] `readme.txt:33`.

### Every setting

| Setting (editor label) | Attribute | Default | Responsive | Notes |
|---|---|---|---|---|
| Orientation | `orientation` | `horizontal` | No | `horizontal` or `vertical`. Changing it resets direction to left or top [code] `build/blocks-marquee.js` |
| Direction | `direction` | `left` | No | Horizontal: `left`, `right`. Vertical: `top`, `bottom` [code] `build/blocks-marquee.js` |
| Scroll Speed > Speed | `speed` | 25 | No | Range 1 to 100. Help text "Higher speeds can cause accessibility issues" shows above 60 [code] `build/blocks-marquee.js`. See speed maths below |
| Pause on Hover | `pauseOnHover` | false | No | Pauses on `mouseenter`, resumes on `mouseleave` [code] `assets/js/kb-marquee-init.min.js` |
| Show Pause Button | `showPlayPause` | false | No | Adds a `<button class="splide__toggle">` with play/pause icons and `aria-pressed` [code] `Blocks/Marquee_Block.php:148-151`; JS toggles `aria-label` between "Pause marquee scroll" and "Start marquee scroll" [code] `kb-marquee-init.min.js` |
| Pause Button padding / Button Background / Icon Color | `pauseButtonPadding` (+ tablet, mobile), `pauseButtonBackground`, `pauseButtonColor` | empty | Padding yes | [code] `Marquee_Block.php:404-421` |
| Item Gap | `gap`, `gapTablet`, `gapMobile`, `gapUnit` | 20 px | Yes | Output as `--kb-marquee-gap` [code] `Marquee_Block.php:239-251` |
| Item Height (horizontal) / Container Height (vertical) | `height` [desktop, tablet, mobile], `heightUnit` | [100,100,100] px | Yes | Horizontal sets `--kb-marquee-item-height`; vertical sets the container height [code] `Marquee_Block.php:309-362` |
| Item Width (vertical only) | `itemWidth` [d, t, m], `itemWidthUnit` | 100 % | Yes | `--kb-marquee-item-width` [code] `Marquee_Block.php:364-378` |
| Max width | `maxWidth` [d, t, m], `maxWidthUnit` | empty | Yes | [code] `Marquee_Block.php:381-396` |
| Fade Edges | `transition` | true | No | Adds a CSS `mask-image` gradient on both edges (class `kb-marquee-transition-fade`) [code] `Marquee_Block.php:129-130`, `build/blocks/marquee/style-index.css` |
| Fade Width | `transitionDistance` [d, t, m], unit px | [100, 60, 40] | Yes | `--kb-marquee-transition-distance` [code] `Marquee_Block.php:253-260` |
| Background Settings | `backgroundType` (`normal`/`gradient`), `background`, `backgroundGradient` | normal | No | Palette colours resolve through the Kadence colour renderer [code] `Marquee_Block.php:291-307` |
| Margin / Padding | `margin`, `tabletMargin`, `mobileMargin`, `padding`, `tabletPadding`, `mobilePadding`, units | empty | Yes | [code] `Marquee_Block.php:398-403` |
| Border Radius (applies to every item) | `borderRadius` (+ tablet, mobile), `borderRadiusUnit` | empty | Yes | Adds `overflow:hidden` on items [code] `Marquee_Block.php:431-436` |
| Z-Index | `zIndex` | empty | No | Adds `position:relative` [code] `Marquee_Block.php:424-429` |
| Anchor | `anchor` support | | | `block.json:16` |

### Speed maths
`speed` (1 to 100) is divided by 4 and written to `data-marquee-speed` (minimum 1) [code] `Marquee_Block.php:157`. The script parses it as an integer, divides by 10 and clamps to 0.1 to 2.5, then moves at that value times 100 px per second [code] `kb-marquee-init.min.js`. So the default 25 runs at about 60 px/s, and 100 runs at 250 px/s. Speeds 1 to 4 all run at the minimum 10 px/s.

### Front-end implementation
- Markup: a wrapper `kb-advanced-marquee kb-advanced-marquee-{id} kb-advanced-marquee--{orientation}`, then a `splide`-classed track and a `ul.splide__list`. Each item is an `li.splide__slide` [code] `Marquee_Block.php:136-187`, `Marquee_Item_Block.php:117-122`. The `splide` class names remain for styling only; Splide itself is not loaded.
- Script: `assets/js/kb-marquee-init.min.js`, handle `kadence-creative-kit-marquee`, depends on handle `gsap` [code] `Marquee_Block.php:471-478`.
- GSAP: registered as handle `gsap` (version string 3.12.5) only if no other plugin already registered `gsap`. The URL can be swapped with the filter `kadence_creative_kit_gsap_src` [code] `Marquee_Block.php:456-469`.
- Behaviour: waits for all images in the list to load, measures items, clones the set until the strip is at least three times the container size, marks clones `aria-hidden="true"` and class `kb-marquee-clone`, then builds an infinite GSAP timeline (`repeat: -1`, `ease: none`). Right/bottom directions reverse the timeline [code] `kb-marquee-init.min.js`.
- It does **not** use IntersectionObserver, does not listen for `resize` or `visibilitychange`, and exposes `window.kbMarquee.init()` for a manual re-init [code] `kb-marquee-init.min.js` (no matches for `resize`, `IntersectionObserver`, `visibilitychange`).
- Styles: `build/blocks/marquee/style-index.css` is loaded only when the block is on the page; per-block CSS is generated with the Kadence breakpoints (tablet `max-width: 1024px`, mobile `max-width: 767px`) [code] `Blocks/Minified_CSS.php:384-390`.

### Responsive controls
Gap, item height or container height, item width (vertical), max width, fade width, margin, padding, border radius and pause button padding all have desktop / tablet / mobile values. Orientation, direction, speed and pause behaviour do not. There is no per-device "disable marquee" option.

### Reduced motion
- The front-end marquee script has **no** `prefers-reduced-motion` check [code] `kb-marquee-init.min.js` (no `matchMedia` call). The animation runs for users who asked for reduced motion.
- The only reduced-motion string in Creative Kit's editor code comes from a bundled Splide copy inside `build/blocks-marquee-item.js`, not from marquee logic [code].
- Practical answer: turn on "Show Pause Button" (meets the WCAG "pause, stop, hide" need for motion over 5 seconds), keep speed low, and if reduced motion must stop the strip, that needs a small custom script or CSS (see section 10).

### Performance notes
- Page cost when used: GSAP core (about 70 KB minified) plus 5 KB init script plus the style file [code] `wc -c` of `assets/js/gsap.min.js`, `kb-marquee-init.min.js`.
- Clones multiply DOM nodes and images (at least 3x the visible width). Keep items light and use correctly sized images.
- The timeline keeps running when the marquee is off screen. GSAP uses `requestAnimationFrame`, so browsers throttle it in background tabs.
- Because there is no resize handler, a marquee measured on a narrow viewport and then widened may show gaps until reload [code] (absence of `resize` listener). Test by resizing a desktop window.

### Limitations
- No reduced-motion handling, no off-screen pause, no resize re-measure (above).
- Clones are `aria-hidden` but are not `inert`, so links or buttons inside items are duplicated in the keyboard tab order [code] `kb-marquee-init.min.js` (only `aria-hidden` is set). Avoid focusable content in items, or accept duplicate focus stops.
- No drag/swipe control, no per-item speed, no "scroll-linked" speed.
- `orientation`, `direction` and `speed` are not responsive.

### Practical examples
- Partner or tool logo strip: horizontal, direction left, speed 15 to 25, Item Height 48 to 64 px, Fade Edges on, Pause on Hover on, Show Pause Button on. Put one Image (Adv) per Marquee Item.
- Text ticker: Marquee Items with Text (Adv), Item Gap 40 px, Fade Edges on.
- Vertical testimonial scroller: orientation vertical, Container Height 400 px desktop / 300 px mobile, Item Width 100 %.

## 4. Marquee Item block

- Name `kadence/marquee-item`, parent `kadence/marquee`, hidden from the inserter, not reusable, supports `anchor` and `kbMetadata` [code] `build/blocks/marquee-item/block.json:5, 96-105`.
- Allowed inner blocks: `core/paragraph`, `core/heading`, `core/image`, `kadence/image`, `kadence/advancedheading`, `kadence/icon`, `kadence/rowlayout`, `kadence/column`, `kadence/vector`, `kadence/lottie`, `kadence/infobox` [code] `build/blocks-marquee-item.js` (allowedBlocks list). Inner block list widened in 1.1.2 [code] `readme.txt:43`.
- Settings: Background Settings (`backgroundType`, `background`, `backgroundGradient`), Margin and Padding with tablet and mobile values [code] `block.json:17-94`. The PHP also reads `textColor`, `linkColor`, `linkHoverColor` [code] `Marquee_Item_Block.php:140-153`, but these are not declared in `block.json` [code], so they have no visible control [unverified]: check the Marquee Item sidebar.
- Render: `li.kb-marquee-item.splide__slide > div.kb-advanced-marquee-item > div.kb-marquee-item-inner` [code] `Marquee_Item_Block.php:94-122`.

## 5. Animate on Scroll add-on (Blocks Pro absent only)

- Registers only when `KBP_VERSION` is not defined [code] `Blocks/Provider.php:44-49`. On a site with Blocks Pro active it is inert; Blocks Pro's own AOS is used instead.
- Same attributes and option set as Blocks Pro: it adds `kadenceAnimation` and `kadenceAOSOptions` to every block that declares support `ktanimate` [code] `build/aos-early-filters.js` (filter `blocks.registerBlockType`, namespace `kadence/animation`), and the same animation list (fade, flip, slide, zoom families, reveal, swipe, parts) [code] `build/aos-editor.js`.
- Global defaults are read from the same option `kadence_blocks_config_blocks` key `kadence/aos`: offset 120, duration 400, easing `ease`, delay 0, once false [code] `Blocks/AOS_Block_Addon.php:36-46`.
- Assets: `assets/js/aos.min.js` and `assets/css/aos.min.css`, enqueued only when a block on the post (including inner blocks and synced patterns) has `kadenceAnimation` [code] `AOS_Block_Addon.php:95-163`. Blocks outside post content (for example in a Kadence Element) are not scanned by this add-on [code] (it reads only the global `$post`).
- Reduced motion: **not handled** in the Creative Kit copy; its init calls `AOS.init` without `disable` [code] `kadence-creative-kit/assets/js/aos.min.js` (tail). The Blocks Pro copy does disable AOS for reduced motion (see `responsive-animation.md`).

## 6. Page Wizard (not active)

`kadence/page-wizard` is registered only when the constant `KADENCE_CREATIVE_KIT_BETA` is defined [code] `Blocks/Provider.php:32-34`. It is not in the runtime block list [runtime] (no `page-wizard` line in the runtime capture). Treat it as unavailable.

## 7. Design library and AI REST routes

- Namespace `kadence-creative-kit/v1`, base `get`, routes `/suggest`, `/styles`, `/create_page`, `/job`, all POST [code] `Admin/Designs_REST_Controller.php:47-50, 57-106`. They call `content.startertemplatecloud.com` and `patterns.startertemplatecloud.com` [code] `Designs_REST_Controller.php:36-42`, sending a header built from the site domain and licence key [code] `Designs_REST_Controller.php:354-370`.
- The routes are registered on every request, not only in beta [code] `Admin/Provider.php:38`.
- **Security note:** these routes call the vendor cloud with the site's licence. Keep Creative Kit updated and remove it if it is not used.

## 8. Dependency on Kadence Blocks and Blocks Pro

| Check | Finding |
|---|---|
| Hard dependency | Boots only if `KADENCE_BLOCKS_VERSION` is defined at `plugins_loaded`; otherwise shows an "Install/Activate Kadence Blocks" admin notice [code] `kadence-creative-kit.php:38-50, 64-96` |
| Minimum Blocks version | None checked in code [code] (no version compare). WordPress 6.4 and PHP 7.4 minimums [code] `kadence-creative-kit.php:11-12` |
| Shared infrastructure | Uses the Kadence Blocks Uplink licensing classes [code] `inc/uplink/Connect.php:7-14, 54-72`, the `kadence-blocks` block category, Kadence Blocks filters such as `kadence_blocks_check_if_rest` and `kadence_blocks_force_render_inline_stylesheet` [code] `Blocks/Abstract_Block.php:151, 331` |
| Blocks Pro overlap | AOS add-on switches itself off when Blocks Pro is active [code] `Blocks/Provider.php:44` |
| Kadence Blocks awareness | Kadence Blocks uses the Creative Kit licence key for its cloud features when no Blocks Pro key exists [code] `kadence-blocks/includes/helper-functions.php:183-191, 228-230, 329-331` |

## 9. Licence gating approach

- Licensing is registered through the Kadence Blocks copy of StellarWP Uplink under the slug `kadence-creative-kit` on the hook `kadence_blocks_uplink_loaded` [code] `inc/uplink/Connect.php:47, 54-72`. If Uplink is missing, licensing silently does nothing [code] `Connect.php:55-57`.
- The licence field appears on the Kadence Blocks home screen (hook `kadence_blocks_admin_before_home`) [code] `Admin/Provider.php:34`, `Admin/Settings.php:30-38`. An admin notice shows when the licence is inactive [code] `Connect.php:110, 191-215`.
- The Marquee block and the AOS add-on contain no licence checks [code] (no `license` or `is_authorized` references in `inc/KadenceCreativeKit/Blocks/` or the built block scripts). The licence governs updates and the cloud design/AI services, not whether the marquee renders.

## 10. When Creative Kit replaces custom code

Use the Marquee (Adv) block instead of custom code when you need:
- an infinite horizontal or vertical scrolling strip of logos, text, icons or cards;
- fade-out edges (CSS mask, already built in);
- pause on hover and an accessible pause button;
- responsive gap, item size, fade width and spacing edited visually.

Custom code is still genuinely required for:
- **Stopping the marquee for `prefers-reduced-motion: reduce`.** The script has no check. Minimal approach: a small script that calls `pause()` on each element's `_kbMarqueeTimeline` when the media query matches (the script stores the timeline on the element) [code] `kb-marquee-init.min.js`. This relies on an internal property, so retest after every Creative Kit update.
- **Re-measuring after resize** (orientation change on tablets). Call `window.kbMarquee.init()` on a debounced resize [code] `kb-marquee-init.min.js`.
- **Keyboard-safe clones** (adding `inert` to `.kb-marquee-clone`) if items contain links.
- Anything scroll-linked, cursor-based, tilt, magnetic hover or GSAP ScrollTrigger effects. None of these exist in Creative Kit 1.1.4.
