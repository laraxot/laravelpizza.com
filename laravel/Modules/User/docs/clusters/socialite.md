---
title: "Socialite Cluster Structure"
type: concept
tags: [socialite]
created: 2026-07-14
updated: 2026-07-14
qmd: "socialite socialite cluster structure"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./passport-actions.md"
---

# Socialite Cluster Structure

This document outlines the structure and organization of the **Socialite** cluster within the **User** module.

## Overview

The `Socialite` cluster groups all resources related to social authentication, following the Laraxot modular architecture principles.

## Structure

```
Modules/User/Filament/Clusters/
├── Socialite.php               # Cluster Definition (extends XotBaseCluster)
└── Socialite/
    └── Resources/
        ├── SocialProviderResource.php
        └── SocialiteUserResource.php
```

## Migration Guide

Resources moved from `Filament/Resources` to `Filament/Clusters/Socialite/Resources`:

- `SocialProviderResource`
- `SocialiteUserResource`

## Namespaces

- **Cluster**: `Modules\User\Filament\Clusters`
- **Resources**: `Modules\User\Filament\Clusters\Socialite\Resources`

## Visibility

To ensure the cluster is visible in the Filament admin panel:
1. The `Socialite` cluster class must extend `XotBaseCluster`.
2. All resources within the cluster must define `protected static ?string $cluster = Socialite::class;`.
