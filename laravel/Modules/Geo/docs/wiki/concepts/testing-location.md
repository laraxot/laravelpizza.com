---
name: Testing Location Policy
description: Where to place Playwright and other tests — modules and themes
type: concept
---

# Testing Location Policy

## Rule

All tests (Playwright, Pest, PHPUnit) must live inside their respective owner's directories:

- **Module tests**: `laravel/Modules/<Name>/tests/`
  - Playwright: `laravel/Modules/<Name>/tests/Playwright/`
  - Pest/PHPUnit: `laravel/Modules/<Name>/tests/Feature/`, `tests/Unit/`
- **Theme tests**: `laravel/Themes/<Name>/tests/`
  - Playwright: `laravel/Themes/<Name>/tests/Playwright/`
- **Never** put tests in root `tests/` directory (deprecated).

## Rationale

- Tests co‑locate con il codice che verificano → ownership chiaro.
- Evita duplicazioni e conflitti tra moduli.
- Allineato con architettura Laraxot modulare.

## Esempio: segnalazioni-elenco

- **Prima**: `tests/Playwright/segnalazioni-elenco.spec.js` (sbagliato)
- **Dopo**: `laravel/Modules/Geo/tests/Playwright/segnalazioni-elenco.spec.js` (corretto)

## Migrazione

1. Creare la directory `tests/Playwright` dentro il modulo/tema.
2. Spostare i file `.spec.js` esistenti.
3. Aggiornare i percorsi nei workflow CI se necessario.
4. Documentare il cambiamento in questo file.

## Riferimenti

- Story 8‑75: Segnalazioni Elenco — Mappa Lit + Lista Live
- Regola: `bashscripts/ai/.claude/rules/second-brain-always-first.md`
