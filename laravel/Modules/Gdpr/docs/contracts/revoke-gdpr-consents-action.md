---
title: "Contratto — RevokeGdprConsentsAction"
type: contract
action: "Modules\Gdpr\Actions\Consent\RevokeGdprConsentsAction"
tags: [contract, action, gdpr, consenso, revoca]
created: 2026-11-24
updated: 2026-11-24
---

# RevokeGdprConsentsAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/Consent/RevokeGdprConsentsAction.php` (GDPR art. 7 par. 3).

## Input

- L'utente (`Modules\User\Models\BaseUser`).
- Implicito: l'IP della richiesta corrente e l'utente autenticato (`auth()->id()`).

## Output

- Nessuno (`void`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GDPR-REVOKE-INV-1 | Revoca = `UPDATE` di `revoked_at`, `revoked_ip_address`, `updated_by`: nessuna riga viene cancellata (traccia per l'art. 30). | — |
| GDPR-REVOKE-INV-2 | Tocca solo le righe con `revoked_at` nullo: una revoca precedente conserva data e IP originali. | — |
| GDPR-REVOKE-INV-3 | L'utente si riconosce da `user_id` + `user_type` in entrambe le forme (classe, scritta da `SaveGdprConsentsAction`; alias morph, scritto da `HasGdpr::giveConsent`). | — |
| GDPR-REVOKE-INV-4 | Scrive solo colonne che esistono in `consents` (DCP-285). | — |

Debito: le quattro righe sono provate da `tests/Unit/Actions/RevokeGdprConsentsActionTest.php`, una classe PHPUnit senza group
che oggi fallisce prima di arrivare all'Action (la tabella `users` del DB di prova condiviso non ha la colonna `state` che la
`UserFactory` scrive). Quando torna verde, convertirla in Pest e aggiungere i group.

## Effetti collaterali

- Una sola query `UPDATE consents ... WHERE user_id = ? AND user_type IN (...) AND revoked_at IS NULL`.

## Errori

- Eccezioni del database al chiamante. Un utente senza consensi non è un errore (0 righe aggiornate).

## Non fa

- Non salva lo user agent della revoca: manca la colonna `revoked_user_agent` (richiesta di schema in DCP-285).
- Non revoca un solo trattamento: revoca tutto.
- Non cancella l'utente né i suoi dati (`Account\DeleteAccountAction`).
- Non crea una riga che registri la revoca: la prova è la colonna `revoked_at` stessa.
