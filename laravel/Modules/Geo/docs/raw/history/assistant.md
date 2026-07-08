# PTVX – Assistant Guide (DRY + KISS)

This document is the **entrypoint for AI coding assistants** (Cascade, Claude Code, ecc.) che lavorano su PTVX.

L'obiettivo è essere **DRY + KISS**:

- **DRY**: niente duplicazioni – usa e aggiorna la documentazione esistente.
- **KISS**: concentrati su scopo e business logic, non su dettagli ovvi del framework.

Le regole dettagliate sono già documentate in `docs/` e nei singoli moduli.

---

## 1. Dove iniziare

- **Indice generale**: [PTVX – Documentazione completa](./index.md)
- **Panoramica progetto**: [README root docs](./README.md)
- **Normalizzazione documentazione**: [Guida alla normalizzazione](./documentation-normalization-guide.md)
- **Regole Laraxot/Xot** (core framework):
  - [Xot – README](../laravel/Modules/Xot/docs/README.md)
  - [Laraxot architecture rules](../laravel/Modules/Xot/docs/laraxot-architecture-rules.md)
  - [Laraxot conventions](../laravel/Modules/Xot/docs/laraxot-conventions.md)

Quando devi capire **come funziona qualcosa**, parti sempre da:

1. `docs/index.md` per trovare l'area giusta.
2. La cartella `Modules/<ModuleName>/docs/` del modulo coinvolto.

---

## 2. Regole critiche (riassunto)

Queste sono solo **sintesi**: i dettagli stanno nei documenti linkati.

- **Filament & Laraxot**
  - Non estendere mai direttamente le classi Filament.
  - Usa sempre le classi `XotBase*` (resource, page, widget, relation manager, ecc.).
  - Non usare `->label()`, `->placeholder()`, `->helperText()` nei componenti Filament: le traduzioni sono risolte automaticamente.
  - Riferimento:
    - [Filament best practices](../laravel/Modules/Xot/docs/filament-best-practices.md)
    - [Filament 4 Laraxot rules](../laravel/Modules/Xot/docs/filament-4-laraxot-rules.md)

- **Architettura moduli**
  - Ogni modulo vive in `Modules/<Nome>/app/...` ma il namespace **non** contiene `App`.
  - Modelli estendono il `BaseModel` del proprio modulo, non `Model` diretto.
  - Traduzioni in `Modules/<Nome>/lang/`, non in `resources/lang`.
  - Riferimento: [Module structure](../laravel/Modules/Xot/docs/module-structure.md)

- **Documentazione**
  - Nomi file docs: minuscolo, kebab-case, **senza date** (eccetto `README.md`).
  - Un concetto = un documento; niente varianti con date/versioni nel nome.
  - Focus su **perché** (business logic), non su copie del codice.
  - Riferimento: [Guida normalizzazione documentazione](./documentation-normalization-guide.md)

---

## 3. Workflow di sviluppo e qualità

### 3.1. Static analysis & qualità codice

Per ogni modifica **PHP**:

- Esegui **PHPStan a livello 10** dalla directory `laravel`.
- Usa anche **PHPMD**, **PHPInsights** e **Rector** quando lavori su refactor strutturali o code quality.
- Format con **Laravel Pint** prima di considerare il lavoro finito.

Documenti di riferimento:

- [PHPStan usage (Xot)](../laravel/Modules/Xot/docs/phpstan-usage.md)
- [PHPStan livello 10 – linee guida](../laravel/Modules/Xot/docs/phpstan-livello10-linee-guida.md)
- [Code quality tools guide](../laravel/Modules/Xot/docs/code-quality-tools-guide.md)
- [Validation post-edit rule](./validation-post-edit-rule.md)

### 3.2. Test

- Tutti i test nuovi **devono usare Pest v3**.
- Preferisci test di **feature** con casi d'uso realistici.
- Quando correggi un bug, aggiungi sempre un **test di regressione**.

Riferimenti:

- [Testing (root docs)](./testing/)
- [Testing best practices (Xot)](../laravel/Modules/Xot/docs/testing-best-practices.md)

---

## 4. Documentazione: DRY + KISS

Quando tocchi la documentazione:

- **Cerca prima** se esiste già un documento sul tema (principio DRY).
- **Aggiorna** doc esistenti invece di crearne uno nuovo per piccole variazioni.
- Mantieni il focus su:
  - Scopo del modulo / feature.
  - Regole di business.
  - Flussi principali.
- Evita:
  - Cronistoria dettagliata (usa `CHANGELOG.md` o git).
  - Copie estese del codice.

Documenti chiave:

- [Documentation normalization guide](./documentation-normalization-guide.md)
- [Documentation conventions](./documentation-conventions.md)

---

## 5. Lavorare sui moduli (es. Sigma)

Per qualsiasi modulo (es. **Sigma**):

1. **Leggi prima la documentazione del modulo**:
   - `Modules/Sigma/docs/README.md`
   - `Modules/Sigma/docs/architecture.md`
   - eventuali `business-logic*.md` o `summary.md`

2. **Scopri chi lo usa**:
   - Cerca `Modules\Sigma` nel codice per capire da quali moduli è chiamato.
   - Documenta le dipendenze nel file `module-dependencies.md` del modulo (se esiste) o aggiornalo.

3. **Aggiorna la doc del modulo** seguendo la struttura standard descritta in:
   - [Guida normalizzazione documentazione](./documentation-normalization-guide.md)

4. **Business logic first**:
   - Prima di cambiare codice, chiarisci sempre:
     - Qual è lo scopo del modulo?
     - Quali sono i flussi principali?
     - Quali invarianti di dominio non devono essere violati?

---

## 6. Ruolo di CLAUDE.md

Il file `laravel/CLAUDE.md` ora è solo un **wrapper leggero** che punta alla documentazione ufficiale (questo file e i doc di modulo).

Quando devi capire le regole del progetto:

- Parti da qui (`docs/assistant.md`).
- Usa `docs/index.md` come mappa generale.
- Scendi poi nelle cartelle `Modules/<Modulo>/docs/` per la business logic specifica.

---

## 7. Principio guida finale

Per ogni intervento (codice o doc):

1. **Capisci il contesto** (modulo, business, altri moduli che dipendono da lui).
2. **Rispetta le regole architetturali Laraxot/Xot**.
3. **Mantieni DRY + KISS** (niente duplicazioni inutili, niente documenti prolissi).
4. **Verifica la qualità** (PHPStan livello 10, quality tools, test).
5. **Aggiorna la documentazione più vicina** al codice che hai toccato.
# Assistente AI - Documentazione Base PTVX

## Caratteristiche Principali
- Basato su Claude 3.5 Sonnet
- Comunicazione primaria in italiano
- Specializzato in programmazione Laravel/PHP
- Formattazione risposte in markdown
- Ubicazione progetto: F:\var\www\_bases\base_ptvx\

## Capacità
- Analisi e modifica di codice esistente
- Creazione di nuovi file e componenti
- Gestione della documentazione
- Supporto multilingua (default: italiano)
- Implementazione best practices Laravel/Filament
- Integrazione con Spatie packages
- Debug e risoluzione problemi
- Refactoring del codice

## Struttura del Progetto
### Directory Principali
- /docs - Documentazione del progetto
- /laravel - Applicazione Laravel
  - /app - Core dell'applicazione
  - /Modules - Moduli Laravel
    - Ogni modulo segue la struttura standard Laravel
  - /config - Configurazioni
  - /resources - Assets e views
  - /routes - Definizioni delle rotte

## Best Practices
### Architettura
- Utilizzo di Spatie Laravel Data per Data Transfer Objects
- Preferenza per Spatie QueueableActions invece dei Services
- Aderenza alla filosofia Laravel con Laraxot
- Modularizzazione del codice attraverso Laravel Modules

### Filament Framework
- Estensione di XotBaseResource per le risorse
- Implementazione corretta dei form schema
- Gestione standardizzata delle liste e delle tabelle
- Routing consistente nelle pagine Filament

### Gestione del Codice
- Mantenimento del codice storico (commentato)
- Versionamento dei file (.old)
- Tipizzazione stretta del codice
- Documentazione inline in italiano

## Gestione Documentazione
### Struttura Docs
- /docs
  - project_notes.md - Note tecniche e best practices
  - assistant.md - Documentazione dell'assistente
  - getting-started/ - Guide di installazione e setup

### Principi di Documentazione
- Aggiornamento continuo e incrementale
- Mantenimento della coerenza con il codice
- Documentazione bilingue quando necessario
- Esempi di codice pratici e testati

## Convenzioni di Codice
### Naming
- CamelCase per le classi
- snake_case per le variabili e i metodi
- UPPERCASE per le costanti
- Prefisso "Xot" per le classi base del framework

### File Structure
- Un concetto per file
- Namespace allineati con la struttura delle directory
- Separazione chiara tra interfacce e implementazioni
- Organizzazione modulare del codice

## Workflow di Sviluppo
1. Analisi dei requisiti
2. Verifica della documentazione esistente
3. Implementazione seguendo le best practices
4. Testing e validazione
5. Aggiornamento della documentazione
6. Commit e versionamento

## Troubleshooting
- Consultare /docs/errors.txt per errori comuni
- Verificare i log in storage/logs
- Utilizzare il debugger di Laravel
- Controllare la configurazione dei moduli

## Sicurezza
- Validazione input attraverso Form Requests
- Sanitizzazione output
- Gestione corretta delle autorizzazioni
- Implementazione dei middleware di sicurezza

## Performance
- Utilizzo di cache quando appropriato
- Ottimizzazione delle query database
- Lazy loading delle relazioni
- Minimizzazione degli assets

## Manutenzione
- Backup regolare dei dati
- Aggiornamento delle dipendenze
- Pulizia dei file temporanei
- Monitoraggio dei log
