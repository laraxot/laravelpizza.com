<<<<<<< HEAD
<<<<<<< HEAD
---
title: "Rules Index"
type: index
created: 2026-05-11
updated: 2026-05-11
tags: [rules, index, on-demand]
related:
  - ../rules/00-TRIGGER_MAP.md
  - ../rules/on-demand-pattern.md
---

# Rules Index

Le Rules progettuali vivono qui, nel wiki del Module **Job**, e vengono caricate **on-demand**.

> Vedi anche → [Trigger Map](../rules/00-TRIGGER_MAP.md)

## Regola

1. individua il trigger del task
2. consulta `../rules/00-TRIGGER_MAP.md`
3. se serve, esegui `qmd search "<topic>"`
4. leggi solo la Rules wiki pertinente

## Pattern di caricamento

| Pattern | Comando |
|---------|---------|
| Carica Rules specifica | `Read ../rules/<name>.md` |
| Ricerca semantica | `qmd search "<topic>"` |
| Via trigger map | Consulta `../rules/00-TRIGGER_MAP.md` |

## Note

- La sorgente di verita' per le Rules e' sempre il wiki locale
- Non embeddare Rules nei prompt di avvio
- Per Rules globali, consulta il [wiki root](../../docs/wiki/rules/INDEX.md)

## Aggiungere una Nuova RULES

1. Crea `../rules/<nome>.md` con contenuto completo
2. Aggiungi la voce in `../rules/00-TRIGGER_MAP.md`
3. Aggiorna questo indice se la Rules e' ricorrente
4. Committa: `docs: add rules <nome>`

=======
=======
>>>>>>> origin/dev
# Job Module - rules Index

## Purpose
Index for Job module rules.

## On-Demand Loading

```bash
qmd search "Job rules" --limit 5
```

## See Also
- [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
- [Root Wiki](../../../docs/wiki/)

---
*Updated: 2026-05-11*

- [context-overflow-prevention](../../../../../docs/wiki/rules/context-overflow-prevention.md) — prevenzione 262K token overflow; file vietati; tool output compression
<<<<<<< HEAD
>>>>>>> 40b96bcd6 (.)
=======
>>>>>>> origin/dev
