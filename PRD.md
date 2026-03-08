# LaravelPizza — Product Requirements Document

> This PRD drives the Ralph Loop. Each story is atomic, testable, and maps to existing modules only.
> NEVER create new modules. All logic goes in: Meetup, User, Gdpr, Notify, Seo, Cms, Activity.

---

## Module Map

| Feature Area | Existing Module | Key Models |
|---|---|---|
| Events / Meetup lifecycle | Meetup | Event, EventUser, Feedback, Venue, Performer, Sponsor |
| User auth & profile | User | User, Profile |
| GDPR consents | Gdpr | Consent, Treatment |
| Notifications | Notify | — |
| Activity log | Activity | — |
| SEO / Social share | Seo | SocialShareData |

---

## Epic A — Event Lifecycle (Pizzata Proposal & Approval)

### US-A01 — User can propose a meetup
**As a** registered user,
**I want to** submit a meetup proposal with title, description, date, location and max attendees,
**so that** the community admin can review and approve it.

Acceptance criteria:
- POST action `ProposeMeetupAction::execute()` creates Event with `status=pending`
- Event belongs to the proposing user via `user_id`
- Event is NOT visible in the public listing (`scopeApproved()` excludes `status=pending`)
- Activity log records the proposal
- `passes: false`

### US-A02 — Pending event visible only to proposer
**As a** user who proposed a meetup,
**I want to** see my pending proposal with a "In attesa di approvazione" badge,
**so that** I know its status without it being publicly visible.

Acceptance criteria:
- `Event::scopeVisibleTo(User $user)` returns: approved events + pending events owned by user
- Other users querying events do NOT see the pending event
- Pest test: two users, only proposer sees their pending event
- `passes: false`

### US-A03 — Admin can approve or reject a meetup proposal
**As an** admin,
**I want to** approve or reject pending meetup proposals,
**so that** only quality events are shown publicly.

Acceptance criteria:
- `ApproveMeetupAction::execute(Event $event)` sets `status=approved`
- `RejectMeetupAction::execute(Event $event, string $reason)` sets `status=rejected`
- On approval: Notify module sends email to proposer
- On rejection: Notify module sends email with reason
- Activity log records admin decision
- `passes: false`

### US-A04 — Approved event visible to all
**As a** visitor,
**I want to** see all approved meetups on the events page,
**so that** I can find meetups to attend.

Acceptance criteria:
- `Event::scopeApproved()` returns only `status=approved` events
- Events page CMS block uses `scopeApproved()`
- Rejected/pending events never appear in public listing
- `passes: false`

---

## Epic B — Event RSVP (Iscrizione alla Pizzata)

### US-B01 — User can RSVP to an approved event
**As a** registered user,
**I want to** click "Vado!" to register for an event,
**so that** the organizer knows I'm coming.

Acceptance criteria:
- `RsvpEventAction::execute(User $user, Event $event)` attaches user to event via `event_user` pivot
- If event is full (`isFull()`), throws `EventFullException`
- `event.attendees_count` increments by 1 (counter cache)
- User cannot RSVP twice (unique constraint + check)
- `passes: false`

### US-B02 — User can cancel RSVP
**As a** registered user who has RSVP'd,
**I want to** cancel my registration,
**so that** I free up a spot for someone else.

Acceptance criteria:
- `CancelRsvpAction::execute(User $user, Event $event)` detaches user from pivot
- `event.attendees_count` decrements by 1
- Cannot cancel if not registered (throws `NotRegisteredException`)
- `passes: false`

### US-B03 — Attendee count visible on event page
**As a** visitor,
**I want to** see how many people are attending,
**so that** I can gauge the event's popularity.

Acceptance criteria:
- `Event::attendees_count` is always accurate
- Event detail block shows count: "X persone vogliono partecipare"
- Shows remaining spots if max_attendees is set: "ancora X posti disponibili"
- `passes: false`

### US-B04 — Event full indicator
**As a** user trying to RSVP to a full event,
**I want to** see a "Evento esaurito" message,
**so that** I know I can't register.

Acceptance criteria:
- `Event::isFull()` returns true when `attendees_count >= max_attendees`
- UI shows "Esaurito" badge on full events
- RSVP button is disabled when event is full
- `passes: false`

---

## Epic C — User Profile (Profilo Pubblico)

### US-C01 — User has a public profile page
**As a** community member,
**I want** a public profile page showing my name, bio, and events I've attended,
**so that** other members can learn about me.

Acceptance criteria:
- Profile model in Meetup module has: `display_name`, `bio`, `avatar`, `location`, `website`, `github_username`, `twitter_handle`
- Public URL: `/it/profile/{username}` (Folio route)
- Shows attended events (past), proposed events (approved)
- `passes: false`

### US-C02 — User can edit their profile
**As a** registered user,
**I want to** edit my display name, bio, avatar and social links,
**so that** my profile reflects who I am.

Acceptance criteria:
- `UpdateProfileAction::execute(User $user, ProfileData $data)` updates Meetup\Profile
- Avatar upload via Spatie Media Library (stored in `avatars` collection)
- Validation: display_name required, bio max 500 chars, URLs valid format
- `passes: false`

### US-C03 — User can change password
**As a** registered user,
**I want to** change my password,
**so that** I can keep my account secure.

Acceptance criteria:
- `ChangePasswordAction::execute(User $user, string $current, string $new)` verifies current password, sets new
- New password must be >= 8 chars, different from current
- If current password wrong, throws `InvalidPasswordException`
- Activity log records password change (no passwords logged)
- `passes: false`

---

## Epic D — GDPR Compliance

### US-D01 — User must accept required consents on registration
**As a** new user registering,
**I want to** be shown required GDPR consents (Terms of Service, Privacy Policy),
**so that** the platform is legally compliant.

Acceptance criteria:
- Registration form has required checkboxes: `terms_of_service`, `privacy_policy`
- Optional checkboxes: `marketing_emails`, `analytics_tracking`
- `AcceptGdprConsentsAction::execute(User $user, array $consents)` creates Consent records
- Registration fails if required consents not accepted
- `passes: false`

### US-D02 — User can update optional GDPR preferences
**As a** registered user,
**I want to** change my optional GDPR consent choices (marketing, analytics),
**so that** I control how my data is used.

Acceptance criteria:
- Profile settings page has GDPR preferences section
- `UpdateGdprPreferencesAction::execute(User $user, array $optional_consents)` updates optional Consent records
- Required consents cannot be revoked via UI
- Each change creates new Consent record with timestamp/IP
- `passes: false`

### US-D03 — GDPR audit trail is complete
**As an** admin reviewing compliance,
**I want** every consent action logged with IP and user agent,
**so that** we have proof of consent.

Acceptance criteria:
- Consent model stores: `accepted_at`, `ip_address`, `user_agent`, `user_id`, `treatment_id`
- All consent changes (accept/revoke) are immutably logged
- `passes: false`

---

## Epic E — Viral & Social Features

### US-E01 — User can share an event on social media
**As an** attendee,
**I want** one-click share buttons for Twitter/X, LinkedIn, WhatsApp,
**so that** I can invite my network.

Acceptance criteria:
- Event detail block has social share buttons (no external packages — pure PHP URL templates)
- URLs use `LaravelLocalization::localizeUrl()` + `urlencode()`
- Twitter: `https://twitter.com/intent/tweet?text={title}&url={url}`
- LinkedIn: `https://www.linkedin.com/sharing/share-offsite/?url={url}`
- WhatsApp: `https://wa.me/?text={title}+{url}`
- `passes: false`

### US-E02 — "X people are going" social proof
**As a** visitor viewing an event,
**I want to** see attendee count with avatar stack,
**so that** social proof encourages me to sign up.

Acceptance criteria:
- Event detail shows first 5 attendee avatars as stack
- Shows count: "Marco e altre 23 persone partecipano"
- `passes: false`

---

## Epic F — Pest Test Coverage

### US-F01 — Full Pest test suite for all actions
**As a** developer,
**I want** complete Pest tests for every Action in the Meetup module,
**so that** we have 100% behavior coverage.

Acceptance criteria:
- Tests in `Modules/Meetup/tests/Unit/Actions/`
- All tests use `DatabaseTransactions` (via XotBaseTestCase)
- NEVER use `RefreshDatabase`
- All tests pass: `php artisan test --filter=Meetup`
- `passes: false`

---

## Loop Rules (read every iteration)

1. ONE story per loop iteration
2. Check `passes: true/false` — skip completed stories
3. Run `php artisan test --filter=Meetup` before marking passes: true
4. Run `./vendor/bin/pint Modules/Meetup/ Modules/Gdpr/ Modules/User/` before commit
5. Commit with conventional format: `feat(meetup): ...`
6. NEVER create new Modules — use existing ones
7. All relations: `belongsToManyX()` NEVER `belongsToMany()`
8. All Filament: extend XotBase* NEVER Filament directly
9. Git goes FORWARD only — never reset/revert
