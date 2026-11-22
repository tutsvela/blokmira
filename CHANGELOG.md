# Changelog

All notable changes are recorded here. Versions follow [semantic versioning](https://semver.org).

## [0.1.0] - 2026-11-22

First release.

### Added
- **Skill** (`skills/blokmira/SKILL.md`): native-first decision order, a design-to-Kadence workflow, Customizer guidance and verification rules.
- **Version policy:** the runtime scripts are the source of truth on every site, so the skill works across Kadence versions.
- **Knowledge base** (`references/`):
  - Kadence Theme, Theme Kit Pro, Blocks, Blocks Pro and Creative Kit, verified against the installed code;
  - a digest of all 386 current pages of the official Kadence documentation;
  - a map of 893 Customizer settings;
  - Header and Footer Builder slots, palette storage and an MCP operation contract.
- **Scripts:**
  - `runtime-inventory.php`, `customizer-schema.php`, `block-schema.php` and `style-overrides.php` (read-only);
  - `customizer-apply.php` (dry run, validation against the live registry, backup and exact revert).
- **Animate on Scroll guidance:** animated content starts hidden with no no-JavaScript fallback, so the skill explains how to avoid content that never appears.
- **Sample prompts**, an installation guide, an MCP roadmap, a Claude Code plugin and marketplace manifests, and a release workflow.
