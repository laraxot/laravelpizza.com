# Analisi Approfondita: laravel-shop-command-bus

## 1. Struttura delle Cartelle e Naming
- `src/Order/`: dominio ordine, separato dal resto della libreria.
- Sottocartelle: `Events`, `Projectors`, `Actions`, `DTO`, `State`, `Exceptions`.
- **Motivazione**: DDD, modularità, riusabilità come package.

## 2. Event Sourcing
- Ogni cambiamento di stato è un evento (`OrderCreated`, `OrderCompleted`, `OrderCanceled`).
- Gli eventi sono classi dedicate, immutabili, serializzabili.
- **Esempio**:
```php
class OrderCreated extends ShouldBeStored { ... }
```
- **Motivazione**: audit, rollback, debugging, proiezioni flessibili.

## 3. Aggregate Root
- `OrderAggregateRoot` incapsula la logica di business.
- Metodi: `create`, `complete`, `cancel`.
- **Motivazione**: single source of truth per le regole di dominio.

## 4. Projectors
- `OrderProjector` aggiorna le proiezioni (tabelle di lettura) in risposta agli eventi.
- **Motivazione**: performance, UX, reporting.

## 5. Command Bus
- Tutte le azioni che mutano lo stato passano attraverso un command bus.
- **Motivazione**: disaccoppiamento tra chi invia il comando e chi lo gestisce, testabilità, logging, middleware.
- **Esempio**:
```php
$commandBus->dispatch(new CreateOrderCommand($cartId));
```

## 6. DTO e State
- Oggetti dedicati per passare dati e rappresentare lo stato.
- **Motivazione**: type safety, chiarezza, refactoring sicuro.

## 7. Eccezioni di Dominio
- Ogni violazione di regola lancia un'eccezione specifica.
- **Motivazione**: robustezza, chiarezza.

## 8. Testabilità
- Ogni aggregate, evento, proiezione è testabile in isolamento.
- Test end-to-end tramite replay degli eventi.
- Command bus testabile con mock e middleware.

## 9. Filosofia e Zen
- "Ogni comando è un'intenzione esplicita".
- "Il dominio non conosce la persistenza né il trasporto".
- "Fai una cosa sola e falla bene".

## 10. Come ricreare da zero
1. Definisci i bounded context (Order, Cart, Product, ecc.).
2. Crea le cartelle per ogni dominio.
3. Definisci gli eventi come classi immutabili.
4. Implementa l'aggregate root con la logica di business.
5. Crea i projectors per aggiornare le proiezioni.
6. Usa DTO per passare dati tra livelli.
7. Gestisci le eccezioni di dominio.
8. Implementa un command bus per gestire i comandi.
9. Scrivi test per ogni componente.

## 11. Alternative
- CRUD tradizionale: più semplice, meno auditabile.
- Event sourcing: più complesso, ma audit, rollback, proiezioni flessibili.
- Command bus: aggiunge disaccoppiamento e testabilità, ma aumenta la complessità. 
