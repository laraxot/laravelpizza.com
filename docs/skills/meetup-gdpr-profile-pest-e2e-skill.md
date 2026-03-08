# Meetup GDPR Profile Pest E2E Skill

## Trigger

Usare questa skill quando si lavora su journey utente completo meetup + gdpr + profilo.

## Steps

1. Mappare requisito su moduli esistenti `Meetup`, `Gdpr`, `User`.
2. Definire acceptance criteria con stati visibilita' (`pending`, `approved`).
3. Scrivere test Pest feature prima dell'implementazione.
4. Implementare minima logica necessaria.
5. Aggiornare issue/discussion con output test e gap residui.

## Test minimi obbligatori

- pending owner-only
- approved public
- RSVP count coherence
- GDPR required + optional preference update
- profile update + password change
