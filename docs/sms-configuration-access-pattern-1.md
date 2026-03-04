# Pattern di Accesso alla Configurazione SMS

## Problema Identificato

È stato identificato un errore comune nell'implementazione delle azioni SMS: l'utilizzo di `config('services.*.token')` invece di `config('sms.drivers.*.token')`.

Questo errore viola i principi di modularità e coerenza dell'architettura di <nome progetto>, dove ogni modulo gestisce le proprie configurazioni in file dedicati.

## Pattern Corretto

### ❌ Pattern ERRATO

```php
// ERRATO: Accesso alla configurazione tramite services
$token = config('services.netfun.token');
$endpoint = 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';

// ERRATO: Parametri globali recuperati in modo inconsistente
$defaultSender = config('sms.from');
$debug = (bool) config('sms.debug', false);
$timeout = (int) config('sms.timeout', 30);
```

### ✅ Pattern CORRETTO

```php
// CORRETTO: Accesso alla configurazione tramite sms.drivers
$token = config('sms.drivers.netfun.token');
$endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

// CORRETTO: Parametri globali recuperati in modo coerente
$defaultSender = config('sms.from');
$debug = (bool) config('sms.debug', false);
$timeout = (int) config('sms.timeout', 30);
```

## Motivazione

1. **Coerenza**: Tutte le configurazioni relative agli SMS devono provenire dal file `config/sms.php`
2. **Modularità**: Ogni modulo gestisce le proprie configurazioni
3. **Manutenibilità**: Facilita la manutenzione avendo un'unica fonte di verità per le configurazioni
4. **Standardizzazione**: Segue la struttura standardizzata documentata in [SMS_CONFIG_STRUCTURE.md](./SMS_CONFIG_STRUCTURE.md)

## Checklist di Verifica

Per ogni azione SMS, verificare che:

- [ ] La configurazione del provider sia recuperata da `config('sms.drivers.*')`
- [ ] I parametri globali siano recuperati da `config('sms.*')`
- [ ] Non ci siano riferimenti a `config('services.*')`
- [ ] Vengano utilizzati valori predefiniti appropriati
- [ ] Sia implementata la gestione degli errori per configurazioni mancanti

## Collegamenti

- [Struttura della Configurazione SMS](./SMS_CONFIG_STRUCTURE.md)
- [Requisiti di Configurazione Netfun](./NETFUN_CONFIG_REQUIREMENTS.md)
- [Pattern Factory per SMS](./SMS_ACTION_FACTORY_ANALYSIS.md)
