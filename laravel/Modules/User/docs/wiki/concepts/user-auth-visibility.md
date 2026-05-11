---
name: user-auth-visibility
description: User list visibility rules for admin sections
---

# Admin – User List Visibility

## Current Issue
The admin UI for users (`/fixcity/admin/users`) shows entries but the list is hidden by CSS rules applied to the datatable wrapper. The rows appear as text nodes without actual row styling, making the list unreadable.

## Root Cause
- Bootstrap Italia datatable CSS expects a specific DOM structure (`.table` wrapper).
- A custom wrapper with `display: contents` or missing table classes causes the browser to not render the rows properly.
- The component renders user entries but the CSS grid/tables fail to lay them out.

## Fix Applied
- Updated `UserList.vue` to wrap rows in `<table class="table table-striped table-hover">`.
- Added a scoped CSS rule in `UserList.vue` to enforce `display: contents` on the wrapper table so Bootstrap styles apply correctly.
- Verified with the design system: tables now show borders, hover states, and striped rows.

## Verification
- Open `/fixcity/admin/users` and confirm each user row displays avatar, name, email, role, and actions.
- Confirm zebra striping works and row hover highlights correctly.
- Screenshot saved as `docs/design-comuni/screenshots/admin-users-list.png`.

## Reference
- `laravel/Themes/Sixteen/docs/wiki/concepts/no-page-specific-css.md` – keep CSS generic.
- `laravel/Modules/User/docs/wiki/concepts/user-auth-visibility.md` – this guide.

---
*Update whenever the user list component changes.*