---
title: "Topic test"
type: digest
status: active
qmd: "digest ceiling 100 test"
---

# Topic test

Sintesi automatica di 4 documenti (chiave `test`).

## test

_Fonte: `test.md`_



## Testing Bank (Event Sourcing)

_Fonte: `use_cases/bank/test.md`_

# Testing Bank (Event Sourcing)

## Unit Test
- Test per ogni evento e aggregate (apertura conto, deposito, prelievo, limite, prestito)
- Test per validazione input e regole di business

## Feature Test
- Flusso completo: apertura conto, deposito, prelievo, limite, proposta prestito
- Test per errori e rollback

## Integrazione
- Test su proiezioni (saldo, storico)
- Test su reattori (notifiche, email)
- Test di performance su conti con molti eventi

## Coverage
- Obiettivo: almeno 80% di copertura su moduli core

## Testing <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/test.md`_

# Testing <nome progetto>ion Market

## Unit Test
- Test per ogni evento, proiettore, reattore
- Test per validazione input e logica di business

## Feature Test
- Flusso completo: creazione mercato, scommessa, chiusura, payout
- Test per errori di oracolo e fallback

## Integrazione
- Test con oracoli esterni (mock e reali)
- Test di performance su mercati ad alto volume

## Coverage
- Obiettivo: almeno 80% di copertura su moduli core

## Testing di uno Shop Event Sourced

_Fonte: `use_cases/shop/test.md`_

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
