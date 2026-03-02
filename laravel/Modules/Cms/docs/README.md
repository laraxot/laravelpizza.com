# Modulo CMS - Content Management System

## 🎯 Panoramica
Sistema completo di gestione contenuti basato su Filament Builder Blocks per <main module>.

## 🏗️ Componenti Principali
- **PageResource**: Interfaccia amministrativa Filament
- **BlockSystem**: Sistema modulare blocchi contenuto  
- **ContentBuilder**: Composizione dinamica pagine
- **Storage JSON**: Persistenza contenuti ottimizzata

## 📁 Struttura
```
Modules/Cms/
├── app/Filament/Resources/PageResource.php
├── app/Filament/Fields/PageContentBuilder.php
├── docs/                    # Documentazione completa
└── resources/views/components/
```

## 🔗 Collegamenti Documentazione

### Documentazione Interna
- [Sistema Filament Blocks](./filament-blocks-system.md)
- [Strategia Contenuti](./content-management-strategy.md)
- [Regole Link Relativi](./link-relativi-regole.md) ⭐ **CRITICO**
- [Componenti Header](./componenti-header.md)
- [Processo Build Tema](./theme-build-process.md)
- [Architettura Frontend](./frontend-architecture/struttura-homepage.md)
- [Testing Guidelines](./tests/architecture-separation-rules.md)

### Moduli Correlati
- [Modulo UI - Blocchi](../../UI/docs/blocks-system.md)
- [Modulo <main module> - Homepage](../../<main module>/docs/homepage-architecture.md)

### Documentazione Root
- [Architettura Generale](../../../docs/architecture.md)
- [Best Practices UX](../../../docs/ux-design-principles.md)

## 🚨 Regole Critiche

### Link Relativi Obbligatori
**TUTTI i link .md DEVONO essere relativi**
- ✅ `./file.md` (stesso modulo)
- ✅ `../../Modulo/docs/file.md` (altro modulo)  
- ✅ `../../../docs/file.md` (root docs)
- ❌ `/var/www/html/...` (VIETATO)

### Convenzioni
- File docs: minuscolo (eccetto README.md)
- Link: sempre relativi alla posizione file
- Filosofia: "Non avrai altro path all'infuori del relativo"

---
**Ultimo aggiornamento**: Gennaio 2025
# 🗂️ CMS Module - Content Management System

## 📋 Quick Reference
| Categoria | Guida | File |
|-----------|-------| ---- |
| **Content** | Management | [content-management.md](content-management.md) |
| **Components** | Blade | [components.md](components.md) |
| **Filament** | Integration | [filament-integration.md](filament-integration.md) |
| **Folio** | Pages | [folio-pages.md](folio-pages.md) |
| **Homepage** | Structure | [homepage-management.md](homepage-management.md) |
| **Architecture** | XotData | [architecture-xotdata-pattern.md](architecture-xotdata-pattern.md) |
| **Troubleshooting** | Git Issues | [git-conflicts-resolution-impact.md](git-conflicts-resolution-impact.md) |

## 🎯 Core Features
- **Content Management**: Flexible content creation and editing
- **Folio Integration**: File-based routing system
- **Filament Resources**: Admin panel for content management
- **Blade Components**: Reusable UI components
- **Homepage Builder**: Dynamic homepage construction
- **Multi-language**: Full i18n support

## 📁 Documentation Structure
- Core files in root level
- `/blocks/` - Content blocks documentation
- `/components/` - Component guides
- `/content/` - Content management
- `/frontoffice/` - Public facing features
- `/standards/` - Development standards

---
*Principio DRY: Sistema CMS flessibile, documentazione organizzata per funzionalità.*

# Modulo CMS
> **Collegamenti correlati**
> - [README.md documentazione generale <main module>](../../../../docs/README.md)
> - [README.md toolkit bashscripts](../../../../bashscripts/docs/README.md)
> - [README.md modulo CMS](../../../../laravel/Modules/Cms/docs/README.md)
> - [README.md modulo Dental](../../../../laravel/Modules/Dental/docs/README.md)
> - [README.md modulo GDPR](../../../../laravel/Modules/Gdpr/docs/README.md)
> - [README.md modulo User](../../../../laravel/Modules/User/docs/README.md)
> - [README.md modulo Lang](../../../../laravel/Modules/Lang/docs/README.md)
> - [README.md modulo Patient](../../../../laravel/Modules/Patient/docs/README.md)
> - [README.md modulo Activity](../../../../laravel/Modules/Activity/docs/README.md)
> - [README.md modulo Media](../../../../laravel/Modules/Media/docs/README.md)
> - [README.md modulo Notify](../../../../laravel/Modules/Notify/docs/README.md)
> - [README.md modulo Reporting](../../../../laravel/Modules/Reporting/docs/README.md)
> - [README.md modulo Tenant](../../../../laravel/Modules/Tenant/docs/README.md)
> - [README.md modulo UI](../../../../laravel/Modules/UI/docs/README.md)
> - [README.md modulo Xot](../../../../laravel/Modules/Xot/docs/README.md)
> - [README.md modulo Chart](../../../../laravel/Modules/Chart/docs/README.md)
> - [README.md tema One](../../../../laravel/Themes/One/docs/README.md)
> - [README.md tema Two](../../../../laravel/Themes/Two/docs/README.md)
> - [Collegamenti documentazione centrale](../../../../docs/collegamenti-documentazione.md)

> - [README.md documentazione generale <main module>](../../../../docs/README.md)
> - [README.md toolkit bashscripts](../../../../bashscripts/docs/README.md)
> - [README.md modulo CMS](../../../../laravel/Modules/Cms/docs/README.md)
> - [README.md modulo Dental](../../../../laravel/Modules/Dental/docs/README.md)
> - [README.md modulo GDPR](../../../../laravel/Modules/Gdpr/docs/README.md)
> - [README.md modulo User](../../../../laravel/Modules/User/docs/README.md)
> - [README.md modulo Lang](../../../../laravel/Modules/Lang/docs/README.md)
> - [README.md modulo Media](../../../../laravel/Modules/Media/docs/README.md)
> - [README.md modulo Notify](../../../../laravel/Modules/Notify/docs/README.md)
> - [README.md modulo Reporting](../../../../laravel/Modules/Reporting/docs/README.md)
> - [README.md modulo Tenant](../../../../laravel/Modules/Tenant/docs/README.md)
> - [README.md modulo UI](../../../../laravel/Modules/UI/docs/README.md)
> - [README.md modulo Xot](../../../../laravel/Modules/Xot/docs/README.md)
> - [README.md modulo Chart](../../../../laravel/Modules/Chart/docs/README.md)
> - [README.md tema One](../../../../laravel/Themes/One/docs/README.md)
> - [Collegamenti documentazione centrale](../../../../docs/collegamenti-documentazione.md)

# Jigsaw Docs Starter Template

## Introduzione
Il modulo CMS gestisce i contenuti e i widget del sistema, fornendo un sistema flessibile per la gestione dinamica dei contenuti e l'ottimizzazione per i motori di ricerca.

## Indice
1. [Architettura](#architettura)
   - [Struttura del Modulo](structure.md)
   - [Architettura Generale](architecture.md)
   - [Convenzioni e Standard](module-guidelines.md)

2. [Frontend](#frontend)
   - [Frontoffice](frontoffice.md)
   - [Homepage](homepage.md)
   - [Componenti UI](components.md)
   - [Volt & Folio](volt-web-application.md)

3. [Backend](#backend)
   - [Filament Integration](filament-integration.md)
   - [Content Management](content-management.md)
   - [Filament Components](filament-components.md)
   - [Resources](filament-resources.md)

4. [Contenuti](#contenuti)
   - [Gestione Pagine](page-management.md)
   - [Gestione Sezioni](section-management.md)
   - [Storage dei Contenuti](content-storage.md)
   - [Traduzioni](translations.md)

5. [Sviluppo](#sviluppo)
   - [Getting Started](getting-started.md)
   - [Configurazione](configuration.md)
   - [Testing](testing.md)
   - [PHPStan](phpstan.md)
   - [Correzioni PHPStan](phpstan-fixes.md)

6. [UX/UI](#ux-ui)
   - [Web Design](webdesign.md)
   - [Componenti Standard](standard_ui_components.md)
   - [Multi-step Forms](multi-step-forms.md)
   - [Wizard](ux-wizard-registrazione-paziente.md)

## Dipendenze Principali
- Laravel Framework ^11.0
- Filament ^3.2
- Livewire ^3.0
- Laravel Folio ^1.0
- Laravel Volt ^1.0
- Tailwind CSS ^3.4
- Alpine.js ^3.0

## Best Practices
1. **Estensione Classi**
   - Estendere sempre le classi base di Xot
   - Non estendere direttamente le classi di Filament
   - Utilizzare i trait forniti dal modulo

2. **Convenzioni**
   - Seguire le [convenzioni di naming](../../../docs/standards/file_naming_conventions.md)
   - Documentare tutto il codice con PHPDoc
   - Mantenere la struttura dei file coerente

3. **Performance**
   - Utilizzare il caching dove possibile
   - Ottimizzare le query al database
   - Seguire le [best practices di Laravel](https://laravel.com/docs/11.x/best-practices)

## Collegamenti Bidirezionali
- [Modulo User](../User/docs/README.md) - Gestione utenti e permessi
- [Modulo Lang](../Lang/docs/README.md) - Gestione traduzioni
- [Modulo UI](../UI/docs/README.md) - Componenti di interfaccia
- [Modulo Xot](../Xot/docs/README.md) - Modulo base e linee guida
- [Documentazione Principale](../../../docs/README.md) - Documentazione generale

## Roadmap e Sviluppo
- [Roadmap](roadmap.md) - Piano di sviluppo futuro
- [Issues](phpstan_issues.md) - Problemi noti e soluzioni
- [Upgrade Guide](upgrade.md) - Guida all'aggiornamento

## Supporto
Per domande o problemi, consultare:
1. La [documentazione ufficiale](https://<nome progetto>.com/docs)
2. Il [forum di supporto](https://<nome progetto>.com/forum)
3. Il team di sviluppo via [email](mailto:support@<nome progetto>.com)
> Tip: This configuration file is also where you’ll define any "collections" (for example, a collection of the contributors to your site, or a collection of blog posts). Check out the official [Jigsaw documentation](https://jigsaw.tighten.co/docs/collections/) to learn more.

---

### Adding Content

You can write your content using a [variety of file types](http://jigsaw.tighten.co/docs/content-other-file-types/). By default, this starter template expects your content to be located in the `source/docs` folder. If you change this, be sure to update the URL references in `navigation.php`.

The first section of each content page contains a YAML header that specifies how it should be rendered. The `title` attribute is used to dynamically generate HTML `title` and OpenGraph tags for each page. The `extends` attribute defines which parent Blade layout this content file will render with (e.g. `_layouts.documentation` will render with `source/_layouts/documentation.blade.php`), and the `section` attribute defines the Blade "section" that expects this content to be placed into it.

```yaml
---
title: Navigation
description: Building a navigation menu for your site
extends: _layouts.documentation
section: content
---
```

[Read more about Jigsaw layouts.](https://jigsaw.tighten.co/docs/content-blade/)

---

### Adding Assets

Any assets that need to be compiled (such as JavaScript, Less, or Sass files) can be added to the `source/_assets/` directory, and Laravel Mix will process them when running `npm run dev` or `npm run prod`. The processed assets will be stored in `/source/assets/build/` (note there is no underscore on this second `assets` directory).

Then, when Jigsaw builds your site, the entire `/source/assets/` directory containing your built files (and any other directories containing static assets, such as images or fonts, that you choose to store there) will be copied to the destination build folders (`build_local`, on your local machine).

Files that don't require processing (such as images and fonts) can be added directly to `/source/assets/`.

[Read more about compiling assets in Jigsaw using Laravel Mix.](http://jigsaw.tighten.co/docs/compiling-assets/)

---

## Building Your Site

Now that you’ve edited your configuration variables and know how to customize your styles and content, let’s build the site.

```bash
# build static files with Jigsaw
./vendor/bin/jigsaw build

# compile assets with Laravel Mix
# options: dev, prod
npm run dev
```

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

