# Security policy

## Reporting a problem in Blokmira
If you find a security problem in Blokmira's scripts or guidance (for example a script that could write data it should not), please report it privately through GitHub's "Report a vulnerability" (Security tab) on this repository. Please do not open a public issue for it.

We aim to reply within 7 days.

## Problems in Kadence products
Blokmira does not ship Kadence code. Report suspected vulnerabilities in Kadence products to the vendor (Nexcess) privately, not here.

## Safe use
- Run the scripts on staging or a local copy first.
- `customizer-apply.php` is a dry run unless you pass `apply` and a backup path. Keep the backup until the site owner accepts the result.
- The read-only scripts print site settings. Treat their output as site data: do not commit or share it publicly.
