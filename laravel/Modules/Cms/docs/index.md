---
title: "index"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-11-23
qmd: "index"
issues: []
discussions: []
status: draft
---

# Indice documentazione modulo Cms

> Nota 2026-10-14: questo e' il catalogo per argomento, non l'ingresso operativo. L'ingresso e' [00-index.md](./00-index.md); lo stato verificato del modulo (come si servono le pagine, cosa non esiste) e' in [README.md](./README.md). I documenti descritti sotto come "architettura" o "servizi" possono citare classi che non esistono (`PageService`, `BlockService`, modello `Block`): nel dubbio, controllare il codice. 24 link a file inesistenti sono annotati come mancanti.

## Panoramica

Il modulo Cms gestisce contenuti, composizione pagina e rendering CMS-driven dei blocchi (Content Blocks, Sections, Homepage dinamica). Nel lavoro in corso sulla parity "Design Comuni", il Cms governa la struttura della homepage di test, mentre la resa visuale viene rifinita nel tema Sixteen. Vedi [00-index.md](./00-index.md) per il dettaglio operativo di questo workstream.

Questo file e' l'indice di navigazione di `docs/`: organizza per argomento i file `.md` presenti nella radice di `docs/` e nelle sue sottocartelle, senza spostare, rinominare o cancellare nulla.

## Come usare questo indice

- Le sezioni tematiche qui sotto riportano un solo riferimento "pulito" per ogni contenuto quando esistono piu' varianti dello stesso file (case diverso, `_` al posto di `-`, suffissi `-1`/`-old`/`-renamed`, date nel nome).
- Tutte le varianti scartate sono elencate, senza perdita, nella sezione [Storico / da consolidare](#storico--da-consolidare) con una nota sul motivo.
- Le sottocartelle con un proprio indice interno sono linkate direttamente; quelle senza indice sono elencate con conteggio file e primo documento di riferimento.

## Collegamenti tema e workspace attivo

- [../../../Themes/Sixteen/docs/00-index.md](../../../Themes/Sixteen/docs/00-index.md) - Indice docs del tema Sixteen
- [../../../Themes/Sixteen/docs/design-comuni/00-index.md](../../../Themes/Sixteen/docs/design-comuni/00-index.md) - Workspace attivo parity homepage
- [../../../Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md](../../../Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md) - Analisi 54 pagine
- [../../Notify/docs/progress-report-2.md](../../Notify/docs/progress-report-2.md) - Report progresso
- [../../../docs/design-comuni/MASTER_INDEX.md](../../../../docs/design-comuni/MASTER_INDEX.md) - Master Index globale
- [design-comuni-index-3.md](./design-comuni-index.md) - Index Design Comuni con link bidirezionali (vedi anche variante [design-comuni-index-3.md](./design-comuni-index.md) in Storico)

## Documenti in radice di docs/, per argomento

### Design Comuni (parity homepage) (11)

- [design-comuni-argomenti.md](./design-comuni-argomenti.md)
- [design-comuni-argomento.md](./design-comuni-argomento.md)
- [design-comuni-batch-audit.md](./design-comuni-batch-audit.md)
- [design-comuni-batch-parity.md](./design-comuni-batch-parity.md)
- [design-comuni-faq.md](./design-comuni-faq.md)
- [design-comuni-homepage.md](./design-comuni-homepage.md)
- [design-comuni-page-census.md](./design-comuni-page-census.md)
- [design-comuni-risultati-ricerca.md](./design-comuni-risultati-ricerca.md)
- [design-comuni-segnalazioni-elenco.md](./design-comuni-segnalazioni-elenco.md)
- [design-comuni-services-implementation.md](./design-comuni-services-implementation.md)
- [design-comuni-index-3.md](./design-comuni-index.md)

### Homepage, contenuti e blocchi CMS (59)

- [block-data-flow.md](./block-data-flow.md)
- [blockdata-implementation.md](./blockdata-implementation.md)
- [cms-driven-pages-system.md](./cms-driven-pages-system.md)
- [cms-theme-template-runtime-architecture.md](./cms-theme-template-runtime-architecture.md)
- [cms-theme-template-runtime-reference.md](./cms-theme-template-runtime-reference.md)
- [cms.md](./cms.md)
- [component-page-alias-rule.md](./component-page-alias-rule.md)
- [component-page-runtime.md](./component-page-runtime.md)
- [componenti-blocchi-contenuto.md](./componenti-blocchi-contenuto.md)
- [componenti-footer.md](./componenti-footer.md)
- [componenti-header.md](./componenti-header.md)
- [components.md](./components.md)
- [content-blocks-architecture.md](./content-blocks-architecture.md)
- [content-blocks-system.md](./content-blocks-system.md)
- [content-json-mapping.md](./content-json-mapping.md)
- [content-management-strategy.md](./content-management-strategy.md)
- [content-management.md](./content-management.md)
- [content-storage.md](./content-storage.md)
- [content.md](./content.md)
- [footer-blocks.md](./footer-blocks.md)
- [footer-error-resolution.md](./footer-error-resolution.md)
- [footer-target-implementation.md](./footer-target-implementation.md)
- [footer-ui-ux-analysis.md](./footer-ui-ux-analysis.md)
- [footer-ui-ux-correction-sumy.md](./footer-ui-ux-correction-sumy.md)
- [footer-ui-ux-fixes-applied.md](./footer-ui-ux-fixes-applied.md)
- [gestione-homepage.md](./gestione-homepage.md)
- [homepage-architecture.md](./homepage-architecture.md)
- [homepage-contenuti.md](./homepage-contenuti.md)
- [homepage-errori-comuni.md](./homepage-errori-comuni.md)
- [homepage-management.md](./homepage-management.md)
- [homepage-parity-notes.md](./homepage-parity-notes.md)
- [homepage-structure.md](./homepage-structure.md)
- [homepage-struttura-corretta.md](./homepage-struttura-corretta.md)
- [homepage.md](./homepage.md)
- [implementation-pagina-servizi.md](./implementation-pagina-servizi.md)
- [implementazione-pagina-servizi.md](./implementazione-pagina-servizi.md)
- [json-content-system-architecture.md](./json-content-system-architecture.md)
- [layout-runtime-contract.md](./layout-runtime-contract.md)
- [legal-pages-json-rule.md](./legal-pages-json-rule.md)
- [namespace-componenti-blocchi.md](./namespace-componenti-blocchi.md)
- [page-block-data-resolution.md](./page-block-data-resolution.md)
- [page-component-context-data.md](./page-component-context-data.md)
- [page-component-data-context-scaling.md](./page-component-data-context-scaling.md)
- [page-content-management.md](./page-content-management.md)
- [page-directory-structure.md](./page-directory-structure.md)
- [page-management.md](./page-management.md)
- [page-resource.md](./page-resource.md)
- [page-translation-strategy.md](./page-translation-strategy.md)
- [page-component-architecture-3.md](./page-component-architecture.md)
- [pages-content-strategy.md](./pages-content-strategy.md)
- [register-disabled-implementation.md](./register-disabled-implementation.md)
- [schema-org-web-pages.md](./schema-org-web-pages.md)
- [section-management.md](./section-management.md)
- [sections.md](./sections.md)
- [testing-homepage-content-management-fix.md](./testing-homepage-content-management-fix.md)
- [tests-pages-block-bridge.md](./tests-pages-block-bridge.md)
- [webpage-profilepage-rollout.md](./webpage-profilepage-rollout.md)
- [webpage-schema-governance.md](./webpage-schema-governance.md)
- [x-page-context-data-rule.md](./x-page-context-data-rule.md)

### Filament (resource, form, widget, componenti) (17)

- [filament-4x-compatibility.md](./filament-4x-compatibility.md)
- [filament-5x-compatibility.md](./filament-5x-compatibility.md)
- [filament-architecture-principles.md](./filament-architecture-principles.md)
- [filament-blade-components.md](./filament-blade-components.md)
- [filament-blocks-system.md](./filament-blocks-system.md)
- [filament-components.md](./filament-components.md)
- [filament-form-sopra-tabella.md](./filament-form-sopra-tabella.md)
- [filament-forms.md](./filament-forms.md)
- [filament-integration.md](./filament-integration.md)
- [filament-nesting-opportunities.md](./filament-nesting-opportunities.md)
- [filament-personalizzazioni-avanzate.md](./filament-personalizzazioni-avanzate.md)
- [filament-plugin-pattern-analysis.md](./filament-plugin-pattern-analysis.md)
- [filament-resource-guidelines.md](./filament-resource-guidelines.md)
- [filament-resources.md](./filament-resources.md)
- [filament-widget-registrazione.md](./filament-widget-registrazione.md)
- [filament-widgets-in-blade.md](./filament-widgets-in-blade.md)
- [filament.md](./filament.md)

### Folio, Volt e routing (22)

- [folio-localization-architecture.md](./folio-localization-architecture.md)
- [folio-pages.md](./folio-pages.md)
- [folio-routing-locale.md](./folio-routing-locale.md)
- [folio-routing-system.md](./folio-routing-system.md)
- [folio-runtime-governance.md](./folio-runtime-governance.md)
- [folio-volt-best-practices.md](./folio-volt-best-practices.md)
- [frontoffice-flow.md](./frontoffice-flow.md)
- [frontoffice.md](./frontoffice.md)
- [gestione-route-folio.md](./gestione-route-folio.md)
- [laravel-folio-governance.md](./laravel-folio-governance.md)
- [laravel-folio-operational-rules.md](./laravel-folio-operational-rules.md)
- [locale-prefix-e2e-rule.md](./locale-prefix-e2e-rule.md)
- [multi-step-forms.md](./multi-step-forms.md)
- [profile-public-route-resolution.md](./profile-public-route-resolution.md)
- [routing-frontoffice.md](./routing-frontoffice.md)
- [todo-application.md](./todo-application.md)
- [volt-folio-esempio.md](./volt-folio-esempio.md)
- [volt-folio-structure.md](./volt-folio-structure.md)
- [volt-introduction.md](./volt-introduction.md)
- [volt-livewire-component-boundaries.md](./volt-livewire-component-boundaries.md)
- [volt-single-root-element.md](./volt-single-root-element.md) _(target mancante, verificato 2026-10-14)_
- [volt-web-application.md](./volt-web-application.md)

### Localizzazione e namespace (10)

- [case-sensitivity-percorsi-moduli.md](./case-sensitivity-percorsi-moduli.md)
- [convenzioni-namespace-filament.md](./convenzioni-namespace-filament.md)
- [lang-link.md](./lang-link.md)
- [laravel-localization-governance.md](./laravel-localization-governance.md)
- [laravel-localization-guide.md](./laravel-localization-guide.md)
- [localization.md](./localization.md)
- [namespace-modules.md](./namespace-modules.md)
- [namespace-moduli-laravel-saluteora.md](./namespace-moduli-laravel-saluteora.md)
- [struttura-layout-componenti-blade-saluteora.md](./struttura-layout-componenti-blade-saluteora.md)
- [utilizzo-modelli-user-in-saluteora.md](./utilizzo-modelli-user-in-saluteora.md)

### Collegamenti incrociati tra moduli (7)

- [links.md](./links.md)
- [prompt-rules-link.md](./prompt-rules-link.md)
- [root-links.md](./root-links.md) _(target mancante, verificato 2026-10-14)_
- [themes-ui-link.md](./themes-ui-link.md)
- [ui-link.md](./ui-link.md)
- [user-link.md](./user-link.md)
- [xot-link.md](./xot-link.md)

### PHPStan e qualita del codice (61)

- [analisi-metodi-duplicati.md](./analisi-metodi-duplicati.md)
- [bottlenecks.md](./bottlenecks.md)
- [code-quality-analysis-legacy.md](./code-quality-analysis-legacy.md) _(target mancante, verificato 2026-10-14)_
- [code-quality-analysis.md](./code-quality-analysis.md)
- [code-quality-improvement-report.md](./code-quality-improvement-report.md)
- [code-quality-report.md](./code-quality-report.md)
- [code-quality.md](./code-quality.md)
- [copilot-redundancy-audit-2026-05-25.md](./copilot-redundancy-audit-2026-05-25.md) _(target mancante, verificato 2026-10-14)_
- [coverage.md](./coverage.md)
- [cyclomatic-complexity-report.md](./cyclomatic-complexity-report.md)
- [dependency-intelligence.md](./dependency-intelligence.md)
- [dry-kiss-analysis.md](./dry-kiss-analysis.md)
- [duplicate-methods-analysis.md](./duplicate-methods-analysis.md)
- [factory-coverage-report.md](./factory-coverage-report.md)
- [metodi-duplicati-analisi.md](./metodi-duplicati-analisi.md)
- [missing-features-analysis.md](./missing-features-analysis.md)
- [model-factory-seeder-audit.md](./model-factory-seeder-audit.md)
- [modelli-factory-seeder-analisi.md](./modelli-factory-seeder-analisi.md)
- [models-factory-seeder-analysis.md](./models-factory-seeder-analysis.md)
- [models-factory-seeder.md](./models-factory-seeder.md)
- [models-migrations-coverage.md](./models-migrations-coverage.md)
- [optimization-analysis.md](./optimization-analysis.md)
- [optimization-recommendations.md](./optimization-recommendations.md)
- [performance-optimization.md](./performance-optimization.md)
- [phpinsights-report.md](./phpinsights-report.md)
- [phpmd-report.md](./phpmd-report.md)
- [phpstan-analysis-cms.md](./phpstan-analysis-cms.md)
- [phpstan-analysis.md](./phpstan-analysis.md)
- [phpstan-cluster.md](./phpstan-cluster.md)
- [phpstan-compliance-status.md](./phpstan-compliance-status.md)
- [phpstan-compliance.md](./phpstan-compliance.md)
- [phpstan-corrections.md](./phpstan-corrections.md)
- [phpstan-errors-roadmap.md](./phpstan-errors-roadmap.md)
- [phpstan-errors.md](./phpstan-errors.md)
- [phpstan-fix-plan.md](./phpstan-fix-plan.md)
- [phpstan-fixes-plan.md](./phpstan-fixes-plan.md)
- [phpstan-fixes-roadmap.md](./phpstan-fixes-roadmap.md)
- [phpstan-fixes-summary.md](./phpstan-fixes-summary.md)
- [phpstan-fixes.md](./phpstan-fixes.md)
- [phpstan-incremental.md](./phpstan-incremental.md)
- [phpstan-issues.md](./phpstan-issues.md)
- [phpstan-level-10-achievement.md](./phpstan-level-10-achievement.md)
- [phpstan-level-10-compliance.md](./phpstan-level-10-compliance.md)
- [phpstan-level-10-fixes.md](./phpstan-level-10-fixes.md)
- [phpstan-remediation.md](./phpstan-remediation.md)
- [phpstan-roadmap.md](./phpstan-roadmap.md)
- [phpstan-scripts-fixes.md](./phpstan-scripts-fixes.md)
- [phpstan-scripts-roadmap.md](./phpstan-scripts-roadmap.md)
- [phpstan-session.md](./phpstan-session.md)
- [phpstan-standards.md](./phpstan-standards.md)
- [phpstan-syntax-blockers.md](./phpstan-syntax-blockers.md)
- [phpstan-view-string-resolution.md](./phpstan-view-string-resolution.md)
- [phpstan.md](./phpstan.md)
- [ponytail-audit-over-engineering.md](./ponytail-audit-over-engineering.md)
- [quality-status.md](./quality-status.md)
- [quality-tooling.md](./quality-tooling.md)
- [quality.md](./quality.md)
- [redundancy-audit-2.md](./redundancy-audit-2.md) _(target mancante, verificato 2026-10-14)_
- [redundancy-report.md](./redundancy-report.md)
- [redundancy-analysis-3.md](./redundancy-analysis.md)
- [safe.md](./safe.md)

### Testing (14)

- [rules-testing-no-migrate-fresh.md](./rules-testing-no-migrate-fresh.md)
- [test-smtp-page.md](./test-smtp-page.md)
- [test.md](./test.md)
- [test111.md](./test111.md)
- [test2.md](./test2.md)
- [test2025-08-28.md](./test2025-08-28.md) _(target mancante, verificato 2026-10-14)_
- [test222.md](./test222.md)
- [test3.md](./test3.md)
- [testing-business-behavior-update-summary.md](./testing-business-behavior-update-summary.md)
- [testing-guidelines.md](./testing-guidelines.md)
- [testing-individual-folio-routes-fix.md](./testing-individual-folio-routes-fix.md)
- [testing-registration-widget.md](./testing-registration-widget.md)
- [testing-rules.md](./testing-rules.md)
- [testing.md](./testing.md)

### Prodotto, roadmap e strategia (19)

- [gitignore-organization-strategy.md](./gitignore-organization-strategy.md)
- [launch.md](./launch.md)
- [metatag-population-strategy.md](./metatag-population-strategy.md)
- [module-implementation-roadmap.md](./module-implementation-roadmap.md)
- [prd.md](./prd.md)
- [product-launch-plan.md](./product-launch-plan.md)
- [product-management.md](./product-management.md)
- [product-roadmap.md](./product-roadmap.md)
- [product-strategy.md](./product-strategy.md)
- [research.md](./research.md)
- [roadmap-and-issues.md](./roadmap-and-issues.md)
- [roadmap-complete.md](./roadmap-complete.md)
- [roadmap-q1-alternative.md](./roadmap-q1-alternative.md)
- [roadmap.md](./roadmap.md)
- [sprint-planning.md](./sprint-planning.md)
- [sprint.md](./sprint.md)
- [strategy.md](./strategy.md)
- [task-versioning-pagine.md](./task-versioning-pagine.md)
- [user-research.md](./user-research.md)

### UX, web design e riferimenti visuali (15)

- [algolia-docsearch.md](./algolia-docsearch.md)
- [daisyui-componenti.md](./daisyui-componenti.md)
- [daisyui-pro-contro-metriche.md](./daisyui-pro-contro-metriche.md)
- [guida-implementation-ux.md](./guida-implementation-ux.md)
- [guida-implementazione-ux.md](./guida-implementazione-ux.md)
- [icon-design.md](./icon-design.md)
- [leggi-ux.md](./leggi-ux.md)
- [mcp-ui-ux.md](./mcp-ui-ux.md)
- [risorse-ui-ux.md](./risorse-ui-ux.md)
- [siti-ispirazioni-web-design.md](./siti-ispirazioni-web-design.md)
- [siti-referenza-ui-ux.md](./siti-referenza-ui-ux.md)
- [standard-ui-components.md](./standard-ui-components.md)
- [ux-wizard-registrazione-paziente.md](./ux-wizard-registrazione-paziente.md)
- [web-design-rules.md](./web-design-rules.md)
- [webdesign.md](./webdesign.md)

### Governance docs, regole root e naming (18)

- [bashscripts-script-location.md](./bashscripts-script-location.md)
- [case-conflicts.md](./case-conflicts.md)
- [case-variant-collisions.md](./case-variant-collisions.md)
- [cleanup-log.md](./cleanup-log.md)
- [docs-directory-violation-reminder.md](./docs-directory-violation-reminder.md)
- [file-naming-rules.md](./file-naming-rules.md)
- [file-structure-cleanup.md](./file-structure-cleanup.md)
- [link-relativi-regole.md](./link-relativi-regole.md)
- [module-root-hygiene.md](./module-root-hygiene.md) _(target mancante, verificato 2026-10-14)_
- [no-ai-tool-scaffold-dirs.md](./no-ai-tool-scaffold-dirs.md)
- [on-demand-pattern.md](./on-demand-pattern.md)
- [root-file-policy.md](./root-file-policy.md) _(target mancante, verificato 2026-10-14)_
- [root-files-hygiene.md](./root-files-hygiene.md) _(target mancante, verificato 2026-10-14)_
- [rules-index.md](./rules-index.md)
- [script-placement-governance.md](./script-placement-governance.md)
- [script-placement-rules.md](./script-placement-rules.md)
- [task-consolidare-documentazione.md](./task-consolidare-documentazione.md)
- [validate-links.md](./validate-links.md)

### Conflitti git e merge (7)

- [conflict-resolution.md](./conflict-resolution.md)
- [git-conflict-resolution-2026-07-31.md](./git-conflict-resolution-2026-07-31.md) _(target mancante, verificato 2026-10-14)_
- [git-conflicts-list.md](./git-conflicts-list.md)
- [git-conflicts-resolution-impact.md](./git-conflicts-resolution-impact.md)
- [merge-conflict-files-list.md](./merge-conflict-files-list.md)
- [merge-conflict-marker-cleanup.md](./merge-conflict-marker-cleanup.md)
- [merge-conflicts-list.md](./merge-conflicts-list.md)

### Chaos engineering e resilienza (4)

- [chaos-monkey-checklist.md](./chaos-monkey-checklist.md)
- [chaos-monkey-deep-dive.md](./chaos-monkey-deep-dive.md)
- [chaos-monkey-recovery-playbook.md](./chaos-monkey-recovery-playbook.md)
- [chaos-readiness-toolkit.md](./chaos-readiness-toolkit.md)

### Architettura modulo e struttura codice (36)

- [analisi-componenti-blade-laravel.md](./analisi-componenti-blade-laravel.md)
- [analysis-componenti-blade-laravel.md](./analysis-componenti-blade-laravel.md)
- [architectural-zen.md](./architectural-zen.md)
- [architecture-xotdata-pattern.md](./architecture-xotdata-pattern.md)
- [architecture-xotdata.md](./architecture-xotdata.md)
- [backoffice.md](./backoffice.md)
- [best-practices-3.md](./best-practices.md)
- [blade-logic-separation.md](./blade-logic-separation.md)
- [business-logic-overview.md](./business-logic-overview.md)
- [business-logic-report.md](./business-logic-report.md)
- [chat-ai-components.md](./chat-ai-components.md)
- [database-structure-refactor.md](./database-structure-refactor.md)
- [dependencies.md](./dependencies.md)
- [folder-structure.md](./folder-structure.md)
- [mcp-configuration.md](./mcp-configuration.md)
- [mcp-server-recommended.md](./mcp-server-recommended.md)
- [modular-architecture-update-summary.md](./modular-architecture-update-summary.md)
- [modular-architecture-update-sumy.md](./modular-architecture-update-sumy.md)
- [module-analysis-complete.md](./module-analysis-complete.md)
- [module-analysis.md](./module-analysis.md)
- [module-guidelines.md](./module-guidelines.md)
- [modules-integration-reference.md](./modules-integration-reference.md)
- [nested-resources.md](./nested-resources.md)
- [nestedset-migration-best-practices.md](./nestedset-migration-best-practices.md)
- [package-dependency-chaos-map.md](./package-dependency-chaos-map.md)
- [packages.md](./packages.md)
- [patient-tests-deletion-reasoning.md](./patient-tests-deletion-reasoning.md)
- [project-structure.md](./project-structure.md)
- [psr4-autoload-cleanup.md](./psr4-autoload-cleanup.md)
- [psr4-autoload-remediation.md](./psr4-autoload-remediation.md)
- [queueable-actions.md](./queueable-actions.md)
- [struttura-moduli-laravel.md](./struttura-moduli-laravel.md)
- [struttura-route-e-viste.md](./struttura-route-e-viste.md)
- [task-completare-sistema-blocks.md](./task-completare-sistema-blocks.md)
- [task-ridurre-phpstan-suppressioni.md](./task-ridurre-phpstan-suppressioni.md)
- [task-test-folio-volt-routing.md](./task-test-folio-volt-routing.md)

### Tema, build e frontend tooling (7)

- [create-theme.md](./create-theme.md)
- [temi.md](./temi.md)
- [template-theme-cms-reference.md](./template-theme-cms-reference.md)
- [template-theme-cms-runtime-architecture.md](./template-theme-cms-runtime-architecture.md)
- [theme-build-process.md](./theme-build-process.md)
- [theme-compilation.md](./theme-compilation.md)
- [theme-vite-manifest-workflow.md](./theme-vite-manifest-workflow.md)

### Guide generiche / boilerplate starter-kit (Jigsaw, verificarne l'utilita) (15)

- [configuration.md](./configuration.md)
- [custom-404-page.md](./custom-404-page.md)
- [custom-components.md](./custom-components.md)
- [customizing-your-site.md](./customizing-your-site.md)
- [first-blog-post.md](./first-blog-post.md)
- [getting-started.md](./getting-started.md)
- [glossary.md](./glossary.md)
- [introduction.md](./introduction.md)
- [introduzione.md](./introduzione.md)
- [migration.md](./migration.md)
- [my-first-blog-post.md](./my-first-blog-post.md)
- [navigation.md](./navigation.md)
- [philosophy.md](./philosophy.md)
- [technologies.md](./technologies.md)
- [upgrade.md](./upgrade.md)

### Documenti generali del modulo (10)

- [00-index.md](./00-index.md)
- [CHANGELOG.md](./CHANGELOG.md)
- [license-3.md](license-3.md)
- [README.md](./README.md)
- [aggiornamenti.md](./aggiornamenti.md)
- [agid-compliance.md](./agid-compliance.md)
- [ai-methodologies.md](./ai-methodologies.md)
- [docs-health.md](./docs-health.md)
- [qmd-setup.md](./qmd-setup.md)
- [readme-en.md](./readme-en.md)

### Fix e risoluzioni puntuali (7)

- [codex-error-fix.md](./codex-error-fix.md)
- [common-phpstan-errors.md](./common-phpstan-errors.md)
- [logging-performance.md](./logging-performance.md)
- [seo-keting-integration.md](./seo-keting-integration.md)
- [serializable-closure-error-resolution.md](./serializable-closure-error-resolution.md)
- [site-replication-report.md](./site-replication-report.md)
- [workflow-improvements.md](./workflow-improvements.md)


## Sottocartelle di docs/

Sottocartelle con indice interno proprio (usarlo come punto di ingresso):

| Cartella | File .md | Indice / riferimento |
|---|---|---|
| [blocks/](./blocks/) | 28 | [blocks/README.md](./blocks/README.md), [blocks/index.md](./blocks/index.md) |
| [components/](./components/) | 43 | [components/README.md](./components/README.md) |
| [content/](./content/) | 1 | [content/README.md](./content/README.md) |
| [frontend-architecture/](./frontend-architecture/) | 3 | [frontend-architecture/index.md](./frontend-architecture/index.md) |
| [frontoffice/](./frontoffice/) | 23 | [frontoffice/README.md](./frontoffice/README.md) |
| [outputs/](./outputs/) | 1 | [outputs/README.md](./outputs/README.md) (stub canonico verso Themes) |
| [raw/](./raw/) | 25 | [raw/README.md](./raw/README.md), [raw/index.md](./raw/index.md) (stub canonico verso Themes) |
| [roadmap/](./roadmap/) | 41 | [roadmap/README.md](./roadmap/README.md) — contiene anche 00-index.md/00-index.md/index.md duplicati, vedi Storico |
| [sections/](./sections/) | 31 | [sections/index.md](./sections/index.md) |
| [standards/](./standards/) | 1 | [standards/README.md](./standards/README.md) |
| [wiki/](./wiki/) | 53 | [wiki/README.md](./wiki/README.md), [wiki/index.md](./wiki/index.md) — LLM wiki del modulo |

Sottocartelle senza indice interno (elenco file diretto consigliato per chi le apre; riferimento sotto e' il primo documento trovato):

| Cartella | File .md | Primo documento (riferimento) |
|---|---|---|
| [actions/](./actions/) | 2 | [actions/page-resolution-pipeline.md](./actions/page-resolution-pipeline.md) |
| [advanced/](./advanced/) | 1 | [advanced/echarts.md](./advanced/echarts.md) |
| [architecture/](./architecture/) | 6 | [architecture/file-placement-rules.md](./architecture/file-placement-rules.md), [architecture/homepage-structure.md](./architecture/homepage-structure.md) |
| [best-practices/](./best-practices/) | 7 | [best-practices/blade-components.md](./best-practices/blade-components.md) |
| [concepts/](./concepts/) | 1 | [concepts/xotbase-never-extend-filament.md](./concepts/xotbase-never-extend-filament.md) |
| [data/](./data/) | 2 | [data/block-data.md](./data/block-data.md) |
| [design-comuni/](./design-comuni/) | 3 | (solo file, nessun heading di primo livello — vedi elenco cartella) |
| [development/](./development/) | 7 | [development/roadmap.md](./development/roadmap.md) |
| [errors/](./errors/) | 8 | [errors/404.md](./errors/404.md) |
| [filament/](./filament/) | 2 | [filament/class-extension-rules.md](./filament/class-extension-rules.md) |
| [filament-resources/](./filament-resources/) | 1 | [filament-resources/attachment-resource.md](./filament-resources/attachment-resource.md) |
| [folio/](./folio/) | 1 | [folio/routing-system.md](./folio/routing-system.md) |
| [html/](./html/) | 1 | [html/semantic.md](./html/semantic.md) |
| [_integration/](./_integration/) | 1 | [_integration/links.md](./_integration/links.md) |
| [it/](./it/) | 1 | [it/trait-method-implementation.md](./it/trait-method-implementation.md) |
| [livewire/](./livewire/) | 1 | [livewire/page-show.md](./livewire/page-show.md) |
| [llm-wiki/](./llm-wiki/) | 2 | [llm-wiki/agents-2.md](llm-wiki/agents-2.md) |
| [localization/](./localization/) | 1 | [localization/localization-setup.md](./localization/localization-setup.md) |
| [localizzazione/](./localizzazione/) | 1 | [localizzazione/gestione-rotte-localizzate.md](./localizzazione/gestione-rotte-localizzate.md) |
| [migrations/](./migrations/) | 8 | [migrations/01-theme-to-components.md](./migrations/01-theme-to-components.md) |
| [packages/](./packages/) | 4 | [packages/analytics.md](./packages/analytics.md) |
| [patterns/](./patterns/) | 2 | [patterns/state.md](./patterns/state.md) |
| [prompts/](./prompts/) | 5 | [prompts/01.md](./prompts/01.md) |
| [refactoring/](./refactoring/) | 1 | [refactoring/page-content-to-section.md](./refactoring/page-content-to-section.md) |
| [responsive/](./responsive/) | 1 | [responsive/guidelines.md](./responsive/guidelines.md) |
| [screenshots/](./screenshots/) | 9 | (note su screenshot, nessun heading) |
| [stories/](./stories/) | 2 | [stories/seo-head-component.story.md](./stories/seo-head-component.story.md), [stories/head-sixteen-layout-migration.story.md](./stories/head-sixteen-layout-migration.story.md), [stories/head-sixteen-parity-closeout.story.md](./stories/head-sixteen-parity-closeout.story.md), [stories/untranslated-detail-pages-indexing.story.md](./stories/untranslated-detail-pages-indexing.story.md), [stories/7.1.phpstan-paramtype-coverage.story.md](./stories/7.1.phpstan-paramtype-coverage.story.md) |
| [tasks/](./tasks/) _(target mancante, verificato 2026-10-14)_ | 11 | [tasks/001-content-management-system.md](./tasks/001-content-management-system.md) _(target mancante, verificato 2026-10-14)_ |
| [testing/](./testing/) | 1 | [testing/naming-conventions.md](./testing/naming-conventions.md) |
| [tests/](./tests/) | 11 | [tests/architecture-aration-rules.md](./tests/architecture-aration-rules.md) |
| [themes/](./themes/) | 13 | [themes/assets.md](./themes/assets.md) |
| [ui/](./ui/) | 2 | [ui/integration-strategy.md](./ui/integration-strategy.md) |
| [webdesign/](./webdesign/) | 3 | [webdesign/responsive-design.md](./webdesign/responsive-design.md) |

Cartelle vuote o senza file `.md` diretti: `examples/`, `root-code-workspace-files/`, `source/` (verificare se vanno rimosse o popolate).


## Storico / da consolidare

Questi file non sono stati toccati (nessuna cancellazione o rinomina), ma sono raggruppati qui perche' palesemente duplicati o superati. Per ciascuna riga il primo link e' il riferimento consigliato; gli altri sono le varianti storiche.

- **[00-index.md](./00-index.md)** — contenuto identico duplicato per case del filename. Varianti storiche: [00-index.md](./00-index.md)
- **[algolia-docsearch.md](./algolia-docsearch.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [algolia-docsearch.md](./algolia-docsearch-adding-custom.md), [algolia-docsearch-old.md](./algolia-docsearch-old.md), [algolia-docsearch-old2.md](./algolia-docsearch-old2.md), [algolia-docsearch-1-2.md](./algolia-docsearch-adding-custom.md), [algolia-docsearch-2.md](./algolia-docsearch-2.md)
- **[algolia-docsearch.md](./algolia-docsearch.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [algolia-docsearch-1.md](./algolia-docsearch-adding-custom.md), [algolia-docsearch-old.md](./algolia-docsearch-old.md), [algolia-docsearch-old2.md](./algolia-docsearch-old2.md), [algolia-docsearch-1-2.md](./algolia-docsearch-adding-custom.md), [algolia-docsearch-2.md](./algolia-docsearch-2.md)
- **[analisi-componenti-blade-laravel.md](./analisi-componenti-blade-laravel.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [analisi-componenti-blade-laravel-1.md](./analisi-componenti-blade-laravel-corretta.md), [analisi-componenti-blade-laravel-1-2.md](./analisi-componenti-blade-laravel-problema-identificato.md), [analisi-componenti-blade-laravel-2.md](./analisi-componenti-blade-laravel-2.md)
- **[architecture-xotdata-pattern.md](./architecture-xotdata-pattern.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [architecture-xotdata-pattern-1.md](./architecture-xotdata-pattern-errore-critico.md), [architecture-xotdata-pattern-1-2.md](./architecture-xotdata-pattern-errore-critico-risolto.md), [architecture-xotdata-pattern-2.md](./architecture-xotdata-pattern-2.md)
- **[best-practices-3.md](./best-practices.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [best-practices-3.md](./best-practices.md)
- **[business-logic-report.md](./business-logic-report.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [business-logic-report-2.md](./business-logic-report-2.md)
- **[case-sensitivity-percorsi-moduli.md](./case-sensitivity-percorsi-moduli.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [case-sensitivity-percorsi-moduli-2.md](./case-sensitivity-percorsi-moduli-2.md)
- **[CHANGELOG.md](./CHANGELOG.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [CHANGELOG.md](./CHANGELOG.md)
- **[chat-ai-components.md](./chat-ai-components.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [chat-ai-components-1.md](./chat-ai-components-componenti.md), [chat-ai-components-1-2.md](./chat-ai-components-componenti.md), [chat-ai-components-2.md](./chat-ai-components-2.md)
- **[cleanup-log.md](./cleanup-log.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [cleanup-log-2.md](./cleanup-log-2.md)
- **[code-quality-analysis.md](./code-quality-analysis.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [code-quality-analysis-2.md](./code-quality-analysis-2.md), [code-quality-analysis-3.md](./code-quality-analysis-november-cms.md), [code-quality-analysis-november.md](./code-quality-analysis-november.md), [code-quality-analysis-renamed.md](./code-quality-analysis-renamed.md)
- **[componenti-blocchi-contenuto.md](./componenti-blocchi-contenuto.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [componenti-blocchi-contenuto-1.md](./componenti-blocchi-contenuto.md), [componenti-blocchi-contenuto-1-2.md](./componenti-blocchi-contenuto.md), [componenti-blocchi-contenuto-2.md](./componenti-blocchi-contenuto-2.md)
- **[componenti-footer.md](./componenti-footer.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [componenti-footer-2.md](./componenti-footer-2.md)
- **[componenti-header.md](./componenti-header.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [componenti-header-2.md](./componenti-header-2.md)
- **[content-blocks-architecture.md](./content-blocks-architecture.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [content-blocks-architecture-1.md](./content-blocks-architecture-saluteora-architettura.md), [content-blocks-architecture-1-2.md](./content-blocks-architecture-nome-progetto.md), [content-blocks-architecture-2.md](./content-blocks-architecture-2.md)
- **[content-blocks-system.md](./content-blocks-system.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [content-blocks-system-1.md](./content-blocks-system-saluteora-sistema.md), [content-blocks-system-1-2.md](./content-blocks-system-saluteora-sistema.md), [content-blocks-system-2.md](./content-blocks-system-2.md)
- **[content-json-mapping.md](./content-json-mapping.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [content-json-mapping-1.md](./content-json-mapping.md), [content-json-mapping-1-2.md](./content-json-mapping.md)
- **[content-management.md](./content-management.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [content-management-2.md](./content-management-2.md)
- **[content-management-strategy.md](./content-management-strategy.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [content-management-strategy-2.md](./content-management-strategy-2.md)
- **[content-storage.md](./content-storage.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [content-storage-2.md](./content-storage-2.md)
- **[convenzioni-namespace-filament.md](./convenzioni-namespace-filament.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [convenzioni-namespace-filament-2.md](./convenzioni-namespace-filament-2.md)
- **[create-theme.md](./create-theme.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [create-theme-2.md](./create-theme-2.md)
- **[custom-404-page.md](./custom-404-page.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [custom-404-page-1.md](./custom-404-page-collegamenti-versioni.md), [custom-404-page-1-2.md](./custom-404-page-versione-head.md), [custom-404-page-2.md](./custom-404-page-2.md)
- **[custom-components.md](./custom-components.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [custom-components-2.md](./custom-components-2.md)
- **[customizing-your-site.md](./customizing-your-site.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [customizing-your-site-1.md](./customizing-your-site.md), [customizing-your-site-1-2.md](./customizing-your-site-styles.md), [customizing-your-site-2.md](./customizing-your-site-2.md)
- **[daisyui-componenti.md](./daisyui-componenti.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [daisyui-componenti-1.md](./daisyui-componenti.md), [daisyui-componenti-1-2.md](./daisyui-componenti.md), [daisyui-componenti-2.md](./daisyui-componenti-2.md)
- **[design-comuni-index-3.md](./design-comuni-index.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [design-comuni-index-3.md](./design-comuni-index.md)
- **[docs-directory-violation-reminder.md](./docs-directory-violation-reminder.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [docs-directory-violation-reminder-2.md](./docs-directory-violation-reminder-2.md), [docs-directory-violation-reminder-3.md](./docs-directory-violation-reminder-3.md)
- **[filament-4x-compatibility.md](./filament-4x-compatibility.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-4x-compatibility-2.md](./filament-4x-compatibility-2.md)
- **[filament-5x-compatibility.md](./filament-5x-compatibility.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-5x-compatibility-2.md](./filament-5x-compatibility-2.md)
- **[filament-blade-components.md](./filament-blade-components.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-blade-components-1.md](./filament-blade-components-usage-cms.md), [filament-blade-components-1-2.md](./filament-blade-components-collegamenti.md), [filament-blade-components-2.md](./filament-blade-components-2.md)
- **[filament-components.md](./filament-components.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-components-1.md](./filament-components-utilizzo-componenti.md), [filament-components-1-2.md](./filament-components-utilizzo-componenti-progetto.md), [filament-components-2.md](./filament-components-2.md)
- **[filament-form-sopra-tabella.md](./filament-form-sopra-tabella.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-form-sopra-tabella-2.md](./filament-form-sopra-tabella-2.md)
- **[filament-forms.md](./filament-forms.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-forms-2.md](./filament-forms-2.md)
- **[filament-integration.md](./filament-integration.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-integration-2.md](./filament-integration-2.md)
- **[filament-personalizzazioni-avanzate.md](./filament-personalizzazioni-avanzate.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-personalizzazioni-avanzate-2.md](./filament-personalizzazioni-avanzate-2.md)
- **[filament-resource-guidelines.md](./filament-resource-guidelines.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-resource-guidelines.md](./filament-resource-guidelines.md), [filament-resource-guidelines-3.md](./filament-resource-guidelines.md), [filament-resourcelines.md](./filament-resourcelines.md), [filament-resource-guidelines-renamed.md](./filament-resource-guidelines-renamed.md), [filament-resource-guidelines-4.md](./filament-resource-guidelines.md)
- **[filament-resources.md](./filament-resources.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-resources-2.md](./filament-resources-2.md)
- **[filament-widget-registrazione.md](./filament-widget-registrazione.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-widget-registrazione-2.md](./filament-widget-registrazione-2.md)
- **[filament-widgets-in-blade.md](./filament-widgets-in-blade.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [filament-widgets-in-blade-2.md](./filament-widgets-in-blade-2.md)
- **[first-blog-post.md](./first-blog-post.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [first-blog-post-2.md](./first-blog-post-2.md)
- **[folder-structure.md](./folder-structure.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [folder-structure-2.md](./folder-structure-2.md)
- **[folio-pages.md](./folio-pages.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [folio-pages-2.md](./folio-pages-2.md)
- **[folio-routing-system.md](./folio-routing-system.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [folio-routing-system-2.md](./folio-routing-system-2.md)
- **[footer-error-resolution.md](./footer-error-resolution.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [footer-error-resolution-2.md](./footer-error-resolution-2.md)
- **[footer-ui-ux-analysis.md](./footer-ui-ux-analysis.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [footer-ui-ux-analysis-2.md](./footer-ui-ux-analysis-2.md)
- **[footer-ui-ux-correction-sumy.md](./footer-ui-ux-correction-sumy.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [footer-ui-ux-correction-sumy-2.md](./footer-ui-ux-correction-sumy-2.md)
- **[footer-ui-ux-fixes-applied.md](./footer-ui-ux-fixes-applied.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [footer-ui-ux-fixes-applied-2.md](./footer-ui-ux-fixes-applied-2.md)
- **[frontoffice-flow.md](./frontoffice-flow.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [frontoffice-flow-2.md](./frontoffice-flow-2.md)
- **[gestione-homepage.md](./gestione-homepage.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [gestione-homepage-2.md](./gestione-homepage-2.md)
- **[gestione-route-folio.md](./gestione-route-folio.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [gestione-route-folio-2.md](./gestione-route-folio-2.md)
- **[getting-started.md](./getting-started.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [getting-started-2.md](./getting-started-2.md)
- **[git-conflicts-resolution-impact.md](./git-conflicts-resolution-impact.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [git-conflicts-resolution-impact-2.md](./git-conflicts-resolution-impact-2.md), [gits-resolution-impact.md](./gits-resolution-impact.md)
- **[gitignore-organization-strategy.md](./gitignore-organization-strategy.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [gitignore-organization-strategy-2.md](./gitignore-organization-strategy-2.md)
- **[guida-implementazione-ux.md](./guida-implementazione-ux.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [guida-implementazione-ux-2.md](./guida-implementazione-ux-2.md)
- **[homepage-architecture.md](./homepage-architecture.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [homepage-architecture-1.md](./homepage-architecture.md), [homepage-architecture-1-2.md](./homepage-architecture.md)
- **[homepage-contenuti.md](./homepage-contenuti.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [homepage-contenuti-2.md](./homepage-contenuti-2.md)
- **[homepage-errori-comuni.md](./homepage-errori-comuni.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [homepage-errori-comuni-2.md](./homepage-errori-comuni-2.md), [homepagei-comuni.md](./homepagei-comuni.md)
- **[homepage-management.md](./homepage-management.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [homepage-management-1.md](./homepage-management-gestione.md), [homepage-management-1-2.md](./homepage-management-gestione.md)
- **[homepage-structure.md](./homepage-structure.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [homepage-structure-1.md](./homepage-structure.md), [homepage-structure-1.md](./homepage-structure-documentation-themes.md), [homepage-structure-2.md](./homepage-structure-2.md)
- **[homepage-struttura-corretta.md](./homepage-struttura-corretta.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [homepage-struttura-corretta-2.md](./homepage-struttura-corretta-2.md)
- **[icon-design.md](./icon-design.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [iconesign.md](./iconesign.md)
- **[implementazione-pagina-servizi.md](./implementazione-pagina-servizi.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [implementazione-pagina-servizi-2.md](./implementazione-pagina-servizi-2.md)
- **[index.md](./index.md)** — index.md e' ora il presente indice principale; index.md resta come stub segnaposto superato. Varianti storiche: [index.md](./index.md)
- **[lang-link.md](./lang-link.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [lang-link-2.md](./lang-link-2.md)
- **[leggi-ux.md](./leggi-ux.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [leggi-ux-2.md](./leggi-ux-2.md)
- **[license-3.md](license-3.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [license-renamed.md](./license-renamed.md), [license-3.md](license-3.md)
- **[mcp-server-recommended.md](./mcp-server-recommended.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [mcp-server-recommended-2.md](./mcp-server-recommended-2.md)
- **[metatag-population-strategy.md](./metatag-population-strategy.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [metatag-population-strategy-1.md](./metatag-population-strategy-saluteora-strategia.md), [metatag-population-strategy-1-2.md](./metatag-population-strategy-nome-progetto.md), [metatag-population-strategy-2.md](./metatag-population-strategy-2.md)
- **[metodi-duplicati-analisi.md](./metodi-duplicati-analisi.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [metodi-duplicati-analisi.md](./metodi-duplicati-analisi.md), [metodi-duplicati-analisi-4.md](./metodi-duplicati-analisi.md), [metodi-duplicati-analisi-4.md](./metodi-duplicati-analisi.md), [metodiuplicati-analisi.md](./metodiuplicati-analisi.md)
- **[modelli-factory-seeder-analisi.md](./modelli-factory-seeder-analisi.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [modelli-factory-seeder-analisi-1.md](./modelli-factory-seeder-analisi-modulo-cms.md), [modelli-factory-seeder-analisi-2.md](./modelli-factory-seeder-analisi-2.md)
- **[modular-architecture-update-summary.md](./modular-architecture-update-summary.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [modular-architecture-update-summary-2.md](./modular-architecture-update-summary.md), [modular-architecture-update-summary-3.md](./modular-architecture-update-summary.md)
- **[module-guidelines.md](./module-guidelines.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [module-guidelines-2.md](./module-guidelines-2.md), [modulelines.md](./modulelines.md)
- **[multi-step-forms.md](./multi-step-forms.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [multi-step-forms-2.md](./multi-step-forms-2.md)
- **[my-first-blog-post.md](./my-first-blog-post.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [my-first-blog-post-2.md](./my-first-blog-post-2.md)
- **[namespace-componenti-blocchi.md](./namespace-componenti-blocchi.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [namespace-componenti-blocchi-2.md](./namespace-componenti-blocchi-2.md)
- **[namespace-modules.md](./namespace-modules.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [namespace-modules-2.md](./namespace-modules-2.md)
- **[namespace-moduli-laravel-saluteora.md](./namespace-moduli-laravel-saluteora.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [namespace-moduli-laravel-saluteora-2.md](./namespace-moduli-laravel-saluteora-2.md)
- **[on-demand-pattern.md](./on-demand-pattern.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [on-demand-pattern.md](./on-demand-pattern.md)
- **[optimization-recommendations.md](./optimization-recommendations.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [optimization-recommendations-1.md](./optimization-recommendations-modulo-cms.md), [optimization-recommendations-1-2.md](./optimization-recommendations.md), [optimization-recommendations-2.md](./optimization-recommendations-2.md)
- **[page-component-architecture-3.md](./page-component-architecture.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [page-component-architecture-3.md](./page-component-architecture.md)
- **[page-content-management.md](./page-content-management.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [page-content-management-2.md](./page-content-management-2.md)
- **[page-management.md](./page-management.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [page-management-2.md](./page-management-2.md)
- **[page-resource.md](./page-resource.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [page-resource-2.md](./page-resource-2.md)
- **[pages-content-strategy.md](./pages-content-strategy.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [pages-content-strategy-2.md](./pages-content-strategy-2.md)
- **[performance-optimization.md](./performance-optimization.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [performance-optimization.md](./performance-optimization.md)
- **[phpstan.md](./phpstan.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [phpstanes.md](./phpstanes.md)
- **[phpstan-compliance.md](./phpstan-compliance.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [phpstan-compliance-dec.md](./phpstan-compliance-dec.md), [phpstan-compliance-max-level.md](./phpstan-compliance-max-level.md)
- **[phpstan-corrections.md](./phpstan-corrections.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [phpstan-corrections-2.md](./phpstan-corrections-2.md), [phpstan-corrections-cms-module.md](./phpstan-corrections-cms-module.md)
- **[phpstan-fixes.md](./phpstan-fixes.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [phpstan-fixes-2.md](./phpstan-fixes-2.md), [phpstan-fixes-january.md](./phpstan-fixes-january.md), [phpstan-fixes-gennaio.md](./phpstan-fixes-gennaio.md), [phpstan-fixes-cms-module.md](./phpstan-fixes-cms-module.md), [phpstan-fixes-sumy.md](./phpstan-fixes-sumy.md), [phpstan-fixes-3.md](./phpstan-fixes-3.md)
- **[phpstan-incremental.md](./phpstan-incremental.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [phpstan-incremental-2.md](./phpstan-incremental-2.md)
- **[phpstan-remediation.md](./phpstan-remediation.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [phpstan-remediation-2.md](./phpstan-remediation-2.md)
- **[prd.md](./prd.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [prd-corporate.md](./prd-corporate.md)
- **[product-launch-plan.md](./product-launch-plan.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [product-launch-plan-3.md](./product-launch-plan.md), [product-launch-plan-3.md](./product-launch-plan.md)
- **[product-management.md](./product-management.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [product-management-2.md](./product-management-2.md)
- **[product-roadmap.md](./product-roadmap.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [product-roadmap-3.md](./product-roadmap.md), [product-roadmap-3.md](./product-roadmap.md)
- **[product-strategy.md](./product-strategy.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [product-strategy-corporate.md](./product-strategy-corporate.md), [product-strategy-corporate.md](./product-strategy-corporate.md)
- **[project-structure.md](./project-structure.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [project-structure.md](./project-structure.md)
- **[psr4-autoload-cleanup.md](./psr4-autoload-cleanup.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [psr4-autoload-cleanup-2026-03-09.md](./psr4-autoload-cleanup.md)
- **[psr4-autoload-remediation.md](./psr4-autoload-remediation.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [psr4-autoload-remediation-2026-03-09.md](./psr4-autoload-remediation.md)
- **[qmd-setup.md](./qmd-setup.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [qmd-setup.md](./qmd-setup.md)
- **[quality-status.md](./quality-status.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [quality-status-2.md](./quality-status-2.md), [quality-status-11.md](./quality-status.md), [quality-status-2025-11.md](./quality-status-activity-module-november.md) _(target mancante, verificato 2026-10-14)_
- **[redundancy-analysis-3.md](./redundancy-analysis.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [redundancy-analysis-3.md](./redundancy-analysis.md)
- **[register-disabled-implementation.md](./register-disabled-implementation.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [register-disabled-implementation-1.md](./register-disabled-implementation.md), [register-disabled-implementation-1-2.md](./register-disabled-implementation.md), [register-disabled-implementation-2.md](./register-disabled-implementation-2.md), [registerisabled-implementation.md](./registerisabled-implementation.md)
- **[risorse-ui-ux.md](./risorse-ui-ux.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [risorse-ui-ux-2.md](./risorse-ui-ux-2.md)
- **[roadmap.md](./roadmap.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [roadmap-renamed.md](./roadmap-renamed.md), [roadmap-2.md](./roadmap-2.md), [roadmap-q1.md](./roadmap-q1.md)
- **[root-links.md](./root-links.md) _(target mancante, verificato 2026-10-14)_** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [root_links.md](./root_links.md) _(target mancante, verificato 2026-10-14)_
- **[script-placement-rules.md](./script-placement-rules.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [script-placement-rules-3.md](./script-placement-rules.md), [script-placement-rules-3.md](./script-placement-rules.md)
- **[section-management.md](./section-management.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [section-management-2.md](./section-management-2.md)
- **[serializable-closure-error-resolution.md](./serializable-closure-error-resolution.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [serializable-closure-error-resolution-2.md](./serializable-closure-error-resolution-2.md)
- **[siti-ispirazioni-web-design.md](./siti-ispirazioni-web-design.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [siti-ispirazioni-webesign.md](./siti-ispirazioni-webesign.md), [siti-ispirazioni-web-design-2.md](./siti-ispirazioni-web-design-2.md)
- **[siti-referenza-ui-ux.md](./siti-referenza-ui-ux.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [siti-referenza-ui-ux-2.md](./siti-referenza-ui-ux-2.md)
- **[sprint-planning.md](./sprint-planning.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [sprint-planning-3.md](./sprint-planning.md), [sprint-planning-3.md](./sprint-planning.md)
- **[struttura-layout-componenti-blade-saluteora.md](./struttura-layout-componenti-blade-saluteora.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [struttura-layout-componenti-blade-saluteora-2.md](./struttura-layout-componenti-blade-saluteora-2.md)
- **[struttura-moduli-laravel.md](./struttura-moduli-laravel.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [struttura-moduli-laravel-2.md](./struttura-moduli-laravel-2.md)
- **[struttura-route-e-viste.md](./struttura-route-e-viste.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [struttura-route-e-viste-2.md](./struttura-route-e-viste-2.md)
- **[test-smtp-page.md](./test-smtp-page.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [test-smtp-page-2.md](./test-smtp-page-2.md)
- **[testing.md](./testing.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [testing.md](./testing.md), [testing-renamed.md](./testing-renamed.md)
- **[testing-business-behavior-update-summary.md](./testing-business-behavior-update-summary.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [testing-business-behavior-update-summary-2.md](./testing-business-behavior-update-summary.md), [testing-business-behavior-update-summary-3.md](./testing-business-behavior-update-summary.md)
- **[testing-registration-widget.md](./testing-registration-widget.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [testing-registration-widget-2.md](./testing-registration-widget-2.md)
- **[theme-build-process.md](./theme-build-process.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [theme-build-process-2.md](./theme-build-process-2.md)
- **[theme-compilation.md](./theme-compilation.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [theme-compilation-1.md](./theme-compilation.md), [theme-compilation-1-2.md](./theme-compilation.md)
- **[themes-ui-link.md](./themes-ui-link.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [themes-ui-link-1.md](./themes-ui-link-collegamenti-ai.md), [themes-ui-link-1-2.md](./themes-ui-link-collegamenti-ai-temi.md), [themes-ui-link-2.md](./themes-ui-link-2.md)
- **[todo-application.md](./todo-application.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [todo-application-2.md](./todo-application-2.md)
- **[ui-link.md](./ui-link.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [ui-link-1.md](./ui-link-collegamenti-al.md), [ui-link-1-2.md](./ui-link-collegamenti-al-modulo.md), [ui-link-2.md](./ui-link-2.md)
- **[user-link.md](./user-link.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [user-link-1.md](./user-link-collegamento-al.md), [user-link-1-2.md](./user-link-collegamento-al-modulo.md), [user-link-2.md](./user-link-2.md)
- **[user-research.md](./user-research.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [user-research-3.md](./user-research.md), [user-research-3.md](./user-research.md)
- **[utilizzo-modelli-user-in-saluteora.md](./utilizzo-modelli-user-in-saluteora.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [utilizzo-modelli-user-in-saluteora-2.md](./utilizzo-modelli-user-in-saluteora-2.md)
- **[ux-wizard-registrazione-paziente.md](./ux-wizard-registrazione-paziente.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [ux-wizard-registrazione-paziente-2.md](./ux-wizard-registrazione-paziente-2.md)
- **[volt-folio-esempio.md](./volt-folio-esempio.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [volt-folio-esempio-1.md](./volt-folio-esempio.md), [volt-folio-esempio-1-2.md](./volt-folio-esempio.md), [volt-folio-esempio-2.md](./volt-folio-esempio-2.md)
- **[volt-folio-structure.md](./volt-folio-structure.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [volt-folio-structure-1.md](./volt-folio-structure.md), [volt-folio-structure-1.md](./volt-folio-structure-struttura-corretta.md), [volt-folio-structure-2.md](./volt-folio-structure-2.md)
- **[volt-introduction.md](./volt-introduction.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [volt-introduction-1.md](./volt-introduction-introduzione-laravel.md), [volt-introduction-1-2.md](./volt-introduction-introduzione-laravel.md), [volt-introduction-2.md](./volt-introduction-2.md)
- **[volt-single-root-element.md](./volt-single-root-element.md) _(target mancante, verificato 2026-10-14)_** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [volt-single-root-element-1.md](./volt-single-root-element-1.md) _(target mancante, verificato 2026-10-14)_, [volt-single-root-element_1.md](./volt-single-root-element_1.md) _(target mancante, verificato 2026-10-14)_, [volt_single_root_element.md](./volt_single_root_element.md) _(target mancante, verificato 2026-10-14)_
- **[volt-web-application.md](./volt-web-application.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [volt-web-application-1.md](./volt-web-application.md), [volt-web-application-1-2.md](./volt-web-application.md), [volt-web-application-2.md](./volt-web-application-2.md)
- **[web-design-rules.md](./web-design-rules.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [web-design-rules-2.md](./web-design-rules-2.md), [webesign.md](./webesign.md)
- **[xot-link.md](./xot-link.md)** — varianti dello stesso contenuto per case/underscore-trattino/suffisso numerico (-1, _1, -old, -renamed) o data di redazione. Varianti storiche: [xot-link-2.md](./xot-link-2.md)

### Cartelle-archivio (contenuto storico, non indicizzato per singolo file)

- [archive/](./archive/) _(target mancante, verificato 2026-10-14)_ — 184 file `.md`, dump storico di documentazione superata (es. varianti vecchie di algolia-docsearch e altri doc gia' presenti anche in radice). Consultare solo per ricostruire la storia di una decisione.
- [raw/](./raw/) — 25 file, materiale grezzo/non rifinito, con stub `README.md`/`index.md` che puntano a `Themes/docs/shared-components/`.
- [historical/](./historical/) _(target mancante, verificato 2026-10-14)_ — 4 file, snapshot storici (es. code-quality-analysis datata novembre 2025).
- [root-md-files/](./root-md-files/) — 31 file, altro deposito di `.md` spaiati (es. `business-logic-report-dup-16529.md`, il nome stesso segnala un duplicato).
- [root-txt-files/](./root-txt-files/) _(target mancante, verificato 2026-10-14)_ — 6 file (es. `test111.md`), materiale di scarto spostato dalla root del modulo.
- [root-code-workspace-files/](./root-code-workspace-files/) _(target mancante, verificato 2026-10-14)_ — cartella presente ma senza file `.md` diretti.

### File di scratch/test in radice docs/ (probabile materiale di prova, verificarne l'utilita')

- [test.md](./test.md), [test2.md](./test2.md), [test3.md](./test3.md), [test111.md](./test111.md), [test222.md](./test222.md), [test2025-08-28.md](./test2025-08-28.md) _(target mancante, verificato 2026-10-14)_ — file senza contenuto strutturato riconoscibile dal nome, verosimilmente scratchpad.

### Nomi file corrotti/mangled ricondotti al cluster corretto

Durante l'audit sono stati individuati alcuni file con nome chiaramente corrotto (probabile bug di uno script di rinomina/dedup passato: lettere mancanti). Sono stati inclusi come varianti storiche nei cluster sopra invece che lasciati come voci a se stanti:

- `filament-resourcelines.md` -> variante di `filament-resource-guidelines.md`
- `modulelines.md` -> variante di `module-guidelines.md`
- `registerisabled-implementation.md` -> variante di `register-disabled-implementation.md`
- `metodiuplicati-analisi.md` -> variante di `metodi-duplicati-analisi.md`
- `homepagei-comuni.md` -> variante di `homepage-errori-comuni.md`
- `iconesign.md` -> variante di `icon-design.md`
- `webesign.md` -> variante di `web-design-rules.md`
- `siti-ispirazioni-webesign.md` -> variante di `siti-ispirazioni-web-design.md`
- `gits-resolution-impact.md` -> variante di `git-conflicts-resolution-impact.md`
- `phpstanes.md` -> variante di `phpstan.md`
- `footer-ui-ux-correction-sumy.md` / `footer-ui-ux-correction-sumy-2.md` -> variante di `footer-ui-ux-correction.md` (documento base non presente separatamente)


## Manutenzione di questo indice

- Story BMAD collegata: [stories/docs-index-audit.story.md](./stories/docs-index-audit.story.md).
- Questo indice copre tutti i file `.md` sotto `docs/` (radice + sottocartelle) al 2026-09-03: 570 file in radice, ~596 nelle sottocartelle, totale 1166.
- Non sono stati creati, rinominati o cancellati file `.md` esistenti in questo audit.
- Prossimo passo suggerito (non eseguito qui): valutare con l'owner del modulo la cancellazione/consolidamento reale dei cluster in "Storico / da consolidare" e delle cartelle-archivio.
- [Contenuti JSON: unicita' dello slug](./json-content-slug-uniqueness.md): collisioni, override tenant, nome canonico `tests.<slug>.json` (2026-10-13).
