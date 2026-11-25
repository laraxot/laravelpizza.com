# HasTenantNotifications contract

`HasTenantNotifications` adds tenant-aware notification-log relationships and
the `forTenant` query scope to an Eloquent model.

Purpose: **NotificationLog** morph logs filtered by current Filament tenant —
not Laravel database notifications (`Illuminate\Notifications\Notifiable`).

## Generics

PHPStan/Larastan type `morphMany()` as `MorphMany<Related, $this>`. Declaring
`MorphMany<NotificationLog, TModel>` (even with `@use HasTenantNotifications<Notification>`)
fails with covariance mismatch against `$this`. Use `$this` directly:

```php
use HasTenantNotifications;

/** @return MorphMany<NotificationLog, $this> */
public function notifications(): MorphMany
```

Same for `Builder<$this>` on `scopeForTenant`.

## Consumers

- `Modules\Notify\Models\Notification` — record di dominio Notify (UUID, canali, status)
- `Modules\Notify\Models\TenantNotifiable` — host minimo multi-tenant (fillable `tenant_id`)

I test usano dummy (`NotifyTenantDummyModel`): non bastano per PHPStan perche'
`tests/` e' escluso dal gate. I consumer di produzione devono restare cablati.

Do not combine this trait with `Notifiable` on the same class (method name collision
on `notifications()` / `unreadNotifications()`).

Vedi anche [generic-notification-traits.md](./generic-notification-traits.md) per
rate-limit/tracking su `GenericNotification`.
