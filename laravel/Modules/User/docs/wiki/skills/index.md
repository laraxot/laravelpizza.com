---
title: "Skills Index"
type: index
created: 2026-05-11
updated: 2026-05-11
tags: [skills, index, on-demand]
related:
  - ../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md
  - ../../../../../../docs/wiki/rules/00-ON_DEMAND_PATTERN.md
qmd: "skills regola pattern caricamento note aggiungere nuova"
---

# Skills Index

Le Skills progettuali vivono qui, nel wiki del Module **User**, e vengono caricate **on-demand**.

> Vedi anche → [Trigger Map](../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)

## Regola

1. individua il trigger del task
2. consulta `docs/wiki/rules/00-TRIGGER_MAP.md` (root del progetto)
3. se serve, esegui `qmd search "<topic>"`
4. leggi solo la Skills wiki pertinente

## Pattern di caricamento

| Pattern | Comando |
|---------|---------|
| Carica Skills specifica | `Read ../skills/<name>.md` |
| Ricerca semantica | `qmd search "<topic>"` |
| Via trigger map | Consulta `docs/wiki/rules/00-TRIGGER_MAP.md` |

## Note

- La sorgente di verita' per le Skills e' sempre il wiki locale
- Non embeddare Skills nei prompt di avvio
- Per Skills globali, consulta il [wiki root](../../../../../../docs/wiki/skills/index.md)

## Aggiungere una Nuova SKILLS

1. Crea `../skills/<nome>.md` con contenuto completo
2. Aggiungi la voce in `docs/wiki/rules/00-TRIGGER_MAP.md`
3. Aggiorna questo indice se la Skills e' ricorrente
4. Committa: `docs: add skills <nome>`
