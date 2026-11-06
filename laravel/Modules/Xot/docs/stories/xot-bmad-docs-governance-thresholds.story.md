---
id: xot-bmad-docs-governance-thresholds
title: "Governare i tetti di debito BMAD: documenti di modulo, numeri story, scope"
type: story
status: open
priority: P2
owner: module:Xot
module: Xot
tags: [bmad, docs, governance, soglie, planning]
related: [fix-xot-convention-tests]
---

# Governare i tetti di debito BMAD

Fase BMAD: Planning (decisione sui tetti) poi Dev.

## Stato misurato
- Soglie a cricchetto abbassate al debito misurato: documenti di modulo da 1642 a 1261, collisioni di numero story da 74 a 57.
- Restano: 86 epic orfani contro soglia 85; 539 story senza `Owned File` o `Module Scope` contro soglia 348.
- Le soglie non sono state alzate: serve una scelta di planning.

## Decisione da prendere
Per ogni tetto scegliere uno tra: (a) ripulire il debito fino alla soglia, (b) abbassare la soglia al valore reale con data di revisione, (c) escludere una categoria con motivazione.

## Azioni
1. Elencare gli epic orfani e assegnare owner.
2. Completare `Owned File` e `Module Scope` nelle story con priorità alta.
3. Aggiornare il test a cricchetto solo con valori misurati e motivati.

## Verifica
- Test `StoryNumbersAreUniqueTest` e `StoryEpicAndOwnedScopeTest` verdi con la soglia scelta.
