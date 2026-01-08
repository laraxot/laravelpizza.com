---
description: Pixel parity homepage (/it)
---

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
  - `Themes/Meetup/resources/css|js/*` (quando necessario)
  - `config/local/laravelpizza/database/content/pages/*.json` (contenuti)

## Evidenze raccolte

### Asset caricati (locale)
- CSS:
  - `/themes/Meetup/assets/app-*.css`
  - `/fonts/filament/.../inter/index.css`
  - `/vendor/cookie-consent/css/cookie-consent.css`
- JS:
  - `/themes/Meetup/assets/app-*.js`
  - `/vendor/livewire/livewire.js`
  - `/vendor/cookie-consent/js/cookie-consent.js`
- Manifest:
  - `/themes/Meetup/site.webmanifest`

### Asset caricati (online)
- L’HTML corrente risulta servito da `Hostinger Horizons` (bundle `/assets/index-*.js|css`), quindi non rappresenta necessariamente la stessa pipeline Laravel/Theme.

## Fix implementati

### 1) Allineamento blocco “Why Join Our Community?”
- **JSON**: `home.json` usa `pub_theme::components.blocks.features.grid`
- **Fix**: `Themes/Meetup/resources/views/components/blocks/features/grid.blade.php`
  - Allineato a palette dark (`bg-slate-900`, `text-white`, `text-slate-300`)
  - Grid coerente con 4 feature (`lg:grid-cols-4`)
  - Rimossa interpolazione di classi Tailwind (no `hover:border-{{ ... }}`) per compatibilità Tailwind v4

## Screenshots
Salvare qui gli screenshot (PNG) per audit e regressioni:

- `docs/assets/pixel-parity/home-local-before.png`
- `docs/assets/pixel-parity/home-local-after-features.png`
- `docs/assets/pixel-parity/home-prod-reference.png`

> Nota: gli screenshot devono essere aggiornati ad ogni cambio visivo significativo.

## Link correlati
- `Themes/Meetup/docs/visual-differences-analysis.md`
- `Themes/Meetup/docs/build-and-copy-workflow.md`
- `Themes/Meetup/docs/folio-pages-json-only-rule.md`
