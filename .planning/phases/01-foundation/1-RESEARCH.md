# Phase 1 Research: Foundation

## 1) Overview

Phase 1 establishes enforceable testing and static-analysis foundations before module-by-module coverage work (Phases 2-9). The implementation target is not “add more tests yet”, but “make quality gates deterministic and fail-fast” across `laravel/Modules/*`.

Scope anchored to roadmap goal:
- Configure/verify coverage driver and coverage commands
- Standardize Pest test conventions
- Enforce type-safety conventions in test code
- Enforce PHPStan Level 10 gate viability
- Ensure these gates are runnable from repository scripts and CI-friendly command lines

Practical boundary for this phase:
- Modify infrastructure/config/conventions first
- Do **not** attempt full module coverage closure in this phase

### FND-01..FND-11 mapping (implementation-oriented, inferred from Phase 1 roadmap + context)

Because `FND-01..FND-11` are listed in `.planning/ROADMAP.md` but not expanded in `.planning/REQUIREMENTS.md`, use the following operational mapping for plan tasks:

- `FND-01`: Pest conventions standardized (`uses(...)` + module/global Pest setup)
- `FND-02`: `declare(strict_types=1);` enforced for test PHP files
- `FND-03`: Functional Pest style enforced (no `protected function` in test files)
- `FND-04`: No `mixed` declarations in test files (except explicit justified exemptions)
- `FND-05`: Coverage driver availability verified (`pcov` preferred, `xdebug` fallback)
- `FND-06`: Full coverage command gate defined and executable (`--coverage --min=100`)
- `FND-07`: Type coverage command gate defined and executable (`--type-coverage --min=100`)
- `FND-08`: PHPStan Level 10 gate defined and executable
- `FND-09`: Test DB/runtime prerequisites codified (`.env.testing`, mysql test DB, no sqlite)
- `FND-10`: Scripted quality gate orchestration documented (local + CI sequence)
- `FND-11`: Validation architecture defined for phase exit criteria and regression detection

## 2) Current baseline and gaps

Baseline evidence from current repository state (`2026-03-05`):

### Baseline (already present)

- Root PHPUnit source scope exists for module app code in `laravel/phpunit.xml` (`./Modules/*/app`).
- Root Pest discovery exists in `laravel/tests/Pest.php` with module paths including:
  - `../Modules/*/tests/Feature`
  - `../Modules/*/tests/Unit`
  - `../Modules/*/tests/Traits`
  - `../Modules/*/tests/Integration`
  - `../Modules/*/tests/Performance`
- Base test inheritance is aligned to Xot architecture:
  - `laravel/tests/TestCase.php` extends `Modules\Xot\Tests\XotBaseTestCase`.
- Coverage runtime drivers are available:
  - `pcov` loaded
  - `xdebug` loaded
- Toolchain versions available:
  - Pest `4.4.1`
  - PHPStan `2.1.40`
- Existing automation scripts present:
  - `laravel/bashscripts/testing/assert-no-refreshdatabase.sh`
  - `laravel/bashscripts/testing/generate-coverage.sh`

### Gaps (must be closed in Phase 1)

- Test style non-conformance is significant:
  - `mixed` occurrences in tests: `62`
  - `protected function` occurrences in tests: `25`
- Strict types are not universal in test files:
  - test PHP files found: `350`
  - files with explicit `declare(strict_types=1);`: `343`
  - missing strict types: `7`
- Conventions are inconsistent between “per-file `uses(..., DatabaseTransactions::class)`” and “DatabaseTransactions in module `TestCase`”.
  - Current codebase heavily uses module `TestCase` with `DatabaseTransactions` trait (e.g. `laravel/Modules/User/tests/TestCase.php`).
  - Roadmap success criteria asks for per-file `uses(TestCase::class, DatabaseTransactions::class)`; this needs one canonical decision to avoid dual patterns.
- Root `phpstan.neon` currently includes broad `ignoreErrors` entries and excludes `./Modules/Xot/*`; this may conflict with strict Level 10 gate intent unless explicitly justified in phase deliverables.
- Type-coverage CLI options are not visible in `./vendor/bin/pest --help`; plugin verification should be explicit before setting hard gate expectations.

## 3) Tooling commands (pest coverage/type-coverage/phpstan)

All commands below are from `laravel/`.

### Environment preflight

```bash
cd laravel
php -m | rg -i '^(pcov|xdebug)$'
php --ri pcov || true
php --ri xdebug || true
```

### Test convention audit commands (Foundation-specific)

```bash
cd laravel

# strict types coverage in tests
TOTAL_TEST_PHP=$(rg --files Modules/*/tests tests -g '*.php' | wc -l)
STRICT_TEST_PHP=$(rg -n '^declare\(strict_types=1\);' Modules/*/tests tests -g '*.php' | wc -l)
echo "strict-types: ${STRICT_TEST_PHP}/${TOTAL_TEST_PHP}"

# forbidden patterns in tests
rg -n '\bmixed\b' Modules/*/tests tests -g '*.php'
rg -n 'protected function' Modules/*/tests tests -g '*.php'
rg -n 'RefreshDatabase' Modules/*/tests tests -g '*.php'
```

### Code coverage commands

```bash
cd laravel

# Baseline visibility
php artisan test --coverage --min=0 --compact

# Phase gate target
php artisan test --coverage --min=100

# Optional exact hard gate
php artisan test --coverage --exactly=100

# Module report generator (writes per-module docs)
bash bashscripts/testing/generate-coverage.sh
```

### Type coverage commands

```bash
cd laravel

# Validate command support first
./vendor/bin/pest --help | rg -n 'type-coverage' -i

# Baseline visibility
php artisan test --type-coverage --compact

# Phase gate target
php artisan test --type-coverage --min=100
```

### PHPStan Level 10 commands

```bash
cd laravel

# Clear stale cache before baseline
./vendor/bin/phpstan clear-result-cache

# Full gate command
./vendor/bin/phpstan analyse --level=10 --memory-limit=2G

# Module-focused drill-down while fixing
./vendor/bin/phpstan analyse Modules/User --level=10 --memory-limit=2G
```

## 4) Risks and mitigations

- Risk: coverage gate fails due to oversized source scope or non-runtime files.
- Mitigation: keep source perimeter explicit in `laravel/phpunit.xml` and validate with `--min=0` before hard gate.

- Risk: test runtime instability from wrong DB context.
- Mitigation: enforce `.env.testing` and test DB env overrides in `laravel/phpunit.xml`; retain mysql test DB, avoid sqlite shortcut.

- Risk: convention drift (mixed patterns for `DatabaseTransactions`).
- Mitigation: define single approved pattern in phase plan and enforce via grep-based checks in CI.

- Risk: type-coverage gate blocked by plugin/config mismatch.
- Mitigation: add explicit preflight (`pest --help` contains `type-coverage`), then enable gate.

- Risk: PHPStan Level 10 “green” achieved via excessive ignores/exclusions.
- Mitigation: treat each `ignoreErrors`/`excludePaths` entry in `laravel/phpstan.neon` as auditable debt; document allowlist + rationale during phase execution.

- Risk: long-running full-suite commands reduce planning/execution cadence.
- Mitigation: use wave-based validation (syntax/pattern audits first, then full gate once per wave end).

## Validation Architecture

Validation for Phase 1 should be layered, deterministic, and scriptable.

### Layer A: Static convention validation (fast)

Run grep audits on:
- strict types presence in `laravel/Modules/*/tests` and `laravel/tests`
- absence of `mixed`, `protected function`, `RefreshDatabase` in test files

Purpose: fail fast in seconds before expensive coverage runs.

### Layer B: Runtime capability validation (fast)

Validate prerequisites:
- coverage driver presence (`pcov` preferred)
- type coverage command availability
- DB test env consistency (`laravel/.env.testing`, `laravel/phpunit.xml` test env vars)

Purpose: prevent false failures caused by environment misconfiguration.

### Layer C: Quality gates (expensive, authoritative)

Run in strict order:
1. `php artisan test --coverage --min=100`
2. `php artisan test --type-coverage --min=100`
3. `./vendor/bin/phpstan analyse --level=10`

Purpose: certify Phase 1 exit readiness for Phase 2+ module testing.

### Layer D: Evidence artifacts

Persist machine-readable outputs where possible:
- coverage xml/text (e.g. `laravel/coverage.xml`, `laravel/coverage.txt`)
- type coverage json (e.g. `laravel/type-coverage.json`)
- phpstan json log (if enabled during execution)

Purpose: make regressions diffable between plan waves and CI runs.

## 6) Recommended execution order for plan waves

### Wave 0 - Baseline Capture

- Capture current counts and tool availability (strict types, mixed, protected functions, drivers, Pest/PHPStan versions).
- Confirm root config files in scope:
  - `laravel/phpunit.xml`
  - `laravel/tests/Pest.php`
  - `laravel/phpstan.neon`

Deliverable: reproducible baseline snapshot in phase notes.

### Wave 1 - Convention Normalization

- Align test conventions across modules (`uses(...)` policy, strict types, no mixed/protected functions in tests).
- Resolve pattern ambiguity between per-file `DatabaseTransactions` and module `TestCase` trait approach.
- Keep changes mechanical and grep-verifiable.

Deliverable: convention checks pass with zero violations.

### Wave 2 - Toolchain Gate Hardening

- Ensure coverage/type-coverage commands run in this repo context.
- Ensure PHPStan Level 10 command runs with explicit memory flag and no hidden cache artifacts.
- Define canonical gate command sequence for local and CI.

Deliverable: single documented quality-gate command chain for Foundation.

### Wave 3 - Phase Exit Validation

- Run full Layer C gates on clean working tree state.
- Record pass/fail with actionable error buckets (coverage, type coverage, phpstan).
- Freeze Phase 1 completion checklist for handoff to Phase 2 (`Xot Module`).

Deliverable: Foundation “ready” verdict with evidence artifacts and known residual debt list (if any).
