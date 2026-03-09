# BelongsToManyX Relationship Memory

Memoria operativa:

- in LaravelPizza la convenzione many-to-many e' `belongsToManyX()`;
- non devo reintrodurre `belongsToMany()` nei modelli applicativi per abitudine Laravel standard;
- se un modello del progetto usa pivot relation, la prima opzione da valutare e' sempre `belongsToManyX()`;
- eventuali eccezioni vanno documentate, non improvvisate.
