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
<<<<<<< HEAD
  - Modules/User/docs/stories/dashboard-lang-collateral-damage-2026-09-21.story.md
=======
<<<<<<< .merge_file_vhg1br
  - Modules/User/docs/stories/dashboard-lang-collateral-damage.story.md
=======
  - Modules/User/docs/stories/dashboard-lang-collateral-damage-2026-09-21.story.md
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
github:
  repository: null
  issues: []
qmd: "cache store env var test infra"
---

# phpunit.xml: CACHE_DRIVER non ha effetto, serve CACHE_STORE

## Contesto

Durante verifica del fix concorrente su `HasSpatiePermission::hasPermissionToOrCreate()`
(vedi sezione "Feature verificata" sotto), i test in
`Modules/User/tests/Feature/HasSpatiePermissionAutoCreateTest.php` fallivano con:

```
QueryException: SQLSTATE[42S02]: Base table or view not found:
<<<<<<< .merge_file_l242c3
1146 Table '<nome progetto>_data_test.cache' doesn't exist
=======
<<<<<<< HEAD
1146 Table 'quaeris_data_test.cache' doesn't exist
=======
<<<<<<< .merge_file_vhg1br
1146 Table '<nome progetto>_data_test.cache' doesn't exist
=======
1146 Table 'quaeris_data_test.cache' doesn't exist
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
>>>>>>> .merge_file_r3bK03
```

## Causa radice

- `config/cache.php:19` → `'default' => env('CACHE_STORE', 'database')`. Legge **solo**
  `CACHE_STORE`. Non legge `CACHE_DRIVER` (nome deprecato, pre-Laravel 11).
<<<<<<< .merge_file_l242c3
- `phpunit.xml` impostava `<env name="CACHE_DRIVER" value="array" />` — nessun effetto,
=======
<<<<<<< HEAD
- `phpunit.xml` impostava `<env name="CACHE_DRIVER" value="array" />` — nessun effetto,
=======
<<<<<<< .merge_file_vhg1br
- `phpunit.xml` impostava `<env name="CACHE_DRIVER" value="array" />`: nessun effetto,
=======
- `phpunit.xml` impostava `<env name="CACHE_DRIVER" value="array" />` — nessun effetto,
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
>>>>>>> .merge_file_r3bK03
  var mai letta.
- `APP_ENV=testing` → `app/Application.php::environmentFile()` cerca prima `.env.sqlite`
  poi `.env.testing`. Verificato: **`.env.sqlite` non esiste** su disco (`ls` → No such
  file or directory). Carica quindi `.env.testing`, che a sua volta ha
<<<<<<< HEAD
=======
<<<<<<< .merge_file_vhg1br
  `CACHE_DRIVER=array` (riga 48): stesso bug, stesso nome sbagliato.
- Risultato: nessuna delle due fonti setta `CACHE_STORE`. Laravel ripiega sul default
  `'database'`, che richiede la tabella `cache` (migration standard Laravel): assente
  da `<nome progetto>_data_test`.
<<<<<<< .merge_file_l242c3
=======
=======
>>>>>>> laraxot/dev
  `CACHE_DRIVER=array` (riga 48) — stesso bug, stesso nome sbagliato.
- Risultato: nessuna delle due fonti setta `CACHE_STORE`. Laravel ripiega sul default
  `'database'`, che richiede la tabella `cache` (migration standard Laravel) — assente
  da `quaeris_data_test`.
<<<<<<< HEAD
=======
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
>>>>>>> .merge_file_r3bK03
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
<<<<<<< .merge_file_l242c3
vince su qualsiasi valore in `.env.testing` — non serve toccare quel file.
=======
<<<<<<< HEAD
vince su qualsiasi valore in `.env.testing` — non serve toccare quel file.
=======
<<<<<<< .merge_file_vhg1br
vince su qualsiasi valore in `.env.testing`: non serve toccare quel file.
=======
vince su qualsiasi valore in `.env.testing` — non serve toccare quel file.
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
>>>>>>> .merge_file_r3bK03

## Verifica

```bash
XDEBUG_MODE=coverage vendor/bin/pest Modules/User/tests/Feature/HasSpatiePermissionAutoCreateTest.php
```

Prima del fix: 3/5 test falliti su `QueryException` tabella `cache` mancante (bypassato
solo con `CACHE_STORE=array` via CLI, non persistito).
Dopo il fix (nessun override CLI): **5 passed (9 assertions)**.

<<<<<<< .merge_file_l242c3
Nota tooling: `XDEBUG_MODE=off` fa uscire Pest senza eseguire nulla (silenzioso) — vedi
=======
<<<<<<< HEAD
Nota tooling: `XDEBUG_MODE=off` fa uscire Pest senza eseguire nulla (silenzioso) — vedi
=======
<<<<<<< .merge_file_vhg1br
Nota tooling: `XDEBUG_MODE=off` fa uscire Pest senza eseguire nulla (silenzioso): vedi
=======
Nota tooling: `XDEBUG_MODE=off` fa uscire Pest senza eseguire nulla (silenzioso) — vedi
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
>>>>>>> .merge_file_r3bK03
memoria `pest-coverage-xdebug-mode-coverage-non-off.md`. Serve `XDEBUG_MODE=coverage`.

## Feature verificata di sponda (non mia, sessione concorrente)

<<<<<<< .merge_file_l242c3
`Modules\User\Models\Traits\HasSpatiePermission::hasPermissionToOrCreate()` — wrapper
=======
<<<<<<< HEAD
`Modules\User\Models\Traits\HasSpatiePermission::hasPermissionToOrCreate()` — wrapper
=======
<<<<<<< .merge_file_vhg1br
`Modules\User\Models\Traits\HasSpatiePermission::hasPermissionToOrCreate()`: wrapper
=======
`Modules\User\Models\Traits\HasSpatiePermission::hasPermissionToOrCreate()` — wrapper
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
>>>>>>> .merge_file_r3bK03
che auto-crea il permesso mancante (`Permission::findOrCreate`) invece di lasciar
esplodere `PermissionDoesNotExist`, poi richiama `hasPermissionTo()` normale. Usato in
tutti e 7 i metodi di `OauthAccessTokenPolicy`. Codice e uso confermati corretti
(`php -l` pulito, 5/5 test verdi). Non ho scritto io questo codice, solo verificato.

## Reperto collaterale: dead code già rimosso

<<<<<<< .merge_file_l242c3
`Modules/User/app/Actions/Permission/EnsurePermissionExistsAction.php` — Action ormai
bypassata dal refactor sopra (che chiama `Permission::findOrCreate()` diretto). Grep
repo-wide conferma zero riferimenti. Il file risulta già `D` (deleted, non committato)
in `git status` — cancellato dalla sessione concorrente, non da me. Nessuna azione
=======
<<<<<<< HEAD
=======
<<<<<<< .merge_file_vhg1br
`Modules/User/app/Actions/Permission/EnsurePermissionExistsAction.php`: Action ormai
bypassata dal refactor sopra (che chiama `Permission::findOrCreate()` diretto). Grep
repo-wide conferma zero riferimenti. Il file risulta già `D` (deleted, non committato)
in `git status`: cancellato dalla sessione concorrente, non da me. Nessuna azione
=======
>>>>>>> laraxot/dev
`Modules/User/app/Actions/Permission/EnsurePermissionExistsAction.php` — Action ormai
bypassata dal refactor sopra (che chiama `Permission::findOrCreate()` diretto). Grep
repo-wide conferma zero riferimenti. Il file risulta già `D` (deleted, non committato)
in `git status` — cancellato dalla sessione concorrente, non da me. Nessuna azione
<<<<<<< HEAD
=======
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
>>>>>>> .merge_file_r3bK03
necessaria.

## File toccati da me in questa story

<<<<<<< .merge_file_l242c3
- `phpunit.xml` — +1 riga (`CACHE_STORE`)
=======
<<<<<<< HEAD
- `phpunit.xml` — +1 riga (`CACHE_STORE`)
=======
<<<<<<< .merge_file_vhg1br
- `phpunit.xml`: +1 riga (`CACHE_STORE`)
=======
- `phpunit.xml` — +1 riga (`CACHE_STORE`)
>>>>>>> .merge_file_yCcLtk
>>>>>>> laraxot/dev
>>>>>>> .merge_file_r3bK03

## Non toccato (fuori scope, di altre sessioni)

- `HasSpatiePermission.php`, `OauthAccessTokenPolicy.php`,
  `HasSpatiePermissionAutoCreateTest.php`, cancellazione `EnsurePermissionExistsAction.php`
