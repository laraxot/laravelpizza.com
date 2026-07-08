---
module: User
topic: METODI_DUPLICATI_ANALISI
tags: [metodi-duplicati, refactoring]
canonical: ../../../Themes/One/docs/shared-components/METODI_DUPLICATI_ANALISI.md
---

# Metodi Duplicati — Analisi User

Elenco dei metodi duplicati (cross-file e cross-modulo) che coinvolgono il modulo **User**, estratti dal report globale generato da `/tmp/metodi_duplicati_domain_report.md`.

## Metodo: `via` (14 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in User:**

- `./laravel/Modules/User/app/Notifications/Auth/Otp.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getUser` (14 occorrenze)

**Moduli coinvolti:** Notify, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/MyProfilePage.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFormActions` (14 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Pdnd, Ptv, Sigma, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/Auth/PasswordExpired.php`
- `./laravel/Modules/User/app/Filament/Pages/MyProfilePage.php`
- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/PasswordExpiredWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `before` (14 occorrenze)

**Moduli coinvolti:** Activity, Gdpr, Job, Lang, Media, Performance, Progressioni, Setting, Sigma, Tenant, UI, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/Policies/UserPermissionBasePolicy.php`

[Riflessione: Presente in 13 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `__invoke` (14 occorrenze)

**Moduli coinvolti:** Media, User

**File in User:**

- `./laravel/Modules/User/app/Http/Controllers/Api/GetLoggedUserController.php`
- `./laravel/Modules/User/app/Http/Controllers/Api/LoginController.php`
- `./laravel/Modules/User/app/Http/Controllers/Api/LogoutController.php`
- `./laravel/Modules/User/app/Http/Controllers/Api/RegisterController.php`
- `./laravel/Modules/User/app/Http/Controllers/Auth/EmailVerificationController.php`
- `./laravel/Modules/User/app/Http/Controllers/Auth/LogoutController.php`
- `./laravel/Modules/User/app/Http/Controllers/Auth/VerifyEmailController.php`
- `./laravel/Modules/User/app/Http/Controllers/Socialite/ProcessCallbackController.php`
- `./laravel/Modules/User/app/Http/Controllers/Socialite/RedirectToProviderController.php`
- `./laravel/Modules/User/app/Http/Controllers/UpgradeController.php`
- `./laravel/Modules/User/app/Http/Volt/LogoutAction.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getWidgets` (13 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, Job, Ptv, Sigma, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/Dashboard.php`
- `./laravel/Modules/User/app/Filament/Resources/BaseUserResource.php`
- `./laravel/Modules/User/app/Filament/Resources/UserResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModel` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Media, Notify, Ptv, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `./laravel/Modules/User/app/Filament/Resources/ClientResource.php`
- `./laravel/Modules/User/app/Filament/Resources/TeamResource.php`
- `./laravel/Modules/User/app/Filament/Resources/TenantResource.php`
- `./laravel/Modules/User/app/Filament/Resources/UserResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHeaderWidgets` (13 occorrenze)

**Moduli coinvolti:** Job, Media, Notify, Ptv, UI, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/UserResource/Pages/BaseListUsers.php`
- `./laravel/Modules/User/app/Filament/Resources/UserResource/Pages/ListUsers.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `form` (13 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Ptv, Sigma, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/SocialiteProviderSettingsPage.php`
- `./laravel/Modules/User/app/Http/Livewire/Auth/Login.php`
- `./laravel/Modules/User/app/Http/Livewire/Auth/Register.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `active` (13 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in User:**

- `./laravel/Modules/User/database/factories/OauthAccessTokenFactory.php`
- `./laravel/Modules/User/database/factories/OauthClientFactory.php`
- `./laravel/Modules/User/database/factories/UserFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getRows` (11 occorrenze)

**Moduli coinvolti:** Lang, Setting, Sigma, Tenant, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/SocialProvider.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNavigationLabel` (11 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/CreateOauthAccessToken.php`
- `./laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/EditOauthAccessToken.php`
- `./laravel/Modules/User/app/Filament/Resources/OauthAccessTokenResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `user` (10 occorrenze)

**Moduli coinvolti:** Activity, Job, Rating, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/BaseTeamUser.php`
- `./laravel/Modules/User/app/Models/DeviceUser.php`
- `./laravel/Modules/User/app/Models/SocialiteUser.php`
- `./laravel/Modules/User/app/Models/TeamPermission.php`
- `./laravel/Modules/User/app/Models/Traits/IsProfileTrait.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `toMail` (10 occorrenze)

**Moduli coinvolti:** Job, Notify, Progressioni, Ptv, User

**File in User:**

- `./laravel/Modules/User/app/Notifications/Auth/Otp.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `getType` (10 occorrenze)

**Moduli coinvolti:** Performance, Seo, UI, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/UsersChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `validate` (9 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, Pdnd, Progressioni, UI, User

**File in User:**

- `./laravel/Modules/User/app/Rules/CheckOtpExpiredRule.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `inactive` (9 occorrenze)

**Moduli coinvolti:** DbForge, Setting, Tenant, UI, User, Xot

**File in User:**

- `./laravel/Modules/User/database/factories/UserFactory.php`

[Riflessione: Presente in 6 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `handleRecordUpdate` (8 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Logo.php`
- `./laravel/Modules/User/app/Filament/Pages/MyProfilePage.php`
- `./laravel/Modules/User/app/Filament/Pages/Password.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `getHeading` (8 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/MyProfilePage.php`
- `./laravel/Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/UsersChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getData` (8 occorrenze)

**Moduli coinvolti:** Lang, UI, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/UserTypeRegistrationsChartWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/UsersChartWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `authenticate` (8 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, IndennitaResponsabilita, Performance, Progressioni, Sigma, User

**File in User:**

- `./laravel/Modules/User/app/Http/Livewire/Auth/Login.php`
- `./laravel/Modules/User/resources/views/pages/auth/login.blade.php`

[Riflessione: Presente in 7 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `users` (7 occorrenze)

**Moduli coinvolti:** Tenant, User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`
- `./laravel/Modules/User/app/Models/BaseTenant.php`
- `./laravel/Modules/User/app/Models/Device.php`
- `./laravel/Modules/User/app/Models/SsoProvider.php`
- `./laravel/Modules/User/app/Models/Traits/IsTenant.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `error` (7 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, User, Xot

**File in User:**

- `./laravel/Modules/User/database/seeders/UserMassSeeder.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `canView` (7 occorrenze)

**Moduli coinvolti:** Gdpr, Lang, UI, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `updateData` (6 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php`
- `./laravel/Modules/User/app/Filament/Pages/Password.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `removeTeamMember` (6 occorrenze)

**Moduli coinvolti:** Job, User

**File in User:**

- `./laravel/Modules/User/app/Models/Policies/RolePolicy.php`
- `./laravel/Modules/User/app/Models/Policies/TeamPolicy.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getUpdateFormActions` (6 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Alignment.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Background.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Colors.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/CustomCss.php`
- `./laravel/Modules/User/app/Filament/Clusters/Appearance/Pages/Favicon.php`
- `./laravel/Modules/User/app/Filament/Pages/Password.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPluralModelLabel` (6 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/PermissionResource/RelationManager/RoleRelationManager.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFormModel` (6 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/EditUserWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LoginWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `destroy` (6 occorrenze)

**Moduli coinvolti:** Job, Performance, Progressioni, Sigma, User

**File in User:**

- `./laravel/Modules/User/app/Http/Livewire/Profile/DeleteAccount.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `broadcastOn` (6 occorrenze)

**Moduli coinvolti:** IndennitaResponsabilita, Job, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Events/NewPasswordSet.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `booted` (6 occorrenze)

**Moduli coinvolti:** Gdpr, Incentivi, Sigma, User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseProfile.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `afterSave` (6 occorrenze)

**Moduli coinvolti:** Incentivi, Lang, Setting, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/RoleResource/Pages/EditRole.php`

[Riflessione: Presente in 5 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `addTeamMember` (6 occorrenze)

**Moduli coinvolti:** Job, User

**File in User:**

- `./laravel/Modules/User/app/Models/Policies/RolePolicy.php`
- `./laravel/Modules/User/app/Models/Policies/TeamPolicy.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updateTeamMember` (5 occorrenze)

**Moduli coinvolti:** Job, User

**File in User:**

- `./laravel/Modules/User/app/Models/Policies/RolePolicy.php`
- `./laravel/Modules/User/app/Models/Policies/TeamPolicy.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `teams` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Profile.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `switchTeam` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Http/Livewire/Team/Change.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `submit` (5 occorrenze)

**Moduli coinvolti:** Gdpr, IndennitaResponsabilita, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/RegisterWidget.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `revoked` (5 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/factories/OauthAccessTokenFactory.php`
- `./laravel/Modules/User/database/factories/OauthAuthCodeFactory.php`
- `./laravel/Modules/User/database/factories/OauthClientFactory.php`
- `./laravel/Modules/User/database/factories/OauthRefreshTokenFactory.php`
- `./laravel/Modules/User/database/factories/OauthTokenFactory.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `resetPassword` (5 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/Auth/PasswordExpired.php`
- `./laravel/Modules/User/app/Filament/Widgets/Auth/ResetPasswordWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/PasswordExpiredWidget.php`
- `./laravel/Modules/User/app/Http/Livewire/Auth/Passwords/Reset.php`
- `./laravel/Modules/User/resources/views/pages/auth/password/[token].blade.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `profile` (5 occorrenze)

**Moduli coinvolti:** Rating, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`
- `./laravel/Modules/User/app/Models/DeviceUser.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `mutateFormDataBeforeSave` (5 occorrenze)

**Moduli coinvolti:** Lang, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/RoleResource/Pages/EditRole.php`
- `./laravel/Modules/User/app/Filament/Resources/UserResource/Pages/BaseEditUser.php`
- `./laravel/Modules/User/app/Filament/Resources/UserResource/Pages/EditUser.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `logout` (5 occorrenze)

**Moduli coinvolti:** Activity, User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/UserDropdown.php`
- `./laravel/Modules/User/app/Livewire/Logout.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `isValid` (5 occorrenze)

**Moduli coinvolti:** Pdnd, User

**File in User:**

- `./laravel/Modules/User/app/Datas/DeviceData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `isSuperAdmin` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`
- `./laravel/Modules/User/app/Models/Traits/IsProfileTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getStats` (5 occorrenze)

**Moduli coinvolti:** Rating, UI, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Widgets/PassportStatsWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getRedirectUrl` (5 occorrenze)

**Moduli coinvolti:** Incentivi, Setting, User

**File in User:**

- `./laravel/Modules/User/app/Http/Livewire/Auth/Login.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModelLabel` (5 occorrenze)

**Moduli coinvolti:** Incentivi, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/OauthAccessTokenResource.php`
- `./laravel/Modules/User/app/Filament/Resources/PermissionResource/RelationManager/RoleRelationManager.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFormFill` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/EditUserWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LoginWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getConnectionName` (5 occorrenze)

**Moduli coinvolti:** MobilitaVolontaria, Tenant, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/Extra.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `forUser` (5 occorrenze)

**Moduli coinvolti:** Notify, User

**File in User:**

- `./laravel/Modules/User/database/factories/MembershipFactory.php`
- `./laravel/Modules/User/database/factories/OauthAccessTokenFactory.php`
- `./laravel/Modules/User/database/factories/OauthClientFactory.php`
- `./laravel/Modules/User/database/factories/OauthTokenFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `canAccessSocialite` (5 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/BaseUser.php`
- `./laravel/Modules/User/app/Models/Traits/HasSocialite.php`
- `./laravel/Modules/User/app/Models/User.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `token` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/PassportHasApiTokensContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `team` (4 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseTeamUser.php`
- `./laravel/Modules/User/app/Models/Role.php`
- `./laravel/Modules/User/app/Models/TeamInvitation.php`
- `./laravel/Modules/User/app/Models/TeamPermission.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `roles` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasRoles.php`
- `./laravel/Modules/User/app/Models/Traits/HasSpatiePermission.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `ownsTeam` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `mutateFormDataBeforeCreate` (4 occorrenze)

**Moduli coinvolti:** IndennitaCondizioniLavoro, User

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/BaseProfileResource/Pages/CreateProfile.php`
- `./laravel/Modules/User/app/Filament/Resources/RoleResource/Pages/CreateRole.php`
- `./laravel/Modules/User/app/Filament/Resources/TeamResource/Pages/CreateTeam.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `message` (4 occorrenze)

**Moduli coinvolti:** Media, Performance, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Rules/CheckOtpExpiredRule.php`

[Riflessione: Presente in 4 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `hasTeamPermission` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasRole` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/UserContract.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getTable` (4 occorrenze)

**Moduli coinvolti:** Job, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/PermissionRole.php`
- `./laravel/Modules/User/app/Models/Role.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getSubheading` (4 occorrenze)

**Moduli coinvolti:** Notify, Ptv, Sigma, User

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/MyProfilePage.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getSlugOptions` (4 occorrenze)

**Moduli coinvolti:** Lang, Notify, Rating, User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseTenant.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getNavigationIcon` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/CreateOauthAccessToken.php`
- `./laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Pages/EditOauthAccessToken.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getModules` (4 occorrenze)

**Moduli coinvolti:** Lang, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/Traits/HasModules.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFullNameAttribute` (4 occorrenze)

**Moduli coinvolti:** Incentivi, Sigma, User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`
- `./laravel/Modules/User/app/Models/Traits/IsProfileTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `createToken` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/PassportHasApiTokensContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `check` (4 occorrenze)

**Moduli coinvolti:** Performance, Progressioni, User

**File in User:**

- `./laravel/Modules/User/app/Actions/Otp/Hasher.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `belongsToTeam` (4 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `withScopes` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/factories/OauthAccessTokenFactory.php`
- `./laravel/Modules/User/database/factories/OauthClientFactory.php`
- `./laravel/Modules/User/database/factories/OauthTokenFactory.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `toggleSuperAdmin` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Http/Livewire/Profile/SuperAdmin.php`
- `./laravel/Modules/User/app/Models/Traits/IsProfileTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `tenant` (3 occorrenze)

**Moduli coinvolti:** Tenant, User

**File in User:**

- `./laravel/Modules/User/app/Models/Traits/InteractsWithTenant.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `tenants` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTenants.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `teamRole` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsAndUserContract.php`
- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `teamPermissions` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `socialiteUsers` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/BaseUser.php`
- `./laravel/Modules/User/app/Models/Traits/HasSocialite.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `sendResetPasswordLink` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/PasswordResetWidget.php`
- `./laravel/Modules/User/app/Http/Livewire/Auth/Passwords/Email.php`
- `./laravel/Modules/User/resources/views/pages/auth/password/reset.blade.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `scopeWithExtraAttributes` (3 occorrenze)

**Moduli coinvolti:** Rating, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/Profile.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `personalTeam` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `permissions` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Models/Role.php`
- `./laravel/Modules/User/app/Models/Team.php`
- `./laravel/Modules/User/app/Models/Traits/HasSpatiePermission.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `owner` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `ownedTeams` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `normalizeFormSchema` (3 occorrenze)

**Moduli coinvolti:** UI, User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/EditUserWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/RegistrationWidget.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `members` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`
- `./laravel/Modules/User/app/Models/BaseTenant.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `login` (3 occorrenze)

**Moduli coinvolti:** Activity, Notify, User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LoginWidget.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `isResourceFormComponentsEnabled` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `./laravel/Modules/User/app/Filament/Resources/ClientResource.php`
- `./laravel/Modules/User/app/Filament/Resources/ClientResource/Schemas/ClientForm.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `info` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/seeders/UserMassSeeder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `hasCombinedRelationManagerTabsWithContent` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/BaseUserResource.php`
- `./laravel/Modules/User/app/Filament/Resources/UserResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getResourceFormComponents` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `./laravel/Modules/User/app/Filament/Resources/ClientResource.php`
- `./laravel/Modules/User/app/Filament/Resources/ClientResource/Schemas/ClientForm.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFacadeAccessor` (3 occorrenze)

**Moduli coinvolti:** Seo, User, Xot

**File in User:**

- `./laravel/Modules/User/app/Facades/FilamentShield.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `extendTableCallback` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/OauthAuthCodeResource.php`
- `./laravel/Modules/User/app/Filament/Resources/OauthRefreshTokenResource.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `expired` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/factories/OauthAuthCodeFactory.php`
- `./laravel/Modules/User/database/factories/OauthRefreshTokenFactory.php`
- `./laravel/Modules/User/database/factories/OauthTokenFactory.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `devices` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`
- `./laravel/Modules/User/app/Models/Traits/HasDevices.php`
- `./laravel/Modules/User/app/Models/Traits/IsProfileTrait.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `currentTeam` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `created` (3 occorrenze)

**Moduli coinvolti:** Activity, Job, User

**File in User:**

- `./laravel/Modules/User/app/Observers/UserObserver.php`

[Riflessione: Presente in 3 moduli diversi — forte candidato per refactoring in trait/modulo Xot o helper condiviso]

---

## Metodo: `clients` (3 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/PassportHasApiTokensContract.php`
- `./laravel/Modules/User/app/Models/BaseUser.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `authentications` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasAuthentications.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasAuthenticationLogTrait.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `allTeams` (3 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `withAccessToken` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/PassportHasApiTokensContract.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `validateForPassportPasswordGrant` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `userHasPermission` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `updateUser` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/EditUserWidget.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `updateProfile` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/MyProfilePage.php`
- `./laravel/Modules/User/resources/views/pages/profile/edit.blade.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `updatePassword` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/MyProfilePage.php`
- `./laravel/Modules/User/resources/views/pages/profile/edit.blade.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `unverified` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/factories/UserFactory.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `tokens` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/PassportHasApiTokensContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `tokenCan` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/PassportHasApiTokensContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `teamUsers` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseTeam.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `teamInvitations` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `resetForm` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/PasswordResetConfirmWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/Auth/PasswordResetWidget.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `resend` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Http/Livewire/Auth/Verify.php`
- `./laravel/Modules/User/resources/views/pages/auth/verify.blade.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `replaceRecoveryCode` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TwoFactorAuthenticatableContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `removeUser` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `removeRole` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Contracts/UserContract.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `registerPolicies` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Providers/PassportServiceProvider.php`
- `./laravel/Modules/User/app/Providers/UserServiceProvider.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `redirectAfterLogout` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `recoveryCodes` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TwoFactorAuthenticatableContract.php`
- `./laravel/Modules/User/app/Contracts/UserContract.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `purge` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `performLogout` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `notifications` (2 occorrenze)

**Moduli coinvolti:** Notify, User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `logLogoutSuccess` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `latestAuthentication` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`
- `./laravel/Modules/User/app/Models/Traits/HasAuthenticationLogTrait.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `isCurrentTeam` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasUser` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasUserWithEmail` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasTeamRole` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `hasLogo` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/Auth/PasswordExpired.php`
- `./laravel/Modules/User/app/Filament/Widgets/PasswordExpiredWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `handleRegistration` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/Tenancy/RegisterTeam.php`
- `./laravel/Modules/User/app/Filament/Pages/Tenancy/RegisterTenant.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `handleCommandStarted` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `handleCommandOutput` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `handleCommandFailed` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `handleCommandError` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `getResourceSlug` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Support/Utils.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getResetPasswordFormAction` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/Auth/PasswordExpired.php`
- `./laravel/Modules/User/app/Filament/Widgets/PasswordExpiredWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getProviderField` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`
- `./laravel/Modules/User/app/Models/Traits/HasSocialite.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getPluralLabel` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Resources/OauthAccessTokenResource.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getMobileDeviceTokens` (2 occorrenze)

**Moduli coinvolti:** Notify, User

**File in User:**

- `./laravel/Modules/User/app/Models/Traits/IsProfileTrait.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getLogoutAction` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getLocalizedHomeUrl` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getKey` (2 occorrenze)

**Moduli coinvolti:** Notify, User

**File in User:**

- `./laravel/Modules/User/app/Contracts/UserContract.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getHelperText` (2 occorrenze)

**Moduli coinvolti:** UI, User

**File in User:**

- `./laravel/Modules/User/app/Datas/PasswordData.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getFilamentAvatarUrl` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasProfilePhotoContract.php`
- `./laravel/Modules/User/app/Models/BaseTenant.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCurrentPasswordFormComponent` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Pages/Auth/PasswordExpired.php`
- `./laravel/Modules/User/app/Filament/Widgets/PasswordExpiredWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getConsoleCommand` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/seeders/RolesSeeder.php`
- `./laravel/Modules/User/database/seeders/UserMassSeeder.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getCancelAction` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `getAvatarUrl` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/BaseProfile.php`

[Riflessione: Metodo getter/setter — possibile trait o interfaccia condivisa]

---

## Metodo: `forRole` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/factories/PermissionRoleFactory.php`
- `./laravel/Modules/User/database/factories/RoleHasPermissionFactory.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `forPermission` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/factories/PermissionRoleFactory.php`
- `./laravel/Modules/User/database/factories/RoleHasPermissionFactory.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `forClient` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/database/factories/OauthAccessTokenFactory.php`
- `./laravel/Modules/User/database/factories/OauthTokenFactory.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `findForPassport` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/BaseUser.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `executeCommand` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Filament/Clusters/Passport/Pages/PassportDashboard.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `displaySummary` (2 occorrenze)

**Moduli coinvolti:** Activity, User

**File in User:**

- `./laravel/Modules/User/database/seeders/UserMassSeeder.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `dispatchPreLogoutEvent` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `dispatchPostLogoutEvent` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Filament/Widgets/Auth/LogoutWidget.php`
- `./laravel/Modules/User/app/Filament/Widgets/LogoutWidget.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `confirm` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Http/Livewire/Auth/Passwords/Confirm.php`
- `./laravel/Modules/User/resources/views/pages/auth/password/confirm.blade.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `configureScopes` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Providers/PassportServiceProvider.php`
- `./laravel/Modules/User/app/Providers/Traits/HasPassportConfiguration.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `configureRoutes` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Providers/PassportServiceProvider.php`
- `./laravel/Modules/User/app/Providers/Traits/HasPassportConfiguration.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `configureModels` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Providers/PassportServiceProvider.php`
- `./laravel/Modules/User/app/Providers/Traits/HasPassportConfiguration.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `canUpdateTeamMember` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsAndUserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `canRemoveTeamMember` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/HasTeamsAndUserContract.php`
- `./laravel/Modules/User/app/Models/Traits/HasTeams.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `broker` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Http/Livewire/Auth/Passwords/Email.php`
- `./laravel/Modules/User/app/Http/Livewire/Auth/Passwords/Reset.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `avatar` (2 occorrenze)

**Moduli coinvolti:** User, Xot

**File in User:**

- `./laravel/Modules/User/app/Models/Traits/IsProfileTrait.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Metodo: `authenticatable` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Models/Authentication.php`
- `./laravel/Modules/User/app/Models/AuthenticationLog.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `allUsers` (2 occorrenze)

**Moduli coinvolti:** User

**File in User:**

- `./laravel/Modules/User/app/Contracts/TeamContract.php`
- `./laravel/Modules/User/app/Models/BaseTeam.php`

[Riflessione: Duplicato interno al modulo User — valutare estrazione in trait di modulo o classe base]

---

## Metodo: `add` (2 occorrenze)

**Moduli coinvolti:** Ptv, User

**File in User:**

- `./laravel/Modules/User/app/Contracts/AddsTeamMembers.php`

[Riflessione: Presente in 2 moduli — valutare se la logica è identica (refactoring) o volutamente diversa (override)]

---

## Riflessioni per User

- **Totale metodi duplicati che coinvolgono User:** 165
- **Di cui cross-modulo:** 97
- **Di cui interni al modulo:** 68

### Pattern di riflessione

- **refactoring in trait/classe base/helper:** 126 metodi
- **altro:** 39 metodi

### Moduli con maggiori duplicazioni incrociate

- **Xot:** 119 metodi in comune
- **Notify:** 37 metodi in comune
- **Job:** 26 metodi in comune
- **Tenant:** 19 metodi in comune
- **Ptv:** 13 metodi in comune
- **UI:** 12 metodi in comune
- **Sigma:** 10 metodi in comune
- **Pdnd:** 9 metodi in comune
- **Performance:** 9 metodi in comune
- **IndennitaResponsabilita:** 8 metodi in comune

---
_Report generato automaticamente — fonte: `/tmp/metodi_duplicati_domain_report.md`_
