# Geo Module — Filament Forms Components

## Overview

Il modulo Geo fornisce **componenti Filament form** per tutte le esigenze di geolocalizzazione. Ogni componente si integra nativamente con il sistema di form di Filament, Livewire state, e validazione.

## Componenti Disponibili

### 1. AddressInput

**Tipo**: Filament Field (`extends Field`)
**Path**: `app/Filament/Forms/Components/AddressInput.php`
**View**: `resources/views/filament/forms/components/address-input.blade.php`

Campo indirizzo singolo con pulsante "Usa la tua posizione" che usa il browser geolocation API.

**Usage**:
```php
use Modules\Geo\Filament\Forms\Components\AddressInput;

AddressInput::make('address')
    ->label('Indirizzo')
    ->placeholder('Via Roma 1, Milano')
    ->required()
    ->maxLength(255)
    ->spritePath('/themes/Sixteen/design-comuni/assets/bootstrap-italia/dist/svg/sprites.svg'),
```

**Features**:
- ✅ Browser geolocation (`navigator.geolocation.getCurrentPosition()`)
- ✅ Reverse geocoding via Nominatim (OSM, gratuito, no API key)
- ✅ Livewire state binding nativo (`$statePath`)
- ✅ Loading state durante geolocalizzazione
- ✅ Error handling (permission denied, not supported)
- ✅ Validazione Filament standard

### 2. AddressSection

**Tipo**: Filament Section (`extends Section`)
**Path**: `app/Filament/Forms/Components/AddressSection.php`

Sezione con campi indirizzo separati: via, numero civico, città, CAP, provincia, paese.

**Usage**:
```php
use Modules\Geo\Filament\Forms\Components\AddressSection;

AddressSection::make('address')
    ->label('Indirizzo')
    ->columns(2)
    ->schema([
        // Campi personalizzati se necessario
    ]),
```

**Fields inclusi**:
- `street` — Via/piazza
- `number` — Numero civico
- `city` — Città
- `postal_code` — CAP
- `province` — Provincia
- `country` — Paese
- `notes` — Note aggiuntive

### 3. LatitudeLongitudeInput

**Tipo**: Filament Field
**Path**: `app/Filament/Forms/Components/LatitudeLongitudeInput.php`
**View default**: `resources/views/filament/forms/components/latitude-longitude-input.blade.php`
**View Lit**: `resources/views/filament/forms/components/latitude-longitude-input-lit.blade.php`

Coppia di input numerici annidati nello stato del field (schema interno `latitude` / `longitude`) con **mappa Leaflet integrata**, marker trascinabile, geolocalizzazione, fullscreen e **sincronizzazione bidirezionale non-distruttiva** input ↔ mappa ↔ Livewire.

**Regola runtime (Anti-Regressione)**:
- ✅ Marker, center mappa e input devono essere sempre allineati
- ✅ Il drag del marker NON genera refresh/re-render distruttivi della shell
- ✅ Sync continuo resta **locale** durante drag (DOM only), persistenza Livewire su dragend
- ✅ Gli input usano `wire:model.change` (non `.live`) per evitare aggressione Livewire
- ✅ Commitare coordinate via change event, non via `wire.set()` diretto
- ✅ Idempotenza: inizializzazione riveduta non duplica istanze o DOM
- ✅ Stato iniziale: Livewire state ha precedenza su default center

**Sincronizzazione Bidirezionale**:

#### Marker → Inputs → Livewire
1. **drag**: Aggiorna `currentLat`/`currentLng` in memoria, throttle setInputValues() ogni ~200ms (DOM only)
2. **dragend**: Chiama `setInputValues()` per aggiornare DOM, poi `commitCoordinates()` che dispatches change event
3. **change event**: Attiva `wire:model.change` per sincronizzare a Livewire

#### Map Click / Geolocation → Livewire
1. Aggiorna marker position
2. Chiama `setInputValues()` + `commitCoordinates()`
3. Stesso flusso di dragend

#### Inputs → Marker → Center Map
1. **input event**: Throttle syncMapFromInputs() ogni ~160ms (preview, no commit)
2. **change event**: syncMapFromInputs(true) ricalcola posizione, recentra mappa, commit
3. `wire:model.change` si attiva automaticamente dal browser form submission

**Usage**:
```php
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;

LatitudeLongitudeInput::make('location')
    ->hiddenLabel()
    ->defaultCenter(41.9028, 12.4964)  // Roma
    ->defaultZoom(13)
    ->mapHeight('340px')
    ->showMap(true),
```

**Renderer Selection**:
```php
LatitudeLongitudeInput::make('location')
    ->jsFramework('lit')
    ->defaultCenter(41.9028, 12.4964)
    ->defaultZoom(13)
    ->mapHeight('340px');
```

**Regola**:
- `blade` resta il renderer di default e mantiene il percorso legacy Blade/Alpine
- `lit` è opt-in esplicito e usa un Web Component dedicato
- Filament/PHP resta il layer di governo del field; il renderer JS cambia solo la UI
- valori supportati: `blade`, `lit`

**Data Structure** (Livewire state):
```php
'location' => [
    'latitude' => 41.9028,
    'longitude' => 12.4964,
]
```

**Protocollo Tecnico**:
- `wire:ignore` protegge la shell mappa da Livewire re-renders
- Global instance registry (`window.geoMapInstances`) previene duplicazioni
- `isProgrammaticInputUpdate` flag previene sync circolare durante updates JS
- Throttling (200ms drag, 160ms input) riduce DOM thrashing
- Non usiamo `wire.set()` diretto — usiamo change event per attivare `wire:model.change`

**Variante Lit**:
- la Blade Lit monta `<my-map>` come Web Component
- il bridge dati resta nel field: input Filament con `wire:model.change` + sync bidirezionale `inputs ↔ my-map`
- la variante Lit oggi copre il contract dati del field senza replicare integralmente tutti i controlli UX del renderer legacy

### 4. LeafletMarkerMapInput

**Tipo**: Filament Field
**Path**: `app/Filament/Forms/Components/LeafletMarkerMapInput.php`
**View**: `resources/views/filament/forms/components/leaflet-marker-map-input.blade.php`

Mappa Leaflet (tile OpenStreetMap, pattern ispirato a mappe civiche tipo [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu): OSM, UX chiara, niente lock-in) con marker trascinabile, controlli in overlay (posizione corrente, schermo intero) e aggiornamento lat/lng sullo stato Livewire. Il campo mappa è `dehydrated(false)`; invece di persistere direttamente nello stato del form, aggiorna automaticamente due campi sibling configurati (di default `latitude` e `longitude`) nello stesso scope dello schema.

Per il flusso wizard segnalazione in Fixcity vedi anche [story wizard mappa](../../Fixcity/docs/stories/wizard-leaflet-map-controls.md).

**Usage Approaches**:

#### Approach 1: Automatic Sibling Field Binding (Recommended)
Il componente aggiorna automaticamente i campi sibling `latitude` e `longitude` quando l'utente interagisce con la mappa:
```php
use Modules\Geo\Filament\Forms\Components\LeafletMarkerMapInput;

LeafletMarkerMapInput::make('location')
    ->label(__('fixcity::segnalazione.fields.place.section.label'))
    ->defaultCenter(41.9028, 12.4964) // Roma di default
    ->defaultZoom(13)
    ->mapHeight('340px'),
// Aggiungi i campi sibling nascosti nello stesso schema:
TextInput::make('latitude')->numeric()->hidden(),
TextInput::make('longitude')->numeric()->hidden(),
```

#### Approach 2: Custom Field Names
Per utilizzare nomi di campo diversi dalla predefinita `latitude`/`longitude`:
```php
use Filament\Forms\Components\TextInput;
use Modules\Geo\Filament\Forms\Components\LeafletMarkerMapInput;

LeafletMarkerMapInput::make('location_map')
    ->defaultCenter(45.4642, 9.1900)
    ->defaultZoom(13)
    ->mapHeight('400px')
    ->bindLatitudeField('lat')    // Nome campo personalizzato per latitudine
    ->bindLongitudeField('lng'),  // Nome campo personalizzato per longitudine
TextInput::make('lat')->numeric()->hidden(),
TextInput::make('lng')->numeric()->hidden(),
```

**Features**:
- ✅ Leaflet 1.9 da CDN (tile OSM)
- ✅ Marker trascinabile e click sulla mappa
- ✅ Controlli in overlay sulla mappa: **posizione corrente** (aggiorna lat/lng via Livewire) e **schermo intero** (Fullscreen API + `invalidateSize()`)
- ✅ `IntersectionObserver` + seconda passata `boot` su mappa già inizializzata: ridimensionamento corretto quando lo step wizard diventa visibile
- ✅ Campo mappa non persistito (`dehydrated(false)`); persistenza su campi sibling lat/lng
- ✅ Aggiornamento automatico dei campi sibling configurati via Livewire
- ✅ Traduzioni `geo::leaflet_map.*` e riuso messaggi `geo::address.geolocation.*`
- ✅ Supporto per nomi di campo personalizzati tramite `bindLatitudeField()` e `bindLongitudeField()`

### 5. Composizione indirizzo + mappa

Non esiste un unico field composito nel repo; combinare **`AddressInput`** (testo + reverse geocoding opzionale) e/o **`LeafletMarkerMapInput`** (coordinate) secondo il flusso dominio.

## Zen: Perché Componenti Filament (non Blade::render)

| Approccio | Problema | Soluzione |
|---|---|---|
| `Blade::render('view')` | Non ha accesso a `$wire`, stato Livewire | ✅ Estendere `Field` |
| `wire:ignore` | Livewire non aggiorna il valore | ✅ Usare `$statePath` correttamente |
| JS globale `$wire` | Fragile, non funziona in Blade::render | ✅ Passare statePath alla funzione JS |
| `wire:model.defer` | JS non aggiorna il valore | ✅ Usare `wire:model.live` |

**Filament Way**:
```php
class AddressInput extends Field
{
    protected string $view = 'geo::filament.forms.components.address-input';
    
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->afterStateHydrated(function (AddressInput $component, mixed $state): void {
            if (! is_string($state)) {
                $component->state('');
            }
        });
    }
}
```

**Blade View** (con stato Livewire corretto):
```blade
@php
    $statePath = $getStatePath();
@endphp

<input
    type="text"
    wire:model.live="{{ $statePath }}"
    id="address-{{ $statePath }}"
>

<button x-on:click="useMyLocation('{{ $statePath }}')">
    Usa la tua posizione
</button>

<script>
function useMyLocation(statePath) {
    navigator.geolocation.getCurrentPosition(function(pos) {
        // Reverse geocode...
        const address = data.display_name;
        // Update Livewire state via $wire
        $wire.$set(statePath, address);
    });
}
</script>
```

## Web Components & Lit.dev

### Overview

Il modulo Geo utilizza **web components** (custom HTML elements) basati su [Lit.dev](https://lit.dev/) per componenti interattivi come `<my-map>`. I web components seguono lo standard DOM Web Components, con Lit come lightweight library di supporto.

**Why Lit.dev?**
- **Standard-based**: Utilizza Custom Elements (Web Components standard W3C)
- **Lightweight**: ~5KB minified, zero dependencies (oltre a Leaflet per mappe)
- **Reactive**: Data binding dichiarativo e reactive properties
- **Shadow DOM**: Encapsulation garantito, CSS scoped automaticamente
- **Lifecycle management**: `firstUpdated()`, `updated()`, `disconnectedCallback()` per gestire risorse

### Componente my-map

**Path**: `resources/js/components/my-map-lit.js`
**Extends**: `LitElement`
**Custom Element**: `<my-map>`

**Properties**:
```typescript
static properties = {
    lat: { type: Number },        // Latitude (default: 45.6669)
    lng: { type: Number },        // Longitude (default: 12.2423)
    zoom: { type: Number },       // Zoom level (default: 10)
    markerTitle: { type: String, attribute: 'marker-title' }
};
```

**Usage in Blade**:
```blade
<my-map 
    lat="45.6669" 
    lng="12.2423" 
    zoom="10"
    marker-title="My Location"
></my-map>
```

### Design Patterns

#### 1. Never Import Web Components Globally in Themes

❌ **WRONG** (laravel/Themes/Sixteen/resources/js/app.js):
```javascript
// This breaks the build because CSS imports from node_modules don't resolve at theme level
import '../../../../Modules/Geo/resources/js/components/my-map-lit.js';
```

✅ **CORRECT**:
- Keep web component files in module folder (`Modules/Geo/resources/js/`)
- Import only where needed (specific page/feature, not globally in theme)
- If needed at theme level, compile separately or use lazy-loading

**Why?**
- Web components are **module-scoped assets** with their own dependencies
- Themes are **presentation layer** — importing module-specific code breaks separation of concerns
- The build system can't resolve module CSS imports (`leaflet/dist/leaflet.css`) from theme context
- Each import in `app.js` becomes a global dependency that must resolve at build time

#### 2. Lifecycle Management

Always implement `disconnectedCallback()` to clean up resources:

```javascript
disconnectedCallback() {
    if (this._map) {
        this._map.remove();      // Clean up Leaflet instance
        this._map = null;
    }
    super.disconnectedCallback();
}
```

This prevents:
- Memory leaks on page navigation
- Ghost instances in DOM
- Race conditions on re-render

#### 3. Shadow DOM for Style Encapsulation

Lit uses Shadow DOM by default:
```javascript
static styles = css`
    :host {
        display: block;
    }
    .map {
        width: 100%;
        height: 400px;
    }
`;
```

Benefits:
- CSS scoped to component (no conflicts with page CSS)
- Component styles don't leak to parent
- Predictable styling independent of page context

### Integration with Filament Fields

To use a web component in a Filament field:

**Create field wrapper** (`app/Filament/Forms/Components/MyMapField.php`):
```php
class MyMapField extends Field {
    protected string $view = 'geo::filament.forms.components.my-map-field';
    
    public function getChildComponents(): array {
        return [];
    }
}
```

**Field view** (`resources/views/filament/forms/components/my-map-field.blade.php`):
```blade
<my-map 
    lat="{{ $getState()['lat'] ?? 45.6669 }}"
    lng="{{ $getState()['lng'] ?? 12.2423 }}"
    zoom="12"
    marker-title="Selected Location"
    wire:ignore
></my-map>
```

**Key points**:
- Use `wire:ignore` to prevent Livewire from re-rendering the web component
- Pass state via attributes (not JS, not Livewire.entangle)
- Web component manages its own state internally
- Use Alpine/custom events to communicate back to Livewire if needed

### Building & Compilation

Web components in Geo module are bundled with module assets, NOT with theme assets.

**Workflow**:
1. Code web component in `Modules/Geo/resources/js/components/`
2. Build happens at **module level** (if applicable) or **application level**
3. Never import module-level code in theme build context
4. Import only in specific pages/components where needed

## Troubleshooting

### Problema: Livewire non aggiorna il valore dell'input

**Causa**: `wire:model.defer` invece di `wire:model.live`
**Soluzione**: Usare `wire:model.live` per aggiornamenti da JS

### Problema: Errore "Livewire property cannot be found"

**Causa**: statePath non definito nel componente
**Soluzione**: Assicurarsi che `$statePath` sia passato correttamente dal campo Filament

### Problema: Entangle error

**Causa**: Tentativo di usare `@entangle` su stato non esistente
**Soluzione**: Non usare `@entangle` in custom fields, usare `$wire.$set()`

### Problema: Geolocalizzazione non funziona

**Causa**: Browser non supporta geolocalizzazione o permesso negato
**Soluzione**: 
1. Verificare `navigator.geolocation` esiste
2. Controllare permesso browser
3. HTTPS richiesto (geolocalizzazione non funziona su HTTP)

## Translations

Namespace: `geo::address.*`

| Chiave | IT | EN |
|---|---|---|
| `fields.address.label` | Indirizzo | Address |
| `fields.address.placeholder` | Cerca un indirizzo... | Search for an address... |
| `fields.use_my_location.label` | Usa la tua posizione | Use your current location |
| `geolocation.not_supported` | Geolocalizzazione non supportata | Geolocation not supported |
| `geolocation.address_not_found` | Indirizzo non trovato | Address not found |
| `geolocation.error` | Errore durante la geolocalizzazione | Error during geolocation |
| `geolocation.permission_denied` | Permesso di geolocalizzazione negato | Geolocation permission denied |

## Testing

Ogni componente deve avere:
- Unit test per state handling
- Integration test: render in form schema
- Browser test: geolocation button (se browser supporta)
- Map test: marker drag aggiorna coordinate
- Validation test: lat/lng invalidi rifiutati

## Riferimenti

- [Filament Custom Fields](https://filamentphp.com/docs/5.x/forms/custom-fields)
- [Filament Forms Overview](https://filamentphp.com/docs/5.x/forms/overview)
- [Filament Wizards](https://filamentphp.com/docs/5.x/schemas/wizards)
- [Livewire + Geolocation](https://dev.to/bradisrad83/browser-location-with-laravel-livewire-54bd)
- [CheeseGrits Google Maps Plugin](https://filamentphp.com/plugins/cheesegrits-google-maps)
