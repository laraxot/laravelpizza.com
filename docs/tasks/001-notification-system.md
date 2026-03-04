# Task 001: Implement Multi-Channel Notification System

## Description
Create comprehensive notification system supporting multiple channels (email, SMS, push, in-app, webhooks) with templates, scheduling, and delivery tracking.

## Context
The Notify module needs a robust multi-channel notification system for sending messages to users through various communication channels with reliable delivery and tracking.

## Requirements

### Functional Requirements
- Multi-channel support (email, SMS, push, in-app, webhooks)
- Notification templates
- Notification scheduling
- Delivery tracking and status
- Retry logic for failed deliveries
- User notification preferences
- Notification groups and batching
- Rich content support
- Notification history
- Analytics and metrics

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Laravel Notifications
- Multiple service integrations
- Queue-based delivery
- DatabaseTransactions for tests

## Implementation Steps

### 1. Database Schema
- [ ] Create `notifications` table
  - id (uuid/ulid)
  - tenant_id
  - user_id (nullable, for guest notifications)
  - notification_type (string)
  - title (string)
  - content (text)
  - channels (json: ['email', 'sms', 'push', 'in_app', 'webhook'])
  - data (json, nullable)
  - status (enum: 'pending', 'sending', 'sent', 'failed', 'cancelled')
  - sent_at (nullable)
  - failed_at (nullable)
  - error_message (text, nullable)
  - retry_count (int, default 0)
  - scheduled_at (nullable)
  - expires_at (nullable)
  - read_at (nullable)
  - created_by (nullable)
  - timestamps

- [ ] Create `notification_templates` table
  - id, tenant_id, name, slug, type (enum: 'email', 'sms', 'push', 'in_app'), subject, content, variables (json), is_active

- [ ] Create `notification_deliveries` table
  - id, notification_id, channel, status (enum: 'pending', 'sent', 'failed'), provider, provider_message_id, sent_at, failed_at, error_message, retry_count

- [ ] Create `notification_preferences` table
  - id, user_id, channel, is_enabled, quiet_hours_start (time, nullable), quiet_hours_end (time, nullable)

- [ ] Create `notification_groups` table
  - id, tenant_id, name, slug, description, is_active

- [ ] Create `notification_group_user` pivot table

### 2. Models
- [ ] Create `Notification` model
- [ ] Create `NotificationTemplate` model
- [ ] Create `NotificationDelivery` model
- [ ] Create `NotificationPreference` model
- [ ] Create `NotificationGroup` model

### 3. Notification Service
- [ ] Create `NotificationService`
  - `send(array $data): Notification`
  - `sendToUser(string $userId, string $type, array $data): Notification`
  - `sendToGroup(string $groupId, string $type, array $data): array`
  - `sendToMultiple(array $userIds, string $type, array $data): array`
  - `scheduleNotification(array $data, Carbon $scheduleAt): Notification`
  - `cancelNotification(string $notificationId): bool`
  - `retryFailedNotification(string $notificationId): bool`

### 4. Channel Providers
- [ ] Create `NotificationChannel` interface
  - `send(Notification $notification, array $data): bool`
  - `validate(array $data): array`

- [ ] Implement EmailChannel
  - SMTP, Mailgun, SendGrid, SES
  - HTML and plain text
  - Attachments

- [ ] Implement SmsChannel
  - Twilio, Nexmo, MessageBird
  - Character limit handling
  - Delivery receipts

- [ ] Implement PushChannel
  - Firebase Cloud Messaging
  - APNs
  - Web Push

- [ ] Implement InAppChannel
  - Store in database
  - Real-time broadcast
  - Mark as read

- [ ] Implement WebhookChannel
  - POST to URL
  - Retry logic
  - Signature verification

### 5. Template Engine
- [ ] Create `NotificationTemplateEngine`
  - `render(string $templateId, array $variables): array`
  - `previewTemplate(string $templateId, array $variables): string`
  - `validateTemplate(string $content): array`
  - `getTemplateVariables(string $content): array`

### 6. Delivery Tracking Service
- [ ] Create `NotificationDeliveryService`
  - `trackDelivery(string $notificationId, string $channel, array $data): NotificationDelivery`
  - `updateDeliveryStatus(string $deliveryId, string $status, array $data): bool`
  - `getDeliveryReport(string $notificationId): array`
  - `getFailedDeliveries(string $notificationId): Collection`
  - `retryFailedDeliveries(string $notificationId): int`

### 7. Notification Preferences Service
- [ ] Create `NotificationPreferencesService`
  - `getUserPreferences(string $userId): array`
  - `updatePreference(string $userId, string $channel, bool $enabled): bool`
  - `setQuietHours(string $userId, string $start, string $end): bool`
  - `isQuietHours(string $userId): bool`
  - `getPreferredChannels(string $userId): array`

### 8. Notification Analytics Service
- [ ] Create `NotificationAnalyticsService`
  - `getDeliveryStats(Carbon $from, Carbon $to): array`
  - `getChannelStats(Carbon $from, Carbon $to): array`
  - `getTypeStats(Carbon $from, Carbon $to): array`
  - `getSuccessRate(string $channel): float`
  - `getAverageDeliveryTime(string $channel): float`
  - `generateReport(array $filters): array`

### 9. Filament Resources
- [ ] Create `NotificationResource`
  - Notification list
  - Send new notification
  - Notification details
  - Retry failed

- [ ] Create `NotificationTemplateResource`
  - Template management
  - Template editor
  - Variable preview
  - Template testing

- [ ] Create `NotificationPreferenceResource`
  - User preferences
  - Channel configuration
  - Quiet hours

- [ ] Create `NotificationGroupResource`
  - Group management
  - Add/remove users
  - Group analytics

- [ ] Create `NotificationStatsWidget`
  - Delivery stats
  - Channel breakdown
  - Recent notifications

### 10. API Endpoints
- [ ] `POST /api/notifications/send` - Send notification
- [ ] `GET /api/notifications/{id}` - Get notification
- [ ] `POST /api/notifications/{id}/retry` - Retry notification
- [ ] `GET /api/notifications/user/{userId}` - Get user notifications
- [ ] `PUT /api/notifications/{id}/read` - Mark as read

### 11. Actions
- [ ] Create `SendNotificationAction`
- [ ] Create `ScheduleNotificationAction`
- [ ] Create `RetryNotificationAction`
- [ ] Create `MarkAsReadAction`

### 12. Tests
- [ ] Create `NotificationServiceTest`
- [ ] Create `ChannelProviderTest`
- [ ] Create `TemplateEngineTest`
- [ ] Create `DeliveryTrackingTest`

### 13. Documentation
- [ ] Create notification guide
- [ ] Document channel providers
- [ ] Create template guide
- [ ] Add analytics guide

## Acceptance Criteria
- [ ] Notifications send via all channels
- [ ] Templates render correctly
- [ ] Delivery is tracked accurately
- [ ] Failed deliveries are retried
- [ ] User preferences are respected
- [ ] Analytics provide insights
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- User module (user preferences)
- Laravel Notifications
- Email/SMS/Push providers
- Filament 5.x (admin UI)

## Estimated Time
- Database schema: 3 hours
- Models: 3 hours
- Notification service: 5 hours
- Channel providers: 10 hours (5 channels × 2h)
- Template engine: 4 hours
- Delivery tracking: 4 hours
- Preferences: 3 hours
- Analytics: 4 hours
- Filament integration: 6 hours
- API endpoints: 3 hours
- Actions: 2 hours
- Tests: 8 hours
- Documentation: 3 hours

**Total: 58 hours (~7 days)**

## Priority
**High** - Core notification functionality

## Related Tasks
- Task 002: Advanced Notification Features

## Notes
- Use queues for all channel delivery
- Implement exponential backoff for retries
- Respect user quiet hours
- Rate limit per channel
- Track delivery receipts
- Implement notification deduplication
- Use webhooks for real-time updates

---

**Status**: Pending
**Assignee**: TBD