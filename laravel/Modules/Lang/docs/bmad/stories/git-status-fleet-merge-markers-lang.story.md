---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "git status fleet merge markers lang.story"
issues: []
discussions: []
title: "Bonifica marker merge committati — Lang"
type: story
module: Lang
epic: quality
story_id: "git-status-fleet-merge-markers-lang"
status: done
track: quality/fleet
related:
  - ../../../Xot/docs/bmad/stories/merge-marker-fleet-residue.story.md
---

# git-status-fleet-merge-markers-lang

## Contesto

Il processo automatico "laraxot" ha committato marker di merge conflict non
risolti (`<<<<<<<`, `=======`, `>>>>>>>`, varianti diff3) in file docs.
Strategia canonica (story Xot `merge-marker-fleet-residue`): HEAD pulito →
`git checkout HEAD -- file`; HEAD sporco → restore blob ultimo commit pulito in
history. Tool: `bashscripts/tools/resolve-merge-markers.sh`.

## Git status iniziale

- Branch: `dev`, up to date con `laraxot/dev`, working tree clean.
- `.gitattributes`: nessun marker.

## Risultati

| Metrica | Valore |
|---|---|
| File candidati (grep marker) | 9 |
| RESTORE_HEAD | 0 |
| RESTORE_HIST | 7 |
| MANUAL / MANUAL_UNTRACKED | 0 |
| Skipped (marker solo dentro fence) | 2 |
| `git status --porcelain` post-apply | 8 (7 restored + questa story) |

Dettaglio restore:
- `docs/docs-naming-convention-fix-duplicate.md` ← `7402d521` (commits_reverted=34)
- 6 file in `docs/wiki/integrations/_da-riconciliare/` ← `dc6ea6bd` (commits_reverted=1)

Campione >5 commits (`docs-naming-convention-fix-duplicate.md`, 34 revertiti):
verificato che il blob HEAD ripulito dai soli marker è **identico** al blob
ripristinato — i 34 commit intermedi non avevano contenuto reale oltre i marker.
Nessuna perdita.

## MANUAL irrisolti

Nessuno.

## Verifica finale

- Zero marker `<<<<<<<`/`=======`/`>>>>>>>`/`|||||||` fuori dai code fence.
- Nessun commit effettuato.

## Review blocchi divergenti

Seconda passata manuale sui 5 blocchi divergenti risolti provvisoriamente
"ours" (pack `/tmp/review-Lang.md`). Nota: i marker provengono da
`laraxot/dev:docs/archive/historical/` — il lato THEIRS è la copia archiviata
storica; entrambi i parent del merge contenevano gli stessi marker committati.

| File | Blocco | Decisione | Motivo |
|---|---|---|---|
| `docs/wiki/integrations/_da-riconciliare/file-naming.md` | 1 (frontmatter) | union | `type: rule` da theirs (il doc è normativo — "Regola Fondamentale", convenzioni, checklist — e `rule` è un tipo già usato in `docs/wiki/rules/`); `tags`/`qmd` ours (italiano = lingua del doc, già superset semantico di `[migration, filament]`; dedup migrazione/migration) |
| `docs/wiki/integrations/_da-riconciliare/pluralization-and-localization.md` | 1 | ours | path kebab-case `translation-keys-best-practices.md` vs `./TRANSLATION_KEYS_BEST_PRACTICES.md`: vince kebab (convenzione repo, ~150 vs ~51 occorrenze) |
| `docs/wiki/integrations/_da-riconciliare/pluralization-and-localization.md` | 2 | union | link kebab da ours + lista theirs deduplicata: ours aveva 5 righe `README.md` duplicate (garbage); risultato = 4 link unici |
| `docs/wiki/integrations/_da-riconciliare/validation-messages.md` | 1 | ours | come pluralization blocco 1: vince path kebab-case |
| `docs/wiki/integrations/_da-riconciliare/validation-messages.md` | 2 | union | come pluralization blocco 2: kebab ours + lista deduplicata (5×README → 1) |

Note residue (fuori scope del pack, da girare al parent):
- In entrambi i file `.md` del pack il **corpo del documento è duplicato
  integralmente 2 volte** — pre-esistente e identico nei due parent, non
  introdotto da questo merge: lasciato com'è.
- Marker reali ancora presenti in `_da-riconciliare/documentation-link-conventions.md`
  e `_da-riconciliare/coverage.md` (altri pack); le occorrenze in
  `merge-conflicts-list.md`, story e inventory sono citazioni in prosa/fence, legittime.

## Pest

Skip: intervento solo su file documentazione (`.md`).
