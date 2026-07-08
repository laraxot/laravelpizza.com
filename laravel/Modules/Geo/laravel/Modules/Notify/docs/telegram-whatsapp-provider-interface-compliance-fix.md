# Telegram/WhatsApp provider action interface compliance fix

## Summary

A codebase audit (ponytail-audit) found two related problems in the Telegram
and WhatsApp provider action layer of the Notify module. One was dead code,
the other was a real runtime bug. Both are fixed as of this document.

## Problem A: `SmsProviderContract` removed (dead interface)

`Modules/Notify/app/Contracts/SmsProviderContract.php` had zero usages
anywhere in the project besides its own declaration. SMS providers actually
implement `Modules\Notify\Contracts\SMS\SmsActionContract` instead (see
`Modules/Notify/app/Actions/SMS/`). The unused `SmsProviderContract` file has
been deleted. No other file referenced it, so this is a pure removal with no
behavior change.

## Problem B: provider actions not implementing their own interface (real bug)

`TelegramActionFactory::create()` and `WhatsAppActionFactory::create()` both
resolve a driver class name at runtime (for example
`Send{Driver}TelegramAction`) and then guard with:

```php
if (! is_subclass_of($className, TelegramProviderActionInterface::class)) {
    throw new Exception("Class {$className} does not implement TelegramProviderActionInterface.");
}
```

Before this fix, only **one** concrete action per channel actually declared
`implements` the corresponding interface:

- Telegram: only the default driver implicitly worked by luck of factory
  defaults; none of `SendOfficialTelegramAction`, `SendNutgramTelegramAction`,
  `SendBotmanTelegramAction` declared `implements
  TelegramProviderActionInterface`.
- WhatsApp: only `SendTwilioWhatsAppAction` declared `implements
  WhatsAppProviderActionInterface`. `SendVonageWhatsAppAction`,
  `Send360dialogWhatsAppAction`, and `SendFacebookWhatsAppAction` did not.

**Effect in production**: selecting any Telegram driver other than the
implicit default, or any WhatsApp driver other than Twilio (e.g. via
`config('telegram.default')` / `config('whatsapp.default')` or an explicit
`$driver` argument), caused `TelegramActionFactory::create()` /
`WhatsAppActionFactory::create()` to throw immediately, even though the
selected action class was otherwise fully functional and its `execute()`
method signature already matched the interface exactly (same parameter type,
same `array<string, mixed>` return type).

### Fix

Added the missing `implements` declaration (plus the corresponding `use`
import) to the six action classes below. No other code in these classes was
changed — the method bodies were already interface-compliant:

- `Modules/Notify/app/Actions/Telegram/SendOfficialTelegramAction.php`
- `Modules/Notify/app/Actions/Telegram/SendNutgramTelegramAction.php`
- `Modules/Notify/app/Actions/Telegram/SendBotmanTelegramAction.php`
- `Modules/Notify/app/Actions/WhatsApp/SendVonageWhatsAppAction.php`
- `Modules/Notify/app/Actions/WhatsApp/Send360dialogWhatsAppAction.php`
- `Modules/Notify/app/Actions/WhatsApp/SendFacebookWhatsAppAction.php`

`SendTwilioWhatsAppAction` already implemented `WhatsAppProviderActionInterface`
and was left untouched.

All six classes now implement their respective interface:

- `Modules\Notify\Contracts\TelegramProviderActionInterface` — requires
  `execute(TelegramData $telegramData): array`.
- `Modules\Notify\Contracts\WhatsAppProviderActionInterface` — requires
  `execute(WhatsAppData $whatsappData): array`. The concrete classes use the
  parameter name `$whatsAppData` (capital A); PHP does not require parameter
  names to match between an interface and its implementation, so this is not
  a conflict.

### Test updated

`Modules/Notify/tests/Unit/Factories/ActionFactoriesTest.php` had a test named
`'telegram action factory throws when selected class does not implement
interface'` that asserted `TelegramActionFactory->create('official')` threw
an exception — i.e. it encoded the bug as expected behavior. That test was
rewritten to `'telegram action factory creates official driver instance'`,
asserting the factory now returns a valid
`TelegramProviderActionInterface` instance, mirroring the existing WhatsApp
Twilio test.

## Verification performed

- `php -l` on all six modified files: no syntax errors.
- `./vendor/bin/phpstan analyse Modules/Notify` (single-process/`--debug`
  mode, to avoid an unrelated pre-existing parallel-worker crash in
  `Modules/Xot/app/Filament/Resources/Pages/XotBaseManageRelatedRecords.php`):
  no errors.
- `php tools/phpmd.phar` against `app/Contracts`, `app/Actions/Telegram`,
  `app/Actions/WhatsApp` (cleancode, codesize, design, unusedcode rulesets):
  only pre-existing complexity/style warnings already present on the
  untouched `SendTwilioWhatsAppAction`, i.e. nothing newly introduced by
  adding `implements`.
- `./vendor/bin/phpinsights analyse Modules/Notify`: no new architecture
  violations related to the interface changes.
- `./vendor/bin/pest` against the Notify Telegram/WhatsApp/Factories/Channels
  test files: 116 passing, 1 pre-existing unrelated failure in
  `NotificationsChannelsTest` (`TelegramChannel` calls `Log::debug()` but the
  test mocks `Log::shouldReceive('info')`) — untouched by this fix, confirmed
  via `git log` to predate this change.
- No browser/Playwright/Puppeteer testing was performed: these are outbound
  HTTP actions calling external Telegram/WhatsApp APIs with no UI surface to
  drive.

## Related docs

- `Modules/Notify/docs/telegram_provider_architecture.md` and
  `Modules/Notify/docs/whatsapp-provider-architecture.md` describe an
  aspirational/example architecture (e.g. `SendBotTelegramAction`,
  `SendApiTelegramAction`) that does not match the actual driver class names
  in this codebase (`SendOfficialTelegramAction`, `SendNutgramTelegramAction`,
  `SendBotmanTelegramAction`, `SendVonageWhatsAppAction`,
  `Send360dialogWhatsAppAction`, `SendFacebookWhatsAppAction`,
  `SendTwilioWhatsAppAction`). This document intentionally describes the real
  , current implementation instead of duplicating or rewriting those files.
