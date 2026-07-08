---
title: Architecture Patterns — IndennitaCondizioniLavoro Module
type: architecture
module: IndennitaCondizioniLavoro
status: approved
tags: [architecture, domain, work-conditions, allowances]
updated: "2026-06-18"
related:
  - ./README.md
  - ../app
  - ../../Xot/docs/architecture-patterns.md
---

# Architecture Patterns — IndennitaCondizioniLavoro Module

> **Work Conditions Allowances Domain.** Hazard pay, shift differentials, and special work conditions compensation with complex eligibility rules and historical tracking.

## Overview

IndennitaCondizioniLavoro manages **compensation for special working conditions**:
- **Hazard Pay** (dangerous work environments)
- **Shift Differentials** (night shifts, weekend work)
- **Special Work Conditions** (extreme weather, altitude, etc.)
- **Eligibility Rules** (role-based, location-based, time-based)
- **Historical Tracking** (audit trail of changes and calculations)
- **Payroll Integration** (data export for payroll processing)

## Architettura Principale

### 1. Core Domain Models (26 Models)

**Main Entity: CondizioniLavoro (Work Condition)**
```php
class CondizioniLavoro extends XotBaseModel
{
    // Relationships
    belongsToMany(Dipendente)               // Employees subject to this condition
    hasMany(Indennitá)                      // Allowances granted under this condition
    hasMany(StoricoCondizioni)              // History of changes
    hasMany(EligibilityRule)                // Eligibility rules
    belongsTo(User, 'created_by')           // Who created it
    
    // Key attributes
    string $nome_condizione                 // e.g., "Turno Notturno"
    enum $tipo_condizione                   // hazard, shift, special, altitude, temperature
    text $descrizione                       // Description
    decimal $percentuale_base               // Base percentage increase
    datetime $data_inizio                   // When condition applies
    datetime $data_fine                     // Optional end date (null = ongoing)
    json $regole_applicazione               // Application rules (flexible)
    bool $attiva                            // Active/inactive flag
    text $note_interne                      // Internal notes
}
```

**Related Models**:
```
Indennitá
├── Allowance granted to employee
├── Amount calculated from CondizioniLavoro
├── Period of application
├── Approval status
└── Linked to StoricoIndennitá

StoricoCondizioni
├── Tracks all changes to condition definition
├── Previous/new values
├── Changed by (user)
├── Timestamp
└── Enables rollback

EligibilityRule
├── Business rules for eligibility
├── Role-based, location-based, time-based
├── Dynamic evaluation
└── Audit trail of rule changes

Dipendente (via BelongsToMany)
├── Pivot: dipendente_condizioni_lavoro
├── Approved (bool)
├── Approved by (user_id)
├── Approved at (timestamp)
└── Notes

StoricoIndennitá
├── Historical allowance records
├── Amount, percentage, dates
├── Calculated formula
├── Payroll export timestamp
└── Enables reconciliation
```

### 2. Filament Resources (39 Resources)

**Primary Resources**:
- **CondizioniLavoroResource** — Work conditions administration
- **IndennitáResource** — Allowance CRUD
- **StoricoCondatoriResource** — History/versioning
- **EligibilityRuleResource** — Rule management
- **DipendenteCodndazioneResource** — Eligibility matrix

**Resource Architecture**:
```php
class CondizioniLavoroResource extends XotBaseResource
{
    // Customized form() with:
    ├── Condition type (hazard, shift, special)
    ├── Base percentage input
    ├── Effective dates (inizio/fine)
    ├── Description (rich text)
    ├── Rules editor (JSON/visual)
    ├── Status toggle (active/inactive)
    ├── Approvers list
    └── Associated employees (HasMany)
    
    // Customized table() with:
    ├── Condition type badge
    ├── Base percentage
    ├── Active status
    ├── Date range display
    ├── Employee count
    ├── Last modified date
    └── Bulk actions (approve, deactivate, export)
}

class IndennitáResource extends XotBaseResource
{
    // Form fields:
    ├── Condition selection (with description)
    ├── Employee selection (with eligibility check)
    ├── Period (inizio/fine)
    ├── Calculated amount (read-only)
    ├── Percentage override
    ├── Notes/reason
    ├── Status workflow (draft → approved)
    └── Approval signature
    
    // Table columns:
    ├── Employee name
    ├── Condition type
    ├── Amount (auto-calculated)
    ├── Period dates
    ├── Status badge
    ├── Approver info
    └── Created/Updated timestamps
}
```

### 3. Actions Pattern (3 Actions for Core Logic)

**Core Actions**:
```php
CalculateIndennitáAction
  ├── input: Dipendente, CondizioniLavoro, period
  ├── Evaluate eligibility rules
  ├── Calculate based on formula
  ├── Apply any overrides
  ├── output: Indennitá instance with amount

ApproveIndennitáAction
  ├── Validate preconditions
  ├── Require approver + signature
  ├── Transition: draft → approved
  ├── Generate approval record
  ├── Trigger notification
  └── Log activity

ExportToPayrollAction
  ├── Gather approved allowances
  ├── Filter by date range
  ├── Format for payroll system
  ├── Include calculation details
  └── Track export timestamp
```

**Validation Actions**:
```php
ValidateEligibilityAction
  ├── Check employee eligibility
  ├── Verify condition is active
  ├── Validate date ranges
  ├── Check for conflicts
  └── Return validation errors

ValidateConditionConstraintsAction
  ├── Ensure no overlapping periods
  ├── Check role applicability
  ├── Verify department assignment
  └── Validate percentage limits
```

### 4. Data Transfer Objects (DTOs)

**Condition Configuration**:
```php
class CondizioniLavoroData extends Data
{
    public function __construct(
        public string $nome_condizione,
        public string $tipo_condizione,  // hazard, shift, special, altitude, temperature
        public string $descrizione,
        public decimal $percentuale_base,
        public DateTime $data_inizio,
        public ?DateTime $data_fine = null,
        public array $regole_applicazione = [],
        public bool $attiva = true,
    ) {}
    
    public static function rules(): array
    {
        return [
            'nome_condizione' => 'required|unique:condizioni_lavoro',
            'tipo_condizione' => 'required|in:hazard,shift,special,altitude,temperature',
            'percentuale_base' => 'required|numeric|between:0,100',
            'data_inizio' => 'required|date',
            'data_fine' => 'nullable|date|after:data_inizio',
        ];
    }
}

class IndennitáData extends Data
{
    public function __construct(
        public string $dipendente_id,
        public string $condizione_id,
        public DateTime $data_inizio,
        public DateTime $data_fine,
        public decimal $importo,
        public ?decimal $percentuale_override = null,
        public ?string $note = null,
        public string $status = 'draft',
    ) {}
}

class EligibilityRuleData extends Data
{
    public function __construct(
        public string $rule_name,
        public string $rule_type,  // role_based, location_based, time_based, salary_based
        public array $conditions,
        public bool $required = false,
        public string $error_message = '',
    ) {}
}
```

### 5. Service Layer

**CondizioniLavoroService** — Condition management:
```php
class CondizioniLavoroService
{
    // Query helpers
    public function getActive(DateTime $date): Collection
    public function getByType(string $tipo): Collection
    public function getForEmployee(Dipendente $emp, DateTime $date): Collection
    
    // Business logic
    public function createCondition(CondizioniLavoroData $data): CondizioniLavoro
    public function deactivateCondition(string $conditionId): bool
    public function getApplicableRules(CondizioniLavoro $condition): Collection
}
```

**IndennitáService** — Allowance management:
```php
class IndennitáService
{
    // Calculation
    public function calculateAmount(Dipendente $emp, CondizioniLavoro $cond, Period $period): decimal
    public function getCalculationFormula(CondizioniLavoro $cond): string
    
    // Workflow
    public function createAllowance(IndennitáData $data): Indennitá
    public function approveAllowance(string $indentnitaId, User $approver): bool
    public function rejectAllowance(string $indennitaId, string $reason): bool
    
    // Querying
    public function getPendingApprovals(): Collection
    public function getApprovedByPeriod(DateRange $period): Collection
    public function getByEmployee(string $empId): Collection
}
```

**EligibilityService** — Rule evaluation:
```php
class EligibilityService
{
    // Rule evaluation
    public function isEligible(Dipendente $emp, CondizioniLavoro $cond): bool
    public function getFailedRules(Dipendente $emp, CondizioniLavoro $cond): Collection
    public function canApplyCondition(Dipendente $emp, CondizioniLavoro $cond): array  // [bool, array of reasons]
    
    // Rule management
    public function registerRule(EligibilityRuleData $rule): void
    public function evaluateRule(EligibilityRule $rule, Dipendente $emp): bool
}
```

**PayrollIntegrationService** — Export for payroll:
```php
class PayrollIntegrationService
{
    // Export
    public function exportApprovedAllowances(DateRange $period): array
    public function generatePayrollReport(DateRange $period): string  // CSV/JSON
    
    // Integration
    public function syncWithPayroll(): void
    public function getLastExportDate(): DateTime
    public function reconcileExported(DateRange $period): array  // Discrepancies
}
```

### 6. Eligibility Rules Engine

**Rule Types**:
```
Role-Based Rules
├── Only directors get certain allowances
├── Managers vs. workers
└── Specialization-specific

Location-Based Rules
├── Remote work vs. onsite
├── Geographic area
└── Work environment classification

Time-Based Rules
├── Minimum tenure required
├── Seniority levels
└── Contract type

Salary-Based Rules
├── Salary bracket thresholds
├── Gross vs. net income
└── Position level
```

**Rule Evaluation**:
```php
class EligibilityRule extends Model
{
    // Evaluates against Dipendente
    public function evaluate(Dipendente $emp): bool
    {
        return match($this->rule_type) {
            'role_based' => $this->evaluateRole($emp),
            'location_based' => $this->evaluateLocation($emp),
            'time_based' => $this->evaluateTime($emp),
            'salary_based' => $this->evaluateSalary($emp),
        };
    }
}
```

### 7. Events & Listeners

**Domain Events**:
```
CondizioneCreated
CondizioneActivated
CondizioneDeactivated
IndennitáCreated
IndennitáApproved
IndennitáRejected
IndennitáExportedToPayroll
StoricoIndennitáRecorded
```

**Listeners**:
- Notify affected employees
- Log activity trail
- Update statistics
- Trigger payroll export
- Archive historical records

### 8. Policies & Authorization

**CondizioniLavoroPolicy**:
```php
view()      → Public info visible to all affected employees
create()    → HR/Admin only
update()    → HR/Admin (if no active allowances under it)
delete()    → Never (soft-delete if needed, keep history)
approve()   → HR Manager via Role
```

**IndennitáPolicy**:
```php
view()      → Employee (own), HR, managers (reports)
create()    → HR/Auto from condition rules
update()    → Only if status=draft
delete()    → Never (keep audit trail)
approve()   → Only HR Manager
```

### 9. Database Schema

**Core Tables**:
```sql
condizioni_lavoro
├── id (uuid)
├── nome_condizione (varchar)
├── tipo_condizione (enum)
├── descrizione (text)
├── percentuale_base (decimal)
├── data_inizio, data_fine
├── regole_applicazione (json)
├── attiva (bool)
├── created_by (user_id)
├── created_at, updated_at
└── deleted_at (soft-delete)

indennitá
├── id (uuid)
├── dipendente_id (fk)
├── condizione_id (fk)
├── data_inizio, data_fine
├── importo (decimal)
├── percentuale_override (nullable)
├── status (enum: draft, approved, rejected)
├── approved_by (nullable, user_id)
├── approved_at (nullable)
├── note (text)
├── exported_at (nullable, for payroll)
├── created_at, updated_at

storico_indennitá
├── id (uuid)
├── indennitá_id (fk)
├── field_name (varchar)
├── old_value (json)
├── new_value (json)
├── changed_by (user_id)
├── changed_at (timestamp)

eligibility_rules
├── id (uuid)
├── condizione_id (fk)
├── rule_name (varchar)
├── rule_type (enum)
├── conditions (json)
├── required (bool)
├── error_message (text)
├── created_at, updated_at

dipendente_condizioni_lavoro (pivot)
├── dipendente_id (fk)
├── condizione_id (fk)
├── approved (bool)
├── approved_by (user_id)
├── approved_at (timestamp)
└── notes (text)
```

## Model Relationships Diagram

```
CondizioniLavoro
├── belongsToMany(Dipendente) via dipendente_condizioni_lavoro
├── hasMany(Indennitá)
├── hasMany(StoricoCondizioni)
├── hasMany(EligibilityRule)
└── belongsTo(User, 'created_by')

Indennitá
├── belongsTo(Dipendente)
├── belongsTo(CondizioniLavoro)
├── belongsTo(User, 'approved_by')
├── hasMany(StoricoIndennitá)
└── hasMany(PayrollExportRecord)

EligibilityRule
├── belongsTo(CondizioniLavoro)
└── evaluated on: Dipendente

Dipendente
├── belongsToMany(CondizioniLavoro)
├── hasMany(Indennitá)
└── hasMany historical records
```

## Best Practices

### 1. Condition Definition
- Document hazard classification per EU regulations
- Set realistic percentage ranges (typically 10-50%)
- Use versioning for rule changes
- Require approval for new conditions

### 2. Eligibility Rules
- Keep rules simple and auditable
- Use data-driven rules (not hardcoded)
- Log all rule changes
- Test rule evaluation with sample employees

### 3. Allowance Calculation
- Use formula (not direct amount entry where possible)
- Store calculation details for audit
- Never round until final amount
- Validate calculated amount against bounds

### 4. Approval Workflow
- Require explicit approval (no auto-approval)
- Keep approval chain simple (1-2 signers max)
- Archive approval signature
- Notify employee upon approval

### 5. Payroll Integration
- Export only approved allowances
- Mark as exported (prevent double-processing)
- Keep export history
- Reconcile monthly with payroll system

### 6. Historical Tracking
- Never delete conditions or allowances (soft-delete)
- Maintain complete history for audit
- Track who changed what and when
- Enable queries of historical data

## Development Workflow

### Adding New Condition Type
1. Add new enum value to `tipo_condizione`
2. Create template `CondizioniLavoroData` for new type
3. Define domain-specific `EligibilityRules`
4. Update Filament resources with conditional fields
5. Create calculation logic in service
6. Add validation tests
7. Document in architecture-patterns.md

### Implementing New Eligibility Rule
1. Create rule type enum variant
2. Implement evaluation logic in `EligibilityService`
3. Create `EligibilityRule` record with conditions
4. Test against sample employee dataset
5. Add to rule matrix/dashboard
6. Document rule logic in wiki

## Backlinks & References

- **Root README**: [IndennitaCondizioniLavoro Module](./README.md)
- **Related Module**: [IndennitaResponsabilita](../IndennitaResponsabilita/docs/architecture-patterns.md)
- **Framework Base**: [Xot Architecture Patterns](../../Xot/docs/architecture-patterns.md)
- **PHPStan Issues**: [phpstan-fixes.md](./phpstan-fixes.md)
- **Audit Trail**: [accessor-guard-audit.md](./accessor-guard-audit.md)
- **Code Quality**: [code-redundancy-audit.md](./code-redundancy-audit.md)

---

**Document Type**: Architecture Reference  
**Module**: IndennitaCondizioniLavoro  
**Last Updated**: 2026-06-18  
**Maintainers**: Development Team  
**Status**: Approved
