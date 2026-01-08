# Best Practices per Risorse Filament nel Modulo Job

Questo documento descrive le best practices da seguire quando si creano o modificano risorse Filament nel modulo Job.

## Rimozione del metodo `getPages()`

Quando una risorsa estende `XotBaseResource`, il metodo `getPages()` può essere completamente rimosso se:
- Definisce solo le tre pagine standard (index, create, edit)
- Utilizza gli stessi pattern di route standard ('/', '/create', '/{record}/edit')

### Motivazione

La classe base `XotBaseResource` fornisce già un'implementazione predefinita del metodo `getPages()` che definisce queste tre pagine con le stesse route. Rimuovere il metodo nelle classi figlie:
- Riduce la ridondanza del codice
- Semplifica la manutenzione
- Migliora la coerenza del codice
- Segue il principio DRY (Don't Repeat Yourself)

### Esempio: Prima

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListExports::route('/'),
        'create' => Pages\CreateExport::route('/create'),
        'edit' => Pages\EditExport::route('/{record}/edit'),
    ];
}
```

### Esempio: Dopo

Il metodo viene completamente rimosso, lasciando che sia la classe base a fornire l'implementazione predefinita.

### Risorse modificate

Le seguenti risorse sono state modificate per rimuovere il metodo `getPages()` ridondante:
- `ExportResource`
- `FailedImportRowResource`
- `ImportResource`

### Quando NON rimuovere il metodo `getPages()`

Il metodo `getPages()` deve essere mantenuto nei seguenti casi:
- Quando si definisce un set diverso di pagine (ad esempio, solo 'index')
- Quando si aggiungono pagine personalizzate (ad esempio, 'board', 'view')
- Quando si utilizzano pattern di route non standard

## Utilizzo di array associativi in `getFormSchema()`

Le risorse Filament richiedono che il metodo `getFormSchema()` restituisca un array associativo con chiavi di tipo stringa: `array<string, Component>`.

### Esempio corretto:

```php
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')->required(),
        'email' => TextInput::make('email')->email()->required(),
    ];
}
```

### Esempio errato:

```php
public static function getFormSchema(): array
{
    return [
        TextInput::make('name')->required(),
        TextInput::make('email')->email()->required(),
    ];
}
```

Questo pattern è stato corretto nelle seguenti risorse:
- `ExportResource`
- `FailedImportRowResource` 