---
title: "Architettura del front office del tema Meetup"
type: reference
status: active
theme: Meetup
qmd: "architettura tema meetup folio volt json x-page blocchi cms separazione tema flusso rendering sushi blockdata"
---

# Architettura del front office del tema Meetup

## Perche' esiste

Spiega come una richiesta diventa una pagina del sito pubblico, chi possiede ogni pezzo (tema, Cms, Tenant, Xot, moduli di
dominio) e quali scorciatoie sono vietate. Serve a non cercare nel tema la logica che vive altrove e a non reintrodurre
controller o Blade per pagina.

## Decisione di fondo

Le pagine pubbliche sono **dati** (JSON del CMS) resi da componenti **Blade** del tema; il routing e' di **Folio**; l'interattivita'
leggera e' **Volt**; i form con logica sono **widget Filament dei moduli**. Niente controller, niente rotte in `web.php` o
`api.php` per il front office, niente Blade per singola pagina di contenuto, niente resolver di tipo nel tema.

Perche' (esito di un confronto tra "pagine solo JSON" e "Blade dedicate per i casi speciali"; ha vinto il JSON):

- una sola pipeline di rendering invece di pagine che divergono (DRY);
- un solo posto dove cercare la definizione di una pagina (KISS);
- le pagine si cambiano da JSON, con review e senza deploy del tema;
- se serve un layout nuovo si scrive un **blocco riusabile**, non una pagina speciale.

Decisioni formali: [ADR pagine pubbliche da JSON via x-page](adr/public-pages-from-json-via-x-page.md) e
[ADR form di auth come widget dei moduli](adr/auth-forms-are-module-widgets.md). Test di guardia:
`Themes/Meetup/tests/Unit/PagesAndAuthFormsContractTest.php`.

## Chi possiede cosa

| Livello | Dove | Responsabilita' |
|---|---|---|
| Tema Meetup | `laravel/Themes/Meetup` | layout, blocchi Blade, CSS/JS, traduzioni `pub_theme::`, pagine Folio sottili |
| Cms | `Modules/Cms` | montaggio di Folio/Volt, modello `Page`, `BlockData`, componenti `<x-page>`, `<x-section>`, `<x-cms::head>`, middleware di pagina |
| Tenant | `Modules/Tenant` | nome tenant dall'host, lettura di `config/local/<tenant>/`, trait `SushiToJsons` |
| Xot | `Modules/Xot` | `XotData` (tema attivo, percorsi), classi base `XotBase*` |
| Meetup | `Modules/Meetup` | dominio eventi, widget e componenti Livewire dei blocchi, icone SVG |
| User / Gdpr | `Modules/User`, `Modules/Gdpr` | widget di login, registrazione, menu utente |

Il tema ha una sola classe PHP: `app/Providers/ThemeServiceProvider.php` (registra traduzioni e view sotto `pub_theme` e `meetup`
e la rotta `POST /events/{slug}/book`, vedi [events-pages](events-pages.md)).

## Flusso di una richiesta

```
GET /it/events
 -> Cms FolioVoltServiceProvider: una mount Folio per lingua sulla cartella pages/ del tema
 -> middleware: SetFolioLocale, 'web' + base del tenant, LaravelLocalization*
 -> pagina Folio del tema (es. [container0]/index.blade.php) + PageSlugMiddleware
 -> componente Volt della pagina
 -> <x-page side="content" :slug="...">  (Cms\View\Components\Page)
 -> Page::getBlocksBySlug(slug, side)    (Page = modello SushiToJsons sui file JSON)
 -> BlockData per ogni blocco            (verifica la view, risolve l'eventuale "query")
 -> @include del blocco Blade del tema   (pub_theme::components.blocks.<tipo>.<nome>)
 -> dentro x-layouts.app: header (x-section) + <main> + footer (x-section)
```

Punti che contano, verificati sul codice:

- **Montaggio Folio** (`Modules/Cms/app/Providers/FolioVoltServiceProvider.php`): parte dentro `app->booted()`, cosi' la
  catch-all `fallback` di Folio resta l'ultima rotta e non oscura le home dei pannelli Filament multi-tenant. Il path e' quello
  restituito da `XotData::make()->getPubThemeViewPath('pages')`. Per ogni lingua supportata monta `Folio::path(...)->uri($lang)`
  con `SetFolioLocale` e i middleware di localizzazione di mcamara; monta anche le `resources/views/pages` dei moduli abilitati
  e infine `Volt::mount()`. I nomi di rotta Folio vengono localizzati sulla lingua corrente (`route('container0.view')` da `/de`
  resta tedesco).
- **Lingua**: la imposta `SetFolioLocale` (prefisso URL, poi lingua salvata dell'utente, poi default). Le pagine Folio non devono
  mai chiamare `setLocale()`: Folio esegue il loro blocco PHP iniziale anche solo per leggere `name()` e `middleware()`, per
  esempio quando si genera `route('login')` in una e-mail da coda. Guardia:
  `Modules/Meetup/tests/Unit/Architecture/FolioPagesWithoutSideEffectsTest.php` ([localization](localization.md)).
- **Protezione**: `PageSlugMiddleware` legge il campo `middleware` del JSON della pagina, lo valida (allowlist) e lo esegue.
  Se non riesce a stabilire la protezione risponde 503 (fail-closed), mai la pagina pubblica. Gli alias di URL
  (es. `/it/login` -> `/it/auth/login`) stanno in `config/local/laravelpizza/seo.php`.
- **Dati**: `Page` e' un modello Sushi: legge i JSON di `config/local/laravelpizza/database/content/pages/` come tabella
  virtuale, quindi i contenuti si versionano in git, senza database ([cms-json-pages](cms-json-pages.md)). Piu' di un record con
  lo stesso slug e' un errore esplicito ("CMS content collision").
- **Lati della pagina**: `content`, `sidebar`, `footer` corrispondono ai campi JSON `content_blocks`, `sidebar_blocks`,
  `footer_blocks`, ciascuno per lingua (`{"it": [...], "en": [...]}`).
- **Blocco**: `BlockData` richiede `data.view`; se la view non esiste lancia `RuntimeException('view not found: ...')`.
  Se il blocco ha una chiave `query` (`model`, `scope`/`scopes`, `orderBy`, `direction`, `limit`, `wrap_in`) i dati vengono
  aggiunti da `ResolveBlockQueryAction`. Il componente `<x-page>` include la view con i dati del blocco **sia come variabili
  singole sia come array `$data`**: i blocchi leggono `$title` oppure `$data['title']`.

Esempio reale, `home.json` (per lingua): `hero` -> `pub_theme::components.blocks.hero.main`, `events` -> `blocks.events.list`,
`features` -> `blocks.features.grid`, `cta` -> `blocks.cta.banner`.

## Pagine Folio del tema

`resources/views/pages/`:

| File | Nome rotta | URL | Contenuto |
|---|---|---|---|
| `index.blade.php` | `home` | `/{lang}` | `<x-page>` slug `home`, lati content e sidebar |
| `[slug].blade.php` | `pages.view` | `/{lang}/{slug}` | CMS a un livello (about, contact, privacy, ...) |
| `[container0]/index.blade.php` | `container0` | `/{lang}/{container}` | `<x-page>` col JSON del contenitore; 404 se non esiste |
| `[container0]/[slug0]/index.blade.php` | `container0.view` | `/{lang}/{container}/{slug}` | evento, sotto-pagina CMS (`events.my`) o record risolto da `ResolvePageAction` |
| `auth/login`, `auth/register` | `login`, `register` | `/{lang}/auth/...` | widget di User e Gdpr ([auth-pages](auth-pages.md)) |
| `auth/logout`, `auth/verify` | `auth.logout`, `verification.notice` | idem | |
| `auth/password/{reset,[token],confirm}` | `password.request`, `password.reset`, `password.confirm` | idem | componenti Volt del tema |
| `profile/[id].blade.php` | `profile.view` | `/{lang}/profile/{id}` | profilo ([dashboard-and-profile](dashboard-and-profile.md)) |

Dettaglio evento (`container0 = events`): il record e' cercato con `Event::visibleTo($utente)` (pubblicati, o bozze del
proprietario); non trovato diventa una sotto-pagina CMS `events.<slug>` oppure 404. Per gli altri contenitori decide
`Modules\Cms\Actions\ResolvePageAction` (allowlist dei modelli, poi pagina CMS `container.slug`, poi `container.view`): vedi
`Modules/Cms/docs/adr/cms-owns-page-resolution.md`. Dettagli di routing in [folio-routing](folio-routing.md) e dei
componenti Volt in [volt-components](volt-components.md).

I nomi `@volt('...')` devono essere unici tra tema e moduli (Volt registra i frammenti per nome: un doppione mostra il frammento
sbagliato). Il tema usa il prefisso `meetup.` quando un modulo usa lo stesso nome. Guardia: `UniqueVoltFragmentNamesTest`.

## Layout e sezioni

- `x-layouts.main`: guscio HTML (`<html>`, `<body>`, skip link, `@livewireScripts`); il `<head>` e' `<x-cms::head>` del Cms
  (titolo, descrizione, canonical, hreflang, Open Graph, dati strutturati). Carica `resources/css/app.css` solo se serve Filament
  (utente loggato o `/{lang}/auth/*`), altrimenti il piu' leggero `site.css`. Mai scrivere un `<head>` a mano.
- `x-layouts.app`: `main` + `<x-section slug="header"/>` + `<main id="main-content">` + `<x-section slug="footer"/>`; per gli
  utenti loggati aggiunge l'assistente `x-ui.assistant`. E' l'entry point di ogni pagina pubblica.
- `x-layouts.guest`, `x-layouts.auth`, `x-layouts.navigation`: altre varianti, descritte in [layouts](layouts.md).
- `<x-section slug="header">` rende `pub_theme::components.sections.<slug>.<tpl>` (`tpl` di default `v1`): il contenuto viene da
  `config/local/laravelpizza/database/content/sections/{header,footer}.json`; le view sono in `components/sections/{header,footer}/v1.blade.php`
  ([header-footer-logo](header-footer-logo.md)).

## Struttura del tema

```
Themes/Meetup/
  app/Providers/ThemeServiceProvider.php   unica classe PHP
  Http/Controllers/EventBookingController  debito dichiarato (vedi sotto)
  resources/views/{pages,components,filament,errors,profile}
  resources/views/components/{blocks,layouts,sections,ui}
  resources/{css,js,mail-layouts,html}     html = prototipo statico di studio, non servito
  lang/{de,en,es,fr,hi,it,ru,zh}           traduzioni pub_theme::
  scripts/                                 screenshot, audit a11y e front/back office, clean-stale-assets
  tests/Unit/PagesAndAuthFormsContractTest.php
  public/                                  output di vite build (symlink da public_html/themes/Meetup)
  docs/                                    questa documentazione
```

## Namespace e risoluzione delle view

`pub_theme::` e `meetup::` puntano alle view del tema; `pub_theme::` e' il nome da usare nei JSON e nei moduli, perche' resta valido
se il tema attivo cambia. La catena tenant -> `pub_theme` e i dettagli di registrazione (`view.paths`, componenti anonimi con e senza
prefisso) sono in [tenant-theme-resolution](tenant-theme-resolution.md).

## Debiti e punti noti

- `POST /events/{slug}/book` -> `Http/Controllers/EventBookingController::book()`: non e' un'Action, senza middleware `web` (niente
  sessione ne' CSRF), aggiornamento del contatore non atomico, dipende da `Modules\Meetup\Models\Event`. Dettagli in
  [contracts/README.md](contracts/README.md).
- `pages/index.blade.php` impagina la home con una colonna contenuto 3/4 e una sidebar 1/4 (`x-page side="sidebar"`) anche se `home.json`
  non ha `sidebar_blocks`.
- Se le view sono in cache (`view:cache`), dopo aver cambiato un blocco Blade serve `php artisan view:clear`.

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| `view not found: pub_theme::components.blocks.x.y` | `data.view` del JSON punta a un blocco che non c'e' | creare il file in `components/blocks/x/y.blade.php` o correggere il JSON |
| 404 su `/it/qualcosa` | nessun JSON con quello slug (o sotto-pagina nella cartella sbagliata) | aggiungere `pages/qualcosa.json`; sotto-pagine in `pages/<contenitore>/<nome>.json` |
| 503 su una pagina | middleware di pagina non validabile (fail-closed) | controllare il campo `middleware` del JSON e il log |
| `/de/...` risponde in italiano | codice di pagina che cambia lingua o middleware di locale mancante | togliere `setLocale()` dalla pagina; la lingua e' di `SetFolioLocale` |
| Un blocco mostra il frammento di un altro modulo | nome `@volt` duplicato | rinominare con prefisso `meetup.` |

## Vedi anche

- [tenant-theme-resolution](tenant-theme-resolution.md) - come si sceglie il tema
- [cms-json-pages](cms-json-pages.md) e [blocks-and-components](blocks-and-components.md) - pagine JSON e blocchi
- [theme-rules](theme-rules.md) - regole da rispettare quando si tocca il tema
- [filament-and-widgets](filament-and-widgets.md) - quando usare un widget invece di Volt
