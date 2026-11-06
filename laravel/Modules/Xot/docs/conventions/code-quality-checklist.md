---
title: "Code Quality Checklist: Audit Subagent (BMAD + Blueprint)"
type: convention-checklist
status: active
module: Xot
scope: cross-module (Modules/)
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, code-quality, second-brain, blueprint, checklist, audit]
qmd: "code quality checklist audit pint phpstan strict types blueprint"
related:
  - ../bmad/filament-blueprint.md
  - ../bmad/code-quality-wave.md
  - ../conventions/docs-organization.md
---

<!--
GateGuard: supersedes doc-only authorization note; linked from code-quality-wave;
user: "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint"
-->

# Scopo

Checklist del wave BMAD ([code-quality-wave.md](../bmad/code-quality-wave.md)).

> **Autorizzazione 2026-10-20**: PHP del lotto Filament/XotBase + DRY haversine permesso dall'utente.

# Audit (per punto)

## 1. Pint (format)

- Comando: `vendor/bin/pint --test` (in `laravel/`)
- Stato: **FAIL** (`exit=1`)
- Problemi: molteplici file con errori di formattazione. Estrazione parziale dal log (`/tmp/pint_result.txt`):
  - `Modules/Cms/app/Filament/Clusters/section/Resources/*.php`
  - `Modules/Media/app/Filament/Clusters/极est/Pages/AwsTest.php`
  - `Modules/User/tests/Unit/Actions/Auth/RecordAuthenticationLogActionTest.php`
  - `Modules/User/app/Contracts/*.php` (multiple)
  - `Modules/Xot/app/Contracts/*.php` (multiple, `class_definition`, `fully_qualified_strict_types`)
  - `Modules/Xot/app/Filament/Resources/XotBaseResource.php` (unary_operator_spaces)
  - `config/*.php`, `tests/Architecture/ModulesArchitectureTest.php`, `scripts/*.php`
- Azione: **non corretta automaticamente**; lista salvata per intervento autorizzato separato.

## 2. PHPStan (static analysis)

- Comando: `vendor/bin/phpstan analyse Modules --no-progress --memory-limit=512M`
- Stato: **OK**: `[OK] No errors`
- Config: solo `laravel/phpstan.neon` (regola non negoziabile; nessun `.neon` aggiunto).

## 3. Strict types (`declare(strict_types=1)`)

- Comando: `grep -rL 'declare(strict_types=1)' --include="*.php"` su `app/`, `tests/`, `database/`
- Stato: **17 file mancanti** (non 19 come stimato nel wave; verifica aggiornata).
- Dettaglio per modulo:
  - `Modules/Cms`: **16 file** (database/Factories/, database/Migrations/, database/Seeders/, app/docs/source/ blade-embedded `.php`)
  - `Modules/Media`: **1 file** (`app/Filament/Clusters/极est/Pages/AwsTest.php`)
- Note: i file sono principalmente factory, migration, seeder, e un test page. Nessun `app/Contracts/` o `app/Actions/` mancante; i contratti e le azioni dei moduli chiave hanno già il declare.

## 4. Blueprint compliance (`Modules/Xot/docs/bmad/filament-blueprint.md`)

Target: 2–3 moduli chiave con `filament-blueprint.md` (Xot, Cms, AI, User, Notify).

### Xot (base)
- Resource che estendono `XotBaseResource`: 6/7 (`ModuleResource`, `LogResource`, `CacheResource` + schema sub-files)
- Azioni `QueueableAction` + `execute()`: **223/241** azioni (`app/Actions/`): alta conformità; poche eccezioni (test, stub, bak).
- Regola 2 (`label()` hardcoded): non verificata nel dettaglio (richiede lettura per-resource); segnala per follow-up autorizzato.

### Cms
- Resource: `PageContentResource`, `AttachmentResource`, `SectionResource`, `PageResource` estendono `LangBaseResource` (non direttamente `XotBaseResource`, ma tramite gerarchia base). 1 resource su 5 estende esplicitamente base Xot (`CacheResource` non presente). Accettabile per dominio Lang/Cms.
- Azioni: **10/10** con `QueueableAction`; **10/10** con `execute()`.

### AI
- Resource: `AiActionProposalResource` estende `XotBaseResource` (1/1).
- Azioni: **29/29** `QueueableAction`; **29/29** `execute()`. Massima conformità.

### User
- Resource: 32/35 estendono `XotBaseResource`. 3 eccezioni (cluster Passport self-reference, `ProfileResource` → `BaseProfileResource`, `OAuthRefreshTokenResource` self-reference): accettabili per architettura cluster.
- Azioni: 56/60 `QueueableAction`; 56/60 `execute()`. 4 azioni probabili test/stub.

### Notify
- Resource: tutte estendono base (6/6, con `LangBaseResource` per `MailTemplateResource`).
- Azioni: 50/50 `QueueableAction`; 49/50 `execute()` (1 mancante). Ottimo.

### Regola 3: Business logic nelle Actions, mai in `*Service`
- Non svolto audit completo sui `Service` (fuori scope sequenziale); verificato solo che le azioni principali (Xot, AI, Cms) usano `QueueableAction` + `execute()`. Eventuale verifica `*Service` registrata come nota per wave successivo.

# Soluzioni / Note incrementali

1. **Pint**: intervento necessario ma non eseguito (regola: non correggere automaticamente, documenta solo). File con problemi elencati sopra; raccomandato `vendor/bin/pint --dirty` con autorizzazione separata per lotto controllato.
2. **Strict types**: 17 file da aggiornare (fabbrica + migrazione + seeder + 1 test page). Lotti sicuri: `Cms/database/Factories/`, `Cms/database/Migrations/`, `Cms/database/Seeders/`, `Media/app/Filament/Clusters/极est/Pages/AwsTest.php`. Nessun `app/Contracts/` o `app/Actions/` toccato.
3. **Blueprint: hardcoded label()**: non verificato nel dettaglio; se necessario, audit per-resource su `XotBaseResource`, `ModuleResource`, `LogResource`, `AiActionProposalResource`, `PageContentResource`.
4. **PHP commenti / doc**: nessuna modifica a `.neon`; `phpstan.neon` non toccato.

# Link

- Blueprint: [`Modules/Xot/docs/bmad/filament-blueprint.md`](../bmad/filament-blueprint.md)
- Wave: [`Modules/Xot/docs/bmad/code-quality-wave.md`](../bmad/code-quality-wave.md)
- Convenzione docs: [`Modules/Xot/docs/conventions/docs-organization.md`](docs-organization.md)
- Second brain / iniziativa collegata (se registrata): vedere `hindsight_capture_initiative` per `code-quality-wave.md`.

# Stato finale (aggiornato wave Filament XotBase)

- PHPStan Modules: ✅ OK (`--memory-limit=2G`)
- Pint `--dirty` lotto corrente: ✅ passed
- Strict types storici Cms/Media: ⚠️ ancora aperti (prossimo lotto)
- Blueprint produzione: ✅ 0 extends Filament diretti residui (mock test = 1, baseline 1)
- Lotto PHP: Notify Select/ViewColumn, UI TextColumn, Geo Address*, BuildHaversine DRY
- Services dirs: ✅ 0
