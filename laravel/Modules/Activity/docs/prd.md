# PRD - Activity Module (2025-2026 Lean Standard)

## 1. Problem Statement
System observability and audit trails are fragmented and lack a unified, type-safe implementation. There is a need for a centralized, agnostic module that handles logging and event sourcing across all platform modules without creating circular dependencies.

## 2. KPIs (Key Performance Indicators)
- **Compliance**: 100% PHPStan Level 10 across all module files.
- **Performance**: < 5ms overhead for log generation (using asynchronous queues).
- **Quality**: 0 issues reported by PHPMD and PHPInsights.
- **Coverage**: > 80% test coverage for core logging actions.

## 3. Functional Requirements

### P0 (Critical)
- **Agnostic Audit Trail**: Log CRUD operations for any model extending `XotBaseModel`.
- **Event Sourcing Support**: Provide standard resources for `StoredEvent` and `Snapshot` management.
- **Filament Integration**: Refactored resources using the `Schemas/Tables` pattern for better maintainability.

### P1 (High Priority)
- **Search & Filter**: Advanced filtering by `causer`, `subject`, and `batch_uuid`.
- **JSON Properties**: Support for schemaless attributes in log properties for flexible metadata storage.

### P2 (Nice to Have)
- **PDF Reporting**: Export activity summaries as institutional-grade PDF reports.
- **Retention Policies**: Automatic cleanup of old logs based on configurable thresholds.

## 4. Technical Specifications

### Agnostic Design
- The module must NOT depend on domain-specific modules (e.g., Ptv, Fixcity).
- Use `UserContract` for causer identification to remain auth-provider agnostic.

### Data Schema
- **activities**: Standard Spatie Activity Log schema with `batch_uuid` and `event` columns.
- **snapshots**: State capture for event sourcing.
- **stored_events**: Immutable event log for domain state reconstruction.

## 5. Success Criteria
- All Filament resources are refactored into the `Schemas/Tables` structure.
- Full quality pipeline (PHPStan, PHPMD, PHPInsights, Pest) passes without errors.
- Documentation in `docs/wiki/` is updated and ingested.
