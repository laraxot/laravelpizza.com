<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
# base_healthcare_app_fila5_mono
# healthcare_app Fila3 Mono Project

## Overview

healthcare_app Fila3 Mono is a comprehensive Laravel-based modular application built on the Laraxot framework. This project implements a complete authorization system with policies for all models across all modules.

## Key Features

- **Modular Architecture**: Built using Laravel Modules for clean separation of concerns
- **Comprehensive Authorization**: Complete policy system for all models
- **Automatic Policy Registration**: Policies are automatically discovered and registered
- **Multi-Tenant Support**: Full multi-tenancy with tenant-aware policies
- **Filament Integration**: Modern admin panel with policy-aware interfaces
- **Type Safety**: PHPStan Level 10 compliance for maximum code quality

## Module Structure

The project consists of the following modules:

### Core Modules
- **User**: User management, authentication, and authorization
- **Xot**: Base framework functionality and shared components
- **UI**: User interface components and themes

### Content Management
- **Cms**: Content management system with pages, menus, and sections
- **Media**: File and media management
- **FormBuilder**: Dynamic form creation and management

### Geographic and Location
- **Geo**: Geographic data management (countries, regions, cities, addresses)
- **Tenant**: Multi-tenant architecture support

### Survey and Analytics
- **healthcare_app**: Survey management and analytics
- **Limesurvey**: Integration with LimeSurvey platform
- **Chart**: Data visualization and charting

### Workflow and Processing
- **Job**: Background job management and scheduling
- **Activity**: Activity logging and tracking
- **Notify**: Notification system

### Additional Modules
- **CloudStorage**: Cloud storage integration
- **DbForge**: Database schema management
- **Gdpr**: GDPR compliance tools
- **Lang**: Internationalization and translation management
- **Setting**: Application configuration management

## Policy System

### Automatic Registration
All policies are automatically discovered and registered through the `XotBaseServiceProvider`. Each module scans its models and registers corresponding policies.

### Policy Structure
Each module has its own base policy class:
```php
abstract class ModuleNameBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
        return null;
    }
}
```

### Permission Naming
Consistent permission naming across all modules:
- `model_name.viewAny` - View any records
- `model_name.view` - View specific record
- `model_name.create` - Create new records
- `model_name.update` - Update records
- `model_name.delete` - Delete records
- `model_name.restore` - Restore soft-deleted records
- `model_name.forceDelete` - Permanently delete records

## Installation

1. Clone the repository
2. Install dependencies: `composer install`
3. Configure environment variables
4. Run migrations: `php artisan migrate`
5. Seed permissions and roles: `php artisan db:seed`

## Usage

### Policy Usage in Controllers
```php
public function show(Model $model)
{
    $this->authorize('view', $model);
    return view('model.show', compact('model'));
}
```

### Policy Usage in Blade
```blade
@can('update', $model)
    <a href="{{ route('model.edit', $model) }}">Edit</a>
@endcan
```

### Policy Usage in Filament
```php
Tables\Actions\EditAction::make()
    ->visible(fn ($record) => auth()->user()->can('update', $record))
```

## Development Guidelines

### Code Quality
- PHPStan Level 10 compliance required
- Strict type declarations in all files
- Comprehensive PHPDoc for all methods
- Follow PSR-12 coding standards

### Policy Development
- Extend appropriate base policy class
- Implement all standard CRUD methods
- Use permission-based authorization
- Consider model ownership and relationships
- Include comprehensive tests

### Module Development
- Follow Laraxot module structure
- Implement policies for all models
- Use proper namespace conventions
- Maintain comprehensive documentation

## Security

### Authorization
- All access controlled through policies
- Permission-based system with role hierarchy
- Super admin override for all policies
- Default deny approach for security

### Multi-Tenancy
- Tenant-aware policies
- Data isolation between tenants
- Tenant-specific permissions

## Documentation

- [Policy Implementation Guide](docs/policies_implementation.md)
- [User Module Documentation](laravel/Modules/User/docs/README.md)
- [Module-specific documentation in each module's docs folder]

## Contributing

1. Follow the established coding standards
2. Implement policies for all new models
3. Add comprehensive tests
4. Update documentation
5. Ensure PHPStan Level 10 compliance

## License

This project is proprietary software. All rights reserved.

## Support

For support and questions, please refer to the project documentation or contact the development team.

*Last updated: January 2025*
# base_healthcare_app_fila5_mono
# base_healthcare_app_fila5_mono
