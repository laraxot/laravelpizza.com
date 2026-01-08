# NavigationBlock

## Descrizione
Il NavigationBlock è un blocco Filament che gestisce la creazione e modifica di menu di navigazione all'interno del CMS. Supporta titoli opzionali per organizzare i menu in sezioni.

## Caratteristiche
- Gestione multilingua
- Supporto per menu gerarchici
- Titoli di sezione opzionali
- Configurazione target link
- Gestione stato attivo/inattivo
- Ordinamento drag-and-drop

## Schema
```php
Block::make('navigation')
    ->label('Navigazione')
    ->schema([
        TextInput::make('title')
            ->label('Titolo')
            ->nullable(),
        Repeater::make('items')
            ->label('Voci Menu')
            ->schema([
                TextInput::make('label')->required(),
                TextInput::make('url')->required(),
                Toggle::make('is_active')->default(true),
                TextInput::make('target')->default('_self'),
            ])
    ]);
```

## Struttura Dati
```json
{
    "type": "navigation",
    "data": {
        "title": "Titolo Menu",
        "items": [
            {
                "label": "Home",
                "url": "/",
                "is_active": true,
                "target": "_self"
            }
        ]
    }
}
```

## Best Practices
1. Utilizzare URL relativi per la portabilità
2. Mantenere la coerenza tra le diverse lingue
3. Limitare la profondità della navigazione
4. Utilizzare titoli descrittivi per le sezioni
5. Seguire le convenzioni di accessibilità

## Utilizzo
- Header: Menu di navigazione principale senza titolo
- Footer: Menu di navigazione categorizzati con titoli
- Sidebar: Menu di navigazione contestuale con titolo opzionale

## Collegamenti
- [Documentazione Blocchi](./README.md)
- [Componente Header](../components/header.md)
- [Componente Footer](../components/footer.md)
- [Convenzioni Filament](../../../docs/filament-conventions.md) 

## Collegamenti tra versioni di navigation.md
* [navigation.md](laravel/Modules/Gdpr/docs/navigation.md)
* [navigation.md](laravel/Modules/Xot/docs/navigation.md)
* [navigation.md](laravel/Modules/UI/docs/navigation.md)
* [navigation.md](laravel/Modules/Cms/docs/blocks/navigation.md)
* [navigation.md](laravel/Modules/Cms/docs/navigation.md)
* [navigation.md](laravel/Modules/Cms/docs/components/navigation.md)

