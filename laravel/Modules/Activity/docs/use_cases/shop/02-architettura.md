# Architettura di uno Shop Event Sourced

## 1. Modularità e Bounded Context
- Ogni dominio (Order, Cart, Product, Payment, Inventory, Customer) è una cartella autonoma.
- Ogni dominio contiene: AggregateRoot, Events, Projectors, Projections, Actions, DTO, State, Exceptions.

## 2. Event Sourcing
- Ogni cambiamento di stato è un evento immutabile (es. `OrderCreated`, `ProductAddedToCart`).
- Gli eventi sono l'unica fonte di verità: lo stato si ricostruisce dal log eventi.
- **Esempio**:
```php
class OrderCreated extends ShouldBeStored {
    public function __construct(public string $orderUuid, public OrderData $orderData, public Carbon $createdAt) {}
}
```

## 3. CQRS (Command Query Responsibility Segregation)
- **Comandi**: mutano lo stato (es. `CreateOrder`, `AddProductToCart`).
- **Query**: leggono lo stato (es. `GetOrderDetails`).
- **Pro**: performance, chiarezza, scalabilità.
- **Contro**: maggiore complessità iniziale.

## 4. Aggregate Root
- Incapsula la logica di business e decide se un evento può essere registrato.
- Garantisce la coerenza delle regole di dominio.
- **Esempio**:
```php
class OrderAggregateRoot extends AggregateRoot {
    public function create(Cart $cart) { ... }
    public function complete(string $invoicePath) { ... }
}
```

## 5. Projectors e Projections
- I projectors ascoltano gli eventi e aggiornano le tabelle di lettura (proiezioni).
- Le proiezioni sono ottimizzate per la lettura (es. dashboard, report, API).
- **Esempio**:
```php
class OrderProjector extends Projector {
    public function onOrderCreated(OrderCreated $event) { ... }
}
```

## 6. Reactors
- Gestiscono effetti collaterali (es. invio email, notifiche, integrazioni esterne).
- Separano la logica di dominio dagli effetti esterni.
- **Esempio**:
```php
class SecondCompletedOrderReactor implements Reactor {
    public function onOrderCompleted(OrderCompleted $event) {
        // invia email di congratulazioni se è il secondo ordine completato
    }
}
```

## 7. DTO (Data Transfer Object)
- Oggetti immutabili per passare dati tra livelli.
- Favoriscono chiarezza e type safety.

## 8. State Machine
- Gestione esplicita degli stati (Pending, Completed, Cancelled, ecc.).
- Più leggibile e testabile di semplici flag.

## 9. Eccezioni di Dominio
- Ogni violazione di regola di business lancia un'eccezione specifica.
- Migliora la robustezza e la chiarezza del dominio.

## 10. Console Commands come entrypoint
- I comandi console sono spesso il modo più semplice e pragmatico per interagire con il dominio in demo, PoC o sistemi semplici.
- Esempi: `product:list`, `product:purchase`, `product:register`, `product:replenish`.
- **Motivazione**: semplicità, testabilità, automazione.

## 11. Pattern Phoenix Context
- Separare la logica di dominio in "contesti" (es. ProductContext, OrderContext) per isolare responsabilità e facilitare la manutenzione.
- Ogni context gestisce la propria logica, eventi, proiezioni e reactors.

## 12. Testabilità
- Ogni aggregate, evento, proiezione è testabile in isolamento.
- Test di flusso end-to-end tramite replay degli eventi.

## 13. Alternative e Scelte
- **CRUD tradizionale**: più semplice, ma senza audit e rollback.
- **Event Sourcing**: più complesso, ma auditabile e estendibile.
- **CQRS**: separa responsabilità, ma richiede più codice.
- **Approccio minimalista**: per demo o PoC, una struttura semplice con pochi comandi console e proiezioni può essere sufficiente.

## 14. Zen e Religione
- Ogni modulo fa una cosa sola e bene.
- La logica di business non conosce la persistenza.
- Ogni cambiamento è un evento, ogni evento è una storia.
- "Sii pragmatico: la semplicità vince sempre nelle demo e nei PoC". 
