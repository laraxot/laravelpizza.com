---
title: "Difese a strati: i test non devono mai toccare un database vero"
type: guide
status: active
module: Xot
created: 2026-11-18
updated: 2026-11-18
related:
  - ./test-placement-guidelines.md
  - ./real-data-vs-mock-testing-strategy.md
qmd: "test database guard phpunit DB_URL RefreshDatabase prohibitDestructiveCommands staging agenti table killer"
---

# Difese a strati per il database nei test

Il caso tipico ("the table killer"): un `DB_URL` nel `.env` vince su `DB_CONNECTION=sqlite` di
`phpunit.xml`, `RefreshDatabase` parte e cancella le tabelle del database vero. Nessuna difesa da sola
basta; per questo sono cinque, una dietro l'altra.

| # | Difesa | Dove | Cosa ferma |
|---|---|---|---|
| 1 | `DB_URL` e `DATABASE_URL` vuoti, con `force="true"` | `laravel/phpunit.xml` | un URL nel `.env` o nella shell che porterebbe i test sul DB vero. I progetti Laravel creati prima di febbraio 2026 non hanno questa riga: va aggiunta a mano |
| 2 | Guardia nel bootstrap dei test | `Modules/Xot/tests/Support/TestDatabaseGuard.php`, chiamata da `CreatesApplication` | `APP_ENV` diverso da `testing`; una connessione non sqlite su un database che non finisce per `_test`; una connessione su un host non locale (vedi sotto). L'URL della connessione vince, come a runtime |
| 3 | `DB::prohibitDestructiveCommands()` in produzione | `XotServiceProvider::prohibitDestructiveDatabaseCommands()` | `db:wipe`, `migrate:fresh`, `migrate:refresh`, `migrate:reset`, `migrate:rollback` con `APP_ENV=production`. `migrate --force` resta permesso: un errore si corregge con una nuova migrazione |
| 4 | Staging con ruolo DB separato | infrastruttura | l'utente DB dello sviluppo non ha DDL (CREATE/DROP/ALTER) su staging e produzione; le migrazioni girano solo dal deploy |
| 5 | Agenti: test sì, DB remoti no | `.env` e `.env.testing` locali | gli agenti AI (Claude, Codex, …) lanciano i test, ma il loro `.env` non punta mai a un server remoto |

## Perché sqlite non è l'unico driver ammesso

La guardia non blocca "qualunque driver non sqlite" come in un progetto semplice: alcuni moduli
richiedono MariaDB (JSON, indici, collation) e i test girano anche su un MariaDB locale. Il confine qui è
il **nome** (`*_test` o `claude_scratch_pest_*` di `pest-scratch-db.sh`) più l'**host** (locale).

## Host ammessi

Locali di default: `localhost`, `127.0.0.1`, `::1`, host vuoto (socket) e i nomi di servizio di docker
compose (`mysql`, `mariadb`, `db`, `database`, `pgsql`, `postgres`), che esistono solo dentro la rete
dei container. Un server di CI usa-e-getta si aggiunge con la variabile d'ambiente:

```bash
TEST_DB_ALLOWED_HOSTS=ci-db.internal ./vendor/bin/pest
```

Mai metterci l'host di staging o di produzione.

## Eccezione nota

`liveuser_general` è esclusa dalla guardia perché nessun `.env.testing` la definisce e ricade su un nome
reale. Nessun test deve usarla; va rimossa quando l'ultimo modulo smette di dichiararla.

## Controllo rapido ("stasera aprite il vostro phpunit.xml")

```bash
grep -n 'DB_URL\|DATABASE_URL\|DB_CONNECTION\|DB_DATABASE' laravel/phpunit.xml
grep -n '^DB_\|_URL=' laravel/.env.testing
APP_ENV=production php artisan db:wipe --force   # deve rispondere "prohibited"
```

Test della guardia: `Modules/Xot/tests/Unit/Support/TestDatabaseGuardTest.php`.
