# HasNotificationTracking contract

Adds open-pixel and outbound-link rewrite to HTML bodies when
`notify.tracking` is enabled. Keeps tracking out of legacy HTTP controllers.

## Consumer

Wired on `Modules\Notify\Notifications\GenericNotification` so mail/HTML
channels can call `addTracking($html, $trackingId)` before render.

Full wiring rationale: [generic-notification-traits.md](./generic-notification-traits.md).

See also: [../no-notification-tracking-controller.md](../no-notification-tracking-controller.md).
