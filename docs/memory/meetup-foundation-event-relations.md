# Meetup Foundation Event Relations

Data: 2026-03-05
Contesto: esecuzione piano `.planning/phases/01-foundation/01-01-PLAN.md`.

Memoria operativa:

- I modelli core del modulo Meetup sono `Event`, `Venue`, `Performer`, `Sponsor`.
- Le relazioni many-to-many di `Event` verso performer/sponsor/utenti usano `belongsToManyX()`.
- `belongsToMany()` non e' la forma canonica del progetto per queste relazioni: se compare in docs o snippet va trattato come drift documentale da correggere.
- I pivot devono restare allineati a FK esplicite:
  - `event_performer(event_id, performer_id)`
  - `event_sponsor(event_id, sponsor_id)`
  - `event_user(event_id, user_id)`
- Per readiness REGS-03 i dati di registrazione passano da `event_user` e dai contatori in `events` (`attendees_count`, `max_attendees`).
