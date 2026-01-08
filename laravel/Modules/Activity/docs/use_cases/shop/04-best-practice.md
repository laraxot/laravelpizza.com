# Best Practice, Zen e Pattern per uno Shop Event Sourced

## 1. Eventi Immutabili e Atomici
- Ogni evento rappresenta un cambiamento atomico e irreversibile.
- **Esempio**: `OrderCreated`, `ProductAddedToCart`.
- **Motivazione**: garantisce audit, rollback, debugging.

## 2. Aggregate Root come Guardiano del Dominio
- Tutta la logica di business vive nell'aggregate.
- Nessun comando può bypassare le regole di dominio.
- **Esempio**: `OrderAggregateRoot::complete()` verifica stato e condizioni.

## 3. Proiezioni Ottimizzate per la Lettura
- Le proiezioni sono tabelle dedicate solo alla lettura, aggiornate dai projectors.
- **Motivazione**: performance, UX, scalabilità.

## 4. Separazione tra Comandi e Query (CQRS)
- Mai mischiare scrittura e lettura nello stesso handler.
- **Motivazione**: chiarezza, testabilità, performance.

## 5. Reactors per Effetti Collaterali
- Tutto ciò che non è dominio puro (email, notifiche, API esterne) va nei reactors.
- **Motivazione**: dominio puro, testabilità, isolamento.

## 6. DTO e Type Safety
- Usare DTO per passare dati tra livelli, mai array associativi.
- **Motivazione**: chiarezza, refactoring sicuro, IDE friendly.

## 7. Gestione Stati tramite State Machine
- Stati espliciti, transizioni chiare.
- **Motivazione**: meno bug, più leggibilità.

## 8. Test End-to-End tramite Replay Eventi
- Testare i flussi ricostruendo lo stato dagli eventi.
- **Motivazione**: garantisce che il sistema sia realmente event sourced.

## 9. Errori da Evitare
- Scrivere logica di business nei projectors o reactors.
- Usare array invece di DTO.
- Aggiornare direttamente le proiezioni senza passare dagli eventi.
- Non gestire le eccezioni di dominio.

## 10. Zen
- "Fai una cosa sola e falla bene" (Single Responsibility Principle).
- "Ogni cambiamento è una storia" (event sourcing come narrazione).
- "Il dominio non conosce la persistenza" (DDD puro). 
