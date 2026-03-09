# WebPage/ProfilePage Rollout

## Obiettivo

Standardizzare lo schema pagina (`schema.org`) a livello globale, non solo a livello entity.

## Regole

- Ogni pagina pubblica deve avere JSON-LD di tipo pagina.
- `WebPage` e' baseline.
- Usare un sottotipo specifico quando il contesto lo consente.
- `ProfilePage` va usato solo per pagine che rappresentano un profilo persona, non per form tecnici.

## Mappa iniziale route -> type

- homepage (`/`, `home`) -> `WebPage`
- lista eventi (`/events`, `container0.index` con `events`) -> `CollectionPage`
- dettaglio evento (`/events/{slug}`, `container0.view` con `events`) -> `ItemPage`
- about -> `AboutPage`
- contact -> `ContactPage`
- profile edit/show -> `ProfilePage` (con `mainEntity` Person quando utente disponibile)
- auth/login/register/reset/verify -> `WebPage`

## Implementazione

- punto unico: componente `Metatags` in Cms;
- l'entity schema resta nei blocchi/pagine specifiche (es. `Event`);
- page schema non deve duplicare tutti i dettagli entity.

## Verifica

- test Pest su mapping type pagina;
- validazione presenza JSON-LD nei contesti principali.
