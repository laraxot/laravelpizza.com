# Event Detail UX gaps - id-id-quidem-quae-eveniet-Jy1p

## URL

`/it/events/id-id-quidem-quae-eveniet-Jy1p`

## Stato verificato

- HTTP: `200 OK`
- Rendering pagina: corretto
- Problema: coerenza UX e microcopy nel dettaglio evento

## Gap confermati

1. Mancano organizer o host anche se il model espone `organizer()` e `owner()`.
2. `event_attendance_mode` non e' mostrato in una forma leggibile per l'utente.
3. La location e' testo grezzo e non aiuta l'utente a capire dove andare o cosa aspettarsi.
4. La CTA RSVP non deve promettere una registrazione se non esiste `registration_url` o backend di iscrizione reale.
5. I metadata opzionali (`audience`, `typical_age_range`, `keywords`, `registration_opens_at`) non vengono valorizzati quando presenti.
6. Il blocco partecipanti deve avere un empty state esplicito e copy coerente.
7. I testi di social share devono restare localizzati.

## Direzione fix (DRY + KISS)

- Tenere `ResolvePageAction` come single source per la risoluzione del model.
- Tenere `events/detail.blade.php` come presenter puro, senza query DB nel path standard.
- Mostrare organizer o host solo se disponibili.
- Rendere esplicita la modalita' di partecipazione.
- Migliorare la location con formattazione, badge e link mappa solo se coerente con il dato.
- Rendere la CTA onesta:
  - `registration_url` reale se disponibile;
  - stato informativo se l'evento e' aperto ma non ha URL di registrazione;
  - CTA diverse per guest autenticazione solo se esiste davvero un flusso di registrazione utilizzabile.
- Coprire la pagina con Pest sul caso di rendering migliorato.
