# Attendee Registration Domain Rules

## Goal
Define deterministic business rules for registering a user to a meetup event.

## Core rules

1. Capacity guard:
   - registration is denied when `attendees_count >= max_attendees`.
2. Duplicate guard:
   - same user cannot register twice for the same event.
3. Counter consistency:
   - successful registration increments `attendees_count` by exactly 1.
4. Atomicity:
   - pivot insert (`event_user`) and counter increment must run in one DB transaction.

## Data model touchpoints

- `events` table (`attendees_count`, `max_attendees`)
- `event_user` pivot (`event_id`, `user_id`)

## Failure semantics

- Full event: throw domain exception.
- Duplicate registration: throw domain exception.

## Testing notes

- Pest tests must cover:
  - happy path,
  - full capacity,
  - duplicate registration.

## Related

- Track A issue: #438
- Blocker infra: #437
