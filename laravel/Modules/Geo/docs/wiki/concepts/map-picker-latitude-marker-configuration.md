# Map Picker Latitude/Longitude Configuration

## REGOLA: Gestire coordinate null
- Se `latitude` o `longitude` sono null, geolocalizza automaticamente usando browser GPS
- Metodo: `getCurrentLatitude()` e `getCurrentLongitude()`
- Fallback a coordinate predefinite (41.9028, 12.4964) se GPS non disponibile

### Implementazione
```javascript
// In coordinate-picker-field.js
if (latitude === null || longitude === null) {
  const current = getCurrentCoordinates();
  map.setView([current.lat, current.lng], 13);
}
```

### Verifica
```php
// In CoordinatePickerTest.php
public function testMapsToCurrentLocationWhenNullCoordinates() {
  $this->latitude = null;
  $this->longitude = null;
  $this->setUp();  // Dovrebbe chiudere currentLocation
  $this->assertEquals(41.9028, $this->map.getCenter().getLat());
}
```