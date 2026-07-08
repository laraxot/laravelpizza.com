# Theme Detection System - FixCity Fila5

**Project:** FixCity Fila5
**Date:** 2026-04-01
**Status:** ✅ **Documented**
**Priority:** 🔴 **Critical Architecture**

---

## 🎯 Scopo

Questo documento spiega il sistema di rilevamento del tema basato su `APP_URL` e il percorso di configurazione dinamico.

---

## 📐 Theme Detection Flow

### Algoritmo di Rilevamento

```
.env → APP_URL
  ↓
1. Rimuovi protocollo (http:// o https://)
  ↓
2. Rimuovi www. (se presente)
  ↓
3. Estrai dominio (es: fixcity.local)
  ↓
4. Explode da "." → ['fixcity', 'local']
  ↓
5. Inverti array → ['local', 'fixcity']
  ↓
6. Join con "/" → "local/fixcity"
  ↓
7. Config path → base_path('config/local/fixcity/xra.php')
  ↓
8. Leggi pub_theme → 'Sixteen'
  ↓
9. Theme folder → laravel/Themes/Sixteen/
```

---

## 🔧 Implementazione

### Step-by-Step Example

**Input:** `APP_URL=http://fixcity.local`

**Step 1: Rimuovi protocollo**
```php
$appUrl = 'http://fixcity.local';
$parsed = parse_url($appUrl);
$host = $parsed['host'] ?? 'localhost';
// Result: 'fixcity.local'
```

**Step 2: Rimuovi www.**
```php
$host = str_replace('www.', '', $host);
// Result: 'fixcity.local' (unchanged if no www)
```

**Step 3: Explode e Inverti**
```php
$parts = explode('.', $host);
// Result: ['fixcity', 'local']

$reversed = array_reverse($parts);
// Result: ['local', 'fixcity']
```

**Step 4: Join**
```php
$configPath = implode('/', $reversed);
// Result: 'local/fixcity'
```

**Step 5: Leggi Config**
```php
$configFile = base_path("config/{$configPath}/xra.php");
// Result: base_path('config/local/fixcity/xra.php')

if (file_exists($configFile)) {
    $config = include $configFile;
    $pubTheme = $config['pub_theme'] ?? 'Sixteen';
    // Result: 'Sixteen'
}
```

---

## 📁 File Structure

```
laravel/
├── config/
│   └── local/
│       └── fixcity/
│           └── xra.php              ← Theme configuration
│               pub_theme => 'Sixteen'
├── Themes/
│   └── Sixteen/                     ← Theme folder
│       ├── resources/
│       ├── Main_files/
│       ├── vite.config.js
│       └── package.json
└── .env
    APP_URL=http://fixcity.local
```

---

## 🔍 xra.php Configuration

**File:** `laravel/config/local/fixcity/xra.php`

```php
<?php

declare(strict_types=1);

return [
    'adm_home' => '01',
    'enable_ads' => '1',
    'main_module' => 'Fixcity',
    'primary_lang' => 'it',
    'pub_theme' => 'Sixteen',        // ← Theme name
    'search_action' => 'it/videos',
    'show_trans_key' => false,
    'disable_admin_dynamic_route' => true,
    'disable_frontend_dynamic_route' => false,
    'register_adm_theme' => false,
    'register_pub_theme' => true,
];
```

---

## 🎨 Theme Folder Structure

**Folder:** `laravel/Themes/Sixteen/`

```
Sixteen/
├── resources/
│   ├── views/
│   │   ├── components/
│   │   │   ├── layouts/
│   │   │   │   ├── main.blade.php     ← <x-layouts.main>
│   │   │   │   └── app.blade.php      ← <x-layouts.app>
│   │   │   ├── sections/
│   │   │   │   ├── header.blade.php   ← <x-section slug="header" />
│   │   │   │   └── footer.blade.php   ← <x-section slug="footer" />
│   │   │   └── blocks/                ← Reusable blocks
│   │   │       ├── hero/
│   │   │       ├── cards/
│   │   │       └── ...
│   │   └── pages/
│   │       └── tests/
│   │           ├── [slug].blade.php   ← ALL pages use this
│   │           └── index.blade.php    ← Listing page
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── Main_files/
│   └── five/
│       ├── src/
│       │   ├── style-apply.css        ← Tailwind @apply rules
│       │   └── app1.js                ← Alpine.js components
│       └── ...
├── vite.config.js
├── package.json
└── docs/
    └── ...
```

---

## 🚀 Build Process

### Vite Configuration

**File:** `laravel/Themes/Sixteen/vite.config.js`

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    build: {
        outDir: './public',              // ← Build to local public/
        emptyOutDir: true,
        manifest: 'manifest.json',
        rollupOptions: {
            input: {
                app: resolve(__dirname, 'resources/js/app.js'),
                style: resolve(__dirname, 'resources/css/app.css'),
            },
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            publicDirectory: 'public',
            buildDirectory: 'build',
        }),
    ],
});
```

### Package.json Scripts

**File:** `laravel/Themes/Sixteen/package.json`

```json
{
  "scripts": {
    "build": "vite build",
    "copy": "cp -rv ./public/* ../../../public_html/themes/Sixteen/"
  }
}
```

### Build Commands

```bash
cd laravel/Themes/Sixteen

# 1. Update dependencies
composer update -W

# 2. Install NPM packages
npm install

# 3. Build Vite assets (outDir: './public')
npm run build

# 4. Copy to public_html
npm run copy
```

**Result:**
- Build: `laravel/Themes/Sixteen/public/build/manifest.json`
- Copy: `public_html/themes/Sixteen/build/manifest.json`

---

## 🎯 Blade Component Usage

### Layout Components

```blade
{{-- CORRETTO --}}
<x-layouts.app>
    <x-page side="content" :slug="$pageSlug" :data="$data" />
</x-layouts.app>

{{-- SBAGLIATO --}}
<x-layouts.design-comuni>           <!-- Non esiste -->
<x-pub_theme::layouts.main>         <!-- Namespace sbagliato -->
<x-sixteen::layouts.app>            <!-- Hardcoded theme name -->
```

### Section Components

```blade
{{-- CORRETTO --}}
<x-section slug="header" />
<x-section slug="footer" tpl="full" />
<x-section slug="footer" tpl="slim" />

{{-- SBAGLIATO --}}
@include('pub_theme::sections.header')  <!-- Usa <x-section> -->
<x-pub_theme::sections.header />        <!-- Usa <x-section> -->
```

### Block Components

```blade
{{-- CORRETTO --}}
<x-pub_theme::components.blocks.hero.default :data="$data" />
<x-pub_theme::components.blocks.cards.grid :data="$data" />

{{-- SBAGLIATO --}}
<x-sixteen::blocks.hero />              <!-- Hardcoded theme -->
<x-pub_theme::blocks.tests.argomenti>   <!-- Page-specific (NO!) -->
```

---

## 📝 Folio + Volt Pattern

### [slug].blade.php (ALL Pages)

**File:** `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`

```blade
<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $slug = '';
    public string $pageSlug = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
        $this->data = [
            'slug' => $slug
        ];
    }
};
?>

<x-layouts.app>
    @volt('tests.view')
        <div>
            <x-page side="content" :slug="$pageSlug" :data="$data" />
        </div>
    @endvolt
</x-layouts.app>
```

### index.blade.php (Listing Page)

**File:** `laravel/Themes/Sixteen/resources/views/pages/tests/index.blade.php`

```blade
<?php

declare(strict_types=1);

use function Laravel\Folio\middleware;
use function Laravel\Folio\name;
use Livewire\Volt\Component;
use Modules\Cms\Http\Middleware\PageSlugMiddleware;

name('tests.index');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public string $pageSlug = '';

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->pageSlug = 'tests.index';
        $this->data = [];
    }
};
?>

<x-layouts.app>
    @volt('tests.index')
        <div>
            <x-page side="content" :slug="$pageSlug" :data="$data" />
        </div>
    @endvolt
</x-layouts.app>
```

---

## 🔗 Cross-References

### Internal Documents

- → [Layout Architecture](Themes/Sixteen/docs/LAYOUT_ARCHITECTURE_AND_NAMESPACE.md) - Layout hierarchy
- → [Page Component Architecture](Modules/Cms/docs/PAGE_COMPONENT_ARCHITECTURE.md) - Page component
- → [Vite Build System](Themes/Sixteen/docs/VITE_MANIFEST_FIX_COMPLETE.md) - Build process
- → [Master Index](docs/MODULE_DOCS_INDEX.md) - Central navigation

### External Resources

- → [Laravel Folio Documentation](https://laravel.com/docs/folio)
- → [Livewire Volt Documentation](https://livewire.laravel.com/docs/volt)
- → [Vite Documentation](https://vitejs.dev/)

---

## 🚨 Common Mistakes

### 1. ❌ Hardcoded Theme Name

```blade
<x-sixteen::...>  <!-- SBAGLIATO: "sixteen" è hardcodato -->
```

✅ **CORRETTO:** `<x-pub_theme::...>` o `<x-...>` (componenti globali)

---

### 2. ❌ Page-Specific Files

```bash
pages/tests/homepage.blade.php      # SBAGLIATO
pages/tests/argomenti.blade.php     # SBAGLIATO
pages/tests/amministrazione.blade.php # SBAGLIATO
```

✅ **CORRETTO:** `pages/tests/[slug].blade.php` (UNICO file per TUTTE)

---

### 3. ❌ Vite Without Theme Parameter

```blade
@vite(['resources/css/app.css'])  # SBAGLIATO: cerca in public_html/build/
```

✅ **CORRETTO:** `@vite(['resources/css/app.css'], 'themes/Sixteen')`

---

### 4. ❌ Inline Header/Footer

```blade
{{-- SBAGLIATO in [slug].blade.php --}}
<header>...</header>
<footer>...</footer>
```

✅ **CORRETTO:** `<x-section slug="header" />` (in app.blade.php)

---

### 5. ❌ Bootstrap Italia Import

```css
@import url('https://cdn.jsdelivr.net/npm/bootstrap-italia@2.8.8/dist/css/bootstrap-italia.min.css');
```

✅ **CORRETTO:** Tailwind `@apply` in `style-apply.css`

---

## ✅ Checklist

### Theme Detection

- [ ] `APP_URL` in `.env`
- [ ] Config file exists: `config/local/{domain}/xra.php`
- [ ] `pub_theme` key set
- [ ] Theme folder exists: `laravel/Themes/{theme}/`

### Build Process

- [ ] `vite.config.js` with `outDir: './public'`
- [ ] `package.json` with `copy` script
- [ ] `composer update -W` executed
- [ ] `npm install` executed
- [ ] `npm run build` executed
- [ ] `npm run copy` executed
- [ ] Manifest exists: `public_html/themes/{theme}/manifest.json`

### Blade Components

- [ ] `<x-layouts.app>` used (NOT custom layouts)
- [ ] `<x-section slug="header" />` used
- [ ] `<x-section slug="footer" />` used
- [ ] `<x-pub_theme::...>` namespace used
- [ ] `[slug].blade.php` used (NOT page-specific files)

---

**📝 Documento preparato da:** Multi-Agent Team (BMad + GSD)
**📅 Data:** 2026-04-01
**🔄 Status:** ✅ **Documented**

🐮 **Theme Detection System Documented!**
