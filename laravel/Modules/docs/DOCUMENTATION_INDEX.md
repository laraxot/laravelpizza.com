# Module Documentation Index

**Generated:** 2026-03-30  
**Total Modules:** 19  
**Total Documentation Files:** 13,174  
**After Deduplication Target:** ~6,500

---

## Quick Navigation

### By Module
- [AI](#ai-module)
- [Activity](#activity-module)
- [Blog](#blog-module)
- [Cms](#cms-module)
- [Comment](#comment-module)
- [Fixcity](#fixcity-module)
- [Gdpr](#gdpr-module)
- [Geo](#geo-module)
- [Job](#job-module)
- [Lang](#lang-module)
- [Media](#media-module)
- [Notify](#notify-module)
- [Rating](#rating-module)
- [Seo](#seo-module)
- [Tenant](#tenant-module)
- [UI](#ui-module)
- [User](#user-module)
- [Xot](#xot-module)

### By Topic
- [Architecture](#architecture)
- [Testing](#testing)
- [Quality](#quality)
- [Translations](#translations)
- [Filament](#filament)
- [Routing](#routing)

---

## Module Documentation

### AI Module
**Location:** `laravel/Modules/AI/docs/`  
**Files:** ~50  
**Entry Point:** [`README.md`](../AI/docs/README.md)

**Key Topics:**
- AI integration patterns
- Model management
- Prediction generation

**Cross-References:**
- See also: [Predict Module](#fixcity-module)
- Related: [Xot Architecture](#xot-module)

---

### Activity Module
**Location:** `laravel/Modules/Activity/docs/`  
**Files:** ~200  
**Entry Point:** [`README.md`](../Activity/docs/README.md)

**Key Topics:**
- Activity tracking
- User actions logging
- Audit trails

**⚠️ Audit Note:** Contains `coverage-full.md` (2,930 lines) - should be split

**Cross-References:**
- Related: [User Module](#user-module)
- Related: [Gdpr Module](#gdpr-module)

---

### Blog Module
**Location:** `laravel/Modules/Blog/docs/`  
**Files:** 60  
**Entry Point:** [`README.md`](../Blog/docs/README.md)

**Key Topics:**
- Blog post management
- Content blocks
- Categories and tags
- Comments integration

**Key Documents:**
- [`prd.md`](../Blog/docs/prd.md) - Product Requirements
- [`structure.md`](../Blog/docs/structure.md) - Module architecture
- [`blocks.md`](../Blog/docs/blocks.md) - Content blocks system

**Cross-References:**
- Uses: [Cms Blocks](#cms-module)
- Related: [Comment Module](#comment-module)

---

### Cms Module
**Location:** `laravel/Modules/Cms/docs/`  
**Files:** 893  
**Entry Point:** [`index.md`](../Cms/docs/index.md)

**Key Topics:**
- Content Management System
- Page builder
- Content blocks
- Folio routing
- Volt components

**⚠️ Audit Note:** 793 files in `archive/` directory (89% duplication)

**Key Documents:**
- [`content-blocks-system.md`](../Cms/docs/content-blocks-system.md) - **SSOT** for blocks
- [`pages-content-blocks.md`](../Cms/docs/pages-content-blocks.md) - Page composition
- [`frontoffice/multi-block-page-builder-governance.md`](../Cms/docs/frontoffice/multi-block-page-builder-governance.md)

**Deprecated:**
- `archive/` directory - scheduled for removal
- `volt_web_application.md` → use `volt-web-application.md`

**Cross-References:**
- Links to: [UI Components](#ui-module)
- Uses: [Xot Base](#xot-module)
- Related: [Blog Module](#blog-module)

---

### Comment Module
**Location:** `laravel/Modules/Comment/docs/`  
**Files:** ~30  
**Entry Point:** [`00-INDEX.md`](../Comment/docs/00-INDEX.md)

**Key Topics:**
- Comment system
- Moderation
- Threading

**Cross-References:**
- Used by: [Blog Module](#blog-module)
- Related: [User Module](#user-module)

---

### Fixcity Module
**Location:** `laravel/Modules/Fixcity/docs/`  
**Files:** ~100  
**Entry Point:** [`README.md`](../Fixcity/docs/README.md)

**Key Topics:**
- Core platform features
- User research
- Roadmap

**Key Documents:**
- [`roadmap/user-research.md`](../Fixcity/docs/roadmap/user-research.md) - User insights

**Cross-References:**
- Depends on: [All modules](#)

---

### Gdpr Module
**Location:** `laravel/Modules/Gdpr/docs/`  
**Files:** ~40  
**Entry Point:** [`README.md`](../Gdpr/docs/README.md)

**Key Topics:**
- GDPR compliance
- Data privacy
- User consent

**Cross-References:**
- Related: [User Module](#user-module)
- Related: [Activity Module](#activity-module)

---

### Geo Module
**Location:** `laravel/Modules/Geo/docs/`  
**Files:** ~150  
**Entry Point:** [`README.md`](../Geo/docs/README.md)

**Key Topics:**
- Geographic data
- Location services
- Maps integration

**⚠️ Audit Note:** Contains `coverage-full.md` (2,048 lines) - should be split

**Cross-References:**
- Used by: [Fixcity Module](#fixcity-module)

---

### Job Module
**Location:** `laravel/Modules/Job/docs/`  
**Files:** ~50  
**Entry Point:** [`README.md`](../Job/docs/README.md)

**Key Topics:**
- Job postings
- Employment features

**Cross-References:**
- Related: [User Module](#user-module)

---

### Lang Module
**Location:** `laravel/Modules/Lang/docs/`  
**Files:** 879  
**Entry Point:** [`index.md`](../Lang/docs/index.md)

**Key Topics:**
- **SSOT** for all translation/i18n content
- Multi-language support
- Laravel Localization integration
- Translation file structure

**⚠️ Audit Note:** 700+ files in `archive/` directory

**Key Documents:**
- [`translation_system.md`](../Lang/docs/translation_system.md) - **SSOT**
- [`translation_keys_best_practices.md`](../Lang/docs/translation_keys_best_practices.md) - **SSOT**
- [`translation_files_update.md`](../Lang/docs/translation_files_update.md)
- [`working_with_locales.md`](../Lang/docs/working_with_locales.md)

**Deprecated:**
- `archive/` directory - scheduled for removal
- Multiple naming variants: `translation_*.md` vs `translations_*.md`

**Cross-References:**
- Used by: **All modules**
- Related: [mcamara/laravel-localization](https://github.com/mcamara/laravel-localization)

---

### Media Module
**Location:** `laravel/Modules/Media/docs/`  
**Files:** ~80  
**Entry Point:** [`README.md`](../Media/docs/README.md)

**Key Topics:**
- Media library
- File management
- Image processing

**Cross-References:**
- Uses: [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary)
- Related: [UI Module](#ui-module)

---

### Notify Module
**Location:** `laravel/Modules/Notify/docs/`  
**Files:** ~200  
**Entry Point:** [`README.md`](../Notify/docs/README.md)

**Key Topics:**
- Notification system
- Email templates
- Telegram integration
- Seasonal campaigns

**Key Documents:**
- [`seasonal-email-templates.md`](../Notify/docs/seasonal-email-templates.md) - 1,731 lines
- [`telegram-provider-architecture.md`](../Notify/docs/telegram-provider-architecture.md)

**Cross-References:**
- Related: [User Module](#user-module)

---

### Rating Module
**Location:** `laravel/Modules/Rating/docs/`  
**Files:** ~40  
**Entry Point:** [`00-INDEX.md`](../Rating/docs/00-INDEX.md)

**Key Topics:**
- Rating system
- Reviews
- Star ratings

**Cross-References:**
- Related: [Comment Module](#comment-module)

---

### Seo Module
**Location:** `laravel/Modules/Seo/docs/`  
**Files:** ~100  
**Entry Point:** [`00-INDEX.md`](../Seo/docs/00-INDEX.md)

**Key Topics:**
- SEO optimization
- Meta tags
- Sitemaps

**⚠️ Audit Note:** Contains `metodi-duplicati-analisi.md` (1,611 lines)

**Cross-References:**
- Related: [Cms Module](#cms-module)
- Related: [Blog Module](#blog-module)

---

### Tenant Module
**Location:** `laravel/Modules/Tenant/docs/`  
**Files:** ~60  
**Entry Point:** [`README.md`](../Tenant/docs/README.md)

**Key Topics:**
- Multi-tenancy
- Tenant isolation
- Database scoping

**Cross-References:**
- Related: [User Module](#user-module)

---

### UI Module
**Location:** `laravel/Modules/UI/docs/`  
**Files:** 589  
**Entry Point:** [`index.md`](../UI/docs/index.md)

**Key Topics:**
- **SSOT** for UI components
- Filament components
- Blade components
- Design system
- Charts and widgets

**⚠️ Audit Note:** 400+ files in `archive/` directory

**Key Documents:**
- [`components.md`](../UI/docs/components.md) - **SSOT**
- [`filament-components-usage.md`](../UI/docs/filament-components-usage.md)
- [`folo-volt-best-practices.md`](../UI/docs/folio-volt-best-practices.md)
- [`architecture.md`](../UI/docs/architecture.md)

**Deprecated:**
- `architecture-.md` → use `architecture.md`
- `naming_conventions.md` → use `naming-conventions.md`

**Cross-References:**
- Used by: **All modules with UI**
- Related: [Themes](../Themes/docs/README.md)

---

### User Module
**Location:** `laravel/Modules/User/docs/`  
**Files:** ~1,500  
**Entry Point:** [`README.md`](../User/docs/README.md)

**Key Topics:**
- User management
- Authentication
- Authorization
- Profile management
- GDPR compliance

**⚠️ Audit Note:** 
- 1,000+ files in `archive/` directory
- Contains `coverage-full.md` (11,055 lines) - **CRITICAL**: split immediately

**Key Documents:**
- [`gdpr-compliance.md`](../User/docs/gdpr-compliance.md) - **SSOT**
- [`guida-migrazione-step-by-step.md`](../User/docs/guida-migrazione-step-by-step.md)

**Deprecated:**
- `volt_errors.md` → use `volt-errors.md`
- `archive/` directory - scheduled for removal

**Cross-References:**
- Used by: **All modules**
- Related: [Gdpr Module](#gdpr-module)
- Related: [Tenant Module](#tenant-module)

---

### Xot Module
**Location:** `laravel/Modules/Xot/docs/`  
**Files:** 4,993  
**Entry Point:** [`00-INDEX.md`](../Xot/docs/00-INDEX.md)

**Key Topics:**
- **SSOT** for core architecture
- Base classes (XotBase*)
- Actions pattern
- Module system
- Quality standards

**⚠️ Audit Note:** 
- **CRITICAL**: 4,893 files in `archive/` directory (98% duplication)
- Multiple `laraxot.md` duplicates (8,831 lines each)

**Key Documents:**
- [`xot-engine.md`](../Xot/docs/xot-engine.md) - **SSOT**
- [`testing-best-practices.md`](../Xot/docs/testing-best-practices.md) - **SSOT**
- [`module-architecture.md`](../Xot/docs/module-architecture.md) - **SSOT**

**Deprecated:**
- `archive/` directory - **IMMEDIATE DELETION RECOMMENDED**
- `consolidated/archive/` - **IMMEDIATE DELETION RECOMMENDED**
- `historical/` subdirectories - **IMMEDIATE DELETION RECOMMENDED**

**Cross-References:**
- **Base framework for all modules**
- Related: [Laraxot Documentation](viking://docs/project/laraxot.md)

---

## Topic-Based Index

### Architecture

**Single Sources of Truth:**
1. [`Xot/docs/module-architecture.md`](../Xot/docs/module-architecture.md) - Core architecture
2. [`Xot/docs/xot-engine.md`](../Xot/docs/xot-engine.md) - Xot engine
3. [`UI/docs/architecture.md`](../UI/docs/architecture.md) - UI architecture

**Related:**
- `Cms/docs/folio-routing-locale.md`
- `User/docs/gdpr-compliance.md`

---

### Testing

**Single Sources of Truth:**
1. [`Xot/docs/testing-best-practices.md`](../Xot/docs/testing-best-practices.md) - **MASTER GUIDE**
2. [`Xot/docs/testing/pest-complete-guide.md`](../Xot/docs/testing/pest-complete-guide.md)

**Module-Specific:**
- `Activity/docs/coverage-full.md` (⚠️ too large)
- `User/docs/coverage-full.md` (⚠️ too large)
- `Geo/docs/coverage-full.md` (⚠️ too large)

---

### Quality

**Single Sources of Truth:**
1. [`Xot/docs/quality/phpstan-level-10-enforcement.md`](../Xot/docs/quality/phpstan-level-10-enforcement.md) - **MASTER GUIDE**
2. [`Xot/docs/phpstan-code-quality-guide.md`](../Xot/docs/phpstan-code-quality-guide.md)

**Module-Specific:**
- All modules have `phpstan-*.md` files - **CONSOLIDATE INTO MASTER**

---

### Translations
1. [`Lang/docs/translation_system.md`](../Lang/docs/translation_system.md) - **MASTER GUIDE**
2. [`Lang/docs/translation_keys_best_practices.md`](../Lang/docs/translation_keys_best_practices.md)

**Related:**
- `Xot/docs/translation-rules-1.md`
- `UI/docs/translations-update-january-2026.md`

---

### BMAD & Context Engineering

**Single Sources of Truth:**
1. [`docs/wiki/concepts/bmad-method.md`](../../../docs/wiki/concepts/bmad-method.md) - **BMAD MASTER GUIDE**
2. [`docs/wiki/concepts/context-engineering.md`](../../../docs/wiki/concepts/context-engineering.md) - **CONTEXT MASTER GUIDE**
3. [`docs/wiki/concepts/context-memory-compaction-rule.md`](../../../docs/wiki/concepts/context-memory-compaction-rule.md) - **COMPACTION RULE**

**Module-Specific Adoption:**
- [`laravel/Modules/docs/llm-wiki.md`](llm-wiki.md) - How modules participate in LLM Wiki

---

### Filament

**Single Sources of Truth:**
1. [`UI/docs/filament-components-usage.md`](../UI/docs/filament-components-usage.md) - **MASTER GUIDE**
2. [`Cms/docs/FILAMENT-RESOURCE-GUIDELINES.md`](../Cms/docs/FILAMENT-RESOURCE-GUIDELINES.md)

**Related:**
- `Xot/docs/volt-folio-best-practices.md`
- `UI/docs/filament-blade-components-usage.md`

---

### Routing

**Single Sources of Truth:**
1. [`Cms/docs/folio-routing-locale.md`](../Cms/docs/folio-routing-locale.md) - **MASTER GUIDE**

**Related:**
- `UI/docs/folio-volt-best-practices.md`
- `Xot/docs/volt-folio-best-practices.md`

---

## Deprecated Documents

### Marked for Deletion

**Archive Directories (IMMEDIATE):**
```
laravel/Modules/Xot/docs/archived/ (4,893 files)
laravel/Modules/Cms/docs/archived/ (793 files)
laravel/Modules/User/docs/archived/ (1,000+ files)
laravel/Modules/Lang/docs/archived/ (700+ files)
laravel/Modules/UI/docs/archived/ (400+ files)
```

**Exact Duplicates (by MD5 hash):**
- See [DOCUMENTATION_AUDIT.md](DOCUMENTATION_AUDIT.md) for complete list

**Naming Variants:**
- `*_*.md` → `*-*-*` (snake_case to kebab-case)
- `*-.md` → delete (trailing hyphen)
- `*-1.md` → merge or delete

---

## OpenViking URIs

**Master Documents (use these URIs):**
```
viking://modules/xot/docs/xot-engine.md
viking://modules/xot/docs/module-architecture.md
viking://modules/lang/docs/translation_system.md
viking://modules/ui/docs/filament-components-usage.md
viking://modules/cms/docs/content-blocks-system.md
```

---

## Maintenance

### Monthly Audit Checklist
- [ ] Check for new duplicates
- [ ] Verify all files <1000 lines
- [ ] Update deprecated markers
- [ ] Refresh OpenViking URIs

### Governance Rules
1. **DRY**: No topic duplication across modules
2. **KISS**: Files <500 lines, flat structure
3. **Forward-Only**: Mark DEPRECATED, never delete
4. **Single Source**: One master document per topic

---

**Index Generated:** 2026-03-30  
**Next Review:** 2026-04-30  
**Owner:** Documentation Governance Team

---

*For detailed audit findings, see [DOCUMENTATION_AUDIT.md](DOCUMENTATION_AUDIT.md)*
