# MediaRelationManager

Il MediaRelationManager è un componente Filament che gestisce le relazioni media seguendo le convenzioni Laraxot.

## Caratteristiche principali

- Gestione delle relazioni media
- Supporto per azioni personalizzate
- Integrazione con il sistema di risorse Filament
- Estensione di XotBaseRelationManager

## Configurazione

### Relazioni
```php
protected static string $relationship = 'media';
protected static ?string $inverseRelationship = 'model';
```

## Azioni disponibili

### Header della tabella
- `AddAttachmentAction`: Permette di aggiungere nuovi allegati

## Integrazione

### Traits utilizzati
- `NavigationLabelTrait`: Per la gestione delle etichette di navigazione

### Classi base
- `XotBaseRelationManager`: Fornisce le funzionalità base per i relation manager

## Best Practices

- Utilizzare le azioni predefinite quando possibile
- Estendere le funzionalità attraverso azioni personalizzate
- Mantenere la coerenza con le convenzioni Laraxot
- Documentare le personalizzazioni

## Esempio di utilizzo

```php
use Modules\Media\Filament\Resources\HasMediaResource\RelationManagers\MediaRelationManager;

class MyResource extends Resource
{
    public static function getRelations(): array
    {
        return [
            MediaRelationManager::class,
        ];
    }
}
```

## Personalizzazione

Per personalizzare il comportamento del relation manager:

1. Estendere la classe
2. Sovrascrivere i metodi necessari
3. Aggiungere nuove azioni
4. Configurare le opzioni della tabella

```php
class CustomMediaRelationManager extends MediaRelationManager
{
    public function getTableHeaderActions(): array
    {
        return array_merge(
            parent::getTableHeaderActions(),
            [
                'custom_action' => CustomAction::make(),
            ]
        );
    }
}
``` 
## Collegamenti tra versioni di media-relation-manager.md
* [media-relation-manager.md](../../../Media/docs/filament/relation-managers/media-relation-manager.md)
* [media-relation-manager.md](../../../Media/docs/resources/media-relation-manager.md)

