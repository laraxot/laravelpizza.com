# Ricerca Dentista

## Descrizione
Sistema avanzato di ricerca dentisti con filtri multipli, geolocalizzazione e visualizzazione risultati in modalità mappa/lista.

## Stato Attuale
- **Completamento**: 100%
- **Responsabile**: Team Frontend
- **Data completamento**: Maggio 2025

## Funzionalità Implementate
- Ricerca per nome, specializzazione, prestazione
- Filtro per prossimità geografica
- Filtro disponibilità temporale
- Ordinamento risultati personalizzabile
- Vista mappa interattiva
- Vista lista dettagliata
- Schede profilo dentisti con foto e specializzazioni
- Filtri salvabili per ricerche future

## Filtri di Ricerca
- Distanza (1km, 5km, 10km, 25km, 50km)
- Specializzazione
- Convenzioni accettate
- Fascia di prezzo
- Rating minimo
- Disponibilità giorni/orari
- Servizi offerti
- Lingue parlate

## Visualizzazione Risultati
- Mappa interattiva con marker (integrazione Leaflet/Google Maps)
- Vista lista con ordinamento personalizzabile
- Card dentisti con informazioni principali
- Paginazione e caricamento dinamico

## Tecnologie Utilizzate
- Geo-API per localizzazione
- Ricerca full-text con Elasticsearch/Meilisearch
- Leaflet per mappe interattive
- Filtri dinamici con Alpine.js
- URL parametrizzati per condivisione ricerche
- Local storage per preferenze utente

## Performance e UX
- Caricamento progressivo risultati
- Caching risultati frequenti
- Prefetching dati hover
- Suggerimenti automatici durante digitazione
- Persistenza filtri tra sessioni

## Documentazione Correlata
- [Selezione slot](./selezione-slot.md)
- [Conferma prenotazione](./conferma-prenotazione.md)
- [Mappa dentisti](../mappa-dentisti.md)

## Riferimento Principale
→ [Torna a Stato Avanzamento Lavori](../../stato_avanzamento_lavori_2025_06_05.md)
