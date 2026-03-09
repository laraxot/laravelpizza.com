# Theme Schema.org Readiness

Il tema `Meetup` deve assumere che i dati strutturati arrivino da contratti canonici del dominio `Meetup`, non da assemblaggi ad hoc dispersi nelle Blade.

## Regola

- il tema consuma JSON-LD o nodi schema.org prodotti da model / mapper canonici;
- evitare duplicazione della logica structured data direttamente nelle view;
- quando una pagina renderizza un `Event`, `Venue`, `Performer`, `Sponsor` o `Profile`, la view deve preferire il payload schema canonico del dominio.

## Implicazione pratica

Per essere davvero `rich snippets ready`, il tema deve poter comporre:
- `Event` come root entity;
- `Place`, `Person`, `Organization`, `Review`, `EventReservation` come nested entities o grafi collegati;
- breadcrumb, organization, website e altri graph node solo se coerenti con il contenuto della pagina.

## Anti-pattern

- costruire JSON-LD diverso per la stessa entity in view diverse;
- dichiarare rich snippets support senza un mapper condiviso nel dominio;
- trattare `schema.org` come semplice checklist di campi statici.
