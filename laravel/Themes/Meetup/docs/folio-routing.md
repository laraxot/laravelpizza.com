---
title: "Routing Folio del tema Meetup"
type: reference
status: active
theme: Meetup
qmd: "folio routing container0 slug0 pipeline precedenza route name pagine json x-page agnostico model binding"
---

# Routing Folio del tema Meetup

## Perche' esiste

Il front office non ha controller ne' `routes/web.php`: ogni URL pubblico e' un file in
`Themes/Meetup/resources/views/pages/` (Folio) che passa il contesto di rotta a `<x-page>`, il quale rende il JSON del
CMS ([cms-json-pages](cms-json-pages.md)). Qui stanno la mappa dei file, le regole di precedenza di Folio (la fonte piu'
frequente di "rende la pagina sbagliata"), la convenzione dei nomi di rotta e cosa NON mettere in una pagina Folio.
La decisione di fondo e' in `adr/public-pages-from-json-via-x-page.md`.

## Come le pagine vengono montate

`Modules/Cms/app/Providers/FolioVoltServiceProvider.php` (non il tema) registra i path, dopo l'avvio dell'applicazione:

- per ogni lingua di `laravellocalization.supportedLocales` (oggi `it en de fr es ru`) monta
  `Folio::path(<pages del tema>)->uri($locale)`: le pagine vivono sotto `/{locale}/...`, `/it` e' la home. Lo stesso
  vale per `Modules/<Modulo>/resources/views/pages` dei moduli abilitati;
- middleware di ogni pagina: `SetFolioLocale` (imposta la lingua), poi `web` + `config/local/<tenant>/middleware.php`
  (`base`, oggi vuoto) + i middleware mcamara di redirect/sessione della lingua;
- `Volt::mount()` sui path delle pagine e su `components/blocks` (i blocchi restano pero' Blade semplici, vedi
  [volt-components](volt-components.md));
- la registrazione e' rimandata a `app->booted()`: la catch-all di Folio e' una rotta `fallback` e deve restare
  l'ultima, altrimenti oscura le home dei pannelli Filament multi-tenant;
- le rotte Folio hanno lo stesso nome in ogni lingua e `FolioRoutes` tiene l'ultima registrata: un resolver dedicato
  (`localizeFolioNamedRoutes`) sposta il prefisso sulla lingua corrente, cosi' `route('container0.view', [...])` da `/de`
  produce `/de/...` e non `/it/...`;
- `RedirectUnlocalizedPath` (middleware globale) porta `/events` a `/it/events`, ma solo se la richiesta finirebbe nella
  catch-all di Folio: pannelli, Livewire e API non vengono toccati.

I link verso pagine localizzate si costruiscono con `LaravelLocalization::localizeUrl('/percorso')`, mai con `url()`.
Dettaglio in [localization](localization.md).

## Mappa dei file

| File in `pages/` | URL (`/{locale}` omesso) | `name()` | Middleware | Rende |
|---|---|---|---|---|
| `index.blade.php` | `/` | `home` | `PageSlugMiddleware` | `x-page` slug `home`, lati `content` e `sidebar` |
| `[slug].blade.php` | `/{slug}` | `pages.view` | `PageSlugMiddleware` | `x-page` slug = `$slug` |
| `[container0]/index.blade.php` | `/{container0}` | `container0` | `PageSlugMiddleware` | `x-page` slug = `$container0`; 404 se la pagina CMS non esiste |
| `[container0]/[slug0]/index.blade.php` | `/{container0}/{slug0}` | `container0.view` | `PageSlugMiddleware` | evento/modello risolto oppure sotto-pagina CMS |
| `profile/[id].blade.php` | `/profile/{id}` | `profile.view` | `PageSlugMiddleware` | sotto-pagina `profile.<id>` o profilo pubblico |
| `auth/login`, `auth/register` | `/auth/login`, `/auth/register` | `login`, `register` | `guest` | widget dei moduli |
| `auth/logout` | `/auth/logout` | `auth.logout` | - | logout via `wire:init` |
| `auth/verify` | `/auth/verify` | `verification.notice` | `auth`, `throttle:6,1` | Volt |
| `auth/password/reset`, `[token]`, `confirm` | `/auth/password/...` | `password.request`, `password.reset`, `password.confirm` | `guest`/`auth` | Volt |

Le pagine di accesso sono in [auth-pages](auth-pages.md). Gli alias "a orecchio" (`/it/login` verso `/it/auth/login`,
`/it/chi-siamo` verso `about`, `events-my` verso `events/my`) non sono file Folio: stanno in
`config/local/laravelpizza/seo.php` (`path_aliases`).

## Precedenza: l'ordine fisso della pipeline Folio

Per ogni segmento di URL, `vendor/laravel/folio/src/Router.php` (Folio 1.4.0) fa passare lo stato in una pipeline con
ordine fisso; il primo step che trova un match vince:

1. `MatchRootIndex`: `index.blade.php` della radice
2. `MatchDirectoryIndexViews`: cartella letterale con `index.blade.php`
3. `MatchWildcardViewsThatCaptureMultipleSegments`: `[...param].blade.php`
4. `MatchLiteralDirectories`: cartella letterale (`profile/`, `auth/`), continua al segmento successivo
5. `MatchWildcardDirectories`: cartella parametrica (`[container0]/`); sull'ultimo segmento vince se contiene `index.blade.php`
6. `MatchLiteralViews`: file letterale (`about.blade.php`)
7. `MatchWildcardViews`: file parametrico (`[slug].blade.php`)

Conseguenze verificate sul codice di Folio e sulla struttura attuale di `pages/`:

- Una cartella parametrica con `index.blade.php` (step 5) batte sempre un file parametrico (step 7). Per un URL a un solo
  segmento (`/it/about`) il match e' quindi `[container0]/index.blade.php` con `container0 = 'about'`, non
  `[slug].blade.php`: e' il motivo per cui quella pagina fa `abort_if(... === null, 404)` da sola. `[slug].blade.php`
  resta il fallback se la cartella sparisce. Non e' stato rieseguito `folio:list` per questa sintesi: dopo ogni modifica
  alla struttura controllare con `php artisan folio:list`.
- Una cartella letterale (step 4) batte una parametrica (step 5): `/it/profile/edit` va a `profile/[id].blade.php`
  (con `id = 'edit'`) e `/it/auth/login` a `auth/login.blade.php`, mai a `[container0]/[slug0]`.
- In una stessa directory Folio considera UNA sola cartella parametrica e UN solo file parametrico (il primo trovato,
  `findWildcardDirectory`/`findViewWith`). Il nome del parametro e' quello tra parentesi quadre, quindi
  `[container0]/[slug0]/index.blade.php` e' valido con nomi diversi. Una seconda cartella `[container1]/` accanto a
  `[slug0]/` non sarebbe mai raggiunta in modo prevedibile: non crearla (e non lasciare file di prova del genere, che
  rubano le rotte alla pagina vera).
- Per dare priorita' a una pagina specifica si usa una cartella o un file letterale, non un'altra posizione del
  catch-all e non l'ordine di registrazione dei path.
- Dopo aver aggiunto o tolto pagine: `php artisan view:clear` (e controllare `folio:list`).

## Il pattern `[container0]/[slug0]`

Un solo file gestisce ogni contenuto annidato (`/events/{slug}`, `/profile/...`, contenitori futuri) senza una cartella
per tipo: aggiungere un contenitore non richiede nuove Blade. La pagina e' un router: non contiene query al modello, non
decide il blocco da rendere. Lo stato attuale del file reale:

- `mount(ResolvePageAction $resolvePageAction, string $container0, string $slug0)` calcola `pageSlug` (di norma
  `{container0}.view`), un eventuale `item` e popola `$data`;
- `events` e' l'unico contenitore trattato in pagina, perche' la visibilita' e' per utente: `Event::query()->visibleTo($user)
  ->where('slug', $slug0)`; se non c'e' un evento, prova la sotto-pagina CMS `events.<slug0>` (`/events/my`,
  `/events/past`) e altrimenti 404. Un evento inesistente o non visibile risponde 404;
- per ogni altro contenitore chiama `Modules\Cms\Actions\ResolvePageAction`: ordine blog/events pubblicati (se il modulo
  Blog c'e'), poi allowlist `cms.config.container0_models` (vuota di default: nessun modello arbitrario dall'URL), poi pagina
  CMS `container.slug`, poi `container.view`. Ne' modello ne' pagina CMS significa 404 (es. `/it/genesis/about`);
- il render e' sempre `<x-page side="content" :slug="$this->pageSlug" :data="$this->data" />`, con
  `data = [container0, slug0, item, event]`. Il blocco `events.detail` legge `event`/`item` dalle variabili.

Il contesto di rotta viaggia solo dentro `:data` (mai `:container0=`/`:slug0=` come props): il componente `Page` resta
agnostico e nuovi segmenti (`container1`, `slug1`) non ne cambiano il costruttore. Il test
`Modules/Cms/tests/Unit/Views/PageComponentDataMergeTest.php` fissa il comportamento (il `data` della pagina vince sui
default del blocco).

### Cosa non va nella pagina Folio

- Niente `<x-blocks.content-resolver>` e niente componenti che decidono il tipo di contenuto: il tema non deve
  conoscere i tipi (guardia: `Themes/Meetup/tests/Unit/PagesAndAuthFormsContractTest.php` fallisce se una delle quattro
  pagine generiche perde `<x-page` o rimette `content-resolver`; il file `content-resolver` non esiste piu').
- Niente `request()->route('container0')`: i parametri arrivano al componente (vedi [volt-components](volt-components.md)).
- Niente `setLocale()` nel blocco PHP iniziale: Folio lo esegue anche solo per leggere `name()`/`middleware()` (per
  esempio `route('login')` in una mail dalla coda) e cambierebbe la lingua dell'intero processo. La lingua la imposta
  `SetFolioLocale`. Guardia: `Modules/Meetup/tests/Unit/Architecture/FolioPagesWithoutSideEffectsTest.php`.
- Nomi `@volt('...')` unici fra tema e moduli (Volt registra i frammenti per nome; il tema usa il prefisso `meetup.`
  dove un modulo ha gia' lo stesso nome). Guardia: `UniqueVoltFragmentNamesTest.php` nella stessa cartella.
- Niente controller o rotte in `web.php` per pagine pubbliche. Unica eccezione registrata:
  `POST /events/{slug}/book` (`ThemeServiceProvider`, name `events.book`).

## Convenzione dei nomi di rotta

Nome semantico e generico, non legato ai parametri: `{ambito}.{azione}` con azioni `view` (dettaglio), `index`
(lista), `create`, `edit`. Esempi reali: `pages.view`, `container0` (lista di un contenitore), `container0.view`,
`profile.view`, `home`; le pagine di accesso usano i nomi standard di Laravel (`login`, `register`,
`password.reset`, `verification.notice`). Mai `container0.slug0` o altri nomi che ripetono il parametro. Il nome della
rotta e' anche uno dei candidati con cui `PageSlugMiddleware` cerca la pagina CMS (vedi [cms-json-pages](cms-json-pages.md)).
Il logout ha nome `auth.logout` perche' `logout` appartiene alla rotta POST di `Modules/User`: due rotte con lo stesso nome
rendono `route('logout')` dipendente dall'ordine di registrazione.

## Model binding Folio

Folio sa legare un modello dal nome del file: `[User].blade.php`, `[Event:slug].blade.php`, oppure con namespace di
modulo `[.Modules.Meetup.Models.Event].blade.php` (i punti diventano backslash; la colonna e' `getRouteKeyName()`).
Il tema NON lo usa: l'evento e' risolto in `[container0]/[slug0]` per poter applicare `visibleTo()` e il 404. Usare il
binding Folio solo quando serve davvero e la visibilita' e' semplice.

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| `/it/events/<slug>` rende un'altra pagina | cartella parametrica concorrente (es. `[container0]/[container1]/index.blade.php`) o cartella letterale `events/` sparita/ricreata | tenere una sola cartella parametrica per directory; `folio:list`; `view:clear` |
| `Undefined variable $pageSlug` in `container0.view` | stato Volt usato fuori dal frammento `@volt`, oppure stato derivato duplicato (`pageSlug`, `data`, `mount`) | usare le proprieta' dentro `@volt('container0.view')`; il file attuale le tiene tutte e le usa come `$this->pageSlug` |
| 404 su una sotto-pagina CMS (`/events/my`) | JSON piatto con trattino (`events-my.json`) o `slug` completo dentro la sottocartella | `pages/events/my.json` con `"slug": "my"`: vedi [cms-json-pages](cms-json-pages.md) |
| Link sempre in italiano | `route()` Folio con prefisso dell'ultima lingua registrata | gia' risolto da `localizeFolioNamedRoutes`; non costruire URL a mano |
| 500 dopo un sync dei moduli su `auth/password/...` | stesso nome `@volt` in tema e modulo | prefisso `meetup.` e `UniqueVoltFragmentNamesTest` |

## Da verificare

- Il comportamento a runtime di `[slug].blade.php` rispetto a `[container0]/index.blade.php` per URL a un segmento e'
  dedotto dal codice di Folio, non da `folio:list` rieseguito.

## Vedi anche

- [cms-json-pages](cms-json-pages.md): come lo slug diventa un JSON e quando risponde 404
- [volt-components](volt-components.md): come i parametri arrivano al componente Volt della pagina
- [blocks-and-components](blocks-and-components.md): come `x-page` rende i blocchi
- [localization](localization.md): prefisso lingua e `localizeUrl`
- [architecture](architecture.md): quadro generale del tema
