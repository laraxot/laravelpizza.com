# User Module Documentation

## Overview
This document serves as the central index for the User module, providing guidance on managing user-related functionality within a Laravel application. The User module handles authentication, authorization, profile management, and related features in a modular and reusable way.

## Key Principles
1. **Modularity**: The User module is designed to be reusable across different projects, maintaining generic functionality.
2. **Extensibility**: Allows for customization and extension to meet specific project needs without altering core code.
3. **Security**: Implements best practices for authentication, session management, and data protection.

## Core Features
- **Authentication**: Handles user login, logout, and session management.
- **Authorization**: Manages roles and permissions for access control.
- **Profile Management**: Provides functionality for user profile creation and updates.
- **Integration**: Works seamlessly with other modules like Notify for notifications.

## Implementation Guidelines

### 1. Module Structure
- The User module follows a standard structure with directories for models, controllers, services, and views to ensure clarity and maintainability.

### 2. BaseUser Model
- Use the `BaseUser` model as the foundation for user-related data and logic, extending it as needed for specific types.
  ```php
  namespace Modules\User\Models;

  class User extends BaseUser
  {
      // Custom user logic
  }
  ```

### 3. Authentication
- Implement authentication using Laravel's built-in systems or custom solutions integrated with Filament for admin interfaces.

### 4. Routing
- Define user-related routes in a dedicated `routes` directory, ensuring they are prefixed with the appropriate locale.

## Common Issues and Fixes
- **Authentication Failures**: Ensure correct configuration of auth providers and middleware for user routes.
- **Permission Conflicts**: Verify role and permission assignments to avoid access issues.
- **Session Expiry**: Implement proper session management to handle user logout and timeouts securely.

## Documentation and Updates
- Document any custom implementations or deviations from standard User module practices in the relevant documentation folder.
- Update this index if new features or significant changes are introduced to the User module.

## Links to Related Documentation
- [BaseUser Model](./BaseUser.md)
- [Authentication Pages Implementation](./AUTH_PAGES_IMPLEMENTATION.md)
- [Profile Management](./PROFILE_MANAGEMENT.md)
- [Routing Best Practices](./ROUTING_BEST_PRACTICES.md)
- [Session Management](./SESSION_MANAGEMENT.md)

## Sottocartelle

### Models
- [Index](./Models/INDEX.md) - Indice della documentazione sui modelli
- [Documentazione Traits](./traits/INDEX.md) - Documentazione sui trait utilizzati

### Folio e Blade
- [Documentazione Blade](./blade/INDEX.md) - Documentazione sui template Blade
- [Componenti](./components/INDEX.md) - Documentazione sui componenti

## Roadmap e Sviluppo Futuro
- [Roadmap](./roadmap.md) - Piano di sviluppo futuro del modulo User

## Note sulla Manutenzione
Questa documentazione viene aggiornata regolarmente. Prima di apportare modifiche al codice, consultare la documentazione pertinente e aggiornare i documenti correlati.

Ultimo aggiornamento: 14 Maggio 2025

# Indice Documentazione User

- [filament-best-practices.mdc](./filament-best-practices.mdc) — **Regola fondamentale:** chi estende XotBaseResource NON deve dichiarare $navigationGroup, $navigationLabel, né il metodo statico table(Table $table): Table. Seguire sempre questa regola per evitare errori di override e garantire coerenza tra i moduli.
