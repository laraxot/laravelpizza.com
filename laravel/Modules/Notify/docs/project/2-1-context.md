---
title: "PHASE 2 - EPIC 2.1: Citizen Dashboard - CONTEXT"
type: concept
tags: [context]
created: 2026-07-14
updated: 2026-07-14
qmd: "2-1-context phase 2 - epic 2.1: citizen dashboard - context"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./2-1-1-plan.md"
  - "./agents.md"
  - "./ai-agent-lessons-learned.md"
  - "./ai-skills-and-plugins-complete.md"
  - "./commit-message.md"
  - "./configuration.md"
  - "./design-comuni-bmad-master-plan.md"
  - "./docs-governance.md"
status: draft
---

# PHASE 2 - EPIC 2.1: Citizen Dashboard - CONTEXT

## Purpose
Provide a centralized area for citizens to manage their reports (tickets), see statistics, and interact with a map.

## UI/UX Decisions
- **Layout**: Use `x-layouts.app` from the Sixteen theme.
- **Components**: Use Livewire Volt for reactivity.
- **Route**: `/my-tickets` via Folio.
- **Features**:
  - List of personal tickets with status indicators.
  - Basic stats (Total, Pending, Solved).
  - Search/Filter by status.

## Technical Details
- **Model**: `Modules\App\Models\Ticket` (need to verify this).
- **Filtering**: Eager loading to optimize queries.
- **Auth**: Required `auth` middleware.

## Questions to Resolve
- [ ] Is there already a `Ticket` model in the `App` module?
- [ ] What are the ticket statuses available?
- [ ] How is the relation between User and Ticket defined?
