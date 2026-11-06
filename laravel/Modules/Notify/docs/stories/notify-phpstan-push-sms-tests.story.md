---
title: "PHPStan zero su test push e SMS Notify"
type: story
status: done
priority: high
module: Notify
tags: [phpstan, push, sms, pest, swarm]
related:
  - ./phpstan-notify-push-delivery.story.md
  - ./4.32.notify-phpstan-swarm-internal-errors.story.md
  - ../wiki/concepts/services-to-actions-migration.md
---

# PHPStan zero: test push / SMS / API template

## Scopo

I quattro file sotto `tests/` documentano il recapito **push** (payload
`PushNotificationData` + Action `Actions/Push/*`) e **SMS** (normalizzazione
numero + formattazione GSM), più l’API REST dei template. Gli errori PHPStan
derivavano da test scritti per un DTO FCM “monolitico” (`token`, `tokens`,
`topic`, `toFcmArray()`) e per `SendPushNotificationAction`, rimossi con la
migrazione canonica descritta in
[services-to-actions-migration](../wiki/concepts/services-to-actions-migration.md).

## Famiglie risolte (76 → 0)

| Identificatore | Causa radice | Fix |
|----------------|--------------|-----|
| `class.notFound` | Test importava `SendPushNotificationAction` cancellata | Allineato a `SendPushToDeviceAction`, `SendPushToDevicesAction`, `SendPushToTopicAction` |
| `argument.unknown` / `property.notFound` | Parametri FCM sul DTO che oggi descrive solo il blocco *notification* | Assert su campi reali (`title`, `body`, `icon`, `priority`, `ttl`, …) |
| `method.notFound` | `toFcmArray()` non esiste sul Data | `toArray()` Spatie Data |
| `method.nonObject` / `argument.type` | `User::factory()` e `NotificationTemplate::create()` senza tipo | `UserFactory` / `NotificationTemplateFactory::createOne()`, helper `assertNotifyArray`, `assertFreshModel` |
| `variable.unused` | Template creato ma non usato nell’assert | Assert su `code` o refresh tipizzato |
| `argument.type` / `pest.expectation.*` | `FormatSmsMessageAction::execute` restituisce `array{0: string, 1: int, 2: int}` | Destructuring tipizzato; assert su conteggio SMS concatenati, non troncamento inventato |

## File toccati

- `tests/Unit/Datas/PushNotificationDataTest.php`
- `tests/Unit/Actions/Push/SendPushNotificationActionTest.php` (contenuto = Action `Push/*` canonica)
- `tests/Feature/NotificationApiTest.php`
- `tests/Unit/Actions/SMS/SendSmsActionTest.php`

## Verifica

```bash
cd laravel && ./vendor/bin/phpstan analyse \
  Modules/Notify/tests/Unit/Datas/PushNotificationDataTest.php \
  Modules/Notify/tests/Unit/Actions/Push/SendPushNotificationActionTest.php \
  Modules/Notify/tests/Feature/NotificationApiTest.php \
  Modules/Notify/tests/Unit/Actions/SMS/SendSmsActionTest.php
```

Exit `0`, messaggio `[OK] No errors`.

Nota harness: test che chiamano `config()` / `Http::fake()` richiedono
`Modules\Notify\Tests\TestCase` (Pest extend); `vendor/bin/pest` su path
singolo senza bootstrap app resta limite d’ambiente documentato in 4.29.
