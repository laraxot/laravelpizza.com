---
title: "Technical Debt - User Module"
type: concept
tags: [technical, debt]
created: 2026-07-14
updated: 2026-07-14
qmd: "technical-debt technical debt - user module"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-roadmap-user.md"
  - "./00-index.md"
  - "./00-overview.md"
  - "./01-current-state.md"
  - "./01-now.md"
  - "./02-goals.md"
  - "./02-next.md"
  - "./03-later.md"
status: draft
---

# Technical Debt - User Module

| Area | Stato | Target |
|------|-------|--------|
| File obsoleti | 550+ | 0 |
| Security Cluster | Da implementare | Filament v5 Cluster |
| Test Auth | Parziale | 100% flussi critici |
| Passport/Sanctum | In uso | Auditing token |

## Dipendenze

- **Xot**: XotBaseResource, XotBasePage
- **Gdpr**: Consensi registrazione
- **Tenant**: Multi-tenant (se attivo)
