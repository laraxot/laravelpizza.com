# Login e Logout

## Panoramica
Documentazione dettagliata del sistema di autenticazione e gestione della sessione.

## Flusso di Accesso

### Login
1. Utente inserisce email e password
2. Validazione lato client
3. Richiesta al server con credenziali
4. Verifica credenziali e stato account
5. Generazione token JWT
6. Impostazione cookie di sessione
7. Reindirizzamento all'area riservata

### Logout
1. Eliminazione token JWT lato client
2. Invalido token lato server
3. Pulizia cookie di sessione
4. Reindirizzamento alla homepage

## Specifiche Tecniche

### Endpoint API
```
POST /api/v1/auth/login
POST /api/v1/auth/logout
```

### Sicurezza
- Token JWT con scadenza 8 ore
- Refresh token con scadenza 7 giorni
- Protezione contro attacchi CSRF
- Rate limiting: 10 tentativi/ora per utente
- Blocco account dopo 5 tentativi falliti

## Documentazione Correlata
- [Panoramica Autenticazione](./README.md)
- [Registrazione Pazienti](./registrazione_pazienti.md)
- [Recupero Password](./recupero_password.md)

[← Torna all'elenco componenti](./README.md)
