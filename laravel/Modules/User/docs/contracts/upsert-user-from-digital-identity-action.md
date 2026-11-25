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
Trova o crea l'utente che ha fatto accesso con SPID o CIE e ne aggiorna i dati d'identità. Dati personali: codice fiscale, nome, cognome, email. Codice: `app/Actions/Auth/UpsertUserFromDigitalIdentityAction.php:81-168`.

## Input

- `string $authMethod`: solo `spid` o `cie` (`HasVerifiedIdentityAction::TRUSTED_IDENTITY_METHODS`).
- `array $attributes`: chiavi usate `fiscal_code`, `name`, `surname`, `email`.
- `bool $emailVerified`: se l'IdP ha verificato l'email.
- `?string $identityProvider`: se assente vale il metodo.

## Output

- Un modello utente (`UserContract&Model`), creato o aggiornato e salvato.

## Invarianti

| ID | Regola | Prova nel codice | Test esistente (senza group) |
|---|---|---|---|
| `USER-IDENT-INV-1` | Metodi diversi da `spid`/`cie` sono rifiutati. | riga 91 | `tests/Feature/Auth/DigitalIdentityUserUpsertTest.php:94` |
| `USER-IDENT-INV-2` | Il codice fiscale è normalizzato (trim, maiuscolo, prefisso `TINIT-` tolto) e deve rispettare `^[A-Z0-9]{11,16}$`. | righe 148-157 | `tests/Feature/Auth/DigitalIdentityUserUpsertTest.php:86` |
| `USER-IDENT-INV-3` | L'utente si cerca per `fiscal_code`; solo se assente, per email **verificata** dall'IdP. Un'email non verificata non collega mai un account esistente. | righe 97-105 | `tests/Feature/Auth/DigitalIdentityUserUpsertTest.php:66,75` |
| `USER-IDENT-INV-4` | Senza email verificata un nuovo utente riceve `<metodo>.<cf minuscolo>@noemail.local` con `email_verified_at` null; con email verificata `email_verified_at` è valorizzato. | righe 132-135 | `tests/Feature/Auth/DigitalIdentityUserUpsertTest.php:36,53` |
| `USER-IDENT-INV-5` | Su un utente esistente l'email cambia solo se l'IdP ne fornisce una verificata diversa dall'attuale o se l'attuale non risulta verificata. | righe 124-130 | `tests/Feature/Auth/DigitalIdentityUserUpsertTest.php:75` |

## Effetti collaterali

Un solo `forceFill(...)->save()` sulla tabella utenti (riga 131 o 137), con `auth_method`, `identity_provider`, `fiscal_code`, `last_login_at = now()` e, se presenti, `first_name`, `last_name`, `name`. Nessuna transazione esplicita; gli eventi Eloquent e gli observer del modello utente scattano come per ogni `save()` (non verificato quali). Nessuna coda, nessuna email.

## Errori

- `InvalidArgumentException` (Webmozart Assert) per metodo non ammesso, codice fiscale assente o malformato (righe 91, 150, 155).

## Non fa

- Non assegna ruoli o permessi.
- Non rende "verificata" l'email segnaposto: l'identità è garantita da `HasVerifiedIdentityAction`, non da `email_verified_at`.
- Non conserva dati oltre quelli elencati (docblock, riga 79).
- Marker `@contract` e `@see` presenti nel docblock della classe.
- Dubbio da verificare: la riga 51 scrive sempre `fiscal_code` anche quando l'utente è stato trovato per email verificata; un account esistente con un altro codice fiscale verrebbe riassegnato.
