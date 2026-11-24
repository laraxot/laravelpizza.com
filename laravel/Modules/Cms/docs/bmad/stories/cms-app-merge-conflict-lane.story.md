---
title: "Cms app merge conflict lane"
status: done
module: Cms
updated: 2026-11-24
qmd: "cms app folio volt head schema merge conflict lane"
related:
  - ../../../Xot/docs/bmad/stories/phpstan-modules-zero-swarm-standing.story.md
  - ../../adr/folio-volt-sole-owner.md
  - ../filament-layout-styles-scripts.md
---

# Story: lane-cms — conflitti `app/**` + `config/config.php`

## Perché

Marker di merge in Cms rompono bootstrap PHPStan e la pipeline Folio+Volt+head/Schema.org.

## Decisioni

- Base: `laraxot/dev` quando HEAD era vuoto/docs-only.
- `FolioVoltServiceProvider`: DEV + `RedirectUnlocalizedPath` (FR-15); **no** `empty.php`.
- Head / `BuildHeadSchemaAction` / `ResolvePageMetaAction`: pipeline Schema.org DEV (`business`, fallback `name`/`content`).
- `BuildPageSchemaAction` Event: riferimento `@id` (HEAD) — evita Event incompleto per Google.
- `config.php`: allowlist `auth`, `guest`, `throttle`.

## Esito

18 file in scope risolti e staged; `php -l` ok; marker residui in `app/` = 0.

<<<<<<< .merge_file_gggny8
<<<<<<< .merge_file_yWdnpx
## Claims

| Claim | Evidence |
|---|---|
| `head.blade.php` + `foot.blade.php`: marker rimossi; contratto FO con `@if ($panelAssets)` + Vite/stack; `routes/web.php` senza marker e **senza** `Xot/routes/empty.php` | Blade risolte 2026-11-24; `rg '^<<<<<<<'` su quei path = 0 |

## Estensione: tests, docs, stragglers (2026-11-24)

Partenza: 216 file con marker nell'albero di lavoro (4 stragglers, 117 test, 95 docs), arrivo 0. Il blob `HEAD` (`ca74b86ab`) ne aveva 74 (72 docs, 2 test): l'albero era stato riportato a una versione con marker dopo l'ultimo commit, quindi `HEAD` serve da riferimento accanto a `dd46996a4`.

- **Metodo**: `classify_conflict_hunks.py` si ferma sui file con marker annidati (114 test su 115 lo erano), quindi parser ricorsivo dei marker; per ogni file si confrontano la vista «primo lato» e quella «ultimo lato» con la base.
- **Test** (117): 104 con vista modulo = base + `uses(TestCase::class)` per file (ADR `Xot/docs/adr/pest-testcase-binding-per-file.md`); 9 dal blob `HEAD` (stessa vista); a mano `TestCase.php`, `FolioVoltSoleOwnerTest`, `FilamentLayoutDirectivesTest` (regex `@if ($panelAssets)` come le Blade, path con `dirname(__DIR__, 3)` perché il test non avvia l'app) e il fixture `slug-probe.blade.php` (versione con `email=`, asserita da `PageComponentDataMergeTest`). Group `->group('<ID>-INV-n')`: 10 coppie file/ID prima e dopo, nessuna persa.
- **Docs** (95): 24 dal blob `HEAD`; 68 con regole per hunk (data più recente, minuscole nei titoli, link verso il target che esiste, altrimenti `README.md`/`Xot/docs`, testo `npm run copy` sostituito dalla frase con il symlink); a mano `contracts/README.md` e `adr/README.md` (tre copie dello stesso indice impilate), `wiki/concepts/cms-page-middleware-json-ssot.md` (allowlist reale `auth`, `guest`, `throttle`, non `verified`), `bmad/filament-layout-styles-scripts.md` (descrive `panelAssets`, default `true`; l'anti-pattern che lo vietava contraddiceva il codice).
- 21 docs avevano un secondo frontmatter incollato nel corpo (artefatto del lato modulo): tolto; `status:` della base rimesso dove mancava.
- **Stragglers**: `.gitignore` (unione, `tests/coverage-*.*` una volta sola), `routes/api.php`, `head`/`foot.blade.php` (risolte in parallelo da un altro agente con lo stesso risultato: `panelAssets`, `@stack('styles')`).
- **Finding**: `FolioVoltSoleOwnerTest` fallisce perché `laravel/app/Providers/FolioServiceProvider.php` è ancora tracciato (non registrato in `bootstrap/providers.php`): fuori da Cms, da togliere per l'ADR `folio-volt-sole-owner`. Nessun tema passa `:panel-assets="false"`. I link `canonical` di `redundancy-analysis.md` puntano a `Themes/docs/shared-components/`, che non esiste.

=======
>>>>>>> .merge_file_zWWHqi
=======
>>>>>>> .merge_file_Sqd5Kd
## Gate facts (creazione)

1. **Supersedes / duplicates**: non sostituisce `docs/stories/cms-merge-conflict-resolution.story.md` (docs-sweep storica, ancora con marker fuori scope); non duplica le story Folio locale auth. È il verbale operativo di **lane-cms** sul standing Xot.
2. **Linked from**: riga `lane-cms` in `Modules/Xot/docs/bmad/stories/phpstan-modules-zero-swarm-standing.story.md`.
3. **Why new**: standing Xot ha solo la riga Coordinamento; serve un verbale Cms kebab sotto `docs/bmad/stories/` già esistente.
4. **User instruction**: «Short update to Modules/Cms/docs/bmad/stories/ or Xot standing story Coordinamento lane-cms.»
