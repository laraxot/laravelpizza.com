---
title: "Consensi e trattamenti"
type: reference
module: Gdpr
updated: 2026-11-25
related:
  - adr/consent-proof-is-append-only.md
  - contracts/README.md
---

# Consensi e trattamenti

La regola di fondo (GDPR art. 7 par. 1: il titolare deve poter **dimostrare** il consenso) e' nell'
[ADR sulla prova append-only](adr/consent-proof-is-append-only.md); il comportamento delle Action e' nei
[contratti](contracts/README.md). Qui il modello e come si usa.

## Modello dati

- **`Treatment`** (tabella `treatments`): un trattamento per cui si chiede consenso. Colonne: `name` (unico), `description`,
  `required`, `active`, `weight`, `documentVersion`, `documentUrl`. UUID, soft delete.
- **`Consent`** (tabella `consents`): una scelta di un utente su un trattamento. UUID, soft delete, `user_id` + `user_type`
  (morph: classe dell'utente), `treatment_id`, `type`, `accepted_at` (nullo = rifiuto), `ip_address`, `user_agent`,
  `metadata` (JSON: `document_version`, `locale`, motivo della cancellazione), `revoked_at`, `revoked_ip_address`,
  `created_by`, `updated_by`. Se `user_type` e' vuoto alla creazione si usa la classe utente di `XotData`.
- **`Event`** (tabella `gdpr_events`): registro di azioni su trattamenti e consensi; `ip` e `payload` si salvano cifrati
  (`Crypt`) e si decifrano nell'accessor.
- **`ConsentType`** (enum, 14 valori): marketing (email, sms, telefono), `privacy_policy`, `cookies`, `analytics`,
  `personalization`, `third_party_sharing`, `data_transfer`, `terms_and_conditions`, `age_verification`, `research`,
  `profiling`, `automated_decision_making`. Obbligatori: `privacy_policy`, `terms_and_conditions`, `age_verification`.

Schema e migrazioni: [database.md](database.md).

## Salvare, revocare, interrogare

| Cosa | Come | Note |
|---|---|---|
| Consensi della registrazione | `SaveGdprConsentsAction::execute($user, ['privacy_accepted' => bool, 'terms_accepted' => bool, 'marketing_consent' => bool], $ip, $userAgent)` | Una riga per ognuno dei tre trattamenti `privacy_policy`, `terms_conditions`, `marketing_consent`, accettato o no. Crea il trattamento mancante con versione `1.0`. Solo INSERT. |
| Aggiornare le preferenze di un utente esistente | `UpdateGdprConsentsAction::execute(...)` | Delega a `SaveGdprConsentsAction`: aggiunge righe, non modifica le precedenti. |
| Raccogliere le tre scelte in un array | `Consent\CollectGdprConsentsAction::execute($privacy, $terms, $marketing)` | Solo mappa i booleani nelle chiavi attese. |
| Validare i due consensi obbligatori | `Validation\ValidateGdprConsentAction::execute($privacy, $terms)` | `ValidationException` con i messaggi `gdpr::register.consents.*_required`. |
| Revocare tutti i consensi | `Consent\RevokeGdprConsentsAction::execute($user)` | `UPDATE` di `revoked_at`, `revoked_ip_address`, `updated_by` sulle righe non gia' revocate. Non cancella righe. |
| Consensi dalla registrazione via evento | listener `SaveGdprConsents` -> `Consent\SaveRegistrationConsentsAction` | Sette trattamenti (privacy, termini, `data_processing`, marketing, profilazione, analytics, terze parti), `created_by` = `system`; salta in silenzio i trattamenti mancanti (comportamento storico, non da imitare). Oggi nessun codice del repository dispatcha `Modules\User\Events\UserRegistered`: la registrazione del widget non passa da qui. |

### Trait `HasGdpr` (sul modello utente del progetto)

`consents()` (morphMany), `activeConsents()` (`revoked_at` nullo), `treatments()`, `hasGivenConsent($type)` (cache 1 giorno),
`hasGivenConsentWithoutCache()`, `giveConsent($type, $metadata)`, `revokeConsent($type)`, `getMissingRequiredConsents()`,
`hasAllRequiredConsents()`. `giveConsent` e `SaveGdprConsentsAction` scrivono `user_type` in forme diverse (alias morph la prima,
classe la seconda): `RevokeGdprConsentsAction` le riconosce entrambe. Test: `tests/Unit/Traits/HasGdprTraitTest.php`
(con `tests/Fixtures/HasGdprDummy.php`).

## Versione del documento

Ogni riga scritta da `SaveGdprConsentsAction` porta `metadata.document_version` (mai vuota: se il trattamento non ha versione
si salva `1.0` anche sul trattamento) e `metadata.locale`. Quando l'informativa o i termini cambiano, il progetto aggiorna
`documentVersion` del trattamento: le nuove righe portano la nuova versione, le vecchie conservano quella accettata.

## Cosa NON e' garantito

- Il pannello (`ConsentResource`) consente create/edit/delete di righe `consents` agli utenti con i permessi
  `consent.*`: la regola append-only vale per le Action, non e' imposta dal database ([admin-panel.md](admin-panel.md)).
- Nessuna Action revoca un singolo trattamento: `RevokeGdprConsentsAction` revoca tutto. Lo user agent della revoca non e' salvato
  (manca la colonna `revoked_user_agent`).
- Le colonne di `consents` che le Action scrivono devono esistere nel database del progetto: dopo un aggiornamento del modulo
  lanciare le migrazioni ([database.md](database.md)).
