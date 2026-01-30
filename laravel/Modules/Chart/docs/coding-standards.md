# Coding Standards for Chart Module

This document summarizes the coding standards and best practices used in this repository for the **Chart** module. The authoritative project-wide rules live in `CLAUDE.md` (project root) and in the **Xot** module docs; this file is a Chart-specific distillation.

## General Principles

- **Boy-Scout Rule:** leave code better than you found it.
- **Readability & Maintainability:** prefer clarity over cleverness.
- **Testability:** keep responsibilities small; side effects explicit.
- **Performance & Security:** treat chart rendering and export as potentially heavy operations (CPU, memory, I/O).

## Specific Guidelines

- **Function/Method Size:** keep functions focused; refactor when complexity grows.
- **Modularity:** prefer `Action` classes and DTO/Data objects for chart data preparation.
- **Meaningful Naming:** names must reflect domain intent (chart type, export target, format).
- **Documentation:** keep docs updated inside `docs/` after changes.

## PHP Specific

- **Laravel/Filament Idioms:** use Filament 4 widgets/resources/pages the Laraxot way (extend Xot base classes where applicable).
- **Strict Typing:** use `declare(strict_types=1);` and strong type hints; target PHPStan level 10.
- **Arrays & keys:** when array keys are semantically meaningful (e.g. schema definitions), prefer associative arrays with explicit string keys.

## JavaScript Specific

- **Modular Code:** keep JS export utilities isolated and testable.
- **Avoid Inline JavaScript:** do not embed JS in Blade; use the module build pipeline.

## Documentation Pointers (Charts + PDF)

- `filament-charts-professional-guide.md`
- `charts-and-pdf-complete-guide.md`
- `pdf-charts-advanced-techniques.md`

By following these guidelines, we can keep a consistent and maintainable chart + export system across the Chart module and the whole project.
