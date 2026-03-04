# Testing Best Practices - Laraxot Methodology (2026)

## 0. Obiettivo e Struttura

*   **Obiettivo:** 100% coverage su tutto il progetto (app + tutti i moduli).
*   **Struttura:** Ogni modulo ha il proprio `composer.json` e la cartella `tests/`.
*   **Framework:** Pest only — mai PHPUnit classico.
*   **❌ MAI `RefreshDatabase`:** Usare `DatabaseTransactions` per velocità e isolamento.

## 1. Core Principles
*   **Behavior over Implementation:** Test what the system *does*, not how it is built.
*   **Zero Boilerplate:** Use Pest's functional API.
*   **100% Type Safety:** Tests must pass PHPStan Level 10.
*   **Isolation:** Each module/theme manages its own tests and dependencies.

## 2. Mandatory Rules
*   **❌ NO `RefreshDatabase`:** Use `DatabaseTransactions` for speed and isolation. Mai usare RefreshDatabase.
*   **✅ Single Source of Truth:** Models are the source of truth; use Factories for data.
*   **✅ Execute-Only Actions:** Test Spatie Queueable Actions only via their `execute()` method.
*   **✅ Arch Testing:** Use Pest Architecture testing to enforce modular boundaries.

## 3. Recommended Workflow ("Super Mucca")
1.  **Develop:** Implement feature/fix.
2.  **Pest:** `php artisan test --compact` (and `--coverage` for 100% goal).
3.  **PHPStan:** `./vendor/bin/phpstan analyse Modules` (Level 10).
4.  **Pint:** Format code for PSR-12 compliance.
5.  **Insights:** Ensure Quality > 80% and Complexity < 10.

## 4. Module Test Configuration
Each module must have a `tests/Pest.php` that extends the base `TestCase` and includes necessary traits:

```php
// Modules/{Name}/tests/Pest.php
uses(
    \Modules\{Name}\Tests\TestCase::class,
    \Illuminate\Foundation\Testing\DatabaseTransactions::class,
)->in('Feature', 'Unit');
```

## 5. UI Testing (Filament & Volt)
*   **Volt:** Use `Volt::test('component-name')` to assert rendering and state.
*   **Filament:** Use `livewire(Resource\Pages\ListRecords::class)` to test table actions, forms, and filters.

---
*
*Status: Active*
