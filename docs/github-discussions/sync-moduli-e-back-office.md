---
date: 2026-11-18
pubblicata: no
---

Categoria: General · Titolo: **Dopo un sync dei moduli condivisi: cosa si è rotto e come accorgersene prima**

Il sync del 13/11 ha portato in `dev` 476 file con conflitti git non risolti e la CI è rimasta ferma per giorni senza che nessuno lo notasse. Riparazione e dettagli: issue #581.

Cosa abbiamo imparato:
- **Un database già migrato nasconde i problemi.** In locale tutto funzionava; su un database vuoto (come in CI) la migrazione `users` falliva perché una migrazione `add_*` più vecchia creava la tabella con una sola colonna.
- **Le pagine admin vanno aperte tutte.** Un crawl delle 223 pagine come super-admin ha trovato 34 problemi, molti errori 500. Ora c'è `npm run audit:bo`.
- **I nomi `@volt()` sono globali.** Il modulo User ora ha pagine Folio sue: un nome uguale a quello del tema faceva mostrare il frammento sbagliato (`/it/auth/password/confirm` in 500).
- **Un `.gitignore` troppo largo** (`scripts`) ha tenuto fuori da git lo script di postbuild del tema: in locale funzionava, in CI no.

Checklist dopo ogni sync: `docs/deploy/runbook.md` §11.

Domanda aperta per chi mantiene i moduli: come teniamo i moduli condivisi agnostici? Nel modulo User ci sono logica `restaurant::admin` e pagine di altri progetti (`area-personale`, `genesis`). Proposte?
