# Task: Test Geocoding Services - Geo

**Modulo**: Geo
**Priorita'**: Media
**Completamento**: 20%
**Data**: 2026-01-30

---

## Descrizione

I servizi di geocoding (Google, Mapbox, Here) necessitano test con mock delle API esterne.

## Test da Implementare

- [ ] HereService: test con mock HTTP response
- [ ] Nominatim actions: test lookup/search con mock
- [ ] Address geocoding: test round-trip (address -> coordinates -> address)
- [ ] Error handling: test timeout, rate limit, API key invalida

## Criteri di Completamento

- [ ] 8+ test per servizi geocoding
- [ ] Mock per tutte le API esterne
- [ ] Test error handling
