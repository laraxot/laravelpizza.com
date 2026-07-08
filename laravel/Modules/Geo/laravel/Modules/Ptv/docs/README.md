---
title: documentazione modulo ptv
module: Ptv
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-07-01"
related:
  - ../README.md
---

# Documentazione — modulo Ptv

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Modulo PTV principale per portale HR e gestione integrata risorse umane nel contesto Laraxot.

## Stato qualità (2026-07-01)

- **PHPStan** (`level: max`): `./vendor/bin/phpstan analyse Modules/Ptv --memory-limit=4G` → **0 errori**. L'errore precedentemente segnalato in `app/Filament/Actions/Header/TrovaEsclusiAction.php:81` (`class-string<SchedaContract>` atteso vs stringa generica) **non si è riprodotto** su un run pulito: era un falso positivo da OOM di un run parziale precedente.
- **PHPMD**: violazioni residue soprattutto `UnusedFormalParameter` su metodi di Policy/Action che devono rispettare firme di interfaccia (es. `$scheda`, `$value` non usati in `CriteriEsclusione/*`), `CamelCase*` su campi legacy DB e complessità elevata in `Actions/CriteriEsclusione/Check.php`. Non modificate: rimuovere parametri da metodi di interfaccia romperebbe i contratti; rinominare campi DB legacy è fuori scope senza migrazione dedicata.
- **Fix applicati in questa sessione**: nessun bug di codice reale trovato oltre lo stile. Stile/formattazione: applicato `./vendor/bin/pint Modules/Ptv` (preset `laravel`, regole non rischiose: import ordering, PHPDoc, graffe, blank lines, riordino yoda-condition già `===`). Nessuna modifica di semantica.
- **PHPInsights**: punteggio Style migliorato dopo Pint (verificato via run temporaneo con `composer.lock` copiato nel modulo, necessario per bypassare un bug noto di PHPInsights che cerca `composer.lock` nel common-path invece che nella root del progetto quando si analizza una sotto-directory).
- **Pest**: `./vendor/bin/pest Modules/Ptv/tests` esegue ma la maggioranza dei test fallisce con `LogicException: bootIfNotBooted ... while it is being booted` — problema di infrastruttura test pre-esistente (DB sqlite di test assente/non inizializzato), non introdotto in questa sessione. Rispettata la regola "mai migrate/RefreshDatabase": non toccato il DB.

## Quick Start

### Send Email with PDF

```php
use Modules\Ptv\Actions\SendMailAction;
use Modules\Ptv\Models\Scheda;

// Create and send evaluation PDF via email
$scheda = Scheda::find($id);
$action = app(SendMailAction::class);
$action->handle($scheda, [
    'email' => 'employee@domain.com',
    'template' => 'evaluation_form',
    'attachments' => ['pdf' => $pdf_content]
]);
```

### Update Scheda Data

```php
use Modules\Ptv\Models\Scheda;

// Fetch and update evaluation
$scheda = Scheda::with('valutatore', 'assenza')->find($id);
$scheda->update([
    'voto' => 85,
    'note' => 'Excellent performance',
    'status' => 'submitted'
]);
```

## Architecture Overview

**Ptv** (Performance & Talent Management Portal) is the main HR portal module:

**Core Components**:
```
Scheda (evaluation form)
    |
    +---> Valutatore (evaluator assignment)
    |
    +---> Assenza (absence/attendance impact)
    |
    +---> Message (email tracking)
    |
    +---> LogEmail (activity logging)
    |
    v
Filament Resources (UI forms & tables)
    |
    v
Email/PDF Actions (notifications)
```

**Key Subsystems**:
- **Evaluation**: Scheda forms with scoring
- **Email/PDF**: SendMailAction, LogEmailAction for tracking
- **Activity Log**: LogEmail model for audit trail
- **Custom Columns**: Filament enhancements for dynamic UI
- **Policies**: Fine-grained access control (CriteriEsclusione)

**Module Dependencies**:
- **Sigma** (employee data)
- **Performance** (performance scores)
- **Progressioni** (progression context)
- **Notify** (notification delivery)
- **Activity** (audit logs)

## Core Features

### 1. Email/PDF Document Management

Scheda can be sent via email with PDF attachment:
- Template rendering
- Recipient tracking via LogEmail
- Attachment validation
- Retry logic for failed sends

See: [email-pdf-attachments.md](./email-pdf-attachments.md)

### 2. Activity Tracking

All Scheda changes logged to Activity model:
```php
activity()
    ->performedOn($scheda)
    ->withProperties(['voto' => 85])
    ->log('scheda_updated');
```

See: [activity-log-email-tracking-final-implementation.md](./activity-log-email-tracking-final-implementation.md)

### 3. Custom Filament Columns

Extend Resource columns with custom rendering:
```php
TextColumn::make('voto')
    ->badge()
    ->color(fn($state) => $state >= 80 ? 'success' : 'warning')
```

See: [custom-columns.md](./custom-columns.md)

### 4. Dynamic Form Schemas

Filament forms with conditional fields:
```php
TextInput::make('note')
    ->visible(fn($get) => $get('status') == 'submitted')
```

See: [filament-resources.md](./filament-resources.md)

## Key Resources & Actions

### Main Filament Resources

| Resource | Purpose |
|----------|---------|
| `SchedaResource` | Manage evaluations |
| `ValutatoreResource` | Assign evaluators |
| `MessageResource` | View sent emails |
| `LogEmailResource` | Audit email tracking |

### Key Actions

| Action | Purpose |
|--------|---------|
| `SendMailAction` | Send Scheda via email |
| `LogEmailAction` | Log email sent event |
| `PrepareEvaluationDataAction` | Auto-fill scheda |
| `GetFilenameByScheda` | Generate PDF filename |

## Common Patterns

### 1. Email Sending with Tracking

```php
SendMailAction::dispatch($scheda, $emailData);
// Queued for reliability, logged to activity
```

### 2. Resource Inheritance

PTV Resources inherit from custom base to share schema logic (see [filament-resource-base-inheritance.md](./filament-resource-base-inheritance.md))

### 3. Enum-based Select Options

Use PHP Enums for status dropdowns (see [enum-naming-reusable.md](./enum-naming-reusable.md))

## FAQ

**Q: How is Scheda different from other evaluation models?**
A: Scheda is Ptv's primary UI model. PerformanceIndividuale/Progressioni have Scheda within them.

**Q: Can emails be resent?**
A: Yes, through MessageResource UI. LogEmail tracks all attempts.

**Q: How does Ptv handle multi-language forms?**
A: Uses Lang module + Filament form builder. See [translation-array-error-prevention.md](./translation-array-error-prevention.md)

**Q: What's the relationship between Valutatore and evaluators?**
A: Valutatore = assignment record linking employee, evaluator, and year. One evaluator can have many Valutatore assignments.

**Q: How are PDFs generated?**
A: Via html2pdf library. See [pdf-implementation-guide.md](./pdf-implementation-guide.md)

**Q: Can Scheda be bulk-imported?**
A: Yes, via import action (not currently exposed in UI). Contact dev team for bulk operations.

## Dove iniziare

- **[Architecture Patterns](./architecture-patterns.md)** — Case workflows, state machines, 65+ actions
- **[Architecture Overview](./architecture-overview.md)** — Technical deep dive
- **[Documentation Index](./INDEX.md)** — Complete table of contents
- [Wiki locale](./wiki/index.md)
- [Audit ridondanza (wiki)](./wiki/redundancy-audit.md)
- [Audit ridondanza](./code-redundancy-audit.md)
- [Regole architettura](./architecture-rules.md)


## Struttura tipica

```text
Ptv/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Ptv`
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
