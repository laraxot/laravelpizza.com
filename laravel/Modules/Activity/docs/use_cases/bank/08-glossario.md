# Glossario Bank (Event Sourcing)

- **Event Sourcing**: Pattern di persistenza basato su eventi immutabili.
- **Aggregate Root**: Oggetto che incapsula la logica di business e gestisce gli eventi di un'entità (es. conto bancario).
- **Proiettore**: Componente che genera viste di lettura dagli eventi.
- **Reattore**: Componente che gestisce effetti collaterali (es. invio email).
- **AccountCreated**: Evento di apertura conto.
- **MoneyAdded**: Evento di deposito fondi.
- **MoneySubtracted**: Evento di prelievo fondi.
- **AccountLimitHit**: Evento di superamento limite saldo.
- **LoanProposed**: Evento di proposta prestito.
- **Snapshotting**: Salvataggio dello stato corrente per ottimizzare la ricostruzione degli aggregate. 
