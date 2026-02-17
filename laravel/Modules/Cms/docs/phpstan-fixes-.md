# PHPStan Fixes for Cms Module (2025-12-30)

This document outlines the errors found by PHPStan in the `Cms` module and the plan to resolve them.

## Error Summary: "Cannot use X as Y because the name is already in use"

These errors indicate conflicting `use` statements or duplicated class/trait imports without proper aliasing.

## Affected Files and Specific Errors:

### 1. `app/Http/View/Composers/XotComposer.php` - Line 10
- **Message:** `Cannot use Illuminate\Database\Eloquent\Relations\HasOne as HasOne because the name is already in use`
- **Plan:** Investigate `use` statements in `XotComposer.php` for redundant `HasOne` imports. Either remove a duplicate or add an alias if another `HasOne` is required from a different namespace.

### 2. `app/Models/BaseTreeModel.php` - Line 18
- **Message:** `Cannot use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships as HasRecursiveRelationships because the name is already in use`
- **Plan:** Investigate `use` statements in `BaseTreeModel.php` for redundant `HasRecursiveRelationships` imports. Correct by removing duplicates or aliasing.

### 3. `database/seeders/CmsMassSeeder.php` - Line 11
- **Message:** `Cannot use Illuminate\Database\Eloquent\Collection as Collection because the name is already in use`
- **Plan:** Investigate `use` statements in `CmsMassSeeder.php` for redundant `Collection` imports. Correct by removing duplicates or aliasing.

## Remediation Plan (per file):

1.  **Read File:** Get the content of the affected file.
2.  **Identify Conflict:** Locate the conflicting `use` statements.
3.  **Apply Fix:**
    *   If a `use` statement is truly duplicated, remove one.
    *   If a class is already part of the current namespace, remove its `use` statement.
    *   If two different classes with the same base name are needed, add an alias to one (e.g., `use Some\Namespace\Collection as MyCollection;`).
4.  **Verify:** Run `phpstan` on the specific file to ensure the error is resolved.
5.  **Quality Checks:** Once all PHPStan errors are clear for the file, run `phpmd` and `phpinsights` on it.
6.  **Commit:** Once all files in the module are fixed and verified, commit the changes.
