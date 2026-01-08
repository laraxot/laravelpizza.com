# Flusso degli Eventi - Prediction Market

## 1. Creazione Mercato
```mermaid
sequenceDiagram
    participant Admin
    participant MarketMaker
    participant System
    Admin->>MarketMaker: Abilita creazione mercato
    MarketMaker->>System: Crea nuovo mercato
    System->>System: Genera evento MarketCreated
```

## 2. Piazzamento Scommessa
```mermaid
sequenceDiagram
    participant User
    participant System
    User->>System: PlaceBet
    System->>System: Genera evento BetPlaced
    System->>User: Conferma scommessa
```

## 3. Chiusura Mercato e Payout
```mermaid
sequenceDiagram
    participant Oracolo
    participant System
    participant User
    Oracolo->>System: Fornisce esito
    System->>System: Genera evento MarketClosed
    System->>System: Genera evento PayoutProcessed
    System->>User: Aggiorna saldo vincitori
```

## 4. Audit Trail e Rollback
- Tutti gli eventi sono persistiti e possono essere rigiocati per ricostruire lo stato
- Possibilità di rollback tramite snapshot e replay 
