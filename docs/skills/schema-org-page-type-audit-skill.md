# Skill Operativa: Schema.org Page Type Audit

## Quando usarla

Usare questa skill quando il task riguarda:

- JSON-LD di pagine pubbliche;
- profili pubblici;
- pagine evento, liste eventi, privacy, terms, contact;
- mappatura tra route e page type `schema.org`.

## Workflow

1. Identificare la route pubblica e il suo scopo.
2. Scegliere il page type piu' specifico disponibile in `schema.org`.
3. Identificare la `mainEntity` della pagina, se esiste.
4. Verificare che il contenuto visibile supporti davvero il tipo scelto.
5. Documentare la coppia `page type` + `entity type`.
6. Se si modifica PHP per il rendering, eseguire il quality gate completo.

## Anti-pattern

- marcare tutto come `WebPage` generica;
- emettere `ProfilePage` per route private di editing;
- emettere `Person` o `Event` senza il nodo pagina quando la route e' chiaramente una pagina autonoma.
