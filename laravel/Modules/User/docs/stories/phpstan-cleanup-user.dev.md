---
title: "[DEV] PHPStan cleanup modulo User"
type: dev-story
status: done-with-blocker
tags: [user, phpstan, enum, migration, tests, quality]
created: 2026-10-06
updated: 2026-10-06
related:
  - "./2026-10-06-phpstan-cleanup-user.story.md"
  - "./8.1-phpstan-l10-user-config-offset-access.story.md"
  - "../../../../bashscripts/ai/wiki/rules/permission-config-table-names-immutable.md"
---

# [DEV] PHPStan cleanup modulo User

## Technical Plan

1. Leggere file, chiamanti (`grep`), doc modulo e history; capire lo scopo prima di toccare.
2. Dove l'errore indica logica mancante => implementarla (conteggio revoche, ramo "User not found", assert dei test).
3. Dove e' codice morto confermato dai chiamanti => rimuoverlo (variabili/query inutili), mai file.
4. Insiemi di valori => backed enum in `app/Enums/`; costanti di configurazione => costanti tipizzate.
5. Config `mixed` => restringere a runtime (`config()->boolean()/array()/string()` o `is_string`), mai `@var`.

## Files to Modify

Codice (`laravel/Modules/User/`):
- `app/Enums/NameSearchEnum.php` (nuovo), `DefaultRoleId.php` (nuovo), `FetchUserApiTokenExitCode.php` (nuovo), `UserType.php`
- `app/Actions/Socialite/ResolveUserNameFieldsFromSocialiteAction.php`, `app/Actions/Socialite/Utils/UserNameFieldsResolver.php`, `app/Adapters/Socialite/UserNameFieldsResolver.php`
- `app/Console/Commands/{AssignRole,AssignTenant,ChangeType,FetchUserApiToken}Command.php`
- `app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php`, `app/Filament/Tables/Columns/{UserColumn,SingleRoleSelectColumn}.php`
- `app/Http/Controllers/{UpgradeController,Socialite/ProcessCallbackController}.php`, `app/Http/Livewire/Auth/Passwords/Confirm.php`
- `app/Listeners/{LoginListener,FailedLoginListener,AssignFreeCreditsListener}.php`, `Listeners/AssignFreeCreditsListener.php` (copia orfana)
- `app/Models/{Role,User,BaseUser}.php`, `app/Models/Traits/InteractsWithTenant.php`
- `database/migrations/2026_10_05_174817_create_permission_tables.php`, `database/migrations/_legacy/2023_01_01_093340_create_permission_table.php`, `Database/Migrations/2023_01_01_093340_create_permission_table.php` (copia), `database/seeders/UserSeeder.php`

Test: `tests/Unit/{RoleTest,UserModelTest,AuthenticationBusinessLogicTest}.php`, `tests/Unit/Actions/User/*`, `tests/Unit/Rules/CheckOtpExpiredRuleTest.php`,
`tests/Unit/Filament/Widgets/EditUserWidgetTest.php`, `tests/Unit/Models/{TenantTest,PassportModelWrappersTest}.php`, `tests/Unit/Enums/PhpstanCleanupEnumsTest.php` (nuovo),
`tests/Feature/{UserCommandIntegrationTest,UserManagementBusinessLogicTest,user-management-business-logic}.php`, `tests/Feature/Authentication/{ApiLogoutControllerTest,UserAuthenticationTest}.php`,
`tests/Feature/Filament/Widgets/Team/TeamChangeWidgetTest.php`, `tests/Support/{helpers,helpers-extended}.php`.

## Implementation Steps

- [x] Migrazione permission: `configString()` (non vuoto, altrimenti default Spatie) + `config()->boolean/array`; chiave team: errore se `teams` attivo e chiave vuota, default `team_id` solo per `permission.testing`
- [x] Migrazioni legacy (2 copie): `config()->boolean/array/string`, ramo cache in `try` invariato
- [x] `NameSearchEnum::applyTo()` al posto di `->$metodo()` + `validateSearchMethod()` (3 classi; comportamento verificato con script: "John Doe", "John", email `john.doe@`, vuoto)
- [x] `DefaultRoleId` al posto delle costanti `Role::ROLE_*`; `RoleTest` aggiornato
- [x] `FetchUserApiTokenExitCode`; comando con query diretta cosi' il ramo "User not found" torna raggiungibile
- [x] `UserType`: guard inline (costanti eliminate)
- [x] Bulk revoke: `:count` passato a `static::trans(..., params: ['count' => $count])` (2 punti)
- [x] `ChangeTypeCommand`: `label ?? value`, `Htmlable` => `toHtml()`
- [x] `InteractsWithTenant::tenant()`: via il caricamento sessione scartato
- [x] Listener login: `$log` rimosso (create() resta), commento notifiche aggiornato
- [x] Seeder team: `array_map($this->createTeam(...), [...])`
- [x] `Confirm`: `view($view)->extends(...)` senza `@var View` (rimosso anche l'import)
- [x] Test: assert reali (execute/validate/message, relazioni Tenant, hash password, wrapper Passport `isSubclassOf`, token 2FA `forceFill`, login OTP => `true`)
- [x] Test fixture-only (`$role2`, `$editorRole`, `$deletePermission`): creati senza variabile con commento sul perche' esistono
- [x] Costanti rimaste tipizzate: `FREE_STARTING_CREDITS`, `DEFAULT_NAME` x2
- [ ] Alzare `laravel/composer.json` `require.php` a `^8.3`/`^8.4` (**decisione fuori scope**, sblocca 4 errori residui)

## Testing

Pest **non eseguito**: `.env.testing` usa `APP_ENV=local` + MySQL (`techplanner_data_test` su 127.0.0.1), non sqlite/in-memory => rischio sui dati. Verifica fatta con:
- `php -l` su tutti i file toccati
- script PHP puro (`vendor/autoload.php`) che confronta i 3 resolver (Action, Utils, Adapter) su 4 input
- `NameSearchEnum`, `UserType::getDefaultGuard()`, `FetchUserApiTokenExitCode` verificati via `php -r`
- nuovo test `tests/Unit/Enums/PhpstanCleanupEnumsTest.php` (da eseguire in ambiente di test sicuro)

## Verification

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/User --memory-limit=-1 --no-progress   # 108 -> 4 (solo classConstant.nativeTypeNotSupported)
for f in $(git status --short Modules/User | awk '{print $2}' | grep '\.php$'); do php -l "../$f"; done
```

## Lessons Learned

1. **Un `@var` inline non e' una correzione**: con `treatPhpDocTypesAsCertain: false` PHPStan continua a dire `mixed given`. La storia 8.1 dichiarava "0 errori" grazie a `@var` finti: ricontrollata, non reggeva. Restringere a runtime (`config()->string()`, `is_string()`).
2. **`null` in config e' voluto** (`role_pivot_key => null`): `config()->string($k, $default)` lancia, perche' la chiave esiste. Per le chiavi nullable serve un helper `is_string(...) ? ... : default`.
3. **"Variabile mai letta" spesso e' logica sparita**: `$count` (notifica), `$user_class` (ramo "not found" morto), `$labelString`, `$attributes` negli helper. Leggere i chiamanti e la lang prima di cancellare.
4. **Test senza assert sono bugie**: Una dozzina di test "has X" non verificavano nulla. Un assert su un tipo gia' noto a PHPStan (`method_exists` su classe nota) viene segnalato `alreadyNarrowedType`: usare `ReflectionClass::hasMethod/isSubclassOf`.
5. **Il working tree puo' contenere de-tipizzazioni fatte per zittire un'altra regola**: le costanti erano state private del tipo nativo per evitare `classConstant.nativeTypeNotSupported`, generando `constantTypeCoverage`. La causa e' `composer.json` `^8.2`, non le costanti: segnalare, non rimbalzare tra le due regole.
6. Duplicati non toccati (vedi report): `Listeners/` vs `app/Listeners/`, `Database/Migrations` vs `database/migrations/_legacy`, `Actions/Socialite/Utils` vs `Adapters/Socialite` resolver, `tests/Feature/user-management-business-logic.php`, helper 2FA definito 3 volte.
