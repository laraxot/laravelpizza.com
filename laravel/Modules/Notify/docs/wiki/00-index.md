---
title: "Notify Module: Document"
type: docs/bmad
module: Notify
scope: documentation
bmad_version: 1.0
<<<<<<< HEAD
<<<<<<< .merge_file_yB5WGx
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_bYszQ2
updated: 2026-10-06
status: stale
tags: [docs, notify, wiki]
qmd: "**indice documentazione modulo notify** notify"
=======
<<<<<<< .merge_file_yB5WGx
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_bYszQ2
updated: 2026-11-23
status: stale
tags: [docs, notify, wiki]
qmd: "**indice documentazione modulo notify** notify"
created: 2026-11-23
<<<<<<< .merge_file_yB5WGx
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_bYszQ2
>>>>>>> laraxot/dev
---

> Nota 2026-10-14 (docs-audit): Variante di maiuscole di wiki/00-index.md, stesso testo; l'indice operativo e' ../00-index.md. Contenuto non riscritto, verificare prima di usarlo.

# 📚 **Indice Documentazione Modulo Notify**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.1.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica completa e Quick Start.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Multi-channel API e AI Templates.
3. [philosophy-3.md](../../../Lang/docs/philosophy-3.md) - "Essere Connessi": filosofia delle notifiche in tempo reale.

## 🏗️ **Architettura & Canali**
- 📧 **[Email System](../email-templates-2.md)** - Gestione template dinamici e stagionali (Spatie integration).
- 💬 **[SMS & WhatsApp](../whatsapp-integration-2.md)** - Integrazione con NetFun e altri provider.
- 🚀 **[Bulk Notifications](./send-notification-bulk-action.md)** - Azioni massive per migliaia di utenti.
- 🧱 **[Base Templates](../base-templates-2.md)** - Struttura HTML responsive per messaggi transazionali.

## ⚙️ **Configurazione Avanzata**
- 📦 **[Composer Dependencies](../composer-dependencies.md)** - Firebase, FCM, Telegram: package nel modulo Notify, mai nel root.
- 📦 **[Riferimento pacchetti](../../../../docs/composer-packages-reference.md)** | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - AWS, Telegram, Postmark, Spatie mail templates
- 🛠️ **[Channel Provider](../provider-actions-architecture-2.md)** - Come estendere il modulo con nuovi driver.
- 🏷️ **[Acronym Naming](../acronym-naming-conventions-2.md)** - Standard per la denominazione dei driver e canali.
<<<<<<< HEAD
<<<<<<< .merge_file_yB5WGx
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< .merge_file_K8DfDX
>>>>>>> laraxot/dev
=======
=======
<<<<<<< .merge_file_K8DfDX
>>>>>>> .merge_file_bYszQ2
- 🔄 **[Queue Management](./monitoring.md)** - Monitoraggio delle code e dei fallback.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-fixes.md)** - Report di conformità Level 10.
- 🚨 **[PHPStan Cluster 2026-03-10](./phpstan-cluster-2026-03-10.md)** - Modelli canonici mancanti per log/canali e impatto su factory/controller.
- 🧭 **[No Orphan Http Controllers](./no-orphan-http-controllers.md)** - I controller web senza route o boundary chiaro non devono restare nel modulo.
- 🚫 **[No NotificationTrackingController](./no-notification-tracking-controller.md)** - Il tracking notifiche non deve vivere in un controller HTTP legacy.
- 🧹 **[PHPStan cleanup Notify 2026-10-06](../stories/2026-10-06-phpstan-cleanup-notify.dev.md)** - NotificationLog ripristinato + enum, stub push, pagine Test Filament ([story](../stories/2026-10-06-phpstan-cleanup-notify.story.md)).
=======
<<<<<<< .merge_file_yB5WGx
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_bYszQ2
>>>>>>> laraxot/dev
- 🔄 **[Queue Management](../monitoring.md)** - Monitoraggio delle code e dei fallback.
- 📧 **[Email System](../email-templates.md)** - Gestione template dinamici e stagionali (Spatie integration).
- 💬 **[SMS & WhatsApp](../whatsapp-integration-2.md)** - Integrazione con NetFun e altri provider.
- 🚀 **[Bulk Notifications](./send-notification-bulk-action.md)** - Azioni massive per migliaia di utenti.
- 🧱 **[Base Templates](../base-templates.md)** - Struttura HTML responsive per messaggi transazionali.

## ⚙️ **Configurazione Avanzata**
- 📦 **[Composer Dependencies](../composer-dependencies.md)** - Firebase, FCM, Telegram: package nel modulo Notify, mai nel root.
- 📦 **[Riferimento pacchetti](../../../../docs/composer-packages-reference.md)** | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - AWS, Telegram, Postmark, Spatie mail templates
- 🛠️ **[Channel Provider](../provider-actions-architecture.md)** - Come estendere il modulo con nuovi driver.
- 🏷️ **[Acronym Naming](../acronym-naming-conventions-2.md)** - Standard per la denominazione dei driver e canali.
- 🔄 **[Queue Management](../monitoring.md)** - Monitoraggio delle code e dei fallback.

## 🧪 **Qualità e Sviluppo**
<<<<<<< HEAD
<<<<<<< .merge_file_yB5WGx
- ✅ **[PHPStan Analysis](../phpstan-fixes.md)** - Report di conformità Level 10.
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_bYszQ2
- ✅ **[PHPStan Analysis](../phpstan-fixes.md)** - Report di conformità Level 10.
=======
<<<<<<< HEAD
- ✅ **[PHPStan Analysis](../phpstan-fixes.md)** - Report di conformità Level 10.
=======
- ✅ **[PHPStan Analysis](../phpstan-fixes.md)** - Report di conformità Level 10.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_yB5WGx
=======
- ✅ **[PHPStan Analysis](../phpstan-fixes.md)** - Report di conformità Level 10.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_bYszQ2
- 🚨 **[PHPStan Cluster 2026-03-10](../phpstan-cluster.md)** - Modelli canonici mancanti per log/canali e impatto su factory/controller.
- 🧭 **[No Orphan Http Controllers](../no-orphan-http-controllers.md)** - I controller web senza route o boundary chiaro non devono restare nel modulo.
- 🚫 **[No NotificationTrackingController](../no-notification-tracking-controller.md)** - Il tracking notifiche non deve vivere in un controller HTTP legacy.
- 🧹 **[PHPStan cleanup Notify 2026-10-06](../stories/phpstan-cleanup-notify.dev.md)** - NotificationLog ripristinato + enum, stub push, pagine Test Filament ([story](../stories/phpstan-cleanup-notify.story.md)).
<<<<<<< HEAD
=======
<<<<<<< .merge_file_yB5WGx
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_bwW5Gg
>>>>>>> laraxot/dev
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_bwW5Gg
>>>>>>> laraxot/dev
>>>>>>> .merge_file_bYszQ2
- 🧹 **[PHPStan Notify push delivery 2026-10-08](../stories/2026-10-08-phpstan-notify-push-delivery.story.md)** - Tre copie del recapito push ridotte alle Action `Actions/Push/*` (il facade residuo e' stato poi eliminato).
- 🧹 **[Notify senza Services 2026-10-08](../stories/services-to-actions-notify.story.md)** - `app/Services` eliminata (test sulle Action), `STATUS_*` -> `NotificationLogStatusEnum`, consegne push simulate tracciate.
- 🔬 **[Testing Guidelines](./testing.md)** - Mocking dei canali e verifica invio.
- 📘 **[Docs-First Workflow](../docs-first-workflow.md)** - Sequenza obbligatoria docs -> codice -> tracking GitHub.
- 🧪 **PSR-4 Test Helpers** - Nei file Pest usare helper anonimi o support file dedicati; evitare classi top-level extra che rompono `composer dump-autoload`.

## 🪮 **Ponytail audit**
<<<<<<< HEAD
- 📋 **[Over-engineering audit](../ponytail-audit-over-engineering.md)** - SMS multi-driver, policy stub, remediation `.bak`.
- 🧾 **[SMS Actions consolidation decision](./decisions/sms-actions-consolidation.md)** - Cosa è stato consolidato in `.bak`, cosa resta attivo (netfun/smsfactor raggiungibili da Filament `SendSmsPage`) e perché.
=======
<<<<<<< .merge_file_yB5WGx
<<<<<<< HEAD
<<<<<<< HEAD
- 📋 **[Over-engineering audit](../ponytail-audit-over-engineering.md)** - SMS multi-driver, policy stub, remediation `.bak`.
- 🧾 **[SMS Actions consolidation decision](./decisions/sms-actions-consolidation.md)** - Cosa è stato consolidato in `.bak`, cosa resta attivo (netfun/smsfactor raggiungibili da Filament `SendSmsPage`) e perché.
=======
=======
>>>>>>> .merge_file_bYszQ2
<<<<<<< .merge_file_K8DfDX
- 📋 **[Over-engineering audit](./ponytail-audit-over-engineering.md)** - SMS multi-driver, policy stub, remediation `.bak`.
- 🧾 **[SMS Actions consolidation decision](./wiki/decisions/sms-actions-consolidation-2026-06-30.md)** - Cosa è stato consolidato in `.bak`, cosa resta attivo (netfun/smsfactor raggiungibili da Filament `SendSmsPage`) e perché.
=======
- 📋 **[Over-engineering audit](../ponytail-audit-over-engineering.md)** - SMS multi-driver, policy stub, remediation `.bak`.
<<<<<<< .merge_file_yB5WGx
- 🧾 **[SMS Actions consolidation decision](./decisions/sms-actions-consolidation.md)** - Cosa è stato consolidato in `.bak`, cosa resta attivo (netfun/smsfactor raggiungibili da Filament `SendSmsPage`) e perché.
>>>>>>> .merge_file_bwW5Gg
>>>>>>> laraxot/dev
=======
- 📋 **[Over-engineering audit](../ponytail-audit-over-engineering.md)** - SMS multi-driver, policy stub, remediation `.bak`.
- 🧾 **[SMS Actions consolidation decision](./decisions/sms-actions-consolidation.md)** - Cosa è stato consolidato in `.bak`, cosa resta attivo (netfun/smsfactor raggiungibili da Filament `SendSmsPage`) e perché.
>>>>>>> laraxot/dev
=======
- 🧾 **[SMS Actions consolidation decision](./decisions/sms-actions-consolidation.md)** - Cosa è stato consolidato in `.bak`, cosa resta attivo (netfun/smsfactor raggiungibili da Filament `SendSmsPage`) e perché.
>>>>>>> .merge_file_bwW5Gg
>>>>>>> .merge_file_bYszQ2
>>>>>>> laraxot/dev

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](../translation-cleanup-plan-2.md)** - Rimozione dei 500+ file obsoleti accumulati.
- 🛡️ **[Security Analysis](../security-analysis-2.md)** - Protezione dei webhook dei provider (es. WhatsApp).

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/README.md) - Dispatcher centrale.
- [User](../../user/docs/README.md) - Definizione dei destinatari e preferenze.
- 🧭 **[No Orphan Http Controllers](../no-orphan-http-controllers.md)** - I controller web senza route o boundary chiaro non devono restare nel modulo.
- 🚫 **[No NotificationTrackingController](../no-notification-tracking-controller.md)** - Il tracking notifiche non deve vivere in un controller HTTP legacy.
- 🧹 **[PHPStan cleanup Notify 2026-10-06](../stories/phpstan-cleanup-notify.dev.md)** - NotificationLog ripristinato + enum, stub push, pagine Test Filament ([story](../stories/phpstan-cleanup-notify.story.md)).
- 🧹 **[PHPStan Notify push delivery 2026-10-08](../stories/phpstan-notify-push-delivery.story.md)** - Tre copie del recapito push ridotte alle Action `Actions/Push/*` (il facade residuo e' stato poi eliminato).
- 🧹 **[Notify senza Services 2026-10-08](../stories/services-to-actions-notify.story.md)** - `app/Services` eliminata (test sulle Action), `STATUS_*` -> `NotificationLogStatusEnum`, consegne push simulate tracciate.
- 🔬 **[Testing Guidelines](./testing.md)** - Mocking dei canali e verifica invio.
- 📘 **[Docs-First Workflow](../docs-first-workflow.md)** - Sequenza obbligatoria docs -> codice -> tracking GitHub.
- 🧪 **PSR-4 Test Helpers** - Nei file Pest usare helper anonimi o support file dedicati; evitare classi top-level extra che rompono `composer dump-autoload`.

## 🪮 **Ponytail audit**
- 📋 **[Over-engineering audit](../ponytail-audit-over-engineering.md)** - SMS multi-driver, policy stub, remediation `.bak`.
- 🧾 **[SMS Actions consolidation decision](./decisions/sms-actions-consolidation-consolidamento-contracts-ponytail-audit.md)** - Cosa è stato consolidato in `.bak`, cosa resta attivo (netfun/smsfactor raggiungibili da Filament `SendSmsPage`) e perché.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](../translation-cleanup-plan.md)** - Rimozione dei 500+ file obsoleti accumulati.
- 🛡️ **[Security Analysis](../security-analysis.md)** - Protezione dei webhook dei provider (es. WhatsApp).

## 🔗 **Moduli Correlati**
- [Xot](../../../Xot/docs/README.md) - Dispatcher centrale.
- [User](../../../User/docs/README.md) - Definizione dei destinatari e preferenze.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

<<<<<<< HEAD
- [Dependency intelligence](../dependency-intelligence.md)
- [Dependency intelligence](../dependency-intelligence.md)
=======
<<<<<<< .merge_file_yB5WGx
<<<<<<< HEAD
<<<<<<< HEAD
- [Dependency intelligence](../dependency-intelligence.md)
- [Dependency intelligence](../dependency-intelligence.md)
=======
=======
>>>>>>> .merge_file_bYszQ2
<<<<<<< .merge_file_K8DfDX
- [Dependency intelligence](dependency-intelligence.md)
=======
- [Dependency intelligence](../dependency-intelligence.md)
<<<<<<< .merge_file_yB5WGx
- [Dependency intelligence](../dependency-intelligence.md)
>>>>>>> .merge_file_bwW5Gg
>>>>>>> laraxot/dev
=======
- [Dependency intelligence](../dependency-intelligence.md)
>>>>>>> laraxot/dev
=======
- [Dependency intelligence](../dependency-intelligence.md)
>>>>>>> .merge_file_bwW5Gg
>>>>>>> .merge_file_bYszQ2
>>>>>>> laraxot/dev
