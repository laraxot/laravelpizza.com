---
title: "User — profiles id bigint + uuid (fix 1364)"
type: concept
module: User
tags: [user, profile, migration, uuid, bigint, id-contract]
created: 2026-07-27
updated: 2026-07-27
qmd: "user profiles id bigint uuid convertIdFromUuidToBigintIfNeeded field id default value 1364"
issues:
  - "https://github.com/laraxot/base_workorder_fila5/issues/7"
related:
  - ./profile-migration-uuid-contract.md
  - ./migration-naming-religion-user.md
  - ../../../../Xot/docs/wiki/concepts/basemodel-connection-religion.md
---

# Profiles — errore 1364 `id` senza default

## Sintomo

```
Field 'id' doesn't have a default value
insert into profiles (user_id, uuid, ...) — senza id
```

## Causa

- DB legacy: `id` char(36) PK (migrazione `uuid('id')->primary()`)
- Model: `incrementing=true` → Laravel non invia `id`
- **5 file** `create_profiles_table` duplicati, nessuno chiamava `convertIdFromUuidToBigintIfNeeded()`

## Fix (2026-07-27)

Owner **WorkOrder** (`main_module`): `2026_07_27_111500_create_profiles_table.php`

- `tableCreate`: `id()` + `uuid` + colonne dominio
- `convertIdFromUuidToBigintIfNeeded()` per legacy UUID PK
- `tableUpdate`: colonne additive + `updateTimestamps`
- Duplicati User in `_bak/*.merged`

Vedi [WorkOrder profile-schema-ownership](../../../WorkOrder/docs/profile-schema-ownership.md).

## Contratto

| Colonna | Tipo | Uso |
|---------|------|-----|
| `id` | bigint unsigned AI | interno |
| `uuid` | char(36) | API / `byUuid()` |

`BaseProfile::booted()` genera `uuid` se vuoto.

## Verifica

```bash
php artisan migrate
# SHOW COLUMNS: id bigint unsigned auto_increment
```

## Fix restaurant_fila5 (2026-09-04)

Errore 500 su `/it/auth/login` con stack:

```
XotData::getProfileClass()  →  Webmozart\Assert\InvalidArgumentException
  cercava "Modules\TechPlanner\Models\Profile"  (inesistente)
XotComposer → XotData::getProfileModel() → getProfileModelByUserId()
  → Profile::firstOrCreate(['user_id' => $uuid])
  → PDOException 1364 Field 'id' doesn't have a default value
```

Cause concorrenti:

1. `config/local/restaurant/xot.php` + `config/local/restaurant/xra.php` + `config/localhost/xra.php` avevano `'main_module' => 'TechPlanner'` (modulo assente)
2. `BaseProfile::booted()` settava `$model->id = (string) Str::uuid()` su tabella con `id` bigint AI → insert senza default
3. `BaseProfile::$casts()` forzava `'id' => 'integer'` su colonna di tipo `int` — ridondante ma PHPStan L10 lo segnalava

Correzioni:

1. Allineato `main_module = 'User'` nei 3 file config → `XotData::getProfileClass()` risolve `Modules\User\Models\Profile`
2. `BaseProfile::booted()` ora genera solo `uuid`, lascia `id` a MySQL (AI)
3. `BaseProfile::casts()`: rimosso `'id' => 'integer'` (ora colonna int gestita da migration)
4. Aggiunto `Livewire\LivewireServiceProvider::class` in `bootstrap/providers.php` (era implicito via Folio, ma per safety)
5. Volt `LoginComponent` ora tipizza `Builder<UserContract>` invece di `Builder<Model>`
6. Config `Modules/Cms/app/Config/xra.php` + lowercase duplicato: aggiunto `use Modules\User\Models\User; use Modules\User\Models\Profile;` per `::class` literals

Verifica login funzionante → composer/pint/phpstan green sui file chiave.
