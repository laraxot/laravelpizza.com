# Troubleshooting: {COMPONENT_NAME}

## 🚨 Problemi Comuni

### Errore: {ERROR_TYPE_1}
**Sintomi**:
- Descrizione del comportamento osservato
- Messaggi di errore specifici

**Cause Possibili**:
- Causa principale più probabile
- Cause secondarie

**Soluzione**:
1. Step 1 della risoluzione
2. Step 2 della risoluzione
3. Verifica finale

**Prevenzione**:
- Come evitare il problema in futuro

---

### Errore: {ERROR_TYPE_2}
**Sintomi**:
- Descrizione del comportamento osservato

**Diagnosi Rapida**:
```bash

# Comandi per diagnosticare
php artisan {command}
```

**Soluzione**:
```php
// Codice di fix
```

## 🔍 Strumenti di Diagnosi

### Log Files
- `storage/logs/laravel.log` - Log applicazione
- `storage/logs/query.log` - Log query database

### Comandi Utili
```bash

# PHPStan analysis
./vendor/bin/phpstan analyze --level=9

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Debug mode
php artisan tinker
```

## 📊 Metriche e Monitoring

### Performance
- Tempo di risposta atteso: < 200ms
- Memory usage: < 128MB
- Query count: < 10 per request

### Indicatori di Salute
- [ ] Tutti i test passano
- [ ] PHPStan level 9 pulito
- [ ] Nessun warning nei log
- [ ] Response time nella norma

## 🆘 Escalation

### Quando Escalare
- Errore critico che blocca la produzione
- Performance degradation > 50%
- Data corruption o perdita dati

### Informazioni da Raccogliere
1. Timestamp esatto dell'errore
2. User ID e azioni eseguite
3. Log completi dell'errore
4. Screenshot se UI issue
5. Ambiente (dev/staging/prod)

## 🔗 Collegamenti Utili
- [Log Analysis Guide](../development/logging.md)
- [Performance Monitoring](../reference/performance.md)
- [Error Codes Reference](../reference/error-codes.md)

---
*Template standardizzato - Principi DRY + KISS*
*Aggiornato: 2025-08-04*
