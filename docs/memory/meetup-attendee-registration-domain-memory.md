# Meetup attendee registration domain memory

## Date
2026-03-07

## Decision
Registration to meetup events is now treated as a guarded domain operation with three invariants:
- no over-capacity registrations,
- no duplicate user registration for the same event,
- attendees counter update is atomic with pivot insert.

## Why
This is the minimum reliable foundation for REGS-01 before wiring full public UI flow.

## References
- `laravel/Modules/Meetup/docs/attendee-registration-domain-rules.md`
- Issue #438
