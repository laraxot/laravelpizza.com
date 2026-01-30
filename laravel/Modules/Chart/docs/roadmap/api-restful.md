# Definizione Struttura API RESTful

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Attuale

La definizione della struttura API RESTful per il progetto il progetto è attualmente completata al 40%. Questa componente è fondamentale per consentire l'integrazione con sistemi esterni e supportare applicazioni mobile e web.

## Obiettivi dell'Implementazione

L'API RESTful di il progetto mira a:

1. Fornire un'interfaccia programmatica completa per tutte le funzionalità del sistema
2. Garantire interoperabilità con sistemi esterni (ospedali, cliniche, SSN)
3. Supportare lo sviluppo di applicazioni mobile native
4. Permettere integrazioni con servizi di terze parti
5. Mantenere elevati standard di sicurezza e performance

## Componenti Implementati (40%)

- ✅ Definizione delle convenzioni di naming e struttura degli endpoint
- ✅ Implementazione del sistema di autenticazione base (parziale)
- ✅ Struttura base dei controller API per il modulo Patient
- ✅ Implementazione Resource e Collection per la trasformazione dei dati
- ✅ Validazione degli input con form request
- ✅ Gestione errori standardizzata

## Componenti da Implementare (60%)

- 🚧 Completamento endpoint CRUD per tutti i moduli principali (30%)
- 🚧 Implementazione versioning delle API (10%)
- 🚧 Documentazione OpenAPI/Swagger completa (20%)
- 🚧 Rate limiting e throttling configurabile (15%)
- 🚧 Sistema di autorizzazione granulare basato su scopes (25%)
- 🚧 Integrazione completa autenticazione OAuth2 (20%)
- 📅 Gestione caching intelligente
- 📅 Implementazione API analytics e metriche

## Architettura API

L'architettura delle API segue il pattern REST con le seguenti caratteristiche:

```
/api/v1/{module}/{resource}/{id?}/{relation?}
```

### Esempio per il modulo Patient

```
GET    /api/v1/patient/patients          # Lista pazienti
POST   /api/v1/patient/patients          # Creazione paziente
GET    /api/v1/patient/patients/{id}     # Dettaglio paziente
PUT    /api/v1/patient/patients/{id}     # Aggiornamento paziente
DELETE /api/v1/patient/patients/{id}     # Eliminazione paziente
GET    /api/v1/patient/patients/{id}/appointments  # Appuntamenti del paziente
```

## Standard Implementati

- Utilizzo di codici HTTP appropriati (200, 201, 400, 401, 403, 404, 422, 500)
- Risposte JSON standardizzate con struttura coerente
- Paginazione con meta-informazioni
- Filtri e ordinamento tramite query parameters
- Selezione campi tramite parametro `fields`
- Inclusione risorse correlate tramite parametro `include`

## Sicurezza API

La sicurezza delle API è garantita attraverso:

1. **Autenticazione**:
   - Token JWT / OAuth2
   - Refresh token automatico
   - Revoca token

2. **Autorizzazione**:
   - RBAC (Role-Based Access Control)
   - Scopes per permessi granulari
   - Filtro automatico dei risultati in base ai permessi

3. **Protezione**:
   - HTTPS obbligatorio
   - CORS configurato
   - Rate limiting e throttling
   - Protezione CSRF per endpoint sensibili

## Documentazione API

La documentazione delle API sarà generata automaticamente utilizzando OpenAPI/Swagger:

```php
/**
 * @OA\Get(
 *     path="/api/v1/patient/patients",
 *     summary="Recupera la lista dei pazienti",
 *     @OA\Response(
 *         response=200,
 *         description="Lista dei pazienti restituita con successo"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non autorizzato"
 *     )
 * )
 */
```

## Calendar di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| CRUD moduli principali | Maggio 2024 | Alta |
| Documentazione OpenAPI | Maggio 2024 | Alta |
| Autenticazione OAuth2 | Giugno 2024 | Alta |
| Rate limiting | Giugno 2024 | Media |
| Versioning | Luglio 2024 | Media |
| Caching | Luglio 2024 | Bassa |

## Risorse Assegnate

- 2 Backend Developer (60% tempo)
- 1 Security Specialist (20% tempo)
- 1 Technical Writer (30% tempo per documentazione)

## Integrazione con Frontend

L'API RESTful sarà utilizzata da:

- Applicazione SPA (Single Page Application)
- Applicazione mobile (iOS e Android)
- Integrazioni di terze parti

## Metriche di Successo

- Tempo medio di risposta < 200ms
- Copertura della documentazione 100%
- Numero di endpoint implementati vs pianificati
- Tasso di errori < 0.1%
- Soddisfazione sviluppatori > 4.5/5
