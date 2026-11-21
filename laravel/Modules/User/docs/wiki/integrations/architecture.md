---
title: "User Module Architecture"
type: architecture
tags: [module, architecture, design]
created: 2026-07-28
updated: 2026-07-28
---

# User Module — Architecture

## System Boundary

Il modulo **User** fornisce le fondamenta di autenticazione, autorizzazione e gestione identità per l'intera piattaforma Laraxot. È un **modulo core**, essenziale, separato dal resto solo per organizzazione logica.

```
┌─────────────────────────────────────────────────────────────┐
│                        User Module                          │
├─────────────────────────────────────────────────────────────┤
│ Authentication │ Authorization │ Identity │ Team/Tenant Mgmt│
│              (Spatie Permission)                             │
├─────────────────────────────────────────────────────────────┤
│ Dipendenze: Laravel 11/12, Spatie Permission, Filament v5   │
│ Dipendenti: 16+ moduli (Activity, Notify, Tenant, Lang...)  │
└─────────────────────────────────────────────────────────────┘
```

## Layer Architecture

### Layer 1: Models (Eloquent)
```
app/Models/
├── User                    # BaseModel → XotBaseModel (UUID, timestamps)
├── Team                    # Multi-team support
├── Tenant                  # Multi-tenancy isolation
├── Role                    # Spatie Permission wrapper
└── Permission              # Spatie Permission wrapper
```

**Relazioni Critiche:**
- `User` → `HasMany(Team)` — gestione team multipli
- `User` → `BelongsToMany(Role)` — via `model_has_role`
- `User` → `BelongsToMany(Tenant)` — isolamento multi-tenant
- `Team` → `HasMany(User)` — team members

### Layer 2: Actions (Reusable Business Logic)
```
app/Actions/
├── Authentication/
│   ├── LoginAction              # Validate + session creation
│   ├── LogoutAction             # Cleanup + logout
│   └── TwoFactorAction          # 2FA logic
├── Authorization/
│   ├── AssignRoleAction         # Attach role → user
│   ├── RevokePermissionAction   # Detach permission
│   └── CheckAccessAction        # Gate/policy enforcement
├── UserManagement/
│   ├── CreateUserAction         # User creation + defaults
│   ├── UpdateUserAction         # Profile edits
│   ├── DeleteUserAction         # Soft delete
│   └── ActivateUserAction       # Enable/disable toggle
└── TeamManagement/
    ├── CreateTeamAction
    ├── AddTeamMemberAction
    └── RemoveTeamMemberAction
```

### Layer 3: Traits (Reusable Behaviors)
```
app/Traits/
├── HasAuthenticationLogTrait    # Track login/logout events
├── HasTeams                     # Multi-team support (requires HasRoles)
└── HasTenants                   # Multi-tenancy isolation (requires HasRoles)
```

### Layer 4: Filament Resources (Admin UI)
```
app/Filament/Resources/
├── UserResource                 # CRUD users
├── TeamResource                 # Team management
├── RoleResource                 # Role configuration
└── PermissionResource           # Permission setup
```

### Layer 5: Configuration
```
config/user.php                  # Module-level settings
- authentication_timeout (minuti)
- two_factor_enabled (bool)
- team_limit_per_user (int)
- tenant_isolation_mode (enum: none|soft|hard)
```

## Dependency Graph

**Consumed by:** Activity, Notify, Tenant, Lang, Performance, UI, Progressioni, Rating, Sigma, Job, Media...  
**Depends on:** Xot (BaseModel), Spatie Permission, Laravel Auth

## Quality Gates

✅ **PHPStan L10:** Executed (2026-07-28)  
⚠️ **PHPMD:** Blocked (PDepend/Symfony conflict)  
⚠️ **PHP Insights:** Blocked (plugin allowlist)
