---
title: Documentation Index — IndennitaCondizioniLavoro Module
module: IndennitaCondizioniLavoro
type: index
status: approved
tags: [documentation, index, work-conditions, allowances]
updated: "2026-06-18"
related:
  - ./README.md
  - ./architecture-patterns.md
---

# Documentation Index — IndennitaCondizioniLavoro Module

> **Work Conditions Allowances Hub.** Complete reference for hazard pay, shift differentials, and compensation patterns.

## Quick Navigation

### Start Here
1. **[README.md](./README.md)** — Module overview
2. **[architecture-patterns.md](./architecture-patterns.md)** — Domain design & eligibility rules
3. **[phpstan-fixes.md](./phpstan-fixes.md)** — Type-checking patterns

## Core Components

### Models (26 Models)
| Model | Purpose |
|-------|---------|
| `CondizioniLavoro` | Work condition definitions |
| `Indennitá` | Allowances granted |
| `StoricoCondizioni` | Condition history |
| `EligibilityRule` | Eligibility rules engine |

### Filament Resources (39 Resources)
- CondizioniLavoroResource, IndennitáResource, EligibilityRuleResource

### Services
- CondizioniLavoroService, IndennitáService, EligibilityService, PayrollIntegrationService

## 📚 Related Documentation

- **[accessor-guard-audit.md](./accessor-guard-audit.md)** — Accessor patterns
- **[code-redundancy-audit.md](./code-redundancy-audit.md)** — Code quality
- **[phpstan-*.md](./phpstan-*.md)** — Type-checking issues

## Eligibility Rules Types
- Role-based (position/department)
- Location-based (remote/onsite)
- Time-based (tenure/seniority)
- Salary-based (income brackets)

## 📞 Support

See **[architecture-patterns.md](./architecture-patterns.md)** for:
- Complete domain model
- Service layer patterns
- Business rules engine
- Payroll integration

---

**Last Updated**: 2026-06-18  
**Status**: Approved
