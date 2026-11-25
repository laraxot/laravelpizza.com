---
title: "Notify notification traits — purpose and consumers"
status: active
module: Notify
updated: 2026-11-24
qmd: "notify traits rate limiting tracking tenant GenericNotification trait.unused"
---

# Notify notification traits — purpose and consumers

Hub unico (DRY): perche' esistono i trait Notify e dove sono cablati in `app/`.
I dummy sotto `tests/Unit/Traits/` **non** soddisfano PHPStan `trait.unused`
(i test sono fuori dal neon). Aggiorna questa pagina invece di crearne gemelle.

| Trait | Scopo (business why) | Consumer in `app/` | Dettaglio |
|-------|----------------------|--------------------|-----------|
| `HasNotificationRateLimiting` | Cap tentativi di invio per chiave (`notify.rate_limiting`) | `Notifications\GenericNotification` | [has-notification-rate-limiting.md](./has-notification-rate-limiting.md) |
| `HasNotificationTracking` | Pixel open + rewrite link HTML senza controller HTTP legacy (`notify.tracking`) | `Notifications\GenericNotification` | [has-notification-tracking.md](./has-notification-tracking.md) |
| `HasTenantNotifications` | Morph `NotificationLog` + scope `forTenant` (tenant Filament, non `Notifiable` Laravel) | `Models\Notification`, `Models\TenantNotifiable` | [has-tenant-notifications.md](./has-tenant-notifications.md) |

## Rate limit + tracking (sendable)

Appartengono all'oggetto **notifica inviabile**, non ai model Eloquent:
`GenericNotification` chiama `shouldSendNotification()` / helper di tracking
intorno al render del canale.

- `Modules\Notify\Notifications\GenericNotification` — `use HasNotificationRateLimiting; use HasNotificationTracking;`

## Tenant (Eloquent host)

Appartengono al model che espone i log morph filtrati per tenant. Non combinare
con `Illuminate\Notifications\Notifiable` (collisione su `notifications()`).

- `Modules\Notify\Models\Notification`
- `Modules\Notify\Models\TenantNotifiable`

## PHPStan `trait.unused`

Ordine: censimento cross-base (pizza vs ptvx) → **wire** in `app/` → park solo
se nessun consumer nel fleet. Mai probe; ignore solo con ADR. Canone:
[37-phpstan.md](../../../../../../bashscripts/docs/prompts/37-phpstan.md).

## Related

- [has-tenant-notifications.md](./has-tenant-notifications.md)
- [../no-notification-tracking-controller.md](../no-notification-tracking-controller.md)
- [phpstan-modules-zero-handoff.md](../../../Xot/docs/bmad/stories/phpstan-modules-zero-handoff.md)
