---
title: "Pattern di Accesso alla Configurazione SMS"
type: pattern
tags: [sms, configuration, access, pattern]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-configuration-access-pattern-2 pattern di accesso alla configurazione sms"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Pattern di Accesso alla Configurazione SMS

## Problema Identificato

È stato identificato un errore comune nell'implementazione delle azioni SMS: l'utilizzo di `config('services.*.token')` invece di `config('sms.drivers.*.token')`.

Questo errore viola i principi di modularità e coerenza dell'architettura di Quaeris, dove ogni modulo gestisce le proprie configurazioni in file dedicati.

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
4. **Standardizzazione**: Segue la struttura standardizzata documentata in [SMS_CONFIG_STRUCTURE.md](./sms-config-structure.md)
4. **Standardizzazione**: Segue la struttura standardizzata documentata in [SMS_CONFIG_STRUCTURE.md](./sms-config-structure.md)

## Checklist di Verifica

Per ogni azione SMS, verificare che:

- [ ] La configurazione del provider sia recuperata da `config('sms.drivers.*')`
- [ ] I parametri globali siano recuperati da `config('sms.*')`
- [ ] Non ci siano riferimenti a `config('services.*')`
- [ ] Vengano utilizzati valori predefiniti appropriati
- [ ] Sia implementata la gestione degli errori per configurazioni mancanti

## Collegamenti

- [Struttura della Configurazione SMS](./sms-config-structure.md)
- [Requisiti di Configurazione Netfun](./netfun-config-requirements.md)
- [Pattern Factory per SMS](./sms-action-factory-analysis.md)
- [Struttura della Configurazione SMS](./sms-config-structure.md)
- [Requisiti di Configurazione Netfun](./netfun-config-requirements.md)
- [Pattern Factory per SMS](./sms-action-factory-analysis.md)