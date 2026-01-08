# Gestione Contenuti

## Modelli di Contenuto

### Page

Il modello `Page` rappresenta una pagina del sito con i seguenti attributi:

- `title`: Titolo della pagina
- `slug`: Identificatore unico della pagina (URL-friendly)
- `content_blocks`: Blocchi di contenuto della pagina
- `sidebar_blocks`: Blocchi di contenuto della sidebar

### Menu

Il modello `Menu` rappresenta un menu di navigazione con i seguenti attributi:

- `title`: Titolo del menu
- `items`: Elementi del menu (struttura JSON)

### PageContent

Il modello `PageContent` rappresenta un blocco di contenuto riutilizzabile:

- `name`: Nome del blocco di contenuto
- `slug`: Identificatore unico del blocco
- `blocks`: Contenuto strutturato del blocco

## Builder di Contenuti

Il modulo utilizza diversi builder per la creazione di contenuti dinamici:

### PageContent Builder

Un editor visuale che permette di creare contenuti strutturati con:

- Testo formattato
- Immagini
- Video
- Gallerie
- Call to action
- Form di contatto
- Testimonial
- FAQ
- Slider
- Pricing
- Team
- Features

Esempio:

```php
// Utilizzare il campo PageContent in una risorsa Filament
'content' => Forms\Components\Section::make('Contenuto Pagina')
    ->schema([
        PageContent::make('content_blocks')
            ->required()
            ->columnSpanFull(),
    ]),
```

### Sidebar Builder

Un editor per la creazione di sidebar con:

- Widget personalizzati
- Richiami a blocchi di contenuto
- Menu secondari
- Form di ricerca
- Tag cloud

Esempio:

```php
// Utilizzare il campo Sidebar in una risorsa Filament
'sidebar' => Forms\Components\Section::make('Sidebar')
    ->schema([
        LeftSidebarContent::make('sidebar_blocks')
            ->columnSpanFull(),
    ]),
```

## Rendering dei Contenuti

### Blade Components

Il modulo fornisce componenti Blade per il rendering dei contenuti:

```blade
<x-cms::page-content :content="$page->content_blocks" />
<x-cms::sidebar :content="$page->sidebar_blocks" />
<x-cms::menu :menu="$menu" />
```

### Helpers

Sono disponibili helper per recuperare e visualizzare i contenuti:

```php
// Recuperare una pagina per slug
$page = cms_page('chi-siamo');

// Recuperare un menu per slug
$menu = cms_menu('main-menu');

// Recuperare un blocco di contenuto per slug
$content = cms_content('home-hero');
```

## Traduzione dei Contenuti

Il modulo supporta la traduzione dei contenuti tramite il trait `Translatable`:

```php
// Recuperare una pagina tradotta nella lingua corrente
$page = Page::find(1)->translate();

// Recuperare una pagina in una lingua specifica
$page = Page::find(1)->translate('en');

// Salvare una traduzione
$page->setTranslation('title', 'en', 'About Us')
     ->setTranslation('title', 'it', 'Chi Siamo')
     ->save();
``` 