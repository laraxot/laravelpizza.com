# Gestione Profilo Utente

## Panoramica
La sezione di gestione del profilo consente agli utenti di visualizzare e modificare le proprie informazioni personali, le preferenze e le impostazioni di sicurezza.

## Sezioni del Profilo

### 1. Dati Anagrafici
- Nome e cognome
- Data di nascita
- Codice Fiscale
- Luogo di nascita
- Indirizzo di residenza
- Recapiti (telefono, email)

### 2. Domicilio Sanitario
- Medico di base
- Struttura sanitaria di riferimento
- Codice STP/ENI (per stranieri)

### 3. Preferenze
- Lingua preferita
- Preferenze di notifica
- Consenso al trattamento dati
- Privacy settings

### 4. Sicurezza
- Cambio password
- Autenticazione a due fattori
- Dispositivi fidati
- Cronologia accessi

## Funzionalità

### Modifica Dati
1. L'utente clicca su "Modifica"
2. I campi diventano editabili
3. Modifica dei dati desiderati
4. Salvataggio delle modifiche
5. Verifica identità se necessario
6. Conferma dell'aggiornamento

### Cambio Email
1. Richiesta di modifica email
2. Verifica tramite email corrente
3. Inserimento nuova email
4. Conferma tramite link inviato
5. Aggiornamento credenziali

### Gestione Dispositivi Fidati
1. Visualizzazione dispositivi connessi
2. Nome personalizzato per ogni dispositivo
3. Possibilità di revocare l'accesso
4. Notifica per nuovi dispositivi

## API Endpoints

### GET /api/v1/patient/profile
Recupera i dati del profilo utente

### PUT /api/v1/patient/profile
Aggiorna i dati del profilo

### POST /api/v1/patient/change-email
Richiesta cambio email

### GET /api/v1/patient/devices
Lista dispositivi fidati

### DELETE /api/v1/patient/devices/{id}
Rimuove un dispositivo fidato

## Sicurezza
- Verifica identità per operazioni sensibili
- Log di tutte le modifiche
- Notifica per cambiamenti critici
- Blocco temporaneo dopo troppi tentativi

## Validazione Dati
- Formato corretto per email e telefono
- Validazione CF secondo algoritmo ufficiale
- Controllo completezza indirizzi
- Verifica CAP e comune

## Documentazione Correlata
- [Panoramica Area Personale](./README.md)
- [Politica sulla Privacy](../privacy/privacy_policy.md)
- [Linee Guida Sicurezza](../sicurezza/linee_guida.md)

[← Torna all'Area Personale](./README.md)
