# Meetup Theme Documentation Index

## Roadmap

- [Roadmap Meetup Theme](roadmap/00-index.md) - Visione, fasi, qualità

## Core Concepts

- [Composer Packages Study](../../../docs/architecture/composer-packages-study.md) - Studio completo dipendenze runtime e implicazioni chaos monkey.
- [Riferimento pacchetti](../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../docs/architecture/composer-packages-full-inventory.md) - Folio, Volt, Livewire, Filament, Tailwind (via root/moduli)
- [Kinetic UX Checklist](kinetic-ux-checklist.md) - Motion, micro-interazioni, performance e accessibilità (tema Meetup)
- [Package Dependency Chaos Map](package-dependency-chaos-map.md) - Mappa pacchetti e rischio runtime lato tema.
- [CMS Theme Runtime Memory](memories/cms-theme-runtime-memory.md) - Operational memory for fast diagnosis of theme/CMS runtime failures.
- [Chaos Monkey Debug Skills](chaos-monkey-debug-skills.md) - Repeatable debugging skills and incident checklist for randomized breakage.
- [Chaos Monkey Checklist](chaos-monkey-checklist.md) - Scenario -> symptom -> diagnosis -> fix playbook (theme side).
- [Chaos Monkey Incident Playbook](chaos-monkey-incident-playbook.md) - Protocollo operativo di recovery per rotture su tema/asset/traduzioni.
- [Chaos Monkey Theme Recovery Playbook](chaos-monkey-theme-recovery-playbook.md) - Theme-specific recovery recipes for layout, sections, and block rendering.
- [Critical Rules Consolidated](critical-rules-consolidated.md) - Essential rules for Meetup theme
- [Critical Rules and Patterns](critical-rules-and-patterns.md) - Stack (Folio, Volt, Filament 5, Tailwind)
- [Volt Automatic Route Parameter Binding](volt-automatic-route-binding.md) - Volt handles route parameters automatically, no manual extraction needed
- [Project Purpose](project-purpose.md) - Why this theme exists
- [Project Philosophy](project-philosophy.md) - Core philosophy of the theme
- [Dashboard Integration](dashboard-integration.md) - Integration between Meetup dashboard and theme
- [Theme Development Rules](theme-development-rules.md) - Development guidelines
- [Docs-First Workflow](docs-first-workflow.md) - Regola operativa: prima docs, poi codice, poi tracking GitHub
- [Architecture Folio Volt Filament](architecture-folio-volt-filament.md) - Architecture patterns
- [Filament 5 – riferimento tema](filament-5-theme-reference.md) - Filament 5 requirements, nostro setup, CSS nel tema
- [PasswordData Integration](passworddata-integration.md) - Enterprise-grade password configuration for registration forms
- [Grafica vs laravelpizza.com](grafica-confronto-laravelpizza.md) - Confronto grafica e uso MCP per screenshot
- [Differenze grafica e miglioramenti](differenze-grafica-e-miglioramenti.md) - Differenze dettagliate (header, hero, features, CTA, footer) e priorità miglioramenti; screenshot in screenshots/grafica-confronto
- [Differenze grafica approfondimento](differenze-grafica-approfondimento.md) - Mappatura file, codice (logo, hero SVG, nav/footer URL), checklist tecnica
- [Evidenzia differenze](evidenzia-differenze.md) - Riepilogo rapido differenze e link agli screenshot
- [Footer logo confronto](footer-logo-confronto.md) - Logo footer vs laravelpizza.com, screenshot, roadmap
- [Theme Resolution and Workflow](theme-resolution-and-workflow.md) - Risoluzione tema (APP_URL → pub_theme), build e copy
- [MCP Configuration](mcp-configuration.md) - MCP per confronto grafica e task
- [Laravel Localization Implementation](folio-page-localization.md) - Complete Laravel Localization setup and configuration
- [Localization Standard](localization-standard.md) - Standard localization practices and patterns
- [UI/UX Language Switcher](../../../Modules/Meetup/docs/ui-ux-language-switcher-standard.md) - Design standards for language selection
- [Events Page Comparison](events-page-comparison.md) - Comparison of events page with laravelpizza.com
- [Events Comparison](events-comparison/) - Detailed events page comparison analysis
- [Visual Comparison](visual-comparison/) - Visual comparison tools and analysis

## Replikate - LaravelPizza Replication

- [Replikate Directory](prompts/replikate/) - Structured prompts for replicating laravelpizza.com
  - [README](prompts/replikate/README.md) - Guide to using replikate prompts
  - [Replicate Analysis](prompts/replikate/replicate.md) - Detailed target site analysis and implementation plan
  - [Main Replication Prompt](prompts/replikate/main-replication-prompt.md) - Master prompt for site alignment
  - [Footer Improvement](prompts/replikate/footer.md) - Specific footer UI/UX task
  - [Home Content Review](prompts/replikate/home.md) - Homepage content analysis task
  - [Prompt Writing Guide](prompts/replikate/prompt-writing-guide.md) - Standards for writing prompts

## Filament 5.x Upgrade

- [Upgrade Analysis & Implementation](filament-5/upgrade-analysis.md) - Detailed impact of Filament 5.1
- [Filament 5 – riferimento tema](filament-5-theme-reference.md) - Setup, CSS, and component usage
- [Installation Guide](03-development/01-filament-5-installation-guide.md) - Complete setup guide

## Visual Analysis & Parity

- [Visual Comparison Local vs Original](visual-comparison-local-vs-original.md) - Confronto completo homepage locale vs laravelpizza.com con screenshot
- [Events Page Comparison](events-page-comparison.md) - Confronto pagina events (CRITICO: view mancante)
- [Footer Logo Confronto](footer-logo-confronto.md) - Logo footer analisi e roadmap
- [Gap Documentation](visual-analysis/gap-documentation.md) - Status and differences from target site
- [Difference Analysis](visual-analysis/difference-analysis.md) - Technical breakdown of UI inconsistencies
- [Screenshots Cache](visual-analysis/screenshots/) - Collection of visual references
- Screenshots: `screenshots/local/`, `screenshots/original/`, `screenshots/local-events/`, `screenshots/original-events/`

## Implementation Guides

- [Theme Styling Implementation](theme-styling-implementation.md) - Styling approach
- [Theme Integration Guide](theme-integration-guide.md) - Integration patterns
- [Theme Improvements](theme-improvements.md) - Improvement strategies
- [Folio Volt Implementation](theme-folio-volt-implementation.md) - Implementation guide
- [Folio Volt Best Practices](folio-volt-best-practices.md) - Best practices

## Frontend Assets

- [Frontend Asset Management](frontend-asset-management.md) - Asset management
- [Vite Build Output Directory](vite-build-output-directory.md) - Build configuration
- [Vite Asset Loading Best Practices](vite-asset-loading-best-practices.md) - Asset loading
- [Theme Asset Synchronization Plan](theme-asset-synchronization-plan.md) - Asset sync
- [Theme Asset Build System](theme-asset-build-system.md) - Build system

## Layout and Components

- [Layout Component Strategy](layout-component-strategy.md) - Layout strategy
- [Layout Hierarchy Rules](layout-hierarchy-rules.md) - Layout rules
- [Layout Philosophy Laraxot](layout-philosophy-laraxot.md) - Layout philosophy
- [Block Components Structure](block-components-structure.md) - Component structure
- [Metatags Component Usage](metatags-component-usage.md) - Metatag usage

## Pages and Features

- [Events Page](events-page.md) - Event page implementation
- [Events Page Analysis](events-page-analysis.md) - Event page analysis
- [Events Page Differences Analysis](events-page-differences-analysis.md) - Event page differences
- [Design Implementation Plan](design-implementation-plan.md) - Design approach
- [Design Synthesis](design-synthesis.md) - Design synthesis

## Troubleshooting

- [Error Analysis and Solution](error-analysis-and-solution.md) - Error solutions
- [Root Cause Found](root-cause-found.md) - Root cause analysis
- [Missing View Fix Plan](missing-view-fix-plan.md) - Missing view fixes
- [Missing Layout Section Fix Plan](missing-layout-section-fix-plan.md) - Layout fixes
- [Livewire Property event not found](troubleshooting/livewire-property-event-not-found.md) - Fix per blocchi CMS inclusi via `@include`
- [Troubleshooting Directory](troubleshooting/) - Detailed troubleshooting guides

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
