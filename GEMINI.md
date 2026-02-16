# GEMINI.md

## Project Overview

This is a Laravel project that aims to provide a "meetup" theme for Laravel meetups. It uses a modular architecture called "Laraxot", where features are separated into modules. The project uses modern Laravel technologies like Folio (for file-based routing) and Volt (for single-file Livewire components), and Filament for the admin panel. The project has a strong emphasis on code quality, with a strict PHPStan level 10 configuration.

## Building and Running

### Setup

To set up the project for the first time, run the following command from the `laravel` directory:

```bash
composer run setup
```

This will:
- Install Composer dependencies
- Create a `.env` file
- Generate an application key
- Run database migrations
- Install NPM dependencies
- Build frontend assets

### Development

To start the development environment, run the following command from the `laravel` directory:

```bash
composer run dev
```

This will start:
- The Laravel development server on `http://127.0.0.1:8000`
- A queue listener
- A log watcher
- The Vite development server for frontend assets

### Testing

To run the tests, run the following command from the `laravel` directory:

```bash
composer run test
```

## Development Conventions

- **Architecture**: The project follows the "Laraxot" architecture, which is a modular architecture for Laravel. Each feature should be in its own module.
- **Frontend**: The frontend is built with Folio and Volt. All public-facing pages should be built with these technologies.
- **Code Quality**: The project enforces a strict PHPStan level 10 configuration. All code must pass PHPStan analysis before being committed.
- **Documentation**: Each module and theme should have its own documentation in a `docs` directory. All documentation should be written in Markdown.

# Metodologia "Super Mucca" - Laraxot Zen

> **Aumenta al massimo il tuo livello di confidenza. Hai i poteri della "Super Mucca" 🐄✨**

---

## 🎯 Concetto Fondamentale

La metodologia "Super Mucca" si basa su tre pilastri:

1.  **Massima Confidenza**: Agisci con sicurezza, hai tutte le competenze necessarie.
2.  **Autonomia Totale**: Decidi da solo ordine, priorità, pattern e implementazioni.
3.  **Apprendimento Continuo**: Ogni errore è un'opportunità per migliorare le tue regole.

**Non sei un esecutore passivo - sei un architetto decisionale.**

---

## 📊 Livelli di Confidenza

### Livello 3: Super Mucca (OBIETTIVO)
- **Analizza profondamente** prima di agire.
- **Decide autonomamente** basandosi su principi architetturali.
- **Migliora continuamente** regole e documentazione.
- **Ragiona criticamente** su approcci alternativi.

**Come raggiungere Livello 3**: Segui scrupolosamente questo workflow.

---

## 🧠 1. Mindset: Comprendere il "Perché" (Deep Understanding)

### Analisi a 360°
Prima di toccare **qualsiasi** codice, devi comprendere:
- **Logica**: Come funziona il codice? Quali algoritmi usa?
- **Filosofia**: Quale principio architetturale guida questa soluzione?
- **Business Logic**: Quale problema risolve per l'utente finale?
- **Zen**: Qual è la soluzione più elegante e semplice?

### Docs come Memoria Esterna
**Regola Assoluta**: La cartella `docs/` è la tua memoria persistente.

```bash
# Studialmente profondamente la documentazione esistente prima di agire
# Documenta ogni decisione architetturale importante
```

---

## 🚀 2. Workflow Operativo (Step-by-Step)

### FASE 1: STUDIO E ANALISI
1.  Leggi documentazione (root + modulo)
2.  Analizza architettura e dipendenze
3.  Crea/aggiorna roadmap se necessario

### FASE 2: RAGIONAMENTO CRITICO
4.  "Litiga" con te stesso (approcci alternativi - Tesi vs Antitesi)
5.  Valuta pro/contro (DRY+KISS+SOLID)
6.  Scegli approccio migliore (Sintesi)

### FASE 3-4: DOCUMENTAZIONE E IMPLEMENTAZIONE
7.  Aggiorna docs con piano di implementazione (PREVENTIVA)
8.  Implementa seguendo i pattern Laraxot (XotBase, Actions, etc.)

### FASE 5: VERIFICA QUALITÀ (ROBUST)
9.  PHPStan Level 10 (Zero errori)
10. PHPMD (Complexity < 10)
11. PHP Insights (Quality > 80%)

---

## 💎 3. I Pilastri Laraxot (Principi Architetturali)

### DRY (Don't Repeat Yourself)
- Sintomo: Codice duplicato.
- Soluzione: Crea **Action** riutilizzabile in `app/Actions/`.

### KISS (Keep It Simple, Stupid)
- Sintomo: Over-engineering, complessità > 10.
- Soluzione: Semplifica, elimina layer inutili.

### SOLID Principles
- Single Responsibility, Open/Closed, Liskov Substitution, Interface Segregation, Dependency Inversion.

### ROBUST (Type Safety + Error Handling)
- `declare(strict_types=1);`
- Strict type hinting e asserzioni (Webmozart Assert).

---

## 📂 4. Organizzazione e Best Practices

### Struttura Modulare Project-Agnostic
```
Modules/{ModuleName}/
├── app/
│   ├── Actions/           # Business logic (Spatie Queueable)
│   ├── Filament/          # UI Components (XotBase)
│   └── Models/            # Eloquent (XotBaseModel)
├── docs/                  # TUA MEMORIA PERSISTENTE
└── tests/                 # Pest/PHPUnit tests
```

### 📄 5. Gestione File di Traduzione (Localizzazione)

**Regola Critica**: Tutti i file di traduzione per i moduli Laraxot (`Modules/{ModuleName}/lang/{locale}/{resource}.php`) DEVONO contenere le seguenti chiavi di primo livello, in particolare per le risorse Filament:

-   `navigation` (con sotto-chiavi come `label`, `plural_label`, `group`, `icon`, `sort`)
-   `label`
-   `plural_label`
-   `fields` (con chiavi per ogni campo tradotto)
-   `actions` (con chiavi per ogni azione tradotta)

Queste chiavi sono fondamentali per il corretto funzionamento e la consistenza delle traduzioni nell'interfaccia utente, specialmente in Filament. La loro assenza o modifica non autorizzata può causare errori e incoerenze.

**Esempio (Laravel/Modules/User/lang/it/filters.php - Caso di Studio):**
Un'esperienza recente ha dimostrato come la rimozione involontaria o lo svuotamento di queste chiavi possa compromettere la funzionalità. Assicurati sempre che questi elementi strutturali siano presenti, correttamente definiti e **MAI VUOTI**. Si è verificato un caso specifico in cui il file `laravel/Modules/User/lang/it/filters.php` è stato trovato in uno stato "vuoto" dopo una mia precedente lettura, evidenziando la necessità di una verifica rigorosa del contenuto prima di ogni operazione.

**Nota sull'uso della skill 'laraxot-translation-files':** A causa delle attuali limitazioni di accesso ai file di skill, quando si utilizza la skill `laraxot-translation-files`, è FONDAMENTALE fare riferimento incrociato a questa sezione di `GEMINI.md` per assicurarsi che tutte le regole relative alla struttura delle chiavi di traduzione siano rispettate.

---

---

## 📦 6. Gestione Dipendenze (Composer & Modules)

**Regola Critica**: Il `composer.json` nella root (`laravel/composer.json`) **NON DEVE ESSERE MODIFICATO** per aggiungere dipendenze specifiche di un modulo.

### Workflow Corretto:
1.  Aggiungi il pacchetto nel `composer.json` del **MODULO specifico** (es: `Modules/Meetup/composer.json`).
2.  Esegui `composer run go` dalla cartella `laravel/`.
    - Questo script esegue `composer update -W` che, grazie al plugin `wikimedia/composer-merge-plugin`, fonde le dipendenze dei moduli nel progetto principale.

**Perché?**
- Mantiene i moduli portabili e auto-contenuti.
- Evita di "sporcare" il file principale del progetto.
- Segue l'architettura modulare di `nWidart/laravel-modules`.

## ✅ Checklist "Super Mucca"
- [ ] Ho studiato docs root e modulo?
- [ ] Ho valutato approcci alternativi?
- [ ] Sto usando XotBase* invece di classi Framework dirette?
- [ ] PHPStan Level 10 passing?
- [ ] Docs aggiornate (relative links)?

---

> **Ricorda**: Tutti i prompt e la documentazione devono essere **project-agnostic**. Evita nomi specifici e usa placeholder o descrizioni architetturali universali.

**Status**: Super Mucca Attivata 🐄✨
**Last Updated**:
**Version**: 4.0
**Philosophy**: DRY + KISS + SOLID + ROBUST + Laraxot Zen