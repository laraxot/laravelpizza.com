---
title: "Skills Index"
<<<<<<< HEAD
<<<<<<< HEAD
type: index
created: 2026-05-11
updated: 2026-05-11
tags: [skills, index, on-demand]
related:
  - ../rules/00-TRIGGER_MAP.md
  - ../rules/on-demand-pattern.md
---

# Skills Index

Le Skills progettuali vivono qui, nel wiki del Module **Lang**, e vengono caricate **on-demand**.

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

=======
=======
>>>>>>> origin/dev
type: "index"
tags: [skills, lang, translations, localization]
module: "Lang"
updated: 2026-05-12
---

# Skills — Lang Module Wiki

> Skill operative del modulo Lang. Load on-demand.

## Available Skills

- [translation-key-audit](./translation-key-audit.md) — audit di chiavi, path e ownership delle traduzioni modulo/tema/Filament

## Usage

```bash
qmd search "Lang module skill translation audit" --limit 5
```

---

**Upstream:** [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
<<<<<<< HEAD
>>>>>>> 40b96bcd6 (.)
=======
>>>>>>> origin/dev
