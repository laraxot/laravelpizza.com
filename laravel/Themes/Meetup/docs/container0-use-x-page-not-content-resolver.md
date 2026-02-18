# Container0 Slug0: Usare `<x-page>` NON `<x-blocks.content-resolver>`

## 🎯 Principio: Usare Componente CMS `<x-page>` per Routing Agnostic

**Il file `[container0]/[slug0]/index.blade.php` deve usare `<x-page>` per passare i dati al sistema CMS, NON `<x-blocks.content-resolver>`.**

## ❌ SBAGLIATO: Usare `content-resolver`

**NON fare MAI questo:**

```blade
@volt('container0.view')
<div>
    <!-- ❌ SBAGLIATO: content-resolver contiene logica specifica -->
    <x-blocks.content-resolver :container0="$this->container0" :slug0="$this->slug0" />
</div>
@endvolt
```

**Perché è SBAGLIATO:**

1. **Logica specifica**: `content-resolver` contiene logica per decidere quale componente renderizzare
2. **Violazione Agnosticismo**: Il routing diventa dipendente da logica di business
3. **Duplicazione**: Logica duplicata invece di usare il sistema CMS
4. **Rigidità**: Ogni nuovo contenuto richiede modifiche al resolver

## ✅ CORRETTO: Usare `<x-page>` Component CMS

**Implementazione corretta:**

```php
<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // Volt auto-inietta automaticamente questi parametri dalla route
    public string $container0;
    public string $slug0;
    public array $data = [];
    public string $pageSlug = '';

    public function mount(): void
    {
        // ✅ CORRETTO: Volt ha già popolato $this->container0 e $this->slug0 automaticamente
        // Usiamo questi parametri per costruire lo slug del template JSON
        $this->pageSlug = $this->container0 . '.view';
        
        // Popolare $this->data per passare variabili ai componenti inclusi
        // page-content.blade.php fa: array_merge($block->data, $this->data)
        $this->data = [
            'container0' => $this->container0,
            'slug0' => $this->slug0,
        ];
    }
};

?>

<x-layouts.app>
    @volt('container0.view')
    <div>
        <!-- ✅ CORRETTO: Usare componente CMS <x-page> -->
        <x-page side="content" :slug="$this->pageSlug" :data="$this->data" />
    </div>
    @endvolt
</x-layouts.app>
```

## 📜 Perché `<x-page>` e NON `content-resolver`

### 1. Sistema CMS Gestisce Tutto

Il componente `<x-page>`:
- ✅ Carica il JSON corrispondente allo slug (`events.view.json`)
- ✅ Processa i content blocks dal JSON
- ✅ Include i componenti block specificati nel JSON
- ✅ Passa `$this->data` ai componenti inclusi tramite `array_merge($block->data, $this->data)`

### 2. Agnostic e CMS-Driven

Con `<x-page>`:
- ✅ Il routing è completamente agnostico
- ✅ Il JSON definisce quale componente renderizzare
- ✅ Nessuna logica specifica nel routing
- ✅ Scalabile: nuovi contenuti senza modifiche al routing

Con `content-resolver`:
- ❌ Contiene logica specifica (`if ($container0 === 'events')`)
- ❌ Violazione agnosticismo
- ❌ Rigidità: ogni nuovo contenuto richiede modifiche

### 3. Flusso Completo con `<x-page>`

```
1. URL: /it/events/laravel-beginners-pizza-night
   ↓
2. Volt popola: $this->container0 = 'events', $this->slug0 = 'laravel-beginners-pizza-night'
   ↓
3. mount() calcola: $this->pageSlug = 'events.view'
   ↓
4. mount() popola: $this->data = ['container0' => 'events', 'slug0' => 'laravel-beginners-pizza-night']
   ↓
5. <x-page slug="events.view" :data="$this->data" />
   ↓
6. Page Component carica: events_view.json (slug: events.view)
   ↓
7. Content Blocks: Il JSON definisce quale componente renderizzare
   ↓
8. Block Rendering: page-content.blade.php fa array_merge($block->data, $this->data)
   ↓
9. Component Include: events/detail.blade.php riceve $slug0 tramite $data
   ↓
10. Component carica: Event::where('slug', $slug0)->first()
```

## ✅ Best Practices

1. **Sempre usare `<x-page>`**: Per routing agnostic CMS-driven
2. **NON usare `content-resolver`**: Contiene logica specifica, viola agnosticismo
3. **JSON definisce tutto**: Il JSON (`events.view.json`) definisce quale componente renderizzare
4. **Routing solo dispatcher**: Il routing passa solo parametri, non decide cosa fare

## 🔗 Riferimenti

- [Routing No Business Logic](routing-no-business-logic.md)
- [Container0 Slug0 Agnostic Pattern](container0-slug0-agnostic-pattern.md)
- [Volt Mount vs PHP Block](volt-mount-vs-php-block.md)
- [Volt Data Property Indispensable](volt-data-property-indispensable.md)
