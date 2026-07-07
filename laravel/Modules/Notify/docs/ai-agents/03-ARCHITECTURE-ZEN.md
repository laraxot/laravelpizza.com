# 🏛️ Architecture Zen Philosophy

**Part of**: [00-INDEX.md](00-INDEX.md) — AI Agents Coordination  
**Related**: [04-FILAMENT-PHILOSOPHY.md](04-FILAMENT-PHILOSOPHY.md) — Filament Widgets

---

## 🔴 Fundamental Rules

### 1. **NO Themes/*/Http/Livewire/**

**Philosophy**: Theme is the DRESS, not the LOGIC.

```
❌ WRONG
Themes/TwentyOne/Http/Livewire/
Themes/Sixteen/Http/Livewire/

✅ CORRECT
Modules/Predict/app/Filament/Widgets/
Modules/UI/app/Filament/Widgets/
```

**Why**:
- **Modules** = Business logic (agnostic, reusable)
- **Themes** = Dress (aesthetics, layout, CSS)
- **Filament Widgets** = UI components (back office + front office)
- **NO Livewire in theme** = Separation of concerns

---

### 2. **NO laravel/docs/**

**Philosophy**: Documentation distributed, close to code.

```
❌ WRONG
laravel/docs/
  ├── COMPOSER_RULE.md
  └── FILAMENT_RULE.md

✅ CORRECT
docs/                          # Only CROSS-MODULE documents
  ├── ARCHITECTURE_ZEN.md
  └── MULTI_AGENT_COORDINATION.md

Modules/Predict/docs/          # Predict-specific docs
  ├── PHILOSOPHY.md
  ├── WIDGETS.md
  └── SEEDERS.md

Themes/TwentyOne/docs/         # Theme-specific docs
  ├── DESIGN_SYSTEM.md
  └── KINETIC_WEB_DESIGN.md
```

**Why**:
- **Documentation close to code** = Easier to maintain
- **docs/ root** = Only cross-module documents
- **Module docs** = Module-specific documentation
- **Theme docs** = Theme-specific design system

---

### 3. **NO foreach in blade for lists**

**Philosophy**: Filament Tables does everything.

```blade
❌ WRONG
@foreach($predicts as $predict)
    <div class="card">{{ $predict->title }}</div>
@endforeach

✅ CORRECT
<x-page side="content" slug="predicts.index" />

// JSON: predicts.index.json
{
  "type": "widget",
  "data": {
    "view": "pub_theme::filament.widgets.predict-table",
    "widget": "Modules\\Predict\\Filament\\Widgets\\PredictTableWidget"
  }
}
```

**Why**:
- **Filament Table** = Search, filters, sorting, pagination (automatic)
- **NO foreach** = NO logic in blade
- **Widget** = Reusable, testable, maintainable

---

### 4. **NO Blade Logic**

**Philosophy**: Blade is presentation only.

```blade
❌ WRONG
@php
    $probability = $predict->transactions()->sum('amount');
    $participants = $predict->transactions()->distinct('user_id')->count();
@endphp

✅ CORRECT
// Action class
class CalculatePredictStatsAction {
    public function execute(Predict $predict): array {
        return [
            'probability' => $predict->transactions()->sum('amount'),
            'participants' => $predict->transactions()->distinct('user_id')->count(),
        ];
    }
}

// Blade
{{ $stats['probability'] }}
```

**Why**:
- **Blade** = Presentation only (HTML, CSS classes)
- **Actions** = Business logic
- **Components** = Complex presentation logic

---

## 🧠 Zen Philosophy

### Theme is the Dress

> **"Module is the body, theme is the dress"**

**Module (Body)**:
- ✅ Business logic
- ✅ Data models
- ✅ Filament Widgets
- ✅ Actions, Services
- ✅ Seeders, Migrations

**Theme (Clothing)**:
- ✅ Layout (app.blade.php)
- ✅ CSS (Tailwind)
- ✅ Aesthetic components
- ✅ Folio pages (routing)
- ❌ NO business logic
- ❌ NO Livewire
- ❌ NO Models

---

### Filament Widgets are Universal

> **"One widget for all themes"**

```
Modules/Predict/app/Filament/Widgets/PredictTableWidget.php
    ↓
pub_theme::filament.widgets.predict-table (view namespace)
    ↓
Themes/TwentyOne/resources/views/filament/widgets/predict-table.blade.php
```

**Benefits**:
- ✅ Widget written ONCE
- ✅ Used in ALL themes
- ✅ Theme customizes only view
- ✅ Logic ALWAYS in module

---

### Documentation is Treasure Map

> **"Documentation close to code = Treasure found"**

```
Modules/Predict/
├── app/
│   ├── Models/
│   ├── Filament/
│   └── Actions/
├── docs/              ← Treasure map of Predict
│   ├── PHILOSOPHY.md
│   ├── WIDGETS.md
│   └── SEEDERS.md
└── database/
    └── seeders/
```

**Rule**:
- **docs/ root** = Only cross-module documents
- **Module docs** = Module-specific
- **Theme docs** = Design system, CSS

---

## 🚨 Common Mistakes

### 1. ❌ Livewire in Theme

```
Themes/TwentyOne/Http/Livewire/
```

**✅ CORRECT**:
```
Modules/Predict/app/Filament/Widgets/
```

---

### 2. ❌ Documentation in root

```
laravel/docs/
  └── FILAMENT_RULE.md
```

**✅ CORRECT**:
```
docs/
  └── ARCHITECTURE_ZEN.md

Modules/Predict/docs/
  └── WIDGETS.md
```

---

### 3. ❌ Foreach in blade

```blade
@foreach($predicts as $predict)
    <x-predict.card :predict="$predict"/>
@endforeach
```

**✅ CORRECT**:
```blade
<x-page side="content" slug="predicts.index" />

// JSON
{
  "type": "widget",
  "widget": "Modules\\Predict\\Filament\\Widgets\\PredictTableWidget"
}
```

---

### 4. ❌ Logic in blade

```blade
@php
    $volume = $predict->transactions()->sum('amount');
@endphp
```

**✅ CORRECT**:
```php
// Action
class CalculateVolumeAction {
    public function execute(Predict $predict) {
        return $predict->transactions()->sum('amount');
    }
}

// Blade
{{ $volume }}
```

---

## ✅ Code Review Checklist

Before committing:

### Architecture
- [ ] ✅ NO `Themes/*/Http/Livewire/`
- [ ] ✅ Widgets in `Modules/*/Filament/Widgets/`
- [ ] ✅ NO `laravel/docs/` (use `docs/` or `Modules/*/docs/`)
- [ ] ✅ NO foreach in blade for lists (use Filament Table)
- [ ] ✅ NO logic in blade (use Actions)

### Documentation
- [ ] ✅ Documentation close to code
- [ ] ✅ docs/ root = only cross-module
- [ ] ✅ Module docs = module-specific
- [ ] ✅ Theme docs = design system, CSS

### Enforcement
- [ ] ✅ PHPStan: NO errors
- [ ] ✅ PHPMD: NO warnings
- [ ] ✅ Code Review: Architecture check
- [ ] ✅ Pre-commit hook: Architecture validation

---

## 🔗 Related Documentation

- **Filament Philosophy**: [04-FILAMENT-PHILOSOPHY.md](04-FILAMENT-PHILOSOPHY.md)
- **Front Office Audit**: [05-FRONT-OFFICE-AUDIT.md](05-FRONT-OFFICE-AUDIT.md)
- **External**: https://github.com/nWidart/laravel-modules

---

**Last Updated**: 2026-03-20  
**Status**: ✅ Mandatory  
**Enforcement**: PHPStan + Code Review + Pre-commit Hook
