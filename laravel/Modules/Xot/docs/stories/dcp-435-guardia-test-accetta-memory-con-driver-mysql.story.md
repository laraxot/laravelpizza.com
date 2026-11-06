---
title: "DCP-435: la guardia dei test accetta `:memory:` con driver mysql"
type: story
status: ready-for-dev
module: Xot
created: 2026-10-27
updated: 2026-10-27
tags: [bmad, story, xot, tests, database-guard, incidente, dati-sacri]
qmd: "test database guard memory mysql mariadb schema stray pest incidente"
related:
  - ./test-database-guard.story.md
  - ../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md
---

# DCP-435: la guardia dei test accetta `:memory:` con driver mysql

## Richiesta (verbatim)

«crea tutte le bmad stories»

## Origine

Incidente del 2026-10-27, descritto nel Dev Agent Record di [mobile-camera-upload](../../../Fixcity/docs/bmad/stories/mobile-camera-upload.story.md): un comando Pest con `DB_DATABASE=:memory:` ha creato nel MariaDB di sviluppo uno schema chiamato `:memory:` (76 tabelle) e 108 test sono falliti. Lo schema e' stato eliminato; i dati veri sono stati ricontrollati (`fixcity_data` 94 tabelle, `fixcity_user` 39; categories 25, tickets 538, users 85).

## Evidenza (prova di oggi)

`Modules/Xot/tests/Support/TestDatabaseGuard.php:53` ammette `:memory:` senza guardare il driver:

```php
if ($driver === 'sqlite' || $database === ':memory:' || \str_ends_with($database, '_test')) {
```

Chiamata pura di `TestDatabaseGuard::assert('testing', [...])`, nessun database coinvolto:

| driver | database | esito |
|--------|----------|-------|
| mysql | `:memory:` | **accettato** |
| sqlite | `:memory:` | accettato |
| mysql | `fixcity_data` | rifiutato |

La story [test-database-guard](./test-database-guard.story.md) (done, 2026-10-20) dice che sqlite `:memory:` e' ammesso; il suo caso 4 prova sqlite `:memory:`, non mysql `:memory:`.

**Non provato**: che nel run dell'incidente la guardia fosse nel bootstrap e abbia lasciato passare proprio questo caso. E' la spiegazione coerente con il codice, non una riproduzione.

## Acceptance criteria

1. Una connessione con driver diverso da sqlite e database `:memory:` viene rifiutata con `RuntimeException`.
2. sqlite (file e `:memory:`), il suffisso `_test` e il prefisso `claude_scratch_pest_` restano ammessi.
3. Il messaggio nomina connessione e database, mai password o URL.
4. Il test nuovo fallisce prima della correzione e passa dopo.

## Tasks

- [ ] Aggiungere a `TestDatabaseGuardTest.php` il caso mysql + `:memory:` (rosso).
- [ ] Limitare l'eccezione `:memory:` al driver sqlite in `TestDatabaseGuard`.
- [ ] Eseguire il file con `bashscripts/tools/pest-scratch-db.sh` (con `APP_CONFIG_CACHE=/nonexistent/config.php`) e controllare `SHOW DATABASES` dopo il run.
- [ ] Verificare se il bootstrap dell'incidente caricava la guardia; annotare l'esito qui.

## Owned file scope

`laravel/Modules/Xot/tests/Support/TestDatabaseGuard.php`, `laravel/Modules/Xot/tests/Unit/Support/TestDatabaseGuardTest.php`. Fuori scope: `pest-scratch-db.sh` e la config di test.

## Coordinamento

| Data | Agente | Scope | Nota |
|------|--------|-------|------|
| 2026-10-27 | Claude | stesura | nessun lavoro avviato; la story done non viene riscritta, questa la integra |
