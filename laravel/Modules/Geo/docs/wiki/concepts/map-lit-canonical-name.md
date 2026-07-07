# `<map-lit>` — Canonical Custom Element Name

**Decision date**: 2026-05-08
**Owner**: Xot
**Story**: 8-133

## Regola

Per la pagina `/it/tests/ticket-list` e qualsiasi altra pagina pubblica/admin che renderizza una mappa Leaflet con marker delle segnalazioni, il custom element canonico è **`<map-lit>`**, definito da `laravel/Modules/Geo/resources/js/components/map-lit.js` (linea 382: `customElements.define('map-lit', MapLit)`).

## Why

La proliferazione `<geo-map-lit>`, `<my-map-lit>`, `<ticket-map-lit>` con file alias `geo-map-lit-final.js`, `geo-map-lit-new.js`, `geo-map-lit.bak.js` è il **sintomo del problema**, non la soluzione. Sostituire il nome nel Blade per "far riconoscere il custom element" è la **scorciatoia sbagliata** — il problema vero è quasi sempre l'import mancante o il bundle non aggiornato.

## How to apply

### Tag Blade
```blade
{{-- ✅ CORRETTO --}}
<map-lit
    id="segnalazioni-map"
    data-url="{{ asset('data/tickets.json') }}"
    height="clamp(360px,58vh,560px)"
    style="height:clamp(360px,58vh,560px);display:block;width:100%"
    aria-label="..."
></map-lit>

{{-- ❌ VIETATO --}}
<geo-map-lit ...></geo-map-lit>
<my-map-lit ...></my-map-lit>
<ticket-map-lit ...></ticket-map-lit>
```

### Import nel Theme bundle
Il theme `laravel/Themes/Sixteen/resources/js/app.js` deve importare `map-lit.js`:
```js
import '@modules/Geo/resources/js/components/map-lit.js';
```

NON aggiungere `<script type="module" src="{{ Vite::asset('...,'assets/geo') }}">` nel Blade come scorciatoia cross-module — il theme bundle è la fonte canonica.

### Cosa fare se `<map-lit>` non si registra
1. Verifica `import '@modules/Geo/resources/js/components/map-lit.js';` in `Themes/Sixteen/resources/js/app.js`
2. `cd laravel/Themes/Sixteen && npm run build && npm run copy`
3. `cd laravel && php artisan optimize:clear`
4. Hard reload browser (Ctrl+Shift+R)
5. Verifica console: `customElements.get('map-lit')` deve tornare la classe, non `undefined`

**MAI**: rinominare il tag nel Blade come fix.

## Anti-pattern condannati

- File alias proliferati: `geo-map-lit-final.js`, `geo-map-lit-new.js`, `geo-map-lit.bak.js`, `my-map-lit.js`
- **Fork nel tema Sixteen:** `Themes/Sixteen/resources/js/components/geo-map-lit-local.js` (vietato — regola progetto [no-theme-map-lit-fork](../../../../../docs/wiki/rules/no-theme-map-lit-fork.md))
- Custom element duplicati: `<geo-map-lit>`, `<my-map-lit>`, `<ticket-map-lit>`
- Cross-module Vite asset deploy: `<script src="{{ Vite::asset('...,'assets/geo') }}">`
- "Compat layer" che mantiene entrambi i nomi attivi → causa "Custom element already defined"

## Pattern consolidato (post-fix Story 8-133)

I tre Blade owner per `/it/tests/ticket-list` usano tutti `<map-lit>`:
1. `Themes/Sixteen/resources/views/pages/tests/ticket-list.blade.php` → `@include('pub_theme::components.sections.map-lit')`
2. `Themes/Sixteen/resources/views/components/sections/map-lit.blade.php` → partial canonico riusabile
3. `Themes/Sixteen/resources/views/components/blocks/tests/ticket-list.blade.php` → `<map-lit>` linea 118
4. `Themes/Sixteen/resources/views/components/blocks/segnalazioni/layout.blade.php` → `<map-lit>` linea 201 (CMS block)

## Riferimenti

- File canonico: `laravel/Modules/Geo/resources/js/components/map-lit.js`
- Memory feedback: `~/.claude/projects/-var-www--bases-base-fixcity-fila5/memory/feedback_map_lit_canonical_name.md`
- Story 8-133: `_bmad-output/implementation-artifacts/8-133-ticket-list-map-not-visible-geo-vite-asset-deploy.md`
- Wiki correlate (deprecated callout da aggiungere): `geo-map-lit-implementation.md`, `geo-map-lit-marker-clusters.md`, `geo-map-lit-reference.md`
