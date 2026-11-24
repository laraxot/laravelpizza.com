---
title: "ECC — indice operativo Xot"
type: index
status: in-progress
updated: 2026-11-17
module: Xot
<<<<<<< HEAD
qmd: "ECC indice Xot verification gates esito phpstan saturazione swarm"
=======
<<<<<<< .merge_file_FZbVAM
qmd: "ECC indice Xot verification gates esito"
=======
qmd: "ECC indice Xot verification gates esito phpstan saturazione swarm"
>>>>>>> .merge_file_aonTvP
>>>>>>> laraxot/dev
---

# ECC — modulo Xot

<!-- supersedes: indice senza nota saturazione PHPStan; linked-from: ecc-ptvx-workflow SKILL, workflows.md; user: "fa tutto in parallelo utilizzando swarm + subagents + bmad + ecc + second brain" -->

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).
Ordine sintetico: [workflows.md](./workflows.md).

Su worktree condiviso: prima di PHPStan rispettare saturazione HARD
<<<<<<< HEAD
([11-phpstan](../../../../../bashscripts/docs/prompts/11-phpstan.md),
[46-swarm](../../../../../bashscripts/docs/prompts/46-multi-agent-module-swarm.md),
=======
<<<<<<< HEAD
([37-phpstan](../../../../../bashscripts/docs/prompts/37-phpstan.md),
[04-swarm-multi-agente](../../../../../bashscripts/docs/prompts/04-swarm-multi-agente.md),
=======
([11-phpstan](../../../../../bashscripts/docs/prompts/11-phpstan.md),
[46-swarm](../../../../../bashscripts/docs/prompts/46-multi-agent-module-swarm.md),
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
[memoria](../../../../../bashscripts/ai/wiki/memories/phpstan-host-saturation-max-three.md),
[STOP thrashing](../../../../../docs/chat/STOP-phpstan-process-thrashing.md)).

| Controllo | Stato | Evidenza |
|---|---|---|
<<<<<<< HEAD
| Inventario statico | verificato (2026-11-16) | [audit](../bmad/audits/xot-audit.md) |
| PHPStan `Modules/Xot` | 0 errori (rerun; prima passata 6+ errori in `FeatureFlagsTest` mentre un altro agente lo editava) | `phpstan analyse Modules/Xot` (17:10 / rerun 17:21) |
| Pest | skip documentato | DB test `10.100.200.53` irraggiungibile + `TestDatabaseGuard` |
=======
<<<<<<< HEAD
| Inventario statico | verificato (2026-11-16) | [audit](../bmad/audits/xot-audit.md) |
| PHPStan `Modules/Xot` | 0 errori (rerun; prima passata 6+ errori in `FeatureFlagsTest` mentre un altro agente lo editava) | `phpstan analyse Modules/Xot` (17:10 / rerun 17:21) |
| Pest | skip documentato | DB di test configurato irraggiungibile + `TestDatabaseGuard` |
=======
<<<<<<< .merge_file_FZbVAM
| Inventario statico | verificato | ../bmad/audits/xot-audit.md |
| PHPStan | 0 su tree Modules (2026-11-16) | comando in audit |
| Pest | pending | ambiente testing |
| Security review | pending | story figlie P0/P1 |
| Docs pack | aggiornato | questo indice + audit ECC |
=======
>>>>>>> .merge_file_aonTvP
| Inventario statico | verificato (2026-11-16) | [audit](../bmad/audits/xot-audit.md) |
| PHPStan `Modules/Xot` | 0 errori (rerun; prima passata 6+ errori in `FeatureFlagsTest` mentre un altro agente lo editava) | `phpstan analyse Modules/Xot` (17:10 / rerun 17:21) |
| Pest | skip documentato | DB test `10.100.200.53` irraggiungibile + `TestDatabaseGuard` |
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
| Security review | parziale | P2-X3 `HandleArtisanActRequestAction`; `--force` solo su SQLite di test e symlink opt-in |
| Docs pack | aggiornato | audit, epics, decision-log, brainstorming, story |

Dettaglio: [xot-ecc-audit.md](./xot-ecc-audit.md)
