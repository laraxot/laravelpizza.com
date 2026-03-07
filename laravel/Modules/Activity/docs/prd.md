# PRD - Activity Module

## 1. Executive Summary
The Activity module is responsible for tracking and logging all system actions, audit trails, and user interactions across the PTVX platform. It provides a centralized repository for observability and compliance.

## 2. Target Personas
- **System Administrators:** Monitor system health and audit logs.
- **Security Officers:** Review access logs for compliance and security investigations.
- **Internal Developers:** Integrate activity logging into other modules.

## 3. Functional Requirements
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

## 7. Release Criteria
- 100% PHPStan Level 10 compliance.
- 100% Test coverage (Pest) for all business logic and models.
- 100% Autonomous CI/CD Monitoring: The AI agent is responsible for fixing any workflow failure.
- API documentation completed.

## 8. Testing Strategy (Laraxot Standard)
- **Framework**: Pest PHP.
- **Isolation**: Use `DatabaseTransactions` with `protected array $connectionsToTransact = ['mysql', 'activity', 'user'];`.
- **Database**: Must use `.env.testing` pointing to `_test` suffixed databases.
- **No Refresh**: `RefreshDatabase` and `migrate:fresh` are strictly forbidden.
- **Migrations**: Run `php artisan migrate --env=testing` once before the test suite.

## Testing & Coverage

Il modulo $(basename $(dirname $(dirname "$prd"))) segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`. (.)
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

