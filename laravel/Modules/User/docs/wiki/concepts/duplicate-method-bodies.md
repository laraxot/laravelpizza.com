---
title: "corpi metodo duplicati — User"
type: analysis
module: User
tags: [dry, duplication, census, refactoring, user]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies User identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
---

# Corpi metodo duplicati — User

> **152** gruppi con corpo identico coinvolgono User (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo User)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 53 | 1818 |
| `B_business_duplicate` | 52 | 347 |
| `C_cross_name` | 13 | 407 |
| `M_database_layer` | 12 | 132 |
| `S_trivial_stub` | 22 | 20245 |

## Dettaglio

### B — Business logic con corpo identico (consolidare: 1 owner)

#### `handleRecordUpdate` — 8 classi · 5 righe · ~35 righe duplicate

- `User` · `Alignment::handleRecordUpdate` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php:111`
- `User` · `Background::handleRecordUpdate` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php:104`
- `User` · `Colors::handleRecordUpdate` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php:100`
- `User` · `CustomCss::handleRecordUpdate` · `Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php:96`
- `User` · `Favicon::handleRecordUpdate` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php:96`
- `User` · `Logo::handleRecordUpdate` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Logo.php:94`
- … +2 occorrenze

#### `execute` — 2 classi · 21 righe · ~21 righe duplicate

- `User` · `CreateClientAction::execute` · `Modules/User/app/Actions/Passport/CreateClientAction.php:33`
- `User` · `CreateGenericClientAction::execute` · `Modules/User/app/Actions/Passport/CreateGenericClientAction.php:16`

#### `getUpdateFormActions` — 5 classi · 5 righe · ~20 righe duplicate

- `User` · `Alignment::getUpdateFormActions` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php:101`
- `User` · `Background::getUpdateFormActions` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php:94`
- `User` · `Colors::getUpdateFormActions` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php:90`
- `User` · `CustomCss::getUpdateFormActions` · `Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php:86`
- `User` · `Favicon::getUpdateFormActions` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php:86`

#### `normalizeFormSchema` — 2 classi · 16 righe · ~16 righe duplicate

- `User` · `EditUserWidget::normalizeFormSchema` · `Modules/User/app/Filament/Widgets/EditUserWidget.php:208`
- `User` · `RegistrationWidget::normalizeFormSchema` · `Modules/User/app/Filament/Widgets/RegistrationWidget.php:148`

#### `getRows` — 3 classi · 6 righe · ~12 righe duplicate

- `User` · `SocialProvider::getRows` · `Modules/User/app/Models/SocialProvider.php:118`
- `Sigma` · `WebService::getRows` · `Modules/Sigma/app/Models/WebService.php:75`
- `Xot` · `InformationSchemaTable::getRows` · `Modules/Xot/app/Models/InformationSchemaTable.php:94`

#### `showModelPath` — 2 classi · 12 righe · ~12 righe duplicate

- `User` · `ShieldUtilsAction::showModelPath` · `Modules/User/app/Actions/Shield/ShieldUtilsAction.php:265`
- `User` · `Utils::showModelPath` · `Modules/User/app/Support/Utils.php:274`

#### `getResourcePermissionPrefixes` — 2 classi · 11 righe · ~11 righe duplicate

- `User` · `ShieldUtilsAction::getResourcePermissionPrefixes` · `Modules/User/app/Actions/Shield/ShieldUtilsAction.php:282`
- `User` · `Utils::getResourcePermissionPrefixes` · `Modules/User/app/Support/Utils.php:291`

#### `isResourcePublished` — 2 classi · 10 righe · ~10 righe duplicate

- `User` · `ShieldUtilsAction::isResourcePublished` · `Modules/User/app/Actions/Shield/ShieldUtilsAction.php:35`
- `User` · `Utils::isResourcePublished` · `Modules/User/app/Support/Utils.php:34`

#### `getGeneralResourcePermissionPrefixes` — 2 classi · 8 righe · ~8 righe duplicate

- `User` · `ShieldUtilsAction::getGeneralResourcePermissionPrefixes` · `Modules/User/app/Actions/Shield/ShieldUtilsAction.php:130`
- `User` · `Utils::getGeneralResourcePermissionPrefixes` · `Modules/User/app/Support/Utils.php:139`

#### `getExcludedResouces` — 2 classi · 8 righe · ~8 righe duplicate

- `User` · `ShieldUtilsAction::getExcludedResouces` · `Modules/User/app/Actions/Shield/ShieldUtilsAction.php:212`
- `User` · `Utils::getExcludedResouces` · `Modules/User/app/Support/Utils.php:221`

_… +42 gruppi in questa categoria (vedi JSON)_

### C — Corpo identico, nomi diversi (copy-paste con rename)

#### `getHeaderActions` / `getTableHeaderActions` — 22 classi · 6 righe · ~126 righe duplicate

- `User` · `ListOauthClients::getHeaderActions` · `Modules/User/app/Filament/Resources/OauthClientResource/Pages/ListOauthClients.php:24`
- `User` · `ListPermissions::getHeaderActions` · `Modules/User/app/Filament/Resources/PermissionResource/Pages/ListPermissions.php:125`
- `User` · `ManagePersonalAccessTokens::getHeaderActions` · `Modules/User/app/Filament/Resources/PersonalAccessTokenResource/Pages/ManagePersonalAccessTokens.php:22`
- `User` · `PermissionsRelationManager::getTableHeaderActions` · `Modules/User/app/Filament/Resources/RoleResource/RelationManagers/PermissionsRelationManager.php:55`
- `User` · `ListTeamInvitations::getHeaderActions` · `Modules/User/app/Filament/Resources/TeamInvitationResource/Pages/ListTeamInvitations.php:23`
- `User` · `TeamInvitationsRelationManager::getTableHeaderActions` · `Modules/User/app/Filament/Resources/TeamResource/RelationManagers/TeamInvitationsRelationManager.php:41`
- … +16 occorrenze

#### `getHeaderActions` / `getTableActions` — 14 classi · 6 righe · ~78 righe duplicate

- `User` · `OauthPersonalAccessClientResource::getTableActions` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthPersonalAccessClientResource.php:116`
- `User` · `SsoProviderResource::getTableActions` · `Modules/User/app/Filament/Clusters/Socialite/Resources/SsoProviderResource.php:102`
- `User` · `OauthPersonalAccessClientResource::getTableActions` · `Modules/User/app/Filament/Resources/OauthPersonalAccessClientResource.php:105`
- `User` · `PermissionsRelationManager::getTableActions` · `Modules/User/app/Filament/Resources/RoleResource/RelationManagers/PermissionsRelationManager.php:66`
- `User` · `TeamInvitationsRelationManager::getTableActions` · `Modules/User/app/Filament/Resources/TeamResource/RelationManagers/TeamInvitationsRelationManager.php:52`
- `User` · `DomainsRelationManager::getTableActions` · `Modules/User/app/Filament/Resources/TenantResource/RelationManagers/DomainsRelationManager.php:75`
- … +9 occorrenze

#### `updateData` / `updateLogo` — 6 classi · 12 righe · ~60 righe duplicate

- `User` · `Alignment::updateData` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php:76`
- `User` · `Background::updateData` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php:69`
- `User` · `Colors::updateData` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php:65`
- `User` · `CustomCss::updateData` · `Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php:61`
- `User` · `Favicon::updateData` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php:61`
- `User` · `Logo::updateLogo` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Logo.php:59`

#### `getHeaderActions` / `getTableActions` — 9 classi · 6 righe · ~48 righe duplicate

- `User` · `EditSocialProvider::getHeaderActions` · `Modules/User/app/Filament/Clusters/Socialite/Resources/SocialProviderResource/Pages/EditSocialProvider.php:16`
- `User` · `EditRole::getHeaderActions` · `Modules/User/app/Filament/Resources/RoleResource/Pages/EditRole.php:43`
- `User` · `EditSocialProvider::getHeaderActions` · `Modules/User/app/Filament/Resources/SocialProviderResource/Pages/EditSocialProvider.php:16`
- `User` · `EditTeam::getHeaderActions` · `Modules/User/app/Filament/Resources/TeamResource/Pages/EditTeam.php:17`
- `User` · `EditTenant::getHeaderActions` · `Modules/User/app/Filament/Resources/TenantResource/Pages/EditTenant.php:20`
- `Incentivi` · `EditEmployee::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/EmployeeResource/Pages/EditEmployee.php:16`
- … +4 occorrenze

#### `create` / `delete` / `forceDelete` / `restore` / `reverse` / `update` — 11 classi · 3 righe · ~30 righe duplicate

- `User` · `BaseTeamPolicy::restore` · `Modules/User/app/Models/Policies/BaseTeamPolicy.php:58`
- `User` · `BaseTeamPolicy::forceDelete` · `Modules/User/app/Models/Policies/BaseTeamPolicy.php:66`
- `User` · `BaseUserPolicy::restore` · `Modules/User/app/Models/Policies/BaseUserPolicy.php:59`
- `Incentivi` · `SettlementPolicy::reverse` · `Modules/Incentivi/app/Models/Policies/SettlementPolicy.php:103`
- `IndennitaResponsabilita` · `BaseModelPolicy::create` · `Modules/IndennitaResponsabilita/app/Models/Policies/BaseModelPolicy.php:32`
- `IndennitaResponsabilita` · `BaseModelPolicy::update` · `Modules/IndennitaResponsabilita/app/Models/Policies/BaseModelPolicy.php:40`
- … +17 occorrenze

#### `create` / `delete` / `update` / `view` / `viewAny` — 10 classi · 3 righe · ~27 righe duplicate

- `User` · `BaseTeamPolicy::viewAny` · `Modules/User/app/Models/Policies/BaseTeamPolicy.php:16`
- `User` · `BaseTeamPolicy::create` · `Modules/User/app/Models/Policies/BaseTeamPolicy.php:33`
- `User` · `BaseUserPolicy::viewAny` · `Modules/User/app/Models/Policies/BaseUserPolicy.php:16`
- `User` · `BaseUserPolicy::create` · `Modules/User/app/Models/Policies/BaseUserPolicy.php:33`
- `IndennitaResponsabilita` · `IndennitaResponsabilitaPolicy::update` · `Modules/IndennitaResponsabilita/app/Models/Policies/IndennitaResponsabilitaPolicy.php:54`
- `IndennitaResponsabilita` · `IndennitaResponsabilitaPolicy::delete` · `Modules/IndennitaResponsabilita/app/Models/Policies/IndennitaResponsabilitaPolicy.php:62`
- … +11 occorrenze

#### `execute` / `isReadable` — 2 classi · 11 righe · ~11 righe duplicate

- `User` · `IsNotificationSchemaReadableAction::execute` · `Modules/User/app/Actions/Notification/IsNotificationSchemaReadableAction.php:18`
- `User` · `NotificationSchema::isReadable` · `Modules/User/app/Support/NotificationSchema.php:15`

#### `execute` / `getPermissionModel` — 3 classi · 5 righe · ~10 righe duplicate

- `User` · `GetPermissionModelAction::execute` · `Modules/User/app/Actions/Shield/GetPermissionModelAction.php:15`
- `User` · `ShieldUtilsAction::getPermissionModel` · `Modules/User/app/Actions/Shield/ShieldUtilsAction.php:302`
- `User` · `Utils::getPermissionModel` · `Modules/User/app/Support/Utils.php:311`

#### `execute` / `forAuthenticatable` — 2 classi · 5 righe · ~5 righe duplicate

- `User` · `GetAuthenticationLogQueryForAuthenticatableAction::execute` · `Modules/User/app/Actions/Authentication/GetAuthenticationLogQueryForAuthenticatableAction.php:19`
- `User` · `AuthenticationLogQuery::forAuthenticatable` · `Modules/User/app/Support/AuthenticationLogQuery.php:16`

#### `execute` / `make` — 2 classi · 3 righe · ~3 righe duplicate

- `User` · `HashOtpValueAction::execute` · `Modules/User/app/Actions/Otp/HashOtpValueAction.php:19`
- `User` · `Hasher::make` · `Modules/User/app/Actions/Otp/Hasher.php:16`
- `User` · `Hasher::make` · `Modules/User/app/Adapters/Otp/Hasher.php:16`

_… +3 gruppi in questa categoria (vedi JSON)_

### A — Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getHeaderActions` — 50 classi · 5 righe · ~245 righe duplicate

- `User` · `EditOauthAccessTokens::getHeaderActions` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/EditOauthAccessTokens.php:23`
- `User` · `EditSocialiteUser::getHeaderActions` · `Modules/User/app/Filament/Clusters/Socialite/Resources/SocialiteUserResource/Pages/EditSocialiteUser.php:23`
- `User` · `EditAuthenticationLog::getHeaderActions` · `Modules/User/app/Filament/Resources/AuthenticationLogResource/Pages/EditAuthenticationLog.php:23`
- `User` · `EditDevice::getHeaderActions` · `Modules/User/app/Filament/Resources/DeviceResource/Pages/EditDevice.php:15`
- `User` · `EditOauthAccessTokens::getHeaderActions` · `Modules/User/app/Filament/Resources/OauthAccessTokenResource/Pages/EditOauthAccessTokens.php:23`
- `User` · `EditSocialiteUser::getHeaderActions` · `Modules/User/app/Filament/Resources/SocialiteUserResource/Pages/EditSocialiteUser.php:23`
- … +46 occorrenze

#### `getTableColumns` — 20 classi · 10 righe · ~190 righe duplicate

- `User` · `OauthAccessTokensTable::getTableColumns` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Tables/OauthAccessTokensTable.php:16`
- `User` · `OauthAuthCodesTable::getTableColumns` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAuthCodeResource/Tables/OauthAuthCodesTable.php:16`
- `User` · `OauthClientsTable::getTableColumns` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource/Tables/OauthClientsTable.php:16`
- `User` · `OauthDeviceCodesTable::getTableColumns` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthDeviceCodeResource/Tables/OauthDeviceCodesTable.php:16`
- `User` · `OauthPersonalAccessClientsTable::getTableColumns` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthPersonalAccessClientResource/Tables/OauthPersonalAccessClientsTable.php:16`
- `User` · `OauthRefreshTokensTable::getTableColumns` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthRefreshTokenResource/Tables/OauthRefreshTokensTable.php:16`
- … +14 occorrenze

#### `getTableBulkActions` — 31 classi · 5 righe · ~150 righe duplicate

- `User` · `PermissionsRelationManager::getTableBulkActions` · `Modules/User/app/Filament/Resources/RoleResource/RelationManagers/PermissionsRelationManager.php:78`
- `User` · `TeamInvitationsRelationManager::getTableBulkActions` · `Modules/User/app/Filament/Resources/TeamResource/RelationManagers/TeamInvitationsRelationManager.php:64`
- `User` · `DomainsRelationManager::getTableBulkActions` · `Modules/User/app/Filament/Resources/TenantResource/RelationManagers/DomainsRelationManager.php:87`
- `User` · `ProfileRelationManager::getTableBulkActions` · `Modules/User/app/Filament/Resources/UserResource/RelationManagers/ProfileRelationManager.php:83`
- `User` · `TokensRelationManager::getTableBulkActions` · `Modules/User/app/Filament/Resources/UserResource/RelationManagers/TokensRelationManager.php:72`
- `Incentivi` · `ManageProjectSettlements::getTableBulkActions` · `Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectSettlements.php:107`
- … +25 occorrenze

#### `getFormSchema` — 19 classi · 7 righe · ~126 righe duplicate

- `User` · `OauthAccessTokenForm::getFormSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Schemas/OauthAccessTokenForm.php:17`
- `User` · `OauthAuthCodeForm::getFormSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAuthCodeResource/Schemas/OauthAuthCodeForm.php:17`
- `User` · `OauthClientForm::getFormSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource/Schemas/OauthClientForm.php:17`
- `User` · `OauthDeviceCodeForm::getFormSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthDeviceCodeResource/Schemas/OauthDeviceCodeForm.php:17`
- `User` · `OauthPersonalAccessClientForm::getFormSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthPersonalAccessClientResource/Schemas/OauthPersonalAccessClientForm.php:17`
- `User` · `OauthRefreshTokenForm::getFormSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthRefreshTokenResource/Schemas/OauthRefreshTokenForm.php:17`
- … +13 occorrenze

#### `casts` — 7 classi · 18 righe · ~108 righe duplicate

- `User` · `TenantUser::casts` · `Modules/User/app/Models/TenantUser.php:70`
- `Job` · `BaseMorphPivot::casts` · `Modules/Job/app/Models/BaseMorphPivot.php:49`
- `Notify` · `BaseMorphPivot::casts` · `Modules/Notify/app/Models/BaseMorphPivot.php:49`
- `Notify` · `BasePivot::casts` · `Modules/Notify/app/Models/BasePivot.php:45`
- `Xot` · `BaseMorphPivot::casts` · `Modules/Xot/app/Models/BaseMorphPivot.php:55`
- `Xot` · `XotBaseMorphPivot::casts` · `Modules/Xot/app/Models/XotBaseMorphPivot.php:117`
- … +1 occorrenze

#### `getInfolistSchema` — 12 classi · 7 righe · ~77 righe duplicate

- `User` · `OauthAccessTokenInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Schemas/OauthAccessTokenInfolist.php:14`
- `User` · `OauthAuthCodeInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAuthCodeResource/Schemas/OauthAuthCodeInfolist.php:14`
- `User` · `OauthClientInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource/Schemas/OauthClientInfolist.php:14`
- `User` · `OauthDeviceCodeInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthDeviceCodeResource/Schemas/OauthDeviceCodeInfolist.php:14`
- `User` · `OauthPersonalAccessClientInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthPersonalAccessClientResource/Schemas/OauthPersonalAccessClientInfolist.php:14`
- `User` · `OauthRefreshTokenInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthRefreshTokenResource/Schemas/OauthRefreshTokenInfolist.php:14`
- … +6 occorrenze

#### `getFormSchema` — 2 classi · 58 righe · ~58 righe duplicate

- `User` · `TenantResource::getFormSchema` · `Modules/User/app/Filament/Resources/TenantResource.php:44`
- `User` · `TenantForm::getFormSchema` · `Modules/User/app/Filament/Resources/TenantResource/Schemas/TenantForm.php:19`

#### `schema` — 4 classi · 19 righe · ~57 righe duplicate

- `User` · `Alignment::schema` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php:55`
- `User` · `Background::schema` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php:48`
- `User` · `CustomCss::schema` · `Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php:40`
- `User` · `Favicon::schema` · `Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php:40`

#### `getFormSchema` — 3 classi · 23 righe · ~46 righe duplicate

- `User` · `OauthClientResource::getFormSchema` · `Modules/User/app/Filament/Resources/OauthClientResource.php:30`
- `User` · `ClientForm::getFormSchema` · `Modules/User/app/Filament/Resources/OauthClientResource/Schemas/ClientForm.php:17`
- `User` · `OauthClientForm::getFormSchema` · `Modules/User/app/Filament/Resources/OauthClientResource/Schemas/OauthClientForm.php:17`

#### `getFormSchema` — 2 classi · 43 righe · ~43 righe duplicate

- `User` · `AuthenticationLogResource::getFormSchema` · `Modules/User/app/Filament/Resources/AuthenticationLogResource.php:35`
- `User` · `AuthenticationLogForm::getFormSchema` · `Modules/User/app/Filament/Resources/AuthenticationLogResource/Schemas/AuthenticationLogForm.php:21`

_… +43 gruppi in questa categoria (vedi JSON)_

### M — Layer database (migrations/factories/seeders)

#### `run` — 2 classi · 65 righe · ~65 righe duplicate

- `User` · `PermissionSeeder::run` · `Modules/User/database/seeders/PermissionSeeder.php:14`
- `User` · `PermissionsSeeder::run` · `Modules/User/database/seeders/PermissionsSeeder.php:16`

#### `definition` — 2 classi · 12 righe · ~12 righe duplicate

- `User` · `PermissionRoleFactory::definition` · `Modules/User/database/factories/PermissionRoleFactory.php:36`
- `User` · `RoleHasPermissionFactory::definition` · `Modules/User/database/factories/RoleHasPermissionFactory.php:24`

#### `revoked` — 3 classi · 5 righe · ~10 righe duplicate

- `User` · `OauthAccessTokenFactory::revoked` · `Modules/User/database/factories/OauthAccessTokenFactory.php:50`
- `User` · `OauthClientFactory::revoked` · `Modules/User/database/factories/OauthClientFactory.php:85`
- `User` · `OauthTokenFactory::revoked` · `Modules/User/database/factories/OauthTokenFactory.php:55`

#### `forUser` — 3 classi · 5 righe · ~10 righe duplicate

- `User` · `OauthAccessTokenFactory::forUser` · `Modules/User/database/factories/OauthAccessTokenFactory.php:71`
- `User` · `OauthClientFactory::forUser` · `Modules/User/database/factories/OauthClientFactory.php:105`
- `User` · `OauthTokenFactory::forUser` · `Modules/User/database/factories/OauthTokenFactory.php:96`

#### `withScopes` — 3 classi · 5 righe · ~10 righe duplicate

- `User` · `OauthAccessTokenFactory::withScopes` · `Modules/User/database/factories/OauthAccessTokenFactory.php:93`
- `User` · `OauthClientFactory::withScopes` · `Modules/User/database/factories/OauthClientFactory.php:127`
- `User` · `OauthTokenFactory::withScopes` · `Modules/User/database/factories/OauthTokenFactory.php:118`

#### `forClient` — 2 classi · 5 righe · ~5 righe duplicate

- `User` · `OauthAccessTokenFactory::forClient` · `Modules/User/database/factories/OauthAccessTokenFactory.php:81`
- `User` · `OauthTokenFactory::forClient` · `Modules/User/database/factories/OauthTokenFactory.php:106`

#### `active` / `notRevoked` — 2 classi · 5 righe · ~5 righe duplicate

- `User` · `OauthClientFactory::active` · `Modules/User/database/factories/OauthClientFactory.php:95`
- `User` · `OauthTokenFactory::notRevoked` · `Modules/User/database/factories/OauthTokenFactory.php:65`

#### `run` — 2 classi · 3 righe · ~3 righe duplicate

- `User` · `NotificationSeeder::run` · `Modules/User/database/seeders/NotificationSeeder.php:12`
- `Notify` · `NotificationSeeder::run` · `Modules/Notify/database/seeders/NotificationSeeder.php:12`

#### `run` — 2 classi · 3 righe · ~3 righe duplicate

- `User` · `TenantSeeder::run` · `Modules/User/database/seeders/TenantSeeder.php:12`
- `Tenant` · `TenantSeeder::run` · `Modules/Tenant/database/Seeders/TenantSeeder.php:12`
- `Tenant` · `TenantSeeder::run` · `Modules/Tenant/database/seeders/TenantSeeder.php:12`

#### `revoked` — 2 classi · 3 righe · ~3 righe duplicate

- `User` · `OauthAuthCodeFactory::revoked` · `Modules/User/database/factories/OauthAuthCodeFactory.php:43`
- `User` · `OauthRefreshTokenFactory::revoked` · `Modules/User/database/factories/OauthRefreshTokenFactory.php:50`

_… +2 gruppi in questa categoria (vedi JSON)_

### S — Stub banali (≤30 char) — rumore, non debito

22 gruppi — elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```
