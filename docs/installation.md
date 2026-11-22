# Installation guide

This guide installs Blokmira, checks that it works and shows how to update it.

## Contents
1. Before you start
2. Claude Code
3. Claude.ai and Claude Desktop
4. Other agents
5. Prepare the WordPress site
6. Check the installation
7. Update
8. Uninstall
9. Troubleshooting

## 1. Before you start

**You need:**
- A WordPress site with the **Kadence** theme active. A child theme is fine.
- **Kadence Blocks** (recommended). Blocks Pro, Theme Kit Pro, Creative Kit and other Kadence products are optional; Blocks Pro and Theme Kit Pro are needed only for the features that need them.
- A **staging or local copy** of the site for the agent to work on. Do not point an agent at a live site first.
- For the scripts: **WP-CLI** on that site, and an agent that can run shell commands. Without a shell, the agent can still plan and work through the WordPress admin.

## 2. Claude Code

Install it as a plugin:

```text
/plugin marketplace add tutsvela/blokmira
/plugin install blokmira@blokmira
```

Restart Claude Code, or run `/plugin` and check that **blokmira** is listed as installed.

**Manual install, without the marketplace:**

```bash
git clone https://github.com/tutsvela/blokmira.git
mkdir -p ~/.claude/skills
cp -R blokmira/skills/blokmira ~/.claude/skills/blokmira
```

To use it in one project only, copy the folder to `<project>/.claude/skills/blokmira` instead.

## 3. Claude.ai and Claude Desktop

1. Open the [latest release](https://github.com/tutsvela/blokmira/releases/latest) and download `blokmira.skill`.
2. In Claude, open **Settings › Capabilities** and make sure Skills are enabled.
3. Under **Skills**, choose **Upload skill** and select `blokmira.skill`.
4. Start a new chat and ask: "Use Blokmira. What can you do with a Kadence site?"

In Claude.ai the skill can plan and write build specs and change files. Running the scripts needs an environment with WP-CLI access to your site.

## 4. Other agents

Blokmira follows the open Agent Skills format: a folder with `SKILL.md`, `references/` and `scripts/`.

1. Download the source zip from the [latest release](https://github.com/tutsvela/blokmira/releases/latest), or clone the repository.
2. Copy `skills/blokmira/` into the folder your agent reads skills from. See your agent's documentation for the location.
3. If your agent does not load skills automatically, tell it: "Read `skills/blokmira/SKILL.md` and follow it."

## 5. Prepare the WordPress site

1. Make a backup of the staging or local site.
2. Check WP-CLI works: `wp theme list` should show `kadence`.
3. Make the scripts available to WP-CLI. Either run the commands from a folder that contains `skills/blokmira/scripts/`, or copy that folder onto the server.
4. Run the inventory once:

```bash
wp eval-file skills/blokmira/scripts/runtime-inventory.php > kadence-inventory.txt
```

Treat script output as site data. Keep it out of public repositories.

## 6. Check the installation

Ask your agent:

```text
Use Blokmira. Audit this Kadence site read-only: products, versions, Theme Kit Pro modules and CSS that overrides the Customizer.
```

A working installation:
- reads `SKILL.md`;
- runs (or asks you to run) `runtime-inventory.php` and `style-overrides.php`;
- reports what is installed, without changing anything.

## 7. Update

- **Claude Code plugin:** run `/plugin marketplace update blokmira`, then reinstall or update the plugin from `/plugin`.
- **Manual install:** pull the repository and copy `skills/blokmira/` over the old folder.
- **Claude.ai:** remove the old skill and upload the new `blokmira.skill`.

Read the [CHANGELOG](../CHANGELOG.md) before you update.

## 8. Uninstall

- **Claude Code:** `/plugin uninstall blokmira@blokmira`, then optionally `/plugin marketplace remove blokmira`.
- **Manual install:** delete the `blokmira` folder from your skills directory.
- **Claude.ai:** remove the skill under Settings › Capabilities › Skills.

The scripts leave nothing on the site. Only `customizer-apply.php ... apply` writes, and its backup file lets you revert.

## 9. Troubleshooting

| Problem | Fix |
|---|---|
| The agent does not use Blokmira | Start the request with "Use Blokmira", or name the task in Kadence terms ("build this section with Kadence blocks"). |
| `Error: Kadence is not the active parent theme.` | Activate the Kadence theme, or a child theme of it, on the site. |
| A Customizer key is refused as "not a Kadence Customizer setting" | The key needs a Theme Kit Pro module or a plugin that is not active, or it does not exist in this version. Run `customizer-schema.php` and use its keys. |
| Customizer changes do not show on the front end | Run `style-overrides.php`. Child theme or Additional CSS may override them. Also purge caches. |
| WP-CLI commands fail on the host | Some hosts block `proc_open`. Use `wp eval-file` scripts, which do not need it. |
| Animated content is invisible | Animate on Scroll starts content hidden until its script runs. Exclude the AOS script from "delay JavaScript" options. See `references/responsive-animation.md`. |

Still stuck? [Open an issue](https://github.com/tutsvela/blokmira/issues/new/choose) with your versions. Never include licence keys, passwords or private site data.
