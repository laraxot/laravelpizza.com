# Glossario Shop Event Sourced

- **Event Sourcing**: pattern in cui ogni cambiamento di stato è registrato come evento immutabile. Esempio: `OrderCreated`.
- **CQRS**: separazione tra comandi (scrittura) e query (lettura).
- **Aggregate Root**: oggetto che incapsula la logica di business e gestisce gli eventi di un'entità (es. ordine).
- **Projector**: componente che aggiorna le proiezioni (tabelle di lettura) in risposta agli eventi.
- **Proiezione**: tabella o vista ottimizzata per la lettura, aggiornata dai projectors.
- **Reactor**: componente che gestisce effetti collaterali (es. invio email) in risposta agli eventi.
- **DTO (Data Transfer Object)**: oggetto immutabile per trasferire dati tra livelli.
- **State Machine**: gestione esplicita degli stati e delle transizioni di un'entità.
- **Comando**: azione che muta lo stato del sistema (es. `AddProductToCart`).
- **Query**: richiesta di dati senza effetti collaterali (es. `GetOrderDetails`).
- **Domain Exception**: eccezione lanciata quando una regola di business viene violata.
- **Replay**: ricostruzione dello stato tramite la riproduzione degli eventi.
- **Bounded Context**: area del dominio con regole e modelli propri (es. Order, Cart).
- **Zen**: filosofia di semplicità, chiarezza, single responsibility.
- **Command Bus**: pattern per disaccoppiare l'invio e la gestione dei comandi.
- **CRUD**: Create, Read, Update, Delete; approccio tradizionale senza event sourcing. 
