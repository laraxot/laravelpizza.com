# 📋 Front Office Pages Audit Checklist

**Part of**: [00-INDEX.md](00-INDEX.md) — AI Agents Coordination  
**Related**: [03-ARCHITECTURE-ZEN.md](03-ARCHITECTURE-ZEN.md) — Architecture

---

## 🔍 Mandatory Checklist (Before Commit)

### 1. Routing Multilingual
- [ ] ✅ URLs with language prefix (`/it/`, `/en/`)
- [ ] ✅ Links use `url(app()->getLocale().'/path')`
- [ ] ✅ NO hardcoded links (`/predicts`, `/register`)

### 2. Filament Forms & Tables
- [ ] ✅ Forms use Filament Form Widget (NOT custom blade)
- [ ] ✅ Tables use Filament Table Widget (NOT custom grid)
- [ ] ✅ Search, filters, sorting with Filament

### 3. NO /tmp Folder
- [ ] ✅ NO usage of `/tmp` or `sys_get_temp_dir()`
- [ ] ✅ Temp files use `storage_path('app/temp/')`

### 4. NO Emoji Front Office
- [ ] ✅ NO emoji in blade (use SVG or `@svg()`)
- [ ] ✅ Icons with `<x-filament::icon>` or Heroicons

### 5. Real Data (NO Mock)
- [ ] ✅ Data from database
- [ ] ✅ NO hardcoded values

### 6. Web Design Checklist (31 sources)
- [ ] ✅ Mobile First (touch targets ≥ 44x44px)
- [ ] ✅ Accessibility (ARIA labels, focus indicators)
- [ ] ✅ Kinetic animations (hover, transitions)
- [ ] ✅ Micro-interactions (6 types)
- [ ] ✅ Core Web Vitals (LCP < 2.5s, INP < 200ms)

### 7. Quality Gate
- [ ] ✅ PHPStan: NO errors
- [ ] ✅ PHPMD: NO warnings
- [ ] ✅ PHPInsight: Quality > 90%
- [ ] ✅ Pest: Test passing

---

## 📁 Pages to Audit

### Theme Pages (38 total)

| Category | Count | Status |
|----------|-------|--------|
| **Root Pages** | 6 | ⚠️ Audit |
| **Auth Pages** | 7 | ⚠️ Audit |
| **Content Pages** | 7 | ⚠️ Audit |
| **Feature Pages** | 10 | ⚠️ Audit |
| **Legacy/Test** | 8 | ❌ Remove |

### Predict Components (50+)

| Category | Count | Status |
|----------|-------|--------|
| **Home Blocks** | 10 | ⚠️ Audit |
| **Predict Components** | 15 | ⚠️ Audit |
| **Article List** | 20+ | ⚠️ Audit |
| **Shared Components** | 10+ | ⚠️ Audit |

---

## 🚨 Priority Errors

### Priority 1 (CRITICAL)
1. ❌ Custom forms in blade → Migrate to Filament Form Widgets
2. ❌ Custom table grids → Migrate to Filament Table Widgets
3. ❌ Legacy pages (hello, prova, test) → Remove

### Priority 2 (HIGH)
4. ❌ Dashboard stats custom → Migrate to Filament Stats Widgets
5. ❌ Manual search/filters → Migrate to Filament filters

### Priority 3 (MEDIUM)
6. ⚠️ Accessibility (ARIA labels) → Improve
7. ⚠️ Micro-interactions → Add
8. ⚠️ Core Web Vitals → Optimize

---

## 🔗 Related Documentation

- **Architecture**: [03-ARCHITECTURE-ZEN.md](03-ARCHITECTURE-ZEN.md)
- **Filament**: [04-FILAMENT-PHILOSOPHY.md](04-FILAMENT-PHILOSOPHY.md)
- **Cinematic**: [06-CINEMATIC-EFFECTS.md](06-CINEMATIC-EFFECTS.md)
- **Full Audit**: `docs/project/FRONT_OFFICE_PAGES_AUDIT.md`

---

**Last Updated**: 2026-03-20  
**Status**: ✅ Mandatory  
**Enforcement**: Code Review + Pre-commit Hook
