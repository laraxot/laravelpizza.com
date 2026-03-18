# OauthClient - Authorizable e HasRoles

**Riferimento**: [aurmich/sample_passport Client.php](https://github.com/aurmich/sample_passport/blob/develop/app/Models/Client.php)

## Scopo

Estendere `OauthClient` con `AuthorizableContract` e `HasRoles` per permettere ai client OAuth (machine-to-machine, app terze) di avere permessi propri tramite Spatie Permission.

## Implementazione

- **AuthorizableContract** + **Authorizable**: interfaccia `can()`, `cant()`, `cannot()`, `canAny()`
- **HasRoles**: trait Spatie per ruoli/permessi sul client
- **guard_name = 'api'**: guard dedicato (non `web`)
- **user() override**: `XotData::make()->getUserClass()` invece di `config()`
- **checkPermission()**: catch `PermissionDoesNotExist` per permessi non esistenti

## Test

- [OauthClientTest](../tests/Unit/Models/OauthClientTest.php)

## Collegamenti

- [passport-integration](passport-integration.md)
- [passport-oauth-audit](passport-oauth-audit.md)
