---
title: "On-Demand Pattern — Module Activity"
type: documentation
created: 2026-05-11
updated: 2026-05-11
tags: [on-demand, pattern, wiki, qmd]
related:
<<<<<<< .merge_file_vY4JAi
  - ../../docs/wiki/rules/on-demand-pattern.md
  - ../../docs/wiki/concepts/llm-wiki-operational-discipline.md
=======
  - ../../../../docs/wiki/rules/on-demand-pattern.md
  - ../../../../docs/wiki/concepts/llm-wiki-operational-discipline.md
status: draft
qmd: "on-demand pattern   module **activity** activity"
>>>>>>> .merge_file_espFVC
---

# On-Demand Pattern — Module **Activity**

<<<<<<< .merge_file_vY4JAi
**Fonte canonica**: [../../docs/wiki/rules/on-demand-pattern.md](../../docs/wiki/rules/on-demand-pattern.md)
=======
**Fonte canonica**: [../../docs/wiki/rules/on-demand-pattern.md](../../../../docs/wiki/rules/on-demand-pattern.md)
>>>>>>> .merge_file_espFVC

## Principio

Questo Module segue il **pattern on-demand** per rules, skills, commands e memories:

- ✅ **Vivono solo nel wiki** — ../../docs/wiki/
<<<<<<< .merge_file_vY4JAi
- ✅ **Caricati on-demand** — via trigger map o 
=======
- ✅ **Caricati on-demand** — via trigger map o
>>>>>>> .merge_file_espFVC
- ❌ **NON pre-caricati** — mai embeddare nei bootstrap files
- ❌ **Nessuna duplicazione** — wiki = sorgente di verità unica

## Perché On-Demand?

1. **Contesto minimo** — Carico solo le regole pertinenti al task corrente
2. **Token efficient** — Nessun carico inutile all'avvio (~50K → ~2K token)
3. **Scalabile** — Aggiungere nuove rules non richiede modifiche ai bootstrap
4. **Manutenibile** — Una sola fonte di verità (wiki)

## Come Funziona

### Step-by-Step

```bash
# 1. Identifico il trigger nel task
# 2. Consulto la trigger map globale
Read ../../docs/wiki/rules/00-TRIGGER_MAP.md

# 3. Carico on-demand la risorsa
Read docs/wiki/rules/<file>.md
# OPPURE
qmd search "<topic>"

# 4. Applico la regola/skill/command/memory
```

### Local vs Global

- **Locali** → Usa  (module-specific)
- **Globali** → Usa  (project-wide)

## Struttura di Questo Modulo

```
./laravel/Modules/Activity/docs/
├── wiki/                    # Knowledge base locale
│   ├── rules/INDEX.md      # Indice rules modulo-specifiche
│   ├── skills/INDEX.md     # Indice skills modulo-specifiche
│   ├── commands/INDEX.md   # Indici commands
│   └── memories/INDEX.md   # Indice memories
└── ON-DEMAND-PATTERN.md     # Questo file
```

## Quick Reference

| Bisogno | Azione |
|---------|--------|
| Trigger map globale | `Read ../../docs/wiki/rules/00-TRIGGER_MAP.md` |
| Pattern on-demand | `Read ../../docs/wiki/rules/on-demand-pattern.md` |
| Ricerca locale | `qmd search "topic" -c Activity` |
| Wiki locale | `Read ./laravel/Modules/Activity/docs/wiki/index.md` |

## Regole Critiche per Module

1. **Nessun bootstrap pesante** — Non elencare rules in AGENTS.md o CLAUDE.md
2. **Carica only what you need** — Ogni task carica max 3-5 file
3. **Mantieni la wiki aggiornata** — Dopo ogni task, aggiorna ./laravel/Modules/Activity/docs/wiki/log.md
4. **Rispetta la trigger map** — Se esiste, usala; altrimenti usa qmd search

## Eccezioni

- **Emergency fixes**: Puoi caricare regole aggiuntive se bloccante
- **Cross-module**: Quando un task tocca più moduli, carica i rispettivi local wiki

## Riferimenti

<<<<<<< .merge_file_vY4JAi
- [Global On-Demand Pattern](../../docs/wiki/rules/on-demand-pattern.md)
- [LLM Wiki Operational Discipline](../../docs/wiki/concepts/llm-wiki-operational-discipline.md)
- [Trigger Map](../../docs/wiki/rules/00-TRIGGER_MAP.md)
=======
- [Global On-Demand Pattern](../../../../docs/wiki/rules/on-demand-pattern.md)
- [LLM Wiki Operational Discipline](../../../../docs/wiki/concepts/llm-wiki-operational-discipline.md)
- [Trigger Map](../../../../docs/wiki/rules/00-TRIGGER_MAP.md)
>>>>>>> .merge_file_espFVC
- [Module Wiki Index](./wiki/index.md)

---
*Ultimo aggiornamento: 2026-05-11 | Pattern: on-demand via QMD*
