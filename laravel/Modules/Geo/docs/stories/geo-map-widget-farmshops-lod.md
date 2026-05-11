# Story: GeoMapWidget Filament v5 con pattern farmshops e LOD client-side

## Status
Draft

## Priority
Alta

## Type
Nuova feature / consolidamento architetturale Geo

## Module
Geo

## Date
2026-04-17

---

## As A
utente backoffice o operatore che deve esplorare punti geografici del dominio Geo

## I Want
un widget Filament v5 `GeoMapWidget` nel modulo `Geo` che mostri una mappa Leaflet interattiva, caricando un solo dataset GeoJSON statico e gestendo cluster, layer multipli, popup e filtri interamente lato client

## So That
possa consultare dataset geografici medi (~3000 punti) con UX rapida e scalabile, senza roundtrip server continui e senza duplicare logica fuori dal dominio Geo.

---

## Executive Intent

Questa story non chiede una “mappa generica”. Chiede un widget Geo conforme all’architettura Laraxot/Filament del repository, che prenda come riferimento reale e verificato `farmshops.eu`, ne conservi i pattern buoni e li migliori in modo rigoroso:

- dataset statico pre-caricato una sola volta;
- clustering Leaflet con icone aggregate;
- popup e selezione marker;
- stato client-side persistente;
- multi-layer combinabili;
- logica di dettaglio graduata per livello di zoom;
- isolamento UI tramite Web Component Lit;
- nessuna dipendenza da CDN;
- nessun codice dominio disperso fuori dal modulo `Geo`.

Il widget deve essere progettato per Filament v5 e aderire ai wrapper/protocolli del progetto. Dove esistono già asset o prove tecniche nel modulo `Geo`, vanno analizzati e riusati consapevolmente, non ignorati.

---

## Verified Upstream Findings

### Farmshops.eu: pattern verificati

Dallo studio del repository `CodeforKarlsruhe/farmshops.eu` risultano verificati questi elementi:

- `update_data.js` genera offline un singolo `FeatureCollection` GeoJSON semplificato e, separatamente, i dettagli per singolo punto in `data/<id>/details.json`.
- `direktvermarkter.js` inizializza una mappa Leaflet con stato permalink, base layer OSM e satellite, marker per categoria, clustering `L.markerClusterGroup`, popup aperti on-demand al click e controllo layer.
- `direktvermarkter.js` usa `maxClusterRadius` variabile in base allo zoom e `iconCreateFunction` per cambiare il contenuto visuale dei cluster in base alle categorie presenti e al livello di zoom.
- `popupcontent.js` costruisce popup ricchi e traduce/mette in evidenza metadati utili, link esterni e orari di apertura.
- `README.md` conferma il pattern: dati da OSM, export GeoJSON, marker distinti per categoria, popup che rendono più leggibili i dati grezzi, permalinks, punti e poligoni.

### Miglioramenti richiesti rispetto a farmshops

Il nuovo widget **non** deve replicare i limiti di farmshops:

- niente jQuery;
- niente dipendenza da file `details.json` per popup con ulteriori chiamate HTTP;
- niente asset caricati con script statici o CDN;
- niente logica UI sparsa in file legacy non tipizzati;
- niente componenti mischiati tra tema e modulo se il dominio è Geo.

### Standard tecnici verificati

- **Leaflet** supporta `L.geoJSON`, `FeatureGroup`, `LayerGroup`, `Control.Layers`, popup, marker e poligoni.
- **Leaflet.markercluster** è il package npm ufficiale da usare (`leaflet.markercluster`, con punto), distinto dal package deprecato `leaflet-markercluster`.
- **Lit** è appropriato per costruire un Web Component con stato reattivo, lifecycle esplicito e Shadow DOM.

---

## Existing Repo Context To Reuse

Nel modulo `Geo` esistono già asset, codice e prove che l’implementatore deve studiare prima di cambiare qualcosa:

- `laravel/Modules/Geo/resources/js/direktvermarkter.js`
- `laravel/Modules/Geo/resources/js/popupcontent.js`
- `laravel/Modules/Geo/resources/js/leaflet.js`
- `laravel/Modules/Geo/resources/js/leaflet.markercluster.js`
- `laravel/Modules/Geo/resources/js/leaflet.permalink.min.js`
- `laravel/Modules/Geo/resources/views/maps/farmshops/*`
- `laravel/Modules/Geo/docs/LIT-MAP-IMPLEMENTATION.md`
- `laravel/Modules/Geo/app/Filament/Widgets/LocationWidget.php`
- `laravel/Modules/Geo/app/Filament/Widgets/OSMMapWidget.php`
- `laravel/Modules/Geo/app/Models/GeoJsonModel.php`
- `laravel/Modules/Geo/app/Transformers/GeoJsonResource.php`
- `laravel/Modules/Geo/app/Transformers/GeoJsonCollection.php`
- `laravel/Modules/Geo/app/Actions/ClusterLocationsAction.php`

Osservazioni importanti:

- Esiste già codice farmshops “vendorizzato” nel modulo. Prima di aggiungere nuovi file, va deciso cosa riusare, cosa rifattorizzare e cosa archiviare.
- `OSMMapWidget` estende `Filament\Widgets\Widget`; il nuovo lavoro deve invece allinearsi ai wrapper attuali del progetto e alla realtà Filament v5.
- `LocationWidget` mostra il pattern corretto di estensione da `XotBaseWidget`.
- Il modulo contiene già immagini categoria (`hof.png`, `markt.png`, `imker.png`) che potrebbero essere riutilizzabili come base iconografica.

---

## Non-Negotiable Constraints

- Il widget si chiama **`GeoMapWidget`**.
- Il widget vive **interamente dentro il modulo `Geo`**.
- Nessuna logica di dominio Geo deve essere spostata in tema o in moduli estranei.
- Nessuna dipendenza da CDN.
- Le dipendenze JS devono provenire da npm e dal build tool effettivamente in uso nel progetto.
- Non assumere che il package manager del modulo sia sufficiente: verificare il punto reale di build Vite/Mix prima di installare o importare.
- Il dataset punti è un **unico GeoJSON** caricato una sola volta.
- Il dataset target è circa **3000 punti max**, quindi l’architettura va ottimizzata per dataset medio, non per streaming infinito.
- Nessuna chiamata server per marker/popup dopo l’inizializzazione, salvo esplicita estensione futura non inclusa in questa story.
- Tutto il filtraggio e il layer switching devono avvenire lato client sul dataset già caricato.
- La UI della mappa deve essere un **Web Component Lit**.
- Il motore di rendering deve essere **Leaflet**.
- Il clustering deve usare **`leaflet.markercluster`**.
- I layer devono poter combinare almeno: `points`, `cluster`, `heatmap`, `zones/polygons`.
- Il sistema deve supportare marker cliccabili, popup, selezione punto e sincronizzazione dello stato interno.
- Il lavoro non è chiuso finché non passano: **PHPStan, PHPMD, PHP Insights, Pest**.

---

## Architecture Guardrails

### PHP / Filament

- Il widget deve estendere `Modules\Xot\Filament\Widgets\XotBaseWidget`, non il widget Filament base.
- La classe PHP del widget deve restare sottile: prepara config, serializza dati iniziali, espone view e contratti di integrazione.
- La business logic di trasformazione dati deve stare nel modulo `Geo`, preferibilmente in `Actions`, `Datas`, `Transformers` o classi dedicate del modulo, non inline nella Blade.
- Evitare di aggiungere nuovi `Service` generici. In questo repository la direzione preferita è `Action` over `Service`.

### Frontend

- Il Web Component Lit deve separare chiaramente:
  - stato UI;
  - gestione dataset GeoJSON;
  - orchestrazione layer Leaflet;
  - rendering popup;
  - filtri e selezione.
- Il componente non deve ricreare la mappa o ricaricare il dataset a ogni update reattivo.
- Gli aggiornamenti di stato devono mutare solo i layer necessari.
- I popup devono essere generati da template/factory deterministiche, non da concatenazione caotica di stringhe sparse.

### Data layer

- Prevedere un formato GeoJSON coerente e documentato.
- Le feature devono contenere almeno:
  - `id`
  - geometria
  - categoria/tipo
  - titolo/nome
  - payload minimo per popup
  - flag/attributi utili per filtri e layer
- Se esistono poligoni, il sistema deve renderli come layer vettoriale dedicato e, se necessario, generare centroid/marker derivati in modo esplicito.

---

## Required Outcome

L’implementazione finale deve produrre almeno:

1. Un widget Filament v5 `GeoMapWidget`.
2. Una view Blade minimale che monta il Web Component Lit.
3. Un Web Component Lit dedicato alla mappa.
4. Un modulo di state management client-side.
5. Un layer manager client-side.
6. Un adapter/mapper GeoJSON -> layer Leaflet.
7. Un popup renderer/factory.
8. Un contratto chiaro per il payload iniziale passato dal PHP al frontend.
9. Test Pest adeguati per il lato PHP.
10. Documentazione Geo aggiornata per architettura, dipendenze e uso.

---

## Acceptance Criteria

- [ ] Esiste `GeoMapWidget` nel modulo `Geo`, conforme a Filament v5 e ai wrapper del progetto.
- [ ] Il widget non introduce codice dominio Geo fuori dal modulo `Geo`.
- [ ] Il widget monta una mappa Leaflet tramite un Web Component Lit.
- [ ] Nessun asset JS/CSS della soluzione finale è caricato da CDN.
- [ ] Il dataset punti è un singolo file GeoJSON, caricato una sola volta all’avvio.
- [ ] Dopo il caricamento iniziale, zoom, filtri, selezione, popup e layer switch non effettuano ulteriori fetch server.
- [ ] Il clustering usa `leaflet.markercluster` package ufficiale.
- [ ] Il widget implementa logica LOD: cluster a zoom basso, aggregazione per categoria a zoom intermedio, dettaglio marker a zoom alto.
- [ ] Il widget espone UI interna per attivare/disattivare layer `points`, `cluster`, `heatmap`, `zones/polygons`.
- [ ] I layer possono essere combinati senza perdita di stato client-side.
- [ ] I marker sono cliccabili e aprono popup utili costruiti con dati già presenti nel dataset.
- [ ] La selezione di un punto aggiorna uno stato interno coerente del componente.
- [ ] Il filtraggio client-side agisce sul dataset già in memoria e non ricarica la mappa da zero.
- [ ] L’implementazione evita re-render inutili del Web Component e re-inizializzazioni Leaflet non necessarie.
- [ ] L’implementazione evita iterazioni complete sul dataset quando basta aggiornare subset/layer derivati.
- [ ] Il layer manager è una struttura esplicita e testabile, non una serie di variabili globali.
- [ ] La soluzione è leggibile, modulare e pronta a estensioni future.
- [ ] PHPStan passa.
- [ ] PHPMD passa.
- [ ] PHP Insights passa.
- [ ] Pest passa.

---

## Recommended Technical Shape

### Candidate PHP files

- `laravel/Modules/Geo/app/Filament/Widgets/GeoMapWidget.php`
- `laravel/Modules/Geo/resources/views/filament/widgets/geo-map-widget.blade.php`
- `laravel/Modules/Geo/app/Actions/Maps/BuildGeoMapWidgetPayloadAction.php`
- `laravel/Modules/Geo/app/Datas/Map/GeoMapWidgetData.php`
- `laravel/Modules/Geo/app/Datas/Map/GeoMapLayerConfigData.php`

### Candidate JS files

- `laravel/Modules/Geo/resources/js/components/geo-map-widget.ts`
- `laravel/Modules/Geo/resources/js/components/maps/geo-map-widget.element.ts`
- `laravel/Modules/Geo/resources/js/components/maps/geo-map-state.ts`
- `laravel/Modules/Geo/resources/js/components/maps/geo-map-layer-manager.ts`
- `laravel/Modules/Geo/resources/js/components/maps/geo-map-leaflet-renderer.ts`
- `laravel/Modules/Geo/resources/js/components/maps/geo-map-popup-renderer.ts`
- `laravel/Modules/Geo/resources/js/components/maps/geo-map-geojson-adapter.ts`

### Candidate tests

- `laravel/Modules/Geo/tests/Feature/Filament/GeoMapWidgetTest.php`
- `laravel/Modules/Geo/tests/Unit/Actions/Maps/BuildGeoMapWidgetPayloadActionTest.php`
- eventuali test JS solo se il progetto ha già una pipeline consolidata; in caso contrario, documentare il limite e coprire il contratto lato PHP.

### Candidate docs

- `laravel/Modules/Geo/docs/geo-map-widget.md`
- aggiornamento di `laravel/Modules/Geo/docs/filament.md`
- aggiornamento di `laravel/Modules/Geo/docs/LIT-MAP-IMPLEMENTATION.md`

---

## Data Contract Guidance

Il widget deve ricevere dal lato PHP un payload iniziale simile a:

```php
[
    'datasetUrl' => '...',
    'initialState' => [
        'center' => ['lat' => 45.0, 'lng' => 9.0],
        'zoom' => 7,
        'selectedId' => null,
        'activeLayers' => ['cluster', 'zones'],
        'filters' => [
            'categories' => [],
            'text' => null,
        ],
    ],
    'layerConfig' => [
        'cluster' => ['enabled' => true],
        'points' => ['enabled' => false],
        'heatmap' => ['enabled' => false],
        'zones' => ['enabled' => true],
    ],
]
```

Il GeoJSON reale deve contenere già i campi minimi per popup e filtri, evitando fetch secondari.

---

## LOD Rules

La story richiede esplicitamente una logica LOD. L’implementazione deve quindi formalizzare soglie di zoom e comportamento:

- **Zoom basso**: prevale il layer cluster.
- **Zoom medio**: il cluster mostra aggregazione semantica per categoria, non solo count grezzo.
- **Zoom alto**: emergono marker dettagliati individuali.

Le soglie di zoom e i raggi cluster non vanno hardcodati “a sentimento”: vanno messi in config interna leggibile e verificabile.

Pattern upstream da conservare/migliorare:

- `farmshops` usa `maxClusterRadius` dipendente dallo zoom;
- `farmshops` cambia il contenuto del cluster in funzione delle categorie presenti;
- qui la stessa idea va resa più modulare, tipizzata e configurabile.

---

## Popup Rules

- Il popup deve funzionare senza fetch addizionali.
- Il popup deve consumare un payload già presente nella feature.
- Il popup deve distinguere chiaramente:
  - intestazione;
  - metadati principali;
  - eventuali link;
  - azioni o dettagli contestuali.
- Niente HTML costruito con logica sparsa su più file legacy se si può usare un renderer/factory dedicato.

---

## Layer Manager Requirements

Il layer manager deve:

- registrare tutti i layer disponibili;
- sapere se un layer è attivo/disattivo;
- montare/smontare il layer su Leaflet senza ricreare l’intera mappa;
- reagire ai cambi zoom/stato/filtri;
- evitare condizioni ambigue fra `cluster` e `points`;
- permettere combinazioni valide di layer.

Il layer manager non deve dipendere da variabili globali browser.

---

## Performance Requirements

- Caricare il GeoJSON una sola volta.
- Evitare `map.remove()` / `L.map(...)` ripetuti.
- Non ricostruire cluster e marker se cambia solo uno stato non geografico.
- Se il dataset cresce, prevedere già una pipeline dove i layer derivati possano essere rigenerati in modo incrementale o chunked.
- Valutare `chunkedLoading` di `leaflet.markercluster` se utile dopo verifica reale sul dataset.
- Minimizzare `forEach` ridondanti su tutte le feature a ogni evento `move` o `zoom`.

---

## Anti-Goals

- Non usare Google Maps o librerie proprietarie.
- Non usare CDN.
- Non usare jQuery.
- Non introdurre polling o fetch continui.
- Non introdurre un backend query-per-viewport in questa story.
- Non spostare il widget nel tema.
- Non lasciare codice farmshops legacy duplicato e non referenziato senza documentare cosa resta e cosa viene sostituito.
- Non inventare heatmap o plugin non verificati: se si usa una heatmap, la libreria deve essere verificata prima e documentata.

---

## Implementation Notes For Dev Agent

1. Studiare prima tutti i file farmshops già presenti nel modulo.
2. Verificare quale build JS è realmente usata dal progetto corrente per il modulo `Geo`.
3. Verificare se `lit`, `leaflet` e `leaflet.markercluster` sono installati nel package realmente compilato.
4. Se mancano, aggiungere dipendenze nel punto corretto di build, non nel posto “più vicino”.
5. Introdurre il nuovo widget senza rompere eventuali widget Geo esistenti.
6. Tenere la classe PHP del widget piccola e focalizzata su payload/config.
7. Scrivere prima o subito dopo i test lato PHP per il contratto del widget.
8. Aggiornare documentazione modulo e note architetturali finali.

---

## Verification

### Functional

1. Aprire una pagina/panel Filament che monta `GeoMapWidget`.
2. Verificare che la mappa venga inizializzata una sola volta.
3. Verificare che il GeoJSON venga caricato una sola volta.
4. Verificare cluster a zoom basso.
5. Verificare aggregazione categoria/cluster a zoom intermedio.
6. Verificare dettaglio marker a zoom alto.
7. Verificare attivazione/disattivazione layer.
8. Verificare combinazioni layer valide.
9. Verificare popup marker.
10. Verificare selezione punto e stato interno.
11. Verificare filtri client-side senza fetch aggiuntivi.

### Quality Gates

Eseguire e far passare senza errori:

```bash
./vendor/bin/pest
./vendor/bin/phpstan analyse
./vendor/bin/phpmd laravel/Modules/Geo text laravel/Modules/Geo/phpmd.ruleset.xml
./vendor/bin/phpinsights --no-interaction --ansi
```

Se i comandi reali del repository differiscono, documentare quelli effettivamente usati e far passare gli equivalenti.

---

## Definition Of Done

La story è completata solo se:

- il widget esiste e funziona come descritto;
- il design architetturale è coerente con il modulo `Geo`;
- non ci sono fetch server post-init per la mappa;
- il layer manager è esplicito e modulare;
- i popup funzionano con payload locale;
- i quality gates passano;
- la documentazione è aggiornata;
- è chiaro quali file farmshops legacy restano, quali vengono riusati e quali diventano candidati ad archivio.

---

## Source References

- Farmshops repository: `https://github.com/CodeforKarlsruhe/farmshops.eu`
- Upstream logic studied:
  - `README.md`
  - `index.html`
  - `js/direktvermarkter.js`
  - `js/popupcontent.js`
  - `update_data.js`
- Leaflet reference: `https://leafletjs.com/reference.html`
- Lit components overview: `https://lit.dev/docs/components/overview/`
- Leaflet.markercluster official repository: `https://github.com/Leaflet/Leaflet.markercluster`
- Leaflet.markercluster npm package ufficiale: `https://www.npmjs.com/package/leaflet.markercluster`
- Deprecated package da non usare: `https://www.npmjs.com/package/leaflet-markercluster`
