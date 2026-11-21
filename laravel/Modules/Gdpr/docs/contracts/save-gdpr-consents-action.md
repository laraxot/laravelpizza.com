---
title: "Contratto — SaveGdprConsentsAction"
type: contract
action: "Modules\Gdpr\Actions\SaveGdprConsentsAction"
tags: [contract, action]
created: 2026-11-18
updated: 2026-11-18
---

# SaveGdprConsentsAction

Contratto di comportamento (regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`).
Sorgente: `app/Actions/SaveGdprConsentsAction.php`.

## Input

- L'utente registrato, le scelte (`privacy_accepted`, `terms_accepted`, `marketing_consent`), IP e user agent (se mancano, quelli della richiesta).

## Output

- Nessuno (void).

## Invarianti

- Una riga di `consents` per ognuno dei tre trattamenti, accettati o no.
- Ogni riga porta la versione del documento (`metadata.document_version`, mai vuota), la lingua, IP e user agent.
- `accepted_at` solo se accettato.

## Effetti collaterali

- Crea il trattamento se non esiste.
- Se esiste senza versione gli assegna quella di partenza.

## Errori

- Eccezioni del database verso il chiamante (la registrazione deve fallire, non riuscire senza prova).

## Non fa

- Non valida le scelte obbligatorie (lo fa il modulo di registrazione).
- Non revoca consensi (RevokeGdprConsentsAction).
- Non manda email.
