---
title: documentazione modulo indennitaresponsabilita
module: IndennitaResponsabilita
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo IndennitaResponsabilita

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Responsibility allowances module for the Laraxot ecosystem: position-based bonuses, role compensation, and management allowances.

## Dove iniziare

- **[Architecture Patterns](./architecture-patterns.md)** — Design patterns, workflows, approval chains
- **[Documentation Index](./INDEX.md)** — Table of contents e navigazione completa
- [Wiki locale](./wiki/index.md)
- [PHPStan Analysis](./phpstan-analysis.md)
- [Audit ridondanza](./code-redundancy-audit.md)
- [Regole architettura](./architecture-rules.md)
- [Disciplina agenti](./agent-edit-discipline.md)


## Struttura tipica

```text
IndennitaResponsabilita/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\IndennitaResponsabilita`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/)
- [Wiki progetto](../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.

---

## ✅ PHPStan Status — Verifica 2026-07-01

| Data | Livello | Errori |
|------|---------|--------|
| 2026-07-01 | max | **0** |

```bash
./vendor/bin/phpstan analyze Modules/IndennitaResponsabilita --level=max --memory-limit=512M
# [OK] No errors
```

Modulo conforme alle regole Laraxot:
- Classi Filament estendono XotBase (mai direttamente Filament)
- Nessun label/placeholder/tooltip hardcoded
- Nessun BadgeColumn (usa TextColumn::make()->badge())
- Actions usano QueueableAction pattern
- Nessun Service tradizionale
