# Integrazione Mappe - Geo Module

## Regola Fondamentale
**MAI usare Google Maps API a pagamento - USARE SOLO risorse FREE**

**Link a Google Maps ammesso solo per navigazione (direzioni), non per visualizzazione.**

## Opzioni per Visualizzazione Mappa

### 1. Google Maps Embed (CONSIGLIATO per precisione indirizzi italiani)
- **Utilizzo**: Siti web dove serve massima precisione indirizzi italiani
- **Vantaggi**: Precisione migliore per indirizzi Italia, familiarità utenti
- **Implementazione**: iframe embed Google Maps
- **Link navigazione**: Click sull'immagine → Google Maps per directions

### 2. OpenStreetMap Embed
- **Utilizzo**: Alternativa gratuita e open source
- **Vantaggi**: Completamente gratuito, no account, open source
- **Implementazione**: iframe embed OpenStreetMap

### 3. Static Map (OpenStreetMap)
- **Utilizzo**: Immagini statiche per email, print
- **Tool**: https://staticmaps.openstreetmap.de/

### 4. Leaflet.js
- **Utilizzo**: Mappe personalizzate con marker
- **Vantaggi**: Free, open source, molti plugin

## COSE DA NON FARE
- ❌ Google Maps API (a pagamento)
- ❌ Google Static Maps API (richiede API key)
- ❌ Mapbox (ha limiti gratuiti ma non ideale)

## Soluzione Attuale Sottana Service

### Dati Posizione
- **Indirizzo**: via Vanzo 86/A, 31021 Mogliano Veneto TV
- **Coordinate**: lat 45.5633, lon 12.2506

### Implementazione
- Google Maps embed iframe
- Link diretto per navigazione completa

## File Riferimento
- `Themes/Two/resources/views/components/blocks/map/static-clickable.blade.php`

## Prossimi Passi
- [x] Usare Google Maps embed (più preciso per indirizzi italiani)
- [ ] Considerare download mappa statica PNG
- [ ] Integrare con modelli Address del modulo Geo
