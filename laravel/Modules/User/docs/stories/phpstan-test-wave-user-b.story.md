---
title: "PHPStan sui test User: spec non implementate sostituite da placeholder skip"
type: story
status: done
module: User
epic: phpstan-test-wave
tags: [phpstan, pest, test, skip, placeholder]
qmd: "phpstan test wave user skip placeholder specifica non implementata RefreshDatabase SoftDeletes Team memberships api users"
---

# PHPStan sui test User: spec non implementate sostituite da placeholder skip

## Contesto

Un'ondata PHPStan sui test del modulo ha trovato file scritti per API che il codice non ha mai avuto
(classi PHPUnit su `Tests\TestCase` con `RefreshDatabase`, che sul progetto e' vietato perche' i test girano su MySQL
senza `migrate:fresh`). Ogni `Model::factory()->create()` letto come `mixed` nascondeva chiamate a metodi inesistenti
(per esempio `Team::memberships()`, `roles()`, `userHasRole()`, `restore()` su un modello senza `SoftDeletes`).

## Decisione

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

## Regole che ne derivano

- Un test `skip` non e' copertura: va riscritto o cancellato alla fonte quando la funzionalita' esiste o e' definitivamente scartata
  (igiene dei test nel backlog: `user-test-igiene-phpunit-testcase-e-svuotati` e `user-test-senza-refresh-database`, in [backlog.md](backlog.md)).
- Mai `RefreshDatabase` ne' `migrate:fresh` nei test del modulo; si parte da `Modules\User\Tests\TestCase`.
- I placeholder portano `@see Modules/User/docs/stories/phpstan-test-wave-user-b.story.md`: questo file non si rinomina.

## Verifica

Eseguita sul codice: i quattro file che citano la story esistono e contengono un solo `it(...)->skip(...)`;
il conteggio dei `->skip(` nei test del modulo e' 21 righe in 9 file (`rg -n -F -e '->skip(' Modules/User/tests`).
