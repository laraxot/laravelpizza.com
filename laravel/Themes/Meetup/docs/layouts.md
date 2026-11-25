---
title: "Layout del tema Meetup"
type: reference
status: active
theme: Meetup
qmd: "layout x-layouts.app x-layouts.main layout hierarchy sezioni header footer container griglia responsive folio layout"
---

# Layout del tema Meetup

## Perche' esiste

Le pagine pubbliche del sito non scelgono da sole struttura, `<head>`, header e footer: li prendono da due componenti Blade del tema. Questa pagina dice quali sono, cosa fanno davvero, quale usare e come si diagnosticano gli errori di rendering piu' comuni. Le regole di colore e stile sono in [design-system.md](design-system.md).

## Gerarchia dei layout

Tutti i layout sono componenti anonimi in `Themes/Meetup/resources/views/components/layouts/` e si usano come `<x-layouts.*>`.

| Layout | Cosa produce | Chi lo usa |
|---|---|---|
| `x-layouts.main` | Documento HTML nudo: `<html>`, `<head>` del CMS, skip link, `{{ $slot }}`, script Livewire | Solo `x-layouts.app` e `pages/auth/logout.blade.php` (pagina senza header/footer) |
| `x-layouts.app` | `main` + header + messaggio flash + `<main id="main-content">` + footer + assistente AI | Tutte le pagine Folio del tema (12 file, incluse login e registrazione) |
| `guest`, `auth`, `navigation` | Residui del kit Breeze e del tema Sixteen | Nessuna pagina del tema (vedi "Da verificare") |

**Regola**: ogni pagina Folio apre con `<x-layouts.app>` (opzionale `:title`, `:description`). Non esistono `layouts.public` ne' `layouts/app/sidebar`: furono ipotizzati e scartati. Anche l'idea di un `app` che "sceglie" tra layout in base all'utente fu provata e abbandonata, perche' aggiungeva logica nel layout senza un secondo layout reale da servire. `x-layouts.main` direttamente solo se la pagina non deve avere ne' header ne' footer.

```blade
<x-layouts.app :title="__('pub_theme::auth.login.page_title')">
    ...
</x-layouts.app>
```

## x-layouts.main

File: `components/layouts/main.blade.php`. Props: `title`, `description` (opzionali; senza, li decide il CMS).

- **`<head>`**: lo scrive `<x-cms::head>` (`Modules/Cms/app/View/Components/Head.php`): titolo, descrizione, canonical, hreflang delle sole lingue scritte, robots, Open Graph, dati strutturati. Una pagina aggiunge tag propri con `@push('head')` (esempio: JSON-LD `Event` nel dettaglio evento). Dettagli SEO in [seo-structured-data.md](seo-structured-data.md).
- **CSS**: `$needsFilament = auth()->check() || request()->is('*/auth', '*/auth/*')`. Se vero si carica `resources/css/app.css` (include il CSS di Filament), altrimenti `resources/css/site.css` (senza Filament, circa 650 KB in meno). Il visitatore anonimo e Googlebot scaricano quindi il bundle leggero. Motivo: prestazioni come segnale di ranking.
- **JS**: `@vite(['resources/js/app.js'], 'themes/'.MetatagData::make()->getPubTheme())` dentro `@push('head')`; il secondo argomento punta al manifest del tema. `@livewireScripts` sempre, `@filamentScripts` solo se `$needsFilament`. Alpine arriva con Livewire, non da `app.js`.
- **Dark mode**: uno script inline legge `localStorage.theme_dark` e aggiunge la classe `dark` a `<html>`, tranne quando vale `'false'`. Il default e' quindi scuro. Dettagli in [design-system.md](design-system.md).
- **Accessibilita'**: skip link verso `#main-content`, testo da `pub_theme::layout.skip_links.main_content.label`; `<html lang>` da `app()->getLocale()` (la lingua la imposta il middleware `SetFolioLocale`, vedi [localization-standard.md](localization-standard.md)).

## x-layouts.app

File: `components/layouts/app.blade.php`. Avvolge `x-layouts.main` e aggiunge, in ordine:

1. `<x-section slug="header"/>`
2. Barra `role="status"` se la sessione ha `status_message` (es. "Account eliminato" dopo un redirect: `session()->flash('status_message', ...)`)
3. `<main id="main-content">{{ $slot }}</main>`
4. `<x-section slug="footer"/>`
5. `<x-ui.assistant />` solo per `@auth` (e solo se c'e' un fornitore AI configurato)

### Sezioni (header e footer)

`<x-section slug="X" tpl="v1"/>` e' il componente `Modules/Cms/app/View/Components/Section.php`. Rende la vista `pub_theme::components.sections.{slug}.{tpl}` (`tpl` di default `v1`), quindi:

- `components/sections/header/v1.blade.php`
- `components/sections/footer/v1.blade.php`

Esistono anche `config/local/laravelpizza/database/content/sections/{header,footer}.json` con blocchi (`navigation/v1`, `footer-institutional`), ma le due viste `v1` sono Blade scritti a mano e non iterano `$blocks`. Contenuto e comportamento di header e footer: [header-footer-logo.md](header-footer-logo.md).

## Pattern di impaginazione

- **Pagina CMS**: `<x-page side="content" :slug="$slug" />` dentro `@volt`. La home usa due colonne: contenuto `lg:col-span-3`, `<x-page side="sidebar" slug="home" />` in `lg:col-span-1` (griglia `grid-cols-1 lg:grid-cols-4`). Vedi [cms-json-pages.md](cms-json-pages.md) e [folio-routing.md](folio-routing.md).
- **Pagine di accesso**: sezione a tutta altezza con sfondo gradiente scuro e una scheda centrale (login: `max-w-2xl`, `bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-700/50`). Vedi [authentication-ui-ux.md](authentication-ui-ux.md).
- **Contenitori**: header e footer usano `container mx-auto px-4`; la classe `.container-custom` (`max-w-7xl mx-auto px-4 sm:px-6 lg:px-8`) e `.section` (`py-12 md:py-16 lg:py-20`) sono in `resources/css/custom.css`.
- **Responsive**: mobile-first con i breakpoint standard di Tailwind (`sm` 640, `md` 768, `lg` 1024, `xl` 1280, `2xl` 1536). Il menu desktop compare da `md`.
- **Form**: una sola colonna, etichetta sopra il campo, campi raggruppati in sezioni con titolo (`fieldset`/`legend` o heading), larghezza massima per la leggibilita' ma piena su mobile, spaziatura a multipli di 4 px della scala Tailwind.

## Errori tipici

| Errore | Causa | Rimedio |
|---|---|---|
| `Unable to locate a class or view for component [pub_theme::components.layouts.main]` | Namespace `pub_theme::` non registrato o tema sbagliato | Controlla `pub_theme` in `config/local/<tenant>/xra.php` e che `ThemeServiceProvider` sia attivo; vedi [tenant-theme-resolution.md](tenant-theme-resolution.md) |
| `view not found: pub_theme::components.sections.header.v1` | Manca `sections/<slug>/<tpl>.blade.php` per la sezione richiesta | Crea il file con quel percorso esatto (slug e `tpl`) |
| `ParseError ... expecting "elseif" or "else" or "endif"` in un layout | Direttiva Blade non chiusa nel layout o in un componente incluso (`x-cms::head`, uno `@push`) | Cerca `@if`/`@php`/`@foreach` senza chiusura, partendo dal punto indicato e risalendo |
| Header e footer assenti in una pagina | La pagina usa `x-layouts.main` invece di `x-layouts.app` | Cambia layout |

## Da verificare

- `layouts/guest.blade.php` e `layouts/auth.blade.php` caricano `@vite(..., 'themes/Sixteen')` (manifest di un altro tema); `layouts/navigation.blade.php` usa `route('dashboard')` e `<x-application-logo>` del kit Breeze. Nessuna vista del tema li richiama: candidati alla rimozione. `Modules/Cms` risolve comunque `pub_theme::components.layouts.guest` nel componente `GuestLayout`.
- `CLAUDE.md` del progetto descrive `x-layouts.guest` come layout delle pagine di accesso; nel codice login e registrazione usano `x-layouts.app`.
- `<html lang>` usa `app()->getLocale()`; la regola di progetto preferisce `LaravelLocalization::getCurrentLocale()`.

## Vedi anche

- [design-system.md](design-system.md)
- [header-footer-logo.md](header-footer-logo.md)
- [folio-routing.md](folio-routing.md)
- [blocks-and-components.md](blocks-and-components.md)
- [authentication-ui-ux.md](authentication-ui-ux.md)
