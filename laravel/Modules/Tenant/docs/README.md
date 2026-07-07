---
title: documentazione modulo Tenant
module: Tenant
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo Tenant

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Multi-tenancy module for the Laraxot ecosystem: single application instance serving multiple tenants with data isolation.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Tenant/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Tenant`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-INDEX | [00-INDEX.md](./00-INDEX.md) |
| 00-index | [00-index.md](./00-index.md) |
| METODI_DUPLICATI_ANALISI | [METODI_DUPLICATI_ANALISI.md](./METODI_DUPLICATI_ANALISI.md) |
| ON-DEMAND-PATTERN | [ON-DEMAND-PATTERN.md](./ON-DEMAND-PATTERN.md) |
| PERFORMANCE-OPTIMIZATION | [PERFORMANCE-OPTIMIZATION.md](./PERFORMANCE-OPTIMIZATION.md) |
| PRD | [PRD.md](./PRD.md) |
| PRODUCT_LAUNCH_PLAN | [PRODUCT_LAUNCH_PLAN.md](./PRODUCT_LAUNCH_PLAN.md) |
| PRODUCT_ROADMAP | [PRODUCT_ROADMAP.md](./PRODUCT_ROADMAP.md) |
| PRODUCT_STRATEGY | [PRODUCT_STRATEGY.md](./PRODUCT_STRATEGY.md) |
| PROJECT-STRUCTURE | [PROJECT-STRUCTURE.md](./PROJECT-STRUCTURE.md) |
| QMD-SETUP | [QMD-SETUP.md](./QMD-SETUP.md) |
| REDUNDANCY_ANALYSIS | [REDUNDANCY_ANALYSIS.md](./REDUNDANCY_ANALYSIS.md) |
| SPRINT_PLANNING | [SPRINT_PLANNING.md](./SPRINT_PLANNING.md) |
| SUSHI_TO_JSON_FIX_PLAN | [SUSHI_TO_JSON_FIX_PLAN.md](./SUSHI_TO_JSON_FIX_PLAN.md) |
| TODO | [TODO.md](./TODO.md) |
| USER_RESEARCH | [USER_RESEARCH.md](./USER_RESEARCH.md) |
| about | [about.md](./about.md) |
| activitylog | [activitylog.md](./activitylog.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| ai-methodologies | [ai-methodologies.md](./ai-methodologies.md) |
| alternatives | [alternatives.md](./alternatives.md) |
| api-integration | [api-integration.md](./api-integration.md) |
| app | [app.md](./app.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| arr-first-vs-collect-first-decision | [arr-first-vs-collect-first-decision.md](./arr-first-vs-collect-first-decision.md) |
| arr-first-vs-collect-first-ision | [arr-first-vs-collect-first-ision.md](./arr-first-vs-collect-first-ision.md) |
| auth | [auth.md](./auth.md) |
| best-practices | [best-practices.md](./best-practices.md) |
| business-logic-deep-dive | [business-logic-deep-dive.md](./business-logic-deep-dive.md) |
| case-sensitivity-rules | [case-sensitivity-rules.md](./case-sensitivity-rules.md) |
| chaos-monkey-tenant-isolation-checklist | [chaos-monkey-tenant-isolation-checklist.md](./chaos-monkey-tenant-isolation-checklist.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| codex-error-fix | [codex-error-fix.md](./codex-error-fix.md) |
| confidence_guidelines | [confidence_guidelines.md](./confidence_guidelines.md) |
| configuration-logic-analysis | [configuration-logic-analysis.md](./configuration-logic-analysis.md) |
| configuration | [configuration.md](./configuration.md) |
| conflict-resolution-fixes | [conflict-resolution-fixes.md](./conflict-resolution-fixes.md) |
| conflict-resolution | [conflict-resolution.md](./conflict-resolution.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
