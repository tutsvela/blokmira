# Guidance for coding agents working on this repository

This repository is **Blokmira**, an Agent Skill (and Claude Code plugin) for building WordPress sites natively with Kadence.

- The skill lives in `skills/blokmira/`. `SKILL.md` is the entry point; `references/` is the knowledge base; `scripts/` are WP-CLI scripts.
- Every fact in `references/` carries a tag: `[code]`, `[runtime]`, `[docs]` or `[unverified]`, and code facts give a file and line. Do not add untagged facts.
- Scripts start with `defined( 'WP_CLI' ) || exit;`. Read-only scripts must never write. Write paths are dry-run by default, validate against the live registry and back up first.
- Never commit Kadence source code, licence keys, credentials or site data. `references/customizer-settings.md` holds defaults only.
- Do not publish details of unpatched vulnerabilities; see `SECURITY.md`.
- Run `php -l` on scripts and `claude plugin validate .` before opening a pull request. Test behaviour changes on a staging or local Kadence site.
- Write in plain, simple English. One idea per sentence.
