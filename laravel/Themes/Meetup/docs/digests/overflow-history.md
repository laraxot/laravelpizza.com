---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 17 file oltre target 100.

### `blocks-and-components.md` — Blocchi e componenti del tema


# Blocchi e componenti del tema

## Perche' esiste

I blocchi sono i mattoni con cui i JSON del CMS compongono le pagine: `Themes/Meetup/resources/views/components/blocks/`.
Un blocco e' una vista Blade che riceve i dati del JSON e li rende. Qui stanno il contratto di un blocco (che variabili
riceve, come si include, cosa non puo' fare), l'inventario di quelli reali con i loro parametri e come se ne crea uno
nuovo. Come i JSON referenziano i blocchi e' in [cms-json-pages](cms-json-pages.md).

## Contratto di un blocco

- Nome: `pub_theme::components.blocks.<gruppo>.<nome>` corrisponde al file
  `Themes/Meetup/resources/views/components/blocks/<gruppo>/<nome>.blade.php`. Il namespace `pub_theme` punta al tema in
  `xot.pub_theme`/`xra.pub_theme` (`Meetup`) ed e' registrato da `CmsServicePr

### `dashboard-and-profile.md` — Dashboard, area personale e profili


# Dashboard, area personale e profili

Dove vive cosa per un utente autenticato e per i profili pubblici: nessun controller, nessuna Blade per pagina, solo JSON del CMS, un'unica pagina Folio dedicata e blocchi "presenter" del tema.

## Front office e back office

- Front office (tema): pagine Folio + JSON. "Area personale" dopo il login = `xra.post_login_path` = `/events/my` (`config/local/laravelpizza/xra.php`), cioe' la pagina "I miei eventi" ([events-pages](events-pages.md)).
- Back office (Filament, `/admin`): la dashboard di gestione e' `Modules\Meetup\Filament\Pages\MeetupDashboard` con i widget del modulo (`MeetupStatsOverviewWidget`, `RecentEventsWidget`, `EventCalendarWidget`, ...), tutti derivati da `XotBaseWidget`. Non ha nulla nel tema: il tema non deve ricostruire una dashbo

### `header-footer-logo.md` — Header, footer e logo


# Header, footer e logo

## Perche' esiste

Header e footer sono la parte del sito che ogni pagina mostra: devono avere lo stesso logo, link sempre localizzati, testi tradotti e nessuna icona incollata come SVG nel Blade. Qui sta come sono fatti oggi, le regole che li governano e i difetti noti. Il selettore lingua ha una pagina propria: [language-switcher.md](language-switcher.md).

## Dove sono

| Pezzo | File |
|---|---|
| Header (nav sticky) | `resources/views/components/sections/header/v1.blade.php` |
| Footer | `resources/views/components/sections/footer/v1.blade.php` |
| Logo come componente | `resources/views/components/ui/logo.blade.php` |
| CTA di accesso condivise | `resources/views/components/ui/auth-buttons.blade.php` |
| Icone | `Modules/Meetup/resources/svg/*.svg` |

Header

### `language-switcher.md` — Selettore lingua


# Selettore lingua

## Perche' esiste

Chi legge il sito in una lingua deve poterla cambiare restando sulla stessa pagina, con un controllo comprensibile, accessibile da tastiera e che non rompa SEO e sessione. Il tema lo fa con un componente piccolo, tutto lato server: ogni voce e' un normale link all'URL della stessa pagina nell'altra lingua. Le regole generali su URL e traduzioni sono in [localization-standard.md](localization-standard.md).

## Come e' fatto

Componente: `resources/views/components/ui/language-switcher.blade.php`, usato nell'header due volte (`<x-ui.language-switcher />` nel nav desktop, `<x-ui.language-switcher mobile />` nel menu mobile). Vedi [header-footer-logo.md](header-footer-logo.md).

- **Lingue**: `LaravelLocalization::getSupportedLocales()` (oggi `it`, `en`,

### `manuals/manuale-utente.md` — Tema Meetup — front office pubblico


> Screenshot reale della home pubblica (`/it`), verificato il 25 novembre 2026 con `tools/visual/shot.mjs` su `http://127.0.0.1:8000`.

![Home pubblica del tema Meetup in italiano](assets/home-it.png)

# Tema Meetup — front office pubblico

Questo manuale copre il **tema pubblico** `laravel/Themes/Meetup` (namespace `pub_theme::`):
le pagine che vede chiunque visita il sito — home, eventi, contatti, chi siamo, accesso e
registrazione, profilo pubblico — e il comportamento trasversale (header, footer,
localizzazione, viewport mobile). Non copre i pannelli Filament dei moduli: per quello
esistono i manuali in `laravel/Modules/<Modulo>/docs/manuals/`.

Per la guida utente completa per ruolo (visitatore, partecipante, organizzatore,
amministratore) con oltre cento screenshot annotati e PDF st

### `mcp-configuration.md` — MCP Server Configuration - Meetup Theme

# MCP Server Configuration - Meetup Theme

**Status**: ✅ Configured
**MCP Servers**: Asana, ClickUp, Filesystem, Database, **cursor-browser-extension**, Redmine (Planned)

---

## 📋 Overview

The Meetup theme's MCP configuration enables AI assistants to interact with:
- **Asana Work Graph** - Frontend development task tracking
- **ClickUp Workspace** - Advanced task workflows and time tracking
- **Redmine** - Project management (planned, requires self-hosted instance)
- **Filesystem** - Theme assets, components, and page access
- **Database** - Theme configuration and settings inspection
- **cursor-browser-extension** - Navigazione e screenshot per confronto grafico con laravelpizza.com

---

## 🔧 Configuration

### `on-demand-pattern.md` — On-Demand Pattern — stub


# On-Demand Pattern — stub

Copia scaffold rimossa. **Fonte canonica** (wiki temi condivisa):

**[on-demand-pattern.md](../../docs/on-demand-pattern.md)**

### `pixel-parity-home.md` — Pixel parity homepage (`/it`) vs `laravelpizza.com`


# Pixel parity homepage (`/it`) vs `laravelpizza.com`

## Obiettivo
Rendere la homepage locale `http://127.0.0.1:8002/it` visivamente equivalente a `https://laravelpizza.com/`.

## Source-of-truth (architettura)
- **Folio page**: `Themes/Meetup/resources/views/pages/index.blade.php`
- **Layout**: `<x-layouts.app>` (delegation → `<x-layouts.public>` per guest)
- **Renderer contenuti**: `<x-page side="content" slug="home" />`
- **Contenuti**: JSON in `config/local/laravelpizza/database/content/pages/home.json`

## Metodo di lavoro (evidenze)
- Confronto “above the fold” tramite screenshot (locale vs online)
- Verifica asset effettivamente caricati (CSS/JS/manifest)
- Fix incrementali in:
  - `Themes/Meetup/resources/views/components/blocks/*` (Blade)
  - `Themes/Meetup/resources/css|js/*` (

### `project-structure.md` — Project Structure — stub


# Project Structure — stub

Copia scaffold rimossa. **Fonte canonica** (wiki temi condivisa):

**[project-structure.md](../../docs/project-structure.md)**

### `roadmap/03-later.md` — Later (Theme Meetup)

# Later (Theme Meetup)

## Longer-term ideas

### `roadmap/04-risks.md` — Risks and dependencies (Theme Meetup)

# Risks and dependencies (Theme Meetup)

## Risks

## Dependencies

### `roadmap/05-risks.md` — Risks - Meetup

# Risks - Meetup

## Top Risks

1. Drift tra documentazione e comportamento runtime.
2. Regressioni introdotte da fix rapidi non verificati.
3. Dipendenze incrociate non documentate.

## Mitigations

1. Aggiornare docs insieme ai fix di codice.
2. Usare checklist pre-merge e post-fix.
3. Mantenere un set di file canonici per diagnosi rapida.

### `root-cause-found.md` — Root Cause Analysis - Homepage Layout Issue

# Root Cause Analysis - Homepage Layout Issue

## Problem Identified

The homepage at `/it` is rendering with the **WRONG LAYOUT**.

## Current (WRONG) Setup

### File: `Themes/Meetup/resources/views/pages/index.blade.php`

```blade
<x-layouts.app>
    @volt('home')
        <div>
            <x-page side="content" slug="home" :type="auth()->user()?->type?->value" />
        </div>
    @endvolt
</x-layouts.app>
```


### `seo-structured-data.md` — SEO, meta tag e dati strutturati


# SEO, meta tag e dati strutturati

Il SEO del sito e' fatto dal modulo Cms (`<head>`, schema delle pagine), dal modulo Seo (sitemap, robots, alias) e dal modulo Meetup (JSON-LD `Event`). Il tema fornisce layout e immagine di condivisione e non reinventa nulla. Le regole sotto evitano la regressione tipica: ogni pagina con lo stesso titolo e markup strutturato incompleto o contraddittorio.

## Il `<head>` lo scrive il CMS

`resources/views/components/layouts/main.blade.php` non contiene un `<head>` a mano: chiama `<x-cms::head :title :description :stylesheet>` (`Modules/Cms/app/View/Components/Head.php`, view `Modules/Cms/resources/views/components/head.blade.php`). La view emette `@head` e gli stack `head`/`styles`; i tag li compone `Head.php` con `HeadManager`: `title`, description, `ca

### `tenant-theme-resolution.md` — Tenant, configurazione e risoluzione del tema pubblico


# Tenant, configurazione e risoluzione del tema pubblico

## Perche' esiste

Il tema pubblico non e' scritto nel codice: si ricava dal **tenant**, cioe' dal dominio. Chi non conosce la catena cerca i JSON
nella cartella sbagliata, modifica il tema sbagliato o non capisce perche' `pub_theme::...` non si risolve. Questa pagina
tiene insieme dominio -> cartella di config -> `pub_theme` -> cartella del tema -> namespace delle view.

## La catena

1. **Dominio**: `.env` ha `APP_URL=http://laravelpizza.local`. Su web conta l'host della richiesta; in console, code e scheduler
   conta `APP_URL` (cosi' un job lavora con la stessa configurazione della richiesta che lo ha creato).
2. **Cartella tenant**: il modulo Tenant (`GetTenantNameAction`) inverte le parti del dominio: `laravelpizza.local` ->


### `translation-rules.md` — Regole per le Traduzioni — Meetup Theme (pub_theme)

# Regole per le Traduzioni — Meetup Theme (pub_theme)

## Struttura obbligatoria

Le traduzioni del tema pubblico usano il namespace `pub_theme::` che mappa a `Themes/Meetup/lang/{locale}/`.

**MAI chiavi flat. SEMPRE struttura espansa con sotto-chiavi.**

## Gerarchia dei file

```
Themes/Meetup/lang/{locale}/
├── event.php       # Evento singolo (detail page)
├── events.php      # Lista eventi
├── home.php        # Home page
└── navigation.php  # Navigazione
```

## Struttura standard per `event.php`


### `workflow-summary.md` — Workflow Summary - Sessione


# Workflow Summary - Sessione

> Data di sessione ricavata dal vecchio nome file (`workflow-summary-jan-22.md`): il nome non porta piu' date.

**Status**: ✅ Completato
**Scopo**: Riepilogo completo del lavoro svolto seguendo le raccomandazioni degli altri agenti AI

---

## 🎯 Obiettivo Principale

Seguire le raccomandazioni degli altri agenti AI leggendo le cartelle `docs/` dei temi, fare la scelta più intelligente, e aggiornare la documentazione.

---

## 📚 Fase 1: Studio Documentazione

### Documenti Analizzati
