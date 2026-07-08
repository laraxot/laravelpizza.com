# Architecture Documentation Index

**Path**: `.agents/docs/architecture/`
**Purpose**: Architectural decisions, patterns, and guidelines
**Last Updated**: 2026-03-26

## Documents

| File | Description | Priority |
|------|-------------|----------|
| [filament-table-vs-blade-component.md](./filament-table-vs-blade-component.md) | LIST-like = Filament table, shell/detail = Blade | CRITICAL |

## Metodologia esecutiva collegata

- [../../../../docs/project/gsd-and-bmad-workflow.md](../../../../docs/project/gsd-and-bmad-workflow.md) — ordine canonico BMAD -> GSD -> Ralph
- [../../ralph/00-INDEX.md](../../ralph/00-INDEX.md) — albero Ralph locale, senza duplicare template nel root del repository

## Quick Decision Guide

### Building a LIST-like public surface?
-> Use **Filament Table Widget**
-> See: [Filament Table vs Blade Component](./filament-table-vs-blade-component.md)

### Building a DETAIL page?
-> Use **Blade shell + Filament Table dove la sezione e list-like**
-> See: [Filament Table vs Blade Component](./filament-table-vs-blade-component.md)

## Navigation

- [../00-INDEX.md](../00-INDEX.md)
- [../../../../AGENTS.md](../../../../AGENTS.md)
