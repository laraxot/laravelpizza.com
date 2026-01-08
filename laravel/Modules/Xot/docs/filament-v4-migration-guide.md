# Filament v4 Migration Guide - Modulo Xot
**Data**: 10 Dicembre 2025  
**Modulo**: Xot (Core Framework)  
**Versione**: 4.0  
**Stato**: Ready for Implementation

## 🚨 CRITICAL CHANGES - IMPLEMENTAZIONE OBBLIGATORIA

### 1. Grid/Section/Fieldset - columnSpanFull() OBBLIGATORIO

#### Problema
In Filament v4, i componenti di layout `Grid`, `Section` e `Fieldset` non occupano più tutta la larghezza di default. Questo impatta TUTTI i form Filament in PTVX.

#### Soluzione
Aggiungere `->columnSpanFull()` a OGNI componente di layout:

```php
// ❌ ERRATO - Filament v4
Section::make('Dettagli Anagrafici')
    ->schema([
        Grid::make(2)
            ->schema([
                TextInput::make('nome'),
                TextInput::make('cognome'),
            ]),
    ])

// ✅ CORRETTO - Filament v4
Section::make('Dettagli Anagrafici')
    ->columnSpanFull() // OBBLIGATORIO
    ->schema([
        Grid::make(2)
            ->columnSpanFull() // OBBLIGATORIO
            ->schema([
                TextInput::make('nome'),
                TextInput::make('cognome'),
            ]),
    ])
```

#### Azione Immediata
1. Cercare tutti i file con `Section::make()`, `Grid::make()`, `Fieldset::make()`
2. Aggiungere `->columnSpanFull()` dopo ogni chiamata
3. Testare tutti i form per verificare layout

### 2. unique() Validation - Comportamento Invertito

#### Problema
Il metodo `unique()` ora ha `ignoreRecord: true` di default (era `false` in v3).

#### Soluzione
Esplicitare il comportamento desiderato:

```php
// ❌ POTENZIALMENTE ERRATO - Comportamento cambiato
TextInput::make('email')
    ->unique() // Ora ignora il record corrente

// ✅ CORRETTO - Esplicitare comportamento
TextInput::make('email')
    ->unique(ignoreRecord: false) // Non ignorare il record corrente

// ✅ CORRETTO - Per update form
TextInput::make('email')
    ->unique(ignoreRecord: true) // Ignorare il record corrente
```

### 3. Table Filters - Deferred by Default

#### Problema
`deferFilters()` è ora il comportamento default. I filtri non si applicano automaticamente.

#### Soluzione
```php
// ✅ Mantenere comportamento v3
public function table(Table $table): Table
{
    return $table
        ->deferFilters(false) // Disabilitare comportamento differito
        // ... resto configurazione
}
```

### 4. Radio::inline() - Comportamento Modificato

#### Problema
`inline()` ora mette solo i radio inline, non anche l'etichetta.

#### Soluzione
```php
// ❌ Comportamento cambiato
Radio::make('tipo')
    ->inline() // Solo radio inline

// ✅ Comportamento desiderato
Radio::make('tipo')
    ->inline() // Radio inline
    ->inlineLabel() // Etichetta inline
```

## 🔧 CONFIGURAZIONE GLOBALE XOT

Aggiungere in `XotServiceProvider`:

```php
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Tables\Table;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Radio;

public function boot()
{
    // Mantenere comportamento layout v3
    Fieldset::configureUsing(fn (Fieldset $fieldset) => 
        $fieldset->columnSpanFull()
    );
    Grid::configureUsing(fn (Grid $grid) => 
        $grid->columnSpanFull()
    );
    Section::configureUsing(fn (Section $section) => 
        $section->columnSpanFull()
    );
    
    // Mantenere comportamento filtri v3
    Table::configureUsing(fn (Table $table) => 
        $table->deferFilters(false)
    );
    
    // Mantenere comportamento validazione v3
    Field::configureUsing(fn (Field $field) => 
        $field->uniqueValidationIgnoresRecordByDefault(false)
    );
    
    // Mantenere comportamento radio v3
    Radio::configureUsing(fn (Radio $radio) => 
        $radio->inlineLabel(fn (): bool => $radio->isInline())
    );
    
    // Mantenere paginazione con opzione 'all'
    Table::configureUsing(fn (Table $table) => 
        $table->paginationPageOptions([5, 10, 25, 50, 'all'])
    );
}
```

## 📋 CLASSE BASE XotBaseResource - AGGIORNAMENTI

### Metodi Obbligatori da Rivedere

```php
abstract class XotBaseResource extends Resource
{
    // ✅ Metodi rimangono invariati
    public static function getFormSchema(): array { /* ... */ }
    public static function getPages(): array { /* ... */ }
    
    // ❌ METODI VIETATI - Devono essere solo nelle pagine List
    // public function getTableColumns(): array { /* VIETATO */ }
    // public function getTableFilters(): array { /* VIETATO */ }
    // public function getTableActions(): array { /* VIETATO */ }
    // public function getTableBulkActions(): array { /* VIETATO */ }
}
```

## 📋 CLASSE BASE XotBaseListRecords - AGGIORNAMENTI

### Metodi Obbligatori

```php
abstract class XotBaseListRecords extends ListRecords
{
    // ✅ METODI OBBLIGATORI - Solo qui
    abstract public function getTableColumns(): array;
    
    // ✅ Metodo aggiunto per compatibilità v4
    protected function getDefaultTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ];
    }
    
    // ✅ Layout con columnSpanFull() automatico
    protected function getTableContent(): ?View
    {
        return view('filament.tables.table', [
            'table' => $this->getTable(),
        ])->with('columnSpanFull', true);
    }
}
```

## 🎯 AZIONI IMMEDIATE PER TEAM XOT

### 1. Aggiornare Classi Base
- [ ] Modificare `XotBaseResource` per rimuovere metodi tab
- [ ] Aggiornare `XotBaseListRecords` per layout v4
- [ ] Implementare configurazione globale in `XotServiceProvider`

### 2. Testare Componenti Core
- [ ] Testare tutti i componenti form Xot
- [ ] Verificare componenti table
- [ ] Testare componenti custom

### 3. Aggiornare Documentazione
- [ ] Guide di sviluppo Xot
- [ ] Esempi di codice
- [ ] Best practices

### 4. Comunicare ad Altri Moduli
- [ ] Inviare guida migrazione a team moduli
- [ ] Fornire esempi corretti
- [ ] Supporto durante migrazione

## 🔄 SCRIPT VERIFICA AUTOMATICA

```bash
#!/bin/bash
# Trova tutti i file da correggere
echo "=== RICERCA Grid/Section/Fieldset da correggere ==="
find laravel/Modules -name "*.php" -path "*/Filament/*" -exec grep -l "Section::make\|Grid::make\|Fieldset::make" {} \;

echo "=== RICERCA validazioni unique() ==="
find laravel/Modules -name "*.php" -path "*/Filament/*" -exec grep -l "->unique()" {} \;

echo "=== RICERCA Radio inline ==="
find laravel/Modules -name "*.php" -path "*/Filament/*" -exec grep -l "Radio::make.*inline" {} \;
```

## 📊 IMPATTO STIMATO

| Componente | Files da Modificare | Priorità | Sforzo |
|------------|-------------------|----------|---------|
| Grid/Section/Fieldset | ~50+ | CRITICA | Alto |
| Validazioni unique() | ~30+ | ALTA | Medio |
| Table Filters | ~20+ | MEDIA | Basso |
| Radio inline | ~10+ | MEDIA | Basso |

---

## 🚀 ROLLOUT PLAN

### Fase 1: Core Xot (Settimana 1)
- Aggiornare classi base
- Implementare configurazione globale
- Testare componenti core

### Fase 2: Moduli Critici (Settimana 2)
- IndennitaResponsabilita
- Performance
- Gdpr

### Fase 3: Restanti Moduli (Settimane 3-4)
- Tutti gli altri moduli
- Test regressione
- Documentazione finale

---

**Versione**: 1.0  
**Stato**: Ready for Implementation  
**Target**: Tutti i moduli PTVX  
**Deadline**: 31 Dicembre 2025