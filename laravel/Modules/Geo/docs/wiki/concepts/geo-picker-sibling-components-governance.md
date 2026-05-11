# Geo Picker Sibling Components Governance

## Regola

`CoordinatePicker`, `MapPicker`, `LocationPicker`, `LatitudeLongitudeInput`, `PlacePicker`, `MapPositioner`, `MapLocationInput`, `LeafletMarkerMapInput` e `GeopointPicker` sono componenti sibling del modulo Geo.

Possono condividere un trait comune, ad esempio `HasCoordinatePicker`, per configurazioni e contratti tecnici comuni, ma ciascun componente deve mantenere:

- classe PHP propria che estende `Modules\Xot\Filament\Forms\Components\XotBaseField`;
- Blade dedicata sotto `resources/views/filament/forms/components/`;
- Lit/Web Component JS dedicato sotto `resources/js/components/`, quando ha UI mappa propria;
- semantica pubblica coerente col proprio caso d'uso.

## Perche

La parte comune e reale: coordinate `{ latitude, longitude }`, zoom, center, marker, layer, geolocalizzazione esplicita, eventi `coords-changed`, bridge Livewire/Alpine, cleanup Leaflet.

La parte non comune e altrettanto reale: ogni picker parla a un consumer diverso e ha un contratto semantico diverso.

- `CoordinatePicker`: scelta generica di coordinate.
- `MapPicker`: compatibilita storica e integrazione in form esistenti.
- `LocationPicker`: linguaggio di localizzazione/posizione per UX.
- `LatitudeLongitudeInput`: input coordinate esplicito, non figlio di altri picker.
- `PlacePicker`: punto + place/address metadata.
- `MapPositioner`: posizionamento mappa come interazione primaria.
- `MapLocationInput`: input location orientato a form.
- `LeafletMarkerMapInput`: marker map specializzato.
- `GeopointPicker`: semantica geospaziale/geopoint.

Fondere questi componenti in un'unica classe con flag opzionali sembra DRY, ma produce coupling, branch UI, regressioni cross-component e test meno leggibili. Lo zen del modulo e: condividere il contratto tecnico minimo, non confondere le identita dei componenti.

## Trait comune

Il trait comune puo contenere solo cio che e invariabile tra sibling:

- colonne/stato coordinate;
- zoom, center, height;
- reverse geocoding flag/provider;
- normalizzazione coordinate;
- mapping esplicito verso `latitude` e `longitude`;
- naming eventi;
- helper per config serializzabile verso Blade.

Il trait non deve contenere:

- `$view` del componente;
- markup o path Blade;
- nome del custom element Lit;
- branching UI specifico del consumer;
- logica Leaflet concreta;
- assunzioni su Wizard, tema o pagina frontoffice.

## Blade e Lit separati

Ogni Blade resta separata perche il Blade e il contratto tra Filament field e UI concreta. Anche quando due Blade sembrano simili, tenerle separate evita path di stato impliciti, `if` crescenti basati sul nome del componente, regressioni in Wizard e contaminazione tra backoffice e frontoffice.

Ogni picker con UI mappa puo avere un Lit JS dedicato anche se attinge a helper/stili condivisi. Il JS dedicato preserva custom element name stabile, eventi compatibili, toolbar specifiche, test mirati e migrazioni progressive senza rompere consumer legacy.

## Anti-pattern

- `LatitudeLongitudeInput extends CoordinatePicker`.
- `MapPicker extends CoordinatePicker` solo per risparmiare righe.
- `CoordinatePicker extends Filament\Forms\Components\Field`.
- un unico Blade con `if ($field instanceof ...)` per tutti i picker.
- un unico Lit component con decine di flag di modalita.
- Leaflet montato con `id="map"` o `document.getElementById`.
- usare `@entangle` come scorciatoia in flussi mappa complessi.

## Checklist

Prima di modificare un picker Geo:

1. verificare che la classe estenda `XotBaseField`;
2. verificare che non estenda un picker sibling;
3. verificare che abbia `$view` dedicata;
4. verificare che la Blade non calcoli sibling path con string manipulation;
5. verificare che Leaflet usi classi locali;
6. verificare che il Lit JS sia UI-only;
7. spostare nel trait solo configurazione condivisa stabile;
8. aggiornare docs/wiki/log se emerge una nuova regola.

## Backlinks

- [map-picker-family-architecture](./map-picker-family-architecture.md)
- [latitudelongitudeinput-xotbasefield-rule](./latitudelongitudeinput-xotbasefield-rule.md)
- [leaflet-class-selector-governance](./leaflet-class-selector-governance.md)
- [mappicker-xotbasefield-rule](./mappicker-xotbasefield-rule.md)
