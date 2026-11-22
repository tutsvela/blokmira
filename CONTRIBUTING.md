# Contributing

Thank you for helping improve Blokmira.

## Ground rules
- **Verify before you add.** Every new fact needs a tag: `[code]` (installed plugin source, with file and line), `[runtime]` (seen on a running site), `[docs]` (official documentation, with the page slug) or `[unverified]`.
- **Name the version.** Say which Kadence version you checked.
- **No Kadence source code, licence keys, credentials or site data** in the repository. The settings map holds defaults only.
- **Native first.** A recipe that uses custom code must say which native settings were checked and why they fall short.
- **Plain, simple English.** One idea per sentence.

## Scripts
- Every script starts with `defined( 'WP_CLI' ) || exit;`.
- Read-only scripts must never write. Write paths need a dry run by default, validation and a backup.
- Run `php -l` on every script before you open a pull request. CI runs this lint too.

## Regenerating the Customizer map
On a test site with every Theme Kit Pro module simulated (see `references/environment-check.md` §3):
`wp eval-file skills/blokmira/scripts/customizer-schema.php all-modules > schema.json`
Then rebuild `references/customizer-settings.md` from it with defaults only, never current values.

## Releasing (maintainer)
1. Update the version in `.claude-plugin/plugin.json`, `.claude-plugin/marketplace.json` and the `metadata.version` in `skills/blokmira/SKILL.md`, then add a `CHANGELOG.md` entry.
2. Test the change on a staging or local Kadence site before you commit.
3. Tag and push: `git tag -a vX.Y.Z -m "Blokmira X.Y.Z" && git push origin vX.Y.Z`.
4. The Release workflow checks the tag against `plugin.json`, builds `blokmira.skill` and the source zip, and publishes the GitHub release.
