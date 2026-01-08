# Architettura Bank (Event Sourcing)

## Pattern Principali
- **Event Sourcing**: ogni operazione bancaria (apertura conto, deposito, prelievo, limite raggiunto) è registrata come evento immutabile.
- **Aggregate Root**: la logica di business (es. calcolo saldo, verifica limiti) è centralizzata nell'aggregate del conto.
- **Proiettori**: generano viste di lettura (es. saldo attuale, storico movimenti) a partire dagli eventi.
- **Reattori**: gestiscono effetti collaterali (es. invio email per proposta prestito).

## Struttura Consigliata
- Modulo Bank con:
  - Aggregate per il conto
  - Eventi: AccountCreated, MoneyAdded, MoneySubtracted, AccountLimitHit, LoanProposed
  - Proiettori per saldo e storico movimenti
  - Reattori per notifiche e automazioni
- Database solo per eventi e proiezioni (nessun dato "di stato" mutabile)
- Test automatici su regole di business e proiezioni

## Tecnologie
- Laravel
- spatie/laravel-event-sourcing

Questa architettura garantisce coerenza, auditabilità e facilità di estensione. 
