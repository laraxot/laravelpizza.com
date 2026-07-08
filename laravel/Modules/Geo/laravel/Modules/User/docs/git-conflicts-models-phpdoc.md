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

- [conflict_resolution_report](conflict_resolution_report.md)
- [rules-index](rules-index.md)
