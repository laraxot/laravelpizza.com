---
title: "ECC — indice operativo Xot"
type: index
status: review
updated: 2026-11-25
module: Xot
qmd: "ECC indice Xot verification gates esito phpstan saturazione swarm action naming"
---

# ECC — modulo Xot

<!-- supersedes: indice senza nota saturazione PHPStan; linked-from: ecc-ptvx-workflow SKILL, workflows.md; user: "fa tutto in parallelo utilizzando swarm + subagents + bmad + ecc + second brain" -->

Collega le verifiche ECC al workflow PTVX (BMAD → lock → fix → PHPStan/Pest → docs).
Ordine sintetico: [workflows.md](./workflows.md).

Su worktree condiviso: prima di PHPStan rispettare saturazione HARD
([37-phpstan](../../../../../bashscripts/docs/prompts/quality-gates.md),
[04-swarm-multi-agente](../../../../../bashscripts/docs/prompts/agent-workflow.md),
[memoria](../../../../../bashscripts/ai/wiki/memories/phpstan-swarm-config.md#phpstan-host-saturation-max-three),
[STOP thrashing](../../../../../docs/chat/STOP-phpstan-process-thrashing.md)).

| Controllo | Stato | Evidenza |
|---|---|---|
| Inventario statico | verificato (2026-11-16) | [audit](../bmad/audits/xot-audit.md) |
| PHPStan `Modules/Xot` | ultimo stato storico: 0 errori; gate globale corrente bloccato da parse error in `Modules/User` | `phpstan analyse Modules/Xot` storico; gate globale 2026-11-24 documentato in [xot-ecc-audit.md](./xot-ecc-audit.md) |
| Pest | skip documentato | DB di test configurato irraggiungibile + `TestDatabaseGuard` |
| Security review | parziale | P2-X3 `HandleArtisanActRequestAction`; `--force` solo su SQLite di test e symlink opt-in |
| Docs pack | aggiornato | audit, epics, decision-log, brainstorming, story |
| Action naming `Resolve*` → `Get*` | verificato (2026-11-25) | ADR [0016](../adr/0016-action-names-get-not-resolve.md); Pest `NoResolveActionNamingTest`; `app/Actions` Modules senza `Resolve*Action.php` |
| No docs archive folders | verificato (2026-11-25) | ADR [0041](../adr/0041-no-docs-archive-folders.md); root [0006](../../../../../docs/adr/0006-no-docs-archive-folders.md); Pest `NoDocsArchiveFoldersTest`; gitignore fleet |

Dettaglio: [xot-ecc-audit.md](./xot-ecc-audit.md)

## Audit convenzioni e qualità — 2026-11-24

L'audit corrente ha verificato AGENTS.md, le story BMAD attive, il contratto
`@see` e il perimetro ECC. Le correzioni consentite sono state limitate a
questa documentazione Xot. I marker Git rilevati in `Modules/UI` e `Modules/User`
restano fuori perimetro: non sono stati modificati.
