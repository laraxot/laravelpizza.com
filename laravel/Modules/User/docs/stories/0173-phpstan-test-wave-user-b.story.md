---
title: "STORY — test User scritti per API inesistenti: placeholder skip invece di corpi non eseguibili"
type: story
status: done
date: 2026-11-25
module: User
decision-makers:
qmd: "phpstan test wave user skip placeholder specifica non implementata RefreshDatabase SoftDeletes Team memberships api users"
related: ["user-test-igiene-phpunit-testcase-e-svuotati", "user-test-senza-refresh-database"]
---


# Test User per API inesistenti: placeholder skip invece di corpi non eseguibili

## Context and Problem Statement

Un'ondata PHPStan sui test del modulo ha trovato file scritti per API che il codice non ha mai avuto
(classi PHPUnit su `Tests\TestCase` con `RefreshDatabase`, che sul progetto e' vietato perche' i test girano su MySQL
senza `migrate:fresh`). Ogni `Model::factory()->create()` letto come `mixed` nascondeva chiamate a metodi inesistenti
(per esempio `Team::memberships()`, `roles()`, `userHasRole()`, `restore()` su un modello senza `SoftDeletes`).

## Decision Drivers

- `RefreshDatabase` e `migrate:fresh` sono vietati nei test del modulo (dati reali su MySQL).
- PHPStan non deve piu' leggere chiamate a metodi che i modelli non hanno.
- Un test che non puo' fallire e' copertura apparente.

## Considered Options

- Riparare i corpi: richiede di implementare API assenti (`Team::roles()`, `restore()` senza `SoftDeletes`, rotte `api/users`).
- Cancellare i file: perde la specifica che qualcuno voleva.
- Placeholder `->skip('<motivo>')` con docblock e recupero da git (scelta).

## Decision Outcome

Il corpo di quei test non si ripara: il file diventa un solo test Pest con `->skip('<motivo>')` e un docblock che
nomina cosa manca, dove sta la copertura valida e come recuperare il corpo originale da git. Quando l'API esistera',
il corpo si riscrive in Pest su `Modules\User\Tests\TestCase`, non si ripristina com'era.

## Placeholder risultanti (`rg -n -F -e '->skip(' Modules/User/tests`)

| File | Cosa manca | Copertura valida |
|---|---|---|
| `tests/Feature/TeamManagementBusinessLogicTest.php` | `Team::memberships()`, `roles()`, `invitations()`, `userHasRole()`, `restore()` | `TeamManagementTest.php`, `TeamManagementInvitationsTest.php`, `TeamManagementBusinessLogicInvitationsTest.php` |
| `tests/Unit/Models/RoleTest.php` | costanti `Role::ROLE_*` | `tests/Unit/RoleTest.php` |
| `tests/Unit/Models/UserTest.php` | `restore()` (nessun `SoftDeletes`) | `Unit/UserTest.php`, `Unit/UserModelTest.php`, `Unit/Models/BaseUserTest.php`, `Unit/Models/UserBusinessLogicTest.php` |
| `tests/Feature/Api/UserApiTest.php` | rotte e controller `api/users` (DCP-252) | nessuna |
| `tests/Feature/Filament/Pages/ListUsersTest.php` | sette metodi tabella di `ListUsers` (`getTableQuery()`, `canSelectRecords()`, ...) | non verificata |
| `tests/Feature/Filament/Widgets/Auth/LoginWidgetTest.php` | blade di login troncata (bug preesistente) | non verificata |
| `tests/Feature/ChangeProfilePasswordTest.php`, `tests/Unit/UserTest.php`, `tests/Feature/UserModelTest.php` | rotta `change-password` dei profili; `SoftDeletes` sul model User | non verificata |

### Consequences

- Un test `skip` non e' copertura: va riscritto o cancellato alla fonte quando la funzionalita' esiste o e' definitivamente scartata
  (igiene dei test nel backlog: `user-test-igiene-phpunit-testcase-e-svuotati` e `user-test-senza-refresh-database`, in `backlog.md`).
- Mai `RefreshDatabase` ne' `migrate:fresh` nei test del modulo; si parte da `Modules\User\Tests\TestCase`.
- I placeholder portano `@see Modules/User/docs/stories/0173-phpstan-test-wave-user-b.story.md`: il numero di questa story e il suo percorso compaiono in quei docblock.

### Confirmation

Eseguita sul codice: i quattro file che citano la story esistono e contengono un solo `it(...)->skip(...)`;
il conteggio dei `->skip(` nei test del modulo e' 21 righe in 9 file (`rg -n -F -e '->skip(' Modules/User/tests`).
