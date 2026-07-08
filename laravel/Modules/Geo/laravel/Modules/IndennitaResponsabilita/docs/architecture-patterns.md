---
title: Architecture Patterns — IndennitaResponsabilita Module
type: architecture
module: IndennitaResponsabilita
status: approved
tags: [architecture, domain, patterns, responsibility-allowances]
updated: "2026-06-18"
related:
  - ./README.md
  - ../app
  - ../../Xot/docs/architecture-patterns.md
---

# Architecture Patterns — IndennitaResponsabilita Module

> **Responsibility Allowances Domain.** Position-based bonuses, role compensation, and management allowances with complex hierarchical relationships and approval workflows.

## Overview

IndennitaResponsabilita implements domain logic for **responsibility-based compensation** within Laraxot:
- **Position hierarchies** with compensation tiers
- **Role-based allowances** (director, coordinator, responsible)
- **Service relationships** (estero representatives, partner agencies)
- **Approval workflows** (submit → review → approve)
- **Audit trails** (activity logging on all changes)

## Architettura Principale

### 1. Domain Models — Core Business Entities

**Responsibility Allowance Model** (`IndennitaResponsabilita`)
```
IndennitaResponsabilita
├── Relationships:
│   ├── belongsTo(Dipendente)
│   ├── belongsToMany(ServiceEsterni)
│   ├── hasMany(StoricoIndennitaResponsabilita)
│   └── hasMany(Notifications)
├── Key Fields:
│   ├── dipendente_id (FK)
│   ├── service_esterno_id (nullable, for external services)
│   ├── importo (decimal for amount)
│   ├── percentuale (for percentage-based calculation)
│   ├── status (enum: draft → submitted → approved → rejected)
│   ├── date_inizio, date_fine
│   └── motivo (reason/description)
└── Scopes & Methods:
    ├── byStatus(status)
    ├── active()
    ├── pendingApproval()
    └── calculateNetAmount()
```

**Service Esterno Relationship** (`ServiceEsterni`, `ServiceEsternoRep`)
```
ServiceEsterni
├── Represents external services/agencies
├── hasMany(IndennitaResponsabilita)
├── hasMany(ServiceEsternoRepresentatives)
└── Used for: Partner compensation tracking

ServiceEsternoRep
├── Representative of external service
├── belongsTo(ServiceEsterni)
├── Relationships to allowances
└── Tracks agent responsibility
```

**History/Audit Model** (`StoricoIndennitaResponsabilita`)
```
StoricoIndennitaResponsabilita
├── Tracks all changes to allowance
├── Fields: previous_value, new_value, changed_by, changed_at
├── Enables rollback and audit trail
└── hasMany scopes for querying history
```

**Approval Workflow**
```
Status Flow:
draft (user creates)
  ↓
submitted (awaiting manager review)
  ↓
approved (by responsible manager)  OR  rejected (with reason)
  ↓
active (date range enforcement)
```

### 2. Filament Resources — Admin Interface

**IndennitaResponsabilitaResource**
```
Extends XotBaseResource with:
├── Customized form() for domain-specific fields
│   ├── Service selection (external agencies)
│   ├── Amount/Percentage toggle
│   ├── Date range (inizio/fine)
│   ├── Status workflow (draft → submitted)
│   └── Responsible party (manager approval)
├── Customized table() with:
│   ├── Status badge (colored: draft, submitted, approved, rejected)
│   ├── Employee name + service info
│   ├── Amount column
│   ├── Date range display
│   └── Bulk actions (submit, approve, reject, archive)
└── Actions (form actions):
    ├── SubmitForApprovalAction
    ├── ApproveAction
    ├── RejectAction
    └── ArchiveAction
```

**ServiceEsterniResource**
```
Manages external service agencies
├── Service name, contact info
├── Related allowances (HasMany widget)
├── Representatives (HasMany widget)
└── Activity log (recent changes)
```

### 3. Actions Pattern — Single Responsibility

**Allowance Management Actions**:
```php
// Calculation
CalculateIndennitaResponsabilitaAction
  └── input: dipendente_id, service_id, importo
  └── output: calculated_net (after deductions/taxes)

// Approval Workflow
SubmitForApprovalAction
  └── status: draft → submitted

ApproveIndennitaAction
  └── Authorize allowance, set approval_date

RejectIndennitaAction
  └── Soft-reject with reason, revert to draft

// Notifications
NotifyApprovalPendingAction
  └── Trigger email/SMS to approvers

NotifyApprovedAction
  └── Notify employee of approval
```

**Validation Actions**:
```php
ValidateResponsibilityHierarchyAction
  └── Ensure no conflicts in responsibility chain

CheckDuplicateAllowanceAction
  └── Prevent duplicate allowances for same period

ValidateDateRangeAction
  └── Ensure date_inizio < date_fine, no overlaps
```

### 4. Data Transfer Objects (DTOs/Datas)

**Key Datas**:
```php
class IndennitaResponsabilitaData extends Data
{
    public function __construct(
        public string $dipendente_id,
        public ?string $service_esterno_id,
        public string $importo,
        public ?string $percentuale,
        public string $status = 'draft',
        public DateTime $date_inizio,
        public DateTime $date_fine,
        public string $motivo,
    ) {}
}

class ApprovalData extends Data
{
    public function __construct(
        public string $indennitá_id,
        public string $approved_by,
        public DateTime $approved_at,
        public ?string $approval_note,
    ) {}
}
```

### 5. Service Layer — Business Logic

**IndennitaResponsabilitaService**
```php
class IndennitaResponsabilitaService
{
    // Calculation
    public function calculateAmount(IndennitaResponsabilitaData $data): float
    
    // Submission workflow
    public function submitForApproval(string $indennitaId, Dipendente $user): bool
    
    public function approve(string $indennitaId, Dipendente $approver, ?string $note): bool
    
    public function reject(string $indennitaId, Dipendente $rejector, string $reason): bool
    
    // Query helpers
    public function getPendingApprovals(?User $manager = null): Collection
    
    public function getHistoryFor(string $indennitaId): Collection
}
```

### 6. Events & Listeners — State Change Notifications

**Events**:
```
IndennitaResponsabilitaCreated
IndennitaResponsabilitaSubmitted
IndennitaResponsabilitaApproved
IndennitaResponsabilitaRejected
IndennitaResponsabilitaArchived
```

**Listeners**:
```
→ Trigger notifications to stakeholders
→ Log to Activity table
→ Update dashboard/statistics
→ Trigger downstream workflows (payroll, accounting)
```

### 7. Policies & Authorization

**IndennitaResponsabilitaPolicy**
```
view()     → User can see own or assigned
create()   → Dipendente can create own
update()   → Only if status=draft (by owner)
delete()   → Only if status=draft (by owner)
approve()  → Only responsible manager (via Role/Permission)
```

### 8. Database Schema

**Core Tables**:
```sql
indennitá_responsabilita
├── id (uuid)
├── dipendente_id (fk)
├── service_esterno_id (nullable, fk)
├── importo (decimal)
├── percentuale (decimal, nullable)
├── status (enum)
├── date_inizio, date_fine
├── motivo (text)
├── created_by (user_id)
├── approved_by (nullable, user_id)
├── approved_at (nullable, timestamp)
├── created_at, updated_at
└── deleted_at (soft-delete)

storico_indennitá_responsabilita
├── id (uuid)
├── indennitá_id (fk)
├── field_name (varchar)
├── old_value (json/text)
├── new_value (json/text)
├── changed_by (user_id)
├── changed_at (timestamp)

service_esterni_reps
├── id (uuid)
├── service_esterni_id (fk)
├── nome (varchar)
├── email, telefono
├── created_at, updated_at
```

## Model Relationships Diagram

```
Dipendente (User module)
    ↓ hasMany
IndennitaResponsabilita
    ├── belongsToMany → ServiceEsterni
    ├── hasMany → StoricoIndennitaResponsabilita
    ├── hasMany → Notifications
    ├── belongsTo(approver) → User
    └── belongsTo(creator) → User

ServiceEsterni
    ├── hasMany → IndennitaResponsabilita
    └── hasMany → ServiceEsternoRep

ServiceEsternoRep
    └── belongsTo → ServiceEsterni
```

## Best Practices

### 1. Status Workflow
- Always transition through approved workflow
- Use `SubmitForApprovalAction` instead of direct update
- Never bypass manager approval (policy enforced)

### 2. Amount Calculation
- Use `CalculateIndennitaResponsabilitaAction` for consistency
- Store calculated value + store formula for auditability
- Round to 2 decimals (currency safety)

### 3. Approval Process
- Require explicit approval (no auto-approval)
- Attach approval_by + approval_date for compliance
- Send notification to employee upon approval
- Keep rejection reason in history

### 4. Date Handling
- Always validate date_inizio < date_fine
- Check for overlapping periods (prev → next)
- Use query scopes for "active" allowances
- Handle historical queries (was it approved on date X?)

### 5. Relationship Integrity
- Validate that dipendente exists in current system
- Validate that service_esterno is active (not deleted)
- Handle cascade deletes carefully (keep history)
- Use soft-deletes for audit trail

### 6. Activity Logging
- Auto-log via Activity trait on model
- Track approval/rejection explicitly
- Log amount changes (for payroll reconciliation)
- Include reason/notes in audit log

## Development Workflow

### Adding New Approval Step
1. Extend `status` enum with new value
2. Create new `Action` for transition
3. Add `Event` for state change
4. Add `Listener` for notifications
5. Update Filament resource buttons
6. Add validation rules
7. Update policy
8. Document in architecture-patterns.md

### Adding New Allowance Type
1. Create data class (e.g., `DirectorAllowanceData`)
2. Create calculation action specific to type
3. Add validation action
4. Update Filament resource conditionally
5. Add tests for new calculation
6. Update wiki documentation

## Backlinks & References

- **Root README**: [IndennitaResponsabilita Module](./README.md)
- **Related Module**: [IndennitaCondizioniLavoro](../IndennitaCondizioniLavoro/docs/architecture-patterns.md)
- **Framework Base**: [Xot Architecture Patterns](../../Xot/docs/architecture-patterns.md)
- **PHPStan Issues**: [phpstan-analysis.md](./phpstan-analysis.md), [phpstan-filament5-tablefilters.md](./phpstan-filament5-tablefilters.md)
- **Domain Models**: [analysis-summary.md](./analysis-summary.md)
- **Relationships**: [anag-relationship-conflict-resolution.md](./anag-relationship-conflict-resolution.md)

---

**Document Type**: Architecture Reference  
**Module**: IndennitaResponsabilita  
**Last Updated**: 2026-06-18  
**Maintainers**: Development Team  
**Status**: Approved
