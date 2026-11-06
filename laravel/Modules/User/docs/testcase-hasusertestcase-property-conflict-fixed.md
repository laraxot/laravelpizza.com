---
title: "Fatal error risolto: TestCase vs HasUserTestCase - conflitto proprietà $user"
module: "User"
type: bugfix
tags: [pest, testcase, fatal-error, property-conflict]
created: 2026-07-15
updated: 2026-07-15
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
qmd: "fatal error risolto: `testcase` vs `hasusertestcase`   conflitto proprietà `$user` user"
---

# Fatal error risolto: `TestCase` vs `HasUserTestCase`: conflitto proprietà `$user`

## Sintomo

`./vendor/bin/pest Modules/User` falliva con `PHP Fatal error: ... define the same property ($user) ... considered incompatible`: bloccava **l'intera suite Pest del modulo User** (non solo il file coinvolto), impedendo di verificare qualunque fix con `pest` come richiesto dal workflow del progetto.

## Causa

`Modules/User/tests/Feature/Authentication/UserAuthenticationTest.php` usava:
```php
uses(TestCase::class, HasUserTestCase::class);
```
`TestCase` dichiara già `public ?User $user = null;` (riga 82). `HasUserTestCase` (trait) dichiara `protected User $user;`: tipo non-nullable e visibilità diversa. Comporre le due nella stessa classe di test è illegale in PHP (property redeclaration incompatibile), fatal a tempo di composizione, prima ancora che un singolo test giri.

`HasUserTestCase` resta legittimo altrove (es. `HasUserTestCaseFixture`, dove non c'è conflitto perché la classe non estende `TestCase`), quindi il trait stesso non è stato toccato.

## Fix

Rimosso l'uso ridondante del trait nel test che estende già `TestCase` (che fornisce già `$user`):
```php
// Prima
uses(TestCase::class, HasUserTestCase::class);
// Dopo
uses(TestCase::class);
```
`beforeEach()` valorizza già `$this->user` prima di ogni test: nessun cambio di comportamento, solo rimossa la ridondanza che causava il conflitto.

## Verifica

`./vendor/bin/pest Modules/User/tests/Feature/Authentication/UserAuthenticationTest.php --list-tests` elenca correttamente tutti i 29 test (prima: fatal immediato).

Esecuzione completa (2026-07-15): la composizione ora funziona: i 31 test **vengono eseguiti** invece di fallire a livello di bootstrap. Tutti falliscono con `SQLSTATE[HY000] [2002] Connection timed out` verso `DB_HOST=10.100.200.53:3306` (`laravel/.env.testing`): **problema di raggiungibilità di rete verso il DB di test esterno**, non legato a questo fix né al codice applicativo. Chi riprende il lavoro deve verificare la connettività di rete/VPN verso `10.100.200.53` prima di poter eseguire la suite con asserzioni reali.
