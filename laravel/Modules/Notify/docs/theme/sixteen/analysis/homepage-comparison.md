# Homepage Comparison Analysis

## Overview

This document analyzes the HTML structure differences between:
- **Reference**: `https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html`
- **Local**: `http://127.0.0.1:8000/it/tests/homepage` (generated from blade + JSON)

## Reference Structure (Bootstrap Italia)

### Sections Identified in Reference HTML

1. **Header/Navigation**
   - Skip links: `#main-container`, `#footer`
   - Language selector: ITA/ENG
   - Login link: Area personale
   - Header with logo, region portal link
   - Main navigation: Amministrazione, Novità, Servizi, Vivere il Comune
   - Topic navigation: Iscrizioni, Estate in città, Polizia locale, Tutti gli argomenti

2. **Hero Section** (`#head-section`)
   - H1: Nome del comune
   - H2: Contenuti in evidenza
   - Category+date badge (Notizie, 18 mag 2022)
   - News title link
   - Excerpt text with bold first words
   - Tag chip (Estate in città)
   - "Tutte le novità" link
   - Main image (800x600)

3. **Governance Section** (Organi di governo)
   - Cards for: Sindaco, Giunta, Consiglio
   - Image, title, role/description, link

4. **Events Section** (Settembre 2022)
   - Calendar grid with days (15-21)
   - Weekday labels (lun, mar)
   - Multiple events per day with images

5. **Topics Section** (Argomenti in evidenza)
   - Featured topics with external links
   - Topic links list
   - Other topics tags
   - Thematic sites section

6. **Search Section** (Link utili)
   - Search input with button
   - Useful links list

7. **Feedback Section**
   - Star rating (1-5)
   - Questions about clarity, difficulties

8. **Contacts Section**
   - Contact options list
   - Report disservizio link

9. **Final Search**
   - Search form
   - Suggestions (FORSE STAVI CERCANDO)

10. **Footer**
    - Amministrazione links
    - Categories
    - Novità
    - Contatti (address, phone, email, PEC)
    - Social links

## Local Structure (Blade + JSON)

### JSON Content Blocks (`tests.homepage.json`)

```json
{
  "block-hero": "hero-homepage",
  "block-calendario": "governance-calendario", 
  "block-topics": "topics-highlight",
  "block-useful-links": "useful-links",
  "block-feedback": "feedback-rating",
  "block-contacts": "contacts-homepage",
  "block-servizi": "services-homepage",
  "block-amministrazione": "administration-homepage",
  "block-final-search": "search-final"
}
```

### Blade Components

- `hero/homepage.blade.php` - Hero section
- `governance/cards.blade.php` - Governance cards
- `topics/highlight.blade.php` - Topics
- `search/support-links.blade.php` - Links
- `feedback/rating.blade.php` - Rating
- `contact/homepage.blade.php` - Contacts

## Critical Differences

### 1. CSS Framework
- **Reference**: Bootstrap Italia (legacy)
- **Target**: Tailwind CSS + Alpine.js

### 2. Icons
- **Reference**: Uses SVG sprites from `bootstrap-italia/dist/svg/sprites.svg`
- **Local**: Same sprites path but need Tailwind-compatible icons

### 3. Classes
- **Reference**: Bootstrap classes (`container`, `row`, `col-lg-6`, `card`, `btn-primary`)
- **Target**: Tailwind classes (`container`, `grid`, `col-span-6`, `rounded`, `bg-blue-600`)

### 4. JavaScript
- **Reference**: Bootstrap JS (tooltip, popover, collapse)
- **Target**: Alpine.js for interactivity

### 5. Color System
- **Reference**: CSS variables from Bootstrap Italia theme
- **Target**: Custom Tailwind CSS variables

## HTML Structure Mapping

| Reference | Local Blade | Notes |
|---|---|---|
| `.it-header-wrapper` | Header components | Need Tailwind |
| `#head-section` | `hero/homepage.blade.php` | Need CSS fix |
| `.evidence-section` | `topics/highlight.blade.php` | Complete rewrite |
| `.cmp-calendar` | `governance/cards.blade.php` | Needs review |
| `.it-footer` | Footer component | Needs Tailwind |

## Action Items

### Priority 1 - Critical CSS Fixes

1. **Hero Section**
   - Remove Bootstrap依赖
   - Add Tailwind equivalent classes
   - Fix image sizing
   - Fix card typography

2. **Topics Section**
   - Rewrite background image handling
   - Fix card grid layout
   - Add proper spacing

3. **Navigation**
   - Convert to Tailwind
   - Ensure mobile responsive

### Priority 2 - JavaScript Fixes

1. Move from Bootstrap JS to Alpine.js
2. Preserve all interactivity:
   - Mobile menu
   - Dropdowns
   - Tooltips/popovers if needed

### Priority 3 - Polish

1. Ensure full responsive design
2. Test on mobile/tablet viewports
3. Verify all links work

## Files to Modify

- `laravel/Themes/Sixteen/resources/assets/css/comune-custom.css`
- `laravel/Themes/Sixteen/resources/assets/js/comune-functions.js`
- Blade components as needed

## Build Commands

```bash
cd laravel/Themes/Sixteen
npm run build    # Build CSS/JS
npm run copy    # Copy assets
```

---

*Generated: 2026-04-07*
*Last Updated: 2026-04-07*