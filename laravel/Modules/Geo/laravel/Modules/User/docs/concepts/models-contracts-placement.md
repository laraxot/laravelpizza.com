---
title: "Models/Contracts — capacità Eloquent nel modulo User"
type: concept
module: User
tags: [contract, models, eloquent, can-comment, placement]
created: 2026-06-10
updated: 2026-06-10
qmd: "User Models Contracts placement CanComment app Contracts deprecated"
related:
  - ../../../../docs/wiki/bmad/architecture-models-contracts-placement.md
---

# Models/Contracts (User)

## Regola

Contratti che descrivono **solo capacità Eloquent** (`getKey`, morph, notifiche su Model) vivono in `app/Models/Contracts/`, **mai** in `app/Contracts/`.

`app/Contracts/` resta per boundary cross-modulo (`UserContract`, team, passport).

## CanComment

- **Owner SSOT:** `Modules\Comment\Models\Contracts\CanComment`
- `BaseUser implements CanComment` + `InteractsWithComments`
- Rimosso `app/Contracts/CanComment.php` → archivio `app/Models/Contracts/CanComment.php.old`

## Checklist nuovo contratto User

1. È solo per Model? → `Models/Contracts/`
2. Serve a Filament/service/provider? → `app/Contracts/`
3. Owner dominio in altro modulo? → implementa il contratto owner, non duplicare
