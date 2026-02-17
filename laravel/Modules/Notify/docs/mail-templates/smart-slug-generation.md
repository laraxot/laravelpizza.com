# Generazione Intelligente di Slug in Filament

## Introduzione

Questo documento analizza un approccio avanzato per la generazione di slug da titoli nei form Filament, con particolare attenzione alla preservazione degli slug per i contenuti già pubblicati. Questa metodologia è particolarmente rilevante per il modulo Notify di , in particolare per la gestione dei template email.
Questo documento analizza un approccio avanzato per la generazione di slug da titoli nei form Filament, con particolare attenzione alla preservazione degli slug per i contenuti già pubblicati. Questa metodologia è particolarmente rilevante per il modulo Notify di <nome progetto>, in particolare per la gestione dei template email.

## Concetto Base

La generazione automatica di slug a partire da un campo titolo è una pratica comune che migliora l'usabilità dei form. Tuttavia, una volta che un contenuto viene pubblicato, modificare lo slug può causare problemi di accessibilità (errori 404) per gli URL esistenti. 

L'approccio qui documentato implementa una logica più sofisticata che:

1. Genera automaticamente lo slug dal titolo durante la creazione
2. Consente la modifica dello slug finché il contenuto non è pubblicato
3. Blocca le modifiche automatiche dello slug per i contenuti pubblicati
4. Disabilita il campo slug per i contenuti pubblicati come ulteriore protezione

## Implementazione Base di Filament

La documentazione di Filament propone questa soluzione standard:

```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Illuminate\Support\Str;

TextInput::make('title')
    ->live()
    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))

TextInput::make('slug')
```

Questo approccio funziona bene in situazioni semplici, ma non previene modifiche indesiderate agli slug pubblicati.

## Implementazione Avanzata

### Generazione Condizionale dello Slug

```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

TextInput::make('name')
    ->live()
    ->afterStateUpdated(function (Get $get, Set $set, ?string $operation, ?string $old, ?string $state, ?Model $record) {
        // Non aggiornare lo slug se in modalità edit e il record è pubblicato
        if ($operation === 'edit' && $record->isPublished()) {
            return;
        }
        
        // Non aggiornare lo slug se è stato modificato manualmente
        if (($get('slug') ?? '') !== Str::slug($old)) {
            return;
        }
        
        // Aggiorna lo slug solo se le condizioni sopra non sono verificate
        $set('slug', Str::slug($state));
    })
```

### Campo Slug con Disabilitazione Condizionale

```php
TextInput::make('slug')
    ->required()
    ->maxLength(255)
    ->unique(MailTemplate::class, 'slug', fn ($record) => $record)
    ->disabled(fn (?string $operation, ?Model $record) => 
        $operation === 'edit' && $record->isPublished())
```

## Adattamento per MailTemplateResource

Per integrare questa soluzione nel contesto di `MailTemplateResource` , è necessario:

1. Definire quando un template è considerato "pubblicato"
2. Implementare la logica nei componenti del form
3. Mantenere la compatibilità con le convenzioni del progetto

### Definizione di "Template Pubblicato"

Per i template email, possiamo considerare un template come "pubblicato" quando:
- È stato utilizzato almeno una volta per inviare un'email
- Ha un flag specifico impostato (es. `is_published`)
- È associato a determinati tipi di notifiche

Esempio di implementazione:

```php
// Aggiunta al modello MailTemplate
public function isPublished(): bool
{
    // Logica basata sul numero di utilizzi
    if ($this->logs()->count() > 0) {
        return true;
    }
    
    // O basata su un flag specifico
    return (bool) $this->is_published;
}
```

### Implementazione Conforme in getFormSchema()

```php
public static function getFormSchema(): array
{
    return [
        'name' => TextInput::make('name')
            ->required()
            ->maxLength(255)
            ->live()
            ->afterStateUpdated(function (Get $get, Set $set, ?string $operation, ?string $old, ?string $state, ?Model $record) {
                // Non aggiornare lo slug se in modalità edit e il template è pubblicato
                if ($operation === 'edit' && $record && $record->isPublished()) {
                    return;
                }
                
                // Non aggiornare lo slug se è stato modificato manualmente
                if (($get('slug') ?? '') !== Str::slug($old)) {
                    return;
                }
                
                // Aggiorna lo slug solo se le condizioni sopra non sono verificate
                $set('slug', Str::slug($state));
            }),
            
        'slug' => TextInput::make('slug')
            ->required()
            ->unique(MailTemplate::class, 'slug', fn ($record) => $record)
            ->maxLength(255)
            ->disabled(fn (?string $operation, ?Model $record) => 
                $operation === 'edit' && $record && $record->isPublished()),
            
        // Altri campi...
    ];
}
```

## Vantaggi dell'Approccio

1. **Prevenzione di Link Interrotti**: Gli slug dei template pubblicati rimangono stabili
2. **Flessibilità per Nuovi Template**: Generazione automatica durante la creazione
3. **Interfaccia Intuitiva**: Disabilitazione del campo per indicare visivamente che non può essere modificato
4. **Esperienza Utente Migliorata**: Riduzione degli errori umani
5. **Compatibilità con Workflow**: Si adatta al ciclo di vita del template

## Considerazioni per l'Implementazione

### Adattamenti Necessari

1. **Definizione di "Pubblicato"**: Specificare chiaramente quando un template è considerato pubblicato
2. **Gestione delle Eccezioni**: Prevedere meccanismi per modificare gli slug pubblicati quando assolutamente necessario
3. **Feedback Utente**: Comunicare chiaramente perché lo slug non può essere modificato

### Implementazione Tecnica

1. **Modello**: Aggiungere un metodo `isPublished()` al modello `MailTemplate`
2. **Form**: Configurare i componenti con la logica condizionale
3. **UI**: Fornire indicazioni visive sullo stato del template

## Alternative

### 1. Pacchetto TitleWithSlugInput

Come documentato in [TITLE_WITH_SLUG_COMPONENT.md](./TITLE_WITH_SLUG_COMPONENT.md), il pacchetto `filament-title-with-slug` offre funzionalità simili con un'interfaccia più ricca. Tuttavia, l'approccio presentato qui può essere implementato senza dipendenze aggiuntive.

### 2. Reindirizzamenti Automatici

In alternativa o in aggiunta, è possibile implementare un sistema di reindirizzamenti che preservi l'accesso ai template anche dopo la modifica dello slug. Questo approccio richiede:

- Una tabella per tracciare gli slug precedenti
- Un middleware per intercettare le richieste con slug obsoleti
- Logica di reindirizzamento

## Conclusioni

L'implementazione di una generazione intelligente di slug per i template email migliora significativamente la stabilità e l'usabilità del sistema. Preservando gli slug dei template pubblicati, si prevengono problemi di accessibilità e si garantisce un'esperienza utente coerente.

Per il modulo Notify di , questa soluzione rappresenta un equilibrio ottimale tra automazione e controllo, con particolare attenzione alla preservazione dei link esistenti.
Per il modulo Notify di <nome progetto>, questa soluzione rappresenta un equilibrio ottimale tra automazione e controllo, con particolare attenzione alla preservazione dei link esistenti.

## Riferimenti

- [Articolo Laravel News](https://laravel-news.com/generating-slugs-from-a-title-in-filament)
- [Documentazione Filament Forms](https://filamentphp.com/docs/3.x/forms/advanced)
- [Implementazione Modello con Slug](./MODEL_SLUG_IMPLEMENTATION.md)
- [Componente TitleWithSlug](./TITLE_WITH_SLUG_COMPONENT.md)
- [Miglioramenti UI/UX per Slug](./UI_UX_ENHANCEMENTS.md)
