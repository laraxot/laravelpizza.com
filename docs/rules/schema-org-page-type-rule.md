# Schema.org Page Type Rule

## Regola

Ogni pagina pubblica del progetto deve dichiarare un tipo pagina `schema.org` coerente con la sua funzione, non solo il tipo dell'entita' mostrata.

## Distinzione obbligatoria

- entita': `Event`, `Person`, `Organization`, `Place`, `Review`
- pagina: `WebPage`, `ProfilePage`, `ItemPage`, `CollectionPage`, `ContactPage`, altri sottotipi pertinenti

## Contratto

- il backend/modello fornisce l'entita' pubblica;
- il tema fornisce il nodo pagina;
- il nodo pagina collega l'entita' con `mainEntity` o `mainEntityOfPage`.

## Esempi

- pagina evento: `ItemPage` + `Event`
- pagina profilo pubblico: `ProfilePage` + `Person`
- pagina lista eventi: `CollectionPage` + elenco `Event`
- pagina privacy/terms: `WebPage`

Se esiste un sottotipo piu' preciso di `WebPage`, va preferito.
