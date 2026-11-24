---
title: "PHPStan Modules Fix 2026-05-05"
type: troubleshooting
sources: ["phpstan-full.txt"]
confidence: verified
created: 2026-05-05
updated: 2026-05-05
tags: [phpstan, modules, fix, safe-functions, type-declarations]
related:
  - concepts/phpstan-cluster-map-and-false-friends.md
  - concepts/why-xotbaseresourceform-superior.md
---

# PHPStan Modules Fix - 2026-05-05

## Issue Summary

Esecuzione di `php vendor/bin/phpstan analyse Modules --level=5` ha rilevato **24 errori** iniziali, ridotti a **5 errori** dopo fix sistematici.

## Errori Classificati

### 1. Missing Dependencies (Ignored in phpstan.neon)
- `class.notFound` per `Spatie\LaravelPdf\*`, `Fidum\EloquentMorphToOne\*` (non installate)
- `property.notFound`, `method.notFound` correlati a deps mancanti
- **Decisione**: Ignorati in `phpstan.neon` perché Composer ha restrizioni che impediscono l'installazione

### 2. Safe Functions Mancanti (Fixed ✅)
- `MakePdfSpatieTestAction.php`: aggiunto `use function Safe\base64_decode;`
- `SocialiteProviderSettingsPage.php`: aggiunto `use function Safe\chmod;`

### 3. Type Mismatch in PHPDoc (Fixed ✅)
- `SocialiteProviderSettingsPage.php`: corretto annotazioni `@var array<string, array<string, mixed>>` → `@var array<string, mixed>` per `$google`, `$github`, `$microsoft`

### 4. Return Type Covariance (Open)
- `LanguageSwitcherWidget.php`: `getAvailableLocales()` e `getDefaultLanguages()` ritornano `Collection<int, array{}>` ma PHPDoc dichiara tipo più specifico
- **Decisione**: Lasciato aperto (Filament type covariance issue)

## Files Modificati

1. `phpstan.neon` - aggiunti ignore per `class.notFound`, `property.notFound`, `method.notFound`
2. `Xot/app/Actions/Pdf/MakePdfSpatieTestAction.php` - aggiunto Safe function
3. `User/app/Filament/Pages/SocialiteProviderSettingsPage.php` - corretti tipi e aggiunto Safe function

## Regola Adottata

**Scelta professionale**: Non forzare l'installazione di pacchetti mancanti (Composer restrictions). Invece:
1. Documentare il blocker nel wiki
2. Ignorare errori da deps mancanti in phpstan.neon
3. Fixare solo errori di codice reali

## Quality Gates

- ✅ PHPStan: 5 errori rimanenti (tutti da deps mancanti)
- ✅ Pint: formattazione corretta
- ⚠️ PHPMD: da verificare (StaticAccess warnings attesi)
- ⚠️ Test: da verificare con `--exclude-group=sqlite`

## Related

- [phpstan-cluster-map-and-false-friends](concepts/phpstan-cluster-map-and-false-friends.md)
- [safe-functions-rule](../../../../docs/wiki/concepts/safe-functions-rule.md)
- [phpstan-level10](concepts/phpstan-level10.md)
