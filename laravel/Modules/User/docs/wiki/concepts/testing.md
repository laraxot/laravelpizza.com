---
title: "User module testing and PHPStan discipline"
type: concept
tags: [user, pest, phpstan, testing]
created: 2026-06-13
updated: 2026-10-28
qmd: "User module pest phpstan skipUserTest uses fqcn helpers Safe glob"
issues:
discussions:
related:
  - "./ai-harness-user-discipline.md"
  - "./baseuser-hierarchy.md"
  - "./code-redundancy-user.md"
  - "./context-mode-user-discipline.md"
  - "./context-overflow-prevention.md"
  - "./filament-langserviceprovider-governance.md"
  - "./filament-widget-linear-crud-model-create.md"
  - "./filament-widget-resource-form-delegation.md"
status: draft
---

# Testing in User

Il modulo User resta **Pest-first**. PHPStan L10 sul modulo intero:

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/User
```

## Regole

- `uses(\Modules\User\Tests\TestCase::class)`: sempre FQCN, mai `uses(TestCase::class)`.
- Nei test namespaced importare esplicitamente facades, modelli ed eccezioni (`Schema`, `Str`, `Throwable`, `Profile`); non usare FQCN non importati nel corpo del test.
- Per `BelongsToMany` dichiarato da trait riusabili su piu model, non usare `$this` nel template `TDeclaringModel` se il contratto richiede `Model`: il template non e covariante e PHPStan segnala `return.type`.
- `membershipTeams()` resta API concreta di `BaseUser`/`HasTeams`: non inserirla in `Modules\Xot\Contracts\UserContract`; nei command/service che partono dal contratto usare `Assert::isInstanceOf($user, BaseUser::class)` prima della chiamata.
- Assertion: `PHPUnit\Framework\Assert::assert*` nelle closure (no `expect()->…` se segnalato `method.internalClass`).
- Eccezioni attese: `try/catch` + `Assert::fail()` / `Assert::assertSame()` sul messaggio (no catena `test()->throws()`).
- Skip senza `$this` in closure: helper globali in `tests/Support/helpers.php`:
  - `skipUserTest(string $message): never` → `Assert::markTestSkipped()`
  - `skipLegacyRedirectPersistenceCheck(): void`: Passport Create*ClientAction
- Seeders: `$this->seed(RolesSeeder::class)` con `@var TestCase $this` quando serve DB assertion; evitare `$this->app` protected.
- Helper tipizzati: `UserFactory::new()`, `Safe\glob`, `@param array<string,mixed>` su attributi factory.
- Closure Filament: ogni parametro ha un tipo nativo, scelto da cio' che Filament inietta (`vendor/filament/schemas/src/Components/Component.php`). `$context`/`$operation` → `string`; `$livewire` → `Livewire\Component`; `$record` → `?Model` in un form (e' `null` in creazione), `Model` in una relation manager; `$state` di un `TextInput` → `?string`. `mixed` solo se il corpo verifica comunque il tipo (es. `instanceof Carbon`). Un parametro mai letto (`$_permission`) si elimina: si filtra sulle chiavi.
- Closure/callback nei test (`array_map`, `usort`, `Collection::every`): tipo il parametro (`ReflectionParameter`, `stdClass`, `Permission`). La soglia `typeCoverage` e' del progetto intero: il controllo di modulo non la vede, serve `phpstan analyse` full-tree.
- Token di reset nei test: `Password::createToken($user)`; `Password::broker()` e' il contratto `PasswordBroker`, che non dichiara `createToken()`.
- Seeder: `Seeder::$command` e' `null` fuori da artisan, anche se il docblock dice `Command`. Si scrive `$this->command?->info(...)` direttamente, senza helper `getConsoleCommand(): ?Command` (PHPStan: `return.unusedType`).

## Quality gate locale

1. Pest: `cd laravel && ./vendor/bin/pest Modules/User/tests`
2. PHPStan: `cd laravel && ./vendor/bin/phpstan analyse Modules/User`
3. PHPMD: `cd laravel && ./tools/phpmd.sh Modules/User`
