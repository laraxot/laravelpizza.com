# Eventi del Carrello della Spesa

## Introduzione

Gli eventi sono il cuore dell'Event Sourcing, rappresentando ogni modifica significativa allo stato del carrello della spesa. Questa sezione descrive gli eventi principali utilizzati nei progetti di Spatie.

## Eventi Principali

### Carrello

- **CartItemAdded**: Generato quando un articolo viene aggiunto al carrello. Contiene dettagli come ID articolo, quantità e prezzo.
- **CartItemRemoved**: Registra la rimozione di un articolo dal carrello.
- **CartCheckedOut**: Indica che il carrello è stato completato e pronto per diventare un ordine.

### Ordine

- **OrderPlaced**: Generato quando un carrello completato diventa un ordine.
- **OrderPaid**: Registra il pagamento di un ordine.
- **OrderShipped**: Indica che l'ordine è stato spedito.

### Pagamento

- **PaymentReceived**: Registra un pagamento ricevuto per un ordine.
- **PaymentFailed**: Indica il fallimento di un tentativo di pagamento.

## Ruolo degli Eventi

Gli eventi non solo tracciano le modifiche, ma guidano anche la logica di business. Ad esempio, un evento `CartCheckedOut` può triggerare la creazione di un ordine e la verifica dell'inventario. Questo approccio consente di mantenere un registro storico completo e di reagire a specifici cambiamenti di stato.
