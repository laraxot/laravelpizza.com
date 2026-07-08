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
- [x] PHPStan Level 10 (0 errori)
- [x] PHPMD (Complexity < 10)
- [x] PHP Insights (Quality > 94%)
- [x] Pint formatting (OK)
- [x] Zero TODO/Codice commentato
# PHPStan Status: Modules/UI

## Analysis 2026-06-18
- **Total Errors**: 0
- **Status**: Passed

## Correzioni Effettuate

### 1. Cancellazione Test Obsoleti
- Cancellati `MockCalendarWidget.php` e fixture (riferivano a classi inesistenti)

### 2. Rimozione Trait Duplicato
- Cancellato `Modules/UI/app/Traits/TableLayoutTrait.php` (duplicato di `Filament/Actions/Table/TableLayoutTrait`)

### 3. Fix HasTableLayoutPage.php
- Rinominato `setLayoutView()` → `applyLayoutView()` (naming comportamentale)
- Corretti commenti `@phpstan-var` per evitare "inline doc comment"
- Spezzate linee >80 caratteri
- Rimossa variabile inutile `$layout` in `readLayoutFrom()`

## PHPInsights Results
- **HasTableLayoutPage.php**: CODE 100pts, COMPLEXITY 100pts, ARCHITECTURE 94.1pts, MISC 100pts

## Verification
- UI module is compliant with current PHPStan configuration.
- PHPInsights quality >94% across all metrics.
