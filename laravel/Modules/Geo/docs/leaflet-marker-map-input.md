# LeafletMarkerMapInput Componente Filament

## Visione
Fornire un componente mappa riutilizzabile che incapsulli completamente la logica di Leaflet JS, permettendo ai moduli dominio di utilizzare funzionalità GIS avanzate senza duplicare dipendenze o conoscenze geografiche.

## Filosofia (Geo Module Boundaries)
Il componente rispetta rigorosamente i confini del dominio:
- **Responsabilità del modulo Geo**: Gestione di tile OSM, proiezione WGS84, interazioni mappa, geolocalizzazione browser
- **Responsabilità dei moduli dominio**: Definire quali campi latitude/longitude aggiornare, validazione dei dati di coordinate
- **Zero duplicazione**: I moduli come Fixcity importano questo componente invece di reimplementare Leaflet

## Regola del Componente
Il campo mappa stesso è `dehydrated(false)` - non persiste direttamente nello stato del form.
Invece, aggiorna campi sibling configurati (di default `latitude` e `longitude`) nello stesso scope dello schema.
Questa separazione permette:
- Stato mappa transitorio (zoom, posizione centro) non persiste tra i refresh
- Solo le coordinate effettive vengono salvate nel modello
- Architettura pulita tra componente di visuale e campi di dati

## Scopo Tecnico
Fornire un input Filament che:
1. Visualizza una mappa Leaflet con marker trascinabile
2. Centra inizialmente su coordinate fornite o su default (Roma)
3. Permette all'utente di:
   - Trascinare il marker per selezionare una posizione
   - Cliccare sulla mappa per posizionare il marker
   - Usare il pulsante "Usa la mia posizione" per centrare sulla posizione corrente (con consenso)
4. Aggiorna automaticamente i campi latitude e longitude nascosti quando la posizione cambia
5. Supporta validazione tramite i campi nascosti collegati

## Politica di Dipendenza
- Dipende solo da Leaflet.js CDN (version 1.9.4) - nessun pacchetto NPM richiesto
- CSS e JS inclusi via @once per evitare duplicazioni
- Completamente lato client - nessuna dipendenza da Laravel backend oltre allo stato Filament

## Zen dell'Implementazione
- **Semplicità**: API minimale con metodi setter per configurare campi e centro
- **Trasparenza**: Il comportamento è completamente visibile nel Blade template
- **Estensibilità**: Facile da sottoclassificare per varianti (es. con ricerca indirizzi)
- **Robustezza**: Gestisce casi edge come coordinate iniziali non valide, negazione geolocalizzazione