# Environment check: what is installed on this site?

Purpose: confirm which Kadence products, versions, modules and licences a site actually has before planning any build.

**Version policy.** The skill is meant for any Kadence version. Its code findings were verified against one baseline (§1) and are labelled with that version. On every real site, the runtime scripts (§3) are the source of truth for block names, attributes, Customizer keys and choices. A static reference is only a map.

## Contents
1. Baseline versions the code findings were verified against
2. Quick check (WP-CLI)
3. Full read-only inventory script
4. Checks in the WordPress admin
5. How to read the results
6. Writing the result down

## 1. Baseline versions

| Product | Verified version | Folder |
|---|---|---|
| Kadence Theme | 1.6.0 | `wp-content/themes/kadence` |
| Kadence Theme Kit Pro | 1.2.6 | `wp-content/plugins/kadence-pro` |
| Kadence Blocks | 3.9.1 | `wp-content/plugins/kadence-blocks` |
| Kadence Blocks Pro | 2.8.16 | `wp-content/plugins/kadence-blocks-pro` |
| Kadence Creative Kit | 1.1.4 | `wp-content/plugins/kadence-creative-kit` |

At that baseline, 88 `kadence/*` blocks were registered (59 Blocks, 27 Blocks Pro, 2 Creative Kit). The Customizer had 740 controls with Theme Kit Pro modules at default, and 1,096 with every module on.

Newer releases existed at the last check (Nexcess changelogs, 22 Nov 2026): Blocks 3.9.1.2, Blocks Pro 2.9.1.1, Theme Kit Pro 1.3.0, Creative Kit 1.1.4.1. See `research-references.md` for what changed. Official docs, changelogs and downloads now live with Nexcess (`official-docs.md` §1).

## 2. Quick check (WP-CLI, read-only)
Run these on the site you are building, or on its staging copy:
- `wp theme list` and `wp plugin list`: Kadence product versions and active state.
- `wp option get kadence_pro_theme_config`: enabled Theme Kit Pro modules, stored as a JSON string. Empty means every module is off. The keys are `elements`, `conditional_headers`, `header_addons`, `mega_menu`, `dark_mode`, `scripts`, `infinite`, `archive_meta`, `localgravatars`, `adv_pages` and `woocommerce_addons`.
- `wp option get kadence_global_palette`: the current palette sets and the active set.
- `wp eval 'echo count(array_filter(array_keys(WP_Block_Type_Registry::get_instance()->get_all_registered()), fn($n)=>str_starts_with($n,"kadence/")));'`: the number of Kadence blocks.

If the host blocks `proc_open`, some WP-CLI commands fail. Then use `wp eval-file` with PHP instead.

## 3. Read-only runtime scripts
| Script | Output | Use it for |
|---|---|---|
| `scripts/runtime-inventory.php` | text | versions, modules, blocks, Customizer panels, sections and controls |
| `scripts/customizer-schema.php` | JSON | every Customizer setting with default, current value, choices, visibility rules and storage (`customizer-automation.md`) |
| `scripts/block-schema.php [block-name]` | JSON | every registered `kadence/*` block with attributes, defaults, enums, parents, supports, render type |
| `scripts/style-overrides.php [json]` | text or JSON | CSS outside the Customizer that can override it (child theme, Additional CSS, child theme.json) |

The write script `scripts/customizer-apply.php` (dry run by default, backup and revert) is described in `customizer-automation.md` §2.

`scripts/runtime-inventory.php` prints:
- versions and active state;
- licence status words (never keys);
- every registered `kadence/*` block with its title, parent, render type, attribute count and supports;
- block categories, pattern counts and Kadence post types;
- Theme Kit Pro module config;
- every Customizer panel, section and control.

Run it with:
`wp eval-file <skill-path>/scripts/runtime-inventory.php > kadence-inventory.txt`

It writes nothing to the database. To see what each Theme Kit Pro module would add without switching it on, add this WP-CLI global flag. It only changes the value in memory for that one run:

`--exec='WP_CLI::add_wp_hook("pre_option_kadence_pro_theme_config", function(){ return json_encode(array("elements"=>true,"conditional_headers"=>true,"header_addons"=>true,"mega_menu"=>true,"dark_mode"=>true,"scripts"=>true,"infinite"=>true,"archive_meta"=>true,"localgravatars"=>true,"adv_pages"=>true,"woocommerce_addons"=>true)); });'`

The same flag works with `customizer-schema.php`. The filter must come from `--exec`: added inside a script it runs too late.

Afterwards, run `wp option get kadence_pro_theme_config` to confirm the stored option is unchanged.

## 4. Checks in the WordPress admin
- **Appearance › Kadence:** the Theme Kit Pro module switches and licence state.
- **Kadence › Settings** (Kadence Blocks): block visibility, defaults, Style Library and Pro features.
- **Customize:** confirm the header and footer items you plan to use appear in the builder's available items.
- **Block editor:** search the inserter for the block. A block missing from the inserter may be disabled in Kadence Blocks settings.

## 5. How to read the results
- **Product missing:** drop every recipe tagged with it, for example `[Pro]` (Blocks Pro), `[TKP]`/`[Theme Kit Pro]` or `[CK]`/`[Creative Kit]`. Then pick the free alternative listed in `recipes.md`.
- **Module off:** Elements, Conditional Headers, Mega Menu, Dark Mode and Header Addons need their switch on. Switching a module on is a site setting change, so ask the site owner first.
- **Different version:**
  - Re-check any block or attribute you depend on with `scripts/block-schema.php <block-name>`, or the block's `block.json` in the plugin's `dist/blocks/<name>/` folder.
  - Regenerate the Customizer schema before planning Customizer changes.
  - Read the changelog differences in `research-references.md`.
  - Treat version-labelled findings in the references as needing confirmation.
- **Licence invalid:** in the baseline versions, blocks and module switches kept working without a valid licence; updates and cloud features did not. Do not rely on this for other versions.

## 6. Writing the result down
Record the inventory in the project's own docs, not in this skill: versions, enabled modules, licence state, and any block or setting that differs from the baseline. This skill stays general so it can serve every project.
