# LaravelPizza — Domain Analysis

## Platform Purpose

LaravelPizza is a community platform for Laravel/PHP developers to organize and attend meetups ("pizzate"). It is NOT a pizza e-commerce or food delivery platform.

---

## Core Domain Objects

### Event (Pizzata)

The central entity. Represents a meetup proposed, organized, or attended by community members.

**Lifecycle states:**
```
DRAFT → PENDING → APPROVED (public) | REJECTED (proposer-only)
                ↘ CANCELLED
```

**Visibility rules:**
- `draft`: only proposer sees it
- `pending`: only proposer sees it, with "In attesa di approvazione" badge
- `approved`: visible to all users and visitors
- `rejected`: only proposer sees it, with "Proposta rifiutata" badge
- `cancelled`: visible with "Annullato" badge

**Existing model:** `Modules\Meetup\Models\Event`
**Key fields:** title, description, start_date, end_date, location, max_attendees, attendees_count, status, event_status, slug, user_id (proposer), organizer_id

---

### EventUser (RSVP / Iscrizione)

Pivot table linking users to events they want to attend.

**Existing model:** `Modules\Meetup\Models\EventUser`
**Table:** `event_user`
**Fields:** event_id, user_id, (timestamps)

**RSVP states (to add to pivot):**
- `going` — confermato
- `maybe` — forse
- `not_going` — non vado (used for cancellation tracking)

---

### Profile (Profilo Pubblico)

User's public-facing identity on the platform.

**Existing model:** `Modules\Meetup\Models\Profile`
**Fields to ensure:** display_name, bio, avatar, location, website, github_username, twitter_handle, user_id

**Different from** `Modules\User\Models\Profile` (auth/system profile) — Meetup Profile is the public community profile.

---

### Venue (Location)

Where events are held.

**Existing model:** `Modules\Meetup\Models\Venue`
**Fields:** name, address, city, country, latitude, longitude, capacity

---

### Performer (Speaker/Host)

People presenting at events.

**Existing model:** `Modules\Meetup\Models\Performer`
**Pivot:** `Modules\Meetup\Models\EventPerformer`

---

### Sponsor

Companies sponsoring events.

**Existing model:** `Modules\Meetup\Models\Sponsor`
**Pivot:** `Modules\Meetup\Models\EventSponsor`

---

### Feedback

Post-event ratings and comments.

**Existing model:** `Modules\Meetup\Models\Feedback`
**Fields:** user_id, event_id, rating (1-5), comment

---

## Domain Actions (to implement in Meetup module)

All go in `Modules/Meetup/app/Actions/Event/`:

| Action | Input | Output | Side Effects |
|--------|-------|--------|--------------|
| `ProposeMeetupAction` | `User, EventData` | `Event (pending)` | Activity log |
| `ApproveMeetupAction` | `Event` | `Event (approved)` | Notify proposer, Activity log |
| `RejectMeetupAction` | `Event, string $reason` | `Event (rejected)` | Notify proposer with reason, Activity log |
| `RsvpEventAction` | `User, Event` | `EventUser` | Increment counter, Activity log |
| `CancelRsvpAction` | `User, Event` | `void` | Decrement counter, Activity log |
| `UpdateProfileAction` | `User, ProfileData` | `Profile` | — |
| `ChangePasswordAction` | `User, string $current, string $new` | `void` | Activity log |

All go in `Modules/User/app/Actions/`:

| Action | Input | Output |
|--------|-------|--------|
| `ChangePasswordAction` | `User, string $current, string $new` | `void` |

All go in `Modules/Gdpr/app/Actions/`:

| Action | Input | Output |
|--------|-------|--------|
| `AcceptGdprConsentsAction` | `User, array $consents` | `Collection<Consent>` |
| `UpdateGdprPreferencesAction` | `User, array $optional` | `Collection<Consent>` |

---

## GDPR Consent Structure

### Required consents (cannot be refused to register)
- `terms_of_service` — Termini di servizio
- `privacy_policy` — Informativa sulla privacy

### Optional consents (can be changed any time)
- `marketing_emails` — Email marketing e newsletter
- `analytics_tracking` — Raccolta dati analitici anonimi
- `profile_visibility` — Profilo pubblico nella community

### Consent model fields
```
id (uuid), treatment_id, user_id, user_type, type,
accepted_at, ip_address, user_agent, created_at, updated_at
```

### Treatment types (pre-seeded)
Each treatment defines a specific data processing purpose with legal basis (Art. 6 GDPR).

---

## User Journey: New Member

```
1. Visit laravelpizza.com
2. Browse approved events (no login needed)
3. Click "Registrati" to create account
4. Registration form:
   a. Name, email, password
   b. Required GDPR checkboxes (terms + privacy)
   c. Optional GDPR checkboxes (marketing, analytics)
5. Email verification
6. Complete profile (display_name, bio, avatar, city)
7. RSVP to first event
8. Propose their own meetup (becomes "Pending")
```

---

## User Journey: Proposing a Pizzata

```
1. Login
2. Click "Proponi una Pizzata" CTA
3. Fill form: title, description, date, venue, max attendees
4. Submit → Event created with status=pending
5. See own event with "In attesa" badge in their dashboard
6. Admin receives notification
7. Admin approves/rejects
8. User receives email notification
9. If approved: event appears in public listing
```

---

## User Journey: Attending a Pizzata

```
1. Browse events page
2. Click event
3. Read details: date, venue, speaker, attendee count
4. Click "Vado!" (if logged in)
5. If not logged in: redirect to login/register
6. RSVP confirmed → event counter increments
7. Event appears in user's "Le mie pizzate" dashboard
8. Share button to invite friends
9. After event: invited to leave feedback (rating + comment)
```

---

## Visibility Rules (summary)

| Event Status | Visitor | Other Users | Proposer | Admin |
|---|---|---|---|---|
| draft | hidden | hidden | visible (no badge) | visible |
| pending | hidden | hidden | visible + badge "In attesa" | visible |
| approved | visible | visible | visible | visible |
| rejected | hidden | hidden | visible + badge "Rifiutata" | visible |
| cancelled | visible (badge "Annullato") | visible | visible | visible |

---

## Forum Features (use existing Cms module)

Forum announcements, subscriptions, templates are NOT separate modules.
They use the existing `Cms` module's content blocks + `Notify` module for subscriptions.

- Forum page = CMS-driven JSON page in `config/local/laravelpizza/database/content/pages/forum.json`
- Announcements = CMS content blocks
- Subscriptions = Notify module's subscription system
- Templates = CMS block templates

---

## Modules: definitive mapping

| Feature | Module | NEVER create |
|---|---|---|
| Event lifecycle | Meetup | EventModule, EventCategory, EventFeedback... |
| Event location | Meetup (Venue model) | EventLocation |
| Event speakers | Meetup (Performer model) | EventSpeaker |
| Event sponsors | Meetup (Sponsor model) | EventSponsor |
| Event RSVP | Meetup (EventUser pivot) | EventRegistration, EventAttendee |
| Event feedback | Meetup (Feedback model) | EventFeedback |
| Event tags | Meetup (use keywords field on Event) | EventTag |
| Event tickets | Meetup (use offers JSON field on Event) | EventTicket |
| Event schedule | Meetup (use start/end_date + agenda in meta_data) | EventSchedule |
| Event organizer | Meetup (organizer_id on Event + User) | EventOrganizer |
| User profile | User + Meetup (Profile) | — |
| GDPR | Gdpr | — |
| Forum | Cms + Notify | ForumAnnouncement, ForumSubscriber, ForumTemplate |
| Notifications | Notify | — |
| Analytics | Activity | EventAnalytics |
