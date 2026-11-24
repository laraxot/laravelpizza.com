---
title: "Contratti del modulo Gdpr"
type: index
tags: [contracts, actions, gdpr]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti del modulo Gdpr

Cosa promettono le Action del modulo Gdpr che scrivono dati personali: salvataggio e revoca dei consensi, cancellazione
dell'account. Ogni invariante ha un ID `GDPR-<OPERAZIONE>-INV-<N>`; con un group Pest si lancia
`vendor/bin/pest Modules/Gdpr/tests --group=<ID>`, `—` è debito dichiarato.

Quando leggerli: prima di chiamare, modificare o imitare una di queste Action, e prima di aggiungere "per completezza" un
comportamento che la sezione «Non fa» esclude. Formato: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

## Contratti

- [SaveGdprConsentsAction](save-gdpr-consents-action.md) — prova dei tre consensi della registrazione; 5 invarianti, tutte con group.
- [RevokeGdprConsentsAction](revoke-gdpr-consents-action.md) — revoca di tutti i consensi senza cancellare righe; 4 invarianti, debito.
- [DeleteAccountAction](delete-account-action.md) — art. 17: disattiva l'account, revoca consensi e token; 5 invarianti, debito.
