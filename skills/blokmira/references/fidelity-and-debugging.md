# Design fidelity, layout debugging and justified custom code

Practical lessons from rebuilding an approved multi-page design in Kadence (Blocks 3.9.x, Blocks Pro 2.8.x, Theme
1.6.x, Theme Kit Pro 1.2.x). Tags as elsewhere: `[runtime]` seen in a browser, `[code]` read in the plugin source.

Contents: 1 Comparing against a design · 2 When custom CSS or JS is justified · 3 Keeping it editable ·
4 Row Layout and Section traps · 5 Vertical spacing · 6 Dynamic content traps · 7 Animations · 8 Debugging method ·
9 Plugin duplication

## 1. Comparing against a design

- Render the reference and the live page **at the same viewport width and scale**, full height, and cut both into
  matching horizontal bands placed side by side. Compare section by section, top to bottom; then repeat at tablet and
  phone widths and in dark mode. One pass is never enough: fix, capture again, compare again.
- Compare geometry before detail: section order and height, container width, column ratio, then typography, wrapping,
  spacing, borders, shadows, images, hover and motion.
- Scroll-linked reveals (`animation-timeline: view()`) leave everything below the first viewport at its "from" state in
  a full-page screenshot. Resize the viewport to the full page height before capturing, or capture with reduced motion
  `[runtime]`. Do not "fix" sections that only look empty in the capture.
- Read the design's own CSS for exact values (font sizes with `clamp()`, gaps, radii, timings) instead of estimating
  from pixels, and cite the source line next to anything you reproduce.
- Keep a difference register: page, section, reference, live, problem, root cause, fix, verification. Severe
  differences (missing sections, missing visuals, wrong layout) first.
- Differences that come from facts are not defects: if the design shows sample statistics, reviews or client names
  that are not verified, leave them out and record why.

## 2. When custom CSS or JS is justified

Kadence first is not Kadence only. Write the smallest custom piece when the native route is missing, and record which
native options you checked. Typical justified cases `[runtime]`:

| Need | Native limit | Small custom piece |
|---|---|---|
| Grid where one card spans two rows (bento) | Query Loop (Adv) and Section grids have equal tracks | `grid-template-areas` on the query grid, scoped by a class |
| Vertical word carousel inside a heading | Text (Adv) typed format types letters; no slide rotation | Heading keeps the full sentence; a small script builds the rotation, `aria-label` keeps the sentence |
| Auto-advancing tabs with a progress bar | Tabs have no timer | Script clicks the next title; stops on any user interaction and for reduced motion |
| Logo marquee that respects reduced motion | Creative Kit Marquee (Adv) ignores reduced motion | CSS loop plus one cloned set (`aria-hidden`, `inert`); wraps and stops for reduced motion |
| Two lines either side of a label, a watermark logo, a glow | One border per side; one background per Section | Pseudo-elements on a scoped class |
| Fixed-size circle with centred text | Advanced Text has max width, not width or height | `width`, `height`, `display:grid; place-items:center` on a scoped class |
| Decorative illustration made of dozens of shapes | Building it from nested Sections makes editing harder | A server-rendered block with no settings; all real copy stays in Kadence blocks |

Rules: scope every rule to a class set in the block's Advanced panel; read `var(--global-paletteN)` for colours;
put each component's "why not a Kadence setting" in a comment; load page-specific CSS and JS only where used; honour
`prefers-reduced-motion`; never hide content when scripts fail.

## 3. Keeping it editable

- Every visible word lives in a block the owner can edit. Scripts enhance markup that already reads correctly
  without them (the rotating heading shows the full sentence; tabs work as normal tabs).
- Put repeating content in post types and Query Loop cards, not in copies of the same Section.
- Build with the editor's own `createBlock` and save through the editor, then reload the editor and confirm there
  are no invalid blocks.
- Name blocks in List View so the owner can find them ("Hero illustration", "Problem finder (advances every 5 s)").

## 4. Row Layout and Section traps

- Horizontal Sections give Section children `flex-grow: 1` and do not output a zero grow. To size grid items, give the
  parent a flex basis (it applies to Section children only) or each child a max width `[runtime]`.
- Non-Section children (Advanced Text, Buttons, Progress Bar, Image) do not grow. Wrap them in a Section when they
  must fill the row (a progress bar beside a label stayed at its intrinsic width) `[runtime]`.
- A Section's **mobile** direction set explicitly to `vertical` outputs a high-specificity rule that centres children
  that have a max width (`margin: auto`); block margins cannot beat it. The tablet `vertical` rule does not. Leave the
  mobile direction empty so phones inherit the tablet stack `[runtime]`.
- `verticalAlignment` has one value for all devices. `bottom` becomes `align-items: flex-end` once a row stacks and
  pushes headings and buttons to the right edge. For heading-plus-button rows keep the phone direction horizontal with
  wrap and a 100 % phone flex basis `[runtime]`.
- A Section ignores its pixel `gutter`/`rowGap` unless `gutterVariable`/`rowGapVariable` is `'custom'` (it prints the preset instead, default `sm` 16px column gap, no row gap). Check the variable before assuming a gap bug; see limitations.md.
  Space with block margins `[runtime]`.
- Max width on Section uses one unit for all devices: `[470, 470, 100]` with unit px means 100 px on phones, not 100 %.
  Leave the device value empty for "no limit" `[runtime]`.
- Advanced Buttons store margins as `margin[0].desk / tablet / mobile`; there is no `mobileMargin` attribute `[code]`.
- Query cards: the grid columns, gaps, card border, radius, padding, background and hover shadow are query card
  settings (stored as `_kad_query_card_*` post meta), not CSS `[code]`. A hidden `kb-query-item-flip-back` element sits
  beside the card in each item: never turn the item into a flex row; give the card `height: 100%` instead `[runtime]`.
- Kadence Section backgrounds paint on the inner `.kt-inside-inner-col`; decorative pseudo-elements on the outer
  element end up underneath. Put them on the inner column `[runtime]`.

## 5. Vertical spacing

- Use the design's section padding (often a `clamp()` rhythm) as Row Layout padding per device; do not shrink every
  section globally to "fix" one gap.
- Most "too much space" reports are an empty element (a hidden block still taking a margin, an empty paragraph), a
  stacked column measured as if side by side, or a margin added in two places. Find the element first.
- Prefer one owner per gap: either the parent's gap or the child's margin, never both.

## 6. Dynamic content traps

- A computed ACF field (a value supplied by `acf/load_value`) is invisible to Dynamic Content until the post has the
  field reference meta (`_fieldname` = field key). Write the reference on save, and once for existing posts `[runtime]`.
- Dynamic Content prints a field's stored value: a select prints its key, a post object an ID. Provide a readable
  computed field when the design needs the label, title or URL.
- Before/After text prints even when the field is empty: pair it with Conditional Display "Not empty".

## 7. Animations

- Reproduce the reference's timings and easing from its CSS; keep the same element order for staggered entrances.
- Put every animation inside `@media (prefers-reduced-motion: no-preference)` or stop it under `reduce`; timers in
  scripts must check the same preference and stop when the user interacts.
- Animate `transform` and `opacity`; reserve the element's space so nothing shifts while it animates.
- Test animations live at the target widths, then once with reduced motion on.

## 8. Debugging method

1. Measure in a real browser at the failing width: element widths, computed `display`, `flex`, `margin`, `align-items`.
2. Walk up the ancestors until the value changes; the first ancestor that differs owns the bug.
3. List the CSS rules that match it (stylesheets and Kadence's inline per-block CSS) and read their specificity.
4. Fix the block setting first. Write CSS only when no setting exists, and never add an override to beat another of
   your own overrides.
5. Capture again at every width that rule can affect, light and dark.

## 9. Plugin duplication

- Before adding a setting or feature, check whether Kadence, the form plugin, the CRM or the SEO plugin already has
  it (robots.txt, sitemaps, llms.txt, social images, email templates, schema). Configure the owner plugin; add code
  only through its filters (for example an SEO plugin filter to reuse the meta description in llms.txt).
- Keep one authority per output: one robots.txt source, one Organization schema, one social image setting.
