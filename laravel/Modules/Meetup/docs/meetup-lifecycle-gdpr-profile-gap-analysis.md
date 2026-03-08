# Meetup Lifecycle + GDPR + Profile Gap Analysis

## Obiettivo

Coprire end-to-end il flusso utente:

1. proposta pizzata/meetup;
2. approvazione staff;
3. visibilita' pubblica solo se approvata;
4. visibilita' privata al proponente con badge `pending`;
5. registrazione RSVP con contatore partecipanti;
6. gestione GDPR in registrazione e aggiornamento preferenze;
7. gestione profilo utente e password.

## Stato attuale (codebase)

### Meetup

- Esiste `Event` con `status` (`draft`/`published`) e `attendees_count`/`max_attendees`.
- Esistono azioni RSVP:
  - `RegisterAttendeeToEventAction`
  - `UnregisterAttendeeFromEventAction`
- Nel dettaglio evento theme c'e' registrazione/disiscrizione e contatore.

### GDPR

- Esiste `RegisterWidget` GDPR con validazione consensi e persistenza (`SaveGdprConsentsAction`).
- Esistono azioni di validazione/raccolta consensi e test di base.

### User/Profile/Password

- Esistono componenti/auth flow e reset password.
- Esiste base per profilo utente e test relativi nel modulo `User`.

## Gap critici da chiudere

1. **Proposta meetup + approvazione**
- Manca un workflow esplicito con stati di revisione (`pending`, `approved`, `rejected`) separato dalla semplice pubblicazione.

2. **Visibilita' pending owner-only**
- Manca uno scope/policy che mostri eventi pending solo al proponente, con badge dedicato.

3. **Commenti meetup**
- Manca dominio commenti completo (create/list/moderation) nel modulo esistente `Meetup`.

4. **GDPR preferenze post-registrazione**
- Manca flusso utente esplicito per aggiornare consensi facoltativi (es. marketing) dopo la registrazione.

5. **Test Pest E2E cross-modulo**
- Mancano test end-to-end che legano insieme Meetup + GDPR + User su journey completo.

## Piano test Pest (modulo per modulo)

### Meetup

- Feature: proposta evento crea stato `pending`.
- Feature: evento pending visibile solo al proponente.
- Feature: evento approvato visibile pubblicamente.
- Feature: badge pending visibile a owner e non ad altri.
- Feature: RSVP incrementa/decrementa `attendees_count` in modo consistente.

### Gdpr

- Feature: registrazione richiede consensi obbligatori.
- Feature: update preferenze facoltative persistente e auditabile.

### User

- Feature: update profilo.
- Feature: cambio password con regole policy.
- Feature: journey integrato user+gdpr+meetup.

## Regole operative

- Niente nuovi moduli: usare `Meetup`, `Gdpr`, `User`.
- Git forward-only.
- Ogni avanzamento tracciato in GitHub Issues + Discussions.
