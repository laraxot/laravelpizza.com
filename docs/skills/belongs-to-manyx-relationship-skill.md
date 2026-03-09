# belongs-to-manyx-relationship-skill.md

## Scopo

Applicare la convenzione relazionale di progetto per le many-to-many.

## Procedura

1. Cercare occorrenze `belongsToMany(` nel modulo toccato.
2. Valutare se sono relazioni applicative da convertire.
3. Usare `belongsToManyX(...)` con tipi di ritorno corretti.
4. Aggiornare test Pest del modello e della relazione pivot.
5. Aggiornare issue/discussion con stato e decisione tecnica.

## Comando di controllo

```bash
rg -n "belongsToMany\\(" laravel/Modules/<Modulo>
```

## Definition of Done

- nessuna nuova relazione applicativa usa `belongsToMany(...)`
- documentazione del modulo coerente con la convenzione
- issue/discussion aggiornate
