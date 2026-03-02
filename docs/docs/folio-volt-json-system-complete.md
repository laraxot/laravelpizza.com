# Sistema Completo Folio + Volt + JSON

**Status**: ✅ Documentazione Critica Completa
**Scopo**: Documentazione completa del sistema Folio + Volt + JSON per pagine dinamiche

---

## 🎯 Architettura Completa

### Pattern Obbligatorio Frontoffice

```
Request → Folio (routing) → Blade Page → Volt Component → Action → Service/Model
```

---

## 📄 Struttura File Folio + Volt

### File: `Themes/Meetup/resources/views/pages/[slug].blade.php`

**Questo file è il CATCH-ALL per tutte le pagine dinamiche.**

```php
<?php
declare(strict_types=1);
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('pages.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $slug;
};
?>

<x-layouts.app>
    @volt('pages.view')
        <div>
            <x-page side="content" :slug="$slug" />
        </div>
    @endvolt
</x-layouts.app>
```

**Spiegazione**:
1. **`name('pages.view')`**: Nome della route Folio
2. **`middleware(PageSlugMiddleware::class)`**: Middleware che estrae lo slug dalla route
3. **`new class extends Component`**: Componente Volt anonimo
4. **`public string $slug`**: Proprietà che riceve lo slug dal middleware
5. **`@volt('pages.view')`**: Direttiva Volt per interattività Livewire
6. **`<x-page side="content" :slug="$slug" />`**: Componente che legge il JSON

---

## 🔄 Flusso Completo Request → Response

### Esempio: `/it/home`

```
1. HTTP Request: GET /it/home
   ↓
2. Folio Routing: Folio cerca file che matcha la route
   - Cerca: pages/home.blade.php (NON esiste)
   - Cerca: pages/[slug].blade.php (ESISTE - match!)
   ↓
3. Folio Page: [slug].blade.php viene renderizzato
   - name('pages.view') → route name
   - middleware(PageSlugMiddleware::class) → estrae slug="home"
   ↓
4. PageSlugMiddleware: Estrae slug dalla route
   - Route parameter: {slug} = "home"
   - Passa $slug al componente Volt
   ↓
5. Volt Component: pages.view viene eseguito
   - $slug = "home" (da route parameter)
   ↓
6. Page Component: <x-page side="content" slug="home" />
   ↓
7. Component Constructor: Page::__construct('content', 'home')
   ↓
8. Model Lookup: PageModel::firstWhere('slug', 'home')
   ↓
9. SushiToJsons Trait: getSushiRows()
   - Carica tutti i JSON da: config/local/laravelpizza/database/content/pages/*.json
   - Crea "database virtuale" con tutti i JSON
   ↓
10. JSON Loading: Trova home.json
    - Legge: config/local/laravelpizza/database/content/pages/home.json
    - Crea model instance con dati dal JSON
   ↓
11. Content Blocks Extraction:
    $page->content_blocks.it[] viene estratto
    [
        {
            type: "hero",
            slug: "hero-section",
            data: {
                view: "pub_theme::components.blocks.hero.main",
                title: "Laravel Developers. Pizza. Community.",
                ...
            }
        },
        {
            type: "features",
            slug: "features-grid",
            data: {
                view: "pub_theme::components.blocks.features.grid",
                ...
            }
        }
    ]
   ↓
12. Block Processing: BlockData::collect($blocks)
    - Processa ogni blocco
    - Estrae data.view per ogni blocco
    - Valida che la view esista
   ↓
13. Block Rendering: Ogni blocco renderizza componente Blade
    - hero.main → pub_theme::components.blocks.hero.main
      - Riceve $data con title, subtitle, cta_primary, ecc.
      - Renderizza HTML hero section
    - features.grid → pub_theme::components.blocks.features.grid
      - Riceve $data con title, features array
      - Renderizza HTML features grid
   ↓
14. Layout: x-layouts.app
    - Header: x-sections.header
    - Content: Tutti i blocchi renderizzati
    - Footer: x-sections.footer
   ↓
15. Response: HTML completo renderizzato
```

---

## 📁 Struttura JSON

### File: `config/local/laravelpizza/database/content/pages/home.json`

```json
{
    "id": "1",
    "title": {
        "it": "Laravel Pizza Meetups - Home"
    },
    "slug": "home",
    "middleware": null,
    "content": null,
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "slug": "hero-section",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Laravel Developers. Pizza. Community.",
                    "subtitle": "Join fellow Laravel, Filament, and Livewire enthusiasts for pizza meetups.",
                    "description": "Share knowledge, build connections, and enjoy great food together.",
                    "background_image": "/images/hero-bg.jpg",
                    "cta_primary": {
                        "label": "Join the Community",
                        "url": "/auth/register",
                        "style": "primary"
                    },
                    "cta_secondary": {
                        "label": "View Events",
                        "url": "/events",
                        "style": "secondary"
                    }
                }
            },
            {
                "type": "features",
                "slug": "features-grid",
                "data": {
                    "view": "pub_theme::components.blocks.features.grid",
                    "title": "Why Join Our Community?",
                    "description": "More than just pizza - it's about building lasting connections...",
                    "features": [
                        {
                            "icon": "heroicon-o-calendar",
                            "title": "Regular Meetups",
                            "description": "Join weekly pizza meetups with Laravel developers in your area",
                            "color": "red"
                        }
                    ]
                }
            }
        ]
    },
    "sidebar_blocks": {
        "it": []
    },
    "footer_blocks": {
        "it": []
    }
}
```

---

## 🎨 Frontend Asset Management

### Workflow CSS/JS

**Directory**: `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup`

**Comandi Obbligatori**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup

# Prima volta o dopo modifiche package.json
npm install

# Dopo modifiche CSS/JS (OBBLIGATORIO)
npm run build      # Compila CSS/JS (Vite + Tailwind)
npm run copy       # Copia asset in public_html/themes/Meetup/
```

**Perché**:
1. **Vite Compilation**: I file source devono essere compilati
2. **Asset Distribution**: Gli asset devono essere copiati in `public_html/` per essere accessibili via web
3. **Senza build e copy**: Le modifiche NON sono visibili nel browser

---

## 🔍 Componenti Chiave

### 1. PageSlugMiddleware

**File**: `Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php`

**Funzione**: Estrae lo slug dalla route e lo passa al componente Volt.

### 2. Page Component

**File**: `Modules/Cms/app/View/Components/Page.php`

**Funzione**:
- Riceve `side` (content/sidebar/footer) e `slug`
- Cerca `PageModel::firstWhere('slug', $slug)`
- Estrae `content_blocks.it[]` o `sidebar_blocks.it[]` o `footer_blocks.it[]`
- Processa blocchi con `BlockData::collect()`

### 3. SushiToJsons Trait

**File**: `Modules/Tenant/app/Models/Traits/SushiToJsons.php`

**Funzione**:
- Carica tutti i JSON da `config/local/laravelpizza/database/content/pages/*.json`
- Crea "database virtuale" usando libreria Sushi
- Permette query Eloquent standard su dati JSON

### 4. BlockData Class

**File**: `Modules/Cms/app/Datas/BlockData.php`

**Funzione**:
- Processa array di blocchi
- Estrae `data.view` per ogni blocco
- Valida che la view esista
- Renderizza componente Blade passando `$data`

---

## 📚 Riferimenti

- [Folio Pages JSON Only Rule](./folio-pages-json-only-rule.md)
- [System Architecture Complete](./system-architecture-complete.md)
- [LaravelPizza.com Conversion Architecture](./laravelpizza-com-conversion-architecture.md)
- [Development Workflow CSS/JS](./development-workflow-css-js-changes.md)

---

**Ultimo aggiornamento**: [DATE]
**Versione**: 1.0.0
**Status**: ✅ Documentazione Critica Completa
