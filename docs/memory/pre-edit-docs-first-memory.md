# Pre-Edit Docs-First Memory

Snapshot 2026-03-04:

- Regola operativa consolidata: il primo passo e sempre docs-first.
- Nessuna modifica codice parte senza:
  1) ragionamento sul perimetro,
  2) studio docs modulo/tema,
  3) aggiornamento docs/rules/memory/skills rilevanti.

Promemoria rapido:

- Moduli: `laravel/Modules/*/docs`
- Temi: `laravel/Themes/*/docs`
- Globale: `docs/rules`, `docs/memory`, `docs/skills`

Aggiornamento operativo (2026-03-04):

- Per la stabilizzazione della pipeline test/coverage, i test legacy non recuperabili nel ciclo corrente vengono rinominati con suffisso `.old` invece di lasciare skip permanenti nella suite attiva.

Aggiornamento operativo (2026-03-09):

- Se un metodo sparisce da `XotData` o da altri data object condivisi, prima si studia lo storico con `git show`, poi si ripristina solo la compatibilita' minima necessaria nel file corrente.
- Il divieto di "ripristinare file vecchi" non vieta lo studio del contratto storico; vieta il restore wholesale. La correzione corretta e' forward-only, mirata e documentata.
- Per bug frontend dei temi, aggiornare anche le docs locali di modulo e tema coinvolti (`laravel/Modules/*/docs`, `laravel/Themes/*/docs`) oltre alle docs globali.

Aggiornamento operativo (2026-03-09, governance rafforzata):

- Regola utente confermata: prima di modificare qualunque file, studiare/aggiornare/migliorare le cartelle docs del modulo e del tema impattati.
- Dopo l'aggiornamento docs, valutare sempre se registrare progresso su GitHub Issues e GitHub Discussions.
- Questo ordine non e' opzionale: docs locali modulo/tema prima, docs globali subito dopo, codice solo alla fine.
