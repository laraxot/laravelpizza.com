---
title: "PHPStan Modules full-tree remediation"
type: story
status: done
epic: Xot
qmd: "phpstan modules full tree remediation deprecated filament schema reactive live swarm"
related:
  - ./phpstan-modules-scan-remediation.story.md
  - ../../../../Ptv/docs/bmad/stories/phpstan-fix-ptv-deprecations.story.md
  - ../../../../Progressioni/docs/bmad/stories/phpstan-fix-progressioni.story.md
  - ./phpstan-fix-xot.story.md
---

# PHPStan Modules full-tree remediation

## Contesto

`cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules`
(10616 file, level max, nessun ignore/baseline consentito) riportava **39 errori**
in 7 moduli. Baseline atteso: 0 errori — ogni segnalazione è una regressione o
debito reale.

## Cluster (scope disgiunti, swarm parallelo)

| Cluster | Moduli | Errori | Tipologia |
|---|---|---|---|
| A | Ptv | 11 | Filament deprecated: `schema()`→`form()`, `reactive()`→`live()` |
| B | Progressioni | 6 | deprecated Filament + test `Panel|null` method.nonObject |
| C | IndennitaCondizioniLavoro + IndennitaResponsabilita | 6 | deprecated Filament + test offsetAccess |
| D | Performance | 2 | deprecated `schema()`→`form()` |
| E | Xot | 5 | test Safe functions, trait.unused, Pest redundant |
| F | bashscripts/docs/prompts | — | revisione/miglioramento prompt (non-PHPStan) |

## Regole

- Fix alla radice (mai `@phpstan-ignore`, baseline, assert, cast).
- `schema()` → `form()` su `Filament\Tables\Filters\BaseFilter`;
  `reactive()` → `live()` su `Filament\Schemas\Components\Component`.
- Lock `bashscripts/lock/` su file condivisi; lock stale >24h rimossi
  dopo verifica assenza processi (fatto: lock di ottobre rimossi).
- Pest gate: eseguire Pest sullo scope toccato o documentare skip.
- Story per modulo toccato in `Modules/<Mod>/docs/bmad/stories/`.

## Esito

**39 errori → 0.** Run completo
`php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --no-progress --error-format=raw`
con exit 0 e nessuna segnalazione (10616 file, level max, nessun ignore/baseline).

| Cluster | Fix | Verifica |
|---|---|---|
| A Ptv | 6 filtri Filament `schema()`→`form()`/`reactive()`→`live()`; `DeleteCessatiAction` aggiornata; 2 `trait.unused` coperti da test probe (`WorkerTypesSharedTraitsTest`, 5 test/12 assertion) | PHPStan Ptv 0; Pest Ptv tests/Unit/Filament 51 passed + 3 failure preesistenti non correlate |
| B Progressioni | 3 table + 1 select + 4 `Panel|null` nei test, con `Assert::assertInstanceOf(Panel::class, $panel)`. Dettaglio: `./phpstan-fix-progressioni.story.md` | PHPStan 0; Pest mirato skip DB-gated |
| C ICL/IR | ICL: 4 rename Filament. IR: 1 rename + tipizzazione `array<string,mixed>` dei filtri test, contratto reale di `IndennitaResponsabilitaResource::getXlsFields()`. Dettaglio: `../../../../IndennitaCondizioniLavoro/docs/bmad/stories/phpstan-fix-icl.story.md` e `../../../../IndennitaResponsabilita/docs/bmad/stories/phpstan-fix-ir.story.md` | PHPStan 0; Pest IR skip DB-gated |
| D Performance | 2 filtri `schema()`→`form()`. Dettaglio: `../../../../Performance/docs/bmad/stories/phpstan-fix-performance-filters.story.md` | PHPStan 0; Pest 9 passed/345 assertion |
| E Xot | Trait `RequiresOperationalPermissions` mantenuto come contratto ADR e reso analizzabile da test Gate; Safe functions nel test symlink; expectation Pest ridondante sostituita. Dettaglio: `./phpstan-fix-xot.story.md` | Test trait 2 passed/2 assertion; Pest mirato 24 skipped (DB-gated) + 6 passed |

Pest mirato complessivo: exit 0, 6 passed / 24 skipped (skip `TestDatabaseGuard` su DB
Progressioni/IR non disponibili), 10 assertion, 92s.

Pulizia documentale: rimossa la vecchia story ICL del 2026-10-21 (piano superato, 646
errori) e allineati i nomi delle story a kebab-case stabile senza date.

Cluster F (revisione prompt in `bashscripts/docs/prompts/`) resta tracciato come
follow-up documentale, fuori dal perimetro PHPStan di questa story.

## Pulizia extra e debito noto (2026-11-11)

Oltre ai fix PHPStan:

- `Ptv/app/Filament/Tables/Filters/HasRatingValuesFilter.php` era un **documento
  markdown salvato come `.php`** (nessuna classe PHP; duplicava la memory wiki
  `ratings-non-zero-filter-implement.md` e conteneva un sample con `reactive()`
  obsoleto). La classe reale è `Modules\Rating\Filament\Tables\Filters\
  HasRatingValuesFilter` (usata da `BaseSchedasTable`). File eliminato.
- Due file `.php` **vuoti** (0 byte, tracciati, zero riferimenti) eliminati:
  `ICL/app/Models/CondizioniLavoroIndennitaTipoDettaglio.php` e
  `Pdnd/app/Services/Anpr/Shared/Models/Base/BaseResponse.php`.
- Sweep fleet-wide: zero `->reactive()` residui in `Modules/`+`Themes/`;
  `$this->schema()` residui sono method non-deprecate dei componenti Schema
  (verificato in `vendor/filament`).
- `public_html/themes/{One,Zero}` erano file di testo invece di symlink
  (`core.symlinks=false` nel checkout) — convertiti in symlink reali.

### Debito non risolto

- `XotBasePolicyTest` 1 failure **pre-esistente** (`hasRole('xot::admin')` non
  mockato); file lockato da altro agente (`codex-root`, 2026-11-05).
- `bashscripts/docs/prompts/` `.txt` categoria 2/3: ~20 candidati a
  delete/rigenerazione, 4 richiedono decisione umana; 5 `.cursor/rules`
  allineate a Filament 5/Laravel 13.
- `filament-action-rules.mdc` insegna `->label(trans(...))` in contraddizione
  con `no-filament-labels.mdc`.
- Pest Ptv: 3 failure pre-esistenti non correlate
  (`BaseListStabiDirigentesTest` ×2, `FormColumnParityTest`) — assegnare allo
  story owner StabiDirigente/FormColumn-parity.
