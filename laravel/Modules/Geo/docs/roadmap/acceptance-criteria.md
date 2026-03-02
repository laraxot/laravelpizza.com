# Criteri di accettazione Modulo Geo

Criteri verificabili per considerare completate le fasi della roadmap Geo.

---

## Fase 1 · Core Geo Services (completata)

- [ ] Modelli `Location` e `Address` (o equivalenti) presenti con gestione coordinate e relazioni documentate.
- [ ] Servizio di geocoding (o adapter) che astrae il provider; almeno un provider funzionante (es. Google o OSM).
- [ ] PHPStan Level 10 su tutto il modulo senza errori.

## Fase 2 · Advanced Features (completata)

- [ ] Geofencing e routing esposti tramite API/azioni utilizzabili da altri moduli.
- [ ] Supporto a più provider cartografici configurabile (config o env); nessun hardcoding del solo Google.
- [ ] Cache per richieste geografiche ripetitive (chiave per coordinate/indirizzo); hit verificabile in test o log.

## Fase 3 · Analytics e ottimizzazione (in corso)

- [ ] Report o query che sfruttano dati geo (es. distribuzione per area, conteggi per zona).
- [ ] Query GIS ottimizzate (indici, uso corretto di funzioni spatial); tempi di risposta documentati o sotto soglia.
- [ ] Documentazione su come abilitare aggiornamenti di posizione (polling o eventi) se richiesto.

## Fase 4 · AI e scenari avanzati (pianificata)

- [ ] Routing suggerito (o predittivo) basato su dati storici; criterio di “suggerimento” documentato.
- [ ] Stili mappa configurabili per tenant (config o DB) senza toccare codice per ogni tenant.
- [ ] Isolamento dati geografici per tenant (scope o connection dedicata) verificabile con test.

---

Metriche e obiettivi numerici: [metrics.md](metrics.md).  
Dipendenze e confini: [dependencies.md](dependencies.md).
