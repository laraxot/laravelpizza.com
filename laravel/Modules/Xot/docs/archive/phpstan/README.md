# Analisi PHPStan per Moduli Laravel

Questa documentazione spiega come utilizzare gli script forniti per analizzare i moduli Laravel con PHPStan.

## Cos'è PHPStan?

PHPStan è uno strumento di analisi statica per PHP che consente di rilevare errori di programmazione senza eseguire il codice. Supporta diversi livelli di analisi, da 0 (più permissivo) a 9 (più restrittivo).

## Script disponibili

Nel progetto sono disponibili due script per eseguire l'analisi PHPStan su tutti i moduli:

1. `analyze_modules_phpstan.php` - Script PHP che esegue l'analisi e genera file JSON e MD con i risultati
2. `analyze_modules_phpstan.sh` - Wrapper Bash per lo script PHP che fornisce un'interfaccia più user-friendly

## Prerequisiti

- PHP 8.1 o superiore
- PHPStan già installato (incluso nelle dipendenze Composer)
- Permessi di scrittura nelle directory dei moduli

## Come eseguire l'analisi

### Metodo 1: Utilizzando lo script Bash

1. Navigare alla directory principale di Laravel
2. Eseguire lo script bash:

```bash
cd /path/to/laravel
./analyze_modules_phpstan.sh
```

### Metodo 2: Utilizzando lo script PHP direttamente

1. Navigare alla directory principale di Laravel
2. Eseguire lo script PHP:

```bash
cd /path/to/laravel
php analyze_modules_phpstan.php
```

## Output dell'analisi

Per ogni modulo, gli script generano:

- File JSON con i risultati dell'analisi: `Modules/[ModuleName]/project_docs/phpstan/level_[1-9].json`
- File Markdown con suggerimenti per le correzioni: `Modules/[ModuleName]/project_docs/phpstan/correction.md`

## Livelli di analisi

Lo script analizza ogni modulo con livelli di PHPStan incrementali da 1 fino a 9. Se l'analisi fallisce a un determinato livello, l'elaborazione per quel modulo si ferma e viene generato un report.

Descrizione dei livelli:
- **Livello 1**: Controlli di base (chiamate a funzioni/metodi non esistenti)
- **Livello 2**: Controlli di tipo
- **Livello 3**: Controlli su proprietà e metodi non esistenti
- **Livello 4**: Type juggling e controlli più rigidi
- **Livello 5**: Controlli sui dead code e sulle firme dei metodi
- **Livello 6**: Controlli sulla compatibilità delle firme
- **Livello 7**: Controlli sulle dichiarazioni di proprietà
- **Livello 8**: Controlli più avanzati sui tipi di ritorno
- **Livello 9**: Controlli più avanzati su array e parametri variadic

## Come interpretare i risultati

I file JSON contengono gli errori dettagliati rilevati da PHPStan, mentre i file Markdown (`correction.md`) forniscono suggerimenti per correggere gli errori.

Per ogni errore, lo script suggerisce una possibile soluzione in base al tipo di problema rilevato.

## Personalizzazione

Se necessario, è possibile modificare gli script per:

- Cambiare il livello massimo di analisi
- Aggiungere ulteriori suggerimenti per tipi specifici di errori
- Personalizzare il formato dell'output

## Risoluzione problemi

### PHPStan non trovato

Assicurarsi che PHPStan sia correttamente installato eseguendo:

```bash
composer require --dev phpstan/phpstan
```

### Permessi di scrittura

Se lo script non riesce a creare le directory o i file di output, verificare i permessi:

```bash
chmod -R 775 Modules/*/docs
```

### Memoria insufficiente

Se PHPStan esaurisce la memoria durante l'analisi, è possibile aumentare il limite di memoria PHP:

```bash
php -d memory_limit=1G analyze_modules_phpstan.php
``` 

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/project_docs/README.md)
* [README.md](bashscripts/project_docs/it/README.md)
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
* [README.md](laravel/vendor/mockery/mockery/project_docs/README.md)
* [README.md](../../../Chart/project_docs/README.md)
* [README.md](../../../Reporting/project_docs/README.md)
* [README.md](../../../Gdpr/project_docs/phpstan/README.md)
* [README.md](../../../Gdpr/project_docs/README.md)
* [README.md](../../../Notify/project_docs/phpstan/README.md)
* [README.md](../../../Notify/project_docs/README.md)
* [README.md](../../../Xot/project_docs/filament/README.md)
* [README.md](../../../Xot/project_docs/phpstan/README.md)
* [README.md](../../../Xot/project_docs/exceptions/README.md)
* [README.md](../../../Xot/project_docs/README.md)
* [README.md](../../../Xot/project_docs/standards/README.md)
* [README.md](../../../Xot/project_docs/conventions/README.md)
* [README.md](../../../Xot/project_docs/development/README.md)
* [README.md](../../../Dental/project_docs/README.md)
* [README.md](../../../User/project_docs/phpstan/README.md)
* [README.md](../../../User/project_docs/README.md)
* [README.md](../../../User/project_docs/README.md)
* [README.md](../../../UI/project_docs/phpstan/README.md)
* [README.md](../../../UI/project_docs/README.md)
* [README.md](../../../UI/project_docs/standards/README.md)
* [README.md](../../../UI/project_docs/themes/README.md)
* [README.md](../../../UI/project_docs/components/README.md)
* [README.md](../../../Lang/project_docs/phpstan/README.md)
* [README.md](../../../Lang/project_docs/README.md)
* [README.md](../../../Job/project_docs/phpstan/README.md)
* [README.md](../../../Job/project_docs/README.md)
* [README.md](../../../Media/project_docs/phpstan/README.md)
* [README.md](../../../Media/project_docs/README.md)
* [README.md](../../../Tenant/project_docs/phpstan/README.md)
* [README.md](../../../Tenant/project_docs/README.md)
* [README.md](../../../Activity/project_docs/phpstan/README.md)
* [README.md](../../../Activity/project_docs/README.md)
* [README.md](../../../Patient/project_docs/README.md)
* [README.md](../../../Patient/project_docs/standards/README.md)
* [README.md](../../../Patient/project_docs/value-objects/README.md)
* [README.md](../../../Cms/project_docs/blocks/README.md)
* [README.md](../../../Cms/project_docs/README.md)
* [README.md](../../../Cms/project_docs/standards/README.md)
* [README.md](../../../Cms/project_docs/content/README.md)
* [README.md](../../../Cms/project_docs/frontoffice/README.md)
* [README.md](../../../Cms/project_docs/components/README.md)
* [README.md](../../../../Themes/Two/project_docs/README.md)
* [README.md](../../../../Themes/One/project_docs/README.md)

