# Flusso Utente Shop Event Sourced

## 1. Navigazione e Scoperta Prodotti
- L'utente esplora il catalogo (proiezione ottimizzata per la lettura).
- **Motivazione**: separazione tra dati di dominio e viste di lettura per performance.

## 2. Aggiunta al Carrello
- Comando: `AddProductToCart`
- Evento: `ProductAddedToCart`
- **Motivazione**: ogni azione è tracciata, il carrello è uno stream di eventi.
- **Esempio**:
```php
$cartAggregate->addProduct($productId, $qty);
```

## 3. Checkout
- Comando: `CheckoutCart`
- Evento: `OrderCreated`
- **Motivazione**: la creazione ordine è atomica, il carrello viene "consumato" e nasce un ordine.

## 4. Pagamento
- Comando: `PayOrder`
- Evento: `OrderPaid`
- **Motivazione**: separazione tra creazione ordine e pagamento, per gestire pagamenti asincroni o falliti.

## 5. Gestione Stato Ordine
- Eventi: `OrderCompleted`, `OrderCancelled`
- **Motivazione**: ogni stato è esplicito, ogni transizione è tracciata.

## 6. Notifiche e Reactors
- Reactor: invio email, aggiornamento inventario, notifiche push.
- **Motivazione**: separazione tra dominio e effetti collaterali.

## 7. Consultazione Storico
- Query: `GetOrderHistory`
- **Motivazione**: proiezioni ottimizzate per la UX, ricostruite dagli eventi.

## 8. Esempio di Flusso Completo
1. L'utente aggiunge 2 prodotti al carrello (2 eventi `ProductAddedToCart`)
2. Effettua il checkout (`OrderCreated`)
3. Paga l'ordine (`OrderPaid`)
4. L'ordine viene completato (`OrderCompleted`)
5. Riceve email di conferma (reactor)

## Alternative
- In un CRUD tradizionale, molte di queste azioni sarebbero update diretti su tabelle, senza storia né audit.
- Con event sourcing, ogni passaggio è tracciato e ricostruibile. 
