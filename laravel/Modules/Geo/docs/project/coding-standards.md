# Coding Standards & Quality Analysis

## 1. Static Analysis (PHPStan)
- **Target**: Level 10 compliance for all modules.
- **Rules**:
    - NEVER pass `--level`. The level is in `phpstan.neon`.
    - NEVER modify `laravel/phpstan.neon`.
    - NEVER use `@phpstan-ignore` or baselines.
    - All errors must be fixed in the code.
- **Execution**: `./vendor/bin/phpstan analyse Modules/{ModuleName}`.

## 2. Code Quality (Rules & Metrics)
- **Cyclomatic Complexity**: MUST be < 10. Use Guard Clauses and Extract Method patterns.
- **Method Length**: SHOULD be < 20 lines (MAX 50).
- **PHP Insights**: Maintain 90%+ score across all categories.
- **Clean Code**: No `TODO` comments. No commented-out code. Use professional placeholders.

## 3. Type Safety & Narrowing
- **Strict Types**: Always use `declare(strict_types=1);`.
- **Typing**: Use strict type hints. Avoid `mixed` types. Use Union types or Generics.
- **Narrowing**: When using `Arr` helpers or external collections, use PHPDocs to narrow the type:
  ```php
  /** @var Collection<int, User> $users */
  $users = $collection->filter(...);
  ```
- **Assertions**: Use `Webmozart\Assert\Assert` for input validation and state verification.

## 4. Eloquent Property Access (CRITICAL)
Eloquents magic attributes are not detected by `property_exists()`.
- **Rule**: NEVER use `property_exists()` on Eloquent Models.
- **Solution**:
    - Use `isset($model->attr)`
    - Use `$model->hasAttribute('attr')`
    - Use `Schema::hasColumn($model->getTable(), 'attr')`
    - Use `Modules\Xot\Actions\Cast\SafeAttributeCastAction::get($model, 'attr', 'default')`

## 5. Filament Specific Standards
- **Schema Returns**: Methods like `getInfolistSchema()`, `getTableActions()`, `getFormSchema()`, and `getHeaderActions()` MUST return associative arrays with **STRING keys**.
- **Icons & Labels**: Do not hardcode. Use translation-driven resolution via `XotBase` classes.

## 6. Directory Etiquette
- **README**: Global files must be `README.md`. No lowercase `readme.md` allowed.
- **_docs**: The `_docs` directories are deprecated. Transform content into `.md` files in the module's `docs/` directory.
- **Scripts**: All scripts (.sh, .py, .php CLI) MUST be in `bashscripts/` subfolders. NEVER in the `laravel/` root.
