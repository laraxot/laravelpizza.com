# Architettura Conversione LaravelPizza.com

**Status**: ✅ Documentazione Critica
**Scopo**: Documentare l'architettura di conversione di laravelpizza.com nella struttura base_laravelpizza

---

## 🎯 Obiettivo

**Convertire laravelpizza.com nella struttura base_laravelpizza utilizzando Filament Forms Builder per la gestione dei content blocks.**

Questo progetto è la **conversione fedele** del sito originale laravelpizza.com nella nuova architettura modulare Laraxot.

---

## 🏗️ Architettura del Sistema

### 1. Folio + Volt per Frontoffice

**Pattern Obbligatorio**:
```
Request → Folio (routing) → Blade Page → Volt Component → Action → Service/Model
```

**File**: `Themes/Meetup/resources/views/pages/[slug].blade.php`

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

**Come Funziona**:
1. Folio usa `[slug].blade.php` come **catch-all** per tutte le pagine dinamiche
2. La route `/it/{slug}` viene automaticamente gestita
3. Il middleware `PageSlugMiddleware` estrae lo slug dalla route
4. Il componente Volt `pages.view` passa lo slug al componente `<x-page>`

---

### 2. Sistema JSON-Driven Content

**Pattern**: **Solo JSON, NO Blade Files per pagine dinamiche**

#### ❌ VIETATO
- Creare file Blade `Themes/Meetup/resources/views/pages/{slug}.blade.php` per pagine dinamiche
- Creare rotte in `routes/web.php` o `routes/api.php`
- Creare controller per pagine pubbliche

#### ✅ OBBLIGATORIO
- Creare **SOLO file JSON** in `config/local/laravelpizza/database/content/pages/{slug}.json`
- Il file `[slug].blade.php` già esiste e gestisce automaticamente tutte le pagine dinamiche
- Il componente `<x-page side="content" :slug="$slug" />` legge automaticamente il JSON corrispondente

#### Flusso JSON → Rendering

```
1. Request: /it/home
   ↓
2. Folio: [slug].blade.php (slug = "home")
   ↓
3. Component: <x-page side="content" slug="home" />
   ↓
4. Model: Page::where('slug', 'home')->first()
   ↓
5. Trait: SushiToJsons carica da config/local/laravelpizza/database/content/pages/home.json
   ↓
6. Content Blocks: content_blocks.it[] viene processato
   ↓
7. Rendering: Ogni blocco usa data.view per renderizzare componente Blade
   ↓
8. Output: Pagina renderizzata con tutti i blocchi
```

---

### 3. Content Blocks System

**Struttura JSON**:

```json
{
    "id": "1",
    "title": {
        "it": "Laravel Pizza Meetups - Home"
    },
    "slug": "home",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "slug": "hero-section",
                "data": {
                    "view": "pub_theme::components.blocks.hero.main",
                    "title": "Laravel Developers. Pizza. Community.",
                    "subtitle": "Join fellow Laravel, Filament, and Livewire enthusiasts...",
                    "cta_primary": {
                        "label": "Join the Community",
                        "url": "/auth/register",
                        "style": "primary"
                    }
                }
            },
            {
                "type": "features",
                "slug": "features-grid",
                "data": {
                    "view": "pub_theme::components.blocks.features.grid",
                    "title": "Why Join Our Community?",
                    "features": [...]
                }
            }
        ]
    }
}
```

**Componenti Blade**:
- `pub_theme::components.blocks.hero.main` → `Themes/Meetup/resources/views/components/blocks/hero/main.blade.php`
- `pub_theme::components.blocks.features.grid` → `Themes/Meetup/resources/views/components/blocks/features/grid.blade.php`
- `pub_theme::components.blocks.stats.overview` → `Themes/Meetup/resources/views/components/blocks/stats/overview.blade.php`
- `pub_theme::components.blocks.cta.banner` → `Themes/Meetup/resources/views/components/blocks/cta/banner.blade.php`

---

### 4. Filament Forms Builder Integration

**Gestione Content Blocks via Filament Admin**:

Il sistema utilizza **Filament Forms Builder** per gestire i content blocks:

1. **Admin Panel**: `/admin/appearance/pages/{slug}/edit`
2. **Form Builder**: Drag & drop per aggiungere/modificare blocchi
3. **JSON Generation**: Filament salva automaticamente in `config/local/laravelpizza/database/content/pages/{slug}.json`
4. **Live Preview**: Preview in tempo reale dei blocchi

**Risorse Filament**:
- `Modules/Cms/app/Filament/Resources/PageResource.php` - Gestione pagine
- `Modules/Cms/app/Filament/Resources/PageContentResource.php` - Gestione content blocks
- `Modules/Cms/app/Filament/Clusters/Appearance/` - Cluster per gestione aspetto

---

## 📁 Struttura Directory

### Content JSON Files

```
config/local/laravelpizza/database/content/
├── pages/
│   ├── home.json          ← Homepage
│   ├── contact.json       ← Pagina contatti
│   ├── events.json        ← Pagina eventi
│   └── ...
└── sections/
    ├── header.json        ← Header configurazione
    ├── footer.json        ← Footer configurazione
    └── ...
```

### Theme Components

```
Themes/Meetup/resources/views/
├── pages/
│   └── [slug].blade.php   ← Catch-all Folio (NON modificare per pagine dinamiche)
├── components/
│   ├── layouts/
│   │   ├── app.blade.php  ← Layout completo (header + footer)
│   │   ├── main.blade.php ← Layout base (no header/footer)
│   │   └── guest.blade.php ← Layout auth
│   └── blocks/
│       ├── hero/
│       │   └── main.blade.php
│       ├── features/
│       │   └── grid.blade.php
│       ├── stats/
│       │   └── overview.blade.php
│       └── cta/
│           └── banner.blade.php
```

---

## 🎨 Frontend Asset Management

### Workflow CSS/JS

**Directory**: `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup`

**Comandi Obbligatori**:
```bash
cd /var/www/_bases/base_laravelpizza/laravel/Themes/Meetup
npm install        # Prima volta o dopo modifiche package.json
npm run build      # Compila CSS/JS (Vite + Tailwind)
npm run copy       # Copia asset in public_html/themes/Meetup/
```

**Quando Eseguire**:
- ✅ Dopo modifiche a `resources/css/app.css`
- ✅ Dopo modifiche a `resources/js/app.js`
- ✅ Dopo modifiche a `tailwind.config.js`
- ✅ Prima di testare nel browser (`http://127.0.0.1:8002/it`)
- ✅ Prima di commitare modifiche CSS/JS

**Perché**:
1. **Vite Compilation**: I file source devono essere compilati
2. **Asset Distribution**: Gli asset devono essere copiati in `public_html/` per essere accessibili via web
3. **Senza build e copy**: Le modifiche NON sono visibili nel browser

**Dev Mode** (Hot Reload):
```bash
npm run dev  # Hot reload automatico (NON serve copy)
```

---

## 🔄 Flusso Completo Request → Response

### Esempio: Homepage `/it/home`

```
1. HTTP Request: GET /it/home
   ↓
2. Laravel Routing: Folio registra route da [slug].blade.php
   ↓
3. Middleware: PageSlugMiddleware estrae slug="home"
   ↓
4. Folio Page: [slug].blade.php viene renderizzato
   ↓
5. Volt Component: pages.view viene eseguito
   ↓
6. Page Component: <x-page side="content" slug="home" />
   ↓
7. Model Lookup: Page::where('slug', 'home')->first()
   ↓
8. JSON Loading: SushiToJsons carica config/local/.../pages/home.json
   ↓
9. Content Blocks: content_blocks.it[] viene processato
   ↓
10. Block Rendering: Ogni blocco renderizza componente Blade
    - hero.main → pub_theme::components.blocks.hero.main
    - features.grid → pub_theme::components.blocks.features.grid
    - stats.overview → pub_theme::components.blocks.stats.overview
    - cta.banner → pub_theme::components.blocks.cta.banner
   ↓
11. Layout: x-layouts.app (header + content + footer)
   ↓
12. Response: HTML completo renderizzato
```

---

## 📊 Confronto LaravelPizza.com Originale vs Conversione

### Originale (laravelpizza.com)
- Framework: Next.js / React
- Content: Hardcoded in componenti React
- Styling: CSS Modules / Tailwind
- Routing: Next.js file-based routing

### Conversione (base_laravelpizza)
- Framework: Laravel + Folio + Volt
- Content: JSON-driven (Filament Forms Builder)
- Styling: Tailwind CSS (Vite compilation)
- Routing: Folio file-based routing

### Vantaggi Conversione
1. ✅ **Content Management**: Filament admin per gestire contenuti
2. ✅ **Type Safety**: PHP strict types + PHPStan L10
3. ✅ **Modularità**: Architettura modulare Laraxot
4. ✅ **Riusabilità**: Componenti Blade riusabili
5. ✅ **Multi-tenant**: Supporto multi-tenant integrato
6. ✅ **SEO**: Server-side rendering Laravel

---

## 🎯 Regole Critiche

### 1. Pagine Folio = Solo JSON
- ❌ NON creare file Blade per pagine dinamiche
- ✅ Creare SOLO file JSON in `config/local/.../pages/{slug}.json`

### 2. Frontend Assets
- ❌ NON modificare direttamente file in `public_html/`
- ✅ Modificare `resources/css/app.css` e `resources/js/app.js`
- ✅ Eseguire `npm run build && npm run copy` dopo modifiche

### 3. Layout Hierarchy
- `x-layouts.main` → Shell HTML base (no header/footer), NON usare direttamente
- `x-layouts.app` → Layout completo con header nav + footer (pagina pubblica)
- `x-layouts.guest` → Layout per login/registrazione/password (auth)

### 4. Componenti Blade
- Usare sintassi semplice: `<x-component-name>` (NON `<x-pub_theme::component-name>`)
- Componenti anonimi registrati con namespace non supportano sintassi esplicita

---

## 📚 Riferimenti

- [Folio Pages JSON Only Rule](./folio-pages-json-only-rule.md)
- [Development Workflow CSS/JS](./development-workflow-css-js-changes.md)
- [Content Blocks Architecture](../../Modules/Cms/docs/content-blocks-architecture.md)
- [Filament Forms Builder](https://filamentphp.com/docs/4.x/forms/builder)

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.0
**Status**: ✅ Documentazione Critica
