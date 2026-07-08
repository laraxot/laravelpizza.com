# Troubleshooting SMS

## Errori Comuni e Soluzioni

### 1. Errore di Autenticazione
**Errore**: `Authentication failed` o `Invalid API key`

**Cause**:
- API key non valida o scaduta
- Credenziali non configurate correttamente
- Problemi di rete

**Soluzione**:
1. Verificare le credenziali nel file `.env`
2. Controllare la validità dell'API key
3. Verificare la connessione di rete
4. Controllare i log per dettagli specifici

### 2. Errore di Validazione Numero
**Errore**: `Invalid phone number format`

**Cause**:
- Formato numero non valido
- Prefisso internazionale mancante
- Caratteri non numerici

**Soluzione**:
1. Verificare il formato del numero (+39XXXXXXXXXX)
2. Aggiungere il prefisso internazionale
3. Rimuovere caratteri speciali
4. Utilizzare la validazione configurata

### 3. Errore di Rate Limit
**Errore**: `Rate limit exceeded`

**Cause**:
- Troppe richieste in breve tempo
- Limiti del provider superati
- Configurazione rate limit non corretta

**Soluzione**:
1. Implementare coda per gli invii
2. Aumentare i limiti nel provider
3. Ottimizzare la frequenza di invio
4. Utilizzare il rate limiting configurato

### 4. Errore di Template
**Errore**: `Template not found` o `Invalid template variables`

**Cause**:
- Template non esistente
- Variabili mancanti
- Sintassi template errata

**Soluzione**:
1. Verificare l'esistenza del template
2. Controllare le variabili richieste
3. Validare la sintassi del template
4. Testare il rendering

### 5. Errore di Connessione
**Errore**: `Connection failed` o `Timeout`

**Cause**:
- Problemi di rete
- Server non raggiungibile
- Timeout configurazione

**Soluzione**:
1. Verificare la connessione di rete
2. Controllare i firewall
3. Aumentare i timeout
4. Implementare retry mechanism

## Logging e Monitoraggio

### 1. Struttura Log
```json
{
    "timestamp": "2024-03-20 10:00:00",
    "level": "error",
    "message": "SMS sending failed",
    "context": {
        "recipient": "+393331234567",
        "template": "welcome",
        "error": "Invalid phone number",
        "provider": "smsfactor"
    }
}
```

### 2. Monitoraggio
- Tasso di consegna
- Tempi di risposta
- Errori per provider
- Costi per provider

## Best Practices

### 1. Validazione
- Verificare numeri prima dell'invio
- Validare template e variabili
- Controllare limiti e quote
- Testare in ambiente di sviluppo

### 2. Gestione Errori
- Implementare retry mechanism
- Logging dettagliato
- Notifiche di errore
- Monitoraggio continuo

### 3. Performance
- Utilizzare code per invii massivi
- Ottimizzare template
- Caching quando possibile
- Monitorare risorse

### 4. Sicurezza
- Proteggere API keys
- Validare input
- Rate limiting
- Logging sicuro

## Strumenti di Debug

### 1. Comandi Artisan
```bash

# Test connessione provider
php artisan sms:test-connection

# Verifica template
php artisan sms:validate-template welcome

# Test invio
php artisan sms:test-send +393331234567
```

### 2. Logging
```php
// Abilitare debug logging
Log::debug('SMS Debug', [
    'recipient' => $number,
    'template' => $template,
    'variables' => $variables
]);
```

### 3. Monitoraggio
- Dashboard provider
- Log Laravel
- Metriche applicazione
- Alert system

## Riferimenti

### 1. Documentazione Provider
- [SMSFactor](https://www.smsfactor.com)
- [Twilio](https://www.twilio.com/docs)
- [Nexmo](https://developer.nexmo.com)
- [Plivo](https://www.plivo.com/docs)

### 2. Risorse Utili
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queue](https://laravel.com/docs/queues)
- [Laravel Logging](https://laravel.com/docs/logging)
- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Logging](https://laravel.com/docs/logging)- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queue](https://laravel.com/project_docs/queues)
- [Laravel Logging](https://laravel.com/project_docs/logging)

## Supporto

### 1. Canali di Supporto
- Email: support@example.com
- Ticket System: https://support.example.com
- Documentazione: https://docs.example.com

### 2. SLA
- Risposta entro 24h
- Risoluzione entro 48h
- Supporto 24/7 per criticità

## Manutenzione

### 1. Backup
- Backup giornaliero configurazioni
- Backup template
- Backup log

### 2. Aggiornamenti
- Monitoraggio versioni
- Test compatibilità
- Piano rollback

### 3. Monitoraggio
- Check periodici
- Alert system
- Report mensili 
