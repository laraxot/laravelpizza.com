---
title: "Dashboard, area personale e profili"
type: reference
status: active
theme: Meetup
qmd: "dashboard area personale profilo profile view edit assistants public profile user vs profile meetupdashboard filament post login profilepage user id uuid"
---

# Dashboard, area personale e profili

Dove vive cosa per un utente autenticato e per i profili pubblici: nessun controller, nessuna Blade per pagina, solo JSON del CMS, un'unica pagina Folio dedicata e blocchi "presenter" del tema.

## Front office e back office

- Front office (tema): pagine Folio + JSON. "Area personale" dopo il login = `xra.post_login_path` = `/events/my` (`config/local/laravelpizza/xra.php`), cioe' la pagina "I miei eventi" ([events-pages](events-pages.md)).
- Back office (Filament, `/admin`): la dashboard di gestione e' `Modules\Meetup\Filament\Pages\MeetupDashboard` con i widget del modulo (`MeetupStatsOverviewWidget`, `RecentEventsWidget`, `EventCalendarWidget`, ...), tutti derivati da `XotBaseWidget`. Non ha nulla nel tema: il tema non deve ricostruire una dashboard pubblica. Una pagina `/it/dashboard` inesistente risponde 404 (non una pagina vuota). Audit del back office: `npm run audit:bo` ([testing](testing.md)).
- Le pagine Folio del modulo User (`area-personale/*`, ...) non vengono servite: il tema e' montato per primo e `[container0]/[slug0]` le intercetta; un contenitore senza modello e senza pagina CMS da' 404.

## Profilo: pagine e JSON

| URL | Pagina | JSON / blocco |
|---|---|---|
| `/{locale}/profile/{id}` | `pages/profile/[id].blade.php` (Folio+Volt, `name('profile.view')`, `PageSlugMiddleware`) | `pages/profile/view.json` -> `pub_theme::components.blocks.profile.detail` |
| `/{locale}/profile/edit` | stessa pagina `[id]` | sotto-pagina CMS `profile.edit` (`pages/profile/edit.json`, `middleware: auth`) -> `blocks.profile.edit` |
| `/{locale}/profile/assistants` | stessa pagina `[id]` | `profile.assistants` (`middleware: auth`) -> `blocks.profile.assistants` |

Logica di `[id].blade.php` (convenzione sottopagine: `Modules/Cms/docs/cms-subpages-folders.md`): 1) se esiste una pagina CMS `profile.<id>` si rende quella (con il middleware del JSON); 2) altrimenti `{id}` e' `User::id` (UUID reale, **non** `profiles.uuid`, colonna non garantita) caricato con `profile` in eager loading; utente inesistente o eliminato dal titolare (`deleted_at`, dati anonimizzati) = 404; 3) il `<title>` e' il nome della persona (`request()->attributes->set(ResolvePageMetaAction::TITLE, ...)`). La rotta dedicata e' piu' semplice che piegare `container0/slug0` a un profilo, che non e' una collezione come `events`.

## Contratto del blocco `profile.detail`

- Riceve `item` (`Modules\User\Models\User`, `Modules\User\Models\Profile` o `Modules\Meetup\Models\Profile`) e `slug0`; se manca `item` ripiega su una query diretta su `User`.
- Solo `User`: la pagina resta leggibile; con `Profile` arricchisce bio, avatar e campi community. Nessuna query duplicata quando i dati sono gia' nel payload. Presenter puro (Blade semplice, niente stato Livewire: [events-pages](events-pages.md)).
- Le proprieta' del `ProfileContract` si leggono con accesso sicuro a stringhe opzionali (PHPStan non vede proprieta' non documentate); guardia `Modules/Meetup/tests/Unit/Architecture/ProfileContractPhpdocTest.php`.
- Tutte le stringhe da chiavi `pub_theme::profile.*` (badge `public_profile`, sezioni `profile_details`, azioni `browse_events`/`contact`, messaggi `anonymous_user`/`short_bio_fallback`, campi `member_since`/`email`/`locale`/`location`), con fallback tradotti per dati mancanti: lo stato "chiavi visibili in pagina" e' la regressione tipica ([localization-standard](localization-standard.md)).
- Privacy (audit del front office): email e indirizzo visibili solo al titolare, mai nel JSON-LD; Gravatar disattivato (`xra.gravatar = false`), iniziali in locale ([gdpr-compliance](gdpr-compliance.md)).
- Schema.org: la pagina e' una `ProfilePage` con `mainEntity` = `Person` dell'utente pubblico risolto dalla rotta (non dell'utente autenticato); mappa dei tipi pagina in [seo-structured-data](seo-structured-data.md).

## User e Profile: perche' sono separati

`User` porta l'identita' leggera (`id`, `email`, lingua di sistema `lang`) ed e' quello caricato per header e permessi; `Profile` porta i dati descrittivi (nome, bio, avatar, social) e si carica solo quando serve (relazione `profile`, lazy; eager loading solo per liste di utenti con avatar: `User::with('profile')`). La lingua salvata su `User` fa si' che il sito si adatti al login da qualunque dispositivo. In `config/local/laravelpizza/xra.php` il modulo principale e' `Meetup`, quindi il profilo di produzione e' `Modules\Meetup\Models\Profile` (database dati), diverso dalla tabella `profiles` del modulo User: i test usano la stessa configurazione ([testing](testing.md)). Nel menu utente (desktop e mobile) e nel profilo l'avatar di riserva sono le iniziali generate in locale, non un'immagine Gravatar.

## Vedi anche

- [events-pages](events-pages.md) — "I miei eventi"
- [authentication-ui-ux](authentication-ui-ux.md) — login e logout
- [cms-json-pages](cms-json-pages.md) — come i JSON diventano pagine
