# geo-map-marker — sfondo stato (farmshops parity)

## scopo

I marker su `map-lit` devono leggersi come [farmshops.eu](https://github.com/CodeforKarlsruhe/farmshops.eu): **corpo colorato per stato**, glifo tipologia leggibile su **pad bianco**, **punta** per l’ancoraggio GPS.

| Canale | sorgente |
|--------|----------|
| Corpo + punta | `TicketStatusEnum` → `ticketStatus.color` |
| Glifo centrale | `TicketTypeEnum` → `iconUrl` su pad bianco |

## implementazione (2026-06-03)

**SSoT codice:** `resources/js/components/map/marker-config.js`

```text
.geo-map-marker-card__shell   → hover lift (transform-origin 50% 100%)
.geo-map-marker-card__inner   → 36×36 squircle, gradiente stato, bordo bianco
.geo-map-marker-card__glyph-pad → 28×28 #fff, glifo tipologia 22px a colori
.geo-map-marker-card__point   → triangolo 8px, border-top = --status-color
```

**Dimensioni Leaflet:** 40×44 px; `iconAnchor` `[20, 44]`; `popupAnchor` `[0, -42]`.

Variabili inline: `--status-color`, `--status-fill` (α 0.94), `--status-glow` (α 0.38).

### criteri UX

- Ancoraggio: vertice `__point` = coordinate feature.
- Contrasto: alone bianco + ring + drop-shadow tintato.
- Hover: `transform` su `__shell` — **vietato** `transform` su `.leaflet-marker-icon` (STORY-123).

Tema rinforzo: `Themes/Sixteen/resources/css/app/07-map-clusters-and-leaflet.css` — `__glyph-pad`, `__point`, glifo 22px `filter: none`.

## ricostruzione da documentazione

Vedi [geo-map-lit-reconstruction-guide.md](./geo-map-lit-reconstruction-guide.md) sezione **marker**.

## anti-pattern

- Corpo marker tutto bianco con solo bordo colorato.
- Tag `<header>` nel popup (altro componente) — non confondere con marker.
- `iconAnchor` al centro del quadrato (errore posizione).
- Hover con `transform` separato su corpo e punta (disallinea visivamente).

## github

- [module_geo_fila5#44](https://github.com/laraxot/module_geo_fila5/issues/44) — STORY-130 sfondo stato
- [module_geo_fila5#43](https://github.com/laraxot/module_geo_fila5/issues/43) — popup STORY-129

## story

- [STORY-130](../../../../../docs/stories/STORY-130-map-marker-status-colored-fill.md)

## collegamenti

- [ticket-type-vs-status-map-semantics.md](./ticket-type-vs-status-map-semantics.md)
- [geo-map-lit-farmshops-parity.md](./geo-map-lit-farmshops-parity.md)
- [geo-map-popup-leaflet-boundary.md](../../../../../Themes/Sixteen/docs/wiki/concepts/geo-map-popup-leaflet-boundary.md)
- [geo-map-lit-reconstruction-guide.md](./geo-map-lit-reconstruction-guide.md)
- [map-popup-header-whitespace-fix.md](../troubleshooting/map-popup-header-whitespace-fix.md)
