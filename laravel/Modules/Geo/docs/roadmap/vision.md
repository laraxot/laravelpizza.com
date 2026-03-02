# Visione del Modulo Geo

Il modulo `Geo` ha il compito di centralizzare **tutta la geolocalizzazione del sistema**:
- indirizzi normalizzati
- coordinate e geometrie
- integrazione con provider cartografici esterni
- servizi di geocoding e reverse geocoding.

## Obiettivi di business

- Rendere semplice collegare qualsiasi entità di dominio (paziente, struttura, appuntamento, attività, ecc.) a una posizione geografica consistente e riusabile.
- Fornire funzionalità di **geofencing** e routing che possano essere sfruttate dai moduli applicativi senza duplicare logica.
- Abilitare reporting e analytics geografici (mappe di calore, distribuzione utenti, copertura servizi).

## Obiettivi tecnici

- Esporre modelli e servizi geo agnostici rispetto al provider (Google, OpenStreetMap, ecc.).
- Garantire prestazioni elevate tramite caching mirato delle richieste GIS.
- Mantenere il modulo allineato a:
  - PHP 8.2+ con type-safety completa
  - Laravel 12
  - PHPStan Level 10 come baseline.

