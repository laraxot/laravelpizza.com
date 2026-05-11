# MapPicker Filament Field (Lit + Leaflet + Livewire) - Refactored v2

**Data aggiornamento:** 2026-04-20  
**Status:** Produzione (Laravel 12 / Filament v5)  
**Argomento:** Campo Filament `MapPicker` con stato unico `{ latitude, longitude }` e Alpine adapter minimale.

---

## Obiettivo Architetturale

Eliminare la fragilità della sincronizzazione bidirezionale e il coupling tra Blade e schema database, consolidando il `MapPicker` come un componente "Unified State" robusto e testabile.

### Miglioramenti Chiave (2026)
1. **Unified State Object**: Lo stato del campo è un singolo oggetto/array `{ latitude, longitude }`.
2. **Thin Alpine Adapter**: Alpine non gestisce più variabili locali (`displayLat`/`lng`), ma funge da bridge puro tra eventi Lit e `$wire`.
3. **Shadow DOM Enforcement**: Il componente Lit `map-picker-lit` usa correttamente `renderRoot` per isolare Leaflet e i suoi stili.
4. **Visibility Awareness**: `ResizeObserver` integrato nel Web Component per gestire correttamente l'inizializzazione in step di Wizard nascosti.
5. **Current Position Rule**: se `latitude` oppure `longitude` sono `null` o non numeriche, il runtime deve trattare la coppia come incompleta e tentare geolocalizzazione browser, impostando entrambe le coordinate alla posizione corrente.

---

## Pattern di Implementazione

### 1. Field PHP (`MapPicker.php`)
Estende `XotBaseField`. Questa non e una scelta opzionale ma una regola Laraxot permanente: i custom field Filament del modulo Geo non devono estendere `Field` direttamente e non devono appoggiarsi a gerarchie sibling improprie.

`MapPicker` gestisce la configurazione (zoom, height, search) e fornisce metodi per il geocoding lato server.
Lo stato di default è inizializzato a `['latitude' => null, 'longitude' => null]`.

### 2. Blade View (`map-picker.blade.php`)
Usa `wire:ignore.self` sul wrapper.
Alpine Bridge:
- `onLocationChanged(e)`: Riceve `{ latitude, longitude, source }` dal Web Component e chiama `$wire.$set(statePath, { latitude, longitude }, false)`.
- `$wire.$watch(statePath, ...)`: Propaga variazioni esterne (es. geocoding, reset form) al Web Component chiamando `applyExternalLocation(value)`.

### 2.b Runtime effettivo nel repository

Nel repository attuale l'alias PHP `MapPicker` renderizza una view che delega al bridge `coordinate-picker.blade.php` e al web component `coordinate-picker-field.js`.

Quindi la regola runtime "coordinate incomplete => geolocalizza" va protetta prima di tutto in quel path effettivo, anche quando esistono altri componenti Lit piu evoluti nel modulo.

### 3. Web Component Lit (`map-picker-lit.js`)
Componente UI puro (Dumb Component):
- **Props**: `latitude`, `longitude`, `zoom`, `height`, `show-search`.
- **Events**: `location-changed`.
- **Public API**: `applyExternalLocation(loc)` aggiorna marker e vista senza emettere eventi (previene loop).

---

## Contratto Dati (API)

### Stato del Campo
```json
{
  "latitude": 41.9028,
  "longitude": 12.4964
}
```

### Evento `location-changed`
```javascript
detail: {
  latitude: number,
  longitude: number,
  source: 'click' | 'drag' | 'geolocation' | 'search' | 'external'
}
```

---

## Regole Operative Critiche

- **Niente `@entangle`**: Usare `$wire.$set` e `$wire.$watch` per controllo granulare.
- **Solo `XotBaseField`**: `MapPicker` deve continuare a estendere `Modules\Xot\Filament\Forms\Components\XotBaseField`.
- **Coordinate complete o geolocalizzazione**: se manca `latitude` o manca `longitude`, il componente non deve mantenere una coordinata vecchia e una nulla; deve tentare geolocalizzazione e valorizzare entrambe.
- **Shadow DOM**: Non usare `createRenderRoot() { return this; }`. L'isolamento è fondamentale.
- **ResizeObserver**: Fondamentale per Leaflet. Se il container ha altezza 0 (Wizard), posticipare l'init finché non diventa visibile.
- **Unified State**: Se il DB ha due colonne, la trasformazione deve avvenire in `afterStateHydrated` e `dehydrateStateUsing` nel consumer del field, mantenendo il field UI agnostico rispetto allo schema fisico.

## Guardrail DRY + KISS

- non introdurre sottogerarchie inutili tra picker per riusare una manciata di metodi;
- condividere logica tramite trait o helper piccoli, non cambiando la base class del field;
- se nasce un dubbio, l'audit parte sempre da `extends XotBaseField`.

---

## Troubleshooting v2

| Problema | Causa Probabile | Soluzione |
|----------|-----------------|-----------|
| Mappa grigia all'avvio | Init su container invisibile | Verificato: `map-picker-lit` ora attende visibilità via `ResizeObserver`. |
| Loop di aggiornamento | Evento UI → Livewire → Prop Lit → Evento UI | Verificato: `applyExternalLocation` non emette eventi. |
| Stili Leaflet rotti | Mancanza di CSS nel Shadow DOM | Assicurarsi che `map-picker-styles.js` importi correttamente gli stili necessari. |

---

## File di riferimento (v2)

- `laravel/Modules/Geo/app/Filament/Forms/Components/MapPicker.php`
- `laravel/Modules/Geo/resources/views/filament/forms/components/map-picker.blade.php`
- `laravel/Modules/Geo/resources/js/components/map-picker-lit.js`
- `laravel/Modules/Geo/resources/js/components/map-picker-styles.js`

---

*Aggiornato per LLM Wiki da Gemini Architect. Massima coerenza, zero duplicazione.*
