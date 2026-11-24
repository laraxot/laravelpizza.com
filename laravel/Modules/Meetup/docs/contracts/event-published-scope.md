# Event published scope contract

`Event::published()` returns only events whose workflow status is exactly
`published`. Domain filter on the `status` column — not Spatie/CMS
`published_at`.

`HasCommonScopes::scopePublished` (filters `published_at`) must **not** live
on `XotBaseModel`: wiring it there made `Event::scopePublished` a child
override and PHPStan failed (`method.childParameterType` /
`method.childReturnType` on `Builder<$this>` vs `Builder<static(XotBaseModel)>`).
Consumer of `HasCommonScopes`: `Notify\Models\NotificationTemplate` and
`Xot\Models\Module` only (never the base).

Se PHPStan riporta ancora quei 2 errori con il trait gia' fuori da
`XotBaseModel`: e' cache stantia — `./vendor/bin/phpstan clear-result-cache`
poi `analyse Modules`.

The scope filters the internal workflow `status`; the Schema.org
`event_status` enum remains a separate representation concern.

## Related

- [Xot standing PHPStan story](../../../Xot/docs/bmad/stories/phpstan-modules-zero-swarm-standing.story.md)
- [Notify NotificationTemplate](../../../Notify/app/Models/NotificationTemplate.php)
