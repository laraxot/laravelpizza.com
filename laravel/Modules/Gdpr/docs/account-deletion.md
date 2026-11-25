---
title: "Cancellazione dell'account (art. 17)"
type: guide
module: Gdpr
updated: 2026-11-25
related:
  - adr/account-deletion-deactivates-and-keeps-proof.md
  - contracts/delete-account-action.md
  - contracts/revoke-gdpr-consents-action.md
---

# Cancellazione dell'account

`Modules\Gdpr\Actions\Account\DeleteAccountAction` **disattiva** l'utente e **conserva** la prova dei consensi; non cancella ne'
anonimizza nome, email o altri dati personali. Il perche' e' nell'
[ADR](adr/account-deletion-deactivates-and-keeps-proof.md), le invarianti nel [contratto](contracts/delete-account-action.md).

## Come si usa

- **Rotta storica**: `Route::match(['get','post'], '/{lang}/account/delete')`, nome `account.delete`, middleware `auth`
  (`routes/web.php`). POST con `confirm` = `cancella` e `reason` facoltativo (max 1000); risponde con redirect a `/{locale}` e
  flash `gdpr::account.flash.account_deleted`. La vista `resources/views/account/delete.blade.php` usa le chiavi
  `gdpr::account.delete.*`.
- **Uso diretto**: `DeleteAccountAction::execute(BaseUser $user, string $reason = '')` da un'Action del progetto ospite.

## Cosa fa, nell'ordine (in una transazione sulla connessione `user`)

1. autorizza con l'ability `deleteOwnAccount` (mai `delete`, che e' del back office);
2. `RevokeGdprConsentsAction`: `revoked_at`, `revoked_ip_address`, `updated_by` su tutte le righe attive;
3. registra la richiesta come riga di `consents` di tipo `account_deletion` (trattamento `account_deletion`, IP, user agent,
   motivo in `metadata.reason`): e' l'unica eccezione alla regola "solo INSERT";
4. valorizza `deleted_at` e `deleted_by` sull'utente (nessun `SoftDeletes` su `BaseUser`: non e' una cancellazione fisica);
5. `RevokeUserAccessAction` (modulo User): token Passport, refresh token, "ricordami";
6. se il modulo Activity e' installato, marca come cancellate le sue righe sul soggetto;
7. dopo il commit: logout, sessione invalidata, token CSRF rigenerato.

Un account con `deleted_at` non entra piu'; l'effetto e' provato da `Modules/User/tests/Feature/Auth/DeletedAccountAccessTest.php`.

## Cosa deve fare il progetto ospite

Se l'informativa promette la cancellazione dei dati, il progetto li **anonimizza dopo** la chiamata: l'Action da sola lascia nome
ed email. Un progetto che lo fa chiama `DeleteAccountAction::execute()` e poi anonimizza i campi personali nella propria
Action (esempio nel repository: il modulo di eventi, con test sulla pagina "Modifica il profilo"). La decisione su cosa
accade ai contenuti pubblicati dall'utente (anonimizzare l'autore o cancellare) e' del titolare: senza quella regola la
cancellazione non si implementa ([story DCP-140](stories/dcp-140-diritti-dellinteressato-procedura-e-strumenti.story.md)).

## Le colonne di revoca

`RevokeGdprConsentsAction`, `DeleteAccountAction` e il trait `HasGdpr` scrivono su `consents` le colonne `revoked_at`,
`revoked_ip_address` e `metadata`. Fino al 12/11/2026 nessuna migrazione le creava e `Consent::$fillable` non le elencava:
"elimina account" rispondeva 500 (`Unknown column 'revoked_at'`) e `updateOrCreate` scartava in silenzio i campi non fillable.
Correzione: migrazioni additive e idempotenti `2026_11_11_000001`, `2026_11_12_000001` e `2026_11_12_000002` (solo
`tableUpdate` con `hasColumn`), le tre colonne in `$fillable`, cast `accepted_at`/`revoked_at` datetime e `metadata` array.
Dopo un aggiornamento del modulo vanno lanciate le migrazioni ([database.md](database.md)).

## Non fa

Non purga gli account cancellati dopo un periodo di conservazione, non manda email di conferma, non salva lo user agent della
revoca. Nessun test del modulo esercita `DeleteAccountAction` (debito dichiarato nel contratto).
