---
title: "Notify — test doubles e helper PHPStan"
type: concept
tags: [notify, phpstan, pest, testing, doubles]
created: 2026-06-13
updated: 2026-07-06
qmd: "Notify NotificationManager test doubles trait PHPStan Pest mockService"
issues:
  - "https://github.com/laraxot/module_fixcity_fila5/issues/52"
discussions:
  - "https://github.com/laraxot/module_fixcity_fila5/discussions/53"
related:
  - ./testing.md
  - ../../phpstan-compliance-status.md
  - ../../../Xot/docs/wiki/concepts/phpstan-pest-bridge-discipline.md
---

# Notify — test doubles e helper PHPStan

## Contesto

Sessione 2026-06-13: ~28 errori PHPStan in `Modules/Notify/tests/` (manager nullable, classi dummy mancanti, mock Mockery vs PHPUnit).

## Migliorie applicate

### 1. `notificationManager()` su TestCase

```php
public function notificationManager(): NotificationManager
{
    Assert::assertNotNull($this->notificationManager);
    return $this->notificationManager;
}
```

Rimuove `assert()` ridondanti e narrowing manuale nelle closure.

### 2. Test doubles per trait coverage

File owner: `tests/Unit/Traits/NotifyTraitTestDoubles.php`

| Classe | Trait coperto |
|--------|---------------|
| `NotifyRateLimitDummy` | `HasNotificationRateLimiting` |
| `NotifyTrackingDummy` | `HasNotificationTracking` |
| `NotifyTenantDummyModel` | `HasTenantNotifications` |

Espongono metodi `public` che delegano ai `protected` del trait — pattern KISS per test unitari senza istanziare modelli Eloquent completi.

### 3. Mock `SendNotificationAction`

Preferire `createStub` / `createUnitMock` + `expectsOnce()` da `XotBaseTestCase`, non `Mockery::shouldReceive()->once()` (PHPStan L10 su union Mockery).

### 4. Test reflection PHPStan-safe

- Usare `Safe\class_uses()` e `Safe\file_get_contents()` nei test strutturali.
- Prima di chiamare `ReflectionType::getName()`, restringere a `ReflectionNamedType`; `ReflectionUnionType` e `ReflectionIntersectionType` non espongono `getName()`.
- `ReflectionClass::getFileName()` puo restituire `false`: verificare e passare una stringa a `file_get_contents()`.

## Cosa resta per Notify

| Task | Priorità |
|------|----------|
| Copertura Pest su `Actions/SendNotificationAction` | P1 |
| Allineare test channel (mail, SMS, push) a pattern stub | P2 |
| Migrare test che istanziano `Services/NotificationManager` verso Actions quando il manager sarà thin | P2 |
| Namespace `tests/` vs `Tests` — [#370](https://github.com/laraxot/base_fixcity_fila5/issues/370) | P2 |

## Verifica

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Notify/tests
./vendor/bin/pest Modules/Notify/tests
```

Aggiornamento 2026-07-06:

- `NetfunSendActionTest` usa varianti Safe e restringe i tipi reflection prima di leggere nomi/file.
- `NotificationManagerTest` usa recipient reali Eloquent nei punti in cui il servizio richiede `Model`.
- I test helper globali condivisi tra moduli devono essere idempotenti (`function_exists`) quando PHPStan carica piu suite nello stesso processo.
- PHPStan globale su `Modules` e tornato a zero errori; PHPMD resta bloccato dall'assenza locale di `tools/phpmd.phar`.
