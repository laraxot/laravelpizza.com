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

### 🏆 PHPStan Level 10 Compliance (Dicembre 2025)

**Status**: ✅ **0 Errori** (16 → 0)
**Approccio**: Fix, Don't Ignore
**Baseline**: Nessuno

Il modulo Xot ha raggiunto la piena conformità PHPStan Level 10 senza compromessi:
- Zero baseline entries
- Nessuna modifica a phpstan.neon
- Solo correzioni reali del codice
- Type safety al 100%

**Documentazione dettagliata**:
- [PHPStan Patterns Dec 2025](./phpstan-patterns-dec-2025.md)
- [PHPStan Level 10 Success](../../../docs/phpstan-level-10-success.md)

## 🗺️ **Roadmap**
1.  **Consolidamento Documentazione**: Unificare e semplificare la documentazione di tutti i moduli (obiettivo: 500 → 120 file).
2.  **Automazione Script di Merge**: Creare script per la gestione automatica dei conflitti comuni e la validazione pre-commit.
3.  **Aumento Test Coverage**: Portare la copertura dei test per i moduli core sopra il 90%.
4.  **Dashboard Health Check**: Introdurre una dashboard per monitorare lo stato di salute e la compliance di tutti i moduli.

## 🔗 **Link Utili**
- [CHANGELOG](./changelog.md)
- [Guida alla Risoluzione dei Conflitti Git](../../../bashscripts/docs/git-conflict-resolution-guide.md)
- [Convenzioni sui Namespace](./namespace_conventions.md)
- [Linee Guida per il Testing](./testing.md)

## 🤖 **AI Development Tools & Skills**
- [Claude Context (Laravel)](../../../claude.md)
- [AI Agents Guide](../../../../agents.md)
- [Cursor Rules & Skills](../../../../.cursor/readme.md)
- [Skills di progetto](../../../../.cursor/skills/)

## 🔁 **CI & Semantic Versioning**
- Workflow locale del modulo: `.github/workflows/semantic-versioning.yml`
- Scopo: tagging semantico del modulo quando serve rilasciare
 - Attestazione build provenance: step `actions/attest-build-provenance@v3`
 - Workflow root progetto: `/.github/workflows/*.yml`

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- marco sottana <marco.sottana@gmail.com>

**License:** MIT
