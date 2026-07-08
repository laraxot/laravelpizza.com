# Xot Module - Dependencies

## 📋 Table of Contents
- [External Dependencies](#external-dependencies)
- [Internal Dependencies](#internal-dependencies)
- [Dependency Graph](#dependency-graph)
- [Version Requirements](#version-requirements)
- [Dependency Management](#dependency-management)

## External Dependencies

### Core Framework Dependencies

#### Laravel Framework
- **Package**: `laravel/framework`
- **Purpose**: Core PHP framework
- **Status**: Stable
- **Criticality**: Critical

**Usage**:
- Application structure
- Service container
- Routing
- Eloquent ORM
- Authentication
- Authorization

#### Laravel Modules
- **Package**: `nwidart/laravel-modules`
- **Purpose**: Module management system
- **Status**: Stable
- **Criticality**: Critical

**Usage**:
- Module registration
- Module discovery
- Module routing
- Module configuration

### Admin Panel Dependencies

#### Filament
- **Package**: `filament/filament`
- **Purpose**: Admin panel framework
- **Status**: Stable
- **Criticality**: Critical

**Usage**:
- Admin panel UI
- Resources
- Forms
- Tables
- Widgets

#### Filament Packages
- **filament/actions**: Action management
- **filament/forms**: Form components
- **filament/tables**: Table components
- **filament/widgets**: Widget components
- **filament/infolists**: Info list components

### Quality Tools Dependencies

#### PHPStan
- **Package**: `phpstan/phpstan`
- **Purpose**: Static analysis
- **Status**: Stable
- **Criticality**: High

**Configuration**:
- Level: 10 (Maximum)
- Memory: 2GB
- Check generic types: Yes
- Check missing iterable values: Yes

#### Laravel Pint
- **Package**: `laravel/pint`
- **Purpose**: Code formatting
- **Status**: Stable
- **Criticality**: High

**Configuration**:
- Preset: laravel
- Rules: PSR-12
- Auto-fix: Enabled

#### Pest PHP
- **Package**: `pestphp/pest`
- **Purpose**: Testing framework
- **Status**: Stable
- **Criticality**: High

**Usage**:
- Feature tests
- Unit tests
- Test suites
- Test coverage

#### Pest Plugins
- **pestphp/pest-plugin-laravel**: Laravel integration
- **pestphp/pest-plugin-arch**: Architecture testing
- **pestphp/pest-plugin-type-coverage**: Type coverage

### Additional Quality Tools

#### PHPMD
- **Package**: `phpmd/phpmd`
- **Purpose**: Code quality metrics
- **Status**: Stable
- **Criticality**: Medium

#### PHPInsights
- **Package**: `nunomaduro/phpinsights`
- **Purpose**: Code analysis
- **Status**: Stable
- **Criticality**: Medium

#### PHP CodeSniffer
- **Package**: `squizlabs/php_codesniffer`
- **Purpose**: Code sniffer
- **Status**: Stable
- **Criticality**: Medium

### Utility Dependencies

#### Safe PHP
- **Package**: `thecodingmachine/safe`
- **Purpose**: Safe PHP functions
- **Status**: Stable
- **Criticality**: High

**Usage**:
- Safe file operations
- Safe JSON operations
- Safe system commands
- Exception handling

#### Webmozart Assert
- **Package**: `webmozart/assert`
- **Purpose**: Assertion library
- **Status**: Stable
- **Criticality**: Medium

## Internal Dependencies

### Dependency Hierarchy

```
Xot (Foundation)
├── User (Authentication)
├── Activity (Logging)
├── Cms (Content Management)
├── Media (File Management)
├── Notify (Notifications)
├── Rating (Evaluation)
├── Seo (SEO)
├── Tenant (Multi-tenancy)
├── UI (UI Components)
└── [All other modules]
```

### Module Dependencies

#### No Dependencies
- **Xot**: Foundation module (no dependencies)

#### Depends on Xot Only
- **User**: Extends XotBaseModel
- **Activity**: Extends XotBaseModel
- **Cms**: Extends XotBaseModel
- **Media**: Extends XotBaseModel
- **Notify**: Extends XotBaseModel
- **Rating**: Extends XotBaseModel
- **Seo**: Extends XotBaseModel
- **Tenant**: Extends XotBaseModel
- **UI**: Extends XotBaseModel
- **Fixcity**: Extends XotBaseModel
- **Blog**: Extends XotBaseModel
- **Comment**: Extends XotBaseModel
- **Gdpr**: Extends XotBaseModel
- **Geo**: Extends XotBaseModel
- **Job**: Extends XotBaseModel
- **Lang**: Extends XotBaseModel

#### Cross-Module Dependencies
- **User → Activity**: User activities
- **User → Media**: User media
- **User → Notify**: User notifications
- **Cms → Media**: CMS media
- **Fixcity → Geo**: Location data
- **Fixcity → Rating**: Rating system

## Dependency Graph

### Visual Representation

```
                    [Laravel Framework]
                            |
                    [nwidart/laravel-modules]
                            |
                    [Filament Framework]
                            |
                    ┌───────┴───────┐
                    |               |
                [Xot]          [Other Packages]
                    |
    ┌───────────────┼───────────────┐
    |               |               |
[User]          [Cms]          [Media]
    |               |               |
    └───────┬───────┴───────┬───────┘
            |               |
        [Activity]      [Notify]
```

### Dependency Matrix

| Module | Xot | User | Cms | Media | Activity | Notify |
|--------|-----|------|-----|-------|----------|--------|
| Xot | - | ❌ | ❌ | ❌ | ❌ | ❌ |
| User | ✅ | - | ❌ | ✅ | ✅ | ✅ |
| Cms | ✅ | ❌ | - | ✅ | ❌ | ❌ |
| Media | ✅ | ❌ | ❌ | - | ❌ | ❌ |
| Activity | ✅ | ✅ | ❌ | ❌ | - | ❌ |
| Notify | ✅ | ✅ | ❌ | ❌ | ❌ | - |

**Legend**:
- ✅ = Depends on
- ❌ = No dependency

## Version Requirements

### PHP Version
- **Minimum**: 8.2
- **Recommended**: 8.3
- **Target**: 8.4

### Laravel Version
- **Minimum**: 12.0
- **Recommended**: 12.x (latest stable)
- **Target**: 12.x

### Filament Version
- **Minimum**: 5.0
- **Recommended**: 5.x (latest stable)
- **Target**: 5.x

### PHPStan Version
- **Minimum**: 2.1
- **Recommended**: 2.x (latest stable)
- **Target**: 2.x

### Pest Version
- **Minimum**: 3.8
- **Recommended**: 3.x (latest stable)
- **Target**: 3.x

## Dependency Management

### Composer Configuration

#### Main Composer
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "nwidart/laravel-modules": "*",
        "filament/filament": "^5.0",
        "thecodingmachine/safe": "^3.3"
    },
    "require-dev": {
        "phpstan/phpstan": "^2.1",
        "laravel/pint": "^1.25",
        "pestphp/pest": "^3.8"
    }
}
```

#### Module Composer
```json
{
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\Xot\\Providers\\XotServiceProvider"
            ]
        }
    }
}
```

### Dependency Best Practices

#### Version Constraints
- Use caret constraints (`^`) for major version compatibility
- Use exact versions for security patches
- Avoid wildcard constraints (`*`) except for stable packages

#### Dependency Updates
- **Weekly**: Check for security updates
- **Monthly**: Update non-breaking dependencies
- **Quarterly**: Review and update all dependencies

#### Dependency Auditing
- **Security**: Run `composer audit` weekly
- **Outdated**: Run `composer outdated` monthly
- **Licenses**: Run `composer licenses` quarterly

### Dependency Conflicts

#### Known Conflicts

**Filament 4 vs 5**:
- **Issue**: Some packages only support Filament 4
- **Resolution**: Use Filament 5 compatible packages
- **Status**: Resolved

**PHPStan Levels**:
- **Issue**: Some packages only support lower PHPStan levels
- **Resolution**: Use baseline files for third-party packages
- **Status**: Resolved

**Laravel 12 Compatibility**:
- **Issue**: Some packages not yet compatible with Laravel 12
- **Resolution**: Use forked versions or wait for updates
- **Status**: Monitoring

### Dependency Risk Assessment

#### Critical Dependencies
- **Laravel Framework**: High risk, but very stable
- **Filament**: Medium risk, active development
- **PHPStan**: Low risk, stable API

#### Non-Critical Dependencies
- **PHPMD**: Low risk, can be replaced
- **PHPInsights**: Low risk, can be replaced
- **PHP CodeSniffer**: Low risk, can be replaced

#### Future Dependencies
- **AI Tools**: Potential future dependency
- **Performance Tools**: Potential future dependency
- **Testing Tools**: Potential future dependency

## Dependency Maintenance

### Update Schedule

#### Weekly
- Check for security advisories
- Review dependency updates

#### Monthly
- Update non-breaking dependencies
- Run compatibility tests
- Update documentation

#### Quarterly
- Review all dependencies
- Update to latest stable versions
- Audit for security vulnerabilities
- Remove unused dependencies

### Dependency Testing

#### Pre-Update Testing
1. Create feature branch
2. Update dependencies
3. Run PHPStan analysis
4. Run test suite
5. Check for breaking changes

#### Post-Update Validation
1. Verify all tests pass
2. Check PHPStan compliance
3. Test key functionality
4. Monitor for issues
5. Update documentation

### Dependency Documentation

#### Version Documentation
- Maintain composer.lock in version control
- Document version requirements in README
- Track breaking changes in CHANGELOG

#### Dependency Guides
- Create upgrade guides for major versions
- Document compatibility issues
- Provide migration instructions

---

