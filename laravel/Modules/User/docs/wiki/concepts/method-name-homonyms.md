---
title: "censimento omonimi metodi — modulo User"
type: analysis
module: User
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — User

> **147** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo User)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 35 |
| `E_scheda_stack` | 8 |
| `F_trait_name_collision` | 1 |
| `G_module_local` | 37 |
| `H_cross_module_homonym` | 66 |

## Dettaglio

### `A_filament_framework` (35 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `toArray` — 39 classi

- `User` · `ClientResource` · `Modules/User/app/Http/Resources/ClientResource.php`
- `User` · `OwnerResource` · `Modules/User/app/Http/Resources/OwnerResource.php`
- `User` · `Otp` · `Modules/User/app/Notifications/Auth/Otp.php`

#### `before` — 14 classi

- `User` · `UserPermissionBasePolicy` · `Modules/User/app/Models/Policies/UserPermissionBasePolicy.php`

#### `via` — 14 classi

- `User` · `Otp` · `Modules/User/app/Notifications/Auth/Otp.php`

#### `getHeaderWidgets` — 13 classi

- `User` · `BaseListUsers` · `Modules/User/app/Filament/Resources/UserResource/Pages/BaseListUsers.php`
- `User` · `ListUsers` · `Modules/User/app/Filament/Resources/UserResource/Pages/ListUsers.php`

#### `getModel` — 10 classi

- `User` · `OauthClientResource` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `User` · `ClientResource` · `Modules/User/app/Filament/Resources/ClientResource.php`
- `User` · `TeamResource` · `Modules/User/app/Filament/Resources/TeamResource.php`
- `User` · `TenantResource` · `Modules/User/app/Filament/Resources/TenantResource.php`
- `User` · `UserResource` · `Modules/User/app/Filament/Resources/UserResource.php`

#### `toMail` — 10 classi

- `User` · `Otp` · `Modules/User/app/Notifications/Auth/Otp.php`

#### `validate` — 8 classi

- `User` · `CheckOtpExpiredRule` · `Modules/User/app/Rules/CheckOtpExpiredRule.php`

#### `destroy` — 5 classi

- `User` · `DeleteAccount` · `Modules/User/app/Http/Livewire/Profile/DeleteAccount.php`

### `F_trait_name_collision`

#### `roles` — 2 classi

- `User` · `trait:HasRoles` · `Modules/User/app/Models/Traits/HasRoles.php`
- `User` · `trait:HasSpatiePermission` · `Modules/User/app/Models/Traits/HasSpatiePermission.php`

### `G_module_local`

#### `handleRecordUpdate` — 8 classi

- `User` · `Alignment` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php`
- `User` · `Background` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php`
- `User` · `Colors` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php`
- `User` · `CustomCss` · `Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php`
- `User` · `Favicon` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php`
- `User` · `Logo` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Logo.php`
- `User` · `MyProfilePage` · `Modules/User/app/Filament/Pages/MyProfilePage.php`
- `User` · `Password` · `Modules/User/app/Filament/Pages/Password.php`

#### `getUpdateFormActions` — 6 classi

- `User` · `Alignment` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php`
- `User` · `Background` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php`
- `User` · `Colors` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php`
- `User` · `CustomCss` · `Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php`
- `User` · `Favicon` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php`
- `User` · `Password` · `Modules/User/app/Filament/Pages/Password.php`

#### `updateData` — 6 classi

- `User` · `Alignment` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php`
- `User` · `Background` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php`
- `User` · `Colors` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php`
- `User` · `CustomCss` · `Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php`
- `User` · `Favicon` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php`
- `User` · `Password` · `Modules/User/app/Filament/Pages/Password.php`

#### `revoked` — 5 classi

- `User` · `OauthAccessTokenFactory` · `Modules/User/database/factories/OauthAccessTokenFactory.php`
- `User` · `OauthAuthCodeFactory` · `Modules/User/database/factories/OauthAuthCodeFactory.php`
- `User` · `OauthClientFactory` · `Modules/User/database/factories/OauthClientFactory.php`
- `User` · `OauthRefreshTokenFactory` · `Modules/User/database/factories/OauthRefreshTokenFactory.php`
- `User` · `OauthTokenFactory` · `Modules/User/database/factories/OauthTokenFactory.php`

#### `resetPassword` — 4 classi

- `User` · `PasswordExpired` · `Modules/User/app/Filament/Pages/Auth/PasswordExpired.php`
- `User` · `ResetPasswordWidget` · `Modules/User/app/Filament/Widgets/Auth/ResetPasswordWidget.php`
- `User` · `PasswordExpiredWidget` · `Modules/User/app/Filament/Widgets/PasswordExpiredWidget.php`
- `User` · `Reset` · `Modules/User/app/Http/Livewire/Auth/Passwords/Reset.php`

#### `team` — 4 classi

- `User` · `BaseTeamUser` · `Modules/User/app/Models/BaseTeamUser.php`
- `User` · `Role` · `Modules/User/app/Models/Role.php`
- `User` · `TeamInvitation` · `Modules/User/app/Models/TeamInvitation.php`
- `User` · `TeamPermission` · `Modules/User/app/Models/TeamPermission.php`

#### `canAccessSocialite` — 3 classi

- `User` · `BaseUser` · `Modules/User/app/Models/BaseUser.php`
- `User` · `trait:HasSocialite` · `Modules/User/app/Models/Traits/HasSocialite.php`
- `User` · `User` · `Modules/User/app/Models/User.php`

#### `devices` — 3 classi

- `User` · `BaseUser` · `Modules/User/app/Models/BaseUser.php`
- `User` · `trait:HasDevices` · `Modules/User/app/Models/Traits/HasDevices.php`
- `User` · `trait:IsProfileTrait` · `Modules/User/app/Models/Traits/IsProfileTrait.php`

#### `expired` — 3 classi

- `User` · `OauthAuthCodeFactory` · `Modules/User/database/factories/OauthAuthCodeFactory.php`
- `User` · `OauthRefreshTokenFactory` · `Modules/User/database/factories/OauthRefreshTokenFactory.php`
- `User` · `OauthTokenFactory` · `Modules/User/database/factories/OauthTokenFactory.php`

#### `getResourceFormComponents` — 3 classi

- `User` · `OauthClientResource` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `User` · `ClientResource` · `Modules/User/app/Filament/Resources/ClientResource.php`
- `User` · `ClientForm` · `Modules/User/app/Filament/Resources/ClientResource/Schemas/ClientForm.php`

#### `isResourceFormComponentsEnabled` — 3 classi

- `User` · `OauthClientResource` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `User` · `ClientResource` · `Modules/User/app/Filament/Resources/ClientResource.php`
- `User` · `ClientForm` · `Modules/User/app/Filament/Resources/ClientResource/Schemas/ClientForm.php`

#### `permissions` — 3 classi

- `User` · `Role` · `Modules/User/app/Models/Role.php`
- `User` · `Team` · `Modules/User/app/Models/Team.php`
- `User` · `trait:HasSpatiePermission` · `Modules/User/app/Models/Traits/HasSpatiePermission.php`

_… +25 metodi in questa categoria_

### `H_cross_module_homonym`

#### `getUser` — 14 classi

- `User` · `MyProfilePage` · `Modules/User/app/Filament/Pages/MyProfilePage.php`

#### `getFormActions` — 13 classi

- `User` · `PasswordExpired` · `Modules/User/app/Filament/Pages/Auth/PasswordExpired.php`
- `User` · `MyProfilePage` · `Modules/User/app/Filament/Pages/MyProfilePage.php`
- `User` · `LogoutWidget` · `Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `User` · `LogoutWidget` · `Modules/User/app/Filament/Widgets/LogoutWidget.php`
- `User` · `PasswordExpiredWidget` · `Modules/User/app/Filament/Widgets/PasswordExpiredWidget.php`

#### `getNavigationLabel` — 11 classi

- `User` · `CreateOauthAccessToken` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/CreateOauthAccessToken.php`
- `User` · `EditOauthAccessToken` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/EditOauthAccessToken.php`
- `User` · `OauthAccessTokenResource` · `Modules/User/app/Filament/Resources/OauthAccessTokenResource.php`

#### `getRows` — 11 classi

- `User` · `SocialProvider` · `Modules/User/app/Models/SocialProvider.php`

#### `active` — 10 classi

- `User` · `OauthAccessTokenFactory` · `Modules/User/database/factories/OauthAccessTokenFactory.php`
- `User` · `OauthClientFactory` · `Modules/User/database/factories/OauthClientFactory.php`
- `User` · `UserFactory` · `Modules/User/database/factories/UserFactory.php`

#### `getWidgets` — 10 classi

- `User` · `Dashboard` · `Modules/User/app/Filament/Pages/Dashboard.php`
- `User` · `BaseUserResource` · `Modules/User/app/Filament/Resources/BaseUserResource.php`
- `User` · `UserResource` · `Modules/User/app/Filament/Resources/UserResource.php`

#### `form` — 9 classi

- `User` · `SocialiteProviderSettingsPage` · `Modules/User/app/Filament/Pages/SocialiteProviderSettingsPage.php`
- `User` · `Login` · `Modules/User/app/Http/Livewire/Auth/Login.php`
- `User` · `Register` · `Modules/User/app/Http/Livewire/Auth/Register.php`

#### `user` — 9 classi

- `User` · `BaseTeamUser` · `Modules/User/app/Models/BaseTeamUser.php`
- `User` · `DeviceUser` · `Modules/User/app/Models/DeviceUser.php`
- `User` · `SocialiteUser` · `Modules/User/app/Models/SocialiteUser.php`
- `User` · `TeamPermission` · `Modules/User/app/Models/TeamPermission.php`
- `User` · `trait:IsProfileTrait` · `Modules/User/app/Models/Traits/IsProfileTrait.php`

#### `getData` — 8 classi

- `User` · `UserTypeRegistrationsChartWidget` · `Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- `User` · `UsersChartWidget` · `Modules/User/app/Filament/Widgets/UsersChartWidget.php`

#### `getHeading` — 8 classi

- `User` · `MyProfilePage` · `Modules/User/app/Filament/Pages/MyProfilePage.php`
- `User` · `UserTypeRegistrationsChartWidget` · `Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- `User` · `UsersChartWidget` · `Modules/User/app/Filament/Widgets/UsersChartWidget.php`

#### `getType` — 8 classi

- `User` · `UserTypeRegistrationsChartWidget` · `Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- `User` · `UsersChartWidget` · `Modules/User/app/Filament/Widgets/UsersChartWidget.php`

#### `getLabel` — 7 classi

- `User` · `EditTeamProfile` · `Modules/User/app/Filament/Pages/Tenancy/EditTeamProfile.php`
- `User` · `EditTenantProfile` · `Modules/User/app/Filament/Pages/Tenancy/EditTenantProfile.php`
- `User` · `RegisterTeam` · `Modules/User/app/Filament/Pages/Tenancy/RegisterTeam.php`
- `User` · `RegisterTenant` · `Modules/User/app/Filament/Pages/Tenancy/RegisterTenant.php`

_… +54 metodi in questa categoria_




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
