---
title: "Rules Index"
<<<<<<< HEAD
<<<<<<< HEAD
type: index
created: 2026-05-11
updated: 2026-05-11
tags: [rules, index, on-demand]
related:
  - ../rules/00-TRIGGER_MAP.md
  - ../rules/on-demand-pattern.md
---

# Rules Index

Le Rules progettuali vivono qui, nel wiki del Module **Lang**, e vengono caricate **on-demand**.

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
type: "index"
tags: [rules, lang, translations, localization]
module: "Lang"
created: 2026-05-12
updated: 2026-06-12
qmd: "Lang rules translation governance factory auto increment id pest sqlite"
issues:
  - "https://github.com/laraxot/base_fixcity_fila5/issues/345"
discussions:
  - "https://github.com/laraxot/base_fixcity_fila5/discussions/273"
---

# Rules — Lang Module Wiki

> Regole ricorrenti del modulo Lang. Load on-demand.

## Available Rules
- [context-overflow-prevention](../../../../../docs/wiki/rules/context-overflow-prevention.md) — prevenzione 262K token overflow; file vietati; tool output compression

- [translation-key-governance](./translation-key-governance.md) — ownership delle chiavi, struttura semantica e divieto di `->label()`/stringhe inline
- [translation-factory-auto-increment-id](./translation-factory-auto-increment-id.md) — factory Lang: non impostare `id` manuale su colonne auto-increment
- [laravel12-lang-path-rule](../concepts/laravel12-lang-path-rule.md) — il path canonico resta `lang/` e non `resources/lang/`
- [schema-conventions](../../../../../docs/wiki/rules/schema-conventions.md) — convenzioni globali per label e traduzioni gestite da `LangServiceProvider`
- [filament-rules-summary](../../../../../docs/wiki/rules/filament-rules-summary.md) — guardrail Filament che impattano anche il modulo Lang

## Usage

```bash
qmd search "Lang module rule translation key" --limit 5
```

---

**Upstream:** [Root Trigger Map](../../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
<<<<<<< HEAD
>>>>>>> 40b96bcd6 (.)
=======
>>>>>>> origin/dev
