---
title: "Skills Index"
type: index
created: 2026-05-11
updated: 2026-05-11
tags: [skills, index, on-demand]
related:
  - ../rules/00-TRIGGER_MAP.md
  - ../rules/on-demand-pattern.md
---

# Skills Index

Le Skills progettuali vivono qui, nel wiki del Module **Seo**, e vengono caricate **on-demand**.

> Vedi anche → [Trigger Map](../rules/00-TRIGGER_MAP.md)

## Regola

1. individua il trigger del task
2. consulta `../rules/00-TRIGGER_MAP.md`
3. se serve, esegui `qmd search "<topic>"`
4. leggi solo la Skills wiki pertinente

## Pattern di caricamento

| Pattern | Comando |
|---------|---------|
| Carica Skills specifica | `Read ../skills/<name>.md` |
| Ricerca semantica | `qmd search "<topic>"` |
| Via trigger map | Consulta `../rules/00-TRIGGER_MAP.md` |

## Note

- La sorgente di verita' per le Skills e' sempre il wiki locale
- Non embeddare Skills nei prompt di avvio
- Per Skills globali, consulta il [wiki root](../../docs/wiki/skills/INDEX.md)

## Aggiungere una Nuova SKILLS

1. Crea `../skills/<nome>.md` con contenuto completo
2. Aggiungi la voce in `../rules/00-TRIGGER_MAP.md`
3. Aggiorna questo indice se la Skills e' ricorrente
4. Committa: `docs: add skills <nome>`

