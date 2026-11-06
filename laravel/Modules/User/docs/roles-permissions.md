---
title: "Gestione coerente di roles, permissions e guard_name"
type: note
status: draft
updated: 2026-10-07
tags: [docs, user]
qmd: "gestione coerente di roles, permissions e guard_name user"
---
# Gestione coerente di roles, permissions e guard_name

## Regola fondamentale
Tutti i ruoli e permessi devono avere `guard_name = 'web'` (o quello specificato dal modello utente). Il modello utente deve dichiarare esplicitamente:
```php
protected $guard_name = 'web';
```

## Motivazione
La coerenza del guard_name è essenziale per evitare errori di runtime, escalation di privilegi e problemi di sicurezza (es. `GuardDoesNotMatch`).

## Esempio pratico
- Tabella `roles` e `permissions`: tutti i record devono avere `guard_name = 'web'`.
- Modello utente:
```php
class BaseUser extends Authenticatable
{
    use HasRoles;
    protected $guard_name = 'web';
    // ...
}
```

## Query SQL di correzione
```sql
UPDATE roles SET guard_name = 'web' WHERE guard_name = '' OR guard_name IS NULL;
UPDATE permissions SET guard_name = 'web' WHERE guard_name = '' OR guard_name IS NULL;
```

## Collegamento regole generali
Vedi anche: ../../Xot/docs/roles-permissions.md
---
module: theme
topic: roles-permissions
canonical: ../../../Themes/docs/shared-components/roles-permissions.md
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
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/roles-permissions.md
