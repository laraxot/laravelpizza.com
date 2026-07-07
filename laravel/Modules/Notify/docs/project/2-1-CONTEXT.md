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
- **Model**: `Modules\Fixcity\Models\Ticket` (need to verify this).
- **Filtering**: Eager loading to optimize queries.
- **Auth**: Required `auth` middleware.

## Questions to Resolve
- [ ] Is there already a `Ticket` model in the `Fixcity` module?
- [ ] What are the ticket statuses available?
- [ ] How is the relation between User and Ticket defined?
