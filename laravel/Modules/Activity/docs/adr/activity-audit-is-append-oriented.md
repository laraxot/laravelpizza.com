---
status: accepted
module: Activity
title: "ADR — L'audit delle attività è append-oriented"
type: decision
tags: [adr, activity, audit]
created: 2026-11-23
updated: 2026-11-24
---

# L'audit delle attività è append-oriented

## Contesto

Activity conserva eventi, snapshot e attività per ricostruire cosa è accaduto a un soggetto.

## Decisione

Le registrazioni di audit si producono tramite le Actions e i recorder del modulo; la cronologia non viene riscritta per correggere una visualizzazione.

## Driver della decisione

- Conservare una cronologia verificabile.

## Alternative scartate

- Usare il log applicativo come unica fonte.
- Aggiornare gli eventi storici quando cambia una label.

## Conseguenze

La cronologia resta affidabile e interrogabile; le viste devono interpretare gli eventi senza mutare la fonte storica.

## Conferma

Verificare recorder, policy e test di registrazione prima di cambiare lo schema dell'audit.

## Verifica

- `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/Actions/LogActivityActionTest.php` e i test gemelli
  `LogModelCreatedActionTest.php`, `LogModelUpdatedActionTest.php`, `LogModelDeletedActionTest.php`,
  `LogUserLoginActionTest.php` nella stessa cartella (`Modules/Activity/tests/Unit/Actions/LogActivityActionTest.php`,
  `Modules/Activity/tests/Unit/Actions/LogModelUpdatedActionTest.php`): coprono la registrazione tramite le Action.
- Policy: `Modules/Activity/tests/Unit/ActivityPolicyTest.php` (permessi `activity.update`, `activity.delete`, `activity.restore`).
- Solo revisione, nessun test lo dimostra: `rg -n '(->|::)(update|upsert|save)\(' laravel/Modules/Activity/app --glob '*.php'`
  trova solo `LogoutListener` (un `save()` su un `Activity` appena creato) e `RestoreActivityAction`, che aggiorna il record
  del soggetto con `properties.old`, non la riga del log. Ogni nuovo punto che modifica una riga di `activity_log` va giustificato qui.
- La pulizia per anzianita' (`Modules/Activity/app/Actions/ActivityMaintenanceAction.php`) cancella righe vecchie: e' retention,
  non riscrittura della cronologia.
