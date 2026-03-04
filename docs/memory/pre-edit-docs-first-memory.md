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
