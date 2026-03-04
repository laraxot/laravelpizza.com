# Flusso Utente Prediction Market

1. **Creazione Mercato**: un utente crea un mercato (es. “Vincerà il candidato X?”).
   - Comando console: `market:create "Vincerà il candidato X?"`
2. **Partecipazione**: altri utenti acquistano quote (“sì” o “no”) tramite smart contract.
   - Comando console: `market:bet {marketId} {userId} {outcome} {amount}`
3. **Chiusura Mercato**: alla scadenza, un oracolo fornisce il risultato.
   - Comando console: `market:close {marketId} {outcome}`
4. **Settlement**: i vincitori ricevono automaticamente il payout.
   - Comando console: `market:settle {marketId}`

## Esempio di Flusso
- Registrazione utente (`user:register {name}`)
- Deposito fondi (wallet) (`user:deposit {userId} {amount}`)
- Scelta del mercato e acquisto quote (`market:bet ...`)
- Attesa esito evento (`market:close ...`)
- Ricezione payout automatico (`market:settle ...`)
- Storico personale e leaderboard (`user:history {userId}`)

## Pattern Context
- Ogni step può essere gestito da un context dedicato (MarketContext, UserContext, WalletContext).
- Ogni context espone i propri comandi console per interagire con il dominio.

## Zen
- "Ogni comando console è un test vivente del dominio."
- "La semplicità favorisce la testabilità e la comprensione."
