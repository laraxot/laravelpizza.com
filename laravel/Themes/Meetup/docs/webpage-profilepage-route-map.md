# Theme Meetup: WebPage/ProfilePage Route Map

## Scopo

Allineare il tema Meetup alla governance schema.org per i tipi pagina.

## Route e tipi

- `/` -> `WebPage`
- `/it/events` e varianti -> `CollectionPage`
- `/it/events/{slug}` -> `ItemPage` (entity principale Event gestita a parte)
- `/profile/edit` -> `ProfilePage`
- `auth/*` -> `WebPage`

## Nota operativa

`ProfilePage` richiede coerenza semantica: pagina centrata su identita' persona/profilo.
Se in futuro esiste una pagina profilo pubblico (`/profile/{slug}`), quella deve avere priorita' per `ProfilePage`.
