---
title: "Contratto — UpsertUserFromDigitalIdentityAction"
type: contract
action: "Modules\User\Actions\Auth\UpsertUserFromDigitalIdentityAction"
tags: [contract, action, spid, cie, identita-digitale]
created: 2026-11-24
updated: 2026-11-24
---

# UpsertUserFromDigitalIdentityAction

Sorgente: `app/Actions/Auth/UpsertUserFromDigitalIdentityAction.php`. Perché: [ADR](../adr/digital-identity-upsert-by-fiscal-code.md).

## Input

- `$authMethod`: `spid` o `cie`.
- `$attributes`: chiavi usate `fiscal_code` (obbligatoria), `name`, `surname`, `email`; le altre si ignorano.
- `$emailVerified`: se l'IdP garantisce l'email.
- `$identityProvider` (facoltativo): nome dell'IdP; default = `$authMethod`.

## Output

- Il modello utente (`XotData::make()->getUserClass()`), salvato, `UserContract&Model`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| USER-SPID-UPSERT-INV-1 | Accetta solo i metodi di `HasVerifiedIdentityAction::TRUSTED_IDENTITY_METHODS` (`spid`, `cie`). | `USER-SPID-UPSERT-INV-1` |
| USER-SPID-UPSERT-INV-2 | Il CF si normalizza (maiuscolo, senza `TINIT-`) e deve rispettare `^[A-Z0-9]{11,16}$`; altrimenti eccezione prima di ogni scrittura. | `USER-SPID-UPSERT-INV-2` |
| USER-SPID-UPSERT-INV-3 | Stesso CF = stesso utente: mai un secondo record. | — |
| USER-SPID-UPSERT-INV-4 | Un account esistente si collega per email solo se l'email è verificata dall'IdP. | — |
| USER-SPID-UPSERT-INV-5 | Un'email non verificata non viene mai salvata: il nuovo utente riceve `<metodo>.<cf>@noemail.local` con `email_verified_at` null. | — |

Le righe con «—» sono provate da `tests/Feature/Auth/DigitalIdentityUserUpsertTest.php`, che però richiede un database di
test migrato con le colonne d'identità: il group si aggiunge quando quei casi girano verdi.

## Effetti collaterali

- Insert o update su `users` (`forceFill()->save()`): `fiscal_code`, `auth_method`, `identity_provider`, `last_login_at`,
  e se presenti `first_name`, `last_name`, `name`; `email`/`email_verified_at` solo con email verificata nuova o non ancora verificata.

## Errori

- `Webmozart\Assert\InvalidArgumentException`: metodo non ammesso, CF mancante o malformato.
- Errori del database (vincolo di unicità, colonne mancanti) si propagano.

## Non fa

- Non autentica l'utente né apre la sessione: lo fa il controller del tema che la chiama.
- Non assegna ruoli o team.
- Non salva altri attributi SAML/OIDC (data di nascita, indirizzo...): minimizzazione, vedi la migrazione owner `create_users_table`.
- Non verifica la firma della risposta dell'IdP: arriva già validata.
