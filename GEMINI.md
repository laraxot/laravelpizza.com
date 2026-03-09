# GEMINI.md

🚨 **CRITICAL**: This project is worked on by **MULTIPLE autonomous AI agents simultaneously**. See `.cursor/rules/MULTI_AGENT_HARMONY.md` and `.cursor/rules/GITHUB_MULTI_AGENT_COMMUNICATION.md` for coordination protocols.

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

# Metodologia "Super Mucca" - Laraxot Zen (Updated 2026-03-05)

> **Aumenta al massimo il tuo livello di confidenza. Hai i poteri della "Super Mucca" 🐄✨**
> **Multi-Agent Harmony**: Lavora in armonia con gli altri agenti. Prima di iniziare un task, controlla se altri ci stanno lavorando o lo hanno completato. Non andare necessariamente in ordine per limitare collisioni.
> **Safe Deletion**: NON cancellare mai file; rinominali concatenando `.old`.
> **Coordination**: Utilizza GitHub Issues e GitHub Discussions per comunicare con gli altri agenti AI. Leggi sempre l'elenco delle issues attive prima di iniziare un nuovo modulo o task.

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
- **Coordina con altri agenti** via GitHub issues e discussions (CRITICAL!)

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
- **Multi-Agent Coordination**: Sempre aggiornare `docs/coverage-plan.md` e altri file di tracking per segnalare l'avancemento ed evitare sovrapposizioni.
- **Documentation First**: Aggiorna sempre `docs`, `rules`, `memories` e `skills` riflettendo le nuove scoperte o regole.

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

## 🎬 7. Action Execution Rules (Spatie Queueable Actions)

**Regola Critica**: Le Actions sono il cuore della business logic in Laraxot. Devono seguire queste regole INVIOLABILI:

### Regola 1: Il metodo pubblico è SEMPRE `execute()`

❌ **SBAGLIATO:**
```php
app(CreateClientAction::class)->createPersonalAccessClient($data);
```

✅ **CORRETTO:**
```php
app(CreatePersonalAccessClientAction::class)->execute($data);
```

**Perché?**
- Spatie Queueable Actions impone un unico entry point: `execute()`.
- Un'Action = Una Responsabilità = Un `execute()`.
- Se serve un comportamento diverso, crea una Action DIVERSA (es. `CreatePersonalAccessClientAction`), non un metodo diverso sulla stessa classe.
- API prevedibile e uniforme in tutto il codebase.

### Regola 2: MAI usare Dependency Injection pesante nel costruttore

❌ **SBAGLIATO:**
```php
public function __construct(
    private readonly DatabaseManager $dbManager,
    private readonly LoggerInterface $logger,
    private readonly Hasher $hasher,
    private readonly SafeStringCastAction $safeStringCastAction,
) {}
```

✅ **CORRETTO:**
```php
class CreatePersonalAccessClientAction
{
    use QueueableAction;

    public function execute(ClientData $data): OauthClient
    {
        // Le dipendenze si risolvono inline via app() se servono
        // oppure si iniettano SOLO quelle strettamente necessarie
        // (max 1-2 nel costruttore, MAI 4-5)
    }
}

// Invocazione:
app(CreatePersonalAccessClientAction::class)->execute($data);
```

**Perché?**
- **KISS**: Il container di Laravel (`app()`) risolve automaticamente tutte le dipendenze. Specificarle manualmente nel costruttore è boilerplate ridondante.
- **DRY**: Il container sa già come risolvere tutto; riscrivere le dipendenze è duplicazione.
- **Disaccoppiamento**: Il chiamante NON deve conoscere le dipendenze interne dell'Action.
- **Spatie Design**: `app(Action::class)->execute()` è il pattern per cui Spatie Queueable Actions è stato progettato.
- **Leggibilità**: Meno codice = meno complessità = meno bug.

### Pattern Corretto Completo
```php
<?php

declare(strict_types=1);

namespace Modules\{ModuleName}\Actions;

use Spatie\QueueableAction\QueueableAction;

class DoSomethingAction
{
    use QueueableAction;

    /**
     * Se serve una dipendenza, max 1-2 e solo se strettamente necessarie.
     * Preferire app() inline per dipendenze occasionali.
     */
    public function execute(SomeData $data): SomeResult
    {
        // Business logic qui
        // Per dipendenze occasionali: app(OtherAction::class)->execute(...)
    }
}

// Invocazione SEMPRE così:
app(DoSomethingAction::class)->execute($data);
```

---

## 🎬 8. Dynamic Event Loading and SEO-Friendly URLs

**Principio**: Gli eventi sul frontend (es. `/it/events`) sono caricati dinamicamente dal database utilizzando il modello `Modules\Meetup\Models\Event` e configurazioni specificate in file JSON (es. `config/local/laravelpizza/database/content/pages/events.json`).

### Workflow Dettagliato:

1.  **Configurazione JSON**: File come `events.json` definiscono un `content_block` di tipo `events` che include una chiave `query`. Questa `query` specifica il `model` (es. `Modules\Meetup\Models\Event`), `scope`, `orderBy`, `direction` e `limit`.
2.  **Folio Page (`[slug].blade.php`)**: La pagina Folio generica (es. `Themes/Meetup/resources/views/pages/[slug].blade.php`) utilizza il componente `<x-page />` per renderizzare il contenuto basato sul JSON.
3.  **Componente `<x-page />`**: Questo componente (`Modules/Cms/resources/views/components/page.blade.php`) itera sui `content_blocks` definiti nel JSON e include la vista specificata in `block->view`, passando `block->data` (inclusa la `query`) come props.
4.  **Componente `events.list`**: Il componente Blade `pub_theme::components.blocks.events.list` (es. `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`) riceve la `query` configurata. Se non sono passati eventi hardcoded, costruisce una query Eloquent dinamica usando il `model`, `scope`, `orderBy`, `direction` e `limit` per recuperare gli eventi dal database.
5.  **`toBlockArray()`**: Il metodo `toBlockArray()` del modello `Modules\Meetup\Models\Event` trasforma l'istanza del modello in un array formattato per il Blade, includendo la generazione dell'URL dell'evento utilizzando l'attributo `slug` (es. `'/it/events/' . $this->slug`), garantendo URL SEO-friendly.
6.  **Dettaglio Evento (SEO)**: La stessa pagina Folio `[slug].blade.php` gestisce anche le pagine di dettaglio degli eventi. Se lo slug nel percorso della URL corrisponde allo `slug` di un evento esistente (`Modules\Meetup\Models\Event::where('slug', $eventSlug)->first()`), renderizza il componente `pub_theme::components.blocks.events.detail` con i dati dell'evento, garantendo URL di dettaglio SEO-friendly.

**Conclusione**: Il sistema è progettato per caricare dinamicamente gli eventi e generare URL basate sullo slug, aderendo ai principi Laraxot di configurazione basata sui dati e URL pulite. La "hardcoding" di eventi non dovrebbe essere necessaria se il `slug` è correttamente popolato nel modello `Event`.

---

## 🎬 9. Pragmatic StaticAccess Decisions

**Principio**: Mentre la metodologia "Super Mucca" e Laraxot incoraggiano la minimizzazione dell'accesso statico per migliorare testabilità e disaccoppiamento, alcune eccezioni sono considerate pragmatiche e accettabili nel contesto di questo progetto, data la natura di specifici framework e librerie.

### Eccezioni Accettabili per StaticAccess:

1.  **Filament Components e Actions**:
    *   Le chiamate statiche a componenti e azioni di Filament (es. `DatePicker::make()`, `EditAction::make()`) sono intrinseche al design idiomatico di Filament per la costruzione di form, tabelle e azioni. Rifattorizzare queste chiamate a un approccio non statico comporterebbe una complessità ingiustificata e una deviazione significativa dalle best practice di Filament. Vengono quindi mantenute.
2.  **Eloquent Model Queries in Test**:
    *   L'accesso statico a metodi di query del modello Eloquent (es. `Event::count()`, `Event::where()`) all'interno dei test è considerato standard e non introduce problemi di testabilità significativi in questo contesto. Vengono mantenute.
3.  **`Webmozart\Assert\Assert`**:
    *   Questa libreria di asserzioni è progettata con un'API statica e il suo utilizzo in modo statico è il pattern d'uso previsto. Vengono mantenute.
4.  **`Carbon` e `Illuminate\Support\Carbon`**:
    *   Le chiamate statiche a `Carbon::now()`, `Carbon::parse()` (e i loro equivalenti in `Illuminate\Support\Carbon`) sono helper fondamentali e onnipresenti in Laravel per la manipolazione di date e orari. Sostituirle con dependency injection aggiunge complessità senza un chiaro beneficio pragmatico in molti contesti. Vengono mantenute.
5.  **`LaravelLocalization::localizeURL()`**:
    *   L'utilizzo del facade `LaravelLocalization` per la localizzazione degli URL è una funzionalità specifica e ben definita. Iniettare il servizio di localizzazione per ogni utilizzo aggiungerebbe boilerplate. Vengono mantenute.

**Giustificazione**: In questi casi specifici, il costo in termini di complessità e deviazione dai pattern idiomatici supera i benefici teorici della completa eliminazione dell'accesso statico. La decisione è basata sulla pragmatica e sull'aderenza alle convenzioni dei framework utilizzati, bilanciando la rigorosità con l'efficienza di sviluppo e la leggibilità del codice.

---

## ✅ Checklist "Super Mucca"
- [ ] Ho studiato docs root e modulo?
- [ ] Ho valutato approcci alternativi?
- [ ] Sto usando XotBase* invece di classi Framework dirette?
- [ ] PHPStan Level 10 passing?
- [ ] Docs aggiornate (relative links)?

---

## 🎬 10. Documentazione, Script e Robustezza (Aggiornamento 2026-03-02)

**Regola Critica**: Tutti i file `.md` (eccetto `README.md` e `CHANGELOG.md`) devono seguire queste convenzioni:
1. **Naming**: Solo caratteri minuscoli, niente date nei nomi dei file, niente caratteri speciali (usare solo hyphen `-` o underscore `_`).
2. **Contenuto**: Rimuovere riferimenti a date fisse come "Last Updated", "Ultimo aggiornamento" o "[DATE]". La documentazione deve essere agnostica rispetto al tempo.
3. **PRD**: Ogni modulo e tema DEVE avere un file `PRD.md` nella sua cartella `docs/` che descriva requisiti e architettura.
4. **Archive**: Le cartelle `archive/` dentro `docs/` sono vietate.
5. **Links**: Usare sempre link relativi tra i file di documentazione.

**Regola Critica**: Posizione degli Script:
1. Tutti gli script (`.sh`, `.py`, ecc.) devono risiedere in una sottocartella appropriata di `bashscripts/`.
2. È vietato avere script nella root, in `laravel/` o dentro le cartelle dei moduli (es. `Modules/Xot/bashscripts` è vietato).
3. Lo script `generate_coverage.sh` è in `bashscripts/testing/generate-coverage.sh`.

**Regola Critica**: Robustezza e Tipi:
1. L'uso del tipo `mixed` è vietato, se non come ultimissima spiaggia. Preferire sempre tipi specifici, union types o generics.
2. I test devono sempre usare `.env.testing` e puntare al database di test (es. `laravelpizza_data_test`).
3. **100% Pest Coverage + Type Coverage**: È obbligatorio raggiungere il 100% di test coverage (Pest) E il 100% di type coverage per ogni modulo e tema, con particolare focus sulle Spatie Actions.
   - **Code Coverage**: `php artisan test --coverage --min=100`
   - **Type Coverage**: `php artisan test --type-coverage --min=100`
   - Tutti i parametri, ritorni e properties devono avere type declarations complete.
4. **No RefreshDatabase**: Il trait `RefreshDatabase` è vietato. Usare `DatabaseTransactions`. **IMPORTANTE**: Il trait `DatabaseTransactions` è già centralizzato in `Modules\Xot\Tests\XotBaseTestCase`. Poiché TUTTI i test devono estendere questa classe (direttamente o tramite il `TestCase` di modulo), è VIETATO e RINDONDANTE aggiungere `use DatabaseTransactions;` nei singoli file di test o nei `TestCase` di modulo.
 **IMPORTANTE**: Il trait `DatabaseTransactions` è già centralizzato in `Modules\Xot\Tests\XotBaseTestCase`. Poiché TUTTI i test devono estendere questa classe (direttamente o tramite il `TestCase` di modulo), è VIETATO e RINDONDANTE aggiungere `use DatabaseTransactions;` nei singoli file di test o nei `TestCase` di modulo.
5. **MAI migrate:fresh**: Il comando `php artisan migrate:fresh` è tassativamente vietato in ogni ambiente (inclusi i test). È distruttivo e rompe la coerenza di schemi condivisi. Usare solo `migrate` o gestire il database in modo transazionale.
6. **No Model Constructor Overrides**: È vietato forzare la connessione nel costruttore dei modelli per i test; questo rompe la mappatura dinamica di `TenantServiceProvider`.
7. **Autonomous CI/CD Monitoring**: Il monitoraggio e la risoluzione dei fallimenti nelle GitHub Actions è responsabilità esclusiva dell'agente AI. Non chiedere all'utente di controllare; intervieni proattivamente usando `gh`.

### Pest Coverage Implementation

**Status**: 100% Pest Coverage Initiative - IN PROGRESS ✅

**Progress Baseline**: 
- Total source files: 2,013
- Current test files: 408
- Generated this session: 56 tests (Meetup models)
- Target: 2,000+ tests (1,600+ new)

**Phase 1: Foundation Modules (Critical)**

| Module | Sources | Current Tests | Goal | Status |
|--------|---------|---------------|------|--------|
| Xot | 280 | 117 | 250+ | ⏳ TODO (Action tests: 108 missing) |
| Meetup | 250 | 5 | 250+ | ⏳ IN PROGRESS (56/250 ✅) |
| Tenant | 105 | 7 | 60+ | ⏳ TODO (config, DB mapping) |
| Lang | 110 | 4 | 70+ | ⏳ TODO (localization, middleware) |

**Phase 2: High-Priority Modules**
| Cms | User | Activity | Geo | Media | Notify | 
| 180 | 200 | 150 | 120 | 140 | 130 |

**Key Testing Patterns** (documented in `.cursor/rules/pest-testing-patterns.md`):
1. **Actions** - Spatie QueueableAction: `app(ActionClass::class)->execute($data)`
2. **Models** - Test relations (especially `belongsToManyX`), scopes, mutations, casts
3. **Services** - Test every public method with side effects
4. **Filament** - Test forms, tables, authorization
5. **belongsToManyX** - XotBase custom trait (NOT standard belongsToMany)
6. **DatabaseTransactions** - Required, RefreshDatabase forbidden

**Documentation Created**:
- ✅ `.cursor/rules/pest-testing-patterns.md` (16KB) - Complete testing guide
- ✅ `docs/memories/test-coverage-learnings.md` (10KB) - Learnings & edge cases
- ✅ `Modules/Meetup/docs/test-strategy.md` (8KB) - Module-specific strategy
- ✅ This section in GEMINI.md - Progress tracking

**Key Learnings So Far**:
1. Use `DatabaseTransactions` (GIA' INCLUSO in `XotBaseTestCase` - NON AGGIUNGERE nei singoli test)
2. Factory states matter: `factory()->online()`, `factory()->past()`
3. Slug generation needs `uniqid()` for uniqueness
4. CMS integration: test `toBlockArray()` and `toSchemaOrg()`
5. Schema.org structured data for SEO
6. Cross-connection relations (User DB ↔ Meetup DB)
7. Anonymous class mocks fail strict typing

**References**:
- Full testing guide: `.cursor/rules/pest-testing-patterns.md`
- Implementation learnings: `docs/memories/test-coverage-learnings.md`
- Coverage progress: GitHub issues #191-205
- Related commits: dd3958759, e594a7f60, 98cfec88b

---

---

## ✅ 11. Multi-Agent Coordination via GitHub (🚨 CRITICAL - 2026-03-05)

**CARDINAL RULE**: We are multiple AI agents. **ALWAYS check GitHub Issues & Discussions BEFORE starting work.**

### 🚨 NEVER Assume You're Alone
Other agents have likely already:
- Fixed test failures you see
- Started work on your target module
- Resolved configuration issues
- Updated documentation

### GitHub Communication Protocol
**See**: `docs/GITHUB-AGENT-COMMUNICATION.md` (complete guide)

**Before Starting ANY Work**:
```bash
# 1. Check GitHub Issues
gh issue list --label "coverage" --state open
# Look for [AGENT-WORK] issues on YOUR target module

# 2. Check Discussions
gh discussion list
# Search for recent updates on your module

# 3. IF starting work, CREATE issue
gh issue create \
  --title "[AGENT-WORK] ModuleName - YourTask" \
  --label "coverage,in-progress,module-name"

# 4. Work
# 5. Close issue when done
gh issue close <number>
```

### Key Coordination Rules
1. **Check GitHub Issues first** - is anyone on your module?
2. **Create [AGENT-WORK] issue** when starting - mark status: IN PROGRESS
3. **Use Discussions** for questions ("Who's tested Geo?", "Found pattern for X")
4. **Update issue** when done: mark completed, link to commit
5. **Choose low-collision modules** if your target is taken: Geo, Job, Seo, Gdpr

### Database Connections
| Module | Connection | Migrated |
|--------|-----------|----------|
| User | `user` | ✅ 2026-03-05 |
| Meetup | `meetup` | ✅ 2026-03-05 |
| Geo, Job, Others | default | ✅ |

### Current Status (2026-03-05 14:50 UTC)
- **Tests Passing**: 2,866+ (RoleTest fixed: 17 passing)
- **Coverage Target**: 100% code + 100% type
- **Modules In Progress** (check GitHub Issues for current work)
- **Communication**: GitHub Issues + Discussions + coverage-plan.md

---

> **Ricorda**: Tutti i prompt e la documentazione devono essere **project-agnostic**. Evita nomi specifici e usa placeholder o descrizioni architetturali universali.

**Status**: Super Mucca Attivata 🐄✨ | 100% Pest Coverage In Progress ✅ | Multi-Agent Coordination Active 🤝
**Last Updated**: 2026-03-05 14:40 UTC
**Version**: 4.2
**Philosophy**: DRY + KISS + SOLID + ROBUST + Laraxot Zen + Test Coverage First + Parallel Execution
- **Validation is Mandatory**: NEVER claim a task is finished without executing automated tests (`pest`) and static analysis (`phpstan`). A task is only complete when the behavioral correctness is verified and the code is syntactically perfect.
- **Ralph Loop Integration**: Use `/ralph-loop` for highly iterative tasks. Persistence and self-correction are mandatory.
- **Git Forward-only Strategy**: Git history moves only forward. Do not use `reset --hard`, `revert`, or `checkout` to restore old versions. Old code can be studied for understanding, but fixes must be applied as new commits.
- **Module Consolidation Rule (STRICT)**: DO NOT create granular modules. Use existing ones.
  - **Forbidden Event Modules**: `Event`, `EventCategory`, `EventFeedback`, `EventLocation`, `EventRegistration`, `EventSchedule`, `EventSpeaker`, `EventSponsor`, `EventTag`, `EventTicket`, `EventAttendee`, `EventOrganizer`. Use `Modules/Meetup`.
  - **Forbidden Forum Modules**: `ForumAnnouncement`, `ForumSubscriber`, `ForumTemplate`. Use `Modules/Meetup` (for community) or `Modules/Cms` (for generic).
- **Script Location Standard**: ALL scripts (`.sh`, `.php`, `.py`) MUST reside in a subfolder of `./bashscripts/` (e.g., `./bashscripts/automation/`). 
  - Scripts must be documented in `./bashscripts/docs/`.
  - NO scripts are allowed in the project root or `laravel/` root.