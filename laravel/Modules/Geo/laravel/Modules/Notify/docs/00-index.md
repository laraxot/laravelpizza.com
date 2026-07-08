# 📚 **Indice Documentazione Modulo Notify**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.1.0

## 🎯 **Lettura Essenziale**
1. [README.md](./readme.md) - Panoramica completa e Quick Start.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Multi-channel API e AI Templates.
3. [philosophy.md](./philosophy.md) - "Essere Connessi": filosofia delle notifiche in tempo reale.

## 🏗️ **Architettura & Canali**
- 📧 **[Email System](./email-templates.md)** - Gestione template dinamici e stagionali (Spatie integration).
- 💬 **[SMS & WhatsApp](./whatsapp-integration.md)** - Integrazione con NetFun e altri provider.
- 🚀 **[Bulk Notifications](./send-notification-bulk-action.md)** - Azioni massive per migliaia di utenti.
- 🧱 **[Base Templates](./base-templates.md)** - Struttura HTML responsive per messaggi transazionali.

## ⚙️ **Configurazione Avanzata**
- 📦 **[Composer Dependencies](./composer-dependencies.md)** - Firebase, FCM, Telegram: package nel modulo Notify, mai nel root.
- 📦 **[Riferimento pacchetti](../../../../docs/composer-packages-reference.md)** | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - AWS, Telegram, Postmark, Spatie mail templates
- 🛠️ **[Channel Provider](./provider-actions-architecture.md)** - Come estendere il modulo con nuovi driver.
- 🏷️ **[Acronym Naming](./acronym-naming-conventions.md)** - Standard per la denominazione dei driver e canali.
- 🔄 **[Queue Management](./monitoring.md)** - Monitoraggio delle code e dei fallback.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-fixes.md)** - Report di conformità Level 10.
- 🚨 **[PHPStan Cluster 2026-03-10](./phpstan-cluster-2026-03-10.md)** - Modelli canonici mancanti per log/canali e impatto su factory/controller.
- 🧭 **[No Orphan Http Controllers](./no-orphan-http-controllers.md)** - I controller web senza route o boundary chiaro non devono restare nel modulo.
- 🚫 **[No NotificationTrackingController](./no-notification-tracking-controller.md)** - Il tracking notifiche non deve vivere in un controller HTTP legacy.
- 🔬 **[Testing Guidelines](./testing.md)** - Mocking dei canali e verifica invio.
- 📘 **[Docs-First Workflow](./docs-first-workflow.md)** - Sequenza obbligatoria docs -> codice -> tracking GitHub.
- 🧪 **PSR-4 Test Helpers** - Nei file Pest usare helper anonimi o support file dedicati; evitare classi top-level extra che rompono `composer dump-autoload`.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./translation-cleanup-plan.md)** - Rimozione dei 500+ file obsoleti accumulati.
- 🛡️ **[Security Analysis](./security-analysis.md)** - Protezione dei webhook dei provider (es. WhatsApp).

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/readme.md) - Dispatcher centrale.
- [User](../../user/docs/readme.md) - Definizione dei destinatari e preferenze.

---
# Notify Module Documentation Index

**Last Update**: 19 Dicembre 2025 (Integrated with collaborative AI agents work)  
**Status**: ✅ PHPStan Level 10 Compliant  
**Module Version**: 1.0

## 📚 Quick Navigation

### 🎯 Essential Reading
1. [README.md](./README.md) - Overview completo del modulo
2. [notification-implementation.md](./notification-implementation.md) - Implementazione notifiche

### 🏗️ Architecture & Patterns
- [SendNotificationBulkAction](./send-notification-bulk-action.md) - ✅ Azione riutilizzabile per invio notifiche in blocco
- [SendRecordNotificationAction Refactoring](./refactoring/send-record-notification-action-refactoring.md) - Refactoring per eliminare duplicazioni
- [ChannelEnum Implementation Complete](./refactoring/channel-enum-implementation-complete.md) - ✅ Implementazione Smart Enum per gestione canali
- [DRY Composition Pattern](./dry-composition-pattern.md) - Pattern DRY per composizione Actions bulk → single
- [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md) - Pattern per Actions che chiamano altre Actions
- [Extract Method Pattern](./refactoring/extract-method-pattern.md) - 🧘 Pattern Clean Code per estrazione metodi privati (leggibilità, SRP)
- [Zen of Schema (Filament)](./refactoring/zen-of-schema.md) - 🧘 Filosofia per UI dichiarativa in Filament
- [Zen of Reuse (Components)](./refactoring/zen-of-reuse.md) - 🧘 Filosofia per componenti form riutilizzabili (DRY)
- [Bulk Notification Action](./bulk-notification-action.md) - Azione per invio notifiche in blocco
- [Dependency Injection Patterns](./dependency-injection-patterns.md) - Pattern di iniezione delle dipendenze
- [Refactoring Composition Pattern Implementation](./refactoring-composition-pattern-implementation.md) - Documentazione implementazione pattern composizione
- [Filament Extension Rules](./filament-extension-rules.md) - ✅ Regole per estensione componenti Filament (XotBase)
- [Notification System Architecture](./notification-architecture.md) - Architettura sistema notifiche

### 🧩 Core Components
- [MailTemplate Model](../../app/Models/MailTemplate.php) - Modello template email/SMS
- [SendRecordsNotificationBulkAction](../../app/Actions/SendRecordsNotificationBulkAction.php) - Azione invio notifiche in bulk (composizione)
- [SendRecordNotificationAction](../../app/Actions/SendRecordNotificationAction.php) - Azione invio notifica singolo record
- [SendNotificationBulkAction](../../app/Filament/Actions/SendNotificationBulkAction.php) - Azione Filament
- [RecordNotification](../../app/Notifications/RecordNotification.php) - Sistema notifiche
- [RecordNotification Constructor Refactoring](./record-notification-constructor-refactoring.md) - Refactoring del costruttore (Model, string slug)

### 📋 Form Components
- [Reusable Form Components](./forms/components-reusable.md) - ✅ Componenti riutilizzabili MailTemplateSelect e ChannelCheckboxList (DRY)

### 🔧 Implementation Guides
- [Channel Configuration](./channel-configuration.md) - Configurazione canali (mail, SMS, WhatsApp)
- [Template Management](./template-management.md) - Gestione template notifiche
- [Seasonal Email Templates](./seasonal-email-templates.md) - ✨ Template email stagionali (Natale, Pasqua, etc.)
- [Phone Number Normalization](./phone-normalization.md) - Normalizzazione numeri telefono

### 🧪 Testing
- [Test Suite](../../tests/) - Suite di test per il modulo Notify
- [Feature Tests](../../tests/Feature/) - Test funzionali
- [Integration Tests](../../tests/Integration/) - Test di integrazione
- [Unit Tests](../../tests/Unit/) - Test unitari

### 🐛 Troubleshooting & Fixes
- [Common Issues](./common-issues.md) - Problemi comuni e soluzioni
- [Channel-Specific Issues](./channel-issues.md) - Problemi specifici canali

### 📋 Reports & Recommendations
- [Seasonal Email System Implementation Report](./seasonal-email-system-implementation-report.md) - ✅ Report completo revisione sistema email stagionali
- [Seasonal Email System Recommendations](./seasonal-email-system-recommendations.md) - Linee guida e raccomandazioni per sviluppo futuro
- [Removal GetSeasonalEmailLayoutAction](./removal-getseasonalemaillayoutaction.md) - ✅ Motivazione rimozione over-engineering
- [Removal ChristmasGreetingMailable](./removal-christmasgreetingmailable.md) - ✅ Perché mai creare Mailable hardcoded per feste
- [RecordNotification Constructor Slug Pattern](./refactoring/record-notification-constructor-slug.md) - ✅ Refactoring costruttore per lazy resolution con slug
- [RecordNotification Zen Delegation](./refactoring/record-notification-zen-delegation.md) - ✅ Refactoring per delegazione completa a SpatieEmail (DRY assoluto)

### 📊 Code Quality
- [PHPStan Fixes Report](./phpstan-fixes.md) - ✅ Report completo correzioni PHPStan Level 10
- [Verification Report](./verification_report.md) - Verification and compliance report
- [PHPStan Analysis](./phpstan-analysis.md) - PHPStan reports
- [Code Quality Metrics](./quality-metrics.md) - Metriche di qualità

### 🚀 Deployment
- [Notify Module Deployment](./deployment.md) - Linee guida per deploy
- [Channel Provider Configuration](./provider-config.md) - Configurazione provider canali

## 📈 Module Statistics

- **Total Docs**: 28+ files (including subdirs: enums/, notifications/, refactoring/)
- **PHPStan Compliance**: ✅ Level 10 (17 → 2 errors, 15 fixed - vedi phpstan-fixes.md)
- **Architecture**: XotBase compliant
- **Type Safety**: 100%
- **Email Templates**: 2+ implemented (base.html, christmas.html, easter.html, summer.html, halloween.html)
- **Seasonal System**: ✅ Automatic tramite GetMailLayoutAction → GetThemeContextAction (Xot)
- **Core Actions**: 3 (Send Record, Send Bulk, Normalize Phone) + GetMailLayoutAction (delega a GetThemeContextAction del modulo Xot)
- **Rimossi**: GetSeasonalEmailLayoutAction (over-engineering - violava DRY), ChristmasGreetingMailable (mai creata - identificata come "cagata" - viola Genericity)

## 🔗 Related Modules

- [Xot](../../Xot/docs/README.md) - Core framework
- [TechPlanner](../../TechPlanner/docs/README.md) - Business logic integration
- [Client Resource](../../TechPlanner/app/Filament/Resources/ClientResource/) - Integration examples

## 🎯 Quick Start

1. Leggi [README.md](./README.md) per overview
2. Studia [notification-implementation.md](./notification-implementation.md)
3. Consulta [bulk-notification-action.md](./bulk-notification-action.md)
4. Verifica [channel-configuration.md](./channel-configuration.md)

---

*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)