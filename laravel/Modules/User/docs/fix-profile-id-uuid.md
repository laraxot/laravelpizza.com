# Profile: id autoincrement + colonna uuid

## Regola architetturale
- **id**: bigint autoincrement (uso interno, join, performance MySQL)
- **uuid**: char(36) unique (Android, PostgreSQL, API esterne, sync multi-DB)

L'uuid evita di esporre id sequenziali nelle API e permette identificazione stabile tra MySQL e PostgreSQL.

## Schema
```php
$table->id();
$table->uuid('uuid')->unique()->after('id');
```

## Modello BaseProfile
- `id` non in fillable (autoincrement)
- `uuid` generato in `booted()` con `Str::uuid()` alla creazione
- Per API/Android: usare `Profile::where('uuid', $uuid)->first()`

## Migrazione esistente
La migration `2026_02_22_000000_create_profiles_table.php` sta nel **modulo main** (<nome progetto>) perché Profile è strettamente dipendente dal main_module. Crea la tabella con id bigint + uuid e converte tabelle esistenti con id UUID tramite `XotBaseMigration::convertIdFromUuidToBigintIfNeeded()`.

## Riferimenti
- [user-profile.md](user-profile.md)
- [filosofia-modulo-user.md](filosofia-modulo-user.md)
