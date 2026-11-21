---
updated: 2026-09-26
qmd: "PHILOSOPHY"
issues: []
discussions: []
title: Notify Module Philosophy
type: manifesto
tags: [notify, philosophy, architecture, async]
created: 2026-09-06
---

# Notify Module Philosophy

> **Essere Connessi** — A citizen in the dark is a citizen who doubts. The moment they know—via email, SMS, WhatsApp, or push—that their ticket was received, routed, escalated, closed, they trust the system. That's why Notify exists: not as a feature, but as the connective tissue between state and awareness.

---

## Religione: The Core Dogmas

### 1. Notification is State Reflection

Notify does not *create* state. It *reflects* state. The decision to notify lives in the domain (`Xot\States\Transitions\XotBaseTransition`, `Ptv\Actions\Scheda\SendMailByRecord`). Notify is the messenger, never the decision-maker.

**Sacred Boundary**: If you're deciding *whether* to send a notification inside Notify code, you've crossed the line. Push that logic back to the domain.

### 2. Multi-Channel is Non-Negotiable

A notification is simultaneously email, SMS, WhatsApp, push, and Telegram—or none. Channels are not alternatives; they are dimensions of the same message. A single template compiles to multiple forms:

- Email: HTML + text fallback
- SMS: 160 chars, truncated elegantly
- Push: title + body, platform-aware
- Telegram: Markdown-escaped
- WhatsApp: Compliant with provider's text restrictions

The recipient's preferences (from the User module) determine which dimensions light up.

### 3. Async is Not Optional

Every notification is a `QueueableAction`. Synchronous sends are only for testing. Production always queues. Why? Because a citizen's ticket acknowledgment email cannot hang the API response. Queue it, retry 3 times, escalate to admin if all fail. Move on.

### 4. Templates Are First-Class Citizens

Templates live in the database, versioned, translatable, compiled at send-time. Not hardcoded. Not in view files. The Filament UI lets admins tweak subject lines without a deploy. Variables are explicit ({{user_name}}, {{ticket_id}}), validated before rendering.

### 5. Provider Abstraction: One Action Per Provider

46 actions. One per SMS provider (Twilio, Netfun, Plivo, Nexmo, Agiletelecom, Gammu, Esendex, SmsFactor, NexmoX2, Plus X), one per push (Firebase variants), one per Telegram API flavor, one per WhatsApp route.

Why 46 instead of 1 god-action? **Because constraints are data.** Each provider has:
- Different auth (Basic, Bearer, API Key, OAuth)
- Different rate limits
- Different retry semantics
- Different payload shapes
- Different success/failure codes

Lumping them together hides this truth. Separating them makes each provider's weirdness explicit and testable in isolation.

---

## Filosofia: Architecture Decisions

### Why So Many Actions?

**The Action-Per-Provider Thesis:**

Each provider is a **bounded context**. When Twilio changes its API, you fix 1 action, not 46. When you want to add Vonage, you write 1 new action, deploy it, toggle it on in config. No fear of breaking SMS-via-Nexmo while adding WhatsApp-via-Vonage.

The pattern is:

```
SendNotificationAction (orchestrator)
  → SendMail/SmsMail/PushAction (channel coordinator)
    → SendTwilio/SendNetfun/SendPlivo (provider implementations)
```

The orchestrator handles template compilation and multi-channel routing. Each channel coordinator knows about its own transports. Each provider action speaks to exactly one API.

### Why Spatie QueueableAction, Not Services?

**QueueableAction Wins:**

1. **Intrinsic async**: The action *itself* knows if it should queue. No separate "Job" wrapper.
2. **Reuse**: An action can be called sync (testing, admin UI) or queued (production). One artifact.
3. **Composability**: Actions calling actions. `SendNotificationAction` calls `SendMail`, which might call internal formatting actions. Clean dependency graph.
4. **Type safety**: Constructor injection, no service-locator games.

**Why Not Services?**

Services blur the line. A service is "business logic," but Notify's actions are "transport logic." Using `NotifyService` suggests you're making decisions there, which violates Religione #1. Using `SendSmsAction` says exactly what you're doing: sending an SMS.

### Why Not Laravel's Native Notification System?

Laravel's `Notification` + `Notifiable` is great for simple apps. But FixCity has:

- **Template versioning**: Who changed the "ticket assigned" email? When? Why?
- **Audit trail**: Every notification sent is logged, tied to a user and template.
- **Multi-tenant**: Notifications must respect tenant boundaries.
- **Admin override**: An admin might want to resend a notification to a subset of users.
- **Preference matrix**: A user might want email for "urgent" but SMS for "escalation" only.
- **Retry policy**: If Twilio fails, try again in 30 mins. If it fails again, escalate to a human queue.

Notify handles all this. Laravel's system handles simpler cases.

### Why Contracts, Not Traits?

Each provider action implements `SmsActionContract` or `WhatsAppProviderActionContract`. Why contracts instead of traits?

**Contracts are explicit guarantees.** When you see `implements SmsActionContract`, you know this action accepts `SmsData` and returns `['status_code' => int, 'status_txt' => string]`. Traits are methods in the dark; contracts are a billboard.

Traits were tempting for "shared SMS logic" (phone number normalization, character encoding). We rejected them because each provider has *slightly* different rules. Consolidating them hides bugs. Better to repeat the normalization 8 times and know exactly what each provider gets.

---

## Politica: Rules That Govern Operation

### Channel Preference Rules

1. **Explicit Override**: Admin can force a notification via a specific channel, ignoring user preference.
2. **Silent Fallback**: If SMS fails (no phone number), don't bounce the whole send. Try email instead.
3. **Graceful Degradation**: If FCM is down, log it, but don't crash. Admin sees the failed notification in the dashboard.
4. **Batching**: Bulk sends (100+ notifications) are split into 10-notification micro-batches to avoid rate-limit blasts.

### Retry Logic

| Channel | Provider | Retry Attempts | Backoff Strategy | Max Age |
|---------|----------|-----------------|------------------|---------|
| SMS     | Twilio   | 3               | 30s, 5m, 30m     | 24h     |
| SMS     | Netfun   | 3               | 1m, 10m, 60m     | 24h     |
| Email   | SMTP     | 5               | 1m, 5m, 15m, 1h, 6h | 48h |
| Push    | FCM      | 2               | 10s, 1m          | 6h      |
| Telegram| Official | 3               | 10s, 1m, 10m     | 12h     |

### Rate Limiting

- **Per User**: 60 notifications/hour max (configurable).
- **Per Provider**: Twilio allows 100 msgs/sec; Notify respects it via token-bucket throttling.
- **Per Queue**: Notifications queue uses `'notifications'` queue with 5 workers max.

### Template Activation Rules

A template only sends if:

1. `is_active = true`
2. `channels` is not empty
3. `conditions` (if present) evaluate to true (e.g., "only send if ticket priority > 2")
4. `shouldSend()` method returns true (custom logic per template)

### Preference Matrix Example

```
User: Marco
- Urgent notifications: Email + SMS
- Status updates: Email only
- Marketing: Do not disturb (DND)
- Digest: Sunday 8am email (future)

Ticket state: "Escalation needed"
Notification type: "Escalation alert" (Urgent)
Notify should send: Email to marco@... + SMS to +39...
```

---

## Scopo: What Notify Solves in FixCity

### The Problem It Solves

A citizen reports a pothole. The ticket is created, routed to a district manager, reviewed, scheduled, repaired, closed. Without Notify:
- Citizen gets 0 updates. They wonder: Is anyone looking at this?
- District manager misses assignments because no alert.
- Supervisor has no visibility into work in progress.
- Admin can't prove to the city council that the system is live.

With Notify:
- Citizen receives SMS (preferred) or email (fallback) when status changes.
- Manager gets a WhatsApp notification when assigned.
- Supervisor logs in and sees 47 tickets in flight, completion rate 89%.
- City council sees a dashboard: "892 issues reported, 847 resolved in 6 days."

### Consumers of Notify

6 modules depend on Notify:
1. **IndennitaResponsabilita** (9 files): Liability notifications
2. **Progressioni** (6 files): Progression alerts
3. **Xot** (4 files): Core transitions
4. **Ptv** (3 files): PTV-specific messaging
5. **Pdnd** (2 files): PDND compliance
6. **User** (1 file): User-level preferences

All 6 trigger notifications by calling `NotificationManager::send()` with a template code and context data. They never hardcode email subjects or SMS bodies.

### What Notify Does NOT Own

- **Deciding to notify**: Domain modules decide. Notify only executes.
- **User authentication**: User module handles login, roles, permissions.
- **Storing user contact info**: User module owns email/phone. Notify reads it.
- **Rendering full website emails**: Email layout is HTML, but Notify delegates view-building to Spatie's email templates.
- **Scheduling future notifications**: Not yet. Planned for 2026 Q2.

---

## Zen: The Essence of Async Communication

Async notification is a **contract between states**:

```
User's State at T0: "ticket_open"
  ↓
System Event: "Ticket escalated"
  ↓
Notify.send(template: "escalation_alert", data: {...})
  ↓
Message queued at T1
  ↓
Worker picks up at T2 (now + 10 seconds)
  ↓
Message sent at T3
  ↓
Notification record created: { status: "sent", sent_at: T3 }
  ↓
User's awareness at T3: "My ticket is escalated"
```

The gap between T0 (decision) and T3 (awareness) is async. It's accepted because:
- T3 - T0 is usually < 30 seconds in production.
- The database record at step N guarantees idempotence: if the worker crashes, another worker picks up the same job without duplicating the send.
- If send fails (T3 throws), the job is retried. Admin is alerted if all retries fail.

**Zen Principle:** Async is not fire-and-forget. It's fire, retry, log, and alert. The user's phone buzzes late, but it buzzes. The system never silently loses a notification.

---

## Librerie da Installare

### Core Laravel/PHP

- `laravel/framework` (v12) — Queueing, Eloquent, Migrations
- `spatie/laravel-queueable-action` — The action pattern
- `spatie/laravel-medialibrary` — File attachments for templates
- `spatie/laravel-translatable` — Multi-language templates

### Channel Providers

#### Email

- `laravel/mail` (built-in) — SMTP driver
- `spatie/laravel-html-to-pdf` (optional) — PDF attachments
- `symfony/mailer` (built-in) — Mail sending

#### SMS

- `twilio/sdk` — Twilio API
- `vonage/client` (Nexmo rebrand) — Vonage/Nexmo
- `guzzlehttp/guzzle` — HTTP client (used by all providers)

#### Push Notifications

- `kreait/firebase-php` — Firebase Admin SDK
- `google/cloud-storage` (optional) — GCS for FCM certificates

#### Telegram

- `nutgram/nutgram` — Telegram Bot API wrapper (preferred)
- `irazasyed/telegram-bot-sdk` — Alternative Telegram SDK
- Manual cURL for official Bot API

#### WhatsApp

- `twilio/sdk` — Twilio WhatsApp integration
- `vonage/client` — Vonage WhatsApp
- `facebook/business` — Facebook Cloud API

### Infrastructure

- `predis/predis` — Redis for queue backend (optional; use SQS/Postgres if not self-hosted)
- `monolog/monolog` (built-in) — Logging (configured in config/logging.php)

### Development & Testing

- `pestphp/pest` — Test framework
- `laravel/dusk` (optional) — Browser testing for rendered emails
- `jchrist/mailhog` (Docker image) — Local SMTP testing

### Installation

```bash
# In the Notify module composer.json (not root)
composer require \
  spatie/laravel-queueable-action \
  spatie/laravel-medialibrary \
  spatie/laravel-translatable \
  twilio/sdk \
  vonage/client \
  kreait/firebase-php \
  nutgram/nutgram
```

---

## Future Implementazioni

### 2026 Q1: Webhook Delivery Status

Currently: Notifications are sent, not fully tracked. Future: Provider webhooks (e.g., Twilio "message delivered" callback) update the notification record in real time.

Implementation:
- Add webhook receiver routes in `routes/api.php`
- Validate webhook signature (provider-specific)
- Update `NotificationLog` record: `status = 'delivered'`, `delivered_at = now()`
- Trigger follow-up actions (e.g., "ticket auto-close if all recipients confirmed")

### 2026 Q2: Scheduled & Digest Notifications

Today: Send immediately or retry on failure. Tomorrow:
- Schedule a notification for later (e.g., "send at 2pm UTC")
- Digest mode: Collect 10 updates and batch-send once at end of day

Implementation:
- Add `scheduled_at` and `digest_id` columns to `notifications` table
- Batch job at midnight: "CollectDigestsAndSend"
- UI in Filament to set digest frequency per user per type

### 2026 Q3: AI-Powered Template Suggestions

Admin writes: "User {{name}}, your ticket is {{status}}." AI suggests: "You'll get 5% higher engagement if you personalize by priority too." With approval, suggest: "Your {{priority}} ticket..."

Implementation:
- POST to `/api/templates/suggest` with template text
- LLM (Claude via API) returns suggestions
- Admin reviews, accepts, rejects

### 2026 Q4: Multi-Tenant Customization

Each tenant configures:
- Logo in email headers
- Colors, font, layout
- Sender address (no-reply@ourcompany.com vs admin@municipality.gov.it)
- Preferred channels per notification type

Implementation:
- Tenant-scoped `NotificationTemplate::where('tenant_id', auth()->tenant()->id)`
- Tenant-scoped provider credentials (Twilio Account SID stored per tenant)
- `TenantAwareNotificationManager` middleware

### 2027 H1: End-to-End Encryption

Sensitive data (ticket IDs, user names) in transit. Encrypt at send time with tenant's public key, decrypt client-side.

---

## Competitors & Inspirations

### Industry Players

| Service | Strength | Weakness | Why Notify Differs |
|---------|----------|----------|-------------------|
| **Twilio SendGrid** | Best-in-class email deliverability, templates | Expensive ($100+/mo), SaaS lock-in, not SMS | We own the IP, mix 7 SMS + 4 email providers |
| **Mailgun** | Good email + SMS combo, good docs | Pricey, less WhatsApp support | We are cheaper, multi-tenant, no API calls for template logic |
| **Firebase FCM** | Only push service that matters | Only push, no email/SMS | We layer FCM + email + SMS in one place |
| **Vonage/Nexmo** | Mature, global carrier relationships | Expensive per SMS, SMS-only | We let admins pick Twilio (cheaper for US) or Vonage (better global) |
| **Slack** | Real-time, team collaboration | Not for citizen notifications, API-first only | Notify is batch + real-time, async-first, with human audit trail |

### Inspirations

1. **Spatie QueueableAction** — Why Notify uses actions, not services.
2. **Laravel Notification Channel System** — The idea of channels (mail, SMS, push), reimplemented more carefully.
3. **Postmark's Email Template Language** — Safe variable rendering without eval.
4. **Segment's CDP** — Audience filtering (e.g., "send only to users in district X").
5. **Intercom's Messenger** — Multi-channel, user preference aware, real-time.

---

## Best Practices

### 1. Always Use Templates, Never Hardcode

❌ WRONG:
```php
$user->notify(new \Illuminate\Notifications\Mail\MailNotification('Your ticket is closed'));
```

✅ RIGHT:
```php
NotificationManager::send($user, 'ticket_closed', ['ticket_id' => 123]);
```

The template `ticket_closed` exists in the database, has subject/body/channels, is versioned, translatable.

### 2. Prefer QueueableAction, Not Direct Send

❌ WRONG:
```php
Mail::send('ticket-closed', $data, function ($m) { $m->to($user->email); });
```

✅ RIGHT:
```php
SendMailAction::dispatch($recipient, $template, $options);
// Inside the action, all the queuing, error handling, and logging happens.
```

### 3. Store Context in the Notification Log

Each `Notification` record must capture what was sent:

```php
$notification->data = [
    'subject' => 'Ticket closed',
    'body_html' => '<p>Your ticket #123 is closed</p>',
    'body_text' => 'Your ticket #123 is closed',
    'template_code' => 'ticket_closed',
    'template_id' => 42,
    'payload' => ['ticket_id' => 123, 'ticket_status' => 'closed'],
    'options' => ['priority' => 'high']
];
```

Why? Audit trail. A year later, you can see exactly what was said.

### 4. Respect Channel Preferences

```php
// User prefers SMS for urgent, email for routine.
if ($notification_type === 'urgent') {
    $channels = ['sms']; // Override template's channels
} else {
    $channels = []; // Use template's default channels
}

NotificationManager::send($user, 'status_update', $data, $channels);
```

### 5. Test Notifications Synchronously

```php
// In tests
public function test_ticket_closed_sends_notification()
{
    $user = User::factory()->create();
    $ticket = Ticket::factory()->for($user)->create();

    // Set queue to 'sync' for testing
    Queue::fake(); // or use sync driver

    SendNotificationAction::dispatch($user, 'ticket_closed', ['ticket_id' => $ticket->id]);

    // Assert notification was logged
    $this->assertDatabaseHas('notifications', [
        'notifiable_type' => User::class,
        'notifiable_id' => $user->id,
    ]);
}
```

### 6. Log Failures, Don't Ignore Them

```php
try {
    SendTwilioSMSAction::dispatch($smsData);
} catch (Exception $e) {
    Log::error('SMS send failed', [
        'provider' => 'twilio',
        'recipient' => $smsData->recipient,
        'error' => $e->getMessage(),
    ]);
    // Escalate to admin queue if critical
    if ($is_critical) {
        AdminAlertAction::dispatch('SMS failed: '.$e->getMessage());
    }
}
```

### 7. Use Enums for Notification Types

```php
enum NotificationType: string {
    case TICKET_ASSIGNED = 'ticket_assigned';
    case TICKET_ESCALATED = 'ticket_escalated';
    case TICKET_CLOSED = 'ticket_closed';
}

NotificationManager::send($user, NotificationType::TICKET_ASSIGNED->value, $data);
```

No magic strings.

### 8. Version Templates, Never Edit in Place

When you need to change a template:

1. Create a new version in the database.
2. Set old template `is_active = false`.
3. Run migration: Point existing notifications to new template (optional).
4. New sends use new template automatically.

This way, you can audit: "On Sept 1, we changed the escalation email from 'Your issue is urgent' to 'Your issue needs immediate attention.'"

---

## Bad Practices

### 1. Hardcoding Notification Logic in Controllers

❌ WRONG:
```php
// In TicketController
public function update(Ticket $ticket, Request $request)
{
    $ticket->update($request->validated());
    
    if ($request->status === 'escalated') {
        Mail::send('ticket-escalated', ['ticket' => $ticket], function ($m) {
            $m->to(auth()->user()->email);
        });
    }
}
```

✅ RIGHT:
```php
// In TicketController
public function update(Ticket $ticket, Request $request)
{
    $ticket->update($request->validated());
    
    if ($request->status === 'escalated') {
        NotificationManager::send(auth()->user(), 'ticket_escalated', ['ticket_id' => $ticket->id]);
    }
}

// Or better: In the Ticket model's observer or state machine
// Xot\States\Transitions\XotBaseTransition fires NotificationManager automatically
```

The point: Controller coordinates, domain decides, Notify executes.

### 2. Ignoring Async Failures

❌ WRONG:
```php
SendMailAction::dispatch($user, $template);
// ... no error handling, no retry, no audit
```

✅ RIGHT:
```php
$job = SendMailAction::dispatch($user, $template)
    ->onQueue('notifications')
    ->onConnection('redis')
    ->retryUntil(now()->addHours(24));

// Later, a listener monitors job failures and escalates
// See JobFailedEvent listener
```

### 3. Mixing Notification Logic with Business Logic

❌ WRONG:
```php
class TicketService {
    public function closeTicket($ticket) {
        // Notification logic leaks into business logic
        $ticket->status = 'closed';
        $ticket->save();
        
        // Email sent here — hard to test, hard to debug
        Mail::send(...);
        
        // What if email fails? Transaction rolls back? Ticket stays open?
    }
}
```

✅ RIGHT:
```php
class TicketService {
    public function closeTicket($ticket) {
        // Pure business logic
        $ticket->status = 'closed';
        $ticket->save();
        // No email here
    }
}

// In the observer or event listener
class TicketStateObserver {
    public function updated(Ticket $ticket) {
        if ($ticket->wasChanged('status') && $ticket->status === 'closed') {
            // Event-driven notification
            NotificationManager::send($ticket->user, 'ticket_closed', ['ticket_id' => $ticket->id]);
        }
    }
}
```

### 4. Storing Secrets in Templates

❌ WRONG:
```
Template body: "Your password is {{user.password}}"
```

✅ RIGHT:
```
Template body: "Click here to reset your password: {{password_reset_link}}"
// Link is generated server-side, only the URL is in the template
```

Never expose sensitive data through templates.

### 5. Ignoring Rate Limits

❌ WRONG:
```php
foreach ($users as $user) {
    SendMailAction::dispatch($user, 'marketing_campaign');
}
// If there are 10,000 users, this queues 10,000 jobs instantly.
// Twilio/SendGrid rate limit: exceeded. Providers throttle. Notifications fail.
```

✅ RIGHT:
```php
$users->chunk(100)->each(function ($chunk) {
    SendBulkMailAction::dispatch($chunk, 'marketing_campaign')
        ->delay(now()->addMinutes(rand(1, 5))); // Stagger
});

// Inside SendBulkMailAction, chunk further and throttle
```

### 6. Forgetting About Time Zones

❌ WRONG:
```php
NotificationManager::send($user, 'daily_digest', ['scheduled_at' => now()]);
// Sends at server time, not user's time zone.
```

✅ RIGHT:
```php
$userTz = $user->timezone ?? 'UTC'; // Get from user profile
$sendAt = now()->setTimezone($userTz)->startOfDay()->addHours(8); // 8am user's time

NotificationManager::send($user, 'daily_digest', ['scheduled_at' => $sendAt]);
```

### 7. Not Testing Provider Credentials

❌ WRONG:
```php
// In production, user misconfigures Twilio credentials. First failure detected in production.
```

✅ RIGHT:
```php
// In NotifyServiceProvider or artisan command
public function boot() {
    if (app()->isProduction()) {
        $this->validateProviderCredentials();
    }
}

private function validateProviderCredentials() {
    try {
        $twilio = new Client(config('sms.drivers.twilio.account_sid'), ...);
        $twilio->api->accounts->fetch(); // Test the connection
    } catch (Exception $e) {
        Log::error('Twilio credentials invalid: '.$e->getMessage());
    }
}
```

---

## False Friends: Common Gotchas

### 1. Retry Logic Gotcha

**The Trap**: You set `backoff: [60, 300, 1800]` (1m, 5m, 30m). Job fails 3 times and disappears.

**The Reality**: After 3 retries, the job is moved to the dead-letter queue (DLQ) if configured, or just dropped. Admin doesn't know.

**The Fix**:
```php
// In your Job or Action
public function failed(Throwable $exception)
{
    Log::error('Notification send failed after all retries', [
        'exception' => $exception->getMessage(),
        'notification_id' => $this->notification_id,
    ]);
    
    // Escalate to human
    AdminAlert::dispatch('Notification failed: '.$this->notification_id);
}
```

### 2. Template Variable Gotcha

**The Trap**: Template says `{{user.full_name}}`. You pass `['user_id' => 123]`. Rendering fails silently.

**The Reality**: The `compile()` method expects exact keys. `{{user.full_name}}` means `data['user']['full_name']`. If you pass `['user_id' => 123]`, it renders as empty string.

**The Fix**: Always validate variables before sending.
```php
$template = NotificationTemplate::find($template_id);
$required = $template->variables ?? [];
foreach ($required as $var) {
    if (!array_key_exists($var, $data)) {
        throw new Exception("Missing template variable: {$var}");
    }
}
```

### 3. SMS Length Gotcha

**The Trap**: You write a 320-char SMS. It sends as 3 SMSes (160 chars each), charged 3x.

**The Reality**: Different providers have different length limits. Twilio charges per SMS (160 chars in English, 70 in Unicode). If you send 161 chars, that's 2 SMSes = 2x charge.

**The Fix**:
```php
$message = "Your ticket is closed..."; // 200 chars
if (strlen($message) > 160) {
    Log::warning('SMS exceeds 160 chars, will be split', ['length' => strlen($message)]);
}

// Or truncate intelligently
if (strlen($message) > 160) {
    $message = substr($message, 0, 157) . '...'; // 160 total
}
```

### 4. Email Header Gotcha

**The Trap**: You set `From: noreply@example.com`. Email gets flagged as spam because SPF/DKIM/DMARC fail.

**The Reality**: Sending email requires you to own the domain and configure records.

**The Fix**:
```bash
# In DNS for example.com
# SPF record
v=spf1 include:sendgrid.net ~all

# DKIM record (provided by Sendgrid/Mailgun)
selector._domainkey.example.com TXT v=DKIM1; k=rsa; p=MIGfMA0B...

# DMARC record (optional but recommended)
_dmarc.example.com TXT v=DMARC1; p=quarantine; rua=mailto:admin@example.com
```

Only then will emails deliver reliably.

### 5. Race Condition Gotcha

**The Trap**: User updates their phone number. Old SMS job is queued. New SMS job is queued. Both send (duplicate message).

**The Reality**: Without idempotency keys, it can happen.

**The Fix**:
```php
// In NotificationLog or a new IdempotencyKey table
$idempotency_key = hash('sha256', $user->id . $template_code . $data_hash);

// Check: has this exact notification been sent in the last 10 seconds?
$duplicate = NotificationLog::where('idempotency_key', $idempotency_key)
    ->where('created_at', '>', now()->subSeconds(10))
    ->exists();

if ($duplicate) {
    Log::warning('Duplicate notification detected, skipping');
    return null;
}
```

### 6. Preference Override Gotcha

**The Trap**: User prefers SMS. You override to email. User never sees it because they don't read email.

**The Reality**: Overrides should be rare and logged.

**The Fix**:
```php
if ($override_channels !== []) {
    Log::info('Notification channel override', [
        'user_id' => $user->id,
        'template_code' => $template_code,
        'user_preference' => $user_channels,
        'override_channels' => $override_channels,
        'reason' => 'Admin manual send for debugging',
    ]);
}
```

### 7. Language Mismatch Gotcha

**The Trap**: User's locale is `it_IT`. Template is only in `en`. Renders in English, user is confused.

**The Reality**: Template::translatable = ['subject', 'body_html', 'body_text']. If translation missing, falls back to default locale.

**The Fix**:
```php
$template = NotificationTemplate::find($template_id);
$user_locale = $user->locale ?? app()->getLocale();

if (!in_array($user_locale, $template->getTranslatedLocales())) {
    Log::warning('Template not translated for user locale', [
        'template_code' => $template->code,
        'user_locale' => $user_locale,
        'available_locales' => $template->getTranslatedLocales(),
    ]);
}
```

---

## Come Usarlo: Code Examples

### Example 1: Send a Ticket Status Notification

```php
// In XotBaseTransition or an Observer

use Modules\Notify\Actions\NotificationManager;

public function transitionTo(Ticket $ticket, string $status) {
    $ticket->status = $status;
    $ticket->save();
    
    // Notify user
    $templateCode = match($status) {
        'assigned' => 'ticket_assigned',
        'escalated' => 'ticket_escalated',
        'closed' => 'ticket_closed',
        default => null,
    };
    
    if ($templateCode) {
        NotificationManager::send(
            $ticket->user, 
            $templateCode, 
            [
                'ticket_id' => $ticket->id,
                'ticket_status' => $status,
                'assigned_to' => $ticket->assignee?->name,
            ]
        );
    }
}
```

### Example 2: Bulk Notification with Override

```php
// In Filament Resource action, admin sends custom alert to all users in a district

use Modules\Notify\Actions\NotificationManager;

public static function sendAlert(array $users, string $message) {
    foreach ($users as $user) {
        NotificationManager::send(
            $user,
            'admin_alert', // Template code
            [
                'message' => $message,
                'sent_at' => now()->format('Y-m-d H:i'),
            ],
            ['sms', 'email'], // Force SMS + email, ignore user preference
            ['priority' => 'high'] // Extra options
        );
    }
}
```

### Example 3: Test a Notification Send

```php
// In Pest test file

test('ticket_assigned notification sends email', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);
    $ticket = Ticket::factory()->for($user)->create();
    
    Queue::fake();
    
    NotificationManager::send($user, 'ticket_assigned', ['ticket_id' => $ticket->id]);
    
    // Assert job was queued
    Queue::assertPushed(SendNotificationAction::class);
    
    // Assert notification was logged
    expect($user->notifications)->toHaveCount(1);
    expect($user->notifications[0]->data['template_code'])->toBe('ticket_assigned');
});
```

### Example 4: Prefer SMS but Fallback to Email

```php
// In a service or action

public function notifyUrgent(User $user, string $message) {
    $channels = [];
    
    // Prefer SMS if phone number exists
    if ($user->phone_number) {
        $channels[] = 'sms';
    }
    
    // Always add email as fallback
    $channels[] = 'email';
    
    NotificationManager::send(
        $user,
        'urgent_alert',
        ['message' => $message],
        $channels
    );
}
```

### Example 5: Custom Template with Variables

```php
// In Filament resource, admin creates a template

return Notification\CreateAction::make()
    ->form([
        Forms\Components\TextInput::make('code')
            ->label('Template Code')
            ->required()
            ->example('ticket_reopened'),
        Forms\Components\Textarea::make('subject')
            ->label('Subject')
            ->hint('Variables: {{ticket_id}}, {{user_name}}, {{reason}}')
            ->required(),
        Forms\Components\TalesEditor::make('body_html')
            ->label('HTML Body')
            ->hint('Renders as email HTML'),
        Forms\Components\CheckboxList::make('channels')
            ->label('Channels')
            ->options(['email' => 'Email', 'sms' => 'SMS', 'push' => 'Push', 'telegram' => 'Telegram'])
            ->default(['email']),
    ]);

// Usage
NotificationManager::send($user, 'ticket_reopened', [
    'ticket_id' => 123,
    'user_name' => 'Marco',
    'reason' => 'Customer requested reopening',
]);
```

---

## Come Installarlo: Setup Guide

### Step 1: Install Dependencies

```bash
cd laravel/Modules/Notify

# Ensure composer.json has required packages
composer install

# Key packages for Notify in composer.json:
{
    "require": {
        "spatie/laravel-queueable-action": "^2.x",
        "spatie/laravel-medialibrary": "^10.x",
        "spatie/laravel-translatable": "^3.x",
        "twilio/sdk": "^7.x",
        "vonage/client": "^2.x",
        "kreait/firebase-php": "^7.x"
    }
}
```

### Step 2: Publish Configuration

```bash
# From root
php artisan vendor:publish --provider="Modules\Notify\Providers\NotifyServiceProvider"

# Creates config/sms.php, config/notify.php, etc.
```

### Step 3: Run Migrations

```bash
php artisan migrate
# Creates: notifications, notification_templates, notification_logs, etc.
```

### Step 4: Configure Providers

Edit `.env`:
```env
# Email
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password

# SMS - Twilio
TWILIO_ACCOUNT_SID=your_sid
TWILIO_AUTH_TOKEN=your_token
TWILIO_FROM=+1234567890

# SMS - Netfun (alternative)
NETFUN_API_KEY=your_key
NETFUN_API_URL=https://api.netfun.it

# Push - Firebase
FIREBASE_PROJECT_ID=your_project_id
FIREBASE_CREDENTIALS=/path/to/firebase-key.json

# Telegram
TELEGRAM_BOT_TOKEN=your_token
TELEGRAM_CHAT_ID=your_chat_id
```

### Step 5: Register Channels in Queue

Edit `config/queue.php`:
```php
'connections' => [
    'notifications' => [
        'driver' => 'redis', // or 'database', 'sqs'
        'connection' => 'default',
        'queue' => 'notifications',
        'retry_after' => 300,
        'block_for' => null,
    ],
],
```

### Step 6: Create Base Template

Create in Filament admin or via seeder:
```php
NotificationTemplate::create([
    'name' => 'Ticket Assigned',
    'code' => 'ticket_assigned',
    'subject' => 'Your ticket #{{ticket_id}} was assigned to {{assigned_to}}',
    'body_html' => '<p>Hi {{user_name}},</p><p>Your ticket has been assigned.</p>',
    'body_text' => 'Hi {{user_name}}, Your ticket #{{ticket_id}} was assigned to {{assigned_to}}.',
    'channels' => ['email', 'sms'],
    'variables' => ['ticket_id', 'user_name', 'assigned_to'],
    'is_active' => true,
]);
```

### Step 7: Start Queue Worker

```bash
php artisan queue:work --queue=notifications --timeout=60
```

### Step 8: Test

```bash
php artisan tinker

$user = User::first();

Modules\Notify\Actions\NotificationManager::send(
    $user, 
    'ticket_assigned', 
    ['ticket_id' => 1, 'user_name' => 'Marco', 'assigned_to' => 'Alice']
);

# Check queue
# Check notifications table
```

---

## Coverage Analysis

### Action Coverage

| Category | Count | Coverage | Notes |
|----------|-------|----------|-------|
| **SMS Providers** | 8 | ✅ | Twilio, Netfun, Plivo, Nexmo, Agiletelecom, Gammu, SmsFactor, Esendex |
| **Email Providers** | 4 | ✅ | SMTP, Mailtrap, Duocircle, custom |
| **Push/FCM** | 8 | ✅ | Firebase Admin SDK, multi-device, topic, targeting |
| **Telegram** | 3 | ✅ | Official API, Nutgram, Botman |
| **WhatsApp** | 4 | ✅ | Twilio, Vonage, Facebook, 360dialog |
| **Orchestration** | 5 | ✅ | Manager, Sender, Recipient, Recorder, Dispatcher |
| **Support** | 4 | ✅ | Phone normalization, theme resolver, PDF attachment, formatting |

**Total: 46 Actions** — Each provider is separate, each channel is coordinated, each concern is isolated.

### Model Coverage

| Model | Purpose | Status |
|-------|---------|--------|
| `Notification` | Main log | ✅ |
| `NotificationTemplate` | Database-backed template | ✅ |
| `NotificationLog` | Audit trail | ✅ |
| `NotificationChannel` | Channel metadata | ✅ |
| `NotificationType` | Enum/types | ✅ |
| `Contact` | Recipient contact info | ✅ |
| `Theme` | Template styling | ✅ |

### Test Coverage

| Domain | Files | Coverage |
|--------|-------|----------|
| Actions | 15+ | 75% (queued actions hard to test) |
| Models | 8+ | 85% |
| Services | 3+ | 80% |
| Contracts | 6 | 100% (interfaces only) |

**Target**: 85%+ by Q1 2026.

---

## Final Mantra

> Async notifications are not a luxury feature. They are the interface between your system and human trust. Every notification that fails silently is a citizen losing faith. Every notification that arrives is a vote for your platform's competence.

Design Notify as if you're a telecom operator: redundant, monitored, audited, retried, never silent. That's how you build systems that are trusted.

**Verso il futuro.** The system watches. The citizen knows. The loop closes.
