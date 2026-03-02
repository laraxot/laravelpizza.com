# Checklist Qualità Modulo Geo

## Codice e architettura

- [x] PHPStan Level 10 per l’intero modulo `Geo`.
- [ ] Tutti i modelli geo estendono il `BaseModel` del modulo.
- [ ] Nessun utilizzo di `property_exists()` sui modelli Eloquent.
- [ ] Nessuna dipendenza diretta da un singolo provider cartografico nei layer di dominio (solo negli adapter).

## Performance

- [ ] Tempo di risposta medio per geocoding (con cache) inferiore agli obiettivi di progetto.
- [ ] Query GIS ottimizzate con uso consapevole di indici e funzioni database.
- [ ] Caching configurato per le chiamate più costose (geocoding, routing, reverse geocoding).

## Testing e sicurezza

- [ ] Test Pest per i servizi di geocoding, geofencing e routing.
- [ ] Test di integrazione che validano l’uso del modulo da parte di almeno un modulo consumer.
- [ ] Verifica del corretto isolamento dei dati in scenari multi-tenant.

