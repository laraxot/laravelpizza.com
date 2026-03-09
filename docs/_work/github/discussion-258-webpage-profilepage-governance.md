Progress update sulla governance Schema.org per le pagine.

Ho esteso la regola da entity-only a page + entity:
- `WebPage` come base per il layer pagina;
- `ProfilePage` per le pagine profilo;
- sottotipi come `CollectionPage` e `ItemPage` per listing e detail.

Punto critico fissato:
- non basta serializzare `Person` o `Event`;
- bisogna dichiarare anche il tipo della pagina che li ospita.

Questo evita due errori ricorrenti:
- usare sempre `WebPage` generico;
- usare solo schema entity e dimenticare la semantica della pagina.
