# Tech Stack Frontend - NO Bootstrap

> **Regola permanente**: Non utilizzare Bootstrap. Usare esclusivamente TailwindCSS + Alpine.js + Lit + DaisyUI + Flowbite + Filament.

## Stack Tecnologico Approvato

| Tecnologia | Versione | Uso | URL |
|------------|----------|-----|-----|
| **TailwindCSS** | 3.x+ | Styling utility-first | https://tailwindcss.com/docs |
| **Alpine.js** | 3.x+ | Interattività JS leggera | https://alpinejs.dev/ |
| **Lit** | 2.x+ | Web components (mappe) | https://lit.dev/ |
| **DaisyUI** | 3.x+ | Componenti UI Tailwind | https://daisyui.com/components/ |
| **Flowbite** | 2.x+ | Pattern e componenti | https://flowbite.com/docs/ |
| **Filament** | 3.x+ | Admin/forms/widgets | https://filamentphp.com/docs |

## ❌ Proibito

- Bootstrap CSS (classi `bootstrap-*`, `container`, `row`, `col-*`)
- Bootstrap JS (`data-bs-toggle`, `data-bs-target`, `bootstrap.Modal`, `bootstrap.Tab`)
- Bootstrap Icons (usare solo `it-*` icons da Design Comuni o Lucide)
- jQuery per manipolazione DOM

## ✅ Pattern Alternativi

### Tabs (senza Bootstrap)

```html
<!-- ❌ Bootstrap -->
<ul class="nav nav-tabs" data-bs-toggle="tab">...</ul>

<!-- ✅ Alpine.js + Tailwind -->
<div x-data="{ activeTab: 'map' }" class="flex gap-1 bg-gray-100 p-1 rounded-lg">
    <button @click="activeTab = 'map'" 
            :class="{ 'bg-white shadow': activeTab === 'map' }"
            class="px-4 py-2 rounded transition">
        Mappa
    </button>
    <button @click="activeTab = 'list'"
            :class="{ 'bg-white shadow': activeTab === 'list' }"
            class="px-4 py-2 rounded transition">
        Elenco
    </button>
</div>
```

### Modal (senza Bootstrap)

```html
<!-- ❌ Bootstrap -->
<div class="modal" data-bs-toggle="modal">...</div>

<!-- ✅ DaisyUI + Alpine.js -->
<div x-data="{ open: false }">
    <button @click="open = true" class="btn">Apri</button>
    <dialog :open="open" class="modal" @click.outside="open = false">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Titolo</h3>
            <p class="py-4">Contenuto...</p>
            <div class="modal-action">
                <button @click="open = false" class="btn">Chiudi</button>
            </div>
        </div>
    </dialog>
</div>
```

### Accordion (senza Bootstrap)

```html
<!-- ❌ Bootstrap -->
<div class="accordion" data-bs-toggle="collapse">...</div>

<!-- ✅ Alpine.js + Tailwind -->
<div x-data="{ expanded: false }" class="border rounded-lg">
    <button @click="expanded = !expanded" class="w-full p-4 flex justify-between">
        <span>Titolo</span>
        <span x-show="!expanded">+</span>
        <span x-show="expanded">-</span>
    </button>
    <div x-show="expanded" x-collapse class="p-4 border-t">
        Contenuto espandibile...
    </div>
</div>
```

### Grid Layout (senza Bootstrap)

```html
<!-- ❌ Bootstrap -->
<div class="row">
    <div class="col-lg-3">Sidebar</div>
    <div class="col-lg-9">Main</div>
</div>

<!-- ✅ Tailwind CSS Grid -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <aside class="lg:col-span-3">Sidebar</aside>
    <main class="lg:col-span-9">Main</main>
</div>
```

## Componenti DaisyUI Utili

| Componente | Classe | Use Case |
|------------|--------|----------|
| Button | `btn`, `btn-primary`, `btn-outline` | Azioni, CTA |
| Card | `card`, `card-body`, `card-title` | Ticket cards |
| Checkbox | `checkbox`, `checkbox-primary` | Filtri |
| Badge | `badge`, `badge-primary` | Contatori |
| Alert | `alert`, `alert-info` | Messaggi |
| Modal | `modal`, `modal-box` | Dialog |
| Tabs | `tabs`, `tab`, `tab-active` | Navigazione |
| Input | `input`, `input-bordered` | Form |
| Select | `select`, `select-bordered` | Dropdown |

## Design Comuni Colors (Tailwind Config)

```javascript
// tailwind.config.js
colors: {
    'italia-blue': '#0066CC',
    'italia-blue-dark': '#003D73',
    'primary': '#007A52', // Verde PA
}
```

## Esempi da Flowbite Blocks

```
https://flowbite.com/blocks/

Marketing:
- /marketing/cta/ → cta-sections/
- /marketing/hero/ → hero-sections/
- /marketing/feature/ → feature-sections/
- /marketing/content/ → content-sections/
- /marketing/feedback/ → feedback-sections/

Application UI:
- /application-ui/layout/grid-layouts/ → grid-layouts/
- /application-ui/navigation/vertical-navigation/ → vertical-navigation/
- /application-ui/layout/sidebar-layouts/ → sidebar-layouts/
```

## Collegamenti

- [Naming Convention Cartelle](./BLOCKS-FOLDER-NAMING.md)
- [Design Comuni Reference](https://italia.github.io/design-comuni-pagine-statiche/)
- [Tailwind UI Blocks](https://tailwindcss.com/plus/ui-blocks)
