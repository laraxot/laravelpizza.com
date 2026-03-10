# Public Profile Route

## Scope

- la pagina pubblica profilo del tema Meetup vive su `/{$locale}/profile/{id}`;
- `{id}` e' lo `User::id` UUID reale, non `profiles.uuid`;
- la route Folio dedicata e' `profile.view`, separata dal resolver generico `container0/slug0`.

## Why

- il database reale espone `users.id` UUID come identificatore stabile pubblico;
- la tabella `profiles` in questo install non garantisce una colonna `uuid`, quindi forzare lookup `Profile::byUuid()` rompe la pagina;
- una route dedicata resta piu' KISS del piegare `container0/slug0` a un profilo che non e' una collezione tipo `events`.

## Rendering contract

- la view carica `User` con `profile` eager-loaded;
- il tema usa i dati del `Profile` solo come arricchimento opzionale;
- tutte le stringhe UI passano da chiavi `pub_theme::profile.*`.

## Schema.org

- `profile.view` deve produrre `ProfilePage`;
- `mainEntity` deve essere una `Person` costruita dall'utente pubblico risolto dalla route, non dall'utente autenticato corrente.
