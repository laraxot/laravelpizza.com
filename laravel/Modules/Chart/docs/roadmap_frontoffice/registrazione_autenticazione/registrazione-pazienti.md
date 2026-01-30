# Registrazione Pazienti

## Panoramica
Documentazione dettagliata del flusso di registrazione pazienti per il portale <nome progetto>.

## Requisiti Funzionali
- [x] Form di registrazione con validazione lato client e server
- [x] Verifica dell'email obbligatoria
- [x] Accettazione privacy policy e termini di servizio
- [x] Controllo duplicati email/CF
- [x] Integrazione con sistema di notifiche

## Specifiche Tecniche

### Endpoint API
```
POST /api/v1/auth/register
```

### Campi Richiesti
| Campo | Tipo | Obbligatorio | Note |
|-------|------|--------------|------|
| email | string | Sì | Deve essere un'email valida |
| password | string | Sì | Min 12 caratteri, maiuscole, numeri |
| nome | string | Sì | Solo lettere e spazi |
| cognome | string | Sì | Solo lettere e spazi |
| codice_fiscale | string | Sì | Formato valido CF |
| data_nascita | date | Sì | Formato YYYY-MM-DD |
| telefono | string | No | Formato internazionale |
| accetta_termini | boolean | Sì | Deve essere true |

### Flusso di Registrazione
1. Utente compila il form
2. Validazione lato client
3. Invio dati al server
4. Creazione record utente con stato "in attesa di verifica"
5. Invio email di verifica
6. Conferma tramite link nell'email
7. Attivazione account

## Sicurezza
- Password crittografate con bcrypt
- Token di verifica con scadenza 24h
- Rate limiting: 5 tentativi/ora per indirizzo IP
- Protezione CSRF
- Logging di sicurezza per tentativi sospetti

## Test
- [x] Test unitari
- [x] Test di integrazione
- [x] Test di carico
- [x] Test di sicurezza OWASP

## Documentazione Correlata
- [Panoramica Autenticazione](./README.md)
- [Specifiche Sicurezza](../sicurezza/autenticazione_sicurezza.md)
- [API Reference](../api/auth_api.md)

[← Torna all'elenco componenti](./README.md)
