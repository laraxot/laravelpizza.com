---
title: "Overflow history (ceiling 100)"
type: digest
status: active
qmd: "digest ceiling 100 overflow-history"
---

# Overflow history (ceiling 100)

Overflow force-cap: 40 file oltre target 100.

### `bmad/stories/0001-phpstan-l10-tenant-sushi-fixes.story.md` — BMAD Story 8.2: PHPStan L10 Tenant Module (81 errors → 0)

# BMAD Story 8.2: PHPStan L10 Tenant Module (81 errors → 0)

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `bmad/stories/0002-continuazione-domani.story.md` — Continuazione domani

type: concept
tags: [docs, tenant, bmad]

# Continuazione domani

TODO: story description

### `bmad/stories/0003-docs-reorg-core.story.md` — Story — riorganizzazione docs core: Tenant


# Story — riorganizzazione docs core: Tenant

- **ID:** `2026-10-09-docs-reorg-core-tenant`
- **Status:** done
- **Scope:** sola documentazione del modulo Tenant.

## Acceptance criteria

- [x] Esiste l'indice canonico [docs/bmad/index.md](../index.md).
- [x] Sono indicate directory canoniche e legacy con link relativi.
- [x] Inventario marker eseguito: nessun marker di merge nei `docs/` posseduti.
- [x] Nessun file di codice modificato.

## Inventario

Canoniche: [`docs/bmad/architecture`](../architecture/), [`brainstorming`](../brainstorming/), [`epics`](../epics/), [`stories`](../stories/), [`docs/wiki`](../../wiki/).

Legacy: [`docs/_integration`](../../_integration/), [`docs/raw`](../../raw/), [`docs/roadmap`](../../roadmap/), [`docs/chat`](../../chat/), [`docs/wiki`](../../wiki/), o

### `bmad/stories/0006-module-bmad-baseline-audit.story.md` — Story — Tenant: baseline BMAD

# Story — Tenant: baseline BMAD

Come manutentore del modulo Tenant, voglio una baseline BMAD verificabile, così da poter pianificare lavoro senza confondere ipotesi, WIP e comportamento osservato.

## Acceptance criteria

- [ ] Confermare API pubblica e confini con riferimenti a codice reale.
- [ ] Inventariare i flussi critici e collegarli a test Pest.
- [ ] Misurare PHPStan/Pest nel contesto stabile del modulo.
- [ ] Registrare dipendenze, rischi e decisioni nel modulo.
- [ ] Aggiornare lo stato reale in `docs/sprint-status.yaml`.

## Task

- [ ] Revisione architettura.
- [ ] Brainstorming con stakeholder.
- [ ] Decomposizione epic in story più piccole.
- [ ] Quality gate e second-brain write-back.

## Audit 2026-11-16

### `bmad/stories/0007-phpstan-modules-zero.story.md` — Story: PHPStan zero — Tenant


# Story: PHPStan zero — Tenant

## Scopo

Portare `Modules/Tenant` a **0 errori** PHPStan (level max progetto) senza ignore, senza `mixed` di comodo, rispettando Filament/XotBase e array PHP una chiave per riga.

## Metriche

| | |
|---|---|
| Errori iniziali | **111** |
| Errori finali | **0** |
| Data gate | 2026-11-16 |

## Cosa e' stato fatto

Root cause: commit 3e548fe aveva cancellato fixture/test helper ancora referenziati. Ripristinati da git + Safe\tempnam/file_put_contents/unlink nel test CreateJsonFileByRecordActionStringId.

## Verifica

### `configuration.md` — Configurazione per tenant


# Configurazione per tenant

Dato il nome del tenant ([tenant-resolution](tenant-resolution.md)), la config base di Laravel viene **sovrapposta** a quella
della cartella `config/<tenant>/`. Tutto il codice sta in `app/Actions/Config/`, piu' `Translations/` e `Markdown/`.

## Le Action

| Action | Cosa fa |
|---|---|
| `GetTenantFilePathAction` | percorso assoluto di un file sotto `config/<tenant>/`; rifiuta percorsi assoluti, NUL e segmenti `..` (`TENANT-PATH-INV-1..3`) |
| `GetTenantConfigPathAction` | prefisso Laravel di una chiave: `local/sito` + `app` -> `local.sito.app` |
| `GetTenantConfigNamesAction` | elenco dei `*.php` della cartella tenant (`id`, `name`) |
| `GetTenantConfigArrayAction` | `require` di `config/<tenant>/<nome>.php`; array vuoto se il file manca o non e' leggibile;

### `contracts/create-json-file-by-record-action.md` — CreateJsonFileByRecordAction


# CreateJsonFileByRecordAction

Sorgente: `app/Actions/Json/CreateJsonFileByRecordAction.php`. Gemelle: `UpdateJsonFileByRecordAction`,
`DeleteJsonFileByRecordAction` (stessa chiave `($keyName, $key)`).

## Input

- `Model&HasSushiToJson $record`: il record da aggiungere, non ancora salvato.

## Output

- `void`; il record riceve `id`, `created_at`, `updated_at`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| TENANT-JSON-CREATE-INV-1 | Nuovo id = max(id numerici esistenti) + 1; gli id stringa numerici (`"11"`) valgono come interi, quelli non numerici come 0. | `TENANT-JSON-CREATE-INV-1` |
| TENANT-JSON-CREATE-INV-2 | File senza righe = id 1, nessuna `ValueError` da `max()`. | `TENANT-JSON-CREATE-INV-2` |

### `contracts/delete-json-file-by-record-action.md` — DeleteJsonFileByRecordAction


# DeleteJsonFileByRecordAction

Rimuove dal file JSON del tenant la riga del record cancellato. Codice: `app/Actions/Json/DeleteJsonFileByRecordAction.php:22-52`.

## Input

- `Model&HasSushiToJson $record`: record con chiave.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `DELETE-JSON-INV-1` | La chiave deve essere un intero o una stringa di sole cifre; altrimenti `Assert` lancia. Questo esclude le chiavi UUID, che `UpdateJsonFileByRecordAction` accetta: incoerenza tra le due Action. | riga 34 | nessuno |
| `DELETE-JSON-INV-2` | La riga con quella chiave è rimossa e il file è riscritto come lista. | righe 38-50 | nessuno |
| `DELETE-JSON-INV-3` | Se la chiave non esiste, il file è riscritto invariato. | righe 40-50 | nessuno 

### `contracts/filter-config-string-keys-action.md` — FilterConfigStringKeysAction


# FilterConfigStringKeysAction

Tiene solo le voci con chiave stringa di un array di configurazione. Codice: `app/Actions/Config/FilterConfigStringKeysAction.php:9-30`.

## Input

- `array<mixed, mixed> $config`: array con chiavi di qualunque tipo (riga 17).

## Output

- `array<string, mixed>`: stesse voci di `$config` con chiave stringa, nello stesso ordine (righe 19-28).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-FILTER-INV-1` | Il risultato contiene solo chiavi stringa; le chiavi intere sono scartate. | righe 22-25 | `tests/Unit/TenantGapsCoverageTest.php` (riferimento alla classe, non per l'invariante) |
| `TENANT-FILTER-INV-2` | Il filtro è solo di primo livello: le chiavi intere annidate restano. | righe 22-25 (nessuna ricorsione

### `contracts/get-domains-array-action.md` — GetDomainsArrayAction


# GetDomainsArrayAction

Ricostruisce i domini dei tenant dalla struttura delle cartelle sotto `config/`. Codice: `app/Actions/Domains/GetDomainsArrayAction.php:13-81`.

## Input

- Nessun parametro. Scansiona `config_path()`.

## Output

- `array<int, array{id: string, name: string}>`: per ogni cartella foglia (vuota), `id` e `name` sono il dominio ricostruito invertendo il percorso (`eu/fixcity` diventa `fixcity.eu`) (righe 26-33, 63-81).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-DOMAINS-INV-1` | Le cartelle chiamate `lang` sono escluse a ogni livello. | riga 50 | `tests/Unit/Actions/Domains/GetDomainsArrayActionTest.php` |
| `TENANT-DOMAINS-INV-2` | Solo le cartelle foglia (senza sottocartelle) producono un dominio. | righe 68-70 | 

### `contracts/get-ente-data-action.md` — GetEnteDataAction


# GetEnteDataAction

Legge i dati dell'ente da `config('ente')` e li restituisce normalizzati in un `EnteData`. Codice: `app/Actions/Ente/GetEnteDataAction.php:22-151`.

## Input

- `?string $locale`: lingua per i testi; se assente usa la lingua corrente dell'app (riga 44).

## Output

- `EnteData`: campi testuali, `pec`, `email`, `dpo_email`, `phone`, `toll_free`, `region_url` e `social` (lista di `{network, label, url, icon}`).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-ENTE-INV-1` | Un valore mancante o non valido vale stringa vuota, mai un segnaposto. | righe 46, 80-82 | `tests/Unit/Actions/Ente/GetEnteDataActionTest.php` |
| `TENANT-ENTE-INV-2` | Per i testi per lingua vale: lingua richiesta, poi `app.fallback_locale`, poi il primo

### `contracts/get-localized-markdown-path-action.md` — GetLocalizedMarkdownPathAction


# GetLocalizedMarkdownPathAction

Trova il file markdown del tenant nella lingua corrente, con ripiego sulla versione generica. Codice: `app/Actions/Markdown/GetLocalizedMarkdownPathAction.php:11-33`.

## Input

- `string $name`: percorso relativo del markdown (ad esempio `privacy.md`).

## Output

- `string`: percorso assoluto del primo file esistente, nell'ordine `lang/<locale>/<name>` poi `<name>`; `'#'` se nessuno esiste (righe 19-31).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-MD-INV-1` | Vince la versione nella lingua corrente, se esiste. | righe 19-25 | `tests/Unit/Actions/Markdown/GetLocalizedMarkdownPathActionTest.php` |
| `TENANT-MD-INV-2` | Se nessun file esiste, il risultato è `'#'`. | righe 27-29 | `tests/Unit/Actions/Markd

### `contracts/merge-recursive-string-key-config-action.md` — MergeRecursiveStringKeyConfigAction


# MergeRecursiveStringKeyConfigAction

Fonde più array di configurazione, scartando le chiavi non stringa. Codice: `app/Actions/Config/MergeRecursiveStringKeyConfigAction.php:9-37`.

## Input

- `array<array-key, mixed> ...$configs`: uno o più array; anche con chiavi intere (riga 20).

## Output

- `array<string, mixed>`: fusione ricorsiva; con zero argomenti restituisce `[]`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-MERGE-INV-1` | Il risultato ha solo chiavi stringa di primo livello. | righe 29 e 34 | `tests/Unit/TenantCoverageBoostTest.php` (riferimento alla classe) |
| `TENANT-MERGE-INV-2` | Con più array, vince l'ultimo per ogni chiave foglia (`array_replace_recursive`). | righe 27-30 | nessuno dedicato |


### `contracts/save-tenant-config-action.md` — SaveTenantConfigAction


# SaveTenantConfigAction

Persiste un file di configurazione del tenant corrente fondendo i dati nuovi con quelli esistenti. Codice: `app/Actions/Config/SaveTenantConfigAction.php:12-73`.

## Input

- `string $name`: nome del file di config senza estensione (diventa `<name>.php`).
- `array<string, mixed> $data`: chiavi da scrivere.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente (senza group) |
|---|---|---|---|
| `TENANT-SAVE-INV-1` | Il file è sempre risolto con `GetTenantFilePathAction` (stesso controllo anti-traversal e stesso isolamento per tenant). | riga 21 | `tests/Unit/Actions/Config/SaveTenantConfigActionTest.php` |
| `TENANT-SAVE-INV-2` | Le chiavi esistenti non presenti in `$data` sono conservate; gli array associativi si fondono ricorsi

### `contracts/translate-tenant-key-action.md` — TranslateTenantKeyAction


# TranslateTenantKeyAction

Traduce una chiave `file.chiave` usando il file di lingua del tenant. Codice: `app/Actions/Translations/TranslateTenantKeyAction.php:14-45`.

## Input

- `string $key`: il primo segmento (prima del punto) è il nome del file in `lang/<locale>/`; il resto è la chiave annidata (righe 22-27).

## Output

- `string`: la traduzione, oppure la chiave originale se non si risolve (righe 31, 41, 43).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `TENANT-TRANS-INV-1` | Se il file di lingua del tenant non esiste, si restituisce la chiave. | righe 29-32 | `tests/Unit/Actions/Translations/TranslateTenantKeyActionTest.php` |
| `TENANT-TRANS-INV-2` | Se la chiave non è una stringa, si restituisce la chiave. | righe 39-41 | `tests/Unit/

### `contracts/update-json-file-by-record-action.md` — UpdateJsonFileByRecordAction


# UpdateJsonFileByRecordAction

Sostituisce nel file JSON del tenant la riga del record modificato. Codice: `app/Actions/Json/UpdateJsonFileByRecordAction.php:22-51`.

## Input

- `Model&HasSushiToJson $record`: record con chiave valorizzata.

## Output

- `void`.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `UPDATE-JSON-INV-1` | La riga è identificata da `($keyName, $key)` e sostituita. | righe 37-39 | `tests/Unit/Actions/Json/JsonFileByRecordActionsTest.php` |
| `UPDATE-JSON-INV-2` | La chiave può essere intera o stringa (UUID); bool e float sono rifiutati da `Assert::validArrayKey`. | riga 34 | nessuno dedicato |
| `UPDATE-JSON-INV-3` | Se la chiave non esiste nel file, la riga viene aggiunta (upsert). | riga 39 | nessuno (comportamento da con

### `stories/0001-tenant-phpstan-fix.story.md` — BMAD Story - Tenant PHPStan Fix


# BMAD Story - Tenant PHPStan Fix
Date: Sun Sep  6 04:36:00 PM CEST 2026
Status: Done — vedi `phpstan-tenant-fix.md` per il dettaglio completo (0 errori confermati
con cache pulita, 2026-09-06, sessione claude sonnet 5). Story superseded da quella, non
cancellata per non perdere la cronologia dello swarm.

## 2026-10-07 - `SushiConnectionByName` (`trait.unused`)

Il trait non era morto: mancava la riga `use SushiConnectionByName;` nei quattro trait `SushiToJson`, `SushiToJsons`, `SushiToCsv`, `SushiToPhpArray`. Ripristinata in avanti, 0 errori PHPStan sui file toccati. Scopo, causa radice, verifica e seguiti in `7.4.sushi-connection-by-name.story.md` (sezione 2026-10-07).

### `stories/0002-tenant-skippedtestexception-non-esiste-piu.story.md` — Story 2.14 — Gli skip di Tenant lanciano una classe che non esiste


# Story 2.14 — Gli skip di Tenant lanciano una classe che non esiste

## Story

Come **manutentore del modulo Tenant**,
voglio che i dieci `throw new \PHPUnit\Framework\SkippedTestException(...)` diventino
`Assert::markTestSkipped(...)`,
così che un test che non può scrivere sul database venga saltato invece di morire con un
`Error: Class not found`, e i 20 errori PHPStan che lo dicevano da settimane spariscano.

## Context

Nella corsa del 2026-08-24 il modulo Tenant ha 73 errori, e i primi 20 sono tutti la stessa
riga ripetuta:

```
class.notFound   Instantiated class PHPUnit\Framework\SkippedTestException not found.
class.notFound   Throwing object of an unknown class PHPUnit\Framework\SkippedTestException.
```

### `stories/0003-multi-tenant-scope-isolation.story.md` — 3.5: Multi-tenant scope isolation (tenant_id in queries)


---
# 3.5: Multi-tenant scope isolation (tenant_id in queries)

**Story ID:** 3.5
**Epic:** 3 — Access Control & Security
**Slug:** multi-tenant-scope-isolation
**Status:** backlog

## Story

As a PA tenant administrator,
I want every query against tenant-owned tables to be automatically scoped to my tenant,
so that no user can ever read or write another PA's data through the application layer, even by accident.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. A global Eloquent scope (or trait applied via model boot) automatically appends `tenant_id = auth()->user()->tenant_id` to every query on `User` and any other tenant-owned model available in `Modules/Tenant`. [Source: prd.md#FR-005 — "Multi-tenant: one database per PA; tenant_id fil

### `stories/0004-verify-rls-policies.story.md` — 3.8: Row-Level Security: verify RLS policies active


---
# 3.8: Row-Level Security: verify RLS policies active

**Story ID:** 3.8
**Epic:** 3 — Access Control & Security
**Slug:** verify-rls-policies
**Status:** backlog

## Story

As a security-conscious PA admin,
I want automated proof that PostgreSQL Row-Level Security policies are active and enforced on every tenant/user-scoped table,
so that a bug or omission in application-layer policy code cannot silently expose another tenant's or employee's data at the database layer.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. RLS is enabled (`ENABLE ROW LEVEL SECURITY`) on the `Scheda`, `Activity`, and `Progressioni` (ProgressioniApproval) tables via a migration owned by this story. [Source: prd.md#NFR-SEC-002 — "DB enforcement: PostgreSQL RL

### `stories/0005-monitoring-alerting-setup.story.md` — 5.8: Monitoring setup: Vercel logs + alerting on errors


---
# 5.8: Monitoring setup: Vercel logs + alerting on errors

**Story ID:** 5.8
**Epic:** 5 — Code Quality & Infrastructure
**Slug:** monitoring-alerting-setup
**Status:** backlog

## Story

As the DevOps/tech-lead owner accountable for the 99.9% uptime SLA,
I want a health-check endpoint polled by Vercel every 5 minutes with PagerDuty alerting on repeated failures, kept entirely inside EU-approved logging infrastructure,
so that NFR-REL-001's uptime target is actually observed and actionable instead of an unmonitored aspiration, without violating the project's EU-only data-residency constraint.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. A health-check endpoint exists and is polled every 5 minutes by Vercel's uptime monitor. [Sourc

### `stories/0006-setup-wizard-db-init-seed.story.md` — 6.1: Filament setup wizard: DB init + seed


---
# 6.1: Filament setup wizard: DB init + seed

**Story ID:** 6.1
**Epic:** 6 — Setup & Operations
**Slug:** setup-wizard-db-init-seed
**Status:** backlog

## Story

As a PA (public administration) admin deploying a new tenant,
I want a Filament wizard that captures the PA's core setup data and seeds the default roles,
so that I can bring a new PA online in under an hour instead of 4-8 hours of manual configuration.

## Acceptance Criteria

<!-- LOCKED. External dev tools must not edit Acceptance Criteria. -->

1. The wizard captures PA name, admin email, department list, and evaluation types on a single Filament wizard page. [Source: prd.md#FR-010]

### `stories/0010-create-json-max-oneliner.story.md` — Story 7.5 — CreateJsonFileByRecordAction: one-liner `$max`

# Story 7.5 — CreateJsonFileByRecordAction: one-liner `$max`

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0012-docs-index-audit.story.md` — Tenant: audit e riorganizzazione indice docs/


# Tenant: audit e riorganizzazione indice docs/

Audit di tutti i 426 file `.md` sotto `Modules/Tenant/docs/` e riscrittura di `index.md` come
indice organizzato per argomento (panoramica, architettura, config, filament, api, testing,
phpstan, conflitti/git, regole, roadmap, tasks, stories, wiki, llm-wiki, html2pdf, staging).

Nessun file esistente e' stato rinominato o cancellato. 115 doppioni/varianti case-sensitive,
typo o file superati (es. `api-2.md` vs `api-2.md`, `roadmap/` sequenza numerata vs nomi piatti,
`root-md-files/`/`root-txt-files/`/`raw/root-import/` come mirror ridondanti tra loro) sono
raggruppati nella sezione "Storico / da consolidare" di `index.md` con nota sul file canonico,
senza azione distruttiva in questo task.

### `stories/0013-git-state-conflict-marker-daemon-cleanup.story.md` — Tenant — pulizia stato git (marker di conflitto residui)


# Tenant — pulizia stato git (marker di conflitto residui)

## Diagnosi

`git status --short --branch` mostrava 11 file "dirty" nel working tree (non un
rebase in corso: `.git/rebase-merge` e `.git/rebase-apply` assenti). Nessuna
divergenza `dev`/`laraxot/dev` (0 ahead / 0 behind).

Root cause: un commit precedente (`4d7ffe3` — "fix(Tenant): pulizia marker di
conflitto residui in docs/") aveva gia' ripulito correttamente 8 file
(`docs/00-index.md`, `docs/index.md`, `docs/patterns-2.md`, `docs/README.md`,
`docs/TROUBLESHOOTING.md`, `docs/architecture.md` e le 4 story
3.5/3.8/5.8/6.1). Due commit successivi (`7c6e6f1`, `c3deab5`, entrambi autore
`marco76tv`, messaggio `.`) hanno **reintrodotto** gli stessi marker di
conflitto in forma annidata sopra il contenuto gia' pulito — pattern
ricond

### `stories/0014-phpstan-safe-preg-stringable.story.md` — PHPStan: Safe\preg_replace e stringhe


# PHPStan: Safe\preg_replace e stringhe

`Safe\preg_replace` dichiara `string|array` anche per un input stringa. I punti del modulo che subito dopo usavano il risultato come stringa
ora passano da `Str::of(...)->replaceMatches(...)->toString()`. Motivazione e elenco completo sono nella story omonima di Xot.

### `stories/0015-phpstan-tenant-swarm-scope-fix.story.md` — PHPStan swarm — perimetro Tenant: scope, causa radice, fix


# PHPStan swarm — perimetro Tenant: scope, causa radice, fix

Agente swarm, scope disgiunto `laravel/Modules/Tenant/`.
Prompt: `bashscripts/docs/prompts/11-phpstan.md`, `46-multi-agent-module-swarm.md`,
`57-second-brain.md`, `15-bmad.md`.
Vincoli: mai `phpstan.neon`/baseline/ignore, mai `checkout/restore/reset` (forward-only),
test solo in `Modules/Tenant/tests/`. Nessun update QMD (lo fa il coordinatore).

## Ground truth

- `laravel/phpstan_tenant_errors.json`: 0 `errors`, 6 `file_errors` su 5 file.
- `laravel/phpstan_modules_initial.json`: 1 `phpstan.parse` FATAL in scope
  (`BaseModelJsonsFactory.php:146`, `Syntax error, unexpected EOF, expecting ')'`).
  Gli altri parse/internal-error del file iniziale sono fuori scope (Lang, Media,
  Notify, UI, config/database, TenantDomainFactory)

### `stories/0016-phpstan-test-wave-tenant.story.md` — Tenant: regressione PHPStan dei test dopo il pull del 2026-10-20


# Tenant: regressione PHPStan dei test dopo il pull del 2026-10-20

Lane `tenant` del run descritto in [phpstan-test-wave-regression](../../../Xot/docs/stories/phpstan-test-wave-regression.story.md). Fase BMAD: implementazione e quality gate.

## Misura

| | File | Errori |
|---|---:|---:|
| Baseline 09:00 (bucket `tenant`) | 41 | 764 |
| Ri-misura prima di toccare (stessi file) | 41 | 733 |
| Dopo il passo 1 (`TestCase.php` e `Pest.php`) | 41 | 208 |
| Dopo il passo 2 (9 test riportati alla forma Pest tipizzata, `domaintest.php` rimosso) | 40 | 16 |
| Dopo il passo 3 (produzione) | 40 | **0** |

Le ri-misure dei passi 1 e 2 contano solo gli errori sui file del bucket. Il trait `SushiToJsons.php` ha 32 errori in baseline (inclusi nei 764) che non compaiono analizzando solo quei file: PHPS

### `stories/0017-placeholder-translations-cleanup.story.md` — Via le traduzioni segnaposto dai file di lingua


# Via le traduzioni segnaposto dai file di lingua

Rimosse le voci `helper_text`, `placeholder`, `description`, `tooltip`, `label`, `heading` e `hint` uguali al nome del
campo. Le aveva scritte il salvataggio automatico delle chiavi mancanti (`AutoLabelAction`, solo in locale) e
comparivano in produzione come testo sotto e dentro i campi. Eliminati anche i file `.php` senza nome.

Strumento: `php artisan lang:clean-placeholders {Modulo} [--dry-run]` (modulo Lang). Tocca solo i file di soli
dati: quelli che chiamano funzioni restano come sono.

### `stories/0018-symlinked-tenant-config-ignored-on-web.story.md` — Config del tenant ignorata via web e pulizia del log

# Config del tenant ignorata via web e pulizia del log

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0019-tenant-mixed-type-reduction.story.md` — Tenant: riduzione uso mixed dove il tipo reale e' noto

# Tenant: riduzione uso mixed dove il tipo reale e' noto

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0020-tenant-services-to-actions.story.md` — Tenant: eliminazione app/Services, conversione a QueueableAction

# Tenant: eliminazione app/Services, conversione a QueueableAction

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0021-testing-content-isolation.story.md` — Isolamento dei contenuti tenant nei test

# Isolamento dei contenuti tenant nei test

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `stories/0022-xotbaseresourcetable-model-audit-batch-tenant-limesurvey-lang-ai.story.md` — XotBaseResourceTable model audit - Tenant/DomainsTable

# XotBaseResourceTable model audit - Tenant/DomainsTable

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.


### `sushi-json-models.md` — Modelli Eloquent su file del tenant


# Modelli Eloquent su file del tenant

Pagine, sezioni, menu e altri contenuti del sito non stanno in tabelle: sono file versionati sotto
`config/<tenant>/database/content/<tabella>.json`. Il modulo li espone come modelli Eloquent in sola memoria con il pacchetto
Sushi: si interrogano con `Page::query()`, e il **file e' il dato**. La cartella e' del tenant, quindi ogni tenant ha i suoi
contenuti ([tenant-resolution](tenant-resolution.md)).

## I trait

| Trait / classe | Sorgente delle righe | Scrittura |
|---|---|---|
| `SushiToJson` (+ `BaseModelJson`, contratto `HasSushiToJson`) | `config/<tenant>/database/content/<tabella>.json`, via `GetTenantFilePathAction` | `creating`/`updating`/`deleting` riscrivono il file |
| `SushiToJsons` (+ `BaseModelJsons`) | variante con piu' file; deve fo

### `tenant-resolution.md` — Risoluzione del tenant


# Risoluzione del tenant

Il tenant **e' una cartella di `config/`**, non una riga di database. Decisione: [ADR 0003](adr/0003-tenant-name-from-reversed-host.md);
contratto completo con gli invarianti `TENANT-NAME-INV-1..5`: [get-tenant-name-action](contracts/get-tenant-name-action.md).

## Algoritmo (`app/Actions/GetTenantNameAction.php`)

1. **Host sorgente**, in quest'ordine:
   - `$_SERVER['SERVER_NAME']`, se non e' vuoto e non e' `127.0.0.1`, `::1`, `localhost`;
   - altrimenti l'header `Host` (`request()->getHost()`), ma **solo fuori dalla console** (artisan, queue e scheduler non
     hanno una richiesta). `php artisan serve` e i proxy inversi lasciano in `SERVER_NAME` l'indirizzo di bind: senza
     l'header ogni dominio ricadrebbe sul tenant di fallback e le pagine risponderebber

### `wiki/concepts/lowercase-database-factories-directory.md` — Directory database lowercase — factories


# Directory database lowercase — factories

Il modulo Tenant usa **solo** cartelle `database/` in minuscolo, allineate a Laravel e `composer.json` PSR-4.

## Regola

| Canonico | Vietato |
|----------|---------|
| `database/factories/` | `database/Factories/`, `database/Factories_/`, `database/Factories_old/` |
| `database/seeders/` | `database/Seeders/` |
| `database/migrations/` | `database/Migrations/` |

Regola progetto: [modules-structure-rules.md#database-folder-lowercase-rule](../../../../../../bashscripts/ai/wiki/concepts/modules-structure-rules.md#database-folder-lowercase-rule).

## Perché `Factories_/` non deve esistere

- Suffisso `_` o `_old` = copia stale, spesso in `.gitignore` ma ancora su disco → confusione su quale factory sia attiva.
- `composer.json` del modulo mappa `

### `wiki/concepts/no-services-no-support-queueable-actions.md` — Tenant — Services/Support vietati: solo Actions


# Tenant — Services/Support vietati: solo Actions

## Regola

- **Mai** creare file in `app/Services/` o `app/Support/`
- **Sempre** `app/Actions/{Contexto}/FooAction.php`
- **Trait**: `use Spatie\QueueableAction\QueueableAction;`
- **Entrypoint**: unico metodo `execute(...)`
- **Chiamata**: `app(FooAction::class)->execute(...)`
- **Gruppi**: sottocartelle per attore/contesto

## Conversione

Vedi [no-app-support-queueable-actions.md](no-app-support-queueable-actions.md) per il mapping legacy → Action.

### `wiki/troubleshooting/git-merge-conflict-inventory.md` — Git Conflict Inventory

# Git Conflict Inventory

- Date: 2026-04-28
- Owner: Modules/Tenant
- Files with conflict markers: 1

## Files

- docs/wiki/README.md

## Notes

- Inventory generated from `rg -l "^(<<<<<<<|=======|>>>>>>>)"`.
- Use this list as a volatile coordination map; re-open each file before editing because other agents may resolve items in parallel.

### `wiki/troubleshooting/tenant-pages-sushi-empty-pageslugmiddleware.md` — Tenant name — Page Sushi vuoto → auth JSON ignorato


# Tenant name — Page Sushi vuoto → auth JSON ignorato

## Sintomo

- `GET /it/tickets/create` → 200 per guest (dovrebbe 302 login)
- `Page::count()` → 0
- `PageSlugMiddleware` non applica `auth` dal JSON

## Causa (2026-07-13)

`GetTenantNameAction` chiamava metodo inesistente `containsUnsafeTenantPathCharacters()` → fatal in bootstrap tenant → pagine CMS non caricate da `config/local/fixcity/database/content/pages/`.

## Fix

Usare `containsUnsafePathCharacters()` (metodo esistente nella stessa classe).

## Verifica

```bash
