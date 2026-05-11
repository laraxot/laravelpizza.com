# Geo Components: The Stories

Each geographic component in the Geo module tells a different story. While they share the same technical foundation (Trait `HasCoordinatePicker`), their implementation details are distinct to support unique UX journeys. They are sibling components: no picker should extend another picker just to reuse behavior.

## 1. CoordinatePicker
- **The Story**: "I am a bridge between the digital and physical worlds. I show you where you are in numbers, and let you verify it on a map."
- **Focus**: Technical accuracy.
- **Components**: `CoordinatePicker.php`, `coordinate-picker.blade.php`, `coordinate-picker-lit`.

## 2. MapPicker
- **The Story**: "I am the explorer's tool. I show you the world, and you tell me where to plant the flag."
- **Focus**: Visual discovery.
- **Components**: `MapPicker.php`, `map-picker.blade.php`, `map-picker-lit`.

## 3. LocationPicker
- **The Story**: "I am the guide. You give me a name or an address, and I will lead you to the exact spot on the earth."
- **Focus**: Contextual search.
- **Components**: `LocationPicker.php`, `location-picker.blade.php`, `location-picker-lit`.

## 4. LatitudeLongitudeInput
- **The Story**: "I am the purist. I give you direct access to the coordinates, with a map only for your convenience."
- **Focus**: Raw data integrity.
- **Components**: `LatitudeLongitudeInput.php`, `latitude-longitude-input.blade.php`, `geo-latlng-input`.

## 5. PlacePicker
- **The Story**: "I am the concierge. I help you find Points of Interest and specific landmarks."
- **Focus**: Semantic locations.
- **Components**: `PlacePicker.php`, `place-picker.blade.php`, `place-picker-lit`.

## 6. MapPositioner
- **The Story**: "I am the director. I don't care about a single point; I care about the view, the zoom, and the perspective."
- **Focus**: Viewport management.
- **Components**: `MapPositioner.php`, `map-positioner.blade.php`, `map-positioner-lit`.

## 7. MapLocationInput
- **The Story**: "I am the shortcut. Just click, and you're there. No fuss, no numbers, just the map."
- **Focus**: Speed.
- **Components**: `MapLocationInput.php`, `map-location-input.blade.php`, `map-location-input-lit`.

## 8. LeafletMarkerMapInput
- **The Story**: "I am the engine. I expose the raw power of Leaflet for those who need precise control over marker behavior."
- **Focus**: Technical customization.
- **Components**: `LeafletMarkerMapInput.php`, `leaflet-marker-map-input.blade.php`, `leaflet-marker-map-input-lit`.

## 9. GeopointPicker
- **The Story**: "I am the archivist. I ensure that whatever you pick is formatted exactly for the database's spatial types."
- **Focus**: Database compatibility.
- **Components**: `GeopointPicker.php`, `geopoint-picker.blade.php`, `geopoint-picker-lit`.

## Shared Rule

All these components extend `XotBaseField`, keep their own Blade, and keep their own Lit/custom element when the UI differs. Shared logic belongs in `HasCoordinatePicker` or narrow helpers, not in sibling inheritance.

## Backlinks

- [geo-fields-zen](./geo-fields-zen.md)
- [geo-picker-sibling-components-governance](./geo-picker-sibling-components-governance.md)
