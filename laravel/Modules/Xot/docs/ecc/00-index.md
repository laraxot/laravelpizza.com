---
title: "ECC — indice operativo Xot"
type: index
status: in-progress
updated: 2026-11-17
module: Xot
qmd: "ECC indice Xot verification gates esito phpstan saturazione swarm"
---

# ECC — modulo Xot

<!-- supersedes: indice senza nota saturazione PHPStan; linked-from: ecc-ptvx-workflow SKILL, workflows.md; user: "fa tutto in parallelo utilizzando swarm + subagents + bmad + ecc + second brain" -->

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).
Ordine sintetico: [workflows.md](./workflows.md).

Su worktree condiviso: prima di PHPStan rispettare saturazione HARD
([37-phpstan](../../../../../bashscripts/docs/prompts/37-phpstan.md),
[04-swarm-multi-agente](../../../../../bashscripts/docs/prompts/04-swarm-multi-agente.md),
[memoria](../../../../../bashscripts/ai/wiki/memories/phpstan-host-saturation-max-three.md),
[STOP thrashing](../../../../../docs/chat/STOP-phpstan-process-thrashing.md)).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato (2026-11-16) | [audit](../bmad/audits/xot-audit.md) |
| PHPStan `Modules/Xot` | 0 errori (rerun; prima passata 6+ errori in `FeatureFlagsTest` mentre un altro agente lo editava) | `phpstan analyse Modules/Xot` (17:10 / rerun 17:21) |
| Pest | skip documentato | DB di test configurato irraggiungibile + `TestDatabaseGuard` |
| Security review | parziale | P2-X3 `HandleArtisanActRequestAction`; `--force` solo su SQLite di test e symlink opt-in |
| Docs pack | aggiornato | audit, epics, decision-log, brainstorming, story |

Dettaglio: [xot-ecc-audit.md](./xot-ecc-audit.md)
