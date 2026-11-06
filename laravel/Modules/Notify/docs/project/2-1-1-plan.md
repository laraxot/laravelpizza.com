---
title: "PHASE 2 - EPIC 2.1 - TASK 1: Create /my-tickets Folio Page"
type: concept
tags: [plan]
created: 2026-07-14
updated: 2026-07-14
qmd: "2-1-1-plan phase 2 - epic 2.1 - task 1: create /my-tickets folio page"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./2-1-context.md"
  - "./agents.md"
  - "./ai-agent-lessons-learned.md"
  - "./ai-skills-and-plugins-complete.md"
  - "./commit-message.md"
  - "./configuration.md"
  - "./design-comuni-bmad-master-plan.md"
  - "./docs-governance.md"
status: draft
---

# PHASE 2 - EPIC 2.1 - TASK 1: Create /my-tickets Folio Page

## Goal
Implement a dynamic dashboard for citizens to view and filter their submitted tickets.

## Plan
1. Create `laravel/Themes/Sixteen/resources/views/pages/my-tickets.blade.php`.
2. Define Folio metadata (middleware: `auth`, `verified`).
3. Implement Volt component logic:
   - Fetch authenticated user's tickets using `Ticket::where('owner_id', auth()->id())`.
   - Implement eager loading for `type`, `priority`, and `statuses`.
   - Add filtering logic by status.
4. Implement UI using Tailwind CSS and Sixty theme components:
   - Header with statistics.
   - List of tickets with status badges and icons.
   - Empty state handling.

## Verification
- Access `/my-tickets` as an authenticated user.
- Verify that only personal tickets are displayed.
- Test filtering by status.
- Confirm performance (check query count with Debugbar if possible, or simulate).
