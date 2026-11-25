---
title: "INDEX ADR — UI"
type: index
owner: UI
updated: 2026-11-25
qmd: "UI ADR INDEX 0001-0006 numbered MADR IDColumn blocks CMS"
---

# INDEX ADR — UI

Solo file con prefisso `NNNN-` (stub `superseded` non numerati esclusi dall'elenco).

| ADR | Stato | Sintesi |
|---|---|---|
| [0001-block-discovery-by-filament-blocks-folder](0001-block-discovery-by-filament-blocks-folder.md) | accepted | Scoperta blocchi da `app/Filament/Blocks` per modulo |
| [0002-idcolumn-mandatory-on-tables](0002-idcolumn-mandatory-on-tables.md) | accepted | Ogni tabella Filament espone `IDColumn` (self-link `#record-{id}`) |
| [0003-missing-block-view-shows-type-not-content](0003-missing-block-view-shows-type-not-content.md) | accepted | Vista mancante: avviso con tipo, mai il contenuto del blocco |
| [0004-optional-cms-delegation-for-block-data](0004-optional-cms-delegation-for-block-data.md) | accepted | Delega opzionale a Cms per dati blocco, senza dipendenza dura |
| [0005-ui-blocks-use-cms-localization](0005-ui-blocks-use-cms-localization.md) | accepted | Blocchi UI localizzati dal CMS con ripiego autonomo |
| [0006-ui-does-not-authorize-domain-data](0006-ui-does-not-authorize-domain-data.md) | proposed | UI è layer condiviso e non autorizza il dominio Geo |

Formato e regole: [README](README.md).
