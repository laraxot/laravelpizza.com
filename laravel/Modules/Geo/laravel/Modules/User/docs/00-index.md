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
- 🧷 **[Passport Model Wrappers](./passport-model-wrappers.md)** - Mappa obbligatoria tra model vendor Passport e wrapper `Oauth*` locali.
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
- 🚨 **[PHPStan Syntax Blockers 2026-03-10](./phpstan-syntax-blockers-2026-03-10.md)** - Severe syntax errors e merge marker da eliminare prima dell'analisi completa.
- 🧭 **[IDE Helper Models Wave 2026-03-10](./ide-helper-models-wave-2026-03-10.md)** - Distinzione tra errori sandbox e reali durante `php artisan ide-helper:models -W`.
- 🔬 **[Testing Identity](./testing.md)** - Test di autenticazione e autorizzazione (Pest).
- 🧬 **[Model Inheritance](./model-inheritance-rules.md)** - Regole per estendere il modello User.
- 🧪 **PSR-4 Test Helpers** - Nei test trait/helper preferire anonymous classes o fixture dedicate sotto `tests/` con percorso coerente PSR-4.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./todo.md)** - Strategia per gestire i 550+ documenti accumulati.

## 📦 **Pacchetti Composer**
- [Riferimento completo](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md)
- `laravel/passport` - OAuth2 API
- `socialiteproviders/microsoft`, `socialiteproviders/auth0` - OAuth
- `flowframe/laravel-trend` - Statistiche
- `jenssegers/agent` - User-Agent
- `spatie/laravel-personal-data-export` - Export GDPR

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/readme.md) - Core per la gestione dei trait `HasTeams`.
- [Tenant](../../tenant/docs/readme.md) - Risoluzione del Tenant corrente per l'utente.

---
# User Module Documentation Index

**Last Update**: 18 Dicembre 2025  
**Status**: ✅ PHPStan Level 10 Compliant  
**Module Version**: 1.0

## 📚 Quick Navigation

### 🎯 Essential Reading
1. [README.md](./README.md) - Overview completo del modulo
2. [phpstan-level-10-compliance.md](./phpstan-level-10-compliance.md) - Compliance status

### 🏗️ Architecture & Patterns
- [User Model Structure](./user-model-structure.md) - Struttura modello User
- [Authentication Flow](./authentication-flow.md) - Flusso autenticazione
- [Permission System](./permission-system.md) - Sistema permessi e ruoli
- [User Relationships](./user-relationships.md) - Relazioni con altri modelli

### 🧩 Core Components
- [User Model](../../app/Models/User.php) - Modello principale User
- [User Factory](../../database/factories/UserFactory.php) - Factory per test
- [User Seeder](../../database/seeders/UserSeeder.php) - Seeder dati iniziali

### 🔧 Implementation Guides
- [User Registration](./user-registration.md) - Processo registrazione utente
- [User Profile Management](./user-profile-management.md) - Gestione profilo
- [Password Management](./password-management.md) - Gestione password
- [Session Management](./session-management.md) - Gestione sessioni

### 🧪 Testing
- [Test Suite](../../tests/) - Suite di test per il modulo User
- [Feature Tests](../../tests/Feature/) - Test funzionali
- [Integration Tests](../../tests/Integration/) - Test di integrazione
- [Unit Tests](../../tests/Unit/) - Test unitari

### 🐛 Troubleshooting & Fixes
- [Common Issues](./common-issues.md) - Problemi comuni e soluzioni
- [Authentication Troubleshooting](./authentication-troubleshooting.md) - Debug autenticazione
- [LoginWidget Form Data Binding Fix](./login-widget-fix.md) - Fix per campi form non popolati
- [Login Issue Resolution](./login-issue-resolution-report.md) - Report tecnico risoluzione login
- [Livewire StatePath Issue](./livewire-form-statepath-issue.md) - Analisi problemi binding

### 📊 Code Quality
- [PHPStan Analysis](./phpstan-analysis.md) - PHPStan reports
- [Code Quality Metrics](./quality-metrics.md) - Metriche di qualità

### 🚀 Deployment
- [User Module Deployment](./deployment.md) - Linee guida per deploy
- [Environment Configuration](./environment-config.md) - Configurazione ambiente

## 📈 Module Statistics

- **Total Docs**: 8 files
- **PHPStan Compliance**: ✅ Level 10
- **Architecture**: XotBase compliant
- **Type Safety**: 100%

## 🔗 Related Modules

- [Xot](../../Xot/docs/README.md) - Core framework
- [Tenant](../../Tenant/docs/README.md) - Multi-tenancy support
- [Notify](../../Notify/docs/README.md) - Sistemi di notifica

## 🎯 Quick Start

1. Leggi [README.md](./README.md) per overview
2. Studia [user-model-structure.md](./user-model-structure.md)
3. Consulta [authentication-flow.md](./authentication-flow.md)
4. Verifica [phpstan-level-10-compliance.md](./phpstan-level-10-compliance.md)

---

*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)