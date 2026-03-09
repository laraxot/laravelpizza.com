Sto aprendo questa discussione prima dell'implementazione per allineare la direzione del miglioramento della pagina dettaglio evento `/it/events/{slug}`.

Stato attuale sul caso reale `id-id-quidem-quae-eveniet-Jy1p`:

- la pagina ora risolve correttamente il model;
- pero' il dettaglio e' ancora incompleto dal punto di vista UX e contenutistico.

Gap principali:

1. organizer/host non mostrato nonostante il dato sia disponibile;
2. `event_attendance_mode` non esposto in modo leggibile;
3. location grezza e poco utile;
4. CTA RSVP con modal locale che non porta a una vera registrazione;
5. metadata facoltativi non valorizzati quando presenti.

Direzione proposta:

- mantenere `ResolvePageAction` come single source per la risoluzione del model;
- migliorare solo il presenter tema `events/detail.blade.php`;
- sostituire la CTA finta con comportamento onesto: usare `registration_url` se presente, altrimenti stato informativo/disabled CTA;
- aggiungere un blocco summary con organizer, attendance mode, audience/age/keywords quando disponibili;
- tenere il layout KISS e DRY, senza nuova logica di dominio nel Blade.

Procedo con questa direzione e aggiorno qui con i progressi verificati.
