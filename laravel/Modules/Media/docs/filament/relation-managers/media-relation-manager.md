# MediaRelationManager Documentation

## Overview
Il `MediaRelationManager` è un gestore di relazioni Filament che gestisce le relazioni media seguendo le convenzioni Laraxot.

## Caratteristiche

### Relazioni
- `media`: Relazione principale con i media
- `model`: Relazione inversa con il modello associato

### Azioni
- `AddAttachmentAction`: Azione per aggiungere nuovi allegati
  - Accessibile dall'header della tabella
  - Integrata con Spatie Media Library

### Funzionalità
- Gestione polimorfiche dei media
- Supporto per upload multipli
- Integrazione con Spatie Media Library
- Interfaccia utente Filament standard

## Utilizzo

### Configurazione Base
```php
use Modules\Media\Filament\Resources\HasMediaResource\RelationManagers\MediaRelationManager;

class YourResource extends Resource
{
    public static function getRelations(): array
    {
        return [
            MediaRelationManager::class,
        ];
    }
}
```

### Personalizzazione
- Estendibile per aggiungere azioni personalizzate
- Configurabile per tipi di media specifici
- Adattabile per requisiti di visualizzazione personalizzati

## Recent Changes
- Rimossi conflitti di merge
- Migliorata la documentazione del codice
- Aggiunta tipizzazione stretta
- Implementata integrazione Laraxot 
## Collegamenti tra versioni di media-relation-manager.md
* [media-relation-manager.md](../../../Media/docs/filament/relation-managers/media-relation-manager.md)
* [media-relation-manager.md](../../../Media/docs/resources/media-relation-manager.md)

