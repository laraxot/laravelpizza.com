# Section Component

## Panoramica
Il componente `Section` è un componente Blade che permette di renderizzare sezioni riutilizzabili del sito, come header, footer, sidebar, etc.

## Implementazione

### Componente PHP
```php
namespace Modules\Cms\View\Components;

class Section extends Component
{
    public string $slug;
    public ?string $view = null;
    public array $data = [];

    public function __construct(string $slug, ?string $view = null, array $data = [])
    {
        $this->slug = $slug;
        $this->view = $view;
        $this->data = $data;
    }

    public function render()
    {
        $section = SectionModel::where('slug', $this->slug)->first();
        // ...
    }
}
```

### View di Default
```blade
<section @class([
    'section',
    $section->slug,
    $data['class'] ?? '',
])>
    @foreach($blocks as $block)
        @includeFirst([
            "cms::blocks.{$block['type']}.{$section->slug}",
            "cms::blocks.{$block['type']}.default",
            "cms::blocks.{$block['type']}"
        ], [
            'data' => $block['data'],
            'section' => $section,
            'extraData' => $data
        ])
    @endforeach
</section>
```

## Utilizzo

### Base
```blade
<x-cms::section slug="main-header" />
```

### Con Classe CSS
```blade
<x-cms::section 
    slug="main-header" 
    :data="['class' => 'bg-primary']"
/>
```

### Con View Personalizzata
```blade
<x-cms::section 
    slug="main-header"
    view="themes.custom.header"
    :data="['theme' => 'dark']"
/>
```

## Ricerca dei Template dei Blocchi

Il componente cerca i template dei blocchi nel seguente ordine:
1. `blocks/{type}/{section-slug}.blade.php`
2. `blocks/{type}/default.blade.php`
3. `blocks/{type}.blade.php`

Questo permette:
- Template specifici per sezione
- Template di default per tipo
- Template base come fallback

## Dati Disponibili nelle View

### Variabili Base
- `$section`: Modello Section completo
- `$blocks`: Array dei blocchi tradotti
- `$data`: Dati extra passati al componente

### Nei Template dei Blocchi
- `$data`: Dati specifici del blocco
- `$section`: Riferimento alla sezione
- `$extraData`: Dati extra dal componente

## Best Practices

### 1. Organizzazione Template
- Template specifici in `blocks/{type}/{section-slug}.blade.php`
- Template di default in `blocks/{type}/default.blade.php`
- Template base in `blocks/{type}.blade.php`

### 2. Dati Extra
- Usare `$data` per configurazione blocchi
- Usare `$extraData` per dati di contesto
- Mantenere coerenza nei nomi

### 3. Styling
- Classi base dal componente
- Classi specifiche via `$data['class']`
- Stili specifici per sezione via slug

## Collegamenti
- [Documentazione Blocchi](../blocks/README.md)
- [Gestione Sezioni](../section-management.md)
- [Documentazione Root](../../../../docs/components.md) 
