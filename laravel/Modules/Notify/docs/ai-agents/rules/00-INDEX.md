# 🔴 CRITICAL RULES - AI Agents

**Path**: `./.agents/docs/rules/00-INDEX.md`  
**Last Updated**: 2026-03-26  
**Status**: ✅ ALWAYS ACTIVE  
**Priority**: BLOCKER (violation = STOP immediately)

---

## 🎯 Rule #1: Filament Tables for Lists

> **MAI** creare blade personalizzati per liste di outcomes, predict, o dati tabellari.
> **SEMPRE** usare Filament Table Widget che ha già:
> - ✅ Search (debounce 400ms)
> - ✅ Sorting (multi-column)
> - ✅ Filters (status, category, date, hot)
> - ✅ Pagination (12/24/48)
> - ✅ CSS hooks (fi-ta-*)
> - ✅ Livewire reactivity
> - ✅ URL synchronization
> - ✅ Export ready
> - ✅ Accessibility built-in

### ✅ CORRECT - Filament Table Widget

```php
// ✅ CORRETTO - Filament Table Widget
class PredictTableWidget extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->searchable()      // ← Automatic search
            ->filters([...])    // ← Automatic filters
            ->columns([         // ← Automatic sorting
                TextColumn::make('title')->sortable(),
                TextColumn::make('probability')->sortable(),
            ]);
    }
}
```

### ❌ WRONG - Custom Blade

```blade
{{-- ❌ SBAGLIATO - Custom blade con loop manuale --}}
@foreach($outcomes as $outcome)
    <div class="outcome-card">
        {{ $outcome['title'] }}
        {{ $outcome['probability'] }}%
    </div>
@endforeach

{{-- ❌ Implementazione manuale di search, sorting, filters --}}
<input type="text" wire:model.debounce.400ms="search" />
{{-- MAI FARE QUESTO! Filament lo fa già --}}
```

---

## 🎯 Rule #2: Multi-Outcome Universal

> **TUTTO è multi-risposta** (anche SÌ/NO = 2 outcomes)
> - SÌ/NO = 2 outcomes (caso particolare)
> - F1 = 6 outcomes (caso generale)
> - Politica = 10+ outcomes (caso esteso)
> - **NON ESISTE** dicotomia binary vs multi-outcome

### ✅ CORRECT - Universal Approach

```php
// ✅ CORRETTO - Tutti gli outcomes trattati allo stesso modo
foreach ($outcomes as $outcome) {
    // Funziona per F1 (6), Politica (10), Binary (2)
}
```

### ❌ WRONG - Binary Dichotomy

```php
// ❌ SBAGLIATO - Distinzione binary vs multi
if ($isBinary) {
    // logica speciale per YES/NO
} else {
    // logica per multi-outcome
}
```

---

## 🎯 Rule #3: Container Agnostic

> **MAI** logica specifica nel container blade
> Container deve essere **agnostico** (predicts, articles, events, etc.)

### ✅ CORRECT - Agnostic Container

```blade
{{-- ✅ CORRETTO - Container agnostico --}}
<div>
    @livewire('view-predict-widget', ['predict' => $predict])
</div>
```

### ❌ WRONG - Container Pollution

```blade
{{-- ❌ SBAGLIATO - Logica specifica nel container --}}
@if($container0 === 'predicts')
    {{-- domain logic --}}
@endif
```

---

## 🎯 Rule #4: Actions Over Services

> **USARE** Actions per business logic
> **MAI** creare Service classes

### ✅ CORRECT - Action Class

```php
// ✅ CORRETTO - Action class
class BuildOutcomesAction extends Action
{
    public function execute(Predict $predict): array
    {
        // Business logic here
    }
}
```

### ❌ WRONG - Service Class

```php
// ❌ SBAGLIATO - Service class
class OutcomeService
{
    // MAI FARE QUESTO!
}
```

---

## 🎯 Rule #5: PHPStan Level MAX

> **SEMPRE** PHPStan Level MAX dopo modifiche PHP
> **MAI** ignorare errori PHPStan

```bash
# ✅ SEMPRE eseguire prima di commit
composer phpstan
# MUST PASS: 0 errors
```

---

## 📋 Pre-Commit Checklist

**BEFORE** any `git commit`:

- [ ] ✅ PHPStan: 0 errors
- [ ] ✅ PHPInsights: Quality > 90%
- [ ] ✅ Laravel Pint: Code formatted
- [ ] ✅ Pest Tests: All passing
- [ ] ✅ Screenshots: Page verified
- [ ] ✅ Documentation: Indices updated
- [ ] ✅ Cache: Cleared
- [ ] ✅ **Filament Tables used (NOT custom blade)**

**IF ANY CHECK FAILS** → **DO NOT COMMIT**

---

## 🔗 Related Documentation

### Project Rules
- **[00-INDEX.md](00-INDEX.md)** - Master rules index
- **[multi-outcome-universal.md](multi-outcome-universal.md)** - Multi-outcome principle
- **[container-agnostic.md](container-agnostic.md)** - Container agnostic rule
- **[actions-over-services.md](actions-over-services.md)** - Actions over services

### Guidelines
- **[../guidelines/00-INDEX.md](../guidelines/00-INDEX.md)** - Guidelines index
- **[../guidelines/filament-tables.md](../guidelines/filament-tables.md)** - Filament tables guide

### Skills
- **[../skills/filament-tables.md](../skills/filament-tables.md)** - Filament tables skill
- **[../skills/laravel-best-practices.md](../skills/laravel-best-practices.md)** - Laravel best practices

---

## 📝 Changelog

### 2026-03-26 - CRITICAL UPDATE
- ✅ Added Rule #1: Filament Tables for Lists (BLOCKER)
- ✅ Updated pre-commit checklist
- ✅ Added examples (CORRECT vs WRONG)

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Per-release  
**Next Review**: 2026-04-02  
**Enforcement**: 🔴 CRITICAL rules are BLOCKERS
