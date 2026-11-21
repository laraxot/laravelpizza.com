---
title: "User Module API Reference"
type: reference
tags: [user, api, actions]
created: 2026-07-28
updated: 2026-07-28
---

# User Module — API Reference

## Actions

### Authentication\LoginAction
```php
execute(string $email, string $password): bool
```
Validates credentials and creates session. Returns true on success.

### Authentication\LogoutAction
```php
execute(): void
```
Destroys session and clears auth state.

### UserManagement\CreateUserAction
```php
execute(array $data): User
```
Creates new user. Data: `email`, `password`, `name`.

### UserManagement\DeleteUserAction
```php
execute(User $user): bool
```
Soft-deletes user. Returns true if successful.

## Models

### User
```php
$user = User::find($id);
$user->email;
$user->name;
$user->hasRole('admin');
$user->assignRole('editor');
```

### Team
```php
$team = Team::find($id);
$team->members();          // User collection
$team->owner;              // User (belongs-to)
```

## Traits

### HasAuthenticationLogTrait
Provides `authenticationLogs()` relation on User.

### HasTeams
Provides `teams()` and `currentTeam()` methods (requires HasRoles).

### HasTenants
Provides `tenants()` and `currentTenant()` methods (requires HasRoles).
