---
title: "User Module Traits"
type: concept
tags: [traits]
created: 2026-07-14
updated: 2026-07-14
qmd: "traits user module traits"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# User Module Traits

## HasTeams

Gestisce l'appartenenza a team multipli.

```php
use Modules\User\Models\Traits\HasTeams;

class User extends Authenticatable
{
    use HasTeams;
}
```

## HasTenants

Gestione multi-tenant Filament.

```php
use Modules\User\Models\Traits\HasTenants;

class User extends Authenticatable
{
    use HasTenants;
}
```

## HasAuthenticationLogTrait

Logging autenticazioni.

```php
use Modules\User\Models\Traits\HasAuthenticationLogTrait;

class User extends Authenticatable
{
    use HasAuthenticationLogTrait;
}
```

## Collegamenti

- [Modulo User](./README.md)
- [Xot Traits](../../Xot/docs/)
