# Regole generali su roles, permissions e guard_name

## Regola generale
Ogni modulo che utilizza Spatie/Permission deve assicurare che:
- Tutti i ruoli e permessi abbiano un `guard_name` coerente con quello del modello utente (tipicamente `web`).
- Ogni modello utente coinvolto dichiari `protected $guard_name = 'web';`.

## Motivazione e implicazioni
Una mancata coerenza porta a errori come `GuardDoesNotMatch`, malfunzionamenti di comandi artisan, problemi di sicurezza e difficoltà nella manutenzione.

## Esempio pratico
- Tabella `roles` e `permissions`: tutti i record devono avere `guard_name = 'web'`.
- Modello utente:
```php
class BaseUser extends Authenticatable
{
    use HasRoles;
    protected $guard_name = 'web';
}
```

## Query SQL suggerite
```sql
UPDATE roles SET guard_name = 'web' WHERE guard_name = '' OR guard_name IS NULL;
UPDATE permissions SET guard_name = 'web' WHERE guard_name = '' OR guard_name IS NULL;
```

## Collegamento documentazione specifica
Vedi anche: ../../User/project_docs/roles-permissions.md
