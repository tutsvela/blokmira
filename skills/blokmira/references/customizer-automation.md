# Customizer automation: reading and changing Kadence settings safely

Purpose: let an agent (or an MCP tool) read, validate, change and revert Kadence Theme Customizer settings without the Customizer UI, using the same storage the Customizer uses. Verified on a local site `[runtime]` with the scripts in `scripts/`. The full setting list is `customizer-settings.md`; on a real site, generate it with `scripts/customizer-schema.php`.

## Contents
1. Where values live
2. The three scripts
3. Value shapes by control type
4. Header and Footer Builder slots and items
5. Palette
6. Rules for safe changes
7. MCP-ready operation contract
8. Known limits

## 1. Where values live
- **Theme mods by default.** Each setting is its own theme mod under its setting key, stored in the option `theme_mods_{active stylesheet}` `[code]` (`inc/components/options/component.php`, `option()`). With a child theme active, values live in the child theme's theme mods. Switching to another child theme starts from defaults.
- **Option mode.** If the filter `kadence_theme_option_type` returns `option`, values move into one array option named by `kadence_theme_option_name` (default `kadence_settings`) `[code]`. Always ask the scripts, never assume.
- **Unsaved means default.** A missing or empty value falls back to `kadence()->default( $key )`, then to the caller's default `[code]`. Theme mods hold only what someone changed.
- **Partial objects are normal.** The Customizer saves whole objects (for example `{"size":1200,"unit":"px"}`). Write the full shape: deep-merge your change into the current value, as `customizer-apply.php` does.
- **Palette is separate.** The global palette is the option `kadence_global_palette`, a JSON string (§5). The Customizer's own palette control writes it.
- **Not Customizer settings:** block defaults (`kadence_blocks_config_blocks`), Style Library, Elements (post type `kadence_element`), Advanced Headers and Navigation (block content), Theme Kit Pro module switches (`kadence_pro_theme_config`). See `blocks-inventory.md` §4 and `theme-kit-pro-elements.md`.
- **No sanitize callback.** Kadence registers most settings with an empty `sanitize_callback` `[code]` (`class-theme-customizer.php`, `add_controls()`). The Customizer UI limits input; a direct write does not. Validate before writing (§6).
- **UI import and export routes** `[docs]`, for owners and browser-driven agents:
  - Whole Customizer: Customize > Import/Export (Export downloads `kadence-theme-export.dat`; Reset restores all theme settings). This panel comes from the Starter Templates plugin and disappears if it is removed. The file format is not documented; use the scripts for automation.
  - Palette: Colors & Fonts > Colors > folder icon > Export/Import tab, as pasted JSON.
  - Elements, Advanced Headers and Navigations: ZIP export and import from their admin lists, without icons or images.
  - Block Defaults and block visibility: Kadence Block Controls > Import/Export.
- **CSS is generated per request** from the stored values. A change shows on the next uncached page load. Purge page caches after a change.

## 2. The three scripts
All are WP-CLI `eval-file` scripts. All print JSON or plain text, and exit early outside WP-CLI.

| Script | Writes | Use |
|---|---|---|
| `runtime-inventory.php` | nothing | Products, versions, blocks, modules, every Customizer panel, section and control |
| `customizer-schema.php` | nothing | Machine-readable list of every setting: key, control, section, panel, label, default, current value, `is_default`, choices, responsive flag, visibility rules (`visible_when`), storage |
| `customizer-apply.php` | theme mods, palette option (only with `apply`) | Validate, diff, apply with backup, revert |
| `style-overrides.php` | nothing | Finds CSS outside the Customizer that can override it: child theme stylesheets, Additional CSS, child theme.json (font families, hard-coded colours, redefined `--global-*` variables, `!important`) |

Commands:
```
wp eval-file scripts/customizer-schema.php > schema.json
wp eval-file scripts/customizer-apply.php changes.json                    # dry run, prints the diff
wp eval-file scripts/customizer-apply.php changes.json apply backup.json  # writes after saving previous values
wp eval-file scripts/customizer-apply.php backup.json revert              # restores exactly
```
To list settings that Theme Kit Pro modules would add, without turning modules on, add the in-memory `--exec` hook from `environment-check.md` §3. It must be passed as a WP-CLI flag: a filter added inside the script is too late, because Theme Kit Pro loads its option files earlier.

`changes.json` format:
```json
{
  "settings": { "header_sticky": "main", "content_width": { "size": 1200 } },
  "palette": { "palette1": "#D9480F" },
  "palette_active": "palette",
  "merge": true
}
```
Validation done by `customizer-apply.php` before any write `[runtime]`:
- The key must be a registered Kadence setting on this site. Tabs and headings are refused. A key that needs an inactive module or plugin is refused.
- Shape: an object setting needs an object, and a scalar setting needs a scalar.
- Choices: select, radio-icon and row values (each device value) must be one of the registered options.
- Palette colours must be hex or `rgb()`/`rgba()`, and the slot must exist.
- Any problem stops the whole batch with nothing written.

Tested round trip on a local site `[runtime]`: apply `header_sticky`, `content_width` and `palette1`. The front end then showed `--global-content-width:1200px`, `--global-palette1:#D9480F` and the stuck header class. After revert, the theme mods were byte-identical to the state before apply, and the palette option was removed again.

## 3. Value shapes by control type
Taken from defaults `[runtime]`. Device keys are `desktop`, `tablet`, `mobile`; an empty string means "inherit from the larger device".

| Control | Shape |
|---|---|
| switch | `true` / `false` |
| select | `"value"` (one of the choices) |
| radio_icon | `"value"`, or responsive `{"desktop":"","tablet":"","mobile":""}` |
| range | `{"size":{"desktop":..,"tablet":..,"mobile":..},"unit":{"desktop":"px",..}}` or non-responsive `{"size":1290,"unit":"px"}` |
| measure (padding/margin) | `{"size":{"desktop":["top","right","bottom","left"]},"unit":{"desktop":"px"},"locked":{"desktop":false}}` |
| color | `{"color":"palette3","hover":""}` (keys vary: `color`, `hover`, `active`, `link`...). Use palette slugs `paletteN` so colours follow the palette |
| color_link | `{"highlight":"palette1","highlight-alt":"palette2","highlight-alt2":"palette9","style":"standard"}` |
| typography | `{"size":{"desktop":..},"lineHeight":{"desktop":..},"family":"inherit","google":false,"weight":"","variant":""}`, plus `letterSpacing`, `transform`, `color` on some keys |
| background | `{"desktop":{"color":""}}`, and image keys per device when an image is used |
| border | `{"width":2,"unit":"px","style":"none","color":""}` |
| borders | per side and device |
| shadow | `{"color":"rgba(0,0,0,0)","hOffset":0,"vOffset":0,"blur":0,"spread":-7,"inset":false,"disabled":false}` |
| sorter | ordered list of element ids, for example `["feature","categories","title","meta","excerpt","readmore"]` |
| check_icon | `{"desktop":true,"tablet":true,"mobile":false}` |
| row | responsive layout name per device |
| builder | slot map (§4) |
| social / contact | `{"items":[{"id":"facebook","enabled":true,"source":"icon","url":"","icon":"facebook","label":"Facebook",...}]}` |
| editor / text / textarea | string. Footer HTML supports `{copyright} {year} {site-title} {theme-credit}` |
| conditional (Conditional Headers) | `{"items":[{"id":"kadence_conditional_header_01","label":"..","enabled":false,"show":"","hide":"","user":"","enable_expires":false,"expires":""}]}` |

When in doubt, read the current value from `customizer-schema.php` and change only the leaf you need.

## 4. Header and Footer Builder slots and items
Values `[runtime]`, with every Theme Kit Pro module simulated on.

**`header_desktop_items`:** rows `top`, `main`, `bottom`. Each row has slots `{row}_left`, `{row}_left_center`, `{row}_center`, `{row}_right_center`, `{row}_right`. Each slot is an ordered list of item ids.
Default: `main_left:["logo"]`, `main_right:["navigation"]`.
Item ids:
- Theme: `logo`, `navigation`, `navigation-2`, `search`, `button`, `social`, `html`.
- Theme Kit Pro: `account`, `html2`, `navigation-3`, `navigation-4`, `divider`, `divider2`, `divider3`, `search-bar`, `widget1`, `contact`, `button2`, `toggle-widget`, `dark-mode`.

**`header_mobile_items`:** `popup.popup_content`, plus rows `top`, `main`, `bottom` with slots `_left`, `_center`, `_right`.
Default: `main_left:["mobile-logo"]`, `main_right:["popup-toggle"]`, `popup_content:["mobile-navigation"]`.
Item ids:
- Theme: `mobile-logo`, `mobile-navigation`, `search`, `mobile-button`, `mobile-social`, `mobile-html`, `popup-toggle`.
- Theme Kit Pro: `mobile-nav2`, `mobile-account`, `mobile-html2`, `mobile-divider`, `mobile-divider2`, `toggle-widget`, `mobile-button2`, `mobile-contact`, `mobile-search-bar`, `mobile-dark-mode`.

**`footer_items`:** rows `top`, `middle`, `bottom`, slots `{row}_1` to `{row}_5`.
Default: `bottom_1:["footer-html"]`.
Item ids: `footer-navigation`, `footer-social`, `footer-html` (Copyright), `footer-widget1` to `footer-widget6`, `footer-dark-mode` (Theme Kit Pro).

Rules:
- Use each item once per builder. Each item then has its own section of settings (`customizer-settings.md`).
- Row column counts and layouts are separate settings, for example `footer_top_columns` and `footer_bottom_layout`.
- `header_desktop_items` is hidden when `blocks_header` is true, because a block header replaces the builder.

## 5. Palette
- `kadence_global_palette` is a JSON string with keys `palette`, `second-palette`, `third-palette` (each a list of `{color, slug, name}`, slugs `palette1` to `palette15`) and `active` (which set the site uses) `[code][runtime]`.
- Slots 10 to 15 (complement, success, info, alert, warning, rating) are added by `normalize_palette_option` when a set has only 9 entries `[code]`.
- If the option is missing, the theme uses `palette_defaults()`. Deleting the option restores the defaults.
- Front-end CSS variables are `--global-palette1` to `--global-palette15`. Blocks and settings that store `paletteN` follow palette changes automatically.
- In FSE mode (`kadence_fse_mode` on), the Site Editor owns the palette, and Customizer palette writes are refused (`theme-global-design.md`).
- A Dark Mode palette (Theme Kit Pro) is chosen with the dark mode settings, not by editing `active`.

## 6. Rules for safe changes
1. Inventory first (`runtime-inventory.php`), then schema (`customizer-schema.php`). Plan only with keys that exist on this site.
2. Scan for overrides (`style-overrides.php`). A child theme or Additional CSS that sets its own font families, colours or `--global-*` variables wins over the Customizer on the front end. Report every override that touches the planned change, and agree with the owner which side changes. Do not add more CSS to beat it.
3. Global settings are site-wide. Get the site owner's consent before applying. Work on staging or a local copy first.
4. Always dry-run, show the diff, then apply with a backup file kept outside the web root. Keep the backup until the owner accepts the result.
5. Change the smallest set of keys. Prefer palette slugs and global typography over per-element colours and sizes, so one Customizer change still reaches the whole site.
6. After applying, purge caches, then check the front end at desktop, tablet and mobile widths, in light and dark if Dark Mode is used.
7. Never write a value the Customizer UI could not produce (unknown keys, units or choices). The scripts refuse these.
8. Never store secrets or tracking code through `header_scripts`, `footer_scripts` or `after_body_scripts` without the owner's explicit request. These print on every page with no consent check (`limitations.md` §4).

## 7. MCP-ready operation contract
This contract keeps the skill, a CLI workflow and a future WordPress MCP server consistent. Each operation maps to the scripts above today, and can map to an MCP tool or a REST route later (`permission_callback` = `current_user_can( 'edit_theme_options' )`, the Customizer's own capability).

| Operation | Input | Output | Side effects |
|---|---|---|---|
| `kadence.inventory` | none | products, versions, modules, blocks, Customizer sections | none |
| `kadence.customizer.schema` | optional `section`, `panel`, `changed_only` | settings rows as in `customizer-schema.php` | none |
| `kadence.customizer.get` | `keys[]` | `{key: {value, default, is_default}}` | none |
| `kadence.customizer.plan` | `changes` (format §2) | validated diff, or a list of errors | none |
| `kadence.customizer.apply` | `changes`, `confirm: true` | applied keys and a backup id | writes theme mods or palette, stores the backup |
| `kadence.customizer.revert` | `backup id` | reverted keys | restores the previous values |
| `kadence.palette.get` / `kadence.palette.set` | slot map, active set | palette JSON | writes `kadence_global_palette` |

Design rules for any server built on this contract:
- Read operations are safe by default. Write operations need an explicit confirm flag and always create a backup first.
- The live registry is the validation source, so the server works on any Kadence version without a hard-coded list.
- Content (pages, Elements, headers) is built through block markup produced by the editor's own serializer (`createBlock` and `serialize`, or the editor UI), never hand-written markup (`design-to-kadence.md`). A server that creates content should run that serializer, for example through a headless editor or by asking the editor in a browser session.
- Custom CSS and JS operations come last, after native settings and blocks are ruled out (`decision-framework.md`), and are scoped to a class.

## 8. Known limits
- Settings for integrations (WooCommerce, LearnDash, LifterLMS, Tutor LMS, The Events Calendar, bbPress) and for public custom post types (`{cpt}_layout`, `{cpt}_archive`...) register only when that plugin or post type exists. Regenerate the schema after activating one.
- Theme mods are per stylesheet. Activating a different child theme hides the values until you switch back.
- `media` controls (logo, sticky logo, transparent logo) store attachment IDs. The attachment must exist on the target site.
- Page-level overrides (`_kad_post_*` meta) beat Customizer values for that post (`theme.md` §5). A Customizer change can look ignored on a page with its own setting.
- The scripts do not touch Customizer changesets (drafts and scheduled changes). If the owner has an unpublished changeset open, publishing it later overwrites direct writes. Check Appearance > Customize for drafts first.
