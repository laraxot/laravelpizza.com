---
title: "User Module - Authentication Patterns"
type: "patterns"
tags: ["user", "auth", "roles", "permissions"]
date: "2026-06-13"
qmd: "user-auth-patterns"
github_issue: ""
github_discussion: ""
---

# User Module - Authentication Patterns

## Overview

Sistema autenticazione e autorizzazione multi-tenant.
Stato: ✅ Stabile - 90% completato

## Architettura

```
User
├── Authentication
│   ├── Login/Logout
│   ├── Password Reset
│   ├── OAuth (Google, GitHub)
│   └── 2FA (TOTP)
├── Authorization
│   ├── Roles
│   ├── Permissions
│   └── Teams
└── Profile
    ├── Dati personali
    ├── Preferenze
    └── Notifiche
```

## Multi-Tenancy

### User-Tenant Relationship
```php
// Un user può appartenere a multipli tenant
User → belongsToMany(Tenant)

// Tenant corrente in sessione
tenant_id: bigint (nullable in users)
```

### Tenant Context
```php
// Filament
class UserResource extends XotBaseResource
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tenant_id', tenant()->id);
    }
}

// Actions
class ListUsersAction
{
    public function execute(): Collection
    {
        return User::where('tenant_id', tenant()->id)->get();
    }
}
```

## Roles & Permissions

### Spatie Permission
```php
// Config
'permission' => [
    'models' => [
        'permission' => Permission::class,
        'role' => Role::class,
    ],
]

// Usage
$user->assignRole('admin');
$user->givePermissionTo('edit segnalazioni');
```

### Role Hierarchy
```
super-admin (all tenants)
├── admin (single tenant)
│   ├── manager
│   └── operator
└── user (cittadino)
```

## Filament Shield

```php
// UserResource with Shield
class UserResource extends XotBaseResource
{
    use HasShieldPermissions;
    
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}
```

## API Auth

### Sanctum
```php
// Login
POST /api/auth/login
→ CreateTokenAction → ['token' => '...']

// Me
GET /api/auth/me
→ GetCurrentUserAction → UserData

// Logout
POST /api/auth/logout
→ RevokeTokenAction → 204
```

## TODO

- [ ] OAuth providers (Google, GitHub)
- [ ] 2FA TOTP implementation
- [ ] Device management
- [ ] Session tracking

## Collegamenti

- [Project Roadmap](../../Activity/docs/wiki/PROJECT-ROADMAP.md)
- [Tenant Module](../../../Tenant/docs/wiki/)
