---
module: User
concept: User vs Profile
last_updated: 2026-04-15
---

# User vs Profile Models

To adhere to the **Single Responsibility Principle**, PTVX separates authentication data from public/extended profile data.

## 1. Responsibilities

### User Model (The Identity)
- **Primary Goal**: Authentication and Authorization.
- **Fields**: `email`, `password`, `is_active`, `type`, `state`, `lang`.
- **Connections**: Handled by the `auth` database connection.

### Profile Model (The Persona)
- **Primary Goal**: Public display and extended metadata.
- **Fields**: `first_name`, `last_name`, `avatar`, `bio`, `phone`, `city`.
- **Connections**: Handled by module-specific connections (e.g., `meetup`, `performance`).

## 2. Decision Matrix

| Data Type | User Model | Profile Model |
| :--- | :---: | :---: |
| Credentials (Password, Hash) | ✅ | ❌ |
| Roles & Permissions | ✅ | ❌ |
| Preferred Language | ✅ | ❌ |
| Account Status (Active/Banned) | ✅ | ❌ |
| Public Avatar | ❌ | ✅ |
| Bio / Description | ❌ | ✅ |
| Demographic Data (City, Age) | ❌ | ✅ |
| Tenant-Specific Data | ❌ | ✅ |

## 3. Golden Rules

1. **User for LOGIN**: Use the User model for anything required to login, check permissions, or display the name in the header (fallback).
2. **Profile for VIEW**: Use the Profile model for anything visible to other users, optional during registration, or highly extensible.
3. **NEVER sensitive data in Profile**: Password hashes or API tokens must never leak into the Profile model.
4. **Minimal Duplication**: Prefer one source of truth. If a field exists in both (e.g., `first_name`), designate the User model as the master.

## 4. Performance: Eager Loading
Always load the profile when needed to avoid N+1 queries:

```php
$users = User::with('profile')->get();
```

---
**Related Pages:**
- [[User Module Architecture]]
- [[BaseModel]]
- [[Schemaless Attributes]]
