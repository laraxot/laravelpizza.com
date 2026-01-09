# Classi LangBase per Modelli Traducibili

## Introduzione

Questo documento descrive l'utilizzo corretto delle classi `LangBase*` per la gestione dei modelli che supportano la traduzione tramite il trait `Spatie\Translatable\HasTranslations`.

## Regola Fondamentale

Se un modello utilizza il trait `Spatie\Translatable\HasTranslations`, le relative classi Filament **devono estendere le classi LangBase** corrispondenti e non le classi XotBase:

- Utilizzare `LangBaseCreateRecord` invece di `XotBaseCreateRecord`
- Utilizzare `LangBaseEditRecord` invece di `XotBaseEditRecord`
- Utilizzare altre classi `LangBase*` invece delle corrispondenti `XotBase*`

**Importante**: Basta che il modello abbia `use Spatie\Translatable\HasTranslations` per richiedere l'uso delle classi LangBase.

## Motivazione

La classe `LangBaseCreateRecord` è specificamente progettata per gestire correttamente il supporto multilingua durante la creazione di record, fornendo funzionalità aggiuntive per la gestione delle traduzioni che non sono presenti in `XotBaseCreateRecord`.

Estendere la classe sbagliata può portare a:
- Perdita di traduzioni
- Comportamenti imprevisti nell'interfaccia di amministrazione
- Errori durante il salvataggio dei dati

## Implementazione Corretta

```php
<?php

namespace Modules\Blog\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;
use Spatie\Translatable\HasTranslations;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreatePost extends LangBaseCreateRecord
{
    // Implementazione...
}
```

## Implementazione Errata

```php
<?php

namespace Modules\Blog\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;
use Spatie\Translatable\HasTranslations;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

// ERRATO: Non utilizzare XotBaseCreateRecord con Translatable
class CreatePost extends XotBaseCreateRecord
{
    // Implementazione...
}
```

## Funzionalità Specifiche di LangBaseCreateRecord

La classe `LangBaseCreateRecord` estende `XotBaseCreateRecord` aggiungendo funzionalità specifiche per la gestione delle traduzioni:

1. **Gestione automatica delle lingue**: Rileva automaticamente la lingua corrente e imposta i campi traducibili di conseguenza
2. **Validazione per lingua**: Applica regole di validazione specifiche per ciascuna lingua
3. **Interfaccia utente migliorata**: Fornisce un'interfaccia utente ottimizzata per la gestione delle traduzioni
4. **Salvataggio corretto dei dati traducibili**: Garantisce che i dati traducibili vengano salvati correttamente nel formato richiesto da Spatie Translatable

## Verifica dell'Implementazione

Durante la revisione del codice, verificare sempre che:

1. Se una classe utilizza `Translatable` o `HasTranslations`, deve estendere `LangBaseCreateRecord`
2. Se una classe non necessita di supporto per la traduzione, può estendere `XotBaseCreateRecord`

## Esempi Pratici

### Modello con Translatable

```php
<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;
    
    public $translatable = ['title', 'content'];
    
    // Resto dell'implementazione...
}
```

### Classe CreateRecord Corrispondente

```php
<?php

namespace Modules\Blog\Filament\Resources\PostResource\Pages;

use Modules\Blog\Filament\Resources\PostResource;
use Modules\Lang\Filament\Resources\Pages\LangBaseCreateRecord;

class CreatePost extends LangBaseCreateRecord
{
    protected static string $resource = PostResource::class;
    
    // Eventuali personalizzazioni...
}
```

## Risoluzione dei Problemi

### Traduzioni Non Salvate

Se le traduzioni non vengono salvate correttamente, verificare:

1. Che la classe `CreateRecord` estenda `LangBaseCreateRecord`
2. Che il modello utilizzi correttamente il trait `HasTranslations`
3. Che i campi traducibili siano definiti nell'array `$translatable` del modello

### Errori di Validazione

Se si verificano errori di validazione durante il salvataggio, verificare:

1. Che le regole di validazione siano compatibili con i campi traducibili
2. Che i messaggi di errore siano definiti correttamente per ciascuna lingua

## Riferimenti

- [Spatie Laravel Translatable](https://github.com/spatie/laravel-translatable)
- [Filament Forms](https://filamentphp.com/docs/forms)
- [Modulo Lang - Documentazione](../model-translations.md)