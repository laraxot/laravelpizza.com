# Linee Guida per Filament Resources

## Regole Generali

### Form Schema
- Il metodo `getFormSchema()` DEVE restituire un array con chiavi di tipo stringa
- NON utilizzare indici numerici nell'array restituito
- Ogni campo del form deve avere un ID univoco come chiave stringa

Esempio corretto:
```php
public static function getFormSchema(): array
{
    return [
        'title' => TextInput::make('title')
            ->required(),
        'description' => TextArea::make('description')
            ->nullable(),
    ];
}
```

Esempio errato:
```php
public static function getFormSchema(): array
{
    return [
        TextInput::make('title')
            ->required(),
        TextArea::make('description')
            ->nullable(),
    ];
}
```

### Navigation Icon
- Le classi che estendono `XotBaseResource` NON DEVONO definire la proprietà `$navigationIcon`
- L'icona di navigazione è già gestita dalla classe base
- Se è necessario personalizzare l'icona, utilizzare i metodi forniti da XotBaseResource

### Best Practices
- Utilizzare type hints espliciti per tutti i metodi
- Documentare i metodi con PHPDoc quando necessario
- Seguire le convenzioni di naming di Laravel e Filament
- Mantenere la coerenza con il resto del framework
