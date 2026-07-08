# 🎨 Semantic CSS - AI Agents Documentation

**Path**: `bashscripts/ai/.agents/docs/frontend/semantic-css.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ CANONICAL  
**Version**: 1.0

---

## 🎯 Core Principle

> **"Name classes based on what an element *is*, not what it *looks like*."**

**Source**: [MaintainableCSS Chapter 2 - Semantics](https://maintainablecss.com/chapters/semantics/)

---

## 📋 Quick Reference

### ✅ DO - Semantic Classes

```html
<!-- ✅ Semantic: describes purpose -->
<div class="hero">
  <h1 class="hero-title">Heading</h1>
  <p class="hero-tagline">Tagline</p>
</div>

<div class="outcomes-grid">
  <x-predict.outcome-card />
</div>
```

### ❌ DON'T - Visual/Atomic Classes

```html
<!-- ❌ Visual: describes appearance -->
<div class="red pull-left pb3">
<div class="grid row">
<div class="col-xs-4">
<div class="pb3 pb4-ns pt4 pt5-ns mt4 black-70 fl-l w-50-l">
```

---

## 🔧 Application to Laraxot

### Blade Components

```blade
{{-- ✅ CORRETTO: Semantic Blade --}}
<x-predict.hero :title="$title" :tagline="$tagline" />
<x-predict.outcomes-grid :outcomes="$outcomes" />

{{-- ❌ SBAGLIATO: Utility classes --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  @foreach($outcomes as $outcome)
    <div class="bg-white rounded-lg shadow p-4">
      {{ $outcome->title }}
    </div>
  @endforeach
</div>
```

### Filament Widgets

```php
// ✅ CORRETTO: Filament Table Widget (Rule 005)
class OutcomesTableWidget extends XotBaseTableWidget
{
    public function table(Table $table): Table
    {
        return $table->searchable()->filters([...])->columns([...]);
    }
}

// ❌ SBAGLIATO: Custom Blade con utility
```

---

## 📚 Full Documentation

### For Module Developers

- [Semantic CSS Principles](../../../../laravel/Modules/Predict/docs/SEMANTIC_CSS_PRINCIPLES.md) - Complete guide
- [Blade Minimal Logic](../../../../laravel/Modules/Predict/docs/BLADE_MINIMAL_LOGIC_BEST_PRACTICES.md) - Blade patterns

### For Theme Developers

- [TwentyOne Semantic CSS Guide](../../../../laravel/Themes/TwentyOne/docs/SEMANTIC_CSS_GUIDE.md) - Theme-specific guide

### Rules & Enforcement

- [Semantic CSS Rule](../../rules/frontend/semantic-css-rule.md) - **MANDATORY** rule
- [Frontend Rules Index](../../rules/frontend/00-INDEX.md) - All frontend rules

---

## 🚨 Common Violations

### Violation 1: Visual Naming

```blade
{{-- ❌ VIOLATION --}}
<div class="black-70 pull-left w-50-l">

{{-- ✅ FIX --}}
<div class="hero">
```

### Violation 2: Atomic Classes

```blade
{{-- ❌ VIOLATION --}}
<div class="pd20 pd50-ns fs2 fs3">

{{-- ✅ FIX --}}
<div class="product-card">
```

### Violation 3: Responsive in HTML

```blade
{{-- ❌ VIOLATION --}}
<div class="pb3 pb4-ns pt4 pt5-ns">

{{-- ✅ FIX --}}
<div class="hero-section">
/* CSS handles responsiveness via media queries */
```

---

## ✅ Enforcement Checklist

- [ ] **Code Review**: Check for semantic class names
- [ ] **Blade Audit**: Search for utility classes (`.py-`, `.px-`, `.grid-`)
- [ ] **CSS Migration**: Move responsive logic from HTML to CSS
- [ ] **Documentation**: Update module/theme docs with examples

---

## 🔗 Related Documents

- [Rule 005: Filament Table for Lists](../../rules/filament/005-filament-table-for-lists.md)
- [Container Blade Agnostic Rule](../../rules/frontend/container-blade/agnostic-rule.md)
- [Component-First Architecture](../../../../laravel/Modules/Predict/docs/PHILOSOPHY_AND_VISION.md)

---

**Maintained By**: AI Agents Team  
**Last Review**: 2026-03-26  
**Next Review**: 2026-04-26  
**Enforcement**: MANDATORY
