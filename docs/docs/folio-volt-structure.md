# Folio + Volt Structure - Meetup Module

## Data
[DATE]

## Architettura Frontoffice

### File di Pagina
I file di pagina sono posizionati in:
```
Themes/Meetup/resources/views/pages/
```

### Pagina Home (`index.blade.php`)
Il file `index.blade.php` rappresenta la homepage del sito:

```php
<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Filament\Notifications\Notification;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Livewire\Volt\Component;
use Modules\Tenant\Services\TenantService;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('home');
middleware(PageSlugMiddleware::class);

new class extends Component {};

?>

<x-layouts.app>
    @volt('home')
        <div>
            <x-page side="content" slug="home" />
        </div>
    @endvolt
</x-layouts.app>
```

### Pagina Generica (`[slug].blade.php`)
Il file `[slug].blade.php` gestisce tutte le pagine dinamiche:

```php
<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Filament\Notifications\Notification;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Livewire\Volt\Component;
use Modules\Tenant\Services\TenantService;
use Modules\Cms\Models\Page;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

/** @var array */
//$middleware=TenantService::config('middleware');
//$base_middleware=Arr::get($middleware,'base',[]);

$base_middleware=[];

name('pages.view');
/*
if(isset($slug)){
    $middleware=Page::getMiddlewareBySlug($slug);
    middleware($middleware);
}
*/
middleware(PageSlugMiddleware::class);

new class extends Component
{
    public string $slug;

};

?>

<x-layouts.public>
    @volt('pages.view')
    <div>
        <x-page side="content" :slug="$slug" />
    </div>
    @endvolt
</x-layouts.public>
```

## Sistema di Contenuto JSON

### Struttura dei Dati
I contenuti delle pagine sono memorizzati in file JSON nella directory:
```
config/local/laravelpizza/database/content/
```

### Esempio di Struttura Home Page
```
config/local/laravelpizza/database/content/pages/home.json
```

Il file contiene:
- Titolo della pagina
- Slug
- Middleware
- Content blocks (sezioni dinamiche)
- Sidebar blocks
- Footer blocks

### Componente Page
Il componente `<x-page>` elabora i content blocks e li converte in componenti UI:
```blade
<x-page side="content" slug="home" />
```

## Sistema di Content Blocks

### Funzionamento
I content blocks sono definiti come strutture JSON che contengono:
- `type`: Tipo di blocco
- `view`: Vista Blade da utilizzare
- `data`: Dati specifici per il blocco

### Componente BlockData
Il sistema usa `BlockData` per gestire i dati dei blocchi e assicurare che le viste esistano.

## Build Process CSS/JS

### Comandi Necessari
Dalla directory `Themes/Meetup`:

1. Installare dipendenze:
```bash
npm install
```

2. Compilare assets:
```bash
npm run build
```

3. Copiare assets compilati nella directory pubblica:
```bash
npm run copy
```

### Struttura Vite
- Input: `resources/css/app.css`, `resources/js/app.js`
- Output: `public/` (da copiare in `public_html/themes/Meetup`)
- Configurazione: `vite.config.js`

## Conversione da LaravelPizza.com

### Obiettivo
Questa architettura rappresenta la conversione di laravelpizza.com nella struttura Laraxot utilizzando:
- Laravel Folio per routing file-based
- Livewire Volt per interattività
- Sistema di content blocks con JSON e componenti Blade
- Filament per l'admin panel

### Pattern Utilizzati
- Frontoffice: Folio + Volt (nessun controller)
- Backend: Filament (admin panel)
- Contenuti: JSON-based content blocks
- Componenti: Blade components con sistema di view dinamiche

## Componenti UI

### Componenti Disponibili
I componenti UI sono accessibili tramite il namespace `pub_theme::`:
- Hero sections
- Features grid
- Stats overview
- CTA banners
- E altri componenti modulari

## Sicurezza e Performance

### Sicurezza
- Middleware PageSlugMiddleware per gestire la sicurezza delle pagine
- Validazione delle viste prima del rendering
- Type safety con strict_types=1

### Performance
- Sistema Sushi per dati statici da JSON
- Componenti dinamici solo quando necessario
- Asset compilation ottimizzata con Vite
