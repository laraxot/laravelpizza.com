# Story: MapPicker Filament v5 con Leaflet + Lit + Livewire su colonne latitude/longitude

## Status
Draft

## Priority
Alta

## Type
Refactor strutturale + hardening di custom field Geo

## Module
Geo

## Date
2026-04-17

---

## As A
sviluppatore che costruisce Resource Filament nel progetto

## I Want
un campo custom `MapPicker` riutilizzabile nel modulo `Geo`, basato su Leaflet e Web Component Lit, che lavori direttamente con due colonne reali `latitude` e `longitude`

## So That
possa integrare mappe interattive nelle Resource Filament v5 con stato coerente tra Web Component, Alpine, Livewire e database, senza JSON e senza duplicare logica geografica fuori dal modulo Geo.

---

## Executive Intent

Questa story non parte da zero: nel modulo `Geo` esiste già una prima implementazione di `MapPicker`, ma non è ancora allineata ai vincoli richiesti.

### Stato attuale verificato

- Esiste la classe [MapPicker.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/app/Filament/Forms/Components/MapPicker.php).
- Esiste la view [map-picker.blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/views/filament/forms/components/map-picker.blade.php).
- Esiste già anche una linea parallela `LatitudeLongitudeInput` / `LeafletMarkerMapInput` con pattern Livewire/Leaflet/Lit:
  - [LatitudeLongitudeInput.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/app/Filament/Forms/Components/LatitudeLongitudeInput.php)
  - [LeafletMarkerMapInput.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/app/Filament/Forms/Components/LeafletMarkerMapInput.php)
  - [latitude-longitude-input-lit.blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input-lit.blade.php)
  - [my-map-lit.js](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/js/components/my-map-lit.js)

### Gap reali da correggere

L’implementazione attuale di `MapPicker` è insufficiente rispetto ai requisiti:

- usa **CDN** per Leaflet e Lit;
- dichiara il Web Component Lit **inline nella Blade**;
- contiene fetch di reverse geocoding direttamente nel template;
- non formalizza abbastanza il protocollo `Alpine ↔ Lit ↔ Livewire`;
- non documenta chiaramente il binding a **due colonne vere** `latitude` / `longitude`;
- non mostra un design chiaro per invalidazione visuale, fullscreen e `invalidateSize()`;
- non separa bene asset, stato, renderer, integrazione Field e servizi opzionali.

Questa story deve portare `MapPicker` allo stato richiesto, consolidando i pattern utili già presenti nel modulo Geo e rimuovendo i punti architetturalmente deboli.

---

## Verified Repo Findings

### Componenti esistenti rilevanti

1. `MapPicker` esiste già come `XotBaseField` e supporta:
- `latitude(string $field)`
- `longitude(string $field)`
- `defaultLocation(float $latitude, float $longitude)`
- `zoom(int $zoom)`
- `height(string $height)`
- `autocompleteVisible(bool $visible = true)`

2. La Blade corrente `map-picker.blade.php`:
- usa `@entangle(...).live` per `lat` e `lng`;
- monta `<map-picker-lit>`;
- mostra input visibili;
- ha stato Alpine basilare;
- integra geolocalizzazione, fullscreen e switch layer;
- ma usa asset da CDN e definizione Lit inline.

3. `LatitudeLongitudeInput` ha già documentazione esplicita su:
- sync non distruttiva;
- `wire:model.change`;
- protezione con `wire:ignore`;
- bridge field ↔ Web Component;
- pattern di throttling e anti-loop.

4. `my-map-lit.js` dimostra che nel modulo esiste già una prova concreta di Web Component Lit + Leaflet con:
- marker draggable;
- click su mappa;
- dispatch evento custom;
- `invalidateSize`;
- cleanup in `disconnectedCallback`.

### Implicazione

La soluzione finale deve **riusare e consolidare** questi pattern, non inventarne un terzo incoerente.

---

## Non-Negotiable Constraints

- Il campo si chiama **`MapPicker`**.
- Deve vivere **solo nel modulo `Geo`**.
- Deve essere usabile nelle Resource con sintassi:

```php
MapPicker::make('location_map')
    ->latitude('latitude')
    ->longitude('longitude')
```

- Non deve persistere un payload JSON.
- Deve lavorare con due colonne reali del database:
  - `latitude`
  - `longitude`
- Il Web Component deve essere **Lit**, isolato e riutilizzabile.
- Il motore mappa deve essere **Leaflet**.
- Deve integrarsi con **Livewire** e **Alpine** già presenti nel progetto.
- Deve usare **entangle separato** per latitude e longitude.
- Se `latitude` e `longitude` sono `null`, deve tentare geolocalizzazione browser per inizializzare marker e center.
- Il marker deve essere **draggable**.
- Lo spostamento marker deve aggiornare:
  - stato Lit;
  - stato Alpine;
  - input visibili;
  - binding Livewire.
- Nessun loop o desincronizzazione tra questi layer.
- Deve supportare **fullscreen toggle** con gestione corretta di `invalidateSize()`.
- Deve supportare almeno due base layer:
  - stradale
  - satellitare o equivalente compatibile Leaflet
- Niente CDN.
- Niente contaminazione di altri moduli o temi.
- Il lavoro non è chiuso finché non passano:
  - PHPStan
  - PHPMD
  - PHP Insights
  - Pest

---

## Architecture Guardrails

### PHP / Filament

- `MapPicker` deve continuare a essere un campo Filament nel namespace:
  - `Modules\Geo\Filament\Forms\Components\MapPicker`
- Deve estendere il wrapper del progetto, non il base field Filament puro se il wrapper è già previsto:
  - `XotBaseField`
- La classe PHP deve governare solo:
  - nomi dei campi lat/lng;
  - config iniziale;
  - view;
  - feature flags UI;
  - eventuali endpoint/config di reverse geocoding.

### Blade / Alpine

- Alpine deve essere solo orchestratore:
  - riceve entangle separati;
  - ascolta eventi custom del Web Component;
  - inoltra aggiornamenti al Web Component quando Livewire cambia;
  - gestisce indicatori visuali e stato error/loading.
- La Blade non deve contenere classi Lit o logica Leaflet estesa inline.
- La Blade non deve diventare un mini framework.

### Lit Web Component

- Il Web Component deve incapsulare:
  - init Leaflet;
  - base layers;
  - marker draggable;
  - geolocalizzazione browser iniziale;
  - fullscreen;
  - `invalidateSize()`;
  - dispatch evento `coords-changed`.
- Il Web Component non deve conoscere Livewire direttamente.
- Il Web Component comunica solo via:
  - properties/attributes;
  - custom events.

### Reverse geocoding

- Il reverse geocoding è **opzionale** ma richiesto come possibile miglioramento.
- Se implementato, va progettato come componente separabile:
  - niente fetch hardcoded nel template;
  - niente coupling diretto con il renderer Leaflet;
  - preferibile action/endpoint Geo o adapter JS documentato.
- I servizi suggeriti, coerenti con il requisito, sono:
  - Nominatim
  - Photon
- Ogni uso deve rispettare limiti, user-agent e policy del provider.

---

## Required Outcome

L’implementazione finale deve produrre almeno:

1. Un `MapPicker` Filament v5 realmente riutilizzabile.
2. Un Web Component Lit dedicato, spostato fuori dalla Blade.
3. Una Blade di integrazione pulita.
4. Un bridge chiaro Alpine ↔ Lit ↔ Livewire.
5. Supporto a due colonne reali `latitude` / `longitude`.
6. Marker draggable con sync bidirezionale stabile.
7. Geolocalizzazione iniziale quando i valori sono `null`.
8. Fullscreen + `invalidateSize`.
9. Layer stradale / satellitare.
10. Feedback visuale inline per validità coordinate.
11. Test Pest lato PHP.
12. Documentazione modulo aggiornata.

---

## Acceptance Criteria

- [ ] `MapPicker` esiste nel modulo `Geo` ed è il campo standard da usare nelle Resource per coordinate su due colonne reali.
- [ ] La sintassi supportata include `MapPicker::make(...)->latitude(...)->longitude(...)`.
- [ ] Il campo non salva un JSON e non richiede uno state object persistito.
- [ ] Il campo lavora su due colonne reali `latitude` e `longitude`.
- [ ] Il componente usa Leaflet senza CDN.
- [ ] Il Web Component usa Lit senza CDN.
- [ ] La definizione del Web Component Lit non vive inline nella Blade finale.
- [ ] Alpine usa `@entangle(...).live` separato per latitudine e longitudine.
- [ ] Il marker è draggable.
- [ ] Il drag del marker aggiorna in tempo reale input visibili, Alpine e Livewire.
- [ ] Il click sulla mappa aggiorna marker e coordinate.
- [ ] Se i valori iniziali sono `null`, il componente tenta geolocalizzazione browser.
- [ ] La geolocalizzazione iniziale non crea loop o doppie inizializzazioni.
- [ ] Il Web Component dispatcha `coords-changed`.
- [ ] Alpine ascolta `coords-changed` e sincronizza lo stato.
- [ ] Quando Livewire/Alpine cambiano coordinate, il Web Component si aggiorna senza re-inizializzare la mappa.
- [ ] Esiste fullscreen toggle funzionante.
- [ ] In ingresso/uscita da fullscreen Leaflet riceve `invalidateSize()` correttamente.
- [ ] Esistono almeno due base layer switchabili: stradale e satellitare/equivalente.
- [ ] Gli input mostrano feedback inline di validità/errore.
- [ ] Se viene implementato reverse geocoding, è modulare e basato su servizi OSM-compatibili verificati.
- [ ] PHPStan passa.
- [ ] PHPMD passa.
- [ ] PHP Insights passa.
- [ ] Pest passa.

---

## Recommended Refactor Strategy

### 1. Consolidare il campo esistente invece di duplicarlo

Target principale:

- [MapPicker.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/app/Filament/Forms/Components/MapPicker.php)
- [map-picker.blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/views/filament/forms/components/map-picker.blade.php)

La story deve trasformare questi file in implementazione production-grade invece di creare un secondo `MapPicker`.

### 2. Estrarre il Web Component Lit dalla Blade

Candidate files:

- `laravel/Modules/Geo/resources/js/components/map-picker-lit.ts`
- oppure `laravel/Modules/Geo/resources/js/components/maps/map-picker.element.ts`

Obiettivo:

- niente `<script type="module">` lungo dentro la Blade;
- niente import da `cdn.jsdelivr` o `unpkg`.

### 3. Estrarre bridge/event protocol

Se necessario:

- `laravel/Modules/Geo/resources/js/components/maps/map-picker-bridge.ts`
- oppure script minimo inline solo per boot/hydration, con logica vera altrove.

### 4. Valutare riuso del pattern `LatitudeLongitudeInput`

Da studiare e riusare:

- protezione da update programmatici;
- anti-loop;
- watcher input ↔ component;
- gestione `wire:ignore`;
- convenzioni `wire:model.change` o `entangle.live`.

---

## Data Contract Guidance

Il campo `MapPicker` deve essere pensato come **field shell non-dehydrated**, ma con binding esplicito a due sibling field reali.

### API PHP desiderata

```php
MapPicker::make('location_map')
    ->latitude('latitude')
    ->longitude('longitude')
    ->defaultLocation(41.9028, 12.4964)
    ->zoom(13)
    ->height('400px')
```

### Alpine state minimo desiderato

```js
{
  lat: @entangle($latPath).live,
  lng: @entangle($lngPath).live,
  isSyncingFromComponent: false,
  isSyncingToComponent: false,
  validationState: {
    latitude: null,
    longitude: null,
  },
}
```

### Event contract Web Component

Evento custom:

```js
new CustomEvent('coords-changed', {
  detail: {
    lat: number,
    lng: number,
    source: 'drag' | 'click' | 'geolocation' | 'external',
  },
  bubbles: true,
  composed: true,
})
```

Il campo Alpine deve consumare questo evento e decidere come sincronizzare Livewire senza loop.

---

## Sync Rules

### Source of truth

La story deve imporre chiaramente la priorità delle sorgenti:

1. valori utente da marker drag/click;
2. valori iniziali Livewire se presenti;
3. geolocalizzazione browser se entrambi null;
4. default statico solo come fallback finale.

### Anti-loop rules

- Quando il Web Component emette `coords-changed`, Alpine aggiorna `lat` e `lng`.
- Quando `lat`/`lng` cambiano via entangle, Alpine aggiorna il Web Component solo se il delta è reale.
- Le modifiche programmatiche devono usare guard flag per evitare ping-pong.
- Non re-inizializzare la mappa per un semplice cambio proprietà.

---

## UI / UX Requirements

- Input `latitude` e `longitude` sempre visibili.
- Stato visuale inline:
  - valido;
  - warning;
  - errore.
- Feedback immediato quando coordinate mancanti/non valide.
- Pulsante fullscreen.
- Pulsante geolocalizzazione.
- Switch layer base.
- Eventuale testo secondario con indirizzo reverse-geocoded se disponibile.

### Error states da prevedere

- geolocation non supportata;
- permesso negato;
- coordinate fuori range;
- tile layer non disponibile;
- reverse geocoding fallito.

---

## Tile / Provider Rules

- Base layer stradale: OpenStreetMap standard è accettabile.
- Base layer satellitare: provider equivalente compatibile con Leaflet, con attribution corretta.
- Attribuzione provider sempre presente.
- Nessun provider lock-in proprietario se non già verificato/documentato.

---

## Reverse Geocoding Guidance

Il requisito lo descrive come opzionale ma consigliato. La story deve prevedere due modalità:

### Modalità A
solo coordinate + indicatori validità, senza reverse geocoding.

### Modalità B
reverse geocoding opzionale con servizio OSM-based:

- Nominatim
- Photon

Se si implementa B:

- usare endpoint/config governati dal modulo `Geo`;
- rispettare rate limits e policy d’uso;
- evitare fetch continuo a ogni pixel di drag;
- usare trigger sensato, ad esempio `dragend`, click o debounce consistente.

---

## Recommended File Targets

### PHP

- `laravel/Modules/Geo/app/Filament/Forms/Components/MapPicker.php`

### Blade

- `laravel/Modules/Geo/resources/views/filament/forms/components/map-picker.blade.php`

### Frontend

- `laravel/Modules/Geo/resources/js/components/map-picker-lit.ts`
- oppure:
  - `laravel/Modules/Geo/resources/js/components/maps/map-picker.element.ts`
  - `laravel/Modules/Geo/resources/js/components/maps/map-picker-controller.ts`

### Optional backend support

- `laravel/Modules/Geo/app/Actions/Geocoding/ReverseGeocodeCoordinatesAction.php`
- `laravel/Modules/Geo/app/Datas/Geocoding/ReverseGeocodeResultData.php`

### Tests

- `laravel/Modules/Geo/tests/Feature/Filament/MapPickerFieldTest.php`
- `laravel/Modules/Geo/tests/Unit/Filament/Forms/Components/MapPickerTest.php`
- eventuali test action reverse geocoding se introdotta.

### Docs

- `laravel/Modules/Geo/docs/map-picker.md`
- aggiornamento di:
  - `laravel/Modules/Geo/docs/filament-forms-components.md`
  - `laravel/Modules/Geo/docs/LIT-MAP-IMPLEMENTATION.md`

---

## Testing Guidance

### Pest

Copertura minima lato PHP:

- `MapPicker::make()` costruisce il field correttamente;
- `latitude()` e `longitude()` configurano i field names corretti;
- `defaultLocation()`, `zoom()`, `height()` funzionano;
- view name corretto;
- configurazioni opzionali non rompono il contract.

### Visual/manual verification

1. Montare il field in una Resource di test del modulo Geo.
2. Aprire form create/edit.
3. Verificare inizializzazione con valori presenti.
4. Verificare inizializzazione con valori null.
5. Spostare marker.
6. Controllare sync di input.
7. Controllare sync Livewire.
8. Entrare/uscire fullscreen.
9. Cambiare layer base.
10. Verificare assenza di desincronizzazioni.

---

## Quality Gates

Eseguire e far passare:

```bash
./vendor/bin/pest
./vendor/bin/phpstan analyse
./vendor/bin/phpmd laravel/Modules/Geo text laravel/Modules/Geo/phpmd.ruleset.xml
./vendor/bin/phpinsights --no-interaction --ansi
```

Se nel repository i comandi effettivi differiscono, usare gli equivalenti reali e documentarli nel report finale.

---

## Anti-Goals

- Non creare un nuovo campo parallelo a `MapPicker`.
- Non lasciare il Web Component Lit inline nella Blade.
- Non usare CDN.
- Non reintrodurre JSON come storage coordinate.
- Non usare un unico state path annidato come shape persistita se il requisito è due colonne reali.
- Non accoppiare direttamente Lit a Livewire.
- Non mettere logica di reverse geocoding hardcoded nella view.
- Non spostare codice in temi o moduli estranei.

---

## Definition Of Done

La story è completa solo se:

- `MapPicker` è production-grade e riutilizzabile;
- il bridge `Alpine ↔ Lit ↔ Livewire` è stabile e documentato;
- il field usa due colonne reali `latitude` / `longitude`;
- niente CDN;
- fullscreen e resize Leaflet funzionano;
- i base layer funzionano;
- eventuale reverse geocoding è modulare;
- test e quality gates passano;
- documentazione modulo aggiornata.

---

## Source References

### Repo locale

- [MapPicker.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/app/Filament/Forms/Components/MapPicker.php)
- [map-picker.blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/views/filament/forms/components/map-picker.blade.php)
- [LatitudeLongitudeInput.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/app/Filament/Forms/Components/LatitudeLongitudeInput.php)
- [LeafletMarkerMapInput.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/app/Filament/Forms/Components/LeafletMarkerMapInput.php)
- [latitude-longitude-input-lit.blade.php](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/views/filament/forms/components/latitude-longitude-input-lit.blade.php)
- [my-map-lit.js](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/js/components/my-map-lit.js)
- [filament-forms-components.md](/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/docs/filament-forms-components.md)

### Standard tecnici

- Leaflet docs: `https://leafletjs.com/reference.html`
- Lit docs: `https://lit.dev/docs/components/overview/`

### Provider suggeriti dal requisito

- Nominatim
- Photon
