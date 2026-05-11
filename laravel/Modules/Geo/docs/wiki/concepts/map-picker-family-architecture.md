# Map Picker Family Architecture

## Obiettivo

Allineare `CoordinatePicker`, `MapPicker`, `LocationPicker`, `LatitudeLongitudeInput`, `PlacePicker`, `MapPositioner`, `MapLocationInput`, `LeafletMarkerMapInput` e `GeopointPicker` a un contratto tecnico comune:

- coordinate espresse come `{ latitude, longitude }`
- bridge Alpine minimale verso Livewire v4 (`$wire.$watch`, `$wire.$set(..., false)`)
- web components Lit UI-only senza conoscenza Filament/Livewire
- eventi mappa semantici e coerenti (`coords-changed`)

## Filosofia sibling + trait

I picker Geo hanno parti comuni e devono attingere a un trait comune, ad esempio `HasCoordinatePicker`, per configurazione condivisa, normalizzazione coordinate, mapping e opzioni ricorrenti.

Questo non autorizza ereditarieta tra picker sibling. Ogni picker mantiene:

- classe PHP propria che estende `XotBaseField`;
- Blade dedicata;
- Lit JS dedicato o custom element dedicato;
- nome pubblico e semantica coerenti col proprio caso d'uso.

La regola e DRY senza cancellare i confini: riusare il contratto, non fondere i componenti.

## Contratto eventi condiviso

Tutti i picker Lit devono emettere (direttamente o in compatibilita):

```js
new CustomEvent('coords-changed', {
  detail: { latitude: number, longitude: number },
  bubbles: true,
  composed: true,
})
```

Per retrocompatibilita, `map-picker-lit` mantiene anche `location-changed`.

## Controlli UX minimi obbligatori

Ogni mappa operativa deve avere:

- toggle modalita espansa/fullscreen
- azione esplicita "usa posizione corrente"
- marker draggable con aggiornamento coordinate al `dragend` (no spam di update)

## Sincronizzazione Livewire — Bridge Alpine canonico (story 8-43)

**Pattern obbligatorio** (sostituisce qualsiasi uso di `wire:entangle`):

```js
x-data="{
    _lat: @json($initLat),
    _lng: @json($initLng),
    _suppressUpdate: false,

    init() {
        this.$wire.$watch('{{ $statePath }}', (val) => {
            if (this._suppressUpdate) return;
            this._lat = val?.latitude ?? null;
            this._lng = val?.longitude ?? null;
        });
    },

    handleCoordsChanged(event) {
        const { latitude, longitude } = event.detail;
        this._suppressUpdate = true;
        this._lat = latitude;
        this._lng = longitude;
        this.$wire.$set('{{ $statePath }}', { latitude, longitude });
        setTimeout(() => { this._suppressUpdate = false; }, 350);
    }
}"
```

Regole:
- `wire:entangle` è vietato — causa echo loop bidirezionali
- `_suppressUpdate` + `setTimeout(350ms)` rompe l'echo server→client
- `$wire.$set(path, val)` con Livewire v3 (prefisso `$` obbligatorio)
- aggiornamenti verso backend solo in momenti utili (`click`, `dragend`, geoloc confermata)

## Isolamento `dehydrated(false)` (story 8-43)

`dehydrated(false)` deve essere chiamato esplicitamente da ogni classe composita, **non** dal trait:

```
HasCoordinatePicker::setUpCoordinatePicker()   ← NON chiama dehydrated(false)
CoordinatePicker::setUp()                      ← chiama $this->dehydrated(false) esplicitamente
MapPicker::setUp()                             ← chiama $this->dehydrated(false) esplicitamente
LatitudeLongitudeInput::setUp()                ← NON chiama dehydrated (field diretto)
```

## Nota su Light DOM / Shadow DOM

- `coordinate-picker-field` e `place-picker-field` usano Light DOM intenzionale per compatibilita Leaflet CSS/controls.
- `map-picker-lit` mantiene compatibilita storica con il suo asset/stile attuale, ma espone ora `coords-changed` per convergenza del bridge.

## Riferimenti

- [coordinate-picker-field](./coordinate-picker-field.md)
- [geo-picker-sibling-components-governance](./geo-picker-sibling-components-governance.md)
- [map-picker-runtime-asset-governance](./map-picker-runtime-asset-governance.md)
- [map-picker-locationpicker-architecture](./map-picker-locationpicker-architecture.md)
