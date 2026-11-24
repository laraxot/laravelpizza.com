---
title: "Glossario di dominio User"
type: glossary
owner: User
updated: 2026-11-24
qmd: "glossario User identità SPID CIE ruolo permesso team tenant token Passport OTP"
---

# Glossario di dominio User

Se glossario e codice divergono vale il codice. Percorsi relativi a `laravel/Modules/User/` salvo indicazione.

| Termine | Significato | Nel codice |
|---|---|---|
| Utente | Entità autenticabile del progetto; il contratto è `UserContract`, il modello base `BaseUser`. | `Modules/Xot/app/Contracts/UserContract.php`, `app/Models/BaseUser.php` |
| Identità verificata | Email confermata oppure accesso con SPID/CIE, anche senza email verificata. | `app/Actions/Auth/HasVerifiedIdentityAction.php` |
| Metodo di identità fidato | Valore di `users.auth_method` ammesso come prova d'identità: `spid`, `cie`. | `HasVerifiedIdentityAction::TRUSTED_IDENTITY_METHODS` |
| Codice fiscale | Chiave di riconoscimento dell'utente SPID/CIE; da SPID arriva con prefisso `TINIT-` che viene tolto. | `UpsertUserFromDigitalIdentityAction::normalizeFiscalCode()` |
| Email segnaposto | `<metodo>.<cf>@noemail.local` con `email_verified_at` null, usata se l'IdP non dà un'email verificata. | `UpsertUserFromDigitalIdentityAction::execute()` |
| Account cancellato | Utente con `deleted_at` valorizzato; escluso dall'autenticazione dal provider. | `app/Actions/Auth/BuildActiveUserProviderAction.php` |
| Revoca accessi | Chiusura di token Passport, refresh token e remember token di un utente. | `app/Actions/Auth/RevokeUserAccessAction.php` |
| Ruolo | Ruolo Spatie con guard, assegnabile all'utente. | `app/Models/Role.php` |
| Permesso | Permesso Spatie associabile a ruoli o utenti. | `app/Models/Permission.php` |
| Team | Gruppo di utenti con membership e inviti. | `app/Models/Team.php`, `app/Models/BaseTeamUser.php`, `app/Models/TeamInvitation.php` |
| Profilo | Dati anagrafici collegati all'utente. | `app/Models/Profile.php`, `app/Models/BaseProfile.php` |
| Log di autenticazione | Registro degli accessi dell'utente. | `app/Models/AuthenticationLog.php`, `app/Actions/Auth/RecordAuthenticationLogAction.php` |
| OTP | Password temporanea monouso inviata all'utente, con scadenza. | `app/Actions/Otp/SendOtpByUserAction.php` |
| Token Passport | Token OAuth di accesso e relativo refresh token. | `app/Models/OauthToken.php`, `app/Models/OauthRefreshToken.php` |
| Provider SSO | Provider di accesso esterno (Socialite) configurato per dominio email. | `app/Models/SsoProvider.php`, `app/Actions/Socialite/SetDefaultRolesBySocialiteUserAction.php` |
| Dispositivo | Dispositivo associato a utenti e profili. | `app/Models/Device.php`, `app/Models/DeviceUser.php` |
| Shield | Integrazione di configurazione dei permessi Filament. | `app/Actions/Shield/ShieldUtilsAction.php` |
