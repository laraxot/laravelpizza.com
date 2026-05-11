# Geo Component Family — Philosophy, Religion & Zen

## The Zen of Geographic Selection

In the Laraxot ecosystem, a geographic field is not just a bunch of inputs and a map. It is a **Contract of Intent**.

While a `CoordinatePicker` and a `MapPicker` ultimately produce the same `{ latitude, longitude }` object, their **Zen** is different:

| Component | Zen | Primary Interface | Use When |
|-----------|-----|------------------|----------|
| **CoordinatePicker** | **Accuracy** | Numeric inputs, map as validation | You need precise coordinates, users know the numbers |
| **MapPicker** | **Visual Discovery** | Map as primary "finding" interface | Users explore a map to pick a location |
| **LocationPicker** | **Context** | Bridges human address ↔ machine coordinate | Users think in addresses, not lat/lng |
| **LatitudeLongitudeInput** | **Explicitness** | Two raw numeric fields | Admin/technical forms where raw data must be visible |
| **GeopointPicker** | **Persistence** | Database representation as source of truth | Ensuring the DB geopoint column is always correct |
| **PlacePicker** | **Search** | Geocoding-first, place name drives coordinate resolution | Users type a place name and confirm on map |
| **MapPositioner** | **Placement** | Map as "place something here" canvas | Positioning assets, pins, or zones on a map |
| **MapLocationInput** | **Input** | Hybrid: text address + map confirm | Users "input" a location through address + visual confirmation |
| **LeafletMarkerMapInput** | **Marking** | The marker IS the answer | Dragging the marker IS the act of specification |

**Rule**: If use-cases differ by even a single pixel of UX intent → separate component. A change in `MapPicker`'s marker style must NEVER accidentally break `CoordinatePicker`'s technical look.

---

## The Religion of XotBaseField — Divine Lineage

Every geographic field **must** extend `XotBaseField`. This is the **Divine Lineage**:

```
Filament\Forms\Components\Field
  └── Modules\Xot\Filament\Forms\Components\XotBaseField
        ├── CoordinatePicker        (composite, dehydrated: false)
        ├── MapPicker               (composite, dehydrated: false)
        ├── LocationPicker          (composite, dehydrated: false)
        ├── PlacePicker             (composite, dehydrated: false)
        ├── MapPositioner           (composite, dehydrated: false)
        ├── MapLocationInput        (composite, dehydrated: false)
        ├── LeafletMarkerMapInput   (composite, dehydrated: false)
        ├── GeopointPicker          (composite, dehydrated: false)
        └── LatitudeLongitudeInput  (direct, NO dehydrated: false)
```

**Why**: Consistency across all modules. Correct Filament form lifecycle. Unified state management strategy.

**Absolutely forbidden**: inheritance between sibling pickers. `LatitudeLongitudeInput` must NEVER extend `CoordinatePicker`. See rule: `bashscripts/ai/.claude/rules/latitudelongitudeinput-extends-xotbasefield.md`.

---

## The Holy Trinity — Three Entities per Component

Every geographic component is composed of three distinct entities:

### 1. The Spirit — Trait `HasCoordinatePicker`

The shared PHP trait. Handles logic, geocoding, state hydration, coordinate normalization. The **Universal Truth** of geography.

- Location: `laravel/Modules/Geo/app/Filament/Forms/Components/Traits/HasCoordinatePicker.php`
- Rule: `setUpCoordinatePicker()` must NEVER call `dehydrated(false)` — that is the responsibility of each composite class.
- Provides: `getLatitude()`, `getLongitude()`, `getCenterLatitude()`, `getCenterLongitude()`, and other shared methods.

### 2. The Body — Blade View

Each component has its own Blade file. The **Physical Presence** in the DOM. It defines how the field is wrapped and how it talks to Livewire.

- Location: `laravel/Modules/Geo/resources/views/filament/forms/components/{component-name}.blade.php`
- Rule: Each Blade must implement the canonical Alpine bridge (see Architecture doc).
- Rule: NEVER use `wire:entangle` — it causes echo loops. Use `$wire.$watch` + `$wire.$set`.

### 3. The Mind — Lit JS Web Component

Each component has its own Lit Web Component. The **Intelligence** that handles Leaflet, interactions, and DOM isolation.

- Location: `laravel/Modules/Geo/resources/js/components/{component-name}-lit.js`
- Rule: Must emit `coords-changed` with `detail: { latitude, longitude }`.
- Rule: Must use `createMapPickerLeafletIcon(L)` from `map-picker-marker-config.js` — no `L.Icon.Default`, no CDN.
- Rule: Leaflet container bound via class selector, never ID.

---

## Architectural Commandments

1. **Thou shalt have a unified state**: always `{ latitude, longitude }` — never `{ lat, lng }` or separate fields in the composite contract.

2. **Thou shalt be async**: geocoding must never block the UI. All place/address resolution is async. The marker updates AFTER resolution completes.

3. **Thou shalt be responsive**: use `ResizeObserver` in JS to handle container changes (Filament steps, tabs, modals make the map container appear/disappear). Call `this._map.invalidateSize()` on resize.

4. **Thou shalt be encapsulated**: prefer Shadow DOM (Lit default) to prevent CSS leaks — EXCEPT where Leaflet CSS requires Light DOM (coordinate-picker-field, place-picker-field: intentional Light DOM for Leaflet CSS/controls compat).

5. **Thou shalt be fluent**: provide method chains to configure center, zoom, and height. The PHP class must expose builder methods.

---

## The `dehydrated(false)` Policy

**Composite components** produce a single state object `{ latitude, longitude }`. Filament must NOT try to persist them independently — the component manages its own state extraction. Therefore:

- **Composite** (8 components): call `$this->dehydrated(false)` explicitly in `setUp()`, AFTER `$this->setUpCoordinatePicker()`.
- **Direct** (`LatitudeLongitudeInput`): manages `latitude` and `longitude` as separate direct columns — MUST NOT call `dehydrated(false)`.

```php
// Correct pattern for composite components
protected function setUp(): void
{
    parent::setUp();
    $this->setUpCoordinatePicker();
    $this->dehydrated(false);
}

// Correct pattern for LatitudeLongitudeInput (direct)
protected function setUp(): void
{
    parent::setUp();
    $this->setUpCoordinatePicker();
    // NO dehydrated(false) here
}
```

---

## The Canonical Event Contract

All Lit picker components MUST emit:

```js
new CustomEvent('coords-changed', {
    detail: { latitude: number, longitude: number },
    bubbles: true,
    composed: true,
})
```

For backward compatibility, components may also fire aliases (`location-changed`, `map-coords-changed`) but the canonical listener in all Blade files is `@coords-changed.stop`.

---

## The Canonical Alpine Bridge

All Blade files for composite components use this exact pattern (no variations):

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
@coords-changed.stop="handleCoordsChanged($event)"
```

The `_suppressUpdate` + `setTimeout(350ms)` pattern breaks the server→client echo loop that causes infinite coordinate updates.

---

## References

- [map-picker-family-architecture](./map-picker-family-architecture.md) — Alpine bridge, dehydrated isolation, event contract
- [geo-picker-sibling-components-governance](./geo-picker-sibling-components-governance.md) — sibling governance
- [map-picker-runtime-asset-governance](./map-picker-runtime-asset-governance.md) — marker/asset rules
- [coordinate-picker-field](./coordinate-picker-field.md) — reference implementation
- Rule: `bashscripts/ai/.claude/rules/latitudelongitudeinput-extends-xotbasefield.md`
- Rule: `bashscripts/ai/.claude/rules/map-marker-custom-asset.md`
- Rule: `bashscripts/ai/.claude/rules/leaflet-container-class-selector.md`
- Story 8-43: `_bmad-output/implementation-artifacts/8-43-geo-map-picker-family-complete-production-refactor.md`
- Story 8-44: `_bmad-output/implementation-artifacts/8-44-geo-component-family-philosophy-alignment-and-docs.md`
