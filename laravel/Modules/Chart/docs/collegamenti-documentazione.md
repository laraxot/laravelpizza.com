# Collegamenti Documentazione <nome progetto>

## Mappa dei collegamenti

- [README.md documentazione generale <nome progetto>](./README.md)
- [README.md toolkit bashscripts](../bashscripts/docs/README.md)
- [Documentazione Sistema di Prompt](../bashscripts/docs/PROMPTS_DOCUMENTATION_SYSTEM.md)
- [Percorsi Relativi nella Documentazione](../bashscripts/docs/PERCORSI_RELATIVI_DOCUMENTAZIONE.md)
- [Regole per la Configurazione degli IDE](../bashscripts/docs/REGOLE_IDE_CONFIGURAZIONE.md)
- [Analisi Miglioramento Prompt](../bashscripts/docs/ANALISI_MIGLIORAMENTO_PROMPT.md)
- [Nuovo Formato Prompt](../bashscripts/docs/NUOVO_FORMATO_PROMPT.md)
- [README.md modulo CMS](../laravel/Modules/Cms/docs/README.md)
- [README.md modulo Dental](../laravel/Modules/Dental/docs/README.md)
- [README.md modulo GDPR](../laravel/Modules/Gdpr/docs/README.md)
- [README.md modulo User](../laravel/Modules/User/docs/README.md)
- [README.md modulo Lang](../laravel/Modules/Lang/docs/README.md)
- [README.md modulo Media](../laravel/Modules/Media/docs/README.md)
- [README.md modulo Notify](../laravel/Modules/Notify/docs/README.md)
  - [Sistema di Template Email](../laravel/Modules/Notify/docs/EMAIL_TEMPLATES.md)
  - [Email per i Dottori](../laravel/Modules/Notify/docs/DOCTOR_EMAILS.md)
  - [Filament Resources](../laravel/Modules/Notify/docs/filament-resources.md)
  - [Sistema di Traduzioni](../laravel/Modules/Notify/docs/translations.md)
- [README.md modulo Reporting](../laravel/Modules/Reporting/docs/README.md)
- [README.md modulo Tenant](../laravel/Modules/Tenant/docs/README.md)
- [README.md modulo UI](../laravel/Modules/UI/docs/README.md)
- [README.md modulo Xot](../laravel/Modules/Xot/docs/README.md)
- [README.md modulo Chart](../laravel/Modules/Chart/docs/README.md)
- [README.md tema One](../laravel/Themes/One/docs/README.md)
- [Documentazione Principale](./collegamenti-documentazione.md)
- [Modulo Patient](../Modules/Patient/docs/README.md)
  - [Model Inheritance](../Modules/Patient/docs/MODEL_INHERITANCE.md)
  - [Validation Errors](../Modules/Patient/docs/VALIDATION_ERRORS.md)
  - [Namespace Conventions](../Modules/Patient/docs/NAMESPACE_CONVENTIONS.md)
  - [Filament Customization](../Modules/Patient/docs/FILAMENT_CUSTOMIZATION.md)
  - [Translations](../Modules/Patient/docs/TRANSLATIONS.md)
  - [URL Localization](../Modules/Patient/docs/URL_LOCALIZATION.md)
  - [User.php](../Modules/Patient/app/Models/User.php)
  - [Doctor.php](../Modules/Patient/app/Models/Doctor.php)
  - [RegisterAction.php](../Modules/Patient/app/Actions/Doctor/RegisterAction.php)
  - [Migration Doctors Table](../Modules/Patient/database/migrations/2025_04_01_000002_create_doctors_table.php)
  - [Migration Workflow Table](../Modules/Patient/database/migrations/2025_05_15_000001_create_doctor_registration_workflows_table.php)
- [Modulo Xot](../Modules/Xot/docs/README.md)
  - [Xot Base Classes](../Modules/Xot/docs/XOT_BASE_CLASSES.md)
  - [Code Quality](../Modules/Xot/docs/CODE_QUALITY.md)
  - [XotBaseMigration.php](../Modules/Xot/database/migrations/XotBaseMigration.php)
- [README.md modulo User](../laravel/Modules/User/docs/README.md)
  - [Model Inheritance](../laravel/Modules/User/docs/MODEL_INHERITANCE.md)
  - [Validation Errors](../laravel/Modules/User/docs/VALIDATION_ERRORS.md)
  - [Namespace Conventions](../laravel/Modules/User/docs/NAMESPACE_CONVENTIONS.md)
  - [Filament Customization](../laravel/Modules/User/docs/FILAMENT_CUSTOMIZATION.md)
  - [Translations](../laravel/Modules/User/docs/TRANSLATIONS.md)
  - [URL Localization](../laravel/Modules/User/docs/URL_LOCALIZATION.md)
  - [User.php](../laravel/Modules/User/app/Models/User.php)
  - [Doctor.php](../laravel/Modules/User/app/Models/Doctor.php)
  - [RegisterAction.php](../laravel/Modules/User/app/Actions/Doctor/RegisterAction.php)
  - [Migration Doctors Table](../laravel/Modules/User/database/migrations/2025_04_01_000002_create_doctors_table.php)
  - [Migration Workflow Table](../laravel/Modules/User/database/migrations/2025_05_15_000001_create_doctor_registration_workflows_table.php)
  - [User Module Database Errors](./laravel/Modules/User/docs/DATABASE_ERRORS.md)

## Regole pratiche per la bidirezionalità

- Ogni documento deve avere una sezione "Collegamenti correlati" in cima, che punta a tutti i moduli, root, temi e a questo file.
- Ogni nuovo modulo o tema deve essere aggiunto sia qui che nei README degli altri moduli.
- I link devono essere relativi e funzionanti dal contesto del file.
- In caso di modifica della struttura, aggiornare sempre sia questo file che i README coinvolti.

## Documenti principali

- Documentazione centrale: `./README.md`
- [Gestione build assets Chart](../laravel/Modules/Chart/docs/README.md): motivazione architetturale per output assets in ./resources/dist e autonomia dei moduli
- Documentazione moduli: `../laravel/Modules/*/docs/README.md`
- Documentazione temi: `../laravel/Themes/*/docs/README.md`
- Toolkit bash: `../bashscripts/docs/README.md`
- [Miglioramenti al Prompt docs.txt](../bashscripts/docs/prompt_docs_improvements.md): documentazione dei miglioramenti al prompt di documentazione
- [Regole per i Percorsi Relativi](../laravel/Modules/Xot/docs/RELATIVE_PATHS_RULES.md): linee guida per l'utilizzo corretto dei percorsi relativi nella documentazione

## Note
- Seguire sempre le regole di coerenza e bidirezionalità.
- Aggiornare questa mappa ad ogni aggiunta o rimozione di moduli/temi.

## Documenti Principali

### Installazione e Configurazione
- [Installazione Iniziale](/docs/installazione-iniziale.md) ↔ [Server Setup](/docs/server_setup.md)
- [Configurazione](/docs/configuration.md) ↔ [App PHP Configuration](/docs/app-php-configuration.md)

### Git e Versionamento
- [Git](/docs/git.md) ↔ [Risoluzione Conflitti Git](/docs/risoluzione_conflitti_git.md)
- [Conflitti Git Moduli](/docs/conflitti_git_moduli.md) ↔ [Risoluzione Errori Service Provider](/docs/risoluzione_errore_service_provider.md)

### Standard e Convenzioni
- [Standard Codice](../laravel/Modules/Xot/docs/standards/coding-standards.md) ↔ [Convenzioni](/docs/conventions.md)
- [Naming Conventions](../laravel/Modules/Xot/docs/standards/naming-conventions.md) ↔ [Schema Conventions](/docs/schema_conventions.md)
- [PHPStan Level 10 Fixes](/docs/PHPSTAN_LEVEL10_FIXES.md) ↔ [Safe Library Fix](/docs/safe_library_fix.md)
- [Convenzioni Path nei Moduli](/laravel/Modules/User/docs/PATH_CONVENTIONS.md) ↔ [Convenzioni Path Actions](/laravel/Modules/User/docs/ACTIONS_PATH_CONVENTION.md) ↔ [Analisi Errore: Gestione Percorsi](/docs/error_analysis/path_management.md)
- [Regole Namespace](../laravel/Modules/Xot/docs/standards/namespace-rules.md) ↔ [Namespace Conventions](/docs/namespace-conventions.md)

### Progetto e Roadmap
- [Progetto](/docs/progetto.md) ↔ [Project Structure](/docs/project-structure.md)
- [Roadmap Backoffice](/docs/roadmap_backoffice.md) ↔ [Project Backoffice](/docs/project_backoffice.md)
- [Roadmap Frontoffice](/docs/roadmap_frontoffice.md) ↔ [Project Frontoffice](/docs/project_frontoffice.md)

## Moduli e Componenti

### Laravel e Framework
- [Architettura Folio Volt](/docs/architettura-folio-volt.md) ↔ [Laravel App](/docs/laravel-app)
- [Best Practices Volt e Folio](/laravel/Modules/Xot/docs/VOLT_FOLIO_BEST_PRACTICES.md) ↔ [Analisi Logout Blade](/laravel/Modules/User/docs/LOGOUT_BLADE_ANALYSIS.md)
- [Filament](/docs/filament) ↔ [Filament Block Labels](/docs/filament-block-labels.md)

### Autenticazione
- [Implementazione Auth Pages](/docs/authentication/auth-pages-implementation.md) ↔ [Auth Pages Implementation](/laravel/Modules/User/docs/AUTH_PAGES_IMPLEMENTATION.md)
- [Implementazione Logout](/laravel/Modules/User/docs/LOGOUT_BLADE_IMPLEMENTATION.md) ↔ [Analisi Logout](/laravel/Modules/User/docs/LOGOUT_BLADE_ANALYSIS.md) ↔ [Conclusioni Logout](/laravel/Modules/User/docs/LOGOUT_BLADE_CONCLUSIONS.md)
- [Analisi Errore Logout](/laravel/Modules/User/docs/LOGOUT_BLADE_ERROR_ANALYSIS.md) ↔ [Widget Filament Corretto](/laravel/Modules/User/docs/LOGOUT_FILAMENT_WIDGET_CORRECTED.md)
- [Errore Eventi Logout](/laravel/Modules/User/docs/LOGOUT_EVENT_ERROR.md) ↔ [Implementazione Corretta Eventi](/laravel/Themes/One/resources/views/pages/auth/logout.blade.php.corrected_event)
- [Documentazione Auth Tema One](/laravel/Themes/One/docs/AUTH.md) ↔ [Volt Folio Logout](/laravel/Modules/User/docs/VOLT_FOLIO_LOGOUT.md)

### Frontend e UI
- [Temi](/docs/theme-links.md) ↔ [Theme Build](/docs/theme-build.md)
- [Componenti](/docs/components) ↔ [Sections](/docs/sections.md)
- [Frontend Development](/docs/frontend-development.md) ↔ [Verificare Homepage](/docs/verificare-homepage.md)
- [Widget View Namespaces](/docs/frontend/widget-view-namespaces.md) ↔ [Auth Widgets Namespaces](/laravel/Modules/User/docs/auth-widgets-view-namespaces.md)

### Sezioni
- [Sezioni](/docs/sections.md) ↔ [Sezioni CMS](/laravel/Modules/Cms/docs/sections.md)
- [Sezioni](/docs/sections.md) ↔ [Sezioni Tema One](/laravel/Themes/One/docs/sections.md)
- [Header: Lingua e Utente](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md) ↔ [Implementazione CMS](/laravel/Modules/Cms/docs/sections/HEADER_LANGUAGE_USER_DROPDOWN.md)
- [Header: Selettore Lingua e Avatar](/laravel/Modules/User/docs/HEADER_LANGUAGE_AVATAR_IMPLEMENTATION.md) ↔ [Implementazione Tema One](/laravel/Themes/One/docs/sections/HEADER_LANGUAGE_AVATAR_IMPLEMENTATION.md) ↔ [Implementazione CMS](/laravel/Modules/Cms/docs/sections/HEADER_LANGUAGE_AVATAR_IMPLEMENTATION.md)

### Documentazione e Regole
- [Linee Guida Documentazione](/docs/linee-guida-documentazione.md) ↔ [Regole Documentazione](/docs/regole-documentazione.md)
- [Collegamenti Immagini](/docs/collegamenti-immagini.md) ↔ [Spostare Documenti](/docs/spostare-documenti.md)
- [Piano Riorganizzazione](/docs/piano-riorganizzazione.md) ↔ [Mappatura Contenuti](/docs/mappatura_contenuti.md)

### Traduzioni e Localizzazione
- [Best Practices Chiavi di Traduzione](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_BEST_PRACTICES.md) ↔ [Implementazione Header](/laravel/Modules/User/docs/HEADER_LANGUAGE_AVATAR_IMPLEMENTATION.md)

## Troubleshooting e Supporto

### Errori e Risoluzione
- [Errori](/docs/errors.md) ↔ [Error Analysis](/docs/error_analysis.md)
- [Troubleshooting](/docs/troubleshooting) ↔ [Risoluzione Errori Service Provider](/docs/risoluzione_errore_service_provider.md)

### Scripts e Automazione
- [Bash Scripts](/docs/bashscripts.md) ↔ [Git Scripts](/docs/git.md)
- [Laravel Installer Rule](/docs/laravel-installer-rule.md) ↔ [Laravel New Command](/docs/laravel-new-command.md)

## Note
- I collegamenti bidirezionali (↔) indicano documenti correlati che dovrebbero essere mantenuti sincronizzati
- I documenti duplicati dovrebbero essere unificati o chiaramente differenziati
- Ogni modifica in un documento correlato dovrebbe essere riflessa nel documento corrispondente
- Tutti i collegamenti devono essere relativi e non assoluti
- La documentazione deve essere mantenuta aggiornata e coerente
