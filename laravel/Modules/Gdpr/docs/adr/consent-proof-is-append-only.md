---
title: "ADR — La prova del consenso è una riga per scelta, mai sovrascritta"
type: decision
status: accepted
module: Gdpr
tags: [adr, gdpr, consenso, art-7, audit]
created: 2026-11-24
updated: 2026-11-24
related:
  - ../contracts/save-gdpr-consents-action.md
  - ../contracts/revoke-gdpr-consents-action.md
  - ../stories/dcp-135-registrazione-documenti-accettati-termini-e-consensi-registrati.story.md
---

# ADR: la prova del consenso è una riga per scelta, mai sovrascritta

## Contesto

- GDPR art. 7 par. 1: il titolare deve poter **dimostrare** che l'interessato ha acconsentito, e a quale testo.
- DCP-135 (2026-10-13): `SaveGdprConsentsAction` creava un `Consent` solo se trovava il `Treatment`; con `Treatment::count() = 0`
  nessuna registrazione lasciava traccia, e il `Consent` non portava la versione del documento accettato.
- DCP-285: `RevokeGdprConsentsAction` scriveva colonne inesistenti (`subject_type`, `revoked_user_agent`) e falliva sempre.
- Un agente che "pulisce" il codice tende a usare `updateOrCreate` per utente e trattamento, a saltare un trattamento mancante o a
  cancellare le righe revocate. Domanda: come si conserva la prova di ogni scelta nel tempo?

## Decisione

- `SaveGdprConsentsAction` fa solo `Consent::create`: una riga per ognuno dei tre trattamenti, **anche se rifiutato**
  (`accepted_at` nullo), con `metadata.document_version`, `metadata.document_url`, `metadata.locale`, `ip_address`, `user_agent`.
  `UpdateGdprConsentsAction` delega a lei: cambiare idea dal profilo aggiunge righe.
- Un trattamento mancante si crea da `TREATMENT_DEFAULTS`; uno senza versione riceve `1.0` (stessa classe).
- La revoca (`Consent\RevokeGdprConsentsAction`) è un `UPDATE` di `revoked_at` e `revoked_ip_address` sulle righe non ancora revocate:
  nessuna riga si cancella.
- Lo stato attuale di un consenso è l'ultima riga per trattamento non revocata.

## Alternative scartate

- Una riga per utente e trattamento aggiornata in place (`updateOrCreate`): perde la storia, cioè proprio la prova di cosa era
  stato accettato prima.
- Saltare il trattamento mancante con un warning (comportamento pre DCP-135): la registrazione "riesce" senza prova.
- Cancellare le righe alla revoca: la revoca stessa non sarebbe più dimostrabile (art. 30, registro).
- Tabella di storico separata: due fonti da tenere allineate per un'informazione che una tabella sola già esprime.

## Conseguenze

- Pro: ogni scelta è dimostrabile con data, IP, user agent, versione e lingua.
- Contro: `consents` cresce a ogni modifica; chi legge lo stato deve prendere l'ultima riga, non "la" riga.
- Debito: lo user agent della revoca non si salva (manca `revoked_user_agent`); `Consent\SaveRegistrationConsentsAction` (listener
  `SaveGdprConsents`, sette trattamenti) salta ancora i trattamenti mancanti e scrive `created_by = 'system'`;
  `Account\DeleteAccountAction` usa `updateOrCreate` per la riga `account_deletion` (una per utente, voluto).

## Verifica

- `vendor/bin/pest Modules/Gdpr/tests --group=GDPR-SAVE-INV-5` (e INV-1..4): fallisce se `SaveGdprConsentsAction` aggiorna invece di
  inserire, salta un trattamento o perde la versione.
- La parte revoca è in `tests/Unit/Actions/RevokeGdprConsentsActionTest.php::test_keeps_the_revoked_consents_as_audit_trail_instead_of_deleting_them`,
  oggi rosso per il DB di prova condiviso indietro (colonna `users.state`): fino ad allora, solo revisione — nessun `delete()` su
  `Consent` fuori dalla cancellazione a cascata dell'utente.
