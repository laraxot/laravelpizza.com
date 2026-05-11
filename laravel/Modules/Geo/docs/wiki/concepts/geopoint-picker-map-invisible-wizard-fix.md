---
name: geopoint-picker-map-invisible-wizard-fix
description: "GeopointPicker map not visible in wizard: JS component not imported in theme, missing MutationObserver, missing Leaflet CSS import"
type: bugfix
---

# GeopointPicker — Map Invisible in Wizard Fix

## Data: 2026-04-23

## Problema

URL `/it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step`

La mappa del GeopointPicker non appare nello step "dati-della-segnalazione" del wizard.

## Root Cause

La mappa è invisibile per **tre motivi concatenati**:

### 1. Componente JS non importato nel tema (PRIMARY)

`GeopointPicker.blade.php` renderizza `<geopoint-picker-lit>` ma il file JS **non era importato** in `Themes/Sixteen/resources/js/app.js`.

Il file `Modules/Geo/resources/js/components/geopoint-picker-lit.js` esisteva ma non veniva mai caricato nel bundle del tema → il browser vede un tag HTML custom sconosciuto → renderizza nulla.

**Fix**: aggiunto `import '@modules/Geo/resources/js/components/geopoint-picker-lit.js';` in `app.js`.

### 2. MutationObserver mancante per wizard step (SECONDARY)

Anche se il componente JS fosse stato importato, mancava il `MutationObserver` che cattura il toggle `class="hidden"` dei wizard step Filament 5.

**Perché serve:**
- Filament 5 nasconde gli step inattivi con `class="hidden"` (Tailwind)
- Leaflet misura il container al mount → se nascosto, dimensioni 0×0 → nessun tile caricato
- `ResizeObserver` e `IntersectionObserver` NON catturano il toggle di classe CSS `hidden`
- Solo `MutationObserver` con `attributeFilter: ['class']` funziona

**Fix**: aggiunto MutationObserver su 14 antenati + delay array `[0, 80, 180, 350, 700, 1200]`.

### 3. Leaflet CSS import mancante (TERTIARY)

Il component JS non importava `leaflet/dist/leaflet.css` via Vite → Leaflet inizializzava senza gli stili necessari → mappa potenzialmente invisibile.

**Fix**: aggiunto `import 'leaflet/dist/leaflet.css';` in cima al file.

## File modificati

| File | Modifica |
|------|----------|
| `Modules/Geo/resources/js/components/geopoint-picker-lit.js` | Aggiunto Leaflet CSS import, MutationObserver, _refreshMapSize() |
| `Themes/Sixteen/resources/js/app.js` | Aggiunto import geopoint-picker-lit.js |
| Build tema eseguito: `npm run build` in `Themes/Sixteen` |

## Best Practices da seguire

### Obbligatorie

1. **OGNI componente Lit custom element DEVE essere importato in `Themes/Sixteen/resources/js/app.js`**
   - Altrimenti il browser non lo riconosce → HTML tag sconosciuto
   - Validazione: `customElements.get('nome-component')` in browser console deve restituire la classe

2. **OGNI componente mappa in wizard deve avere:**
   - `import 'leaflet/dist/leaflet.css';` in cima al file JS
   - `MutationObserver` su ≥12 antenati con `attributeFilter: ['class', 'style', 'hidden']`
   - Delay array `[0, 80, 180, 350, 700, 1200]` per `invalidateSize()`
   - `_refreshMapSize()` che controlla `offsetParent !== null` e `getBoundingClientRect()`

3. **OGNI build tema deve essere seguito da:**
   - `npm run build` → `npm run copy` (se configurato)

### BAD Practices rimosse

- `IntersectionObserver` per wizard step visibility → NON funziona con `class="hidden"`
- Affidarsi solo a `ResizeObserver` → NON cattura toggle visibilità
- Importare Leaflet CSS nel template Blade → violazione DRY, duplicato nel bundle

### False Friends

| Observer | Rileva `hidden` class | Rileva viewport | Adeguato per wizard |
|----------|----------------------|-----------------|-------------------|
| `IntersectionObserver` | ❌ NO | ✅ | ❌ |
| `ResizeObserver` | ❌ NO | ❌ | ❌ |
| `MutationObserver` (class) | ✅ SI | ❌ | ✅ |

## Checklist verifica dopo fix

```bash
# 1. Verificare che il componente JS sia importato
grep "geopoint-picker-lit" Themes/Sixteen/resources/js/app.js

# 2. Verificare il build
npm run build  # da Themes/Sixteen

# 3. Verificare in browser console (deve restituire la classe, non undefined)
customElements.get('geopoint-picker-lit')

# 4. Caricare URL wizard e verificare che la mappa sia visibile
# /it/tests/segnalazione-crea?step=form.dati-della-segnalazione::data::wizard-step
```
