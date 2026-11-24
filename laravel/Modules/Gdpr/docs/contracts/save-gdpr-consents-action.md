---
title: "Contratto — SaveGdprConsentsAction"
type: contract
action: "Modules\Gdpr\Actions\SaveGdprConsentsAction"
tags: [contract, action, gdpr, consenso]
created: 2026-11-18
updated: 2026-11-24
---

# SaveGdprConsentsAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveGdprConsentsAction.php`. Perché le righe non si sovrascrivono mai:
[ADR prova del consenso](../adr/consent-proof-is-append-only.md).

## Input

- L'utente registrato (`Modules\User\Models\User`: si leggono solo `id` e classe).
- Le scelte `privacy_accepted`, `terms_accepted`, `marketing_consent` (chiave assente = rifiutato).
- IP e user agent; se mancano, quelli della richiesta corrente.

Chiamata da `Filament/Widgets/Auth/RegisterWidget.php` e `GdprConsentForm.php` (tramite `CollectGdprConsentsAction`) e da
`UpdateGdprConsentsAction`, che delega qui.

## Output

- Nessuno (`void`).

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| GDPR-SAVE-INV-1 | Una riga di `consents` per ognuno dei tre trattamenti (`privacy_policy`, `terms_conditions`, `marketing_consent`), accettato o rifiutato. | `GDPR-SAVE-INV-1` |
| GDPR-SAVE-INV-2 | Ogni riga porta `metadata.document_version` mai vuota, `metadata.locale`, `ip_address` e `user_agent`. | `GDPR-SAVE-INV-2` |
| GDPR-SAVE-INV-3 | `accepted_at` valorizzato solo se la scelta è vera; un rifiuto resta una riga con `accepted_at` nullo. | `GDPR-SAVE-INV-3` |
| GDPR-SAVE-INV-4 | Un trattamento mancante si crea (`TREATMENT_DEFAULTS`) e uno senza versione riceve `1.0`: la prova non si salta mai. | `GDPR-SAVE-INV-4` |
| GDPR-SAVE-INV-5 | Solo INSERT: una seconda chiamata aggiunge righe, non aggiorna le precedenti. | `GDPR-SAVE-INV-5` |

Test: `tests/Unit/Actions/SaveGdprConsentsActionTest.php` (intercetta gli INSERT su `consents` con l'evento `creating`).

## Effetti collaterali

- `Treatment::firstOrCreate` per i tre trattamenti; `forceFill(['documentVersion' => '1.0'])->save()` sul trattamento senza versione.
- `Consent::create` per ogni trattamento (`created_by`/`updated_by` = id dell'utente).
- Una riga `Log::debug` con id utente, IP e scelte.

## Errori

- Le eccezioni del database arrivano al chiamante: la registrazione deve fallire, non riuscire senza prova.
- Nessuna validazione: input mancanti diventano rifiuti, non errori.

## Non fa

- Non valida le scelte obbligatorie (lo fanno il form di registrazione e `ValidateGdprConsentAction`).
- Non revoca né aggiorna consensi esistenti (`Consent\RevokeGdprConsentsAction`).
- Non gestisce i sette trattamenti del listener `SaveGdprConsents`: quelli li scrive `Consent\SaveRegistrationConsentsAction`
  (che salta in silenzio i trattamenti mancanti: comportamento legacy, da non imitare).
- Non apre una transazione propria e non manda email.
