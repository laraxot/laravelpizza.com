# Architettura della Homepage

## Indice
- [Introduzione](#introduzione)
- [Struttura del Template](#struttura-del-template)
- [Gestione dei Contenuti](#gestione-dei-contenuti)
- [Flusso di Rendering](#flusso-di-rendering)
- [Componenti Principali](#componenti-principali)
- [Personalizzazione](#personalizzazione)
- [Best Practices](#best-practices)

## Introduzione

La homepage è implementata utilizzando un'architettura modulare che separa la presentazione dai contenuti. Questo documento descrive come il template della homepage (`index.blade.php`) interagisce con il sistema di gestione dei contenuti per visualizzare i blocchi di contenuto definiti nei file JSON.

## Struttura del Template

Il template principale della homepage si trova in:
```
/Themes/One/resources/views/pages/index.blade.php
```

Questo file è un template Blade che utilizza Laravel Folio per la gestione del routing e Livewire Volt per i componenti reattivi. La struttura del template è volutamente semplice:

```php
<?php
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

name('home');
middleware([/* middleware */]);

new class extends Component
{
   // Logica del componente Volt
};
?>

<x-layouts.marketing>
    <div>
        {!! $_theme->showPageContent('home') !!}
    </div>
</x-layouts.marketing>
```

Questa struttura ha diversi vantaggi:
1. **Separazione delle responsabilità**: Il template si occupa solo della struttura, mentre i contenuti sono gestiti separatamente
2. **Flessibilità**: I contenuti possono essere modificati senza toccare il codice
3. **Manutenibilità**: Aggiornamenti al layout non influenzano i contenuti e viceversa

## Gestione dei Contenuti

I contenuti della homepage sono definiti in un file JSON:
```
/config/local/<nome progetto>/database/content/pages/1.json
```

Questo file contiene una struttura che definisce i blocchi di contenuto della homepage:

```json
{
    "id": "1",
    "title": {
        "it": "il progetto - Promozione della <slogan> per le gestanti"
    },
    "slug": "home",
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "ui::components.blocks.hero.simple",
                    "title": "Benvenuta su <slogan>,",
                    "subtitle": "...",
                    "image": "/img/hero-bg.jpg",
                    "cta_text": "INIZIA ORA",
                    "cta_link": "{{ route('register') }}"
                }
            },
            // Altri blocchi di contenuto...
        ]
    }
}
```

Ogni blocco di contenuto ha:
- Un `type` che definisce il tipo di blocco (hero, paragraph, feature_sections, ecc.)
- Un oggetto `data` che contiene i dati specifici per quel tipo di blocco
- Opzionalmente, un campo `view` che specifica il componente Blade da utilizzare per renderizzare il blocco

## Flusso di Rendering

Il processo di rendering della homepage segue questi passaggi:

1. **Richiesta HTTP**: L'utente richiede la homepage (`/`)
2. **Routing Folio**: Laravel Folio gestisce la richiesta e identifica `index.blade.php` come il template da utilizzare
3. **Inizializzazione del Template**: Il template viene caricato e il componente Volt viene inizializzato
4. **Caricamento del Layout**: Il layout `x-layouts.marketing` viene caricato
5. **Caricamento dei Contenuti**: Il metodo `$_theme->showPageContent('home')` viene chiamato
6. **Recupero della Pagina**: Il `ThemeComposer` recupera la pagina con slug 'home' dal database o dal file JSON
7. **Rendering dei Blocchi**: Il componente `Blocks` itera attraverso i blocchi di contenuto e li renderizza
8. **Output HTML**: L'HTML risultante viene restituito al browser

## Componenti Principali

### ThemeComposer

Il `ThemeComposer` è una classe che fornisce metodi per interagire con i contenuti delle pagine:

```php
// Modules/Cms/app/View/Composers/ThemeComposer.php
public function showPageContent(string $slug): Renderable
{
    // Recupera la pagina dal database o crea una nuova se non esiste
    $page = Page::firstOrCreate(['slug' => $slug], ['title' => $slug, 'content_blocks' => []]);
    
    // Ottiene i blocchi di contenuto
    $blocks = $page->content_blocks;
    
    // Crea un'istanza del componente Blocks per renderizzare i blocchi
    $page = new \Modules\UI\View\Components\Render\Blocks(blocks: $blocks, model: $page);
    
    // Renderizza i blocchi
    return $page->render();
}
```

Questo metodo è responsabile di:
1. Recuperare la pagina con lo slug specificato
2. Estrarre i blocchi di contenuto dalla pagina
3. Creare un'istanza del componente `Blocks` per renderizzare i blocchi
4. Restituire il risultato renderizzato

### Componente Blocks

Il componente `Blocks` è responsabile di renderizzare i blocchi di contenuto:

```php
// Modules/UI/app/View/Components/Render/Blocks.php
public function render(): Renderable
{
    // Ottiene la vista da utilizzare
    $view = app(GetViewAction::class)->execute($this->tpl);
    
    // Prepara i parametri da passare alla vista
    $view_params = [
        'view' => $view,
        'blocks' => $this->blocks,
        'model' => $this->model,
    ];
    
    // Renderizza la vista
    return view($view, $view_params);
}
```

Questo componente:
1. Determina quale vista utilizzare in base al template specificato
2. Passa i blocchi di contenuto e il modello alla vista
3. Renderizza la vista e restituisce il risultato

## Personalizzazione

Per personalizzare la homepage, ci sono due approcci principali:

### 1. Modificare i Contenuti

Per modificare i contenuti della homepage, è sufficiente modificare il file JSON:
```
/config/local/<nome progetto>/database/content/pages/1.json
```

È possibile:
- Modificare i testi, le immagini e altri dati nei blocchi esistenti
- Aggiungere nuovi blocchi di contenuto
- Riordinare i blocchi esistenti
- Rimuovere blocchi non necessari

### 2. Modificare il Template

Per modificare la struttura o il comportamento della homepage:

1. **Modificare il Layout**: Aggiornare il layout `x-layouts.marketing` per cambiare la struttura generale
2. **Modificare i Componenti**: Aggiornare i componenti utilizzati dai blocchi di contenuto
3. **Aggiungere Nuovi Tipi di Blocchi**: Creare nuovi componenti e aggiungerli al sistema

## Best Practices

1. **Separazione dei Contenuti**: Mantenere i contenuti separati dal codice per facilitare le modifiche
2. **Riutilizzo dei Componenti**: Utilizzare componenti esistenti quando possibile
3. **Internazionalizzazione**: Utilizzare la struttura multilingua fornita dal sistema
4. **Testing**: Testare la homepage con diversi dispositivi e dimensioni dello schermo
5. **Performance**: Ottimizzare le immagini e minimizzare il JavaScript
6. **Accessibilità**: Assicurarsi che la homepage sia accessibile a tutti gli utenti

## Conclusione

L'architettura della homepage è progettata per essere flessibile, manutenibile e facile da personalizzare. Separando i contenuti dal codice e utilizzando componenti modulari, è possibile apportare modifiche in modo rapido e sicuro senza influenzare altre parti del sistema.
