# OpenViking Master Memory: Theme Architecture & Build System

**URI**: `viking://themes/sixteen/master-memory`  
**Timestamp**: 2026-03-30  
**Status**: ✅ Living Document

---

## 🎯 Core Architecture Principles

### 1. Folio + Volt Pattern

```
Themes/Sixteen/resources/views/pages/
├── index.blade.php              # /
├── [slug].blade.php             # /{slug} (dynamic routing)
└── tests/
    ├── index.blade.php          # /tests
    └── [slug].blade.php         # /tests/{slug}
```

**Why**: Dynamic routing for CMS-driven pages

**File**: `pages/tests/[slug].blade.php`
```php
name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public function mount(string $slug = ''): void {
        $this->pageSlug = 'tests.' . $slug;
    }
};
```

### 2. Block Type → View Convention

```
pub_theme::components.blocks.{type}.{view}
```

**Example**:
- Type: `topics`
- View: `pub_theme::components.blocks.topics.argomenti`

**Why**: Modularity, predictability, reusability

### 3. Header Structure (Design Comuni)

```
┌─────────────────────────────────────┐
│ Top Bar (Region + Lang + User)      │
├─────────────────────────────────────┤
│ Header (Logo + Municipality + Social)│
├─────────────────────────────────────┤
│ Main Nav (4 PA voices)              │
├─────────────────────────────────────┤
│ Secondary Nav (Breadcrumb + Topics) │
└─────────────────────────────────────┘
```

---

## 📦 Build System

### Commands

```bash
npm run dev      # Development (hot reload)
npm run build    # Production build
npm run copy     # Copy to public directory
```

### File Flow

```
resources/  →  npm run build  →  dist/  →  npm run copy  →  public/
(CSS/JS)                        (built)                    (web-accessible)
```

### Entry Points

- **CSS**: `resources/css/app.css`
- **JS**: `resources/js/app.js`

### Output

- `dist/css/app.css` (minified)
- `dist/js/app.js` (bundled)
- `public/themes/Sixteen/manifest.json`

---

## 🎨 Design System

### Framework Stack

| Layer | Technology | Purpose |
|-------|-----------|---------|
| **CSS Framework** | Tailwind CSS v4 | Utility-first styling |
| **UI Components** | DaisyUI | Pre-built components |
| **Icons** | Heroicons | SVG icons |
| **JS Framework** | Alpine.js | Lightweight reactivity |
| **Build Tool** | Vite v5 | Fast bundling |

### Color Palette

```css
--color-primary: #0066cc;    /* Design Comuni blue */
--color-secondary: #5c6b7f;  /* Gray blue */
--color-accent: #ff6b6b;     /* Red accent */
```

### Typography

```css
font-family: 'Titillium Web', sans-serif;  /* Design Comuni font */
```

---

## 📚 Documentation Structure

```
Themes/Sixteen/docs/
├── header/
│   ├── analysis.md              # Header comparison with Design Comuni
│   └── screenshots/             # Visual comparisons
├── pages/
│   └── slug-file-analysis.md    # Why [slug].blade.php exists
├── blocks/
│   ├── ZEN_PHILOSOPHY.md        # Philosophy of blocks
│   └── ARCHITECTURE_VISION.md   # Long-term vision
├── build-workflow.md            # npm commands, Vite config
└── index.md                     # Master index
```

---

## 🔧 Key Files

### Configuration

| File | Purpose |
|------|---------|
| `package.json` | Dependencies & scripts |
| `vite.config.js` | Vite bundler config |
| `tailwind.config.js` | Tailwind theme config |

### Source

| File | Purpose |
|------|---------|
| `resources/css/app.css` | Main CSS entry |
| `resources/js/app.js` | Main JS entry |
| `resources/views/pages/[slug].blade.php` | Dynamic routing |

### Build Output

| File | Purpose |
|------|---------|
| `dist/css/app.css` | Production CSS |
| `dist/js/app.js` | Production JS |
| `public/themes/Sixteen/manifest.json` | Asset manifest |

---

## 🚀 Development Workflow

### 1. Setup (First Time)

```bash
cd laravel/Themes/Sixteen
npm install
```

### 2. Development

```bash
# Start dev server
npm run dev

# Edit files
vim resources/css/header.css

# Hot reload happens automatically
```

### 3. Production Build

```bash
# Build for production
npm run build

# Copy to public directory
npm run copy

# Test in browser
http://fixcity.local/it/tests/argomenti
```

---

## 📊 Quality Metrics

| Metric | Target | Current |
|--------|--------|---------|
| Build time | <5s | TBD |
| CSS size (gzip) | <50KB | TBD |
| JS size (gzip) | <30KB | TBD |
| Lighthouse score | >90 | TBD |
| Accessibility | AA | TBD |

---

## 🐛 Troubleshooting

### CSS Not Updating

```bash
# Clear cache
rm -rf dist/ public/themes/Sixteen/css/*

# Rebuild
npm run build && npm run copy

# Hard refresh
Ctrl + Shift + R
```

### JavaScript Errors

```bash
# Check Alpine setup
grep -n "Alpine.start()" resources/js/app.js

# Rebuild
npm run build && npm run copy
```

### 404 on Routes

```bash
# Check [slug].blade.php exists
ls -la resources/views/pages/tests/[slug].blade.php

# Clear route cache
php artisan route:clear
php artisan route:cache
```

---

## 🔗 Cross-References

### Module Docs
- `viking://modules/cms/docs/blocks/zen-philosophy`
- `viking://modules/cms/docs/blocks/argomenti-error-analysis`

### Project Docs
- `viking://project/docs/agnostic-documentation-rule`
- `viking://project/docs/migration-plan`

### External
- [Design Comuni](https://italia.github.io/design-comuni-pagine-statiche/)
- [Bootstrap Italia](https://italia.github.io/bootstrap-italia/)
- [Vite Docs](https://vitejs.dev/)

---

## 🧘 Developer Mantras

> *"Il routing segue il pattern, come la vista segue il tipo."*

> *"Costruisci una volta, distribuisci ovunque."*

> *"L'header è il volto del sito, come il titolo è del libro."*

---

## ✅ Checklist for New Pages

- [ ] Create `[slug].blade.php` if dynamic routing needed
- [ ] Add middleware: `PageSlugMiddleware::class`
- [ ] Set route name: `name('tests.view')`
- [ ] Mount slug: `$this->pageSlug = 'tests.' . $slug`
- [ ] Use `<x-page>` component
- [ ] Test route: `/it/tests/{slug}`

---

## ✅ Checklist for CSS/JS Changes

- [ ] Edit source files in `resources/`
- [ ] Run `npm run build`
- [ ] Run `npm run copy`
- [ ] Test in browser
- [ ] Verify no console errors
- [ ] Check responsive behavior

---

**Maintainer**: AI Agent Collective  
**Last Updated**: 2026-03-30  
**Next Review**: 2026-04-30  
**Version**: 1.0
