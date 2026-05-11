# `tableUpdate` and Modifier Methods (`->after()`, `->change()`)

## Context
When writing migrations extending `XotBaseMigration`, developers often use `tableUpdate` to ensure additive, idempotent updates to an existing table.

## Problem
`XotBaseMigration::tableUpdate` has a fallback mechanism: if the table does *not* exist, it will call `$this->getConn()->create($tableName, $next);`.
If the callback contains column modifiers intended for *altering* a table (like `->after('id')` or `->change()`), Laravel's `Blueprint` will append these modifiers to the `CREATE TABLE` query. 
In MariaDB/MySQL, using the `AFTER` modifier inside a `CREATE TABLE` statement results in a syntax error:
`SQLSTATE[42000]: Syntax error ... near 'after id...`

## Solution

### Best Practices
- **Separate Create and Update Logic:** Always use `tableCreate` for the initial table definition and `tableUpdate` purely for subsequent additive changes. Do not expect `tableUpdate` to seamlessly act as `tableCreate` if you use modifiers.
- **Check Table Existence:** If you must use `->after()` or `->change()` inside a migration, wrap them in logic that ensures they only run during an `ALTER` table operation, or simply avoid `->after()` since column order rarely matters.

### Bad Practices
- ❌ Using `->after('column')` inside a `tableCreate` or a `tableUpdate` that might fall back to `create`.
- ❌ Relying on `tableUpdate` to create the table from scratch while using altering modifiers.

### False Friends
- **`after()` Modifier:** It seems harmless to specify column order, but it breaks table creation queries on many relational databases when applied during `Schema::create()`.

## Related Links
- [Laravel Database: Migrations - Column Modifiers](https://laravel.com/docs/11.x/migrations#column-modifiers)
