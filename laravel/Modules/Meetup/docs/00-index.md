# Meetup Module Documentation Index

## Core Concepts

- [Composer Packages Study](../../../../docs/architecture/composer-packages-study.md) - Analisi completa pacchetti e blast radius runtime.
- [Riferimento pacchetti](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md) - `saade/filament-fullcalendar` per calendario eventi
- [Package Dependency Chaos Map](package-dependency-chaos-map.md) - Mappa pacchetti critici e failure modes del modulo.
- [Critical Rules Consolidated](critical-rules-consolidated.md) - Essential rules for Meetup module
- [Chaos Monkey Readiness](chaos-monkey-readiness.md) - Diagnosi e recovery rapida su rotture randomizzate del modulo.
- [Chaos Readiness Toolkit](chaos-readiness-toolkit.md) - Runner condiviso + focus specifico modulo eventi.
- [Volt Automatic Route Parameter Binding](volt-automatic-route-binding.md) - Volt handles route parameters automatically, no manual extraction needed
- [Project Purpose](project-purpose.md) - Why this module exists
- [Business Logic](business-logic.md) - Core business requirements
- [Dashboard Architecture](dashboard-architecture.md) - Architecture of the Meetup dashboard
- [Architecture Overview](architecture-reference.md) - Module architecture patterns
- [Folio + Volt Best Practices](folio-volt-best-practices.md) - Frontend development patterns
- [Chaos Monkey Event Rendering Playbook](chaos-monkey-event-rendering-playbook.md) - Incident recovery guide for events list/detail rendering path.

## Implementation Guides

- [Implementation Plan](implementation-plan.md) - Development roadmap
- [Module Implementation Guide](module-implementation-guide.md) - Step-by-step guide
- [Folio + Volt Guide](laravel-folio-volt-guide.md) - Complete Folio/Volt documentation
- [Services Guide](services-guide.md) - Service layer documentation
- [Config Improvement](config-improvement.md) - Module configuration file improvements
- [Events CMS-Driven Pages](events-cms-driven-pages.md) - Events system with JSON pages

## Theme Integration

- [Theme Integration](theme-integration.md) - How Meetup module integrates with theme
- [Modular Architecture](modular-architecture.md) - Modular design patterns
- [Architecture Rules](architecture-rules.md) - Rules for architecture compliance

## Development Workflow

- [Development](development.md) - Development workflow
- [Quickstart](quickstart.md) - Getting started quickly
- [Testing Quality Assurance](testing-quality-assurance.md) - QA practices
- [Contributing](contributing.md) - How to contribute to the project

## Frontend Assets

- [Development Workflow CSS/JS Changes](development-workflow-css-js-changes.md) - Asset management
- [Tailwind Best Practices](tailwind-best-practices.md) - CSS framework usage
- [Vite Theme Asset Loading](vite-theme-asset-loading.md) - Asset compilation
- [Build and Copy Workflow](build-and-copy-workflow.md) - Build process

## Missing Features & Gaps

- [Missing Features](missing-features.md) - Identified missing functionality
- [Gap Analysis](gap-analysis.md) - Gap analysis between current and desired state
- [Missing Documentation Analysis](missing-documentation-analysis.md) - Documentation gaps
- [Implementation Log](implementation-log.md) - Implementation tracking

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)

## Regola Operativa Obbligatoria

- Prima di modificare codice: ragionare, studiare i docs del modulo/tema, aggiornare docs/rules/memory/skills.
- Riferimento globale: [Pre-Edit Docs-First Rule](../../../../docs/rules/pre-edit-docs-first-rule.md)
- Memory: [Pre-Edit Docs-First Memory](../../../../docs/memory/pre-edit-docs-first-memory.md)
- Skill: [Pre-Edit Docs-First Skill](../../../../docs/skills/pre-edit-docs-first-skill.md)
