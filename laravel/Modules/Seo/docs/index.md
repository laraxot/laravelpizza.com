---
title: "Seo module: indice documentazione"
type: index
status: active
canonical: true
updated: 2026-10-14
tags: [seo, docs, index, canonical]
qmd: "seo module docs index master catalogo canonico superseded duplicati stub stale pilot docs-organization"
related:
  - ./stories/docs-organization-pilot.story.md
  - ./stories/docs-index-audit.story.md
  - ../../../../bmad-output/docs-organization-audit.md
issues: []
discussions: []
---

# Seo module — documentation index

Master index of `docs/` for the Seo module, organized by topic. Every `.md` file under `docs/` is linked from here, either directly or inside the "Storico / da consolidare" section. No file was renamed, moved, or deleted while building this index.

**Indice canonico: questo file.** Gli altri indici di radice (`00-INDEX.md`, `00-index.md`, `INDEX.md`) sono `status: superseded` con `superseded_by: index.md` dal 2026-10-08. `README.md` resta la presentazione del modulo (regola `theme-module-docs-readme-mandatory`), non un secondo indice.

Legenda `status` nel frontmatter: `active` (valido), `stub` (rimanda a un canonico), `superseded` (copia di un altro file, `superseded_by` dice quale), `stale` (obsoleto, con nota datata sotto il frontmatter), `draft` (segnaposto da compilare). Nessun file e' stato cancellato, spostato o rinominato.

Related entry points: [README.md](./README.md) (module overview), [docs/wiki/index.md](./wiki/index.md) (second-brain wiki), [docs/roadmap/README.md](./roadmap/README.md) (roadmap hub).

## Stato verificato e mappa delle directory (2026-10-14)

Il codice del modulo e' piccolo: facade `Metatag` con tre Actions in `app/Actions/Metatag/`, link di condivisione social (`GenerateSocialShareLinksAction`, widget, componente Blade). Non ci sono Model, migration, rotte, comandi Artisan, Resource Filament ne' sitemap, e nessun altro modulo importa `Modules\Seo`. Prove e quick start in [README.md](./README.md). I documenti di prodotto (PRD, roadmap, strategy, sprint, launch, research, `task-*`, `seo-optimization-*`) descrivono funzioni previste (sitemap, Schema.org, analisi AI, report PDF) che oggi non esistono: vanno letti come piani, non come stato.

**Aggiornamento 2026-11-01:** il paragrafo sopra descrive lo stato del 2026-10-14. Oggi il modulo ha anche `GET /sitemap.xml` (`seo.sitemap`) e `GET /robots.txt` (`seo.robots`) in `routes/web.php`, `Actions/Sitemap/BuildSitemapAction`, `Actions/Robots/BuildRobotsTxtAction` e `Actions/Url/NormalizeLocalizedPathAction`; `SeoServiceProvider` definisce `$module_dir` e `$module_ns`. Seo importa l'Action di Cms `ResolveRobotsPolicyAction` (non il contrario). Il componente `<head>` sta in Cms. Cause e correzioni: [story dcp-274](./stories/dcp-274-sitemap-completeness-verification.story.md).

Nota di contratto: `bmad-output/docs-architecture/module-theme-docs-contract.md` indica `00-INDEX.md` come indice operativo, ma in Seo la scelta del 2026-10-08 (pilota) e' `index.md`, con `00-INDEX.md`, `00-index.md` e `INDEX.md` marcati `superseded`. Decisione aperta: vedi la story [2026-10-14-docs-seo-studio](./stories/docs-seo-studio.story.md).

| Directory | Ruolo | Note |
|---|---|---|
| `wiki/` | canonica (concetti, regole, log) | 33 .md; `wiki/log.md` e' il registro cronologico |
| `stories/` | evidence BMAD | 6 file; la story del 2026-10-14 e' l'ultima |
| `bmad/` | evidence | dossier e status (3 file) |
| `investigation/` | diagnosi non risolte | 1 file segnaposto, `draft` |
| `roadmap/` | piani, non stato | 28 file, molti paralleli |
| `concepts/` | residuo | 1 file (`xotbase-never-extend-filament.md`); il canone e' `wiki/concepts/` |
| `llm-wiki/` | legacy | precede `wiki/`, cataloghi quasi vuoti |
| `raw/` | sorgenti immutabili | non si riscrive |
| `screenshots/` | evidence | 1 PNG |

File con `status: stale` per codice inesistente o contenuto estraneo (2026-10-14): `getting-started.md`, `navigation.md`, `custom-404-page.md`, `customizing-your-site.md`, `algolia-docsearch.md` (template Jigsaw), `configuration.md`, `testing.md`, `docs-health.md`, `project-structure.md`.

## Overview and getting started

- [README.md](./README.md) — module overview (canonical entry point)
- [readme-en.md](./readme-en.md) — English presentation
- [getting-started.md](./getting-started.md)
- [configuration.md](./configuration.md)
- [04-datas.md](./04-datas.md) — data/model notes
- [module.md](./module.md) - module doctrine (scope, religion, policy)
- [filament.md](./filament.md) — reference link (ralphjsmit/laravel-filament-seo)
- [structure.md](./structure.md) — legacy auto-generated structure dump (2025-04-23, contains stale merge-conflict markers; superseded in spirit by `project-structure.md` but kept as-is)

## Architecture and conventions

- [project-structure.md](./project-structure.md) — directory/wiki structure and conventions (canonical; see duplicate `PROJECT-STRUCTURE.md` below)
- [contracts-naming.md](./contracts-naming.md)
- [concepts/xotbase-never-extend-filament.md](./concepts/xotbase-never-extend-filament.md)
- [services-to-adapters-conversion.md](./services-to-adapters-conversion.md)
- [dependencies.md](./dependencies.md)
- [dependency-intelligence.md](./dependency-intelligence.md)
- [on-demand-pattern.md](./on-demand-pattern.md) — canonical (see duplicate `ON-DEMAND-PATTERN.md` below)
- [performance-optimization.md](./performance-optimization.md) — canonical (see duplicate `PERFORMANCE-OPTIMIZATION.md` below)
- [no-ai-tool-scaffold-dirs.md](./no-ai-tool-scaffold-dirs.md)
- [PHILOSOPHY.md](philosophy-religion.md) - long philosophy document (stale: cites files that do not exist); [philosophy.md](./philosophy.md) is a different, short introduction

## SEO features

Attenzione: questa sezione elenca documenti, non funzioni. Esistono nel codice solo i metatag (facade) e la condivisione social; sitemap, Schema.org e analisi non sono implementati.

- [sitemap.md](./sitemap.md) — reference link
- [navigation.md](./navigation.md)
- [custom-404-page.md](./custom-404-page.md)
- [customizing-your-site.md](./customizing-your-site.md)
- [algolia-docsearch.md](./algolia-docsearch.md)
- [social-share-component.md](./social-share-component.md)
- [social-sharing-component.md](./social-sharing-component.md)
- [social-share-copy-localization.md](./social-share-copy-localization.md)
- [task-schema-org-eventi.md](./task-schema-org-eventi.md)
- [task-sitemap-generation.md](./task-sitemap-generation.md)
- [seo-optimization-report.md](./seo-optimization-report.md)
- [seo-optimization-roadmap.md](./seo-optimization-roadmap.md)

## Testing and quality

- [testing.md](./testing.md)
- [coverage.md](./coverage.md)
- [phpstan-roadmap.md](./phpstan-roadmap.md)
- [cyclomatic-complexity-report.md](./cyclomatic-complexity-report.md)
- [dry-kiss-analysis.md](./dry-kiss-analysis.md)
- [code-quality-report.md](./code-quality-report.md)
- [code-quality-improvement-report.md](./code-quality-improvement-report.md)
- [duplicate-methods-analysis.md](./duplicate-methods-analysis.md)
- [ponytail-audit-over-engineering.md](./ponytail-audit-over-engineering.md)
- [docs-health.md](./docs-health.md)
- [task-creare-test-suite.md](./task-creare-test-suite.md)

## Product, planning and roadmap

- [prd.md](./prd.md) — canonical (see duplicate `PRD.md` below)
- [product-strategy.md](./product-strategy.md) — "Seo - Product Strategy" (distinct from `product_strategy.md` below)
- [product_strategy.md](./product_strategy.md) — "Seo Module - Product Strategy", canonical (see duplicate `PRODUCT_STRATEGY.md` below)
- [strategy.md](./strategy.md) — "Product Strategy Doc" (distinct third document)
- [research.md](./research.md)
- [user_research.md](./user_research.md) — canonical (see duplicate `USER_RESEARCH.md` below)
- [sprint.md](./sprint.md) — "Sprint Planning Meeting" (distinct from `sprint_planning.md`)
- [sprint_planning.md](./sprint_planning.md) — canonical (see duplicate `SPRINT_PLANNING.md` below)
- [task-implementazione-base.md](./task-implementazione-base.md)
- [launch.md](./launch.md)
- [product_launch_plan.md](./product_launch_plan.md) — canonical (see duplicate `PRODUCT_LAUNCH_PLAN.md` below)
- [product_roadmap.md](./product_roadmap.md) — canonical (see duplicate `PRODUCT_ROADMAP.md` below)
- [roadmap.md](./roadmap.md) — canonical top-level roadmap (see 4 duplicates below: `ROADMAP.md`, `roadmap-2025.md`, `ROADMAP-2025.md`, `ROADMAP_2025.md`)

### Roadmap directory (`docs/roadmap/`)

- [roadmap/README.md](./roadmap/README.md) — roadmap directory entry point
- [roadmap/legacy-roadmap.md](./roadmap/legacy-roadmap.md)
- [roadmap/phases.md](./roadmap/phases.md)
- [roadmap/quality.md](./roadmap/quality.md)
- [roadmap/vision.md](./roadmap/vision.md)
- [roadmap/00-index.md](./roadmap/00-index.md) — canonical (see duplicate `roadmap/00-INDEX.md` below)
- [roadmap/00-overview.md](./roadmap/00-overview.md)
- [roadmap/01-current-state.md](./roadmap/01-current-state.md)
- [roadmap/01-now.md](./roadmap/01-now.md)
- [roadmap/02-goals.md](./roadmap/02-goals.md)
- [roadmap/02-next.md](./roadmap/02-next.md)
- [roadmap/03-later.md](./roadmap/03-later.md)
- [roadmap/03-workstreams.md](./roadmap/03-workstreams.md)
- [roadmap/04-milestones.md](./roadmap/04-milestones.md)
- [roadmap/04-risks.md](./roadmap/04-risks.md) — "Risks and dependencies"
- [roadmap/05-risks.md](./roadmap/05-risks.md) — "Risks - Seo" (distinct content from `04-risks.md`, not a byte-for-byte duplicate; both kept)

## Tooling, MCP and setup

- [mcp-configuration.md](./mcp-configuration.md)
- [qmd-setup.md](./qmd-setup.md) — canonical (see duplicate `QMD-SETUP.md` below)
- [mcp_server_consigliati.md](mcp-server-consigliati.md) — canonical IT variant (see duplicate `MCP_SERVER_CONSIGLIATI.md` below)
- [mcp_server_recommended.md](mcp-server-recommended.md) — canonical EN variant (see duplicate `MCP_SERVER_RECOMMENDED.md` below)
- `root-file-policy.md` - file assente al 2026-10-08 (link rimosso; esiste solo nel tema Meetup)
- `root-files-hygiene.md` - file assente al 2026-10-08 (link rimosso)
- [links.md](./links.md) — raw link dump (SEO packages/tutorials)
- [action-sentinel-main-to-module-20260313T132007Z.md](./action-sentinel-main-to-module-Z.md) — canonical (see lowercase-timestamp duplicate below)

## Fixes, conflicts and incident reports

- [conflict-resolution.md](./conflict-resolution.md)
- [boost-skill-fix-summary.md](./boost-skill-fix-summary.md)
- [redundancy-audit.md](./redundancy-audit.md) - audit del 2026-05-21 (ex `redundancy-audit.md`), distinct from the `redundancy_analysis.md`/`REDUNDANCY_ANALYSIS.md` stub pair (see Storico)
- [wiki/troubleshooting/git-merge-conflict-inventory.md](./wiki/troubleshooting/git-merge-conflict-inventory.md) (ex `...-2026-04-28.md`)

## Wiki / second brain (`docs/wiki/`)

- [wiki/README.md](./wiki/README.md)
- [wiki/index.md](./wiki/index.md) — wiki master catalog
- [wiki/schema.md](./wiki/schema.md)
- [wiki/module-purpose.md](./wiki/module-purpose.md) - module purpose (BMAD, 2026-10-06)
- [wiki/readme.md](./wiki/README.md) - lowercase copy of `wiki/README.md`, superseded
- [wiki/log.md](./wiki/log.md) — append-only activity log
- [wiki/agents.md](wiki/AGENTS.md) — canonical (see duplicate `wiki/AGENTS.md` below)
- [wiki/overviews/seo-module.md](./wiki/overviews/seo-module.md)
- [wiki/concepts/composer-go-quality-gates.md](./wiki/concepts/composer-go-quality-gates.md)
- [wiki/concepts/composer-root-minimal-nwidart.md](./wiki/concepts/composer-root-minimal-nwidart.md)
- [wiki/concepts/index.md](./wiki/concepts/index.md) — canonical (see duplicate `wiki/concepts/INDEX.md` below)
- [wiki/concepts/metatag-data-contract.md](./wiki/concepts/metatag-data-contract.md)
- [wiki/concepts/no-app-support-queueable-actions.md](./wiki/concepts/no-app-support-queueable-actions.md)
- [wiki/concepts/phpstan-compliance.md](./wiki/concepts/phpstan-compliance.md)
- [wiki/concepts/ponytail-audit.md](./wiki/concepts/ponytail-audit.md)
- [wiki/concepts/second-brain-local-discipline.md](./wiki/concepts/second-brain-local-discipline.md)
- [wiki/concepts/testing.md](./wiki/concepts/testing.md)
- [wiki/rules/index.md](./wiki/rules/index.md) — canonical (see duplicate `wiki/rules/INDEX.md` below)
- [wiki/rules/module-contracts-naming-placement.md](./wiki/rules/module-contracts-naming-placement.md) — "Rule: suffisso Contract e collocazione contratti modulo" (distinct from the skills/ file with the same basename)
- [wiki/skills/index.md](./wiki/skills/index.md) — canonical (see duplicate `wiki/skills/INDEX.md` below)
- [wiki/skills/module-contracts-naming-placement.md](./wiki/skills/module-contracts-naming-placement.md) — "Skill: contratti modulo — Contract suffix e placement" (distinct content, same basename as the rules/ file above; not a duplicate, just a naming collision across subfolders)
- [wiki/commands/index.md](./wiki/commands/index.md) — canonical (see duplicate `wiki/commands/INDEX.md` below)
- [wiki/memories/index.md](./wiki/memories/index.md) — canonical (see duplicate `wiki/memories/INDEX.md` below)

## LLM wiki — legacy second brain (`docs/llm-wiki/`)

Predates `docs/wiki/`; mostly empty catalogs today. Kept as-is, not merged.

- [llm-wiki/index.md](./llm-wiki/index.md)
- [llm-wiki/agents.md](llm-wiki/AGENTS.md) — canonical (see duplicate `llm-wiki/AGENTS.md` below)
- [llm-wiki/log.md](./llm-wiki/log.md)
- [llm-wiki/_templates/concept.md](./llm-wiki/_templates/concept.md)
- [llm-wiki/_templates/entity.md](./llm-wiki/_templates/entity.md)
- [llm-wiki/_templates/source.md](./llm-wiki/_templates/source.md)

## Raw sources (`docs/raw/`)

Immutable-source layer per [raw/index.md](./raw/index.md): read by the LLM, not rewritten; syntheses belong in `docs/wiki/`.

- [raw/index.md](./raw/index.md)
- [raw/README.md](./raw/README.md)
- [raw/root-import/changelog.md](./raw/root-import/changelog.md)

Test/sync artifacts under `raw/root-import/` are listed in Storico below.

## Root-archived files (`docs/root-md-files/`)

La directory `root-md-files/` non esiste piu' al 2026-10-08. Il changelog archiviato e' `raw/root-import/changelog.md` (elencato sopra).

## BMAD, stories and decision records

- [stories/seo-site-defaults-hreflang-schema.story.md](./stories/seo-site-defaults-hreflang-schema.story.md) — policy ownership and shared CMS SEO actions
- [stories/docs-index-audit.story.md](./stories/docs-index-audit.story.md) - first documentation-index audit (2026-09-26)
- [stories/phpstan-cleanup-seo.story.md](./stories/phpstan-cleanup-seo.story.md) and [.dev.md](./stories/phpstan-cleanup-seo.dev.md) - PHPStan cleanup
- [stories/phpstan-Seo-fix.md](./stories/phpstan-Seo-fix.md) - earlier PHPStan fix note
- [stories/2026-10-08-docs-organization-pilot.story.md](./stories/docs-organization-pilot.story.md) - this reorganization pilot (frontmatter, links, superseded markers)
- [stories/services-to-actions-seo.story.md](./stories/services-to-actions-seo.story.md) - Services to Actions (removal of `MetatagService`); the docs that cite `app/Services/MetatagService.php` become stale after it
- [stories/blade-i18n-no-hardcoded-text.story.md](./stories/blade-i18n-no-hardcoded-text.story.md) - no fixed text in Blade views (it, en, de, es): rule, numbers, residuals
- [bmad/README.md](./bmad/README.md), [bmad/bmad-dossier.md](./bmad/bmad-dossier.md), [bmad/status.md](./bmad/status.md) - BMAD dossier
- [decision-log.md](./decision-log.md) - decision log (empty template, `draft`)
- [investigation/investigation.md](./investigation/investigation.md) - Schema.org auto-generation investigation (placeholder, `draft`)

## Related modules and themes

- [Xot docs](../../Xot/docs/README.md) - core framework and base classes
- [Geo docs](../../Geo/docs/README.md) - Schema.org Place integration
- [Meetup theme docs](../../../Themes/Meetup/docs/00-INDEX.md) - Schema.org Event integration (Meetup is a theme, not a module)

---

## Storico / da consolidare

Nothing below was deleted, renamed, or moved. From 2026-10-08 every copy listed in section A carries `status: superseded` and `superseded_by` in its frontmatter (body untouched, except a visible note on the three superseded root indexes); the stubs in section B carry `status: stub`. Grouped here only so the index above stays readable. Consolidation (if ever done) is a separate, deliberate task.

### A. Duplicate content (same or near-identical text, different case/separator in the filename)

| Topic | Files | Note |
|---|---|---|
| Top-level index (pre-audit) | [`00-index.md`](./00-index.md), [`00-INDEX.md`](./00-index.md) | Near-identical (1 link differs: `README.md` vs `readme.md`); superseded by this `index.md` (`status: superseded`), kept for history |
| On-demand pattern | [`ON-DEMAND-PATTERN.md`](on-demand-pattern.md) | Byte-identical to `on-demand-pattern.md` |
| Performance optimization | [`PERFORMANCE-OPTIMIZATION.md`](performance-optimization.md) | Byte-identical to `performance-optimization.md` |
| PRD | [`PRD.md`](prd.md) | Byte-identical to `prd.md` |
| Project structure | [`PROJECT-STRUCTURE.md`](project-structure.md) | Byte-identical to `project-structure.md` |
| QMD setup | [`QMD-SETUP.md`](qmd-setup.md) | Byte-identical to `qmd-setup.md` |
| Product launch plan | [`PRODUCT_LAUNCH_PLAN.md`](product_launch_plan.md) | Byte-identical to `product_launch_plan.md` |
| Product roadmap | [`PRODUCT_ROADMAP.md`](product_roadmap.md) | Byte-identical to `product_roadmap.md` |
| Product strategy | [`PRODUCT_STRATEGY.md`](product_strategy.md) | Byte-identical to `product_strategy.md` |
| Sprint planning | [`SPRINT_PLANNING.md`](sprint_planning.md) | Byte-identical to `sprint_planning.md` |
| User research | [`USER_RESEARCH.md`](user_research.md) | Byte-identical to `user_research.md` |
| Roadmap 2025 (top-level) | [`ROADMAP.md`](roadmap.md), [`roadmap-2025.md`](./roadmap-2025.md), [`ROADMAP-2025.md`](./ROADMAP-2025.md), [`ROADMAP_2025.md`](./ROADMAP_2025.md) | All near-identical to `roadmap.md` (only a trailing "Last Updated" line differs). Dal 2026-10-08 `ROADMAP-2025.md` e `ROADMAP_2025.md` sono `superseded_by: roadmap-2025.md` (identici nel corpo); `ROADMAP.md` non e' un duplicato esatto e resta `active` |
| Roadmap sub-index | [`roadmap/00-INDEX.md`](./roadmap/00-index.md) | Byte-identical to `roadmap/00-index.md` |
| Action sentinel log | [`action-sentinel-main-to-module-t132007z.md`](./action-sentinel-main-to-module-t132007z.md) | Byte-identical to the uppercase-`T` filename, only timestamp casing differs |
| MCP server consigliati (IT) | [`MCP_SERVER_CONSIGLIATI.md`](mcp-server-consigliati.md) | Byte-identical to `mcp_server_consigliati.md` |
| MCP server recommended (EN) | [`MCP_SERVER_RECOMMENDED.md`](mcp-server-recommended.md) | Byte-identical to `mcp_server_recommended.md` |
| Wiki agents | [`wiki/AGENTS.md`](./wiki/AGENTS.md) | Byte-identical to `wiki/agents.md` (both contain an unrendered `{{TYPE^}}` template placeholder) |
| LLM-wiki agents | [`llm-wiki/AGENTS.md`](./llm-wiki/AGENTS.md) | Byte-identical to `llm-wiki/agents.md` |
| Wiki commands index | [`wiki/commands/INDEX.md`](./wiki/commands/index.md) | Byte-identical to `wiki/commands/index.md` |
| Wiki concepts index | [`wiki/concepts/INDEX.md`](./wiki/concepts/index.md) | Byte-identical to `wiki/concepts/index.md` |
| Wiki memories index | [`wiki/memories/INDEX.md`](./wiki/memories/index.md) | Byte-identical to `wiki/memories/index.md` |
| Wiki rules index | [`wiki/rules/INDEX.md`](./wiki/rules/index.md) | Byte-identical to `wiki/rules/index.md` |
| Wiki skills index | [`wiki/skills/INDEX.md`](./wiki/skills/index.md) | Byte-identical to `wiki/skills/index.md` |
| Docs root index placeholder | [`INDEX.md`](./INDEX.md) | Thin placeholder, superseded by this `index.md` since 2026-10-08, kept for reference |

### B. Stub pointers to Themes shared docs (`module: theme` frontmatter — not Seo-specific content)

These files only contain a `canonical: ../../../Themes/docs/shared-components/...` pointer. They are not duplicated content within this module, but they do duplicate the *topic* of a real Seo doc listed above; grouped here for visibility.

- [codex-error-fix.md](./codex-error-fix.md)
- [file-naming-rules.md](./file-naming-rules.md)
- [folio-volt-best-practices.md](./folio-volt-best-practices.md)
- [.github/links.md](./.github/links.md)
- [mcp-server-consigliati.md](./mcp-server-consigliati.md)
- [mcp-server-recommended.md](./mcp-server-recommended.md)
- [merge-conflict-files-list.md](./merge-conflict-files-list.md)
- [merge-conflicts-list.md](./merge-conflicts-list.md) — points to a different canonical topic than the file above; not a duplicate of it
- [metodi-duplicati-analisi.md](./metodi-duplicati-analisi.md)
- [metodi_duplicati_analisi.md](./metodi_duplicati_analisi.md)
- [METODI-DUPLICATI-ANALISI.md](metodi-duplicati-analisi.md)
- [METODI_DUPLICATI_ANALISI.md](metodi_duplicati_analisi.md)
- [phpstan.md](./phpstan.md)
- [product-launch-plan.md](./product-launch-plan.md)
- [product-roadmap.md](./product-roadmap.md)
- [redundancy_analysis.md](./redundancy_analysis.md)
- [REDUNDANCY_ANALYSIS.md](redundancy_analysis.md)
- [roadmap/current-state.md](./roadmap/current-state.md)
- [roadmap/goals.md](./roadmap/goals.md)
- [roadmap/index.md](./roadmap/index.md)
- [roadmap/later.md](./roadmap/later.md)
- [roadmap/legacy/legacy-roadmap-x.md](./roadmap/legacy/legacy-roadmap-x.md)
- [roadmap/milestones.md](./roadmap/milestones.md)
- [roadmap/next.md](./roadmap/next.md)
- [roadmap/now.md](./roadmap/now.md)
- [roadmap/overview.md](./roadmap/overview.md)
- [roadmap/risks.md](./roadmap/risks.md)
- [roadmap/workstreams.md](./roadmap/workstreams.md)
- [rules-index.md](./rules-index.md)
- [rules-testing-no-migrate-fresh.md](./rules-testing-no-migrate-fresh.md)
- [sprint-planning.md](./sprint-planning.md)
- [user-research.md](./user-research.md)
- [wiki/_templates/concept.md](./wiki/_templates/concept.md)
- [wiki/_templates/entity.md](./wiki/_templates/entity.md)
- [wiki/_templates/source.md](./wiki/_templates/source.md)

### C. Test/sync tool artifacts (empty or placeholder content)

Residue from doc-sync tooling tests. No informational content.

- [sync-test-file.md](./sync-test-file.md)
- [sync_test_file.md](./sync_test_file.md)
- [SYNC_TEST_FILE.md](sync_test_file.md)
- [test_2025_03_24.md](./test-vuoto-nessun.md)
- [test_2025_03_24_bb.md](./test-bb-vuoto-nessun.md)
- [test-bb.md](./test-bb.md)
- [test.md](./test.md)
- [raw/root-import/sync-test-file.md](./raw/root-import/sync-test-file.md)
- [raw/root-import/sync-test-file-1.md](./raw/root-import/sync-test-file-1.md)
- [raw/root-import/sync-test-file-2.md](./raw/root-import/sync-test-file-2.md)
- [raw/root-import/sync-test-file-3.md](./raw/root-import/sync-test-file-3.md)
- [raw/root-import/test.md](./raw/root-import/test.md)
- [raw/root-import/test-1.md](./raw/root-import/test-1.md)
- [raw/root-import/test-bb.md](./raw/root-import/test-bb.md)
- [raw/root-import/test-bb-1.md](./raw/root-import/test-bb-1.md)
- [raw/root-import/test-2025-03-24.md](./raw/root-import/test-2025-03-24.md)
- [raw/root-import/test-2025-03-24-bb.md](./raw/root-import/test-2025-03-24-bb.md)