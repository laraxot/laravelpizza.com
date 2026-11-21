---
title: "Archivio cartelle config duplicate — modulo UI"
type: concept
module: UI
status: resolved
tags: [module-structure, config, archive, ponytail]
created: 2026-06-30
updated: 2026-07-01
qmd: "UI modulo Config maiuscolo config minuscolo duplicato ponytail"
issues:
discussions:
related:
  - "./auth-register-focus-loss-overlay.md"
  - "./block-rendering-and-optional-services.md"
  - "./claude-audit-static.md"
  - "./code-redundancy-ui.md"
  - "./context-overflow-prevention.md"
  - "./enum-select-best-practices.md"
  - "./enum-select-component.md"
  - "./enum-select-contract-and-false-friends.md"
---

# Cartelle config duplicate — UI

## Situazione (risolta 2026-07-01)

`Config/` (maiuscolo) e `Config.bak/` duplicavano i file già in `config/`:

- `config.php`
- `laravel-localization.php`
- `laravellocalization.php`

## Regola

Solo `config/` (minuscolo) alla root del modulo nwidart.

## Azione

Rimossi `Config/` e `Config.bak/`; nessun autoload/require li referenziava. Git history conserva le versioni precedenti.
