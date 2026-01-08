# Regole Critiche per Filament Resources - Laraxot PTVX

## ⚠️ ERRORI GRAVI DA EVITARE ASSOLUTAMENTE

### 1. USO DI `->label()`, `->placeholder()`, `->helperText()` - VIETATO!

**❌ ERRORE GRAVE - MAI FARE QUESTO:**
```php
TextInput::make('ente')->label('Ente')  // ❌ VIETATO!
DatePicker::make('anv2kd')->label('Data inizio validità')  // ❌ VIETATO!
Toggle::make('anvist')->label('Stato attivo')  // ❌ VIETATO!
```

**✅ CORRETTO:**
```php
TextInput::make('ente')  // ✅ Label gestita automaticamente
DatePicker::make('anv2kd')  // ✅ Label gestita automaticamente
Toggle::make('anvist')  // ✅ Label gestita automaticamente
```

**Motivazione**: Le traduzioni sono gestite automaticamente dal LangServiceProvider tramite i file di traduzione. Usare `->label()` viola l'architettura e crea duplicazioni.

### 2. METODI NON NECESSARI IN XotBaseResource - VIETATO!

**❌ ERRORE GRAVE - MAI IMPLEMENTARE QUESTI METODI IN XotBaseResource:**
```php
public static function getTableColumns(): array { ... }  // ❌ VIETATO in XotBaseResource!
public static function getTableFilters(): array { ... }  // ❌ VIETATO in XotBaseResource!
public static function getTableActions(): array { ... }  // ❌ VIETATO in XotBaseResource!
public static function getTableBulkActions(): array { ... }  // ❌ VIETATO in XotBaseResource!
```

**✅ CORRETTO per XotBaseResource:**
```php
// NESSUN metodo - gestiti automaticamente da XotBaseResource
class IntegparamResource extends XotBaseResource
{
    protected static ?string $model = Integparam::class;
    
    public static function getFormSchema(): array
    {
        return [
            // Solo getFormSchema() è obbligatorio
        ];
    }
}
```

**Motivazione**: XotBaseResource gestisce automaticamente questi metodi. Implementarli manualmente viola il principio DRY e crea inconsistenze.

### 3. getPages() NON NECESSARIO - VIETATO!

**❌ ERRORE GRAVE - MAI FARE QUESTO:**
```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListIntegparams::route('/'),
        'create' => Pages\CreateIntegparam::route('/create'),
        'edit' => Pages\EditIntegparam::route('/{record}/edit'),
        'view' => Pages\ViewIntegparam::route('/{record}'),
    ];
}
```

**✅ CORRETTO:**
```php
// NESSUN getPages() - gestito automaticamente da XotBaseResource
```

**Motivazione**: Se getPages() restituisce solo le pagine standard (index, create, edit, view), è gestito automaticamente da XotBaseResource. Implementarlo manualmente è ridondante.

## ⚠️ REGOLE SPECIFICHE PER XotBaseListRecords

### Metodo OBBLIGATORIO: getTableColumns()

**⚠️ IMPORTANTE**: Tutte le classi che estendono `XotBaseListRecords` DEVONO implementare il metodo `getTableColumns()`:

```php
class ListIntegparams extends XotBaseListRecords
{
    protected static string $resource = IntegparamResource::class;

    /**
     * Get the table columns.
     *
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'ente' => Tables\Columns\TextColumn::make('ente')
                ->searchable()
                ->sortable(),
            'matr' => Tables\Columns\TextColumn::make('matr')
                ->searchable()
                ->sortable(),
            'conome' => Tables\Columns\TextColumn::make('conome')
                ->searchable()
                ->sortable(),
            'nome' => Tables\Columns\TextColumn::make('nome')
                ->searchable()
                ->sortable(),
            'anv2kd' => Tables\Columns\TextColumn::make('anv2kd')
                ->date()
                ->sortable(),
            'anv2ka' => Tables\Columns\TextColumn::make('anv2ka')
                ->date()
                ->sortable(),
            'anvist' => Tables\Columns\IconColumn::make('anvist')
                ->boolean()
                ->sortable(),
            'anvpar' => Tables\Columns\TextColumn::make('anvpar')
                ->searchable(),
            'anvimp' => Tables\Columns\TextColumn::make('anvimp')
                ->numeric()
                ->sortable(),
            'anvqta' => Tables\Columns\TextColumn::make('anvqta')
                ->numeric()
                ->sortable(),
            'anvvoc' => Tables\Columns\TextColumn::make('anvvoc')
                ->searchable(),
            'anvdes' => Tables\Columns\TextColumn::make('anvdes')
                ->limit(50)
                ->searchable(),
        ];
    }
}
```

**Regole per getTableColumns() in XotBaseListRecords:**

1. **Visibilità**: SEMPRE `public`
2. **Tipo di ritorno**: SEMPRE `array<string, \Filament\Tables\Columns\Column>`
3. **Struttura**: Array associativo con chiavi stringa
4. **Campi Reali**: MAI inventare campi, usare solo quelli del modello
5. **Traduzioni**: MAI usare `->label()`, gestite da LangServiceProvider
6. **Tipizzazione**: Includere PHPDoc completo

## REGOLE FONDAMENTALI

### 1. Estensione Corretta
```php
// ✅ SEMPRE estendere XotBaseResource
class IntegparamResource extends XotBaseResource
{
    protected static ?string $model = Integparam::class;
    
    // Solo getFormSchema() è obbligatorio
    public static function getFormSchema(): array
    {
        return [
            TextInput::make('ente')->required()->maxLength(10),
            TextInput::make('matr')->required()->maxLength(10),
            // NESSUN ->label()!
        ];
    }
}
```

### 2. Pagine Corrette
```php
// ✅ SEMPRE estendere le classi base di Xot
class ListIntegparams extends XotBaseListRecords  // DEVE avere getTableColumns()
class CreateIntegparam extends XotBaseCreateRecord
class EditIntegparam extends XotBaseEditRecord
class ViewIntegparam extends XotBaseViewRecord
```

### 3. Traduzioni Automatiche
```php
// ✅ Le traduzioni vengono dai file di lingua
// Modules/Progressioni/lang/it/integparam.php
return [
    'fields' => [
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Inserisci codice ente',
            'help' => 'Codice identificativo dell\'ente',
        ],
    ],
];
```

## CHECKLIST OBBLIGATORIA

Prima di considerare completa una Filament Resource:

### ✅ Estensione Base
- [ ] Estende `XotBaseResource` (NON `Resource`)
- [ ] Estende `XotBaseListRecords` (NON `ListRecords`)
- [ ] Estende `XotBaseCreateRecord` (NON `CreateRecord`)
- [ ] Estende `XotBaseEditRecord` (NON `EditRecord`)
- [ ] Estende `XotBaseViewRecord` (NON `ViewRecord`)

### ✅ Metodi Implementati
- [ ] SOLO `getFormSchema()` implementato in XotBaseResource
- [ ] NESSUN `getTableColumns()` in XotBaseResource (gestito automaticamente)
- [ ] NESSUN `getTableFilters()` in XotBaseResource (gestito automaticamente)
- [ ] NESSUN `getTableActions()` in XotBaseResource (gestito automaticamente)
- [ ] NESSUN `getTableBulkActions()` in XotBaseResource (gestito automaticamente)
- [ ] NESSUN `getPages()` se restituisce solo pagine standard
- [ ] **OBBLIGATORIO**: `getTableColumns()` implementato in XotBaseListRecords

### ✅ Traduzioni
- [ ] NESSUN `->label()` nei form components
- [ ] NESSUN `->placeholder()` hardcoded
- [ ] NESSUN `->helperText()` hardcoded
- [ ] File di traduzione completo nel modulo

### ✅ Campi Reali
- [ ] Tutti i campi esistono nel modello
- [ ] Campi presi da `$fillable` del modello
- [ ] Verificato con la migrazione

## ESEMPIO CORRETTO

```php
<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\Sigma\Models\Integparam;
use Modules\Xot\Filament\Resources\XotBaseResource;

class IntegparamResource extends XotBaseResource
{
    protected static ?string $model = Integparam::class;

    public static function getFormSchema(): array
    {
        return [
            Section::make('Dati Anagrafici')
                ->schema([
                    TextInput::make('ente')->required()->maxLength(10),
                    TextInput::make('matr')->required()->maxLength(10),
                    TextInput::make('conome')->required()->maxLength(50),
                    TextInput::make('nome')->required()->maxLength(50),
                ])
                ->columns(2),

            Section::make('Validità Temporale')
                ->schema([
                    DatePicker::make('anv2kd')->required(),
                    DatePicker::make('anv2ka')->required()->after('anv2kd'),
                    Toggle::make('anvist')->default(0),
                ])
                ->columns(3),

            Section::make('Parametri')
                ->schema([
                    TextInput::make('anvpar')->required()->maxLength(20),
                    TextInput::make('anvimp')->numeric()->required()->step(0.00001),
                    TextInput::make('anvqta')->numeric()->default(0.00)->step(0.01),
                    TextInput::make('anvvoc')->required()->maxLength(10),
                    Textarea::make('anvdes')->required()->maxLength(100)->rows(3),
                ])
                ->columns(2),
        ];
    }
}
```

## MOTIVAZIONI ARCHITETTURALI

1. **Separazione delle Responsabilità**: XotBaseResource gestisce la logica comune
2. **DRY (Don't Repeat Yourself)**: Evita duplicazione di codice
3. **Consistenza**: Tutte le risorse seguono lo stesso pattern
4. **Manutenibilità**: Modifiche centralizzate nelle classi base
5. **Traduzioni Automatiche**: LangServiceProvider gestisce tutte le traduzioni

## ERRORI COMUNI E SOLUZIONI

### Errore: "Class contains abstract method"
**Causa**: Non implementato metodo obbligatorio
**Soluzione**: Implementare solo i metodi richiesti dalla classe base

### Errore: "Label not found"
**Causa**: Uso di `->label()` invece di traduzioni
**Soluzione**: Rimuovere `->label()` e aggiungere traduzioni nel file di lingua

### Errore: "Method already exists"
**Causa**: Override di metodi già gestiti da XotBaseResource
**Soluzione**: Rimuovere i metodi non necessari

*Ultimo aggiornamento: 5 giugno 2025* 