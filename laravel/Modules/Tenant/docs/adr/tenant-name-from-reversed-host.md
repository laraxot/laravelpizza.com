---
title: "ADR — Il tenant è la cartella di config del dominio invertito"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/GetTenantNameAction.php
  - ../../app/Actions/Config/GetTenantFilePathAction.php
  - ../tenant-config-path-philosophy-debate.md
---

# ADR: il tenant è la cartella di config del dominio invertito

## Contesto

- Lo stesso codice serve più siti; ogni sito ha la sua config (`database.php`, `xra.php`, contenuti JSON) versionata
  in `laravel/config/<percorso del tenant>/`.
- Il tenant non ha un record in database che lo identifichi a ogni richiesta: va ricavato dall'host prima che la
  connessione al database sia configurata (`TenantServiceProvider::registerDB()` legge proprio `database.php` del tenant).
- Il dibattito tra `config/<sito>.<ambiente>/` e `config/<ambiente>/<sito>/` è in `docs/tenant-config-path-philosophy-debate.md`.
- Domanda: come si passa da host a cartella in modo deterministico, anche dietro proxy e in console?

## Decisione

`Modules/Tenant/app/Actions/GetTenantNameAction.php`:
- host = `SERVER_NAME`; se è `127.0.0.1`, `::1` o `localhost` (es. `php artisan serve`, proxy inverso) si usa l'header
  `Host` della richiesta, mai in console; altrimenti l'host di `app.url`;
- si toglie `www.`, si slugga ogni parte e si inverte: `foo.example.com` → `com/example/foo`;
- vince la prima cartella esistente tra il percorso completo e quello senza l'ultima parte; poi l'host di `app.url`;
  infine `localhost`;
- se la cartella è un symlink si restituisce il percorso reale rispetto a `config/`, perché le chiavi di config caricate
  da Laravel usano quello.
Ogni file del tenant si raggiunge con `GetTenantFilePathAction` (`config/<tenant>/<file>`), che rifiuta percorsi assoluti,
`..` e byte NUL.

## Alternative scartate

- Tabella `tenants` interrogata a ogni richiesta: serve il database prima di sapere quale database usare.
- `config/<sito>.<ambiente>/`: mescola ambiente e sito, non scala su staging e produzione dello stesso sito (debate).
- Variabile d'ambiente per sito: un'installazione multi-dominio dovrebbe avere un processo per dominio.

## Conseguenze

- Pro: aggiungere un sito = aggiungere una cartella (o un symlink per un alias di dominio).
- Contro: l'host decide quale config si carica; un host non previsto ricade su `app.url` o `localhost`, mai su un
  percorso arbitrario (i nomi sono sluggati).
- Debito: `Modules/Xot/app/Actions/Config/GetTenantConfigPathAction.php` duplica `Config/GetTenantConfigPathAction` di
  questo modulo.

## Verifica

- `Modules/Tenant/tests/Feature/TenantConfigIsolationTest.php`: host con `../` ricade su `localhost`; nome file con
  traversal rifiutato (group `TENANT-FILE-PATH-INV-2`).
- `Modules/Tenant/tests/Unit/Actions/Config/GetTenantFilePathActionTest.php` (groups `TENANT-FILE-PATH-INV-1..3`).
- Debito: `Modules/Tenant/tests/Unit/Actions/GetTenantNameActionTest.php` non lega il TestCase e le sue attese
  (`com/example/myapp` senza cartella esistente) non corrispondono al codice: va riscritto con cartelle di config temporanee.
