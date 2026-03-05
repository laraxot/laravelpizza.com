# Meetup Foundation Migrations Reconciliation Memory

- Context: Phase `01-foundation`, plan `01-04` requires deterministic migration baseline for Meetup.
- Problem pattern: duplicate historical migrations (`create_events_table`, `create_profiles_table`) and ad-hoc pivot creators can silently drift schema.
- Working strategy:
  - introduce/align authoritative `2025_01_01_000001..000008` files;
  - guard legacy migrations with idempotent checks;
  - preserve compatibility with existing model column usage while adding locked canonical fields.
- Critical REGS-03 data contract:
  - registration pivot table exists and links `event_id` + `user_id`;
  - event table contains capacity counters and timing columns needed by anti-overbooking logic.
