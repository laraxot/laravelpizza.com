---
title: "Topic 00-index"
type: digest
status: active
qmd: "digest ceiling 100 00-index"
---

# Topic 00-index

Sintesi automatica di 3 documenti (chiave `00-index`).

## Indice BMAD — Tenant

_Fonte: `bmad/00-index.md`_

# Indice BMAD — Tenant

- [Purpose](./purpose.md)
- [Architecture](./architecture.md)
- [Epics](./epics.md)
- [Decision log](./decision-log.md)
- [Brainstorming](./brainstorming.md)
- [Audit](./audit.md) → [Audit dettagliato](./audits/tenant-audit.md)
- [Piano di miglioramento](./piano-miglioramento.md) (parzialmente superato dall'audit 2026-11-16)
<<<<<<< HEAD
- [Story audit modulo](./stories/module-bmad-audit.story.md)
=======
- [Story audit modulo](stories/0005-module-bmad-audit.story.md)
>>>>>>> laraxot/dev
- [ECC](../ecc/00-index.md)
- [Purpose root](../purpose.md)

## Roadmap Index - Tenant

_Fonte: `roadmap/00-index.md`_

# Roadmap Index - Tenant

## Scope

Questo piano copre il module **Tenant** e le sue integrazioni principali.

## Files

- [Current State](./current-state.md)
- [Goals](./goals.md)
- [Workstreams](./workstreams.md)
- [Milestones](./milestones.md)
- [Risks](05-risks.md)

## Note operative

- Tenere il piano aggiornato con cambiamenti architetturali.
- Inserire date reali e owner quando disponibili.

---

<!-- Merged from 00-index.md, which collided with this file on case-insensitive filesystems. -->

---
title: "Roadmap Index - Tenant"
module: "Tenant"
type: concept
tags: [00, INDEX]
created: 2026-07-14
updated: 2026-07-14

## Tenant Module — Documentation Index

_Fonte: `wiki/00-index.md`_

# Tenant Module — Documentation Index

**Path**: `laravel/Modules/Tenant/docs/`  
**Updated**: 2026-07-01  
**Status**: Multi-tenant core module

---

## 🎯 Quick Start

**Multi-tenancy 101**: [tenantidentification.md](./wiki/tenantidentification.md) — How tenants are identified and isolated  
**Architecture**: [architecture.md](./wiki/architecture.md) — System design and data flow  
**Configuration**: See **Multi-Tenant Config** section below ⬇️

---

## 📋 Hub Canonici (Core Files)

### Wiki (Sacred — Do Not Delete)
- **[wiki/index.md](./wiki/index.md)** — Operating manual for LLM agents
- **[wiki/architecture.md](./wiki/architecture.md)** — Multi-tenant system design
- **[wiki/tenantidentification.md](./wiki/tenantidentification.md)** — How tenants are identified
- **[wiki/configurationdistribution.md](./wiki/configurationdistribution.md)** — Config per tenant
- **[wiki/schema.md](./wiki/schema.md)** — Database schema reference

### Roadmap
- **[roadmap/00-index.md](./roadmap/00-index.md)** — Q4 2025 roadmap and phases
- **[roadmap/vision.md](../roadmap/vision.md)** — Long-term vision
- **[roadmap/tenant-isolation.md](../roadmap/tenant-isolation.md)** — Data isolation strategy
