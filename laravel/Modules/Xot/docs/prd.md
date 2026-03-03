# Xot - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **
> **Status**: Approved
> **Owner**: Xot Core Team

## 1. Purpose & Vision

Xot is the **core framework module** that provides foundational abstractions, base classes, and shared utilities for the entire Laraxot ecosystem. It acts as the "engine that moves the universe" — every other module inherits from Xot's base classes to gain automatic security, internationalization, theme management, and performance optimizations.

The vision is a **Zero-Config** framework for Laravel 12, where each new module inherits best practices through simple class extension.

## 2. Problem Statement

Building modular Laravel applications requires a consistent foundation. Without Xot:
- Each module would duplicate boilerplate code for models, resources, pages, and providers
- No standardized approach for multi-tenancy, theming, or localization
- PHPStan Level 10 compliance would require per-module configuration
- Filament resources would lack consistent behavior (translations, permissions, table/form patterns)

## 3. Target Users

| User | Role | Needs |
|------|------|-------|
| **Module Developer** | Creates new Laraxot modules | Base classes, generators, conventions |
| **Theme Developer** | Builds UI themes | Theme registration, component slots |
| **System Administrator** | Deploys and configures | Health checks, session management, cache |
| **AI Agent** | Automates code generation | Predictable patterns, strict typing |

## 4. Scope

### In Scope
- Base model classes (`XotBaseModel`, `XotBaseMorphPivot`, `XotBasePivot`, `XotBaseTreeModel`, `XotBaseUuidModel`)
- Base Filament classes (`XotBaseResource`, `XotBasePage`, `XotBaseListRecords`, `XotBaseEditRecord`, `XotBaseCreateRecord`)
- Base service providers (`XotBaseServiceProvider`)
- Session and cache management (`Session`, `Cache`, `CacheLock` models)
- Module registry and discovery (`Module` model)
- Health check infrastructure (`HealthCheckResultHistoryItem`)
- Pulse monitoring integration (`PulseAggregate`, `PulseEntry`, `PulseValue`)
- Generic actions (`GeneratePdfAction`, `GetModelByModelTypeAction`, `ExecuteArtisanCommandAction`)
- Feed and extra data management (`Feed`, `Extra`)

### Out of Scope
- Business-domain logic (belongs in domain modules like Performance, Progressioni)
- Authentication/authorization (belongs in User module)
- Localization strings (belongs in Lang module)
- UI components (belongs in UI module)

## 5. Functional Requirements (Prioritized)

### P0: Core Framework (Must-have)
- **FR-001: Base Model System**: Provide abstract base models with built-in support for multi-tenancy, schemaless attributes, activity logging, and morph relationships.
- **FR-002: Filament Resource Framework**: `XotBaseResource` provides automatic translation keys, standardized table/form patterns, `HasXotTable` trait integration.
- **FR-004: Module Discovery**: Automatic discovery and registration of all installed modules via `Module` model and `ModuleResource`.

### P1: Enhanced Utilities (Important)
- **FR-003: PDF Generation**: `GeneratePdfAction` creates PDF documents from Blade templates or HTML via `app(GeneratePdfAction::class)->execute()`.
- **FR-005: Health & Monitoring**: Integration with Laravel Pulse for application monitoring, session management, and cache visibility.

### P2: Future Considerations (Nice-to-have)
- **FR-006: AI Scaffolding**: Xot CLI for module scaffolding with built-in AI code review.
- **FR-007: Dependency Visualizer**: Interactive map of cross-module dependencies.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **No Domain Leakage**: Xot MUST NOT contain any code specific to domain modules (e.g., Performance, HR).
- **Interoperability**: All base classes use standardized interfaces to ensure any module can interact with any other through the Xot core.
- **Isolation**: Each feature (PDF, Monitoring, Registry) is self-contained and can be toggled via configuration.

### Performance & Safety
- **NFR-001: Performance**: Base classes must add < 5ms overhead per request.
- **NFR-002: Type Safety**: 100% PHPStan Level 10 compliance mandatory.
- **NFR-003: Accessibility**: Base UI components (for modules) must be WCAG 2.1 compliant.

## 7. Technical Architecture

### Dependencies
- **Laravel 12** (framework)
- **Filament v5** (admin panel)
- **Spatie packages** (activity-log, media-library, permission, schemaless-attributes)

### Data Model
- `sessions` — Active user sessions
- `cache` / `cache_locks` — Application cache
- `modules` — Registered modules
- `extras` — Polymorphic extra attributes
- `pulse_*` — Monitoring data
- `health_check_result_history_items` — Health history

### Integration Points
- Every module's Service Provider extends `XotBaseServiceProvider`
- Every module's Models extend `XotBaseModel` (or variants)
- Every module's Filament Resources extend `XotBaseResource`

## 8. User Experience

- **Module Admin**: Browse registered modules, view health status, manage sessions
- **Developer**: Extend base classes with zero configuration, get automatic translations and permissions
- **No direct end-user UI** — Xot is infrastructure, consumed by other modules

## 9. Success Metrics & KPIs

| Metric | Target | Measurement |
|--------|--------|-------------|
| PHPStan Level 10 | 0 errors | `vendor/bin/phpstan analyse Modules/Xot` |
| Base class adoption | 100% modules | Audit of `extends` declarations |
| Boot time overhead | < 50ms | Laravel Debugbar measurements |
| Module discovery | Auto-detected | All modules appear in admin panel |

## 10. Risks & Assumptions

### Assumptions
- All modules will use Xot base classes (enforced by architectural rules)
- Laravel and Filament versions remain compatible
- PHPStan Level 10 is achievable for all base abstractions

### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Breaking changes in base classes cascade to all modules | High | Semantic versioning, deprecation cycle |
| Performance regression in base abstractions | High | Benchmarking in CI pipeline |
| Filament v5 API changes | Medium | Adapter layer in XotBase* classes |

## 11. Dependencies & Constraints

- **Technical**: Requires PHP 8.3+, Laravel 12, Filament v5
- **Architectural**: Must remain agnostic — no domain-specific references
- **Regulatory**: N/A (infrastructure module)

## 12. Release Plan

### Phase 1: Framework Stabilization (In Progress)
- PHPStan Level 10 compliance ✅
- Obsolete file removal
- Async boot for `XotBaseServiceProvider`

### Phase 2: Developer Happiness (Planned)
- Xot CLI for module scaffolding
- Trait Auditor tool
- Native Folio + Volt support in `XotBasePage`

### Phase 3: AI Core Integration (Future)
- AI Code Reviewer for Super Mucca rules
- Self-healing base classes
- Cross-module dependency visualizer

## 13. References

- [roadmap.md](roadmap.md)
- [module.md](module.md)
- [philosophy.md](philosophy.md)
