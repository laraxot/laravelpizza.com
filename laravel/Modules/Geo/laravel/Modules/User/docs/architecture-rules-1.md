# Laraxot Architecture Rules

## Core Principles

### 1. Service Provider Registration
- Service providers are registered via `module.json` and `composer.json`, NOT manually in code
- The module system handles provider registration automatically
- Example: `PassportServiceProvider` is registered in both `module.json` and `composer.json` under "extra.laravel.providers"

### 2. Trait Redundancy Rule
- Never use traits that are already included in the parent class
- Example: If extending `XotBaseRelationManager`, don't also use `HasXotTable` trait since it's already included in the parent
- Always check parent classes before adding traits to avoid redundancy

### 3. Separation of Concerns
- Keep Passport configuration in `PassportServiceProvider`, not in `UserServiceProvider`
- Each service provider should have a single responsibility
- Follow the modular architecture where each module handles its own concerns

### 4. DRY + KISS Principles
- Avoid duplicate functionality across files
- Keep implementations simple and straightforward
- Follow established patterns rather than creating new ones