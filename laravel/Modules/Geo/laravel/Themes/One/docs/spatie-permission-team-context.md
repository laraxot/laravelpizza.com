# Spatie Permission Team Context

## Theme Boundary

Theme One is presentation. It must not override Spatie Permission configuration.

The User module owns:

- `Modules\User\Models\Permission`
- `Modules\User\Models\Role`
- `Modules\User\Models\Team`

## Rendering Rule

Use Laravel authorization APIs (`can()`, policies, Filament authorization hooks) and avoid role-name coupling in Blade/Livewire views.

If team switching is visible in the theme, the active team context is part of authorization state. After switching teams, User module code is responsible for resetting the active Spatie team id and reloading role/permission relations.

Spatie Permission v7 separates the configured team model from the active team id:

- `permission.models.team` must point to `Modules\User\Models\Team`;
- `setPermissionsTeamId()` must be called by domain code after a team switch;
- stale `roles` and `permissions` relations must be unloaded before new checks.

## Troubleshooting

`TeamModelNotConfigured` means Spatie's registrar does not know the team model. This is a User module/config-cache issue, not a theme issue.

See `Modules/User/docs/spatie-permission-teams-laravel-13.md`.

Source rule: Spatie Permission v7 teams mode requires both `permission.teams = true` and `permission.models.team`.
