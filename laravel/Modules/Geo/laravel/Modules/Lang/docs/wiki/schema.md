# Lang Module — Wiki Schema

## Struttura wiki

```
docs/
  wiki/
    index.md       ← indice navigabile (obbligatorio)
    log.md         ← log operazioni (obbligatorio)
    schema.md      ← questo file
    concepts/      ← pattern e regole architetturali
    entities/      ← translation files, locales
```

## Regole ingest

- `docs/` = raw source layer (immutabile)
- `docs/wiki/` = compiled wiki layer (LLM aggiorna)
- Nuovi concetti → `concepts/<kebab-case>.md`

## QMD collection

```bash
qmd search "translation locale" -c mod-lang
```
