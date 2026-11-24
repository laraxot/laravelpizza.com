---
title: "User Module Quick Start"
type: guide
tags: [user, authentication, quick-start]
created: 2026-07-28
updated: 2026-07-28
---

# User Module — Quick Start

## Installation

```bash
php artisan migrate --path=Modules/User/database/migrations
```

## Create First User

```php
use Modules\Xot\Contracts\UserContract;
use Illuminate\Support\Facades\Hash;

$user = User::create([
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'name' => 'Admin User',
]);

// Assign admin role
$user->assignRole('admin');
```

## Authenticate User

```php
use Illuminate\Support\Facades\Auth;

// Check if authenticated
Auth::check();           // bool
Auth::id();              // UUID
Auth::user();            // User model
```

## Check Permissions

```php
// Via gate
Gate::authorize('edit-user', $targetUser);

// Via policy
$user->can('edit', $targetUser);

// Via permission
$user->hasPermissionTo('edit-posts');

// Via role
$user->hasRole('admin');
```

## Key Files

- `app/Models/User.php` — User model
- `app/Actions/Authentication/` — Auth actions
- `app/Filament/Resources/UserResource.php` — Admin panel
- `database/migrations/` — Migrations
- `config/user.php` — Config
