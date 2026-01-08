# Linee Guida API per uno Shop Event Sourced

## 1. Endpoints Principali
- `GET /products`: elenco prodotti (proiezione ottimizzata)
- `POST /cart/add`: aggiunta prodotto al carrello (comando)
- `POST /cart/checkout`: checkout carrello (comando)
- `POST /order/pay`: pagamento ordine (comando)
- `GET /orders/{id}`: dettaglio ordine (proiezione)
- `GET /orders/history`: storico ordini (proiezione)

## 2. Payload e DTO
- Usare DTO per validare e tipizzare i payload.
- **Esempio**:
```json
{
  "product_id": "abc123",
  "quantity": 2
}
```

## 3. Sicurezza
- Autenticazione JWT o OAuth2.
- Rate limiting su endpoint di scrittura.
- Logging e audit trail su tutti i comandi.

## 4. Versionamento
- Versionare le API (`/api/v1/`), soprattutto se cambiano le proiezioni.

## 5. Best Practice
- Separare endpoint di comando (POST) da quelli di query (GET).
- Non esporre direttamente gli eventi, ma solo le proiezioni.
- Usare webhook o websocket per notifiche in tempo reale (es. stato ordine).

## 6. Integrazione con Event Sourcing
- Gli endpoint di comando generano eventi tramite aggregate root.
- Le risposte delle query leggono dalle proiezioni aggiornate dai projectors.

## 7. Differenze con CRUD
- In CRUD: ogni endpoint aggiorna direttamente il database.
- In event sourced: ogni comando genera un evento, lo stato è ricostruito dagli eventi.
- **Motivazione**: audit, rollback, proiezioni flessibili, performance sulle letture. 
