# OpenViking Update: Homepage Implementation

**URI**: `viking://themes/sixteen/homepage-implementation`  
**Timestamp**: 2026-03-30  
**Status**: ✅ DOCUMENTATION COMPLETE

---

## 🎯 Objective

Replicate Design Comuni homepage exactly:
- **Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html
- **Target**: http://fixcity.local/it/tests/homepage
- **Requirement**: Identical HTML inside `<body>` + Bootstrap Italia CSS

---

## 📊 Analysis Complete

### Structure Analyzed

```
┌─────────────────────────────────────────┐
│ HEADER (3 levels)                       │
│ 1. Slim: Region | Lang | Login          │
│ 2. Center: Logo | Name | Social | Search│
│ 3. Nav: Admin | News | Services | Live  │
├─────────────────────────────────────────┤
│ MAIN CONTENT                            │
│ - Hero (H1 + Subtitle)                  │
│ - Featured News (Large card)            │
│ - Government (3 cards: Mayor, Council)  │
│ - Events (Calendar list)                │
│ - Topics (5 cards grid)                 │
│ - Thematic Sites (3 cards)              │
│ - Search Bar                            │
│ - Useful Links                          │
│ - Feedback (Stars + Questions)          │
│ - Contact/Service (3 cards)             │
├─────────────────────────────────────────┤
│ FOOTER (4 columns + bottom bar)         │
└─────────────────────────────────────────┘
```

### Bootstrap Italia Classes Identified

| Category | Classes |
|----------|---------|
| **Header** | `.it-header-wrapper`, `.it-header-slim-wrapper`, `.it-nav-wrapper` |
| **Layout** | `.container`, `.row`, `.col-12`, `.col-md-4`, `.col-lg-3` |
| **Cards** | `.card`, `.card-teaser`, `.card-bg`, `.card-topic`, `.card-thumb` |
| **Typography** | `.title-xxxlarge`, `.title-xxlarge`, `.subtitle-small` |
| **Buttons** | `.btn`, `.btn-primary`, `.btn-outline-primary`, `.btn-sm` |
| **Forms** | `.form-control`, `.form-group`, `.star-rating` |
| **Utilities** | `.py-5`, `.mb-4`, `.mt-4`, `.bg-light`, `.bg-dark` |

---

## 📁 Files Created

### 1. Documentation
**File**: `laravel/Themes/Sixteen/docs/homepage/HOMEPAGE_IMPLEMENTATION.md`

**Contents**:
- Complete HTML structure
- Bootstrap Italia classes reference
- Implementation steps
- Validation checklist
- Developer mantra

### 2. Directories
- `laravel/Themes/Sixteen/docs/homepage/screenshots/` ✅
- `laravel/Modules/Cms/docs/homepage/screenshots/` ✅

---

## 🎨 Implementation Plan

### Phase 1: Create Blade View (Ready)

**File**: `laravel/Themes/Sixteen/resources/views/design-comuni/pages/homepage.blade.php`

**Status**: 🟡 Ready to create

### Phase 2: Build & Deploy

```bash
cd laravel/Themes/Sixteen

# Build
npm run build && npm run copy

# Clear cache
php artisan view:clear && php artisan route:clear

# Test
http://fixcity.local/it/tests/homepage
```

### Phase 3: Validation

```bash
# Fetch our HTML
curl http://fixcity.local/it/tests/homepage > our.html

# Fetch Design Comuni HTML
curl https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html > reference.html

# Compare structure
diff <(grep -v '<script>' our.html) <(grep -v '<script>' reference.html)
```

**Expected**: Minimal differences (only content, not structure)

---

## 📋 Section Breakdown

### 1. Hero Section
- **HTML**: `<section class="hero-section py-5">`
- **Content**: H1 "NOME DEL COMUNE", Subtitle "CONTENUTI IN EVIDENZA"
- **Classes**: `.title-xxxlarge`, `.subtitle-small`

### 2. Featured News
- **HTML**: `<section class="featured-news py-5 bg-light">`
- **Content**: Large card with date, title, description
- **Classes**: `.card`, `.card-teaser`, `.shadow`

### 3. Government
- **HTML**: `<section class="government py-5">`
- **Content**: 3 cards (Mayor, Giunta, Consiglio)
- **Classes**: `.card`, `.card-bg`, `.col-lg-4`

### 4. Events
- **HTML**: `<section class="events py-5 bg-light">`
- **Content**: Calendar list with dates
- **Classes**: `.card`, `.card-teaser-card`, `.date-box`

### 5. Topics
- **HTML**: `<section class="topics py-5">`
- **Content**: 5 cards (Trasporto, Mobilità, Animale, Sport, Altri)
- **Classes**: `.card`, `.card-topic`, `.col-lg-4`

### 6. Thematic Sites
- **HTML**: `<section class="thematic-sites py-5 bg-light">`
- **Content**: 3 cards (Mobilità, Turismo, Musei)
- **Classes**: `.card`, `.card-bg`

### 7. Search
- **HTML**: `<section class="search py-5">`
- **Content**: Search form with input + button
- **Classes**: `.form-control`, `.btn-primary`

### 8. Useful Links
- **HTML**: `<section class="useful-links py-5 bg-light">`
- **Content**: List of links (CIE, Residenza, Tributi, etc.)
- **Classes**: `.link-list`

### 9. Feedback
- **HTML**: `<section class="feedback py-5">`
- **Content**: Star rating + 2 questions + textarea
- **Classes**: `.star-rating`, `.form-control`

### 10. Contact/Service
- **HTML**: `<section class="contact-service py-5 bg-light">`
- **Content**: 3 cards (Contatta, Assistenza, Disservizio)
- **Classes**: `.card`, `.card-teaser`, `.btn-outline-primary`

---

## ✅ Validation Checklist

- [x] Analysis complete
- [x] Documentation created
- [x] Directories created
- [ ] Blade view created
- [ ] Assets built (npm run build)
- [ ] Assets copied (npm run copy)
- [ ] Page tested
- [ ] HTML compared with reference
- [ ] Accessibility validated

**Status**: 30% Complete (Documentation ✅, Implementation 🟡 Pending)

---

## 🔗 References

### Documentation
- `viking://themes/sixteen/docs/homepage-implementation` - Full guide
- `viking://themes/sixteen/footer-implementation` - Footer
- `viking://themes/sixteen/docs/complete-implementation-guide` - General

### External
- [Design Comuni Homepage](https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html)
- [Bootstrap Italia Docs](https://italia.github.io/bootstrap-italia/)

---

**Maintainer**: AI Agent Collective  
**Last Updated**: 2026-03-30  
**Next Step**: Create Blade view and build assets
