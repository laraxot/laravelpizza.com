---
title: "Topic api"
type: digest
status: active
qmd: "digest ceiling 100 api"
---

# Topic api

Sintesi automatica di 5 documenti (chiave `api`).

## Activity Module: API

_Fonte: `api.md`_

# Activity Module: API

## LogActivityAction

```php
execute(array $data): Activity
```

- `description` (string): Activity description
- `subject` (Model): Target entity
- `causer` (Model): User performing action
- `type` (string): Event type (user.created, post.updated, etc.)
- `properties` (array): Metadata

## Activity Model

```php
Activity::find($id);
$activity->subject;       // Polymorphic: User, Post, etc.
$activity->causer;        // User performing action
$activity->properties;    // JSON metadata
```

---

<!-- merged from API.md -->

> Nota 2026-10-14 (docs-audit): La firma 'execute(array $data): Activity' non esiste: LogActivityAction prende type, user, subject, properties, description nel costruttore e ha execute(): Activity (app/Actions/LogActivityAction.php). Vedi README.md. Contenuto non riscritto, verificare prima di usarlo.

## Linee Guida API Bank (Event Sourcing)

_Fonte: `use_cases/bank/api.md`_

# Linee Guida API Bank (Event Sourcing)

## Endpoints Principali
- POST /accounts: apertura nuovo conto
- POST /accounts/{id}/deposit: deposito fondi
- POST /accounts/{id}/withdraw: prelievo fondi
- GET /accounts/{id}: dettaglio conto (saldo, storico)
- GET /accounts/{id}/history: storico movimenti

## Best Practice API
- Autenticazione JWT o OAuth2
- Rate limiting e logging
- Webhook per notifiche (es. proposta prestito)
- API pubblica per dati di conto (solo lettura, audit)
- Versionamento API

## Linee Guida API <nome progetto>ion Market

_Fonte: `use_cases/prediction_market/api.md`_

# Linee Guida API <nome progetto>ion Market

## Endpoints Principali
- GET /markets: lista mercati attivi
- GET /markets/{id}: dettaglio mercato
- POST /markets: creazione nuovo mercato
- POST /markets/{id}/bet: acquisto quote
- GET /user/history: storico personale
- POST /user/withdraw: richiesta payout

## Best Practice API
- Autenticazione JWT o OAuth2
- Rate limiting e logging
- Webhook per notifiche di payout
- API pubblica per dati di mercato (come Polymarket, Kalshi)
- Versionamento API

## Linee Guida API per uno Shop Event Sourced

_Fonte: `use_cases/shop/api.md`_

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

## Activity Module — API

_Fonte: `wiki/api.md`_

# Activity Module — API

## LogActivityAction

```php
execute(array $data): Activity
```

- `description` (string): Activity description
- `subject` (Model): Target entity
- `causer` (Model): User performing action
- `type` (string): Event type (user.created, post.updated, etc.)
- `properties` (array): Metadata

## Activity Model

```php
Activity::find($id);
$activity->subject;       // Polymorphic: User, Post, etc.
$activity->causer;        // User performing action
$activity->properties;    // JSON metadata
```
