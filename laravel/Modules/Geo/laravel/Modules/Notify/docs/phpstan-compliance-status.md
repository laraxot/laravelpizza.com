# PHPStan Level 10 Compliance Status

**Last Updated**: 2026-07-06
**Status**: ✅ FULLY COMPLIANT (0 errors, level max)

Baseline STORY-289: 279 → 0. Pattern: `notify-env.php` + `MergesNotifyConfigFromEnv`, PushNotificationService PHPDoc.

Baseline sessione 2026-07-06: 193 → 0. Molti file in `tests/Unit/Actions` (SMS providers) mancavano di `namespace` e/o `uses(TestCase::class)`, oppure avevano un helper `assertReflectionTypeName()` locale corrotto (parametri senza nome, sintassi rotta) che duplicava quello già definito in `tests/Pest.php`. Corretti aggiungendo namespace/`uses()` mancanti e rimuovendo le ridefinizioni corrotte.

## Summary
The Notify module is now fully compliant with PHPStan Level 10 analysis. All static analysis errors have been resolved, ensuring type safety and code quality.

## Fixed Issues

### 1. HTTP Client PromiseInterface|Response Union Type
**Problem**: HTTP client methods may return PromiseInterface or Response
**Solution**: Added proper type checking and casting
**File**: `app/Services/PushNotificationService.php`
**Details**: Added instanceof check for PromiseInterface and wait() method call

```php
// Ensure we have a Response, not Promise
if ($response instanceof \GuzzleHttp\Promise\PromiseInterface) {
    $response = $response->wait();
}

/** @var \Illuminate\Http\Client\Response $response */
```

## Compliance Verification
```bash
./vendor/bin/phpstan analyse Modules/Notify --level=10 --memory-limit=-1
# Result: [OK] No errors
```

## Test suite (2026-06-13)

- Helper `notificationManager()` su `Modules\Notify\Tests\TestCase`
- Doubles trait: `tests/Unit/Traits/NotifyTraitTestDoubles.php`
- Doc: [wiki/concepts/phpstan-pest-test-doubles.md](wiki/concepts/phpstan-pest-test-doubles.md)


1. **HTTP Client Safety**: Proper handling of async HTTP responses
2. **Union Type Management**: Safe handling of PromiseInterface|Response unions
3. **Type Casting**: Using PHPDoc to cast to specific types
4. **Service Architecture**: Clean service implementation with proper typing

## Module Overview

The Notify module provides:
- Push notification management
- Multi-platform notification support (FCM, APNS, Web Push)
- Email notification services
- Notification scheduling
- Template-based notifications

## HTTP Client Pattern

When using Laravel HTTP client:
1. Always check for PromiseInterface
2. Use wait() to resolve promises
3. Cast to Response with PHPDoc
4. Handle both sync and async responses

## Ongoing Maintenance

To maintain PHPStan compliance:
1. Always handle PromiseInterface in HTTP calls
2. Use proper PHPDoc casting for complex types
3. Test notification services thoroughly
4. Verify all service methods have proper return types

## Related Documentation
- [Laravel HTTP Client](https://laravel.com/docs/12.x/http-client)
- [Push Notification Services](push-notification-services.md)
- [Notification Patterns](notification-patterns.md)
- [Service Architecture](service-architecture.md)

## Aggiornamento 2026-07-06

Ri-verificato a zero errori (`./vendor/bin/phpstan analyse Modules/Notify --no-progress`).
Fix applicati in questa sessione:
- Nessuna estensione PHPStan/Larastan per Mockery in questo progetto: creato
  `tests/Support/helpers.php` (`typedMock()`, `mockExpectation()`), stesso
  pattern di `Modules/User/tests/Support/helpers.php::typedMock()`.
- `NotificationManagerTest.php`: asserzioni tautologiche rimosse, mock
  tipizzati, test strutturali senza valore (`method_exists`) rimossi.
- 8 file `Send*SMSActionTest.php` + `NetfunSendActionTest.php`: pattern
  rotto `getType()?->getName()` (solo `ReflectionNamedType` ha `getName()`),
  import `Safe\*` mancanti, sintassi corrotta da un refactor automatico
  precedente.
- Rimossi i probe PHPStan morti (`*PhpstanProbe*`).

Dettagli completi: `docs/chat/phpstan-notify-module-zero-2026-07-06.md` (root repo).
