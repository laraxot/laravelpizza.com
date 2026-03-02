# Dipendenze e confini Modulo Geo

## Dipendenze in ingresso

- **Laravel / Eloquent**: modelli, migrazioni, cache, queue (se usate per geocoding async).
- **Xot**: classi base Filament e convenzioni (se il modulo espone Resource Filament).
- **Provider esterni**: API geocoding/routing (Google, OpenStreetMap, ecc.) tramite client HTTP; configurazione via config/env, nessun hardcoding.
- **Database**: supporto per tipi spatial (MySQL/PostGIS) se usati; documentato in migrazioni.

## Dipendenze in uscita

- **Moduli consumer**: qualsiasi modulo che necessiti di indirizzi, coordinate, mappe, geofencing o routing (es. strutture, appuntamenti, sedi). Integrazione tramite modelli Geo, servizi o Actions pubbliche.
- **Filament / Admin**: eventuali Resource per gestione Location/Address e configurazione provider.

## Rischio dipendenze circolari

- Geo non deve importare modelli o servizi da moduli applicativi (es. Patient, Cms). Solo framework, Xot, client HTTP e pacchetti geo generici.
