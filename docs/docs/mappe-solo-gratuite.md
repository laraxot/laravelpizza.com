# Regola Critica: Solo Servizi Mappe Gratuiti

## Regola Fondamentale

**🚨 MAI usare Google Maps API, Mapbox API o altri servizi a pagamento per mappe statiche o dinamiche.**

**SEMPRE usare solo servizi gratuiti e open source.**

## Servizi Consentiti

### 1. OpenStreetMap Export API (Raccomandato per Mappe Statiche)

**URL Base:** `https://render.openstreetmap.org/cgi-bin/export`

**Parametri:**
- `bbox`: Bounding box formato `min_lon,min_lat,max_lon,max_lat`
- `scale`: Scala in metri per pixel (5000-10000 per zoom ravvicinato)
- `format`: Formato immagine (`png`, `jpeg`, `webp`, `svg`, `pdf`, `ps`)

**Esempio:**
```
https://render.openstreetmap.org/cgi-bin/export?
  bbox=12.2247,45.5548,12.2447,45.5748
  &scale=5000
  &format=png
```

**Limiti:**
- Immagini non possono superare 4,000,000 pixel
- Server applica limiti CPU/memoria
- Alcune richieste possono richiedere token (usare screenshot manuale come alternativa)

**⚠️ IMPORTANTE:** Non scaricare tiles direttamente dai server OpenStreetMap (viola policy). Usare solo Export API.

### 2. OpenStreetMap Nominatim (per Geocoding)

**URL Base:** `https://nominatim.openstreetmap.org/`

**Caratteristiche:**
- Gratuito, nessuna API key richiesta
- Rate limit: 1 richiesta/secondo
- Usare per convertire indirizzi in coordinate

### 3. OpenStreetMap Tile Servers (per Mappe Interattive)

**URL Pattern:** `https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png`

**Caratteristiche:**
- Gratuito, nessuna API key richiesta
- Usare con Leaflet.js per mappe interattive
- Server: `a`, `b`, `c` (rotazione automatica)

### 4. Screenshot Manuale da Google Maps UI (Raccomandato per Precisione)

**Quando usare:**
- Per massima precisione indirizzi italiani
- Quando serve qualità visiva superiore
- Per familiarità utenti con Google Maps

**Procedura:**
1. Aprire https://www.google.com/maps
2. Cercare indirizzo o coordinate
3. Zoom a livello 17-18 (per precisione massima)
4. Fare screenshot dell'area (strumento OS o estensione browser)
5. Salvare come PNG

**⚠️ IMPORTANTE:** Questo è uno screenshot manuale dalla UI di Google Maps, NON una chiamata API. È completamente gratuito e permesso.

## Servizi VIETATI

### ❌ Google Maps Static API
- Richiede API key
- Costi dopo quota gratuita ($0.002 per richiesta)
- **VIETATO**

### ❌ Google Maps JavaScript API
- Richiede API key
- Costi dopo quota gratuita ($0.007 per caricamento)
- **VIETATO**

### ❌ Mapbox Static Images API
- Richiede account e API key
- Costi dopo quota gratuita
- **VIETATO**

### ❌ Mapbox GL JS
- Richiede account e API key
- Costi dopo quota gratuita
- **VIETATO**

### ❌ Qualsiasi servizio che richiede API key a pagamento
- **VIETATO**

## Eccezione: Link Google Maps per Navigazione

**✅ PERMESSO:** Link diretti a Google Maps per navigazione (non API)

**Pattern consentiti:**
```
https://www.google.com/maps/search/?api=1&query={indirizzo}
https://www.google.com/maps?q={lat},{lng}
```

**Perché è permesso:**
- Questi sono link gratuiti, non richiedono API key
- Non sono chiamate API, sono semplici URL
- Google permette link gratuiti per navigazione

## Pattern di Implementazione

### Mappa Statica con OpenStreetMap

```php
// Coordinate
$lat = 45.5648;
$lng = 12.2347;
$offset = 0.01; // ~1km intorno al punto

// Bounding box (min_lon,min_lat,max_lon,max_lat)
$bbox = ($lng - $offset) . ',' . ($lat - $offset) . ',' . ($lng + $offset) . ',' . ($lat + $offset);

// URL mappa statica OpenStreetMap
$imageUrl = "https://render.openstreetmap.org/cgi-bin/export?bbox={$bbox}&scale=10000&format=png";

// Fallback: se Export API non funziona, usare screenshot manuale salvato localmente
if (!file_exists($localImagePath)) {
    // Usa URL diretto come fallback temporaneo
    $imageUrl = "https://render.openstreetmap.org/cgi-bin/export?bbox={$bbox}&scale=10000&format=png";
}
```

### Link Navigazione (Gratuito)

```php
// Link Google Maps per navigazione (gratuito, non è API)
$address = 'Via Vanzo 86/A, 31021 Mogliano Veneto TV';
$encodedAddress = urlencode($address);
$mapsUrl = "https://www.google.com/maps/search/?api=1&query={$encodedAddress}";

// Oppure con coordinate
$mapsUrl = "https://www.google.com/maps?q={$lat},{$lng}";
```

## Verifica Implementazione

Prima di ogni commit, verificare:
- [ ] Nessuna chiamata a Google Maps API
- [ ] Nessuna chiamata a Mapbox API
- [ ] Nessuna API key configurata per servizi a pagamento
- [ ] Solo OpenStreetMap per mappe statiche/dinamiche
- [ ] Link Google Maps solo per navigazione (non API)
- [ ] Documentazione aggiornata con regola "solo gratuiti"

## Documentazione Correlata

- [Mappa Statica Cliccabile](./static-map-clickable-implementation.md)
- [OpenStreetMap Export API](https://wiki.openstreetmap.org/wiki/Export_image_api)
- [OpenStreetMap Tile Usage Policy](https://operations.osmfoundation.org/policies/tiles/)

## Riferimenti Regole Progetto

- [Regola Cursor: Solo Servizi Gratuiti](../../../../.cursor/rules/free-maps-only.mdc)
