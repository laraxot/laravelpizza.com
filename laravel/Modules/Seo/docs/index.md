---
title: "Seo module: indice documentazione"
type: index
status: active
canonical: true
updated: 2026-11-19
tags: [seo, docs, index, canonical]
qmd: "seo module docs index master catalogo canonico superseded duplicati stub stale pilot docs-organization"
related:
  - ./stories/docs-organization-pilot.story.md
  - ./stories/docs-index-audit.story.md
  - ../../../../bmad-output/docs-organization-audit-2026-10-08.md
issues: []
discussions: []
---

# Seo module — documentation index

Master index of `docs/` for the Seo module, organized by topic. Every `.md` file under `docs/` is linked from here, either directly or inside the "Storico / da consolidare" section. No file was renamed, moved, or deleted while building this index.

**Indice canonico: questo file.** Gli altri indici di radice (`00-INDEX.md`, `00-index.md`, `INDEX.md`) sono stati rimossi il 2026-11-19 (issue #64). `README.md` resta la presentazione del modulo (regola `theme-module-docs-readme-mandatory`), non un secondo indice.

Legenda `status` nel frontmatter: `active` (valido), `stub` (rimanda a un canonico), `superseded` (copia di un altro file, `superseded_by` dice quale), `stale` (obsoleto, con nota datata sotto il frontmatter), `draft` (segnaposto da compilare). Nessun file e' stato cancellato, spostato o rinominato.

Related entry points: [README.md](./README.md) (module overview), [docs/wiki/index.md](./wiki/index.md) (second-brain wiki), [docs/roadmap/README.md](./roadmap/README.md) (roadmap hub).

- [stories/audit-qualita.story.md](./stories/audit-qualita.story.md) — audit qualita' (issue #64)

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

- [project-structure.md](./project-structure.md) — directory/wiki structure and conventions (canonical; see duplicate `project-structure-2.md` below)
- [contracts-naming.md](./contracts-naming.md)
- [concepts/xotbase-never-extend-filament.md](./concepts/xotbase-never-extend-filament.md)
- [services-to-adapters-conversion.md](./services-to-adapters-conversion.md)
- [dependencies.md](./dependencies.md)
- [dependency-intelligence.md](./dependency-intelligence.md)
- [on-demand-pattern.md](./on-demand-pattern.md) — canonical (see duplicate `on-demand-pattern-2.md` below)
- [performance-optimization.md](./performance-optimization.md) — canonical (see duplicate `performance-optimization-2.md` below)
- [no-ai-tool-scaffold-dirs.md](./no-ai-tool-scaffold-dirs.md)
- [philosophy-2.md](./philosophy-2.md) - long philosophy document (stale: cites files that do not exist); [philosophy.md](./philosophy.md) is a different, short introduction

## SEO features

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

- [prd.md](./prd.md) — canonical (see duplicate `prd-2.md` below)
- [product-strategy.md](./product-strategy.md) — "Seo - Product Strategy" (distinct from `product-strategy-3.md` below)
- [product-strategy-3.md](./product-strategy-3.md) — "Seo Module - Product Strategy", canonical (see duplicate `product-strategy-2.md` below)
- [strategy.md](./strategy.md) — "Product Strategy Doc" (distinct third document)
- [research.md](./research.md)
- [user-research-3.md](./user-research-3.md) — canonical (see duplicate `user-research-2.md` below)
- [sprint.md](./sprint.md) — "Sprint Planning Meeting" (distinct from `sprint-planning-3.md`)
- [sprint-planning-3.md](./sprint-planning-3.md) — canonical (see duplicate `sprint-planning-2.md` below)
- [task-implementazione-base.md](./task-implementazione-base.md)
- [launch.md](./launch.md)
- [product-launch-plan-3.md](./product-launch-plan-3.md) — canonical (see duplicate `product-launch-plan-2.md` below)
- [product-roadmap-3.md](./product-roadmap-3.md) — canonical (see duplicate `product-roadmap-2.md` below)
- [roadmap.md](./roadmap.md) — canonical top-level roadmap (vedi il duplicato `roadmap-2.md` sotto; le copie `roadmap-2025.md`, `ROADMAP-2025.md`, `ROADMAP_2025.md` sono state fuse qui il 2026-11-19)

### Roadmap directory (`docs/roadmap/`)

- [roadmap/README.md](./roadmap/README.md) — roadmap directory entry point
- [roadmap/legacy-roadmap.md](./roadmap/legacy-roadmap.md)
- [roadmap/phases.md](./roadmap/phases.md)
- [roadmap/quality.md](./roadmap/quality.md)
- [roadmap/vision.md](./roadmap/vision.md)
- [roadmap/00-index.md](./roadmap/00-index.md) — canonical (see duplicate `roadmap/00-index-2.md` below)
- roadmap/00-overview.md
- [roadmap/01-current-state.md](./roadmap/01-current-state.md)
- roadmap/01-now.md
- [roadmap/02-goals.md](./roadmap/02-goals.md)
- roadmap/02-next.md
- roadmap/03-later.md
- [roadmap/03-workstreams.md](./roadmap/03-workstreams.md)
- [roadmap/04-milestones.md](./roadmap/04-milestones.md)
- roadmap/04-risks.md — "Risks and dependencies"
- [roadmap/05-risks.md](./roadmap/05-risks.md) — "Risks - Seo" (distinct content from `04-risks.md`, not a byte-for-byte duplicate; both kept)

## Tooling, MCP and setup

- [mcp-configuration.md](./mcp-configuration.md)
- [qmd-setup.md](./qmd-setup.md) — canonical (see duplicate `qmd-setup-2.md` below)
- [mcp-server-consigliati-3.md](./mcp-server-consigliati-3.md) — canonical IT variant (see duplicate `mcp-server-consigliati-2.md` below)
- [mcp-server-recommended-3.md](./mcp-server-recommended-3.md) — canonical EN variant (see duplicate `mcp-server-recommended-2.md` below)
- `root-file-policy.md` - file assente al 2026-10-08 (link rimosso; esiste solo nel tema Meetup)
- `root-files-hygiene.md` - file assente al 2026-10-08 (link rimosso)
- [links.md](./links.md) — raw link dump (SEO packages/tutorials)
- [action-sentinel-main-to-module.md](action-sentinel-main-to-module.md) — canonical (see lowercase-timestamp duplicate below)

## Fixes, conflicts and incident reports

- [conflict-resolution.md](./conflict-resolution.md)
- [boost-skill-fix-summary.md](./boost-skill-fix-summary.md)
- [redundancy-audit.md](./redundancy-audit.md) - audit del 2026-05-21 (ex `redundancy-audit.md`), distinct from the `redundancy-analysis-2.md`/`redundancy-analysis.md` stub pair (see Storico)
- [wiki/troubleshooting/git-merge-conflict-inventory.md](./wiki/troubleshooting/git-merge-conflict-inventory.md) (ex `...-2026-04-28.md`)

## Wiki / second brain (`docs/wiki/`)

- [wiki/README.md](./wiki/README.md)
- [wiki/index.md](./wiki/index.md) — wiki master catalog
- [wiki/schema.md](./wiki/schema.md)
- [wiki/module-purpose.md](./wiki/module-purpose.md) - module purpose (BMAD, 2026-10-06)
- [wiki/readme.md](./wiki/readme.md) - lowercase copy of `wiki/README.md`, superseded
- [wiki/log.md](./wiki/log.md) — append-only activity log
- [wiki/agents.md](./wiki/agents.md) — canonical (see duplicate `wiki/agents-2.md` below)
- [wiki/overviews/seo-module.md](./wiki/overviews/seo-module.md)
- [wiki/concepts/composer-go-quality-gates.md](./wiki/concepts/composer-go-quality-gates.md)
- [wiki/concepts/composer-root-minimal-nwidart.md](./wiki/concepts/composer-root-minimal-nwidart.md)
- [wiki/concepts/index.md](./wiki/concepts/index.md) — canonical (see duplicate `wiki/concepts/index-2.md` below)
- [wiki/concepts/metatag-data-contract.md](./wiki/concepts/metatag-data-contract.md)
- [wiki/concepts/no-app-support-queueable-actions.md](./wiki/concepts/no-app-support-queueable-actions.md)
- [wiki/concepts/phpstan-compliance.md](./wiki/concepts/phpstan-compliance.md)
- [wiki/concepts/ponytail-audit.md](./wiki/concepts/ponytail-audit.md)
- [wiki/concepts/second-brain-local-discipline.md](./wiki/concepts/second-brain-local-discipline.md)
- [wiki/concepts/testing.md](./wiki/concepts/testing.md)
- [wiki/rules/index.md](./wiki/rules/index.md) — canonical (see duplicate `wiki/rules/index-2.md` below)
- [wiki/rules/module-contracts-naming-placement.md](./wiki/rules/module-contracts-naming-placement.md) — "Rule: suffisso Contract e collocazione contratti modulo" (distinct from the skills/ file with the same basename)
- [wiki/skills/index.md](./wiki/skills/index.md) — canonical (see duplicate `wiki/skills/index-2.md` below)
- [wiki/skills/module-contracts-naming-placement.md](./wiki/skills/module-contracts-naming-placement.md) — "Skill: contratti modulo — Contract suffix e placement" (distinct content, same basename as the rules/ file above; not a duplicate, just a naming collision across subfolders)
- [wiki/commands/index.md](./wiki/commands/index.md) — canonical (see duplicate `wiki/commands/index-2.md` below)
- [wiki/memories/index.md](./wiki/memories/index.md) — canonical (see duplicate `wiki/memories/index-2.md` below)

## LLM wiki — legacy second brain (`docs/llm-wiki/`)

Predates `docs/wiki/`; mostly empty catalogs today. Kept as-is, not merged.

- [llm-wiki/index.md](./llm-wiki/index.md)
- [llm-wiki/agents.md](./llm-wiki/agents.md) — canonical (see duplicate `llm-wiki/agents-2.md` below)
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

- [stories/docs-index-audit.story.md](./stories/docs-index-audit.story.md) - first documentation-index audit (2026-09-26)
- [stories/phpstan-cleanup-seo.story.md](stories/phpstan-cleanup-seo.story.md) and [.dev.md](stories/phpstan-cleanup-seo.dev.md) - PHPStan cleanup
- [stories/phpstan-seo-fix.md](./stories/phpstan-seo-fix.md) - earlier PHPStan fix note
- [stories/docs-organization-pilot.story.md](stories/docs-organization-pilot.story.md) - this reorganization pilot (frontmatter, links, superseded markers)
- [stories/services-to-actions-seo.story.md](stories/services-to-actions-seo.story.md) - Services to Actions (removal of `MetatagService`); the docs that cite `app/Services/MetatagService.php` become stale after it
- [bmad/README.md](./bmad/README.md), [bmad/bmad-dossier.md](./bmad/bmad-dossier.md), [bmad/status.md](./bmad/status.md) - BMAD dossier
- [decision-log.md](./decision-log.md) - decision log (empty template, `draft`)
- [investigation/investigation.md](./investigation/investigation.md) - Schema.org auto-generation investigation (placeholder, `draft`)

## Related modules and themes

- [Xot docs](../../Xot/docs/README.md) - core framework and base classes
- [Geo docs](../../Geo/docs/README.md) - Schema.org Place integration

---

## Storico / da consolidare

Nothing below was deleted, renamed, or moved. From 2026-10-08 every copy listed in section A carries `status: superseded` and `superseded_by` in its frontmatter (body untouched, except a visible note on the three superseded root indexes); the stubs in section B carry `status: stub`. Grouped here only so the index above stays readable. Consolidation (if ever done) is a separate, deliberate task.

### A. Duplicate content (same or near-identical text, different case/separator in the filename)

| Topic | Files | Note |
|---|---|---|
| Top-level index (pre-audit) | [`00-index.md`](./00-index.md), [`00-INDEX.md`](./00-INDEX.md) | Near-identical (1 link differs: `README.md` vs `readme.md`); superseded by this `index.md` (`status: superseded`), kept for history |
| On-demand pattern | [`on-demand-pattern-2.md`](./on-demand-pattern-2.md) | Byte-identical to `on-demand-pattern.md` |
| Performance optimization | [`performance-optimization-2.md`](./performance-optimization-2.md) | Byte-identical to `performance-optimization.md` |
| PRD | [`prd-2.md`](./prd-2.md) | Byte-identical to `prd.md` |
| Project structure | [`project-structure-2.md`](./project-structure-2.md) | Byte-identical to `project-structure.md` |
| QMD setup | [`qmd-setup-2.md`](./qmd-setup-2.md) | Byte-identical to `qmd-setup.md` |
| Product launch plan | [`product-launch-plan-2.md`](./product-launch-plan-2.md) | Byte-identical to `product-launch-plan-3.md` |
| Product roadmap | [`product-roadmap-2.md`](./product-roadmap-2.md) | Byte-identical to `product-roadmap-3.md` |
| Product strategy | [`product-strategy-2.md`](./product-strategy-2.md) | Byte-identical to `product-strategy-3.md` |
| Sprint planning | [`sprint-planning-2.md`](./sprint-planning-2.md) | Byte-identical to `sprint-planning-3.md` |
| User research | [`user-research-2.md`](./user-research-2.md) | Byte-identical to `user-research-3.md` |
| Roadmap (top-level) | [`roadmap-2.md`](./roadmap-2.md) | Quasi identico a `roadmap.md` (differisce solo la riga finale "Last Updated"), resta `active`. Le copie con l'anno nel nome (`roadmap-2025.md`, `ROADMAP-2025.md`, `ROADMAP_2025.md`) sono state fuse in `roadmap.md` il 2026-11-19 |
| Roadmap sub-index | [`roadmap/00-index-2.md`](./roadmap/00-index-2.md) | Byte-identical to `roadmap/00-index.md` |
| MCP server consigliati (IT) | [`mcp-server-consigliati-2.md`](./mcp-server-consigliati-2.md) | Byte-identical to `mcp-server-consigliati-3.md` |
| MCP server recommended (EN) | [`mcp-server-recommended-2.md`](./mcp-server-recommended-2.md) | Byte-identical to `mcp-server-recommended-3.md` |
| Wiki agents | [`wiki/agents-2.md`](wiki/agents-2.md) | Byte-identical to `wiki/agents.md` (both contain an unrendered `{{TYPE^}}` template placeholder) |
| LLM-wiki agents | [`llm-wiki/agents-2.md`](llm-wiki/agents-2.md) | Byte-identical to `llm-wiki/agents.md` |
| Wiki commands index | [`wiki/commands/index-2.md`](wiki/commands/index-2.md) | Byte-identical to `wiki/commands/index.md` |
| Wiki concepts index | [`wiki/concepts/index-2.md`](wiki/concepts/index-2.md) | Byte-identical to `wiki/concepts/index.md` |
| Wiki memories index | [`wiki/memories/index-2.md`](wiki/memories/index-2.md) | Byte-identical to `wiki/memories/index.md` |
| Wiki rules index | [`wiki/rules/index-2.md`](wiki/rules/index-2.md) | Byte-identical to `wiki/rules/index.md` |
| Wiki skills index | [`wiki/skills/index-2.md`](wiki/skills/index-2.md) | Byte-identical to `wiki/skills/index.md` |
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
- [metodi-duplicati-analisi-4.md](./metodi-duplicati-analisi-4.md)
- [metodi-duplicati-analisi-2.md](./metodi-duplicati-analisi-2.md)
- [metodi-duplicati-analisi-3.md](./metodi-duplicati-analisi-3.md)
- [phpstan.md](./phpstan.md)
- [product-launch-plan.md](./product-launch-plan.md)
- [product-roadmap.md](./product-roadmap.md)
- [redundancy-analysis-2.md](./redundancy-analysis-2.md)
- [redundancy-analysis.md](./redundancy-analysis.md)
- [roadmap/current-state.md](./roadmap/current-state.md)
- [roadmap/goals.md](./roadmap/goals.md)
- [roadmap/index.md](./roadmap/index.md)
- [roadmap/later.md](./roadmap/later.md)
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
- [sync-test-file-3.md](./sync-test-file-3.md)
- [sync-test-file-2.md](./sync-test-file-2.md)
- test-3.md
- test_2025_03_24_bb.md
- test-bb.md
- test.md
- [test.md](./test.md)
- [test-bb.md](./test-bb.md)
- [raw/root-import/sync-test-file.md](./raw/root-import/sync-test-file.md)
- [raw/root-import/sync-test-file-1.md](./raw/root-import/sync-test-file-1.md)
- [raw/root-import/sync-test-file-2.md](./raw/root-import/sync-test-file-2.md)
- [raw/root-import/sync-test-file-3.md](./raw/root-import/sync-test-file-3.md)
- raw/root-import/test.md
- raw/root-import/test-1.md
- raw/root-import/test-bb.md
- raw/root-import/test-bb-1.md
- raw/root-import/test-2025-03-24.md
- raw/root-import/test-2025-03-24-bb.md
- [raw/root-import/test.md](./raw/root-import/test.md)
- [raw/root-import/test-1.md](./raw/root-import/test-1.md)
- [raw/root-import/test-bb.md](./raw/root-import/test-bb.md)
- [raw/root-import/test-bb-1.md](./raw/root-import/test-bb-1.md)

