# Coordinate Picker Wizard Shadow DOM Rule

## Regola

Nei wizard Filament/Livewire, `coordinate-picker-lit` deve possedere il proprio DOM interno in modo stabile anche quando lo step viene mostrato dopo una transizione.

Il false friend osservato:

- `coordinate-picker-lit` e' presente nel DOM;
- ha altezza e `display: block`;
- ma non esiste `.leaflet-container`.

Questo significa che il custom element e' visibile, ma Leaflet non e' inizializzato.

## Causa

Il componente usava Light DOM (`createRenderRoot() { return this; }`). Nel contesto Livewire + Alpine + Filament wizard, il nodo host puo' restare visibile mentre il rendering interno non produce il pane Leaflet atteso.

## Best practice

- Usare il render root del componente per il DOM interno.
- Cercare il pane con `this.renderRoot.querySelector(...)`.
- Passare oggetti Alpine a web component come proprieta', non come attributi stringificati:

```blade
<coordinate-picker-lit x-bind:state.prop="state" ...></coordinate-picker-lit>
```

## Bad practice

```blade
<coordinate-picker-lit :state="state"></coordinate-picker-lit>
```

Questo puo' produrre attributi tipo `state="[object Object]"` invece di una property JS coerente.

## Verifica

Dopo click su "Avanti":

- `customElements.get('coordinate-picker-lit')` deve esistere;
- `coordinate-picker-lit.shadowRoot` deve avere contenuto;
- `.leaflet-container` deve avere width/height > 0;
- devono esserci tile Leaflet caricati.

