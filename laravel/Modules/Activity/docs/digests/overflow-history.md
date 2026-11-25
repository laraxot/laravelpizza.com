---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 76 file oltre target 100.

### `activity-pdf-reports.md` — Activity Log PDF Reports


# Activity Log PDF Reports

## 📋 Overview

Guida completa per generare report PDF delle attività utente utilizzando HTML2PDF con integrazione nativa nel modulo Activity.

---

## 🎯 Funzionalità PDF

### 1. Report Attività Utente

Genera report completi delle attività di un utente specifico:

```php
use Modules\Activity\Actions\GenerateActivityPdfAction;

// Generate PDF for user activities
$pdf = app(GenerateActivityPdfAction::class)->execute(

### `best-practices.md` — Best Practices – Activity

# Best Practices – Activity

## Principi DRY/KISS
- **DRY**: Centralizza logica di orchestrazione in `ActivityService`. Usa repository pattern per entità.
- **KISS**: Usa ID semplici per identificatori esterni, non UUID complessi in interfacce.
- **Clean Code**: Applica `Spatie Color` per icone tematiche senza duplicare codice.

## Componenti
- Usa `ActivityLog` per registrare eventi critici.
- Usa progetti con `status` calcolato (`active`, `paused`, `completed`).

## Test
- Implementa test di integrazione per flussi di lavoro complessi.
- Copri casi limite come transizioni di stato non valide.

## Documentazione
- Aggiorna `docs/INDEX.md` con nuovi modelli e relazioni.
- Collega a `Projects` e `Tasks` per contesto operativo.
---
title: "Best Practices – Activity"

### `bmad/architecture.md` — Activity — architettura BMAD


---
title: "Activity — architettura BMAD"
type: concept
tags: [architecture, activity, audit, log, event-sourcing, spatie]
created: 2026-09-28
updated: 2026-11-16
qmd: "Activity architettura moduli Spatie activity event sourcing log viewer contratti modelli"
related:
  - ./architecture/module-boundary.md
  - ./architecture/module-map.md
  - ./brainstorming.md
  - ./epics/module-roadmap.md
  - ./README.md
issues: []
discussions: []
---

# Activity — architettura BMAD


### `bmad/audit.md` — Audit BMAD — Activity


# Audit BMAD — Activity

SSoT dettagliata (inventario, evidenze `path:line`, non-finding): [audits/activity-audit.md](./audits/activity-audit.md).

**Scopo in una frase:** Activity risponde a "chi ha cambiato cosa, quando e com'era prima" — in una PA è un obbligo ([purpose.md](./purpose.md)).

## Sintesi (2026-11-16)

| Metrica | Valore |
|---|---:|
| PHP `app/` / test PHP / file `*Test.php` | 92 / 152 / 100 |
| Resource / Actions / Services / Widget | 3 / 30 / 0 / 0 |
| Policy `return true` (solo `before()`) | 2 |
| Marker conflitto / `RefreshDatabase` | 0 / 0 |
| Test file vuoti / punti di skip | 8 / 19 |

## Finding principali

| # | Sev | Finding |

### `bmad/audits/activity-audit.md` — Audit approfondito — Activity


# Audit approfondito — Activity

## Metodo

Source-first, 2026-11-16: inventario filesystem, `rg -n` con `path:line`, lettura dei file
critici (listener, policy, Resource, Action di logging), `git log` sui test svuotati,
PHPStan sul modulo, Pest sullo scratch DB del repo. La documentazione è stata trattata come
ipotesi e verificata sul codice. Nessuna UI o screenshot inventati.

Limiti dichiarati: nessun test runtime del pannello Filament (nessun `Livewire::test` nel
modulo, vedi P1-5); l'esito Pest è nella sezione [Gate](#gate).

## Scopo (perché esiste)

Activity risponde a "chi ha cambiato cosa, quando e com'era prima". In una PA è un obbligo
di accountability, non una curiosità. Vedi [purpose.md](../purpose.md). Conseguenza
progettuale che l'audit usa come criterio: **il registro deve

### `bmad/brainstorming.md` — Activity — brainstorming BMAD


---
title: "Activity — brainstorming BMAD"
type: concept
tags: [brainstorming, activity, decisioni, debito-tecnico, event-sourcing]
created: 2026-09-28
updated: 2026-11-16
qmd: "Activity brainstorming decisioni aperte event sourcing audit log debito migrazioni"
related:
  - ./brainstorming/module-opportunities.md
  - ./architecture/module-map.md
  - ../architecture.md
  - ./epics/module-roadmap.md
issues: []
discussions: []
---

# Activity — brainstorming BMAD

> **SUMMARY**: decisioni prese (con l'evidenza nel codice), problemi aperti

### `bmad/livewire-inventory.md` — Inventario: Livewire HTTP → Filament: modulo Activity


# Inventario: Livewire HTTP → Filament: modulo Activity

**Solo documentazione. Nessun PHP toccato in questo audit.**

Questo file è la SSoT del modulo Activity per la campagna di conversione Livewire → Filament widget. Formato e metodo sono ripresi da [Modules/Cms/docs/bmad/livewire-inventory.md](../../../Cms/docs/bmad/livewire-inventory.md), con la differenza che qui non esiste nemmeno una classe da classificare: il risultato verificato è **zero componenti Livewire**.

## Metodo (codice, non assunzione)

```bash
find Modules/Activity -path '*/vendor/*' -prune -o -name '*.php' -print | xargs grep -l 'extends.*\(Component\|Livewire\)'
find Modules/Activity -iname '*livewire*' -not -path '*/vendor/*'
ls Modules/Activity/app/Http/Livewire/ Modules/Activity/app/Livewire/
grep -rn "@livewire"

### `bmad/piano-miglioramento.md` — Piano di miglioramento — Activity


# Piano di miglioramento — Activity

Derivato dall'[audit](./audits/activity-audit.md).

## P0

1. Bonificare marker/conflict se presenti (ora: 0).
2. Chiudere policy troppo permissive (`return true` ≈ 2) con matrice ruolo×ability.
3. Blocchi sicurezza runtime (auth panel, mass assignment, export) con test negativi.

## P1

1. Portare Services (0) ad Actions Queueable dove applicabile.
2. Alzare copertura test (attuale 152 test / 92 app PHP).
3. Allineare Filament (resources=3) a XotBase* e traduzioni Lang.
4. Spezzare dipendenze inverse verso verticali peer se rilevate con `rg`.

## P2


### `bmad/quick-reference.md` — Activity — BMAD Quick Reference


# Activity — BMAD Quick Reference
---

# Activity — BMAD Quick Reference
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity, bmad]
qmd: "activity   bmad quick reference activity"
---

# Activity: BMAD Quick Reference

## Comandi Rapidi

### Help
```bash
bmad-help
```

### `bmad/setup-guide.md` — Activity — BMAD Setup Guide


# Activity — BMAD Setup Guide
type: note
---

# Activity — BMAD Setup Guide
type: note
type: note
type: note
type: note
type: note
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity, bmad]
qmd: "activity   bmad setup guide activity"
---

# Activity: BMAD Setup Guide


### `bmad/stories/continuazione-domani.md` — Activity — Continuazione Domani


# Activity — Continuazione Domani
  - ./conflict-markers-cleanup-2026-09-22.story.md
---

# Activity — Continuazione Domani
  - ./conflict-markers-cleanup.story.md
updated: 2026-10-07
tags: [docs, activity, bmad]
qmd: "activity   continuazione domani activity"
---

# Activity: Continuazione Domani

## Stato verificato ora (sessione 2026-09-22)

- `conflict-markers-cleanup-2026-09-22` (**done**, riverificato): 90 file `.md`
  in `docs/` + `.github/contributing.md` + `.github/security.md` avevano
  marker di conflitto git mai risolti, in alcuni casi annidati fino a 4 round
  (`docs/00-index.md`: 39 righe marker su 385). Causa reale: il fix del

### `bottlenecks.md` — Colli di Bottiglia e Soluzioni - Modulo Activity


# Colli di Bottiglia e Soluzioni - Modulo Activity

## Panoramica
Questo documento identifica i principali colli di bottiglia nel modulo Activity e fornisce soluzioni dettagliate passo per passo per risolverli.

## 1. Logging Eccessivo delle Attività

### Problema
Il logging indiscriminato di tutte le attività utente può portare a una crescita rapida della tabella `activity_log`, causando degradazione delle performance del database.

### Impatto
- Aumento delle dimensioni del database
- Rallentamento delle query che coinvolgono la tabella `activity_log`
- Maggiore utilizzo di spazio su disco

### Soluzione Passo-Passo

1. **Implementare Politiche di Logging Selettivo**


### `bugfix-filament-facade-namespace.md` — Bugfix: Filament Facade Namespace Error


# Bugfix: Filament Facade Namespace Error

## 🐛 Errore

**Data:** 2025-01-22
**Data:** [DATE]
**File:** `Modules/Activity/app/Filament/Actions/ListLogActivitiesAction.php:69`
**Messaggio:** `Class "Filament\Support\Facades\Filament" not found`

### Stack Trace

```
Modules\Activity\Filament\Actions\ListLogActivitiesAction->Modules\Activity\Filament\Actions\{closure}()
Modules/Activity/app/Filament/Actions/ListLogActivitiesAction.php:69

$panel = Filament::getCurrentPanel();
```

### Contesto

### `business-logic-analysis-1.md` — Activity Module - Business Logic Analysis

# Activity Module - Business Logic Analysis

## Overview
The Activity module provides comprehensive audit logging and event sourcing capabilities for the healthcare_app platform. It tracks user actions, system events, and data changes across all modules.
The Activity module provides comprehensive audit logging and event sourcing capabilities for the Quaeris platform. It tracks user actions, system events, and data changes across all modules.
The Activity module provides comprehensive audit logging and event sourcing capabilities for the healthcare_app platform. It tracks user actions, system events, and data changes across all modules.

## Business Purpose
- **Audit Trail**: Maintain complete audit trails for compliance and security
- **Event Sourcing**: Implement event sourcing patterns f

### `codex-error-fix.md` — codex-error-fix


See canonical documentation: ../../../Themes/docs/shared-components/codex-error-fix.md

### `conflict-resolution.md` — Conflict resolution — Activity (PHP)


# Conflict resolution — Activity (PHP)

## Scopo

I marker `<<<<<<<` / `=======` / `>>>>>>>` nei PHP del modulo Activity
rompevano il bootstrap PHPStan. Risoluzione manuale per preservare audit log,
Actions Spatie Queueable e Filament XotBase.

## Esito

- Marker PHP: **0** in `app/` + `tests/` + `lang` PHP.
- `php -l` verde sui file toccati.
- PHPStan `Modules/Activity`: **0 errori su `app/`**; residui solo in test
  (typing Pest / harness, ~112) documentati nella story.

## Decisioni (perché)

| Area | Scelta |
|------|--------|

### `contracts/authorize-log-access-action.md` — AuthorizeLogAccessAction


# AuthorizeLogAccessAction

Chi puo' consultare e scaricare i file di log. Regola unica usata da `LogViewer::canAccess()` (`app/Filament/Pages/LogViewer.php:62`) e dal download (`LogViewer.php:128`).


## Input

- `?Authenticatable $user`.

## Output

- `bool`: `true` se l'utente ha il ruolo `super-admin` o il permesso `log.viewAny`.

## Invarianti

- **ACT-LOGAUTH-INV-1** — Ospiti (`null`) e utenti che non implementano `UserContract` sono negati.
  Verifica non marcata: `Modules/Activity/tests/Unit/Actions/Log/AuthorizeLogAccessActionTest.php` («denies guests and users that do not implement the project user contract»); nessun `->group('ACT-LOGAUTH-INV-1')`.
- **ACT-LOGAUTH-INV-2** — Se il permesso `log.viewAny` non esiste nel database l'accesso e' negato senza errore (`PermissionDoesNotE

### `contracts/download-log-file-action.md` — DownloadLogFileAction


# DownloadLogFileAction

Risposta HTTP di download per un file di log scelto dall'utente. Il percorso passa da `ResolveLogFilePathAction`.

## Input

- `string $file`: percorso relativo a `storage/logs`, come da `ResolveLogFilePathAction`.

## Output

- `BinaryFileResponse`: download con nome file = percorso relativo con `/` sostituito da `_`, `Content-Type: text/plain; charset=UTF-8`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGDL-INV-1` | Un file fuori da `storage/logs`, non `.log` o inesistente non produce risposta: viene rilanciata `InvalidLogFileException`. | `DownloadLogFileActionTest.php` («refuses files outside the log directory…») |
| `ACT-LOGDL-INV-2` | La risposta è `BinaryFileResponse`: il file è letto a blocchi dal disco, non caricato in memoria. | `Downloa

### `contracts/index-2.md` — Indice dei contratti — Activity


# Indice dei contratti — Activity

Copertura = `coperto` solo se per ogni ID esiste `->group('<ID>')` nei test del modulo
(`rg -n "group\('ACT-" laravel/Modules/Activity/tests`: nessun risultato). Esiste solo il gruppo `no-activity-db` (in `tests/Unit/Datas/ActivityConfigDataTest.php` e `tests/Unit/Actions/RedactModelAttributesActionTest.php`), che non e' un ID di invariante.

| Operazione | Contract | Classe | Invarianti | Copertura | Comando |
|---|---|---|---|---|---|
| Risolvere il file di log scelto dall'utente | [resolve-log-file-path-action](resolve-log-file-path-action.md) | `Modules\Activity\Actions\Log\ResolveLogFilePathAction` | ACT-LOGPATH-INV-1, ACT-LOGPATH-INV-2, ACT-LOGPATH-INV-3, ACT-LOGPATH-INV-4 | non coperto (test esistenti senza group) | `vendor/bin/pest --group=ACT-LO

### `contracts/log-activity-action.md` — LogActivityAction


# LogActivityAction

Scrive una riga in `activity_log`. È il punto comune usato da `LogModel*Action`, `LogUser*Action`.

## Input

- Costruttore: `string $type` (non vuoto), `?Model $user`, `?Model $subject`, `?array $properties`, `?string $description`.
- `execute()`: nessun argomento.

## Output

- `Activity`: la riga creata.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-LOGACT-INV-1` | `$type` vuoto lancia `InvalidArgumentException('Type cannot be empty')` al costruttore. | `LogActivityActionConstructorTest.php` |
| `ACT-LOGACT-INV-2` | Un `$user` non null che non è `UserContract` lancia `InvalidArgumentException('User must implement UserContract')` in `execute()`. | `LogActivityActionExecuteValidationTest.php` |

### `contracts/log-model-updated-action.md` — LogModelUpdatedAction


# LogModelUpdatedAction

Registra l'evento `updated` di un modello Eloquent con valori precedenti, nuovi e modificati.

## Input

- Costruttore: `?Model $model`, `?Model $user`. `execute(?Model $model = null)`: se passato, prevale sul costruttore.

## Output

- `Activity` con `event = 'updated'`, `description = '<Basename> updated'`, `properties = ['old' => getOriginal(), 'new' => getAttributes(), 'changes' => getChanges()]`.

## Invarianti

| ID | Regola | Test |
|---|---|---|
| `ACT-MUPDATE-INV-1` | Senza modello lancia `InvalidArgumentException('A model is required')`. | Test: nessuno che asserisca il messaggio |
| `ACT-MUPDATE-INV-2` | Il tipo è `updated`; `properties` ha le chiavi `old`, `new`, `changes`. | Test: nessuno sulle chiavi |
| `ACT-MUPDATE-INV-3` | `changes` è quello che i

### `contracts/resolve-log-file-path-action.md` — ResolveLogFilePathAction


# ResolveLogFilePathAction

Unico punto in cui l'input dell'utente del visualizzatore di log (`Filament/Pages/LogViewer.php`) diventa un percorso su disco; lettura (`BuildLogViewerStateAction`) e download (`DownloadLogFileAction`) passano da qui.


## Input

- `string $relativePath`: percorso relativo scelto dall'utente.
- `?string $baseDirectory`: cartella dei log; se `null` e' `storage/logs` (`ResolveLogDirectoryAction`).

## Output

- `ResolvedLogFileData(absolutePath, relativePath)` con percorso reale e percorso relativo normalizzato con `/`.

## Invarianti

- **ACT-LOGPATH-INV-1** — Percorso vuoto o con byte nullo e' rifiutato (`InvalidLogFileException::invalidPath`).
  Verifica non marcata: `Modules/Activity/tests/Unit/Actions/Log/ResolveLogFilePathActionTest.php` («rejects files th

### `contracts/restore-activity-action.md` — RestoreActivityAction


# RestoreActivityAction

Ripristina un record con i valori precedenti di un'attività (`old` di un evento `updated`). Chiamata da `ListLogActivities` (riga 193).

## Input

- `Model $record`: record da aggiornare.
- `array<string, mixed> $oldProperties`: valori da riportare; non vuoto.
Riporta un record ai valori che aveva prima di una modifica, presi dalle `properties.old` di un'attività registrata.
Chiamante: la pagina `app/Filament/Pages/ListLogActivities.php` (azione «ripristina» sulla cronologia di un record).
Sorgente: `app/Actions/RestoreActivityAction.php`.

Test: `cd laravel && vendor/bin/pest Modules/Activity/tests/Unit/Actions/RestoreActivityActionExecuteTest.php`.

## Input

- `Model $record`: il record da ripristinare.
- `array<string, mixed> $oldProperties`: i valori preceden

### `contracts/template.md` — <operazione> — contratto comportamentale


# <operazione> — contratto comportamentale

Classe o superficie: `<FQCN>`  
Riferimento nel codice: `@contract docs/contracts/<file>.md`

## Input

- <input e validazione>

## Output

- <risultato osservabile>

## Invarianti

| ID | Regola | Verifica |
|---|---|---|
| `<MODULE>-INV-1` | <regola che deve restare vera> | <test o controllo ripetibile> |


### `database/migrations.md` — Migrazioni del modulo Activity


# Migrazioni del modulo Activity

Questo documento descrive le migrazioni del database per il modulo Activity. Ogni migrazione include un docblock e un type hint `Blueprint $table` per migliorare la leggibilità e l'analisi statica con PHPStan.

## 2023_03_31_103350_create_activity_table.php
- Crea la tabella `activity` con i campi:
  - `id`, `log_name`, `description`, `subject`, `causer`, `properties`, `batch_uuid`, `event`, indici su `log_name`
- Utilizza una closure tipizzata e documentata:
  ```php
  /**
   * @param Blueprint $table
   */
  function (Blueprint $table) {
      // definizione colonne...
  }
  ```

## 2023_10_30_103350_create_stored_events_table.php
- Crea la tabella `stored_events` per l'Event Sourcing con i campi:

### `decision-log.md` — Decision Log — Activity

# Decision Log — Activity

## Decisions

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `bc3d22ca`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `bc3d22ca` (07/10 06:35), l'ultimo commit prima degli eventi del 07/10 (copia vecchia fusa alle 10:59, re-import).
- **Over**: Tenere le versioni portate dagli eventi, o il commit `68803a66` di Marco dell'08/10 sui 4 file che tocca.
- **Because**: Ogni contenuto sovrascritto e' stato verificato come gia' esistente prima del 07/10 (241 su 241).
  - 241 toccati solo dagli eventi: contenuto da `bc3d22ca`. Tra questi tornano le firme con `UserContract` al posto della classe concreta `User` (`ActivityLogger`, `GetActivityStatisticsAction`, `GetUserActivitiesAc

### `errori/duplicate-entry-accessor-save.md` — Errore: Duplicate Entry Durante Activity Log


# Errore: Duplicate Entry Durante Activity Log

## Problema

```
SQLSTATE[23000]: Integrity constraint violation: 1062
Duplicate entry '9075' for key 'indennita_responsabilita.PRIMARY'
```

**Quando**: Durante il salvataggio di una modifica in Filament EditRecord
**Trigger**: Spatie Activity Log cerca di serializzare le properties
**Causa**: Accessor che chiamano `$this->save()` al loro interno

## Business Logic

### Scenario Utente

Un amministratore modifica un record IndennitaResponsabilita esistente (ID 9075):
1. Apre `/indennita-responsabilitas/9075/edit`

### `errori/modulo-disabilitato.md` — Errore: Modulo Activity Disabilitato


# Errore: Modulo Activity Disabilitato

## Descrizione del Problema

Quando il modulo Activity è disabilitato, il ServiceProvider non viene caricato e di conseguenza:
- Il view namespace `activity::` non viene registrato
- Tutte le pagine che estendono `ListLogActivities` generano l'errore "No hint path defined for [activity]"
- Le feature del modulo non sono disponibili

## Sintomi

### Errore Tipico

```
InvalidArgumentException
No hint path defined for [activity].
```

### Route Interessate

### `errori/no-hint-path-defined.md` — Errore: No hint path defined for [activity]


# Errore: No hint path defined for [activity]

## Descrizione dell'Errore

```
InvalidArgumentException - Internal Server Error
No hint path defined for [activity].
```

Questo errore si verifica quando Laravel non riesce a risolvere il namespace "activity" per le view Blade, tipicamente quando si tenta di accedere a una pagina che estende `ListLogActivities` del modulo Activity.

## Contesto dell'Errore

### Stack Trace Tipico

```
0 - vendor/laravel/framework/src/Illuminate/View/FileViewFinder.php:111
1 - vendor/laravel/framework/src/Illuminate/View/FileViewFinder.php:89
2 - vendor/laravel/framework/src/Illuminate/View/Factory.php:150

### `errori/route-method-does-not-exist.md` — Errore: Method ::route does not exist


# Errore: Method ::route does not exist

## Descrizione dell'Errore

```
BadMethodCallException
Method Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\ListSchedaLogActivities::route does not exist.
```

Errore che si verifica durante il bootstrap dell'applicazione quando Filament tenta di registrare le pagine di una Resource.

## Contesto dell'Errore

### Stack Trace Critico

```
0 - vendor/laravel/framework/src/Illuminate/Macroable/Traits/Macroable.php:89
1 - Modules/IndennitaResponsabilita/app/Filament/Resources/IndennitaResponsabilitaResource.php:63
```

### `errori-migrazione-activity-table-lezioni-1.md` — Lezioni Apprese: Errori Migrazione Activity Table

# Lezioni Apprese: Errori Migrazione Activity Table

## Caso Studio: Errore Critico nella Modifica Migrazione Activity

### 🚨 **ERRORE COMMESSO**
Ho creato una **NUOVA** migrazione `2025_08_22_140500_update_activity_table_causer_nullable.php` per modificare la tabella `activity_log`, violando le regole fondamentali Laraxot.

### ✅ **APPROCCIO CORRETTO APPRESO**
Per modificare una tabella esistente:
1. **MODIFICARE** direttamente la migrazione originale `2023_03_31_103351_create_activity_table.php`
2. **AGGIORNARE** il timestamp nel nome file (es. `2024_01_15_103351_create_activity_table.php`)
3. **NON creare** mai nuove migrazioni separate per modifiche

## 🧠 **PRINCIPI ARCHITETTURALI COMPRESI**

### 1. Single Source of Truth
**Principio**: Una tabella = Una migrazione
**Motivazione**:
- T

### `event-sourcing.md` — event-sourcing


See canonical documentation: ../../../Themes/docs/shared-components/event-sourcing-duplicate.md

### `filament/archive/filament-v4-upgrade-2.md` — Documento unificato


# Documento unificato

Questo file era un duplicato esatto che differiva solo per maiuscole/minuscole, in violazione della regola no-case-only-variations. Il contenuto canonico si trova in [filament_v4_upgrade.md](./filament_v4_upgrade.md).
# Filament v4 Upgrade Documentation

## Overview
This document outlines the key changes and upgrades implemented for Filament v4 in the Activity module.

## Key Changes Made

### 1. Schema-based Resource Definitions
- **Updated**: `ActivityResource` now uses `getFormSchema()` method
- **New Pattern**: Returns array of `Filament\Schemas\Components\Component`
- **Migration**: Moved from v3 `form(Form $form)` to v4 schema approach

```php
// v4 Approach (Current)
public static function getFormSchema(): array
{

### `filament-actions-usage.md` — Filament Actions nel Modulo Activity


# Filament Actions nel Modulo Activity

## Panoramica

Il modulo Activity fornisce Actions Filament riutilizzabili per semplificare l'integrazione dell'Activity Log nelle Resources.

## Business Logic

**Problema DRY**: Senza Actions riutilizzabili, ogni Resource deve implementare manualmente:
```php
// ❌ Codice ripetuto in ogni Resource
Action::make('activities')
    ->label('Cronologia')
    ->tooltip('Visualizza storico modifiche')
    ->icon('heroicon-o-clock')
    ->color('gray')
    ->url(fn ($record) => MyResource::getUrl('log-activity', ['record' => $record]))
    ->visible(fn ($record) => $record->activities()->exists())
```

### `filament-resource-guidelines-1.md` — Activity Module Filament Resource Guidelines

# Activity Module Filament Resource Guidelines

## Extension Patterns

All Filament resources in the Activity module MUST extend `XotBaseResource` and follow the Laraxot extension patterns.

### ✅ Correct Pattern

```php
use Modules\Activity\Models\Activity;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ActivityResource extends XotBaseResource
{
    protected static ?string $model = Activity::class;

    public function getFormSchema(): array
    {
        return [
            // Form schema components only

### `filaments.md` — filaments


See canonical documentation: ../../../Themes/docs/shared-components/filament-errors-duplicate.md

### `file-naming-rules.md` — file-naming-rules


See canonical documentation: ../../../Themes/docs/shared-components/file-naming-rules.md

### `glossary.md` — Glossario di dominio Activity


# Glossario di dominio Activity

Termini verificati nel codice con `rg`. Se glossario e codice divergono vale il codice.
Percorsi relativi a `laravel/Modules/Activity/`.

| Termine | Significato | Nel codice |
|---|---|---|
| Attivita' (Activity) | Riga di audit: cosa e' successo (`description`, `event`), a quale record (`subject_*`), chi l'ha causato (`causer_*`), con `properties`. | `app/Models/Activity.php`, risorsa `app/Filament/Resources/ActivityResource.php` |
| Subject | Record Eloquent su cui e' avvenuta l'attivita'. | colonne `subject_type`, `subject_id` di `Activity` |
| Causer | Utente che ha causato l'attivita'; se non indicato si usa `Auth::id()`. | colonne `causer_type`, `causer_id`, `LogActivityAction::execute()` |
| Log name / tipo | Etichetta con cui l'attivita' e' regist

### `index-generated.md` — Activity Module Documentation Index

# Activity Module Documentation Index

**Stats**: 698 files | 20 categories | Last update: 2026-07-28 10:45

## Quick Navigation

- [Root Documentation](.) | [Wiki](wiki/) | [Architecture](architecture/) | [Use Cases](use_cases/) | [Tasks](tasks/)
- [Roadmap](roadmap/) | [Development](development/) | [Schema](schema/) | [Testing](testing/)

## Documentation by Category

### Root (292 files)

Strategic, foundational, and consolidated documentation at module level:

**Core Documentation** (Key files)
  - [architecture.md](architecture.md): System architecture and design patterns
  - [api-2.md](api.md): API reference and endpoints
  - [database-schema.md](database-schema.md): Database schema definitions
  - [quick-start.md](quick-start.md): Quick start guide

### `investigation/activity-investigation.md` — Investigation: Activity Audit Log

# Investigation: Activity Audit Log

## Problem Statement
Il sistema Activity attualmente non dispone di un audit log completo per tracciare lo stato delle segnalazioni nel tempo. Sono presenti solo stati singoli senza tracciamento temporale intermedio.

## Current State
- Sono presenti documenti BMAD storici (STORY-401 in Fixcity) ma non nel modulo Activity
- Il modulo Activity ha architettura consolidata (Filament, Folio, Actions) ma manca la funzionalità audit trail temporale
- I competitor (FixMyStreet, SeeClickFix, Decoro Urbano) hanno tutti sistemi di timeline completi

## Root Cause Analysis
- Il modello dati non include timestamp per stati intermedi (solo stato finale `status` enum)
- Non esiste un'Action per registrare i cambiamenti di stato
- Non esiste una Folio page per visuali

### `investigation/investigation.md` — Investigation: Audit Log Completamento Workflow

# Investigation: Audit Log Completamento Workflow

## Problem Statement
Analisi delle feature mancanti nel modulo Activity.

## Current State
- Documentazione esistente: 40 stories
- Architettura: Actions,Adapters,Console,Contracts,Datas,Enums,Events,Exceptions,Filament,Http,Listeners,Models,Providers,Support,Traits,View,

## Feature Missing
1. Feature A - descrizione
2. Feature B - descrizione
3. Feature C - descrizione

## Proposed Solution
- Implementare le feature A/B/C usando le regole BMAD
- Seguire: no controller, no services layer, module providers manifest

## Acceptance Criteria
- [ ] APCA contrast ≥75 body, ≥45 large-bold

### `jpgraph.md` — jpgraph


See canonical documentation: ../../../Themes/docs/shared-components/jpgraph-guide.txt

### `list-log-activities-improvements.md` — ListLogActivities UI/UX Improvements - 2025-12-04


# ListLogActivities UI/UX Improvements - 2025-12-04

## Data Intervento: 2025-12-04
# ListLogActivities UI/UX Improvements - [DATE]

## Data Intervento: [DATE]

## Obiettivo

Migliorare la pagina `ListLogActivities` seguendo i principi DRY + KISS e la filosofia Laraxot, con particolare attenzione alla "description" come richiesto.

## Miglioramenti Implementate

### 1. Header Contestuale Informativo

**Prima:** Header assente o minimale
**Dopo:** Header completo con contesto del record e statistiche

```php

### `manuale-uso-attori.md` — Manuale d'uso per attori

# Manuale d'uso per attori

## Scopo

Activity registra attivita', eventi e snapshot e offre risorse Filament e consultazione dei log. L'accesso alle risorse e' espresso da permessi granulari; il log viewer ha una regola separata.

## Attori e capacita'

| Attore | Capacita' verificata | Verifica |
|---|---|---|
| Ospite | N/A verificato. | Le policy richiedono un `UserContract`; il log viewer rifiuta un utente non compatibile. |
| Utente normale autenticato | Puo' eseguire ogni azione per cui possiede il relativo permesso (`activity.*`, `stored_event.*`, `snapshot.*`); senza permesso N/A verificato. | [ActivityPolicy](../app/Models/Policies/ActivityPolicy.php#L15-L65), [StoredEventPolicy](../app/Models/Policies/StoredEventPolicy.php), [SnapshotPolicy](../app/Models/Policies/SnapshotPolicy

### `manuals/manuale-utente.md` — Manuale d'uso per attori


> Screenshot reale del front office FixCity, verificato il 23 novembre 2026. Per questo modulo è una superficie condivisa: il manuale non attribuisce al modulo una UI propria se non documentata dalle fonti.

![Screenshot reale del front office](assets/front-office-home.png)

# Manuale d'uso per attori

## Scopo

Activity registra attivita', eventi e snapshot e offre risorse Filament e consultazione dei log. L'accesso alle risorse e' espresso da permessi granulari; il log viewer ha una regola separata.

## Attori e capacita'

| Attore | Capacita' verificata | Verifica |
|---|---|---|
| Ospite | N/A verificato. | Le policy richiedono un `UserContract`; il log viewer rifiuta un utente non compatibile. |
| Utente normale autenticato | Puo' eseguire ogni azione per cui possiede il relativo per

### `manuals/user-manual.md` — Manuale utente Activity


# Manuale utente Activity

Integra il [manuale actor-oriented](../manuale-uso-attori.md). Activity conserva audit, eventi e snapshot usati dai moduli autorizzati.

## Attori e uso

| Attore | Uso verificato |
|---|---|
| Utente normale/gruppo | Non gestisce direttamente l'audit; le proprie operazioni possono essere registrate. |
| Operatore/admin/auditor | Consulta attività secondo policy e risorse esposte. |
| Super-admin | Governa accesso globale all'audit. |

La cronologia non va modificata per correggere una visualizzazione.

## Evidenza visuale reale

![Schermata reale documentata del modulo Activity](../../screenshots/event-detail-page.png)

Schermata reale presente nella documentazione del modulo.

### `merge-conflict-files-list.md` — merge-conflict-files-list


See canonical documentation: ../../../Themes/docs/shared-components/merge-conflict-files-list.md

### `metodiuplicati-analisi.md` — metodiuplicati-analisi


See canonical documentation: ../../../Themes/docs/shared-components/metodi-duplicati-analisi-Modules.md

### `migration-filament.md` — migration-filament


See canonical documentation: ../../../Themes/docs/shared-components/.gitkeep

### `migrazione-filament.md` — migrazione-filament


See canonical documentation: ../../../Themes/docs/shared-components/migrazione-filament-4-Modules.md

### `modelli-factory-seeder-analisi-1.md` — Analisi Modelli, Factory e Seeder - Moduli Activity, Gdpr, Tenant, UI, <nome progetto>, Xot

# Analisi Modelli, Factory e Seeder - Moduli Activity, Gdpr, Tenant, UI, <nome progetto>, Xot

## Modulo Activity

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Activity** | ✅ ActivityFactory | ✅ ActivityDatabaseSeeder | Core - Log attività sistema |
| **Snapshot** | ✅ SnapshotFactory | ❌ | Core - Snapshot stati |
| **StoredEvent** | ✅ StoredEventFactory | ❌ | Core - Eventi archiviati |
| **BaseModel** | ❌ | ❌ | Abstract |
| **BaseActivity** | ❌ | ❌ | Abstract |
| **BaseSnapshot** | ❌ | ❌ | Abstract |
| **BaseStoredEvent** | ❌ | ❌ | Abstract |

### Modelli Obsoleti
- **BaseActivity.php.no** - 🗑️ File backup da rimuovere

### Seeder Mancanti
1. **SnapshotSeeder** - Per snapshot esempi

### `performance-optimization.md` — Performance Optimization — Module **Activity**


# Performance Optimization — Module **Activity**

## Ottimizzazioni Applicate

### 1. On-Demand Loading (principale)

**Prima**: Bootstrap caricava tutte le rules (50K+ token)
**Dopo**: Carico solo what's needed (~2K startup)

```diff
- 150+ rules embeddate in AGENTS.md
+ 0 rules embeddate — tutte on-demand

- 150+ rules embeddate in AGENTS.md
+ 0 rules embeddate — tutte on-demand

- 150+ rules embeddate in AGENTS.md+ 0 rules embeddate — tutte on-demand
```


### `philosophy-complete.md` — Activity - Filosofia Completa: Logica, Religione, Politica, Zen


# Activity - Filosofia Completa: Logica, Religione, Politica, Zen

**Data Creazione**: 2025-12-23
**Data Creazione**: [DATE]
**Status**: Documentazione Filosofica Completa
**Versione**: 1.0.0

## 📋 Indice Filosofico

1. [Logica (Logic)](#logica-logic)
2. [Religione (Religion)](#religione-religion)
3. [Politica (Politics)](#politica-politics)
4. [Zen (Zen)](#zen-zen)
5. [Manifestazioni Pratiche](#manifestazioni-pratiche)

---

## 🧠 Logica (Logic)


### `phpinsightss.md` — phpinsightss


See canonical documentation: ../../../Themes/docs/shared-components/phpinsights-errors-Modules.md

### `phpmd-analysis.md` — PHPMD Analysis & Fixes - Activity Module


# PHPMD Analysis & Fixes - Activity Module

## 📊 Current Status

### ✅ COMPLETED FIXES (18/25 issues)

- **CamelCase Method Names**: All test methods already compliant
- **Unused Formal Parameters**: Fixed in all Policies and Listeners
- **CamelCase Property Names**: Fixed in ServiceProviders

### 🚨 REMAINING ISSUES (7 issues)

#### 1. High Coupling (MEDIUM) - 2 files

- `ActivityLogger.php` - 13 dependencies (threshold: 13)
- `ListLogActivities.php` - 13 dependencies (threshold: 13)

#### 2. Else Expression (LOW) - 2 files


### `phpmd.md` — phpmd


See canonical documentation: ../../../Themes/docs/shared-components/phpmd-analysis.md

### `phpmds.md` — phpmds


See canonical documentation: ../../../Themes/docs/shared-components/phpmd-errors-Modules.md

### `phpstan-analysis-november.md` — PHPStan Analysis - Activity Module - November 2025

# PHPStan Analysis - Activity Module - November 2025

## Risultato Analisi

**Data Analisi:** 6 Novembre 2025  
**PHPStan Level:** 10 (Massimo)  
**File Analizzati:** 102  
**Data Analisi:** 24 Novembre 2025
**PHPStan Level:** 10 (Massimo)
**File Analizzati:** 106
**Data Analisi:** 6 Novembre 2025  
**PHPStan Level:** 10 (Massimo)  
**File Analizzati:** 102  
**Errori Trovati:** 0 ✅

## Status

✅ **MODULO COMPLETAMENTE CONFORME**

Il modulo Activity è completamente conforme all'analisi PHPStan livello 10, dimostrando:

### `phpstan.md` — phpstan


See canonical documentation: ../../../Themes/docs/shared-components/phpstan-report-Modules.txt

### `prd-2.md` — Product Requirements Document (PRD) - Activity Module

# Product Requirements Document (PRD) - Activity Module

**Module**: Activity
**Version**: 1.0
**Status**: Draft
**Author**: Product Team

## Executive Summary
Activity tracking and audit logging module for Laraxot platform.

## Functional Requirements
- Audit trail for all user actions
- Activity logging with Spatie Laravel Activity Log
- Filament resource for activity browsing
- Integration with all modules

## Technical Specifications
- PHPStan Level 10 compliance
- Pest test coverage >90%
- Integration with Xot base models

### `prompts/01.md` — Prompt 01 — Folio non va in `ActivityServiceProvider`


# Prompt 01 — Folio non va in `ActivityServiceProvider`

## Cosa è sbagliato

```php
Folio::path(module_path($this->name, 'resources/views/pages'))
    ->middleware(['*' => ['web']]);
```

nel provider Activity (anche dentro `booted()`).

## Perché / senso

1. **Owner**: solo `Cms\FolioVoltServiceProvider` (mai `App\Providers\FolioServiceProvider`, mai mount nel provider Activity).
2. **DRY**: altrimenti ogni modulo ripete lo stesso mount.
3. **Catch-all**: la prima registrazione Folio vince; un mount locale può interferire con Filament/tema.
4. Activity resta owner di **config/comportamento**, non del router globale.

## Verifica

### `quality-status-nov.md` — quality-status-nov


See canonical documentation: ../../../Themes/docs/shared-components/quality-status-2025-11.md

### `query-optimization.md` — query-optimization


See canonical documentation: ../../../Themes/docs/shared-components/query-optimization-analysis-3.md

### `roadmap-miglioramenti.md` — Activity — cosa migliorare (visione, non lamento)

# Activity — cosa migliorare (visione, non lamento)
---
title: "Activity: cosa migliorare (visione, non lamento)"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity]
qmd: "activity   cosa migliorare (visione, non lamento) activity"
---
# Activity: cosa migliorare (visione, non lamento)

I numeri misurati (PHPStan, PHPMD, PHPInsights, coverage, casi di test) sono
in [`docs/cosa-migliorare.md`](cosa-migliorare.md), rilevati il 2026-09-01
da un altro agente dopo il ripristino di `vendor/`. Questo documento non li
ripete: li legge, e ci aggiunge quello che un grep sull'anagrafica del
modulo (composer.json, struttura `docs/`) fa emergere e che una tabella di
gate non cattura.

## Il vero bug non è nel codice, è nella cartella docs/


### `roadmap.md` — 🎯 ACTIVITY MODULE - ROADMAP 2025

# 🎯 ACTIVITY MODULE - ROADMAP 2025

**Modulo**: Activity ([Description])  
**Status**: 0% COMPLETATO  
**Priority**: MEDIUM  
**PHPStan**: 🚧 Level 0 (N/A errori)  
**Filament**: 🚧 4.x Compatibile  

---

## 🎯 MODULE OVERVIEW

Il modulo **Activity** [descrizione del modulo].

### 🏗️ Architettura Modulo
```
Activity Module
├── 🏛️ Core Features
│   ├── [Feature 1]
│   ├── [Feature 2]

### `security.md` — Security Documentation

# Security Documentation

## Security Overview

This document outlines security considerations, best practices, and compliance requirements for the Activity module.

## Security Standards

### 1. Input Validation

All external inputs must be validated using Laravel's built-in validation mechanisms:

```php
// Example: User input validation
public function store(Request $request)
{
    $validated = $request->validate([
        'activity_type' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:1000'],
        'ip_address' => ['nullable', 'ip'],

### `stories/phpstan-cleanup-activity-wave.dev.md` — [DEV] PHPStan cleanup — Activity


# [DEV] PHPStan cleanup — Activity

## Technical Plan

- Costanti: tipi nativi, nessun enum (configurazione e liste di opzioni)
- Per le classi anonime: riusare le fixture esistenti prima di crearne di nuove

## Files to Modify

- `app/Actions/Log/{ReadLogTail,ListLogFiles,FilterLogEntries,ParseLogEntries,BuildLogViewerState}Action.php`, `app/Actions/RedactModelAttributesAction.php`, `app/Filament/Pages/LogViewer.php`
- `tests/Feature/ActivityBusinessLogicTest.php`, `tests/PestStubs.php`
- `tests/Unit/CanPaginateTest.php`, `tests/Unit/Actions/RestoreActivityActionExecuteTest.php`, `tests/Unit/Filament/ListLogActivitiesPureMethodsTest.php`
- `tests/Fixtures/RestoreActivityRecordingModel.php`, `RestoreActivityFailingUpdateModel.php`, `RestoreActivityEmptyModel.php`, `ListLogActivitiesTransl

### `structure.md` — Modulo Activity


# Modulo Activity

Data: [DATE] 19:09:55
Data: 2025-04-23 19:09:55
Data: [DATE] 19:09:55Data: 2025-04-23 19:09:55
Data: [DATE] 19:09:55

## Informazioni generali

- **Namespace principale**: Modules\\Activity
Modules\\Activity\\Database\\Factories
Modules\\Activity\\Database\\Seeders
Workbench\\App
Workbench\\Database\\Factories
Workbench\\Database\\Seeders
- **Pacchetto Composer**: laraxot/module_activity_fila5
Marco Sottana
- **Dipendenze**: spatie/laravel-activitylog * spatie/laravel-event-sourcing * repositories type path url ../Xot type path url ../Tenant type path url ../UI scripts post-autoload-dump
- **Totale file PHP**: 55

### `troubleshooting/properties-vuote-activity-log.md` — Troubleshooting: Properties Vuote in Activity Log


# Troubleshooting: Properties Vuote in Activity Log

## Problema

Le attività vengono create correttamente (description='updated', subject registrato), ma le **properties sono VUOTE** - non vengono salvati i dati dei campi modificati.

## Sintomo

```php
$activity = Activity::latest()->first();
echo $activity->description;  // "updated" ✅ OK
echo $activity->subject_type;  // "Modules\..." ✅ OK
print_r($activity->properties);  // [] ❌ VUOTO!
```

**Risultato**: Non puoi vedere QUALI campi sono stati modificati e quali erano i valori vecchi/nuovi.

## Causa Radice


### `use-cases/tracking-email-sent-schede.md` — Use Case: Tracking Email Sent - Schede Valutazione


# Use Case: Tracking Email Sent - Schede Valutazione

## 📋 Overview

Caso d'uso concreto: Tracciamento invio email schede valutazione nel modulo Ptv.

**Modulo:** Ptv (Provincia di Treviso)
**Action:** `LogSchedaEmailSentAction`
**Integrazione:** `SendMailByRecord`

---

## 🎯 Business Requirements

### Obiettivi

1. **Audit Trail Completo**
   - Tracciare ogni invio email scheda (successi E fallimenti)
   - Registrare data/ora precisa

### `use_cases/bank/05-analysis-larabank.md` — 05-analysis-larabank


See canonical documentation: ../../../../../Themes/docs/shared-components/05-analisi-larabank.md

### `use_cases/bank/best-practice.md` — best-practice


See canonical documentation: ../../../../../Themes/docs/shared-components/.gitkeep

### `use_cases/prediction_market/11-architettura-moduli-vs-domain.md` — Architettura a Moduli vs Domain per <nome progetto>ion Market


# Architettura a Moduli vs Domain per <nome progetto>ion Market

## Introduzione
Un <nome progetto>ion market può essere implementato sia seguendo una struttura a moduli (Laravel Modules) sia una struttura a bounded context (Domain). Qui spieghiamo differenze, vantaggi, svantaggi e best practice.

## Struttura a Moduli (Laravel Modules)
- Ogni modulo è un dominio funzionale isolato (es. <nome progetto>ionMarket, User, Payment).
- Ogni modulo ha la sua `app/`, `config/`, `database/`, `resources/`, `routes/`, `tests/`, `composer.json`, `module.json`.
- Ideale per progetti enterprise, multi-team, multi-prodotto.
- Esempio:
```
Modules/
  <nome progetto>ionMarket/
    app/Events/
    app/Actions/
    app/Projectors/
    app/Reactors/
    app/Models/
    app/Providers/

### `use_cases/shop/05-analysis-laravel-shop-main.md` — 05-analysis-laravel-shop-main


See canonical documentation: ../../../../../Themes/docs/shared-components/05-analisi-laravel-shop-main.md

### `use_cases/shop/06-analysis-laravel-shop-command-bus.md` — 06-analysis-laravel-shop-command-bus


See canonical documentation: ../../../../../Themes/docs/shared-components/06-analisi-laravel-shop-command-bus.md

### `use_cases/shop/console-commands-2.md` — console-commands-2


See canonical documentation: ../../../../../Themes/docs/shared-components/.gitkeep-Modules
- `digests/archive-raw.md`
