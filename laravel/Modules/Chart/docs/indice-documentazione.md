# 📚 Indice Completo della Documentazione <nome progetto>

## 🏠 Documentazione Principale

### Overview
- 📖 [README Principale](README.md) - Panoramica del progetto
- 🏗️ [Architettura del Sistema](ARCHITETTURA_SISTEMA.md) - Diagrammi e componenti
- 👨‍💻 [Guida Sviluppatore](GUIDA_SVILUPPATORE.md) - Setup e sviluppo
- 📊 [Stato Avanzamento Lavori](stato_avanzamenti_lavori_2025_05_28.md) - Progress report

### Roadmap
- 🗺️ [Roadmap Generale](roadmap.md) - Piano di sviluppo completo
- 💼 [Roadmap Backoffice](roadmap_backoffice.md) - Sviluppo area amministrativa
- 🌐 [Roadmap Frontoffice](roadmap_frontoffice.md) - Sviluppo area pubblica
- 📄 [Roadmap Documentazione](roadmap_documentation.md) - Piano documentazione

## 📦 Moduli

### Indici e Overview
- 📑 [Indice dei Moduli](modules/modules-index.md) - Lista completa moduli
- 🔗 [Relazioni tra Moduli](modules/modules-relationships.md) - Dipendenze e interazioni
- 🏛️ [Modulo Xot](modules/xot-module.md) - Framework base

### Documentazione Moduli Core
- **Xot** - Framework Base
  - [README](../laravel/Modules/Xot/docs/README.md)
  - [Standards](../laravel/Modules/Xot/docs/standards/README.md)
  - [Conventions](../laravel/Modules/Xot/docs/conventions/README.md)
  - [PHPStan](../laravel/Modules/Xot/docs/phpstan/README.md)

- **User** - Gestione Utenti
  - [README](../laravel/Modules/User/docs/README.md)
  - [PHPStan](../laravel/Modules/User/docs/phpstan/README.md)

- **Tenant** - Multi-tenancy
  - [README](../laravel/Modules/Tenant/docs/README.md)
  - [PHPStan](../laravel/Modules/Tenant/docs/phpstan/README.md)

- **Lang** - Multi-lingua
  - [README](../laravel/Modules/Lang/docs/README.md)
  - [Service Provider](modules/lang-service-provider-improvements.md)
  - [PHPStan](../laravel/Modules/Lang/docs/phpstan/README.md)

### Documentazione Moduli Funzionali
- **Patient** - Gestione Pazienti
  - [README](../laravel/Modules/Patient/docs/README.md)
  - [Standards](../laravel/Modules/Patient/docs/standards/README.md)
  - [Value Objects](../laravel/Modules/Patient/docs/value-objects/README.md)

- **Dental** - Odontoiatria
  - [README](../laravel/Modules/Dental/docs/README.md)
  - [Implementazione](implementazione/dental/README.md)

- **Doctor** - Professionisti
  - [Registrazione](doctor-registration.md)
  - [Widget Registrazione](doctor-registration-widget.md)
  - [Email Template](email-doctor-registration.md)

### Documentazione Moduli di Supporto
- **Activity** - [README](../laravel/Modules/Activity/docs/README.md) | [PHPStan](../laravel/Modules/Activity/docs/phpstan/README.md)
- **Chart** - [README](../laravel/Modules/Chart/docs/README.md) | [PHPStan](../laravel/Modules/Chart/docs/phpstan/README.md)
- **Cms** - [README](../laravel/Modules/Cms/docs/README.md) | [Blocks](../laravel/Modules/Cms/docs/blocks/README.md)
- **Gdpr** - [README](../laravel/Modules/Gdpr/docs/README.md) | [PHPStan](../laravel/Modules/Gdpr/docs/phpstan/README.md)
- **Job** - [README](../laravel/Modules/Job/docs/README.md) | [PHPStan](../laravel/Modules/Job/docs/phpstan/README.md)
- **Media** - [README](../laravel/Modules/Media/docs/README.md) | [PHPStan](../laravel/Modules/Media/docs/phpstan/README.md)
- **Notify** - [README](../laravel/Modules/Notify/docs/README.md) | [System](notifications-system.md)
- **Reporting** - [README](../laravel/Modules/Reporting/docs/README.md)
- **UI** - [README](../laravel/Modules/UI/docs/README.md) | [Components](../laravel/Modules/UI/docs/components/README.md) | [TableLayoutEnum](ui-table-layout-enum.md) | [Enum Translation Pattern](enum-translation-pattern.md)

## 📊 Progettazione e Standards

### Documentazione Tecnica
- 📐 [Standards di Codice](standards/coding-standards.md) - Convenzioni PHP/Laravel
- 🔧 [PHPStan Level 9](standards/phpstan-level-9.md) - Analisi statica
- 📏 [Testing Standards](standards/testing-standards.md) - Standard per i test
- 🌍 [Traduzioni](traduzioni.md) - Sistema multilingua

## 🎯 Analisi e Decisioni

### Analisi Tecniche
- 🔍 [Widget Multiple Root Elements](analisi/widget_multiple_root_elements_analysis.md) - Analisi problema Livewire

### Decisioni Architetturali
- 🏛️ [Widget Frontend Decision](decisioni/widget_frontend_decision.md) - Separazione widget admin/frontend

## 🚨 Errori e Soluzioni

### Coding Standards
- 📏 [Best Practices](best-practices.md) - Linee guida generali
- 🔍 [PHPStan Level 9](phpstan_level10_fixes.md) - Analisi statica
- 📝 [Standards](standards.md) - Standard di codice
- 🏷️ [Convenzioni Naming](convenzioni-naming-campi.md) - Naming conventions
- 🚨 [Struttura Moduli e Namespace](STRUTTURA_MODULI_NAMESPACE.md) - **CRITICO: Regole namespace**
- ⚠️ [Prevenzione Errori Critici](critical-errors-prevention.md) - **CRITICO: Errori da evitare**
- 📖 [Convenzione Naming README.md](readme-naming-convention.md) - **CRITICO: README.md sempre maiuscolo**

### Pattern e Architettura
- 🎯 [Queueable Actions](queueable-action.md) - Pattern preferito
- 🧬 [Model Inheritance](model-inheritance-patterns.md) - Ereditarietà modelli
- 📊 [Parental STI](parental_single_table_inheritance.md) - Single Table Inheritance
- 🔢 [Enums](enums.md) - Gestione stati e tipi
- 📦 [Actions System](actions-system.md) - Sistema di azioni

### Filament
- 📋 [Resources Guidelines](filament-resources-guidelines.md) - Linee guida risorse
- 🏷️ [Block Labels](filament-block-labels.md) - Etichette blocchi
- 📁 [File Uploads](filament-file-uploads.md) - Gestione upload

## 🛠️ Sviluppo

### Setup e Installazione
- 🚀 [Installazione](installazione.md) - Setup iniziale
- 📦 [Installazione Iniziale](installazione-iniziale.md) - Prima installazione
- ✅ [Checklist Ripartenza](checklist-di-ripartenza.md) - Post-setup checklist

### Database
- 🗄️ [Database Connections](database-connections-and-migrations.md) - Connessioni DB
- 📊 [Database Migrations](database-migrations.md) - Migrazioni
- 🔄 [Migration Checklist](migration-checklist.md) - Checklist migrazioni

### Frontend
- 🎨 [Frontend Overview](frontend.md) - Panoramica frontend
- 🧩 [Blade Components](blade-components.md) - Componenti Blade
- 📦 [Asset Management](asset-management.md) - Gestione asset
- 🎭 [Laravel Mix](laravel-mix.md) - Build system

### Configurazione
- ⚙️ [Configuration](configuration.md) - Configurazioni generali
- 🎨 [Configurazione Logo](configurazione-logo.md) - Setup logo
- 🌍 [Translations System](translations-system.md) - Sistema traduzioni
- 🗣️ [Traduzioni](traduzioni.md) - Gestione traduzioni

## 📖 Guide Specifiche

### Gestione Contenuti
- 📝 [Gestione Contenuti JSON](gestione-contenuti-json.md) - Content management
- 🏠 [Gestione Homepage](gestione-homepage.md) - Homepage setup
- 🗺️ [Mappatura Contenuti](mappatura_contenuti.md) - Content mapping
- 🔗 [Collegamenti Documentazione](collegamenti-documentazione.md) - Doc links
- 🖼️ [Collegamenti Immagini](collegamenti-immagini.md) - Image links

### Flussi Operativi
- 👤 [Flusso Registrazione](flusso-registrazione.md) - Registration flow
- 💼 [Project Backoffice](project_backoffice.md) - Backoffice project
- 🌐 [Project Frontoffice](project_frontoffice.md) - Frontoffice project

### Troubleshooting
- 🐛 [Error Resolution](error_resolution_guidelines.md) - Risoluzione errori
- ❌ [Errori Comuni](errori-comuni.md) - Errori frequenti
- 🔧 [Errors](errors.md) - Lista errori
- 🔍 [Error Analysis](error_analysis.md) - Analisi errori

### Git e Versioning
- 🌿 [Git Workflow](git.md) - Workflow Git
- 🔀 [Conflitti Git](conflitti_git_moduli.md) - Risoluzione conflitti
- 🛠️ [Risoluzione Conflitti](risoluzione_conflitti_git.md) - Guide pratiche

## 🔒 Compliance e Sicurezza

### Privacy e GDPR
- 🔐 [Privacy Overview](06-privacy/) - Panoramica privacy
- 📋 [Compliance](compliance/) - Conformità normative
- 🏥 [Informativa Odontoiatri](informativa_per_odontoiatri_che_aderiscono_al_progetto__salute_ora_.md)
- 🤰 [Informativa Gestanti](informativa_progetto_salute_ora_dedicata_alle_gestanti.md)

## 🚀 Deployment e DevOps

### Amministrazione
- 💼 [Amministrazione](amministrazione/README.md) - Overview amministrativa
- 💾 [Backup](amministrazione/backup/README.md) - Strategie backup
- 📊 [Monitoraggio](amministrazione/monitoraggio/README.md) - Monitoring
- 🚀 [Deployment](amministrazione/deployment/README.md) - Deploy procedures

### Server e Infrastruttura
- 🖥️ [Server Setup](server_setup.md) - Configurazione server
- 🌐 [Apache Config](apache/) - Configurazione Apache
- 🐳 [Docker](../bashscripts/docker/README.md) - Containerizzazione

## 📚 Risorse Aggiuntive

### Tools e Utilities
- 🛠️ [Bash Scripts](bashscripts.md) - Script utility
- 💻 [MCP System](mcp-system.md) - Model Context Protocol
- 🧠 [Memories](memories.md) - Sistema memoria

### IDE e Development
- 💻 [Cursor IDE](ide/cursor/README.md) - Setup Cursor
- 📏 [Rules](.cursor/rules/) - Regole di sviluppo

### Testing
- 🧪 [Testing](implementazione/testing/README.md) - Strategie di test
- 🔍 [Analisi](analisi/) - Analisi codice

### Documentazione Legacy
- 📚 [Vecchia Documentazione](readme.md.old) - Versione precedente
- 📄 [Documentazione IT](it/README.md) - Versione italiana

## 🔗 Collegamenti Rapidi

### Documenti Critici
- ⚡ [Checklist di Ripartenza](checklist-di-ripartenza.md)
- 🚨 [Errori Comuni](errori-comuni.md)
- 📏 [Best Practices](best-practices.md)
- 🔍 [PHPStan Rules](phpstan_level10_fixes.md)

### Riferimenti Esterni
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Spatie Packages](https://spatie.be/docs)
- [PHPStan Documentation](https://phpstan.org/user-guide)

## 📝 Note sulla Documentazione

### Convenzioni
- 📁 Ogni modulo ha la sua cartella `docs/`
- 📝 Ogni sezione ha un `README.md`
- 🔗 I collegamenti sono sempre relativi
- 🌍 La documentazione è in italiano
- 📅 Ogni documento riporta la data di aggiornamento

### Contribuire
Per contribuire alla documentazione:
1. Seguire le [Linee Guida](linee-guida-documentazione.md)
2. Rispettare le [Regole Collegamenti](regole_collegamenti_documentazione.md)
3. Aggiornare questo indice quando si aggiungono documenti
4. Mantenere i collegamenti funzionanti

---

*Ultimo aggiornamento: 28 Maggio 2025*
*Totale documenti: 150+*
*Moduli documentati: 14*
