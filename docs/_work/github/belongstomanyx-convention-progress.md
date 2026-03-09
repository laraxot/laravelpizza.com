[Progress]

Aggiornamento completato sulla convenzione many-to-many del progetto.

Documentazione allineata:

- `docs/rules/laravel-relationships-critical.md`
- `docs/memory/belongstomanyx-relationship-memory.md`
- `docs/skills/belongstomanyx-relationship-skill.md`
- `docs/memory/fundamental-rules-updated.md`

Nota importante:

- ho corretto un file storico che raccomandava erroneamente `belongsToMany()`;
- la convenzione canonica resta `belongsToManyX()` per i modelli applicativi del progetto;
- questa decisione e' stata resa esplicita per evitare regressioni future e documentazione contraddittoria.
