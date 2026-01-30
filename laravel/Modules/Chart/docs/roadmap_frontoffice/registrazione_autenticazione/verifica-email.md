# Verifica Email

## Panoramica
Documentazione del processo di verifica dell'indirizzo email per i nuovi utenti.

## Flusso di Verifica
1. Dopo la registrazione, viene inviata un'email di verifica
2. L'email contiene un link con token univoco
3. Cliccando sul link, l'utente conferma la proprietà dell'email
4. L'account viene attivato e l'utente può effettuare il login
5. In caso di mancata ricezione, possibilità di richiedere un nuovo link

## Specifiche Tecniche

### Endpoint API
```
GET /api/v1/auth/verify-email/{token}
POST /api/v1/auth/resend-verification
```

### Token di Verifica
- Durata: 24 ore
- Formato: JWT firmato con chiave segreta
- Payload: { userId, email, exp }
- Monouso: sì

## Gestione Errori
- Token scaduto: richiedere un nuovo link
- Token non valido: notifica all'utente
- Account già verificato: reindirizzamento al login
- Troppi tentativi: temporaneamente bloccato

## Documentazione Correlata
- [Panoramica Autenticazione](./README.md)
- [Registrazione Pazienti](./registrazione_pazienti.md)
- [Template Email](../notifiche/email_templates.md)

[← Torna all'elenco componenti](./README.md)
