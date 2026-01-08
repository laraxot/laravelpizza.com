# Struttura della Homepage

## Introduzione

Questo documento descrive la struttura e il funzionamento della homepage nell'applicazione, concentrandosi sull'architettura tecnica che combina Laravel Folio, il sistema di temi e la gestione dei contenuti tramite blocchi.

## Architettura Generale

La homepage è implementata seguendo un'architettura modulare che separa il layout dalla gestione dei contenuti:

1. **Laravel Folio** - Gestisce il routing basato su file
2. **Theme System** - Fornisce il layout e i componenti visivi
3. **CMS Module** - Gestisce i contenuti dinamici attraverso blocchi configurabili
4. **UI Module** - Implementa i componenti visuali riutilizzabili

## File Principali

### Rotta della Homepage

La homepage è gestita dal file:

```
laravel/Themes/One/resources/views/pages/index.blade.php
```

Questo file utilizza Laravel Folio per mappare la rotta principale (`/`) o localizzata (`/{locale}`) alla homepage dell'applicazione.

### Implementazione

```php
<?php
use function Laravel\Folio\{middleware, name};
use Filament\Notifications\Notification;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Actions\Action;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Livewire\Volt\Component;
use Modules\Tenant\Services\TenantService;

/** @var array */
$base_middleware = [];

name('home');
middleware($base_middleware);

new class extends Component {};
?>

<x-layouts.marketing>
    <div>
        {!! $_theme->showPageContent('home') !!}
    </div>
</x-layouts.marketing>
```

Questo file:
1. Utilizza Laravel Folio per definire la rotta con nome 'home'
2. Applica i middleware configurati
3. Utilizza il layout marketing dal tema corrente
4. Chiama il metodo `showPageContent('home')` del ThemeComposer per renderizzare i contenuti dinamici

## Gestione del Contenuto

### ThemeComposer

Il componente chiave per la visualizzazione della homepage è la classe `ThemeComposer`:

```
laravel/Modules/Cms/app/View/Composers/ThemeComposer.php
```

Il metodo `showPageContent` recupera e renderizza i blocchi di contenuto per una specifica pagina:

```php
public function showPageContent(string $slug): Renderable
{
    Assert::isInstanceOf($page = Page::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]), Page::class, '['.__LINE__.']['.__FILE__.']');

    $blocks = $page->content_blocks;

    if (! is_array($blocks)) {
        $blocks = [];
    }
    $page = new \Modules\UI\View\Components\Render\Blocks(blocks: $blocks, model: $page);

    return $page->render();
}
```

Questo metodo:
1. Recupera la pagina dal database in base allo slug 'home'
2. Estrae i blocchi di contenuto dalla pagina
3. Utilizza il componente `Modules\UI\View\Components\Render\Blocks` per renderizzare i blocchi
4. Restituisce il contenuto HTML renderizzato

### Modello Page

Il modello `Page` in `Modules\Cms\Models\Page` memorizza la struttura e i contenuti delle pagine, inclusa la homepage:

- `slug` - Identificatore univoco della pagina, 'home' per la homepage
- `title` - Titolo della pagina
- `content_blocks` - Array JSON dei blocchi di contenuto
- `sidebar_blocks` - Array JSON dei blocchi della sidebar (opzionale per la homepage)

## Struttura dei Blocchi di Contenuto

I blocchi di contenuto sono strutturati come oggetti JSON con:

1. `type` - Tipo del blocco (es. 'hero', 'text_block', 'feature_sections', 'stats')
2. `data` - Dati specifici del blocco, incluso:
   - `view` - Path al template Blade per renderizzare il blocco
   - Campi specifici per il tipo di blocco (titolo, contenuto, immagini, ecc.)

Esempio di un blocco di tipo hero:

```json
{
    "type": "hero",
    "data": {
        "view": "ui::components.blocks.hero.v1",
        "title": "Promozione della <slogan> per le gestanti",
        "subtitle": "Servizi odontoiatrici gratuiti per donne in gravidanza",
        "image": "/images/hero/dental-care.jpg",
        "cta_text": "Scopri di più",
        "cta_link": "/about"
    }
}
```

## Personalizzazione della Homepage

### Modifica del Layout

Per modificare il layout generale della homepage:

1. Modificare il file `laravel/Themes/One/resources/views/pages/index.blade.php`
2. Personalizzare il layout `<x-layouts.marketing>` o utilizzare un layout alternativo
3. Aggiungere componenti aggiuntivi prima o dopo il contenuto dinamico

### Modifica dei Contenuti

Per modificare i contenuti della homepage:

1. Utilizzare il pannello amministrativo Filament per modificare la pagina con slug 'home'
2. Aggiungere, rimuovere o modificare i blocchi di contenuto
3. Configurare i singoli blocchi in base alle esigenze

Alternativamente, è possibile modificare direttamente il file JSON della pagina (sconsigliato in produzione):

```
/laravel/config/local/database/content/pages/1.json
```

## Collegamento con i Temi

La homepage utilizza il sistema di temi dell'applicazione:

1. Il layout principale è definito in `laravel/Themes/One/resources/views/components/layouts/main.blade.php`
2. Il layout marketing estende il layout principale
3. I componenti UI sono definiti nel modulo UI e richiamati dai blocchi di contenuto

## Considerazioni di Performance

Per ottimizzare le performance della homepage:

1. **Caching**: Implementare il caching per i blocchi di contenuto
2. **Lazy Loading**: Utilizzare il lazy loading per le immagini
3. **Asset Optimization**: Ottimizzare gli asset CSS e JavaScript
4. **Query Optimization**: Ridurre il numero di query al database durante il rendering

## Best Practices

1. **Modularità**: Mantenere una chiara separazione tra layout e contenuto
2. **Riutilizzabilità**: Creare blocchi personalizzabili e riutilizzabili
3. **Localizzazione**: Gestire correttamente le traduzioni dei contenuti
4. **Testing**: Verificare la responsiveness su diversi dispositivi
5. **Manutenibilità**: Documentare le personalizzazioni e i blocchi personalizzati 