# Struttura delle Pagine con Laravel Folio nel Tema One

Questo documento descrive come sono organizzate e gestite le pagine utilizzando Laravel Folio nel tema One del progetto il progetto.

## Indice
1. [Introduzione](#introduzione)
2. [Struttura delle Directory](#struttura-delle-directory)
3. [Nomenclatura dei File](#nomenclatura-dei-file)
4. [Pagine Dinamiche](#pagine-dinamiche)
5. [Integrazione con il CMS](#integrazione-con-il-cms)
6. [Localizzazione](#localizzazione)
7. [Best Practices](#best-practices)
6. [Best Practices](#best-practices)

## Introduzione

Laravel Folio è una libreria di Laravel che permette di creare pagine basate su file, dove ogni file rappresenta un percorso URL specifico. Il tema One utilizza Laravel Folio per gestire le pagine frontend in modo semplice ed efficiente.

## Struttura delle Directory

La struttura delle directory per le pagine nel tema One è organizzata come segue:

```
Themes/One/resources/views/pages/
├── index.blade.php             # Homepage principale
├── about.blade.php             # Pagina "Chi siamo"
├── pages/                      # Sottocartella per le pagine dinamiche
│   ├── index.blade.php         # Indice delle pagine dinamiche
│   └── [slug].blade.php        # Gestore per le pagine dinamiche dal CMS
├── auth/                       # Pagine di autenticazione
├── profile/                    # Pagine profilo utente
└── ... altre sezioni ...
```

## Nomenclatura dei File

Folio segue convenzioni specifiche per la nomenclatura dei file:

1. **File statici**: `nome-pagina.blade.php` → `/nome-pagina`
2. **Parametri dinamici**: `[parametro].blade.php` → `/{valore-parametro}`
3. **Parametri opzionali**: `[[parametro]].blade.php` → `/` o `/{valore-parametro}`
4. **Index files**: `index.blade.php` → `/` (nella directory corrente)

## Pagine Dinamiche

### Il Gestore [slug].blade.php

Il file `[slug].blade.php` nella directory `pages/` è responsabile della gestione delle pagine dinamiche create tramite il CMS. Ecco come funziona:

```php
<?php
use Modules\Cms\Models\Page;
use Illuminate\View\View;
use function Laravel\Folio\{withTrashed, name, render};

withTrashed();
name('page_slug.view');

render(function (View $view, string $slug) {
    $locale = app()->getLocale();
    $page = Page::firstWhere(['slug' => $slug]);
    
    return $view->with('page', $page);
});
?>

<x-layouts.marketing>
    <div class="max-w-[calc(100%-30px)] sm:max-w-[calc(100%-80px)] lg:max-w-[996px] mx-auto pb-12 font-roboto">
        @if($page)
            <div class="py-10">
                <h1 class="text-[2rem] mb-4 font-roboto font-semibold text-neutral-5">
                    {{ $page->title }}
                </h1>
            </div>

            @if(!empty($page->sidebar_blocks))
                <div class="grid grid-cols-1 lg:grid-cols-[21.25rem,1fr] gap-4">
                    <div class="space-y-6">
                        {{ $_theme->showPageSidebarContent($page->slug) }}
                    </div>

                    {{ $_theme->showPageContent($page->slug) }}
                </div>
            @else
                <div>
                    {{ $_theme->showPageContent($page->slug) }}
                </div>
            @endif
        @else
            <!-- Pagina non trovata -->
            <div class="flex flex-col items-center justify-center py-8 space-y-4">
                <!-- Contenuto per errore 404 -->
            </div>
        @endif
    </div>
</x-layouts.marketing>
```

### La Pagina index.blade.php

Il file `index.blade.php` nella directory `pages/` serve come punto di ingresso per l'elenco delle pagine dinamiche. Questo file dovrebbe:

1. Recuperare l'elenco delle pagine disponibili dal modello `Page`
2. Mostrarle in un formato adeguato (ad esempio, una griglia di card o un elenco)
3. Fornire link alle singole pagine, includendo la locale corrente
3. Fornire link alle singole pagine

## Integrazione con il CMS

Il tema One si integra con il modulo CMS per gestire le pagine dinamiche. I componenti chiave di questa integrazione sono:

### 1. Modello Page

Il modello `Page` dal modulo CMS memorizza i dati delle pagine, inclusi:
- Titolo
- Slug (URL)
- Contenuto (usando blocchi strutturati)
- Informazioni della sidebar
- Traduzioni

### 2. Helper del Tema

Il tema One fornisce due helper per renderizzare il contenuto delle pagine:

- `$_theme->showPageContent($slug)`: Renderizza i blocchi principali della pagina
- `$_theme->showPageSidebarContent($slug)`: Renderizza i blocchi della sidebar della pagina

Questi helper gestiscono l'interpretazione dei dati JSON dei blocchi e li convertono in HTML renderizzato.

## Localizzazione

### Struttura degli URL Localizzati

In il progetto, tutti gli URL devono includere il prefisso della lingua corrente. La struttura corretta è:

```
/{locale}/sezione/pagina
```

Esempi:
- `/it/pages/chi-siamo`
- `/en/pages/about-us`

### Generazione Corretta dei Link

Quando si generano link alle pagine, è fondamentale includere sempre la locale corrente:

```php
// CORRETTO
<a href="{{ url('/' . app()->getLocale() . '/pages/' . $page->slug) }}">{{ $page->title }}</a>

// ERRATO - manca la locale
<a href="{{ url('/pages/' . $page->slug) }}">{{ $page->title }}</a>
```

### Recupero della Locale

La locale corrente può essere recuperata usando:

```php
$locale = app()->getLocale();
```

### Cambio Lingua

Per link di cambio lingua, generare URL con la stessa struttura ma diverso prefisso lingua:

```php
<a href="{{ url('/it/pages/' . $page->slug) }}">Italiano</a>
<a href="{{ url('/en/pages/' . $page->slug) }}">English</a>
```

## Best Practices

### Organizzazione delle Pagine

1. **Modularità**: Creare directory dedicate per gruppi di pagine correlate
2. **Riutilizzo**: Utilizzare componenti Blade per elementi ripetuti
3. **Chiarezza**: Utilizzare nomi di file descrittivi che riflettono il contenuto

### Accesso ai Dati

1. **Efficienza**: Ottimizzare le query al database
2. **Caching**: Implementare il caching per le pagine che cambiano raramente
3. **Eager Loading**: Utilizzare il caricamento anticipato per le relazioni quando appropriato

### Layout e Contenuto

1. **Coerenza**: Mantenere un'esperienza utente coerente tra le pagine
2. **Responsività**: Assicurarsi che le pagine siano responsive su tutti i dispositivi
3. **Accessibilità**: Seguire le linee guida di accessibilità WCAG

### Gestione delle Traduzioni

1. **Localizzazione dei URL**: Utilizzare prefissi di lingua negli URL (`/it/page`, `/en/page`)
2. **Contenuto Tradotto**: Memorizzare le traduzioni nel database e recuperarle in base alla lingua corrente
3. **Fallback**: Implementare un meccanismo di fallback alla lingua predefinita

## Creazione di Nuove Pagine

Per creare una nuova pagina statica nel tema One:

1. Creare un nuovo file `.blade.php` nella directory appropriata sotto `pages/`
2. Utilizzare il layout appropriato (es. `<x-layouts.marketing>`)
3. Aggiungere il contenuto della pagina

Per le pagine dinamiche, utilizzare l'interfaccia amministrativa Filament per creare e gestire le pagine attraverso il modulo CMS. 
## Collegamenti tra versioni di folio-pages.md
* [folio-pages.md](laravel/Modules/User/resources/views/project_docs/folio-pages.md)
* [folio-pages.md](laravel/Modules/Cms/project_docs/folio-pages.md)
* [folio-pages.md](laravel/Themes/One/project_docs/folio-pages.md)

