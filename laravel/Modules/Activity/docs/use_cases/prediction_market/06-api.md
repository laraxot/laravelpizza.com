# Linee Guida API Prediction Market

## Endpoints Principali
- GET /markets: lista mercati attivi
- GET /markets/{id}: dettaglio mercato
- POST /markets: creazione nuovo mercato
- POST /markets/{id}/bet: acquisto quote
- GET /user/history: storico personale
- POST /user/withdraw: richiesta payout

## Best Practice API
- Autenticazione JWT o OAuth2
- Rate limiting e logging
- Webhook per notifiche di payout
- API pubblica per dati di mercato (come Polymarket, Kalshi)
- Versionamento API 
