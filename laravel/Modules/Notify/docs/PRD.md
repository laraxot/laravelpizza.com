# PRD - Notify Module

## 1. Executive Summary
The Notify module provides a centralized system for managing and delivering system notifications, alerts, and messages across the PTVX platform.

## 2. Target Personas
- **Users:** Receive and view notifications within the application.
- **System Administrators:** Configure and manage notification rules.
- **Internal Developers:** Integrate notification delivery into other modules.

## 3. Functional Requirements
- Secure delivery of notifications through multiple channels (e.g., in-app, email).
- Management of notification templates and localization.
- User-specific notification preferences and settings.
- Real-time notification updates using WebSockets or polling.

## 4. Service Interface (The Contract)
- **API Endpoints:**
  - `POST /api/notify/send`: Dispatch a notification to a specific user.
  - `GET /api/notify/my-notifications`: Retrieve individual notifications.
- **Events:**
  - `NotificationDispatched`: Dispatched when a new notification is sent.

## 5. System Architecture & Dependencies
- **Data Ownership:** Owns notification records and user preferences.
- **Downstream Dependencies:** Depends on `User` and `Xot` modules.

## 6. Non-Functional Requirements
- **Performance:** Fast delivery and retrieval of notifications.
- **Reliability:** Reliable delivery and retry mechanisms for notifications.

## 7. Release Criteria
- PHPStan Level 10 compliance.
- Verified notification delivery across different channels.

## Testing & Coverage

Il modulo $(basename $(dirname $(dirname "$prd"))) segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

