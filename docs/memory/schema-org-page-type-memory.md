# Schema.org Page Type Memory

## Decisione da ricordare

Quando si lavora su rich snippets o JSON-LD non basta mappare il modello di dominio.

Bisogna chiedersi anche:

- che tipo di pagina e' questa?
- qual e' la `mainEntity` pubblica?

## Esempio chiave

- profilo pubblico utente/speaker: `ProfilePage` + `Person`
- dettaglio evento: `ItemPage` o `WebPage` + `Event`
- lista eventi: `CollectionPage`

## Regola pratica

Se una pagina pubblica ha un ruolo riconoscibile in `schema.org`, non lasciarla come `WebPage` generica senza motivo.
