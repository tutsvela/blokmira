# Blokmira MCP roadmap

Blokmira's long-term goal is an MCP server and a WordPress plugin that let any AI agent build Kadence sites through native settings, with custom CSS and JavaScript only as a last resort.

## Today: the operation contract
The contract is defined in `skills/blokmira/references/customizer-automation.md` §7. Today, each operation maps to a WP-CLI script.

| Operation | Today | Writes |
|---|---|---|
| `kadence.inventory` | `runtime-inventory.php` | no |
| `kadence.blocks.schema` | `block-schema.php` | no |
| `kadence.customizer.schema` | `customizer-schema.php` | no |
| `kadence.customizer.get` | `customizer-schema.php` (filter keys) | no |
| `kadence.customizer.plan` | `customizer-apply.php changes.json` | no |
| `kadence.customizer.apply` | `customizer-apply.php changes.json apply backup.json` | yes, with a backup |
| `kadence.customizer.revert` | `customizer-apply.php backup.json revert` | yes |
| `kadence.palette.get` / `set` | the `palette` section of a changes file | yes, with a backup |

## Next: the Blokmira WordPress plugin (`blokmira`)
- REST routes under `blokmira/v1` that mirror the operations above.
- Every route has a real `permission_callback`: `edit_theme_options` for Customizer work, `edit_posts` or a narrower capability for content.
- Write routes need an explicit confirm flag. They store a backup and return its ID.
- The live Customizer and block registries are the validators, so the plugin works on any Kadence version without a hard-coded list.

## Then: the MCP server (`blokmira-mcp`)
- A thin MCP server that calls the plugin's REST routes with an application password.
- Read tools are always available. Write tools are off until the site owner enables them.
- Content tools (pages, Elements, headers) create block content through the editor's own serializer, never hand-written markup.
- Custom CSS and JS tools come last and are scoped to a class.

## Order of work
1. Lock the contract and the JSON shapes (this repository).
2. Build the plugin's read routes, then plan, apply and revert with tests on a disposable site.
3. Build the MCP server against the plugin.
4. Add content operations (Elements, headers, pages) once editor-side serialization is solved.
