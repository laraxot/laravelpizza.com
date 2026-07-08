---
title: "Laraxot Documentation - Sharded Index"
type: index
confidence: high
created: 2026-05-11
updated: 2026-05-11
tags: [laraxot, xot, documentation, index, shards]
related:
  - ../consolidated/laraxot.md
  - ./01-overview.md
  - ./02-architecture.md
  - ./03-data-management.md
---

# Laraxot Documentation Index

> **ATTENZIONE TOKEN**: Questo indice rimpiazza il file consolidato di 8832 linee (~270K tokens).
> Carica solo gli shard necessari per il task corrente.

## Shard Structure

| Shard | Linee | Tokens | Contenuto |
|-------|-------|--------|-----------|
| [01-overview](./01-overview.md) | ~50 | ~65K | Overview e introduzione |
| [02-architecture](./02-architecture.md) | ~100 | ~130K | Core Architecture, Modules, Base Classes |
| [03-data-management](./03-data-management.md) | ~50 | ~65K | DTOs, Actions, Data Objects |
| [04-best-practices](./04-best-practices.md) | ~100 | ~130K | Module Organization, Type Safety, Error Handling |
| [05-common-patterns](./05-common-patterns.md) | ~50 | ~65K | Repository Pattern, Service Layer |
| [06-testing](./06-testing.md) | ~50 | ~65K | Unit Tests, Feature Tests |
| [07-troubleshooting](./07-troubleshooting.md) | ~50 | ~65K | Common Issues, Debugging |
| [08-security](./08-security.md) | ~50 | ~65K | Validation, Authentication, Authorization |
| [09-performance](./09-performance.md) | ~50 | ~65K | Caching, Query Optimization |
| [10-maintenance](./10-maintenance.md) | ~50 | ~65K | Updates, Monitoring |
| [11-spatie-integration](./11-spatie-integration.md) | ~100 | ~130K | Laravel Data, QueueableActions |
| [12-geo-management](./12-geo-management.md) | ~200 | ~260K | Coordinates, Photon, Client Maps |
| [13-error-logging](./13-error-logging.md) | ~100 | ~130K | Error Handling, Logging Strategy |
| [14-filament](./14-filament.md) | ~150 | ~195K | Resources, Actions, Form Components |
| [15-view-components](./15-view-components.md) | ~100 | ~130K | Blade, Livewire |
| [16-assets-cli](./16-assets-cli.md) | ~100 | ~130K | Vite, Commands |
| [17-contributing](./17-contributing.md) | ~50 | ~65K | Setup, Testing, PR |

## Legacy File

- [consolidated/laraxot.md](../consolidated/laraxot.md) - **DEPRECATO**: 8832 linee, supera limite token. Non caricare intero.

## Compression Rules

Quando carichi shard:
1. **Livello 0**: Carica solo sezioni rilevanti
2. **Livello 1**: Rimuovi esempi non necessari
3. **Livello 2**: Abbrevia nomi campi nei code block
4. **Livello 3**: Schema only per dati strutturati

## Token Budget per Task

| Task Type | Max Shards | Max Tokens |
|-----------|------------|------------|
| Quick reference | 1 | 65K |
| Implementation | 2-3 | 200K |
| Deep dive | 4-5 | 300K |
| Full architecture | Index only | 20K |

## Trigger Map

- "Laraxot overview" → 01-overview.md
- "Xot architecture" → 02-architecture.md
- "Spatie Data" → 11-spatie-integration.md
- "Geo module" → 12-geo-management.md
- "Filament resources" → 14-filament.md
- "Testing" → 06-testing.md
