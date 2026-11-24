# Events Page - Theme Implementation

## Status: ✅ WORKING

The events page at `http://127.0.0.1:8000/it/events` is now displaying events from the database.

## Component

`Themes/Meetup/resources/views/components/blocks/events/list.blade.php`

## Features

- Events loaded dynamically from `Modules\Meetup\Models\Event`
- Scope filtering: `upcoming` scope
- Ordering: by `start_date` ascending
- SEO-friendly URLs with slugs

## Sorgenti del blocco (versione del progetto, non quella generica)

`events/list.blade.php` legge `events_source` dal JSON della pagina CMS (`pages/events.json`, `pages/events/past.json`,
`pages/events/my.json`): `public` (elenco pubblico con filtri citta'/date, `SearchPublicEventsAction`), `user_subscribed`
("I miei eventi", `GetUserRegisteredEventsAction`), nessuna (eventi passati dal CMS). Icone solo come `<x-filament::icon icon="meetup-...">`
(niente SVG inline). Una sincronizzazione con il tema generico aveva rimesso la versione senza `events_source`: l'elenco
`/it/events` usciva senza eventi (`PublicEventsListTest`, `EventVisibilityPageTest`). Ripristinata la versione del progetto e
rimesse in `lang/{it,de,es}/events.php` le chiavi `search.*` (guardia: `ThemeIntegrityTest`).

## Screenshots

- Desktop: `docs/screenshots/events-page-desktop.png`
- Mobile: `docs/screenshots/events-page-mobile.png`

## Related Documentation

- `Modules/Meetup/docs/events-page-implementation-feb2026.md`
