# Task 004: Implement Activity Notification System

## Description
Create a notification system for activities that allows users to subscribe to specific activity types and receive real-time alerts via multiple channels.

## Context
Users need to be notified about important activities in the system (e.g., failed logins, permission changes, critical system events). Currently, there's no notification system for activities.

## Requirements

### Functional Requirements
- Subscribe to activity categories/types
- Subscribe to specific user activities
- Subscribe to tag-based notifications
- Multiple notification channels (email, in-app, SMS, webhook)
- Real-time notifications
- Digest notifications (hourly, daily, weekly)
- Notification preferences management
- Notification history and logs

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Event-driven architecture
- Queue-based notification processing
- Rate limiting for notifications
- Database-backed notification storage

## Implementation Steps

### 1. Database Schema
- [ ] Create `activity_subscriptions` table
  - id (uuid/ulid)
  - user_id
  - category_id (nullable)
  - tag_id (nullable)
  - activity_type (nullable)
  - user_filter_id (nullable, for specific user activities)
  - channels (json: ['email', 'in_app', 'sms', 'webhook'])
  - frequency (enum: 'immediate', 'hourly', 'daily', 'weekly')
  - is_active (boolean, default true)
  - conditions (json, nullable)
  - timestamps

- [ ] Create `activity_notifications` table
  - id (uuid/ulid)
  - user_id
  - activity_id
  - subscription_id (nullable)
  - channel (string)
  - status (enum: 'pending', 'sent', 'failed')
  - sent_at (nullable)
  - error_message (nullable)
  - retry_count (default 0)
  - read_at (nullable)
  - timestamps

### 2. Models
- [ ] Create `ActivitySubscription` model
  - Extends `Modules\Activity\Models\ActivityBaseModel`
  - BelongsTo User
  - BelongsTo ActivityCategory (optional)
  - BelongsTo ActivityTag (optional)
  - HasMany ActivityNotification
  - Strict typing

- [ ] Create `ActivityNotification` model
  - Extends `Modules\Activity\Models\ActivityBaseModel`
  - BelongsTo User
  - BelongsTo Activity
  - BelongsTo ActivitySubscription (optional)
  - Strict typing

### 3. Events
- [ ] Create `ActivityCreated` event (if not exists)
- [ ] Create `ActivityCreatedForNotification` event
- [ ] Create `NotificationSent` event
- [ ] Create `NotificationFailed` event

### 4. Listeners
- [ ] Create `ActivityCreatedListener`
  - Find matching subscriptions
  - Queue notification jobs

- [ ] Create `ProcessNotificationQueueListener`
  - Process pending notifications
  - Send via appropriate channels

- [ ] Create `SendEmailNotificationListener`
- [ ] Create `SendInAppNotificationListener`
- [ ] Create `SendSMSNotificationListener`
- [ ] Create `SendWebhookNotificationListener`

### 5. Services
- [ ] Create `ActivitySubscriptionService`
  - `subscribe(User $user, array $criteria): ActivitySubscription`
  - `unsubscribe(int $subscriptionId): bool`
  - `updateSubscription(int $subscriptionId, array $data): ActivitySubscription`
  - `getUserSubscriptions(User $user): Collection`
  - `matchSubscriptions(Activity $activity): Collection`

- [ ] Create `ActivityNotificationService`
  - `createNotifications(Activity $activity): void`
  - `processPendingNotifications(): void`
  - `markAsRead(int $notificationId): bool`
  - `markAllAsRead(User $user): int`
  - `getUnreadCount(User $user): int`
  - `getNotificationHistory(User $user, int $limit = 50): Collection`

- [ ] Create `DigestNotificationService`
  - `generateHourlyDigest(User $user): Notification`
  - `generateDailyDigest(User $user): Notification`
  - `generateWeeklyDigest(User $user): Notification`

### 6. Channels
- [ ] Create `ActivityEmailChannel`
  - Email template design
  - HTML and plain text versions
  - Attachment support
  - Unsubscribe link

- [ ] Create `ActivityInAppChannel`
  - Store in database
  - Real-time broadcast via WebSocket
  - Notification badge counter

- [ ] Create `ActivitySMSChannel`
  - SMS template
  - Character limit handling
  - Unsubscribe keyword

- [ ] Create `ActivityWebhookChannel`
  - POST to configured URL
  - Retry logic
  - Webhook signature verification

### 7. Jobs
- [ ] Create `CreateActivityNotificationsJob`
  - Queued onActivityCreated
  - Find matching subscriptions
  - Create notification records

- [ ] Create `SendNotificationJob`
  - Process single notification
  - Handle channel-specific sending
  - Retry on failure
  - Mark as sent/failed

- [ ] Create `GenerateDigestJob`
  - Scheduled (hourly, daily, weekly)
  - Aggregate activities per user
  - Send digest notifications

### 8. Filament Resources
- [ ] Create `ActivitySubscriptionResource`
  - List view with filters
  - Create/Edit forms
  - Subscription builder UI
  - Test notification button

- [ ] Create `ActivityNotificationResource`
  - List view with filters
  - Mark as read/unread actions
  - Notification detail view
  - Bulk actions

- [ ] Update `UserResource`
  - Add activity notifications tab
  - Show notification preferences
  - Link to subscription management

- [ ] Create `ActivityNotificationWidget`
  - Notification bell icon
  - Dropdown with recent notifications
  - Unread count badge
  - Mark all as read button

### 9. User Preferences
- [ ] Create notification preferences in user settings
  - Default channels
  - Digest frequency
  - Quiet hours (no notifications)
  - Category preferences

### 10. Tests
- [ ] Create `ActivitySubscriptionTest`
  - Test subscription creation
  - Test subscription matching
  - Test subscription updates

- [ ] Create `ActivityNotificationTest`
  - Test notification creation
  - Test notification sending
  - Test notification reading
  - Test digest generation

- [ ] Create `NotificationChannelTest`
  - Test email channel
  - Test in-app channel
  - Test SMS channel
  - Test webhook channel

- [ ] Create `DigestNotificationTest`
  - Test hourly digest
  - Test daily digest
  - Test weekly digest

### 11. Documentation
- [ ] Create notification guide
- [ ] Document subscription management
- [ ] Create channel configuration guide
- [ ] Add API documentation

## Acceptance Criteria
- [ ] Users can subscribe to activity notifications
- [ ] Notifications sent via all configured channels
- [ ] Real-time in-app notifications work
- [ ] Digest notifications aggregate correctly
- [ ] Notification preferences are respected
- [ ] Failed notifications are retried
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Task 001: Activity Categorization System
- Notify module (notification infrastructure)
- Xot module (base classes)
- Filament 5.x (admin UI)

## Estimated Time
- Database schema: 2 hours
- Models: 2 hours
- Events/Listeners: 3 hours
- Services: 6 hours
- Channels: 6 hours (4 channels × 1.5h)
- Jobs: 3 hours
- Filament resources: 5 hours
- User preferences: 2 hours
- Tests: 6 hours
- Documentation: 2 hours

**Total: 37 hours (5 days)**

## Priority
**High** - Important for user awareness and monitoring

## Related Tasks
- Task 001: Activity Categorization System
- Task 002: Advanced Activity Filtering
- Task 003: Activity Analytics Dashboard

## Notes
- Use Laravel's notification system as base
- Implement rate limiting to prevent notification spam
- Queue all notification sending to avoid blocking
- Use WebSockets for real-time in-app notifications
- Add unsubscribe mechanism for all channels
- Consider notification deduplication

---

**Status**: Pending
**Assignee**: TBD