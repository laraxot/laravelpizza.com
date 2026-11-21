---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
issues: []
discussions: []
title: "Story — doppio tracking laravel/Modules: repo root + submoduli"
type: story
module: Xot
epic: quality
story_id: "double-tracking-modules-root"
status: ready
track: quality/fleet
qmd: "doppio tracking git root laravel/Modules submoduli gitmodules.ini commit duplicati policy"
related:
  - ../../../docs/bmad/stories/git-status-fleet-sync.story.md
  - ../../../../../../bashscripts/docs/prompts/03-quality-gates.md
---

# double-tracking-modules-root

## Perche'

`laravel/Modules/<Mod>` ha `.git` proprio (repo indipendente, `gitmodules.ini`
= inventario, non submodules veri) **ma il repo root traccia gli stessi file**.
Risultato: ogni change va committato due volte (submodulo + root sync) e
`git status` root mostra sempre rumore. Daemon/peer committano nei submoduli,
il root accumula drift finche' qualcuno non fa "sync root".

## Opzioni

| Opzione | Pro | Contro |
|---|---|---|
| Root ignora `laravel/Modules/*` (gitignore + `git rm -r --cached`) | un solo commit per file | root perde snapshot moduli |
| Status quo + script sync | nessuna migrazione | doppio commit eterno, drift |
| Submodules veri | tracking puntato a commit | cambio workflow grosso |

## Task

- [ ] Decidere policy con utente
- [ ] Se ignore: script di migrazione + verifica nessuna perdita
- [ ] Documentare in `03-quality-gates.md` e `AGENTS.md`

## AC

- [ ] Una sola fonte di verita' per ogni file modulo
- [ ] `git status` root pulito quando i submoduli sono puliti
