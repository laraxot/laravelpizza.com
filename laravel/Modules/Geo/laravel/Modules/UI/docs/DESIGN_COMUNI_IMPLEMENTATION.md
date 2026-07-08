# 🎨 Design Comuni Implementation Guide

**Module**: UI (User Interface)  
**Date**: 2026-03-30  
**Status**: ✅ Components Ready

---

## 📋 Overview

This module implements Design Comuni (Italian Municipalities Design System) components using Tailwind CSS with @apply directive.

**Reference**: https://italia.github.io/design-comuni-pagine-statiche/

---

## 🧩 Components Created (12)

### Layout Components

| Component | File | Description |
|-----------|------|-------------|
| **Top Bar** | `blocks/top-bar.blade.php` | Region name + Language selector |
| **Header Enhanced** | `blocks/header-enhanced.blade.php` | Logo + Search + Social + Login |
| **Main Navigation** | `blocks/main-navigation.blade.php` | Menu with submenus |
| **Footer** | `blocks/footer/*.blade.php` | Multi-column footer |

### Content Components

| Component | File | Description |
|-----------|------|-------------|
| **Hero** | `blocks/hero/hero.blade.php` | City banner |
| **Featured News** | `blocks/featured-news.blade.php` | Featured content |
| **Government Bodies** | `blocks/government-bodies.blade.php` | Mayor, Council, etc. |
| **Events Calendar** | `blocks/events-calendar.blade.php` | 7-day calendar |
| **Topics Highlight** | `blocks/topics-highlight.blade.php` | Featured topics |
| **Thematic Sites** | `blocks/thematic-sites.blade.php` | Related sites |
| **Feedback Section** | `blocks/feedback-section.blade.php` | 5-star rating |
| **Contact Section** | `blocks/contact-section.blade.php` | Contact options |

---

## 🎨 CSS Architecture

### File Structure

```
Themes/Sixteen/resources/css/
├── app.css (main entry)
├── agid-variables.css (AGID colors, fonts)
├── bootstrap-italia.css (Bootstrap Italia base)
├── agid-colors.css (Color palette)
├── agid-override.css (AGID overrides)
└── components/
    └── design-comuni.css (Tailwind @apply for all components)
```

### CSS Classes Mapping

All Bootstrap Italia classes are mapped to Tailwind via @apply:

```css
/* Example */
.it-header-slim-wrapper {
    @apply bg-primary-dark border-b border-white/20;
}

.btn-primary {
    @apply bg-primary text-white hover:bg-primary-dark;
}
```

---

## 📄 Usage Examples

### Top Bar

```blade
<x-blocks.top-bar :data="[
    'region_name' => 'Nome della Regione',
    'languages' => [
        ['code' => 'ita', 'label' => 'ITA', 'active' => true],
        ['code' => 'eng', 'label' => 'ENG', 'active' => false],
    ]
]" />
```

### Header Enhanced

```blade
<x-blocks.header-enhanced :data="[
    'city_name' => 'Nome del Comune',
    'tagline' => 'Un comune da vivere',
    'logo_url' => '/themes/Sixteen/images/logo-comune.svg',
    'social_links' => [
        ['platform' => 'twitter', 'url' => '#', 'icon' => 'ui-brands.twitter'],
        ['platform' => 'facebook', 'url' => '#', 'icon' => 'ui-brands.facebook'],
    ],
    'search_action' => '/it/tests/risultati-ricerca',
    'login_url' => '/it/tests/auth/login'
]" />
```

### Main Navigation

```blade
<x-blocks.main-navigation :data="[
    'menu_items' => [
        [
            'label' => 'Amministrazione',
            'url' => '/it/tests/amministrazione',
            'submenu' => [
                ['label' => 'Organi di governo', 'url' => '#'],
                ['label' => 'Aree amministrative', 'url' => '#'],
            ]
        ],
        // ... more items
    ]
]" />
```

---

## 🔧 JSON Configuration

Pages are configured via JSON files:

**Location**: `config/local/fixcity/database/content/pages/`

**Example**: `tests.homepage.json`

```json
{
    "slug": "tests.homepage",
    "content_blocks": {
        "it": [
            {
                "type": "top-bar",
                "data": { ... }
            },
            {
                "type": "header-enhanced",
                "data": { ... }
            },
            // ... all 12 sections
        ]
    }
}
```

---

## 🎯 Page Rendering Flow

```
1. User visits URL
   ↓
2. Folio routes to [slug].blade.php
   ↓
3. Volt component mounts
   ↓
4. <x-page> loads JSON config
   ↓
5. Renders all blocks in order
   ↓
6. Homepage displayed
```

---

## 📊 Component Status

| Component | Created | Tested | Production Ready |
|-----------|---------|--------|------------------|
| Top Bar | ✅ | ⚪ | ⚪ |
| Header Enhanced | ✅ | ⚪ | ⚪ |
| Main Navigation | ✅ | ⚪ | ⚪ |
| Hero | ✅ | ⚪ | ⚪ |
| Featured News | ✅ | ⚪ | ⚪ |
| Government Bodies | ✅ | ⚪ | ⚪ |
| Events Calendar | ✅ | ⚪ | ⚪ |
| Topics Highlight | ✅ | ⚪ | ⚪ |
| Thematic Sites | ✅ | ⚪ | ⚪ |
| Feedback Section | ✅ | ⚪ | ⚪ |
| Contact Section | ✅ | ⚪ | ⚪ |
| Footer | ✅ | ⚪ | ⚪ |

**Progress**: 12/12 created (100%)  
**Testing**: 0/12 tested (0%)  
**Production**: 0/12 ready (0%)

---

## 🧪 Testing Checklist

### Visual Testing
- [ ] Desktop (1920x1080)
- [ ] Tablet (768x1024)
- [ ] Mobile (375x667)
- [ ] Compare with reference

### Functional Testing
- [ ] Language switcher
- [ ] Search functionality
- [ ] Navigation menu
- [ ] Submenus
- [ ] All links work

### Accessibility Testing
- [ ] ARIA labels
- [ ] Keyboard navigation
- [ ] Screen reader support
- [ ] Color contrast
- [ ] Focus states

### Performance Testing
- [ ] Page load time
- [ ] CSS bundle size
- [ ] Image optimization
- [ ] Lazy loading

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Screenshot Analysis** | `docs/design-comuni/screenshots/analysis/` |
| **Component Reference** | `docs/components/` |
| **CSS Guide** | `docs/css/` |
| **AI Tools Workflow** | `.planning/ai-tools/` |

---

## 🤖 AI Tools Used

| Tool | Purpose |
|------|---------|
| **OpenViking** | Context management |
| **BMAD** | Architecture design |
| **GSD** | Phase execution |
| **Ralph Loop** | Component generation |
| **Superpowers** | Planning workflow |
| **NotebookLM MCP** | Research |

---

## ✅ Next Steps

1. **Start local server**
2. **Capture screenshots**
3. **Visual comparison**
4. **Fix any issues**
5. **Accessibility audit**
6. **Performance optimization**
7. **Production deployment**

---

**Status**: ✅ **COMPONENTS COMPLETE**  
**Next**: Testing phase  
**ETA**: 4h for complete testing

**UI module documentation complete! 🎨📚**
