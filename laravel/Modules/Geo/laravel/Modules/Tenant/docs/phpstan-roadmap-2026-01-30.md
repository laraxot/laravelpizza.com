# PHPStan Level 10 Roadmap - Tenant Module

**Data**: 2026-01-30
**Status**: 🟡 In Progress
**Errori Totali**: 581 (Iniziali)

## Analisi Errori
La quasi totalità degli errori (99%) si trova nella directory `Tests`.

### Top Offender Files
- `Tests/Unit/SushiToJsonTraitTest.php`: 197 errori
- `Tests/Feature/TenantBusinessLogicTest.php`: 155 errori
- `Tests/Unit/SushiToJsonTraitPestTest.php`: 110 errori

### Pattern Principali
1. **Mixed Method Calls**: `Cannot call method create() on mixed` (36)
2. **Mixed Property Access**: `Cannot access property $id on mixed` (35)
3. **Pest Internal Access**: `Call to method toBe() ... from outside its root namespace` (32)
4. **Undefined Properties**: `Access to an undefined property PHPUnit\Framework\TestCase::$model` (30)

## Strategia di Risoluzione

### Fase 1: Pest Configuration & Base Classes
- [ ] Investigare errore `Pest\Mixins\Expectation` (probabile problema di namespace o import).
- [ ] Fix `Tests/TestCase.php` e classi base per proprietà non definite (`$model`, `$testJsonPath`).

### Fase 2: SushiToJson Fixes
- [ ] Refactoring `SushiToJsonTraitTest.php` e `SushiToJsonTraitPestTest.php`.
- [ ] Aggiungere type hints per eliminare `mixed`.

### Fase 3: Business Logic Tests
- [ ] Fix `TenantBusinessLogicTest.php`.
- [ ] Tipizzare factory calls e modelli.

## Obiettivo
Ridurre gli errori a 0 mantenendo la validità dei test.
