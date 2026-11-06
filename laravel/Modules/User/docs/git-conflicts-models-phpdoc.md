---
title: "Risoluzione conflitti Git: PHPDoc modelli User"
type: concept
tags: [git, conflicts, models, phpdoc]
created: 2026-07-14
updated: 2026-07-14
qmd: "git-conflicts-models-phpdoc risoluzione conflitti git: phpdoc modelli user"
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

# Risoluzione conflitti Git: PHPDoc modelli User

## Contesto

Conflitti Git nei blocchi PHPDoc di 25+ modelli del modulo User, causati da merge tra branch con IdeHelper/PHPDoc aggiornati.

## File risolti

- Authentication, TeamPermission, Extra, DeviceUser, PasswordReset, Notification
- ProfileTeam, Role, SsoProvider, OauthClient, ModelRole, PersonalAccessToken
- OauthAccessToken, TenantUser, ModelHasRole, ModelHasPermission, TeamInvitation
- SocialiteUser, DeviceProfile, Feature, TeamUser, PermissionUser, Permission
- Passport/Client, Membership, OauthPersonalAccessClient, Tenant, OauthToken
- Geo: County
- _ide_helper_models.php

## Criteri di risoluzione

1. **ProfileContract vs Meetup\Profile**: mantenuto `ProfileContract` (modulo User generico, non dipende da Meetup)
2. **Formattazione**: preferita versione compatta (da38c10) senza righe vuote ridondanti
3. **property-read**: usato dove appropriato per proprietà di sola lettura (Passport Client)
4. **Factory**: mantenuto riferimento a factory del modulo User

## Riferimenti

- [conflict_resolution_report](conflict-resolution-report.md)
- [rules-index](rules-index.md)
