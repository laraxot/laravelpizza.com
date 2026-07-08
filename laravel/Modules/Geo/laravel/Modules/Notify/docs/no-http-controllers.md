# No HTTP controllers in any module

## Rule

No module may contain HTTP controllers. The architecture is Folio + Volt (front office) and Filament (admin) exclusively.

This applies to every module: Notify, User, Meetup, Cms, Gdpr, Geo, Lang, Tenant, Xot, and all others.

## Violation found and removed

**File**: `Modules/Notify/app/Http/Controllers/NotificationTrackingController.php`

This controller handled email open/click tracking via HTTP GET requests. It was deleted entirely.

## Why controllers violate the architecture

### Architecture contract

The project's CLAUDE.md defines the only valid patterns for HTTP request handling:

| Use case | Correct mechanism |
|---|---|
| Public pages | Folio catch-all `[slug].blade.php` + JSON page content |
| Authenticated front office | Volt components inside Folio pages |
| Admin panel | Filament resources, pages, and widgets |
| Background work | Queued Jobs and Actions |

There is no slot for a traditional controller.

### What happens when controllers are added

- They create implicit routing that bypasses the Folio/Localization middleware stack
- They cannot use `LaravelLocalization::localizeUrl()` for redirects correctly
- They bypass the `pub_theme::` namespace resolution
- They undermine the CMS-driven page model — the page has no JSON definition
- They introduce a parallel routing system that conflicts with Folio's file-based routing

### The Notify module specifically

The `Notify` module is responsible for:
- Queuing and sending notifications (email, SMS, push, etc.)
- Providing Filament admin UI for notification management
- Defining Notification classes and their channels

It is not responsible for handling inbound HTTP tracking pixels or link redirects. That concern belongs to either:
- A Folio page in the theme (`Themes/Meetup/resources/views/pages/track/[token].blade.php`)
- A Livewire Volt component that performs the tracking and redirects

## Correct approach for email tracking

If email open/click tracking is needed:

1. Create a Folio page in the theme:
   ```
   Themes/Meetup/resources/views/pages/track/[token].blade.php
   ```

2. Inside that Folio page, use a Volt component or inline PHP to:
   - Decode the token
   - Record the tracking event (via an Action)
   - Redirect to the final destination

3. The tracking Action lives in `Modules/Notify/app/Actions/TrackNotificationOpenAction.php`.

This keeps the HTTP surface in Folio (the correct location) while the business logic stays in the Notify module where it belongs.

## What to do if you find a controller

1. Delete the controller file.
2. Identify the route it served.
3. Create a Folio page for that route.
4. Move business logic to an Action in the appropriate module.
5. Document the change in this file.

## Related

- CLAUDE.md rule 1: "NEVER use traditional controllers or routes in web.php/api.php for front office"
- `laravel/CLAUDE.md` rule 2: Architecture frontend — NO Controller, NO Routes in web.php
- Folio routing docs: `Themes/Meetup/docs/folio-pages-json-only-rule.md`
