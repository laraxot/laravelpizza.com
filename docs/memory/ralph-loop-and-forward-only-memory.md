# Ralph Loop + Forward-Only Memory

## Stato verificato

- CLI `ralph` disponibile nel sistema (`@iannuttall/ralph@0.1.3`).
- Template locali presenti in `.agents/ralph`.
- `ralph build` richiede PRD JSON; senza PRD non avvia il loop.

## Vincoli confermati

- Non creare nuovi moduli: usare solo moduli esistenti.
- Git solo in avanti: si studia lo storico ma non si ripristinano versioni vecchie come soluzione.

## Procedura standard

1. Definire PRD (`ralph prd ...`).
2. Eseguire loop incrementale (`ralph build 1 --no-commit`).
3. Integrare outcome nel codebase seguendo regole progetto.
4. Pubblicare avanzamento su issue/discussion.
