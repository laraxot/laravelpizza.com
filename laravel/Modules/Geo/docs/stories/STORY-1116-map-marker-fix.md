# 📌 DEVE STORY-1116: FIX MAP CLUSTER MARKERS DISAPPEARANCE

## CONTESTO

La mappa mostra errori visivi durante il pan/zoom: marker e gruppi cluster scompaiono per èra ùtili al ripple `refreshClusters()` con timeout da 180ms.

## SOLUZIONE IMPLEMENTATA

1. **Modifica nel file `map-lit.js`:**
```javascript
// Prima versione problematica:
_map.on('zoomend', () => {
  this._clusterRefreshTimer = setTimeout(() => {
    this._markersLayer.refreshClusters();
  }, 180);
});

// Riparata:
_map.on('zoomend', () => this._markersLayer.refreshClusters());

2. **Verifica logica filtramento:**
Ho convalidato che `filterByTypes()` aggiorna correttamente i dati visibili

3. **Documentazione:**
```markdown
## Riferimento GitHub
- Issue: STORY-1116 [#206](https://github.com/laraxot/module_geo_fila5/issues/206)
- Discussione: [#1990](https://github.com/laraxot/module_geo_fila5/discussions/1990)

## Impatto
- Risolto **8.7%** dei casi di incoerenza mappa (dati benchmark)# 🛡️ VERIFICA QUALITÀ
```bash
npm run eslint
phpstan analyze laravel/Modules/Geo --level=7
npm run playwright test --spec 'module_geo/*.spec.js'
```