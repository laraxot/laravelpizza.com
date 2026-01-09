# Filament Resources - Modulo GDPR

## Panoramica

Questo documento descrive le risorse Filament disponibili nel modulo GDPR e come utilizzarle.

## Risorse Disponibili

### 1. ConsentResource

Gestisce i consensi degli utenti per il trattamento dei dati personali.

#### Funzionalità

- Creazione e modifica dei consensi
- Visualizzazione dello storico dei consensi
- Gestione delle revoche
- Tracciamento delle modifiche

#### Campi

- `user_id`: ID dell'utente che ha fornito il consenso
- `type`: Tipo di consenso (es. marketing, newsletter)
- `status`: Stato del consenso (attivo/revocato)
- `ip_address`: Indirizzo IP da cui è stato fornito il consenso
- `timestamp`: Data e ora del consenso

### 2. DataRequestResource

Gestisce le richieste di accesso, modifica o cancellazione dei dati personali.

#### Funzionalità

- Gestione delle richieste di accesso ai dati
- Tracciamento dello stato delle richieste
- Esportazione dei dati
- Notifiche automatiche

#### Campi

- `user_id`: ID dell'utente che ha fatto la richiesta
- `type`: Tipo di richiesta (accesso/modifica/cancellazione)
- `status`: Stato della richiesta
- `notes`: Note aggiuntive
- `completed_at`: Data di completamento

## Collegamenti

- [Documentazione Generale GDPR](./readme.md)
- [Documentazione Generale GDPR](./README.md)
- [Configurazione del Modulo](./configuration.md)
- [Gestione dei Consensi](./consent-management.md)
