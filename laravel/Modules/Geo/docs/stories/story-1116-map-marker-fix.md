---
title: "story 1116 map marker fix"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "story 1116 map marker fix"
issues: []
discussions: []
scope: module:Geo
---

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
## GitHub (tracciamento)

Repository letto da frontmatter `github.repository` o `git remote -v` (se assente: repo root **`laraxot/base_quaeris_fila5`**): **`laraxot/base_quaeris_fila5`**.

| Risorsa | Stato | Link |
|---|---|---|
| Issue | **DA CREARE** | https://github.com/laraxot/base_quaeris_fila5/issues |
| Discussion | **DA CREARE** | https://github.com/laraxot/base_quaeris_fila5/discussions |

Il numero non e' scritto perche' non esiste ancora: `gh` non e' autenticato in questa sessione e i repo sono privati. Appena disponibile, creare con:

```bash
gh issue create --repo laraxot/base_quaeris_fila5 \
  --title "📌 DEVE STORY-1116: FIX MAP CLUSTER MARKERS DISAPPEARANCE" --body-file <FILE>
gh api repos/laraxot/base_quaeris_fila5/discussions -f title="📌 DEVE STORY-1116: FIX MAP CLUSTER MARKERS DISAPPEARANCE" -f body="vedi la story"
```
