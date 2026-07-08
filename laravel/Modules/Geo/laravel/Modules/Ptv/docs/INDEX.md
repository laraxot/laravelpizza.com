---
title: Documentation Index — Ptv Module
module: Ptv
type: index
status: approved
tags: [documentation, index, case-management, workflow]
updated: "2026-06-18"
related:
  - ./README.md
  - ./architecture-patterns.md
---

# Documentation Index — Ptv Module

> **Case Management Hub.** Complete reference for Ptv (Pratiche) workflows, state machines, and approval pipelines.

## Quick Navigation

### Start Here
1. **[README.md](./README.md)** — Module overview
2. **[architecture-patterns.md](./architecture-patterns.md)** — Design patterns and workflows
3. **[architecture-overview.md](./architecture-overview.md)** — Technical details

## Core Components

### Models (31 Models)
| Model | Purpose |
|-------|---------|
| `Ptv` | Main case/procedure entity |
| `StoriaPtv` | History & versioning |
| `PtvActivity` | Activity audit log |
| `PtvEmailLog` | Email communications |
| `PtvAttachments` | Documents |
| `PtvTemplate` | Case templates (21+) |
| `PtvValidationRule` | Business rules |
| `PtvApprovalChain` | Approval workflows |

### Filament Resources (103 Resources)
- PtvResource, StoriaPtvResource, PtvActivityResource, PtvEmailLogResource, PtvAttachmentResource, PtvTemplateResource, and more

### Actions (65 Actions)
- Lifecycle: Create, Submit, Approve, Reject, Complete, Archive
- Validation: Eligibility, Constraints, Duplicates, Approval Chain
- Email & Communication: Send Notification, Log Email, Generate Report
- Administrative: Export, Bulk Update, Statistics, Cleanup

### Workflow States
```
draft → submitted → review → approved/rejected → completed → archived
```

## 📚 Related Documentation

- **[activity-log-final-summary.md](./activity-log-final-summary.md)** — Email tracking & audit
- **[activity-log-email-tracking-final-implementation.md](./activity-log-email-tracking-final-implementation.md)** — Implementation guide
- **[PHPStan Files](./phpstan-*.md)** — Type-checking issues

## 📞 Support

See **[architecture-patterns.md](./architecture-patterns.md)** for:
- Complete model relationships
- Service layer patterns
- Business rules engine
- Development workflow

---

**Last Updated**: 2026-06-18  
**Status**: Approved
