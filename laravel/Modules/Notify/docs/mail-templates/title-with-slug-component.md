# Analisi del Componente TitleWithSlugInput per Filament

## Introduzione

Il pacchetto `filament-title-with-slug` di Camya fornisce un componente specializzato per la gestione combinata di titoli e slug nei form Filament. Questo documento analizza le funzionalità del componente e la sua potenziale integrazione nel modulo Notify di , in particolare per la gestione dei template email.
Il pacchetto `filament-title-with-slug` di Camya fornisce un componente specializzato per la gestione combinata di titoli e slug nei form Filament. Questo documento analizza le funzionalità del componente e la sua potenziale integrazione nel modulo Notify di <nome progetto>, in particolare per la gestione dei template email.

## Panoramica del Pacchetto

### Caratteristiche Principali

- **Integrazione titolo-slug**: Gestione combinata dei campi titolo e slug in un unico componente
- **Generazione automatica**: Conversione automatica del titolo in slug
- **Anteprima URL**: Visualizzazione in tempo reale dell'URL risultante
- **Personalizzazione**: Possibilità di modificare etichette, placeholder e comportamenti
- **Link "Visita"**: Opzione per visualizzare e navigare direttamente all'URL
- **Supporto Dark Mode**: Compatibilità con il tema scuro di Filament
- **Validazione Avanzata**: Regole di validazione personalizzabili

### Compatibilità con

Il componente è compatibile con l'architettura di  e può essere integrato seguendo le convenzioni del progetto:
### Compatibilità con <nome progetto>

Il componente è compatibile con l'architettura di <nome progetto> e può essere integrato seguendo le convenzioni del progetto:

- Non utilizza componenti UI personalizzati
- Può essere configurato per restituire array associativi con chiavi stringhe
- Supporta la localizzazione attraverso file di traduzione
- Si integra con il pattern di form di Filament utilizzato

## Installazione

Per integrare il componente nel modulo Notify, è necessario installare il pacchetto:

```bash
composer require camya/filament-title-with-slug
```

Opzionalmente, è possibile pubblicare il file di configurazione:

```bash
php artisan vendor:publish --tag="filament-title-with-slug-config"
```

## Implementazione in MailTemplateResource

### Configurazione Base

Ecco come il componente potrebbe essere implementato in `MailTemplateResource` seguendo le convenzioni di :
Ecco come il componente potrebbe essere implementato in `MailTemplateResource` seguendo le convenzioni di <nome progetto>:

```php
use Camya\Filament\Forms\Components\TitleWithSlugInput;

public static function getFormSchema(): array
{
    return [
        'titleSlug' => TitleWithSlugInput::make(
            fieldTitle: 'name',
            fieldSlug: 'slug',
        )
        ->columnSpanFull(),

        // Altri campi del form
        'subject' => Forms\Components\TextInput::make('subject')
            ->required()
            ->maxLength(255),

        'html_template' => Forms\Components\RichEditor::make('html_template')
            ->required()
            ->columnSpanFull(),

        'text_template' => Forms\Components\Textarea::make('text_template')
            ->maxLength(65535)
            ->columnSpanFull(),
    ];
}
```

### Personalizzazione Avanzata

Per adattare il componente alle esigenze specifiche di :
Per adattare il componente alle esigenze specifiche di <nome progetto>:

```php
'titleSlug' => TitleWithSlugInput::make(
    fieldTitle: 'name',
    fieldSlug: 'slug',
)
->urlPath('/mail-templates/')
->urlHost(config('app.url'))
->titleLabel('Nome Template')
->titlePlaceholder('Inserisci il nome del template...')
->slugLabel('Identificatore')
->urlVisitLinkLabel('Visualizza Template')
->columnSpanFull(),
```

## Funzionalità Rilevanti

### 1. Generazione Automatica dello Slug

Il componente converte automaticamente il titolo in uno slug, applicando trasformazioni come:
- Conversione in minuscolo
- Sostituzione degli spazi con trattini
- Rimozione di caratteri speciali

Questo comportamento è personalizzabile attraverso il parametro `slugSlugifier`:

```php
->slugSlugifier(fn($string) => Str::slug($string))
```

### 2. Anteprima URL

Il componente mostra un'anteprima dell'URL completo, personalizzabile attraverso:

```php
->urlPath('/mail-templates/')
->urlHost('https://<nome progetto>.example.com')
->urlHost('https://<nome progetto>.example.com')
->urlHostVisible(true)
```

### 3. Validazione

Le regole di validazione possono essere personalizzate sia per il titolo che per lo slug:

```php
->titleRules(['required', 'min:3', 'max:255'])
->slugRules(['required', 'max:255'])
->slugRuleRegex('/^[a-z0-9\-]+$/')
```

Per la validazione dell'unicità, il componente offre parametri specifici:

```php
->titleRuleUniqueParameters([
    'ignorable' => fn(?Model $record) => $record,
])
->slugRuleUniqueParameters([
    'ignorable' => fn(?Model $record) => $record,
])
```

### 4. Link "Visita"

Il componente può generare un link per visualizzare direttamente la risorsa:

```php
->urlVisitLinkRoute(fn(?Model $record) => $record?->slug
    ? route('notify.mail-templates.view', ['slug' => $record->slug])
    : null)
```

## Vantaggi per
## Vantaggi per <nome progetto>

L'integrazione di questo componente nel modulo Notify offrirebbe:

1. **Esperienza Utente Migliorata**: Interfaccia più intuitiva per la gestione dei template email
2. **Riduzione Errori**: Generazione automatica di slug validi e unici
3. **Feedback Visivo**: Anteprima immediata dell'URL
4. **Flessibilità**: Personalizzazione completa per adattarsi alle esigenze del progetto
5. **Consistenza**: Uniformità nella gestione di titoli e slug in tutta l'applicazione

## Considerazioni per l'Implementazione

### Conformità con le Convenzioni di

Per rispettare le convenzioni del progetto, è necessario:

1. **Traduzione**: Configurare le etichette per utilizzare il sistema di traduzione di  anziché testi hardcoded
### Conformità con le Convenzioni di <nome progetto>

Per rispettare le convenzioni del progetto, è necessario:

1. **Traduzione**: Configurare le etichette per utilizzare il sistema di traduzione di <nome progetto> anziché testi hardcoded
2. **Array Associativo**: Utilizzare chiavi stringhe nell'array di schema del form
3. **Nomenclatura**: Seguire le convenzioni di nomenclatura del progetto

### Esempio di Implementazione Conforme

```php
public static function getFormSchema(): array
{
    return [
        'titleWithSlug' => TitleWithSlugInput::make(
            fieldTitle: 'name',
            fieldSlug: 'slug',
        )
        ->columnSpanFull()
        // Non utilizziamo ->label() poiché le etichette sono gestite dal LangServiceProvider
        ->titleExtraInputAttributes(['class' => 'bg-gray-50']) // Stile compatibile con Filament
        ->urlVisitLinkRoute(function (?Model $record) {
            if (!$record?->slug) return null;
            return route('notify.mail-templates.view', ['slug' => $record->slug]);
        }),

        // Altri campi...
    ];
}
```

## Limitazioni e Alternative

### Potenziali Limitazioni

1. **Dipendenza Esterna**: Introduce una dipendenza aggiuntiva nel progetto
2. **Personalizzazione Visiva**: Potrebbe richiedere adattamenti per integrarsi perfettamente con il tema di
2. **Personalizzazione Visiva**: Potrebbe richiedere adattamenti per integrarsi perfettamente con il tema di <nome progetto>
3. **Modifiche Future**: Come ogni dipendenza, è soggetto a cambiamenti nelle versioni future

### Alternative

1. **Soluzione Custom**: Sviluppare un componente su misura basato sulle esigenze specifiche di
1. **Soluzione Custom**: Sviluppare un componente su misura basato sulle esigenze specifiche di <nome progetto>
2. **Approccio Modulare**: Utilizzare i componenti nativi di Filament con logica personalizzata
3. **Altri Pacchetti**: Valutare pacchetti alternativi con funzionalità simili

## Conclusioni

Il componente `TitleWithSlugInput` offre una soluzione elegante e completa per la gestione combinata di titoli e slug nei form Filament. La sua integrazione nel modulo Notify di  potrebbe migliorare significativamente l'esperienza utente nella gestione dei template email, semplificando il processo di creazione e modifica.
Il componente `TitleWithSlugInput` offre una soluzione elegante e completa per la gestione combinata di titoli e slug nei form Filament. La sua integrazione nel modulo Notify di <nome progetto> potrebbe migliorare significativamente l'esperienza utente nella gestione dei template email, semplificando il processo di creazione e modifica.

L'implementazione dovrebbe seguire le convenzioni del progetto, con particolare attenzione alla localizzazione e alla struttura del form schema.

## Riferimenti

- [Repository GitHub del Pacchetto](https://github.com/camya/filament-title-with-slug)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Implementazione Modello con Slug](./MODEL_SLUG_IMPLEMENTATION.md)
- [Implementazione Risorsa con Slug](./RESOURCE_SLUG_IMPLEMENTATION.md)
- [Miglioramenti UI/UX](./UI_UX_ENHANCEMENTS.md)
# Analisi del Componente TitleWithSlugInput per Filament

## Introduzione

Il pacchetto `filament-title-with-slug` di Camya fornisce un componente specializzato per la gestione combinata di titoli e slug nei form Filament. Questo documento analizza le funzionalità del componente e la sua potenziale integrazione nel modulo Notify di <main module>, in particolare per la gestione dei template email.

## Panoramica del Pacchetto

### Caratteristiche Principali

- **Integrazione titolo-slug**: Gestione combinata dei campi titolo e slug in un unico componente
- **Generazione automatica**: Conversione automatica del titolo in slug
- **Anteprima URL**: Visualizzazione in tempo reale dell'URL risultante
- **Personalizzazione**: Possibilità di modificare etichette, placeholder e comportamenti
- **Link "Visita"**: Opzione per visualizzare e navigare direttamente all'URL
- **Supporto Dark Mode**: Compatibilità con il tema scuro di Filament
- **Validazione Avanzata**: Regole di validazione personalizzabili

### Compatibilità con <main module>

Il componente è compatibile con l'architettura di <main module> e può essere integrato seguendo le convenzioni del progetto:

- Non utilizza componenti UI personalizzati
- Può essere configurato per restituire array associativi con chiavi stringhe
- Supporta la localizzazione attraverso file di traduzione
- Si integra con il pattern di form di Filament utilizzato

## Installazione

Per integrare il componente nel modulo Notify, è necessario installare il pacchetto:

```bash
composer require camya/filament-title-with-slug
```

Opzionalmente, è possibile pubblicare il file di configurazione:

```bash
php artisan vendor:publish --tag="filament-title-with-slug-config"
```

## Implementazione in MailTemplateResource

### Configurazione Base

Ecco come il componente potrebbe essere implementato in `MailTemplateResource` seguendo le convenzioni di <main module>:

```php
use Camya\Filament\Forms\Components\TitleWithSlugInput;

public static function getFormSchema(): array
{
    return [
        'titleSlug' => TitleWithSlugInput::make(
            fieldTitle: 'name',
            fieldSlug: 'slug',
        )
        ->columnSpanFull(),

        // Altri campi del form
        'subject' => Forms\Components\TextInput::make('subject')
            ->required()
            ->maxLength(255),

        'html_template' => Forms\Components\RichEditor::make('html_template')
            ->required()
            ->columnSpanFull(),

        'text_template' => Forms\Components\Textarea::make('text_template')
            ->maxLength(65535)
            ->columnSpanFull(),
    ];
}
```

### Personalizzazione Avanzata

Per adattare il componente alle esigenze specifiche di <main module>:

```php
'titleSlug' => TitleWithSlugInput::make(
    fieldTitle: 'name',
    fieldSlug: 'slug',
)
->urlPath('/mail-templates/')
->urlHost(config('app.url'))
->titleLabel('Nome Template')
->titlePlaceholder('Inserisci il nome del template...')
->slugLabel('Identificatore')
->urlVisitLinkLabel('Visualizza Template')
->columnSpanFull(),
```

## Funzionalità Rilevanti

### 1. Generazione Automatica dello Slug

Il componente converte automaticamente il titolo in uno slug, applicando trasformazioni come:
- Conversione in minuscolo
- Sostituzione degli spazi con trattini
- Rimozione di caratteri speciali

Questo comportamento è personalizzabile attraverso il parametro `slugSlugifier`:

```php
->slugSlugifier(fn($string) => Str::slug($string))
```

### 2. Anteprima URL

Il componente mostra un'anteprima dell'URL completo, personalizzabile attraverso:

```php
->urlPath('/mail-templates/')
->urlHost('https://<nome progetto>.example.com')
->urlHostVisible(true)
```

### 3. Validazione

Le regole di validazione possono essere personalizzate sia per il titolo che per lo slug:

```php
->titleRules(['required', 'min:3', 'max:255'])
->slugRules(['required', 'max:255'])
->slugRuleRegex('/^[a-z0-9\-]+$/')
```

Per la validazione dell'unicità, il componente offre parametri specifici:

```php
->titleRuleUniqueParameters([
    'ignorable' => fn(?Model $record) => $record,
])
->slugRuleUniqueParameters([
    'ignorable' => fn(?Model $record) => $record,
])
```

### 4. Link "Visita"

Il componente può generare un link per visualizzare direttamente la risorsa:

```php
->urlVisitLinkRoute(fn(?Model $record) => $record?->slug
    ? route('notify.mail-templates.view', ['slug' => $record->slug])
    : null)
```

## Vantaggi per <main module>

L'integrazione di questo componente nel modulo Notify offrirebbe:

1. **Esperienza Utente Migliorata**: Interfaccia più intuitiva per la gestione dei template email
2. **Riduzione Errori**: Generazione automatica di slug validi e unici
3. **Feedback Visivo**: Anteprima immediata dell'URL
4. **Flessibilità**: Personalizzazione completa per adattarsi alle esigenze del progetto
5. **Consistenza**: Uniformità nella gestione di titoli e slug in tutta l'applicazione

## Considerazioni per l'Implementazione

### Conformità con le Convenzioni di <main module>

Per rispettare le convenzioni del progetto, è necessario:

1. **Traduzione**: Configurare le etichette per utilizzare il sistema di traduzione di <main module> anziché testi hardcoded
2. **Array Associativo**: Utilizzare chiavi stringhe nell'array di schema del form
3. **Nomenclatura**: Seguire le convenzioni di nomenclatura del progetto

### Esempio di Implementazione Conforme

```php
public static function getFormSchema(): array
{
    return [
        'titleWithSlug' => TitleWithSlugInput::make(
            fieldTitle: 'name',
            fieldSlug: 'slug',
        )
        ->columnSpanFull()
        // Non utilizziamo ->label() poiché le etichette sono gestite dal LangServiceProvider
        ->titleExtraInputAttributes(['class' => 'bg-gray-50']) // Stile compatibile con Filament
        ->urlVisitLinkRoute(function (?Model $record) {
            if (!$record?->slug) return null;
            return route('notify.mail-templates.view', ['slug' => $record->slug]);
        }),

        // Altri campi...
    ];
}
```

## Limitazioni e Alternative

### Potenziali Limitazioni

1. **Dipendenza Esterna**: Introduce una dipendenza aggiuntiva nel progetto
2. **Personalizzazione Visiva**: Potrebbe richiedere adattamenti per integrarsi perfettamente con il tema di <main module>
3. **Modifiche Future**: Come ogni dipendenza, è soggetto a cambiamenti nelle versioni future

### Alternative

1. **Soluzione Custom**: Sviluppare un componente su misura basato sulle esigenze specifiche di <main module>
2. **Approccio Modulare**: Utilizzare i componenti nativi di Filament con logica personalizzata
3. **Altri Pacchetti**: Valutare pacchetti alternativi con funzionalità simili

## Conclusioni

Il componente `TitleWithSlugInput` offre una soluzione elegante e completa per la gestione combinata di titoli e slug nei form Filament. La sua integrazione nel modulo Notify di <main module> potrebbe migliorare significativamente l'esperienza utente nella gestione dei template email, semplificando il processo di creazione e modifica.

L'implementazione dovrebbe seguire le convenzioni del progetto, con particolare attenzione alla localizzazione e alla struttura del form schema.

## Riferimenti

- [Repository GitHub del Pacchetto](https://github.com/camya/filament-title-with-slug)
- [Documentazione Filament](https://filamentphp.com/docs)
- [Implementazione Modello con Slug](./MODEL_SLUG_IMPLEMENTATION.md)
- [Implementazione Risorsa con Slug](./RESOURCE_SLUG_IMPLEMENTATION.md)
- [Miglioramenti UI/UX](./UI_UX_ENHANCEMENTS.md)
