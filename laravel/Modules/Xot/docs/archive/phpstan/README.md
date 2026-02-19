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
* [README.md](bashscripts/project_docs/readme.md)
* [README.md](bashscripts/project_docs/it/readme.md)
* [README.md](docs/laravel-app/phpstan/readme.md)
* [README.md](docs/laravel-app/readme.md)
* [README.md](docs/moduli/struttura/readme.md)
* [README.md](docs/moduli/readme.md)
* [README.md](docs/moduli/manutenzione/readme.md)
* [README.md](docs/moduli/core/readme.md)
* [README.md](docs/moduli/installati/readme.md)
* [README.md](docs/moduli/comandi/readme.md)
* [README.md](docs/phpstan/readme.md)
* [README.md](docs/readme.md)
* [README.md](docs/module-links/readme.md)
* [README.md](docs/troubleshooting/git-conflicts/readme.md)
* [README.md](docs/tecnico/laraxot/readme.md)
* [README.md](docs/modules/readme.md)
* [README.md](docs/conventions/readme.md)
* [README.md](docs/amministrazione/backup/readme.md)
* [README.md](docs/amministrazione/monitoraggio/readme.md)
* [README.md](docs/amministrazione/deployment/readme.md)
* [README.md](docs/translations/readme.md)
* [README.md](docs/roadmap/readme.md)
* [README.md](docs/ide/cursor/readme.md)
* [README.md](docs/implementazione/api/readme.md)
* [README.md](docs/implementazione/testing/readme.md)
* [README.md](docs/implementazione/pazienti/readme.md)
* [README.md](docs/implementazione/ui/readme.md)
* [README.md](docs/implementazione/dental/readme.md)
* [README.md](docs/implementazione/core/readme.md)
* [README.md](docs/implementazione/reporting/readme.md)
* [README.md](docs/implementazione/isee/readme.md)
* [README.md](docs/it/readme.md)
* [README.md](laravel/vendor/mockery/mockery/project_docs/readme.md)
* [README.md](../../../chart/project_docs/readme.md)
* [README.md](../../../reporting/project_docs/readme.md)
* [README.md](../../../gdpr/project_docs/phpstan/readme.md)
* [README.md](../../../gdpr/project_docs/readme.md)
* [README.md](../../../notify/project_docs/phpstan/readme.md)
* [README.md](../../../notify/project_docs/readme.md)
* [README.md](../../../xot/project_docs/filament/readme.md)
* [README.md](../../../xot/project_docs/phpstan/readme.md)
* [README.md](../../../xot/project_docs/exceptions/readme.md)
* [README.md](../../../xot/project_docs/readme.md)
* [README.md](../../../xot/project_docs/standards/readme.md)
* [README.md](../../../xot/project_docs/conventions/readme.md)
* [README.md](../../../xot/project_docs/development/readme.md)
* [README.md](../../../dental/project_docs/readme.md)
* [README.md](../../../user/project_docs/phpstan/readme.md)
* [README.md](../../../user/project_docs/readme.md)
* [README.md](../../../user/project_docs/readme.md)
* [README.md](../../../ui/project_docs/phpstan/readme.md)
* [README.md](../../../ui/project_docs/readme.md)
* [README.md](../../../ui/project_docs/standards/readme.md)
* [README.md](../../../ui/project_docs/themes/readme.md)
* [README.md](../../../ui/project_docs/components/readme.md)
* [README.md](../../../lang/project_docs/phpstan/readme.md)
* [README.md](../../../lang/project_docs/readme.md)
* [README.md](../../../job/project_docs/phpstan/readme.md)
* [README.md](../../../job/project_docs/readme.md)
* [README.md](../../../media/project_docs/phpstan/readme.md)
* [README.md](../../../media/project_docs/readme.md)
* [README.md](../../../tenant/project_docs/phpstan/readme.md)
* [README.md](../../../tenant/project_docs/readme.md)
* [README.md](../../../activity/project_docs/phpstan/readme.md)
* [README.md](../../../activity/project_docs/readme.md)
* [README.md](../../../patient/project_docs/readme.md)
* [README.md](../../../patient/project_docs/standards/readme.md)
* [README.md](../../../patient/project_docs/value-objects/readme.md)
* [README.md](../../../cms/project_docs/blocks/readme.md)
* [README.md](../../../cms/project_docs/readme.md)
* [README.md](../../../cms/project_docs/standards/readme.md)
* [README.md](../../../cms/project_docs/content/readme.md)
* [README.md](../../../cms/project_docs/frontoffice/readme.md)
* [README.md](../../../cms/project_docs/components/readme.md)
* [README.md](../../../../themes/two/project_docs/readme.md)
* [README.md](../../../../themes/one/project_docs/readme.md)
