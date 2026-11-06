---
qmd: "index"
issues: []
discussions: []
title: "Memories Index"
type: index
created: 2026-05-11
updated: 2026-07-27
tags: [memories, index, on-demand, github, remote]
related:
  - ../rules/00-TRIGGER_MAP.md
  - ../rules/on-demand-pattern.md
status: draft
---

# Memories Index

Le Memories progettuali vivono qui, nel wiki del Module **Tenant**, e vengono caricate **on-demand**.

> Vedi anche → [Trigger Map](../rules/00-TRIGGER_MAP.md)

## Regola

1. individua il trigger del task
2. consulta `../rules/00-TRIGGER_MAP.md`
3. se serve, esegui `qmd search "<topic>"`
4. leggi solo la Memories wiki pertinente

## Pattern di caricamento

| Pattern | Comando |
|---------|---------|
| Carica Memories specifica | `Read ../memories/<name>.md` |
| Ricerca semantica | `qmd search "<topic>"` |
| Via trigger map | Consulta `../rules/00-TRIGGER_MAP.md` |

## Note

- La sorgente di verita' per le Memories e' sempre il wiki locale
- Non embeddare Memories nei prompt di avvio
- Per Memories globali, consulta il [wiki root](../../docs/wiki/memories/INDEX.md)

## Memories locali (ricorrenti)

| Trigger | File |
|---------|------|
| Link GitHub / merge su `base_*` / `git remote -v` | [github-remote-collision-wrong-base.md](./github-remote-collision-wrong-base.md) |

## Aggiungere una Nuova MEMORIES

1. Crea `../memories/<nome>.md` con contenuto completo
2. Aggiungi la voce in `../rules/00-TRIGGER_MAP.md`
3. Aggiorna questo indice se la Memories e' ricorrente
4. Committa: `docs: add memories <nome>`

