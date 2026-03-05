# Your Idea

Space to capture, develop, and track ideas for improving LaravelPizza.

---

## Idea Template

Use this structure for every new idea:

### Title
Clear, actionable title describing the improvement or feature.

### Problem Statement
What problem does this solve? Why does it matter? Business impact?

### Proposed Solution
Describe your approach, architecture, and implementation strategy.

### Scope
- **In Scope**: What's included
- **Out of Scope**: What's explicitly excluded

### Affected Modules
Which modules are involved? Are new Filament resources or Actions needed? Database changes?

### Implementation Approach
- Key steps or phases
- Dependencies
- Complexity level (simple/medium/complex)

### Related Documentation
Link to relevant docs:
- Architecture: [critical-architecture-rules.md](critical-architecture-rules.md)
- Testing: [testing-guidelines.md](testing-guidelines.md)
- Patterns: [laraxot-philosophy.md](laraxot-philosophy.md)

### Links
- Issue/PR: (if applicable)
- Research: (any external references)

---

## Idea 1: Pest Coverage Factory - 100% Coverage Initiative

## 🎯 Obiettivo (Updated 2026-03-05)

Arrivare al **100% Pest Code Coverage + 100% Type Coverage** su LaravelPizza in modo coordinato e scalabile.

**Stato Attuale**: 4.1% code coverage (316 tests, 1,669/40,247 LOC)

## 💡 Idea Centrale - Vertical Micro-Batches

Usare **coordinamento decentralizzato** tra agenti senza conflitti:

1. Ogni agente prende 1 modulo o 5-15 file dello stesso modulo
2. Scrive test fino a **100% coverage** per quel batch
3. Verifica localmente con `php artisan test --coverage --min=100`
4. Commit + remove completati dalla backlog
5. Lascia log breve con comando e risultato

## 📊 Coverage Baseline (2026-03-05)

| Module | Code % | Type % | LOC | Status | Priority |
|--------|--------|--------|-----|--------|----------|
| Xot | 16.3% | 0% | 10,209 | 🟡 Partial | HIGH |
| **User** | 0% → 5% | 0% | 8,565 | 🟢 In Progress | 🔴 CRITICAL |
| **Meetup** | 0% | 0% | 1,200 | Pending | 🔴 CRITICAL |
| **Tenant** | 0% | 0% | 600 | Pending | 🔴 CRITICAL |
| Notify | 0% | 0% | 4,676 | Pending | HIGH |
| Geo | 0% | 0% | 4,265 | Pending | HIGH |
| Job | 0% | 0% | 2,058 | Pending | MEDIUM |
| Media | 0% | 0% | 2,372 | Pending | MEDIUM |
| Cms | 0% | 0% | 1,997 | Pending | HIGH |
| UI | 0% | 0% | 1,975 | Pending | MEDIUM |
| Activity | 0% | 0% | 1,500 | Pending | HIGH |
| Lang | 0% | 0% | 800 | Pending | LOW |
| Gdpr | 0% | 0% | 600 | Pending | LOW |
| Seo | 0% | 0% | 500 | Pending | LOW |

## 📋 Phase 1 Strategy (Days 1-5)

### Priority 1️⃣: User Module (CRITICAL)
**Why**: 8,565 LOC uncovered, core auth/OAuth functionality

**5 Critical Actions to Test First**:
1. `RevokeAllUserTokensAction` (Passport) - Security critical
2. `LoginUserAction` (Socialite) - Core auth
3. `SetDefaultRolesBySocialiteUserAction` (Socialite) - Permissions
4. `RegisterOauthUserAction` (Socialite) - User creation
5. `IsUserAllowedAction` (Socialite) - Access control

**Target**: 40% coverage

### Priority 2️⃣: Meetup Module (CRITICAL)
**Why**: Core business logic, meetup CRUD operations

### Priority 3️⃣: Tenant Module (CRITICAL)
**Why**: Multi-tenancy backbone

### Priority 4️⃣: Xot Module (HIGH)
**Why**: Already at 16.3%, framework core - increase to 80%+

## ✅ Regole Operative (Stabilite)

### Obbligatorio
1. ✅ Nessun file marcato completato senza `--coverage --min=100`
2. ✅ Ogni batch deve avere test suite GREEN
3. ✅ Usare `uses(TestCase::class, DatabaseTransactions::class);` in OGNI test file
4. ✅ Dichiarare `declare(strict_types=1);` in ogni file
5. ✅ MAI usare `RefreshDatabase` — usare `DatabaseTransactions`
6. ✅ MAI usare `migrate:fresh` in test environment

### Vietato Assoluto
- ❌ Test in namespace quando dovrebbe essere global
- ❌ `protected function` in test files (usare `function` globale)
- ❌ Hardcoded test data (usare factories)
- ❌ `mixed` type declaration
- ❌ Mixed responsibilities in single test

## 🛠️ Test Structure Pattern

```php
<?php

declare(strict_types=1);

use Modules\{Module}\Models\Model;
use Modules\{Module}\Actions\ActionName;
use Modules\{Module}\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

// CRITICAL: This line must be in EVERY test file
uses(TestCase::class, DatabaseTransactions::class);

describe('ActionName', function (): void {
    test('happy path', function (): void {
        $result = app(ActionName::class)->execute($data);
        expect($result)->toBeTruthy();
    });

    test('error path', function (): void {
        expect(fn () => app(ActionName::class)->execute([]))
            ->toThrow();
    });
});
```

## 📊 Documentation Created (Session 2026-03-05)

1. **pest-coverage-guide.md** - Complete Pest documentation
2. **coverage-gaps-analysis-guide.md** - Gap identification + test templates
3. **coverage-implementation-phase-1.md** - Phase 1 strategy
4. **testing-guidelines.md** (updated) - Coverage section
5. **GEMINI.md** (updated) - Pest Coverage Implementation

## 🚀 Protokol Lavoro per ogni Agente

1. **SELEZIONE BATCH** - Scegliere modulo e file correlati
2. **PLANNING** - Leggere sorgente, identificare code paths
3. **IMPLEMENTATION** - Scrivere test (happy + error + edge cases)
4. **VERIFICATION** - Run `php artisan test --coverage --min=100`
5. **COMMIT** - Con chiaro messaggio
6. **CLEANUP** - Update SQL + plan.md

## 📈 Progress Tracking

```bash
# Full coverage report
php artisan test --coverage --min=100

# Module-specific
php artisan test Modules/User --coverage --min=100

# Type coverage
php artisan test --type-coverage --compact
```

## 🎯 Definition of Done (per batch)

- ✅ All tests PASS
- ✅ No regression
- ✅ **100% code coverage**
- ✅ **100% type coverage**
- ✅ SQL tracking updated
- ✅ Plan.md updated

## 🏁 Timeline

- **Phase 1 (Days 1-3)**: User + Meetup → 50% overall
- **Phase 2 (Days 3-5)**: Tenant + Xot + Cms → 75% overall
- **Phase 3 (Days 6-10)**: Media, Geo, Notify, remaining → 100%

---

**Status**: Foundation established, ready for Phase 1 execution
**Last Updated**: 2026-03-05
**Current Coverage**: 4.1% → Target: 100%
