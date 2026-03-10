# Profile View Page Contract

## Pattern

La pagina pubblica `/it/profile/{id}` deve seguire lo stesso pattern di `events.view`:

- route Folio generica `pages/[container0]/[slug0]/index.blade.php`;
- slug CMS `profile.view`;
- JSON `profile_view.json`;
- block presenter puro del tema.

## Dati attesi dal block

Il block `pub_theme::components.blocks.profile.detail` deve poter lavorare con:

- `item` = `Modules\User\Models\User` oppure `Modules\User\Models\Profile` oppure `Modules\Meetup\Models\Profile`;
- `slug0` = identificatore route;
- eventuale `profile` opzionale derivato dall'utente.
- fallback opzionale a query diretta su `User` quando il payload non contiene ancora `item`.

## Comportamento richiesto

- se esiste solo `User`, la pagina deve comunque mostrare una `ProfilePage` leggibile;
- se esiste `Profile`, il block deve arricchire bio/avatar/campi community;
- niente query duplicate nel path standard quando i dati sono gia' nel payload;
- nessuna stringa hardcoded nel tema: tutte le label UI devono usare traduzioni.
- mantenere UI resiliente su dati mancanti (email, bio, avatar) con fallback testuali tradotti.
