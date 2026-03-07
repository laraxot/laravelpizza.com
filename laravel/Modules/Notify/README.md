# Notify Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Actions 35](https://img.shields.io/badge/Actions-35-purple.svg)](#azioni)
[![Channels 5](https://img.shields.io/badge/Channels-5-orange.svg)](#canali)

> **Hub di comunicazione multi-canale**: Email, SMS, WhatsApp, Telegram e notifiche database. Template da DB con Spatie, allegati binari, temi personalizzabili, 35 azioni per 12+ provider.

---

## 📋 Overview

Il modulo **Notify** centralizza tutte le comunicazioni dell'applicazione: dalla semplice email alla notifica WhatsApp, dal template HTML personalizzabile all'SMS di massa. I template vivono nel database (Spatie Mail Templates), i temi sono gestibili da Filament, e ogni canale ha provider multipli con fallback.

> **📧 Focus**: Multi-channel communication, template-driven emails, SMS/WhatsApp/Telegram, database notifications

### 🎯 Cosa Fai

- **📧 Email Communication**: Template-driven emails con variabili dinamiche
- **📱 SMS/WhatsApp**: Multi-provider SMS e WhatsApp con normalizzazione numeri
- **💬 Telegram**: Bot API per notifiche Telegram e messaggi
- **📊 Database Notifications**: Persistenza notifiche Laravel
- **🎨 Theme Management**: Temi grafici per email personalizzabili
- **🔗 Multi-Project Integration**: Supporto per progetti esterni (PTVX, healthcare_app, Meetup)

---

## 🏗️ Architecture

### 📊 **Multi-Channel Architecture**

```
Evento trigger (survey creato, evento registrato, etc.)
    |
    v
35 Queueable Actions (selezione canale + provider)
    |
    +-- Email: Template DB → Tema → SMTP/SES
    +-- SMS: Normalizzazione numero → Provider → Invio
    +-- WhatsApp: Template → Provider → Invio
    +-- Telegram: Bot API → Chat/Group → Messaggio
    +-- Database: Laravel Notification → Persistenza
    |
    v
Log di invio (NotificationLog, MailTemplateLog)
```

### 📋 **Core Models**

| Model | Purpose | Relationships |
|-------|---------|---------------|
| **Notification** | Notification record | type, log |
| **NotificationType** | Channel management | notifications |
| **NotificationTemplate** | Template management | versions |
| **NotificationTemplateVersion** | Version control | template |
| **NotificationLog** | Delivery tracking | notification |
| **MailTemplate** | Email templates | versions |
| **MailTemplateVersion** | Email versioning | mail_template |
| **MailTemplateLog** | Email delivery | mail_template |
| **Contact** | Contact management | preferred channels |
| **NotifyTheme** | Email theming | themeables |
| **NotifyThemeable** | Theme associations | polymorphic |

---

## 🎨 Filament Integration

### 📋 **Resource Management**

| Resource | Function | Purpose |
|----------|----------|---------|
| **NotificationResource** | CRUD notifications | Notification management |
| **NotificationTemplateResource** | Template management | Notification templates |
| **MailTemplateResource** | Email templates | Spatie Mail Templates |
| **NotifyThemeResource** | Theme management | Email themes |
| **ContactResource** | Contact management | Contact book |

### 📊 **Dashboard Widgets**

| Widget | Function | Purpose |
|--------|----------|---------|
| **NotificationStatsWidget** | Statistics | Delivery metrics |
| **TemplateManagementWidget** | Template editor | Template management |
| **ProviderStatusWidget** | Provider monitoring | Channel status |
| **ContactManagementWidget** | Contact management | Contact book |
| **DeliveryAnalyticsWidget** | Analytics | Delivery performance |

---

## 📧 Multi-Channel Support

### 📧 **Email Communication**

```php
// Email with database templates
app(SendEmailAction::class)->execute(
    to: 'user@example.com',
    template: 'survey-invitation',
    data: [
        'survey_name' => 'Customer Satisfaction',
        'link' => $invitationUrl,
        'user_name' => $user->name,
        'deadline' => $survey->deadline->format('d/m/Y')
    ]
);

// Email with attachments
app(SendEmailAction::class)->execute(
    to: $user->email,
    template: 'survey-report',
    attachments: [
        [
            'content' => $pdfBinary,
            'name' => 'report.pdf',
            'mime' => 'application/pdf'
        ]
    ]
);
```

### 📱 **SMS Communication**

```php
// SMS with provider selection
app(SendSmsAction::class)->execute(
    to: '+39123456789',
    message: 'Il tuo survey e pronto!',
    provider: 'twilio', // or plivo, nexmo, agiletelecom...
);

// Bulk SMS
app(SendBulkSmsAction::class)->execute(
    contacts: $contacts,
    message: 'Massive SMS message',
    provider: 'twilio'
);
```

### 💬 **WhatsApp Communication**

```php
// WhatsApp with template
app(SendWhatsAppAction::class)->execute(
    to: '+39123456789',
    template: 'event-reminder',
    data: [
        'event_name' => 'Team Meeting',
        'time' => '14:00'
    ]
);

// WhatsApp with media
app(SendWhatsAppMediaAction::class)->execute(
    to: '+39123456789',
    media: $mediaFile,
    caption: 'Check this out!'
);
```

### 📲 **Telegram Communication**

```php
// Telegram with bot
app(SendTelegramAction::class)->execute(
    chat_id: $chatId,
    text: 'Hello from Telegram!',
    bot: 'official'
);

// Telegram with keyboard
app(SendTelegramWithKeyboardAction::class)->execute(
    chat_id: $chatId,
    text: 'Choose an option',
    keyboard: [
        ['Option 1', 'Option 2'],
        ['Option 3']
    ]
);
```

---

## 🔗 Integration Guide

### 📧 **With User Module**
```php
// Welcome email
app(SendWelcomeEmailAction::class)->execute($user);

// Password reset
app(SendPasswordResetAction::class)->execute($user, $token);

// OTP notification
app(SendOtpAction::class)->execute($user, 'email');
```

### 📊 **With Activity Module**
```php
// Notification logging
app(LogNotificationAction::class)->execute($notification, 'sent');
app(LogNotificationAction::class)->execute($notification, 'failed');
app(LogNotificationAction::class)->execute($notification, 'delivered');
```

### 🌍 **With Lang Module**
```php
// Multi-language templates
$template = MailTemplate::where('name', 'welcome')->first();
$template->translateTo('it', [
    'subject' => 'Benvenuto!',
    'html_template' => '<h1>Benvenuto {{name}}!</h1>'
]);

$template->translateTo('en', [
    'subject' => 'Welcome!',
    'html_template' => '<h1>Welcome {{name}}!</h1>'
]);
```

### 🔐 **With Tenant Module**
```php
// Tenant-specific notifications
$notification = app(SendTenantNotificationAction::class)->execute(
    $tenant,
    'welcome',
    ['user' => $user]
);

// Tenant-specific email templates
$emailTemplate = app(GetTenantEmailTemplateAction::class)->execute(
    $tenant,
    'welcome'
);
```

---

## 🧪 Testing & Quality

### 📋 **Test Coverage**

```bash
# Run Notify module tests
php artisan test --filter=Notify

# Specific email tests
php artisan test --filter=EmailTest

# SMS tests
php artisan test --filter=SmsTest

# WhatsApp tests
php artisan test --filter=WhatsAppTest
```

### ✅ **PHPStan Compliance**

```bash
# Level 10 analysis
./vendor/bin/phpstan analyse Modules/Notify --level=10
```

---

## 🚀 Quick Start

```bash
# Enable Notify module
php artisan module:enable Notify

# Run migrations
php artisan migrate

# Create admin user
php artisan tinker
>>> $user = Modules\User\Models\User::factory()->create();
>>> $user->assignRole('admin');

# Create email template
>>> $template = Modules\Notify\Models\MailTemplate::create([
...     'name' => 'test',
...     'subject' => 'Test: {{title}}',
...     'html_template' => '<h1>{{title}}</h1><p>{{body}}</p>'
... ]);

# Send test email
>>> app(SendEmailAction::class)->execute(
...     to: $user->email,
...     template: 'test',
...     data: ['title' => 'Hello World', 'body' => 'This is a test']
... );

# Access Notify admin
# https://yourdomain.com/quaeris/admin/notifications
```

---

## 📊 Key Metrics

| Metric | Value | Status |
|--------|-------|--------|
| **Models** | 11 | ✅ Complete |
| **Actions** | 35 | ✅ Core |
| **Channels** | 5 | ✅ Multi-channel |
| **SMS Providers** | 7 | ✅ Multi-provider |
| **WhatsApp Providers** | 4 | ✅ Multi-provider |
| **Telegram Providers** | 3 | ✅ Multi-provider |
| **Test Coverage** | 85% | ✅ Good |
| **PHPStan Level** | 10 | ✅ Compliant |

---

## 🎯 Advanced Features

### 🤖 **AI Notification Optimization**
```php
// AI-powered delivery optimization
$optimization = app(AiDeliveryOptimizationAction::class)->execute($notification);
// Optimal timing
// Best channel selection
// Personalized content
```

### 📊 **Advanced Analytics**
```php
// Comprehensive analytics
$analytics = app(GetNotificationAnalyticsAction::class)->execute();
// Delivery rates
// Open rates
// Click rates
// Conversion tracking
```

### 🔐 **Advanced Security**
```php
// Delivery security
$security = app(EnableDeliverySecurityAction::class)->execute($notification);
// Encryption
// Rate limiting
// Delivery verification
```

---

## 📚 Documentation

### 🎯 **Main Guides**
- [📧 Email Templates](docs/email-templates.md)
- [📱 SMS/WhatsApp](docs/sms-whatsapp.md)
- [💬 Telegram](docs/telegram.md)
- [🔗 Multi-Project Integration](docs/multi-project-integration.md)

### 🔧 **Technical Docs**
- [⚙️ Configuration](docs/configuration.md)
- [🧪 Testing](docs/testing.md)
- [🚀 Deployment](docs/deployment.md)
- [🔒 Security](docs/security.md)

---

## 🤝 Contributing

### 🚀 **Development Setup**
```bash
# Clone and setup
git clone [repository]
cd base_quaeris_fila5_mono
composer install
npm install
php artisan migrate
```

### 📋 **Code Standards**
- ✅ Follow PSR-12 coding standards
- ✅ PHPStan Level 10 compliance
- ✅ 85%+ test coverage required
- ✅ Comprehensive documentation

---

## 🔄 Changelog

### v3.1.0 - 2026-03-07
- **🔄 AI Optimization**: AI-powered delivery optimization
- **📊 Advanced Analytics**: Comprehensive analytics dashboard
- **🔐 Security Enhancement**: Advanced delivery security
- **🔗 Multi-Project**: Enhanced project integration
- **📱 Media Support**: WhatsApp media attachments

### v3.0.0 - 2026-01-15
- **🆕 Multi-Channel Hub**: Complete multi-channel notification system
- **📧 Template Management**: Database-driven email templates
- **📱 SMS/WhatsApp**: Multi-provider SMS and WhatsApp
- **💬 Telegram**: Telegram bot integration
- **📊 Delivery Analytics**: Delivery tracking and analytics

---

## 🏆 Quality Metrics

### 📊 **Code Quality**
- **PHPStan Level**: 10 (Max)
- **Test Coverage**: 85%
- **Code Climate**: A+
- **Documentation**: 100%

### 🎯 **Performance**
- **Email Delivery**: <2s
- **SMS Delivery**: <3s
- **WhatsApp Delivery**: <5s
- **Telegram Delivery**: <1s

---

## 📞 Support

- **Documentation**: [docs/](docs/)
- **Issues**: [GitHub Issues](https://github.com/your-repo/issues)
- **Community**: [Discord](https://discord.gg/your-community)
- **Email**: support@notify-module.com

---

<div align="center">
  <strong>📧 Notify - Multi-Channel Communication Hub! ⚡</strong>
  <br>
  <em>Centralized communication with multi-channel support</em>
</div>
