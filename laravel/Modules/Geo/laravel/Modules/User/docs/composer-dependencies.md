# Composer Dependencies - Modulo User

## Regola Fondamentale

**Le dipendenze specifiche del modulo User (auth, login, OAuth, Socialite) vanno in `Modules/User/composer.json`, MAI nel root `laravel/composer.json`.**

## Motivazione

- **Encapsulation**: Il modulo User è responsabile della propria logica di autenticazione
- **Modularità**: Il root composer.json gestisce solo dipendenze core (Laravel, Filament, nwidart)
- **wikimedia/composer-merge-plugin**: Merge automatico dei composer.json dei moduli

## Package che Appartengono al Modulo User

| Package | Motivo |
|---------|--------|
| `socialiteproviders/microsoft` | OAuth Microsoft per login |
| `socialiteproviders/auth0` | OAuth Auth0 per login |
| `laravel/passport` | API OAuth |
| `jenssegers/agent` | User agent per auth |
| `spatie/laravel-personal-data-export` | Export dati utente |

## Workflow Corretto

1. Modificare `Modules/User/composer.json` aggiungendo il package in `require`
2. Dalla root Laravel: `cd laravel && composer go`

## Anti-pattern

```bash
# ERRATO: installa nel root
cd laravel && composer require socialiteproviders/microsoft
```

## Collegamenti

- [Composer Module Dependency Management](../../Xot/docs/composer-module-dependency-management.md)
- [Socialite Microsoft Integration](socialite-microsoft-integration.md)
