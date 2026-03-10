# Public Profile Route

## Scope

- la pagina pubblica profilo del tema Meetup vive su `/{$locale}/profile/{id}`;
- `{id}` e' lo `User::id` UUID reale, non `profiles.uuid`;
- la route Folio dedicata e' `profile.view`, separata dal resolver generico `container0/slug0`;
- il catch-all `container0.view` resta compatibile solo come fallback semantico per lo schema builder, non come route primaria del profilo pubblico.

## Why

- il database reale espone `users.id` UUID come identificatore stabile pubblico;
- la tabella `profiles` in questo install non garantisce una colonna `uuid`, quindi forzare lookup `Profile::byUuid()` rompe la pagina;
- una route dedicata resta piu' KISS del piegare `container0/slug0` a un profilo che non e' una collezione tipo `events`.

## Rendering contract

- la view carica `User` con `profile` eager-loaded;
- il tema usa i dati del `Profile` solo come arricchimento opzionale;
- tutte le stringhe UI passano da chiavi `pub_theme::profile.*`.
- se il `ProfileContract` non espone proprieta' documentate a livello statico, il codice deve leggere solo stringhe opzionali tramite access sicuro, evitando property access diretto che rompe PHPStan.

## Translation checklist

Per evitare regressioni "chiavi visibili in pagina" su `/it/profile/{id}`:

- `pub_theme::profile.badges.public_profile.label`
- `pub_theme::profile.sections.profile_details.label`
- `pub_theme::profile.actions.browse_events.label`
- `pub_theme::profile.actions.contact.label`
- `pub_theme::profile.messages.anonymous_user.label`
- `pub_theme::profile.messages.short_bio_fallback.label`
- `pub_theme::profile.fields.member_since.label`
- `pub_theme::profile.fields.email.label`
- `pub_theme::profile.fields.locale.label`
- `pub_theme::profile.fields.location.label`

## Schema.org

- `profile.view` deve produrre `ProfilePage`;
- `mainEntity` deve essere una `Person` costruita dall'utente pubblico risolto dalla route, non dall'utente autenticato corrente.
