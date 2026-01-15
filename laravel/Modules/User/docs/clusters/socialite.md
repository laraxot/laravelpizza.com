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
