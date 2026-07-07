---
title: analisi phpstan modulo gdpr
type: memory
tags: [phpstan, gdpr, fixes]
created: 2026-05-27
updated: 2026-05-27
status: approved
related:
  - ./phpstan-fixes.md
  - ../../../../docs/wiki/memories/phpstan-modules-inventory.md
---

# Analisi PHPStan — modulo Gdpr

> Scan e fix documentati; data in front matter, **non** nel nome file.

## Stato attuale

- **Livello:** max (`laravel/phpstan.neon`)
- **Errori:** **0** (129 file)
- **Issue:** [provtv/module_gdpr_fila5#9](https://github.com/provtv/module_gdpr_fila5/issues/9) (chiusa)

## Fix applicati

| Area | Azione |
|------|--------|
| `Listeners/GdprRegistrationListener.php` | Rimosso (duplicato di `app/Listeners/SaveGdprConsents`) |
| `*Table.php` (×4) | `@return array<string, \Filament\Tables\Columns\Column>` |
| `TreatmentsTableSeeder.php` | Rimosso `??` ridondante su `documentVersion` |

## Storico (16 errori al primo scan)

Dettaglio pre-fix: issue #9 e inventario wiki. Listener attivo: `app/Listeners/SaveGdprConsents.php`.
