---
title: Code quality: audit label hardcoded Filament
type: story
module: Xot
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, code-quality, filament, translations, label]
qmd: "filament label hardcoded audit lang keys xotbase blueprint"
related:
  - ./tomorrow-handoff.story.md
  - ../bmad/filament-blueprint.md
  - ../bmad/code-quality-wave.md
  - ../conventions/code-quality-checklist.md
---

<!--
GateGuard facts:
1. Supersedes checklist open item "label() non verificato nel dettaglio".
2. Linked from tomorrow-handoff.story.md row 1c and filament-blueprint.md.
3. New story in existing docs/stories/.
4. User verbatim: "fa tutte le bmad stories per continuare domani"
-->

# Audit `->label()` hardcoded

## Perche'

Il Filament blueprint vieta label/placeholder hardcoded: le stringhe vivono in
`lang/<locale>/` del modulo.

## Owned scope (canary)

- `Modules/Xot/app/Filament/**/*.php`
- `Modules/Notify/app/Filament/**/*.php`
- `Modules/Geo/app/Filament/**/*.php`

## Tasks

1. `rg -n "->label\(|->placeholder\(|->helperText\(|->tooltip\(" Modules/{Xot,Notify,Geo}/app/Filament -g '*.php'`
2. Letterali → chiavi `lang/`; già `__()` OK.
3. Evitare chiavi duplicate; riusare file lang della Resource.
4. PHPStan + aggiornare checklist con before/after.

## Acceptance

- [ ] Inventario canary con conteggio letterali
- [ ] Residui eliminati o ticketati; nessun esempio docs con label hardcoded

## Testing strategy

Pest Filament del modulo se esiste; altrimenti PHPStan + review form.
