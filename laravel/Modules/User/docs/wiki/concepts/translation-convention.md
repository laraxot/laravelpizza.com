# Translation Convention - User Module

## Regola
Tutte le traduzioni seguono la convenzione a 5 elementi:
```
__('<namespace>::<context>.<collection>.<key>.<type>')
```

## Struttura
| Elemento | Descrizione | Esempio |
|----------|-------------|---------|
| namespace | modulo/componente | `user`, `pub_theme`, `gdpr` |
| context | area funzionale | `auth`, `login`, `register` |
| collection | raggruppamento logico | `login`, `fields`, `actions` |
| key | chiave specifica | `title`, `submit`, `welcome_back` |
| type | tipo metadato | `text`, `label`, `key`, `description`, `context`, `placeholder` |

## Esempio corretto
```php
__('user::auth.login.title.label')
__('user::auth.login.welcome_back.text')
__('user::auth.login.submit.text')
```

## Esempio sbagliato
```php
__('user::auth.login.title')  // mancano key e type
__('user::auth.login.logging_in')  // mancano key e type
```

## File di riferimento
- `laravel/Modules/User/lang/it/auth.php` — file principale per le traduzioni di autenticazione
- `laravel/Modules/User/lang/it/login.php` — file secondario per widget login
- `laravel/Modules/User/lang/it/login-widget.php` — file per widget Filament login
