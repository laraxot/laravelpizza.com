# Troubleshooting Email

## Errori Comuni e Soluzioni

### 1. Errore Destinatario Mancante
**Errore**: `Symfony\Component\Mime\Exception\LogicException: An email must have a "To", "Cc", or "Bcc" header.`

**Causa**: 
- Il destinatario dell'email non è stato specificato correttamente
- Il valore del destinatario è null o vuoto
- Il formato del destinatario non è valido

**Soluzione**:
1. Verificare che il campo 'to' sia presente e valido
2. Assicurarsi che il valore non sia null
3. Verificare il formato dell'email
4. Controllare che il destinatario sia specificato prima dell'invio

### 2. TypeError con Allegati
**Errore**: `TypeError: Cannot access offset of type string on string`

**Causa**: Formato errato degli allegati nell'email.

**Soluzione**: 
- Utilizzare il formato corretto per gli allegati (array di array)
- Verificare la struttura dei dati passati a `addAttachments()`
- Consultare la documentazione completa in `ATTACHMENTS.md`

### 3. Errori di Template
**Errore**: Template non trovato o non valido

**Causa**: 
- Percorso errato del template
- Template non registrato nel database
- Problemi di cache

**Soluzione**:
- Verificare il percorso del template
- Controllare la registrazione nel database
- Pulire la cache: `php artisan cache:clear`

### 4. Problemi di Localizzazione
**Errore**: Stringhe non tradotte o traduzioni mancanti

**Causa**:
- File di traduzione mancanti
- Chiavi di traduzione non corrette
- Locale non impostato correttamente

**Soluzione**:
- Verificare i file di traduzione
- Controllare le chiavi di traduzione
- Impostare il locale corretto: `Mail::to($user)->locale('it')`

### 5. Errori di Layout
**Errore**: Layout non renderizzato correttamente

**Causa**:
- Problemi con il layout base
- Stili CSS non supportati
- Tag HTML non validi

**Soluzione**:
- Verificare il layout base
- Utilizzare stili inline
- Testare in diversi client email

### 6. Problemi di Invio
**Errore**: Email non inviata

**Causa**:
- Configurazione SMTP errata
- Problemi di autenticazione
- Limiti del server

**Soluzione**:
- Verificare la configurazione SMTP
- Controllare le credenziali
- Monitorare i log del server

## Best Practices per il Debug

### 1. Logging
- Abilitare il logging dettagliato
- Monitorare i log di Laravel
- Utilizzare `Mail::failures()`

### 2. Testing
- Testare in ambiente di sviluppo
- Verificare con diversi client email
- Utilizzare strumenti di test email

### 3. Monitoraggio
- Implementare sistema di tracking
- Monitorare le statistiche di invio
- Tracciare i fallimenti

## Strumenti Utili

### 1. Debug Tools
- Mailtrap per testing
- Email on Acid per compatibilità
- Litmus per preview

### 2. Validatori
- HTML Email Validator
- CSS Inliner
- MIME Type Checker

### 3. Monitoraggio
- Log di Laravel
- Analytics email
- Report di consegna

## Note Importanti
- Mantenere aggiornata la documentazione
- Testare regolarmente i template
- Monitorare le performance
- Implementare gestione errori
- Documentare le soluzioni 
