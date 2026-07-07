# OpenViking: CRITICAL PROJECT KNOWLEDGE

**URI**: `viking://project/critical-knowledge`  
**Timestamp**: 2026-03-30  
**Priority**: MAXIMUM

---

## 🎯 THEME DETECTION

```
APP_URL (fixcity.local)
  ↓ reverse explode by "."
['local', 'fixcity']
  ↓ build path
config/local/fixcity/xra.php
  ↓ read
pub_theme = 'Sixteen'
  ↓ theme folder
laravel/Themes/Sixteen/
```

---

## 📁 COMPOSER ARCHITECTURE

### Root: MINIMAL

```json
{
    "merge-plugin": {
        "include": [
            "Modules/*/composer.json"  // ✅ ONLY modules
        ]
    }
}
```

### Themes: ISOLATED

- Themes have **own** composer.json
- Themes build **independently**
- Themes NOT in merge-plugin
- Themes use Vite separately

---

## 🎨 BLOCK CONVENTION

### Pattern

```
pub_theme::components.blocks.<TYPE>.<VIEW>
```

### Examples

```blade
✅ pub_theme::components.blocks.hero.homepage
✅ pub_theme::components.blocks.card.featured
✅ pub_theme::components.blocks.topics.grid

❌ pub_theme::components.blocks.tests.argomenti  <!-- tests.argomenti is NOT a type -->
```

### Universal Types

`hero`, `card`, `topics`, `features`, `cta`, `content`, `gallery`, `form`, `testimonial`, `pricing`, `faq`, `team`, `contact`, `footer`, `header`, `nav`

---

## 🏛️ SECTION SYSTEM

```blade
<x-section slug="header" />
<x-section slug="footer" />
<x-section slug="footer" tpl="slim" />
```

NOT direct component calls!

---

## 📄 CMS PAGES

### JSON Path

```
config/local/fixcity/database/content/pages/
tests.argomenti.json
tests.appuntamento-06-conferma.json
```

### Structure

```json
{
    "slug": "tests.argomenti",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {"view": "pub_theme::components.blocks.hero.argomenti"}
            },
            {
                "type": "topics",
                "data": {"view": "pub_theme::components.blocks.topics.grid"}
            }
        ]
    }
}
```

---

## 🎯 FOLIO + VOLT

### [slug].blade.php

```php
name('tests.view');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public function mount(string $slug): void {
        $this->slug = $slug;
        $this->pageSlug = 'tests.'.$slug;
    }
};
```

### index.blade.php

```php
name('tests.index');
middleware(PageSlugMiddleware::class);

new class extends Component {
    public function mount(): void {
        $this->pageSlug = 'tests.index';
    }
};
```

---

## 🎨 ICON SYSTEM

```blade
<x-filament::icon icon="heroicon-o-check-circle" class="w-5 h-5" />
```

NOT `<x-icon>` (deprecated)!

---

## 🏗️ VITE BUILD

```bash
cd laravel/Themes/<theme>
composer update -W
npm install
npm run build
npm run copy
```

---

## 📚 DOCUMENTATION RULES

### AGNOSTIC

```markdown
✅ Use `[PROJECT_NAME]`
❌ Use `FixCity`
```

### FILE NAMING

```markdown
✅ `pages-content-blocks.md`
❌ `fixcity-pages-content-blocks.md`
```

---

## 🎯 DESIGN COMUNI

### Strategy

1. Study HTML structure
2. Replicate with Tailwind @apply
3. Create reusable blocks
4. Document (agnostic)
5. Test with screenshots

### DO NOT

- ❌ Save raw HTML
- ❌ Use Bootstrap JS
- ❌ Create page-specific components

### DO

- ✅ Use style-apply.css
- ✅ Use app1.js
- ✅ Create universal blocks
- ✅ Use `<x-section>`
- ✅ Use `<x-filament::icon>`
- ✅ Use CMS JSON pages

---

## 🧘 MANTRAS

> *"La vista segue il tipo."*

> *"Temi isolati. Moduli condivisi."*

> *"Blocchi universali, riutilizzabili."*

> *"Documentazione agnostica."*

> *"Sempre Filament 5."*

---

**Status**: ✅ CRITICAL KNOWLEDGE STORED  
**Next**: Apply everywhere
