# PTVX Laraxot Development Guide

**PTVX** is a production-grade Laravel 12 + Filament 4 + Livewire 3 modular monolith application for public administration management in Italy. Built using the **Laraxot architecture**, it emphasizes strict typing, modularity, and PHPStan Level 10 compliance.

## 📊 Key Metrics
- **34+ independent modules** (plus Xot framework module)
- **PHPStan Level 10** (maximum strictness)
- **96-98% test coverage**
- **Multi-tenancy and multi-language support**

## 🏗️ Architecture Overview

### Core Principles
- **Laraxot Framework**: Custom modular architecture extending Laravel
- **Strict Typing**: `declare(strict_types=1)` everywhere
- **SOLID + DRY + KISS**: Clean architecture patterns
- **Modular Monolith**: Independent modules with clear boundaries
- **Maximum Quality**: PHPStan L10, 98% coverage, automated testing

### Technology Stack

| Component | Technology | Version | Purpose |
|-----------|------------|---------|---------|
| **Language** | PHP | 8.2+ | Core language with strict typing |
| **Framework** | Laravel | 12.3+ | Full-stack framework |
| **Admin Panel** | Filament | 4.x | Modern admin interface |
| **Real-time UI** | Livewire | 3.x | Reactive components |
| **Testing** | Pest | Latest | PHP testing framework |
| **Static Analysis** | PHPStan | Latest | Code quality (Level 10) |
| **DTOs** | Spatie Laravel Data | Latest | Data transfer objects |
| **Actions** | Spatie QueueableAction | Latest | Business logic actions |
| **Permissions** | Spatie Permissions | Latest | Role/permission system |
| **OAuth** | Laravel Passport | 12.4+ | API authentication |

## ⚠️ CRITICAL ARCHITECTURAL RULES

### 🔴 FORBIDDEN: Direct Filament Extensions

**NEVER extend Filament classes directly**. Always use XotBase classes:

```php
// ❌ VIOLATION - NEVER DO THIS
class MyResource extends Filament\Resources\Resource
class CreateRecord extends Filament\Resources\Pages\CreateRecord

// ✅ COMPLIANT - ALWAYS DO THIS
class MyResource extends Modules\Xot\Filament\Resources\XotBaseResource
class CreateRecord extends Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
```

### 🔴 FORBIDDEN: Methods in XotBaseResource

Classes extending `XotBaseResource` **MUST NOT** have these methods:

```php
// ❌ VIOLATION - NEVER DO THIS IN XotBaseResource
public function getTableColumns(): array { /* ... */ }
public function getTableFilters(): array { /* ... */ }
public function getTableActions(): array { /* ... */ }
public function getTableBulkActions(): array { /* ... */ }
```

### 🔴 FORBIDDEN: Properties in XotBasePage

Classes extending `XotBasePage` **MUST NOT** have these properties:

```php
// ❌ VIOLATION - NEVER DO THIS IN XotBasePage
protected static ?string $navigationIcon = 'icon';
protected static ?string $title = 'Title';
protected static ?string $navigationLabel = 'Label';
```

### 🔴 FORBIDDEN: Manual Labels

**NEVER use manual labels**. Translations are automatic via LangServiceProvider:

```php
// ❌ VIOLATION - NEVER DO THIS
TextInput::make('name')->label('Nome')
TextInput::make('email')->placeholder('Email')
TextColumn::make('status')->tooltip('Status')

// ✅ COMPLIANT - ALWAYS DO THIS
TextInput::make('name')  // Translation automatic
TextInput::make('email') // Translation automatic
TextColumn::make('status') // Translation automatic
```

### 🔴 FORBIDDEN: Traditional Services

**NEVER use traditional services**. Use Spatie QueueableAction:

```php
// ❌ VIOLATION - NEVER DO THIS
class UserService { /* traditional service */ }

// ✅ COMPLIANT - ALWAYS DO THIS
class CreateUserAction implements ShouldQueue
{
    use QueueableAction;
    // Implementation
}
```

### 🔴 FORBIDDEN: Deprecated Components

**NEVER use deprecated components**:

```php
// ❌ VIOLATION - NEVER DO THIS
BadgeColumn::make('status')

// ✅ COMPLIANT - ALWAYS DO THIS
TextColumn::make('status')->badge()
```

## 📚 Documentation Structure

### 🏛️ Architecture
- **[Rules](architecture/rules/)** - Critical architectural rules and constraints
- **[Patterns](architecture/patterns/)** - Proven design patterns and solutions
- **[Principles](architecture/principles/)** - SOLID, DRY, KISS principles application

### 🔧 Development
- **[Workflow](development/workflow/)** - Development processes and commands
- **[Tools](development/tools/)** - Development tools and utilities
- **[Bugfix Guide](development/bugfix-guide.md)** - Complete guide for bug fixing and best practices
- **[Deployment](development/deployment/)** - Deployment strategies and procedures

### 📏 Conventions
- **[Naming](conventions/naming/)** - Naming conventions for all components
- **[Structure](conventions/structure/)** - Code organization and file structure
- **[Validation](conventions/validation/)** - Validation patterns and rules

### ✨ Patterns
- **[DRY](patterns/dry/)** - Don't Repeat Yourself implementations
- **[KISS](patterns/kiss/)** - Keep It Simple, Stupid solutions
- **[SOLID](patterns/solid/)** - SOLID principles in practice

### 🔍 Quality Assurance
- **[PHPStan](quality/phpstan/)** - Static analysis configuration and rules
- **[Testing](quality/testing/)** - Testing strategies and best practices
- **[Metrics](quality/metrics/)** - Code quality metrics and monitoring

### 📦 Modules
- **[Structure](modules/structure/)** - Module organization and templates
- **[Development](modules/development/)** - Module development guidelines
- **[Examples](modules/examples/)** - Real module examples and patterns

## 🚀 Quick Start

### Prerequisites
```bash
PHP 8.2+
Composer 2.x
Node.js 18+
NPM/Yarn
Docker (optional)
```

### Installation
```bash
# Clone repository
git clone <repository-url> ptvx
cd ptvx

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Run tests
php artisan test
```

### Development Workflow
```bash
# Start development server
php artisan serve

# Run static analysis
./vendor/bin/phpstan analyse

# Run tests
php artisan test

# Generate documentation
php artisan docs:generate
```

## 📋 Development Checklist

### Code Quality
- [ ] `declare(strict_types=1)` in all PHP files
- [ ] PHPStan Level 10 compliance
- [ ] 100% test coverage for new code
- [ ] PSR-12 code style compliance
- [ ] Complete PHPDoc documentation

### Architecture Compliance
- [ ] Module boundaries respected
- [ ] SOLID principles followed
- [ ] DRY/KISS patterns applied
- [ ] Laraxot conventions followed
- [ ] No direct Filament class extensions

### Testing Requirements
- [ ] Unit tests for all classes
- [ ] Feature tests for user flows
- [ ] Integration tests for modules
- [ ] API tests for endpoints
- [ ] Browser tests for UI components

## 🤝 Contributing

### Development Process
1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Commit** changes (`git commit -m 'Add amazing feature'`)
4. **Push** to branch (`git push origin feature/amazing-feature`)
5. **Create** Pull Request

### Code Review Requirements
- **2 approvals** minimum
- **All tests passing**
- **PHPStan Level 10** clean
- **Documentation updated**
- **No breaking changes** without migration

## 📞 Support

### Communication Channels
- **Issues**: GitHub Issues for bugs and features
- **Discussions**: GitHub Discussions for questions
- **Slack**: Internal team communication
- **Documentation**: This guide for technical reference

### Escalation Path
1. **Self-research** in documentation
2. **Team discussion** for clarification
3. **Architect review** for major changes
4. **Product owner** for business decisions

## 🔄 Version History

| Version | Date | Major Changes |
|---------|------|----------------|
| 4.0 | Dec 2025 | Complete DRY/KISS restructuring, PHPStan L10 enforcement |
| 3.5 | Nov 2025 | Multi-tenancy implementation, API standardization |
| 3.0 | Oct 2025 | Filament 4 migration, Livewire 3 upgrade |
| 2.5 | Sep 2025 | Modular architecture stabilization |
| 2.0 | Aug 2025 | Laraxot framework introduction |

---

**Version**: 4.0
**Last Updated**: December 2025
**Architecture**: Laraxot Modular Monolith
**Maintained By**: Development Team