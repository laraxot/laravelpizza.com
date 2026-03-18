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
    public string $tpl = 'v1';

    public function __construct(string $slug, ?string $tpl = null)
    {
        $this->slug = $slug;
        if (is_string($tpl)) {
            $this->tpl = $tpl;
        }
    }

    public function render()
    {
        return view('pub_theme::components.sections.'.$this->slug.'.'.$this->tpl, [
            'blocks' => SectionModel::getBlocksBySlug($this->slug),
        ]);
    }
}
```

## Contratto runtime reale

Con il contratto attuale del componente, questa chiamata:

```blade
<x-section slug="header" />
```

non cerca `components/sections/header.blade.php`, ma:

```text
pub_theme::components.sections.header.v1
```

Quindi ogni tema che usa `<x-section slug="..."/>` deve fornire almeno:

- `resources/views/components/sections/header/v1.blade.php`
- `resources/views/components/sections/footer/v1.blade.php`

oppure deve passare un `tpl` esplicito compatibile.

Questo e' un vincolo importante: se il tema ha solo `header.blade.php` o `footer.blade.php`, la pagina va in `500` con `View [components.sections.<slug>.v1] not found`.

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
- [Documentazione Blocchi](../blocks/readme.md)
- [Gestione Sezioni](../section-management.md)
- [Documentazione Root](../../../../../docs/components.md)
