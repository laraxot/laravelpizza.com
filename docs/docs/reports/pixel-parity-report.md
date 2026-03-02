# Pixel parity report – 2026-02-02

## Scope

Confronto visivo basato su screenshot (viewport `1440x900`) tra:

- **Locale (Meetup theme)**: `http://127.0.0.1:8000/it`
- **Dominio pubblico**: `https://laravelpizza.com/`

## Risultato sintetico

- **NON è possibile dichiarare “pixel parity” con `https://laravelpizza.com/`**, perché il dominio in questo momento **non serve l’app LaravelPizza**, ma una landing esterna ("Hostinger Horizons").
- È invece possibile (e utile) fare pixel parity **tra locale light/dark** e definire una checklist di miglioramenti UI.

## Screenshot

### Locale

- **Locale – light**: `../screenshots/2026-02-02/local-home-light-1440.png`
- **Locale – dark**: `../screenshots/2026-02-02/local-home-dark-1440.png`

#### Events

- **Events – light**: `../screenshots/2026-02-02/local-events-light-1440.png`
- **Events – dark**: `../screenshots/2026-02-02/local-events-dark-1440.png`

### Dominio pubblico attuale

- **laravelpizza.com (landing esterna)**: `../screenshots/2026-02-02/laravelpizza-com-hostinger-1440.png`

## Evidenze oggettive (perché non è confrontabile)

- Il fetch HTML di `https://laravelpizza.com/` contiene:
  - `meta name="generator" content="Hostinger Horizons"`
  - asset `/<assets>/index-*.js` e `/<assets>/index-*.css`
  - nessun markup/asset riconducibile al tema Laravel (Meetup) del repository

Quindi il confronto locale vs `laravelpizza.com` oggi misura **due siti diversi**.

## Differenze & cose da migliorare (locale)

Questa sezione descrive miglioramenti UI per “rifinire” il tema Meetup, indipendentemente dal dominio esterno.

### Header / Navigation

- **Logo**
  - **Stato**: la navbar usa il componente `x-ui.logo` (single source of truth del tema).
  - **Verifica**: controllare resa in light/dark e su breakpoint mobile.

#### Misure oggettive header (home vs events, light vs dark)

Ho estratto via Puppeteer (DOM + computed styles) un set di metriche minime e ripetibili.

- **JSON completo**: `header_metrics_2026-02-02.json`

Tabella sintetica:

| Pagina | Mode | Nav position | Nav height | Nav class (estratto) | Nav text color | Nav bg | Note |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `/it` | light | fixed | 65 | `bg-slate-100/95 ... border-slate-200 ... shadow-sm` | `rgb(15,23,42)` | `transparent` (via class) | header “fisso” |
| `/it` | dark | fixed | 65 | `... dark:bg-slate-900/95 ... dark:border-slate-800 ...` | `rgb(255,255,255)` | `oklab(... / 0.95)` | no shadow in dark |
| `/it/events` | light | sticky | 65 | `bg-slate-800/50 ... border-slate-700 sticky` | `rgb(255,255,255)` | `oklab(... / 0.5)` | header “sticky”, stile diverso dalla home |
| `/it/events` | dark | sticky | 65 | `bg-slate-800/50 ... border-slate-700 sticky` | `rgb(255,255,255)` | `oklab(... / 0.5)` | identico al light |

**Impatto**: oggi **home** e **events** usano due navbar diverse (fixed + light palette vs sticky + dark palette). Se l’obiettivo è coerenza grafica totale, va unificata la sorgente della navbar anche per `/it/events`.

- **Language switcher**
  - **Stato**: usa `x-ui.language-switcher` (dropdown inline).
  - **Migliorie**:
    - allineare dimensioni/padding ai bottoni auth e al theme toggle per coerenza.
    - verificare che lo stato attivo (lingua corrente) sia evidente anche in dark.

- **Theme toggle (light/dark)**
  - **Stato**: usa `x-ui.theme-toggle` con icone standard sun/moon e persistenza `theme_dark`.
  - **Migliorie**:
    - verificare che la classe `dark` sia coerente con lo script bootstrap in `layouts/main.blade.php`.

### Palette / contrasto / accessibility

- **Contrast**
  - verificare contrasto testo su `bg-slate-100/95` (light) e `bg-slate-900/95` (dark) specialmente su link secondari.

- **Focus states**
  - verificare che gli elementi interattivi in header (language, theme toggle, auth) abbiano `focus:ring-*` coerenti e visibili.

### DOM structure

- Verificare che ci siano elementi semantici coerenti (`<header>`, `<main>`) nelle pagine principali. La home oggi rende una `<nav>` e un “spacer”; va bene, ma un wrapper semantico può aiutare accessibilità e test.

## Backlog operativo

- **[high]** Ottenere URL produzione/staging corretto (non Hostinger) per pixel parity reale.
- **[high]** Screenshot comparativi anche per:
  - pagina eventi (es. `/it/events`)
  - pagina dettaglio evento (se esiste)
- **[medium]** Allineare spacing tra language switcher / theme toggle / auth buttons.
- **[medium]** Audit accessibilità: focus rings + skip links.

## Note tecniche sugli screenshot

Gli screenshot sono stati generati con Puppeteer MCP e salvati nel repository tramite decodifica dei payload base64 presenti in `/tmp/windsurf/mcp_output_*.txt`.
