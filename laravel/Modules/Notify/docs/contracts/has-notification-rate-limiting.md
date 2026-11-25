# HasNotificationRateLimiting contract

Caps notification sends via Laravel `RateLimiter` using
`notify.rate_limiting` (`enabled`, `max_attempts`, `decay_minutes`).

## Consumer

Wired on `Modules\Notify\Notifications\GenericNotification` so every generic
(and subclass) send path can call `shouldSendNotification($key)` before dispatch.

Full wiring rationale: [generic-notification-traits.md](./generic-notification-traits.md).
