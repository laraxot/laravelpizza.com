---
title: Notify Module: Migrations & Schema
created: 2026-07-15
updated: 2026-07-15
type: module-documentation
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
tags: [docs, notify, bmad]
qmd: "notify module   migrations & schema parity notify"
---

# Notify Module: Migrations & Schema Parity

## Philosophy

One model = One migration = One seeder = One factory.

All models in the Notify module must maintain 1:1:1:1 parity across models, migrations, seeders, and factories. This ensures complete schema coverage, clear audit trails, and zero orphaned tables or missing models.

## Models & Migrations (1:1 Parity)

### Current Status

| # | Model | Table | Migration | Status | Notes |
|---|-------|-------|-----------|--------|-------|
| 1 | Contact | contacts | 2026_06_11_180000_create_notify_contacts_table.php | ✅ | User contact info (email, phone, etc.) |
| 2 | MailTemplate | mail_templates | 2018_10_10_000007_create_mail_templates_table.php | ✅ | Email template definitions |
| 3 | MailTemplateLog | mail_template_logs | ❌ MISSING | 🔴 | Email template execution log |
| 4 | MailTemplateVersion | mail_template_versions | 2025_04_20_000001_create_mail_template_versions_table.php | ✅ | Versioned email templates |
| 5 | Notification | notifications | 2026_06_10_134000_create_notifications_table.php | ✅ | Generic notification records |
| 6 | NotificationChannel | notification_channels | ❌ MISSING | 🔴 | Notification delivery channels (email, SMS, etc.) |
| 7 | NotificationLog | notification_logs | 2025_07_01_000000_create_notification_logs_table.php | ✅ | Notification execution audit log |
| 8 | NotificationTemplate | notification_templates | 2026_03_03_000000_create_notification_templates_table.php | ✅ | Notification template definitions |
| 9 | NotificationTemplateVersion | notification_template_versions | ❌ MISSING | 🔴 | Versioned notification templates |
| 10 | NotificationType | notification_types | 2026_03_03_000001_create_notification_types_table.php | ✅ | Notification type catalog |
| 11 | NotifyTheme | notify_themes | 2020_01_01_000007_create_notify_themes_table.php | ✅ | Theme/branding for notifications |
| 12 | NotifyThemeable | notify_themeables | 2022_11_24_000002_create_notify_themeables_table.php | ✅ PIVOT | Many-to-many relationship (polymorphic) |

**Parity: 9/12 models have migrations (3 missing)**

## Key Models Explained

### Core Models

**Contact**: Stores contact information for recipients (email, SMS, phone, etc.)
- Polymorphic: `model_type` / `model_id` (contacts belong to any model)
- Tracks delivery status: `verified_at`, `sms_sent_at`, `mail_sent_at`, `mail_count`, `sms_count`
- Custom attributes: `attribute_1` through `attribute_14` for flexible data storage

**MailTemplate**: Reusable email template library
- `name`: Display name
- `mailable`: Mailable class reference
- `slug`: Unique identifier for lookup
- `subject`, `html_template`, `text_template`: JSON template content
- `params`: JSON-encoded parameters
- `sms_template`: SMS variant

**MailTemplateVersion**: Version history for email templates
- Tracks changes and enables rollback
- Links back to `MailTemplate` via `mail_template_id`
- Audit columns: `created_by`, `updated_by`, `deleted_by`

**Notification**: Individual notification records
- `user_id`: Recipient reference
- `type_id`: Links to NotificationType
- `channel`: Delivery method (email, SMS, in-app, etc.)
- Status tracking: `read_at`, `sent_at`

**NotificationLog**: Execution audit log for all notifications
- Tracks every send attempt: timestamp, status, response
- Links to Notification via `notification_id`
- Error tracking: `error_message`, `retry_count`

**NotificationTemplate**: Reusable notification template library
- Similar to MailTemplate but for generic notifications
- `name`, `slug`, `subject`, `body` (plain text)
- JSON-encoded `variables` for substitution

**NotificationType**: Catalog of notification types
- `name`: Type identifier (e.g., 'password_reset', 'welcome')
- `description`
- `default_channel`: Preferred delivery method

**NotifyTheme**: Branding/theming system
- `name`, `slug`: Theme identifier
- JSON configuration for styling, logos, colors
- Tracks which models use this theme (via pivot)

**NotifyThemeable** (Pivot): Polymorphic many-to-many linking models to themes
- `theme_id` → NotifyTheme
- `themeable_type` / `themeable_id` (polymorphic)

### Models Requiring Migrations (3)

**MailTemplateLog**: Audit log for email template executions
- Tracks every send attempt, success/failure
- Essential for debugging email delivery issues

**NotificationChannel**: Configuration for delivery channels
- Supported channels: email, SMS, push, Slack, webhooks
- Channel-specific settings: API keys, endpoints, rate limits
- Status: active/inactive per channel

**NotificationTemplateVersion**: Version history for notification templates
- Similar to MailTemplateVersion
- Enables template versioning and rollback

## XotBaseMigration Pattern

All migrations MUST extend `XotBaseMigration` and follow the pattern below.

### Template (Recommended: Minimal)

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\Contact;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Contact::class;

    public function up(): void
    {
        // Table creation (idempotent)
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
        });

        // Modifications and audit columns
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table);  // Adds created_at, updated_at, created_by, updated_by
        });
    }
};
```

### Template (Explicit: Optional)

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\MailTemplate;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = MailTemplate::class;

    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('subject')->nullable();
            $table->json('html_template')->nullable();
            $table->json('text_template')->nullable();
        });

        $this->tableUpdate(function (Blueprint $table): void {
            // Add specific columns if needed
            if (! $this->hasColumn('mailable')) {
                $table->string('mailable')->nullable();
            }
            
            // Add audit trail
            $this->updateTimestamps($table);
        });
    }
};
```

### Pivot Table Pattern (NotifyThemeable)

```php
<?php
declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up(): void
    {
        // Note: Pivot tables typically don't have a model_class
        Schema::create('notify_themeables', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('theme_id')->constrained('notify_themes');
            $table->uuidMorphs('themeable');  // polymorphic foreign key
            $table->timestamps();
        });
    }
};
```

### Soft Deletes Pattern

```php
$this->tableUpdate(function (Blueprint $table): void {
    // Pass true to include soft deletes (deleted_at, deleted_by)
    $this->updateTimestamps($table, $softDeletes = true);
});
```

## Verification Checklist

Before committing migration changes:

- [ ] All migrations extend `XotBaseMigration` (never standard `Migration`)
- [ ] No hardcoded table names (derive via model or `$this->getTable()`)
- [ ] No hardcoded `$connection` property (derives from model)
- [ ] Uses `$this->tableCreate()` for table creation
- [ ] Uses `$this->tableUpdate()` for modifications
- [ ] Uses `$this->hasColumn()` for existence checks
- [ ] Uses `$this->updateTimestamps()` for audit columns
- [ ] Parity maintained: 9 models = 9 migrations (+ 3 pending)
- [ ] PHPStan L10: `phpstan analyse Modules/Notify/database/migrations --level=10`
- [ ] PHPMD: `tools/phpmd.sh Modules/Notify/database/migrations/`
- [ ] Tests pass (if applicable): `./vendor/bin/pest Modules/Notify/`

## Known Issues & Cleanup Status

### Duplicate Migrations Archived (as .old)

10 duplicate migrations were archived to clean up the migration directory:

| Archived File | Reason |
|---|---|
| 2018_10_10_000000_create_mail_templates_table.php.old | Superseded by 2018_10_10_000007 |
| 2018_10_10_000002_create_mail_templates_table.php.old | Superseded by 2018_10_10_000007 |
| 2018_10_10_000003_create_mail_templates_table.php.old | Superseded by 2018_10_10_000007 |
| 2018_10_10_000004_create_mail_templates_table.php.old | Superseded by 2018_10_10_000007 |
| 2018_10_10_000005_create_mail_templates_table.php.old | Superseded by 2018_10_10_000007 |
| 2018_10_10_000006_create_mail_templates_table.php.old | Superseded by 2018_10_10_000007 |
| 2022_10_12_133532_create_notifications_table.php.old | Superseded by 2026_06_10 |
| 2022_10_12_133535_create_notify_contacts_table.php.old | Superseded by 2026_06_11 |
| 2024_04_20_000001_create_mail_template_versions_table.php.old | Superseded by 2025_04_20 |
| 2025_03_31_000001_create_notification_logs_table.php.old | Superseded by 2025_07_01 |

**Cleanup Strategy:** Archived files with `.old` suffix remain in git history but are ignored by Laravel migration runner. This preserves audit trail while cleaning active directory.

### Missing Migrations (To Be Created)

| Model | Table | Priority | Notes |
|-------|-------|----------|-------|
| MailTemplateLog | mail_template_logs | HIGH | Audit log for email sends |
| NotificationChannel | notification_channels | HIGH | Channel configuration store |
| NotificationTemplateVersion | notification_template_versions | MEDIUM | Template version history |

## Related Files

- **Migration Base Class:** `laravel/Modules/Xot/app/Database/Migrations/XotBaseMigration.php`
- **Module Models:** `laravel/Modules/Notify/app/Models/*.php`
- **Seeders:** `laravel/Modules/Notify/database/seeders/`
- **Factories:** `laravel/Modules/Notify/database/factories/`
- **Tests:** `laravel/Modules/Notify/tests/`
- **Pattern Docs:** `docs/wiki/patterns/migration-xot-base-pattern.md`

## Questions?

Refer to:
- `laravel/Modules/Xot/docs/migrations.md`: XotBaseMigration comprehensive guide
- `docs/wiki/patterns/migration-naming-and-parity-convention.md`: Naming standards
- `docs/wiki/rules/migration-xot-base-standard.md`: Enforcement rules

---

**Status:** Active  
**Last Updated:** 2026-07-15  
**Parity Audit:** Notify module has 9/12 models with migrations (3 pending creation)
