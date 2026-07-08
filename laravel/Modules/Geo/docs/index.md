# PTVX - Documentazione Completa

> Sistema Modulare per la Gestione della Pubblica Amministrazione

## 🚀 Quick Start

- **[Introduzione](./README.md)** - Panoramica del progetto
- **[Getting Started](./getting-started/)** - Setup e primi passi
- **[Installation](./installation.md)** - Guida installazione completa

## 🏗️ Architettura

### Fondamenti
- **[Architecture Overview](./architecture/)** - Architettura generale del sistema
- **[Directory Structure](./directory-structure.md)** - Struttura cartelle e organizzazione
- **[Module System](./development/module-development.md)** - Sistema modulare
- **[Dependency Management](./dependencies.md)** - Gestione dipendenze

### Moduli Core
- **[Xot Module](../laravel/Modules/Xot/docs/README.md)** - Framework base
- **[User Module](../laravel/Modules/User/docs/README.md)** - Autenticazione e autorizzazione
- **[UI Module](../laravel/Modules/UI/docs/README.md)** - Componenti interfaccia
- **[Tenant Module](../laravel/Modules/Tenant/docs/README.md)** - Multi-tenancy
- **[Lang Module](../laravel/Modules/Lang/docs/README.md)** - Gestione traduzioni

### Design Patterns
- **[Service Providers](./service-provider-best-practices.md)** - Pattern service providers
- **[Data Transfer Objects](./best-practices/dto-pattern.md)** - DTO con Spatie Laravel Data
- **[Actions Pattern](./actions.md)** - Spatie QueueableActions
- **[Event Sourcing](../laravel/Modules/Activity/docs/event-sourcing.md)** - Event sourcing pattern

## 💻 Sviluppo

### Guide per Sviluppatori
- **[Development Guide](./development/)** - Guida completa sviluppo
- **[Module Development](./development/module-development.md)** - Creare nuovi moduli
- **[Coding Conventions](./conventions/)** - Convenzioni di codice
- **[Best Practices](./best-practices/)** - Best practices raccomandate

### Framework e Stack
- **[Laravel](./core/laravel.md)** - Framework Laravel
- **[Filament](./filament/)** - Admin panel Filament
- **[Livewire](./core/livewire.md)** - Componenti reattivi
- **[Blade Components](./blade-components.md)** - Componenti Blade

### Database
- **[Migrations](./database-migrations.md)** - Sistema migrazioni
- **[Models](./core/models.md)** - Eloquent models
- **[Repositories](./repositories.md)** - Pattern repository
- **[EAV System](./eav-system.md)** - Entity-Attribute-Value

## 🎨 Frontend

### UI/UX
- **[UI Components](./ui_components/)** - Componenti UI custom
- **[Theme System](./themes/)** - Sistema di temi
- **[Blade Components](./blade-components.md)** - Componenti Blade
- **[Forms](./filament/forms.md)** - Form builder

### Filament
- **[Resources](./filament/resources.md)** - Filament Resources
- **[Pages](./filament/pages.md)** - Custom pages
- **[Widgets](./filament/widgets.md)** - Dashboard widgets
- **[Actions](./filament/actions.md)** - Custom actions
- **[Relation Managers](./filament/relation-managers.md)** - Gestione relazioni

## 🔒 Sicurezza

### Autenticazione e Autorizzazione
- **[Authentication](./core/authentication.md)** - Sistema autenticazione
- **[Authorization](./authorization.md)** - Autorizzazione e permessi
- **[Roles & Permissions](../laravel/Modules/User/docs/roles-permissions.md)** - Gestione ruoli
- **[Teams](./teams.md)** - Gestione team

### Sicurezza Dati
- **[Security Best Practices](./security.md)** - Sicurezza applicazione
- **[GDPR Compliance](./gdpr-compliance.md)** - Conformità GDPR
- **[Audit Log](../laravel/Modules/Activity/docs/README.md)** - Logging attività

## 🧪 Testing

### Strategia di Testing
- **[Testing Strategy](./testing/)** - Strategia generale
- **[Unit Testing](./testing/unit-testing.md)** - Test unitari
- **[Feature Testing](./testing/feature-testing.md)** - Test funzionali
- **[Integration Testing](./testing/integration-testing.md)** - Test di integrazione

### Qualità del Codice
- **[PHPStan](./best-practices/phpstan.md)** - Analisi statica
- **[Code Quality](./best-practices/code-quality.md)** - Qualità del codice
- **[Testing Guidelines](./testing/guidelines.md)** - Linee guida testing

<<<<<<< HEAD
## 📊 Performance
=======
## 🗺️ Geo Filament Components

### Filosofia e Regole
- [**Filament Geo Pickers Philosophy**](filament-geo-pickers-philosophy.md) - Filosofia, visione e regole per i componenti Geo picker
- [**Map Picker Prompt**](/prompts/map-picker.txt) - Prompt per implementazione MapPicker

### Pickers Components
- CoordinatePicker - Il maestro Zen
- MapPicker / LocationPicker - Alias backward-compatible
- LatitudeLongitudeInput - Le viscere grezze
- PlacePicker - La guida al specifico
- MapPositioner - Il righello di prospettiva
- MapLocationInput - Input nascosto sincronizzato
- LeafletMarkerMapInput - L'amarker con memoria
- GeopointPicker - Il punto geografico puro

## 📋 Convenzioni e Standard
>>>>>>> 74bf6abe2 (.)

### Ottimizzazione
- **[Performance Optimization](./performance-optimization.md)** - Ottimizzazione generale
- **[Cache Management](./cache-management.md)** - Gestione cache
- **[Queue Management](./queue-management.md)** - Code e job
- **[Database Optimization](./performance/database.md)** - Ottimizzazione DB

### Monitoring
- **[Metrics Dashboard](./metrics-dashboard.md)** - Dashboard metriche
- **[Performance Monitoring](./performance/monitoring.md)** - Monitoraggio performance

## 🌐 Internazionalizzazione

### Traduzioni
- **[Lang Service](../laravel/Modules/Lang/docs/README.md)** - Sistema traduzioni
- **[Translation Guidelines](./conventions/translations.md)** - Linee guida traduzioni
- **[Multi-language Support](./core/i18n.md)** - Supporto multilingua

## 🔧 Configurazione

### Setup e Configurazione
- **[Environment Setup](./getting-started/environment.md)** - Setup ambiente
- **[Configuration Files](./core/configuration.md)** - File di configurazione
- **[Module Configuration](./development/module-configuration.md)** - Configurazione moduli

## 🐛 Troubleshooting

### Risoluzione Problemi
- **[Common Errors](./common-errors.md)** - Errori comuni
- **[Debugging Guide](./troubleshooting/debugging.md)** - Guida al debugging
- **[Conflicts Resolution](./conflicts-resolution.md)** - Risoluzione conflitti
- **[Git Conflicts](./git-conflict-resolution.md)** - Conflitti Git

## 🚢 Deploy e Produzione

### Deployment
- **[Deployment Guide](./deployment/)** - Guida al deployment
- **[Server Configuration](./deployment/server.md)** - Configurazione server
- **[CI/CD](./deployment/ci-cd.md)** - Continuous Integration/Deployment

## 📚 Riferimenti

### API e Integrazioni
- **[API Development](./api-development.md)** - Sviluppo API
- **[External Integrations](./integrations/)** - Integrazioni esterne
- **[OAuth](./oauth/)** - Autenticazione OAuth

### Moduli Specifici PA
- **[Performance Module](../laravel/Modules/Performance/docs/README.md)** - Valutazioni
- **[Presenze Assenze](../laravel/Modules/PresenzeAssenze/docs/README.md)** - Timbrature
- **[Progressioni](../laravel/Modules/Progressioni/docs/README.md)** - Carriere
- **[Indennità](../laravel/Modules/IndennitaCondizioniLavoro/docs/README.md)** - Indennità

## 🗺️ Roadmap

### Sviluppo Futuro
- **[Project Roadmap](./project-roadmap.md)** - Roadmap generale
- **[Filament 4 Upgrade](./filament-4-upgrade-guide.md)** - Upgrade Filament 4
- **[Laravel 11 Migration](./core/laravel-11-migration.md)** - Migrazione Laravel 11

## 📝 Convenzioni e Standard

### Naming e Style
- **[Documentation Conventions](./documentation-conventions.md)** - Convenzioni documentazione
- **[Naming Conventions](./conventions/naming.md)** - Convenzioni naming
- **[Code Style](./conventions/code-style.md)** - Stile del codice

### Regole Cursor/Windsurf
- **[Cursor Rules](../.cursor/rules/)** - Regole Cursor AI
- **[Windsurf Rules](../.windsurf/rules/)** - Regole Windsurf AI

## 🤝 Contribuire

### Come Contribuire
- **[Contributing Guide](./contributing/)** - Guida per contribuire
- **[Code of Conduct](./code-of-conduct.md)** - Codice di condotta
- **[Pull Request Process](./contributing/pr-process.md)** - Processo PR

## 📖 Risorse Aggiuntive

### Learning Resources
- **[Laravel Documentation](https://laravel.com/docs)** - Docs Laravel ufficiale
- **[Filament Documentation](https://filamentphp.com/docs)** - Docs Filament ufficiale
- **[PHPStan Documentation](https://phpstan.org/user-guide/)** - Guida PHPStan

### Community
- **GitHub Discussions**: [Link discussions]
- **Issues Tracker**: [Link issues]
- **Wiki**: [Link wiki]

---

<<<<<<< HEAD
## 🔍 Cerca nella Documentazione

Usa Ctrl/Cmd + F per cercare in questa pagina, oppure:
- [Cerca nei moduli](../laravel/Modules/)
- [Cerca nelle regole AI](../.cursor/rules/)
- [Cerca negli script](../bashscripts/)

## 📧 Supporto

- **Email**: marco.sottana@gmail.com
- **Issues**: [GitHub Issues](link-issues)
- **Discussions**: [GitHub Discussions](link-discussions)

---

**Ultima Revisione**: 2025-01-29  
**Versione Documentazione**: 1.0.0  
**Responsabile Documentazione**: AI Assistant

=======
**Versione**: 3.0
**Autore**: AI Assistant
**Stato**: Consolidata e Aggiornata
>>>>>>> 74bf6abe2 (.)
