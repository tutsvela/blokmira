---
name: blokmira
description: Blokmira for Kadence. Native-first WordPress development with the Kadence ecosystem (Kadence Theme and Customizer, Theme Kit Pro, Kadence Blocks, Blocks Pro, Creative Kit, Conversions, Shop Kit, Insights). Use this skill whenever the user wants to build or change a WordPress site, page, section, template, header, footer or layout with Kadence or Gutenberg; recreate a screenshot, Figma or canvas design in WordPress; choose the right Kadence block, setting or Element; read or change Customizer settings (palette, typography, header and footer builder, layouts) by hand, script or MCP tool; show ACF or post data dynamically; add conditional, reusable or hooked content; add native animations or responsive behaviour; or avoid unnecessary custom CSS, PHP or JavaScript on a Kadence site. Use it even when the user only says "build this section in WordPress" or "make this responsive" on a site that runs Kadence.
license: GPL-2.0-or-later
metadata:
  author: Salman Sarwar
  version: 0.1.0
  homepage: https://github.com/tutsvela/blokmira
---

# Blokmira: native-first Kadence development

Blokmira is an independent project by Salman Sarwar. It is not made, endorsed or supported by Kadence, Nexcess or Liquid Web. "Kadence" names the products this skill works with.

This skill turns a design or feature request into native Kadence settings. Its knowledge base has three sources:
- the installed source code of every Kadence product, with file and line references;
- a hands-on build in the block editor;
- a full study of the official Kadence documentation, now published by Nexcess (`references/official-docs.md`).

**Why native first:**
- Native settings stay editable by the site owner in the editor.
- They follow global palette and typography changes.
- They survive theme and plugin updates.

Custom code does none of that reliably. It is still the right answer when a native route is missing, inaccessible, insecure or unreliable, and the references say where that is the case.

**Version policy.** The skill works with any Kadence version.
- Code findings carry the version they were verified against (`references/environment-check.md` §1).
- On a real site, the runtime scripts in `scripts/` are the source of truth for blocks, attributes, Customizer keys and choices.
- When a reference and the runtime disagree, trust the runtime and say so.

## 1. Before anything else: check the environment
Kadence installs differ: products, versions, licences and enabled Theme Kit Pro modules all vary.
- **Inventory.** Run the read-only scripts (`references/environment-check.md` §3):
  - `runtime-inventory.php`: products, versions, modules, blocks, Customizer sections;
  - `customizer-schema.php`: every Customizer setting as JSON;
  - `block-schema.php`: every Kadence block and its attributes as JSON.
  - `style-overrides.php`: child theme and Additional CSS that can override Customizer fonts and colours.
  Record the result in the project's docs, not in this skill.
- **No shell access?** Use what the agent has: the WordPress admin in a browser (Appearance › Kadence, Kadence › Settings, Customize), the REST API, or an MCP server that exposes the operations in `references/customizer-automation.md` §7.
- **Missing product or module:** do not plan around features from a product or module that is not present. Tags in the references show what each feature needs:
  - `[Pro]` = Blocks Pro;
  - `[TKP]`/`[Theme Kit Pro]` = Theme Kit Pro and its module switch;
  - `[CK]` = Creative Kit.
  Other paid products (Conversions, Shop Kit, Insights, Custom Fonts, Child Theme Builder) are named in `references/official-docs.md` §2.
- **Site settings need consent:** switching on a module or changing global Customizer settings is a site setting change, so ask the site owner first.

## 2. The decision order
Work down the list and stop at the first level that fully solves the requirement. Full rules: `references/decision-framework.md`.

1. **Theme controls:** Customizer, global palette and typography, Header and Footer Builders, post type layouts, per-page Kadence settings. The full list is `references/customizer-settings.md`; scripted changes follow `references/customizer-automation.md`.
2. **Kadence Blocks and Blocks Pro:** blocks, block styling, Style Library, responsive controls, Dynamic Content, Conditional Display, Query Loop (Adv), Animate on Scroll.
3. **Kadence Elements** (Theme Kit Pro): reusable, conditional, hooked or template content.
4. **Other Kadence products when installed:**
   - Creative Kit: Marquee (Adv).
   - Conversions: popups, slide-ins, banners.
   - Shop Kit: WooCommerce templates and product blocks.
   - Insights: A/B tests.
   - Custom Fonts: uploaded and Adobe fonts.
5. **Minimal reusable CSS:** scoped to a class set in the block's Advanced panel, using `var(--global-*)` tokens. Use Kadence's own CSS places first (block Custom CSS, Page Scripts, Customizer Additional CSS); see `references/official-docs.md` §5.
6. **Custom PHP or JavaScript:** last. Prefer documented Kadence filters and JS events (`references/official-docs.md` §6) over overrides.

**Before writing any custom code:**
1. State the requirement.
2. Look it up in `recipes.md`, the product reference and `official-docs.md`.
3. Name the native features you checked.
4. Give each one's concrete limit, citing the reference.
5. Only then propose the smallest custom piece, kept separate from the Kadence layout so content stays editable.

Never invent a block, setting, hook or attribute. If the references and the runtime scripts do not confirm it, check the installed plugin before using it, or say it is unverified.

## 3. Design-to-Kadence workflow
Follow this when given a screenshot, Figma frame, design canvas or written layout. The detailed guide is `references/design-to-kadence.md`, and it includes verified attribute formats and a worked example.

1. Analyse the structure.
2. Split it into sections and components.
3. Map global decisions to the Customizer: palette, fonts, content width, buttons, header and footer layout.
4. Map each component to a Kadence block.
5. Map each visual property to a native control.
6. Plan desktop, tablet and mobile behaviour.
7. Map colours to palette slots and sizes to presets.
8. Find the dynamic data.
9. Choose the placement: the page, an Element, or the Customizer builders.
10. Build in the block editor.
11. Verify the front end and editability.

To match an approved design exactly, compare it side by side at the same widths, band by band, after every change, and keep a difference register (`references/fidelity-and-debugging.md` §1). Kadence first is not Kadence only: when no native control reproduces an approved visual or interaction, write the smallest scoped piece (§2) instead of simplifying the design.

Build content through the editor so the editor serializes the markup (the editor UI, or the editor's own `createBlock` and `serialize`). Never hand-write saved block markup or import it with SQL. Never use Custom HTML blocks, shortcodes or inline styles for design.

## 4. Customizer, scripts and MCP tools
- **Map of settings:** `references/customizer-settings.md` lists every setting with its key, control, label, default, choices and visibility rule, grouped by panel and section.
- **How values are stored, value shapes, builder slots, palette JSON:** `references/customizer-automation.md` §1, §3 to §5.
- **Changing settings without the UI:** `scripts/customizer-apply.php`.
  - Dry run by default.
  - Validates keys, shapes and choices against the live registry.
  - Writes only with `apply` and a backup file.
  - `revert` restores the backup exactly.
- **Building an MCP server or other tool layer:** implement the operation contract in `references/customizer-automation.md` §7. Read operations are safe. Write operations need confirmation and a backup. The live registry is the validator, so the tool works on any Kadence version.

## 5. Where to look

| Task | Read |
|---|---|
| "Which block or feature builds X?" | `references/recipes.md`: about 115 requirements in 13 groups, plus 12 step-by-step recipes (§15) |
| Translate a design into settings | `references/design-to-kadence.md` |
| Match an approved design exactly, debug a layout, decide whether custom CSS/JS is justified, Row Layout and Section traps, testing animations | `references/fidelity-and-debugging.md` |
| Block exists? Name, attributes, children, CSS classes | `references/blocks-inventory.md` (§2 all blocks, §3 free blocks in detail, §4 shared controls, Style Library, Block Defaults); on a real site `scripts/block-schema.php` |
| Pro-only blocks and Pro extensions | `references/blocks-pro.md` (§3 blocks, §4 extensions, §5 global features, §8 blocks that look Pro but are not) |
| Every Customizer setting | `references/customizer-settings.md`; on a real site `scripts/customizer-schema.php` |
| Read, change, back up and revert Customizer settings; MCP operation contract | `references/customizer-automation.md` |
| Customizer, page, post, archive and CPT layouts, per-post settings | `references/theme.md` §1, §4, §5 |
| Header Builder, Footer Builder, sticky and transparent header, mobile drawer | `references/theme.md` §2, §3, and `references/theme-kit-pro-elements.md` §3.1, §5, §7 for Pro header items, Conditional Headers and Mega Menu |
| Theme hooks and filters, and Elements vs custom PHP | `references/theme.md` §6, §7 |
| Palette, typography, widths, buttons, `--global-*` variables | `references/theme-global-design.md` |
| Which layer owns a style; keeping a site consistent | `references/styling-layers.md` |
| Theme Kit Pro modules, Dark Mode | `references/theme-kit-pro-elements.md` §2, §3, §6 |
| Elements: types, placements, conditions, preview, templates | `references/theme-kit-pro-elements.md` §4, §9 |
| Dynamic content, ACF, Conditional Display, Repeater, Query cards | `references/dynamic-content-acf.md` (§5 supported attributes, §8 ACF, §9 conditions, §15 worked examples) |
| Breakpoints, stacking, hide on device, sticky, animation, hover, reduced motion | `references/responsive-animation.md` |
| Marquee and what Creative Kit does not include | `references/creative-kit.md` |
| Official docs: product map, panel paths, Conversions, Shop Kit, Insights, Starter Templates, Design Library, filters, JS events, troubleshooting | `references/official-docs.md` |
| Limits, security notes, doc vs code conflicts, unverified items | `references/limitations.md` |
| Versions, changelog differences, official and community sources | `references/research-references.md` |
| Installed products, modules and versions on this site | `references/environment-check.md` |

The larger references open with a contents list. Read the relevant section, not the whole file. For `customizer-settings.md`, search for the key or section id instead of reading it.

## 6. Facts that most often decide a build
Verified at the baseline versions; re-check them with the runtime scripts on other versions.
- **Blocks Pro features.** Dynamic content, Conditional Display, Animate on Scroll, Query Loop (Adv), Repeater, the Modal, Advanced Slider and Post Grid/Carousel blocks, mega menus and several gallery layouts need Blocks Pro.
- **Module switches.** Elements, Conditional Headers, Mega Menu, Dark Mode and the extra header items need Theme Kit Pro with their module switch on (all modules are off by default).
- **Advanced Text.** "Advanced Text" is the Advanced Heading block (`kadence/advancedheading`); use `htmlTag` `p` for paragraphs.
- **Sticky and Custom CSS.** Only Section is sticky (Row Layout is not). The free per-block Custom CSS box exists only on Row Layout, Section and Header Row.
- **Breakpoints differ.** Blocks switch to mobile at 767/768 px; Element device rules switch at 719/720 px. Hide on device is CSS only, so the HTML still loads.
- **Block Defaults.** They apply when a block is inserted, not when the page renders.
- **Palette.** The Customizer palette (option `kadence_global_palette`) is the stored source. The Style Library can override palette slots on the front end. When a dark palette is used, keep colours in the Customizer and leave Style Library palette and button tokens unset.
- **Customizer storage.** Values are theme mods of the active (child) theme, one per key. An unsaved key means the default. Most settings have no sanitize callback, so validate before any direct write.
- **Header precedence.** The Customizer block header is the global default. An Element with "Replace Header" wins where its conditions match.
- **Element limits.**
  - Elements have no start date, only an expiry.
  - Only one single or archive template replacement applies per page (lowest Order wins).
  - There are no conditional footers in Theme Kit Pro 1.2.6.
- **Animate on Scroll.** It does not work on Row Layout or Info Box; wrap them in a Section. Its global "once" default is false, so set Once to replay only one time. Animated content starts invisible and has no no-JavaScript fallback: never animate above-the-fold content, and exclude the AOS script from JS delay (`references/responsive-animation.md`).
- **Creative Kit.** It adds only Marquee (Adv) as a block (plus premium Starter Templates). The marquee ignores reduced motion and leaves cloned items in the tab order.
- **Dynamic content.** Before/After text prints even when a field is empty; pair it with Conditional Display "Not Empty". Relationship fields use only the first related post. Flexible content is not supported.

## 7. Verification rules
- **Evidence.** Never report a check as passed without running it.
- **Editability.**
  - After saving, reload the editor and confirm every block is valid with no recovery prompts.
  - Confirm the Kadence inspector panels open.
  - Confirm the saved content has no `style=` attributes, Custom HTML or shortcodes.
- **Front end.**
  - Check desktop (about 1366 px), tablet (768 px) and mobile (375 px).
  - No horizontal scroll, one H1, text contrast of at least 4.5:1 in light and dark palettes, and focus states visible.
- **Global inheritance.** A palette or typography change in the Customizer should change the section. If it does not, run `scripts/style-overrides.php` to find the CSS that wins.
- **Animations.** Load the page with JavaScript disabled and with the optimiser on. Content must stay readable.
- **Customizer writes.** Dry run first, keep the backup, purge caches, then check the front end. Revert if the owner does not accept the result.
- **Environment.** Work on staging or a local copy unless told otherwise. Take a backup before destructive changes.

## 8. Keeping this skill current
- **Scope.** The references are general Kadence knowledge, labelled with the versions they were verified against. Project-specific facts belong in the project's own docs.
- **New findings.** When a new finding is verified (a setting, a limit, a recipe), add it to the matching reference with a verification tag: `[code]`, `[runtime]`, `[docs]` or `[unverified]`.
- **New versions.**
  - Regenerate `references/customizer-settings.md` from `scripts/customizer-schema.php` (with every module simulated on).
  - Re-run the inventory and block schema.
  - Update the "Versions studied" lines.
- **Never include** proprietary plugin source code, licence keys, credentials or site data. The generated settings map holds defaults only, never a site's current values.
