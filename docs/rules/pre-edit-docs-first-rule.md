# Pre-Edit Docs-First Rule

## Regola vincolante

Prima di qualsiasi modifica al codice, la prima azione deve essere:

1. Ragionare sul problema e definire il perimetro del cambiamento.
2. Studiare la documentazione del modulo coinvolto in `laravel/Modules/*/docs`.
3. Studiare la documentazione del tema coinvolto in `laravel/Themes/*/docs`.
4. Aggiornare e migliorare prima le docs locali del modulo e del tema coinvolti.
5. Aggiornare la documentazione necessaria:
   - regole in `docs/rules`
   - memory operative in `docs/memory`
   - skill operative in `docs/skills`
6. Solo dopo passare alle modifiche di codice.
7. Registrare l'avanzamento su GitHub quando utile al coordinamento:
   - valutare aggiornamento/creazione Issue;
   - valutare aggiornamento/creazione Discussion.

## Scope

La regola si applica a:

- Moduli: `laravel/Modules/*`
- Temi: `laravel/Themes/*`
- Documentazione globale: `docs/*`

## Output minimo richiesto

Prima di editare codice devono esistere:

1. almeno un aggiornamento docs nel modulo/tema toccato (o motivazione esplicita di non necessita);
2. almeno un riferimento a regole/memory/skills globali se la modifica cambia il workflow operativo.
3. una valutazione esplicita se aggiornare Issue/Discussion per tracciamento multi-agente.

## Rafforzamento operativo (2026-03-09)

- La priorita' e sempre: studiare, aggiornare e migliorare prima le cartelle `docs` dentro i moduli e dentro i temi.
- Questa priorita' vale anche per bugfix urgenti: prima consolidare il contesto documentale, poi toccare il codice.
- Questa priorita' va ricordata sempre: se manca un passaggio docs locale su modulo e tema, il task non e' pronto per l'editing del codice.

## Naming vincolante per Markdown

- I file `.md` NON devono contenere date nel filename.
- Esempio vietato: `analysis-2026-03-06.md`.
- Esempio corretto: `analysis.md` oppure `analysis-testing-migrate.md`.
