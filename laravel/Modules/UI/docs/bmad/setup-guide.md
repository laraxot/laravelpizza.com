---
title: "UI: BMAD Setup Guide"
description: "Setup e configurazione BMAD per il modulo UI"
module: "UI"
alias: "ui"
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
type: note
status: draft
updated: 2026-10-07
tags: [docs, ui, bmad]
qmd: "ui   bmad setup guide ui"
---

# UI: BMAD Setup Guide

## Scopo

Rendere ripetibile e verificabile l'uso del BMAD Method per il modulo UI.

## Struttura Directory (Canonical)

- **`_bmad/`**: moduli/agent/skills + configurazione
- **`_bmad-output/`**: artefatti generati
- **`docs/bmad/`**: questa documentazione

## Verifica Minima ("Funziona")

- **skills disponibili**: cartella `_bmad/` presente e popolata
- **output**: la cartella `_bmad-output/` contiene almeno `project-context.md`
- **tailwind.config.js**: configurazione design tokens
- **accessibilità WCAG 2.1 AA**: ogni componente rispetta lo standard

## Vedi Anche

- [quick-reference](quick-reference.md)

---

*UI · BMAD Setup Guide · data 2026-05-27*