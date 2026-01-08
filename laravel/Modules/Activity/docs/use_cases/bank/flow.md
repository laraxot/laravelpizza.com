# Flussi Principali - Use Case Bancario

## 1. Apertura Conto
```mermaid
sequenceDiagram
    participant User
    participant System
    User->>System: Richiesta apertura conto
    System->>System: (Tradizionale) Crea record Account
    System->>System: (Event Sourcing) Genera evento AccountOpened
    System->>User: Conferma apertura conto
```

## 2. Deposito
```mermaid
sequenceDiagram
    participant User
    participant System
    User->>System: Richiesta deposito
    System->>System: (Tradizionale) Aggiorna saldo
    System->>System: (Event Sourcing) Genera evento MoneyDeposited
    System->>User: Conferma deposito
```

## 3. Prelievo
```mermaid
sequenceDiagram
    participant User
    participant System
    User->>System: Richiesta prelievo
    System->>System: (Tradizionale) Aggiorna saldo
    System->>System: (Event Sourcing) Genera evento MoneyWithdrawn
    System->>User: Conferma prelievo
```

## 4. Trasferimento
```mermaid
sequenceDiagram
    participant User
    participant System
    User->>System: Richiesta trasferimento
    System->>System: (Tradizionale) Aggiorna saldo mittente/destinatario
    System->>System: (Event Sourcing) Genera evento MoneyTransferred
    System->>User: Conferma trasferimento
```

## 5. Audit e Rollback
- (Tradizionale) Audit limitato, rollback manuale
- (Event Sourcing) Audit completo, rollback tramite replay eventi o snapshot 
