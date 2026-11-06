---
title: "Profile: id autoincrement + colonna uuid"
type: concept
tags: [fix, profile, uuid]
created: 2026-07-14
updated: 2026-07-14
qmd: "fix-profile-id-uuid profile: id autoincrement + colonna uuid"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

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
La migration `2026_02_22_000000_create_profiles_table.php` sta nel **modulo main** (TechPlanner) perché Profile è strettamente dipendente dal main_module. Crea la tabella con id bigint + uuid e converte tabelle esistenti con id UUID tramite `XotBaseMigration::convertIdFromUuidToBigintIfNeeded()`.

## Riferimenti
- [user-profile.md](user-profile.md)
- [filosofia-modulo-user.md](filosofia-modulo-user.md)
