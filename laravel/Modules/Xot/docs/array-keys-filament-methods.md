# Array Keys in Filament Methods - Regole Obbligatorie

**Data**: 2025-01-18
**Status**: ✅ Regola consolidata
**Priorità**: CRITICA

## Principio Fondamentale

**TUTTI i metodi Filament che restituiscono array DEVONO avere chiavi string, NON int, NON mixed.**

## Metodi Affetti

Questa regola si applica a **TUTTI** questi metodi:

### Resources e Pages
- `getFormSchema()` → `array<string, Component>` (chiavi string obbligatorie)
- `getTableColumns()` → `array<string, Column>` (chiavi string obbligatorie)
- `getTableActions()` → `array<string, Action|ActionGroup>` (chiavi string obbligatorie)
- `getTableBulkActions()` → `array<string, BulkAction>` (chiavi string obbligatorie)
- `getTableFilters()` → `array<string, Filter>` (chiavi string obbligatorie)
- `getHeaderActions()` → `array<string, Action>` (chiavi string obbligatorie)

### Widgets
- Metodi che restituiscono form schema → `array<string, Component>` (chiavi string obbligatorie)
- `getInfolistSchema()` → `array<string, Entry>` (chiavi string obbligatorie)

## Pattern Corretto OBBLIGATORIO

### ✅ CORRETTO - Array Associativo con Chiavi String

```php
/**
 * {@inheritDoc}
 *
 * @return array<string, Action|ActionGroup>
 */
public function getTableActions(): array
{
    return [
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
        'custom' => Action::make('custom')
            ->label('Custom Action'),
    ];
}

/**
 * {@inheritDoc}
 *
 * @return array<string, BulkAction>
 */
public function getTableBulkActions(): array
{
    return [
        'delete' => DeleteBulkAction::make(),
        'export' => ExportBulkAction::make(),
    ];
}

/**
 * {@inheritDoc}
 *
 * @return array<string, \Filament\Forms\Components\Component>
 */
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required(),
        'email' => EmailInput::make('email')->required(),
    ];
}
```

### ❌ ERRATO - Array Numerico o Mixed Keys

```php
// ❌ ERRATO - Array numerico
public function getTableActions(): array
{
    return [
        EditAction::make(),  // ❌ Manca chiave stringa
        DeleteAction::make(), // ❌ Manca chiave stringa
    ];
}

// ❌ ERRATO - Mixed keys (int|string)
/**
 * @return array<int|string, Action>
 */
public function getTableActions(): array
{
    return [
        EditAction::make(),  // ❌ Chiave numerica
        'delete' => DeleteAction::make(), // ❌ Mixed keys
    ];
}

// ❌ ERRATO - Mixed nel PHPDoc
/**
 * @return array<mixed, Component>
 */
public static function getFormSchema(): array
{
    // ...
}
```

## Motivazioni

### 1. Type Safety (PHPStan Level 10)
- PHPStan richiede chiavi esplicite e tipizzate
- `array<string, T>` è più sicuro di `array<int, T>` o `array<mixed, T>`
- Evita errori di accesso a chiavi non definite

### 2. Riferimento Esplicito
- Permette accesso diretto: `$schema['field_name']`
- Facilita override e manipolazione dinamica
- Chiavi descrittive migliorano la leggibilità

### 3. Coerenza Architetturale
- Pattern standard in tutto il framework Laraxot
- Compatibile con XotBaseResource e XotBasePage
- Facilita manutenzione e debugging

### 4. Filament Internals
- Filament si aspetta chiavi string per identificare componenti
- Chiavi string permettono override e personalizzazione
- Accesso più efficiente agli elementi

## Esempi Pratici

### getTableBulkActions()

```php
// ✅ CORRETTO
public function getTableBulkActions(): array
{
    return [
        'update_coordinates' => UpdateCoordinatesBulkAction::make(),
        'send_notifications' => SendNotificationBulkAction::make(),
    ];
}
```

### getFormSchema()

```php
// ✅ CORRETTO
public static function getFormSchema(): array
{
    return [
        'template_slug' => Select::make('template_slug')
            ->options(...)
            ->required(),
        'channels' => CheckboxList::make('channels')
            ->options([...])
            ->required(),
    ];
}
```

### getTableActions() con parent

```php
// ✅ CORRETTO
public function getTableActions(): array
{
    /** @var array<string, Action|ActionGroup> $actions */
    $actions = [
        ...parent::getTableActions(), // Spread operator per merge
        'sort_by_distance' => Action::make('sortByDistance')
            ->icon('heroicon-o-map')
            ->action(...),
    ];

    return $actions;
}
```

## Anti-Pattern: Mixed Type

**NON usare mai `array<mixed, T>` o `array<int|string, T>` per questi metodi.**

```php
// ❌ VIETATO
/**
 * @return array<mixed, Action>
 */
public function getTableActions(): array
{
    // ...
}

// ✅ CORRETTO
/**
 * @return array<string, Action>
 */
public function getTableActions(): array
{
    // ...
}
```

**Motivazione**: `mixed` dovrebbe essere usato solo come ultima spiaggia. Per Filament methods, le chiavi sono sempre string.

## Checklist Pre-Implementazione

Prima di implementare o modificare questi metodi:

- [ ] **Chiavi stringa**: Ogni elemento ha una chiave string esplicita?
- [ ] **PHPDoc corretto**: `@return array<string, T>` invece di `array<int, T>` o `array<mixed, T>`?
- [ ] **Nomi descrittivi**: Le chiavi sono descrittive dello scopo (es. 'edit', 'delete', 'update_coordinates')?
- [ ] **Coerenza**: Mantenuta coerenza con altri metodi simili nel progetto?
- [ ] **Parent merge**: Se usi `...parent::method()`, è il primo elemento dell'array?

## Errori PHPStan Comuni

### Errore: Method should return array<string, T> but returns array<int, T>

**Causa**: Array senza chiavi string esplicite

**Soluzione**: Aggiungere chiavi string a ogni elemento

```php
// Prima (ERRORE)
return [
    TextColumn::make('name'),
    TextColumn::make('email'),
];

// Dopo (CORRETTO)
return [
    'name' => TextColumn::make('name'),
    'email' => TextColumn::make('email'),
];
```

### Errore: PHPDoc mismatch (array<int|string> vs array<string>)

**Causa**: PHPDoc dichiara `array<int|string, T>` ma dovrebbe essere `array<string, T>`

**Soluzione**: Correggere PHPDoc

```php
// Prima (ERRORE)
/**
 * @return array<int|string, Action>
 */

// Dopo (CORRETTO)
/**
 * @return array<string, Action>
 */
```

## Verifica Automatica

Controlla il tuo codice con:

```bash
# PHPStan
./vendor/bin/phpstan analyse Modules/ --memory-limit=2G

# Cerca pattern errati
grep -r "array<int|string" Modules/ --include="*.php"
grep -r "array<mixed" Modules/ --include="*.php"
```

## Backlink e Riferimenti

- [Filament Class Extension Rules](./filament-class-extension-rules.md) - Regole generali estensione classi
- [PHPStan Code Quality Guide](./phpstan-code-quality-guide.md) - Guide PHPStan
- [Filament Form Schema Structure](../../../docs/filament_form_schema_structure.md) - Struttura form schema

---

**Filosofia**: Type Safety, Coerenza, Manutenibilità
**Pattern**: `array<string, T>` sempre, mai `array<int, T>` o `array<mixed, T>`
**Priorità**: CRITICA - PHPStan Level 10 compliance
