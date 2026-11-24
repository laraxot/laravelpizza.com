---
title: "Story: @contract docblock reference on Actions — ADR 0011"
type: story
status: accepted
created: 2026-11-23
updated: 2026-11-23
epic: "Xot documentation"
issues: []
discussions: []
related:
  - docs/contracts/action-behavioral-contract.md
  - laravel/Modules/Xot/docs/adr/actions-over-services.md
---

# Story: @contract docblock reference on Actions — ADR 0011

## Descrizione

Implementare l'ADR 0011: ogni Action in `Modules/*/app/Actions/*.php` deve avere un docblock `@see docs/contracts/{ActionName}.md` (o il percorso di contratto condiviso) che fa riferimento al contratto comportamentale.

## Obiettivo

- Garantire che ogni Action scriva o legga dati / chiami servizi esterni sia documentata
- Aggiungere i docblock `@contract` mancanti nelle Action esistenti
- Verificare con test `PackagesHaveContractsAndAdrTest` e `ActionContractsAreCompleteTest`

## Scope

- In scope: docblock PHP per Actions in `Modules/*/app/Actions/`
- Out of scope: creazione di nuovi contratti per Action che non scrivono dati / non chiamano servizi

## Conferma

- [ ] Tutte le Actions in `Modules/*/app/Actions/*.php` hanno `@contract` / `@see` al contratto
- [ ] Contratti esistenti presenti per le Actions che scrivono dati o chiamano servizi
- [ ] `vendor/bin/pest Modules/Xot/tests/Unit/Docs/PackagesHaveContractsAndAdrTest.php` passa
- [ ] `vendor/bin/pest Modules/Xot/tests/Unit/Docs/ActionContractsAreCompleteTest.php` passa
- [ ] ADR 0011 creato e linkato nell'indice `README.md` del modulo Xot (già fatto)

## GitHub (tracciamento)

- Issue: DA CREARE sul repo `laraxot/module_xot_fila5`
- Comando: `gh issue create --title "ADR 0011: @contract docblock reference on Actions" --body "Vedi ADR in laravel/Modules/Xot/docs/adr/contract-docblock-reference.md"`