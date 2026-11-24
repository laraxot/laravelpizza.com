---
title: "phpstan"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "phpstan"
issues: []
discussions: []
---

# PHPStan Level 10 Roadmap - Job Module

**Status**: ✅ Completato
**Errori Totali**: 1

## Errori Identificati

### Filament Pages

- [x] `app/Filament/Resources/ScheduleResource/Pages/EditSchedule.php:28` - `return.type` - Method `getformSchema()` should return `array<int, Component>` but returns `array`.

  - **Nota**: Il metodo dovrebbe probabilmente chiamarsi `getFormSchema()` (camelCase) e restituire `array<string, mixed>` secondo le regole Laraxot.

## Pattern di Correzione

- **return.type**: Rinominare il metodo in `getFormSchema` se necessario, aggiornare il return type hint in PHPDoc e assicurarsi che restituisca un array associativo con chiavi stringa.

## Prossimi Passi

- [x] Correggere `EditSchedule.php`
- [x] Verificare con PHPStan
- [x] Verifica PHPStan Level 10

## Verifica

- [x] `./vendor/bin/phpstan analyse Modules --level=10`
