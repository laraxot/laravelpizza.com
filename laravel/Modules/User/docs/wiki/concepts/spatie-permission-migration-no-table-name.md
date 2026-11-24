---
title: "Spatie pivot — migrazione senza nome tabella"
type: concept
module: User
tags: [spatie, migration, xot-base-migration, model-has-role, config]
updated: 2026-07-27
issues:
  - "https://github.com/laraxot/base_workorder_fila5/issues/7"
related:
  - ./spatie-permission-table-names.md
  - ./migration-naming-religion-user.md
  - ../../../../Xot/docs/wiki/concepts/xotbase-migration-religion.md
---

# Migrazione pivot Spatie — mai il nome tabella nel file

## Perché

`permission.table_names.*` in `laravel/config/permission.php` è **fisso** (scelta maintainer). Migrazioni e modelli leggono il valore via `Model*::getTable()` — **non** si modifica la config per far combaciare il DB.

## Pattern corretto

```php
// 2026_07_27_160000_create_model_has_role_table.php
return new class extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(static function (Blueprint $table): void {
            // colonne...
        });
        $this->tableUpdate(function (Blueprint $table): void {
            // idempotente...
        });
    }
};
```

- File: `create_{model_snake}_table` → `ModelHasRole` (singolare `role`, non `roles`)
- Tabella: `$this->getTable()` → `ModelHasRole::getTable()` → config
- Connessione: `$this->model->getConnectionName()` — mai `$connection` nella migrazione

## Vietato

```php
// ❌ nome tabella nel file
$this->tableCreate($fn, 'model_has_roles');
Schema::rename('model_has_role', 'model_has_roles');
private const TABLE = 'model_has_roles';
protected ?string $model_class = User::class; // modello sbagliato per pivot
```

## Fix errore “tabella non esiste”

1. `php artisan config:show permission.table_names` — **non modificare**
2. `SHOW TABLES` sul DB User
3. Se mismatch: correggere **migrazione/schema** (modello pivot + `XotBaseMigration`)
4. `php artisan config:clear`

**Vietato:** cambiare `table_names` in `permission.php` o overlay tenant.

## Collegamenti

- [spatie-permission-table-names.md](./spatie-permission-table-names.md)
- [Themes — filosofia Spatie](../../../Themes/docs/shared-components/spatie-permission-philosophy.md)
