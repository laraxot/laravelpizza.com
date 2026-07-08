---
title: SocialiteUser — Entità OAuth utente
type: entity
module: User
updated: 2026-04-20
---

# SocialiteUser

**Path**: `Modules/User/app/Models/SocialiteUser.php`
**Tabella**: `socialite_users`
**Estende**: `BaseModel` → `XotBaseModel`

## Schema

| Colonna | Tipo | Note |
|---------|------|------|
| `id` | int PK | |
| `user_id` | string | FK → users.id |
| `provider` | string | 'google', 'facebook', 'github', ... |
| `provider_id` | string | ID univoco del provider |
| `token` | string\|null | OAuth access token |
| `name` | string\|null | Nome dal provider |
| `email` | string\|null | Email dal provider |
| `avatar` | string\|null | URL avatar |

## Relazioni

- `user()` → BelongsTo User (via `XotData::make()->getUserClass()`)

## Creazione

Gestita da `CreateSocialiteUserAction`. **Non** modificare manualmente.

## Anti-pattern da evitare

```php
// ❌ MAI aggiungere colonne a users
// $user->google_id = ...;

// ✅ Usare SocialiteUser
CreateSocialiteUserAction->execute($provider, $oauthUser, $user);
```

## Link

- [Architettura Socialite](../concepts/socialite-architecture.md)
- [Migration](../../../../../../database/migrations/2023_01_01_000003_create_socialite_user_table.php)
