# Lit light dom map controls and sync

## Scopo

Stabilizzare il `CoordinatePicker` Lit usato in admin (`fixcity/admin/tickets/create`) quando il componente gira in **Light DOM**.

## Problemi osservati

- controlli mappa (fullscreen, zoom, layer, posizione corrente) non visibili/coerenti;
- icona lente percepita enorme;
- trascinando marker, `latitude/longitude` non sempre aggiornate nel readout/form.

## Root cause tecnico

1. Il componente usa `createRenderRoot() { return this; }` (Light DOM).
2. In Light DOM gli stili Lit non sono scoped automaticamente come in Shadow DOM.
3. Il CSS condiviso veniva interpolato come `CSSResult` dentro `<style>`, con comportamento fragile.
4. Nel bridge Alpine, aggiornamenti nested su `state.latitude`/`state.longitude` non garantivano reattivita robusta in tutti i cicli Livewire/entangle.

## Fix implementati

### 1) CSS robusto per Light DOM

- `map-picker-styles.js`: aggiunto export `mapPickerStylesText = mapPickerStyles.cssText`.
- `coordinate-picker-lit.js`: uso di `mapPickerStylesText` nel blocco `<style>`.

Effetto: i controlli overlay ricevono sempre le regole CSS previste (`position`, `size`, `z-index`, icone SVG).

### 2) Sync coordinate con update immutabile

In `coordinate-picker.blade.php`:

- `handleCoordsChanged()` ora riassegna `this.state` con oggetto nuovo;
- stessa strategia in `selectSearchResult()` e `reverseGeocode()`.

Effetto: aggiornamento piu affidabile su Alpine + Livewire entangle quando il marker viene mosso o si seleziona un risultato.

## Verifica tecnica

- build modulo: `npm run build` ✅
- publish asset modulo: `npm run copy` ✅
- output generato in `laravel/Modules/Geo/public` e pubblicato in `public_html/assets/geo`.

## Nota Lit (riferimento)

- [Lit styles docs](https://lit.dev/docs/components/styles/)
- [Lit shadow dom docs](https://lit.dev/docs/v3/components/shadow-dom/)
- In Light DOM, preferire CSS globale o iniezione esplicita di testo CSS quando serve.

## Riferimenti correlati

- [geo vite build contract](./geo-vite-build-contract.md)
- [map picker runtime asset governance](./map-picker-runtime-asset-governance.md)
- [filament admin panel map visibility contract](./filament-admin-panel-map-visibility-contract.md)
