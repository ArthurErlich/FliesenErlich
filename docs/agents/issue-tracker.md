# Issue tracker: Gitea

Issues and specs for this repo live as Gitea issues on `git.arthurerlich.de` (self-hosted). Use the `tea` CLI for all operations; it infers the repo from the local git remote when run inside this clone.

## Conventions

- **Create an issue**: `tea issue create --title "..." --description "..."`. Use a heredoc for multi-line bodies.
- **Read an issue**: `tea issue <number>` for details and comments.
- **List issues**: `tea issue list --state open`, with `--labels` to filter.
- **Comment on an issue**: `tea comment add <number> "..."`
- **Apply / remove labels**: `tea issue edit <number> --add-label "..."` / `--remove-label "..."`
- **Close**: `tea issue close <number>`

## Pull requests as a triage surface

**PRs as a request surface: no.** _(Set to `yes` if this repo treats external PRs as feature requests; `/triage` would read this flag if the `triage` skill is installed.)_

## When a skill says "publish to the issue tracker"

Create a Gitea issue with `tea issue create`.

## When a skill says "fetch the relevant ticket"

Run `tea issue <number>`.
