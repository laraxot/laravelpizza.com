# Notify Chaos Readiness - 2026-03-02

## Scope
- Optional Firebase/FCM dependency hardening.

## Completed
- Refactored push notification pages to avoid hard dependency crashes.
- Refactored Firebase notification class with runtime guards.
- Added missing `MailTemplateVersionFactory` for static analysis consistency.
- Verified `Modules/Notify` passes PHPStan.

## Next Chaos Steps
- Disable Firebase packages and verify UI-level warning path.
- Inject invalid cloud message contracts and ensure controlled failures.
