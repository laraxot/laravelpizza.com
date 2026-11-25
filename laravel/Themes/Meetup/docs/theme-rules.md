---
title: "Regole del tema Meetup"
type: rule
status: active
theme: Meetup
qmd: "regole critiche tema meetup folio governance blade strict_types xotbase head x-cms::head vite namespace pub_theme checklist guardie test"
---

# Regole del tema Meetup

## Perche' esiste

Raccoglie in un posto le regole che valgono per ogni modifica a `laravel/Themes/Meetup`, ciascuna con il suo motivo, e i test
che le fanno rispettare. Quando una regola e' in conflitto con un vecchio documento, vale questa pagina (verificata sul codice).

## Regole architetturali

1. **Front office = Folio + Volt + JSON del CMS.** Mai controller, mai rotte in `web.php`/`api.php`, mai una Blade per pagina di
   contenuto (`pages/<slug>.blade.php`), mai un resolver di tipo nel tema. Una pagina nuova e' un JSON in
   `config/local/laravelpizza/database/content/pages/<slug>.json` (sotto-pagine in `pages/<contenitore>/<nome>.json`); un layout
   nuovo e' un blocco in `components/blocks/`. Perche' e come: [architecture](architecture.md),
   [ADR](adr/public-pages-from-json-via-x-page.md). Guardia: `Themes/Meetup/tests/Unit/PagesAndAuthFormsContractTest.php`.
2. **Il tema pubblico si ricava dal tenant**, non si assume "sempre Meetup": [tenant-theme-resolution](tenant-theme-resolution.md).
3. **Mai estendere classi `Filament\*`: sempre il mirror `Modules\Xot\Filament\...\XotBase*`** (`Resource` -> `XotBaseResource`,
   `Page` -> `XotBasePage`, `Widget` -> `XotBaseWidget`, `ListRecords` -> `XotBaseListRecords`, colonne e campi allo stesso modo).
   Se il mirror manca si crea in Xot, non come scorciatoia nel tema. Il tema non contiene risorse Filament:
   vivono nei moduli (`Modules/Xot/docs/xotbase-extension-rules.md`).
4. **Form con logica = widget Filament dei moduli**, non Volt e non Livewire scritto nel tema:
   [filament-and-widgets](filament-and-widgets.md), [ADR](adr/auth-forms-are-module-widgets.md).
5. **Il tema non ha logica di business.** Niente query complesse, scritture o validazione nelle Blade: Action nei moduli
   (Spatie Queueable Action, metodo `execute()`), DTO con Spatie Data. L'unico effetto collaterale del tema e' un debito
   dichiarato in [contracts/README.md](contracts/README.md).
6. **Una tabella, una migrazione, un modulo.** Il tema non ha migrazioni. Nelle migrazioni dei moduli (`XotBaseMigration`):
   `tableCreate()` chiamato direttamente, senza `if (! tableExists())` intorno; le modifiche in `tableUpdate()`, con guardie
   `hasColumn()`, mai una seconda `create_*_table` per la stessa tabella.
7. **Relazioni many-to-many con `belongsToManyX()`**, mai `belongsToMany()` (regola dei modelli, vale per chi tocca il dominio).

## Regole di Folio e Volt

- La gerarchia di file e cartelle e' la route: `index.blade.php` per la radice di una sezione, nomi dinamici
  (`[slug]`, `[container0]`, `[slug0]`, `[id]`) per i segmenti. Non ricostruire il routing a mano nella pagina.
- Middleware comuni a piu' pagine: nel mount Folio del provider (Cms) o in `PageSlugMiddleware` via campo `middleware` del JSON,
  non replicati nel Blade. `render()` e' per composizione di view/response, non per orchestrare il routing.
- **Nessun effetto collaterale nel blocco PHP iniziale di una pagina.** Folio lo esegue anche solo per leggere `name()` e
  `middleware()` (es. `route('login')` in una e-mail da coda). Mai `setLocale()`: la lingua e' di `SetFolioLocale`.
  Guardia: `FolioPagesWithoutSideEffectsTest`.
- Ruolo di ciascun livello: pagina Folio = routing, metadati, minimo collegamento; Volt = stato e metodi di una interazione
  leggera; Blade con `@include`/componente = sola presentazione, senza assunzioni Livewire.
- **Nomi `@volt('...')` unici** tra tema e moduli (prefisso `meetup.` se serve). Guardia: `UniqueVoltFragmentNamesTest`.
- I test devono chiamare URL reali del tema (con prefisso lingua), non solo renderizzare componenti isolati.

## Regole di Blade

- **Layout**: ogni pagina pubblica usa `<x-layouts.app>`; `x-layouts.main` e' il guscio HTML e non si usa direttamente; `guest`/`auth`
  per le pagine di accesso ([layouts](layouts.md)).
- **`<head>`**: mai scritto a mano. Lo produce `<x-cms::head>` nel layout `main` (titolo, descrizione, canonical, hreflang, Open
  Graph, JSON-LD base). Le pagine aggiungono tag con `@push('head')` (es. JSON-LD `Event` nel dettaglio evento). Il vecchio
  componente `<x-metatags>` non e' piu' usato dal tema.
- **Vite**: `@vite([...], 'themes/<tema>')` vuole il secondo argomento (il layout usa `MetatagData::make()->getPubTheme()`); il CSS lo
  sceglie `x-cms::head` (`app.css` con Filament per utenti loggati e `/auth/*`, `site.css` per gli altri).
- **Componenti anonimi**: `<x-layouts.app>` oppure `<x-pub_theme::ui.logo>` (percorso relativo a `components/`, senza `components.`);
  dettagli in [tenant-theme-resolution](tenant-theme-resolution.md).
- **Props dei blocchi**: il blocco riceve i dati sia come variabili singole sia come `$data`. Scrivere
  `$title = $title ?? ($data['title'] ?? default)`; `@props(['data'])` da solo e `{{ $data['title'] }}` senza controllo rompono quando
  la chiave manca ([blocks-and-components](blocks-and-components.md)).
- **`declare(strict_types=1);`**: nelle pagine Folio/Volt e' la prima istruzione del blocco `<?php` iniziale (lo fanno tutte quelle del
  tema). In un blocco `@php ... @endphp` o dopo qualunque output e' un errore fatale ("strict_types declaration must be the very
  first statement"): li' va tolto, e la logica che lo richiede va in una classe PHP (Action o helper) nel modulo.
- **Commenti Blade**: `{{-- --}}` viene rimosso prima dei direttivi, quindi un `@if` dentro un commento e' innocuo; fanno
  eccezione `@php` e `@verbatim`, che Blade estrae prima dei commenti: non aprirne dentro un commento senza chiuderli.
- **JSON-LD**: dati dinamici con `json_encode(..., JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)` dentro `@push('head')`
  (come `blocks/events/detail`); JSON statico con `@context` dentro `@verbatim`.
- **SVG**: mai SVG scritto dentro una Blade. File `.svg` in `Modules/Meetup/resources/svg/` e
  `<x-filament::icon icon="meetup-<nome>" class="..."/>` (`logo.svg` -> `meetup-logo`). Oggi 26 file Blade del tema contengono ancora
  `<svg` inline (es. `blocks/hero/main`): la regola vale per ogni file che si tocca, che va convertito nella stessa modifica.
- **Testi**: ogni testo visibile passa da `{{ __('pub_theme::contesto.collezione.chiave.tipo') }}` con le stesse chiavi in tutte
  le lingue; mai `meetup::`, mai la frase come chiave ([localization](localization.md),
  [story](stories/blade-i18n-no-hardcoded-text.story.md)).
- **URL**: link e `action` dei form con `LaravelLocalization::localizeUrl('/percorso')` (un POST non localizzato diventa GET dopo il
  redirect); lingua corrente con `LaravelLocalization::getCurrentLocale()`; selettore lingua con `getLocalizedURL($code, null, [], true)`.
  Mai `url(app()->getLocale().'/...')`.
- **Pagine di auth**: login, registrazione e menu utente sono widget (`LoginWidget`, `RegisterWidget`, `UserDropdown`);
  mai form scritti nel tema.

## Regole di build e stile

- Comandi `npm` sempre dalla cartella del tema (ha il suo `package.json`): `cd laravel/Themes/Meetup && npm install && npm run build`.
- **Niente `npm run copy` e niente copie in `public_html`**: `public_html/themes/Meetup` e' un symlink a `Themes/Meetup/public`; lo script
  `copy` e' un no-op. Dopo `npm run build` il sito vede gia' la build ([assets-and-build](assets-and-build.md)).
- Lo script `build` e' `vite build` (nessun `tsc &&`, il tema non ha TypeScript da compilare). `postbuild` ripulisce gli asset vecchi.
- Tailwind v4: `@import 'tailwindcss';` (non `@tailwind base`); `tailwind.config.js` resta per `darkMode: 'class'` e i colori di
  marca. Il CSS di Filament e' importato in `app.css` dopo Tailwind; le personalizzazioni `.fi-*` vanno dopo, per vincere.
- Font Inter da `@fontsource-variable/inter` (niente Google Fonts: nessuna richiesta a terzi prima del consenso); il plugin
  Google Fonts di Filament non e' la regola per il sito pubblico.
- Dopo modifiche a Blade o config: `php artisan optimize:clear` (o almeno `view:clear`); dopo modifiche a CSS/JS: `npm run build`.

## Stack Filament nel tema

Il tema dichiara in `composer.json` solo i pacchetti modulari `filament/{actions,forms,infolists,notifications,schemas,support,tables,widgets}`
(`^5`); il pannello completo (`filament/filament ^5`) e' dell'applicazione. Il front office puo' usare un singolo componente Filament
dove c'e' gia', ma il pannello e le risorse restano nei moduli. Dettagli: [filament-and-widgets](filament-and-widgets.md).

## Tipo di pagina schema.org

Layout e componenti SEO distinguono il tipo della **pagina** da quello dell'**entita'**: `/` `WebPage`; `/events` `CollectionPage`;
`/events/{slug}` `ItemPage` con entita' `Event`; `/profile/{id}` `ProfilePage` con entita' `Person`. Un solo JSON-LD generico per ogni
pagina e' un anti-pattern ([seo-structured-data](seo-structured-data.md)).

## Documentazione e codice

- Tutta la documentazione del tema sta in `Themes/Meetup/docs/`, con nomi minuscoli-con-trattini (eccezioni: `README.md`, `changelog.md`),
  senza date nel nome. Pagina per argomento, non per episodio ([ai-agents-and-docs-workflow](ai-agents-and-docs-workflow.md)).
- Ogni classe o metodo PHP creato o modificato ha nel docblock `@see Themes/Meetup/docs/<file>.md` (modulo: `Modules/<Modulo>/docs/...`),
  e quel file esiste e si aggiorna nella stessa modifica.
- Ogni file PHP ha `declare(strict_types=1);`; provider minimi che estendono `XotBaseServiceProvider` quando sono di modulo.
- Prima di un commit: PHPStan livello 10, Pint, test della suite del tema (`vendor/bin/pest Themes/Meetup/tests`) e guardie del modulo
  Meetup ([quality-and-dependencies](quality-and-dependencies.md), [testing](testing.md)).

## Guardie automatiche

| Test | Cosa impedisce |
|---|---|
| `Themes/Meetup/tests/Unit/PagesAndAuthFormsContractTest.php` | pagine generiche senza `<x-page` o con `content-resolver`; login/registrazione che non usano i widget |
| `Modules/Meetup/tests/Unit/Architecture/FolioPagesWithoutSideEffectsTest.php` | `setLocale()` nelle pagine Folio |
| `.../UniqueVoltFragmentNamesTest.php` | nomi `@volt` duplicati tra tema e moduli |
| `.../ThemePublicSymlinkTest.php`, `.../ModuleAssetsSymlinkTest.php` | symlink di tema e moduli sostituiti da cartelle copiate |
| `.../ThemeIntegrityTest.php` | script npm senza file, manifest Vite non coerente con `public/`, regressioni silenziose dopo un sync |
| `.../NoMergeConflictMarkersTest.php` | marcatori di conflitto git nei file tracciati |
| `.../ProfileContractPhpdocTest.php` | phpdoc dei modelli condivisi con `Profile` al posto di `ProfileContract` per creator/updater/deleter |

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| "strict_types declaration must be the very first statement" | `declare` dentro `@php` o dopo output | toglierlo dal Blade, spostare la logica in una classe |
| `ParseError ... expecting "endif"` | `@php` aperto e non chiuso (anche dentro un commento) o `@if`/`@foreach` non bilanciati | chiudere il blocco o il direttivo |
| Variabile `$data` mancante in un blocco | `@props(['data'])` senza default | `@props(['data' => []])` e normalizzare come sopra |
| Stili non aggiornati nel browser | CSS/JS non ricompilati | `cd laravel/Themes/Meetup && npm run build`; hard refresh |
| Link che perdono la lingua | URL costruito a mano | `LaravelLocalization::localizeUrl()` |
| E-mail in una lingua sbagliata | `setLocale()` in una pagina Folio | rimuoverlo |

## Vedi anche

- [architecture](architecture.md) - flusso e responsabilita'
- [tenant-theme-resolution](tenant-theme-resolution.md) - tenant e namespace
- [filament-and-widgets](filament-and-widgets.md) - widget, Filament 5 nel tema
- [quality-and-dependencies](quality-and-dependencies.md) - PHPStan, Pint, dipendenze
