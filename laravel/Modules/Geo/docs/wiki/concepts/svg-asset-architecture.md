# SVG Asset Architecture — Geo Module

## REGOLA PERMANENTE (2026-04-20)

```
OBBLIGATORIO: laravel/Modules/Geo/resources/svg/{nome}.svg
VIETATO: resources/img/, public/images/, public/vendor/, assets/
```

Tutti gli SVG di un modulo stanno in `resources/svg/` — nessuna eccezione.

## SVG Icons for Map Controls

I nuovi file SVG per i controlli della mappa (creati 2026-04-27):

```
laravel/Modules/Geo/resources/svg/magnifying-glass.svg    ← lente ricerca
laravel/Modules/Geo/resources/svg/arrows-pointing-out.svg  ← fullscreen apri
laravel/Modules/Geo/resources/svg/arrows-pointing-in.svg   ← fullscreen chiudi
laravel/Modules/Geo/resources/svg/map-pin.svg              ← geolocalizzazione
laravel/Modules/Geo/resources/svg/squares-2x2.svg         ← cambio layer
laravel/Modules/Geo/resources/svg/plus.svg                 ← zoom in
laravel/Modules/Geo/resources/svg/minus.svg                ← zoom out
laravel/Modules/Geo/resources/svg/map-marker.svg          ← marker principale
laravel/Modules/Geo/resources/svg/map-picker-marker.svg  ← marker picker
```

## Auto-Registrazione Blade Icons

I moduli registrano automaticamente le proprie SVG tramite `XotBaseServiceProvider`.
Non serve configurare `blade-icons.php` per il modulo Geo — le icone sono
disponibili tramite il nome file senza prefisso personalizzato.

Per riferimento in Blade: scrivere SVG inline direttamente nel template
invece di usare `@svg()` per evitare collisioni di prefisso.

## JS Module Usage

In Lit Element components, le icone sono reference tramite `geoIcon()` da `geo-heroicons.js`:

```javascript
import { geoIcon } from './geo-heroicons.js';
// Uso: html`<button>${geoIcon('magnifying-glass')}</button>`
```

`geo-heroicons.js` carica gli SVG tramite Vite `?raw` import da `../../svg/`.

## Esempi già presenti nel progetto

```
laravel/Modules/Activity/resources/svg/icon.svg
laravel/Modules/Activity/resources/svg/loading.svg
laravel/Modules/User/resources/svg/role.svg
laravel/Modules/User/resources/svg/user-profile.svg
```

## Riferimenti

- `bashscripts/ai/.claude/rules/svg-asset-location.md`
- `geo-heroicons.js` — registry icone Lit
- `map-picker-styles.js` — stili e controlli mappa
