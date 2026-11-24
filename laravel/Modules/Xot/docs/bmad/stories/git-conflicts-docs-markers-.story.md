---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
issues: []
discussions: []
title: "Story — marker di conflitto committati nei docs modulo (2026-09-24)"
type: story
module: Xot
epic: quality
story_id: "git-conflicts-docs-markers-2026-09-24"
status: done
track: quality/fleet
qmd: "marker conflitto git committati docs moduli Media Rating Tenant UI User resolve_docs_markers swarm"
related:
  - ./git-status-fleet-merge-markers-xot.story.md
  - ./merge-marker-fleet-residue.story.md
  - ../../../../../../docs/wiki/how-to/git-merge-marker-sweep.md
---
# git-conflicts-docs-markers-2026-09-24

## Perche'

`git status` del parent: 138 file (tutti `.md` in `docs/` o README) con marker
`<<<<<<<`/`>>>>>>>` in Media 50, Rating 40, User 26, Tenant 12, UI 8, Xot 2.
Nessun file *unmerged* nell'indice: i marker sono **committati nei repo annidati**
dei moduli dopo merge ripetuti con `laraxot/dev` (annidamenti diff3, lati
`.merge_file_*`, `df2ba808`). Il parent HEAD ha la versione pulita pre-merge
(solo lato ours). Durante l'inventario un'altra sessione ha risolto 4 test
Rating e il workspace Xot: l'inventario scade in minuti.

## Task

- [x] Claim: lock `bashscripts/lock/git-conflicts-docs-<Mod>.lock` (6 moduli)
- [x] Backup originali (tar in scratchpad di sessione)
- [x] Nuovo `bashscripts/quality-gates/merge-markers/resolve_docs_markers.py`:
      hunk inside-out, SAME/EMPTY/SUBSET automatici, DIVERGE -> review pack.
      `resolve_markers.py` copre solo PHP/JSON fuori `docs/`.
- [x] Apply regole sicure: 58 file chiusi (EMPTY 82, SAME 54, SUBSET 5 hunk)
- [x] Swarm 8 subagent (batch disgiunti, gemelli case nello stesso batch)
      resolve + verify avversariale sui restanti 80 file: 80/80 resolved
- [x] **Strato 2** scoperto da lezione subagent: marker a 8 caratteri (rename
      conflict) e marker committati anche nel parent (invisibili a `git status`):
      99 file (Xot 43, UI 32, User 19, bashscripts/ai/wiki 3, IR 1, ICL 1).
      Resolver esteso a 7+ caratteri + guardia code fence; 14 chiusi in automatico,
      85 con secondo swarm 8+8: 85/85 resolved, 0 intentional
- [x] Verifica finale: scan contenuto su Modules/Themes/app/config/docs/bashscripts,
      0 marker fuori fence; 0 marker in php/blade/json/neon
- [x] Memoria `bashscripts/ai/wiki/memories/committed-markers-invisible-to-git-status-8char.md`
      + INDEX + TRIGGER_MAP + how-to `git-merge-marker-sweep.md`; riferimento morto
      `resolve_merge_blocks.py` segnalato nella story fleet Xot
- [x] Rilascio lock

## Esito

- 237 file ripuliti (138 strato 1 + 99 strato 2), nessun commit (consegna al flusso composer/daemon).
- Backup originali: tar in scratchpad di sessione (orig.tar, layer2.tar).
- Pest: non applicabile (solo `.md`/docs; nessun file di codice toccato).

## Follow-up (fuori scope, segnalati dai subagent)

- Gemelli case/underscore: Rating `CHANGELOG.md`/`changelog.md`, Rating llm-wiki
  `AGENTS.md`/`agents.md`, Tenant `ARCHITECTURE.md`/`architecture.md`, UI root-md-files
  `CHANGELOG.md`/`changelog.md`, Xot root-txt-files `.txt`/`_x.txt`.
- UI root-md-files: file `effetcts.md` (typo nel nome).
- ~~URL `base_ptv_fila5` invece di `base_ptvx_fila5`~~ **SMENTITO**: `git remote -v` del root =
  `provtv/base_ptv_fila5`; la cartella locale `base_ptvx_fila5` non è il nome del repo GitHub.
- Link di profondità errata pre-esistenti (es. Rating `docs/wiki/memories/INDEX.md`).
- Xot `docs/archive/structure.md`: residui vecchi merge (`### Versione HEAD`).
