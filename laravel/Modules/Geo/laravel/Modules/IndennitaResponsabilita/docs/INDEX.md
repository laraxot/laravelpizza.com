---
title: Documentation Index — IndennitaResponsabilita Module
module: IndennitaResponsabilita
type: index
status: approved
tags: [documentation, index, responsibility-allowances, domain]
updated: "2026-06-18"
related:
  - ./README.md
  - ./architecture-patterns.md
---

# Documentation Index — IndennitaResponsabilita Module

> **Responsibility Allowances Domain Hub.** Complete reference for position-based bonuses, role compensation, and management allowances architecture.

## Quick Navigation

### Start Here
1. **[README.md](./README.md)** — Module overview and purpose
2. **[architecture-patterns.md](./architecture-patterns.md)** — Domain design patterns and workflows
3. **[PHPStan Documentation](#phpstan-documentation)** — Type-checking fixes

### Domain & Business Logic
- **[analysis-summary.md](./analysis-summary.md)** — Complete module analysis
- **[anag-relationship-conflict-resolution.md](./anag-relationship-conflict-resolution.md)** — Relationship handling patterns
- **[activity-log-integration.md](./activity-log-integration.md)** — Audit trail implementation

### Technical Documentation
- **[api.md](./api.md)** — API endpoints and contracts
- **[CHANGELOG.md](./CHANGELOG.md)** — Version history

---

## 📊 Core Components

### Models (27 Models)
| Model | Purpose | Relations |
|-------|---------|-----------|
| `IndennitaResponsabilita` | Main allowance entity | Dipendente, ServiceEsterni, History |
| `StoricoIndennitaResponsabilita` | Audit trail | belongs to Indennitá |
| `ServiceEsterni` | External agencies | hasMany Allowances |
| `ServiceEsternoRep` | External representatives | belongsTo ServiceEsterni |

### Filament Resources (76 Resources)
- **IndennitaResponsabilitaResource** — Allowance management
- **ServiceEsterniResource** — External service admin
- **ServiceEsternoRepResource** — Representative management

### Actions (7 Actions)
- `CalculateIndennitaResponsabilitaAction`
- `SubmitForApprovalAction`
- `ApproveIndennitaAction`
- `RejectIndennitaAction`
- `ValidateResponsibilityHierarchyAction`
- `NotifyApprovalPendingAction`
- `NotifyApprovedAction`

### Workflow States
```
Draft → Submitted → Approved/Rejected
  ↓       ↓          ↓
  Create  Review     Active (with date range)
```

---

## 📚 PHPStan Documentation

| File | Focus | Status |
|------|-------|--------|
| [phpstan-analysis.md](./phpstan-analysis.md) | Type checking issues | Active |
| [phpstan-filament5-tablefilters.md](./phpstan-filament5-tablefilters.md) | Filament 5 table filter types | Active |

---

## 🏛️ Architecture Reference

### Approval Workflow
```
User (Dipendente)
  ├── Creates IndennitaResponsabilita (status: draft)
  ├── Submits for approval (status: submitted)
  │   ├── Notification → Manager
  │   └── Activity logged
  │
Manager (Approver)
  ├── Reviews & Approves (status: approved)
  │   ├── Notification → Employee
  │   ├── History recorded
  │   └── Amount calculated
  │
Payroll System
  └── Processes active allowances (date range validation)
```

### Service Integration
```
IndennitaResponsabilita
  └── Optional Service Esterno relationship
      ├── External agency/partner
      ├── Representative tracking
      └── External compensation handling
```

---

## 📋 Domain Concepts

### Responsibility Types
- **Position-based** (director, coordinator)
- **Service-based** (external representative)
- **Role-based** (management responsibility)

### Amount Calculation
- Fixed amount: `importo`
- Percentage-based: `percentuale` of base salary
- Combined calculation with formula

### Period Management
- Date range (inizio → fine)
- No overlapping periods validation
- Historical queries for audit

### Approval Chain
- Created by employee
- Submitted to manager
- Approved/Rejected by authority
- Audit trail of all transitions

---

## 🛠️ Development Patterns

### Adding New Allowance Type
1. Update `status` enum if new state needed
2. Create calculation action
3. Add Filament resource section
4. Create validation rules
5. Document in architecture-patterns.md

### Extending Workflow
1. Create new `Action` for transition
2. Create `Event` for state change
3. Create `Listener` for notifications
4. Update Filament resource buttons/logic
5. Update policies/authorization

### Querying Allowances
```php
// Active allowances for period
IndennitaResponsabilita::active()
    ->whereBetweenDates($date)
    ->get();

// Pending approvals
IndennitaResponsabilita::where('status', 'submitted')->get();

// Historical changes
$indennitá->history()->get();
```

---

## 📞 Support & Questions

### Documentation Files
- **Domain logic** → [analysis-summary.md](./analysis-summary.md)
- **Relationships** → [anag-relationship-conflict-resolution.md](./anag-relationship-conflict-resolution.md)
- **Activity tracking** → [activity-log-integration.md](./activity-log-integration.md)
- **API contracts** → [api.md](./api.md)

### Related Modules
- **[IndennitaCondizioniLavoro](../IndennitaCondizioniLavoro/docs/)** — Work conditions allowances
- **[Xot Framework Base](../../Xot/docs/)** — Core classes and patterns
- **[User Module](../User/docs/)** — Employee/user management

---

## 📖 Related Documentation

- **GitHub Issue Discipline**: [docs/wiki/how-to/github-issue-agent-discipline.md](../../../docs/wiki/how-to/github-issue-agent-discipline.md)
- **Standard README Pattern**: [docs/wiki/standards/module-theme-readme-dual.md](../../../docs/wiki/standards/module-theme-readme-dual.md)
- **Code Redundancy Audit**: [code-redundancy-audit.md](./code-redundancy-audit.md)
- **Agent Edit Discipline**: [agent-edit-discipline.md](./agent-edit-discipline.md)

---

**Document Type**: Documentation Index  
**Module**: IndennitaResponsabilita  
**Last Updated**: 2026-06-18  
**Maintainers**: Development Team  
**Status**: Approved
