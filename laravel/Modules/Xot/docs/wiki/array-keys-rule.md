# Array Keys Rule for Filament Schemas

## Regola
Tutti i metodi che restituiscono array nelle classi Filament devono usare **chiavi stringhe obbligatorie**.

## Metodi Coinvolti

| Metodo | Return Type | Esempio |
|--------|-------------|---------|
| `getTableColumns()` | `array<string, Column>` | `'title' => TextColumn::make('title')` |
| `getFormSchema()` | `array<string, Component>` | `'title' => TextInput::make('title')` |
| `getInfolistSchema()` | `array<string, Component>` | `'title' => TextEntry::make('title')` |
| `getTableFilters()` | `array<string, BaseFilter>` | `'category' => SelectFilter::make(...)` |

## Perché Chiavi Stringhe

### 1. Leggibilità
```php
// ❌ Chiavi intere - non chiaro cosa rappresenta
return [
    TextColumn::make('title'),
    TextColumn::make('slug'),
];

// ✅ Chiavi stringhe - immediato capire il campo
return [
    'title' => TextColumn::make('title'),
    'slug' => TextColumn::make('slug'),
];
```

### 2. Type-Safety (PHPStan Level 10)
```php
// Più preciso per analisi statica
/** @var array<string, Column> $columns */
```

### 3. Manutenzione
- Ricerca più facile: `$columns['title']` vs `$columns[0]`
- Riferimenti stabili anche se cambia l'ordine

### 4. Consistenza
- Form, Infolist e Table usano tutti lo stesso pattern
- Conformità con Filament demo conventions

## Implementazione in XotBaseResourceTable

```php
/**
 * @return array<string, Column>
 */
public static function getTableColumns(): array
{
    return [];
}

/**
 * @return array<string, BaseFilter>
 */
public static function getTableFilters(): array
{
    return [];
}
```

## Esempi Corretti

### Table
```php
public static function getTableColumns(): array
{
    return [
        'title' => TextColumn::make('title')->searchable()->sortable(),
        'slug' => TextColumn::make('slug'),
        'created_at' => TextColumn::make('created_at')->dateTime(),
    ];
}
```

### Form
```php
public static function getFormSchema(): array
{
    return [
        'title' => TextInput::make('title')->required()->maxLength(255),
        'slug' => TextInput::make('slug')->required()->maxLength(255),
        'content' => RichEditor::make('content')->columnSpanFull(),
    ];
}
```

### Infolist
```php
public static function getInfolistSchema(): array
{
    return [
        'title' => TextEntry::make('title'),
        'slug' => TextEntry::make('slug'),
        'created_at' => TextEntry::make('created_at')->dateTime(),
    ];
}
```

## Riferimenti
- `Modules/Xot/app/Filament/Resources/Tables/XotBaseResourceTable.php`
- `laravel/Themes/Sixteen/docs/prompts/structure.txt`

---
**Creato**: 2026-05-07
**Modulo**: Xot