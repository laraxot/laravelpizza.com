---
title: "BMAD story — second brain UI/UX MCP e prompt compatto"
type: agent-chat
tags: [bmad, story, mcp, llm-wiki, ui-tooling]
created: 2026-06-03
updated: 2026-06-03
related:
  - ../wiki/concepts/ui-ai-tooling-on-demand.md
  - ../../bashscripts/tools/prompts/llm-wiki.txt
---

# Story 166 — second brain UI/UX MCP on-demand

**Stato:** in progress (dev-story)
**Issue mono:** [#166](https://github.com/provtv/base_ptv_fila5_mono/issues/166)
**Issue correlata:** [#165](https://github.com/provtv/base_ptv_fila5_mono/issues/165) (BMAD v6 install)
**Discussion mono:** (da aprire se serve dibattito multi-agente — Discussions abilitate su `provtv/base_ptv_fila5_mono`)

## User story

Come agente sul monorepo, voglio un prompt `llm-wiki.txt` compatto e wiki federata per UI/MCP/BMAD, così ogni sessione carica pochi token e applica verifiche empiriche on-demand.

## Acceptance criteria

- [x] `docs/wiki/concepts` symlink verso `bashscripts/ai/concepts/`
- [x] Nessuna `.cache/` in root repo
- [x] `llm-wiki.txt` ridotto (~120 righe) con router verso wiki
- [x] Matrice UI tooling documentata (`ui-ai-tooling-on-demand.md`)
- [x] Trigger map riga UI/UX MCP
- [x] Rimosso `bashscripts/ai/.agents/node_modules` (gate)
- [x] QMD ingest post-modifica strutturale (`qmd update` OK; embed opzionale: 17365 hash)
- [ ] Commento/issue moduli UI-heavy (es. `theme_*`) con puntatore DRY

## Dev story — implementazione 2026-06-03

| Azione | Esito |
|--------|--------|
| Compattato `bashscripts/tools/prompts/llm-wiki.txt` | 1031 → ~120 righe |
| Fix remote issue `base_ptv_fila5_mono` nel prompt | OK |
| Gate `verify-llm-wiki.sh` | da rieseguire |
| BMAD v6 tree | `bmad-skills/bmad-v6` già presente |

## Classificazione strumenti (sintesi)

- **Stack canonico:** 5 MCP minimi (vedi `mcp-minimum-stack.md`)
- **Opzionali verificati localmente:** Impeccable, Flowbite MCP, UI UX Pro Max
- **Solo con licenza/OAuth:** daisyUI Blueprint, Windframe, Tailkit
- **Informativo:** Tailkits article, Tailwind MCP (Pinterest)

## Domande agli altri agenti

1. Aggiungiamo `flowbite` a `.cursor/mcp.json` di default o solo su issue UI?
2. Dove mettere `PRODUCT.md`/`DESIGN.md` Impeccable — root mono o per tema attivo?

— Cursor (`composer-2.5-fast`)
