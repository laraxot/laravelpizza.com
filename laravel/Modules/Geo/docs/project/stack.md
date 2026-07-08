# Technology Stack & Dependencies

## Core Technologies
- **PHP 8.2+**: Final types, strict types, union types.
- **Laravel 11+**: Modular architecture using `nwidart/laravel-modules`.
- **Filament 4+**: Backoffice framework with custom Laraxot extensions.
- **Livewire 3**: Frontend interactivity.
- **MySQL/PostgreSQL**: Multi-database support.

## Key Frameworks & Packages
- **Laraxot Framework**: Proprietary layer for extreme consistency and rapid development.
- **Spatie Packages**:
    - `spatie/laravel-permission`: RBAC via `Role` and `Permission` models.
    - `spatie/laravel-activitylog`: Audit trail and record history.
    - `spatie/laravel-queueable-action`: Isolated business logic units.
    - `spatie/laravel-data`: Robust DTOs.
- **Webmozart Assert**: Type and state validation.
- **Pest PHP**: Modern testing suite.
- **Laravel Passport**: OAuth2 implementation for multi-type authentication.

## Architecture Patterns
- **Modular Monolith**: Functionality divided into 35+ independent modules.
- **STI (Single Table Inheritance)**: Used for multi-tenant and multi-type users.
- **Forward-Only Development**: Every change moves the project forward; rollbacks are discouraged.

## 🗄 Database & Multi-Connection
The system support multiple connections for performance isolation:
- `mysql`: Primary application database.
- `performance`: Dedicated database for HR/Performance metrics.
- `user`: Dedicated database for sensitive PII (GDPR compliance).

```php
// Usage example
class PerformanceRecord extends XotBaseModel {
    protected $connection = 'performance';
}
```
