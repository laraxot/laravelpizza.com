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

- Status: `done` — allineato a sprint `Xot/phpstan-modules-zero-swarm` (gate finale
  peer sotto flock: JSON `errors=0`/`file_errors=0` + banner `[OK] No errors`)
- AC full-tree: spuntato; Pest mirato ProgressioneVerticale+Diagnose **7 passed**;
  FeatureFlagsTest 15 passed; AppMiddlewareTest skip DB documentato
- Debito fuori gate PHPStan: attivare riga `criteri_esclusione.progressione_verticale`
  in campagna 2026 (owner HR); ridurre thrash multi-agente (max-3)
