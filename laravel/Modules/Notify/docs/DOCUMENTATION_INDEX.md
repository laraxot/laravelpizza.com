# 📚 Indice Generale Documentazione - Fixcity

> **Navigazione Completa della Documentazione del Progetto**

## 🎯 Quick Access

| Categoria | Link Rapidi |
|-----------|-------------|
| **Panoramica** | [Overview](#overview) • [Architettura](#architettura) • [Get Started](#quick-start) |
| **Moduli** | [Core](#moduli-core) • [Business](#moduli-business) • [Utility](#moduli-utility) |
| **Temi** | [Sixteen](#theme-sixteen) • [TwentyOne](#theme-twentyone) • [One](#theme-one) |
| **Guide** | [Development](#guide-sviluppo) • [Testing](#testing) • [Deploy](#deployment) |

---

## 📖 Overview

### Documentazione Principale
- [README Principale](./README.md) - Panoramica progetto completa
- [Analisi Super Mucca](./SUPER_MUCCA_DOCS_ANALYSIS.md) - Report qualità documentazione
- [Architecture](./ARCHITECTURE_ANALYSIS.md) - Analisi architetturale
- [Roadmap](./MASTER_ROADMAP_2025.md) - Piano sviluppo 2025

### Guide Rapide
- [Quick Start](./QUICK_START.md) - Guida avvio rapido
- [Contributing](./CONTRIBUTING.md) - Come contribuire
- [Troubleshooting](./troubleshooting/README.md) - Risoluzione problemi

---

## 🏗️ Architettura

### Documentazione Architetturale
- [Design Patterns](./architecture.md) - Pattern architetturali
- [Database Schema](./database/schema.md) - Schema database
- [API Documentation](./api/README.md) - Documentazione API
- [Security](./security/README.md) - Sicurezza e conformità

### Best Practices
- [Coding Standards](./standards/coding-standards.md) - Standard codifica
- [PHPStan Guidelines](./phpstan/README.md) - Analisi statica
- [Testing Standards](./testing/README.md) - Standard testing
- [Translation Guidelines](./translations/README.md) - Gestione traduzioni

---

## 📦 Moduli

### Moduli Core

#### **Xot Module** - Base Framework
- [README](../laravel/Modules/Xot/docs/README.md) - Panoramica modulo base
- File docs: 395 files
- **Funzionalità**: Framework base, utilities, base classes
- **Status**: ✅ Eccellente (PHPStan Level 9)

#### **User Module** - Gestione Utenti
- [README](../laravel/Modules/User/docs/README.md) - Sistema autenticazione
- File docs: 421 files
- **Funzionalità**: Autenticazione, autorizzazione, profili
- **Status**: ✅ Eccellente (Multi-tenancy)

#### **Lang Module** - Internazionalizzazione
- [README](../laravel/Modules/Lang/docs/README.md) - Sistema traduzioni
- File docs: 279 files
- **Funzionalità**: Traduzioni, localizzazione, multi-lingua
- **Status**: ✅ Eccellente (IT/EN/DE)

### Moduli Business

#### **Fixcity Module** - Ticketing System
- [README](../laravel/Modules/Fixcity/docs/README.md) - Gestione ticket
- File docs: 38 files
- **Funzionalità**: Ticket, segnalazioni, supporto
- **Status**: ✅ Operativo (Filament 4.x)

#### **Notify Module** - Notifiche
- [README](../laravel/Modules/Notify/docs/README.md) - Sistema notifiche
- File docs: 605 files
- **Funzionalità**: Email, SMS, push notifications
- **Status**: ✅ Eccellente (Multi-channel)

#### **Blog Module** - Content Management
- [README](../laravel/Modules/Blog/docs/README.md) - Gestione contenuti
- File docs: 34 files
- **Funzionalità**: Articoli, categorie, commenti
- **Status**: ✅ Operativo (Visual editor)

### Moduli Utility

#### **Cms Module** - CMS System
- [README](../laravel/Modules/Cms/docs/README.md) - Content Management
- File docs: 247 files
- **Funzionalità**: Pagine, blocchi, Folio integration
- **Status**: ✅ Eccellente (Filament Blocks)

#### **UI Module** - Componenti UI
- [README](../laravel/Modules/UI/docs/README.md) - Libreria componenti
- File docs: 273 files
- **Funzionalità**: Blade components, widgets, themes
- **Status**: ✅ Eccellente (Bootstrap Italia)

#### **Media Module** - Gestione Media
- [README](../laravel/Modules/Media/docs/README.md) - Storage e processing
- File docs: 128 files
- **Funzionalità**: Upload, storage, image processing
- **Status**: ✅ Operativo (AWS S3)

#### **Geo Module** - Dati Geografici
- [README](../laravel/Modules/Geo/docs/README.md) - Geolocalizzazione
- File docs: 223 files
- **Funzionalità**: Indirizzi, geocoding, mappe
- **Status**: ✅ Operativo (Google Maps, Mapbox)

#### **Activity Module** - Audit Trail
- [README](../laravel/Modules/Activity/docs/README.md) - Logging attività
- File docs: 86 files
- **Funzionalità**: Audit log, event sourcing, analytics
- **Status**: ✅ Eccellente (PHPStan Level 9)

#### **Gdpr Module** - GDPR Compliance
- [README](../laravel/Modules/Gdpr/docs/README.md) - Conformità GDPR
- File docs: 79 files
- **Funzionalità**: Consensi, trattamenti, privacy
- **Status**: ✅ Operativo (EU compliant)

#### **Tenant Module** - Multi-tenancy
- [README](../laravel/Modules/Tenant/docs/README.md) - Multi-tenant
- File docs: 57 files
- **Funzionalità**: Tenant isolation, database separation
- **Status**: ✅ Operativo

#### **Job Module** - Queue Management
- [README](../laravel/Modules/Job/docs/README.md) - Gestione code
- File docs: 83 files
- **Funzionalità**: Jobs, queues, scheduling
- **Status**: ✅ Operativo

#### **AI Module** - Integrazione AI
- [README](../laravel/Modules/AI/docs/README.md) - MCP e AI
- File docs: 34 files
- **Funzionalità**: MCP protocol, AI chat, fine tuning
- **Status**: ✅ Operativo (MCP servers)

#### **Seo Module** - SEO Optimization
- [README](../laravel/Modules/Seo/docs/README.md) - Ottimizzazione SEO
- File docs: 21 files
- **Funzionalità**: Meta tags, sitemap, structured data
- **Status**: ✅ Operativo

#### **Comment Module** - Sistema Commenti
- [README](../laravel/Modules/Comment/docs/README.md) - Gestione commenti
- File docs: 9 files
- **Funzionalità**: Commenti, threading, moderazione
- **Status**: ✅ Operativo

#### **Rating Module** - Sistema Valutazioni
- [README](../laravel/Modules/Rating/docs/README.md) - Valutazioni e recensioni
- File docs: 13 files
- **Funzionalità**: Rating, reviews, feedback
- **Status**: ✅ Operativo

---

## 🎨 Temi

### Theme Sixteen - Design Comuni Italia
- [README](../laravel/Themes/Sixteen/docs/README.md) - Tema principale AGID
- **Funzionalità**: Bootstrap Italia, WCAG 2.1, Design Comuni
- **Status**: ✅ Eccellente (AGID compliant)
- **Componenti**: 100+ componenti certificati

### Theme TwentyOne - Modern Design
- [README](../laravel/Themes/TwentyOne/docs/README.md) - Tema moderno
- **Funzionalità**: Filament 4.x integration, Livewire
- **Status**: ✅ Operativo
- **Componenti**: 50+ componenti custom

### Theme One - Base Theme
- [README](../laravel/Themes/One/docs/README.md) - Tema base
- **Funzionalità**: Foundation theme, minimal styling
- **Status**: ✅ Minimale
- **Componenti**: Core components only

---

## 🛠️ Guide Sviluppo

### Development Setup
- [Environment Setup](./development/setup.md) - Configurazione ambiente
- [Docker Setup](./development/docker.md) - Configurazione Docker
- [Database Setup](./database/setup.md) - Setup database

### Coding Guidelines
- [PHP Standards](./standards/php.md) - Standard PHP (PSR-12)
- [Laravel Best Practices](./standards/laravel.md) - Best practices Laravel
- [Filament Guidelines](./standards/filament.md) - Linee guida Filament
- [Blade Components](./standards/blade.md) - Componenti Blade

### Quality Assurance
- [PHPStan Configuration](./phpstan/README.md) - Analisi statica
- [Testing Strategy](./testing/strategy.md) - Strategia testing
- [CI/CD Pipeline](./ci-cd/README.md) - Continuous integration

---

## 🧪 Testing

### Test Documentation
- [Testing Guide](./testing/README.md) - Guida completa testing
- [Unit Tests](./testing/unit.md) - Test unitari
- [Feature Tests](./testing/feature.md) - Test funzionali
- [Browser Tests](./testing/browser.md) - Test browser (Dusk)

### Coverage Reports
- [Coverage Overview](./testing/coverage.md) - Panoramica coverage
- [Module Coverage](./testing/module-coverage.md) - Coverage per modulo

---

## 🚀 Deployment

### Deployment Guides
- [Production Deploy](./deployment/production.md) - Deploy produzione
- [Staging Deploy](./deployment/staging.md) - Deploy staging
- [Rollback Strategy](./deployment/rollback.md) - Strategia rollback

### Server Configuration
- [Nginx Configuration](./deployment/nginx.md) - Configurazione Nginx
- [PHP-FPM Configuration](./deployment/php-fpm.md) - Configurazione PHP-FPM
- [SSL/TLS Setup](./deployment/ssl.md) - Configurazione SSL

---

## 📊 Monitoring & Analytics

### Monitoring
- [Application Monitoring](./monitoring/application.md) - Monitoraggio app
- [Performance Monitoring](./monitoring/performance.md) - Performance metrics
- [Error Tracking](./monitoring/errors.md) - Tracking errori

### Analytics
- [Usage Analytics](./analytics/usage.md) - Analisi utilizzo
- [Business Metrics](./analytics/business.md) - Metriche business

---

## 🔒 Security

### Security Documentation
- [Security Guidelines](./security/guidelines.md) - Linee guida sicurezza
- [GDPR Compliance](./security/gdpr.md) - Conformità GDPR
- [Authentication](./security/authentication.md) - Sistema autenticazione
- [Authorization](./security/authorization.md) - Sistema autorizzazioni

---

## 📝 Changelog & Versioning

### Version History
- [Changelog](./CHANGELOG.md) - Storico modifiche
- [Versioning Strategy](./versioning.md) - Strategia versioning
- [Migration Guides](./migrations/README.md) - Guide migrazione

---

## 🤝 Contributing

### Contribution Guidelines
- [How to Contribute](./CONTRIBUTING.md) - Come contribuire
- [Code of Conduct](./CODE_OF_CONDUCT.md) - Codice condotta
- [Pull Request Template](./.github/pull_request_template.md) - Template PR

---

## 📞 Support & Community

### Support Channels
- **📧 Email**: support@fixcity.com
- **🐛 Issues**: [GitHub Issues](https://github.com/laraxot/fixcity/issues)
- **💬 Discord**: [Laraxot Community](https://discord.gg/laraxot)
- **📚 Docs**: [Documentation Portal](https://docs.laraxot.com)

### Community Resources
- [FAQ](./faq/README.md) - Domande frequenti
- [Tutorials](./tutorials/README.md) - Tutorial passo-passo
- [Examples](./examples/README.md) - Esempi codice

---

## 🔗 Collegamenti Utili

### External Resources
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Bootstrap Italia](https://italia.github.io/bootstrap-italia/)
- [Design Comuni](https://designers.italia.it/modello/comuni/)

### Package Documentation
- [Livewire](https://livewire.laravel.com)
- [Alpine.js](https://alpinejs.dev)
- [Tailwind CSS](https://tailwindcss.com)
- [Spatie Packages](https://spatie.be/open-source)

---

**🔄 Ultimo aggiornamento**: 14 Ottobre 2025  
**📦 Versione Progetto**: 4.0.0  
**🐄 Curato da**: Super Mucca Documentation Team  
**✨ Status**: Documentazione Completa e Aggiornata

---

*"La documentazione è il fondamento di ogni grande progetto"* - Team Laraxot
