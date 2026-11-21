# Conversione Tenant Services a Spatie Queueable Actions — Piano Decisionale

**Data**: 2026-10-20
**Modulo**: Tenant
**Path sorgente**: `laravel/Modules/Tenant/app/Services/`
**Obiettivo**: Convertire i servizi a Spatie Queueable Actions preservando la logica esistente e documentando le decisioni.

---

## 1. Pattern di riferimento (DbForge)

Il pattern QueueableAction utilizzato nel progetto si basa su:

```php
use Spatie\QueueableAction\QueueableAction;

class NomeAction
{
    use QueueableAction;

    public function execute(...): mixed
    {
        // logica sincrona
    }
}
```

- Sincrono: `app(NomeAction::class)->execute($data)`
- Asincrono: `app(NomeAction::class)->dispatch($data)` (in coda)
- Il trait `QueueableAction` aggiunge `dispatch()` e usa `__invoke` o `execute()`.
- Package: `spatie/laravel-queueable-action` (già installato in `vendor/`).

Esempio reale nel progetto: `Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction` (usa QueueableAction, execute(), dispatch()).

---

## 2. Inventario servizi da valutare

| # | File | Tipo | Stato |
|---|------|------|-------|
| 1 | `TenantService.php` | Static facade / utility | **Non convertibile** — giustificato (vedi §3.1) |
| 2 | `ConfigResolverRegistry.php` | Service locator / registry | **Non convertibile** — giustificato (vedi §3.2) |
| 3 | `ConfigResolverInterface.php` | Contract / interface | **Non convertibile** — giustificato (vedi §3.3) |
| 4 | `Config/Resolvers/MorphMapConfigResolver.php` | Stateful resolver | **Non convertibile** — giustificato (vedi §3.4) |
| 5 | `Config/Resolvers/DatabaseConfigResolver.php` | Stateful resolver | **Non convertibile** — giustificato (vedi §3.5) |
| 6 | `Config/Resolvers/StandardConfigResolver.php` | Stateful resolver (fallback) | **Non convertibile** — giustificato (vedi §3.6) |

---

## 3. Analisi dettagliata per file

### 3.1 TenantService.php — Static-only utility

**Scopo**: Classe di utilità statica che funge da facade per l'accesso alla configurazione tenant. Contiene 11+ metodi statici (`getName`, `filePath`, `config`, `getConfig`, `saveConfig`, `modelClass`, `model`, `localizedMarkdownPath`, `trans`, `getConfigNames`, `allModules`).

**Motivazione della non-conversione**:
- È già un **fasade statico** che delega l'implementazione a QueueableActions esistenti:
  - `getName()` → `GetTenantNameAction::execute()`
  - `filePath()` → `GetTenantFilePathAction::execute()` *(vedi azione esistente)*
  - `config()` → `ResolveTenantConfigValueAction::execute()`
  - `getConfig()` → `FilterConfigStringKeysAction::execute()`
  - `saveConfig()` → `SaveTenantConfigAction::execute()`
  - `getConfigNames()` → `GetTenantConfigNamesAction::execute()`
  - `modelClass()` → `ResolveTenantModelClassAction::execute()`
  - `model()` → `ResolveTenantModelInstanceAction::execute()`
  - `localizedMarkdownPath()` → `GetLocalizedMarkdownPathAction::execute()`
- Convertire TenantService stesso a QueueableAction **romperebbe l'API statica** usata in tutto il progetto (es. `TenantService::config('app.name')`, `TenantService::getName()`).
- Il pattern QueueableAction prevede un **singolo metodo `execute()`** con uno scopo specifico. TenantService è una **classe multi-scopo**.

**Decisione**: **TENERE** TenantService come static facade. Aggiornare i metodi statici per delegare correttamente a QueueableActions se non già delegati, mantenendo pieno backward compatibility.

**To-due**: Verificare che `filePath()` delegi a `GetTenantFilePathAction` (già presente ma non usato). Aggiornare `getConfigNames()` per usare l'azione esistente.

> Nota: il metodo `filePath()` è **esplicitamente menzionato come target**. Esiste già l'azione `GetTenantFilePathAction` in `Modules/Tenant/app/Actions/Config/`. Si tratta quindi di far delegare il metodo statico a questa action.

### 3.2 ConfigResolverRegistry.php — Service Locator

**Scopo**: Registro che contiene istanze di `ConfigResolverInterface` e trova il resolver appropriato per una data chiave di configurazione. È un **pattern Registry/Locator**, non un'azione discriminata.

**Motivazione della non-conversione**:
- Non ha uno scopo singolo di "esecuzione con input/output". È uno **strumento di iniezione dipendenza** con ciclo di vita.
- I resolver sono **stateless singletons** gestiti dal registry. Convertirli a QueueableAction romperebbe il pattern di selezione tramite `canResolve()` + `resolve()`.
- Non ci sono motivi per inviare in coda l'intero registry.

**Decisione**: **TENERE** come Registry. Non conversione.

### 3.3 ConfigResolverInterface.php — Contract

**Scopo**: Interfaccia che definisce `canResolve(string $key): bool` e `resolve(...)`. È un **contratto**, non un'implementazione.

**Motivazione della non-conversione**:
- Un'interfaccia non può né deve usare QueueableAction (è un trait per implementazioni concrete).
- Il contratto garantisce polimorfismo tra MorphMap, Database e Standard resolvers.

**Decisione**: **TENERE** come interface contract.

### 3.4 MorphMapConfigResolver.php — Resolver per morph_map

**Scopo**: Risolve configurazione `morph_map` per il panel admin, fondendo modelli del modulo, configurazione originale e configurazione tenant. Dipende fortemente da `Request::segment(2)`, `inAdmin()`, e `getModuleModels()`.

**Motivazione della non-conversione**:
- Implementa `ConfigResolverInterface` con due metodi (`canResolve`, `resolve`), non `execute()`.
- È **stateless e selettivo** (viene usato solo quando `canResolve` è true), non un'azione da dispatchare in coda.
- La logica dipende da **Request in corso** — non idonea a dispatch asincrono (il request context non è disponibile in coda).
- `Config::set()` modifica lo stato globale del processo corrente, il che non funziona in queue worker.

**Decisione**: **TENERE** implementazione. Non convertire a QueueableAction. La logica esistente è corretta per suo scopo.

### 3.5 DatabaseConfigResolver.php — Resolver per database

**Scopo**: Risolve configurazione database unendo connessioni per i moduli (aggiunge connessioni modulo-specifiche). Implementa `ConfigResolverInterface`.

**Motivazione della non-conversione**:
- Stessa ragione di §3.4: implementa interfaccia con `canResolve()`+`resolve()`, stateless, selettivo, dipende da `Module::toCollection()` e da `config()`.
- La logica di merging delle connessioni database è **operazione da eseguire in request**, non in coda.

**Decisione**: **TENERE** implementazione.

### 3.6 StandardConfigResolver.php — Fallback resolver

**Scopo**: Resolver di fallback per qualsiasi chiave di configurazione. Implementa `ConfigResolverInterface`. Delega a `DatabaseConfigResolver` per la chiave `database`.

**Motivazione della non-conversione**:
- È il **fallback** del registry (canResolve ritorna sempre `true`).
- Implementa interfaccia con `canResolve()`+`resolve()`.
- Delega internamente a `DatabaseConfigResolver` per `database`.

**Decisione**: **TENERE** implementazione.

---

## 4. Azioni QueueableAction esistenti nel modulo Tenant

Queste azioni sono **già** QueueableActions e rappresentano l'implementazione reale della logica che i servizi esposti offrono:

| Azione | Path | Delega |
|--------|------|--------|
| `GetTenantNameAction` | `Actions/GetTenantNameAction.php` | `TenantService::getName()` |
| `GetTenantFilePathAction` | `Actions/Config/GetTenantFilePathAction.php` | `TenantService::filePath()` |
| `GetTenantConfigPathAction` | `Actions/Config/GetTenantConfigPathAction.php` | `TenantService::getConfigPath()` |
| `GetTenantConfigArrayAction` | `Actions/Config/GetTenantConfigArrayAction.php` | `TenantService::getConfig()` |
| `SaveTenantConfigAction` | `Actions/Config/SaveTenantConfigAction.php` | `TenantService::saveConfig()` |
| `GetTenantConfigNamesAction` | `Actions/Config/GetTenantConfigNamesAction.php` | `TenantService::getConfigNames()` |
| `ResolveTenantConfigValueAction` | `Actions/Config/ResolveTenantConfigValueAction.php` | `TenantService::config()` |
| `FilterConfigStringKeysAction` | `Actions/Config/FilterConfigStringKeysAction.php` | utilità riuso in più azioni |
| `ResolveTenantModelClassAction` | `Actions/Models/ResolveTenantModelClassAction.php` | `TenantService::modelClass()` |
| `ResolveTenantModelInstanceAction` | `Actions/Models/ResolveTenantModelInstanceAction.php` | `TenantService::model()` |
| `GetLocalizedMarkdownPathAction` | `Actions/Markdown/GetLocalizedMarkdownPathAction.php` | `TenantService::localizedMarkdownPath()` |
| `MergeRecursiveStringKeyConfigAction` | `Actions/Config/MergeRecursiveStringKeyConfigAction.php` | utilità riuso in più azioni |

Questo conferma che **l'architettura QueueableAction è già in atto** per la logica business del Tenant. I servizi in `app/Services/` sono **facade statiche** che delegano a queste azioni.

---

## 5. Piano modifiche (concreto)

### 5.1 TenantService.php
- **Obiettivo**: far delegare `filePath()` all'esistente `GetTenantFilePathAction` (se non già).
- Verificare la coerenza dei deleghi (es. `getName`, `getConfig`, `saveConfig`).
- **Nessun metodo reso QueueableAction** — la classe rimane static facade.
- Aggiungere PHPDoc `@see` cross-reference verso le azioni delegate.

### 5.2 ConfigResolverRegistry / Interface / Resolvers
- **Nessuna modifica funzionale**.
- **Aggiungere PHPDoc** che documenti che i resolver implementano `ConfigResolverInterface` (non QueueableAction) e il perché.

### 5.3 Documentazione
- Questo file (`queueable-actions-conversion-plan.md`) documenta le decisioni.
- Aggiornare `conflict-resolutiones.md` se rilevante.

---

## 6. Riepilogo decisionale

> **Chiave**: QueueableAction è indicato per **azioni discrete con input/output** che possono essere eseguite in coda. Non è indicato per **facade statiche, registry, interface, e resolver stateful che dipendono da Request/Config globale**.

| Servit\izione | Convertibile? | Motivo sintetico | Azione |
|--------------|---------------|-------------------|--------|
| TenantService | ❌ No | Static facade multi-metodo, già delegante a QueueableActions | TENERE, rafforzare deleganze |
| ConfigResolverRegistry | ❌ No | Service locator, non azione | TENERE |
| ConfigResolverInterface | ❌ No | Contract/interface | TENERE |
| MorphMapConfigResolver | ❌ No | Stateful, Request-dipendente, implementa interfaccia | TENERE |
| DatabaseConfigResolver | ❌ No | Stateful, implementa interfaccia, non queue-safe | TENERE |
| StandardConfigResolver | ❌ No | Fallback resolver, implementa interfaccia, stateful | TENERE |

---

## 7. Note tecniche aggiuntive

### Perché i resolver non vanno bene per le code
1. **`Config::set()`**: modifica lo stato del repository di configurazione Laravel del processo corrente. Un queue worker ha un processo separato — le modifiche andrebberoperse.
2. **`Request::segment()`**: disponibile solo nel request lifecycle, non in queue worker.
3. **`canResolve()`**: è un metodo discriminatore usato dal registry, non un punto di ingresso di azione.

### Coerenza con DbForge
Il modulo DbForge usa QueueableAction per azioni come `GenerateModelByTableAction` (singola responsabilità: generare un modello). È lo stesso pattern applicato in Tenant per le QueueableActions già esistenti.

---

## 8. Conclusione

La conversione vera e propria a QueueableAction **è già stata effettuata** tramite le QueueableActions in `app/Actions/`. I servizi in `app/Services/` sono **facade statiche** che delegano a queste azioni. Non è necessario né corretto convertire a QueueableAction:

- La `ConfigResolverInterface` e i resolver sono un **pattern Registry/Strategy** distinti, che risolvono un problema diverso (selezionare il resolver giusto per una chiave).
- `TenantService` è un **service facade**, non un'azione.

Le modifiche consigliate sono:
1. Documentare le decisioni (questo file).
2. Verificare e rafforzare i deleganze in `TenantService` verso le QueueableActions esistenti.
3. Aggiungere cross-reference `@see` nel PHPDoc.
```
