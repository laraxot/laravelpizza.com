# Testing di uno Shop Event Sourced

## 1. Unit Test
- Testare ogni aggregate root in isolamento.
- Testare ogni evento (payload, serializzazione, validazione).
- Testare DTO e state machine.
- **Esempio**:
```php
it('un ordine può essere completato solo se pagato', function() {
    $aggregate = OrderAggregateRoot::retrieve($uuid);
    $aggregate->pay($paymentData);
    $aggregate->complete();
    expect($aggregate->state())->toBe('completed');
});
```

## 2. Feature Test
- Testare i flussi utente: aggiunta al carrello, checkout, pagamento, completamento ordine.
- Simulare comandi e verificare la generazione degli eventi corretti.

## 3. End-to-End tramite Replay Eventi
- Ricostruire lo stato di un ordine tramite replay degli eventi.
- Verificare che le proiezioni siano coerenti con lo stream eventi.

## 4. Test di Proiezioni e Projectors
- Testare che ogni evento aggiorni correttamente la proiezione.
- **Esempio**: dopo `OrderCreated`, la tabella ordini deve avere una nuova riga.

## 5. Test di Reactors
- Testare effetti collaterali (email, notifiche, API esterne) in risposta agli eventi.
- Usare mock per servizi esterni.

## 6. Coverage
- Obiettivo: almeno 80% di copertura su moduli core.

## 7. Confronto con CRUD
- In CRUD: test su controller e repository.
- In event sourced: test su aggregate, eventi, projectors, reactors, flussi end-to-end.
- **Motivazione**: garantire che il sistema sia realmente event sourced e auditabile. 
