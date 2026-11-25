---
title: "INDEX contratti — User"
type: index
owner: User
updated: 2026-11-24
qmd: "User contract INDEX invarianti copertura pest group USER-INV"
---

# INDEX contratti — User

Registro operativo dei contratti di comportamento delle Action di autenticazione e identità. Il formato è in [README](README.md). I comandi si eseguono da `laravel/`.

Un invariante è `coperto` se esiste un test Pest con `->group('<ID>')` (verifica: `rg -n "group\('<ID>'" Modules/User/tests`). Un test che prova il comportamento ma non ha il group conta come «nessuno»: l'invariante resta senza group finché il caso non gira verde nel gate.

| Operazione | Contract | Classe | Invarianti | Group Pest | Comando | `@contract` nella classe |
|---|---|---|---|---|---|---|
| Verifica identità (email o SPID/CIE) | [has-verified-identity-action](has-verified-identity-action.md) | `Modules\User\Actions\Auth\HasVerifiedIdentityAction` | `HAS-VERIFIED-INV-1..3` | nessuno | — | sì |
| Provider utenti che esclude gli account cancellati | [build-active-user-provider-action](build-active-user-provider-action.md) | `Modules\User\Actions\Auth\BuildActiveUserProviderAction` | `USER-PROVIDER-INV-1..3` | nessuno | — | sì |
| Revoca di tutti gli accessi di un utente | [revoke-user-access-action](revoke-user-access-action.md) | `Modules\User\Actions\Auth\RevokeUserAccessAction` | `USER-REVOKE-INV-1..3` | nessuno | — | sì |
| Upsert utente da SPID/CIE | [upsert-user-from-digital-identity-action](upsert-user-from-digital-identity-action.md) | `Modules\User\Actions\Auth\UpsertUserFromDigitalIdentityAction` | `USER-SPID-UPSERT-INV-1..5` | solo -1, -2 | `vendor/bin/pest --group=USER-SPID-UPSERT-INV-1` (idem -2) | sì |
| Freno agli invii di registrazione e recupero password | [consume-auth-submission-slot-action](consume-auth-submission-slot-action.md) | `Modules\User\Actions\Auth\ConsumeAuthSubmissionSlotAction` | `USER-AUTH-THROTTLE-INV-1..4` | tutti | `vendor/bin/pest --group=USER-AUTH-THROTTLE-INV-1` (idem -2, -3, -4) | sì |
| Registro degli accessi | [record-authentication-log-action](record-authentication-log-action.md) | `Modules\User\Actions\Auth\RecordAuthenticationLogAction` | `USER-AUTHLOG-INV-1..3` | solo -1, -3 | `vendor/bin/pest --group=USER-AUTHLOG-INV-1` (idem -3) | sì |
| Invio OTP (password temporanea) | [send-otp-by-user-action](send-otp-by-user-action.md) | `Modules\User\Actions\Otp\SendOtpByUserAction` | `USER-OTP-SEND-INV-1..3` | nessuno | — | sì |
| Ruoli di default da Socialite | [set-default-roles-by-socialite-user-action](set-default-roles-by-socialite-user-action.md) | `Modules\User\Actions\Socialite\SetDefaultRolesBySocialiteUserAction` | nessun ID nel contract | nessuno | — | sì |

`HAS-VERIFIED-INV-*` e il contract di `SetDefaultRolesBySocialiteUserAction` (senza ID) non seguono ancora il formato `USER-<AREA>-INV-<N>`: da portare a quel formato prima di aggiungere i group.

## Copertura delle Action

`app/Actions` contiene 84 file `.php`; 78 hanno un contratto in questa cartella (file `*-action.md`). Senza contratto restano:

- `Filament/NormalizeFormSchemaAction.php`
- `Login/Concerns/ResolvesLoginLogQuery.php`
- `Otp/Hasher.php`
- `Socialite/ProcessCallbackSession.php`
- `Socialite/Utils/EmailDomainAnalyzer.php`
- `Socialite/Utils/UserNameFieldsResolver.php`
