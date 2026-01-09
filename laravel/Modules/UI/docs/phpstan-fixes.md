# Correzioni e Audit Qualità - Modulo UI (PHPStan Level 10)

Questo documento traccia l'audit di qualità e le correzioni basate sulla "PHPStan Code Quality Guide - Laraxot".

## Obiettivi Gennaio 2026
- **PHPStan Level 10**: Compliance totale (0 errori).
- **Architectural Rules**: Rimozione metodi UI proibiti (`label`, `placeholder`, `tooltip`, `helperText`).
- **Complexity**: Riduzione complessità ciclomica (< 10).
- **Naming & Styles**: Lowercase filenames e Pint formatting.

---

## 🏗️ Regole Architetturali Applicate

### 1. Rimozione Metodi UI Proibiti
**Regola**: NON usare `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()` direttamente nei componenti.
**Soluzione**: Fare affidamento su `LangServiceProvider` e file di traduzione in `Modules/UI/lang/`.

#### File Identificati con Violazioni:
- `app/Filament/Tables/Columns/IconStateSplitColumn.php`
- `app/Filament/Forms/Components/OpeningHoursField.php`
- `app/Filament/Forms/Components/LocationSelector.php`
- `app/Filament/Actions/Table/TableLayoutToggleTableAction.php`
- `app/Filament/Blocks/Navigation.php`
- `app/Filament/Blocks/*.php` (Page, Post, Category, Contact)

### 2. Accesso a Proprietà Eloquent
**Regola**: Usare `isset()` invece di `property_exists()` per attributi magici Eloquent.
**Esempio**:
```php
// ✅ CORRETTO
if (isset($record->attribute)) {
    $value = $record->attribute;
}
```

### 3. Estensione Classi XotBase
**Regola**: Assicurarsi che tutti i componenti e widget estendano le classi `XotBase`.
- `Modules\UI\app\Filament\Forms\Components\RadioBadge.php` estende `Radio`. (Verificare se serve `XotBase` wrapper).

---

## 🔧 Piano di Correzione Batch

### Batch 1: Pulizia Metodi UI (Blocks & Components)
1. Spostare tutte le stringhe hardcoded in `Modules/UI/lang/it/`.
2. Rimuovere le chiamate a `->label()`, `->placeholder()`, ecc.
3. Verificare che `LangServiceProvider` carichi correttamente le traduzioni.

### Batch 2: Complessità e Type Safety
1. Analizzare `LocationSelector.php` e `OpeningHoursField.php` per ridurre complessità.
2. Assicurarsi `strict_types=1` in tutti i file.

---

## ✅ Checklist di Verifica
- [x] PHPStan Level 10 (Analisi Modulo: OK)
- [ ] PHPMD (Complexity < 10)
- [ ] PHP Insights (Quality > 80%)
- [ ] Pint formatting (`--dirty`)
- [ ] Zero TODO/Codice commentato
# PHPStan Status: Modules/UI

## Analysis
- **Date**: 2025-12-24
- **Total Errors**: 0
- **Status**: Passed

## Verification
- UI module is compliant with current PHPStan configuration.
