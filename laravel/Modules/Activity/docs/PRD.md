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
- Test coverage > 80% for logging logic.
- API documentation completed.
