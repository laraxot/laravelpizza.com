# Theme Page Type Governance

Nel tema `Meetup`, ogni route pubblica dovrebbe poter dichiarare un page type `schema.org` coerente.

## Regola pratica

- layout e componenti SEO devono distinguere il type pagina dal type entity;
- una pagina profilo non va marcata solo come `WebPage`: deve essere `ProfilePage`;
- una pagina dettaglio evento non va trattata solo come `Event`: la pagina e' `ItemPage`, l'entity principale e' `Event`.

## Mappa minima

- `/` -> `WebPage`
- `/events` -> `CollectionPage`
- `/events/{slug}` -> `ItemPage` + entity `Event`
- `/profile/{slug}` o pagina profilo equivalente -> `ProfilePage` + entity `Person`

## Anti-pattern

- un solo JSON-LD generico per tutte le pagine;
- usare `ProfilePage` quando non esiste davvero una pagina profilo pubblica;
- usare solo entity JSON-LD e dimenticare la semantica della pagina.
