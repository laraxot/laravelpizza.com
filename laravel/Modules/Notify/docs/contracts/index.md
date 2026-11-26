---
title: "INDEX — Notify"
type: index
status: active
created: 2026-11-23
updated: 2026-11-23
decision-makers: []
qmd: "notify index contracts"
---

<!-- File: docs/contracts/INDEX.md · formato MADR breve. -->

# <!-- Titolo: indice operativo Notify -->

Elenco operativo dei contract comportamentali del modulo Notify.

| Operazione | Contract | Classe | Invarianti |
|---|---|---|---|
| Gestione stati modello | [modelwithstatuscontract](modelwithstatuscontract.md) | `Modules\Xot\Contracts\ModelWithStatusContract` | NOTIFY-INV-1 |

## Trait di notifica (rate limiting, tracking, tenant)

Pagina canonica a cui rimandano i docblock `@see` di `Traits\HasNotificationRateLimiting`, `Traits\HasNotificationTracking`,
`Traits\HasTenantNotifications` e dei loro consumer. Aggiornare qui invece di creare una pagina per trait.

| Trait | Scopo | Consumer in `app/` |
|---|---|---|
| `HasNotificationRateLimiting` | Cap sui tentativi di invio per chiave (`notify.rate_limiting`: `enabled`, `max_attempts`, `decay_minutes`) | `Notifications\GenericNotification` |
| `HasNotificationTracking` | Pixel di apertura + riscrittura dei link nell'HTML (`notify.tracking`: `enabled`, `pixel`, `links`) | `Notifications\GenericNotification` |
| `HasTenantNotifications` | Morph verso `NotificationLog` + scope `forTenant` filtrati sul tenant Filament corrente | `Models\Notification`, `Models\TenantNotifiable` |

- **Rate limiting e tracking sono della notifica inviabile, non dei model.** `GenericNotification` li include e li mette a
  disposizione di se' e delle sottoclassi: `shouldSendNotification($key)` (via libera o no, con `RateLimiter`),
  `getNotificationRateLimitKey($type, $id)` (chiave `notify:<tipo>:<id>`), `addTracking($html, $trackingId)` (link + pixel).
  Con la config `enabled` spenta restituiscono l'input invariato / `true`. Non esiste un controller HTTP di tracking:
  vedi [no-notification-tracking-controller](../no-notification-tracking-controller.md). I link `unsubscribe`, `mailto:`, `tel:`,
  gli anchor e gli URL relativi non vengono riscritti.
- **Tenant: log morph, non database notifications Laravel.** Il trait espone `notifications()`, `unreadNotifications()`,
  `readNotifications()` su `NotificationLog`, imposta `tenant_id` alla creazione e aggiunge un global scope sul tenant
  corrente. Non combinarlo con `Illuminate\Notifications\Notifiable` sullo stesso model (collisione su `notifications()` e
  `unreadNotifications()`).
- **Generics PHPStan.** `morphMany()` e' tipizzato `MorphMany<Related, $this>`: dichiarare `MorphMany<NotificationLog, TModel>`
  produce un errore di covarianza, quindi nel trait si usa `$this` (stessa cosa per `Builder<$this>` su `scopeForTenant`).
- **Consumer e `trait.unused`.** I dummy sotto `tests/Unit/Traits/` non bastano a PHPStan (i test sono fuori dal gate): i
  consumer di produzione elencati sopra devono restare cablati; un ignore richiede un ADR.