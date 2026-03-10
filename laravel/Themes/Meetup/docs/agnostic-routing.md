# Routing Dinamico Agnostico - Meetup Theme

## Panoramica

Il tema Meetup utilizza un **routing dinamico agnostico** basato su Folio, dove il file `[container0]/[slug0]/index.blade.php` funge esclusivamente da router senza logica di business.

## Architettura

### File di Routing (Agnostico)

**Percorso**: `resources/views/pages/[container0]/[slug0]/index.blade.php`

```php
<?php
declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('container0.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    // ✅ Volt auto-inietta i parametri della route!
    public string $container0 = '';
    public string $slug0 = '';
    public array $data = [];
    public string $pageSlug = '';
    
    // ✅ mount() prepara lo slug della pagina e i dati
    public function mount(): void
    {
        // Lo slug per il JSON del dettaglio è 'container0.view' (es. events.view)
        $this->pageSlug = $this->container0 . '.view';
        
        // Passa container0 e slug0 ai componenti inclusi
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
        <x-page side="content" :slug="$pageSlug" :data="$data" />
    </div>
    @endvolt
</x-layouts.app>
```

**Principio**: Il router NON contiene logica specifica per nessun modello.

Questo vale anche per il tracking notifiche:
- il tema non deve esporre o governare endpoint di tracking email/notifiche;
- open/click tracking appartiene al dominio Notify, non ai file Folio o Blade del tema;
- se serve un endpoint, deve essere solo un transport sottile che delega subito ad action del modulo.

**Vantaggi**: 
- Volt auto-inietta i parametri della route (`container0`, `slug0`) nelle proprietà pubbliche
- `mount()` prepara `$pageSlug` con il template corretto (`container0.view`)
- `<x-page>` è il componente CMS che gestisce il rendering della pagina

### ⚠️ ANTI-PATTERN: MAI mettere logica nel Router

**SBAGLIATO** - Non mettere mai metodi `resolveContent()` o `loadDynamicModel()` nel file `[container0]/[slug0]/index.blade.php`:

```php
// ❌ ERRORE GRAVE - MAI FARE QUESTO
new class extends Component {
    public string $container0;
    public string $slug0;
    public ?object $item = null;
    
    // ❌ mount() con request()->route() NON è necessario!
    // ✅ Volt gestisce automaticamente l'iniezione dei parametri route grazie all'integrazione con Laravel Folio
    public function mount(): void
    {
        $this->container0 = request()->route('container0') ?? '';  // ❌ SBAGLIATO - Volt gestisce automaticamente i parametri
        $this->slug0 = request()->route('slug0') ?? '';  // ❌ SBAGLIATO - Volt gestisce automaticamente i parametri
        $this->resolveContent();  // ❌ VIOLA il principio agnostico
    }
    
    // ❌ MAI - Questo va nel Content Resolver, non nel Router!
    private function resolveContent(): void { ... }
    
    // ❌ MAI - Mapping dei modelli nel router!
    private function loadDynamicModel(): ?object { ... }
};
```

**Perché è sbagliato:**
1. **Violazione Separation of Concerns**: Il router conosce troppi dettagli
2. **Non riutilizzabile**: Aggiungere un nuovo container richiede modificare il router
3. **Difficile da testare**: Non si può testare la logica isolatamente
4. **Accoppiamento stretto**: Il router è accoppiato a specifici modelli

**CORRETTO** - Il router deve essere completamente agnostico (vedi esempio sopra).

### Content Resolver

**Percorso**: `resources/views/components/blocks/content-resolver.blade.php`

Questo blocco contiene tutta la logica di risoluzione dei contenuti:

- Rileva il tipo di container (`events`, `blog`, `pages`, etc.)
- Carica il modello appropriato
- Renderizza il blocco corretto
- Fallback al CMS se nessun contenuto trovato

## Container Supportati

| Container | Modello | View | Descrizione |
|-----------|---------|------|-------------|
| `events` | `Event` | `blocks.events.detail` | Dettaglio evento |
| `blog` | `Post` | `blocks.blog.detail` | Dettaglio post blog |
| `pages` | `Page` | `blocks.page.detail` | Pagina CMS custom |

## Naming Convention

Seguiamo la convenzione Laravel `resource.action`:

| File | Route Name | Azione |
|------|------------|--------|
| `[container0]/index.blade.php` | `name('container0')` | Lista/index del container |
| `[container0]/[slug0]/index.blade.php` | `name('container0.view')` | Dettaglio/visualizzazione item |

### Perché `container0.view`?

- `container0` = risorsa padre (events, blog, pages)
- `view` = azione di visualizzazione dettaglio

Questo segue lo stile RESTful di Laravel: `posts.index`, `posts.show`, `posts.create`, etc.

```
/it/{container0}              → [container0]/index.blade.php (lista)
/it/{container0}/{slug0}      → [container0]/[slug0]/index.blade.php (dettaglio)
```

### Esempi

| URL | Container | Slug | Risultato |
|-----|-----------|------|-----------|
| `/it/events` | events | - | Lista eventi |
| `/it/events/laravel-pizza` | events | laravel-pizza | Dettaglio evento |
| `/it/blog/my-post` | blog | my-post | Dettaglio blog post |

## Vantaggi dell'Approccio Agnostico

1. **Separation of Concerns**: Router separato dalla logica
2. **DRY**: Un solo file di routing per tutti i container
3. **Testabilità**: Content resolver testabile isolatamente
4. **Estensibilità**: Aggiungere nuovi container senza toccare il router
5. **Manutenibilità**: Cambiamenti centralizzati

## Aggiungere un Nuovo Container

Per aggiungere supporto per un nuovo tipo di contenuto (es. `products`):

1. **Aggiungere logica nel Content Resolver**:
```php
elseif ($container0 === 'products' && !empty($slug0)) {
    $content = \Modules\Shop\Models\Product::where('slug', $slug0)->first();
    $contentType = 'product';
    $view = 'blocks.products.detail';
}
```

2. **Creare il blocco di dettaglio**:
```
resources/views/components/blocks/products/detail.blade.php
```

3. **Nessuna modifica al router necessaria!**

## Collegamenti

- [Documentazione CMS Routing](../../../../../modules/cms/docs/folio_routing_system.md)
- [Pattern Container0/Slug0 - Memory di Sistema](../../../../../.cursor/memories/)
- [Folio Volt Structure](../folio-volt-structure.md)

---
**Ultimo aggiornamento**: Feb 2026
