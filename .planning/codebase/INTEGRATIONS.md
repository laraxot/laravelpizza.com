# External Integrations

## 1) Integration map (at a glance)
- **Databases:** MySQL/MariaDB/PostgreSQL/SQL Server/SQLite via Laravel DB config in `laravel/config/database.php`.
- **Auth providers:** Laravel Passport OAuth2 + Socialite/Auth0 (+ dynamic Microsoft extension) via `laravel/Modules/User/*`.
- **Messaging APIs:** Telegram, SMS providers, WhatsApp providers via `laravel/Modules/Notify/*`.
- **Cloud providers:** AWS (S3/SQS/SES/DynamoDB-capable) and Firebase config present in `laravel/config/*.php`.
- **Webhooks:** outbound webhook templates configured, inbound webhook route currently commented for Telegram in `laravel/Modules/Notify/routes/api.php`.

## 2) Databases and storage backends

### Implemented configuration
- **DB drivers configured:** `sqlite`, `mysql`, `mariadb`, `pgsql`, `sqlsrv` in `laravel/config/database.php`.
- **Extra `user` database connection** in `laravel/config/database.php` (separate DB credentials/DB name support).
- **Tenant connection propagation logic** in `laravel/Modules/Tenant/app/Providers/TenantServiceProvider.php` (module-specific cloned connections).

### Environment evidence
- `.env.example` defaults to SQLite (`DB_CONNECTION=sqlite`) in `laravel/.env.example`.
- Testing env uses MySQL and separate user DB variables in `laravel/.env.testing`.

### Filesystem/cloud storage
- **S3 disk configured** in `laravel/config/filesystems.php`.
- **AWS env keys referenced** in `laravel/.env.example` and `laravel/config/filesystems.php`.

## 3) Authentication and identity integrations

### OAuth2 / API auth
- **Passport dependency** in `laravel/composer.json` and `laravel/Modules/User/composer.json`.
- **Passport config (keys/client/personal access)** in `laravel/config/passport.php`.
- **Passport runtime setup** (routes, token TTLs, custom models, password grant) in `laravel/Modules/User/app/Providers/PassportServiceProvider.php` + `laravel/Modules/User/config/passport.php`.
- **OAuth persistence tables** in User migrations, for example:
  - `laravel/Modules/User/database/migrations/2023_01_01_000003_create_oauth_access_tokens_table.php`
  - `laravel/Modules/User/database/migrations/2023_01_01_000000_create_oauth_auth_codes_table.php`
  - `laravel/Modules/User/database/migrations/2020_01_01_000003_create_oauth_refresh_tokens_table.php`

### Social login / external IdP
- **Socialite/Auth0 package** in `laravel/Modules/User/composer.json` (`socialiteproviders/auth0`).
- **Auth0 event wiring** in `laravel/Modules/User/app/Providers/EventServiceProvider.php`.
- **Dynamic Microsoft Socialite extension** in `laravel/Modules/User/app/Providers/SocialiteServiceProvider.php`.
- **Social OAuth routes** (`/admin/login/{provider}`, `/sso/{provider}/callback`) in `laravel/Modules/User/routes/socialite.php`.
- **Provider credential matrix** (Google, GitHub, GitLab, LinkedIn, Slack, Microsoft, etc.) in `laravel/Modules/User/config/social-providers.php`.
- **Filament-socialite config** in `laravel/Modules/User/config/socialite.php`.

## 4) Email, notification, and chat integrations

### Email transports
- **Configured transports:** SMTP, SES, Postmark, Resend, Sendmail, log, failover, roundrobin in `laravel/config/mail.php`.
- **Third-party credential registry:** Postmark/Resend/SES/Slack in `laravel/config/services.php`.
- **Notification template engine:** Spatie mail templates package in `laravel/Modules/Notify/composer.json` and usage in `laravel/Modules/Notify/app/Emails/SpatieEmail.php`.

### Telegram
- **Telegram SDK config (global):** bot token/webhook support in `laravel/config/telegram.php`.
- **Telegram drivers (official/botman/nutgram):** in `laravel/Modules/Notify/config/telegram.php`.
- **Telegram sender action calls Telegram Bot API endpoints** (`/bot{token}/sendMessage`, etc.) in `laravel/Modules/Notify/app/Actions/Telegram/SendOfficialTelegramAction.php`.
- **Telegram channel factory** in `laravel/Modules/Notify/app/Factories/TelegramActionFactory.php`.

### SMS providers
- **Configured SMS drivers:** `smsfactor`, `twilio`, `nexmo`, `plivo`, `gammu`, `netfun`, `agiletelecom` in `laravel/Modules/Notify/config/sms.php`.
- **SMSFactor API usage** (base URL + `/messages`) in:
  - `laravel/Modules/Notify/app/Datas/SMS/SmsFactorData.php`
  - `laravel/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`
- **AgileTelecom API usage** (`https://secure.agiletelecom.com/securesend_v1.aspx`) in `laravel/Modules/Notify/app/Actions/SMS/SendAgiletelecomSMSv1Action.php`.

### WhatsApp providers
- **Configured providers:** Twilio, Vonage, Facebook, 360dialog in `laravel/Modules/Notify/config/whatsapp.php`.
- **Twilio API endpoint usage** (`https://api.twilio.com/2010-04-01/.../Messages.json`) in `laravel/Modules/Notify/app/Actions/WhatsApp/SendTwilioWhatsAppAction.php`.
- **Vonage/Nexmo endpoint usage** (`https://api.nexmo.com/v1/messages`) in `laravel/Modules/Notify/app/Actions/WhatsApp/SendVonageWhatsAppAction.php`.

## 5) Firebase integration
- **Firebase config present** with credentials/auth/firestore/realtime-db/storage/dynamic-links in `laravel/config/firebase.php`.
- **Push messaging usage points** in Notify test pages and notifications, e.g.:
  - `laravel/Modules/Notify/app/Filament/Clusters/Test/Pages/SendPushNotificationPage.php`
  - `laravel/Modules/Notify/app/Notifications/FirebaseAndroidNotification.php`

## 6) Queues, cache, and async backends
- **Queue drivers configured:** database, beanstalkd, sqs, redis, deferred, background, failover in `laravel/config/queue.php`.
- **Cache stores configured:** database, file, memcached, redis, dynamodb, octane, failover in `laravel/config/cache.php`.
- **Redis config** in `laravel/config/database.php`.
- **Queue default:** database in `laravel/config/queue.php`.

## 7) Webhooks

### Outbound (configured)
- **Notification webhook templates** in `laravel/Modules/Notify/config/notify.php` (`notification_delivered`, `notification_bounced`, `notification_clicked`).
- **Webhook config helper plumbing** in `laravel/Modules/Notify/app/Helpers/ConfigHelper.php`.

### Inbound (current status)
- **Telegram webhook route scaffold exists but is commented out** in `laravel/Modules/Notify/routes/api.php`.
- **Webhook setup command exists but action is commented** in `laravel/Modules/Notify/app/Console/Commands/TelegramWebhook.php`.

## 8) Notable integration gaps/mismatches to verify
- Telegram sending actions read `config('services.telegram.*')` in `laravel/Modules/Notify/app/Actions/Telegram/SendOfficialTelegramAction.php`, while Telegram config is defined in `laravel/config/telegram.php` and `laravel/Modules/Notify/config/telegram.php`.
- This suggests a potential config-key mismatch unless `services.telegram` is added elsewhere at runtime.

## 9) Practical integration summary
- **Strongly implemented:** Passport OAuth2, Socialite/Auth0 scaffolding, modular DB multi-connection, mail transport abstraction, SMS/WhatsApp API clients.
- **Configured but environment-dependent:** AWS (S3/SQS/SES/DynamoDB), Firebase, many social providers.
- **Partially wired:** webhook inbound receivers (currently scaffolded/commented).
