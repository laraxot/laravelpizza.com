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
