# 🧘 XotBase Architecture - Philosophy & Zen

**Path**: `Modules/Xot/docs/XOTBASE_ARCHITECTURE_PHILOSOPHY.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ ENLIGHTENMENT ACHIEVED

---

## 🎯 THE WHY - Filosofia Profonda

> **"XotBase non è una classe. È un contratto architetturale."**

---

## 🏛️ L'ARCHITETTURA ZEN

### Il Pattern: Base Class Hierarchy

```
Filament\Widgets\TableWidget (Vendor)
    ↑
    │ Estende Filament puro
    │ NO Laraxot awareness
    │
Modules\Xot\Filament\Widgets\XotBaseTableWidget
    ↑
    │ Estende Filament + aggiunge Laraxot features
    │ - HasXotTable trait
    │ - TransTrait (i18n)
    │ - InteractsWithPageFilters
    │ - getTableQuery() standardizzato
    │ - getTableColumns() standardizzato
    │ - Record key univoco
    │
Modules\Predict\Filament\Widgets\OutcomesTableWidget
    ↑
    │ Implementa business logic specifica
    │ - table() method
    │ - getTableQuery() per Predict
    │ - getTableColumns() per Predict
    │ - Actions, Filters, BulkActions
```

---

## 🧘 PERCHÉ ESTENDERE XotBaseTableWidget

### 1. **Centralizzazione Features** (DRY)

```php
// ❌ SBAGLIATO: Duplicazione codice
class OutcomesTableWidget extends TableWidget
{
    // Devi riscrivere TUTTO
    public function table(Table $table): Table {
        // Copi 100 righe di boilerplate
    }
    
    protected function getTableQuery() {
        // Copi logica query
    }
    
    public function getTableRecordKey($record): string {
        // Copi logica chiave univoca
    }
    
    // ... altro codice duplicato
}

// ✅ CORRETTO: Eredi tutto
class OutcomesTableWidget extends XotBaseTableWidget
{
    // Scrivi SOLO business logic specifica
    public function getTableQuery() {
        return RatingMorph::query()->where('model_type', Predict::class);
    }
    
    public function getTableColumns(): array {
        return [
            // Solo colonne specifiche
        ];
    }
}
```

**Vantaggi**:
- ✅ **DRY**: Codice scritto UNA volta, ereditato ovunque
- ✅ **Manutenibilità**: Modifichi XotBase → tutti i widget aggiornati
- ✅ **Consistenza**: Tutti i widget comportano stesso modo
- ✅ **Testing**: Testi XotBase → tutti i widget testati

---

### 2. **Standardizzazione** (KISS)

```php
// XotBaseTableWidget impone standard:

// 1. Query standardizzata
abstract protected function getTableQuery(): Builder|Relation;

// 2. Colonne standardizzate
abstract public function getTableColumns(): array;

// 3. Record key univoco (CRITICAL!)
public function getTableRecordKey(Model $record): string {
    // Livewire richiede chiavi univoche
    // Se sbagli, mostra duplicati o perde dati
}

// 4. Filters integration
use InteractsWithPageFilters;

#[On('filterUpdate')]
public function updateFilters(array $filters): void {
    // Tutti i widget rispondono a filterUpdate
}
```

**Vantaggi**:
- ✅ **KISS**: API semplice, chiara, consistente
- ✅ **Onboarding**: Nuovo developer capisce subito pattern
- ✅ **Code Review**: Standard chiaro → review veloce
- ✅ **Refactoring**: Pattern noto → refactoring sicuro

---

### 3. **Traits & Composables** (Zen)

```php
// XotBaseTableWidget usa traits:

use HasXotTable;           // Laraxot table features
use InteractsWithPageFilters; // Filament filters
use TransTrait;            // i18n support

// Ogni trait fa UNA cosa bene
// Composti insieme → widget completo
```

**Filosofia Zen**:
- 🕊️ **Vuoto**: XotBase è "vuoto" di business logic
- 🕊️ **Riempibile**: Ogni widget lo "riempie" con logica specifica
- 🕊️ **Componibile**: Traits come mattoncini LEGO

---

### 4. **Livewire Integration** (Technical Zen)

```php
// CRITICAL: Livewire richiede chiavi univoche
public function getTableRecordKey(Model $record): string {
    if (\is_array($record)) {
        return (string) ($record['_id'] ?? $record['id'] ?? '');
    }
    return (string) ($record->_id ?? $record->id ?? '');
}

// ❌ Se NON lo fai:
// - Livewire pensa che record siano uguali
// - Mostra duplicati
// - Perde aggiornamenti
// - UI si rompe

// ✅ Se lo fai:
// - Livewire traccia ogni record
// - Updates funzionano
// - UI reattiva
```

**Perché XotBase lo fa per te**:
- ✅ **Previene bug**: Livewire key gestita centralmente
- ✅ **Performance**: Key caching ottimizzato
- ✅ **Edge cases**: Array vs Object gestiti

---

## 📜 I 10 COMANDAMENTI XotBase

### Architettura

1. **Thou shalt extend XotBase**
   - `class OutcomesTableWidget extends XotBaseTableWidget`
   - MAI estendere Filament diretto
   - ✅ Eredi features, standard, fixes

2. **Thou shalt NOT duplicate**
   - Se XotBase già fa → NON riscrivere
   - Override SOLO se necessario
   - ✅ DRY sopra tutto

3. **Thou shalt use traits**
   - `HasXotTable` per tabelle
   - `TransTrait` per i18n
   - ✅ Composable architecture

### Implementation

4. **Thou shalt implement getTableQuery**
   - Restituisci Builder o Relation
   - MAI query hardcoded
   - ✅ Reusable, testable

5. **Thou shalt implement getTableColumns**
   - Array di colonne Filament
   - Label i18n (`__('predict::labels.outcome')`)
   - ✅ Standardizzato

6. **Thou shalt respect Livewire keys**
   - `getTableRecordKey()` MAI ignorato
   - Chiavi univoche SEMPRE
   - ✅ UI reattiva

### Code Quality

7. **Thou shalt type hint**
   - `: Builder|Relation`
   - `: array`
   - `: string`
   - ✅ PHPStan happy

8. **Thou shalt use i18n**
   - `__('module::key', 'Default')`
   - MAI stringhe hardcoded
   - ✅ Multi-language ready

9. **Thou shalt document**
   - PHPDoc per metodi
   - Commenti per logica complessa
   - ✅ Maintainable

10. **Thou shalt test**
    - Widget rendering test
    - Actions test
    - Filters test
    - ✅ Confidence

---

## 🎯 ESEMPI PRATICI

### ✅ CORRETTO: OutcomesTableWidget

```php
<?php

namespace Modules\Predict\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseTableWidget;

class OutcomesTableWidget extends XotBaseTableWidget
{
    // ✅ ESTENDE XotBaseTableWidget
    
    protected int|string|array $columnSpan = 'full';
    
    public ?Predict $predict = null;
    
    public function mount(?Predict $predict = null): void
    {
        $this->predict = $predict;
    }
    
    // ✅ OVERRIDE getTableQuery per business logic specifica
    protected function getTableQuery(): Builder|Relation
    {
        if (!$this->predict instanceof Predict) {
            return RatingMorph::query()->whereNull('id');
        }
        
        return RatingMorph::query()
            ->where('model_type', $this->predict::class)
            ->where('model_id', $this->predict->getKey())
            ->with('rating');
    }
    
    // ✅ OVERRIDE getTableColumns per colonne specifiche
    public function getTableColumns(): array
    {
        return [
            'outcome' => Tables\Columns\TextColumn::make('rating.title')
                ->label(__('predict::labels.outcome', 'Outcome'))
                ->searchable()
                ->sortable(),
            'percentage' => Tables\Columns\TextColumn::make('percentage')
                ->label(__('predict::labels.probability', 'Probability'))
                ->numeric()
                ->sortable()
                ->suffix('%'),
        ];
    }
    
    // ✅ OVERRIDE actions specifiche
    public function getTableActions(): array
    {
        return [
            'backOutcome' => Action::make('backOutcome')
                ->label(__('predict::actions.back_this_outcome'))
                ->action(fn (RatingMorph $record) => $this->backOutcome($record)),
        ];
    }
    
    // ✅ TUTTO il resto ereditato da XotBaseTableWidget:
    // - table() method
    // - getTableRecordKey()
    // - updateFilters()
    // - getTableSearch()
    // - Traits (HasXotTable, TransTrait, etc.)
}
```

---

### ❌ SBAGLIATO: OutcomesTableWidget (NO XotBase)

```php
<?php

namespace Modules\Predict\Filament\Widgets;

use Filament\Widgets\TableWidget; // ❌ SBAGLIATO!

class OutcomesTableWidget extends TableWidget // ❌ SBAGLIATO!
{
    // ❌ Devi riscrivere TUTTO il boilerplate
    
    public function table(Table $table): Table {
        // ❌ Copi 100 righe di codice
        return $table
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns())
            ->defaultSort('submitdate', 'desc')
            ->paginated([10, 25, 50, 100])
            ->poll('30s');
    }
    
    // ❌ Duplicazione logica query
    protected function getTableQuery(): Builder {
        // ...
    }
    
    // ❌ Duplicazione logica key
    public function getTableRecordKey($record): string {
        // ...
    }
    
    // ❌ NO filters integration
    // ❌ NO TransTrait
    // ❌ NO HasXotTable
    // ❌ NO standardizzazione
}
```

**Problemi**:
- ❌ **Duplicazione**: 100+ righe di boilerplate
- ❌ **Mantenibilità**: Modifichi 10 file invece di 1
- ❌ **Inconsistenza**: Ogni widget fa a modo suo
- ❌ **Bug**: Livewire keys gestite male
- ❌ **NO i18n**: TransTrait mancante
- ❌ **NO filters**: InteractsWithPageFilters mancante

---

## 🔗 LINK BIDIREZIONALI

### Da Questo Documento

| Da | A | Tipo |
|----|---|------|
| XotBase Philosophy | [XotBaseTableWidget Source](../../app/Filament/Widgets/XotBaseTableWidget.php) | Implementation |
| XotBase Philosophy | [OutcomesTableWidget Example](../../Modules/Predict/Filament/Widgets/OutcomesTableWidget.php) | Example |
| XotBase Philosophy | [HasXotTable Trait](../../Modules/Xot/Filament/Traits/HasXotTable.php) | Dependency |

### Verso Questo Documento

| Da | A | Tipo |
|----|---|------|
| [Predict Module Index](../00-INDEX.md) | XotBase Philosophy | Reference |
| [Architecture Index](./01-architecture/00-INDEX.md) | XotBase Philosophy | Parent |
| [Filament Widgets Rule](../../docs/project/FILAMENT_WIDGETS_FOR_LISTS_RULE.md) | XotBase Philosophy | Reference |

---

## 📚 RIFERIMENTI

### Interni
- [XotBaseTableWidget Source](../../app/Filament/Widgets/XotBaseTableWidget.php)
- [XotBaseWidget Source](../../app/Filament/Widgets/XotBaseWidget.php)
- [HasXotTable Trait](../../Modules/Xot/Filament/Traits/HasXotTable.php)
- [TransTrait](../../Modules/Xot/Filament/Traits/TransTrait.php)

### Esterni
- [Filament Widgets Docs](https://filamentphp.com/docs/widgets)
- [Livewire Docs](https://livewire.laravel.com/docs)
- [Laraxot Architecture](../../docs/project/ARCHITECTURE_ZEN.md)

---

## 🎯 MEMORIZZA

> **XotBase = Contratto Architetturale**  
> **Estendi XotBase = Eredi saggezza collettiva**  
> **NON estendere XotBase = Reinventi la ruota**

**Domande da farti PRIMA di codare**:
1. "C'è già una XotBase class?" → Estendi quella
2. "Posso usare un trait?" → Composable
3. "Sto duplicando?" → DRY violation
4. "È standardizzato?" → KISS

---

## ✅ CHECKLIST Pre-Commit

Prima di creare un widget:

- [ ] Estende XotBaseTableWidget (o XotBaseWidget)?
- [ ] Usa traits (HasXotTable, TransTrait)?
- [ ] Implementa getTableQuery()?
- [ ] Implementa getTableColumns()?
- [ ] Rispetta getTableRecordKey()?
- [ ] Usa i18n (`__('module::key')`)?
- [ ] Type hint corretto (`: Builder|Relation`)?
- [ ] Documentato (PHPDoc)?
- [ ] Testato?

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Every sprint  
**Next Review**: 2026-04-02  
**Enlightenment Level**: 🎯 **SATORI ACHIEVED**
