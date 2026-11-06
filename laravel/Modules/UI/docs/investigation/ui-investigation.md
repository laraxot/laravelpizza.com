---
type: investigation
title: "Investigation UI Component System"
links: {github_issue: "#XXX"}
updated: 2026-10-08
tags: [docs, ui, investigation]
qmd: "investigation: ui component system ui"
status: stale
---

> Nota 2026-10-14 (docs-audit): numeri e proposte superati: dice 33 stories (stories/ ne ha 7, bmad/stories 13) e propone di rimuovere il layer Services, che non esiste piu' (app/Services assente, spostato in Actions il 2026-10-08); nei test del modulo non c'e' alcun controllo APCA ne' di prefers-reduced-motion (solo `DarkModeToggleTest` ha un test sul contrasto in dark mode). Contenuto non riscritto, verificare prima di usarlo.

# Investigation: UI Component System

## Problem Statement
Il modulo UI ha 33 stories ma manca un'investigation che analizzi le feature mancanti e proponga miglioramenti architetturali.

## Current State
- Stories: 33 (phpstan cleanup, component refactoring, Filament integration)
- Architettura: Actions, Filament, Livewire, Components, Forms, Models, Providers, Rules, Services, Traits
- Decision-log: presente (threaded record)

## Feature Missing
1. **Design System Tokens** - Token mapping per tutti i componenti (colori, spacing, radius, elevation)
2. **Component Library** - Documentazione componenti riutilizzabili con API pubblica
3. **Accessibility Audit** - Verifica APCA contrast, stati focus-visible, prefers-reduced-motion
4. **Visual Regression** - Baseline screenshots per componenti critici

## Proposed Solution
- Mappare tutti i componenti esistenti ai token DESIGN.md
- Creare story per Design System (tokens + component API)
- Aggiungere ux_audit gate nei CI per ogni PR UI
- Rimuovere Services layer (spostare in Actions)

## Acceptance Criteria
- [ ] APCA contrast ≥75 body, ≥45 large-bold per tutti i componenti
- [ ] Tokens ONLY - nessun hardcoded hex fuori `:root`
- [ ] Stati interattivi completi (`focus-visible`, `:disabled`)
- [ ] Prefers-reduced-motion fallback per animazioni
- [ ] Zero slop tells (glassmorphism, gradient orbs, neon glow, default-card, 1px gray border)

## Next Steps
1. Completare decision-log con scelte su Design System
2. Creare story per Design System tokens + componenti
3. Eseguire ux_audit su CSS attuale
4. Refactor Services → Actions per compliance architetturale
