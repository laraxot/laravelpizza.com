---
title: "BMAD: Module Tests & Docs Directory Convention"
type: bmad-fix
theme: laravel-modules
tags: [bmad, second-brain, module-structure, tests, docs, filament-blueprint]
status: completed
related:
  - ../second-brain-module-tests-docs-error.md
updated: 2026-10-20
qmd: "bmad   correzione percorso test/docs nei moduli user"
---

# BMAD: Correzione percorso test/docs nei moduli

## Errore riconosciuto

Il percorso `laravel/tests/Modules/` è **sbagliato**. La convenzione del progetto è:

- `laravel/Modules/{ModuleName}/tests/`: test di ciascun modulo
- `laravel/Modules/{ModuleName}/docs/`: documentazione di ciascun modulo
- `laravel/Themes/Sixteen/docs/`: documentazione della tema
- `laravel/Themes/Sixteen/tests/`: test della tema
- `laravel/Modules/docs/`: documentazione di gruppo (opzionale, radice)

## Perché l'errore è accaduto

Non ho verificato la struttura directory prima di impostare `phpstan.neon` (che usa correttamente `./Modules/`) e prima di suggerire percorsi di test. Ho assunto un percorso unificato `tests/Modules/` che non esiste nel progetto.

## Decisioni (ADRs)

| Codice | Decisione | Rationale |
|---|---|---|
| D1 | Usare `ModuleName/tests/` per i test | Ogni modulo è autonomo (Filament Blueprint) |
| D2 | Usare `ModuleName/docs/` per docs | Documentazione co-locata con il codice |
| D3 | Non creare `laravel/tests/Modules/` | Violerebbe il principio di modularità
| D4 | Mantenere `phpstan.neon` con `paths: ./Modules/` | Analizza tutti i moduli correttamente |

## Filament Blueprint compliance

- Ogni componente `components/blocks/*` resta data-driven
- `docs/` nel modulo documenta il contratto e le decisioni architetturali
- `tests/` nel modulo contiene solo test relativi al modulo
- Nessun percorso centralizzato `tests/Modules/`: mantiene separazione dei moduli