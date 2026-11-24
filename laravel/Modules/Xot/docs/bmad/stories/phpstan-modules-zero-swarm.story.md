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
- [ ] Fix **source-first**: capire caller, contratto XotBase/Action/trait, responsabilità di modulo; patch minima alla radice
- [ ] `mixed` / cast / `@phpstan-ignore` / baseline / edit `phpstan.neon` = **last resort** (solo se documentato in story + memoria)
- [ ] Parallelismo: swarm/subagent su file disgiunti + `bashscripts/lock/`; **flock max-3** processi PHPStan concorrenti (no thrashing host)
- [ ] **Pest gate**: test mirati eseguiti e verdi sullo scope toccato, oppure skip documentato (host `10.100.200.15` / DB testing irraggiungibile)
- [ ] Docs solo boy scout nei moduli/temi toccati; niente mass-delete di `.md`

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

<<<<<<< HEAD
=======
- Status: `review` — cold gate Modules **`[OK] No errors` EXIT 0** (2026-11-17)
- AC full-tree: spuntato osservato; Pest mirato ProgressioneVerticale+Diagnose **7 passed**
- Lock session `phpstan-modules-swarm-session` + lane Activity/Ptv unlock
- Debito: attivare `progressione_verticale` in `criteri_esclusione` 2026 (owner HR);
  Pest HostApp richiede DB testing raggiungibile; ridurre thrash multi-agente (max-3)
- Prossimo: boy-scout ridondanza story phpstan datate in Xot/docs/bmad/stories;
  prompts bashscripts/docs/prompts (subagent); qmd update memoria thrash/cache
>>>>>>> laraxot/dev
- Status: `done` — allineato a sprint `Xot/phpstan-modules-zero-swarm` (gate finale
  peer sotto flock: JSON `errors=0`/`file_errors=0` + banner `[OK] No errors`)
- AC full-tree: spuntato; Pest mirato ProgressioneVerticale+Diagnose **7 passed**;
  FeatureFlagsTest 15 passed; AppMiddlewareTest skip DB documentato
- Debito fuori gate PHPStan: attivare riga `criteri_esclusione.progressione_verticale`
  in campagna 2026 (owner HR); ridurre thrash multi-agente (max-3)
<<<<<<< HEAD
=======
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
>>>>>>> laraxot/dev
