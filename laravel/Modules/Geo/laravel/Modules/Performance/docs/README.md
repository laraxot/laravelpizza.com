---
title: documentazione modulo Performance
module: Performance
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-07-01"
related:
  - ../README.md
---

# Documentazione — modulo Performance

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Performance evaluation and HR assessment module for the Laraxot ecosystem: employee reviews, KPI tracking, and competency evaluation.

## Quick Start - Usage

### Calculate Performance Score

```php
use Modules\Performance\Models\PerformanceIndividuale;

// Get individual performance and calculate score
$perf = PerformanceIndividuale::find($id);
$score = $perf->getVotoMerito(); // returns normalized score (0-100)
$category = $perf->getCategoryByScore(); // returns A/B/C/D
```

### Bulk Update Actions

```php
use Modules\Performance\Actions\Individuale\UpdateBudgetAction;

// Update budget for all individuals in a year
$action = app(UpdateBudgetAction::class);
$action->execute($year, ['allocation' => 100000]);
```

## Architecture Overview

Performance module evaluates employees and allocates merit bonuses:

**Data Model**:
```
PerformanceIndividuale (1 per employee per year)
    |
    +---> PerformanceOrganizzativa (1 per dept per year)
    |
    +---> FondoPerformance (budget allocation & rules)
    |
    +---> Valutatore (evaluator assignment)
    |
    v
Filament Resources (UI for evaluation forms)
```

**Key Features**:
- **Individuale**: Single employee rating (0-100)
- **Organizzativa**: Department pool rating  
- **STI (STI Pattern)**: Parental relationship filtering (see parental-sti-pattern.md)
- **Budget Allocation**: Merit-based distribution across organization

**Dependencies**:
- **Sigma** (reads employee data)
- **Progressioni** (reads career stage)
- **User** (evaluator management)

## Key Models & Actions

### Primary Models

| Model | Purpose |
|-------|---------|
| `PerformanceIndividuale` | Individual employee performance rating |
| `PerformanceOrganizzativa` | Department/organization pool rating |
| `FondoPerformance` | Budget allocation fund & rules |
| `Valutatore` | Evaluator assignment |

### Key Actions

| Action | Purpose |
|--------|---------|
| `Individuale\CheckSumAction` | Calculate checksum for integrity |
| `Individuale\UpdateAssenze` | Update absence impact on score |
| `Individuale\UpdateBudgetAction` | Allocate merit budget |
| `Individuale\UpdateTotValutatore` | Sum evaluator scores |
| `Organizzativa\CopyValutatoreId` | Copy evaluator to org pool |
| `HasExcellenceByYearAction` | Check if employee has excellence rating |
| `MakePdfByRecord` | Generate performance PDF report |

## Common Patterns

### 1. Parental STI Pattern

Filter related records using STI (Single Table Inheritance):
```php
// Get performance records for individual's organization
$perf = PerformanceIndividuale::query()
    ->whereHas('valutatore', fn($q) => 
        $q->parentalSti($this->organizzazione)
    )
    ->get();
```
See: [parental-sti-pattern.md](./parental-sti-pattern.md)

### 2. Checksum Validation

Ensure data integrity across updates:
```php
$action = app(CheckSumAction::class);
$isValid = $action->handle($performance);
```

### 3. Bulk Update with Queuing

Performance updates run as queued jobs:
```php
UpdateBudgetAction::dispatch($year, $payload);
```

## FAQ

**Q: What's the difference between Individuale and Organizzativa?**
A: Individuale = individual employee rating. Organizzativa = department-level pool that feeds individual allocations.

**Q: How are evaluators assigned?**
A: Via Valutatore model with organizational hierarchy. See parental-sti-best-practices.md.

**Q: Can evaluations be modified after submission?**
A: Yes, through Filament admin UI or actions. Checksum validates integrity.

**Q: What's the FondoPerformance model used for?**
A: Defines total budget available and allocation rules (percentage per grade, merit factor, etc.)

**Q: How does Performance integrate with Sigma data?**
A: Reads employee master data (Anagrafica) from Sigma for calculations but never modifies it.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Performance/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Performance`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| action-update-gg-anno | [action-update-gg-anno.md](./action-update-gg-anno.md) |
| action-update-gg-presenza-dalal | [action-update-gg-presenza-dalal.md](./action-update-gg-presenza-dalal.md) |
| action-update-perc-parttimepond-dalal | [action-update-perc-parttimepond-dalal.md](./action-update-perc-parttimepond-dalal.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| bugfix-individuale-regionale-parental-scope | [bugfix-individuale-regionale-parental-scope.md](./bugfix-individuale-regionale-parental-scope.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| confidence_guidelines | [confidence_guidelines.md](./confidence_guidelines.md) |
| discrepanza-calcolo-quota | [discrepanza-calcolo-quota.md](./discrepanza-calcolo-quota.md) |
| docs-archive-policy | [docs-archive-policy.md](./docs-archive-policy.md) |
| filament-infolist-pattern | [filament-infolist-pattern.md](./filament-infolist-pattern.md) |
| filament-v4-migration-impact | [filament-v4-migration-impact.md](./filament-v4-migration-impact.md) |
| filament-version | [filament-version.md](./filament-version.md) |
| laravel-13-upgrade | [laravel-13-upgrade.md](./laravel-13-upgrade.md) |
| launch-plan | [launch-plan.md](./launch-plan.md) |
| model-fillable-checklist | [model-fillable-checklist.md](./model-fillable-checklist.md) |
| parental-index | [parental-index.md](./parental-index.md) |
| parental-research-complete | [parental-research-complete.md](./parental-research-complete.md) |
| parental-sti-best-practices | [parental-sti-best-practices.md](./parental-sti-best-practices.md) |
| parental-sti-filtering | [parental-sti-filtering.md](./parental-sti-filtering.md) |
| parental-sti-pattern | [parental-sti-pattern.md](./parental-sti-pattern.md) |
| parental-verification-guide | [parental-verification-guide.md](./parental-verification-guide.md) |
| performance-fondo-record-pages | [performance-fondo-record-pages.md](./performance-fondo-record-pages.md) |
| phpstan-errors-roadmap | [phpstan-errors-roadmap.md](./phpstan-errors-roadmap.md) |
| phpstan-refactor | [phpstan-refactor.md](./phpstan-refactor.md) |
| prd | [prd.md](./prd.md) |
| product-requirements | [product-requirements.md](./product-requirements.md) |
| psr4-test-autoload-fix | [psr4-test-autoload-fix.md](./psr4-test-autoload-fix.md) |
| recent-updates | [recent-updates.md](./recent-updates.md) |
| recent_updates | [recent_updates.md](./recent_updates.md) |
| release-marketing-standard | [release-marketing-standard.md](./release-marketing-standard.md) |
| roadmap | [roadmap.md](./roadmap.md) |
| schema | [schema.md](./schema.md) |
| second-brain | [second-brain.md](./second-brain.md) |
| sprint-planning | [sprint-planning.md](./sprint-planning.md) |
| strategy | [strategy.md](./strategy.md) |
| user-research | [user-research.md](./user-research.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.

## ✅ PHPStan Status

| Data | Livello | Errori |
|------|---------|--------|
| 2026-07-01 | max | **0** |

```bash
./vendor/bin/phpstan analyze Modules/Performance --level=max --memory-limit=512M
# [OK] No errors
```

## Fix Applicati (2026-07-01)

- Nessun fix necessario: il modulo era già conforme alle regole Laraxot
- Actions Individuale e Organizzativa usano correttamente QueueableAction
- Nessun label hardcoded nei campi Filament

## Architettura Classi Principali

```
Performance/
├── app/
│   ├── Actions/
│   │   ├── Individuale/ (CheckSum, UpdateAssenze, UpdateBudget, UpdateTotValutatore, ...)
│   │   ├── Organizzativa/ (CheckSum, CopyValutatoreId, ...)
│   │   ├── GetHaDirittoMotivoAction.php
│   │   ├── HasExcellenceByYearAction.php
│   │   ├── MakePdfByRecord.php
│   │   └── OrganizzativaSpreadMoneyByYearAction.php
│   ├── Models/
│   │   ├── PerformanceIndividuale.php
│   │   ├── PerformanceOrganizzativa.php
│   │   └── FondoPerformance.php
│   └── Filament/Resources/
└── docs/README.md (questo file)
```
