# LaravelPizza — Role-based User Guide (EN)

> **Verification status (16 November 2026):** This document reflects inspected source code on `dev`; the app has **not** been launched and screenshots have **not** been captured. Never present generated mockups as real application screenshots. Role permissions and browser actions must be verified with end-to-end tests.

## 1. Platform overview
LaravelPizza is a Laravel/PHP meetup and community platform. Public pages use the Meetup Folio/Volt theme; event management is built in the Meetup module using Filament resources.

## 2. Personas and workflows
| Persona | Main tasks | Code evidence / limitation |
|---|---|---|
| Visitor | View homepage, events and details | Public theme pages, event blocks |
| Member / attendee | Register, sign in, view profile, join events | Auth pages and `EventUser`; registration UI not yet E2E tested |
| Event organizer | Propose/manage events | Event `organizer_id`, status, proposal state; permission checks pending |
| Event operator | Create/edit events and manage registrants | Filament `EventResource`, `EventForm`, `RegistrationsRelationManager` |
| Speaker | Be associated with an event | `PerformerResource`; no dedicated speaker portal verified |
| Sponsor | Be associated with an event | `SponsorResource`; no dedicated sponsor portal verified |
| Administrator | Oversee events and linked records | Dashboard, events, venues, performers, sponsors; per-role authorization to test |

## 3. Visitor
1. Open the public site and choose a language.
2. Browse localized event listings (the README documents `/it/events` on localhost).
3. Open an event to view title, date, time, location, attendance mode, capacity and organizer where available.
4. Use the linked map where a venue is supplied.
5. Open the registration page to join the community.

**Screenshots to capture:** `screenshots/en/01-home.png`, `02-events-list.png`, `03-event-detail.png`, `04-register.png`.

## 4. Member and attendee
1. Register using the GDPR `RegisterWidget` form; complete verification steps if presented.
2. Sign in and inspect your profile.
3. Open a published upcoming event.
4. Follow the registration action **if available**; some events may instead expose an external registration URL.
5. An event at capacity or a duplicate registration must be rejected by domain rules.
6. Verify the My Events and cancellation controls against the running app before publishing instructions.

**Screenshots to capture:** `05-login.png`, `06-profile.png`, `07-event-registration.png`, `08-my-events.png`, `09-full-event.png`.

## 5. Organizer and event operator
*The account must have the corresponding Filament permissions.*

1. Open Events in Filament, then Create. An event import action also exists on the list.
2. Enter title, description, start and end time (end must be later), location and optionally a structured venue.
3. Choose draft, published or cancelled. Draft is the safe initial state.
4. Enter a positive maximum capacity. The attendee count is read-only and maintained by registration actions.
5. Upload a cover image; select or create speakers and sponsors from the event form.
6. Save and check the public event page.
7. Open Registrations to inspect names, emails, statuses and registration dates; export CSV or cancel an entry after confirmation.
8. Event deletion uses a confirmation dialog and `DeleteEventAction`, with attendee count information.

**Screenshots to capture:** `10-admin-events.png`, `11-create-event.png`, `12-event-people.png`, `13-event-registrations.png`, `14-export-csv.png`, `15-delete-confirmation.png`.

## 6. Venues, speakers and sponsors
Filament has list/create/edit resources for venues, speakers and sponsors. Manage them independently or create related records from the event form. No dedicated speaker or sponsor self-service interface has been verified.

**Screenshots:** `16-venues.png`, `17-performers.png`, `18-sponsors.png`.

## 7. Administration
Available code includes dashboards, an event statistics widget, calendar widgets, event import and management resources. Only document controls actually visible to each test account after verifying policies.

**Screenshots:** `19-dashboard.png`, `20-calendar.png`, `21-import-events.png`.

## 8. Acceptance tests
- Reject full and duplicate registrations.
- Insert a registration row and increment capacity count once, atomically.
- Distinguish an organizer's draft from a pending proposal.
- Published events are visible publicly; a user sees their own eligible drafts/proposals; super-admin sees all events through `scopeVisibleTo`.
- Cancellation and deletion maintain registrations and counts consistently.

## 9. Real screenshots and demo data policy
Existing Meetup factories cover Event, EventUser, Performer, Sponsor, Venue, Profile, Feedback and relations. The existing `MeetupDatabaseSeeder` creates upcoming/past events and related venues, speakers and sponsors. Its nearly-full/full event states set counts directly; actual matching registrations were **not established** in the inspected seeder.

Use an isolated demo database; never reset production. First verify migrations/dependencies and actual roles. Seed consistent registration rows/capacity counts, including draft, pending, upcoming, past, full and cancelled cases. Log in as separate test personas, capture genuine browser screenshots at desktop and mobile sizes, redact secrets and personal data, and record page URL, persona, locale, timestamp and commit SHA. Store original PNGs under `docs/manuale-utente/screenshots/{it,en}/`. **None have been captured in this version.**

## 10. Done criteria and source references
Finalize only once every flow is reproduced on a running build, all authentic PNGs are available, demo factories/seeders have passed tests, and PDFs are generated from the Markdown. Sources: `laravel/Modules/Meetup/database/`, `laravel/Modules/Meetup/app/Models/Event.php`, `laravel/Modules/Meetup/app/Filament/Resources/`, `laravel/Modules/Meetup/docs/attendee-registration-domain-rules.md`, and `laravel/Themes/Meetup/resources/views/`.
