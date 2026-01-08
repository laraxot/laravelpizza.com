# Use Case Shop – Event Sourcing e Console Commands

## Introduzione
Questo modulo implementa la gestione di uno shop tramite event sourcing, aggregate root e proiezioni, ispirandosi alle best practice di progetti open source come [event-sourcing-with-laravel](https://github.com/cnastasi/event-sourcing-with-laravel).

## Obiettivi
- Tracciabilità completa delle modifiche a carrelli, ordini e pagamenti
- Separazione della logica di business tramite eventi e aggregate
- Audit trail e rollback garantiti
- Performance e scalabilità tramite proiezioni ottimizzate

## Console Commands Principali
- `activity:shop:create-cart {userId}` – Crea un nuovo carrello
- `activity:shop:add-item {cartUuid} {itemId} {quantity} {price}` – Aggiunge un articolo
- `activity:shop:checkout {cartUuid}` – Completa un ordine
- Altri: gestione prodotti, replenishment, reportistica (vedi esempi nei file dedicati)

## Esempi di Utilizzo
```bash
php artisan activity:shop:create-cart 12345
php artisan activity:shop:add-item cart_12345_xxx item_001 2 19.99
php artisan activity:shop:checkout cart_12345_xxx
```

## Aggregate Root e Eventi
- **CartAggregate**: gestisce aggiunta/rimozione articoli, checkout
- **OrderAggregate**: gestisce creazione ordine, pagamento, spedizione
- **Eventi**: `CartItemAdded`, `CartItemRemoved`, `CartCheckedOut`, `OrderPlaced`, `OrderPaid`, `OrderShipped`, `PaymentReceived`, `PaymentFailed`

## Proiezioni
- **CartProjection**: stato attuale del carrello
- **OrderHistoryProjection**: storico ordini per utente
- **ProductInventoryProjection**: stock prodotti

## Flusso Operativo
1. Comando CLI → 2. Aggregate → 3. Evento → 4. Proiettore → 5. Modello di lettura → 6. UI/API

## Best Practice
- Eventi immutabili e atomici
- Aggregate root come unico punto di logica di dominio
- Proiezioni solo per lettura, aggiornate da projectors
- Separazione tra comandi (write) e query (read)
- Reactors per effetti collaterali (notifiche, email)
- DTO per passaggio dati tra livelli
- Test end-to-end tramite replay eventi

## Checklist di Implementazione
- [ ] Definire eventi e aggregate principali
- [ ] Implementare proiezioni e projectors
- [ ] Scrivere test per ogni comando/evento/proiezione
- [ ] Documentare i flussi principali e i comandi
- [ ] Prevedere rollback e replay

## FAQ
- Come aggiungere un nuovo comando?
- Come testare un aggregate?
- Come gestire rollback e replay eventi?
- Come integrare nuovi metodi di pagamento?
- Come estendere le proiezioni?

## Collegamenti correlati
- [Console Commands Shop](./console_commands.md)
- [Best Practice Shop](./04_best_practice.md)
- [Architettura Shop](./architecture.md)
- [Eventi Shop](./events.md)
- [Implementazione Shop](./implementation.md)
- [Test Shop](./09_test.md)
- [Glossario Shop](./10_glossario.md)
- [Confronto Approcci](./07_confronto_approcci.md)
- [Build from Scratch](./build_from_scratch.md)
- [README Prediction Market](../prediction_market/README.md)
- [README Bank](../bank/README.md)

---
**Questa documentazione è neutra e riutilizzabile, senza riferimenti a progetti specifici, e segue le regole di neutralità e modularità.** 
