# Laraxot Architecture Rules and Memory Updates

## Updated Architectural Principles

Based on analysis of external packages like `olivierguerriat/filament-spatie-laravel-database-mail-templates`, we've identified additional architectural principles to enhance our system.

### Core Principles (Updated)

1. **DRY + KISS + SOLID**: All existing principles remain valid
2. **Modular Isolation**: Modules should be independently deployable
3. **Extensibility First**: Design for easy extension and customization
4. **Performance Conscious**: Always consider performance implications
5. **Security by Default**: Built-in security measures in all components
6. **Testability Built-in**: All components should be easily testable

### Module Design Guidelines

#### 1. Template Systems
- Implement database-stored templates for non-technical content management
- Use proper caching strategies (L1: In-memory, L2: Redis, L3: Database)
- Create variable substitution systems with proper validation
- Include preview and testing capabilities

#### 2. Filament Integration Patterns
- All resources extend `XotBaseResource` (never extend Filament classes directly)
- Use consistent form and table patterns across modules
- Implement custom actions following established patterns
- Include proper access control and permissions

#### 3. Repository Pattern Enhancement
- Use repository pattern for data access operations
- Implement caching at repository level
- Create query builder extensions for complex operations
- Follow consistent naming and structure patterns

### Security Guidelines (Updated)

#### 1. Content Sanitization
- All user-generated content must be sanitized
- Template variables should be properly escaped
- HTML content should be filtered using safe libraries
- Never trust external template sources

#### 2. Input Validation
- Implement comprehensive input validation
- Use type-safe casting actions (SafeStringCastAction, etc.)
- Validate all template variables and content
- Implement proper error handling and fallbacks

### Performance Guidelines (Updated)

#### 1. Caching Strategies
- Implement multi-level caching (in-memory, Redis, database)
- Cache templates with appropriate invalidation strategies
- Use lazy loading for resource-intensive operations
- Implement cache warming for critical paths

#### 2. Database Optimization
- Proper indexing on all frequently queried fields
- Use eager loading to prevent N+1 queries
- Implement efficient pagination for large datasets
- Use read replicas for read-heavy operations

### Testing Guidelines (Updated)

#### 1. Comprehensive Testing
- Unit tests for all business logic
- Integration tests for module interactions
- Feature tests for user-facing functionality
- Performance tests for critical paths

#### 2. Template-Specific Testing
- Test template rendering with various data sets
- Validate template security and sanitization
- Test fallback mechanisms
- Verify variable substitution accuracy

### Cross-Module Integration Patterns

#### 1. Notification System Enhancement
- Database-stored templates for dynamic content
- Integration with User module for personalization
- Activity tracking for template performance
- Tenant isolation for multi-tenant scenarios

#### 3. Database & Frontend Standards
- **Laravel 12.x Database**: Standardize all database connections using `env('DB_URL')` and version-safe SSL attribute handling.
- **Filament 5.x / Tailwind v4**: Use the latest Filament 5.x requirements, specifically Tailwind CSS v4.1+ and the new Vite plugin architecture.
- **Icon Management**: SVGs must reside in `resources/svg` of the responsible module and be consumed via `x-filament::icon`.
- **Branding & Design**: Adhere to **Symbolic Minimalism**. Logos must be abstract/geometric, not literal/photorealistic. Premium design = line-art simplicity.
- **Multilingual Standard**: Adherence to `mcamara/laravel-localization` is mandatory for all modules and themes. Use `LaravelLocalization::localizeUrl()` for all internal navigation to preserve state.
- **Asset Sync**: Maintain strict synchronization between theme assets and the public-facing `public_html/themes` directory.

### Implementation Roadmap

#### Phase 1: Foundation
- Update existing modules with new architectural guidelines
- Implement template system in Notify module
- Enhance security measures across all modules
- Add comprehensive caching strategies

#### Phase 2: Integration
- Connect modules following new patterns
- Implement advanced features (analytics, preview, etc.)
- Enhance testing coverage
- Optimize performance based on new guidelines

#### Phase 3: Refinement
- Monitor system performance
- Gather feedback from implementation
- Refine patterns based on real-world usage
- Document lessons learned and best practices

### Memory Updates

Remember to always:
- Design with extensibility in mind
- Implement proper caching strategies
- Follow security-first approach
- Use consistent patterns across modules
- Maintain high test coverage
- Optimize for performance from the beginning
- Document decisions and patterns
- Learn from external packages and integrate best practices
