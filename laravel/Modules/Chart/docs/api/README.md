# API Documentation - <nome progetto>

> **🌐 OBIETTIVO**: Documentazione completa delle API REST per l'integrazione con il sistema <nome progetto>

## 📋 Overview

Le API di <nome progetto> forniscono accesso programmatico a tutte le funzionalità principali del sistema per l'integrazione con applicazioni esterne, sistemi sanitari e partner tecnologici.

## 🔑 Autenticazione

### JWT Token Authentication

```bash

# Login e ottenimento token
POST /api/auth/login
Content-Type: application/json

{
    "email": "paziente@example.com",
    "password": "password123"
}

# Response
{
    "success": true,
    "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "token_type": "bearer",
        "expires_in": 3600,
        "user": {
            "id": 1,
            "nome": "Maria",
            "cognome": "Rossi",
            "email": "maria.rossi@example.com",
            "role": "patient"
        }
    }
}
```

### Utilizzo Token

```bash

# Header per richieste autenticate
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...
Content-Type: application/json
Accept: application/json
```

### Rate Limiting

```bash

# Limiti per endpoint
Authentication: 10 requests/minute
General API: 60 requests/minute
File Upload: 5 requests/minute

# Headers di risposta
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
X-RateLimit-Reset: 1623456789
```

## 👥 Gestione Utenti

### Registrazione Paziente

```bash
POST /api/auth/register
Content-Type: application/json

{
    "nome": "Maria",
    "cognome": "Rossi",
    "email": "maria.rossi@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "codice_fiscale": "RSSMRA90A01H501Z",
    "telefono": "+39 345 1234567",
    "data_nascita": "1990-01-01",
    "settimane_gestazione": 20,
    "data_presunta_parto": "2025-08-15",
    "terms_accepted": true,
    "privacy_accepted": true
}
```

**Response:**
```json
{
    "success": true,
    "message": "Registrazione completata. Controlla la tua email per verificare l'account.",
    "data": {
        "user": {
            "id": 123,
            "nome": "Maria",
            "cognome": "Rossi",
            "email": "maria.rossi@example.com",
            "email_verified_at": null,
            "created_at": "2025-06-05T10:30:00.000000Z"
        }
    }
}
```

### Profilo Utente

```bash

# Ottieni profilo corrente
GET /api/user/profile
Authorization: Bearer {token}

# Response
{
    "success": true,
    "data": {
        "id": 1,
        "nome": "Maria",
        "cognome": "Rossi",
        "email": "maria.rossi@example.com",
        "codice_fiscale": "RSSMRA90A01H501Z",
        "telefono": "+39 345 1234567",
        "settimane_gestazione": 22,
        "data_presunta_parto": "2025-08-15",
        "documents_completed": true,
        "profile_completion": 95
    }
}
```

```bash

# Aggiorna profilo
PUT /api/user/profile
Authorization: Bearer {token}
Content-Type: application/json

{
    "telefono": "+39 345 9876543",
    "settimane_gestazione": 23,
    "indirizzo_completo": "Via Roma 123, Milano"
}
```

## 🏥 Gestione Studi

### Lista Studi

```bash
GET /api/studios
Authorization: Bearer {token}

# Parametri query opzionali
?lat=45.4642&lng=9.1900&radius=10&services[]=prima_visita&city=Milano

# Response
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nome": "Studio Dentistico Bianchi",
            "indirizzo_completo": "Via Garibaldi 45, 20121 Milano MI",
            "telefono": "+39 02 1234567",
            "email": "info@studiobianchi.it",
            "distanza_km": 2.5,
            "valutazione_media": 4.7,
            "numero_recensioni": 85,
            "servizi_disponibili": [
                "prima_visita",
                "igiene_orale",
                "odontoiatria_conservativa"
            ],
            "orari_apertura": {
                "lunedi": {"mattina": "09:00-13:00", "pomeriggio": "14:00-18:00"},
                "martedi": {"mattina": "09:00-13:00", "pomeriggio": "14:00-18:00"}
            },
            "prossima_disponibilita": "2025-06-08T09:00:00",
            "dentisti": [
                {
                    "id": 1,
                    "nome_completo": "Dr. Marco Bianchi",
                    "specializzazioni": ["odontoiatria_generale", "endodonzia"]
                }
            ]
        }
    ],
    "meta": {
        "total": 15,
        "per_page": 10,
        "current_page": 1,
        "last_page": 2
    }
}
```

### Dettagli Studio

```bash
GET /api/studios/{id}
Authorization: Bearer {token}

# Response
{
    "success": true,
    "data": {
        "id": 1,
        "nome": "Studio Dentistico Bianchi",
        "descrizione": "Studio specializzato in odontoiatria per donne in gravidanza",
        "indirizzo_completo": "Via Garibaldi 45, 20121 Milano MI",
        "telefono": "+39 02 1234567",
        "email": "info@studiobianchi.it",
        "sito_web": "https://www.studiobianchi.it",
        "partita_iva": "12345678901",
        "coordinate": {
            "latitude": 45.4642,
            "longitude": 9.1900
        },
        "servizi_offerti": [...],
        "dentisti": [...],
        "orari_apertura": {...},
        "certificazioni": [
            "ISO 9001:2015",
            "Autorizzazione Sanitaria ASL Milano"
        ],
        "foto_studio": [
            "https://api.<nome progetto>.it/storage/studios/1/photo1.jpg"
        ]
    }
}
```

## 📅 Disponibilità e Prenotazioni

### Disponibilità Studio

```bash
GET /api/studios/{id}/availability
Authorization: Bearer {token}

# Parametri query
?from=2025-06-08&to=2025-06-15&dentist_id=1&tipo_visita=prima_visita

# Response
{
    "success": true,
    "data": [
        {
            "id": 101,
            "data_ora": "2025-06-08T09:00:00",
            "durata_minuti": 60,
            "tipo_visita": "prima_visita",
            "dentista": {
                "id": 1,
                "nome_completo": "Dr. Marco Bianchi"
            },
            "servizi_disponibili": [
                {
                    "id": 1,
                    "nome": "Prima Visita",
                    "descrizione": "Visita completa iniziale"
                },
                {
                    "id": 2,
                    "nome": "Igiene Orale",
                    "descrizione": "Pulizia professionale"
                }
            ],
            "note": "Slot riservato a prime visite",
            "disponibile": true
        }
    ]
}
```

### Creazione Appuntamento

```bash
POST /api/appointments
Authorization: Bearer {token}
Content-Type: application/json

{
    "availability_id": 101,
    "servizi": [1, 2],
    "note_paziente": "Ho urgenza per un controllo",
    "termini_accettati": true,
    "privacy_accettata": true
}

# Response
{
    "success": true,
    "message": "Appuntamento creato con successo",
    "data": {
        "id": 501,
        "codice_prenotazione": "SO250608A001",
        "data_appuntamento": "2025-06-08T09:00:00",
        "durata_minuti": 60,
        "stato": "confermato",
        "studio": {
            "nome": "Studio Dentistico Bianchi",
            "indirizzo": "Via Garibaldi 45, 20121 Milano MI",
            "telefono": "+39 02 1234567"
        },
        "dentista": {
            "nome_completo": "Dr. Marco Bianchi"
        },
        "servizi": [
            {"nome": "Prima Visita"},
            {"nome": "Igiene Orale"}
        ]
    }
}
```

### Gestione Appuntamenti

```bash

# Lista appuntamenti paziente
GET /api/appointments
Authorization: Bearer {token}

# Parametri query
?status=confermato&from=2025-06-01&to=2025-06-30

# Response
{
    "success": true,
    "data": [
        {
            "id": 501,
            "codice_prenotazione": "SO250608A001",
            "data_appuntamento": "2025-06-08T09:00:00",
            "durata_minuti": 60,
            "tipo_visita": "prima_visita",
            "stato": "confermato",
            "note_paziente": "Ho urgenza per un controllo",
            "studio": {...},
            "dentista": {...},
            "servizi": [...]
        }
    ]
}
```

```bash

# Dettagli appuntamento
GET /api/appointments/{id}
Authorization: Bearer {token}

# Modifica appuntamento
PUT /api/appointments/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "note_paziente": "Note aggiornate"
}

# Cancellazione appuntamento
DELETE /api/appointments/{id}
Authorization: Bearer {token}
```

## 📄 Gestione Documenti

### Upload Documento

```bash
POST /api/documents/upload
Authorization: Bearer {token}
Content-Type: multipart/form-data

tipo_documento=tessera_sanitaria
file=@tessera_sanitaria.pdf

# Response
{
    "success": true,
    "message": "Documento caricato con successo",
    "data": {
        "id": 201,
        "tipo_documento": "tessera_sanitaria",
        "nome_file": "tessera_sanitaria.pdf",
        "dimensione_file": 2048576,
        "stato_verifica": "in_verifica",
        "data_caricamento": "2025-06-05T10:30:00Z",
        "data_scadenza": "2025-12-31"
    }
}
```

### Lista Documenti

```bash
GET /api/documents
Authorization: Bearer {token}

# Response
{
    "success": true,
    "data": [
        {
            "id": 201,
            "tipo_documento": "tessera_sanitaria",
            "tipo_documento_label": "Tessera Sanitaria",
            "nome_file": "tessera_sanitaria.pdf",
            "dimensione_file": 2048576,
            "stato_verifica": "verificato",
            "data_caricamento": "2025-06-05T10:30:00Z",
            "data_scadenza": "2025-12-31",
            "download_url": "/api/documents/201/download"
        }
    ]
}
```

### Download Documento

```bash
GET /api/documents/{id}/download
Authorization: Bearer {token}

# Response: File binario con headers appropriati
Content-Type: application/pdf
Content-Disposition: attachment; filename="tessera_sanitaria.pdf"
```

## 🔔 Sistema Notifiche

### Preferenze Notifiche

```bash
GET /api/notifications/preferences
Authorization: Bearer {token}

# Response
{
    "success": true,
    "data": {
        "email_enabled": true,
        "sms_enabled": false,
        "push_enabled": true,
        "appointment_reminders": true,
        "appointment_confirmations": true,
        "promotional_emails": false,
        "system_updates": true
    }
}
```

```bash
PUT /api/notifications/preferences
Authorization: Bearer {token}
Content-Type: application/json

{
    "email_enabled": true,
    "sms_enabled": true,
    "appointment_reminders": true
}
```

### Notifiche Ricevute

```bash
GET /api/notifications
Authorization: Bearer {token}

# Parametri query
?read=false&type=appointment&limit=20

# Response
{
    "success": true,
    "data": [
        {
            "id": "uuid-notification-id",
            "type": "appointment_confirmed",
            "title": "Appuntamento Confermato",
            "message": "Il tuo appuntamento del 08/06/2025 alle 09:00 è stato confermato",
            "data": {
                "appointment_id": 501,
                "studio_name": "Studio Dentistico Bianchi"
            },
            "read_at": null,
            "created_at": "2025-06-05T10:30:00Z"
        }
    ]
}
```

## ⚕️ API Studi Odontoiatrici

### Gestione Appuntamenti Studio

```bash

# Lista appuntamenti studio
GET /api/studio/appointments
Authorization: Bearer {studio_token}

# Parametri query
?date=2025-06-08&dentist_id=1&status=confermato

# Response
{
    "success": true,
    "data": [
        {
            "id": 501,
            "data_appuntamento": "2025-06-08T09:00:00",
            "patient": {
                "nome_completo": "Maria Rossi",
                "telefono": "+39 345 1234567",
                "settimane_gestazione": 22
            },
            "dentista": {...},
            "servizi": [...],
            "stato": "confermato",
            "note_paziente": "Ho urgenza per un controllo"
        }
    ]
}
```

### Aggiornamento Stato Appuntamento

```bash
PUT /api/studio/appointments/{id}/status
Authorization: Bearer {studio_token}
Content-Type: application/json

{
    "stato": "completato",
    "note_post_visita": "Visita completata. Controllo tra 6 mesi.",
    "servizi_effettuati": [1, 2]
}
```

### Gestione Disponibilità

```bash

# Crea slot disponibilità
POST /api/studio/availability
Authorization: Bearer {studio_token}
Content-Type: application/json

{
    "dentista_id": 1,
    "data_ora": "2025-06-15T14:00:00",
    "durata_minuti": 60,
    "tipo_visita": "controllo",
    "note": "Slot per controlli periodici"
}

# Elimina slot
DELETE /api/studio/availability/{id}
Authorization: Bearer {studio_token}
```

## 📊 Analytics e Reporting

### Statistiche Studio

```bash
GET /api/studio/analytics
Authorization: Bearer {studio_token}

# Parametri query
?period=month&year=2025&month=6

# Response
{
    "success": true,
    "data": {
        "appuntamenti": {
            "totali": 45,
            "completati": 42,
            "annullati": 2,
            "no_show": 1
        },
        "pazienti": {
            "nuovi": 15,
            "ricorrenti": 30,
            "settimane_gestazione_media": 24.5
        },
        "performance": {
            "tasso_occupazione": 87.5,
            "tempo_medio_visita": 52,
            "valutazione_media": 4.8
        }
    }
}
```

## 🔐 Webhooks

### Configurazione Webhook

```bash
POST /api/webhooks
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "url": "https://studio.example.com/webhooks/<nome progetto>",
    "events": [
        "appointment.created",
        "appointment.cancelled",
        "document.verified"
    ],
    "secret": "webhook_secret_key"
}
```

### Eventi Webhook

```json
// appointment.created
{
    "event": "appointment.created",
    "data": {
        "appointment": {
            "id": 501,
            "studio_id": 1,
            "patient_id": 123,
            "data_appuntamento": "2025-06-08T09:00:00",
            "stato": "confermato"
        }
    },
    "timestamp": "2025-06-05T10:30:00Z"
}
```

## ❌ Gestione Errori

### Codici di Stato HTTP

```bash
200 - OK: Richiesta completata con successo
201 - Created: Risorsa creata con successo
400 - Bad Request: Dati richiesta non validi
401 - Unauthorized: Token non valido o mancante
403 - Forbidden: Accesso negato
404 - Not Found: Risorsa non trovata
422 - Unprocessable Entity: Validazione fallita
429 - Too Many Requests: Rate limit superato
500 - Internal Server Error: Errore interno del server
```

### Formato Errori

```json
{
    "success": false,
    "error": {
        "code": "VALIDATION_ERROR",
        "message": "I dati forniti non sono validi.",
        "details": {
            "email": ["Il campo email è obbligatorio."],
            "password": ["Il campo password deve contenere almeno 8 caratteri."]
        }
    },
    "debug": {
        "trace_id": "abc123def456",
        "timestamp": "2025-06-05T10:30:00Z"
    }
}
```

## 📚 SDK e Librerie

### JavaScript/TypeScript

```bash
npm install @<nome progetto>/api-client

# Utilizzo
import { <nome progetto>Client } from '@<nome progetto>/api-client';

const client = new <nome progetto>Client({
    baseURL: 'https://api.<nome progetto>.it',
    apiKey: 'your-api-key'
});

// Ottenere lista studi
const studios = await client.studios.list({
    lat: 45.4642,
    lng: 9.1900,
    radius: 10
});

// Creare appuntamento
const appointment = await client.appointments.create({
    availability_id: 101,
    servizi: [1, 2],
    note_paziente: 'Note paziente'
});
```

### PHP

```bash
composer require <nome progetto>/api-client

# Utilizzo
use <nome progetto>\ApiClient\Client;

$client = new Client([
    'base_uri' => 'https://api.<nome progetto>.it',
    'api_key' => 'your-api-key'
]);

// Ottenere profilo paziente
$profile = $client->user()->profile();

// Lista appuntamenti
$appointments = $client->appointments()->list([
    'status' => 'confermato'
]);
```

## 🔗 Link Utili

### Documentazione Correlata
- [Documentazione Tecnica](../technical/README.md)
- [Setup Ambiente Sviluppo](../roadmap_frontoffice/setup_ambiente_sviluppo.md)
- [Sistema Notifiche](../roadmap_frontoffice/notifiche/README.md)

### Strumenti di Sviluppo
- **API Testing**: Postman Collection disponibile
- **OpenAPI Spec**: `/api/documentation`
- **Sandbox Environment**: `https://sandbox-api.<nome progetto>.it`

### Supporto
- **Email Tecnico**: api-support@<nome progetto>.it
- **Documentazione Live**: https://docs.<nome progetto>.it
- **Status Page**: https://status.<nome progetto>.it

---

**📅 Ultimo aggiornamento**: 5 Giugno 2025  
**🔄 Versione API**: v1.2  
