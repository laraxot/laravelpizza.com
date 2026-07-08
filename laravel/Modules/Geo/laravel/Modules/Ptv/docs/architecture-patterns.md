---
title: Architecture Patterns — Ptv Module
type: architecture
module: Ptv
status: approved
tags: [architecture, domain, case-management, workflow]
updated: "2026-06-18"
related:
  - ./README.md
  - ../app
  - ../../Xot/docs/architecture-patterns.md
  - ./architecture-overview.md
---

# Architecture Patterns — Ptv Module

> **Case Management & Workflow Domain.** Complex multi-actor workflows, state machines, and approval pipelines for personnel case management (Pratiche).

## Overview

Ptv (Pratiche Temporanee di Validazione / Temporary Validation Procedures) manages:
- **Case/Procedure Workflows** (multi-step approval chains)
- **State Machines** (draft → submitted → review → approved → completed)
- **Multi-actor Coordination** (employee, manager, HR, compliance)
- **Email Tracking** (audit trail of communications)
- **Business Rules Engine** (validation, eligibility, constraints)
- **Historical Records** (versioning and audit logs)

## Architettura Principale

### 1. Core Domain Models (31 Models)

**Main Entity: Ptv (Pratica/Case)**
```php
class Ptv extends XotBaseModel
{
    // Key relationships
    belongsTo(Dipendente)               // Employee/case owner
    belongsTo(User, 'created_by')       // Initiator
    belongsTo(User, 'approved_by')      // Approver
    hasMany(StoriaPtv)                  // History/versions
    hasMany(PtvActivity)                // Activity log
    hasMany(PtvEmailLog)                // Email tracking
    hasMany(PtvAttachments)             // Documents
    
    // Key attributes
    string $numero_pratica              // Case number (unique)
    string $tipo_pratica                // Case type
    enum $status                        // draft, submitted, review, approved, rejected, completed
    datetime $data_inizio               // Start date
    datetime $data_fine                 // End date
    text $descrizione                   // Description
    json $meta                          // Flexible metadata
    text $note_interne                  // Internal notes
    text $motivo_rigetto               // Rejection reason (if rejected)
}
```

**Specialized Models**:
```
StoriaPtv
├── Version history of case
├── Tracks all state changes
└── Enables rollback/audit

PtvActivity
├── User actions on case
├── Created/Updated/Submitted/Approved
└── Timestamp + actor tracking

PtvEmailLog
├── Email communications audit trail
├── Sent/Received emails
├── Attachment tracking
└── Delivery status

PtvAttachments
├── Associated documents
├── Storage path + metadata
├── Upload timestamp + uploader
└── Signature/approval workflow

PtvTemplate (21+ templates)
├── Case templates by type
├── Pre-defined fields
├── Workflow steps
└── Auto-population rules

PtvValidationRule
├── Business rules
├── Eligibility checks
├── Constraint validation
└── Dynamic rule evaluation

PtvApprovalChain
├── Multi-actor approval paths
├── Role-based routing
├── Escalation rules
└── SLA tracking
```

### 2. Filament Resources (103 Resources)

**Primary Resources**:
- **PtvResource** — Case management CRUD
- **StoriaPtvResource** — History/version browser
- **PtvActivityResource** — Activity audit log
- **PtvEmailLogResource** — Email tracking
- **PtvAttachmentResource** — Document management
- **PtvTemplateResource** — Template administration
- **PtvValidationRuleResource** — Rule management
- **PtvApprovalChainResource** — Workflow configuration

**Resource Features**:
```php
class PtvResource extends XotBaseResource
{
    // Customized form() with:
    ├── Case type selector (with conditional fields)
    ├── Dates & validity period
    ├── Status workflow (buttons: Submit, Approve, Reject)
    ├── Assignment (to manager/reviewer)
    ├── Rich text editor for description
    ├── Metadata JSON editor
    ├── Activity log timeline
    └── Email history viewer
    
    // Customized table() with:
    ├── Sortable columns (number, type, status, dates)
    ├── Filterable (status, type, assigned_to, date_range)
    ├── Bulk actions (bulk approve, bulk reject, bulk export)
    ├── Status badge (colored)
    ├── Quick-view modal
    └── Export to PDF/Excel
}
```

### 3. Actions Pattern (65 Actions — Highest Count)

**Case Lifecycle Actions**:
```php
CreatePtvAction
  ├── input: PtvData
  ├── Validate initial conditions
  ├── Auto-assign template fields
  └── output: Ptv instance

SubmitPtvAction
  ├── Transition: draft → submitted
  ├── Validation checks
  ├── Notification to approvers
  └── Activity log entry

ApprovePtvAction
  ├── Transition: review → approved
  ├── Digital signature support
  ├── Generate approval certificate
  ├── Trigger downstream workflows
  └── Email notification

RejectPtvAction
  ├── Transition: review → rejected
  ├── Require rejection reason
  ├── Allow re-submission
  ├── Notify employee
  └── Archive in history

CompletePtvAction
  ├── Final status: completed
  ├── Archive documents
  ├── Generate summary report
  └── Trigger cleanup tasks
```

**Validation Actions**:
```php
ValidatePtvEligibilityAction
  ├── Check employee status
  ├── Check role permissions
  ├── Verify case type applicability
  └── Validate date ranges

ValidatePtvConstraintsAction
  ├── Check business rules
  ├── Verify dependencies
  ├── Check for conflicts
  └── Validate metadata

CheckDuplicatePtvAction
  ├── Prevent duplicate cases
  ├── Check date overlaps
  ├── Merge if allowed
  └── Alert user

ValidateApprovalChainAction
  ├── Ensure approvers assigned
  ├── Check approval order
  ├── Verify SLA compliance
  └── Escalate if overdue
```

**Email & Communication Actions**:
```php
SendPtvNotificationAction
  ├── Email to stakeholders
  ├── SMS optional
  ├── Log in PtvEmailLog
  ├── Track delivery status
  └── Template-based messages

LogPtvEmailAction
  ├── Record incoming/outgoing email
  ├── Attach to case
  ├── Extract metadata
  └── Update activity log

GeneratePtvReportAction
  ├── PDF summary report
  ├── Include all documents
  ├── Timeline of changes
  └── Signature page
```

**Administrative Actions** (20+ more):
```
ExportPtvAction         → Excel/CSV export
ArchivePtvAction        → Move to archive
BulkUpdateStatusAction   → Batch processing
GenerateStatisticsAction → Analytics
CleanupOldPtvAction      → Retention policy
MergePtvAction          → Consolidate duplicates
... (65 total)
```

### 4. Data Transfer Objects (DTOs/Datas)

**Case Configuration**:
```php
class PtvData extends Data
{
    public function __construct(
        public string $tipo_pratica,
        public string $numero_pratica,
        public ?string $dipendente_id,
        public string $descrizione,
        public DateTime $data_inizio,
        public DateTime $data_fine,
        public ?string $template_id = null,
        public array $metadata = [],
        public ?array $allegati = null,
    ) {}
    
    public static function rules(): array
    {
        return [
            'tipo_pratica' => 'required|in:tipo1,tipo2,tipo3',
            'numero_pratica' => 'required|unique:ptv,numero_pratica',
            'data_inizio' => 'required|date',
            'data_fine' => 'required|date|after:data_inizio',
        ];
    }
}

class PtvApprovalData extends Data
{
    public function __construct(
        public string $ptv_id,
        public string $approved_by,
        public DateTime $approved_at,
        public ?string $firma_digitale = null,
        public ?string $note = null,
    ) {}
}

class PtvEmailLogData extends Data
{
    public function __construct(
        public string $ptv_id,
        public string $email_address,
        public string $subject,
        public string $body,
        public string $direction,  // 'incoming' or 'outgoing'
        public ?array $attachments = null,
        public string $status = 'sent',  // sent, failed, bounced
    ) {}
}
```

### 5. Service Layer

**PtvService** — Main business logic coordinator:
```php
class PtvService
{
    // Workflow management
    public function createFromTemplate(string $templateId, array $data): Ptv
    public function submitForApproval(string $ptvId): bool
    public function approve(string $ptvId, User $approver): bool
    public function reject(string $ptvId, User $rejector, string $reason): bool
    public function complete(string $ptvId): bool
    
    // Querying
    public function getPendingApprovals(User $manager): Collection
    public function getByStatus(string $status): Collection
    public function getByEmployee(string $employeeId): Collection
    public function getOverdue(): Collection
    
    // Validation
    public function validateEligibility(Dipendente $employee, string $tipo): bool
    public function validateConstraints(PtvData $data): array  // returns errors
    
    // Reporting
    public function generateReport(string $ptvId): string  // PDF path
    public function getStatistics(DateRange $period): array
}
```

**PtvEmailService** — Email tracking:
```php
class PtvEmailService
{
    public function logOutgoing(Ptv $ptv, string $email, array $data): void
    public function logIncoming(string $ptv_id, string $from, string $subject, string $body): void
    public function getHistory(string $ptvId): Collection
    public function syncWithMailbox(): void  // IMAP sync
}
```

**PtvApprovalChainService** — Multi-actor workflows:
```php
class PtvApprovalChainService
{
    public function buildChain(Ptv $ptv, string $chainType): Collection
    public function getNextApprover(Ptv $ptv): ?User
    public function notifyApprover(Ptv $ptv, User $approver): void
    public function escalateIfOverdue(Ptv $ptv): void
}
```

### 6. Events & Listeners

**Domain Events**:
```
PtvCreated
PtvSubmitted
PtvApprovalRequested
PtvApproved
PtvRejected
PtvCompleted
PtvArchivedEvent
```

**Listeners**:
- Send notifications
- Log to activity trail
- Update statistics
- Trigger downstream workflows
- Archive documents
- Generate audit reports

### 7. Policies & Authorization

**PtvPolicy**:
```php
view()      → User can view (own, assigned, or admin)
create()    → Dipendente + role check
update()    → Only if status=draft (by creator) or admin
delete()    → Only admin (soft-delete preserves history)
approve()   → Only assigned approver (via Role)
reject()    → Only approver (via Policy)
```

### 8. Business Rules Engine

**PtvValidationRule Model**:
```php
class PtvValidationRule extends Model
{
    // Stores rule conditions
    string $rule_type        // eligibility, constraint, dependency
    string $ptv_type        // case type this applies to
    string $rule_name       // human-readable name
    json $conditions        // Rule conditions (if-then)
    bool $active            // Enable/disable
    
    // Methods
    public function evaluate(Ptv $ptv): bool
    public function getErrorMessage(): string
}
```

### 9. State Machine Implementation

**Status Enum**:
```php
enum PtvStatus: string
{
    case Draft = 'draft';
    case Submitted = 'submitted';
    case Review = 'review';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Completed = 'completed';
    case Archived = 'archived';
}
```

**Transition Validation**:
```
draft           → submitted (all validations pass)
submitted       → review (auto-assign approvers)
review          → approved (digital signature required)
           OR   → rejected (reason required)
approved        → completed (optional, automatic after time)
completed/rejected → archived (retention policy)
```

## Model Relationships Diagram

```
Ptv (Case/Procedure)
├── belongsTo(Dipendente)
├── belongsTo(User, 'created_by')
├── belongsTo(User, 'approved_by')
├── hasMany(StoriaPtv)
├── hasMany(PtvActivity)
├── hasMany(PtvEmailLog)
├── hasMany(PtvAttachments)
├── belongsToMany(PtvTemplate)
└── hasMany(PtvApprovalStep)

PtvTemplate
├── hasMany(Ptv)           [via belongsToMany]
├── hasMany(TemplateField)
└── hasMany(ApprovalChain)

PtvApprovalChain
├── hasMany(ApprovalStep)
└── belongsTo(PtvTemplate)

PtvValidationRule
├── applies to: PtvType
└── evaluated on: Ptv

User/Dipendente
├── hasMany(Ptv)           [created_by]
├── hasMany(Ptv)           [approved_by]
└── hasMany(PtvActivity)
```

## Best Practices

### 1. Case Creation
- Always use template when possible
- Validate eligibility upfront
- Pre-populate from template fields
- Document decision rationale

### 2. Approval Workflow
- Never auto-approve (explicit action required)
- Require digital signature for legal compliance
- Keep approval chain under 4 levels (escalate if needed)
- Set SLA per case type

### 3. State Transitions
- Only allow valid transitions (enforce in action)
- Log every transition (activity trail)
- Notify stakeholders on state change
- Validate preconditions before transition

### 4. Email Handling
- Log all emails (incoming/outgoing)
- Use templates for consistency
- Archive related attachments
- Track delivery status

### 5. Data Integrity
- Use transactions for multi-step operations
- Maintain version history (never delete, soft-delete only)
- Validate constraints before save
- Implement idempotency for critical actions

### 6. Reporting
- Generate audit trail on demand
- Export to PDF for compliance
- Include timeline of all changes
- Require digital signature on exports

## Development Workflow

### Adding New Case Type
1. Create `PtvTemplate` with type-specific fields
2. Create `PtvApprovalChain` (routing rules)
3. Create domain-specific `Actions` (validation, submission)
4. Add `PtvValidationRules` for eligibility
5. Update Filament resources with conditional fields
6. Create test cases (unit + feature)
7. Document workflow in wiki

### Extending Approval Chain
1. Define new step in `PtvApprovalChain`
2. Create new `Action` if business logic needed
3. Create `Event` + `Listener` for notifications
4. Update `PtvApprovalChainService`
5. Test escalation scenarios
6. Document in architecture

## Backlinks & References

- **Root README**: [Ptv Module](./README.md)
- **Architecture Overview**: [architecture-overview.md](./architecture-overview.md)
- **Framework Base**: [Xot Architecture Patterns](../../Xot/docs/architecture-patterns.md)
- **Email Tracking**: [activity-log-final-summary.md](./activity-log-final-summary.md)
- **PHPStan**: [phpstan documentation files](./phpstan-*.md)
- **Related Modules**: [IndennitaResponsabilita](../IndennitaResponsabilita/docs/), [IndennitaCondizioniLavoro](../IndennitaCondizioniLavoro/docs/)

---

**Document Type**: Architecture Reference  
**Module**: Ptv  
**Last Updated**: 2026-06-18  
**Maintainers**: Development Team  
**Status**: Approved
