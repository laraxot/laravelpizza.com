# Overview and Technology Stack

## 📋 Project Overview

PTVX is a comprehensive modular Laravel application built with modern PHP frameworks and tools. The system follows strict architectural patterns and coding standards.

## 🛠️ Technology Stack

### Core Framework
- **Laravel 11.x** - Primary framework
- **PHP 8.3+** - Required version with strict types
- **Composer** - Dependency management

### Admin Panel & UI
- **Filament 4.x** - Admin panel (NEVER extend directly)
- **Livewire 3.x** - Reactive components
- **Tailwind CSS 4.x** - Styling framework
- **Alpine.js** - Frontend interactions

### Database & ORM
- **MySQL 8.0+** - Primary database
- **Eloquent ORM** - Laravel's ORM
- **Spatie Laravel-Data** - Data transfer objects
- **Spatie Schemaless Attributes** - Dynamic attributes

### Quality Assurance
- **PHPStan Level 10** - Static analysis
- **PHPMD** - Code mess detection
- **PHP Insights** - Code quality metrics
- **Pest 3.x** - Testing framework

### Development Tools
- **Laravel Sail** - Docker development environment
- **Laravel Telescope** - Debugging and monitoring
- **Laravel Horizon** - Queue monitoring
- **Laravel Reverb** - WebSocket server

## 📁 Project Structure

```
ptvx/
├── laravel/                 # Main Laravel application
│   ├── Modules/            # Modular architecture
│   ├── Themes/             # Frontend themes
│   └── docs/               # Documentation
├── bashscripts/            # Automation scripts
├── docker/                 # Docker configuration
└── docs/                   # AI guidelines and docs
```

## 🎯 Key Principles

### Architecture
- **Modular Design**: Everything is a module
- **Dependency Injection**: Constructor injection only
- **SOLID Principles**: Strict adherence to clean architecture
- **DRY + KISS**: No repetition, simple solutions

### Code Quality
- **Strict Types**: Always enabled
- **Type Hints**: All parameters and returns typed
- **PHPDoc**: Comprehensive documentation
- **PSR-12**: Code style standard

### Development
- **Git Flow**: Feature branches and releases
- **Testing**: All code must be tested
- **Documentation**: Self-documenting code
- **CI/CD**: Automated quality checks

## 🔗 Related Documentation

- [Architecture Rules](architecture-rules.md) - Critical rules to follow
- [Module Structure](module-structure.md) - How modules are organized
- [Code Conventions](../development/conventions.md) - Coding standards
- [Development Tasks](../development/tasks.md) - Common operations
