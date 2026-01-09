# API Endpoints del Progetto Laravel Pizza

## Autenticazione

### Login
- **POST** `/api/login`
  - **Descrizione**: Autenticazione utente
  - **Headers**: `Content-Type: application/json`
  - **Body**:
    ```json
    {
      "email": "user@example.com",
      "password": "password"
    }
    ```
  - **Risposta**:
    ```json
    {
      "token": "jwt_token_here",
      "user": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com"
      }
    }
    ```

### Registrazione
- **POST** `/api/register`
  - **Descrizione**: Registrazione nuovo utente
  - **Headers**: `Content-Type: application/json`
  - **Body**:
    ```json
    {
      "name": "John Doe",
      "email": "user@example.com",
      "password": "password",
      "password_confirmation": "password"
    }
    ```
  - **Risposta**:
    ```json
    {
      "token": "jwt_token_here",
      "user": {
        "id": 1,
        "name": "John Doe",
        "email": "user@example.com"
      }
    }
    ```

### Logout
- **POST** `/api/logout`
  - **Descrizione**: Logout utente
  - **Headers**: `Authorization: Bearer {token}`
  - **Risposta**: `200 OK`

## Pizze

### Lista Pizze
- **GET** `/api/pizzas`
  - **Descrizione**: Ottieni tutte le pizze disponibili
  - **Parametri**:
    - `category` (opzionale): Filtra per categoria
    - `page` (opzionale): Paginazione
  - **Headers**: `Authorization: Bearer {token}` (opzionale)
  - **Risposta**:
    ```json
    {
      "data": [
        {
          "id": 1,
          "name": "Margherita",
          "description": "Pomodoro e mozzarella",
          "price": 8.50,
          "category": "classiche",
          "image_url": "https://example.com/image.jpg",
          "ingredients": [
            {
              "id": 1,
              "name": "Mozzarella",
              "allergens": ["lactose"]
            }
          ]
        }
      ],
      "links": {
        "first": "/api/pizzas?page=1",
        "last": "/api/pizzas?page=10",
        "prev": null,
        "next": "/api/pizzas?page=2"
      },
      "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 10,
        "links": [...],
        "path": "/api/pizzas",
        "per_page": 10,
        "to": 10,
        "total": 100
      }
    }
    ```

### Dettagli Pizza
- **GET** `/api/pizzas/{id}`
  - **Descrizione**: Ottieni i dettagli di una pizza specifica
  - **Headers**: `Authorization: Bearer {token}` (opzionale)
  - **Risposta**:
    ```json
    {
      "id": 1,
      "name": "Margherita",
      "description": "Pomodoro e mozzarella",
      "price": 8.50,
      "category": "classiche",
      "image_url": "https://example.com/image.jpg",
      "ingredients": [
        {
          "id": 1,
          "name": "Mozzarella",
          "allergens": ["lactose"],
          "quantity": 100
        }
      ],
      "available": true,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

## Ordini

### Crea Ordine
- **POST** `/api/orders`
  - **Descrizione**: Crea un nuovo ordine
  - **Headers**: `Authorization: Bearer {token}`, `Content-Type: application/json`
  - **Body**:
    ```json
    {
      "items": [
        {
          "pizza_id": 1,
          "quantity": 2,
          "special_instructions": "Senza origano"
        }
      ],
      "delivery_address": {
        "street": "Via Roma 1",
        "city": "Milano",
        "zip_code": "20100",
        "country": "IT"
      },
      "delivery_time": "2023-01-01T19:30:00",
      "payment_method": "card"
    }
    ```
  - **Risposta**:
    ```json
    {
      "id": 1,
      "order_number": "ORD-20230101-001",
      "status": "pending",
      "items": [
        {
          "pizza_id": 1,
          "pizza_name": "Margherita",
          "quantity": 2,
          "price": 17.00,
          "special_instructions": "Senza origano"
        }
      ],
      "total_amount": 17.00,
      "delivery_address": {
        "street": "Via Roma 1",
        "city": "Milano",
        "zip_code": "20100",
        "country": "IT"
      },
      "delivery_time": "2023-01-01T19:30:00.000000Z",
      "estimated_delivery": "2023-01-01T19:45:00.000000Z",
      "payment_method": "card",
      "created_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

### Lista Ordini Utente
- **GET** `/api/orders`
  - **Descrizione**: Ottieni la cronologia ordini dell'utente
  - **Headers**: `Authorization: Bearer {token}`
  - **Parametri**:
    - `status` (opzionale): Filtra per stato
    - `date_from` (opzionale): Data inizio
    - `date_to` (opzionale): Data fine
  - **Risposta**:
    ```json
    {
      "data": [
        {
          "id": 1,
          "order_number": "ORD-20230101-001",
          "status": "delivered",
          "total_amount": 17.00,
          "items_count": 2,
          "created_at": "2023-01-01T00:00:00.000000Z",
          "delivery_time": "2023-01-01T19:30:00.000000Z"
        }
      ],
      "links": {...},
      "meta": {...}
    }
    ```

### Dettagli Ordine
- **GET** `/api/orders/{id}`
  - **Descrizione**: Ottieni i dettagli di un ordine specifico
  - **Headers**: `Authorization: Bearer {token}`
  - **Risposta**:
    ```json
    {
      "id": 1,
      "order_number": "ORD-20230101-001",
      "status": "delivered",
      "items": [
        {
          "pizza_id": 1,
          "pizza_name": "Margherita",
          "quantity": 2,
          "price": 17.00,
          "special_instructions": "Senza origano"
        }
      ],
      "total_amount": 17.00,
      "delivery_address": {
        "street": "Via Roma 1",
        "city": "Milano",
        "zip_code": "20100",
        "country": "IT"
      },
      "delivery_time": "2023-01-01T19:30:00.000000Z",
      "estimated_delivery": "2023-01-01T19:45:00.000000Z",
      "actual_delivery": "2023-01-01T19:42:00.000000Z",
      "payment_method": "card",
      "payment_status": "paid",
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

## Profilo Utente

### Ottieni Profilo
- **GET** `/api/profile`
  - **Descrizione**: Ottieni i dettagli del profilo utente
  - **Headers**: `Authorization: Bearer {token}`
  - **Risposta**:
    ```json
    {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com",
      "phone": "+39 1234567890",
      "addresses": [
        {
          "id": 1,
          "street": "Via Roma 1",
          "city": "Milano",
          "zip_code": "20100",
          "country": "IT",
          "is_default": true
        }
      ],
      "loyalty_points": 150,
      "created_at": "2023-01-01T00:00:00.000000Z",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

### Aggiorna Profilo
- **PUT** `/api/profile`
  - **Descrizione**: Aggiorna i dettagli del profilo utente
  - **Headers**: `Authorization: Bearer {token}`, `Content-Type: application/json`
  - **Body**:
    ```json
    {
      "name": "John Doe Updated",
      "phone": "+39 0987654321"
    }
    ```
  - **Risposta**:
    ```json
    {
      "id": 1,
      "name": "John Doe Updated",
      "email": "user@example.com",
      "phone": "+39 0987654321",
      "updated_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

## Indirizzi

### Lista Indirizzi
- **GET** `/api/addresses`
  - **Descrizione**: Ottieni tutti gli indirizzi dell'utente
  - **Headers**: `Authorization: Bearer {token}`
  - **Risposta**:
    ```json
    {
      "data": [
        {
          "id": 1,
          "street": "Via Roma 1",
          "city": "Milano",
          "zip_code": "20100",
          "country": "IT",
          "is_default": true,
          "label": "Casa"
        }
      ]
    }
    ```

### Aggiungi Indirizzo
- **POST** `/api/addresses`
  - **Descrizione**: Aggiungi un nuovo indirizzo
  - **Headers**: `Authorization: Bearer {token}`, `Content-Type: application/json`
  - **Body**:
    ```json
    {
      "street": "Via Milano 2",
      "city": "Roma",
      "zip_code": "00100",
      "country": "IT",
      "label": "Ufficio",
      "is_default": false
    }
    ```
  - **Risposta**:
    ```json
    {
      "id": 2,
      "street": "Via Milano 2",
      "city": "Roma",
      "zip_code": "00100",
      "country": "IT",
      "label": "Ufficio",
      "is_default": false,
      "created_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

## Recensioni

### Aggiungi Recensione
- **POST** `/api/reviews`
  - **Descrizione**: Aggiungi una recensione per una pizza
  - **Headers**: `Authorization: Bearer {token}`, `Content-Type: application/json`
  - **Body**:
    ```json
    {
      "pizza_id": 1,
      "rating": 5,
      "comment": "Ottima pizza, come sempre!",
      "order_id": 1
    }
    ```
  - **Risposta**:
    ```json
    {
      "id": 1,
      "pizza_id": 1,
      "user_id": 1,
      "rating": 5,
      "comment": "Ottima pizza, come sempre!",
      "order_id": 1,
      "created_at": "2023-01-01T00:00:00.000000Z"
    }
    ```

### Lista Recensioni Pizza
- **GET** `/api/pizzas/{id}/reviews`
  - **Descrizione**: Ottieni tutte le recensioni di una pizza
  - **Headers**: `Authorization: Bearer {token}` (opzionale)
  - **Risposta**:
    ```json
    {
      "data": [
        {
          "id": 1,
          "user": {
            "id": 1,
            "name": "John Doe"
          },
          "rating": 5,
          "comment": "Ottima pizza, come sempre!",
          "created_at": "2023-01-01T00:00:00.000000Z"
        }
      ],
      "average_rating": 4.5,
      "total_reviews": 10
    }
    ```

## Categorie

### Lista Categorie
- **GET** `/api/categories`
  - **Descrizione**: Ottieni tutte le categorie pizze
  - **Headers**: `Authorization: Bearer {token}` (opzionale)
  - **Risposta**:
    ```json
    {
      "data": [
        {
          "id": 1,
          "name": "Classiche",
          "description": "Pizze tradizionali",
          "image_url": "https://example.com/classic.jpg",
          "pizza_count": 15
        }
      ]
    }
    ```

## Ingredienti

### Lista Ingredienti
- **GET** `/api/ingredients`
  - **Descrizione**: Ottieni tutti gli ingredienti disponibili
  - **Headers**: `Authorization: Bearer {token}` (opzionale)
  - **Risposta**:
    ```json
    {
      "data": [
        {
          "id": 1,
          "name": "Mozzarella",
          "allergens": ["lactose"],
          "vegetarian": true,
          "vegan": false,
          "price_surcharge": 0.50
        }
      ]
    }
    ```

## Tracking Ordini

### Stato Ordine in Tempo Reale
- **GET** `/api/orders/{id}/tracking`
  - **Descrizione**: Ottieni lo stato in tempo reale dell'ordine
  - **Headers**: `Authorization: Bearer {token}`
  - **Risposta**:
    ```json
    {
      "order_id": 1,
      "status": "on_delivery",
      "status_text": "In consegna",
      "estimated_delivery": "2023-01-01T19:45:00.000000Z",
      "delivery_person": {
        "name": "Mario Rossi",
        "phone": "+39 1122334455",
        "vehicle": "motorino"
      },
      "coordinates": {
        "lat": 45.4642,
        "lng": 9.1900,
        "last_update": "2023-01-01T19:40:00.000000Z"
      }
    }
    ```

## Errori Comuni

Tutti gli endpoint restituiscono errori nel seguente formato:

```json
{
  "message": "Messaggio di errore descrittivo",
  "errors": {
    "field_name": ["Messaggio di errore specifico"]
  },
  "code": 422
}
```

## Headers Comuni

- `Authorization: Bearer {token}` - Per endpoint che richiedono autenticazione
- `Content-Type: application/json` - Per richieste con body JSON
- `Accept: application/json` - Per richieste che si aspettano risposta JSON

## Paginazione

Tutti gli endpoint che restituiscono liste seguono il formato di paginazione standard di Laravel con le seguenti informazioni:

- `data`: Array di oggetti risultato
- `links`: Collegamenti per navigazione pagina (first, last, prev, next)
- `meta`: Informazioni di paginazione (current_page, last_page, per_page, total, ecc.)
