---
title: "ai root md txt hygiene.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "ai root md txt hygiene.story"
issues: []
discussions: []
name: ai-root-md-txt-hygiene
description: Pulizia file .txt in root del modulo AI, spostati sotto docs/root-txt-files/
status: done
---

# AI root .md/.txt hygiene

## Problema

Regola standing order (`bashscripts/docs/prompts/03-quality-gates.md`, sezione "Igiene root
modulo/tema"): la root di ogni modulo ha al massimo 6 file `.md` e zero file `.txt`. La root
di `Modules/AI/` aveva 3 file `.md` (sotto soglia, OK) ma 3 file `.txt` (output effimeri di
tool: PHPMD, Pest, un incident report), non ammessi in root.

## File spostati

| Vecchio percorso | Nuovo percorso | Natura |
|---|---|---|
| `AI_phpmd.txt` | `docs/root-txt-files/AI_phpmd.txt` | output grezzo PHPMD |
| `AI_CLOSURE_REPORT.txt` | `docs/root-txt-files/AI_CLOSURE_REPORT.txt` | incident report testuale (2026-09-06, workflow di chiusura bloccato) |
| `AI_pest.txt` | `docs/root-txt-files/AI_pest.txt` | output grezzo Pest (run con colori ANSI) |

Spostati con `git mv` per preservare la history. Nessun contenuto cancellato. La cartella
`docs/root-txt-files/` esisteva già vuota nel modulo, predisposta per questo scopo esatto
(pattern già usato per `docs/root-md-files/`).

## Esito

- Root `Modules/AI/`: 3 file `.md` (README.md, ARCHITECTURE.md, CHANGELOG.md), 0 file `.txt`.
- Verificato con `find laravel/Modules/AI -maxdepth 1 -iname '*.md' -o -maxdepth 1 -iname '*.txt'`.
- Nessun file `phpstan.neon` toccato, nessun `@phpstan-ignore` aggiunto.
