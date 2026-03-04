# Pre-Edit Docs-First Rule

## Regola vincolante

Prima di qualsiasi modifica al codice, la prima azione deve essere:

1. Ragionare sul problema e definire il perimetro del cambiamento.
2. Studiare la documentazione del modulo/tema coinvolto.
3. Aggiornare la documentazione necessaria:
   - regole in `docs/rules`
   - memory operative in `docs/memory`
   - skill operative in `docs/skills`
4. Solo dopo passare alle modifiche di codice.

## Scope

La regola si applica a:

- Moduli: `laravel/Modules/*`
- Temi: `laravel/Themes/*`
- Documentazione globale: `docs/*`

## Output minimo richiesto

Prima di editare codice devono esistere:

1. almeno un aggiornamento docs nel modulo/tema toccato (o motivazione esplicita di non necessita);
2. almeno un riferimento a regole/memory/skills globali se la modifica cambia il workflow operativo.
