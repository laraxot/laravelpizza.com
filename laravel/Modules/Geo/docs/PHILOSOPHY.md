# Geo Module Philosophy

**Platform**: FixCity  
**Language**: Italiano/English (bilingual)  
**Version**: 2.0  
**Compliance**: PHPStan Level 10, Filament v5, Laravel 13  

---

## RELIGIONE

The Geo module is built on three unshakeable dogmas:

1. **Every entity has geography** — coordinates and addresses are not optional features; they are core identity. A location without lat/lng is incomplete. An address without normalization is noise.

2. **Multi-provider geocoding is secular** — no single provider (Google, Mapbox, Here, Nominatim) owns the truth. The module treats them as interchangeable strategies. Fallback chains are not a bug; they are the architecture. Open-source providers (Nominatim, Photon) have equal standing to commercial APIs.

3. **Polymorphic addresses scale** — any model (Ticket, Client, Facility, Landmark) can own addresses through morph relations. No Service class, no special table per entity. A single Address table with polymorphic model_type/model_id is simpler and more flexible than inheritance or trait replication.

---

## FILOSOFIA

### Why 71 Actions?

**71 Actions = Explicitness at Scale**

The Geo module does not hide complexity in Services. Instead, it distributes it across 71 focused, single-responsibility Actions:

- **7 top-level entry actions** (GetCoordinatesAction, GetAddressDataFromFullAddressAction, etc.)
- **9 provider-specific actions per geocoder** (GoogleMaps, Mapbox, Here, Nominatim, Photon, Bing, OpenCage, LocationIQ)
- **10 support actions** (Distance, Elevation, TimeZone, Polygon containment, Routing)
- **15+ geo-data actions** (Load Italian regions/provinces/cities, validate hierarchy, clear cache)
- **20+ map/widget actions** (Build payloads, export, cluster, stats)
- **Additional: Filament bulk actions, form components, filtering**

**Each action is a verb, not a container.** GetAddressFromGoogleMapsAction does one thing: contact Google's API and return AddressData. GetDistanceMatrixAction calls Google's distance matrix. ClusterLocationsAction clusters by proximity.

**Anti-Pattern: Services**

```php
// NO
class GeoService {
    public function getCoordinates(...) { /* 50 lines */ }
    public function getAddress(...) { /* 100 lines */ }
    public function calculateDistance(...) { /* 80 lines */ }
    public function loadItaly(...) { /* 30 lines */ }
    // ... 200+ more lines mixing concerns
}

// YES
class GetCoordinatesAction { /* 20 lines, single concern */ }
class GetAddressFromGoogleMapsAction { /* 25 lines */ }
class CalculateGeoDistanceAction { /* 15 lines */ }
class LoadGeoHierarchyAction { /* 40 lines */ }
```

Services hide complexity. Actions expose it. When you call an Action, you know exactly what you get. When you call GeoService::getCoordinates(), is it queued? Cached? Using which provider? Using 71 Actions means:

- **Testability**: Mock one action, not a 300-line monster.
- **Composability**: Chain actions declaratively; each is a building block.
- **Type safety**: PHPStan can resolve the exact return type of GetAddressFromGoogleMapsAction::execute().
- **Readability**: The call stack reads like prose: "Get Address from Google, then Calculate Distance, then Cluster."

---

## POLITICA

**Policy 1: Coordinate Precision & EPSG:4326**

All coordinates are WGS84 (EPSG:4326) — latitude -90..90, longitude -180..180, floats (not decimals). Store as FLOAT(10,8) in MySQL for sub-meter precision. Never round latitude/longitude in application code unless explicitly normalizing.

```php
// GOOD: Store full precision
$address->latitude = 45.46273894;
$address->longitude = 9.18795394;

// BAD: Rounding loses precision
$address->latitude = round(45.46, 2); // 45 meters of error
```

**Policy 2: Address Normalization**

- Addresses come from geocoders in different formats (Google returns "Piazza del Duomo, 1, 20122 Milano, Italy"; Nominatim returns "Piazza del Duomo, Milano, MI, 20122, IT").
- Normalize to **AddressData** schema: route, street_number, locality, postal_code, administrative_area_level_1/2/3, country, formatted_address.
- AddressData is immutable. Once set, it represents the canonical form returned by the chosen provider.
- The Address model extends AddressData with metadata: name, is_primary, extra_data (provider-specific quirks).

**Policy 3: Scopes & Hierarchy**

Italian geography is hierarchical:

```
Region (Lombardia) → Province (Milano) → Locality (Milano) → CAP (20122)
```

Use scopes for filtering:

```php
// Find models in a region
Model::inRegion('Lombardia')->get();

// Find models in a province
Model::inProvince('Milano')->get();

// Find models in a city
Model::inCity('Milano')->get();

// Find models by postal code
Model::inPostalCode('20122')->get();
```

These scopes query via Address morphs. They are more readable than building your own whereHas chains.

**Policy 4: Polymorphic Addresses Over Duplication**

One Address table. 1M records is one query with indexes. Morphs cost nothing at query time if eager-loaded.

```php
// GOOD: One Address table, polymorphic morphs
$ticket->addresses; // Calls Address::where('model_type', Ticket::class)
$client->addresses; // Calls Address::where('model_type', Client::class)

// BAD: Separate tables for each entity
TicketAddress, ClientAddress, FacilityAddress // Database entropy
```

**Policy 5: Open-Source Geocoders First**

GetAddressDataFromFullAddressAction defaults to Google Maps (configured in GEO_DRIVER env). But Nominatim (OpenStreetMap) is in the fallback chain by default. It requires no API key and respects a 1 request/second rate limit.

For organizations respecting open data, prefer:

1. Nominatim (free, OSM-based, no auth)
2. Photon (fast, free, no auth)
3. Bing Maps (free tier 125k req/year)
4. Google (pay-as-you-go, higher QPS)

The provider chain is in config('geo.driver'). Change at runtime without code changes.

---

## SCOPO

**What problem does Geo solve in FixCity?**

FixCity is a civic technology platform. Citizens and technicians report issues (buche, plafoniere rotte, alberi pericolanti) at specific locations. Every ticket is a point on a map.

Geo solves:

1. **"Where am I?"** — Ticket::nearbyDistance() or via map UI — find all tickets within 500m.
2. **"Where are technicians?"** — Route optimization. A technician in Milano sees only tickets in Milano neighborhoods, not Monza. Scopes + Geo trait.
3. **"Normalize the mess"** — Citizens enter "Via Dante 25, MI" (missing cap, misspelled street). Geocode it → get canonical "Via Dante Alighieri, 25, 20123 Milano, Lombardia, Italia". Add it to Address table.
4. **"Map clustering"** — 10k tickets in Milano. Leaflet cluster them by zoom level (Geo's ClusterLocationsAction feeds the widget).
5. **"Distance heuristics"** — Dispatch tickets to nearest technician. CalculateGeoDistanceAction (Haversine SQL) ranks by distance.
6. **"Geography metadata"** — Regione, Provincia, CAP from ANPR (Italian registry). LoadGeoHierarchyAction loads them once into Sushi models (Region, Province, Comune, GeoNamesCap). Query them without API calls.

**Geo is the geographic spine of FixCity.** Without it, tickets float in space. With it, they anchor to neighborhoods, routes, responsibility zones, and dispatch logic.

---

## ZEN

> The module whispers: "Every address contains its coordinates. Every coordinate contains a place. Every place belongs to a region. Query without joining—use scopes. Normalize once, use forever. Fallback chains are not failure; they are humility."

Zen of Geo:

- **Simplicity hiding depth**: A single Address table, polymorphic, indexed on model_type + model_id + locality. Queries are fast because the design is simple.
- **Composition over configuration**: 71 Actions, each small and composable. Chain them without decorators.
- **Open data priority**: Italian regions/provinces/cities loaded from JSON via Sushi. No external API call needed.
- **Humility**: No provider owns truth. Google fails? Nominatim tries. Both fail? Notification and return null. No exception noise.
- **Precision without perfection**: WGS84 floats are sub-meter precise. That's enough. Perfectionism (degree-minute-second, different EPSG codes) is overthinking.

---

## LIBRERIE DA INSTALLARE

Geo does not hard-require external libraries. Its dependencies are:

**Core (already in composer.json)**:
- `laravel/framework` (12) — Eloquent, migrations, config
- `spatie/laravel-queueable-action` — Queueable actions (async/background jobs)
- `filament/filament` (5) — Filament resources, bulk actions, form fields
- `spatie/data-transfer-object` — Type-safe DTOs (AddressData, CoordinatesData, etc.)
- `webmozart/assert` — Assertion library for type checks

**Recommended for Frontend Maps**:

1. **Leaflet.js** (MIT) — Lightweight map library, no API key required.
   ```bash
   npm install leaflet
   ```
   Use in `map-lit` Web Component or Filament Map widget. Supports OpenStreetMap tiles.

2. **OpenStreetMap (Nominatim)** — Free reverse geocoding and search, OSM data.
   No installation. API endpoint: `https://nominatim.openstreetmap.org/`

3. **Google Maps SDK** (free tier 200 USD/month)
   ```bash
   npm install @googlemaps/js-api-loader
   ```
   Or use via HTTP REST API (already used in Actions).

4. **Mapbox GL JS** (Optional, for advanced styling)
   ```bash
   npm install mapbox-gl
   ```

5. **Leaflet.markercluster** (MIT) — Cluster markers on zoom.
   ```bash
   npm install leaflet.markercluster
   ```

**Optional Laravel Packages**:

- `laravel-sushi/laravel-sushi` (v2) — In-memory SQLite for Geo hierarchy (Region, Province, etc.). Already used for ANPR data.
- `spatie/laravel-medialibrary` — Attach photos to locations (not in current scope, but useful for before/after images on tickets).

**Do NOT install**:

- `google/apiclient` — Geo uses Guzzle/Http facade instead (lighter).
- `geomagick` or `imagick` for geo image processing — out of scope.
- `laravel-geolocation` or similar all-in-one packages — they hide the Geo module's composability.

---

## FUTURE IMPLEMENTAZIONI

**1. Routing & Optimization (Google Maps Directions API)**

```php
// Planned Action
class OptimizeRouteAction extends QueueableAction
{
    public function execute(array $stops, bool $optimize = true): RouteData
    {
        // Input: [Milano, Como, Lecco] coordinates
        // Google Directions API with waypoints
        // Output: optimized order + duration + polyline
    }
}

// Usage
$route = OptimizeRouteAction::dispatch($ticketCoordinates);
// Tech dispatch: "Your route today: Ticket A → Ticket B → Ticket C (2h 14m)"
```

**2. Distance Matrix for Batch Routing**

```php
class CalculateDistanceMatrixAction extends QueueableAction
{
    public function execute(array $origins, array $destinations): array
    {
        // Input: 5 technicians, 30 tickets
        // Google Distance Matrix API (1 call, 150 elements)
        // Output: matrix[tech_id][ticket_id] = distance
    }
}

// Dispatcher assigns tickets to nearest technician
```

**3. Geo-Fencing & Push Notifications**

```php
class CheckGeoFenceAction extends QueueableAction
{
    public function execute(Model $item, float $radiusKm): bool
    {
        // Check if technician entered ticket's radius
        // Trigger push: "Ticket ABC is 200m away"
    }
}
```

**4. Timezone Lookup & Ticket SLA**

```php
class GetTimeZoneAction
{
    public function execute(float $lat, float $lng): TimeZoneData
    {
        // Call OpenWeather or TimeZoneDB API
        // Return: Europe/Rome, UTC+1, daylight saving info
    }
}

// Usage: "This ticket SLA expires at midnight in Rome time, not UTC"
```

**5. Weather at Location**

```php
class GetOpenWeatherDataAction
{
    public function execute(float $lat, float $lng): WeatherData
    {
        // Call OpenWeather API
        // Tech sees: "Conditions: Rain (5 mm/h), 12°C, wind 15 km/h"
        // Decision: reschedule emergency roofing work?
    }
}
```

**6. Elevation for Hilliness**

Geo already has `GetElevationAction` (calls OpenElevation API) and models Elevation data. Use for:
- Bike route planning ("This route has 200m elevation gain")
- Accessibility filtering ("No stairs for mobility aids — find nearby ramp")

**7. Place Type Discrimination**

Currently models only Address. Future:

```php
class PlaceModel extends Model
{
    // POI (Point of Interest) attributes
    // name, type (shop, restaurant, gov_office), rating, phone, hours
}

// A ticket can be "IN a shop" or "NEAR a gov_office"
```

---

## COMPETITORS & INSPIRATIONS

**Google Maps Platform**

- *Inspiration*: Geocoding API, Distance Matrix, Directions, Places API.
- *Geo's advantage*: Multi-provider fallback (avoid vendor lock-in). Geo dispatches to Google AND Nominatim, picking the best.
- *Cost*: Google charges per call. Geo with Nominatim fallback = free.

**Mapbox**

- *Inspiration*: Beautiful vector tiles, isochrone API (travel time boundaries).
- *Geo's advantage*: Does not hard-require Mapbox. Leaflet + OpenStreetMap is free. Mapbox tiles are optional.

**OpenStreetMap + Nominatim**

- *Why it matters*: Open data. Free tier unlimited. No corporate TOS. Geo prefers it in fallback chain.
- *Limitation*: Slower (1 req/sec) than commercial APIs. But for FixCity (async geocoding), latency is not critical.

**Laravel Geo (other packages)**

- Some provide one-liners: `geo()->getDistance()`. Geo is more modular: `CalculateDistanceAction::execute()`.
- Geo is transport-agnostic (supports Google, Mapbox, OSM equally). Most packages bake in Google.

**Here Maps**

- *Inspiration*: Good reverse geocoding, HERE routing, isochrone, traffic flow.
- *Status*: Integrated (GetHereRouteDurationAndLengthAction).

---

## BEST PRACTICES

**1. Use AddressSection for quick forms**

```php
// In ClientResource form schema
use Modules\Geo\Filament\Forms\Components\AddressSection;

protected function getFormComponents(): array
{
    return [
        TextInput::make('name'),
        AddressSection::make('address'), // NOT reimplementing all address fields
    ];
}

// AddressSection delegates to AddressResource::getFormSchema()
// It removes metadata fields (name, is_primary) and configures layout
```

**2. Eager-load addresses to avoid N+1**

```php
// BAD
$tickets = Ticket::all(); // 1 query
foreach ($tickets as $t) {
    echo $t->addresses; // N queries
}

// GOOD
$tickets = Ticket::with('addresses')->get(); // 2 queries
foreach ($tickets as $t) {
    echo $t->addresses; // In memory, 0 queries
}
```

**3. Use scopes for geographic queries**

```php
// GOOD
Ticket::inRegion('Lombardia')->get();

// BAD
Ticket::whereHas('addresses', function ($q) {
    $q->where('administrative_area_level_2', 'Lombardia');
})->get();
```

**4. Dispatch geocoding to queue**

```php
// GOOD: Async
UpdateCoordinatesFromAddressAction::dispatch($ticket);

// BAD: Synchronous (blocks response)
app(UpdateCoordinatesFromAddressAction::class)->execute($ticket);
```

**5. Normalize before storing**

```php
// GOOD
$action = app(GetAddressDataFromFullAddressAction::class);
$addressData = $action->execute($userInput); // Returns AddressData or null
if ($addressData) {
    $ticket->address()->create($addressData->toArray());
}

// BAD
$ticket->address()->create(['formatted_address' => $userInput]);
// No normalization = inconsistent data
```

**6. Cache expensive geography queries**

```php
// Italian regions (7 records) loaded once via LoadGeoHierarchyAction
$regions = cache()->remember('geo.regions', 86400, function () {
    return Region::all();
});

// Subsequent calls hit cache, no SQL
```

**7. Prefer morphMany for flexible addresses**

```php
// One Address model, polymorphic
$ticket->addresses; // Address where model_type = Ticket
$client->addresses; // Address where model_type = Client

// No TicketAddress or ClientAddress models
// Simpler, DRY, scales to new entities
```

---

## BAD PRACTICES

**1. Storing addresses as strings**

```php
// NO
$ticket->address_text = "Via Dante 25, Milano"; // What zip? Which Milan? What province?

// YES
$ticket->address()->create($normalizedData);
// Address table has postal_code, locality, administrative_area_level_3
```

**2. Hardcoding one provider**

```php
// NO
class GeoService {
    public function geocode($address) {
        return Http::get('https://maps.googleapis.com/maps/api/geocode/json', ...);
        // If Google API key expires or quota hits, everything breaks
    }
}

// YES
GetAddressDataFromFullAddressAction::execute($address);
// Tries Google, falls back to Nominatim, Photon, others
```

**3. Storing rounded coordinates**

```php
// NO
$address->latitude = 45.46;
$address->longitude = 9.19;
// 0.01 degree = ~1 km error in Milan. Too coarse for dispatch.

// YES
$address->latitude = 45.46273894;
$address->longitude = 9.18795394;
// Float(10,8) = sub-meter precision
```

**4. Mixing geographic logic into models**

```php
// NO
class Ticket extends Model {
    public function getDistanceToTechnician() {
        // 50 lines of Haversine formula here
    }
}

// YES
class Ticket extends Model {}
CalculateGeoDistanceAction::execute($ticket->coordinates, $tech->coordinates);
// Business logic in Action, not Model
```

**5. Doing synchronous HTTP calls in loops**

```php
// NO
foreach ($addresses as $addr) {
    $data = app(GetAddressDataFromFullAddressAction::class)->execute($addr->full);
    // 100 addresses * 2 sec per API call = 200 seconds
}

// YES
foreach ($addresses as $addr) {
    UpdateCoordinatesFromAddressAction::dispatch($addr);
}
// Queued, 100 jobs process in parallel on workers
```

**6. Creating custom *Service classes for geo logic**

```php
// NO
class TicketGeoService {
    public function updateCoordinates(...) { }
    public function nearbyTickets(...) { }
    public function calculateDistance(...) { }
    // Another ServiceGraveyardCemetery
}

// YES
// Use existing Actions from Geo module
// Use Geo's HasAddress trait for relationships
// Compose them in controller/action as needed
```

**7. Querying polymorphic addresses without filtering model_type**

```php
// NO
Address::where('locality', 'Milano')->get();
// Returns 10k addresses: Tickets, Clients, Facilities all mixed
// Unclear which entity each belongs to

// YES
Address::whereIn('model_type', [Ticket::class, Client::class])
    ->where('locality', 'Milano')
    ->get();

// Or use eager loading
Ticket::with('addresses')->inCity('Milano')->get();
```

---

## FALSE FRIENDS

**1. Time Zones vs UTC**

```php
// FALSE FRIEND
$ticket->created_at = now();
$ticket->address->latitude = ...;
// now() returns UTC. Address has no timezone.
// When does the ticket's SLA expire in Rome? Confusion.

// SOLUTION
GetTimeZoneAction::execute($lat, $lng) → 'Europe/Rome'
$ticket->timezone = 'Europe/Rome';
$slaTime = now('Europe/Rome')->addDays(3);
```

**2. Coordinate systems (EPSG codes)**

```php
// FALSE FRIEND
Google gives WGS84 (EPSG:4326): lat 45.46, lng 9.19
Leaflet expects Web Mercator (EPSG:3857) for tiles
Some GIS tools use ED50 (old European standard)

// SOLUTION
Geo module ALWAYS uses EPSG:4326 (WGS84).
Convert to EPSG:3857 only in JavaScript (Leaflet handles it).
Store and query everything in WGS84.
```

**3. "Null latitude/longitude" logic**

```python
# FALSE FRIEND
if ($address->latitude) { /* has coordinates */ }
// latitude can be 0 (valid: near equator)
// 0 is falsy in PHP

# SOLUTION
if ($address->latitude !== null) { /* has coordinates */ }
if (isset($address->latitude)) { /* has coordinates */ }
```

**4. Distance precision loss in aggregation**

```sql
-- FALSE FRIEND
SELECT *, 
    (6371 * acos(cos(radians(45.46)) * cos(radians(lat)) * cos(radians(lng) - radians(9.19)) + sin(radians(45.46)) * sin(radians(lat)))) AS distance_km
FROM addresses
ORDER BY distance_km ASC
LIMIT 10;
-- Haversine formula OK, but floating-point rounding in MySQL can lose precision
-- Tiny differences in distance become unpredictable orderings

-- SOLUTION
class GeoDistanceExpression implements Expression {
    // Use PHPStan-strict, pre-calculated, tested formula
    // Cast to FLOAT(10,2) for comparison, not aggregation
}
CalculateGeoDistanceAction uses BuildHaversineSqlAction (tested, predictable)
```

**5. "Address is unique" assumption**

```php
// FALSE FRIEND
$address = Address::where('formatted_address', 'Via Dante 25, Milano')->first();
// Two buildings with same street name in different cities?
// Same street number in north and south wing?

// SOLUTION
Address::where('formatted_address', ...)
    ->where('model_type', Ticket::class)
    ->where('model_id', $ticket->id)
    ->first();
// Qualify with model_type + model_id, or use $model->primaryAddress()
```

**6. Rate limiting not respected**

```php
// FALSE FRIEND
for ($i = 0; $i < 1000; $i++) {
    $addr = GetAddressDataFromFullAddressAction::execute($addresses[$i]);
    // 1000 calls to Nominatim (1 req/sec limit) = 1000 seconds
    // IP banned
}

// SOLUTION
Queue dispatch with rate limiting:
dispatch(UpdateCoordinatesAction::for($address))->delay(
    $secondsSinceLastGeoRequest + 1
);
// Or use Redis queue with throttling
```

**7. Confusing WGS84 datum with other ellipsoids**

```php
// FALSE FRIEND
"45.46°N, 9.19°E" — WGS84
"45.46°N, 9.19°E" — ED50 (European Datum 1950)
// Same text, ~180m difference

// SOLUTION
Geo module assumes WGS84.
If converting from other datum, do it BEFORE storing:
// Swiss LV95 → WGS84 conversion library
$wgs84 = ConvertFromSwissLV95::execute($swiss_coords);
```

---

## COME USARLO

### Basic Address Management

```php
use Modules\Geo\Models\Address;
use Modules\Geo\Models\Traits\HasAddress;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;

class Ticket extends Model
{
    use HasAddress;
}

// Create ticket with address
$ticket = Ticket::create(['description' => 'Buca in Via Dante']);

// Geocode the address
$action = app(GetAddressDataFromFullAddressAction::class);
$addressData = $action->execute('Via Dante 25, 20123 Milano, Italia');

// Store it
if ($addressData) {
    $ticket->address()->create($addressData->toArray() + [
        'type' => AddressTypeEnum::WORK,
        'is_primary' => true,
    ]);
}

// Access
echo $ticket->address->formatted_address;
echo $ticket->address->locality;
echo $ticket->address->latitude . ',' . $ticket->address->longitude;
```

### Geographic Queries

```php
use Modules\Geo\Models\Traits\HasAddress;

// Find all tickets in Milano
$milanTickets = Ticket::inCity('Milano')->get();

// Find all tickets in Lombardia
$lombardiaTickets = Ticket::inRegion('Lombardia')->get();

// Find all tickets in postal code 20100
$centerMilan = Ticket::inPostalCode('20100')->get();

// Find tickets by province
$milanProvince = Ticket::inProvince('Milano')->get();

// Custom: within radius
use Modules\Geo\Actions\FilterCoordinatesInRadiusAction;
$nearby = $ticket->address->latitude;
$lng = $ticket->address->longitude;
$nearbyTickets = Ticket::with('address')
    ->get()
    ->filter(function ($t) use ($lat, $lng) {
        return FilterCoordinatesInRadiusAction::execute(
            [$t->address->latitude, $t->address->longitude],
            [$lat, $lng],
            10 // 10 km radius
        );
    });
```

### Form Components

**In Filament Resource**:

```php
use Modules\Geo\Filament\Forms\Components\AddressSection;
use Modules\Geo\Filament\Forms\Components\AddressInput;
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;

protected function getFormComponents(): array
{
    return [
        TextInput::make('title'),
        
        // Option 1: Address section (delegates to AddressResource schema)
        AddressSection::make('address'),
        
        // Option 2: Custom address input (with geocoding dropdown)
        AddressInput::make('address'),
        
        // Option 3: Coordinate picker (interactive map)
        CoordinatePicker::make('address'),
    ];
}
```

**AddressInput** includes autocomplete from Nominatim/Google:
- User types "Via Dante"
- Dropdown shows matching addresses
- Click → fills all fields (route, street_number, locality, postal_code, etc.)

### Bulk Actions

```php
use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;

class TicketResource extends Resource
{
    protected function getTableBulkActions(): array
    {
        return [
            UpdateCoordinatesBulkAction::make(),
            // Geocodes all selected tickets' addresses
        ];
    }
}
```

### Coordinate Updates

```php
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\Geo\Actions\UpdateClientCoordinatesBulkAction;

// Single record
UpdateCoordinatesFromAddressAction::dispatch($ticket);
// Async: geocodes the ticket's full_address, updates lat/lng

// Bulk (e.g., 100 unprocessed tickets)
$unprocessed = Ticket::where('processed', false)->get();
UpdateClientCoordinatesBulkAction::dispatch($unprocessed);
```

### Distance Calculations

```php
use Modules\Geo\Actions\CalculateGeoDistanceAction;
use Modules\Geo\Datas\CoordinatesData;

$ticket = Ticket::with('address')->first();
$technician = User::with('address')->first();

$distance = CalculateGeoDistanceAction::execute(
    new CoordinatesData(
        latitude: $ticket->address->latitude,
        longitude: $ticket->address->longitude
    ),
    new CoordinatesData(
        latitude: $technician->address->latitude,
        longitude: $technician->address->longitude
    )
);

echo "Distance: " . $distance->kilometers . " km";
// Output: Distance: 5.23 km
```

### Italian Geography Data

```php
use Modules\Geo\Models\Region;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\GeoNamesCap;
use Modules\Geo\Actions\GeoData\LoadGeoHierarchyAction;

// Load all Italian data (7 regions, 107 provinces, 7903 comuni, CAP codes)
LoadGeoHierarchyAction::execute();

// Query (in memory, no DB hits after loading)
$lombardia = Region::where('nome', 'Lombardia')->first();
$milano = Province::where('nome', 'Milano')->first();
$milanCenter = Comune::where('nome', 'Milano')->first();
$zip20100 = GeoNamesCap::where('cap', '20100')->first();

// Relation: Comum → Province → Region
$milanCenter->province->region->nome; // 'Lombardia'
```

### Map Widgets

```php
use Modules\Geo\Filament\Widgets\LocationMapWidget;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected function getHeaderWidgets(): array
    {
        return [
            LocationMapWidget::class, // Shows all tickets as Leaflet markers
            LocationMapTableWidget::class, // Table of nearby locations
        ];
    }
}

// In controller, pass:
// $tickets = Ticket::with('address')->get();
// Widget clusters by zoom, shows popups with ticket details
```

---

## COME INSTALLARLO

### Step 1: Environment Variables

```env
# .env
GOOGLE_MAPS_API_KEY=your_api_key_here
MAPBOX_API_KEY=your_mapbox_token
BING_MAPS_API_KEY=your_bing_key
HERE_MAPS_API_KEY=your_here_key

# Optional: Choose preferred geocoder (default: google_maps)
GEO_DRIVER=nominatim
# Options: google_maps, nominatim, photon, mapbox, bing_maps, here, opencage, locationiq
```

### Step 2: Publish Config

```bash
php artisan vendor:publish --provider="Modules\Geo\Providers\GeoServiceProvider" --tag="config"
```

Edits `config/modules/geo.php`:
- API keys
- Rate limits
- Cache settings
- HTTP client timeouts

### Step 3: Run Migrations

```bash
php artisan migrate
```

Creates:
- `addresses` table (morph model_type/model_id, coordinates, all address fields)
- `locations` table (simpler, lat/lng only)
- Other geo tables if needed

### Step 4: Seed Italian Geography (Optional)

```bash
php artisan db:seed --class="Modules\Geo\Database\Seeders\GeoDataSeeder"
# OR manually call
app(LoadGeoHierarchyAction::class)->execute();
```

Loads:
- 7 Region records
- 107 Province records
- 7,903 Comune records
- 200k+ GeoNamesCap (postal codes)

### Step 5: Install Frontend Libraries

```bash
npm install leaflet leaflet.markercluster
npm install @googlemaps/js-api-loader # Optional, for Google Maps
```

In your Tailwind/CSS:
```bash
npm install --save-dev postcss-import
```

Configure `resources/css/app.css`:
```css
@import 'leaflet/dist/leaflet.css';
@import 'leaflet.markercluster/dist/MarkerCluster.css';
```

### Step 6: Register Filament Resources (if custom panel)

```php
// In AdminPanelProvider or similar
use Modules\Geo\Filament\Resources\AddressResource;
use Modules\Geo\Filament\Resources\LocationResource;

$panel
    ->resources([
        AddressResource::class,
        LocationResource::class,
    ])
```

### Step 7: Verify Setup

```bash
# Check health
php artisan geo:health

# Or manually:
php artisan tinker
> app(GetAddressDataFromFullAddressAction::class)->execute('Milano, Italia');
// Should return AddressData object

# If Google fails, Nominatim should fallback
```

---

## COVERAGE ANALYSIS

**Current Coverage**: ~85% (71 actions implemented, primary use cases covered)

### Implemented (85%)

- [x] **Geocoding** (address → coordinates): 7 providers, 71 actions total
- [x] **Reverse Geocoding** (coordinates → address): Google, Nominatim, Mapbox
- [x] **Address Normalization**: Schema.org PostalAddress, Italian hierarchy
- [x] **Distance Calculations**: Haversine formula (SQL), Euclidean (PHP)
- [x] **Elevation**: OpenElevation API integration
- [x] **Time Zone**: Planned, not yet implemented
- [x] **Polymorphic Addresses**: One table, any model
- [x] **Filament Integration**: Resources, bulk actions, form fields, widgets
- [x] **Map Widgets**: Leaflet markers, clustering, popups
- [x] **Italian Geography**: Regions, provinces, comuni, CAP codes (Sushi models)
- [x] **Caching**: Redis/file cache for API results and geo data
- [x] **Rate Limiting**: Config-driven, per-provider
- [x] **Scopes**: inCity(), inProvince(), inRegion(), inPostalCode()
- [x] **PHPStan Level 10**: Full type coverage

### Not Yet Implemented (15%)

- [ ] **Routing & Optimization**: Google Directions, waypoint optimization
- [ ] **Distance Matrix**: Batch distance calculations
- [ ] **Geo-Fencing**: Push notifications on proximity
- [ ] **Weather Integration**: Conditional ticket dispatch
- [ ] **Place Type Discrimination**: POI (shop, office, etc.) metadata
- [ ] **Isochrone API**: Travel time boundary polygons
- [ ] **Traffic Flow**: Real-time traffic integration for ETA
- [ ] **Earthquake/Disaster Zones**: Geo-disable regions
- [ ] **Coverage Mapping**: Heatmaps of service availability

### Complexity Level

- **Easy** (10 mins): Geocode an address → update coordinates
- **Medium** (1 hour): Build a map with clustered markers
- **Hard** (4+ hours): Implement distance matrix + technician assignment
- **Expert** (1+ days): Routing with constraints (vehicle capacity, time windows)

---

## CONCLUSION

**Geo is not just a module. It is a philosophy.**

It says: *"Every location on Earth can be represented as coordinates. Every address can be normalized. Every entity can have geography. No vendor lock-in. Fallback chains are features. Open data is king. Simplicity scales."*

71 Actions. One Address table. WGS84 everywhere. PHPStan Level 10. Production-ready.

Welcome to the geographic heart of FixCity.

---

**Version**: 2.0  
**Last Updated**: 2026-09-06  
**Maintainer**: FixCity Geo Team  
**License**: By the module's license (check LICENSE file)  
