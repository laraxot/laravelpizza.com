---
title: "BaseUser Model in Laravel Modules"
type: concept
tags: [baseuser]
created: 2026-07-14
updated: 2026-07-14
qmd: "baseuser baseuser model in laravel modules"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# BaseUser Model in Laravel Modules

## Overview
This document outlines the structure and usage of the `BaseUser` model within a Laravel module, serving as the foundation for user-related functionality.

## Key Principles
1. **Inheritance**: `BaseUser` provides common attributes and methods for all user types, allowing for easy extension.
2. **Modularity**: Designed to be reusable across projects without modification.
3. **Customization**: Can be extended to include specific user types like admin or customer.

## Implementation Guidelines
### 1. Model Structure
- The `BaseUser` model includes essential fields like `id`, `name`, `email`, and authentication-related attributes.
  ```php
  namespace Modules\User\Models;

  use Illuminate\Foundation\Auth\User as Authenticatable;

  class BaseUser extends Authenticatable
  {
      protected $fillable = ['name', 'email', 'password'];
      // Common methods and relationships
  }
  ```

### 2. Extending BaseUser
- Create specific user models by extending `BaseUser` to add custom fields or logic.
  ```php
  namespace Modules\User\Models;

  class User extends BaseUser
  {
      protected $fillable = ['name', 'email', 'password', 'role'];
      // Custom logic for this user type
  }
  ```

### 3. Single Table Inheritance
- Use single table inheritance to manage different user types within the same database table, using a `type` column to differentiate.

## Common Issues and Fixes
- **Inheritance Conflicts**: Ensure that extending models do not redefine essential `BaseUser` methods unless intentional.
- **Attribute Overlap**: Avoid duplicating attributes in child models that are already defined in `BaseUser`.

## Documentation and Updates
- Document any custom extensions or modifications to `BaseUser` in the relevant module's documentation folder.
- Update this document if significant changes are made to the `BaseUser` structure or functionality.

## Links to Related Documentation
- [User Module Index](./index.md)
- [Authentication Pages Implementation](./auth-pages-implementation.md)
- [Profile Management](./profile-management.md)
- [Routing Best Practices](./routing-best-practices.md)
- [Session Management](./session-management.md)
- [Profile Management](./profile-management-laravel-modules.md)
- [Routing Best Practices](./routing-best-practices-architettura-volt-folio-filament.md)
- [Session Management](./session-management-gestione-sessioni.md)
- [[HasTeamsContract]]
- [[UserContract]]
- [[Team]]
- [[Role]]
- [[Tenant]]
- [[Device]]
- [[SocialiteUser]]
- [[AuthenticationLog]]
