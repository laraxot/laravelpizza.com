---
title: documentazione tema Three
module: Three
type: index
status: approved
tags: [documentation, readme, tema, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — tema Three

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Tema Three Laraxot PTVX — documentazione operativa.

## Dove iniziare

- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Three/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Themes\Three`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| changelog | [changelog.md](./changelog.md) |
| context-compression | [context-compression.md](./context-compression.md) |
| docs-archive-policy | [docs-archive-policy.md](./docs-archive-policy.md) |
| filament-version | [filament-version.md](./filament-version.md) |
| laravel-13-composer-boundary | [laravel-13-composer-boundary.md](./laravel-13-composer-boundary.md) |
| laravel-13-upgrade | [laravel-13-upgrade.md](./laravel-13-upgrade.md) |
| naming-conventions | [naming-conventions.md](./naming-conventions.md) |
| release-marketing-standard | [release-marketing-standard.md](./release-marketing-standard.md) |
| second-brain | [second-brain.md](./second-brain.md) |
| spatie-permission-team-context | [spatie-permission-team-context.md](./spatie-permission-team-context.md) |
| spatie-permission-teams-boundary | [spatie-permission-teams-boundary.md](./spatie-permission-teams-boundary.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../../../Modules/Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
