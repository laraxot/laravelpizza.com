# Event published scope contract

`Event::published()` returns only events whose workflow status is exactly
`published`. It overrides `HasCommonScopes::scopePublished` (which filters
`published_at`) because Event domain uses the `status` column.

PHPDoc uses `Builder<$this>` so the override stays compatible with the
parent `Builder<static>` signature on `HasCommonScopes`.

The scope filters the internal workflow `status`; the Schema.org
`event_status` enum remains a separate representation concern.
