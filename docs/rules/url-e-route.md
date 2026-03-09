# Regole per URL e Route in il progetto

## Introduzione

Questo documento definisce le convenzioni e le best practice per la creazione e la gestione di URL e route all'interno del progetto il progetto.

> **Nota:** Per le regole specifiche sui collegamenti nella documentazione, consulta [Regole per i Collegamenti nella Documentazione](collegamenti-relativi.md).

## Indice
1. [Struttura degli URL](#struttura-degli-url)
2. [Localizzazione](#localizzazione)
3. [Generazione dei Link](#generazione-dei-link)
4. [Folio e Route Dinamiche](#folio-e-route-dinamiche)
5. [Parametri e Query String](#parametri-e-query-string)
6. [Best Practices](#best-practices)
7. [Troubleshooting](#troubleshooting)

## Struttura degli URL

il progetto segue una struttura uniforme per tutti gli URL:

```
/{locale}/{sezione}/{risorsa}/{azione?}/{id?}
```

Dove:
- `{locale}` è il codice della lingua (es. `it`, `en`)
- `{sezione}` è l'area del sito (es. `pages`, `services`, `doctors`)
- `{risorsa}` è la risorsa specifica (es. `chi-siamo`, `cardiologia`)
- `{azione}` e `{id}` sono parametri opzionali per azioni specifiche

## Localizzazione

### Prefissi di Lingua Obbligatori

Tutti gli URL in il progetto **devono** includere il prefisso della lingua come primo segmento del percorso.

Esempi corretti:
- `/it/pages/chi-siamo`
- `/en/services/cardiology`
- `/it/doctors/rossi-mario`

Esempi errati:
- `/pages/chi-siamo` (manca la locale)
- `it/pages/chi-siamo` (manca lo slash iniziale)

### Recupero della Locale Corrente

La locale corrente puo' essere letta con `app()->getLocale()`, ma nel progetto non va usata per costruire URL concatenando manualmente il path.

Per URL e switch lingua usare gli helper del pacchetto `mcamara/laravel-localization`.

## Generazione dei Link

### Utilizzare la Locale Corrente

Quando si generano link nel codice, usare sempre gli helper del pacchetto:

```php
// CORRETTO
<a href="{{ LaravelLocalization::localizeUrl('/pages/' . $page->slug) }}">{{ $page->title }}</a>

// CORRETTO - language switcher / alternate locale
<a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ $label }}</a>

// ERRATO
<a href="{{ url('/' . app()->getLocale() . '/pages/' . $page->slug) }}">{{ $page->title }}</a>

// ERRATO
<a href="/it/pages/{{ $page->slug }}">{{ $page->title }}</a>
```

## Folio e Route Dinamiche

### Laravel Folio

Quando si utilizzano le pagine Folio, assicurarsi che la route viva nel gruppo localizzato del pacchetto e passare alla vista solo i dati che servono:

```php
<?php
use Illuminate\View\View;
use function Laravel\Folio\render;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

render(function (View $view) {
    // Altre operazioni...

    return $view->with([
        'data' => $data,
        'eventsUrl' => LaravelLocalization::localizeUrl('/events'),
    ]);
});
?>
```

### Passaggio della Locale alle Viste

Passare alle viste URL gia' localizzati o usare direttamente gli helper del pacchetto:

```php
return view('pages.index', [
    'pages' => $pages,
    'eventsUrl' => LaravelLocalization::localizeUrl('/events'),
]);
```

## Parametri e Query String

### Mantenere i Parametri di Query

Quando si genera un link che deve mantenere i parametri di query esistenti:

```php
<a href="{{ url('/' . $locale . '/pages/' . $page->slug) . '?' . http_build_query(request()->query()) }}">
    {{ $page->title }}
</a>
```

### Aggiungere o Modificare Parametri

```php
$query = request()->query();
$query['filter'] = 'new-value';

<a href="{{ url('/' . $locale . '/pages/' . $page->slug) . '?' . http_build_query($query) }}">
    {{ $page->title }}
</a>
```

## Best Practices

1. **Consistenza**: Mantenere una struttura URL coerente in tutta l'applicazione
2. **Leggibilità**: Usare slug leggibili per gli URL (`chi-siamo` vs `pagina-1`)
3. **Validazione**: Validare sempre i parametri degli URL prima di utilizzarli
4. **Fallback**: Implementare un meccanismo di fallback quando la risorsa non esiste nella lingua richiesta
5. **SEO**: Includere informazioni rilevanti negli URL per migliorare il SEO

## Troubleshooting

### Problemi Comuni

1. **Link Errati**: Se i link non funzionano, verificare che includano il prefisso della lingua
2. **Errori 404**: Verificare che lo slug esista nel database per la lingua corrente
3. **Redirect Infiniti**: Controllare che i middleware di localizzazione non creino redirect infiniti
4. **Incongruenze nelle Traduzioni**: Verificare che gli slug tradotti siano unici per ogni lingua

### Debug

Per debugging di problemi con gli URL:

```php
// Stampare l'URL corrente
dd(request()->url());

// Verificare la locale corrente
dd(app()->getLocale());

// Vedere tutti i parametri della richiesta
dd(request()->all());
```
