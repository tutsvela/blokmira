# Kadence-first decision framework

Purpose: the order in which to choose an implementation route, and the check to run before writing any custom code. General Kadence knowledge, not project-specific.

Versions studied: Kadence Theme 1.6.0, Theme Kit Pro 1.2.6, Kadence Blocks 3.9.1, Blocks Pro 2.8.16, Creative Kit 1.1.4.

## The six levels

Work down the list. Stop at the first level that meets the requirement fully, accessibly and reliably.

| Level | Route | Use it for | Reference |
|---|---|---|---|
| 1 | Kadence Theme controls: Customizer, global palette and typography, Header and Footer Builders, post type layouts, per-post layout panel | Site-wide look, header, footer, page and archive layouts, title areas, breadcrumbs, sidebars | `theme.md`, `theme-global-design.md` |
| 2 | Kadence Blocks and Blocks Pro: blocks, block styling, responsive controls, dynamic content, conditional display, Query Loop (Adv), animate on scroll | Page sections, cards, grids, interactive components, data-driven content | `blocks-inventory.md`, `blocks-pro.md`, `dynamic-content-acf.md` |
| 3 | Kadence Elements (Theme Kit Pro) | Reusable, conditional, hooked or template content: banners, notices, CTAs, single and archive templates, header and footer variations | `theme-kit-pro-elements.md` |
| 4 | Creative Kit | Marquee (Adv) only in 1.1.4 | `creative-kit.md` |
| 5 | Minimal reusable CSS | A documented native limit only, scoped to a class set in the block's Advanced panel, using `var(--global-*)` tokens | `limitations.md` |
| 6 | Custom PHP or JavaScript | Data rendering or behaviour that no native route supports, or where the native route is insecure, inaccessible or unreliable | `limitations.md` |

Levels 1 to 3 often combine. A typical template is a Level 3 Element (where and when) holding Level 2 blocks (what), styled by Level 1 tokens (how it looks).

## Before you write custom code

Answer these in the commit message or the architecture doc:
1. **Requirement:** what is needed, at which breakpoints and for which content.
2. **Routes checked:** list every native route you checked, with the doc section. For example: "Row Layout has no sticky option (`blocks-inventory.md`, Row Layout); Section sticky clips the wrapper (`responsive-animation.md`, Sticky)."
3. **Why each fails:** the exact limit, with a `[code]` reference where possible.
4. **Smallest custom piece:** the code stays separate from the Kadence layout around it and keeps content and styling editable in the editor.
5. **Global tokens:** colours and fonts come from `var(--global-palette*)` and the theme typography, never hard-coded values.

## Rules that prevent the usual mistakes
- **Pick palette slots, not hex.** Choose colours as palette slots (`palette1` to `palette9`) in every block and Customizer control. Hex values do not follow palette or dark-mode changes.
- **Keep heading sizes global.** Leave heading and body font sizes on the global setting unless the design needs a one-off. Use the block's preset sizes (sm/md/lg/xl) before fixed px.
- **Set responsive values together.** Set the desktop, tablet and mobile values in the same pass. Kadence block breakpoints are 1024/767 px; Element device rules and some theme CSS use 719/720 px (`responsive-animation.md`).
- **Mind CSS-only hiding.** Hide-on-device and Element device rules only hide with CSS, so the HTML still loads. Do not use them to keep content private.
- **Defaults apply at insert time.** Block Defaults are copied into a block when it is inserted. Changing a default later does not update existing blocks.
- **Dynamic content is Pro.** Set it through the toolbar's Dynamic Content control, or replicate exactly what the editor saves. Give every Element a Preview post so the editor shows real data.
- **Know template limits.** Template Elements replace the whole single or archive content area. Only one replacement applies per page (lowest Order wins).
- **Check before you build.** Confirm a feature exists in the installed version (`environment-check.md`, `blocks-inventory.md`) before planning around it. Marketing pages and older docs describe features this build does not have (`research-references.md`).

## When a native-only route is the wrong choice
Use a small custom piece when the native route:
- would ship inaccessible markup, for example the marquee clones staying in the tab order, or no reduced-motion support;
- exposes data through CSS-only hiding;
- depends on behaviour that is marked `[unverified]` here and that a test showed to be unreliable.

Record the reason as described above.
