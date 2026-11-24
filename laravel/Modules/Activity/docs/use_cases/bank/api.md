---
title: "Linee Guida API Bank (Event Sourcing)"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity, use_cases]
qmd: "linee guida api bank (event sourcing) activity"
---
# Linee Guida API Bank (Event Sourcing)

## Endpoints Principali
- POST /accounts: apertura nuovo conto
- POST /accounts/{id}/deposit: deposito fondi
- POST /accounts/{id}/withdraw: prelievo fondi
- GET /accounts/{id}: dettaglio conto (saldo, storico)
- GET /accounts/{id}/history: storico movimenti

## Best Practice API
- Autenticazione JWT o OAuth2
- Rate limiting e logging
- Webhook per notifiche (es. proposta prestito)
- API pubblica per dati di conto (solo lettura, audit)
- Versionamento API
