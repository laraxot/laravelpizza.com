---
title: PHPStan Cms a zero (solo tests)
type: story
module: Cms
phase: quality-gate
status: done
related:
  - ./phpstan-test-wave-cms.story.md
  - ./phpstan-cms-swarm-wave.story.md
  - ../00-INDEX.md
  - ../phpstan-fix-plan/plan.md
  - ../../../../../bashscripts/docs/prompts/11-phpstan.md
---

# PHPStan Cms a zero (solo tests)

## Scopo

Portare `Modules/Cms` a **0 errori PHPStan** sui test (inventario `/tmp/phpstan_by_module/Cms.txt`: 145 errori in 7 file), correggendo la causa e non silenziando. I test devono verificare il contratto reale del Cms: pagine JSON per tenant, blocchi tipizzati, risorse Filament su `XotBaseResource`/`LangBaseResource`, rotte Folio.

## Inventario (famiglie)

| Famiglia | File | Causa radice | Fix |
|---|---|---|---|
| `theCodingMachineSafe.function` + `argument.type` su `file_get_contents`/`json_decode` | Homepage*, IndividualFolio*, PestHelpers | I/O nativo puo' restituire `false` | `use function Safe\…` e loader tipizzato su `TestCase` |
| `function.notFound` `cmsHomepageBlocks` | Homepage*, FilamentBuilder*, IndividualFolio* | Helper non collegato / path fantasma `<nome progetto>` | `cmsHomepageBlocks()` delega a `TestCase::homepageBlocksForLocale()`; `Pest.php` fa `require_once PestHelpers.php` |
| `offsetAccess.nonOffsetAccessible` / `foreach.nonIterable` su JSON `mixed` | stessi + PestHelpers | Decode senza shape | `homepageJsonForBlocksArchitecture()` restituisce array shape (`id`, `slug`, `title`, `content_blocks`) |
| `method.deprecated` `DataCollection::filter/each` | Homepage*, FilamentBuilder* | Spatie Data v5 | `collect($dataCollection)->…` (Collection Laravel) |
| `pest.expectation.redundant` | Homepage*, FilamentBuilder* | `toBeInstanceOf`/`toBeArray` su tipo gia' noto | rimossi |
| `method.staticCall` / `alreadyNarrowedType` su Resource | ResourceExtensionTest | `getFormSchema()` final vuoto su Resource; schema in `Schemas\*Form` | assert su `getFormClass()` e dichiarazione metodi |
| `pest.config.redundantLocalUse` / Folio parse | FolioRoutesTest | `uses(TestCase)` ridondante; `preg_match` su mixed | binding solo in Pest.php; `Safe\preg_*` + guardie |
| `argument.type` `strpos` su `string\|false` | HomepageContentManagementTest | `getContent()` puo' essere false | guardia `is_string` prima di `strpos` |

Nessun `@phpstan-ignore`, baseline, `assert()` o cast solo per silenziare. `phpstan.neon` non toccato.

## Verifica

```bash
cd laravel
./vendor/bin/phpstan clear-result-cache
./vendor/bin/phpstan analyse Modules/Cms --no-progress --memory-limit=2G
# → [OK] No errors (exit 0)
```

Misura sul working tree: inventario 09:55 (145) → dopo consolidamento loader + Resource/Folio (10:12+) → **0**.

Spike fleet ~12:21 (`phpstan.parse`, marker merge in Lang/AI/Cms): **`parse` ≠ errori di tipo** — [Lang phpstan-lang-zero](../../Lang/docs/stories/phpstan-lang-zero.story.md).

## Collegamenti

- Dettaglio lane/swarm: [phpstan-test-wave-cms.story.md](./phpstan-test-wave-cms.story.md)
- Gate TSV: [phpstan-cms-swarm-wave.story.md](./phpstan-cms-swarm-wave.story.md)
- Piano: [../phpstan-fix-plan/plan.md](../phpstan-fix-plan/plan.md)
- Indice modulo: [../00-INDEX.md](../00-INDEX.md)
