# GitHub Coordination Fallback Log

## 2026-03-06

- channel: `project`
- command: `gh project list --owner laraxot --limit 20`
- result: token senza scope `read:project`
- fallback: tracking locale in `docs/` e log runtime in `laravel/storage/app/private/coverage/coordination-log.md`.

- channel: `wiki`
- command: verifica subcommand CLI `gh`
- result: nessun subcommand wiki disponibile in questa build
- fallback: aggiornamento operativo su docs fino a disponibilita workflow wiki (git/web).

- channel: `discussion`
- command: GraphQL `addDiscussionComment`
- result: OK su Discussion #207
- reference: `https://github.com/laraxot/laravelpizza.com/discussions/207#discussioncomment-16022917`

- channel: `issue`
- command: `gh issue comment`
- result: OK su #191 e #206
- references:
  - `https://github.com/laraxot/laravelpizza.com/issues/191#issuecomment-4011528300`
  - `https://github.com/laraxot/laravelpizza.com/issues/206#issuecomment-4011528326`
