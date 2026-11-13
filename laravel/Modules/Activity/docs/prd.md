<<<<<<< .merge_file_QxJk8y
=======
---
title: "PRD - Activity Module"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "prd - activity module activity"
---
>>>>>>> .merge_file_jKP3fB
# PRD - Activity Module

## 1. Executive Summary
The Activity module is responsible for tracking and logging all system actions, audit trails, and user interactions across the PTVX platform. It provides a centralized repository for observability and compliance.

## 2. Target Personas
- **System Administrators:** Monitor system health and audit logs.
- **Security Officers:** Review access logs for compliance and security investigations.
- **Internal Developers:** Integrate activity logging into other modules.

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

## 7. Release Criteria
- 100% PHPStan Level 10 compliance.
- Test coverage > 80% for logging logic.
- API documentation completed.
<<<<<<< .merge_file_QxJk8y
=======
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
- Log user actions (create, update, delete).
- Track system events (login, logout, errors).
- Search and filter activity logs by module, user, and date.
- Retention policy management for logs.

## 4. Service Interface (The Contract)
- **API Endpoints:**
  - `POST /api/activity/log`: Submit a new activity entry.
  - `GET /api/activity/search`: Retrieve filtered logs.
- **Events:**
  - `ActivityLogged`: Dispatched whenever a new activity is recorded.

## 5. System Architecture & Dependencies
- **Data Ownership:** Owns the `activities` table.
- **Downstream Dependencies:** Depends on the `User` module for user identification.

## 6. Non-Functional Requirements
- **Performance:** Logging must be asynchronous to avoid blocking main requests.
- **Observability:** Must expose metrics for logging rate and failure rate.
- **Security:** Logs must be immutable and access-controlled.
>>>>>>> .merge_file_jKP3fB
