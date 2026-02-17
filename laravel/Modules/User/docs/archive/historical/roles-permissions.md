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
class BaseUser extends Authenticatable
{
    use HasRoles;
    protected $guard_name = 'web';
    // ...
}
## Query SQL di correzione
```sql
UPDATE roles SET guard_name = 'web' WHERE guard_name = '' OR guard_name IS NULL;
UPDATE permissions SET guard_name = 'web' WHERE guard_name = '' OR guard_name IS NULL;
## Collegamento regole generali
Vedi anche: ../../Xot/project_docs/roles-permissions.md
Vedi anche: ../../Xot/docs/roles-permissions.md
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
