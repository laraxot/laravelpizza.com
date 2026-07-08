---
title: "Story #SU-2026-06-15: Unify Scheda Model Hierarchy"
type: story
status: analysis
priority: high
epic: "Architecture: Module Inheritance & DRY"
phase: architecture
created: 2026-06-15
sprint: "PHPStan Quality Gate"
tags: [architecture, laravel-models, dry, inheritance, refactoring]
related:
  - doc: "docs/wiki/rules/eloquent-relationship-encapsulation.md"
  - doc: "docs/wiki/rules/module-hierarchy-inheritance-pattern.md"
  - doc: "laravel/Modules/Ptv/docs/architecture-overview.md"
  - issue: "github-issue-scheda-inheritance-refactor"
---

# Story: Unify Scheda Model Hierarchy — Progressioni & Legge104 Extend Ptv::BaseScheda

## Context

### The Problem (Current State — WRONG) ❌

**Current Architecture:**
```
Ptv/BaseScheda              ← Base model with all relations
Ptv/Scheda                  ← Ptv concrete (extends BaseScheda)
Progressioni/Scheda         ← Independent model (DUPLICATES from Ptv)
Legge104/Scheda             ← Independent model (DUPLICATES from Ptv)
```

**Symptom:** Action `ListaAszTipCodEsclusoSubito.php` manually reimplements query logic instead of using `$scheda->asz()` relationship:

```php
// ❌ WRONG: Reimplements BaseScheda relationship logic
$table = (new Asz00k1)->getTable();
$tmp = Asz00k1::query()
    ->where($table.'.matr', $matr)
    ->where($table.'.ente', $scheda->ente ?? 90)
    ->where($table.'.aszann', '')
    ->ofRangeDate((int) $asz_dal, (int) $asz_al)
    ->select('asztip', 'aszcod')
    ->distinct()
    ->get()
    ->toArray();
```

**Root Cause:** `Progressioni/Scheda` is not a proper specialization of `BaseScheda`, so actions in Progressioni can't rely on inherited relationships.

### Target State (After Refactor) ✅

**Correct Architecture:**
```
Ptv/BaseScheda              ← Base model (asz(), valutatori(), etc)
  ↑ extends
Ptv/Scheda                  ← Ptv concrete (add Ptv-specific overrides)
  ↑ extends
Progressioni/Scheda         ← Progressioni specialization
Legge104/Scheda             ← Legge104 specialization

AND

SchedaContract              ← Unified interface (NOT ProgressioneSchedaContract)
  ↑ implements
All Scheda models
```

**Usage in Action (After Refactor):**
```php
// ✅ RIGHT: Uses inherited relationship
$tmp = $scheda->asz()  // Inherited from BaseScheda
    ->ofRangeDate($asz_dal, $asz_al)
    ->select('asztip', 'aszcod')
    ->distinct()
    ->get()
    ->toArray();
```

## User Story

**As a** Laraxot Architect  
**I want to** unify the Scheda model hierarchy so Progressioni and Legge104 properly extend BaseScheda  
**So that** code duplication is eliminated, relationships are inherited, and we follow the DRY principle across our modular monorepo

## Acceptance Criteria

### Phase 1: Analysis & Planning
- [ ] Document current model hierarchy (this story)
- [ ] List all properties/methods/relationships in:
  - `Ptv/BaseScheda`
  - `Progressioni/Scheda` (compare for duplication)
  - `Legge104/Scheda` (compare for duplication)
- [ ] Identify Progressioni-specific overrides (if any)
- [ ] Identify Legge104-specific overrides (if any)
- [ ] Create refactoring checklist (step-by-step)
- [ ] Create CARDINAL RULE documentation: "Module Inheritance Patterns in Modular Monorepo"

### Phase 2: Contract Unification
- [x] Remove `ProgressioneSchedaContract`
- [x] `SchedaContract` con `@method asz()` (STORY-002)
- [x] `ListaAszTipCodEsclusoSubito` → `SchedaContract`
- [ ] Update stale Sigma docs

### Phase 3: Model Hierarchy Implementation
- [x] `Progressioni/Scheda extends Ptv/BaseScheda`
- [ ] Make `Legge104/Scheda extends Ptv/BaseScheda`
- [ ] Remove duplicated properties from child models
- [ ] Remove duplicated relationships from child models
- [ ] Remove duplicated methods from child models
- [ ] Add Progressioni-specific overrides (if needed)
- [ ] Add Legge104-specific overrides (if needed)

### Phase 4: Action Code Cleanup
- [ ] Audit `Progressioni/app/Actions/*` for manual query duplicates
- [ ] Replace `Asz00k1::query()->where()` with `$scheda->asz()`
- [ ] Replace `Valutatore::query()->where()` with `$scheda->valutatori()`
- [ ] Audit `Legge104/app/Actions/*` for same pattern
- [ ] Verify all tests pass after refactoring

### Phase 5: Documentation & Knowledge Base
- [ ] Create `CARDINAL RULE: Module Inheritance Patterns` in wiki
- [ ] Document "Progressioni as Specialization" architecture decision
- [ ] Update Trigger Map with this rule
- [ ] Update second brain memory
- [ ] Create audit script: `audit-model-inheritance-duplication.sh`

### Phase 6: Verification
- [ ] PHPStan analysis passes (level max)
- [ ] All tests pass
- [ ] No regressions in Progressioni functionality
- [ ] No regressions in Legge104 functionality
- [ ] Code review approval

## Implementation Details

### Model Class Diagram

```
┌─────────────────────────────┐
│   Xot\Contracts\BaseModel   │ ← Framework base
└──────────────┬──────────────┘
               │ implements
┌──────────────▼──────────────┐
│   SchedaContract (Ptv)      │ ← Unified interface
└──────────────┬──────────────┘
               │ implements
┌──────────────▼──────────────┐
│   BaseScheda (Ptv)          │ ← Full implementation
│ ├─ relations: asz(),        │
│ │             valutatori(), │
│ │             criteria()     │
│ ├─ methods:                 │
│ │ ├─ canAccessTenant()      │
│ │ ├─ getTenants()           │
│ └─ properties: matr, ente   │
└──────────────┬──────────────┘
       │       │       │
       ├───┬───┼───┬───┤
       │   │   │   │   │
   ┌───▼─┐ │   │   │   │
   │Ptv/ │ │   │   │   │
   │Scheda│ │   │   │   │
   │(empty)│ │   │   │   │
   └──────┘ │   │   │   │
            │   │   │   │
            ├────┐   │   │
            │    │   │   │
     ┌──────▼──┐ │   │   │
     │Progressioni/
     │Scheda   │ │   │   │
     │(extends)│ │   │   │
     └─────────┘ │   │   │
                 │   │   │
                 ├────┐  │
                 │    │  │
              ┌──▼────▼─┐
              │Legge104/│
              │Scheda   │
              │(extends)│
              └─────────┘
```

### Files to Modify

1. **Progressioni Module:**
   - `Progressioni/app/Models/Scheda.php` — Change extends from Model to `\Modules\Ptv\Models\BaseScheda`
   - `Progressioni/app/Models/Contracts/*` — Remove custom contracts if exist
   - `Progressioni/app/Actions/*.php` — Replace manual queries with inherited relationships
   - `Progressioni/docs/wiki/rules/INDEX.md` — Update model architecture docs

2. **Legge104 Module:**
   - `Legge104/app/Models/Scheda.php` — Change extends to `\Modules\Ptv\Models\BaseScheda`
   - `Legge104/app/Models/Contracts/*` — Remove custom contracts if exist
   - `Legge104/app/Actions/*.php` — Replace manual queries with inherited relationships
   - `Legge104/docs/wiki/rules/INDEX.md` — Update model architecture docs

3. **Ptv Module:**
   - `Ptv/app/Models/BaseScheda.php` — No changes (already base)
   - `Ptv/docs/architecture-overview.md` — Update hierarchy diagram
   - `Ptv/docs/wiki/rules/module-hierarchy-inheritance-pattern.md` — Create rule

4. **Global Documentation:**
   - `docs/wiki/rules/module-hierarchy-inheritance-pattern.md` — CARDINAL RULE (new)
   - `docs/wiki/memories/module-inheritance-patterns.md` — Memory (new)
   - `docs/wiki/rules/00-TRIGGER_MAP.md` — Add trigger for module inheritance
   - `bashscripts/tools/audit-model-inheritance-duplication.sh` — Create audit script

### Example: Progressioni/Scheda Refactor

**Before:**
```php
namespace Modules\Progressioni\Models;

class Scheda extends Model {
    protected $table = 'schede';
    
    public function asz(): HasMany {
        return $this->hasMany(Asz00k1::class, 'matr', 'matr')
            ->where('ente', $this->ente ?? 90)
            ->where('aszann', '');
    }
    
    // More duplicated relationships...
}
```

**After:**
```php
namespace Modules\Progressioni\Models;

class Scheda extends \Modules\Ptv\Models\BaseScheda {
    // Optionally add Progressioni-specific overrides only
    // Example: override a method or relationship if needed
    
    // Or leave empty if BaseScheda covers everything
}
```

## Definition of Done

- [x] Design documented (this story)
- [x] Phase 1: Analysis complete
- [x] Phase 2: Contracts unified (ProgressioneSchedaContract rimosso)
- [x] Phase 3: Models inherit correctly (Scheda extends BaseScheda)
- [x] Phase 4: Actions refactored (Disci.php, ListaAszTipCodEsclusoSubito.php)
- [x] Phase 5: Documentation updated
- [ ] Phase 6: All tests pass & reviewed
- [ ] Cardinal rule added to second brain
- [ ] Commit with proper message

## Risks & Mitigations

| Risk | Probability | Impact | Mitigation |
|------|-------------|--------|-----------|
| Breaking Progressioni functionality | Medium | High | Comprehensive test coverage before + after |
| Overlooking custom overrides in child models | Medium | Medium | Careful analysis phase (Phase 1) |
| Type hint conflicts | Low | Medium | Update all action contracts to `SchedaContract` |
| Missing relationship method in specialized context | Low | High | PHPStan level-max validation |

## BMAD Alignment

**Phases:**
- ⚙️ **Solutioning** (current) — Defining architecture, design decisions
- 🔨 **Implementation** — Execute refactoring per phase
- ✅ **Verification** — Tests, reviews, PHPStan

**Skills to activate:**
- `bmad:architecture` — Document design
- `laravel-architecture-reviewer` — Review refactoring
- `laravel-testing-expert` — Test coverage validation

## Reference

- **Cardinal Rule:** [eloquent-relationship-encapsulation.md](../wiki/rules/eloquent-relationship-encapsulation.md)
- **Discovery:** [Brainstorm session notes](./story-scheda-model-hierarchy-unification.md) (this file)
- **Memory:** [Module Inheritance Patterns](../wiki/memories/module-inheritance-patterns.md) (to be created)

---

**Story Created:** 2026-06-15 (Session PHPStan Quality Gate)  
**Triggered by:** Cardinal rule discovery during Eloquent relationship analysis  
**Next:** Phase 1 Analysis → Create detailed model comparison
