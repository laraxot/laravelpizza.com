# Spatie Permission Team Context

## Boundary

Three must consume authorization state, not own it.

Spatie Permission model ownership is:

- User module: concrete permission, role, and team models.
- Xot module: shared conventions and framework guardrails.
- Three: UI rendering only.

## Practical Rule

When a rendered page depends on team-aware authorization, use Laravel/Filament authorization APIs. Do not read or rewrite `permission.models.team` from the theme.

If a dashboard raises `Spatie\Permission\Exceptions\TeamModelNotConfigured`, fix the User module permission configuration and clear application/permission caches.

Reference: `Modules/User/docs/spatie-permission-teams-laravel-13.md`.

Source rule: Spatie Permission v7 teams mode requires both `permission.teams = true` and `permission.models.team`.

Spatie Permission v7 also separates configured team model from active team id:

- `permission.models.team` must point to `Modules\User\Models\Team`;
- `setPermissionsTeamId()` must be called by User-domain code after a team switch;
- stale `roles` and `permissions` relations must be unloaded before new checks.
