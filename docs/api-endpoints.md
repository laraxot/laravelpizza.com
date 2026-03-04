# API Endpoints - LaravelPizza Meetup Platform

## Architecture Note

LaravelPizza uses **Folio + Volt + CMS-driven pages** for the public frontend. There are NO traditional API controllers or routes in web.php/api.php for front office pages.

API endpoints exist only for:
- OAuth authentication (Laravel Passport)
- Filament admin panel (backend)
- Potential future mobile app integration

## Authentication (Laravel Passport)

### Login
- **POST** `/oauth/token`
  - **Description**: OAuth2 token generation
  - **Body**: `grant_type`, `client_id`, `client_secret`, `username`, `password`

### Social Login
- **GET** `/auth/{provider}/redirect` (e.g., `/auth/github/redirect`)
  - **Description**: Redirect to OAuth provider (GitHub, Google)
- **GET** `/auth/{provider}/callback`
  - **Description**: OAuth callback handler

## Filament Admin API (Internal)

Filament resources expose CRUD operations via Livewire, not REST endpoints.

### Event Management
- `EventResource` — CRUD for meetup events
- `EventCalendarWidget` — Calendar view (saade/filament-fullcalendar)

### User Management
- `UserResource` — Admin user management
- Role/Permission via Spatie Permission

## CMS Content (JSON-driven, NOT API)

Content is served via CMS JSON files, not API endpoints:

```
config/local/laravelpizza/database/content/pages/
├── home.json          → /it/ or /en/
├── events.json        → /it/events or /en/events
├── about.json         → /it/about or /en/about
├── contact.json       → /it/contact or /en/contact
└── {slug}.json        → /it/{slug} or /en/{slug}
```

## Localization

All public URLs are localized:
- `LaravelLocalization::localizeUrl('/events')` → `/it/events` or `/en/events`
- 6 supported locales: it, en, es, de, fr, ru
