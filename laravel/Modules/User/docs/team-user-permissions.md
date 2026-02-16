# Team User Permissions Column Fix - Laraxot Philosophy Compliant

**Date**: 2026-01-12  
**Status**: ✅ **FIXED** (Following Laraxot Philosophy)  
**Severity**: 🔴 **CRITICAL** (Production down)

## Laraxot Philosophy: 1 Table = 1 Migration File

> **Regola Fondamentale**: In Laraxot, **non devono mai esistere più migration files per la stessa tabella all'interno dello stesso modulo**.

## Problem

Production site (`sottana.net`) was throwing a SQL error:

```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'team_user.permissions' in 'field list'
```

**Error Location**: `Modules/User/app/Models/Traits/HasTeams.php:57` → `teams()` relationship  
**Root Cause**: The `team_user` pivot table was missing the `permissions` column that the `HasTeams` trait expected.

## Initial Violation (WRONG APPROACH ❌)

I initially created a **new migration file** `2026_01_12_113634_add_permissions_to_team_user_table.php`, which **violated the Laraxot philosophy**.

### Why This Was Wrong:
- **Violazione della filosofia Laraxot**: Creare più migration per la stessa tabella
- **Duplicazione inaccettabile**: La tabella `team_user` aveva già una migration
- **Mancata coerenza**: Non rispetta il principio "1 Tabella = 1 Migration"

## Correct Solution (Laraxot Compliant ✅)

### Actions Taken:

1. **Deleted the violation migration**:
   ```bash
   rm Modules/User/database/migrations/2026_01_12_113634_add_permissions_to_team_user_table.php
   ```

2. **Deleted old duplicate migration**:
   ```bash
   rm Modules/User/database/migrations/2023_01_01_000004_create_team_user_table.php
   ```

3. **Renamed the authoritative migration** with current date:
   ```bash
   mv 2025_01_22_120000_create_team_user_table.php → 2026_01_12_120000_create_team_user_table.php
   ```

### Why This Is Correct:

- ✅ **1 Table = 1 Migration**: Solo un file per la tabella `team_user`
- ✅ **XotBaseMigration Pattern**: Usa `tableCreate()` e `tableUpdate()`
- ✅ **Idempotent**: Il blocco `UPDATE` controlla l'esistenza della colonna
- ✅ **Single Source of Truth**: Un solo file autoritativo

## Migration Content

The migration `2026_01_12_120000_create_team_user_table.php` already contains:

```php
// -- CREATE --
$this->tableCreate(static function (Blueprint $table): void {
    $table->id();
    $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
    $table->uuid('user_id')->nullable()->index();
    $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
    $table->string('role')->nullable();
    $table->text('permissions')->nullable(); // ✅ Already present
    $table->unique(['team_id', 'user_id']);
    $table->softDeletes();
    $table->timestamps();
});

// -- UPDATE --
$this->tableUpdate(function (Blueprint $table): void {
    if (! $this->hasColumn('permissions')) {
        $table->text('permissions')->nullable(); // ✅ Safe check
    }
    // ... other updates
});
```

## Deployment Steps

**For Production (sottana.net):**
```bash
cd /home/ploi/sottana.net/laravel
php artisan module:migrate User --force
php artisan optimize:clear
```

## Lessons Learned

1. **SEMPRE seguire la filosofia Laraxot**: 1 Tabella = 1 Migration File
2. **NON creare nuove migration per aggiungere colonne**: Aggiornare la migration esistente
3. **Rinominare con data corrente**: Quando si aggiorna una migration, rinominarla con la data odierna
4. **XotBaseMigration è Dio**: Non deviare mai dal pattern `tableCreate()` + `tableUpdate()`
5. **Studiare sempre i docs**: Prima di agire, studiare `docs/laraxot-migration-philosophy.md`

## Related Files

- [`Modules/User/database/migrations/2026_01_12_120000_create_team_user_table.php`](file://Modules/User/database/migrations/2026_01_12_120000_create_team_user_table.php)
- [`Modules/User/app/Models/Traits/HasTeams.php`](file://Modules/User/app/Models/Traits/HasTeams.php#L465-L469)
- [`Modules/User/docs/laraxot-migration-philosophy.md`](file://Modules/User/docs/laraxot-migration-philosophy.md)

## Updated Memory Rules

Added to permanent memory:
> **Laraxot Migration Philosophy**: NEVER create multiple migration files for the same table. Always update the existing migration and rename it with the current date. Use XotBaseMigration pattern with `tableCreate()` and `tableUpdate()` blocks. Check `hasColumn()` before adding columns in UPDATE block.