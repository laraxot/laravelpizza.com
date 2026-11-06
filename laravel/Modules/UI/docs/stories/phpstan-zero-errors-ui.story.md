---
title: "[STORY] PHPStan zero errori: modulo UI"
type: story
status: done
priority: low
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, ui, typecoverage, pest, bmad, swarm]
related:
  - "./phpstan-zero-errors-ui.dev.md"
  - "../../../../../docs/stories/all-modules-phpstan-zero-errors.story.md"
---

# Story: PHPStan zero errori: modulo UI

## User Request

Swarm PHPStan (2026-10-28): zero errori in `UI` (2 di baseline).

## Analysis

Una sola causa: `typeCoverage.paramTypeCoverage`, soglia 99 % **di progetto** (non di modulo). Il parametro non tipizzato era `$column` nella closure di `array_map` in `EventColumnTest` e `OrganizationColumnTest`, che verifica la proiezione `fields([...])` delle colonne schema.org. `GroupColumn::getFields()` dichiara `array<Column>` → il parametro e' `Filament\Tables\Columns\Column`.

## Result (verificato 2026-10-28)

- `phpstan analyse Modules/User Modules/Gdpr Modules/UI` → UI **2 → 0**; full-tree: 0 errori in UI e nessun `paramTypeCoverage` nell'albero.
- `php -l` pulito. **Pest non eseguito** (`.env.testing` = MySQL); la modifica e' solo un tipo nativo su una closure.

## Acceptance Criteria

- [x] 0 errori PHPStan in `Modules/UI`
- [x] Nessun `@phpstan-ignore`, baseline o modifica a `phpstan.neon`; nessun file cancellato
- [ ] Pest `EventColumnTest` / `OrganizationColumnTest` in sqlite
- [ ] Commit (il modulo e' in un rebase interattivo dell'utente: nessun commit fatto)

## Decisioni aperte

- `EventColumnTest` e `OrganizationColumnTest` differiscono solo per classe, nomi e numeri attesi: candidati a un dataset Pest unico (non fatto: fuori dallo scopo degli errori).
- `.md` con suffisso numerico nel nome (`phpstan-fixes.md`, `phpstan-radio-badge-fix.md`, `wiki/_integration/*-1.md`): rinomina non fatta (collisioni con i file senza suffisso, da unire a mano).

## GitHub (tracciamento)

### Issues
- TODO (`gh` non installato su questa macchina)
### Discussions
- TODO
