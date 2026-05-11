# Geo Module — Wiki Schema

## Struttura wiki

```
docs/
  wiki/
    index.md       ← indice navigabile (obbligatorio)
    log.md         ← log operazioni (obbligatorio)
    schema.md      ← questo file
    concepts/      ← pattern e regole architetturali (MapPicker, Leaflet, etc.)
    entities/      ← MapPicker, LocationPicker, CoordinatePickerField
    summaries/     ← sommari documenti
```

## Regole ingest

- `docs/` = raw source layer (immutabile, non modificare salvo ingest esplicito)
- `docs/wiki/` = compiled wiki layer (LLM sintetizza e aggiorna qui)
- Nuovi concetti → `concepts/<kebab-case>.md`
- Nuove entità → `entities/<kebab-case>.md`

## QMD collection

```bash
qmd search "mappicker leaflet" -c mod-geo
qmd search "coordinate picker" -c mod-geo
```
