---
title: "Bonifica marker merge committati — Media"
type: story
module: Media
epic: quality
story_id: "git-status-fleet-merge-markers-media"
status: done
track: quality/fleet
related:
  - ../../../Xot/docs/bmad/stories/merge-marker-fleet-residue.story.md
---

# git-status-fleet-merge-markers-media

## Contesto

Il processo automatico "laraxot" ha committato marker di merge conflict non
risolti in file docs. Strategia canonica (story Xot
`merge-marker-fleet-residue`): HEAD pulito → `git checkout HEAD -- file`;
HEAD sporco → restore blob ultimo commit pulito in history.
Tool: `bashscripts/tools/resolve-merge-markers.sh`.

## Git status iniziale

- Branch: `dev`, up to date con `laraxot/dev`.
- Worktree: 1 file untracked preesistente
  (`docs/bmad/stories/quality-gates-phpstan-swarm-2026-09-23.story.md`), non toccato.
- `.gitattributes`: nessun marker.

## Risultati

| Metrica | Valore |
|---|---|
| File candidati | 3 |
| RESTORE_HEAD | 0 |
| RESTORE_HIST | 3 |
| MANUAL / MANUAL_UNTRACKED | 0 |
| Skipped | 0 |
| `git status --porcelain` post-apply | 4 (3 restored + untracked preesistente) |

Dettaglio restore:
- `docs/copilot-redundancy-audit-2026-05-25.md` ← `b5c0652d` (commits_reverted=3)
- `docs/redundancy-audit-2026-05-21.md` ← `0f56cdc0` (commits_reverted=3)
- `docs/wiki/troubleshooting/git-merge-conflict-inventory-2026-04-28.md` ← `0f56cdc0` (commits_reverted=1)

## MANUAL irrisolti

Nessuno.

## Verifica finale

- Zero marker `<<<<<<<`/`=======`/`>>>>>>>`/`|||||||` fuori dai code fence.
- Nessun commit effettuato.

## Pest

Skip: intervento solo su file documentazione (`.md`).
