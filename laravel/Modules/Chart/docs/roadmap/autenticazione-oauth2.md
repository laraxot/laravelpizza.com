# Implementazione Autenticazione OAuth2

> [Torna alla Roadmap Principale](../roadmap.md#q2-2024-aprile-giugno)

## Stato Attuale

L'implementazione dell'autenticazione OAuth2 per le API di il progetto è attualmente completata al 20%. Questa componente è essenziale per garantire un accesso sicuro e controllato alle API del sistema.

## Obiettivi dell'Implementazione

L'autenticazione OAuth2 in il progetto mira a:

1. Fornire un sistema di autenticazione robusto e standard
2. Supportare diverse tipologie di client (web, mobile, server)
3. Gestire autorizzazioni granulari attraverso scope
4. Implementare il rinnovo automatico dei token
5. Garantire una gestione sicura delle credenziali

## Componenti Implementati (20%)

- ✅ Installazione e configurazione base di Laravel Passport
- ✅ Definizione dei modelli di base per client e token
- ✅ Configurazione delle rotte OAuth2 standard

## Componenti da Implementare (80%)

- 🚧 Implementazione completa dei grant type (15%)
  - 🚧 Authorization Code Grant
  - 🚧 Client Credentials Grant
  - 🚧 Password Grant
  - 🚧 Refresh Token Grant
- 🚧 Definizione e implementazione degli scope (10%)
- 🚧 Personalizzazione del processo di autenticazione (5%)
- 🚧 Integrazione con il sistema multi-tenant (0%)
- 🚧 Implementazione revoca token (10%)
- 🚧 UI per la gestione client e autorizzazioni (0%)
- 📅 Sistema di monitoraggio accessi
- 📅 Implementazione di PKCE per client pubblici

## Architettura OAuth2

```
┌───────────────┐     (1) Authorization Request     ┌──────────────┐
│               │─────────────────────────────────> │              │
│               │                                   │              │
│  Client App   │                                   │   Resource   │
│               │                                   │    Owner     │
│               │     (2) Authorization Grant       │  (Paziente/  │
│               │ <───────────────────────────────  │   Operatore) │
└───────┬───────┘                                   └──────────────┘
        │                                                
        │ (3) Authorization Grant                      
        ▼                                           
┌───────────────┐     (4) Access Token              ┌──────────────┐
│               │ <───────────────────────────────  │              │
│ Authorization │                                   │              │
│    Server     │     (5) Access Token              │   Resource   │
│  (il progetto)  │─────────────────────────────────> │    Server    │
│               │                                   │  (API REST)  │
│               │     (6) Protected Resource        │              │
│               │ <───────────────────────────────  │              │
└───────────────┘                                   └──────────────┘
```

## Grant Types Supportati

### 1. Authorization Code Grant
Per applicazioni web con backend server, offre il massimo livello di sicurezza:

```
+----------+
| Resource |
|   Owner  |
|          |
+----------+
     ^
     |
    (B)
     |
     v
+---------+                                           +---------------+
|         |---(A)-- Authorization Request ----------->|               |
|         |                                           |               |
|         |<---(C)--- Authorization Code -------------|               |
|         |                                           |               |
|  Client |                                           | Authorization |
|         |                                           |     Server    |
|         |---(D)--- Authorization Code ------------->|               |
|         |          & Redirect URI                   |               |
|         |                                           |               |
|         |<---(E)--- Access Token ------------------|               |
+---------+       (w/ Optional Refresh Token)        +---------------+
```

### 2. Password Grant
Per applicazioni "first-party" che richiedono username e password:

```
+----------+
| Resource |
|  Owner   |
|          |
+----------+
     v
     |    Resource Owner
    (A) Password Credentials
     |
     v
+---------+                                  +---------------+
|         |>--(B)---- Resource Owner ------->|               |
|         |         Password Credentials     |               |
|         |                                  |               |
|         |<--(C)---- Access Token ----------|               |
|  Client |           (w/ Optional           |  Authorization|
|         |          Refresh Token)          |     Server    |
|         |                                  |               |
|         |>--(D)---- Access Token --------->|               |
|         |           (w/ Optional           |               |
|         |          Refresh Token)          |               |
+---------+                                  +---------------+
```

## Implementazione Scopes

Gli scope definiscono i permessi di accesso alle risorse. Gli scope pianificati includono:

```
read:patients       - Lettura dati pazienti
write:patients      - Modifica dati pazienti
read:appointments   - Lettura appuntamenti
write:appointments  - Creazione/modifica appuntamenti
read:treatments     - Lettura trattamenti
write:treatments    - Creazione/modifica trattamenti
admin              - Accesso completo (solo amministratori)
```

## Sicurezza

L'implementazione includerà:

1. **Protezione contro attacchi**:
   - CSRF Protection
   - Token Binding
   - Rate Limiting

2. **Validazione dei Client**:
   - Validazione origine
   - Redirect URI whitelist
   - Client authentication

3. **Gestione Token**:
   - Token scadenza configurabile
   - Revoca token
   - Refresh token rotation

## Calendario di Completamento

| Funzionalità | Completamento Previsto | Priorità |
|--------------|------------------------|----------|
| Grant types base | Maggio 2024 | Alta |
| Scopes | Maggio 2024 | Alta |
| Integrazione multi-tenant | Giugno 2024 | Alta |
| UI gestione | Giugno 2024 | Media |
| Monitoraggio | Luglio 2024 | Media |
| PKCE | Luglio 2024 | Media |

## Risorse Assegnate

- 1 Backend Developer (40% tempo)
- 1 Security Specialist (20% tempo)

## Dipendenze Tecniche

```json
{
  "require": {
    "laravel/passport": "*",
    "nyholm/psr7": "*",
    "league/oauth2-server": "*"
  }
}
```

## Riferimenti

- [OAuth 2.0 RFC 6749](https://tools.ietf.org/html/rfc6749)
- [Laravel Passport Documentation](https://laravel.com/docs/10.x/passport)
- [The OAuth 2.0 Authorization Framework: Bearer Token Usage](https://tools.ietf.org/html/rfc6750)
