# Regole per lo Sviluppo

## Notifiche e Email

### 1. Validazione Dati
- ✅ Validare SEMPRE i dati in ingresso
- ✅ Usare le regole di validazione Laravel
- ✅ Verificare i tipi di dati
- ❌ Non assumere che i dati siano validi

### 2. Queueable Actions
- ✅ Usare Actions per la logica di business
- ✅ Separare la logica in Actions riutilizzabili
- ✅ Utilizzare le code per operazioni pesanti
- ❌ Non mischiare logica di business nel controller

### 3. Gestione Errori
- ✅ Usare try/catch per le operazioni critiche
- ✅ Loggare gli errori
- ✅ Fornire feedback appropriato
- ❌ Non ignorare gli errori

### 4. Struttura Codice
- ✅ Separare la logica in Actions
- ✅ Usare classi dedicate per le notifiche
- ✅ Documentare il codice
- ❌ Non mischiare responsabilità
- ❌ Non usare mai il segmento `App` nei namespace, anche se il file è in `app/`. Per i Data Object usare sempre `Modules\<NomeModulo>\Datas`. Vedi [PATH_AND_NAMESPACE_RULES.md](./PATH_AND_NAMESPACE_RULES.md) per dettagli.

### 5. Testing
- ✅ Testare con dati validi
- ✅ Verificare su vari canali
- ✅ Controllare i limiti
- ❌ Non assumere che funzioni

## Best Practices

### 1. Queueable Actions
- Mantenere Actions piccole e focalizzate
- Usare type hints per i parametri
- Documentare le dipendenze
- Gestire gli errori appropriatamente

### 2. Sicurezza
- Validare input
- Sanitizzare output
- Usare prepared statements
- Proteggere dati sensibili

### 3. Performance
- Ottimizzare query
- Usare cache quando possibile
- Minimizzare richieste
- Monitorare risorse

### 4. Manutenzione
- Aggiornare dipendenze
- Mantenere documentazione
- Fare code review
- Testare regolarmente

## Workflow

### 1. Sviluppo
1. Analizzare requisiti
2. Pianificare struttura
3. Implementare funzionalità
4. Testare codice
5. Documentare cambiamenti

### 2. Testing
1. Test unitari
2. Test integrazione
3. Test funzionali
4. Test performance

### 3. Deployment
1. Verificare ambiente
2. Eseguire migrazioni
3. Aggiornare cache
4. Monitorare errori

## Collegamenti Utili

- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [PHP The Right Way](https://phptherightway.com/)
- [Laravel Documentation](https://laravel.com/docs)
- [Spatie Queueable Action](https://github.com/spatie/laravel-queueable-action)
- [Laravel News](https://laravel-news.com/) 
