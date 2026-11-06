---
title: "Testing Bank (Event Sourcing)"
type: note
updated: 2026-10-07
tags: [docs, activity, use_cases]
qmd: "testing bank (event sourcing) activity"
status: superseded
superseded_by: test.md
---
# Testing Bank (Event Sourcing)

## Unit Test
- Test per ogni evento e aggregate (apertura conto, deposito, prelievo, limite, prestito)
- Test per validazione input e regole di business

## Feature Test
- Flusso completo: apertura conto, deposito, prelievo, limite, proposta prestito
- Test per errori e rollback

## Integrazione
- Test su proiezioni (saldo, storico)
- Test su reattori (notifiche, email)
- Test di performance su conti con molti eventi

## Coverage
- Obiettivo: almeno 80% di copertura su moduli core
