---
title: "Activity: BMAD Method Integration"
description: "BMAD workflow documentation per il modulo Activity"
module: "Activity"
alias: "activity"
version: "1.0.0"
priority: 0
active: true
status: "core-foundation"
author: "Team Laraxot"
license: "Proprietary"
php_version: "^8.1"
core_version: "10.0"
dependencies: ["Xot", "User"]
extends: []
extended_by: 40
documentation_date: "2026-05-27"
bmad_version: "6.2.0"
bmad_track: "core-foundation"
type: index
updated: 2026-10-07
tags: [docs, activity, bmad]
qmd: "activity   bmad method integration activity"
---

# Activity: BMAD Method Integration

## Kit BMAD owner (canonico)

- [BMAD Planning](../bmad-planning.md)
- [BMAD Brainstorming](../bmad-brainstorming.md)
- [Filament blueprint](./filament-blueprint.md)
- [Project context](./project-context.md)
- [Decision log](./decision-log.md)

## Scopo BMAD per Activity

Activity è il **modulo di audit e tracciamento** dell'ecosistema. In BMAD, questo modulo rappresenta l'**osservabilità** del sistema: registra ogni azione significativa per debugging, compliance e analytics.

## Religione BMAD per Activity

Activity segue i principi BMAD di:

1. **Il log permane** - anche quando il token scade, il log resta
2. **Ogni azione ha una traccia** - nessuna operazione significativa è invisibile
3. **Actions, non Services** - la logica di logging passa per Actions
4. **PHPStan Level 10** - sicurezza tipografica non negoziabile
5. **Mai estendere Filament direttamente** - tutte le risorse admin passano per XotBase
6. **La docs è memoria** - ogni decisione di audit deve essere documentata

## Workflow BMAD Consigliati per Activity

### Phase 1: Analysis (Fondamentale per l'osservabilità)
```bash
bmad-domain-research      # Studio dominio audit, logging, compliance
bmad-technical-research   # Valutazione architettura event sourcing
bmad-create-product-brief # Breve su cosa Activity deve tracciare
```

### Phase 2: Planning
```bash
bmad-create-prd           # PRD modulo Activity: cosa loggare, come, per quanto tempo
bmad-create-architecture  # Architettura di logging (tabelle, indici, retention)
```

### Phase 3: Solutioning
```bash
bmad-create-epics-and-stories  # Epic: user actions, system events, compliance reports
bmad-check-implementation-readiness  # Validate prima di implementare
```

### Phase 4: Implementation
```bash
bmad-sprint-planning      # Sprint iniziale per feature di logging
bmad-create-story         # Story: model ActivityLog, migrazione
bmad-dev-story            # Implementazione azioni di logging
bmad-code-review          # Review con focus su performance e privacy
```

## Quick Flow per Activity

Per task rapidi su Activity:
```bash
bmad-quick-dev "Aggiungi logging per evento X"
bmad-quick-spec "Specifica per retention log Y giorni"
```

## Agenti Specializzati per Activity

| Agente | Ruolo | Quando Usare |
|--------|-------|--------------|
| Mary 📊 | Analyst | Studio dominio audit, ricerca best practice logging |
| John 📋 | PM | PRD retention policy, compliance requirements |
| Winston 🏗️ | Architect | Architettura tabelle log, indici, partitioning |
| Amelia 💻 | Developer | Implementazione Actions logging, middleware |
| Quinn 🧪 | QA | Test logging, performance, privacy, GDPR compliance |

## Configurazione

```bash
# Verifica che Activity sia abilitato (module:status non esiste: usare module:list)
php artisan module:list | grep Activity

# Esegui migration
php artisan migrate --path=modules/Activity/database/migrations

# Verifica PHPStan
./vendor/bin/phpstan analyse Modules/Activity --memory-limit=-1

# Test logging
php artisan test --testsuite=Activity
```

## Struttura Output BMAD

```
_bmad-output/
├── planning-artifacts/
│   ├── PRD.md              # Requisiti modulo Activity
│   ├── architecture.md     # Architettura logging e retention
│   └── epics/
│       ├── epic-001-user-actions.md
│       ├── epic-002-system-events.md
│       └── epic-003-compliance.md
└── implementation-artifacts/
    ├── sprint-status.yaml
    └── story-001-activitylog-model.md
```

## Vedi Anche

- [quick-reference](quick-reference.md)
- [setup-guide](setup-guide.md)
- [BMAD Workflow Catalog](../bmad-workflow-catalog.md)

---

*Activity · BMAD Method · data 2026-05-27*
