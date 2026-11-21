---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "git status fleet merge markers notify.story"
issues: []
discussions: []
title: "Bonifica marker merge committati — Notify"
type: story
module: Notify
epic: quality
story_id: "git-status-fleet-merge-markers-notify"
status: done
track: quality/fleet
related:
  - ../../../Xot/docs/bmad/stories/merge-marker-fleet-residue.story.md
---

# git-status-fleet-merge-markers-notify

## Contesto

Il processo automatico "laraxot" ha committato marker di merge conflict non
risolti in file docs. Strategia canonica (story Xot
`merge-marker-fleet-residue`): HEAD pulito → `git checkout HEAD -- file`;
HEAD sporco → restore blob ultimo commit pulito in history.
Tool: `bashscripts/tools/resolve-merge-markers.sh`.

## Git status iniziale

- Branch: `dev`, up to date con `laraxot/dev`, working tree clean.
- `.gitattributes`: nessun marker.

## Risultati

| Metrica | Valore |
|---|---|
| File candidati (script, marker `<<<`/`>>>`) | 2 |
| RESTORE_HEAD | 0 |
| RESTORE_HIST (script) | 2 |
| RESTORE_HIST (extra: `=======` orfani) | 11 |
| MANUAL / MANUAL_UNTRACKED | 0 |
| `git status --porcelain` post-apply | 13 |

Dettaglio:
- Script: `docs/wiki/AGENTS.md`, `docs/wiki/session-summary.md` ← `13ced713` (commits_reverted=1).
- Extra: 11 file con separatore `=======` orfano (cleanup parziale precedente:
  i marker `<<<`/`>>>` erano già stati rimossi, residuando il separatore tra le
  due alternative). Non rilevati dal grep candidati dello script; trovati in
  verifica con detection estesa (`=`, `|` inclusi). Tutti ripristinati dal
  blob pulito `604a432b` (commits_reverted=1 ciascuno):
  `docs/phpstan-fixes.md`, `docs/correzioni-phpstan-completate-3.md`,
  `docs/archive/email-backup.md`, `docs/reports/{FINAL_DOCUMENTATION_REPORT,
  FINAL_SUCCESS_REPORT, DOCUMENTATION_UPDATE_COMPLETE,
  DOCUMENT_ROOT_UPDATE_SUMMARY, THEME_UPDATE_FINAL_REPORT,
  MULTI_AGENT_FINAL_REPORT, TRANSLATION_AUDIT_SUMMARY,
  THEME_DOCUMENTATION_UPDATE_COMPLETE}.md`.

Nota per lo script: il detection dei candidati cerca solo `^(<{7,8}|>{7,8})`;
residui con solo `=======`/`|||||||` orfani sfuggono. Valutare estensione
del grep iniziale.

## MANUAL irrisolti

Nessuno.

## Verifica finale

- Zero marker `<<<<<<<`/`=======`/`>>>>>>>`/`|||||||` fuori dai code fence
  (detection estesa su tutti i 4 tipi di marker).
- Nessun commit effettuato.

## Pest

Skip: intervento solo su file documentazione (`.md`).
