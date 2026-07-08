---
title: "Mirror skill .agents vs .codex (bashscripts)"
module: "AI"
type: "comparison"
updated: "2026-05-04"
---

# Mirror skill: `.agents` e `.codex` nel repo FixCity

## Perché è nel modulo AI

Il modulo **AI** governa integrazioni LLM, MCP e flussi operativi che consumano skill e contesto. La convivenza di più alberi (`bashscripts/ai/.agents`, `.codex/skills`, symlink root) impatta **budget token** e onboarding operatori.

## Sintesi tecnica

Inventario statico al **2026-05-04**:

- `bashscripts/ai/.agents/skills`: **252** file `SKILL.md`
- `.codex/skills`: **252** file `SKILL.md`
- Differenza per **nome cartella** skill: **0** / **0** (insiemi uguali)

Dettaglio e policy anti-deduplica cieca: documentazione canonica in bashscripts (non duplicare tabelle qui).

## Collegamenti

- [Inventario e policy complete](../../../../bashscripts/docs/wiki/comparisons/agents-skills-mirror-codex-inventory.md)
- [Agents context budget (bashscripts)](../../../../bashscripts/docs/wiki/concepts/agents-context-budget-and-deduplication.md)
- [CONTEXT_BUDGET](../../../../bashscripts/ai/.agents/CONTEXT_BUDGET.md) (file operativo nella tree `.agents`)

---

**Ultimo aggiornamento:** 2026-05-04
