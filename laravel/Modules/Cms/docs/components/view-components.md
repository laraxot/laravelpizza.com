# View Components

## Panoramica
I View Components nel modulo Cms forniscono componenti riutilizzabili per la costruzione dell'interfaccia utente. Questi componenti sono progettati per essere modulari, configurabili e facilmente estendibili.

## Tipi di Componenti

### 1. Layout Components
- **AppLayout**: Layout principale dell'applicazione
- **GuestLayout**: Layout per utenti non autenticati

### 2. Section Components
Il componente `Section` gestisce sezioni riutilizzabili del sito:

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
        $section = \Modules\Cms\Models\Section::where('slug', $this->slug)->first();
        
        if (!$section) {
            return '';
        }

        $view = $this->view ?? 'cms::components.section';
        return view($view, [
            'section' => $section,
            'data' => $this->data
        ]);
    }
}
```

### Utilizzo
```blade
<x-cms::section 
    slug="main-header"
    :data="['showLogo' => true]"
/>
```

## Struttura delle View

### 1. View di Default
```blade
{{-- resources/views/components/section.blade.php --}}
<section class="section {{ $section->slug }}">
    @foreach($section->getTranslation('blocks', app()->getLocale()) as $block)
        @include("cms::blocks.{$block['type']}", ['data' => $block['data']])
    @endforeach
</section>
```

### 2. View Personalizzate
```blade
{{-- custom-header.blade.php --}}
<x-cms::section 
    slug="main-header"
    view="themes.custom.header"
    :data="['theme' => 'dark']"
/>
```

## Best Practices

### 1. Naming
- Nomi descrittivi e semantici
- Prefisso del modulo (cms::)
- Suffissi appropriati

### 2. Struttura
- Componenti atomici
- Configurazione flessibile
- Riutilizzabilità

### 3. View
- Template puliti e leggibili
- Supporto multilingua
- Personalizzazione tramite slot

## Integrazione con Filament

### 1. Resources
- Gestione tramite SectionResource
- Builder per i blocchi
- Preview in tempo reale

### 2. Rendering
- Caching appropriato
- Lazy loading quando necessario
- Ottimizzazione performance

## Collegamenti
- [Gestione Sezioni](../section-management.md)
- [Documentazione Blocchi](../blocks/README.md)
- [Documentazione Root](../../../../docs/components.md) 
