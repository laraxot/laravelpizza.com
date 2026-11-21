---
title: "User module testing and PHPStan discipline"
type: concept
tags: [user, pest, phpstan, testing]
created: 2026-06-13
updated: 2026-07-06
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
---

# Testing in User

Il modulo User resta **Pest-first**. PHPStan L10 sul modulo intero:

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/User
```

## Regole

- `uses(\Modules\User\Tests\TestCase::class)` — sempre FQCN, mai `uses(TestCase::class)`.
- Nei test namespaced importare esplicitamente facades, modelli ed eccezioni (`Schema`, `Str`, `Throwable`, `Profile`); non usare FQCN non importati nel corpo del test.
- Per `BelongsToMany` dichiarato da trait riusabili su piu model, non usare `$this` nel template `TDeclaringModel` se il contratto richiede `Model`: il template non e covariante e PHPStan segnala `return.type`.
- `membershipTeams()` resta API concreta di `BaseUser`/`HasTeams`: non inserirla in `Modules\Xot\Contracts\UserContract`; nei command/service che partono dal contratto usare `Assert::isInstanceOf($user, BaseUser::class)` prima della chiamata.
- Assertion: `PHPUnit\Framework\Assert::assert*` nelle closure (no `expect()->…` se segnalato `method.internalClass`).
- Eccezioni attese: `try/catch` + `Assert::fail()` / `Assert::assertSame()` sul messaggio (no catena `test()->throws()`).
- Skip senza `$this` in closure: helper globali in `tests/Support/helpers.php`:
  - `skipUserTest(string $message): never` → `Assert::markTestSkipped()`
  - `skipLegacyRedirectPersistenceCheck(): void` — Passport Create*ClientAction
- Seeders: `$this->seed(RolesSeeder::class)` con `@var TestCase $this` quando serve DB assertion; evitare `$this->app` protected.
- Helper tipizzati: `UserFactory::new()`, `Safe\glob`, `@param array<string,mixed>` su attributi factory.

## Quality gate locale

1. Pest: `cd laravel && ./vendor/bin/pest Modules/User/tests`
2. PHPStan: `cd laravel && ./vendor/bin/phpstan analyse Modules/User`
3. PHPMD: `cd laravel && ./tools/phpmd.sh Modules/User`
