---
title: "Topic on-demand"
type: digest
status: active
qmd: "digest ceiling 100 on-demand"
---

# Topic on-demand

Sintesi automatica di 3 documenti (chiave `on-demand`).

## On-Demand Pattern — Module **Lang**

_Fonte: `on-demand-pattern-2.md`_

# On-Demand Pattern — Module **Lang**

**Fonte canonica**: [../../docs/wiki/rules/on-demand-pattern.md](../../docs/wiki/rules/on-demand-pattern.md)

## Principio

Questo module segue il **pattern on-demand** per rules, skills, commands e memories:

- ✅ **Vivono solo nel wiki** — ../../docs/wiki/
- ✅ **Caricati on-demand** — via trigger map o `qmd search`
- ❌ **NON pre-caricati** — mai embeddare nei bootstrap files
- ❌ **Nessuna duplicazione** — wiki = sorgente di verità unica

## Perché On-Demand?

1. **Contesto minimo** — Carico solo le regole pertinenti al task corrente
2. **Token efficient** — Nessun carico inutile all'avvio (~50K → ~2K token)
3. **Scalabile** — Aggiungere nuove rules non richiede modifiche ai bootstrap
4. **Manutenibile** — Una sola fonte di verità (wiki)

## Come Funziona

### Step-by-Step

\`\`\`bash
# 1. Identifico il trigger nel task
# 2. Consulto la trigger map globale
Read ../../docs/wiki/rules/00-TRIGGER_MAP.md

## On-Demand Pattern — Module **Lang**

_Fonte: `wiki/integrations/_da-riconciliare/on-demand-pattern-2.md`_

# On-Demand Pattern — Module **Lang**

**Fonte canonica**: [../../docs/wiki/rules/on-demand-pattern.md](../../docs/wiki/rules/on-demand-pattern.md)

## Principio

Questo module segue il **pattern on-demand** per rules, skills, commands e memories:

- ✅ **Vivono solo nel wiki** — ../../docs/wiki/
- ✅ **Caricati on-demand** — via trigger map o `qmd search`
- ❌ **NON pre-caricati** — mai embeddare nei bootstrap files
- ❌ **Nessuna duplicazione** — wiki = sorgente di verità unica

## Perché On-Demand?

1. **Contesto minimo** — Carico solo le regole pertinenti al task corrente
2. **Token efficient** — Nessun carico inutile all'avvio (~50K → ~2K token)
3. **Scalabile** — Aggiungere nuove rules non richiede modifiche ai bootstrap
4. **Manutenibile** — Una sola fonte di verità (wiki)

## Come Funziona

### Step-by-Step

\`\`\`bash
# 1. Identifico il trigger nel task
# 2. Consulto la trigger map globale
Read ../../docs/wiki/rules/00-TRIGGER_MAP.md

## Topic on-demand

_Fonte: `wiki/topics/on-demand.md`_

# Topic on-demand

Sintesi automatica di 5 documenti (chiave `on-demand`).

## Divergenza: `on-demand-pattern-3.md`

_Fonte: `wiki/integrations/_da-riconciliare/on-demand-pattern-2.divergenza.md`_

# Divergenza: `on-demand-pattern-3.md`

Questo file veniva da `on-demand-pattern-3.md`, cancellato dal working tree senza migrazione. Il modulo ha gia' un file con lo stesso nome, ma con **corpo diverso**:

- versione del modulo: `laravel/Modules/Lang/docs/on-demand-pattern-2.md`
- versione recuperata: `laravel/Modules/Lang/docs/wiki/integrations/_da-riconciliare/on-demand-pattern-2.md`

Vanno confrontate e fuse a mano. Quando la fusione e' fatta, questo file e la nota vanno rimossi.

Vedi [XOT-5.39](../../../stories/5.39.wiki-integrations-ownership.story.md).

## Divergenza: `on-demand-pattern-4.divergenza.md`

_Fonte: `wiki/integrations/_da-riconciliare/on-demand-pattern-3.divergenza.md`_

# Divergenza: `on-demand-pattern-4.divergenza.md`

Questo file veniva da `docs/wiki/integrations/modules/lang/ON-DEMAND-PATTERN.md`, cancellato dal working tree senza migrazione. Il modulo ha gia' un file con lo stesso nome, ma con **corpo diverso**:

- versione del modulo: `laravel/Modules/Lang/docs/on-demand-pattern.md`
- versione recuperata: `laravel/Modules/Lang/docs/wiki/integrations/_da-riconciliare/on-demand-pattern-4.divergenza.md`
