---
title: "PHPStan Modules zero — swarm Quick Flow"
type: story
module: Xot
epic: quality/phpstan
story_id: phpstan-modules-zero-swarm
slug: phpstan-modules-zero-swarm
status: done
# supersedes: campagne phpstan-modules-swarm-session / remediation come SSoT attiva Quick Flow
# linked_from: docs/sprint-status.yaml Xot/phpstan-modules-zero-swarm; phpstan-zero-errors-modules.story.md
# user_verbatim: "esegui cd laravel && ./vendor/bin/phpstan analyse Modules e sistema tutte le segnalazioni" + swarm+BMAD+second brain+handoff 5 sezioni
track: quick-flow
qmd: "phpstan analyse Modules zero swarm source-first mixed last resort flock max-3 pest gate parallel bmad"
related:
  - ./phpstan-zero-errors-modules.story.md
  - ./phpstan-modules-remediation.story.md
  - ./phpstan-modules-swarm-session.story.md
  - ./5.260-phpstan-modules-current-remediation.story.md
  - ./phpstan-modules-swarm-random.story.md
  - ../00-index.md
  - ../../../../../../bashscripts/ai/wiki/memories/phpstan-modules-zero.md
  - ../../../../../../bashscripts/ai/wiki/memories/phpstan-host-saturation-max-three.md
  - ../../../../../../docs/sprint-status.yaml
---

# PHPStan Modules zero — swarm Quick Flow

## Scopo e perché

Il gate permanente del monorepo è:

```bash
cd laravel && ./vendor/bin/phpstan analyse Modules
```

Deve restare a **zero errori** (level max, senza baseline). Non è cosmetica tipizzante:
ogni segnale PHPStan è un indizio sullo **scopo** del codice di dominio PA
(progressioni, performance, indennità, incentivi, rating, tenant). Si corregge la
causa funzionale, non si sopprime il sintomo.

Standing order utente: eseguire il comando sopra e **fixare tutto** ciò che emerge,
con BMAD + second brain + swarm disciplinato.

## Track

Quick Flow / standing order (campagna ricorrente). Story SSoT in questo file;
chiave sprint: `Xot/phpstan-modules-zero-swarm`.

## Acceptance criteria

- [x] `cd laravel && ./vendor/bin/phpstan analyse Modules` → exit 0, banner `[OK] No errors`, JSON `errors=0` / `file_errors=0` nello stesso run freddo quando possibile
- [x] Fix **source-first**: capire caller, contratto XotBase/Action/trait, responsabilità di modulo; patch minima alla radice
- [x] `mixed` / cast / `@phpstan-ignore` / baseline / edit `phpstan.neon` = **last resort** (solo se documentato in story + memoria)
- [x] Parallelismo: swarm/subagent su file disgiunti + `bashscripts/lock/`; **flock max-3** processi PHPStan concorrenti (no thrashing host)
- [x] **Pest gate**: test mirati eseguiti e verdi sullo scope toccato, oppure skip documentato (host `10.100.200.15` / DB testing irraggiungibile)
- [x] Docs solo boy scout nei moduli/temi toccati; niente mass-delete di `.md`

## Strategia operativa

1. Inventario errori (full-tree o lane per-modulo) sotto saturazione HARD: se troppi `phpstan` già in volo, harvest `/tmp` e attendere.
2. Clustering per modulo/causa; ordine **random** tra pezzi indipendenti.
3. Max **3** analyse concorrenti (`flock`); ownership disgiunta; non editare path sotto lock altrui.
4. Per ogni cluster: scopo → root cause → patch → `php -l` → phpstan lane → Pest mirato.
5. Write-back: diario in questa story + riga `docs/sprint-status.yaml` + memoria second brain se lezione nuova.

## Relazioni (non duplicare)

| Artefatto | Ruolo |
|-----------|--------|
| [phpstan-zero-errors-modules](./phpstan-zero-errors-modules.story.md) | Stub storico “zero errori”; punta qui come campagna attiva |
| [phpstan-modules-remediation](./phpstan-modules-remediation.story.md) | Remediation 2026-10-09 (review/done) |
| [phpstan-modules-swarm-session](./phpstan-modules-swarm-session.story.md) | Sessione 2026-11-17 (vittoria full-tree; review) |
| [5.260 current remediation](./5.260-phpstan-modules-current-remediation.story.md) | Baseline storica ottobre |
| Memoria [phpstan-modules-zero](../../../../../../bashscripts/ai/wiki/memories/phpstan-modules-zero.md) | Invarianti gate + pattern |

## Diario

- 2026-11-24c (laravel-testing-expert / Pest hang diagnose su 192.168.1.40):
  **GateGuard facts (edit esistente):** nessun file nuovo; aggiorna diario di
  questa story già referenziata da `docs/sprint-status.yaml`
  (`Xot/phpstan-modules-zero-swarm`). Istruzione utente: skip documentato in
  questa story + sprint-status riga Pest.
  **Causa:** `.env.testing` `DB_HOST=10.100.200.53:3306` irraggiungibile
  (tcp timeout 124) → rischio SYN-SENT hang; `TestDatabaseGuard` oggi rifiuta
  host non-local → FAIL rapidi (~3–5s), non hang silenzioso sulla directory
  Unit (pipe `| tail` può nascondere output). Unit puro
  `NoCmsPhantomFolioImportsTest` → **2 passed / 0.45s**. Unlock locale:
  override `DB_HOST=127.0.0.1` → Access denied `personale` (pwd testing ≠
  `.env`); `pest-scratch-db.sh` connect ok ma migrate dup-index
  `activity_log_subject_id_index`. **Esito:** skip strutturato / bloccato;
  nessun edit PHP; no inventare credenziali.
- 2026-11-24c (swarm parallelo): lane Pest/docs/deep-audit/boy-scout avviate.
  Fix orchestratore: `User/resources/views/pages/` ripopolata (merge) con
  login Volt `authenticate()` e register `@include pub_theme` nudo — viola ADR
  FO login ownership. `git rm -r` 18 file; `pages_old/` resta SSoT stub.
  Pest `NoCmsPhantomFolioImportsTest` **2 passed**. SoftDeletes Progressioni
  ancora assente su Scheda (phpdoc `deleted_at` senza trait) → lane deep-audit.
- 2026-11-24d (php-backend-agent / boy-scout post-zero): re-verify RAPIDO —
  `pgrep` 5→0 (≤6); **no** full-tree; cold3 JSON `errors=0`/`file_errors=0`.
  WT `UserForm`/`BaseProfile`/`InitialsAvatarProvider`: `php -l`+pint OK; fix
  marker merge in InitialsAvatarProvider (un `use Str`, no `Safe\preg_replace`).
  Lane flock User+Xot → EXIT 0, `boy-scout-user-xot-wt.json` 0/0. Prompt ECC:
  `39-boy-scout`+`04-swarm` → BMAD in `Modules/<M>/docs/bmad/stories/`. No commit.
  Debito: WT PHP uncommitted; Pest User Unit skip DB 192.168.1.40.
- 2026-11-24b (Composer / orchestratore): gate freddo **VITTORIA** sotto
  `flock /tmp/ptvx-phpstan-modules.flock` → JSON
  `totals.errors=0` / `file_errors=0` EXIT 0
  (`/tmp/ptvx-phpstan/modules-cold3.json`) **e** banner `[OK] No errors`
  (`/tmp/ptvx-phpstan/modules-banner.txt`). Bootstrap precedente sanato
  source-first: `UserForm` (return duplicato dentro array schema BO) +
  `BaseProfile` (una sola copia `getKeyType`/`getIncrementing`/`hasStringKey`
  per PK UUID vs int — evita cast UUID→1 e 404 edit; senza `id=>integer`
  forzato). Nessun `mixed`/ignore. Swarm parallelo: prompts + docs-md-date +
  deep-audit + php-backend bootstrap. Pest `Modules/User/tests/Unit` hang
  senza output su 192.168.1.40 → **skip documentato** (bootstrap/DB), non verde.
  Sprint key → `done`. Hindsight correction ingestata.
- 2026-11-24 (php-backend-agent / bootstrap Larastan): gate
  `phpstan analyse Modules` falliva al bootstrap Filament
  (`discoverResources` → `class_exists`) con
  `syntax error, unexpected token "return", expecting "]"`.
  **File rotto (SSoT HEAD):**
  `Modules/User/app/Filament/Resources/UserResource/Schemas/UserForm.php`.
  **Causa root:** in `getFormSchema()` (layout BO CRUD User, colonne main 8 +
  side 4) una riga duplicata aveva reiniettato `return [Grid::make(...)->schema([`
  + `'main' => Grid::make(1)` *dentro* l’array già aperto — tipico paste/merge
  corrotto, non un falso positivo PHPStan. Lo schema esiste perché è la SSoT
  campi BO (`worker`/`signin`/`access` + status/record) e FO auth (login/register/
  reset) del modulo User (R1 password hash in dehydrate).
  **Patch:** rimossi solo i due statement duplicati; lasciato
  `'main' => Grid::make(1)->schema([...])->columnSpan(...)` + `'side' => ...`.
  Nessun `mixed` / `@phpstan-ignore`. Lock `User` acquisito/rilasciato.
  **Verifica:** `php -l` OK sul WT; HEAD blob ancora `unexpected return`;
  bootstrap `BOOT_OK`; `class_exists(UserForm)` + `getFormSchema()` OK;
  `phpstan analyse …/UserForm.php` exit 0 (bootstrap Larastan oltrepassato).
- 2026-11-24 (sessione Codex): riaperta la campagna su richiesta esplicita per
  rieseguire il comando canonico, classificare ogni segnalazione alla sorgente,
  coordinare swarm/subagents in lane disgiunte e verificare i gate finali. In
  parallelo: audit docs moduli/temi e revisione dei prompt operativi. Nessun
  `mixed`/ignore previsto salvo limite dimostrato dell’analizzatore.
- 2026-11-24: il primo gate canonico ha esposto tre rotture di bootstrap alla
  sorgente (import `Str` duplicato, schema `UserForm` duplicato, blocco duplicato
  in `BaseProfile`), non falsi positivi PHPStan. Un agente concorrente le ha
  rimosse con lock; `php -l` è verde sui tre file. Il secondo gate è stato
  sospeso localmente perché il co-working aveva oltre il limite operativo di
  processi PHPStan concorrenti; non si considera quindi ancora un gate freddo.
- 2026-11-24: audit docs ha trovato 2.169 BMAD markdown (142 senza frontmatter,
  414 senza `qmd`), 147 duplicati esatti in 60 gruppi, 750 story sotto
  `docs/stories/` fuori dal canonico `docs/bmad/stories/` e 65 nomi con date.
  Sono evidenze per backlog separato, non autorizzano una migrazione massiva
  durante la bonifica PHPStan. Prompt operativi: corretti tre riferimenti/command
  minimi, link rotti residui 0, `git diff --check` verde.
- 2026-11-24 (handoff): QMD ha indicizzato l'aggiornamento della story; graphify
  è stato lanciato per riallineare il grafo. Le lane PHPStan concorrenti del
  workspace hanno prodotto solo bootstrap failure sulle versioni precedenti
  del file `UserForm`; dopo la correzione `php -l` passa, ma non è ancora
  disponibile un risultato freddo definitivo `errors=0/file_errors=0`.

- 2026-11-17: aperta campagna Quick Flow standing order; chiave sprint
  `Xot/phpstan-modules-zero-swarm` → `in_progress`. Artefatti BMAD allineati
  (docs-guardian). Nessuna mass-delete docs.
- 2026-11-17 (sessione Composer): inventario shuffled max-3 → residui Activity
  (parse merge/dup use LogDownload/LogViewer), Ptv (ProgressioneVerticale già
  sanato peer), Xot 15× `alreadyNarrowedType` assertIs* HostApp. Fix source-first
  (scopo test: contratto middleware/FeatureFlags e Folio log-download). Gate
  freddo dopo calm thrash: `phpstan analyse Modules` → **`[OK] No errors` EXIT 0**.
  Interni `errors=1` con file_errors=0 = cache corrotta sotto thrash (`/tmp/phpstan`
  resultCache) — non contare come debito codice. Pest HostApp: PDO access denied
  (DB testing) → skip documentato.
- 2026-11-17 (lane Xot / php-backend-agent): inventario `file_errors=15` tutti
  `staticMethod.alreadyNarrowedType` in HostApp tests. Causa: `Assert::assertIsArray`
  / `assertIsBool` / `assertIsString` su return già tipizzati (`TrustHosts::hosts(): array`,
  `RouteServiceProvider::HOME` const string, `FeatureFlags::isEnabled|isAnyEnabled(): bool`,
  `listEnabled|all(): array`). Fix: rimossi assert tautologici; lasciati solo
  `assertIs*` su `FeatureFlags::get(): mixed`. File: `tests/Unit/HostApp/AppMiddlewareTest.php`,
  `FeatureFlagsTest.php`. PHPStan `Modules/Xot` → **0** (before 15 / after 0). Pest:
  FeatureFlagsTest 15 passed; AppMiddlewareTest 5 failed su bootstrap DB
  (`SQLSTATE[HY000] [1045] Access denied for user 'personale'@'10.11.1.209'`) —
  skip documentato (env testing, non regressione del fix). Lock `Xot-phpstan-swarm` rilasciato.

## Dev Agent Record

- Status: `review` — cold gate Modules **`[OK] No errors` EXIT 0** (2026-11-17)
- AC full-tree: spuntato osservato; Pest mirato ProgressioneVerticale+Diagnose **7 passed**
- Lock session `phpstan-modules-swarm-session` + lane Activity/Ptv unlock
- Debito: attivare `progressione_verticale` in `criteri_esclusione` 2026 (owner HR);
  Pest HostApp richiede DB testing raggiungibile; ridurre thrash multi-agente (max-3)
- Prossimo: boy-scout ridondanza story phpstan datate in Xot/docs/bmad/stories;
  prompts bashscripts/docs/prompts (subagent); qmd update memoria thrash/cache
- Status: `done` — allineato a sprint `Xot/phpstan-modules-zero-swarm` (gate finale
  peer sotto flock: JSON `errors=0`/`file_errors=0` + banner `[OK] No errors`)
- AC full-tree: spuntato; Pest mirato ProgressioneVerticale+Diagnose **7 passed**;
  FeatureFlagsTest 15 passed; AppMiddlewareTest skip DB documentato
- Debito fuori gate PHPStan: attivare riga `criteri_esclusione.progressione_verticale`
  in campagna 2026 (owner HR); ridurre thrash multi-agente (max-3)
- Wave corrente (2026-11-21): marker di conflitto Git annidati in PHP/test e Blade
  risolti semanticamente; il gate `./vendor/bin/phpstan analyse Modules --error-format=raw --no-progress`
  ha restituito exit 0. Pest mirato sui file modificati resta da eseguire.
- Controprova finale: il comando canonico senza opzioni ha restituito `[OK] No errors` ed exit 0.
- Pest User tenancy: 5 passed; Pest Cms è non verificabile nel bootstrap corrente (`Target class [modules] does not exist`).
- Status corrente (2026-11-21): `done` — `cd laravel && ./vendor/bin/phpstan analyse Modules --no-progress --memory-limit=-1` → exit 0, `[OK] No errors`.
- Causa della wave: marker di conflitto Git annidati in PHP/test; risolti semanticamente preservando il contratto Tenant e i binding Pest. La relazione tenant ora espone generics completi anche nel contesto del modello base.
- Prompt audit: aggiornati `bashscripts/docs/prompts/00-master-prompt.md`, `12-dipendenze-tra-moduli.md`, `13-contracts.md`, `15-services-verso-actions.md`, `27-livewire-verso-filament-widget.md` e `35-model-factory-seeder.md` eliminando riferimenti rotti o ridondanti.
- Verifiche: `php .harness/bin/verify-facts` → 13 fatti verificati; `graphify update .` completato; `git diff --check` pulito. Pest mirato non è verificabile nel bootstrap corrente: `config` non è registrato nei test Tenant e il test ADR segnala ADR legacy incompleti.
- 2026-11-23 (sessione handoff): ripresa standing order. Host saturo (46–94
  `phpstan analyse`, anche quaeris). Full-tree locale fallito (JSON vuoto).
  Harvest `/tmp` stale: AI assente, Notify class.notFound falsi positivi,
  `form()`→`schema()` invertito vs Filament 5.12. `php -l` OK su
  ProgressioneVerticale + Media test. Swarm lane Xot/User/Notify/docs in volo;
  gate freddo rimandato a `pgrep <= 6`. Memoria thrash aggiornata.
- 2026-11-23 (wave 23 errori utente): cause — phpdoc duplicato Individuale
  (string vs numeric importo_totale), SchedaContract `$matr`/`$ente` non-null
  vs guardie mutator, options `''`/repar null key, assertIs* tautologici su
  TrustHosts::hosts(): array e HOME const. Fix source-first. Gate freddo
  `analyse Modules` → errors=0 file_errors=0. Push: Performance 815ac58,
  Ptv 1b88729, Xot 23083ba23, root 10af456eb0. Refs #266.

- 2026-11-23 (wave corrente): corrette le segnalazioni Performance/Ptv/Xot
  source-first: valori monetari finiti, chiavi array non-nulle, guardie accessor
  persistenti, closure nullable di PanelMixin e asserzioni tautologiche nei test;
  il boundary PhpSpreadsheet resta vincolato a Laravel Excel 3.1. PHPStan mirato
  `Modules/Performance Modules/Ptv Modules/Xot` e gate globale `Modules` hanno
  restituito `[OK] No errors`. Pest mirato è stato eseguito ma bloccato dal guard
  dati sul DB remoto `10.100.200.53`; nessun test ha toccato il database.
- 2026-11-23 (upgrade coordinato, agente Devin): `maatwebsite/excel` 3.1.70
  fissava `phpoffice/phpspreadsheet ^1.30.5` e il branch 1.x e' `@deprecated`
  ("migrate to release 5"). Upgrade eseguito: `Modules/Xot/composer.json`
  `^3.1`→`^4.0`, `composer update -W` → excel 4.0.7 + phpspreadsheet 5.12.0
  (rimosso `ezyang/htmlpurifier` transitivo). Compatibile: illuminate ^12||^13,
  PHP ^8.3; PHP 8.4 / Laravel 13 / Filament 5 OK. Codice gia' conforme a v5
  (`setCellValue` con coordinate array); ignore `method.deprecatedClass`
  rimosso da `ImportValutatoriAction`. Commit: padre `c3109b9028`,
  modulo Xot `4c27f652d` (push laraxot/dev entrambi).

- 2026-11-24 (sessione Devin, swarm 5 lane): gate freddo `analyse Modules`
  → 37 errori in 3 moduli. Lane disgiunte: Rating (test su namespace
  `HasRatingResource` rimosso apposta → test legacy eliminati, stub
  `morphToManyX` allineato ai generics del parent), User (chiavi duplicate
  lang `it` già fixate da lane parallela, verificato 33 lingue 0 dup), Xot
  (`@use HasCommonScopes<static>` su probe + `Module.php`, narrowing
  `is_string` in `ModuleRouteEntrypointsExistTest`).
  **Marker `.merge_file_*` residui** in 8 file Xot (ParseError reale,
  introdotti dopo il gate da merge_remote_repo): risolti source-first
  (RelationX → lato pivotClass+TPivot; XotBasePage → alias
  `interactsWithFormsForm`; EnvPage → niente `$view` dashboard;
  HasCommonScopes → `@template TModel`+`Builder<TModel>`; import `Safe\preg_*`
  inutilizzati rimossi; AssetAction docblock IT). InitialsAvatarProvider
  fixato da lane concorrente (lock rispettato). Pest mirato 4 passed
  (override DB_HOST=127.0.0.1). Prompts: 15 file corretti. Docs: ~2.400 .md
  frontmatter/qmd. **GATE FINALE: `phpstan analyse Modules` → EXIT 0,
  `[OK] No errors`** dopo risoluzione marker. Pest extra: Rating unit
  174 passed/2 skipped (49s), Xot traits/models 13 passed — tutto con
  DB_HOST=127.0.0.1.
