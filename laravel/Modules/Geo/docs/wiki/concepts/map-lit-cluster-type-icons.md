# map-lit — icone tipo nel cluster (14px, no SVG oversize)

## Scopo

Nei cluster zoom ≥ 8 mostrare **diversità tipologica** con **icone tipo** (`iconUrl` da `TicketTypeEnum`, come [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu) mostra farm/market/automat), non colori **stato**.

**Gap 2026-06-06:** `_createClusterIcon` usa ancora `statusColor` — vedi [farmshops-cluster-type-icons-study.md](./farmshops-cluster-type-icons-study.md) e STORY-284.

## Sintomo (#12 / #13)

Icona trash (o altri glifi) **enorme** dentro il cerchio cluster su `/it`.

## Cause

1. SVG tipo senza vincolo dimensione dentro `.geo-cluster-type-icons`
2. Regola tema `main svg:not([width]) { max-width: 100% }` su SVG senza width esplicito
3. Confusione tra glifo marker singolo (14px in pin) e contenuto cluster LOD

## Soluzione

### JS — pallini colore, non glifi tipo

`buildClusterTypeDotHtml(color)` in `map/icon-glyph.js`:

- SVG 14×14 con `<circle>` colorato
- Classe `geo-cluster-type-dot` per CSS difensivo

`_createClusterIcon()` usa solo pallini per tipo presente nel cluster (zoom ≥ 8).

### CSS — doppio lock

| Layer | File |
|-------|------|
| Light-DOM Lit | `map/styles.js` → `.geo-cluster-type-icons svg/img` |
| Tema bundlato | `Themes/Sixteen/.../07-map-clusters-and-leaflet.css` |

Regole: `width/height/max 14px`, `flex: 0 0 auto`.

### MAI

- `transform: scale()` per "rimpicciolire" — rompe anchor Leaflet (vedi STORY-123)
- Inserire `buildMarkerGlyphHtml()` / trash SVG raw nel cluster

## Verifica

```bash
cd laravel/Modules/Geo && npx playwright test map-lit-cluster-icon-size.spec.js
```

Tutti i dot in cluster: 10–16px rendered.

## Collegamenti

- [marker-cluster-hover-stability.md](../../../../../Themes/Sixteen/docs/wiki/concepts/marker-cluster-hover-stability.md)
- [map-lit-it-incidents-2026-06.md](../troubleshooting/map-lit-it-incidents-2026-06.md) — incidente 4
- Memoria root: [map-lit-marker-cluster-farmshops-pattern.md](../../../../../../docs/wiki/memories/map-lit-marker-cluster-farmshops-pattern.md)
