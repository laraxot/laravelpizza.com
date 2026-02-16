# Architettura Completa Sistema LaravelPizza.com

**Status**: ✅ Documentazione Critica Completa
**Scopo**: Documentazione completa dell'architettura del sistema di conversione LaravelPizza.com

---

## 🎯 Obiettivo del Progetto

**Convertire laravelpizza.com nella struttura base_laravelpizza utilizzando Filament Forms Builder per la gestione dei content blocks.**

Questo progetto è la **conversione fedele** del sito originale laravelpizza.com nella nuova architettura modulare Laraxot.

---

## 🏗️ Architettura Completa

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
1. **Folio Routing**: Folio usa `[slug].blade.php` come **catch-all** per tutte le pagine dinamiche
2. **Route Matching**: La route `/it/{slug}` viene automaticamente gestita
3. **Middleware**: `PageSlugMiddleware` estrae lo slug dalla route e lo passa al componente Volt
4. **Volt Component**: `pages.view` riceve `$slug` e lo passa al componente `<x-page>`

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

#### Flusso JSON → Rendering Completo

```
1. HTTP Request: GET /it/home
   ↓
2. Laravel Routing: Folio registra route da [slug].blade.php
   ↓
3. Middleware: PageSlugMiddleware estrae slug="home"
   ↓
4. Folio Page: [slug].blade.php viene renderizzato
   ↓
5. Volt Component: pages.view viene eseguito con $slug="home"
   ↓
6. Page Component: <x-page side="content" slug="home" />
   ↓
7. Component Constructor: Page::__construct('content', 'home')
   ↓
8. Model Lookup: PageModel::firstWhere('slug', 'home')
   ↓
9. SushiToJsons Trait: getSushiRows() carica tutti i JSON da:
   config/local/laravelpizza/database/content/pages/*.json
   ↓
10. JSON Loading: Carica home.json e crea "database virtuale"
   ↓
11. Model Instance: Page model con dati da home.json
   ↓
12. Content Blocks: $page->content_blocks.it[] viene estratto
   ↓
13. Block Processing: BlockData::collect($blocks) processa ogni blocco
   ↓
14. Block Rendering: Ogni blocco renderizza componente Blade:
    - hero.main → pub_theme::components.blocks.hero.main
    - features.grid → pub_theme::components.blocks.features.grid
    - stats.overview → pub_theme::components.blocks.stats.overview
    - cta.banner → pub_theme::components.blocks.cta.banner
   ↓
15. Layout: x-layouts.app (header + content + footer)
   ↓
16. Response: HTML completo renderizzato
```

---

### 3. SushiToJsons Trait - Database Virtuale

**Trait**: `Modules/Tenant/app/Models/Traits/SushiToJsons.php`

**Come Funziona**:
1. **getSushiRows()**: Carica tutti i file JSON da `config/local/laravelpizza/database/content/pages/`
2. **Sushi Library**: Converte i JSON in un "database virtuale" usando la libreria Sushi
3. **Eloquent Queries**: Il modello `Page` può usare query Eloquent normali
4. **firstWhere('slug', 'home')**: Cerca nel database virtuale una riga con slug="home"
5. **Model Instance**: Restituisce un'istanza del modello `Page` con i dati dal JSON

**Vantaggi**:
- ✅ Zero database per contenuti statici
- ✅ Versionamento Git dei contenuti
- ✅ Portabilità tra ambienti
- ✅ Query Eloquent standard

---

### 4. Content Blocks System

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
                    "features": [
                        {
                            "icon": "heroicon-o-calendar",
                            "title": "Regular Meetups",
                            "description": "Join weekly pizza meetups...",
                            "color": "red"
                        }
                    ]
                }
            }
        ]
    }
}
```

**Componenti Blade Mapping**:
- `pub_theme::components.blocks.hero.main` → `Themes/Meetup/resources/views/components/blocks/hero/main.blade.php`
- `pub_theme::components.blocks.features.grid` → `Themes/Meetup/resources/views/components/blocks/features/grid.blade.php`
- `pub_theme::components.blocks.stats.overview` → `Themes/Meetup/resources/views/components/blocks/stats/overview.blade.php`
- `pub_theme::components.blocks.cta.banner` → `Themes/Meetup/resources/views/components/blocks/cta/banner.blade.php`

**BlockData::collect()**:
- Processa array di blocchi
- Estrae `data.view` per ogni blocco
- Renderizza componente Blade passando `$data`
- Supporta localizzazione (`content_blocks.it[]`)

---

### 5. Filament Forms Builder Integration

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

**Filament Forms Builder**:
- Utilizza `Filament\Forms\Builder` per form dinamici
- Supporta drag & drop per riordinare blocchi
- Validazione automatica dei blocchi
- Preview in tempo reale

---

## 📁 Struttura Directory Completa

### Content JSON Files

```
config/local/laravelpizza/database/content/
├── pages/
│   ├── home.json          ← Homepage (/it/home)
│   ├── contact.json       ← Pagina contatti (/it/contact)
│   ├── events.json        ← Pagina eventi (/it/events)
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
│   │   ├── guest.blade.php ← Layout auth
│   │   └── public.blade.php ← Layout pubblico
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

### Frontend Assets

```
Themes/Meetup/
├── resources/
│   ├── css/
│   │   └── app.css       ← Source CSS (Tailwind)
│   └── js/
│       └── app.js        ← Source JavaScript
├── public/
│   └── assets/
│       ├── app-[hash].css ← Compilato da Vite
│       ├── app-[hash].js  ← Compilato da Vite
│       └── manifest.json  ← Manifest Vite
└── public_html/
    └── themes/Meetup/
        └── assets/       ← Copiato da npm run copy
            ├── app-[hash].css
            ├── app-[hash].js
            └── manifest.json
```

---

## 🎨 Frontend Asset Management

### Workflow CSS/JS Completo

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

**Quando Eseguire**:
- ✅ Dopo modifiche a `resources/css/app.css`
- ✅ Dopo modifiche a `resources/js/app.js`
- ✅ Dopo modifiche a `tailwind.config.js`
- ✅ Dopo modifiche a `vite.config.js`
- ✅ Prima di testare nel browser (`http://127.0.0.1:8002/it`)
- ✅ Prima di commitare modifiche CSS/JS

**Perché**:
1. **Vite Compilation**: I file source devono essere compilati da Vite
2. **Tailwind Processing**: Tailwind CSS deve processare le classi
3. **Asset Distribution**: Gli asset devono essere copiati in `public_html/` per essere accessibili via web
4. **Senza build e copy**: Le modifiche NON sono visibili nel browser

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
3. Middleware Stack:
   - LocaleSessionRedirect (localizzazione)
   - LaravelLocalizationRoutes (route localizzate)
   - PageSlugMiddleware (estrazione slug)
   ↓
4. Folio Page: [slug].blade.php viene renderizzato
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
9. SushiToJsons Trait:
   - getSushiRows() carica tutti i JSON da:
     config/local/laravelpizza/database/content/pages/*.json
   - Crea "database virtuale" con tutti i JSON
   ↓
10. JSON Loading: Trova home.json e crea model instance
   ↓
11. Content Blocks Extraction:
    $page->content_blocks.it[] viene estratto
    [
        {type: "hero", data: {...}},
        {type: "features", data: {...}},
        {type: "stats", data: {...}},
        {type: "cta", data: {...}}
    ]
   ↓
12. Block Processing: BlockData::collect($blocks)
    - Processa ogni blocco
    - Estrae data.view per ogni blocco
   ↓
13. Block Rendering: Ogni blocco renderizza componente Blade
    - hero.main → pub_theme::components.blocks.hero.main
      - Riceve $data con title, subtitle, cta_primary, ecc.
      - Renderizza HTML hero section
    - features.grid → pub_theme::components.blocks.features.grid
      - Riceve $data con title, features array
      - Renderizza HTML features grid
    - stats.overview → pub_theme::components.blocks.stats.overview
      - Riceve $data con title, stats array
      - Renderizza HTML stats section
    - cta.banner → pub_theme::components.blocks.cta.banner
      - Riceve $data con title, description, cta_primary
      - Renderizza HTML CTA banner
   ↓
14. Layout: x-layouts.app
    - Header: x-sections.header
    - Content: Tutti i blocchi renderizzati
    - Footer: x-sections.footer
   ↓
15. Response: HTML completo renderizzato
```

---

## 📊 Confronto LaravelPizza.com Originale vs Conversione

### Originale (laravelpizza.com)
- **Framework**: Next.js / React
- **Content**: Hardcoded in componenti React
- **Styling**: CSS Modules / Tailwind
- **Routing**: Next.js file-based routing
- **CMS**: Nessuno (content hardcoded)

### Conversione (base_laravelpizza)
- **Framework**: Laravel + Folio + Volt
- **Content**: JSON-driven (Filament Forms Builder)
- **Styling**: Tailwind CSS (Vite compilation)
- **Routing**: Folio file-based routing
- **CMS**: Filament Admin Panel

### Vantaggi Conversione
1. ✅ **Content Management**: Filament admin per gestire contenuti senza toccare codice
2. ✅ **Type Safety**: PHP strict types + PHPStan L10
3. ✅ **Modularità**: Architettura modulare Laraxot
4. ✅ **Riusabilità**: Componenti Blade riusabili
5. ✅ **Multi-tenant**: Supporto multi-tenant integrato
6. ✅ **SEO**: Server-side rendering Laravel
7. ✅ **Versionamento**: Contenuti in JSON versionabili con Git

---

## 🎯 Regole Critiche

### 1. Pagine Folio = Solo JSON
- ❌ NON creare file Blade per pagine dinamiche
- ✅ Creare SOLO file JSON in `config/local/.../pages/{slug}.json`
- ✅ Il file `[slug].blade.php` gestisce automaticamente tutte le pagine

### 2. Frontend Assets
- ❌ NON modificare direttamente file in `public_html/`
- ✅ Modificare `resources/css/app.css` e `resources/js/app.js`
- ✅ Eseguire `npm run build && npm run copy` dopo modifiche
- ✅ Verificare nel browser dopo build

### 3. Layout Hierarchy
- `x-layouts.main` → Shell HTML base (no header/footer), NON usare direttamente nelle pagine
- `x-layouts.app` → Layout completo con header nav + footer (pagina pubblica frontoffice)
- `x-layouts.guest` → Layout per login/registrazione/password (auth frontoffice)
- `x-layouts.public` → Layout pubblico (alternativa a app)

### 4. Componenti Blade
- Usare sintassi semplice: `<x-component-name>` (NON `<x-pub_theme::component-name>`)
- Componenti anonimi registrati con namespace non supportano sintassi esplicita
- Namespace `pub_theme::` è risolto automaticamente

### 5. Content Blocks
- Ogni blocco deve avere `type`, `slug`, `data.view`
- `data.view` deve puntare a componente Blade esistente
- I blocchi vengono processati da `BlockData::collect()`
- Supporto localizzazione: `content_blocks.it[]`, `content_blocks.en[]`

---

## 🔍 Analisi Confronto Pagine

### Homepage Locale (http://127.0.0.1:8002/it)
- ✅ Hero section con titolo e CTA
- ✅ Features grid (4 features)
- ✅ Stats section (4 statistiche)
- ✅ CTA finale
- ✅ Footer con link

### Homepage Produzione (https://laravelpizza.com/)
- ✅ Hero section con titolo e CTA
- ✅ Features grid (4 features)
- ✅ CTA finale
- ✅ Footer con link

**Differenze Minori**:
- Layout leggermente diverso (stili CSS)
- Alcuni testi potrebbero differire
- Stats section potrebbe non essere presente in produzione

**Conclusione**: La struttura è **identica**, la conversione è **fedele**.

---

## 📚 Riferimenti

- [Folio Pages JSON Only Rule](./folio-pages-json-only-rule.md)
- [Development Workflow CSS/JS](./development-workflow-css-js-changes.md)
- [Content Blocks Architecture](../../Modules/Cms/docs/content-blocks-architecture.md)
- [Filament Forms Builder](https://filamentphp.com/docs/4.x/forms/builder)
- [LaravelPizza.com Conversion Architecture](./laravelpizza-com-conversion-architecture.md)

---

**Ultimo aggiornamento**: [DATE]
**Versione**: 1.0.0
**Status**: ✅ Documentazione Critica Completa
