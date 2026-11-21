---
id: cache-store-env-var-test-infra-2026-09-21
slug: cache-store-env-var-test-infra-2026-09-21
title: "phpunit.xml usava CACHE_DRIVER, Laravel legge CACHE_STORE"
description: "Bug infrastruttura test: config/cache.php legge solo CACHE_STORE, non la var deprecata CACHE_DRIVER impostata in phpunit.xml/.env.testing. Ogni test che tocca la cache falliva su tabella `cache` assente."
document_type: story
category: bugfix
scope: test-infrastructure
status: done
version: "1.0"
language: it
ecosystem: laravel
priority: medium
created_at: 2026-09-21
updated_at: 2026-09-21
tags: [testing, cache, phpunit, spatie-permission, env]
related:
  - Modules/User/docs/stories/10.3.retire-auth-livewire-twins.story.md
  - Modules/User/docs/stories/dashboard-lang-collateral-damage-2026-09-21.story.md
github:
  repository: null
  issues: []
---

# phpunit.xml: CACHE_DRIVER non ha effetto, serve CACHE_STORE

## Contesto

Durante verifica del fix concorrente su `HasSpatiePermission::hasPermissionToOrCreate()`
(vedi sezione "Feature verificata" sotto), i test in
`Modules/User/tests/Feature/HasSpatiePermissionAutoCreateTest.php` fallivano con:

```
QueryException: SQLSTATE[42S02]: Base table or view not found:
1146 Table 'quaeris_data_test.cache' doesn't exist
```

## Causa radice

- `config/cache.php:19` → `'default' => env('CACHE_STORE', 'database')`. Legge **solo**
  `CACHE_STORE`. Non legge `CACHE_DRIVER` (nome deprecato, pre-Laravel 11).
- `phpunit.xml` impostava `<env name="CACHE_DRIVER" value="array" />` — nessun effetto,
  var mai letta.
- `APP_ENV=testing` → `app/Application.php::environmentFile()` cerca prima `.env.sqlite`
  poi `.env.testing`. Verificato: **`.env.sqlite` non esiste** su disco (`ls` → No such
  file or directory). Carica quindi `.env.testing`, che a sua volta ha
  `CACHE_DRIVER=array` (riga 48) — stesso bug, stesso nome sbagliato.
- Risultato: nessuna delle due fonti setta `CACHE_STORE`. Laravel ripiega sul default
  `'database'`, che richiede la tabella `cache` (migration standard Laravel) — assente
  da `quaeris_data_test`.
- Impatto: non solo questo test. **Qualsiasi test che tocchi `Cache::` fallisce** allo
  stesso modo (Spatie Permission usa la cache internamente per `hasPermissionTo()`).

## Fix

Aggiunta riga in `phpunit.xml` (`CACHE_DRIVER` lasciata per compatibilità, innocua):

```diff
 <env name="APP_ENV" value="testing" />
 <env name="CACHE_DRIVER" value="array" />
+<env name="CACHE_STORE" value="array" />
 <env name="SESSION_DRIVER" value="array" />
```

`<env>` in phpunit.xml è settato prima del boot Laravel (via `putenv`/`$_ENV`), quindi
vince su qualsiasi valore in `.env.testing` — non serve toccare quel file.

## Verifica

```bash
XDEBUG_MODE=coverage vendor/bin/pest Modules/User/tests/Feature/HasSpatiePermissionAutoCreateTest.php
```

Prima del fix: 3/5 test falliti su `QueryException` tabella `cache` mancante (bypassato
solo con `CACHE_STORE=array` via CLI, non persistito).
Dopo il fix (nessun override CLI): **5 passed (9 assertions)**.

Nota tooling: `XDEBUG_MODE=off` fa uscire Pest senza eseguire nulla (silenzioso) — vedi
memoria `pest-coverage-xdebug-mode-coverage-non-off.md`. Serve `XDEBUG_MODE=coverage`.

## Feature verificata di sponda (non mia, sessione concorrente)

`Modules\User\Models\Traits\HasSpatiePermission::hasPermissionToOrCreate()` — wrapper
che auto-crea il permesso mancante (`Permission::findOrCreate`) invece di lasciar
esplodere `PermissionDoesNotExist`, poi richiama `hasPermissionTo()` normale. Usato in
tutti e 7 i metodi di `OauthAccessTokenPolicy`. Codice e uso confermati corretti
(`php -l` pulito, 5/5 test verdi). Non ho scritto io questo codice, solo verificato.

## Reperto collaterale: dead code già rimosso

`Modules/User/app/Actions/Permission/EnsurePermissionExistsAction.php` — Action ormai
bypassata dal refactor sopra (che chiama `Permission::findOrCreate()` diretto). Grep
repo-wide conferma zero riferimenti. Il file risulta già `D` (deleted, non committato)
in `git status` — cancellato dalla sessione concorrente, non da me. Nessuna azione
necessaria.

## File toccati da me in questa story

- `phpunit.xml` — +1 riga (`CACHE_STORE`)

## Non toccato (fuori scope, di altre sessioni)

- `HasSpatiePermission.php`, `OauthAccessTokenPolicy.php`,
  `HasSpatiePermissionAutoCreateTest.php`, cancellazione `EnsurePermissionExistsAction.php`
