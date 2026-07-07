# OpenViking Master Memory: HTML-First Design Comuni Compliance

**URI**: `viking://themes/sixteen/html-first-compliance`  
**Timestamp**: 2026-03-30  
**Status**: ✅ CRITICAL DIRECTIVE

---

## 🎯 Golden Rule

```
WITHIN <body> (excluding <script>):
  Our HTML == Design Comuni HTML
```

**This is NOT optional. This is MANDATORY.**

---

## Why HTML Identical?

1. **Accessibility**: Design Comuni is WCAG 2.1 AA compliant
2. **Bootstrap Italia**: CSS classes require specific HTML structure
3. **PA Consistency**: All Italian Public Administration sites must match
4. **SEO**: Semantic structure is standardized
5. **Third-party Tools**: Expect Design Comuni HTML structure

---

## Current State Analysis

### Design Comuni HTML Structure

```html
<body>
    <a href="#main-content" class="visually-hidden">Skip link</a>
    
    <div class="it-header-wrapper">
        <div class="it-topbar">...</div>
        <header class="it-header">...</header>
        <nav class="it-main-nav">...</nav>
        <nav class="it-secondary-nav">...</nav>
    </div>
    
    <main id="main-content" class="container py-5">
        <h1>Page Title</h1>
        <section>
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="card card-topic shadow-sm">...</div>
                </div>
            </div>
        </section>
    </main>
    
    <footer class="it-footer">...</footer>
</body>
```

### Our Current HTML (WRONG)

```html
<body>
    <!-- ❌ Skip link missing -->
    
    <header class="site-header">  <!-- ❌ Wrong class -->
        <div class="top-bar">     <!-- ❌ Wrong class -->
            <!-- ... -->
        </div>
    </header>
    
    <!-- ❌ it-secondary-nav missing -->
    
    <main class="container py-5">
        <h1>Page Title</h1>
        <div class="grid grid-cols-3 gap-4">  <!-- ❌ Tailwind, not Bootstrap! -->
            <div class="card">  <!-- ❌ Missing card-topic class -->
                <!-- ... -->
            </div>
        </div>
    </main>
    
    <!-- ❌ Wrong footer structure -->
</body>
```

---

## Critical Gaps

| Element | Required Class | Our Class | Status |
|---------|---------------|-----------|--------|
| **Header Wrapper** | `.it-header-wrapper` | `.site-header` | 🔴 CRITICAL |
| **Top Bar** | `.it-topbar` | `.top-bar` | 🔴 CRITICAL |
| **Main Header** | `.it-header` | `.main-header` | 🔴 CRITICAL |
| **Main Nav** | `.it-main-nav` | `.main-nav` | 🔴 CRITICAL |
| **Secondary Nav** | `.it-secondary-nav` | ❌ Missing | 🔴 CRITICAL |
| **Card Topic** | `.card-topic` | `.card` | 🟡 PARTIAL |
| **Grid** | `.row .col-*` | `.grid grid-cols-*` | 🔴 CRITICAL |
| **Footer** | `.it-footer` | Custom | 🔴 CRITICAL |
| **Skip Links** | `.visually-hidden` | ❌ Missing | 🔴 CRITICAL |

---

## Framework Change

### Before (WRONG)

| Layer | Technology |
|-------|-----------|
| **CSS Framework** | Tailwind CSS v4 |
| **UI Components** | DaisyUI |
| **Grid System** | Tailwind Grid |
| **Icons** | Heroicons |

### After (CORRECT)

| Layer | Technology |
|-------|-----------|
| **CSS Framework** | Bootstrap 5.2.3 |
| **Component Library** | Bootstrap Italia |
| **Grid System** | Bootstrap Grid |
| **Icons** | Bootstrap Italia SVG Sprites |

---

## Implementation Steps

### 1. Install Bootstrap Italia

```bash
cd laravel/Themes/Sixteen
npm install bootstrap-italia@latest --save
npm install @popperjs/core @splidejs/splide animejs --save
```

### 2. Update Vite Config

**File**: `vite.config.js`

```javascript
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',  // Changed from .css
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
```

### 3. SCSS Entry Point

**File**: `resources/scss/app.scss`

```scss
// Import order is CRITICAL
@import "~bootstrap/scss/functions";
@import "~bootstrap-italia/src/scss/colors/colors.scss";
@import "~bootstrap/scss/bootstrap";
@import "~bootstrap-italia/src/scss/bootstrap-italia.scss";
```

### 4. Rewrite Components

**All Blade components MUST output Bootstrap Italia HTML:**

- `components/header.blade.php` → `.it-header-wrapper`, `.it-topbar`, `.it-header`, `.it-main-nav`, `.it-secondary-nav`
- `components/card-topic.blade.php` → `.card-topic`
- `components/breadcrumb.blade.php` → `.breadcrumb`
- `components/footer.blade.php` → `.it-footer`

---

## Validation Process

### Automated Check

```bash
# 1. Fetch our HTML
curl http://fixcity.local/it/tests/argomenti > our.html

# 2. Fetch Design Comuni HTML
curl https://italia.github.io/design-comuni-pagine-statiche/sito/argomenti.html > reference.html

# 3. Compare structure (exclude scripts)
diff <(grep -v '<script>' our.html) <(grep -v '<script>' reference.html)
```

**Expected**: Only content differences, NO structure differences

### Manual Checklist

- [ ] Skip links present (`.visually-hidden`)
- [ ] Header wrapper is `.it-header-wrapper`
- [ ] Top bar is `.it-topbar`
- [ ] Main header is `.it-header`
- [ ] Main nav is `.it-main-nav`
- [ ] Secondary nav is `.it-secondary-nav`
- [ ] Breadcrumb uses `.breadcrumb` with proper ARIA
- [ ] Cards use `.card-topic`
- [ ] Grid uses Bootstrap (`.row .col-*`)
- [ ] Footer is `.it-footer`

---

## OpenViking URIs

- `viking://themes/sixteen/html-first-compliance` - This directive
- `viking://themes/sixteen/docs/html-first-compliance` - Full documentation
- `viking://themes/sixteen/bootstrap-italia-integration` - Integration guide

---

## Related Memories

### Module Docs
- `viking://modules/cms/docs/blocks/zen-philosophy`
- `viking://modules/cms/docs/blocks/argomenti-error-analysis`

### Project Docs
- `viking://project/docs/agnostic-documentation-rule`
- `viking://project/docs/migration-plan`

---

## Developer Mantras

> *"HTML dentro body deve essere identico a Design Comuni. Non simile. Identico."*

> *"Bootstrap Italia non è un'opzione. È il requisito."*

> *"Componenti Blade generano HTML Bootstrap Italia. Niente Tailwind. Niente DaisyUI."*

---

## Status

| Phase | Status | Completion |
|-------|--------|------------|
| **Documentation** | ✅ Complete | 100% |
| **Bootstrap Italia Install** | 🟡 Pending | 0% |
| **Component Rewrite** | 🟡 Pending | 0% |
| **Validation** | 🟡 Pending | 0% |

**Overall**: 25% Complete

---

**Maintainer**: AI Agent Collective  
**Last Updated**: 2026-03-30  
**Next Review**: After Bootstrap Italia installation  
**Priority**: 🔴 CRITICAL
