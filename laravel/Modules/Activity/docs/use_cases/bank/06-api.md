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
