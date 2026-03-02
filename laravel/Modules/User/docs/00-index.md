# 📚 **Indice Documentazione Modulo User**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.5.0

## 🎯 **Lettura Essenziale**
1. [README.md](./readme.md) - Panoramica completa del sistema di identità.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Biometric Auth & AI Moderation.
3. [philosophy.md](./philosophy.md) - "Essere Unici": la gestione dell'identità digitale.

## 🏗️ **Architettura & Auth**
- 🔐 **[Authentication Flow](./authentication.md)** - Dettagli sul ciclo di vita della sessione.
- 📜 **[Permissions System](./permissions.md)** - Gestione ruoli e permessi con Spatie.
- 🎫 **[Passport & SSO](./passport-integration.md)** - Integrazione OAuth2 e Single Sign-On.
- 🛡️ **[2FA Guide](./2fa-guide.md)** - Implementazione dell'autenticazione a due fattori.

## 👤 **Profilo & Moderazione**
- 🧑‍🎨 **[Profile Management](./profile-management.md)** - Gestione estesa dei dati utente (EAV).
- ⚖️ **[Moderation Strategy](./user-moderation-strategy.md)** - Workflow per approvazione e ban (dentisti, cliniche, utenti).
- 🧬 **[BaseUser Architecture](./baseuser.md)** - La classe base che unifica l'identità nel sistema.

## ⚙️ **Integrazioni Filament**
- 🏗️ **[Filament Resources](./filament-resources-updated.md)** - Gestione utenti, ruoli e permessi in v5.
- 🔑 **[Passport Cluster](./passport-cluster-summary.md)** - Gestione centralizzata delle chiavi API.
- ⚡ **[Auth Widgets](./login-widget-fix.md)** - Componenti di login/registrazione riutilizzabili.
- 🔐 **[Socialite + Microsoft OAuth](./socialite-microsoft-integration.md)** - Integrazione autenticazione Microsoft (NEW)

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-level10-user-fixes.md)** - Report di conformità Level 10.
- 🔬 **[Testing Identity](./testing.md)** - Test di autenticazione e autorizzazione (Pest).
- 🧬 **[Model Inheritance](./model-inheritance-rules.md)** - Regole per estendere il modello User.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./todo.md)** - Strategia per gestire i 550+ documenti accumulati.

## 📦 **Pacchetti Composer**
- [Riferimento completo](../../../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../../../docs/architecture/composer-packages-full-inventory.md)
- `laravel/passport` - OAuth2 API
- `socialiteproviders/microsoft`, `socialiteproviders/auth0` - OAuth
- `flowframe/laravel-trend` - Statistiche
- `jenssegers/agent` - User-Agent
- `spatie/laravel-personal-data-export` - Export GDPR

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/readme.md) - Core per la gestione dei trait `HasTeams`.
- [Tenant](../../tenant/docs/readme.md) - Risoluzione del Tenant corrente per l'utente.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
