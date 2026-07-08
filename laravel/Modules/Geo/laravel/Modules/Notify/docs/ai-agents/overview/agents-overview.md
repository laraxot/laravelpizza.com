# 🎯 AI Agents Overview

**File**: `.agents/docs/overview/agents-overview.md`  
**Ultimo Aggiornamento**: 2026-03-20  
**Stato**: ✅ OPERATIONAL

---

## 📊 Project Stack

### Core Technology
- **PHP 8.3+** - Strict typing, latest features
- **Laravel 12** - Latest LTS version
- **Filament v5** - Admin panel, widgets, tables
- **Livewire v4** - Reactive components
- **Nwidart Laravel Modules** - Modular architecture
- **Tailwind CSS v4** - Utility-first CSS

### Development Tools
- **Pest PHP** - Testing framework
- **PHPStan Level MAX** - Static analysis
- **PHPMD .phar** - Mess detection (NOT composer)
- **PHPInsights** - Quality metrics
- **Laravel Pint** - Code formatting

### Architecture Patterns
- **Folio** - File-based routing (NO controllers)
- **Volt** - Functional Livewire API
- **XotBase** - Base classes per moduli
- **CMS JSON** - Configuration-driven content

---

## 🧠 User Preferences

### Communication
- ✅ **Rispondi sempre in italiano**
- ✅ **Sii conciso e diretto** (CLI environment)
- ✅ **Meno di 3 righe** di testo (escludendo tool use)
- ✅ **Niente chitchat** - Vai dritto al punto

### Coding Style
- ✅ **Blade minimal logic** - Logica in Actions/Components
- ✅ **Moduli agnostici** - Riusabili in altri progetti
- ✅ **Type hints** - Sempre parametri e return types
- ✅ **PHPDoc blocks** - Solo per classi (no inline comments)

### Front Office Architecture
- ✅ **Folio + Volt + Laraxot** - NIENTE controllers
- ✅ **NIENTE rotte dedicate** - File-based routing
- ✅ **NIENTE `Themes/Http/Livewire/`** - Solo Filament Widgets
- ✅ **NIENTE emoji** - SVG inline o `@svg()`

### Git Workflow
- ✅ **Forward-only** - NIENTE rollback
- ✅ **Quality gate** - PHPStan, PHPMD, PHPInsights, Pest
- ✅ **Commit atomici** - Un commit per task
- ✅ **Push immediato** - Dopo ogni commit

---

## 🔴 Critical Rules

### 1. Filament Widgets for Lists

**❌ MAI**:
```blade
@foreach($items as $item)
    <div>{{ $item->title }}</div>
@endforeach
```

**✅ SEMPRE**:
```blade
@livewire(\Modules\Predict\Filament\Widgets\PredictTableWidget::class)
```

**Perché**:
- Search automatica (debounce 400ms)
- Filters automatici
- Sorting automatico
- Pagination automatica
- 91% meno codice

**Reference**: `../rules/agents-filament-tables-rule.md`

### 2. NO /tmp Usage

**❌ MAI**:
```php
/tmp/file.txt
/var/tmp/file.txt
sys_get_temp_dir()
```

**✅ SEMPRE**:
```php
storage_path('app/temp/file.txt')
storage_path('framework/cache')
Themes/TwentyOne/docs/screenshots/
```

**Reference**: `../rules/agents-no-tmp-rule.md`

### 3. NO Emoji in Front Office

**❌ MAI**:
```blade
🔥 HOT
⭐ Featured
⚡ Fast
```

**✅ SEMPRE**:
```blade
<x-heroicon-o-fire class="w-4 h-4" />
@svg('heroicon-o-star', 'w-4 h-4')
```

**Reference**: `../rules/agents-no-emoji-frontoffice.md`

### 4. Module Agnosticism

**❌ MAI**:
```php
\Modules\Blog\Models\User::count()
```

**✅ SEMPRE**:
```php
$userClass = \Modules\Xot\Datas\XotData::make()->getUserClass();
$userClass::query()->count()
```

**Perché**: I moduli devono essere agnostici e riusabili.

---

## 🎯 Quality Gate

### Prima di Commit

```bash
# 1. PHPStan
vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=2G

# 2. PHPMD (.phar)
php phpmd.phar . text cleancode,codesize,controversial,design,naming,unusedcode

# 3. PHPInsights
vendor/bin/phpinsights analyze --fix

# 4. Pest
vendor/bin/pest --coverage
```

### Target Metrics
- **PHPStan**: NO errors
- **PHPMD**: NO warnings
- **PHPInsights**: Quality > 90%
- **Pest**: Coverage > 80%

**Reference**: `../workflow/agents-quality-gate.md`

---

## 📚 Documentation Structure

### This Hub
- `overview/` - Panoramica e contesto
- `workflow/` - GSD/BMAD, quality gate
- `architecture/` - Moduli, Filament, temi
- `standards/` - Coding standards, error handling
- `rules/` - Regole specifiche progetto
- `memory/` - Lessons learned

### Project Docs
- `docs/project/` - Documentazione condivisa
- `Modules/*/docs/` - Documentazione modulo
- `Themes/*/docs/` - Documentazione tema

---

## 🔄 Workflow

### GSD Methodology
1. **Discuss** - `/gsd-discuss-phase N`
2. **Plan** - `/gsd-plan-phase N`
3. **Execute** - `/gsd-execute-phase N`
4. **Verify** - `/gsd-verify-work N`

**Reference**: `../workflow/agents-gsd-bmad.md`

### Error Fix Workflow
1. Study `docs/` of involved modules
2. Inspect Git history
3. Reason about business purpose
4. Work forward-only (no rollback)
5. Update persistent knowledge
6. Evaluate GitHub Issue/Discussion
7. Implement and verify

---

## 📊 Metrics

### Current Status
- **Moduli**: 19 enabled
- **Filament**: v5.4.1
- **Livewire**: v4.2.1
- **Laravel**: v12.55.1
- **PHP**: v8.3.30

### Quality Metrics
- **PHPStan**: Level MAX
- **Test Coverage**: > 80%
- **Code Quality**: > 90%
- **Accessibility**: WCAG 2.2 AA

---

## 📖 Quick Links

### Getting Started
- [Coding Standards](../standards/agents-coding-standards.md)
- [Module Architecture](../architecture/agents-module-architecture.md)
- [Quality Gate](../workflow/agents-quality-gate.md)

### Critical Rules
- [Filament Tables Rule](../rules/agents-filament-tables-rule.md)
- [NO /tmp Rule](../rules/agents-no-tmp-rule.md)
- [NO Emoji Rule](../rules/agents-no-emoji-frontoffice.md)

### Workflow
- [GSD/BMAD](../workflow/agents-gsd-bmad.md)
- [Multi-Agent Coordination](../workflow/agents-multi-agent-coordination.md)

---

**Ultimo Aggiornamento**: 2026-03-20  
**Stato**: ✅ OPERATIONAL  
**Prossima Review**: 2026-03-27
