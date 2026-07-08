---
title: documentazione modulo Progressioni
module: Progressioni
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-07-01"
related:
  - ../README.md
---

# Documentazione — modulo Progressioni

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Career progression management module for the Laraxot ecosystem: promotions, salary advancements, and professional development tracking.

## Stato qualità (2026-07-01)

- **PHPStan** (`level: max`, config immutabile): `./vendor/bin/phpstan analyse Modules/Progressioni --memory-limit=4G` → **0 errori**. Il presunto errore in `TrovaEsclusiAction.php` segnalato in un run precedente era un falso positivo da OOM su run parziale.
- **PHPMD** (`cleancode,codesize,design,naming,unusedcode,controversial`): violazioni residue principalmente `CamelCase*` su campi/variabili che rispecchiano nomi colonna DB legacy (`valutaz_fields`, `stabi_dirigente_parz`, ecc.) e complessità elevata in `Scheda.php` (`validate()`, `updateFields()`, `ggInSedeTotByArray()`) e `ProgressioniFunctionTrait.php`. Non rinominate/rifattorizzate per il rischio di rompere integrazioni con DB legacy e assenza di copertura test adeguata: debito tecnico noto, non introdotto in questa sessione.
- **Fix applicati in questa sessione**:
  - `app/Models/Scheda.php::updateVincitori()` — rimossa variabile morta `$res` (risultato `update()` mai utilizzato).
  - `app/Models/Traits/ProgressioniFunctionTrait.php` — rimosso loop morto che assegnava `$a` senza mai leggerlo.
  - `tests/Unit/Actions/RefreshByYearActionTest.php` — corretta firma errata (`: void` con `return`) nel mock anonimo di `Model::getAttribute()`/`getKey()` che mandava in fatal error l'intera suite Pest del modulo.
  - Stile/formattazione: applicato `./vendor/bin/pint Modules/Progressioni` (regole non rischiose, preset `laravel`: import ordering, PHPDoc, graffe, blank lines). Nessuna modifica di semantica.
- **PHPInsights**: punteggio Style passato da 74.7 a 88 pts dopo Pint. Architecture resta basso (~59 pts) principalmente per la regola "classes must be final or abstract", non applicata perché impatterebbe l'intera gerarchia dei model/Filament Resources del modulo (rischio regressione su estendibilità/mock nei test).
- **Pest**: `./vendor/bin/pest Modules/Progressioni/tests` esegue (dopo il fix del mock rotto) ma la maggior parte dei test falla con `LogicException: bootIfNotBooted ... while it is being booted` — problema di infrastruttura test pre-esistente (assenza DB sqlite di test), non introdotto né risolto in questa sessione per rispetto della regola "mai toccare il DB in modo distruttivo/migrate". Non sono stati aggiunti nuovi test dedicati per le due micro-correzioni sopra (rimozione codice morto, nessun cambio di comportamento osservabile).

## Quick Start - Workflows

### Create Progression Year

```php
use Modules\Progressioni\Models\Progressioni;

// Create new progression year
$prog = Progressioni::create([
    'year' => 2024,
    'status' => 'draft',
    'allocation_budget' => 50000
]);

// Update winners after evaluation
$prog->updateVincitori(['winners_by_category' => [...]]);
```

### Bulk Refresh Records

```php
use Modules\Progressioni\Actions\RefreshByYearAction;

// Refresh all progression records for year
$action = app(RefreshByYearAction::class);
$action->execute($year);
```

## Architecture & Data Flow

Progressioni manages career advancement and salary increases:

**Entity Relationships**:
```
Progressioni (year-based progression program)
    |
    +---> Scheda (progression evaluation form per employee)
    |         |
    |         +---> CriteriProgression (evaluation criteria)
    |         |
    |         +---> Peso (weighted scoring)
    |
    +---> EsclusionGroup (exclusion rules)
    |
    v
Filament Resources (UI for evaluation & winners selection)
```

**Key Workflows**:
1. Create progression year with budget and criteria
2. Employees fill Scheda (evaluation form)
3. System calculates scores via Peso model
4. Admin selects winners based on ranking
5. HR approves and salary increases applied

**Dependencies**:
- **Sigma** (reads employee data for ranking)
- **Performance** (uses performance scores in evaluation)
- **User** (evaluator assignment)

## Key Models & Resources

### Core Models

| Model | Purpose |
|-------|---------|
| `Progressioni` | Yearly progression program |
| `Scheda` | Individual progression evaluation |
| `CriteriProgression` | Evaluation criteria definitions |
| `Peso` | Weighted scoring model |
| `EsclusionGroup` | Exclusion rules & exemptions |

### Key Actions

| Action | Purpose |
|--------|---------|
| `RefreshByYearAction` | Recalculate scores for all schede |
| `TrovaEsclusiAction` | Apply exclusion rules |
| `CompileSchedaAction` | Fill scheda with data |
| `UpdateVincitoriAction` | Mark progression winners |

### Filament Resources

| Resource | Purpose |
|----------|---------|
| `SchedaResource` | Edit progression evaluations |
| `ProgressioniResource` | Manage progression programs |
| `CriteriProgressionResource` | Define evaluation criteria |

## Common Patterns

### 1. Filament Infolist Display

Show read-only progression data:
```php
Infolist\Entries\TextEntry::make('year')
    ->label('Progression Year')
    ->formatStateUsing(fn($state) => "Year $state")
```
See: [filament-infolist-pattern.md](./filament-infolist-pattern.md)

### 2. Scheda Compilation

Auto-fill scheda from employee data:
```php
$action = app(CompileSchedaAction::class);
$action->handle($scheda);
```

### 3. STI Pattern with Parental

Filter schede by organization hierarchy (see [filament-resource-wire-assenza.md](./filament-resource-wire-assenza.md))

## FAQ

**Q: What's a Scheda?**
A: Individual progression evaluation form filled annually. Contains criteria scores, evaluator notes, and computed ranking.

**Q: How are winners selected?**
A: Ranked by score, then filtered by budget availability. Admin can manually override rankings.

**Q: Can employees be excluded?**
A: Yes, via EsclusionGroup rules (probation, contract type, etc.). See TrovaEsclusiAction.

**Q: What happens to salary after selection?**
A: Application tier (HR system) applies increase. Progressioni stores decision only.

**Q: How often do progressions run?**
A: Usually once per year. Multiple progression programs per year are supported.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [code redundancy audit](./code-redundancy-audit.md)
- [architecture rules](./architecture-rules.md)
- [agent edit discipline](./agent-edit-discipline.md)
- [agent confidence protocol](./agent-confidence-protocol.md)
- [second brain](./second-brain.md)


## Struttura tipica

```text
Progressioni/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Progressioni`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Indice file in docs/ (root)

| Argomento | File |
| :--- | :--- |
| 00-index | [00-index.md](./00-index.md) |
| activity-log-override-rationale | [activity-log-override-rationale.md](./activity-log-override-rationale.md) |
| agent-confidence-discipline | [agent-confidence-discipline.md](./agent-confidence-discipline.md) |
| agent-confidence-protocol | [agent-confidence-protocol.md](./agent-confidence-protocol.md) |
| agent-edit-discipline | [agent-edit-discipline.md](./agent-edit-discipline.md) |
| architecture-rules | [architecture-rules.md](./architecture-rules.md) |
| code-redundancy-audit | [code-redundancy-audit.md](./code-redundancy-audit.md) |
| compila-scheda-fix | [compila-scheda-fix.md](./compila-scheda-fix.md) |
| confidence_guidelines | [confidence_guidelines.md](./confidence_guidelines.md) |
| database-connection-progressione | [database-connection-progressione.md](./database-connection-progressione.md) |
| docs-archive-policy | [docs-archive-policy.md](./docs-archive-policy.md) |
| filament-resource-navigation | [filament-resource-navigation.md](./filament-resource-navigation.md) |
| filament-resource-schemas-tables | [filament-resource-schemas-tables.md](./filament-resource-schemas-tables.md) |
| filament-resource-wire-assenze | [filament-resource-wire-assenze.md](./filament-resource-wire-assenze.md) |
| filament-v4-upgrade | [filament-v4-upgrade.md](./filament-v4-upgrade.md) |
| filament-version | [filament-version.md](./filament-version.md) |
| group-column-usage | [group-column-usage.md](./group-column-usage.md) |
| html-parsing-error-fix | [html-parsing-error-fix.md](./html-parsing-error-fix.md) |
| html-validation-script | [html-validation-script.md](./html-validation-script.md) |
| html2pdf-migration-guide | [html2pdf-migration-guide.md](./html2pdf-migration-guide.md) |
| laravel-13-upgrade | [laravel-13-upgrade.md](./laravel-13-upgrade.md) |
| launch-plan | [launch-plan.md](./launch-plan.md) |
| mailtemplate-resource-integration | [mailtemplate-resource-integration.md](./mailtemplate-resource-integration.md) |
| override-vs-duplication | [override-vs-duplication.md](./override-vs-duplication.md) |
| pdf-view-translation-bug-fix | [pdf-view-translation-bug-fix.md](./pdf-view-translation-bug-fix.md) |
| phpstan-analysis-complete-summary | [phpstan-analysis-complete-summary.md](./phpstan-analysis-complete-summary.md) |
| phpstan-analysis | [phpstan-analysis.md](./phpstan-analysis.md) |
| phpstan-errors-analysis | [phpstan-errors-analysis.md](./phpstan-errors-analysis.md) |
| phpstan-errors-roadmap | [phpstan-errors-roadmap.md](./phpstan-errors-roadmap.md) |
| phpstan-errors-systematic-fix-plan | [phpstan-errors-systematic-fix-plan.md](./phpstan-errors-systematic-fix-plan.md) |
| phpstan-fixes-summary | [phpstan-fixes-summary.md](./phpstan-fixes-summary.md) |
| phpstan-typing-strategy | [phpstan-typing-strategy.md](./phpstan-typing-strategy.md) |
| prd | [prd.md](./prd.md) |
| product-requirements | [product-requirements.md](./product-requirements.md) |
| release-marketing-standard | [release-marketing-standard.md](./release-marketing-standard.md) |
| rename-schede-to-scheda | [rename-schede-to-scheda.md](./rename-schede-to-scheda.md) |
| roadmap | [roadmap.md](./roadmap.md) |
| schedacriteri-resource-fix | [schedacriteri-resource-fix.md](./schedacriteri-resource-fix.md) |
| schema | [schema.md](./schema.md) |
| second-brain | [second-brain.md](./second-brain.md) |
| sprint-planning | [sprint-planning.md](./sprint-planning.md) |
| strategy | [strategy.md](./strategy.md) |
| translation-array-error-prevention | [translation-array-error-prevention.md](./translation-array-error-prevention.md) |

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/README.md)
- [Wiki progetto](../../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
