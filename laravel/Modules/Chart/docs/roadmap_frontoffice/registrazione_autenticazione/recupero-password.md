# Recupero Password

## Panoramica
Documentazione del flusso di recupero password per gli utenti che hanno dimenticato le credenziali di accesso.

## Flusso di Recupero
1. Utente richiede il recupero password
2. Inserimento email nel form di recupero
3. Verifica esistenza email nel sistema
4. Generazione token di reset con scadenza 1h
5. Invio email con link di reset
6. Utente clicca sul link
7. Inserimento nuova password
8. Conferma nuova password
9. Aggiornamento credenziali nel sistema
10. Notifica di conferma all'utente

## Specifiche Tecniche

### Endpoint API
```
POST /api/v1/auth/forgot-password
POST /api/v1/auth/reset-password
```

### Requisiti Password
- Lunghezza minima: 12 caratteri
- Almeno 1 maiuscola
- Almeno 1 numero
- Almeno 1 carattere speciale
- Non può essere uguale alle ultime 5 password

## Sicurezza
- Token di reset monouso
- Scadenza token: 1 ora
- Rate limiting: 3 richieste/ora per indirizzo IP
- Logging di tutte le operazioni di reset
- Notifica all'utente in caso di richiesta di reset

## Documentazione Correlata
- [Panoramica Autenticazione](./README.md)
- [Login e Logout](./login_logout.md)
- [Politiche di Sicurezza](../sicurezza/politiche_password.md)

[← Torna all'elenco componenti](./README.md)
