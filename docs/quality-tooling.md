# Code Quality Tooling (User Module)

## Goals
- Detect and fix code smells without breaking runtime behavior.
- Enforce LARAXOT and Filament v4 constraints.
- Keep PHPStan at Level 9 with 0 errors.

## Tools Covered
- PHPMD (PHP Mess Detector)
- Laravel Pint / PHP-CS-Fixer
- Psalm (static analysis, optional complement to PHPStan)
- Actionlint (CI workflow lint)

References:
- Gist: https://gist.github.com/slayerfat/2b3cc4faf94d2863b505
- PHPMD: https://phpmd.org/
- JetBrains PHPMD: https://www.jetbrains.com/help/phpstorm/using-php-mess-detector.html
- JetBrains CS Fixer: https://www.jetbrains.com/help/phpstorm/using-php-cs-fixer.html
- Laravel Pint: https://www.jetbrains.com/help/phpstorm/using-laravel-pint.html
- Psalm: https://www.jetbrains.com/help/phpstorm/using-psalm.html
- CodeRabbit PHPMD: https://docs.coderabbit.ai/tools/phpmd
- CodeRabbit Actionlint: https://docs.coderabbit.ai/tools/actionlint
- PHPQA PHPMD: https://phpqa.io/projects/phpmd.html
- PHPMD config sample: https://mprtmma.medium.com/phpmd-a-php-code-smells-detector-d9c014d212a6

---

## Safe Execution Policy
- Run tools in READ-ONLY first (no auto-fix), module-scoped.
- Exclude `vendor/`, `node_modules/`, `storage/`, `bootstrap/`, generated caches.
- After any change, re-run PHPStan L9 and feature tests.

### Paths
- Module root: `laravel/Modules/User/`
- App code: `laravel/Modules/User/app/`
- Tests: `laravel/Modules/User/tests/`

---

## PHPMD (Read-only)
Example run from `laravel/`:
```bash
./vendor/bin/phpmd Modules/User/app text cleancode,codesize,controversial,design,naming,unusedcode \
  --suffixes php \
  --exclude vendor,node_modules,storage,bootstrap,Tests \
  --strict
```
Recommended baseline file (customize per module): `Modules/User/phpmd.xml`.

Common findings to address in this module:
- Long methods (>20 lines) → refactor to smaller private methods.
- Too many parameters (>4) → introduce DTOs (Spatie Data).
- Static access or God classes → extract Actions (Spatie Queueable Actions).
- Cyclic dependencies → invert dependencies via contracts.

---

## Laravel Pint / PHP-CS-Fixer
Read-only first:
```bash
./vendor/bin/pint -v --test
# or
./vendor/bin/php-cs-fixer fix Modules/User --dry-run --diff
```
Then apply fixes (scoped):
```bash
./vendor/bin/pint Modules/User -v
# or
./vendor/bin/php-cs-fixer fix Modules/User --using-cache=yes
```

Style rules must not conflict with LARAXOT constraints (no labels in Filament, etc.).

---

## Psalm (Optional Complement)
Run scoped to module (ensure config exists or use inline):
```bash
./vendor/bin/psalm --threads=4 --no-cache --stats --show-info=false --find-dead-code \
  --root=Modules/User --report=Modules/User/docs/psalm-report.json
```
Note: PHPStan L9 is the primary gate; Psalm is used to spot additional types of issues (dead code, unused vars).

---

## Actionlint (CI Workflows)
Lint GitHub Actions only (safe):
```bash
actionlint -color
```
If not installed locally, use CI job with `rhysd/actionlint` Docker.

---

## Workflow Integration (Local)
1. PHPMD read-only → log findings to `Modules/User/docs/phpmd-report.txt`.
2. Pint/CS-Fixer read-only → confirm no destructive changes, then apply.
3. PHPStan L9 → must remain 0 errors.
4. Run tests and smoke test the app.

---

## Notes for Filament & LARAXOT
- Never extend Filament base classes directly; use `Modules\\Xot\\Filament` base classes.
- In `Resources`, use `getFormSchema()` only. No `table()` in Resource classes.
- No `->label()/->tooltip()/->placeholder()` in code — leverage translations.

---

## Maintenance
- Keep this document updated with new rules, exceptions, and module-specific patterns.
- Document every non-trivial refactor driven by PHPMD in `Modules/User/docs/` (what and why).
