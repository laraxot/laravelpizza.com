---
title: documentazione modulo Sigma
module: Sigma
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-07-01"
related:
  - ../README.md
---

# Documentazione — modulo Sigma

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Sigma HR system integration module for the Laraxot ecosystem: data import/export, payroll sync, and external HR software interoperability.

## Stato qualità (2026-07-01)

- **PHPStan** (`level: max`): `./vendor/bin/phpstan analyse Modules/Sigma --memory-limit=4G` → **0 errori**. L'errore precedentemente segnalato in `app/Models/Traits/Extras/FunctionExtra.php:617` (`is_string()` sempre vero) **non si è riprodotto** su un run pulito: era un falso positivo da OOM di un run parziale precedente.
- **PHPMD**: modulo grande (46k righe), violazioni residue soprattutto complessità elevata (`ImportJsonAction::execute()` NPath 37440, `SyncModelAction::execute()`), `ElseExpression` e naming legacy DB (`matr`, `qua2kd`, `propro`, ecc.). Non rifattorizzate: `ImportJsonAction`/`SyncModelAction` gestiscono logiche di import HR legacy critiche, un refactoring della complessità richiederebbe una suite di test di integrazione che non esiste — rischio troppo alto per uno scope di solo cleanup.
- **Fix applicati in questa sessione**:
  - `app/Actions/WebService/ImportJsonAction.php` — rimossa variabile morta `$n_rows` (risultato di `$pdo->exec()` mai letto).
  - Stile/formattazione: applicato `./vendor/bin/pint Modules/Sigma` (preset `laravel`, regole non rischiose). **Nota**: inizialmente era stato provato `phpinsights --fix`, che ha introdotto proprietà tipizzate su `protected $fillable`/`$listen`/`$connection`/`$table` in conflitto con le property non tipizzate di `Illuminate\Database\Eloquent\Model` (fatal error "must not be defined") e centinaia di conversioni `== null` → `=== null` con rischio di cambio di comportamento su confronti legacy. Le modifiche sono state **annullate** (`git checkout`) e sostituite con Pint, che usa solo regole di formattazione non rischiose.
- **PHPInsights**: Style migliorato dopo Pint (verificato con `composer.lock` copiato temporaneamente nel modulo per bypassare un bug noto del tool quando analizza una sotto-directory).
- **Pest**: `./vendor/bin/pest Modules/Sigma/tests` → **3 test, tutti passano** (non richiedono DB).

## Quick Start - Integration

### Basic Data Import

```php
// Import HR data from external system
$action = new \Modules\Sigma\Actions\WebService\ImportJsonAction();
$result = $action->execute([
    'source' => 'external_hr_system',
    'data' => $jsonPayload,
    'format' => 'standard_hr_schema'
]);

// Sync payroll data
$syncAction = new \Modules\Sigma\Actions\WebService\SyncModelAction();
$syncAction->handle($model, $payload);
```

## Architecture Overview

Sigma integrates external HR systems (payroll, employee data) into Laraxot:

**Data Flow**:
```
External HR System (CSV/JSON/API)
    |
    v
ImportJsonAction (WebService/Parser)
    |
    +---> DataTransformer (schema conversion)
    |
    +---> Bulk Sync (PDO for performance)
    |
    v
Sigma Models (Anagrafica, Buste, Presenze, etc.)
    |
    v
Performance/Progressioni modules (downstream dependents)
```

**Key Components**:
- **ImportJsonAction**: Parse and validate external data
- **SyncModelAction**: Sync single model with transactions
- **Accessor Delegation**: Split complex attr logic (calculation vs persistence)
- **PDO Bulk Operations**: Performance optimization for large datasets

## Key Actions & Models

### Primary Actions

| Action | Location | Purpose |
|--------|----------|---------|
| `ImportJsonAction` | `app/Actions/WebService/` | Bulk import from HR system |
| `SyncModelAction` | `app/Actions/WebService/` | Sync single model instance |
| `SyncAnagrafica` | `app/Actions/` | Sync employee master data |
| `CalculateBudget` | `app/Actions/` | Compute payroll budgets |

### Core Models

| Model | Table | Purpose |
|-------|-------|---------|
| `Anagrafica` | `sigma_anagrafica` | Employee master record |
| `Buste` | `sigma_buste` | Payroll records |
| `Presenze` | `sigma_presenze` | Attendance tracking |
| `MatrEnte` | `sigma_matr_ente` | Org structure/departments |

## Common Patterns

### 1. Accessor Delegation Pattern

Split attribute access into two methods:
```php
// Cached/persisted version
getSomeValueAttribute() { return $this->cache['attr']; }

// Pure calculation
getSomeValue() { return $this->calculate(); }
```
See: [accessor-delegation-complete-guide.md](./accessor-delegation-complete-guide.md)

### 2. PDO Bulk Operations

Use raw PDO for large imports to avoid ORM overhead:
```php
$pdo->exec("INSERT INTO anagrafica (...) VALUES (...), (...), (...)")
```

### 3. Checksum Validation

Verify data integrity during sync (see [architecture-rules.md](./architecture-rules.md))

## FAQ

**Q: Why not use Eloquent for bulk imports?**
A: PDO is 10-100x faster for large datasets (10K+ rows). ORM overhead becomes prohibitive.

**Q: How does Sigma differ from Activity module?**
A: Sigma handles HR data *ingestion* from external systems. Activity logs *changes* to Laraxot models.

**Q: Can multiple modules depend on Sigma data?**
A: Yes. Performance, Progressioni, and User all read from Sigma models but don't write to them.

**Q: How is data validation handled?**
A: See `ImportJsonAction::validate()` and architecture-rules.md for schema validation strategy.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Sigma/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Sigma`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| accessor-delegation-audit | [accessor-delegation-audit.md](./accessor-delegation-audit.md) |
| accessor-delegation-complete-guide | [accessor-delegation-complete-guide.md](./accessor-delegation-complete-guide.md) |
| accessor-delegation-pattern | [accessor-delegation-pattern.md](./accessor-delegation-pattern.md) |
| accessor-getkey-check-final-summary | [accessor-getkey-check-final-summary.md](./accessor-getkey-check-final-summary.md) |
| accessor-getkey-check-pattern | [accessor-getkey-check-pattern.md](./accessor-getkey-check-pattern.md) |
| accessor-helper-audit-complete | [accessor-helper-audit-complete.md](./accessor-helper-audit-complete.md) |
| accessor-helper-pattern | [accessor-helper-pattern.md](./accessor-helper-pattern.md) |
| accessor-helper-status-report-final | [accessor-helper-status-report-final.md](./accessor-helper-status-report-final.md) |
| accessor-mutator-philosophy | [accessor-mutator-philosophy.md](./accessor-mutator-philosophy.md) |
| accessor-pattern-correct | [accessor-pattern-correct.md](./accessor-pattern-correct.md) |
| accessor-refactoring-philosophy | [accessor-refactoring-philosophy.md](./accessor-refactoring-philosophy.md) |
| accessor-refactoring-roadmap | [accessor-refactoring-roadmap.md](./accessor-refactoring-roadmap.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| analysis-report | [analysis-report.md](./analysis-report.md) |
| architecture-dry-kiss | [architecture-dry-kiss.md](./architecture-dry-kiss.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| architecture | [architecture.md](./architecture.md) |
| bugfix-accessor-save-pattern | [bugfix-accessor-save-pattern.md](./bugfix-accessor-save-pattern.md) |
| bugfix-import-json-action | [bugfix-import-json-action.md](./bugfix-import-json-action.md) |
| business-logic-analysis | [business-logic-analysis.md](./business-logic-analysis.md) |
| business-logic | [business-logic.md](./business-logic.md) |
| code-quality-improvements | [code-quality-improvements.md](./code-quality-improvements.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| comprehensive-analysis | [comprehensive-analysis.md](./comprehensive-analysis.md) |
| confidence_guidelines | [confidence_guidelines.md](./confidence_guidelines.md) |
| consolidation-plan | [consolidation-plan.md](./consolidation-plan.md) |
| current-quality-status | [current-quality-status.md](./current-quality-status.md) |
| deep-analysis | [deep-analysis.md](./deep-analysis.md) |
| duplicate-methods-census | [duplicate-methods-census.md](./duplicate-methods-census.md) |
| docs-archive-policy | [docs-archive-policy.md](./docs-archive-policy.md) |
| filament-version | [filament-version.md](./filament-version.md) |
| fix-accessor-save-pattern | [fix-accessor-save-pattern.md](./fix-accessor-save-pattern.md) |
| fix-duplicate-entry-error-summary | [fix-duplicate-entry-error-summary.md](./fix-duplicate-entry-error-summary.md) |
| fixes-applied | [fixes-applied.md](./fixes-applied.md) |
| git-conflicts-inventory | [git-conflicts-inventory.md](./git-conflicts-inventory.md) |
| laravel-13-upgrade | [laravel-13-upgrade.md](./laravel-13-upgrade.md) |
| launch-plan | [launch-plan.md](./launch-plan.md) |
| mago-rector-tools | [mago-rector-tools.md](./mago-rector-tools.md) |
| module-dependencies | [module-dependencies.md](./module-dependencies.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
