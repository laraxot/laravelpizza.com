---
title: "OauthClient - Authorizable e HasRoles"
type: concept
tags: [oauth, client, authorizable]
created: 2026-07-14
updated: 2026-07-14
qmd: "oauth-client-authorizable oauthclient - authorizable e hasroles"
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
