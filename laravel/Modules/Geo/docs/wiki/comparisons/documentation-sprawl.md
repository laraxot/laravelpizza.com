---
qmd: "documentation sprawl"
issues: []
discussions: []
title: "Documentation Sprawl Analysis — Geo Module"
type: comparison
tags: [geo, documentation, redundancy, sprawl, dry]
created: "2026-05-25"
updated: 2026-11-23
---

# Documentation Sprawl Analysis — Geo Module

## Overview

The `laravel/Modules/Geo/docs` directory contains over 200 files in its root, exhibiting extreme redundancy and fragmentation. This sprawl makes it difficult for developers and AI agents to find the Single Source of Truth (SSoT).

## Identified Redundancy Patterns

### 1. Snake-case vs. Kebab-case Duplicates
Many files exist with both naming conventions and nearly identical content:
- `address-autocomplete-2.md` vs `address-autocomplete-2.md`
- `address-implementation-2.md` vs `address-implementation-2.md`
- `address-migration-guide-2.md` vs `address-migration.md` / `address_migration.md`
- `address-model-italian-2.md` vs `address-model-italian-2.md`
- `address-relationships-2.md` vs `address-relationships-2.md`

### 2. Fragmentation by Detail
Topics are split into too many small files that should be consolidated:
- **Address Resource**: `address-resource-2.md`, `address-resource-2.md`, `address-resource-analysis.md`, `address-resource-improvements.md`, `address-resource-summary.md`, `address-resource-sumy.md`, `addressresource.md`, etc.
- **Address Resource**: `address-resource-2.md`, `address-resource-1.md`, `address-resource-analysis.md`, `address-resource-improvements.md`, `address-resource-summary.md`, `address-resource-sumy.md`, `addressresource.md`, etc.
- **Comune Model**: `comune-model-2.md`, `comune-model-2.md`, `comune-sushi-analisi-2.md`, `comune-sushi-conversion-2.md`, `comune-sushi-implementation-2.md`, `comune-sushi-analysis.md`, etc.

### 3. Duplicate Analysis and Summaries
Multiple files exist for "Implementation Summary" and "Consolidated Business Logic":
- `implementation_summary.md`, `implementation-summary.md`, `implementation-summary-1.md`, `implementation-sumy-2.md`
- `business-logic-analysis-3.md`, `business-logic-consolidated.md`, `business-logic-overview.md`

### 4. Placeholder and Empty Files
- `sushi-command-2.md` (1 byte)
- `tomtom-com-2.md` / `tomtom_com.txt` (0 bytes)
- `qmd-setup-3.md` (0 bytes)

## Recommended Actions

1. **Consolidate by Topic**: Merge all "Address" related files into a single `wiki/concepts/address-master-guide.md`.
2. **Standardize Naming**: Adopt Kebab-case (`-`) as the standard and remove Snake-case (`_`) duplicates.
3. **Move to Wiki Structure**: Migrate valuable content to `docs/wiki/concepts/`, `docs/wiki/troubleshooting/`, etc., and delete the root `docs/` files.
4. **Remove Placeholders**: Delete 0-byte and 1-byte files.

## Impact

Reducing the file count from 200+ to ~20 well-structured wiki pages will:
- Improve search accuracy for QMD.
- Reduce cognitive load for developers.
- Prevent "stale documentation" where one version is updated but the duplicate isn't.
