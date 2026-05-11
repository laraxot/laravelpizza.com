# Story: GeoMapWidget farmshops-inspired per modulo Geo

## Status

Draft

## Story

Come amministratore Filament del modulo `Geo`,
voglio un widget `GeoMapWidget` basato su Leaflet e su un Web Component Lit,
così da visualizzare e navigare un dataset GeoJSON statico lato client con clustering, layer multipli e popup ricchi senza dipendere da chiamate server successive al primo caricamento.

## Contesto

Il progetto sorgente di riferimento verificato è `CodeforKarlsruhe/farmshops.eu`, in particolare:

- `js/direktvermarkter.js`, che usa `L.map`, `L.geoJson`, `L.markerClusterGroup`, layer base OSM/Esri, popup e stato client-side.
- `update_data.js`, che genera un dataset statico ridotto partendo da dati OpenStreetMap e lo espone al frontend come payload già pronto al rendering.
- `js/popupcontent.js`, che costruisce popup ricchi a partire dalle proprietà GeoJSON.

Nel modulo `Geo` esistono già widget mappa legacy come `LocationMapWidget` e `OSMMapWidget`, ma il nuovo lavoro deve restare confinato nel dominio `Geo` e introdurre una soluzione moderna, isolata e pronta per Filament v5.

## Obiettivi

- replicare il pattern ad alte prestazioni di `farmshops.eu`: dataset statico caricato una sola volta e gestito in memoria lato client;
- migliorare l'architettura con separazione netta tra data layer, rendering Leaflet, layer manager e stato UI;
- usare solo librerie reali e verificate via npm/documentazione ufficiale;
- evitare CDN: asset JavaScript e CSS devono essere gestiti da npm e build Vite del progetto Laravel.

## Non Obiettivi

- nessuna chiamata AJAX per caricare dettagli marker dopo il bootstrap del widget;
- nessuna logica mappa fuori dal modulo `Geo`;
- nessuna dipendenza da Google Maps o librerie non verificate;
- nessuna mutazione server-side del dataset durante l'interazione mappa.

## Acceptance Criteria

### AC1 - Widget Filament v5 nel modulo Geo

- Esiste un widget Filament v5 `GeoMapWidget` sotto `Modules\Geo\Filament\Widgets`.
- Il widget usa esclusivamente view, asset e classi collocati nel modulo `Geo`.
- Il widget non introduce dipendenze applicative in moduli diversi da `Geo`, salvo primitive framework già presenti nel progetto.

### AC2 - Web Component Lit isolato

- La UI mappa è incapsulata in un Web Component Lit dedicato.
- Il Web Component inizializza e gestisce internamente la mappa Leaflet, i layer, i popup e la selezione.
- Il widget PHP/Blade passa al componente soltanto configurazione e dataset serializzati, senza contenere logica Leaflet inline non banale.

### AC3 - Dataset statico GeoJSON

- Il widget carica un unico file GeoJSON o un unico payload equivalente, con ordine di grandezza massimo di circa 3000 feature puntuali.
- Il dataset viene caricato una sola volta per istanza del widget e poi gestito interamente lato client.
- Non avvengono ulteriori richieste server per cambiare zoom, filtri, layer o selezione.

### AC4 - Parità funzionale verificata rispetto a farmshops

- Il comportamento base riprende pattern verificati in `direktvermarkter.js`: mappa Leaflet, dataset GeoJSON, marker cliccabili, clustering, layer base stradale/satellitare, popup e stato lato client.
- Le differenze rispetto a `farmshops.eu` sono documentate esplicitamente come miglioramenti architetturali o UX, non come assunzioni implicite.

### AC5 - Clustering e LOD

- Il rendering usa `leaflet.markercluster`.
- È presente una logica LOD client-side documentata e testabile:
  - zoom basso: cluster;
  - zoom intermedio: aggregazione per categoria o resa sintetica equivalente;
  - zoom alto: dettaglio feature individuali.
- Il cambio di livello non richiede refetch dati.

### AC6 - Layer manager interno

- Il widget espone almeno questi layer combinabili:
  - `points`
  - `clusters`
  - `heatmap`
  - `zones`
- L'attivazione/disattivazione layer è gestita da un layer manager interno al Web Component.
- Lo stato dei layer resta consistente durante zoom, pan e selezione feature.

### AC7 - Interazione feature

- I marker sono cliccabili e aprono popup con dati leggibili derivati dalle proprietà GeoJSON.
- La selezione di un punto aggiorna lo stato client interno del widget.
- È supportato un filtraggio client-side sul dataset già caricato, senza roundtrip server.

### AC8 - Performance e leggibilità

- Il codice separa chiaramente:
  - acquisizione/caricamento dataset;
  - trasformazione in layer Leaflet;
  - stato UI e filtri;
  - rendering popup.
- La soluzione evita re-render completi della mappa quando cambia soltanto lo stato UI o il layer attivo.
- Le iterazioni sul dataset sono ridotte al minimo ragionevole e documentate nei punti critici.

### AC9 - Build frontend reale

- Le dipendenze frontend sono installate via npm e integrate con Vite del progetto.
- Non sono presenti import runtime da CDN.
- Le librerie usate sono verificate e reali: almeno `leaflet`, `lit` e `leaflet.markercluster`; eventuali plugin aggiuntivi devono essere documentati e verificati prima dell'uso.

### AC10 - Qualità e test

- Il codice nuovo passa `PHPStan` livello massimo già adottato dal progetto sui file interessati.
- Il codice nuovo passa `PHPMD`, `PHP Insights` e test `Pest` pertinenti senza errori.
- Sono presenti test automatici almeno per:
  - configurazione/widget PHP;
  - serializzazione dataset/config;
  - eventuali transformer o helper introdotti nel modulo `Geo`.
- Le limitazioni di test frontend del Web Component, se presenti, sono documentate in modo esplicito.

## Tasks / Subtasks

### 1. Analisi e allineamento architetturale

- Studiare il codice di `farmshops.eu` con focus su `direktvermarkter.js`, `update_data.js` e `popupcontent.js`.
- Analizzare i widget mappa già presenti nel modulo `Geo`.
- Documentare le capacità da mantenere, quelle da scartare e quelle da migliorare.

### 2. Contratto dati GeoJSON

- Definire il contratto minimo delle feature GeoJSON supportate dal widget.
- Definire come rappresentare categorie, popup fields e layer `zones`.
- Stabilire dove risiede il dataset statico nel modulo `Geo` e come viene fornito al widget.

### 3. Widget Filament v5

- Creare `GeoMapWidget` nel namespace `Modules\Geo\Filament\Widgets`.
- Creare la view Blade del widget nel modulo `Geo`.
- Esportare configurazione minima necessaria verso il frontend.

### 4. Web Component Lit

- Creare un componente Lit dedicato nel modulo `Geo`.
- Inizializzare Leaflet e i base layer verificati.
- Implementare marker layer, cluster layer, heatmap layer e zones layer.
- Implementare popup renderer e stato di selezione.

### 5. Layer manager e LOD

- Introdurre un layer manager interno con stato esplicito.
- Implementare la logica LOD in funzione dello zoom.
- Garantire che i toggle layer non provochino ricostruzioni inutili della mappa.

### 6. Filtri client-side

- Definire almeno un meccanismo di filtro lato client coerente con le categorie del dataset.
- Assicurare che filtri, layer e selezione restino sincronizzati.

### 7. Asset pipeline

- Registrare asset JS/CSS tramite npm e Vite.
- Verificare compatibilità con build Laravel/Filament del progetto.
- Evitare dipendenze duplicate o import globali non necessari.

### 8. Test e quality gates

- Aggiungere test Pest per widget/config/trasformazioni.
- Eseguire `PHPStan`, `PHPMD`, `PHP Insights` e Pest sui file o sul modulo interessato.
- Documentare eventuali blocker reali del repository separandoli dai risultati del widget.

## Dev Notes

### Pattern verificati in farmshops.eu

- `direktvermarkter.js` crea una singola mappa Leaflet con center/zoom persistenti, tile layer OSM ed Esri, `L.geoJson` per il dataset e `L.markerClusterGroup` per clustering e icone aggregate.
- `update_data.js` genera un `FeatureCollection` statico e lo salva come asset frontend, riducendo il payload alle proprietà essenziali per il rendering iniziale.
- `popupcontent.js` costruisce popup ricchi interamente lato client a partire dalle proprietà già disponibili.

### Decisioni architetturali richieste

- Il pattern di `farmshops.eu` va mantenuto nel principio prestazionale, ma non copiato letteralmente:
  - niente jQuery;
  - niente script globali legacy;
  - niente caricamento dettagli lazy per singolo marker;
  - niente asset via CDN.
- Il Web Component Lit deve fungere da boundary UI isolato.
- Il widget Filament deve limitarsi a bootstrap, configurazione e integrazione con il pannello.

### Librerie verificate

- `Leaflet` è la libreria base per rendering mappa e supporta layer, GeoJSON e controlli.
- `leaflet.markercluster` è il plugin Leaflet corretto per clustering marker.
- `Lit` fornisce Web Components reattivi adatti all'isolamento della UI.

### Punti da verificare prima dell'implementazione

- plugin heatmap compatibile con `Leaflet` e installabile via npm;
- modalità migliore per registrare asset modulo `Geo` nella build Vite esistente;
- eventuale disponibilità nel progetto di una convenzione Filament v5 per asset/widget custom.

## Testing

### Test automatici minimi

- test unit del widget per verificare view, config e payload serializzato;
- test unit/feature di eventuali transformer GeoJSON o layer config builder;
- smoke test Pest sul rendering del widget se il test harness Filament del modulo lo consente.

### Verifica manuale minima

1. Aprire una pagina Filament che monta `GeoMapWidget`.
2. Verificare caricamento singolo dataset e assenza di refetch su zoom/pan/filter.
3. Verificare cluster a zoom basso, resa sintetica intermedia e marker individuali a zoom alto.
4. Attivare e disattivare `points`, `clusters`, `heatmap` e `zones`.
5. Aprire popup, cambiare layer, selezionare marker e controllare persistenza stato.

## Rischi / Note Aperte

- Il plugin heatmap non è ancora selezionato: va scelto solo dopo verifica npm e compatibilità reale con Leaflet/Vite.
- Il repository ha già mostrato in passato fragilità di bootstrap e quality gates; i risultati del nuovo widget vanno separati chiaramente da eventuali blocker preesistenti.
- Un dataset fino a circa 3000 punti è ragionevole per gestione client-side, ma la strategia di serializzazione deve evitare payload ridondanti.

## Fonti

- BMAD Method repository: https://github.com/bmadcode/BMAD-METHOD
- Farmshops source `direktvermarkter.js`: https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/direktvermarkter.js
- Farmshops source `update_data.js`: https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/update_data.js
- Farmshops source `popupcontent.js`: https://github.com/CodeforKarlsruhe/farmshops.eu/blob/master/js/popupcontent.js
- Leaflet quick start: https://leafletjs.com/examples/quick-start/
- Leaflet layers control: https://leafletjs.com/examples/layers-control/
- Leaflet reference: https://leafletjs.com/reference.html
- Leaflet.markercluster: https://leaflet.github.io/Leaflet.markercluster/
- Lit reactive properties: https://lit.dev/docs/v2/components/properties/
