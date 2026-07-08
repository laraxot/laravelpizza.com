---
title: documentazione tema One
module: One
type: index
status: approved
tags: [documentation, readme, tema, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — tema One

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

One theme for Laraxot PTVX: minimal theme skeleton for future frontend development and customization.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
One/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Themes\One`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| advanced-manage-related-records | [advanced-manage-related-records.md](./advanced-manage-related-records.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| charts-integration | [charts-integration.md](./charts-integration.md) |
| code-quality-tools | [code-quality-tools.md](./code-quality-tools.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| common-errors | [common-errors.md](./common-errors.md) |
| changelog | [changelog.md](./changelog.md) |
| docs-archive-policy | [docs-archive-policy.md](./docs-archive-policy.md) |
| docs-deduplication | [docs-deduplication.md](./docs-deduplication.md) |
| dry-kiss-analysis | [dry-kiss-analysis.md](./dry-kiss-analysis.md) |
| filament-version | [filament-version.md](./filament-version.md) |
| html2pdf-integration | [html2pdf-integration.md](./html2pdf-integration.md) |
| laravel-13-composer-boundary | [laravel-13-composer-boundary.md](./laravel-13-composer-boundary.md) |
| laravel-13-upgrade | [laravel-13-upgrade.md](./laravel-13-upgrade.md) |
| launch-plan | [launch-plan.md](./launch-plan.md) |
| model-docs-governance | [model-docs-governance.md](./model-docs-governance.md) |
| naming-conventions | [naming-conventions.md](./naming-conventions.md) |
| phpstan-level10-analysis | [phpstan-level10-analysis.md](./phpstan-level10-analysis.md) |
| prd | [prd.md](./prd.md) |
| product-launch-plan | [product-launch-plan.md](./product-launch-plan.md) |
| product-requirements | [product-requirements.md](./product-requirements.md) |
| product-strategy | [product-strategy.md](./product-strategy.md) |
| readonly-field-styling | [readonly-field-styling.md](./readonly-field-styling.md) |
| release-marketing-standard | [release-marketing-standard.md](./release-marketing-standard.md) |
| roadmap | [roadmap.md](./roadmap.md) |
| schema | [schema.md](./schema.md) |
| second-brain | [second-brain.md](./second-brain.md) |
| spatie-permission-team-context | [spatie-permission-team-context.md](./spatie-permission-team-context.md) |
| spatie-permission-teams-boundary | [spatie-permission-teams-boundary.md](./spatie-permission-teams-boundary.md) |
| sprint-planning-meeting | [sprint-planning-meeting.md](./sprint-planning-meeting.md) |
| sprint-planning | [sprint-planning.md](./sprint-planning.md) |
| strategy | [strategy.md](./strategy.md) |
| theme-analysis | [theme-analysis.md](./theme-analysis.md) |
| troubleshooting | [troubleshooting.md](./troubleshooting.md) |
| user-research | [user-research.md](./user-research.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../../../Modules/Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
