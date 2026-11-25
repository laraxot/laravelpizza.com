---
title: "Cms: componenti Blade, layout, sezioni, header e footer"
type: concept
module: Cms
status: active
qmd: "cms componenti blade x-page x-section head foot metatags layout runtime header nav footer user dropdown alias pub_theme"
---

# Componenti Blade del Cms

Componenti PHP in `app/View/Components`, viste in `resources/views/components`. Il tema fornisce solo shell e viste dei
blocchi (namespace `pub_theme::`); la logica di dominio resta nei moduli.

| Componente | Ruolo |
|---|---|
| `<x-page side slug :data>` | rende i blocchi di una pagina; risolve il contenitore CMS, unisce il contesto di rotta nel data bag, ricorda titolo/descrizione per l'head |
| `<x-page-content>` | contenuti collegati (`PageContent`) |
| `<x-section slug tpl>` | sezione condivisa (header, footer, sidebar) da `database/content/sections`; view `pub_theme::components.sections.<slug>.<tpl>`, `tpl` di default `v1` |
| `<x-head>` / `<x-foot>` | coda e testa di ogni pagina pubblica (asset Vite, Filament, stack) |
| `<x-metatags>` | `<title>`, description, Open Graph, Twitter Card, JSON-LD ([page-title-and-description.md](page-title-and-description.md)) |
| `AppLayout`, `GuestLayout` | layout applicativo e per ospiti |

Vista di default dei pezzi comuni: `components/{button,footer,headernav,blog,blocks}` (pulsanti action/link/panel,
footer `default`/`empty`/`footer_with_logo`/`social_media_icons`, `headernav/simple`, griglie e filtri del blog,
`blocks/calendar`).

## Regole che valgono sempre

1. **Alias.** Nelle Blade si scrive `<x-page ... />` (o `<x-pub_theme::page ... />`), mai `<x-<nome-tema>::page>`: il
   namespace stabile e' `pub_theme`, il tema puo' cambiare.
2. **`<x-page>` trasporta, non conosce.** Ha solo `side`, `slug`, `data`: niente prop per `container0`, `slug0`,
   `container1`... Il contesto di rotta passa nel data bag (`:data="$data"`), che oggi puo' contenere `container0`,
   `slug0`, `item`, `event` e domani altre chiavi senza cambiare la firma. Contratto:
   [components/page-component-data-contract.md](components/page-component-data-contract.md).
3. **Il PHP ha la logica, la Blade il rendering minimo.** `Page.php` compone lo slug, carica i blocchi e prepara i dati;
   `components/page.blade.php` itera i blocchi e include le loro view, senza logica applicativa. Cosi' il tema puo'
   sovrascrivere la view senza copiare la logica del Cms.
4. **Layout runtime.** Le pagine CMS dinamiche non contengono elementi strutturali globali:
   - `pages/.../[slug].blade.php` del tema: risolve lo slug e invoca `<x-page />`;
   - `layouts/app.blade.php`: skiplink, header, main, footer;
   - `layouts/main.blade.php`: shell HTML, Vite, Filament, script globali.
   Nelle page Blade sono ammessi Folio, Volt, `<x-layouts.app>` e `<x-page />`; non sono ammessi skiplink,
   `<x-section slug="header" />`, `<x-section slug="footer" />` ne' una shell HTML completa. Header e footer sono
   sezioni condivise, non appartengono allo slug pagina: una sola modifica al layout si propaga a tutte le pagine.
5. **Asset Filament nell'head/foot.** `@filamentStyles` va nell'`head` solo dentro `@if ($panelAssets)`, poi `@vite`
   del foglio (prop di `View\Components\Head`), poi `@stack('head')`/`@stack('styles')`; il `foot` ha
   `@livewire('notifications')` e `@filamentScripts` nello stesso `@if`, poi `@vite`. Direttive duplicate o fuori
   dall'`@if` caricano CSS/JS doppi senza errori. Contratto: [bmad/filament-layout-styles-scripts.md](bmad/filament-layout-styles-scripts.md);
   guardia: `Modules/Cms/tests/Unit/Views/FilamentLayoutDirectivesTest.php`. Sostituzione dell'head con
   `<x-head>`: [bmad/head-component-adoption-plan.md](bmad/head-component-adoption-plan.md).
6. **Link localizzati.** I JSON dei blocchi possono tenere path relativi (`"/register"`); la Blade che li stampa li passa da
   `LaravelLocalization::localizeUrl()` ([folio-routing-locale.md](folio-routing-locale.md)).
   `ResolveLocalizedBlockDataAction` esiste per localizzare in blocco i campi URL dei dati di un blocco, ma al momento
   nessun codice del Cms o dei temi la invoca: non contarci finche' non viene agganciata a `BlockData`.

## Header, footer, navigazione

- `header` e `footer` sono **sezioni** (`Section`), non blocchi di pagina: record JSON `sections/header.json`,
  `sections/footer.json` con `blocks.<lingua>[]`. Se un dato puo' variare da un cliente all'altro sta nel JSON, non nella Blade.
- Blocchi Builder correlati (`app/Filament/Blocks`): `HeaderNavBlock`, `NavigationBlock`, `LogoBlock`, `LinksBlock`,
  `SocialBlock`/`SocialLinksBlock`, `QuickLinksBlock`, `NewsletterBlock`. I dati tipizzati sono `HeadernavData`,
  `FooterData`, `LinkData`, `NavbarMenuData`; si salvano con `SaveHeadernavConfigAction` e `SaveFooterConfigAction`
  ([contracts/](contracts/README.md)).
- Menu a tendina utente: in passato aveva voci hardcoded, dati di config ignorati, nessuna traduzione, ARIA mancante e
  URL non validati. Regola: voci dal JSON, etichette tradotte, `aria-*` e navigazione da tastiera, URL validati.
- Selettore lingua dell'header: i link usano `LaravelLocalization::getLocalizedURL($code, null, [], true)` e mostrano la
  lingua corrente con `LaravelLocalization::getCurrentLocale()`.

## Stack UI

Tailwind CSS v4, Alpine.js v3, Lit v3, DaisyUI v5, Flowbite, Filament v5, Vite; niente Bootstrap
([wiki/rules/frontend-stack-canonical.md](wiki/rules/frontend-stack-canonical.md)). Le classi stanno nel tema, i blocchi
prendono il nome dai blocchi Tailwind/Flowbite. DaisyUI: componenti pronti e temi, ma aumenta il peso dei CSS; usarlo
dove riduce markup ripetuto, non come dipendenza di ogni blocco. Per riuso dei componenti tra temi e
convenzioni di nome vedere [theme-and-assets.md](theme-and-assets.md).

## Componenti dei blocchi: convenzioni

- View in `Themes/<tema>/resources/views/components/blocks/<categoria>/<nome>.blade.php`, richiamate come
  `pub_theme::components.blocks.<categoria>.<nome>` ([content-blocks-system.md](content-blocks-system.md)).
- Namespace PSR-4 dei moduli `Modules\<Modulo>\...` (cartella `app/`), mai `app\<Modulo>`; i namespace Blade seguono il
  nome del modulo in minuscolo (`cms::`, `ui::`).
- Estendere le classi XotBase, non quelle di Filament ([filament-admin.md](filament-admin.md)).
- Nessun SVG inline nelle Blade: file `.svg` e `<x-filament::icon>`.
- `Section::render()` unisce i `data` dei blocchi; se la view `<slug>.<tpl>` non esiste la pagina fallisce: creare il template prima del JSON.
