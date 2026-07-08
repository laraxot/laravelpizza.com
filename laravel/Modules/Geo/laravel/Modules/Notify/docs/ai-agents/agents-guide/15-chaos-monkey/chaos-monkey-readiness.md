# Chaos Monkey Readiness

## Overview

This document provides comprehensive readiness information for handling chaos monkey scenarios in the LaravelPizza project. It covers common failure scenarios, debugging skills, and recovery procedures.

## Critical Knowledge Areas

### 1. Template/Theme/CMS System Understanding

**Core Architecture:**
- Configuration-driven system via `xra.php`
- Multi-layer namespace registration (pub_theme, cms, module-specific)
- Folio routes WITHOUT locale middleware (prevents serialization)
- Block-based content system with JSON storage
- Dynamic query resolution via `ResolveBlockQueryAction`
- Livewire/Volt auto-detection in blocks

**Key Patterns:**
- Always use `pub_theme` namespace for theme components
- Handle locale in templates, not middleware
- Use `SushiToJsons` for JSON file storage
- Define explicit model schemas
- Validate view existence in `BlockData` constructor
- Use actions for business logic

### 2. Module Integration Understanding

**Module Hierarchy:**
```
Xot (Core) → Lang, Tenant, Cms → Meetup, User, etc.
```

**Key Integration Points:**
- All modules extend Xot base classes
- TenantService for tenant-aware operations
- Cms module for content management
- Lang module for translations
- Theme provides frontend rendering

**Service Provider Load Order:**
1. XotServiceProvider (core)
2. TenantServiceProvider (infrastructure)
3. LangServiceProvider (infrastructure)
4. CmsServiceProvider (content)
5. Module ServiceProviders (business logic)
6. ThemeServiceProvider (frontend)

### 3. Common Failure Scenarios

**Scenario 1: Page Returns 404**
- Symptoms: Visiting `/it/events` returns 404
- Causes: Page slug mismatch, Folio not registered, middleware blocking
- Fix: Update page slug, ensure Folio registration, fix middleware

**Scenario 2: Blocks Not Rendering**
- Symptoms: Page loads but content area is empty
- Causes: Blocks array empty, view path incorrect, view namespace wrong
- Fix: Add blocks to page, fix view path, correct namespace

**Scenario 3: Dynamic Query Fails**
- Symptoms: Block renders but no data
- Causes: Model class doesn't exist, scope method doesn't exist, no matching records
- Fix: Fix model class, fix scope names, remove restrictive scopes

**Scenario 4: Middleware Not Executing**
- Symptoms: Protected page accessible without authentication
- Causes: PageSlugMiddleware not registered, middleware alias incorrect
- Fix: Register PageSlugMiddleware, register auth middleware

**Scenario 5: Translation Not Working**
- Symptoms: English text on Italian page
- Causes: Locale not set, translation file missing, translation key incorrect
- Fix: Set locale, create translation file, fix translation key

**Scenario 6: Livewire Component Not Working**
- Symptoms: Component doesn't respond to user interaction
- Causes: Component not detected, component name not normalized, component class missing
- Fix: Add Volt directive, normalize component name, create component class

**Scenario 7: Theme Components Not Found**
- Symptoms: `view not found: pub_theme::components.blocks.hero`
- Causes: Theme not registered, view paths not configured, namespace not registered
- Fix: Register theme, configure view paths, register namespace

### 4. Debugging Skills

**Systematic Debugging Approach:**
1. Identify the layer (Configuration, Routing, Model, Block, Template, Middleware, Theme)
2. Check configuration first
3. Trace the flow from request to response
4. Validate assumptions with testing
5. Use debug tools (dump, log, query logging)

**Quick Reference Commands:**
```bash
# Check configuration
php artisan config:show xra

# Check routes
php artisan route:list --path=it/events

# Clear caches
php artisan optimize:clear
php artisan view:clear
php artisan cache:clear

# Check database
php artisan db:show
php artisan tinker
```

### 5. Recovery Procedures

**Emergency Fixes:**
1. Clear all caches
2. Rebuild theme assets (`npm run build && npm run copy`)
3. Restart services
4. Check database connections
5. Verify module status

**Prevention Strategies:**
1. Write tests for critical functionality
2. Use type safety
3. Validate configuration early
4. Log key events
5. Use try-catch for error handling

## Documentation References

**Architecture Documentation:**
- `laravel/Modules/Cms/docs/template-theme-cms-runtime-architecture.md`
- `laravel/Modules/Cms/docs/modules-integration-reference.md`

**Runtime Memory:**
- `laravel/Themes/Readme/docs/memories/cms-theme-runtime-memory.md`

**Debugging Skills:**
- `laravel/Themes/Meetup/docs/chaos-monkey-debug-skills.md`

**Module References:**
- Xot: `laravel/Modules/Xot/docs/00-index.md`
- Lang: `laravel/Modules/Lang/docs/00-index.md`
- Tenant: `laravel/Modules/Tenant/docs/00-index.md`
- Cms: `laravel/Modules/Cms/docs/00-index.md`
- Meetup: `laravel/Themes/Meetup/docs/00-index.md`

## Readiness Checklist

### Configuration Readiness
- [x] Understand xra.php configuration
- [x] Know how to debug configuration issues
- [x] Understand namespace registration
- [x] Know how to clear config cache

### Routing Readiness
- [x] Understand Folio route registration
- [x] Know how to debug 404 errors
- [x] Understand PageSlugMiddleware
- [x] Know how to trace route flow

### Content Management Readiness
- [x] Understand Block system architecture
- [x] Know how to debug block rendering
- [x] Understand dynamic query resolution
- [x] Know how to trace block flow

### Theme Readiness
- [x] Understand theme registration
- [x] Know how to debug view not found errors
- [x] Understand asset management
- [x] Know how to rebuild theme assets

### Module Integration Readiness
- [x] Understand module hierarchy
- [x] Know how to debug module loading issues
- [x] Understand TenantService usage
- [x] Know how to trace integration flow

### Translation Readiness
- [x] Understand translation system
- [x] Know how to debug translation issues
- [x] Understand locale management
- [x] Know how to trace translation flow

### Testing Readiness
- [x] Understand testing patterns
- [x] Know how to write integration tests
- [x] Know how to run tests
- [x] Know how to debug test failures

## Key Takeaways

1. **Configuration is King** - Most issues stem from misconfiguration
2. **Trace the Flow** - Follow request from routing to rendering
3. **Validate Assumptions** - Don't assume, test everything
4. **Use Debug Tools** - dump, log, query logging are your friends
5. **Document Solutions** - Write down what works and what doesn't

## Bug Injection Scenario

Quando bug o file infetti sono introdotti deliberatamente:

1. **Applicare** [bug-injection-recovery-playbook](../../../../laravel/docs/bug-injection-recovery-playbook.md)
2. **Seguire** laraxot-bugfix-workflow e systematic-debugging-laravel
3. **Regola** `.cursor/rules/bug-injection-readiness.mdc`
4. **Memoria** `.cursor/memories/bug-injection-readiness.md`

**Principio**: NO FIX SENZA ANALISI CAUSA RADICE.

## Next Steps

When chaos monkey is introduced:
1. Identify the layer where the issue occurs
2. Use systematic debugging approach
3. Check configuration first
4. Trace the complete flow
5. Validate assumptions
6. Use debug tools
7. Apply appropriate fix
8. Document the solution

This readiness guide ensures you're prepared to handle any chaos monkey scenario in the LaravelPizza project.