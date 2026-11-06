---
title: "Modello di Dominio - Use Case Bancario"
type: note
status: draft
updated: 2026-10-07
tags: [docs, activity, use_cases]
qmd: "modello di dominio - use case bancario activity"
---
# Modello di Dominio - Use Case Bancario

## Aggregate
- **Account**: rappresenta un conto bancario
- **Transaction**: rappresenta un'operazione (deposito, prelievo, trasferimento)

## Eventi (Event Sourcing)
- `AccountOpened`
- `MoneyDeposited`
- `MoneyWithdrawn`
- `MoneyTransferred`
- `TransferFailed`

## Comandi
- `OpenAccount`
- `DepositMoney`
- `WithdrawMoney`
- `TransferMoney`

## Proiezioni
- **AccountBalance**: saldo attuale del conto
- **TransactionHistory**: storico delle operazioni
- **TransferStatus**: stato dei trasferimenti

## Esempio di evento (Eventsauce/Projectors)
```php
class MoneyDeposited implements ShouldBeStored
{
    public function __construct(
        public string $accountUuid,
        public float $amount
    ) {}
}
```

## Esempio di comando
```php
class DepositMoney
{
    public function __construct(
        public string $accountUuid,
        public float $amount
    ) {}
}
```
