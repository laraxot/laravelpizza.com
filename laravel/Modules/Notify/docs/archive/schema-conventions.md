# Schema Conventions in Notify Module

## Field Definitions

When defining schema for Filament resources in the Notify module, follow these important conventions:

### Label Handling

DO NOT use the `->label()` method in schema definitions. Labels are automatically handled by the LangServiceProvider.

```php
// ❌ Incorrect
TextEntry::make('name')
    ->label('Name')

// ✅ Correct
TextEntry::make('name')
```

### DateTime Fields

For datetime fields, simply use the `->dateTime()` method without additional label specifications:

```php
// ❌ Incorrect
TextEntry::make('created_at')
    ->label('Created At')
    ->dateTime()

// ✅ Correct
TextEntry::make('created_at')
    ->dateTime()
```

### Example Schema

Here's a complete example of a properly formatted schema:

```php
'pippo'=>Section::make('pippo')
    ->schema([
        'id' => TextEntry::make('id'),
        'type' => TextEntry::make('type'),
        'notifiable_type' => TextEntry::make('notifiable_type'),
        'notifiable_id' => TextEntry::make('notifiable_id'),
        'data' => TextEntry::make('data'),
        'read_at' => TextEntry::make('read_at')
            ->dateTime(),
        'created_at' => TextEntry::make('created_at')
            ->dateTime(),
        'updated_at' => TextEntry::make('updated_at')
            ->dateTime(),
    ])
### Versione HEAD

```
## Collegamenti tra versioni di schema_conventions.md
* [schema_conventions.md](docs/schema_conventions.md)
* [schema_conventions.md](../../../Notify/docs/schema_conventions.md)


### Versione Incoming

```

---

