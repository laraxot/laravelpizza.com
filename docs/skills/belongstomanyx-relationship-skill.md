# Skill Operativa: belongsToManyX

## Quando usarla

Usare questa skill quando il task tocca:

- relazioni many-to-many nei moduli LaravelPizza;
- pivot model;
- relazione `Event`/`Performer`/`Sponsor`/`User` nel modulo `Meetup`;
- doc o test che mostrano `belongsToMany()`.

## Workflow

1. Cercare la relazione esistente nel modulo coinvolto.
2. Verificare se il progetto usa gia' `belongsToManyX()` nel ramo principale del dominio.
3. Trattare `belongsToManyX()` come fonte canonica.
4. Correggere prima le docs locali del modulo/tema se mostrano esempi sbagliati.
5. Solo dopo valutare eventuali modifiche al codice.
6. Se si tocca PHP, eseguire il quality gate completo (`phpstan`, `phpmd`, `phpinsights`, `pest`).

## Anti-pattern

- introdurre nuove relazioni `belongsToMany()` in moduli Laraxot;
- copiare esempi Eloquent generici senza adattarli a `RelationX`;
- cambiare il codice per inseguire docs vecchie e sbagliate;
- trattare `belongsToManyX()` come refuso.

## Output atteso

- doc locale del modulo/tema riallineata;
- regola/memory/skill globale aggiornata se il gap e' di governance;
- eventuale test o fix del modello allineato alla convenzione `belongsToManyX()`.
