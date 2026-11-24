---
<<<<<<< HEAD
title: "ADR — User possiede identità, ruoli e team"
type: decision
status: accepted
module: User
updated: 2026-11-24
=======
status: accepted
module: User
qmd: "user owns identity and roles possiede"
>>>>>>> laraxot/dev
---

# User possiede identità, ruoli e team

## Contesto

Autenticazione, ruoli globali e membership di team sono usati da tutti i moduli ma devono avere un solo owner.

## Driver della decisione

- Evitare controlli identità e permessi duplicati nei temi e nei domini.

## Decisione

User possiede identità, autenticazione, ruoli, permessi e team; i moduli chiamanti usano policy e contratti User.

## Alternative scartate

- Implementare ruoli direttamente in ogni modulo.
- Confondere appartenenza a un team con privilegio super-admin.

## Conseguenze

Le autorizzazioni restano centralizzate e verificabili; ogni dominio deve dichiarare policy e perimetro della risorsa.

## Conferma

Verificare UserContract, BaseUserPolicy, Role, team membership e test di autenticazione.
<<<<<<< HEAD

## Verifica

- Contratto e policy base nel modulo owner: `Modules/User/app/Contracts/UserContract.php`,
  `Modules/User/app/Models/Policies/BaseUserPolicy.php`, `Modules/User/app/Models/Role.php`,
  `Modules/User/app/Models/TeamUser.php`.
- Uso da parte degli altri moduli: `rg -l 'BaseUserPolicy|UserContract' laravel/Modules/*/app` (ad esempio le policy di Cms).
- Test: `Modules/User/tests/Feature/UserAuthenticationTest.php` e `Modules/User/tests/Feature/TeamManagementTest.php`.
- Non esiste un test che impedisca a un altro modulo di definire ruoli propri o di equiparare un team al super-admin:
  resta revisione del codice.
=======
>>>>>>> laraxot/dev
