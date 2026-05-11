# Page Component Architecture - Cms Module

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** ✅ **Documented**
**Priority:** 🔴 **Critical Architecture**

---

## 🎯 Scopo

Questo documento spiega l'architettura del componente `Page` nel modulo Cms e come i temi devono (o non devono) overridearlo.

---

## 📐 Component Architecture

### File Structure

```
laravel/Modules/Cms/
├── app/View/Components/
│   └── Page.php              ← Logica PHP (Data Access Layer)
├── resources/views/components/
│   └── page.blade.php        ← View minimale (renderizza blocchi)
└── app/Models/
    └── Page.php              ← Model con getBlocksBySlug()

laravel/Themes/Sixteen/
├── resources/views/components/
│   └── page.blade.php        ← ⚠️ OVERRIDE DEL TEMA (sbagliato!)
└── resources/views/pages/tests/
    └── [slug].blade.php      ← Folio route
```

---

## 🔧 Componente PHP: `Modules/Cms/app/View/Components/Page.php`

### Responsabilità

Il componente PHP gestisce:
1. **Input**: `$slug`, `$side`, `$data`
2. **Data Access**: `PageModel::getBlocksBySlug($slug, $side)`
3. **JSON Loading**: Carica blocchi da `config/local/{tenant}/database/content/pages/`
4. **Rendering**: Chiama la view `cms::components.page`

### Codice Chiave

```php
final class Page extends Component
{
    public string $side;
    public string $slug;
    public DataCollection|array $blocks;
    public array $data = [];

    public function __construct(
        array $data = [],
        string $side = 'content',
        ?string $slug = null,
        ?string $type = null,
    ) {
        $this->side = $side;
        $this->data = $data;
        
        // Resolve slug
        if ($slug === null && isset($data['slug'])) {
            $slug = (string) $data['slug'];
        }
        $this->slug = $slug ?? '';
        
        if ($type !== null) {
            $this->slug = $type.'-'.$this->slug;
        }

        // Load blocks from JSON/DB
        $this->blocks = PageModel::getBlocksBySlug($this->slug, $this->side);
    }

    public function render(): ViewContract
    {
        return view('cms::components.page', [
            'blocks' => $this->blocks,
            'side' => $this->side,
            'slug' => $this->slug,
            'data' => $this->data,
        ]);
    }
}
```

---

## 🎨 View Originale: `Modules/Cms/resources/views/components/page.blade.php`

### Blade Minimale (CORRETTA)

```blade
{{-- Page Component --}}
@props([
    'blocks' => [],
    'side' => 'content',
    'slug' => '',
    'page' => null,
    'data' => [],
])

@if(!empty($blocks))
    <div class="page-{{ $side }}-content" data-slug="{{ $slug }}" data-side="{{ $side }}">
        @foreach($blocks as $block)
            {{-- BlockData ha già gestito tutto: vista, dati, fallback --}}
            @include($block->view, array_merge($data, $block->data))
        @endforeach
    </div>
@endif
```

### Perché è Minimale?

- ✅ **Nessuna logica PHP** - Tutta la logica è nel componente PHP
- ✅ **Solo rendering** - Loop sui blocchi e include view
- ✅ **BlockData** - Ogni blocco ha già `view` e `data` risolti
- ✅ **DRY** - Non duplica la logica di caricamento JSON

---

## ⚠️ Problema: Override nel Tema

### Errore Comune

Creare `Themes/Sixteen/resources/views/components/page.blade.php` con logica PHP duplicata:

```blade
{{-- SBAGLIATO: Themes/Sixteen/resources/views/components/page.blade.php --}}
@php
    // Logica DUPLICATA che dovrebbe essere nel PHP component
    $configPath = base_path('config/local/fixcity/database/content/pages/'.$slug.'.json');
    if (file_exists($configPath)) {
        $pageData = json_decode(file_get_contents($configPath), true);
        $blocks = $pageData['content_blocks']['it'] ?? [];
    }
@endphp

<div class="page-content">
    @foreach($blocks as $block)
        @includeIf($block['data']['view'], ['data' => $block['data']])
    @endforeach
</div>
```

**Problemi:**
1. ❌ **Duplicazione logica** - Stessa logica nel PHP e nella blade
2. ❌ **Incoerenza** - Quale usare? PHP o blade?
3. ❌ **Manutenzione** - Cambiamenti in due posti
4. ❌ **BlockData** - Ignora il sistema BlockData del Cms

---

## ✅ Soluzione: Come Usare il Componente Page

### Nel Tema (Folio Route)

```blade
{{-- Themes/Sixteen/resources/views/pages/tests/[slug].blade.php --}}

<x-layouts.app>
    @volt('tests.view')
        {{-- Usa il componente Cms::Page SENZA override --}}
        <x-cms-page side="content" :slug="$pageSlug" :data="$data" />
    @endvolt
</x-layouts.app>
```

### Namespace

Il componente `Page` è registrato come:
- `x-cms-page` (namespace esplicito)
- O `x-page` se aliasato in `config/view.php`

---

## 🔧 Come Funziona il Caricamento Blocchi

### PageModel::getBlocksBySlug()

```php
// Modules/Cms/app/Models/Page.php

public static function getBlocksBySlug(string $slug, string $side = 'content'): DataCollection
{
    // 1. Carica JSON da config path
    $configPath = config_path("local/{tenant}/database/content/pages/{$slug}.json");
    
    // 2. Parse JSON
    $pageData = json_decode(file_get_contents($configPath), true);
    
    // 3. Estrai blocchi per locale
    $locale = app()->getLocale() ?? 'it';
    $blocksJson = $pageData['content_blocks'][$locale] ?? [];
    
    // 4. Converti in BlockData objects
    $blocks = BlockData::collect($blocksJson);
    
    // 5. Return DataCollection
    return $blocks;
}
```

### BlockData Structure

```php
// Modules/Cms/Datas/BlockData.php

class BlockData extends Data {
    public string $id;
    public string $type;
    public int $weight;
    public bool $active;
    public string $view;        // View path risolto
    public array $data;         // Dati del blocco
    
    // Fallback view se non specificata
    public function getViewAttribute(): string
    {
        return $this->data['view'] 
            ?? 'cms::components.blocks.' . $this->type . '.default';
    }
}
```

---

## 📋 Architectural Layers

```
┌─────────────────────────────────────────────────────────┐
│  Folio Route: pages/tests/[slug].blade.php              │
│  <x-layouts.app>                                        │
│    <x-cms-page side="content" :slug="$pageSlug" />     │
└─────────────────────────────────────────────────────────┘
  │
  ▼
┌─────────────────────────────────────────────────────────┐
│  Cms Component: Modules/Cms/app/View/Components/Page.php│
│  - Constructor: PageModel::getBlocksBySlug()            │
│  - Render: view('cms::components.page')                 │
└─────────────────────────────────────────────────────────┘
  │
  ▼
┌─────────────────────────────────────────────────────────┐
│  Cms View: Modules/Cms/resources/views/components/      │
│  page.blade.php                                         │
│  - Loop: @foreach($blocks as $block)                    │
│  - Include: @include($block->view, $block->data)        │
└─────────────────────────────────────────────────────────┘
  │
  ▼
┌─────────────────────────────────────────────────────────┐
│  Block Views: pub_theme::components.blocks.*            │
│  - Themes/Sixteen/resources/views/components/blocks/    │
│  - Renderizza contenuto specifico del blocco            │
└─────────────────────────────────────────────────────────┘
```

---

## 🚨 Errori da Evitare

### 1. ❌ Duplicare Logica nella Blade del Tema

```blade
{{-- Themes/Sixteen/resources/views/components/page.blade.php --}}
@php
    // SBAGLIATO: Logica già nel componente PHP!
    $configPath = base_path('config/local/fixcity/database/content/pages/'.$slug.'.json');
    $pageData = json_decode(file_get_contents($configPath), true);
    $blocks = $pageData['content_blocks']['it'] ?? [];
@endphp
```

✅ **CORRETTO:** Non creare `page.blade.php` nel tema. Usa il componente Cms.

---

### 2. ❌ Usare Namespace Sbagliato

```blade
<x-sixteen::page />     <!-- SBAGLIATO: namespace non esiste -->
<x-page />              <!-- AMBIGUO: quale Page? -->
<x-cms-page />          <!-- CORRETTO: namespace esplicito -->
```

---

### 3. ❌ Ignorare BlockData

```blade
{{-- SBAGLIATO: tratta blocchi come array semplici --}}
@foreach($blocks as $block)
    @includeIf($block['data']['view'])  <!-- $block è array? NO! -->
@endforeach
```

✅ **CORRETTO:** `$block` è un oggetto `BlockData` con proprietà e metodi

---

## 🔗 Cross-References

### Internal Documents

- → [Layout Architecture](Themes/Sixteen/docs/LAYOUT_ARCHITECTURE_AND_NAMESPACE.md) - Layout hierarchy
- → [Fix Tests Pages](Themes/Sixteen/docs/FIX_TESTS_PAGES_ARCHITECTURE.md) - Troubleshooting
- → [BMad Architecture](_bmad-output/design-comuni-architecture.md) - System design
- → [Block Analysis](_bmad-output/design-comuni-block-analysis.md) - 47 componenti

### Module Documentation

- → [Cms Module Docs](Modules/Cms/docs/README.md) - Cms documentation
- → [BlockData](Modules/Cms/docs/block-data.md) - Block data structure
- → [Page Model](Modules/Cms/docs/page-model.md) - Page model docs

---

## ✅ Best Practices

### Per i Temi

1. ✅ **Non overrideare** `page.blade.php` nel tema
2. ✅ **Usare componente Cms**: `<x-cms-page>`
3. ✅ **Solo blocchi view** nel tema: `components/blocks/*`
4. ✅ **Mantenere separazione**: Cms = logica, Theme = view

### Per Moduli

1. ✅ **Logica nel PHP** component, non nella blade
2. ✅ **Blade minimale** - solo rendering
3. ✅ **BlockData** per struttura blocchi
4. ✅ **Fallback** view se non specificata

---

**📝 Documento preparato da:** Multi-Agent Team (BMad + GSD)
**📅 Data:** 2026-04-01
**🔄 Status:** ✅ **Documented**

🐮 **Architecture Documented - Use x-cms-page!**
