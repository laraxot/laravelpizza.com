# 📚 **Indice Documentazione Modulo Notify**

**Last Update**: 31 Gennaio 2026
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.1.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica completa e Quick Start.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Multi-channel API e AI Templates.
3. [philosophy.md](./philosophy.md) - "Essere Connessi": filosofia delle notifiche in tempo reale.

## 🏗️ **Architettura & Canali**
- 📧 **[Email System](./email-templates.md)** - Gestione template dinamici e stagionali (Spatie integration).
- 💬 **[SMS & WhatsApp](./whatsapp-integration.md)** - Integrazione con NetFun e altri provider.
- 🚀 **[Bulk Notifications](./send-notification-bulk-action.md)** - Azioni massive per migliaia di utenti.
- 🧱 **[Base Templates](./base-templates.md)** - Struttura HTML responsive per messaggi transazionali.

## ⚙️ **Configurazione Avanzata**
- 🛠️ **[Channel Provider](./provider-actions-architecture.md)** - Come estendere il modulo con nuovi driver.
- 🏷️ **[Acronym Naming](./acronym-naming-conventions.md)** - Standard per la denominazione dei driver e canali.
- 🔄 **[Queue Management](./monitoring.md)** - Monitoraggio delle code e dei fallback.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-fixes.md)** - Report di conformità Level 10.
- 🔬 **[Testing Guidelines](./testing.md)** - Mocking dei canali e verifica invio.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./translation-cleanup-plan.md)** - Rimozione dei 500+ file obsoleti accumulati.
- 🛡️ **[Security Analysis](./security-analysis.md)** - Protezione dei webhook dei provider (es. WhatsApp).

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Dispatcher centrale.
- [User](../../User/docs/README.md) - Definizione dei destinatari e preferenze.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*