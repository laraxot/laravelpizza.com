[Context]

La pagina dettaglio evento `/it/events/{slug}` ora funziona, ma sul caso reale `/it/events/id-id-quidem-quae-eveniet-Jy1p` restano gap di prodotto e contenuto da chiudere.

[Problemi osservati]

- manca un blocco organizer/host anche se l'evento ha `organizer_id` e `user_id`;
- non viene mostrata chiaramente la modalita' evento (`event_attendance_mode`);
- la location e' mostrata come testo grezzo, senza migliore formattazione o CTA utile;
- la sidebar RSVP e' fuorviante quando non esiste un vero `registration_url`: il modal attuale non registra niente;
- metadata disponibili come `audience`, `typical_age_range`, `keywords`, `registration_opens_at` non vengono valorizzati quando presenti;
- manca una chiara distinzione UX tra evento upcoming e past oltre al badge base.

[Obiettivo]

Migliorare completezza, chiarezza e utilita' della pagina dettaglio evento mantenendo l'architettura corretta:

- route layer risolve il model;
- theme block presenta solo i dati;
- niente query DB nel Blade standard del dettaglio.

[Acceptance criteria]

- organizer/host mostrato se disponibile;
- attendance mode mostrato con etichetta leggibile;
- location resa piu' leggibile e con CTA utile coerente;
- CTA RSVP non deve fingere una registrazione se non esiste backend/URL reale;
- metadata opzionali mostrati solo quando presenti;
- test Pest aggiornato per coprire il rendering migliorato;
- aggiornamento docs tema/modulo e tracking progress su issue/discussion.
