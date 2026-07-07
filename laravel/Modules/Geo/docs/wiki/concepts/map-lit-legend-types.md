> **OBSOLETO (STORY-125):** legenda tipologie errata. Vedi [map-legend-status-semantics.md](./map-legend-status-semantics.md).

# map-lit — legenda tipologie colore (STORY-094)

## Scopo

Spiegare sulla mappa il significato dei **colori pin/cluster** senza obbligare l'utente a cliccare un marker o dedurre dai filtri laterali.

## Business logic

| Domanda utente | Risposta in UI |
|----------------|----------------|
| Cosa significa il verde/viola sul pin? | Voce legenda con pallino colore + label tipo |
| Ho filtrato una categoria | Legenda mostra solo i tipi ancora presenti nel layer |

Fonte dati: stesso contratto di `resolveFeatureTicketType()` usato per i marker (`feature-type.js`).

## Implementazione

| File | Ruolo |
|------|--------|
| `resources/js/components/map/legend.js` | `collectLegendTypesFromFeatures`, `mountMapLegend`, `refreshMapLegend` |
| `resources/js/components/map-lit.js` | `_syncMapLegend()` dopo load GeoJSON e in `filterByTypes` |
| `resources/js/components/map/styles.js` | Stili `.geo-map-legend*` (light-DOM) |

Control Leaflet: posizione `bottomleft` (non copre zoom/fullscreen a destra).

## Comportamento

1. Dopo fetch `/data/tickets.json` → tipi unici da `_allFeatures`
2. Filtro desktop → legenda aggiornata sui feature filtrati
3. Zero tipi → control rimosso

## Anti-pattern

- Legenda statica hardcoded in Blade (desincronizzata da JSON)
- Duplicare colori fuori da `feature-type.js`
- Posizionare legenda su `bottomright` (conflitto controlli mappa)

## Verifica

```bash
cd laravel/Themes/Sixteen && npm run build
cd laravel/Modules/Geo && npx playwright test map-lit-legend.spec.js
```

Selettore: `map-lit#block-map .geo-map-legend`

## GitHub

- Issue: [module_geo_fila5#14](https://github.com/laraxot/module_geo_fila5/issues/14)
- Story root: `docs/stories/STORY-094-map-legend-marker-colors.md`

## Collegamenti

- [map-lit-it-incidents-2026-06.md](../troubleshooting/map-lit-it-incidents-2026-06.md)
- [map-lit-cluster-type-icons.md](./map-lit-cluster-type-icons.md)
- Tema: [map-lit-legend-theme-boundary.md](../../../../../Themes/Sixteen/docs/wiki/concepts/map-lit-legend-theme-boundary.md)
