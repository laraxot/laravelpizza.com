---
title: "Contratto — DeleteAccountAction"
type: contract
action: "Modules\Gdpr\Actions\Account\DeleteAccountAction"
tags: [contract, action, gdpr, cancellazione, art-17]
created: 2026-11-24
updated: 2026-11-24
---

# DeleteAccountAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Account/DeleteAccountAction.php`. Perché disattiva invece di cancellare:
[ADR cancellazione dell'account](../adr/account-deletion-deactivates-and-keeps-proof.md).

## Input

- `__invoke(Request)`: rotta `account.delete` (`Route::match(['get','post'], '/{lang}/account/delete')`, `routes/web.php`), utente
  autenticato, campi `confirm` (deve valere `cancella`) e `reason` (facoltativo, max 1000).
- `execute(BaseUser $user, string $reason = '')`: uso diretto da un'altra Action del progetto ospite.

## Output

- `__invoke`: redirect a `/{locale}` (GET: senza fare nulla; POST: con flash `gdpr::account.flash.account_deleted`).
- `execute`: `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GDPR-DELETE-INV-1 | Autorizza con l'ability `deleteOwnAccount` (`BaseUserPolicy`), mai con `delete` (che è del back office). | — |
| GDPR-DELETE-INV-2 | I passi (revoca consensi, riga `account_deletion`, `deleted_at`/`deleted_by`, revoca token, activity) girano dentro `DB::connection('user')->transaction()`. | — |
| GDPR-DELETE-INV-3 | L'utente non viene cancellato fisicamente: si valorizza `deleted_at` (BaseUser non usa `SoftDeletes`). | — |
| GDPR-DELETE-INV-4 | La richiesta di cancellazione resta come riga di `consents` di tipo `account_deletion` con IP, user agent e motivo in `metadata.reason`. | — |
| GDPR-DELETE-INV-5 | Dopo il commit la sessione è chiusa e invalidata, il token CSRF rigenerato. | — |

Debito: nessun test del modulo Gdpr esercita questa Action. L'effetto a valle (un account con `deleted_at` non entra più) è
provato da `Modules/User/tests/Feature/Auth/DeletedAccountAccessTest.php`.

## Effetti collaterali

- `RevokeGdprConsentsAction` (vedi il suo contratto).
- `Treatment::firstOrCreate(['name' => 'account_deletion'])` e `Consent::updateOrCreate` (una sola riga per utente: l'unica
  eccezione alla regola "solo INSERT" dei consensi).
- `RevokeUserAccessAction` del modulo User: token Passport, refresh token, "ricordami".
- Se il modulo Activity è installato, `Activity::where('subject_id', …)->where('subject_type', …)->update(['deleted_at' => now()])`.
- `Auth::logout()`, `session()->invalidate()`, `session()->regenerateToken()`.

## Errori

- 401 senza utente autenticato; `AuthorizationException` (403) se la policy nega; `ValidationException` se `confirm` non è `cancella`.
- Eccezione nella transazione → rollback della connessione `user` (l'utente resta attivo). `Consent`/`Treatment` sono sulla
  connessione `gdpr` e `Activity` su `activity`: sono coperti dal rollback solo se puntano allo stesso database di `user`
  (difetto noto, da non imitare: una transazione per connessione non è atomica tra database diversi).

## Non fa

- Non cancella né anonimizza nome, email o altri dati personali: lo fa il progetto ospite dopo la chiamata
  (nota in `docs/account-deletion-consents-columns.md`).
- Non purga gli account cancellati dopo un periodo di conservazione.
- Non manda email di conferma.
