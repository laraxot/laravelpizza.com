# Specifiche Tecniche Autenticazione a Due Fattori (2FA)

## Panoramica
Documentazione tecnica per l'implementazione dell'autenticazione a due fattori per il portale <nome progetto>.

## Architettura

### Componenti Principali
1. **Backend API**
   - Generazione segreti 2FA
   - Verifica codici OTP
   - Gestione dispositivi fidati
   - Backup codes

2. **Frontend**
   - Setup iniziale 2FA
   - Inserimento codice OTP
   - Gestione dispositivi fidati
   - Recupero accesso con codici di backup

3. **Database**
   - Tabella `user_two_factor_auth`
   - Tabella `user_trusted_devices`
   - Tabella `user_backup_codes`

## Flusso di Autenticazione

### Setup Iniziale
1. Utente abilita 2FA dal profilo
2. Generazione segreto TOTP
3. Visualizzazione QR Code
4. Conferma con codice OTP
5. Generazione codici di backup
6. Salvataggio configurazione

### Accesso con 2FA
1. Login standard (email/password)
2. Se 2FA abilitato, richiesta codice OTP
3. Verifica codice
4. Opzione "Ricordami su questo dispositivo"
5. Accesso all'area riservata

## Specifiche Tecniche

### Algoritmi e Standard
- **Algoritmo TOTP**: SHA-1 (RFC 6238)
- **Lunghezza codice**: 6 cifre
- **Intervallo di validità**: 30 secondi
- **Tolleranza oraria**: ±1 intervallo
- **Formato segreto**: Base32

### Endpoint API
```
POST /api/v1/auth/2fa/enable
POST /api/v1/auth/2fa/disable
POST /api/v1/auth/2fa/verify
POST /api/v1/auth/2fa/backup-codes
POST /api/v1/auth/2fa/trust-device
```

### Sicurezza
- Rate limiting: 5 tentativi/ora per utente
- Logging dettagliato di tutti i tentativi
- Notifica email per operazioni sensibili
- Richiede riconferma password per modifiche alle impostazioni 2FA

## Requisiti di Sistema

### Backend
- PHP 8.2+
- Estensione GD per generazione QR Code
- NTP per sincronizzazione oraria

### Frontend
- Supporto JavaScript per generazione OTP lato client
- LocalStorage per dispositivi fidati
- Supporto per app autenticazione (Google Authenticator, Authy, etc.)

## Test
- [ ] Test unitari
- [ ] Test di integrazione
- [ ] Test di usabilità
- [ ] Test di sicurezza

## Documentazione Correlata
- [Panoramica Autenticazione](./README.md)
- [Piano di Implementazione 2FA](./2fa_piano.md)
- [Linee Guida Sicurezza](../sicurezza/2fa_security.md)

[← Torna all'elenco componenti](./README.md)
