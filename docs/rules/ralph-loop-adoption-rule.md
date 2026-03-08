# Ralph Loop Adoption Rule

## Scopo

Standardizzare l'uso di Ralph Loop come supporto operativo senza violare le regole del repository.

## Regole

1. Usare Ralph solo come acceleratore di pianificazione/esecuzione, non come sostituto delle regole di progetto.
2. Prima di `ralph build`: assicurare presenza di PRD JSON (`ralph prd ...`).
3. Eseguire loop con opzione sicura in contesti condivisi: `ralph build 1 --no-commit`.
4. Tutto il lavoro resta vincolato a:
   - moduli esistenti (no nuovi moduli non approvati);
   - Git forward-only;
   - aggiornamento continuo di GitHub Issues e Discussions.

## Nota tecnica

`ralph install --skills` puo' richiedere TTY interattivo; in ambienti non interattivi va gestito manualmente.
