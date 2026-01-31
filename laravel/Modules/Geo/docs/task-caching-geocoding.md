# Task: Caching Geocoding Results - Geo

**Modulo**: Geo
**Priorita'**: Bassa
**Completamento**: 0%
**Data**: 2026-01-30

---

## Descrizione

Le chiamate geocoding a API esterne non sono cachate. Implementare cache per ridurre costi e latenza.

## Approccio

1. Cache layer con Laravel Cache (Redis/file)
2. Chiave basata su indirizzo normalizzato
3. TTL configurabile (default 30 giorni per geocoding)
4. Invalidazione su modifica indirizzo

## Criteri di Completamento

- [ ] Cache implementata per tutti i servizi geocoding
- [ ] TTL configurabile via config
- [ ] Test con cache hit/miss
