---
qmd: "sms consolidated"
issues: []
discussions: []
title: "sms: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# sms: Consolidated Documentation

Consolidated from **63** individual files.

## Table of Contents

- [---](#sms-action-factory-analysis-1)
- [Analisi: Sostituzione Match con Formula nel SmsActionFactory](#sms-action-factory-analysis)
- [---](#sms-action-factory-resolution-1)
- [Risoluzione dinamica vs match esplicito in SmsActionFactory](#sms-action-factory-resolution)
- [Analisi: Sostituzione Match con Formula nel SmsActionFactory](#sms-action-factory)
- [Azioni SMS](#sms-actions-1)
- [---](#sms-actions-2)
- [Azioni SMS](#sms-actions)
- [---](#sms-best-practices-1)
- [Best Practices per l'Invio SMS](#sms-best-practices)
- [---](#sms-channel-action-resolution-1)
- [Dove posizionare la logica di risoluzione dell'action SMS?](#sms-channel-action-resolution)
- [Struttura della Configurazione SMS](#sms-config-structure-1)
- [---](#sms-config-structure-2)
- [Struttura della Configurazione SMS ](#sms-config-structure)
- [Pattern di Accesso alla Configurazione SMS](#sms-configuration-access)
- [Traduzioni SmsDriverEnum - Modulo Notify](#sms-driver-enum-translations-1)
- [---](#sms-driver-enum-translations-2)
- [Traduzioni SmsDriverEnum - Modulo Notify](#sms-driver-enum-translations)
- [---](#sms-driver-selection-analysis-1)
- [Analisi: Spostamento Logica Selezione Driver in SmsData](#sms-driver-selection-analysis)
- [---](#sms-driver-selection-specific-analysis-1)
- [Analisi Specifica: Validazione e Selezione Driver in SmsData](#sms-driver-selection-specific-analysis)
- [---](#sms-factor-data-implementation-1)
- [SmsFactorData Implementation Summary](#sms-factor-data-implementation)
- [SmsFactorData Implementation Summary](#sms-factorata-implementation)
- [---](#sms-global-vs-specific-params-1)
- [Parametri a Livello di Root vs Specifici per Provider nella Configurazione SMS](#sms-global-vs-specific-params)
- [---](#sms-implementation-1)
- [Implementazione SMS in Laravel](#sms-implementation)
- [SMS Integration](#sms-integration)
- [Integrazione Netfun SMS Channel in Laravel](#sms-netfun-channel-1)
- [---](#sms-netfun-channel-2)
- [Integrazione Netfun SMS Channel in Laravel](#sms-netfun-channel)
- [Deprecated](#sms-provider-configuration-1)
- [---](#sms-provider-configuration-2)
- [Best Practices per la Configurazione dei Provider SMS](#sms-provider-configuration-best-practices-1)
- [---](#sms-provider-configuration-best-practices-2)
- [Best Practices per la Configurazione dei Provider SMS](#sms-provider-configuration-best-practices)
- [Configurazione Corretta dei Provider SMS](#sms-provider-configuration)
- [Troubleshooting SMS](#sms-troubleshooting-1)
- [---](#sms-troubleshooting-2)
- [Troubleshooting SMS](#sms-troubleshooting)
- [sms skebby](#sms)
- [Analisi: Sostituzione Match con Formula nel SmsActionFactory](#sms_action_factory_analysis)
- [Risoluzione dinamica vs match esplicito in SmsActionFactory](#sms_action_factory_resolution)
- [Azioni SMS](#sms_actions)
- [Best Practices per l'Invio SMS](#sms_best_practices)
- [Dove posizionare la logica di risoluzione dell'action SMS?](#sms_channel_action_resolution)
- [<<<<<<< HEAD](#sms_config_structure)
- [Traduzioni SmsDriverEnum - Modulo Notify](#sms_driver_enum_translations)
- [Analisi: Spostamento Logica Selezione Driver in SmsData](#sms_driver_selection_analysis)
- [Analisi Specifica: Validazione e Selezione Driver in SmsData](#sms_driver_selection_specific_analysis)
- [SmsFactorData Implementation Summary](#sms_factor_data_implementation)
- [Parametri a Livello di Root vs Specifici per Provider nella Configurazione SMS](#sms_global_vs_specific_params)
- [Implementazione SMS in Laravel](#sms_implementation)
- [Integrazione Netfun SMS Channel in Laravel](#sms_netfun_channel)
- [<<<<<<< HEAD](#sms_provider_configuration)
- [Best Practices per la Configurazione dei Provider SMS](#sms_provider_configuration_best_practices)
- [Troubleshooting SMS](#sms_troubleshooting)
- [Traduzioni SmsDriverEnum - Modulo Notify](#smsriver-enum-translations)
- [Analisi Specifica: Validazione e Selezione Driver in SmsData](#smsriver-selection-specific)
- [Analisi: Spostamento Logica Selezione Driver in SmsData](#smsriver-selection)

---

## sms-action-factory-analysis-1

*Consolidated from: `sms-action-factory-analysis.md`*

title: "Analisi: Sostituzione Match con Formula nel SmsActionFactory"
type: concept
tags: [sms, action, factory, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-action-factory-analysis-1 analisi: sostituzione match con formula nel smsactionfactory"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Analisi: Sostituzione Match con Formula nel SmsActionFactory

## Contesto Attuale
```php
$action = match ($driver) {
    'netfun' => app(SendNetfunSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'vonage' => app(SendVonageSMSAction::class),
    default => throw new \Exception("Driver SMS non supportato: {$driver}")
};
```

## Proposta di Modifica
```php
$actionClass = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($driver) . "SMSAction";
$action = app($actionClass);
```

## Vantaggi (40%)

### 1. Manutenibilità (15%)
- **Pro**: Riduce la duplicazione del codice
- **Pro**: Aggiungere un nuovo driver richiede solo la creazione della classe corrispondente
- **Pro**: Non richiede modifiche al factory quando si aggiunge un nuovo driver

### 2. Flessibilità (10%)
- **Pro**: Supporto automatico per nuovi driver senza modifiche al factory
- **Pro**: Facilita l'implementazione di driver dinamici
- **Pro**: Permette l'integrazione di driver di terze parti

### 3. Coerenza (10%)
- **Pro**: Forza una convenzione di naming standard
- **Pro**: Riduce la possibilità di errori di digitazione
- **Pro**: Mantiene una struttura coerente tra driver

### 4. Testabilità (5%)
- **Pro**: Semplifica i test unitari del factory
- **Pro**: Riduce il numero di casi da testare nel factory

## Svantaggi (60%)

### 1. Sicurezza (20%)
- **Contro**: Possibilità di injection di classi non autorizzate
- **Contro**: Nessun controllo esplicito sui driver supportati
- **Contro**: Rischio di caricamento di classi malevole

### 2. Robustezza (15%)
- **Contro**: Nessuna validazione del driver prima dell'istanziazione
- **Contro**: Errori più difficili da debuggare
- **Contro**: Possibili errori runtime non catturati

### 3. Manutenibilità (10%)
- **Contro**: Difficile tracciare quali driver sono effettivamente supportati
- **Contro**: Nessuna documentazione implicita dei driver supportati
- **Contro**: Più difficile da capire per nuovi sviluppatori

### 4. Performance (5%)
- **Contro**: Overhead di reflection per il caricamento dinamico
- **Contro**: Possibili problemi di caching

### 5. Flessibilità (10%)
- **Contro**: Forza una convenzione di naming rigida
- **Contro**: Difficile supportare driver con naming non standard
- **Contro**: Limitazioni nella struttura dei namespace

## Soluzione Ibrida Proposta
```php
private const SUPPORTED_DRIVERS = [
    'netfun',
    'twilio',
    'vonage'
];

public function make(string $driver): SmsActionInterface
{
    if (!in_array($driver, self::SUPPORTED_DRIVERS)) {
        throw new \Exception("Driver SMS non supportato: {$driver}");
    }

    $actionClass = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($driver) . "SMSAction";
    
    if (!class_exists($actionClass)) {
        throw new \Exception("Classe action non trovata per il driver: {$driver}");
    }

    $action = app($actionClass);
    
    if (!$action instanceof SmsActionInterface) {
        throw new \Exception("La classe {$actionClass} non implementa SmsActionInterface");
    }

    return $action;
}
```

## Vantaggi della Soluzione Ibrida
1. Mantiene la flessibilità della formula
2. Aggiunge controlli di sicurezza
3. Documenta i driver supportati
4. Valida l'implementazione dell'interfaccia
5. Fornisce messaggi di errore chiari

## Conclusione
La soluzione ibrida offre il miglior compromesso tra:
- Flessibilità nella gestione dei driver
- Sicurezza e validazione
- Manutenibilità e documentazione
- Robustezza e gestione degli errori

Si consiglia di implementare la soluzione ibrida per ottenere i vantaggi di entrambi gli approcci mantenendo un alto livello di sicurezza e manutenibilità. 

---

## sms-action-factory-analysis

*Consolidated from: `sms-action-factory-analysis.md`*


## Contesto Attuale
```php
$action = match ($driver) {
    'netfun' => app(SendNetfunSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'vonage' => app(SendVonageSMSAction::class),
    default => throw new \Exception("Driver SMS non supportato: {$driver}")
};
```

## Proposta di Modifica
```php
$actionClass = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($driver) . "SMSAction";
$action = app($actionClass);
```

## Vantaggi (40%)

### 1. Manutenibilità (15%)
- **Pro**: Riduce la duplicazione del codice
- **Pro**: Aggiungere un nuovo driver richiede solo la creazione della classe corrispondente
- **Pro**: Non richiede modifiche al factory quando si aggiunge un nuovo driver

### 2. Flessibilità (10%)
- **Pro**: Supporto automatico per nuovi driver senza modifiche al factory
- **Pro**: Facilita l'implementazione di driver dinamici
- **Pro**: Permette l'integrazione di driver di terze parti

### 3. Coerenza (10%)
- **Pro**: Forza una convenzione di naming standard
- **Pro**: Riduce la possibilità di errori di digitazione
- **Pro**: Mantiene una struttura coerente tra driver

### 4. Testabilità (5%)
- **Pro**: Semplifica i test unitari del factory
- **Pro**: Riduce il numero di casi da testare nel factory

## Svantaggi (60%)

### 1. Sicurezza (20%)
- **Contro**: Possibilità di injection di classi non autorizzate
- **Contro**: Nessun controllo esplicito sui driver supportati
- **Contro**: Rischio di caricamento di classi malevole

### 2. Robustezza (15%)
- **Contro**: Nessuna validazione del driver prima dell'istanziazione
- **Contro**: Errori più difficili da debuggare
- **Contro**: Possibili errori runtime non catturati

### 3. Manutenibilità (10%)
- **Contro**: Difficile tracciare quali driver sono effettivamente supportati
- **Contro**: Nessuna documentazione implicita dei driver supportati
- **Contro**: Più difficile da capire per nuovi sviluppatori

### 4. Performance (5%)
- **Contro**: Overhead di reflection per il caricamento dinamico
- **Contro**: Possibili problemi di caching

### 5. Flessibilità (10%)
- **Contro**: Forza una convenzione di naming rigida
- **Contro**: Difficile supportare driver con naming non standard
- **Contro**: Limitazioni nella struttura dei namespace

## Soluzione Ibrida Proposta
```php
private const SUPPORTED_DRIVERS = [
    'netfun',
    'twilio',
    'vonage'
];

public function make(string $driver): SmsActionInterface
{
    if (!in_array($driver, self::SUPPORTED_DRIVERS)) {
        throw new \Exception("Driver SMS non supportato: {$driver}");
    }

    $actionClass = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($driver) . "SMSAction";
    
    if (!class_exists($actionClass)) {
        throw new \Exception("Classe action non trovata per il driver: {$driver}");
    }

    $action = app($actionClass);
    
    if (!$action instanceof SmsActionInterface) {
        throw new \Exception("La classe {$actionClass} non implementa SmsActionInterface");
    }

    return $action;
}
```

## Vantaggi della Soluzione Ibrida
1. Mantiene la flessibilità della formula
2. Aggiunge controlli di sicurezza
3. Documenta i driver supportati
4. Valida l'implementazione dell'interfaccia
5. Fornisce messaggi di errore chiari

## Conclusione
La soluzione ibrida offre il miglior compromesso tra:
- Flessibilità nella gestione dei driver
- Sicurezza e validazione
- Manutenibilità e documentazione
- Robustezza e gestione degli errori

Si consiglia di implementare la soluzione ibrida per ottenere i vantaggi di entrambi gli approcci mantenendo un alto livello di sicurezza e manutenibilità. 

---

## sms-action-factory-resolution-1

*Consolidated from: `sms-action-factory-resolution.md`*

title: "Risoluzione dinamica vs match esplicito in SmsActionFactory"
type: concept
tags: [sms, action, factory, resolution]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-action-factory-resolution-1 risoluzione dinamica vs match esplicito in smsactionfactory"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Risoluzione dinamica vs match esplicito in SmsActionFactory

## Contesto

Nel factory `SmsActionFactory`, invece di usare un `match` esplicito per risolvere la classe action in base al driver, si può calcolare dinamicamente il nome della classe action tramite una formula.

---

## 1. Esempio di match esplicito

```php
$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

---

## 2. Esempio di risoluzione dinamica tramite formula

```php
$driverStudly = Str::studly($driver); // es: smsfactor -> Smsfactor
$class = "Modules\\Notify\\Actions\\SMS\\Send{$driverStudly}SMSAction";
if (!class_exists($class)) {
    throw new Exception("Action class non trovata per driver: {$driver}");
}
$action = app($class);
```

---

## 3. Vantaggi della risoluzione dinamica
- **Scalabilità**: aggiungere un nuovo driver non richiede modifiche al factory, basta rispettare la convenzione di naming.
- **DRY**: elimina la duplicazione di codice e la necessità di aggiornare il match ad ogni nuovo driver.
- **Manutenzione**: meno punti di rottura, meno rischio di dimenticare un driver.
- **Coerenza**: forza l'adozione di una naming convention chiara e uniforme.

**Percentuale vantaggi:** 80%

---

## 4. Svantaggi della risoluzione dinamica
- **Errori silenziosi**: se il nome della classe non rispetta la convenzione, l'errore viene fuori solo a runtime.
- **Refactoring rischioso**: rinominare una classe senza aggiornare la formula può rompere il sistema.
- **Meno esplicito**: la lista dei driver supportati non è visibile a colpo d'occhio nel codice.
- **IDE e static analysis**: meno supporto per refactoring automatici e suggerimenti.

**Percentuale svantaggi:** 20%

---

## 5. Best practice consigliata
- Usare la risoluzione dinamica **solo se** la naming convention è rigorosamente rispettata e documentata.
- Aggiungere test automatici che verifichino la presenza della classe action per ogni driver configurato.
- Documentare chiaramente la formula e la convenzione di naming.
- In caso di driver "speciali" o legacy, prevedere un fallback o una mappa custom.

---

## 6. Formula consigliata

```php
$driverStudly = Str::studly($driver); // es: smsfactor -> Smsfactor
$class = "Modules\\Notify\\Actions\\SMS\\Send{$driverStudly}SMSAction";
if (!class_exists($class)) {
    throw new Exception("Action class non trovata per driver: {$driver}");
}
return app($class);
```

---

## 7. Conclusione

La risoluzione dinamica tramite formula è **più scalabile e manutenibile** rispetto al match esplicito, ma richiede disciplina nella naming convention e test automatici di coerenza. In progetti modulari e in crescita è la scelta preferibile, purché ben documentata e sorvegliata. 

---

## sms-action-factory-resolution

*Consolidated from: `sms-action-factory-resolution.md`*


## Contesto

Nel factory `SmsActionFactory`, invece di usare un `match` esplicito per risolvere la classe action in base al driver, si può calcolare dinamicamente il nome della classe action tramite una formula.

---

## 1. Esempio di match esplicito

```php
$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

---

## 2. Esempio di risoluzione dinamica tramite formula

```php
$driverStudly = Str::studly($driver); // es: smsfactor -> Smsfactor
$class = "Modules\\Notify\\Actions\\SMS\\Send{$driverStudly}SMSAction";
if (!class_exists($class)) {
    throw new Exception("Action class non trovata per driver: {$driver}");
}
$action = app($class);
```

---

## 3. Vantaggi della risoluzione dinamica
- **Scalabilità**: aggiungere un nuovo driver non richiede modifiche al factory, basta rispettare la convenzione di naming.
- **DRY**: elimina la duplicazione di codice e la necessità di aggiornare il match ad ogni nuovo driver.
- **Manutenzione**: meno punti di rottura, meno rischio di dimenticare un driver.
- **Coerenza**: forza l'adozione di una naming convention chiara e uniforme.

**Percentuale vantaggi:** 80%

---

## 4. Svantaggi della risoluzione dinamica
- **Errori silenziosi**: se il nome della classe non rispetta la convenzione, l'errore viene fuori solo a runtime.
- **Refactoring rischioso**: rinominare una classe senza aggiornare la formula può rompere il sistema.
- **Meno esplicito**: la lista dei driver supportati non è visibile a colpo d'occhio nel codice.
- **IDE e static analysis**: meno supporto per refactoring automatici e suggerimenti.

**Percentuale svantaggi:** 20%

---

## 5. Best practice consigliata
- Usare la risoluzione dinamica **solo se** la naming convention è rigorosamente rispettata e documentata.
- Aggiungere test automatici che verifichino la presenza della classe action per ogni driver configurato.
- Documentare chiaramente la formula e la convenzione di naming.
- In caso di driver "speciali" o legacy, prevedere un fallback o una mappa custom.

---

## 6. Formula consigliata

```php
$driverStudly = Str::studly($driver); // es: smsfactor -> Smsfactor
$class = "Modules\\Notify\\Actions\\SMS\\Send{$driverStudly}SMSAction";
if (!class_exists($class)) {
    throw new Exception("Action class non trovata per driver: {$driver}");
}
return app($class);
```

---

## 7. Conclusione

La risoluzione dinamica tramite formula è **più scalabile e manutenibile** rispetto al match esplicito, ma richiede disciplina nella naming convention e test automatici di coerenza. In progetti modulari e in crescita è la scelta preferibile, purché ben documentata e sorvegliata. 

---

## sms-action-factory

*Consolidated from: `sms-action-factory.md`*


## Contesto Attuale
```php
$action = match ($driver) {
    'netfun' => app(SendNetfunSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'vonage' => app(SendVonageSMSAction::class),
    default => throw new \Exception("Driver SMS non supportato: {$driver}")
};
```

## Proposta di Modifica
```php
$actionClass = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($driver) . "SMSAction";
$action = app($actionClass);
```

## Vantaggi (40%)

### 1. Manutenibilità (15%)
- **Pro**: Riduce la duplicazione del codice
- **Pro**: Aggiungere un nuovo driver richiede solo la creazione della classe corrispondente
- **Pro**: Non richiede modifiche al factory quando si aggiunge un nuovo driver

### 2. Flessibilità (10%)
- **Pro**: Supporto automatico per nuovi driver senza modifiche al factory
- **Pro**: Facilita l'implementazione di driver dinamici
- **Pro**: Permette l'integrazione di driver di terze parti

### 3. Coerenza (10%)
- **Pro**: Forza una convenzione di naming standard
- **Pro**: Riduce la possibilità di errori di digitazione
- **Pro**: Mantiene una struttura coerente tra driver

### 4. Testabilità (5%)
- **Pro**: Semplifica i test unitari del factory
- **Pro**: Riduce il numero di casi da testare nel factory

## Svantaggi (60%)

### 1. Sicurezza (20%)
- **Contro**: Possibilità di injection di classi non autorizzate
- **Contro**: Nessun controllo esplicito sui driver supportati
- **Contro**: Rischio di caricamento di classi malevole

### 2. Robustezza (15%)
- **Contro**: Nessuna validazione del driver prima dell'istanziazione
- **Contro**: Errori più difficili da debuggare
- **Contro**: Possibili errori runtime non catturati

### 3. Manutenibilità (10%)
- **Contro**: Difficile tracciare quali driver sono effettivamente supportati
- **Contro**: Nessuna documentazione implicita dei driver supportati
- **Contro**: Più difficile da capire per nuovi sviluppatori

### 4. Performance (5%)
- **Contro**: Overhead di reflection per il caricamento dinamico
- **Contro**: Possibili problemi di caching

### 5. Flessibilità (10%)
- **Contro**: Forza una convenzione di naming rigida
- **Contro**: Difficile supportare driver con naming non standard
- **Contro**: Limitazioni nella struttura dei namespace

## Soluzione Ibrida Proposta
```php
private const SUPPORTED_DRIVERS = [
    'netfun',
    'twilio',
    'vonage'
];

public function make(string $driver): SmsActionInterface
{
    if (!in_array($driver, self::SUPPORTED_DRIVERS)) {
        throw new \Exception("Driver SMS non supportato: {$driver}");
    }

    $actionClass = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($driver) . "SMSAction";
    
    if (!class_exists($actionClass)) {
        throw new \Exception("Classe action non trovata per il driver: {$driver}");
    }

    $action = app($actionClass);
    
    if (!$action instanceof SmsActionInterface) {
        throw new \Exception("La classe {$actionClass} non implementa SmsActionInterface");
    }

    return $action;
}
```

## Vantaggi della Soluzione Ibrida
1. Mantiene la flessibilità della formula
2. Aggiunge controlli di sicurezza
3. Documenta i driver supportati
4. Valida l'implementazione dell'interfaccia
5. Fornisce messaggi di errore chiari

## Conclusione
La soluzione ibrida offre il miglior compromesso tra:
- Flessibilità nella gestione dei driver
- Sicurezza e validazione
- Manutenibilità e documentazione
- Robustezza e gestione degli errori

Si consiglia di implementare la soluzione ibrida per ottenere i vantaggi di entrambi gli approcci mantenendo un alto livello di sicurezza e manutenibilità. 

---

## sms-actions-1

*Consolidated from: `sms-actions.md`*


## Interfaccia

Tutte le azioni di invio SMS devono implementare l'interfaccia `SmsActionInterface`:

```php
namespace Modules\Notify\Contracts\SMS;

interface SmsActionInterface
{
    /**
     * Esegue l'invio dell'SMS
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(SmsData $smsData): array;
}
```

## Struttura

Le azioni SMS sono organizzate secondo questa struttura:

1. **Contratti**: Le interfacce sono definite in `app/Contracts/SMS/`
2. **Implementazioni**: Le azioni concrete sono in `app/Actions/SMS/`
3. **Regole**:
   - Ogni azione deve implementare `SmsActionInterface`
   - Il metodo `execute()` deve accettare solo `SmsData`
   - Deve restituire un array con i dettagli dell'operazione
   - Deve gestire e loggare gli errori appropriatamente

## Provider Supportati

- Netfun
- Altri provider da aggiungere...

## Esempio di Utilizzo

```php
$smsData = new SmsData(
    to: '+393331234567',
    body: 'Il tuo codice OTP è: 123456',
    from: '<nome progetto>'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

## Best Practices

1. **Validazione**:
   - Validare sempre i dati in ingresso
   - Verificare il formato del numero di telefono
   - Controllare la lunghezza del messaggio

2. **Gestione Errori**:
   - Usare try/catch per gestire le eccezioni
   - Loggare gli errori con dettagli
   - Implementare retry per fallimenti temporanei

3. **Performance**:
   - Utilizzare le code per l'invio
   - Implementare rate limiting
   - Monitorare l'uso dell'API

4. **Sicurezza**:
   - Validare l'input degli utenti
   - Sanitizzare i messaggi
   - Proteggere le chiavi API

---

## sms-actions-2

*Consolidated from: `sms-actions.md`*

title: "Azioni SMS"
type: concept
tags: [sms, actions]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-actions-2 azioni sms"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Azioni SMS

## Interfaccia

Tutte le azioni di invio SMS devono implementare l'interfaccia `SmsActionInterface`:

```php
namespace Modules\Notify\Contracts\SMS;

interface SmsActionInterface
{
    /**
     * Esegue l'invio dell'SMS
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(SmsData $smsData): array;
}
```

## Struttura

Le azioni SMS sono organizzate secondo questa struttura:

1. **Contratti**: Le interfacce sono definite in `app/Contracts/SMS/`
2. **Implementazioni**: Le azioni concrete sono in `app/Actions/SMS/`
3. **Regole**:
   - Ogni azione deve implementare `SmsActionInterface`
   - Il metodo `execute()` deve accettare solo `SmsData`
   - Deve restituire un array con i dettagli dell'operazione
   - Deve gestire e loggare gli errori appropriatamente

## Provider Supportati

- Netfun
- Altri provider da aggiungere...

## Esempio di Utilizzo

```php
$smsData = new SmsData(
    to: '+393331234567',
    body: 'Il tuo codice OTP è: 123456',
from: 'App'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

## Best Practices

1. **Validazione**:
   - Validare sempre i dati in ingresso
   - Verificare il formato del numero di telefono
   - Controllare la lunghezza del messaggio

2. **Gestione Errori**:
   - Usare try/catch per gestire le eccezioni
   - Loggare gli errori con dettagli
   - Implementare retry per fallimenti temporanei

3. **Performance**:
   - Utilizzare le code per l'invio
   - Implementare rate limiting
   - Monitorare l'uso dell'API

4. **Sicurezza**:
   - Validare l'input degli utenti
   - Sanitizzare i messaggi
   - Proteggere le chiavi API
---

## sms-actions

*Consolidated from: `sms-actions.md`*


## Interfaccia

Tutte le azioni di invio SMS devono implementare l'interfaccia `SmsActionInterface`:

```php
namespace Modules\Notify\Contracts\SMS;

interface SmsActionInterface
{
    /**
     * Esegue l'invio dell'SMS
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(SmsData $smsData): array;
}
```

## Struttura

Le azioni SMS sono organizzate secondo questa struttura:

1. **Contratti**: Le interfacce sono definite in `app/Contracts/SMS/`
2. **Implementazioni**: Le azioni concrete sono in `app/Actions/SMS/`
3. **Regole**:
   - Ogni azione deve implementare `SmsActionInterface`
   - Il metodo `execute()` deve accettare solo `SmsData`
   - Deve restituire un array con i dettagli dell'operazione
   - Deve gestire e loggare gli errori appropriatamente

## Provider Supportati

- Netfun
- Altri provider da aggiungere...

## Esempio di Utilizzo

```php
$smsData = new SmsData(
    to: '+393331234567',
    body: 'Il tuo codice OTP è: 123456',
    from: ''
    from: '<nome progetto>'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

## Best Practices

1. **Validazione**:
   - Validare sempre i dati in ingresso
   - Verificare il formato del numero di telefono
   - Controllare la lunghezza del messaggio

2. **Gestione Errori**:
   - Usare try/catch per gestire le eccezioni
   - Loggare gli errori con dettagli
   - Implementare retry per fallimenti temporanei

3. **Performance**:
   - Utilizzare le code per l'invio
   - Implementare rate limiting
   - Monitorare l'uso dell'API

4. **Sicurezza**:
   - Validare l'input degli utenti
   - Sanitizzare i messaggi
   - Proteggere le chiavi API

---

## sms-best-practices-1

*Consolidated from: `sms-best-practices.md`*

title: "Best Practices per l'Invio SMS"
type: concept
tags: [sms, best, practices]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-best-practices-1 best practices per l'invio sms"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Best Practices per l'Invio SMS

## 1. Gestione dei Template

### Struttura Template
```php
// Esempio di template ben strutturato
{
    "name": "welcome",
    "content": "Benvenuto {{name}}! Il tuo codice di verifica è {{code}}.",
    "variables": ["name", "code"],
    "max_length": 160
}
```

### Best Practices
- Mantenere template brevi e concisi
- Evitare caratteri speciali
- Utilizzare variabili standardizzate
- Documentare ogni template
- Testare il rendering

## 2. Validazione

### Numeri di Telefono
```php
// Esempio di validazione
public function validatePhoneNumber($number)
{
    return preg_match('/^\+[1-9]\d{1,14}$/', $number);
}
```

### Best Practices
- Verificare formato internazionale
- Validare prima dell'invio
- Gestire errori di formato
- Loggare tentativi non validi
- Implementare blacklist

## 3. Gestione degli Errori

### Retry Mechanism
```php
// Esempio di retry
public function sendWithRetry($number, $message, $attempts = 3)
{
    for ($i = 0; $i < $attempts; $i++) {
        try {
            return $this->send($number, $message);
        } catch (Exception $e) {
            if ($i === $attempts - 1) {
                throw $e;
            }
            sleep(1);
        }
    }
}
```

### Best Practices
- Implementare retry automatico
- Loggare tutti gli errori
- Notificare errori critici
- Monitorare tasso di errore
- Implementare fallback

## 4. Performance

### Queue System
```php
// Esempio di job in coda
class SendSmsJob implements ShouldQueue
{
    public function handle()
    {
        // Logica di invio
    }
}
```

### Best Practices
- Utilizzare code per invii massivi
- Implementare rate limiting
- Ottimizzare batch size
- Monitorare performance
- Implementare caching

## 5. Sicurezza

### API Key Management
```php
// Esempio di gestione sicura
protected function getApiKey()
{
    return config('sms.drivers.smsfactor.api_key');
}
```

### Best Practices
- Proteggere API keys
- Implementare rate limiting
- Validare input
- Loggare accessi
- Implementare audit trail

## 6. Monitoraggio

### Logging Structure
```php
// Esempio di logging
Log::info('SMS Sent', [
    'recipient' => $number,
    'template' => $template,
    'status' => $status,
    'provider' => $provider
]);
```

### Best Practices
- Loggare tutte le operazioni
- Monitorare metriche chiave
- Implementare alerting
- Generare report
- Analizzare trend

## 7. Testing

### Unit Tests
```php
// Esempio di test
public function test_sms_sending()
{
    $result = $this->smsService->send(
        '+393331234567',
        'Test message'
    );
    $this->assertTrue($result);
}
```

### Best Practices
- Testare tutti i casi d'uso
- Implementare mock
- Testare errori
- Validare template
- Testare performance

## 8. Manutenzione

### Backup Strategy
```php
// Esempio di backup
public function backupTemplates()
{
    $templates = SmsTemplate::all();
    Storage::put(
        'backups/sms-templates-' . date('Y-m-d') . '.json',
        $templates->toJson()
    );
}
```

### Best Practices
- Backup regolare
- Versioning template
- Documentazione aggiornata
- Monitoraggio versione
- Piano rollback

## 9. Compliance

### GDPR e Privacy
```php
// Esempio di gestione consenso
public function hasConsent($user)
{
    return $user->sms_consent && $user->sms_consent_date;
}
```

### Best Practices
- Rispettare GDPR
- Gestire consensi
- Documentare policy
- Implementare opt-out
- Audit regolare

## 10. Ottimizzazione

### Costi e Risorse
```php
// Esempio di ottimizzazione
public function optimizeBatch($messages)
{
    return array_chunk($messages, 100);
}
```

### Best Practices
- Ottimizzare costi
- Monitorare utilizzo
- Implementare caching
- Ottimizzare batch
- Analizzare ROI

## 11. Documentazione

### Template Documentation
```php
/**
 * @param string $name Nome del template
 * @param array $variables Variabili richieste
 * @return string Template renderizzato
 */
public function renderTemplate($name, $variables)
{
    // Implementazione
}
```

### Best Practices
- Documentare tutto
- Mantenere aggiornato
- Includere esempi
- Documentare errori
- Aggiornare changelog

## 12. Supporto

### Error Handling
```php
// Esempio di gestione errori
try {
    $this->sendSms($number, $message);
} catch (SmsException $e) {
    Log::error('SMS Error', [
        'error' => $e->getMessage(),
        'number' => $number
    ]);
    // Notifica supporto
}
```

### Best Practices
- Implementare supporto
- Documentare procedure
- Mantenere SLA
- Monitorare ticket
- Analizzare feedback 

---

## sms-best-practices

*Consolidated from: `sms-best-practices.md`*


## 1. Gestione dei Template

### Struttura Template
```php
// Esempio di template ben strutturato
{
    "name": "welcome",
    "content": "Benvenuto {{name}}! Il tuo codice di verifica è {{code}}.",
    "variables": ["name", "code"],
    "max_length": 160
}
```

### Best Practices
- Mantenere template brevi e concisi
- Evitare caratteri speciali
- Utilizzare variabili standardizzate
- Documentare ogni template
- Testare il rendering

## 2. Validazione

### Numeri di Telefono
```php
// Esempio di validazione
public function validatePhoneNumber($number)
{
    return preg_match('/^\+[1-9]\d{1,14}$/', $number);
}
```

### Best Practices
- Verificare formato internazionale
- Validare prima dell'invio
- Gestire errori di formato
- Loggare tentativi non validi
- Implementare blacklist

## 3. Gestione degli Errori

### Retry Mechanism
```php
// Esempio di retry
public function sendWithRetry($number, $message, $attempts = 3)
{
    for ($i = 0; $i < $attempts; $i++) {
        try {
            return $this->send($number, $message);
        } catch (Exception $e) {
            if ($i === $attempts - 1) {
                throw $e;
            }
            sleep(1);
        }
    }
}
```

### Best Practices
- Implementare retry automatico
- Loggare tutti gli errori
- Notificare errori critici
- Monitorare tasso di errore
- Implementare fallback

## 4. Performance

### Queue System
```php
// Esempio di job in coda
class SendSmsJob implements ShouldQueue
{
    public function handle()
    {
        // Logica di invio
    }
}
```

### Best Practices
- Utilizzare code per invii massivi
- Implementare rate limiting
- Ottimizzare batch size
- Monitorare performance
- Implementare caching

## 5. Sicurezza

### API Key Management
```php
// Esempio di gestione sicura
protected function getApiKey()
{
    return config('sms.drivers.smsfactor.api_key');
}
```

### Best Practices
- Proteggere API keys
- Implementare rate limiting
- Validare input
- Loggare accessi
- Implementare audit trail

## 6. Monitoraggio

### Logging Structure
```php
// Esempio di logging
Log::info('SMS Sent', [
    'recipient' => $number,
    'template' => $template,
    'status' => $status,
    'provider' => $provider
]);
```

### Best Practices
- Loggare tutte le operazioni
- Monitorare metriche chiave
- Implementare alerting
- Generare report
- Analizzare trend

## 7. Testing

### Unit Tests
```php
// Esempio di test
public function test_sms_sending()
{
    $result = $this->smsService->send(
        '+393331234567',
        'Test message'
    );
    $this->assertTrue($result);
}
```

### Best Practices
- Testare tutti i casi d'uso
- Implementare mock
- Testare errori
- Validare template
- Testare performance

## 8. Manutenzione

### Backup Strategy
```php
// Esempio di backup
public function backupTemplates()
{
    $templates = SmsTemplate::all();
    Storage::put(
        'backups/sms-templates-' . date('Y-m-d') . '.json',
        $templates->toJson()
    );
}
```

### Best Practices
- Backup regolare
- Versioning template
- Documentazione aggiornata
- Monitoraggio versione
- Piano rollback

## 9. Compliance

### GDPR e Privacy
```php
// Esempio di gestione consenso
public function hasConsent($user)
{
    return $user->sms_consent && $user->sms_consent_date;
}
```

### Best Practices
- Rispettare GDPR
- Gestire consensi
- Documentare policy
- Implementare opt-out
- Audit regolare

## 10. Ottimizzazione

### Costi e Risorse
```php
// Esempio di ottimizzazione
public function optimizeBatch($messages)
{
    return array_chunk($messages, 100);
}
```

### Best Practices
- Ottimizzare costi
- Monitorare utilizzo
- Implementare caching
- Ottimizzare batch
- Analizzare ROI

## 11. Documentazione

### Template Documentation
```php
/**
 * @param string $name Nome del template
 * @param array $variables Variabili richieste
 * @return string Template renderizzato
 */
public function renderTemplate($name, $variables)
{
    // Implementazione
}
```

### Best Practices
- Documentare tutto
- Mantenere aggiornato
- Includere esempi
- Documentare errori
- Aggiornare changelog

## 12. Supporto

### Error Handling
```php
// Esempio di gestione errori
try {
    $this->sendSms($number, $message);
} catch (SmsException $e) {
    Log::error('SMS Error', [
        'error' => $e->getMessage(),
        'number' => $number
    ]);
    // Notifica supporto
}
```

### Best Practices
- Implementare supporto
- Documentare procedure
- Mantenere SLA
- Monitorare ticket
- Analizzare feedback 

---

## sms-channel-action-resolution-1

*Consolidated from: `sms-channel-action-resolution.md`*

title: "Dove posizionare la logica di risoluzione dell'action SMS?"
type: concept
tags: [sms, channel, action, resolution]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-channel-action-resolution-1 dove posizionare la logica di risoluzione dell'action sms?"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Dove posizionare la logica di risoluzione dell'action SMS?

## Contesto

Attualmente la logica di risoluzione dell'action SMS in base al driver configurato è posizionata nel canale custom `SmsChannel`:

```php
$driver = Config::get('sms.default', 'smsfactor');
$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

È stato chiesto se questa logica non sarebbe meglio spostarla all'interno del DTO `SmsData`.

---

## Analisi delle due soluzioni

### 1. Logica nel Canale (`SmsChannel`)

**Vantaggi:**
- **Responsabilità chiara** (Single Responsibility): il canale si occupa di orchestrare l'invio, non il DTO.
- **Separation of Concerns**: il DTO resta un puro contenitore di dati, senza logica applicativa.
- **Testabilità**: più facile testare la logica di risoluzione e mocking delle action.
- **Estendibilità**: aggiungere nuovi driver o cambiare la logica di risoluzione non impatta la struttura dei dati.
- **Aderenza alle best practice Laravel**: i canali sono pensati per orchestrare, i DTO per trasportare dati.

**Svantaggi:**
- La logica di risoluzione è duplicabile se usata in altri punti (ma si può estrarre in un service/factory).

**Percentuali:**
- **Vantaggi:** 85%
- **Svantaggi:** 15%

---

### 2. Logica nel DTO (`SmsData`)

**Vantaggi:**
- **Comodità**: si può richiamare direttamente dal DTO, minor codice in alcuni casi.
- **Incapsulamento**: tutto ciò che riguarda l'SMS sembra essere nel DTO.

**Svantaggi:**
- **Violazione SRP**: il DTO non dovrebbe conoscere la logica di invio, solo trasportare dati.
- **Difficoltà di test**: il DTO diventa difficile da testare e mockare.
- **Rigidità**: se la logica cambia (es. fallback, multi-driver, regole di routing), il DTO va modificato e rischia di diventare un oggetto "Dio".
- **Contrario alle convenzioni Laravel e DDD**: i Data Object non dovrebbero contenere logica di orchestrazione.
- **Rischio di accoppiamento**: il DTO diventa dipendente da tutto il sistema di invio.

**Percentuali:**
- **Vantaggi:** 20%
- **Svantaggi:** 80%

---

## Conclusione

**La logica di risoluzione dell'action SMS va mantenuta nel canale (`SmsChannel`) o, meglio ancora, estratta in una factory/service dedicato.**

- Il DTO (`SmsData`) deve restare un puro contenitore di dati.
- Il canale si occupa di orchestrare e risolvere l'action corretta.
- Per evitare duplicazione, si può creare una `SmsActionFactory` che centralizza la logica di risoluzione.

**Best practice:**
- DTO = solo dati
- Channel = orchestrazione
- Factory/Service = risoluzione dinamica

---

**Percentuali finali:**
- Logica nel canale/factory: **85% pro, 15% contro**
- Logica nel DTO: **20% pro, 80% contro**

**Motivazione:** Separation of Concerns, testabilità, estendibilità, aderenza alle best practice Laravel e DDD. 

---

## sms-channel-action-resolution

*Consolidated from: `sms-channel-action-resolution.md`*


## Contesto

Attualmente la logica di risoluzione dell'action SMS in base al driver configurato è posizionata nel canale custom `SmsChannel`:

```php
$driver = Config::get('sms.default', 'smsfactor');
$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

È stato chiesto se questa logica non sarebbe meglio spostarla all'interno del DTO `SmsData`.

---

## Analisi delle due soluzioni

### 1. Logica nel Canale (`SmsChannel`)

**Vantaggi:**
- **Responsabilità chiara** (Single Responsibility): il canale si occupa di orchestrare l'invio, non il DTO.
- **Separation of Concerns**: il DTO resta un puro contenitore di dati, senza logica applicativa.
- **Testabilità**: più facile testare la logica di risoluzione e mocking delle action.
- **Estendibilità**: aggiungere nuovi driver o cambiare la logica di risoluzione non impatta la struttura dei dati.
- **Aderenza alle best practice Laravel**: i canali sono pensati per orchestrare, i DTO per trasportare dati.

**Svantaggi:**
- La logica di risoluzione è duplicabile se usata in altri punti (ma si può estrarre in un service/factory).

**Percentuali:**
- **Vantaggi:** 85%
- **Svantaggi:** 15%

---

### 2. Logica nel DTO (`SmsData`)

**Vantaggi:**
- **Comodità**: si può richiamare direttamente dal DTO, minor codice in alcuni casi.
- **Incapsulamento**: tutto ciò che riguarda l'SMS sembra essere nel DTO.

**Svantaggi:**
- **Violazione SRP**: il DTO non dovrebbe conoscere la logica di invio, solo trasportare dati.
- **Difficoltà di test**: il DTO diventa difficile da testare e mockare.
- **Rigidità**: se la logica cambia (es. fallback, multi-driver, regole di routing), il DTO va modificato e rischia di diventare un oggetto "Dio".
- **Contrario alle convenzioni Laravel e DDD**: i Data Object non dovrebbero contenere logica di orchestrazione.
- **Rischio di accoppiamento**: il DTO diventa dipendente da tutto il sistema di invio.

**Percentuali:**
- **Vantaggi:** 20%
- **Svantaggi:** 80%

---

## Conclusione

**La logica di risoluzione dell'action SMS va mantenuta nel canale (`SmsChannel`) o, meglio ancora, estratta in una factory/service dedicato.**

- Il DTO (`SmsData`) deve restare un puro contenitore di dati.
- Il canale si occupa di orchestrare e risolvere l'action corretta.
- Per evitare duplicazione, si può creare una `SmsActionFactory` che centralizza la logica di risoluzione.

**Best practice:**
- DTO = solo dati
- Channel = orchestrazione
- Factory/Service = risoluzione dinamica

---

**Percentuali finali:**
- Logica nel canale/factory: **85% pro, 15% contro**
- Logica nel DTO: **20% pro, 80% contro**

**Motivazione:** Separation of Concerns, testabilità, estendibilità, aderenza alle best practice Laravel e DDD. 

---

## sms-config-structure-1

*Consolidated from: `sms-config-structure.md`*
*Consolidated from: `sms-config-structure-struttura-configurazione.md`*


## Introduzione

Questo documento definisce la struttura corretta del file di configurazione SMS (`config/sms.php`) nel modulo Notify, con particolare attenzione alla gestione delle configurazioni generiche vs specifiche per provider.

## Struttura Generale

Il file `config/sms.php` è organizzato in sezioni distinte:

```php
return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'default_provider'),

    // Configurazione dei driver/provider
    'drivers' => [
        // Configurazioni specifiche per provider...
    ],

    // Configurazioni generiche per tutti i provider
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'logging' => [...],
    'validation' => [...],
];
```

## Configurazioni Generiche vs Specifiche

### 1. Configurazioni Generiche

Le configurazioni generiche si applicano a **tutti** i provider SMS e sono definite a livello di root nel file di configurazione:

```php
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],
```

### 2. Configurazioni Specifiche per Provider

Le configurazioni specifiche per provider sono definite all'interno della sezione `drivers` e contengono **solo** i parametri specifici per quel provider:

```php
'drivers' => [
    'netfun' => [
        // Credenziali e parametri di connessione
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', '<nome progetto>'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),

        // Configurazioni avanzate specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],

    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

    // Altri provider...
],
```

## Regola Fondamentale: Evitare Duplicazioni

**IMPORTANTE**: Evitare di duplicare le configurazioni generiche all'interno delle configurazioni specifiche per provider. Ad esempio:

❌ **ERRATO**:
```php
'drivers' => [
    'netfun' => [
        // ...
        'max_retries' => env('NETFUN_MAX_RETRIES', 3),      // Duplica 'retry.attempts'
        'retry_delay' => env('NETFUN_RETRY_DELAY', 1),      // Duplica 'retry.delay'
        'rate_limit' => env('NETFUN_RATE_LIMIT', 100),      // Duplica 'rate_limit.max_attempts'
        'rate_limit_window' => env('NETFUN_RATE_LIMIT_WINDOW', 60), // Duplica 'rate_limit.decay_minutes'
        // ...
    ],
],
```

✅ **CORRETTO**:
```php
// Configurazioni generiche a livello di root
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],

// Solo configurazioni specifiche per provider nella sezione 'drivers'
'drivers' => [
    'netfun' => [
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', '<nome progetto>'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),

        // Solo configurazioni veramente specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Gestione Precedenze

Quando sia le configurazioni generiche che quelle specifiche per provider sono presenti:

1. Le configurazioni specifiche per provider hanno **precedenza** sulle configurazioni generiche
2. Il codice che utilizza queste configurazioni deve implementare questa logica di precedenza

Esempio di implementazione della logica di precedenza:

```php
// In una classe che gestisce l'invio SMS
$retryAttempts = $config['drivers'][$driver]['max_retries'] ?? $config['retry']['attempts'];
$retryDelay = $config['drivers'][$driver]['retry_delay'] ?? $config['retry']['delay'];
```

## Checklist di Verifica

- [ ] Configurazioni generiche (retry, rate_limit, ecc.) definite a livello di root
- [ ] Configurazioni specifiche per provider definite solo nella sezione `drivers`
- [ ] Nessuna duplicazione tra configurazioni generiche e specifiche
- [ ] Logica di precedenza implementata nel codice che utilizza queste configurazioni

## Collegamenti

- [Configurazione Netfun](./NETFUN_CONFIG_REQUIREMENTS.md)
- [Configurazione Netfun](../../netfun_config_requirements.md)
- [Provider SMS Supportati](./notifications/SMS_PROVIDER_CONFIGURATION.md)

---

*Ultimo aggiornamento: 2025-05-12*

---

## sms-config-structure-2

*Consolidated from: `sms-config-structure.md`*

title: "Struttura della Configurazione SMS"
type: concept
tags: [sms, config, structure]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-config-structure-2 struttura della configurazione sms"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Struttura della Configurazione SMS 

## Introduzione

Questo documento definisce la struttura corretta del file di configurazione SMS (`config/sms.php`) nel modulo Notify, con particolare attenzione alla gestione delle configurazioni generiche vs specifiche per provider.

## Struttura Generale

Il file `config/sms.php` è organizzato in sezioni distinte:

```php
return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'default_provider'),
    
    // Configurazione dei driver/provider
    'drivers' => [
        // Configurazioni specifiche per provider...
    ],
    
    // Configurazioni generiche per tutti i provider
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'logging' => [...],
    'validation' => [...],
];
```

## Configurazioni Generiche vs Specifiche

### 1. Configurazioni Generiche

Le configurazioni generiche si applicano a **tutti** i provider SMS e sono definite a livello di root nel file di configurazione:

```php
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],
```

### 2. Configurazioni Specifiche per Provider

Le configurazioni specifiche per provider sono definite all'interno della sezione `drivers` e contengono **solo** i parametri specifici per quel provider:

```php
'drivers' => [
    'netfun' => [
        // Credenziali e parametri di connessione
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
'sender' => env('NETFUN_SENDER', 'App'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        
        // Configurazioni avanzate specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
    
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],
    
    // Altri provider...
],
```

## Regola Fondamentale: Evitare Duplicazioni

**IMPORTANTE**: Evitare di duplicare le configurazioni generiche all'interno delle configurazioni specifiche per provider. Ad esempio:

❌ **ERRATO**:
```php
'drivers' => [
    'netfun' => [
        // ...
        'max_retries' => env('NETFUN_MAX_RETRIES', 3),      // Duplica 'retry.attempts'
        'retry_delay' => env('NETFUN_RETRY_DELAY', 1),      // Duplica 'retry.delay'
        'rate_limit' => env('NETFUN_RATE_LIMIT', 100),      // Duplica 'rate_limit.max_attempts'
        'rate_limit_window' => env('NETFUN_RATE_LIMIT_WINDOW', 60), // Duplica 'rate_limit.decay_minutes'
        // ...
    ],
],
```

✅ **CORRETTO**:
```php
// Configurazioni generiche a livello di root
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],

// Solo configurazioni specifiche per provider nella sezione 'drivers'
'drivers' => [
    'netfun' => [
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
'sender' => env('NETFUN_SENDER', 'App'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        
        // Solo configurazioni veramente specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Gestione Precedenze

Quando sia le configurazioni generiche che quelle specifiche per provider sono presenti:

1. Le configurazioni specifiche per provider hanno **precedenza** sulle configurazioni generiche
2. Il codice che utilizza queste configurazioni deve implementare questa logica di precedenza

Esempio di implementazione della logica di precedenza:

```php
// In una classe che gestisce l'invio SMS
$retryAttempts = $config['drivers'][$driver]['max_retries'] ?? $config['retry']['attempts'];
$retryDelay = $config['drivers'][$driver]['retry_delay'] ?? $config['retry']['delay'];
```

## Checklist di Verifica

- [ ] Configurazioni generiche (retry, rate_limit, ecc.) definite a livello di root
- [ ] Configurazioni specifiche per provider definite solo nella sezione `drivers`
- [ ] Nessuna duplicazione tra configurazioni generiche e specifiche
- [ ] Logica di precedenza implementata nel codice che utilizza queste configurazioni

## Collegamenti

- [Configurazione Netfun](./netfun-config-requirements.md)
- [Provider SMS Supportati](./notifications/sms-provider-configuration.md)

---

- [Configurazione Netfun](./netfun-config-requirements.md)
- [Configurazione Netfun](../../netfun-config-requirements.md)
- [Provider SMS Supportati](./notifications/SMS_PROVIDER_CONFIGURATION.md)

---

*Ultimo aggiornamento: 2025-05-12*
---

## sms-config-structure

*Consolidated from: `sms-config-structure.md`*


## Introduzione

Questo documento definisce la struttura corretta del file di configurazione SMS (`config/sms.php`) nel modulo Notify, con particolare attenzione alla gestione delle configurazioni generiche vs specifiche per provider.

## Struttura Generale

Il file `config/sms.php` è organizzato in sezioni distinte:

```php
return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'default_provider'),
    
    // Configurazione dei driver/provider
    'drivers' => [
        // Configurazioni specifiche per provider...
    ],
    
    // Configurazioni generiche per tutti i provider
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'logging' => [...],
    'validation' => [...],
];
```

## Configurazioni Generiche vs Specifiche

### 1. Configurazioni Generiche

Le configurazioni generiche si applicano a **tutti** i provider SMS e sono definite a livello di root nel file di configurazione:

```php
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],
```

### 2. Configurazioni Specifiche per Provider

Le configurazioni specifiche per provider sono definite all'interno della sezione `drivers` e contengono **solo** i parametri specifici per quel provider:

```php
'drivers' => [
    'netfun' => [
        // Credenziali e parametri di connessione
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', ''),
        'sender' => env('NETFUN_SENDER', '<nome progetto>'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        
        // Configurazioni avanzate specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
    
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],
    
    // Altri provider...
],
```

## Regola Fondamentale: Evitare Duplicazioni

**IMPORTANTE**: Evitare di duplicare le configurazioni generiche all'interno delle configurazioni specifiche per provider. Ad esempio:

❌ **ERRATO**:
```php
'drivers' => [
    'netfun' => [
        // ...
        'max_retries' => env('NETFUN_MAX_RETRIES', 3),      // Duplica 'retry.attempts'
        'retry_delay' => env('NETFUN_RETRY_DELAY', 1),      // Duplica 'retry.delay'
        'rate_limit' => env('NETFUN_RATE_LIMIT', 100),      // Duplica 'rate_limit.max_attempts'
        'rate_limit_window' => env('NETFUN_RATE_LIMIT_WINDOW', 60), // Duplica 'rate_limit.decay_minutes'
        // ...
    ],
],
```

✅ **CORRETTO**:
```php
// Configurazioni generiche a livello di root
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],

// Solo configurazioni specifiche per provider nella sezione 'drivers'
'drivers' => [
    'netfun' => [
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', ''),
        'sender' => env('NETFUN_SENDER', '<nome progetto>'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        
        // Solo configurazioni veramente specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Gestione Precedenze

Quando sia le configurazioni generiche che quelle specifiche per provider sono presenti:

1. Le configurazioni specifiche per provider hanno **precedenza** sulle configurazioni generiche
2. Il codice che utilizza queste configurazioni deve implementare questa logica di precedenza

Esempio di implementazione della logica di precedenza:

```php
// In una classe che gestisce l'invio SMS
$retryAttempts = $config['drivers'][$driver]['max_retries'] ?? $config['retry']['attempts'];
$retryDelay = $config['drivers'][$driver]['retry_delay'] ?? $config['retry']['delay'];
```

## Checklist di Verifica

- [ ] Configurazioni generiche (retry, rate_limit, ecc.) definite a livello di root
- [ ] Configurazioni specifiche per provider definite solo nella sezione `drivers`
- [ ] Nessuna duplicazione tra configurazioni generiche e specifiche
- [ ] Logica di precedenza implementata nel codice che utilizza queste configurazioni

## Collegamenti

- [Configurazione Netfun](./netfun_config_requirements.md)
- [Configurazione Netfun](../../netfun_config_requirements.md)
- [Provider SMS Supportati](./notifications/sms_provider_configuration.md)

---

*Ultimo aggiornamento: [DATE]*

---

## sms-configuration-access

*Consolidated from: `sms-configuration-access.md`*


## Problema Identificato

È stato identificato un errore comune nell'implementazione delle azioni SMS: l'utilizzo di `config('services.*.token')` invece di `config('sms.drivers.*.token')`.

Questo errore viola i principi di modularità e coerenza dell'architettura di , dove ogni modulo gestisce le proprie configurazioni in file dedicati.
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
4. **Standardizzazione**: Segue la struttura standardizzata documentata in [SMS_CONFIG_STRUCTURE.md](./sms_config_structure.md)
4. **Standardizzazione**: Segue la struttura standardizzata documentata in [SMS_CONFIG_STRUCTURE.md](../../sms_config_structure.md)

## Checklist di Verifica

Per ogni azione SMS, verificare che:

- [ ] La configurazione del provider sia recuperata da `config('sms.drivers.*')`
- [ ] I parametri globali siano recuperati da `config('sms.*')`
- [ ] Non ci siano riferimenti a `config('services.*')`
- [ ] Vengano utilizzati valori predefiniti appropriati
- [ ] Sia implementata la gestione degli errori per configurazioni mancanti

## Collegamenti

- [Struttura della Configurazione SMS](./sms_config_structure.md)
- [Requisiti di Configurazione Netfun](./netfun_config_requirements.md)
- [Pattern Factory per SMS](./sms-action-factory-analysis.md)
- [Struttura della Configurazione SMS](../../sms_config_structure.md)
- [Requisiti di Configurazione Netfun](../../netfun_config_requirements.md)
- [Pattern Factory per SMS](../../sms-action-factory-analysis.md)

---

## sms-driver-enum-translations-1

*Consolidated from: `sms-driver-enum-translations.md`*


## Panoramica

Il `SmsDriverEnum` utilizza il `TransTrait` per gestire automaticamente le traduzioni dei driver SMS supportati. Questo permette di avere etichette, colori, icone e descrizioni localizzate per ogni provider SMS.

## Struttura Enum

```php
enum SmsDriverEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;

    case SMSFACTOR = 'smsfactor';
    case TWILIO = 'twilio';
    case NEXMO = 'nexmo';
    case PLIVO = 'plivo';
    case GAMMU = 'gammu';
    case NETFUN = 'netfun';
    case AGILETELECOM = 'agiletelecom';
}
```

## Metodi di Traduzione

L'enum implementa i seguenti metodi che utilizzano il `TransTrait`:

```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value . '.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value . '.description');
}
```

## File di Traduzione

Le traduzioni sono gestite tramite il file `sms_driver_enum.php` in ogni lingua:

### Struttura File
```
laravel/Modules/Notify/lang/
├── it/sms_driver_enum.php
├── en/sms_driver_enum.php
└── de/sms_driver_enum.php
```

### Formato Traduzioni

Ogni driver ha la seguente struttura:

```php
'smsfactor' => [
    'label' => 'SMSFactor',
    'color' => 'primary',
    'icon' => 'heroicon-o-device-phone-mobile',
    'description' => 'Provider SMS francese con API REST e supporto per messaggi bulk',
],
```

## Driver Supportati

### 1. SMSFactor
- **Label**: SMSFactor
- **Color**: primary
- **Icon**: heroicon-o-device-phone-mobile
- **Description**: Provider SMS francese con API REST e supporto per messaggi bulk

### 2. Twilio
- **Label**: Twilio
- **Color**: success
- **Icon**: heroicon-o-chat-bubble-left-right
- **Description**: Piattaforma cloud per comunicazioni con API robuste e documentazione completa

### 3. Nexmo (Vonage)
- **Label**: Nexmo (Vonage)
- **Color**: warning
- **Icon**: heroicon-o-globe-alt
- **Description**: Provider globale per SMS e comunicazioni con copertura internazionale

### 4. Plivo
- **Label**: Plivo
- **Color**: info
- **Icon**: heroicon-o-phone
- **Description**: Piattaforma per comunicazioni vocali e SMS con API semplici

### 5. Gammu
- **Label**: Gammu
- **Color**: secondary
- **Icon**: heroicon-o-cpu-chip
- **Description**: Libreria open source per gestione modem GSM e invio SMS

### 6. Netfun
- **Label**: Netfun
- **Color**: danger
- **Icon**: heroicon-o-bolt
- **Description**: Provider italiano per SMS con supporto per messaggi promozionali e transazionali

### 7. Agile Telecom
- **Label**: Agile Telecom
- **Color**: gray
- **Icon**: heroicon-o-truck
- **Description**: Provider italiano per servizi di telecomunicazioni e SMS

## Utilizzo in Filament

L'enum può essere utilizzato direttamente nei componenti Filament:

```php
use Modules\Notify\Enums\SmsDriverEnum;

// In un form
Select::make('driver')
    ->options(SmsDriverEnum::class)
    ->required();

// In una tabella
TextColumn::make('driver')
    ->formatStateUsing(fn (SmsDriverEnum $state) => $state->getLabel())
    ->color(fn (SmsDriverEnum $state) => $state->getColor())
    ->icon(fn (SmsDriverEnum $state) => $state->getIcon());
```

## Chiavi di Traduzione

Il `TransTrait` genera automaticamente le seguenti chiavi:

- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.label`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.color`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.icon`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.description`

## Aggiunta Nuovi Driver

Per aggiungere un nuovo driver:

1. **Aggiungere il case nell'enum**:
```php
case NUOVO_DRIVER = 'nuovo_driver';
```

2. **Aggiungere le traduzioni** in tutti i file di lingua:
```php
'nuovo_driver' => [
    'label' => 'Nuovo Driver',
    'color' => 'primary',
    'icon' => 'heroicon-o-star',
    'description' => 'Descrizione del nuovo driver',
],
```

3. **Aggiornare la configurazione** in `config/sms.php` se necessario

## Verifica Traduzioni

Per verificare che tutte le traduzioni siano presenti:

```bash

# Verifica sintassi PHP
php -l laravel/Modules/Notify/lang/it/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/en/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/de/sms_driver_enum.php
```

## Collegamenti

- [SmsDriverEnum](../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../config/sms.php)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [SmsDriverEnum](../../../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../../../config/sms.php)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

## sms-driver-enum-translations-2

*Consolidated from: `sms-driver-enum-translations.md`*

title: "Traduzioni SmsDriverEnum - Modulo Notify"
type: concept
tags: [sms, driver, enum, translations]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-driver-enum-translations-2 traduzioni smsdriverenum - modulo notify"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Traduzioni SmsDriverEnum - Modulo Notify

## Panoramica

Il `SmsDriverEnum` utilizza il `TransTrait` per gestire automaticamente le traduzioni dei driver SMS supportati. Questo permette di avere etichette, colori, icone e descrizioni localizzate per ogni provider SMS.

## Struttura Enum

```php
enum SmsDriverEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    
    case SMSFACTOR = 'smsfactor';
    case TWILIO = 'twilio';
    case NEXMO = 'nexmo';
    case PLIVO = 'plivo';
    case GAMMU = 'gammu';
    case NETFUN = 'netfun';
    case AGILETELECOM = 'agiletelecom';
}
```

## Metodi di Traduzione

L'enum implementa i seguenti metodi che utilizzano il `TransTrait`:

```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value . '.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value . '.description');
}
```

## File di Traduzione

Le traduzioni sono gestite tramite il file `sms_driver_enum.php` in ogni lingua:

### Struttura File
```
laravel/Modules/Notify/lang/
├── it/sms_driver_enum.php
├── en/sms_driver_enum.php
└── de/sms_driver_enum.php
```

### Formato Traduzioni

Ogni driver ha la seguente struttura:

```php
'smsfactor' => [
    'label' => 'SMSFactor',
    'color' => 'primary',
    'icon' => 'heroicon-o-device-phone-mobile',
    'description' => 'Provider SMS francese con API REST e supporto per messaggi bulk',
],
```

## Driver Supportati

### 1. SMSFactor
- **Label**: SMSFactor
- **Color**: primary
- **Icon**: heroicon-o-device-phone-mobile
- **Description**: Provider SMS francese con API REST e supporto per messaggi bulk

### 2. Twilio
- **Label**: Twilio
- **Color**: success
- **Icon**: heroicon-o-chat-bubble-left-right
- **Description**: Piattaforma cloud per comunicazioni con API robuste e documentazione completa

### 3. Nexmo (Vonage)
- **Label**: Nexmo (Vonage)
- **Color**: warning
- **Icon**: heroicon-o-globe-alt
- **Description**: Provider globale per SMS e comunicazioni con copertura internazionale

### 4. Plivo
- **Label**: Plivo
- **Color**: info
- **Icon**: heroicon-o-phone
- **Description**: Piattaforma per comunicazioni vocali e SMS con API semplici

### 5. Gammu
- **Label**: Gammu
- **Color**: secondary
- **Icon**: heroicon-o-cpu-chip
- **Description**: Libreria open source per gestione modem GSM e invio SMS

### 6. Netfun
- **Label**: Netfun
- **Color**: danger
- **Icon**: heroicon-o-bolt
- **Description**: Provider italiano per SMS con supporto per messaggi promozionali e transazionali

### 7. Agile Telecom
- **Label**: Agile Telecom
- **Color**: gray
- **Icon**: heroicon-o-truck
- **Description**: Provider italiano per servizi di telecomunicazioni e SMS

## Utilizzo in Filament

L'enum può essere utilizzato direttamente nei componenti Filament:

```php
use Modules\Notify\Enums\SmsDriverEnum;

// In un form
Select::make('driver')
    ->options(SmsDriverEnum::class)
    ->required();

// In una tabella
TextColumn::make('driver')
    ->formatStateUsing(fn (SmsDriverEnum $state) => $state->getLabel())
    ->color(fn (SmsDriverEnum $state) => $state->getColor())
    ->icon(fn (SmsDriverEnum $state) => $state->getIcon());
```

## Chiavi di Traduzione

Il `TransTrait` genera automaticamente le seguenti chiavi:

- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.label`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.color`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.icon`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.description`

## Aggiunta Nuovi Driver

Per aggiungere un nuovo driver:

1. **Aggiungere il case nell'enum**:
```php
case NUOVO_DRIVER = 'nuovo_driver';
```

2. **Aggiungere le traduzioni** in tutti i file di lingua:
```php
'nuovo_driver' => [
    'label' => 'Nuovo Driver',
    'color' => 'primary',
    'icon' => 'heroicon-o-star',
    'description' => 'Descrizione del nuovo driver',
],
```

3. **Aggiornare la configurazione** in `config/sms.php` se necessario

## Verifica Traduzioni

Per verificare che tutte le traduzioni siano presenti:

```bash

# Verifica sintassi PHP
php -l laravel/Modules/Notify/lang/it/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/en/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/de/sms_driver_enum.php
```

## Collegamenti

- [SmsDriverEnum](../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../config/sms.php)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [SmsDriverEnum](../../../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../../../config/sms.php)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

## sms-driver-enum-translations

*Consolidated from: `sms-driver-enum-translations.md`*


## Panoramica

Il `SmsDriverEnum` utilizza il `TransTrait` per gestire automaticamente le traduzioni dei driver SMS supportati. Questo permette di avere etichette, colori, icone e descrizioni localizzate per ogni provider SMS.

## Struttura Enum

```php
enum SmsDriverEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    
    case SMSFACTOR = 'smsfactor';
    case TWILIO = 'twilio';
    case NEXMO = 'nexmo';
    case PLIVO = 'plivo';
    case GAMMU = 'gammu';
    case NETFUN = 'netfun';
    case AGILETELECOM = 'agiletelecom';
}
```

## Metodi di Traduzione

L'enum implementa i seguenti metodi che utilizzano il `TransTrait`:

```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value . '.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value . '.description');
}
```

## File di Traduzione

Le traduzioni sono gestite tramite il file `sms_driver_enum.php` in ogni lingua:

### Struttura File
```
laravel/Modules/Notify/lang/
├── it/sms_driver_enum.php
├── en/sms_driver_enum.php
└── de/sms_driver_enum.php
```

### Formato Traduzioni

Ogni driver ha la seguente struttura:

```php
'smsfactor' => [
    'label' => 'SMSFactor',
    'color' => 'primary',
    'icon' => 'heroicon-o-device-phone-mobile',
    'description' => 'Provider SMS francese con API REST e supporto per messaggi bulk',
],
```

## Driver Supportati

### 1. SMSFactor
- **Label**: SMSFactor
- **Color**: primary
- **Icon**: heroicon-o-device-phone-mobile
- **Description**: Provider SMS francese con API REST e supporto per messaggi bulk

### 2. Twilio
- **Label**: Twilio
- **Color**: success
- **Icon**: heroicon-o-chat-bubble-left-right
- **Description**: Piattaforma cloud per comunicazioni con API robuste e documentazione completa

### 3. Nexmo (Vonage)
- **Label**: Nexmo (Vonage)
- **Color**: warning
- **Icon**: heroicon-o-globe-alt
- **Description**: Provider globale per SMS e comunicazioni con copertura internazionale

### 4. Plivo
- **Label**: Plivo
- **Color**: info
- **Icon**: heroicon-o-phone
- **Description**: Piattaforma per comunicazioni vocali e SMS con API semplici

### 5. Gammu
- **Label**: Gammu
- **Color**: secondary
- **Icon**: heroicon-o-cpu-chip
- **Description**: Libreria open source per gestione modem GSM e invio SMS

### 6. Netfun
- **Label**: Netfun
- **Color**: danger
- **Icon**: heroicon-o-bolt
- **Description**: Provider italiano per SMS con supporto per messaggi promozionali e transazionali

### 7. Agile Telecom
- **Label**: Agile Telecom
- **Color**: gray
- **Icon**: heroicon-o-truck
- **Description**: Provider italiano per servizi di telecomunicazioni e SMS

## Utilizzo in Filament

L'enum può essere utilizzato direttamente nei componenti Filament:

```php
use Modules\Notify\Enums\SmsDriverEnum;

// In un form
Select::make('driver')
    ->options(SmsDriverEnum::class)
    ->required();

// In una tabella
TextColumn::make('driver')
    ->formatStateUsing(fn (SmsDriverEnum $state) => $state->getLabel())
    ->color(fn (SmsDriverEnum $state) => $state->getColor())
    ->icon(fn (SmsDriverEnum $state) => $state->getIcon());
```

## Chiavi di Traduzione

Il `TransTrait` genera automaticamente le seguenti chiavi:

- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.label`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.color`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.icon`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.description`

## Aggiunta Nuovi Driver

Per aggiungere un nuovo driver:

1. **Aggiungere il case nell'enum**:
```php
case NUOVO_DRIVER = 'nuovo_driver';
```

2. **Aggiungere le traduzioni** in tutti i file di lingua:
```php
'nuovo_driver' => [
    'label' => 'Nuovo Driver',
    'color' => 'primary',
    'icon' => 'heroicon-o-star',
    'description' => 'Descrizione del nuovo driver',
],
```

3. **Aggiornare la configurazione** in `config/sms.php` se necessario

## Verifica Traduzioni

Per verificare che tutte le traduzioni siano presenti:

```bash

# Verifica sintassi PHP
php -l laravel/Modules/Notify/lang/it/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/en/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/de/sms_driver_enum.php
```

## Collegamenti

- [SmsDriverEnum](../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../config/sms.php)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [SmsDriverEnum](../../../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../../../config/sms.php)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

## sms-driver-selection-analysis-1

*Consolidated from: `sms-driver-selection-analysis.md`*

title: "Analisi: Spostamento Logica Selezione Driver in SmsData"
type: concept
tags: [sms, driver, selection, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-driver-selection-analysis-1 analisi: spostamento logica selezione driver in smsdata"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Analisi: Spostamento Logica Selezione Driver in SmsData

## Contesto Attuale
Attualmente, la logica di selezione del driver SMS è implementata nel canale di notifica:

```php
$driver = Config::get('sms.default', 'smsfactor');

$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

## Proposta di Modifica
Spostare questa logica all'interno di `SmsData`:

```php
class SmsData extends Data
{
    public function getAction(): SendSmsActionInterface
    {
        $driver = Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

## Analisi dei Vantaggi (60%)

### 1. Incapsulamento (25%)
- La logica di selezione del driver è strettamente correlata ai dati SMS
- Riduce l'accoppiamento tra il canale e i dettagli di implementazione
- Migliora la coesione del codice

### 2. Riutilizzabilità (15%)
- La logica può essere riutilizzata in altri contesti oltre al canale
- Facilita l'implementazione di nuovi punti di invio SMS
- Riduce la duplicazione del codice

### 3. Manutenibilità (10%)
- Centralizza la logica di selezione del driver
- Semplifica le modifiche future alla logica di selezione
- Riduce il rischio di inconsistenze

### 4. Testabilità (10%)
- Facilita il testing isolato della logica di selezione
- Permette di mockare più facilmente l'azione corretta
- Migliora la copertura dei test

## Analisi degli Svantaggi (40%)

### 1. Violazione del Principio di Responsabilità Singola (20%)
- `SmsData` dovrebbe rappresentare solo i dati
- Aggiunge una responsabilità non correlata alla rappresentazione dei dati
- Potrebbe violare il principio di separazione delle preoccupazioni

### 2. Complessità Aggiuntiva (10%)
- Aumenta la complessità della classe `SmsData`
- Potrebbe rendere il codice meno intuitivo
- Richiede una documentazione più dettagliata

### 3. Dipendenze (5%)
- Introduce dipendenze aggiuntive in `SmsData`
- Potrebbe complicare l'inizializzazione dell'oggetto
- Aumenta il rischio di problemi di circolarità

### 4. Flessibilità (5%)
- Potrebbe limitare la flessibilità nella gestione dei driver
- Rende più difficile l'implementazione di logiche di selezione personalizzate
- Potrebbe complicare l'aggiunta di nuovi driver

## Raccomandazione

Basandosi sull'analisi, la raccomandazione è di **NON** spostare la logica di selezione del driver in `SmsData` per i seguenti motivi:

1. La violazione del principio di responsabilità singola è un problema significativo
2. I vantaggi in termini di incapsulamento non giustificano la complessità aggiuntiva
3. La logica di selezione del driver è più appropriata in un servizio dedicato

### Alternativa Proposta

Creare un servizio dedicato per la gestione dei driver:

```php
class SmsDriverService
{
    public function getAction(string $driver = null): SendSmsActionInterface
    {
        $driver = $driver ?? Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

Questa soluzione:
- Mantiene la separazione delle responsabilità
- Centralizza la logica di selezione
- È più facile da testare e mantenere
- Non viola i principi SOLID 

---

## sms-driver-selection-analysis

*Consolidated from: `sms-driver-selection-analysis.md`*


## Contesto Attuale
Attualmente, la logica di selezione del driver SMS è implementata nel canale di notifica:

```php
$driver = Config::get('sms.default', 'smsfactor');

$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

## Proposta di Modifica
Spostare questa logica all'interno di `SmsData`:

```php
class SmsData extends Data
{
    public function getAction(): SendSmsActionInterface
    {
        $driver = Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

## Analisi dei Vantaggi (60%)

### 1. Incapsulamento (25%)
- La logica di selezione del driver è strettamente correlata ai dati SMS
- Riduce l'accoppiamento tra il canale e i dettagli di implementazione
- Migliora la coesione del codice

### 2. Riutilizzabilità (15%)
- La logica può essere riutilizzata in altri contesti oltre al canale
- Facilita l'implementazione di nuovi punti di invio SMS
- Riduce la duplicazione del codice

### 3. Manutenibilità (10%)
- Centralizza la logica di selezione del driver
- Semplifica le modifiche future alla logica di selezione
- Riduce il rischio di inconsistenze

### 4. Testabilità (10%)
- Facilita il testing isolato della logica di selezione
- Permette di mockare più facilmente l'azione corretta
- Migliora la copertura dei test

## Analisi degli Svantaggi (40%)

### 1. Violazione del Principio di Responsabilità Singola (20%)
- `SmsData` dovrebbe rappresentare solo i dati
- Aggiunge una responsabilità non correlata alla rappresentazione dei dati
- Potrebbe violare il principio di separazione delle preoccupazioni

### 2. Complessità Aggiuntiva (10%)
- Aumenta la complessità della classe `SmsData`
- Potrebbe rendere il codice meno intuitivo
- Richiede una documentazione più dettagliata

### 3. Dipendenze (5%)
- Introduce dipendenze aggiuntive in `SmsData`
- Potrebbe complicare l'inizializzazione dell'oggetto
- Aumenta il rischio di problemi di circolarità

### 4. Flessibilità (5%)
- Potrebbe limitare la flessibilità nella gestione dei driver
- Rende più difficile l'implementazione di logiche di selezione personalizzate
- Potrebbe complicare l'aggiunta di nuovi driver

## Raccomandazione

Basandosi sull'analisi, la raccomandazione è di **NON** spostare la logica di selezione del driver in `SmsData` per i seguenti motivi:

1. La violazione del principio di responsabilità singola è un problema significativo
2. I vantaggi in termini di incapsulamento non giustificano la complessità aggiuntiva
3. La logica di selezione del driver è più appropriata in un servizio dedicato

### Alternativa Proposta

Creare un servizio dedicato per la gestione dei driver:

```php
class SmsDriverService
{
    public function getAction(string $driver = null): SendSmsActionInterface
    {
        $driver = $driver ?? Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

Questa soluzione:
- Mantiene la separazione delle responsabilità
- Centralizza la logica di selezione
- È più facile da testare e mantenere
- Non viola i principi SOLID 

---

## sms-driver-selection-specific-analysis-1

*Consolidated from: `sms-driver-selection-specific-analysis.md`*

title: "Analisi Specifica: Validazione e Selezione Driver in SmsData"
type: concept
tags: [sms, driver, selection, specific]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-driver-selection-specific-analysis-1 analisi specifica: validazione e selezione driver in smsdata"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Analisi Specifica: Validazione e Selezione Driver in SmsData

## Contesto Specifico
```php
if (! $smsData instanceof SmsData) {
    throw new Exception('toSms method must return an instance of SmsData');
}

$driver = Config::get('sms.default', 'smsfactor');

$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

## Analisi dei Vantaggi (45%)

### 1. Validazione Integrata (20%)
- La validazione del tipo di dato è strettamente correlata alla classe `SmsData`
- Riduce la duplicazione del codice di validazione
- Centralizza la logica di validazione

### 2. Coerenza dei Dati (15%)
- Garantisce che i dati siano sempre validi prima dell'invio
- Riduce il rischio di errori runtime
- Migliora la robustezza del codice

### 3. Manutenibilità (10%)
- Semplifica la gestione delle modifiche alla validazione
- Centralizza la logica di selezione del driver
- Riduce la complessità del canale di notifica

## Analisi degli Svantaggi (55%)

### 1. Violazione del Principio di Responsabilità Singola (25%)
- `SmsData` dovrebbe occuparsi solo della rappresentazione dei dati
- La validazione e selezione del driver sono responsabilità separate
- Aumenta l'accoppiamento tra dati e logica di business

### 2. Complessità Aggiuntiva (15%)
- Aumenta la complessità della classe `SmsData`
- Rende il codice meno intuitivo
- Richiede una documentazione più dettagliata

### 3. Testabilità (10%)
- Rende più difficile il testing isolato
- Complica il mocking delle dipendenze
- Aumenta la complessità dei test unitari

### 4. Flessibilità (5%)
- Limita la possibilità di personalizzare la validazione
- Rende più difficile l'estensione della logica
- Complica l'aggiunta di nuovi driver

## Raccomandazione Finale

Basandosi sull'analisi specifica, la raccomandazione è di **NON** spostare la logica in `SmsData` per i seguenti motivi:

1. La violazione del principio di responsabilità singola è particolarmente critica in questo caso
2. Gli svantaggi superano i vantaggi (55% vs 45%)
3. La complessità aggiuntiva non è giustificata dai benefici

### Soluzione Proposta

Creare un servizio dedicato che gestisca sia la validazione che la selezione del driver:

```php
class SmsService
{
    public function validateAndGetAction($smsData): SendSmsActionInterface
    {
        if (! $smsData instanceof SmsData) {
            throw new Exception('toSms method must return an instance of SmsData');
        }

        $driver = Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

Questa soluzione:
- Mantiene la separazione delle responsabilità
- Centralizza sia la validazione che la selezione del driver
- È più facile da testare e mantenere
- Non viola i principi SOLID
- Mantiene `SmsData` focalizzato sulla sua responsabilità primaria 

---

## sms-driver-selection-specific-analysis

*Consolidated from: `sms-driver-selection-specific-analysis.md`*


## Contesto Specifico
```php
if (! $smsData instanceof SmsData) {
    throw new Exception('toSms method must return an instance of SmsData');
}

$driver = Config::get('sms.default', 'smsfactor');

$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

## Analisi dei Vantaggi (45%)

### 1. Validazione Integrata (20%)
- La validazione del tipo di dato è strettamente correlata alla classe `SmsData`
- Riduce la duplicazione del codice di validazione
- Centralizza la logica di validazione

### 2. Coerenza dei Dati (15%)
- Garantisce che i dati siano sempre validi prima dell'invio
- Riduce il rischio di errori runtime
- Migliora la robustezza del codice

### 3. Manutenibilità (10%)
- Semplifica la gestione delle modifiche alla validazione
- Centralizza la logica di selezione del driver
- Riduce la complessità del canale di notifica

## Analisi degli Svantaggi (55%)

### 1. Violazione del Principio di Responsabilità Singola (25%)
- `SmsData` dovrebbe occuparsi solo della rappresentazione dei dati
- La validazione e selezione del driver sono responsabilità separate
- Aumenta l'accoppiamento tra dati e logica di business

### 2. Complessità Aggiuntiva (15%)
- Aumenta la complessità della classe `SmsData`
- Rende il codice meno intuitivo
- Richiede una documentazione più dettagliata

### 3. Testabilità (10%)
- Rende più difficile il testing isolato
- Complica il mocking delle dipendenze
- Aumenta la complessità dei test unitari

### 4. Flessibilità (5%)
- Limita la possibilità di personalizzare la validazione
- Rende più difficile l'estensione della logica
- Complica l'aggiunta di nuovi driver

## Raccomandazione Finale

Basandosi sull'analisi specifica, la raccomandazione è di **NON** spostare la logica in `SmsData` per i seguenti motivi:

1. La violazione del principio di responsabilità singola è particolarmente critica in questo caso
2. Gli svantaggi superano i vantaggi (55% vs 45%)
3. La complessità aggiuntiva non è giustificata dai benefici

### Soluzione Proposta

Creare un servizio dedicato che gestisca sia la validazione che la selezione del driver:

```php
class SmsService
{
    public function validateAndGetAction($smsData): SendSmsActionInterface
    {
        if (! $smsData instanceof SmsData) {
            throw new Exception('toSms method must return an instance of SmsData');
        }

        $driver = Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

Questa soluzione:
- Mantiene la separazione delle responsabilità
- Centralizza sia la validazione che la selezione del driver
- È più facile da testare e mantenere
- Non viola i principi SOLID
- Mantiene `SmsData` focalizzato sulla sua responsabilità primaria 

---

## sms-factor-data-implementation-1

*Consolidated from: `sms-factor-data-implementation.md`*

title: "SmsFactorData Implementation Summary"
type: concept
tags: [sms, factor, data, implementation]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-factor-data-implementation-1 smsfactordata implementation summary"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# SmsFactorData Implementation Summary

## Overview

This document summarizes the implementation of the `SmsFactorData` class and the refactoring of `SendSmsFactorSMSAction` to follow the same pattern as `AgiletelecomData`.

## Changes Made

### 1. Created SmsFactorData Class

**File**: `/Modules/Notify/app/Datas/SMS/SmsFactorData.php`

- **Purpose**: Centralized configuration management for SMSFactor SMS provider
- **Pattern**: Follows the same structure as `AgiletelecomData`
- **Features**:
  - Singleton pattern implementation
  - Configuration loading from `config('sms.drivers.smsfactor')`
  - Authentication header generation
  - Helper methods for common operations

**Key Properties**:
- `$token`: SMSFactor API token
- `$base_url`: API endpoint URL (default: https://api.smsfactor.com)
- `$auth_type`: Authentication type (default: 'bearer')
- `$timeout`: HTTP request timeout (default: 30 seconds)

**Key Methods**:
- `make()`: Singleton factory method
- `getAuthHeaders()`: Returns Bearer authentication headers
- `getBaseUrl()`: Returns configured base URL
- `getTimeout()`: Returns configured timeout

### 2. Refactored SendSmsFactorSMSAction

**File**: `/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`

**Changes**:
- Replaced manual configuration handling with `SmsFactorData` usage
- Removed redundant properties (`$token`, `$baseUrl`, `$timeout`)
- Simplified constructor logic
- Updated `execute()` method to use data class methods

**Before**:
```php
private string $token;
private string $baseUrl;
private int $timeout;

public function __construct()
{
    $config = config('sms.drivers.smsfactor');
    $this->token = $config['token'] ?? null;
    $this->baseUrl = $config['base_url'] ?? 'https://api.smsfactor.com';
    $this->timeout = (int) config('sms.timeout', 30);
}
```

**After**:
```php
private SmsFactorData $smsFactorData;

public function __construct()
{
    $this->smsFactorData = SmsFactorData::make();
    
    if (!$this->smsFactorData->token) {
        throw new Exception('Token SMSFactor non configurato in sms.php');
    }
}
```

### 3. Updated Documentation

**Files Created/Updated**:
- `/Modules/Notify/project_docs/sms/drivers/smsfactor/data-class.md`: Comprehensive documentation for `SmsFactorData`
- `/Modules/Notify/project_docs/sms-implementation.md`: Updated to include data class information

**Documentation Includes**:
- Complete class structure and properties
- Method descriptions and usage examples
- Configuration requirements
- Environment variable setup
- Usage patterns and best practices
- Migration guide from direct configuration access

## Benefits of This Implementation

### 1. Consistency
- Follows the same pattern as `AgiletelecomData`
- Standardized approach across SMS providers
- Consistent method naming and structure

### 2. Type Safety
- Leverages Spatie Laravel Data for type safety
- Explicit property types and method signatures
- Better IDE support and autocompletion

### 3. Centralized Configuration
- Single point of configuration management
- Singleton pattern prevents multiple configuration loads
- Easy to extend with additional properties

### 4. Maintainability
- Cleaner action classes with reduced complexity
- Separation of concerns between configuration and business logic
- Easier testing with mockable data objects

### 5. Reusability
- Data class can be used by other SMS-related classes
- Helper methods reduce code duplication
- Standardized authentication header generation

## Configuration Requirements

### Environment Variables
```env
SMSFACTOR_TOKEN=your_smsfactor_api_token
SMSFACTOR_BASE_URL=https://api.smsfactor.com
```

### SMS Configuration
```php
// config/sms.php
'drivers' => [
    'smsfactor' => [
        'token' => env('SMSFACTOR_TOKEN'),
        'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
    ],
],
```

## Usage Example

```php
use Modules\Notify\Datas\SMS\SmsFactorData;
use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;

// Get configuration data
$smsFactorData = SmsFactorData::make();

// Use in action
$action = new SendSmsFactorSMSAction();
$result = $action->execute($smsData);

// Direct usage of data class
$headers = $smsFactorData->getAuthHeaders();
$baseUrl = $smsFactorData->getBaseUrl();
```

## Testing Considerations

The new implementation makes testing easier by allowing mock data objects:

```php
// Create test data
$testData = SmsFactorData::from([
    'token' => 'test_token',
    'base_url' => 'https://test.smsfactor.com',
    'timeout' => 10
]);

// Use in tests
$headers = $testData->getAuthHeaders();
$this->assertEquals('Bearer test_token', $headers['Authorization']);
```

## Future Enhancements

1. **Additional Providers**: The same pattern can be applied to other SMS providers
2. **Configuration Validation**: Add validation rules to the data class
3. **Caching**: Implement configuration caching for better performance
4. **Monitoring**: Add logging and monitoring capabilities to the data class

## Related Files

- `/Modules/Notify/app/Datas/SMS/AgiletelecomData.php`: Similar implementation for Agiletelecom
- `/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`: Refactored action class
- `/Modules/Notify/config/sms.php`: SMS configuration file
- `/Modules/Notify/project_docs/sms-implementation.md`: General SMS implementation documentation

## Conclusion

The implementation of `SmsFactorData` and the refactoring of `SendSmsFactorSMSAction` successfully follows the established pattern and provides a more maintainable, type-safe, and consistent approach to SMS provider configuration management. This change aligns with the project's architecture principles and makes the codebase more robust and easier to extend.

---

## sms-factor-data-implementation

*Consolidated from: `sms-factor-data-implementation.md`*


## Overview

This document summarizes the implementation of the `SmsFactorData` class and the refactoring of `SendSmsFactorSMSAction` to follow the same pattern as `AgiletelecomData`.

## Changes Made

### 1. Created SmsFactorData Class

**File**: `/Modules/Notify/app/Datas/SMS/SmsFactorData.php`

- **Purpose**: Centralized configuration management for SMSFactor SMS provider
- **Pattern**: Follows the same structure as `AgiletelecomData`
- **Features**:
  - Singleton pattern implementation
  - Configuration loading from `config('sms.drivers.smsfactor')`
  - Authentication header generation
  - Helper methods for common operations

**Key Properties**:
- `$token`: SMSFactor API token
- `$base_url`: API endpoint URL (default: https://api.smsfactor.com)
- `$auth_type`: Authentication type (default: 'bearer')
- `$timeout`: HTTP request timeout (default: 30 seconds)

**Key Methods**:
- `make()`: Singleton factory method
- `getAuthHeaders()`: Returns Bearer authentication headers
- `getBaseUrl()`: Returns configured base URL
- `getTimeout()`: Returns configured timeout

### 2. Refactored SendSmsFactorSMSAction

**File**: `/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`

**Changes**:
- Replaced manual configuration handling with `SmsFactorData` usage
- Removed redundant properties (`$token`, `$baseUrl`, `$timeout`)
- Simplified constructor logic
- Updated `execute()` method to use data class methods

**Before**:
```php
private string $token;
private string $baseUrl;
private int $timeout;

public function __construct()
{
    $config = config('sms.drivers.smsfactor');
    $this->token = $config['token'] ?? null;
    $this->baseUrl = $config['base_url'] ?? 'https://api.smsfactor.com';
    $this->timeout = (int) config('sms.timeout', 30);
}
```

**After**:
```php
private SmsFactorData $smsFactorData;

public function __construct()
{
    $this->smsFactorData = SmsFactorData::make();
    
    if (!$this->smsFactorData->token) {
        throw new Exception('Token SMSFactor non configurato in sms.php');
    }
}
```

### 3. Updated Documentation

**Files Created/Updated**:
- `/Modules/Notify/project_docs/sms/drivers/smsfactor/data-class.md`: Comprehensive documentation for `SmsFactorData`
- `/Modules/Notify/project_docs/sms_implementation.md`: Updated to include data class information
- `/Modules/Notify/docs/sms/drivers/smsfactor/data-class.md`: Comprehensive documentation for `SmsFactorData`
- `/Modules/Notify/docs/sms_implementation.md`: Updated to include data class information

**Documentation Includes**:
- Complete class structure and properties
- Method descriptions and usage examples
- Configuration requirements
- Environment variable setup
- Usage patterns and best practices
- Migration guide from direct configuration access

## Benefits of This Implementation

### 1. Consistency
- Follows the same pattern as `AgiletelecomData`
- Standardized approach across SMS providers
- Consistent method naming and structure

### 2. Type Safety
- Leverages Spatie Laravel Data for type safety
- Explicit property types and method signatures
- Better IDE support and autocompletion

### 3. Centralized Configuration
- Single point of configuration management
- Singleton pattern prevents multiple configuration loads
- Easy to extend with additional properties

### 4. Maintainability
- Cleaner action classes with reduced complexity
- Separation of concerns between configuration and business logic
- Easier testing with mockable data objects

### 5. Reusability
- Data class can be used by other SMS-related classes
- Helper methods reduce code duplication
- Standardized authentication header generation

## Configuration Requirements

### Environment Variables
```env
SMSFACTOR_TOKEN=your_smsfactor_api_token
SMSFACTOR_BASE_URL=https://api.smsfactor.com
```

### SMS Configuration
```php
// config/sms.php
'drivers' => [
    'smsfactor' => [
        'token' => env('SMSFACTOR_TOKEN'),
        'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
    ],
],
```

## Usage Example

```php
use Modules\Notify\Datas\SMS\SmsFactorData;
use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;

// Get configuration data
$smsFactorData = SmsFactorData::make();

// Use in action
$action = new SendSmsFactorSMSAction();
$result = $action->execute($smsData);

// Direct usage of data class
$headers = $smsFactorData->getAuthHeaders();
$baseUrl = $smsFactorData->getBaseUrl();
```

## Testing Considerations

The new implementation makes testing easier by allowing mock data objects:

```php
// Create test data
$testData = SmsFactorData::from([
    'token' => 'test_token',
    'base_url' => 'https://test.smsfactor.com',
    'timeout' => 10
]);

// Use in tests
$headers = $testData->getAuthHeaders();
$this->assertEquals('Bearer test_token', $headers['Authorization']);
```

## Future Enhancements

1. **Additional Providers**: The same pattern can be applied to other SMS providers
2. **Configuration Validation**: Add validation rules to the data class
3. **Caching**: Implement configuration caching for better performance
4. **Monitoring**: Add logging and monitoring capabilities to the data class

## Related Files

- `/Modules/Notify/app/Datas/SMS/AgiletelecomData.php`: Similar implementation for Agiletelecom
- `/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`: Refactored action class
- `/Modules/Notify/config/sms.php`: SMS configuration file
- `/Modules/Notify/project_docs/sms_implementation.md`: General SMS implementation documentation
- `/Modules/Notify/docs/sms_implementation.md`: General SMS implementation documentation

## Conclusion

The implementation of `SmsFactorData` and the refactoring of `SendSmsFactorSMSAction` successfully follows the established pattern and provides a more maintainable, type-safe, and consistent approach to SMS provider configuration management. This change aligns with the project's architecture principles and makes the codebase more robust and easier to extend.

---

## sms-factorata-implementation

*Consolidated from: `sms-factorata-implementation.md`*


## Overview

This document summarizes the implementation of the `SmsFactorData` class and the refactoring of `SendSmsFactorSMSAction` to follow the same pattern as `AgiletelecomData`.

## Changes Made

### 1. Created SmsFactorData Class

**File**: `/Modules/Notify/app/Datas/SMS/SmsFactorData.php`

- **Purpose**: Centralized configuration management for SMSFactor SMS provider
- **Pattern**: Follows the same structure as `AgiletelecomData`
- **Features**:
  - Singleton pattern implementation
  - Configuration loading from `config('sms.drivers.smsfactor')`
  - Authentication header generation
  - Helper methods for common operations

**Key Properties**:
- `$token`: SMSFactor API token
- `$base_url`: API endpoint URL (default: https://api.smsfactor.com)
- `$auth_type`: Authentication type (default: 'bearer')
- `$timeout`: HTTP request timeout (default: 30 seconds)

**Key Methods**:
- `make()`: Singleton factory method
- `getAuthHeaders()`: Returns Bearer authentication headers
- `getBaseUrl()`: Returns configured base URL
- `getTimeout()`: Returns configured timeout

### 2. Refactored SendSmsFactorSMSAction

**File**: `/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`

**Changes**:
- Replaced manual configuration handling with `SmsFactorData` usage
- Removed redundant properties (`$token`, `$baseUrl`, `$timeout`)
- Simplified constructor logic
- Updated `execute()` method to use data class methods

**Before**:
```php
private string $token;
private string $baseUrl;
private int $timeout;

public function __construct()
{
    $config = config('sms.drivers.smsfactor');
    $this->token = $config['token'] ?? null;
    $this->baseUrl = $config['base_url'] ?? 'https://api.smsfactor.com';
    $this->timeout = (int) config('sms.timeout', 30);
}
```

**After**:
```php
private SmsFactorData $smsFactorData;

public function __construct()
{
    $this->smsFactorData = SmsFactorData::make();
    
    if (!$this->smsFactorData->token) {
        throw new Exception('Token SMSFactor non configurato in sms.php');
    }
}
```

### 3. Updated Documentation

**Files Created/Updated**:
- `/Modules/Notify/project_docs/sms/drivers/smsfactor/data-class.md`: Comprehensive documentation for `SmsFactorData`
- `/Modules/Notify/project_docs/sms_implementation.md`: Updated to include data class information
- `/Modules/Notify/docs/sms/drivers/smsfactor/data-class.md`: Comprehensive documentation for `SmsFactorData`
- `/Modules/Notify/docs/sms_implementation.md`: Updated to include data class information

**Documentation Includes**:
- Complete class structure and properties
- Method descriptions and usage examples
- Configuration requirements
- Environment variable setup
- Usage patterns and best practices
- Migration guide from direct configuration access

## Benefits of This Implementation

### 1. Consistency
- Follows the same pattern as `AgiletelecomData`
- Standardized approach across SMS providers
- Consistent method naming and structure

### 2. Type Safety
- Leverages Spatie Laravel Data for type safety
- Explicit property types and method signatures
- Better IDE support and autocompletion

### 3. Centralized Configuration
- Single point of configuration management
- Singleton pattern prevents multiple configuration loads
- Easy to extend with additional properties

### 4. Maintainability
- Cleaner action classes with reduced complexity
- Separation of concerns between configuration and business logic
- Easier testing with mockable data objects

### 5. Reusability
- Data class can be used by other SMS-related classes
- Helper methods reduce code duplication
- Standardized authentication header generation

## Configuration Requirements

### Environment Variables
```env
SMSFACTOR_TOKEN=your_smsfactor_api_token
SMSFACTOR_BASE_URL=https://api.smsfactor.com
```

### SMS Configuration
```php
// config/sms.php
'drivers' => [
    'smsfactor' => [
        'token' => env('SMSFACTOR_TOKEN'),
        'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
    ],
],
```

## Usage Example

```php
use Modules\Notify\Datas\SMS\SmsFactorData;
use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;

// Get configuration data
$smsFactorData = SmsFactorData::make();

// Use in action
$action = new SendSmsFactorSMSAction();
$result = $action->execute($smsData);

// Direct usage of data class
$headers = $smsFactorData->getAuthHeaders();
$baseUrl = $smsFactorData->getBaseUrl();
```

## Testing Considerations

The new implementation makes testing easier by allowing mock data objects:

```php
// Create test data
$testData = SmsFactorData::from([
    'token' => 'test_token',
    'base_url' => 'https://test.smsfactor.com',
    'timeout' => 10
]);

// Use in tests
$headers = $testData->getAuthHeaders();
$this->assertEquals('Bearer test_token', $headers['Authorization']);
```

## Future Enhancements

1. **Additional Providers**: The same pattern can be applied to other SMS providers
2. **Configuration Validation**: Add validation rules to the data class
3. **Caching**: Implement configuration caching for better performance
4. **Monitoring**: Add logging and monitoring capabilities to the data class

## Related Files

- `/Modules/Notify/app/Datas/SMS/AgiletelecomData.php`: Similar implementation for Agiletelecom
- `/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`: Refactored action class
- `/Modules/Notify/config/sms.php`: SMS configuration file
- `/Modules/Notify/project_docs/sms_implementation.md`: General SMS implementation documentation
- `/Modules/Notify/docs/sms_implementation.md`: General SMS implementation documentation

## Conclusion

The implementation of `SmsFactorData` and the refactoring of `SendSmsFactorSMSAction` successfully follows the established pattern and provides a more maintainable, type-safe, and consistent approach to SMS provider configuration management. This change aligns with the project's architecture principles and makes the codebase more robust and easier to extend.

---

## sms-global-vs-specific-params-1

*Consolidated from: `sms-global-vs-specific-params.md`*

title: "Parametri a Livello di Root vs Specifici per Provider nella Configurazione SMS"
type: concept
tags: [sms, global, specific, params]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-global-vs-specific-params-1 parametri a livello di root vs specifici per provider nella configurazione sms"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Parametri a Livello di Root vs Specifici per Provider nella Configurazione SMS

## Introduzione

Questo documento chiarisce la distinzione fondamentale tra parametri a livello di root e specifici per provider nella configurazione SMS del modulo Notify. Una corretta comprensione di questa distinzione è essenziale per evitare duplicazioni e inconsistenze nella configurazione.

## Struttura della Configurazione

La configurazione SMS segue una struttura gerarchica con due livelli principali:

1. **Livello Root**: Parametri comuni che si applicano a tutti i provider SMS
2. **Livello Provider**: Parametri che sono specifici per un determinato provider

```php
return [
    // Parametri a livello di root
    'default' => env('SMS_DRIVER', 'default_provider'),
    'from' => env('SMS_FROM'),
    'debug' => env('SMS_DEBUG', false),
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'circuit_breaker' => [...],
    
    // Parametri specifici per provider (nella sezione 'drivers')
    'drivers' => [
        'provider1' => [
            // Solo parametri specifici per questo provider
        ],
        'provider2' => [
            // Solo parametri specifici per questo provider
        ],
    ],
];
```

## Parametri a Livello di Root

I parametri a livello di root sono definiti direttamente nel file di configurazione e si applicano a tutti i provider SMS. Questi parametri **NON devono essere duplicati** nella configurazione specifica di ciascun provider.

### Esempi di Parametri a Livello di Root

| Parametro | Descrizione | Variabile d'Ambiente |
|-----------|-------------|----------------------|
| `from` | Mittente predefinito per tutti i messaggi | `SMS_FROM` |
| `debug` | Modalità debug per tutti i provider | `SMS_DEBUG` |
| `queue` | Coda per l'invio asincrono | `SMS_QUEUE` |
| `retry.attempts` | Numero di tentativi di invio | `SMS_RETRY_ATTEMPTS` |
| `retry.delay` | Ritardo tra i tentativi (secondi) | `SMS_RETRY_DELAY` |
| `rate_limit.enabled` | Abilitazione del rate limiting | `SMS_RATE_LIMIT_ENABLED` |
| `rate_limit.max_attempts` | Numero massimo di tentativi | `SMS_RATE_LIMIT_MAX_ATTEMPTS` |
| `rate_limit.decay_minutes` | Finestra temporale per il rate limiting | `SMS_RATE_LIMIT_DECAY_MINUTES` |
| `circuit_breaker.enabled` | Abilitazione del circuit breaker | `SMS_CIRCUIT_BREAKER_ENABLED` |
| `circuit_breaker.threshold` | Soglia di errori per il circuit breaker | `SMS_CIRCUIT_BREAKER_THRESHOLD` |
| `circuit_breaker.timeout` | Timeout del circuit breaker (secondi) | `SMS_CIRCUIT_BREAKER_TIMEOUT` |

## Parametri Specifici per Provider

I parametri specifici per provider sono definiti all'interno della sezione `drivers` e si applicano solo al provider specifico. Questi parametri **NON devono duplicare** i parametri globali.

### Esempi di Parametri Specifici per Provider

#### Twilio

```php
'twilio' => [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
],
```

#### Netfun

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    'callback_url' => env('NETFUN_CALLBACK_URL'),
    'circuit_breaker' => [  // Solo se necessario sovrascrivere il comportamento globale
        'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
        'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
    ],
],
```

## Errori Comuni da Evitare

### 1. Duplicazione di Parametri a Livello di Root

❌ **Errato**:
```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'from' => env('NETFUN_FROM'),  // ERRORE: duplica il parametro 'from' a livello di root
    'debug' => env('NETFUN_DEBUG', false),  // ERRORE: duplica il parametro 'debug' a livello di root
],
```

✅ **Corretto**:
```php
// A livello di root
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),

// Nella sezione 'drivers'
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    // Nessuna duplicazione di parametri a livello di root
],
```

### 2. Nomenclatura Inconsistente

❌ **Errato**:
```php
// Nomi diversi per lo stesso concetto
'twilio' => [
    'from' => env('TWILIO_FROM'),
],
'netfun' => [
    'sender' => env('NETFUN_SENDER'),  // ERRORE: usa 'sender' invece di 'from'
],
```

✅ **Corretto**:
```php
// A livello globale
'from' => env('SMS_FROM'),

// Nessuna duplicazione nella sezione 'drivers'
```

### 3. Parametri Specifici a Livello Globale

❌ **Errato**:
```php
// A livello globale
'netfun_token' => env('NETFUN_TOKEN'),  // ERRORE: parametro specifico a livello globale
```

✅ **Corretto**:
```php
// Nella sezione 'drivers'
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

## Implementazione della Precedenza

Quando sia i parametri a livello di root che quelli specifici per provider sono presenti, i parametri specifici hanno precedenza. Questo comportamento deve essere implementato nel codice che utilizza queste configurazioni:

```php
// In una classe che gestisce l'invio SMS
$config = config('sms');
$driver = $config['default'];

// Implementazione della precedenza
$debug = $config['drivers'][$driver]['debug'] ?? $config['debug'];
```

## Checklist di Verifica

Prima di modificare la configurazione SMS, verificare che:

- [ ] I parametri comuni siano definiti a livello di root
- [ ] I parametri specifici per provider siano definiti solo nella sezione `drivers`
- [ ] Non ci siano duplicazioni tra parametri a livello di root e parametri specifici per provider
- [ ] La nomenclatura sia coerente tra i diversi provider
- [ ] I nomi dei parametri seguano le convenzioni standard

## Riferimenti

- [Struttura Standardizzata della Configurazione SMS](./standardized-sms-config-structure.md)
- [Configurazione Netfun](./netfun-config-requirements.md)
- [Configurazione Netfun](../../netfun-config-requirements.md)
- [Struttura Standardizzata della Configurazione SMS](./standardized-sms-config-structure.md)
- [Configurazione Netfun](./netfun-config-requirements.md)
- [Laravel Configuration Best Practices](https://laravel.com/docs/configuration)

---

*Ultimo aggiornamento: 2025-05-12*
---

## sms-global-vs-specific-params

*Consolidated from: `sms-global-vs-specific-params.md`*


## Introduzione

Questo documento chiarisce la distinzione fondamentale tra parametri a livello di root e specifici per provider nella configurazione SMS del modulo Notify. Una corretta comprensione di questa distinzione è essenziale per evitare duplicazioni e inconsistenze nella configurazione.

## Struttura della Configurazione

La configurazione SMS segue una struttura gerarchica con due livelli principali:

1. **Livello Root**: Parametri comuni che si applicano a tutti i provider SMS
2. **Livello Provider**: Parametri che sono specifici per un determinato provider

```php
return [
    // Parametri a livello di root
    'default' => env('SMS_DRIVER', 'default_provider'),
    'from' => env('SMS_FROM'),
    'debug' => env('SMS_DEBUG', false),
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'circuit_breaker' => [...],
    
    // Parametri specifici per provider (nella sezione 'drivers')
    'drivers' => [
        'provider1' => [
            // Solo parametri specifici per questo provider
        ],
        'provider2' => [
            // Solo parametri specifici per questo provider
        ],
    ],
];
```

## Parametri a Livello di Root

I parametri a livello di root sono definiti direttamente nel file di configurazione e si applicano a tutti i provider SMS. Questi parametri **NON devono essere duplicati** nella configurazione specifica di ciascun provider.

### Esempi di Parametri a Livello di Root

| Parametro | Descrizione | Variabile d'Ambiente |
|-----------|-------------|----------------------|
| `from` | Mittente predefinito per tutti i messaggi | `SMS_FROM` |
| `debug` | Modalità debug per tutti i provider | `SMS_DEBUG` |
| `queue` | Coda per l'invio asincrono | `SMS_QUEUE` |
| `retry.attempts` | Numero di tentativi di invio | `SMS_RETRY_ATTEMPTS` |
| `retry.delay` | Ritardo tra i tentativi (secondi) | `SMS_RETRY_DELAY` |
| `rate_limit.enabled` | Abilitazione del rate limiting | `SMS_RATE_LIMIT_ENABLED` |
| `rate_limit.max_attempts` | Numero massimo di tentativi | `SMS_RATE_LIMIT_MAX_ATTEMPTS` |
| `rate_limit.decay_minutes` | Finestra temporale per il rate limiting | `SMS_RATE_LIMIT_DECAY_MINUTES` |
| `circuit_breaker.enabled` | Abilitazione del circuit breaker | `SMS_CIRCUIT_BREAKER_ENABLED` |
| `circuit_breaker.threshold` | Soglia di errori per il circuit breaker | `SMS_CIRCUIT_BREAKER_THRESHOLD` |
| `circuit_breaker.timeout` | Timeout del circuit breaker (secondi) | `SMS_CIRCUIT_BREAKER_TIMEOUT` |

## Parametri Specifici per Provider

I parametri specifici per provider sono definiti all'interno della sezione `drivers` e si applicano solo al provider specifico. Questi parametri **NON devono duplicare** i parametri globali.

### Esempi di Parametri Specifici per Provider

#### Twilio

```php
'twilio' => [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
],
```

#### Netfun

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    'callback_url' => env('NETFUN_CALLBACK_URL'),
    'circuit_breaker' => [  // Solo se necessario sovrascrivere il comportamento globale
        'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
        'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
    ],
],
```

## Errori Comuni da Evitare

### 1. Duplicazione di Parametri a Livello di Root

❌ **Errato**:
```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'from' => env('NETFUN_FROM'),  // ERRORE: duplica il parametro 'from' a livello di root
    'debug' => env('NETFUN_DEBUG', false),  // ERRORE: duplica il parametro 'debug' a livello di root
],
```

✅ **Corretto**:
```php
// A livello di root
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),

// Nella sezione 'drivers'
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    // Nessuna duplicazione di parametri a livello di root
],
```

### 2. Nomenclatura Inconsistente

❌ **Errato**:
```php
// Nomi diversi per lo stesso concetto
'twilio' => [
    'from' => env('TWILIO_FROM'),
],
'netfun' => [
    'sender' => env('NETFUN_SENDER'),  // ERRORE: usa 'sender' invece di 'from'
],
```

✅ **Corretto**:
```php
// A livello globale
'from' => env('SMS_FROM'),

// Nessuna duplicazione nella sezione 'drivers'
```

### 3. Parametri Specifici a Livello Globale

❌ **Errato**:
```php
// A livello globale
'netfun_token' => env('NETFUN_TOKEN'),  // ERRORE: parametro specifico a livello globale
```

✅ **Corretto**:
```php
// Nella sezione 'drivers'
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

## Implementazione della Precedenza

Quando sia i parametri a livello di root che quelli specifici per provider sono presenti, i parametri specifici hanno precedenza. Questo comportamento deve essere implementato nel codice che utilizza queste configurazioni:

```php
// In una classe che gestisce l'invio SMS
$config = config('sms');
$driver = $config['default'];

// Implementazione della precedenza
$debug = $config['drivers'][$driver]['debug'] ?? $config['debug'];
```

## Checklist di Verifica

Prima di modificare la configurazione SMS, verificare che:

- [ ] I parametri comuni siano definiti a livello di root
- [ ] I parametri specifici per provider siano definiti solo nella sezione `drivers`
- [ ] Non ci siano duplicazioni tra parametri a livello di root e parametri specifici per provider
- [ ] La nomenclatura sia coerente tra i diversi provider
- [ ] I nomi dei parametri seguano le convenzioni standard

## Riferimenti

- [Struttura Standardizzata della Configurazione SMS](./standardized_sms_config_structure.md)
- [Configurazione Netfun](./netfun_config_requirements.md)
- [Struttura Standardizzata della Configurazione SMS](../../standardized_sms_config_structure.md)
- [Configurazione Netfun](../../netfun_config_requirements.md)
- [Laravel Configuration Best Practices](https://laravel.com/docs/configuration)

---

*Ultimo aggiornamento: [DATE]*

---

## sms-implementation-1

*Consolidated from: `sms-implementation.md`*

title: "Implementazione SMS in Laravel"
type: concept
tags: [sms, implementation]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-implementation-1 implementazione sms in laravel"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Implementazione SMS in Laravel

## Panoramica
Questo documento descrive l'implementazione del sistema di invio SMS nel modulo Notify, utilizzando il pacchetto `gr8shivam/laravel-sms-api` come driver principale **e** il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione delle azioni asincrone e sincrone.

## Architettura Data-Driven

Il sistema SMS utilizza classi Data di Spatie per gestire la configurazione dei provider in modo centralizzato e tipizzato:

- **SmsFactorData**: Gestisce configurazione e autenticazione per SMSFactor
- **AgiletelecomData**: Gestisce configurazione e autenticazione per Agiletelecom

Queste classi implementano il pattern singleton e forniscono metodi helper per l'autenticazione e la configurazione.

## Architettura

### 1. Driver Supportati
- **SMSFactor** (Driver principale)
- **Twilio** (Alternativa)
- **Nexmo/Vonage** (Alternativa)
- **Plivo** (Alternativa)
- **Gammu** (Per server GSM)

### 2. Configurazione
```php
// config/sms.php
return [
    'default' => env('SMS_DRIVER', 'smsfactor'),
    
    'drivers' => [
        'smsfactor' => [
            'token' => env('SMSFACTOR_TOKEN'),
            'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
        ],
        'agiletelecom' => [
            'username' => env('AGILETELECOM_USERNAME'),
            'password' => env('AGILETELECOM_PASSWORD'),
            'sender' => env('AGILETELECOM_SENDER'),
            'endpoint' => env('AGILETELECOM_ENDPOINT'),
            'auth_type' => env('AGILETELECOM_AUTH_TYPE', 'basic'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
        // Altri driver...
    ]
];
```

### 3. Classi Data per Provider

#### SmsFactorData
```php
use Modules\Notify\Datas\SMS\SmsFactorData;

// Utilizzo singleton
$smsFactorData = SmsFactorData::make();

// Metodi helper
$headers = $smsFactorData->getAuthHeaders();
$baseUrl = $smsFactorData->getBaseUrl();
$timeout = $smsFactorData->getTimeout();
```

#### AgiletelecomData
```php
use Modules\Notify\Datas\SMS\AgiletelecomData;

// Utilizzo singleton
$agiletelecomData = AgiletelecomData::make();

// Metodi helper
$headers = $agiletelecomData->getAuthHeaders();
```

### 3. Struttura del Database
```sql
CREATE TABLE sms_templates (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    content text NOT NULL,
    variables json,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE sms_logs (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    template_id bigint unsigned NOT NULL,
    recipient varchar(255) NOT NULL,
    content text NOT NULL,
    status varchar(50) NOT NULL,
    error_message text,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (template_id) REFERENCES sms_templates(id)
);
```

## Implementazione

### 1. Service Provider
```php
namespace Modules\Notify\Providers;

use Illuminate\Support\ServiceProvider;
use Gr8Shivam\SmsApi\SmsApiServiceProvider;

class NotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(SmsApiServiceProvider::class);
    }
}
```

### 2. Notification Channel
```php
namespace Modules\Notify\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Gr8Shivam\SmsApi\SmsApi;

class SmsChannel
{
    protected $sms;

    public function __construct(SmsApi $sms)
    {
        $this->sms = $sms;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        
        return $this->sms->send(
            $notifiable->phone_number,
            $message
        );
    }
}
```

### 3. Template System

> **Nota:** La logica di rendering dei template può essere gestita tramite una action queueable, non tramite un service custom.

Esempio di Action per invio SMS:

```php
namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Gr8Shivam\SmsApi\SmsApi;

class SendSmsAction
{
    use QueueableAction;

    public function execute(string $to, string $template, array $variables = [])
    {
        // Recupera il template dal database
        $smsTemplate = SmsTemplate::where('name', $template)->firstOrFail();
        $content = $smsTemplate->content;
        foreach ($variables as $key => $value) {
            $content = str_replace("{{$key}}", $value, $content);
        }
        // Invia SMS
        app(SmsApi::class)->send($to, $content);
        // Log, gestione errori, ecc.
    }
}
```

#### Esecuzione Sincrona
```php
app(SendSmsAction::class)->execute('+393331234567', 'welcome', ['name' => 'Mario']);
```

#### Esecuzione Asincrona (in coda)
```php
app(SendSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'welcome', ['name' => 'Mario']);
```

### 4. Queueable Actions

Per la gestione di azioni asincrone e sincrone, utilizziamo il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action):

- Permette di scrivere azioni riutilizzabili, testabili e iniettate via costruttore
- Supporta esecuzione immediata o in coda (`onQueue()`)
- Supporta chaining, middleware, backoff, tagging per Horizon

#### Esempio di Action con Middleware e Tag
```php
class SendSmsAction
{
    use QueueableAction;

    public function middleware()
    {
        return [new RateLimited()];
    }

    public function tags()
    {
        return ['sms', 'notify'];
    }

    public function execute(string $to, string $template, array $variables = [])
    {
        // ... come sopra
    }
}
```

#### Testing
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendSmsAction::class)->onQueue()->execute('+393331234567', 'welcome', ['name' => 'Mario']);
QueueableActionFake::assertPushed(SendSmsAction::class);
```

#### Chaining
```php
use Spatie\QueueableAction\ActionJob;

app(SendSmsAction::class)
    ->onQueue()
    ->execute($to, $template, $vars)
    ->chain([
        new ActionJob(AnotherAction::class, [$to, $template, $vars]),
    ]);
```

#### Riferimenti
- [spatie/laravel-queueable-action - GitHub](https://github.com/spatie/laravel-queueable-action)
- [Blog post: Queueable Actions](https://stitcher.io/blog/laravel-queueable-actions)

## Best Practices

- Utilizzare sempre le Actions per la business logic riutilizzabile
- Usare la coda per invii massivi o lenti
- Testare le Actions con Queue::fake e QueueableActionFake
- Gestire errori e retry tramite le features del pacchetto
- Documentare ogni Action

## Testing

### 1. Unit Tests
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\SmsService;

class SmsServiceTest extends TestCase
{
    public function test_sms_sending()
    {
        $service = new SmsService();
        $result = $service->send('+1234567890', 'Test message');
        $this->assertTrue($result);
    }
}
```

### 2. Integration Tests
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\SmsTemplate;

class SmsIntegrationTest extends TestCase
{
    public function test_template_rendering()
    {
        $template = SmsTemplate::create([
            'name' => 'Test',
            'content' => 'Hello {{name}}!'
        ]);
        
        $result = $template->render(['name' => 'John']);
        $this->assertEquals('Hello John!', $result);
    }
}
```

## Monitoraggio e Logging

### 1. Log Structure
```json
{
    "timestamp": "2024-03-20 10:00:00",
    "template_id": 1,
    "recipient": "+1234567890",
    "content": "Test message",
    "status": "sent",
    "provider": "smsfactor",
    "response": {
        "message_id": "123456",
        "status": "success"
    }
}
```

### 2. Metrics
- Tasso di consegna
- Tempo di consegna
- Errori per provider
- Costi per provider

## Deployment

### 1. Requisiti
- PHP 8.1+
- Laravel 10+
- Estensione cURL
- Configurazione SSL

### 2. Variabili d'Ambiente
```env
SMS_DRIVER=smsfactor
SMSFACTOR_API_KEY=your_api_key
SMSFACTOR_SENDER=YourApp
```

## Manutenzione

### 1. Backup
- Backup giornaliero dei template
- Backup dei log
- Backup delle configurazioni

### 2. Aggiornamenti
- Monitoraggio delle versioni
- Test di compatibilità
- Piano di rollback

## Troubleshooting

### 1. Errori Comuni
- Invalid phone number
- API rate limit
- Network issues
- Template rendering errors

### 2. Soluzioni
- Validazione numeri
- Implementazione retry
- Timeout handling
- Error logging

## Riferimenti
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Documentazione SMSFactor](https://www.smsfactor.com)
- [Documentazione Twilio](https://www.twilio.com/docs)
- [Documentazione Nexmo](https://developer.nexmo.com)
- [Documentazione Plivo](https://www.plivo.com/docs) 

---

## sms-implementation

*Consolidated from: `sms-implementation.md`*


## Panoramica
Questo documento descrive l'implementazione del sistema di invio SMS nel modulo Notify, utilizzando il pacchetto `gr8shivam/laravel-sms-api` come driver principale **e** il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione delle azioni asincrone e sincrone.

## Architettura Data-Driven

Il sistema SMS utilizza classi Data di Spatie per gestire la configurazione dei provider in modo centralizzato e tipizzato:

- **SmsFactorData**: Gestisce configurazione e autenticazione per SMSFactor
- **AgiletelecomData**: Gestisce configurazione e autenticazione per Agiletelecom

Queste classi implementano il pattern singleton e forniscono metodi helper per l'autenticazione e la configurazione.

## Architettura

### 1. Driver Supportati
- **SMSFactor** (Driver principale)
- **Twilio** (Alternativa)
- **Nexmo/Vonage** (Alternativa)
- **Plivo** (Alternativa)
- **Gammu** (Per server GSM)

### 2. Configurazione
```php
// config/sms.php
return [
    'default' => env('SMS_DRIVER', 'smsfactor'),
    
    'drivers' => [
        'smsfactor' => [
            'token' => env('SMSFACTOR_TOKEN'),
            'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
        ],
        'agiletelecom' => [
            'username' => env('AGILETELECOM_USERNAME'),
            'password' => env('AGILETELECOM_PASSWORD'),
            'sender' => env('AGILETELECOM_SENDER'),
            'endpoint' => env('AGILETELECOM_ENDPOINT'),
            'auth_type' => env('AGILETELECOM_AUTH_TYPE', 'basic'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
        // Altri driver...
    ]
];
```

### 3. Classi Data per Provider

#### SmsFactorData
```php
use Modules\Notify\Datas\SMS\SmsFactorData;

// Utilizzo singleton
$smsFactorData = SmsFactorData::make();

// Metodi helper
$headers = $smsFactorData->getAuthHeaders();
$baseUrl = $smsFactorData->getBaseUrl();
$timeout = $smsFactorData->getTimeout();
```

#### AgiletelecomData
```php
use Modules\Notify\Datas\SMS\AgiletelecomData;

// Utilizzo singleton
$agiletelecomData = AgiletelecomData::make();

// Metodi helper
$headers = $agiletelecomData->getAuthHeaders();
```

### 3. Struttura del Database
```sql
CREATE TABLE sms_templates (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    content text NOT NULL,
    variables json,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE sms_logs (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    template_id bigint unsigned NOT NULL,
    recipient varchar(255) NOT NULL,
    content text NOT NULL,
    status varchar(50) NOT NULL,
    error_message text,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (template_id) REFERENCES sms_templates(id)
);
```

## Implementazione

### 1. Service Provider
```php
namespace Modules\Notify\Providers;

use Illuminate\Support\ServiceProvider;
use Gr8Shivam\SmsApi\SmsApiServiceProvider;

class NotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(SmsApiServiceProvider::class);
    }
}
```

### 2. Notification Channel
```php
namespace Modules\Notify\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Gr8Shivam\SmsApi\SmsApi;

class SmsChannel
{
    protected $sms;

    public function __construct(SmsApi $sms)
    {
        $this->sms = $sms;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        
        return $this->sms->send(
            $notifiable->phone_number,
            $message
        );
    }
}
```

### 3. Template System

> **Nota:** La logica di rendering dei template può essere gestita tramite una action queueable, non tramite un service custom.

Esempio di Action per invio SMS:

```php
namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Gr8Shivam\SmsApi\SmsApi;

class SendSmsAction
{
    use QueueableAction;

    public function execute(string $to, string $template, array $variables = [])
    {
        // Recupera il template dal database
        $smsTemplate = SmsTemplate::where('name', $template)->firstOrFail();
        $content = $smsTemplate->content;
        foreach ($variables as $key => $value) {
            $content = str_replace("{{$key}}", $value, $content);
        }
        // Invia SMS
        app(SmsApi::class)->send($to, $content);
        // Log, gestione errori, ecc.
    }
}
```

#### Esecuzione Sincrona
```php
app(SendSmsAction::class)->execute('+393331234567', 'welcome', ['name' => 'Mario']);
```

#### Esecuzione Asincrona (in coda)
```php
app(SendSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'welcome', ['name' => 'Mario']);
```

### 4. Queueable Actions

Per la gestione di azioni asincrone e sincrone, utilizziamo il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action):

- Permette di scrivere azioni riutilizzabili, testabili e iniettate via costruttore
- Supporta esecuzione immediata o in coda (`onQueue()`)
- Supporta chaining, middleware, backoff, tagging per Horizon

#### Esempio di Action con Middleware e Tag
```php
class SendSmsAction
{
    use QueueableAction;

    public function middleware()
    {
        return [new RateLimited()];
    }

    public function tags()
    {
        return ['sms', 'notify'];
    }

    public function execute(string $to, string $template, array $variables = [])
    {
        // ... come sopra
    }
}
```

#### Testing
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendSmsAction::class)->onQueue()->execute('+393331234567', 'welcome', ['name' => 'Mario']);
QueueableActionFake::assertPushed(SendSmsAction::class);
```

#### Chaining
```php
use Spatie\QueueableAction\ActionJob;

app(SendSmsAction::class)
    ->onQueue()
    ->execute($to, $template, $vars)
    ->chain([
        new ActionJob(AnotherAction::class, [$to, $template, $vars]),
    ]);
```

#### Riferimenti
- [spatie/laravel-queueable-action - GitHub](https://github.com/spatie/laravel-queueable-action)
- [Blog post: Queueable Actions](https://stitcher.io/blog/laravel-queueable-actions)

## Best Practices

- Utilizzare sempre le Actions per la business logic riutilizzabile
- Usare la coda per invii massivi o lenti
- Testare le Actions con Queue::fake e QueueableActionFake
- Gestire errori e retry tramite le features del pacchetto
- Documentare ogni Action

## Testing

### 1. Unit Tests
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\SmsService;

class SmsServiceTest extends TestCase
{
    public function test_sms_sending()
    {
        $service = new SmsService();
        $result = $service->send('+1234567890', 'Test message');
        $this->assertTrue($result);
    }
}
```

### 2. Integration Tests
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\SmsTemplate;

class SmsIntegrationTest extends TestCase
{
    public function test_template_rendering()
    {
        $template = SmsTemplate::create([
            'name' => 'Test',
            'content' => 'Hello {{name}}!'
        ]);
        
        $result = $template->render(['name' => 'John']);
        $this->assertEquals('Hello John!', $result);
    }
}
```

## Monitoraggio e Logging

### 1. Log Structure
```json
{
    "timestamp": "[DATE] 10:00:00",
    "template_id": 1,
    "recipient": "+1234567890",
    "content": "Test message",
    "status": "sent",
    "provider": "smsfactor",
    "response": {
        "message_id": "123456",
        "status": "success"
    }
}
```

### 2. Metrics
- Tasso di consegna
- Tempo di consegna
- Errori per provider
- Costi per provider

## Deployment

### 1. Requisiti
- PHP 8.1+
- Laravel 10+
- Estensione cURL
- Configurazione SSL

### 2. Variabili d'Ambiente
```env
SMS_DRIVER=smsfactor
SMSFACTOR_API_KEY=your_api_key
SMSFACTOR_SENDER=YourApp
```

## Manutenzione

### 1. Backup
- Backup giornaliero dei template
- Backup dei log
- Backup delle configurazioni

### 2. Aggiornamenti
- Monitoraggio delle versioni
- Test di compatibilità
- Piano di rollback

## Troubleshooting

### 1. Errori Comuni
- Invalid phone number
- API rate limit
- Network issues
- Template rendering errors

### 2. Soluzioni
- Validazione numeri
- Implementazione retry
- Timeout handling
- Error logging

## Riferimenti
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Documentazione SMSFactor](https://www.smsfactor.com)
- [Documentazione Twilio](https://www.twilio.com/docs)
- [Documentazione Nexmo](https://developer.nexmo.com)
- [Documentazione Plivo](https://www.plivo.com/docs) 

---

## sms-integration

*Consolidated from: `sms-integration.md`*


---

## sms-netfun-channel-1

*Consolidated from: `sms-netfun-channel.md`*
*Consolidated from: `sms-netfun-channel-integrazione-laravel.md`*


## Introduzione
Questa guida spiega come integrare il provider Netfun come canale custom per l'invio di SMS in Laravel, seguendo le best practice del framework e sfruttando il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione asincrona.

> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](./NETFUN_CONFIG_REQUIREMENTS.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.
> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](../../netfun_config_requirements.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.

---

## 1. Creazione del Channel Netfun

### 1.1. Struttura del Channel
Crea il file `app/Notifications/Channels/NetfunSmsChannel.php`:

```php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class NetfunSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toNetfunSms($notifiable);
        $to = $notifiable->routeNotificationFor('netfun_sms', $notification);

        // Validazione numero
        if (!self::isValidNumber($to)) {
            \Log::warning('Numero non valido per Netfun SMS', ['to' => $to]);
            return false;
        }

        // Parametri Netfun
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';

        $payload = [
            'apiKey' => $apiKey,
            'messages' => [
                [
                    'recipient' => $to,
                    'text' => $message,
                    'sender' => $sender,
                ]
            ]
        ];

        $response = Http::post($endpoint, $payload);

        // Logging e gestione errori avanzata
        if (!$response->successful() || data_get($response->json(), 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            // Possibile fallback: invio con altro provider
            // dispatch(new FallbackSmsJob(...));
            return false;
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $response->json(),
        ]);
        return $response->json();
    }

    public static function isValidNumber($number): bool
    {
        // Esempio: formato internazionale obbligatorio
        return preg_match('/^\+[1-9]\d{7,15}$/', $number);
    }
}
```

#### Invio Batch Multiplo
Per inviare più SMS in un'unica chiamata:

```php
$recipients = ['+393331234567', '+393331234568'];
$messages = array_map(fn($to) => [
    'recipient' => $to,
    'text' => 'Messaggio di test',
    'sender' => $sender,
], $recipients);

$payload = [
    'apiKey' => $apiKey,
    'messages' => $messages,
];
$response = Http::post($endpoint, $payload);
```

### 1.2. Configurazione

**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](./NETFUN_AUTHENTICATION_METHODS.md).
**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](../../netfun_authentication_methods.md).

Configurazione con API key in `config/sms.php` (documentata ma non implementata nel modulo):

```php
'netfun' => [
    'api_key' => env('NETFUN_API_KEY'),
    'sender' => env('NETFUN_SENDER'),
    'endpoint' => env('NETFUN_ENDPOINT', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
],
```

Configurazione attuale con username/password nel modulo Notify:

```php
'netfun' => [
    'username' => env('NETFUN_USERNAME'),
    'password' => env('NETFUN_PASSWORD'),
    'sender' => env('NETFUN_SENDER', '<nome progetto>'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    // Parametri avanzati...
],
```

Variabili d'ambiente nel `.env` (per la configurazione attuale):
```
NETFUN_USERNAME=your_username
NETFUN_PASSWORD=your_password
NETFUN_SENDER=YourSender
```

---

## 2. Creazione della Queueable Action (Spatie)

Crea la action in `app/Actions/SendNetfunSmsAction.php`:

```php
namespace App\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Http;

class SendNetfunSmsAction
{
    use QueueableAction;

    public function execute($to, $message)
    {
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = config('sms.drivers.netfun.endpoint', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

        // Supporto batch: $to può essere stringa o array
        $recipients = is_array($to) ? $to : [$to];
        $messages = array_map(fn($num) => [
            'recipient' => $num,
            'text' => $message,
            'sender' => $sender,
        ], $recipients);

        $payload = [
            'apiKey' => $apiKey,
            'messages' => $messages,
        ];

        $response = Http::post($endpoint, $payload);
        $json = $response->json();

        if (!$response->successful() || data_get($json, 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            throw new \Exception('Invio SMS Netfun fallito: ' . data_get($json, 'error', 'Errore generico'));
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $json,
        ]);
        return $json;
    }
}
```

#### Esempio invio batch:
```php
app(SendNetfunSmsAction::class)->execute(['+393331234567', '+393331234568'], 'Messaggio multiplo');
```

### Esecuzione Sincrona
```php
app(SendNetfunSmsAction::class)->execute('+393331234567', 'Messaggio di test');
```

### Esecuzione Asincrona (in coda)
```php
app(SendNetfunSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'Messaggio di test');
```

---

## 3. Utilizzo nelle Notification Laravel

### 3.1. Definizione della Notification
Crea la notification in `app/Notifications/OrderShipped.php`:

```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Actions\SendNetfunSmsAction;

class OrderShipped extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['netfun_sms'];
    }

    public function toNetfunSms($notifiable)
    {
        $message = "Ciao {$notifiable->name}, il tuo ordine è stato spedito!";
        // Esecuzione asincrona
        app(SendNetfunSmsAction::class)
            ->onQueue('sms')
            ->execute($notifiable->phone_number, $message);
        return $message;
    }
}
```

### 3.2. Invio della Notification
```php
$user->notify(new OrderShipped());
```

---

## 4. Dettagli Endpoint e Risposta

### 4.1. Payload di Richiesta (singolo e batch)
```json
{
  "apiKey": "<API_KEY>",
  "messages": [
    {
      "recipient": "+393331234567",
      "text": "Messaggio di test",
      "sender": "YourSender"
    },
    {
      "recipient": "+393331234568",
      "text": "Messaggio di test",
      "sender": "YourSender"
    }
  ]
}
```

### 4.2. Risposta API
Esempio di risposta positiva:
```json
{
  "status": "OK",
  "batchId": "1234567890",
  "messages": [
    {
      "recipient": "+393331234567",
      "status": "QUEUED",
      "messageId": "abcdef123456"
    },
    {
      "recipient": "+393331234568",
      "status": "QUEUED",
      "messageId": "abcdef123457"
    }
  ]
}
```

In caso di errore:
```json
{
  "status": "ERROR",
  "error": "Invalid API key"
}
```

#### Parsing della risposta
```php
$json = $response->json();
if (data_get($json, 'status') === 'OK') {
    foreach ($json['messages'] as $msg) {
        // $msg['recipient'], $msg['status'], $msg['messageId']
    }
}
```

---

## 5. Testing

### 5.1. Testare la Action
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendNetfunSmsAction::class)->onQueue()->execute('+393331234567', 'Test SMS');
QueueableActionFake::assertPushed(SendNetfunSmsAction::class);
```

### 5.2. Testare la Notification
```php
Notification::fake();
$user->notify(new OrderShipped());
Notification::assertSentTo($user, OrderShipped::class);
```

---

## 6. Best Practices Avanzate
- Validare sempre i numeri (formato internazionale, blacklist, opt-out)
- Loggare sia successi che errori, includendo payload e risposta
- Usare la coda per evitare blocchi e gestire retry automatici
- Implementare fallback su provider secondari in caso di errore
- Gestire rate limiting e throttling
- Documentare payload, risposta e casi d'uso
- Monitorare batchId e messageId per tracciamento
- Gestire la privacy (GDPR): loggare solo dati necessari, anonimizzare dove possibile
- Aggiornare la documentazione ad ogni modifica

---

## 7. Troubleshooting
- **Invalid API key**: controlla la chiave e i permessi
- **Numero non valido**: verifica il formato e la presenza in blacklist
- **Status diverso da OK**: logga la risposta, valuta retry o fallback
- **Timeout o errori di rete**: implementa retry/backoff, monitora la connettività
- **Messaggi non consegnati**: controlla lo status di ogni messaggio nella risposta

---

## 8. Compliance e Sicurezza
- Conserva i log in modo sicuro e conforme a GDPR
- Non loggare dati sensibili inutilmente
- Proteggi le API key tramite variabili d'ambiente
- Aggiorna regolarmente le dipendenze
- Implementa audit trail per le operazioni critiche

---

## 9. Riferimenti
- [Netfun SMS API](https://www.netfunitalia.it/)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Notifications](https://laravel.com/docs/notifications)

---

## 10. Utilizzo di DTOs con Spatie Laravel Data

Per standardizzare e validare i dati degli SMS, utilizziamo i Data Object di [`spatie/laravel-data`](https://github.com/spatie/laravel-data) nella cartella `app/Datas`.

### 10.1. Esempio di DTO per SMS

Il file `app/Datas/SmsData.php`:

```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
}
```

### 10.2. Utilizzo in Action/Channel

```php
use Modules\Notify\Datas\SmsData;

// Creazione DTO
$smsData = new SmsData(
    from: config('sms.drivers.netfun.sender'),
    to: '+393331234567',
    body: 'Messaggio di test'
);

// Accesso ai dati
$payload = [
    'apiKey' => config('sms.drivers.netfun.api_key'),
    'messages' => [[
        'recipient' => $smsData->to,
        'text' => $smsData->body,
        'sender' => $smsData->from,
    ]],
];
```

### 10.3. Best Practices
- Usare sempre DTO per validare e tipizzare i dati in ingresso
- Utilizzare metodi statici/factory per conversioni da array/request
- Validare i dati con regole custom (es. formato numero, lunghezza mittente)
- Documentare ogni DTO e aggiornarlo in caso di modifiche API

---

# Canale SMS Netfun

Questo documento descrive come utilizzare il canale SMS Netfun nel modulo Notify.

## Configurazione

### 1. Configurazione del Provider

Aggiungi la seguente configurazione nel file `config/services.php`:

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

### 2. Variabili d'Ambiente

Aggiungi la seguente variabile nel tuo file `.env`:

```env
NETFUN_TOKEN=your_api_token_here
```

## Utilizzo

### Invio SMS Base

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

### Invio SMS in Coda

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$action->onQueue('sms')->execute($smsData);
```

## Gestione degli Errori

L'azione gestisce automaticamente gli errori HTTP e lancia un'eccezione con dettagli appropriati. È consigliabile utilizzare un try-catch per gestire questi errori:

```php
try {
    $result = $action->execute($smsData);
} catch (Exception $e) {
    Log::error('Errore invio SMS: ' . $e->getMessage());
    // Gestisci l'errore appropriatamente
}
```

## Note Importanti

1. L'azione implementa l'interfaccia `SmsActionInterface` per garantire la consistenza con altri provider SMS.
2. I numeri di telefono vengono automaticamente normalizzati per assicurare il formato corretto.
3. L'invio è asincrono per default (`async: true`).
4. Il supporto UTF-8 è abilitato per default per gestire caratteri speciali.

## Best Practices

1. **Validazione**: Assicurati di validare i numeri di telefono prima dell'invio.
2. **Logging**: Implementa un logging appropriato per tracciare gli invii e gli errori.
3. **Rate Limiting**: Considera l'implementazione di rate limiting per evitare sovraccarichi.
4. **Retry**: Implementa una logica di retry per gestire fallimenti temporanei.

## Testing

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

class NetfunSMSTest extends TestCase
{
    public function test_can_send_sms()
    {
        $smsData = new SmsData(
            to: '+393331234567',
            from: 'TestSender',
            body: 'Test message'
        );

        $action = new SendNetfunSMSAction();
        $result = $action->execute($smsData);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('status_code', $result);
        $this->assertArrayHasKey('status_txt', $result);
    }
}
```

---

## sms-netfun-channel-2

*Consolidated from: `sms-netfun-channel.md`*

title: "Integrazione Netfun SMS Channel in Laravel"
type: concept
tags: [sms, netfun, channel]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-netfun-channel-2 integrazione netfun sms channel in laravel"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Integrazione Netfun SMS Channel in Laravel

## Introduzione
Questa guida spiega come integrare il provider Netfun come canale custom per l'invio di SMS in Laravel, seguendo le best practice del framework e sfruttando il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione asincrona.

> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](./netfun-config-requirements.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.
> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](../../netfun-config-requirements.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.
> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](./netfun-config-requirements.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.

---

## 1. Creazione del Channel Netfun

### 1.1. Struttura del Channel
Crea il file `app/Notifications/Channels/NetfunSmsChannel.php`:

```php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class NetfunSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toNetfunSms($notifiable);
        $to = $notifiable->routeNotificationFor('netfun_sms', $notification);

        // Validazione numero
        if (!self::isValidNumber($to)) {
            \Log::warning('Numero non valido per Netfun SMS', ['to' => $to]);
            return false;
        }

        // Parametri Netfun
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';

        $payload = [
            'apiKey' => $apiKey,
            'messages' => [
                [
                    'recipient' => $to,
                    'text' => $message,
                    'sender' => $sender,
                ]
            ]
        ];

        $response = Http::post($endpoint, $payload);

        // Logging e gestione errori avanzata
        if (!$response->successful() || data_get($response->json(), 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            // Possibile fallback: invio con altro provider
            // dispatch(new FallbackSmsJob(...));
            return false;
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $response->json(),
        ]);
        return $response->json();
    }

    public static function isValidNumber($number): bool
    {
        // Esempio: formato internazionale obbligatorio
        return preg_match('/^\+[1-9]\d{7,15}$/', $number);
    }
}
```

#### Invio Batch Multiplo
Per inviare più SMS in un'unica chiamata:

```php
$recipients = ['+393331234567', '+393331234568'];
$messages = array_map(fn($to) => [
    'recipient' => $to,
    'text' => 'Messaggio di test',
    'sender' => $sender,
], $recipients);

$payload = [
    'apiKey' => $apiKey,
    'messages' => $messages,
];
$response = Http::post($endpoint, $payload);
```

### 1.2. Configurazione

**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](./netfun-authentication-methods.md).
**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](../../netfun-authentication-methods.md).
**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](./netfun-authentication-methods.md).

Configurazione con API key in `config/sms.php` (documentata ma non implementata nel modulo):

```php
'netfun' => [
    'api_key' => env('NETFUN_API_KEY'),
    'sender' => env('NETFUN_SENDER'),
    'endpoint' => env('NETFUN_ENDPOINT', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
],
```

Configurazione attuale con username/password nel modulo Notify:

```php
'netfun' => [
    'username' => env('NETFUN_USERNAME'),
    'password' => env('NETFUN_PASSWORD'),
'sender' => env('NETFUN_SENDER', 'App'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    // Parametri avanzati...
],
```

Variabili d'ambiente nel `.env` (per la configurazione attuale):
```
NETFUN_USERNAME=your_username
NETFUN_PASSWORD=your_password
NETFUN_SENDER=YourSender
```

---

## 2. Creazione della Queueable Action (Spatie)

Crea la action in `app/Actions/SendNetfunSmsAction.php`:

```php
namespace App\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Http;

class SendNetfunSmsAction
{
    use QueueableAction;

    public function execute($to, $message)
    {
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = config('sms.drivers.netfun.endpoint', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

        // Supporto batch: $to può essere stringa o array
        $recipients = is_array($to) ? $to : [$to];
        $messages = array_map(fn($num) => [
            'recipient' => $num,
            'text' => $message,
            'sender' => $sender,
        ], $recipients);

        $payload = [
            'apiKey' => $apiKey,
            'messages' => $messages,
        ];

        $response = Http::post($endpoint, $payload);
        $json = $response->json();

        if (!$response->successful() || data_get($json, 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            throw new \Exception('Invio SMS Netfun fallito: ' . data_get($json, 'error', 'Errore generico'));
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $json,
        ]);
        return $json;
    }
}
```

#### Esempio invio batch:
```php
app(SendNetfunSmsAction::class)->execute(['+393331234567', '+393331234568'], 'Messaggio multiplo');
```

### Esecuzione Sincrona
```php
app(SendNetfunSmsAction::class)->execute('+393331234567', 'Messaggio di test');
```

### Esecuzione Asincrona (in coda)
```php
app(SendNetfunSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'Messaggio di test');
```

---

## 3. Utilizzo nelle Notification Laravel

### 3.1. Definizione della Notification
Crea la notification in `app/Notifications/OrderShipped.php`:

```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Actions\SendNetfunSmsAction;

class OrderShipped extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['netfun_sms'];
    }

    public function toNetfunSms($notifiable)
    {
        $message = "Ciao {$notifiable->name}, il tuo ordine è stato spedito!";
        // Esecuzione asincrona
        app(SendNetfunSmsAction::class)
            ->onQueue('sms')
            ->execute($notifiable->phone_number, $message);
        return $message;
    }
}
```

### 3.2. Invio della Notification
```php
$user->notify(new OrderShipped());
```

---

## 4. Dettagli Endpoint e Risposta

### 4.1. Payload di Richiesta (singolo e batch)
```json
{
  "apiKey": "<API_KEY>",
  "messages": [
    {
      "recipient": "+393331234567",
      "text": "Messaggio di test",
      "sender": "YourSender"
    },
    {
      "recipient": "+393331234568",
      "text": "Messaggio di test",
      "sender": "YourSender"
    }
  ]
}
```

### 4.2. Risposta API
Esempio di risposta positiva:
```json
{
  "status": "OK",
  "batchId": "1234567890",
  "messages": [
    {
      "recipient": "+393331234567",
      "status": "QUEUED",
      "messageId": "abcdef123456"
    },
    {
      "recipient": "+393331234568",
      "status": "QUEUED",
      "messageId": "abcdef123457"
    }
  ]
}
```

In caso di errore:
```json
{
  "status": "ERROR",
  "error": "Invalid API key"
}
```

#### Parsing della risposta
```php
$json = $response->json();
if (data_get($json, 'status') === 'OK') {
    foreach ($json['messages'] as $msg) {
        // $msg['recipient'], $msg['status'], $msg['messageId']
    }
}
```

---

## 5. Testing

### 5.1. Testare la Action
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendNetfunSmsAction::class)->onQueue()->execute('+393331234567', 'Test SMS');
QueueableActionFake::assertPushed(SendNetfunSmsAction::class);
```

### 5.2. Testare la Notification
```php
Notification::fake();
$user->notify(new OrderShipped());
Notification::assertSentTo($user, OrderShipped::class);
```

---

## 6. Best Practices Avanzate
- Validare sempre i numeri (formato internazionale, blacklist, opt-out)
- Loggare sia successi che errori, includendo payload e risposta
- Usare la coda per evitare blocchi e gestire retry automatici
- Implementare fallback su provider secondari in caso di errore
- Gestire rate limiting e throttling
- Documentare payload, risposta e casi d'uso
- Monitorare batchId e messageId per tracciamento
- Gestire la privacy (GDPR): loggare solo dati necessari, anonimizzare dove possibile
- Aggiornare la documentazione ad ogni modifica

---

## 7. Troubleshooting
- **Invalid API key**: controlla la chiave e i permessi
- **Numero non valido**: verifica il formato e la presenza in blacklist
- **Status diverso da OK**: logga la risposta, valuta retry o fallback
- **Timeout o errori di rete**: implementa retry/backoff, monitora la connettività
- **Messaggi non consegnati**: controlla lo status di ogni messaggio nella risposta

---

## 8. Compliance e Sicurezza
- Conserva i log in modo sicuro e conforme a GDPR
- Non loggare dati sensibili inutilmente
- Proteggi le API key tramite variabili d'ambiente
- Aggiorna regolarmente le dipendenze
- Implementa audit trail per le operazioni critiche

---

## 9. Riferimenti
- [Netfun SMS API](https://www.netfunitalia.it/)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Notifications](https://laravel.com/docs/notifications) 

---

## 10. Utilizzo di DTOs con Spatie Laravel Data

Per standardizzare e validare i dati degli SMS, utilizziamo i Data Object di [`spatie/laravel-data`](https://github.com/spatie/laravel-data) nella cartella `app/Datas`.

### 10.1. Esempio di DTO per SMS

Il file `app/Datas/SmsData.php`:

```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
}
```

### 10.2. Utilizzo in Action/Channel

```php
use Modules\Notify\Datas\SmsData;

// Creazione DTO
$smsData = new SmsData(
    from: config('sms.drivers.netfun.sender'),
    to: '+393331234567',
    body: 'Messaggio di test'
);

// Accesso ai dati
$payload = [
    'apiKey' => config('sms.drivers.netfun.api_key'),
    'messages' => [[
        'recipient' => $smsData->to,
        'text' => $smsData->body,
        'sender' => $smsData->from,
    ]],
];
```

### 10.3. Best Practices
- Usare sempre DTO per validare e tipizzare i dati in ingresso
- Utilizzare metodi statici/factory per conversioni da array/request
- Validare i dati con regole custom (es. formato numero, lunghezza mittente)
- Documentare ogni DTO e aggiornarlo in caso di modifiche API

--- 

# Canale SMS Netfun

Questo documento descrive come utilizzare il canale SMS Netfun nel modulo Notify.

## Configurazione

### 1. Configurazione del Provider

Aggiungi la seguente configurazione nel file `config/services.php`:

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

### 2. Variabili d'Ambiente

Aggiungi la seguente variabile nel tuo file `.env`:

```env
NETFUN_TOKEN=your_api_token_here
```

## Utilizzo

### Invio SMS Base

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

### Invio SMS in Coda

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$action->onQueue('sms')->execute($smsData);
```

## Gestione degli Errori

L'azione gestisce automaticamente gli errori HTTP e lancia un'eccezione con dettagli appropriati. È consigliabile utilizzare un try-catch per gestire questi errori:

```php
try {
    $result = $action->execute($smsData);
} catch (Exception $e) {
    Log::error('Errore invio SMS: ' . $e->getMessage());
    // Gestisci l'errore appropriatamente
}
```

## Note Importanti

1. L'azione implementa l'interfaccia `SmsActionInterface` per garantire la consistenza con altri provider SMS.
2. I numeri di telefono vengono automaticamente normalizzati per assicurare il formato corretto.
3. L'invio è asincrono per default (`async: true`).
4. Il supporto UTF-8 è abilitato per default per gestire caratteri speciali.

## Best Practices

1. **Validazione**: Assicurati di validare i numeri di telefono prima dell'invio.
2. **Logging**: Implementa un logging appropriato per tracciare gli invii e gli errori.
3. **Rate Limiting**: Considera l'implementazione di rate limiting per evitare sovraccarichi.
4. **Retry**: Implementa una logica di retry per gestire fallimenti temporanei.

## Testing

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

class NetfunSMSTest extends TestCase
{
    public function test_can_send_sms()
    {
        $smsData = new SmsData(
            to: '+393331234567',
            from: 'TestSender',
            body: 'Test message'
        );

        $action = new SendNetfunSMSAction();
        $result = $action->execute($smsData);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('status_code', $result);
        $this->assertArrayHasKey('status_txt', $result);
    }
}
```

--- 
---

## sms-netfun-channel

*Consolidated from: `sms-netfun-channel.md`*


## Introduzione
Questa guida spiega come integrare il provider Netfun come canale custom per l'invio di SMS in Laravel, seguendo le best practice del framework e sfruttando il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione asincrona.

> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](./netfun_config_requirements.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.
> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](../../netfun_config_requirements.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.

---

## 1. Creazione del Channel Netfun

### 1.1. Struttura del Channel
Crea il file `app/Notifications/Channels/NetfunSmsChannel.php`:

```php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class NetfunSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toNetfunSms($notifiable);
        $to = $notifiable->routeNotificationFor('netfun_sms', $notification);

        // Validazione numero
        if (!self::isValidNumber($to)) {
            \Log::warning('Numero non valido per Netfun SMS', ['to' => $to]);
            return false;
        }

        // Parametri Netfun
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';

        $payload = [
            'apiKey' => $apiKey,
            'messages' => [
                [
                    'recipient' => $to,
                    'text' => $message,
                    'sender' => $sender,
                ]
            ]
        ];

        $response = Http::post($endpoint, $payload);

        // Logging e gestione errori avanzata
        if (!$response->successful() || data_get($response->json(), 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            // Possibile fallback: invio con altro provider
            // dispatch(new FallbackSmsJob(...));
            return false;
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $response->json(),
        ]);
        return $response->json();
    }

    public static function isValidNumber($number): bool
    {
        // Esempio: formato internazionale obbligatorio
        return preg_match('/^\+[1-9]\d{7,15}$/', $number);
    }
}
```

#### Invio Batch Multiplo
Per inviare più SMS in un'unica chiamata:

```php
$recipients = ['+393331234567', '+393331234568'];
$messages = array_map(fn($to) => [
    'recipient' => $to,
    'text' => 'Messaggio di test',
    'sender' => $sender,
], $recipients);

$payload = [
    'apiKey' => $apiKey,
    'messages' => $messages,
];
$response = Http::post($endpoint, $payload);
```

### 1.2. Configurazione

**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](./netfun_authentication_methods.md).
**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](../../netfun_authentication_methods.md).

Configurazione con API key in `config/sms.php` (documentata ma non implementata nel modulo):

```php
'netfun' => [
    'api_key' => env('NETFUN_API_KEY'),
    'sender' => env('NETFUN_SENDER'),
    'endpoint' => env('NETFUN_ENDPOINT', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
],
```

Configurazione attuale con username/password nel modulo Notify:

```php
'netfun' => [
    'username' => env('NETFUN_USERNAME'),
    'password' => env('NETFUN_PASSWORD'),
    'sender' => env('NETFUN_SENDER', ''),
    'sender' => env('NETFUN_SENDER', '<nome progetto>'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    // Parametri avanzati...
],
```

Variabili d'ambiente nel `.env` (per la configurazione attuale):
```
NETFUN_USERNAME=your_username
NETFUN_PASSWORD=your_password
NETFUN_SENDER=YourSender
```

---

## 2. Creazione della Queueable Action (Spatie)

Crea la action in `app/Actions/SendNetfunSmsAction.php`:

```php
namespace App\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Http;

class SendNetfunSmsAction
{
    use QueueableAction;

    public function execute($to, $message)
    {
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = config('sms.drivers.netfun.endpoint', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

        // Supporto batch: $to può essere stringa o array
        $recipients = is_array($to) ? $to : [$to];
        $messages = array_map(fn($num) => [
            'recipient' => $num,
            'text' => $message,
            'sender' => $sender,
        ], $recipients);

        $payload = [
            'apiKey' => $apiKey,
            'messages' => $messages,
        ];

        $response = Http::post($endpoint, $payload);
        $json = $response->json();

        if (!$response->successful() || data_get($json, 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            throw new \Exception('Invio SMS Netfun fallito: ' . data_get($json, 'error', 'Errore generico'));
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $json,
        ]);
        return $json;
    }
}
```

#### Esempio invio batch:
```php
app(SendNetfunSmsAction::class)->execute(['+393331234567', '+393331234568'], 'Messaggio multiplo');
```

### Esecuzione Sincrona
```php
app(SendNetfunSmsAction::class)->execute('+393331234567', 'Messaggio di test');
```

### Esecuzione Asincrona (in coda)
```php
app(SendNetfunSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'Messaggio di test');
```

---

## 3. Utilizzo nelle Notification Laravel

### 3.1. Definizione della Notification
Crea la notification in `app/Notifications/OrderShipped.php`:

```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Actions\SendNetfunSmsAction;

class OrderShipped extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['netfun_sms'];
    }

    public function toNetfunSms($notifiable)
    {
        $message = "Ciao {$notifiable->name}, il tuo ordine è stato spedito!";
        // Esecuzione asincrona
        app(SendNetfunSmsAction::class)
            ->onQueue('sms')
            ->execute($notifiable->phone_number, $message);
        return $message;
    }
}
```

### 3.2. Invio della Notification
```php
$user->notify(new OrderShipped());
```

---

## 4. Dettagli Endpoint e Risposta

### 4.1. Payload di Richiesta (singolo e batch)
```json
{
  "apiKey": "<API_KEY>",
  "messages": [
    {
      "recipient": "+393331234567",
      "text": "Messaggio di test",
      "sender": "YourSender"
    },
    {
      "recipient": "+393331234568",
      "text": "Messaggio di test",
      "sender": "YourSender"
    }
  ]
}
```

### 4.2. Risposta API
Esempio di risposta positiva:
```json
{
  "status": "OK",
  "batchId": "1234567890",
  "messages": [
    {
      "recipient": "+393331234567",
      "status": "QUEUED",
      "messageId": "abcdef123456"
    },
    {
      "recipient": "+393331234568",
      "status": "QUEUED",
      "messageId": "abcdef123457"
    }
  ]
}
```

In caso di errore:
```json
{
  "status": "ERROR",
  "error": "Invalid API key"
}
```

#### Parsing della risposta
```php
$json = $response->json();
if (data_get($json, 'status') === 'OK') {
    foreach ($json['messages'] as $msg) {
        // $msg['recipient'], $msg['status'], $msg['messageId']
    }
}
```

---

## 5. Testing

### 5.1. Testare la Action
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendNetfunSmsAction::class)->onQueue()->execute('+393331234567', 'Test SMS');
QueueableActionFake::assertPushed(SendNetfunSmsAction::class);
```

### 5.2. Testare la Notification
```php
Notification::fake();
$user->notify(new OrderShipped());
Notification::assertSentTo($user, OrderShipped::class);
```

---

## 6. Best Practices Avanzate
- Validare sempre i numeri (formato internazionale, blacklist, opt-out)
- Loggare sia successi che errori, includendo payload e risposta
- Usare la coda per evitare blocchi e gestire retry automatici
- Implementare fallback su provider secondari in caso di errore
- Gestire rate limiting e throttling
- Documentare payload, risposta e casi d'uso
- Monitorare batchId e messageId per tracciamento
- Gestire la privacy (GDPR): loggare solo dati necessari, anonimizzare dove possibile
- Aggiornare la documentazione ad ogni modifica

---

## 7. Troubleshooting
- **Invalid API key**: controlla la chiave e i permessi
- **Numero non valido**: verifica il formato e la presenza in blacklist
- **Status diverso da OK**: logga la risposta, valuta retry o fallback
- **Timeout o errori di rete**: implementa retry/backoff, monitora la connettività
- **Messaggi non consegnati**: controlla lo status di ogni messaggio nella risposta

---

## 8. Compliance e Sicurezza
- Conserva i log in modo sicuro e conforme a GDPR
- Non loggare dati sensibili inutilmente
- Proteggi le API key tramite variabili d'ambiente
- Aggiorna regolarmente le dipendenze
- Implementa audit trail per le operazioni critiche

---

## 9. Riferimenti
- [Netfun SMS API](https://www.netfunitalia.it/)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Notifications](https://laravel.com/docs/notifications) 

---

## 10. Utilizzo di DTOs con Spatie Laravel Data

Per standardizzare e validare i dati degli SMS, utilizziamo i Data Object di [`spatie/laravel-data`](https://github.com/spatie/laravel-data) nella cartella `app/Datas`.

### 10.1. Esempio di DTO per SMS

Il file `app/Datas/SmsData.php`:

```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
}
```

### 10.2. Utilizzo in Action/Channel

```php
use Modules\Notify\Datas\SmsData;

// Creazione DTO
$smsData = new SmsData(
    from: config('sms.drivers.netfun.sender'),
    to: '+393331234567',
    body: 'Messaggio di test'
);

// Accesso ai dati
$payload = [
    'apiKey' => config('sms.drivers.netfun.api_key'),
    'messages' => [[
        'recipient' => $smsData->to,
        'text' => $smsData->body,
        'sender' => $smsData->from,
    ]],
];
```

### 10.3. Best Practices
- Usare sempre DTO per validare e tipizzare i dati in ingresso
- Utilizzare metodi statici/factory per conversioni da array/request
- Validare i dati con regole custom (es. formato numero, lunghezza mittente)
- Documentare ogni DTO e aggiornarlo in caso di modifiche API

--- 

# Canale SMS Netfun

Questo documento descrive come utilizzare il canale SMS Netfun nel modulo Notify.

## Configurazione

### 1. Configurazione del Provider

Aggiungi la seguente configurazione nel file `config/services.php`:

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

### 2. Variabili d'Ambiente

Aggiungi la seguente variabile nel tuo file `.env`:

```env
NETFUN_TOKEN=your_api_token_here
```

## Utilizzo

### Invio SMS Base

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

### Invio SMS in Coda

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$action->onQueue('sms')->execute($smsData);
```

## Gestione degli Errori

L'azione gestisce automaticamente gli errori HTTP e lancia un'eccezione con dettagli appropriati. È consigliabile utilizzare un try-catch per gestire questi errori:

```php
try {
    $result = $action->execute($smsData);
} catch (Exception $e) {
    Log::error('Errore invio SMS: ' . $e->getMessage());
    // Gestisci l'errore appropriatamente
}
```

## Note Importanti

1. L'azione implementa l'interfaccia `SmsActionInterface` per garantire la consistenza con altri provider SMS.
2. I numeri di telefono vengono automaticamente normalizzati per assicurare il formato corretto.
3. L'invio è asincrono per default (`async: true`).
4. Il supporto UTF-8 è abilitato per default per gestire caratteri speciali.

## Best Practices

1. **Validazione**: Assicurati di validare i numeri di telefono prima dell'invio.
2. **Logging**: Implementa un logging appropriato per tracciare gli invii e gli errori.
3. **Rate Limiting**: Considera l'implementazione di rate limiting per evitare sovraccarichi.
4. **Retry**: Implementa una logica di retry per gestire fallimenti temporanei.

## Testing

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

class NetfunSMSTest extends TestCase
{
    public function test_can_send_sms()
    {
        $smsData = new SmsData(
            to: '+393331234567',
            from: 'TestSender',
            body: 'Test message'
        );

        $action = new SendNetfunSMSAction();
        $result = $action->execute($smsData);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('status_code', $result);
        $this->assertArrayHasKey('status_txt', $result);
    }
}
```

--- 

---

## sms-provider-configuration-1

*Consolidated from: `sms-provider-configuration.md`*


This file is deprecated.

Use:

- [sms-provider-configuration](./sms-provider-configuration.md)

---

## sms-provider-configuration-2

*Consolidated from: `sms-provider-configuration.md`*

title: "Configurazione Corretta dei Provider SMS"
type: concept
tags: [sms, provider, configuration]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-provider-configuration-2 configurazione corretta dei provider sms"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Configurazione Corretta dei Provider SMS 

## Regola Fondamentale

, tutte le configurazioni relative ai provider SMS **DEVONO** essere gestite esclusivamente attraverso il file `config/sms.php` e non tramite il file `config/services.php`.

## Struttura Corretta

```php
// Struttura CORRETTA in config/sms.php
return [
    // Configurazioni di base (applicate a tutti i provider)
    'from' => env('SMS_FROM', '<nome progetto>'),
'from' => env('SMS_FROM', 'App'),
    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    
    // Configurazione specifiche dei provider
    'drivers' => [
        'netfun' => [
            'api_key' => env('NETFUN_API_KEY'),
            'sender' => env('NETFUN_SENDER', '<nome progetto>'),
'sender' => env('NETFUN_SENDER', 'App'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
        ],
        // Altri provider...
    ],
];
```

## Implementazione Corretta nelle Action

Ecco come recuperare correttamente le configurazioni nelle classi Action:

```php
// ✅ CORRETTO
public function __construct()
{
    // Recupera configurazione specifica per il provider
    $config = config('sms.drivers.netfun');
    if (!is_array($config)) {
        throw new Exception('Configurazione Netfun non trovata in sms.php');
    }

    $this->token = $config['api_key'] ?? null;
    if (!is_string($this->token)) {
        throw new Exception('API Key Netfun non configurata in sms.php');
    }
    
    // Parametri generici a livello di root
    $this->defaultSender = config('sms.from');
    $this->timeout = config('sms.timeout', 30);
}
```

## Errori Comuni da Evitare

1. **MAI utilizzare `config('services.{provider}')` per accedere alle configurazioni SMS**:
   - ❌ ERRATO: `$token = config('services.netfun.token');`
   - ✅ CORRETTO: `$token = config('sms.drivers.netfun.api_key');`

2. **MAI duplicare configurazioni generiche nei singoli provider**:
   - ❌ ERRATO: Impostare timeout/retry in ogni provider
   - ✅ CORRETTO: Definire timeout/retry a livello di root in config/sms.php

3. **MAI assumere valori predefiniti hardcoded** che non siano documentati:
   - ❌ ERRATO: Usare URL o valori senza documentarli
   - ✅ CORRETTO: Utilizzare sempre env() con valori predefiniti documentati

## Motivazione

1. **Separazione delle Responsabilità**:
   - `services.php` è riservato ai servizi di terze parti generali
   - `sms.php` è dedicato specificatamente alle configurazioni SMS

2. **Manutenibilità**:
   - Centralizzare le configurazioni in un unico file facilita la manutenzione
   - Evita confusione su dove cercare le configurazioni

3. **Coerenza e Standardizzazione**:
   - Tutti i provider SMS seguono lo stesso pattern di configurazione
   - Facilita l'aggiunta di nuovi provider mantenendo lo stesso standard

## Riferimenti nei File di Ambiente

Quando configuri il file `.env`, utilizza questi nomi di variabili:

```

# Configurazione generale SMS
SMS_FROM=<nome progetto>
SMS_FROM=App
SMS_RETRY_ATTEMPTS=3
SMS_RETRY_DELAY=60

# Netfun
NETFUN_API_KEY=your_api_key_here
NETFUN_SENDER=<nome progetto>
NETFUN_SENDER=App
NETFUN_API_URL=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# Twilio
TWILIO_ACCOUNT_SID=your_account_sid_here
TWILIO_AUTH_TOKEN=your_auth_token_here
```
---

## sms-provider-configuration-best-practices-1

*Consolidated from: `sms-provider-configuration-best-practices.md`*


## Struttura Corretta della Configurazione

, il file di configurazione SMS (`config/sms.php`) deve seguire una struttura precisa che separa chiaramente le configurazioni generiche dalle configurazioni specifiche dei provider.

### Configurazione Corretta

```php
<?php

return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'netfun'),

    // Configurazioni generiche applicabili a tutti i driver
    'from' => env('SMS_FROM'),
    'timeout' => (int) env('SMS_TIMEOUT', 30),
    'debug' => (bool) env('SMS_DEBUG', false),

    // Configurazione per retry e circuit breaker
    'retry' => [
        'attempts' => (int) env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => (int) env('SMS_RETRY_DELAY', 60),
    ],

    // Configurazione per rate limiting
    'rate_limit' => [
        'enabled' => (bool) env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => (int) env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => (int) env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],

    // Configurazioni specifiche per driver
    'drivers' => [
        'netfun' => [
            // Solo parametri specifici per Netfun
            'username' => env('NETFUN_USERNAME'),
            'password' => env('NETFUN_PASSWORD'),
            'sender' => env('NETFUN_SENDER'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],

        'twilio' => [
            // Solo parametri specifici per Twilio
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        // Altri provider...
    ],
];
```

## Principi Fondamentali

### 1. Separazione delle Responsabilità

- **Configurazione Provider-Specifica** (sezione `drivers`):
  - SOLO credenziali e parametri di connessione essenziali (username, password, api_key, token, endpoint)
  - MAI includere retry, rate limiting, circuit breaker, timeout, debug flags

- **Configurazione Generica** (sezioni separate):
  - Sezione `retry` per tentativi di ripetizione
  - Sezione `rate_limit` per limitazione delle richieste
  - Sezione `timeout` per timeout globale
  - Sezione `debug` per flag di debug

### 2. Nessun Valore Predefinito per Parametri Critici

Per parametri critici come `sender`, non utilizzare valori predefiniti:

```php
// ❌ ERRATO
'sender' => env('NETFUN_SENDER', '<nome progetto>'),

// ✅ CORRETTO
'sender' => env('NETFUN_SENDER'),
```

### 3. Accesso alla Configurazione

Nel codice, recuperare sempre le configurazioni dal file `config/sms.php` e MAI da `config('services')`:

```php
// ✅ CORRETTO
$token = config('sms.drivers.netfun.username');
$endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

// ❌ ERRATO
$token = config('services.netfun.token');
```

## Errori Comuni da Evitare

1. **Duplicazione della Configurazione**: Non duplicare configurazioni generiche nelle sezioni dei provider
2. **Valori Predefiniti Inappropriati**: Non utilizzare valori predefiniti per parametri critici come `sender`
3. **Configurazione in File Errati**: Non inserire configurazioni SMS in `config/services.php`
4. **Endpoint Errati**: Utilizzare sempre gli endpoint corretti e verificati per ogni provider

## Provider SMS Supportati

| Provider | Endpoint Verificato | Metodo Autenticazione |
|----------|---------------------|------------------------|
| Netfun | `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json` | username/password |
| Twilio | `https://api.twilio.com/2010-04-01/Accounts/{account_sid}/Messages.json` | account_sid/auth_token |
| Vonage | `https://rest.nexmo.com/sms/json` | api_key/api_secret |
| SMSHosting | `https://api.smshosting.it/rest/api/sms/send` | token |
| Telcob | `https://api.telcob.com/sms/v1/send` | api_key |

## Documentazione Correlata

- [SMS Provider Architecture](./SMS_PROVIDER_ARCHITECTURE.md)
- [SMS Implementation](./SMS_IMPLEMENTATION.md)
- [SMS Best Practices](./SMS_BEST_PRACTICES.md)
- [Netfun Authentication Methods](./NETFUN_AUTHENTICATION_METHODS.md)
- [SMS Provider Architecture](../../sms_provider_architecture.md)
- [SMS Implementation](../../sms_implementation.md)
- [SMS Best Practices](../../sms_best_practices.md)
- [Netfun Authentication Methods](../../netfun_authentication_methods.md)

---

## sms-provider-configuration-best-practices-2

*Consolidated from: `sms-provider-configuration-best-practices.md`*

title: "Best Practices per la Configurazione dei Provider SMS"
type: concept
tags: [sms, provider, configuration, best]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-provider-configuration-best-practices-2 best practices per la configurazione dei provider sms"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

# Best Practices per la Configurazione dei Provider SMS

## Struttura Corretta della Configurazione

, il file di configurazione SMS (`config/sms.php`) deve seguire una struttura precisa che separa chiaramente le configurazioni generiche dalle configurazioni specifiche dei provider.

### Configurazione Corretta

```php
<?php

return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'netfun'),
    
    // Configurazioni generiche applicabili a tutti i driver
    'from' => env('SMS_FROM'),
    'timeout' => (int) env('SMS_TIMEOUT', 30),
    'debug' => (bool) env('SMS_DEBUG', false),
    
    // Configurazione per retry e circuit breaker
    'retry' => [
        'attempts' => (int) env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => (int) env('SMS_RETRY_DELAY', 60),
    ],
    
    // Configurazione per rate limiting
    'rate_limit' => [
        'enabled' => (bool) env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => (int) env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => (int) env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    
    // Configurazioni specifiche per driver
    'drivers' => [
        'netfun' => [
            // Solo parametri specifici per Netfun
            'username' => env('NETFUN_USERNAME'),
            'password' => env('NETFUN_PASSWORD'),
            'sender' => env('NETFUN_SENDER'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
        
        'twilio' => [
            // Solo parametri specifici per Twilio
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
        
        // Altri provider...
    ],
];
```

## Principi Fondamentali

### 1. Separazione delle Responsabilità

- **Configurazione Provider-Specifica** (sezione `drivers`):
  - SOLO credenziali e parametri di connessione essenziali (username, password, api_key, token, endpoint)
  - MAI includere retry, rate limiting, circuit breaker, timeout, debug flags

- **Configurazione Generica** (sezioni separate):
  - Sezione `retry` per tentativi di ripetizione 
  - Sezione `rate_limit` per limitazione delle richieste
  - Sezione `timeout` per timeout globale
  - Sezione `debug` per flag di debug

### 2. Nessun Valore Predefinito per Parametri Critici

Per parametri critici come `sender`, non utilizzare valori predefiniti:

```php
// ❌ ERRATO
'sender' => env('NETFUN_SENDER', 'App'),

// ✅ CORRETTO
'sender' => env('NETFUN_SENDER'),
```

### 3. Accesso alla Configurazione

Nel codice, recuperare sempre le configurazioni dal file `config/sms.php` e MAI da `config('services')`:

```php
// ✅ CORRETTO
$token = config('sms.drivers.netfun.username');
$endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

// ❌ ERRATO
$token = config('services.netfun.token');
```

## Errori Comuni da Evitare

1. **Duplicazione della Configurazione**: Non duplicare configurazioni generiche nelle sezioni dei provider
2. **Valori Predefiniti Inappropriati**: Non utilizzare valori predefiniti per parametri critici come `sender`
3. **Configurazione in File Errati**: Non inserire configurazioni SMS in `config/services.php`
4. **Endpoint Errati**: Utilizzare sempre gli endpoint corretti e verificati per ogni provider

## Provider SMS Supportati

| Provider | Endpoint Verificato | Metodo Autenticazione |
|----------|---------------------|------------------------|
| Netfun | `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json` | username/password |
| Twilio | `https://api.twilio.com/2010-04-01/Accounts/{account_sid}/Messages.json` | account_sid/auth_token |
| Vonage | `https://rest.nexmo.com/sms/json` | api_key/api_secret |
| SMSHosting | `https://api.smshosting.it/rest/api/sms/send` | token |
| Telcob | `https://api.telcob.com/sms/v1/send` | api_key |

## Documentazione Correlata

- [SMS Provider Architecture](./sms-provider-architecture.md)
- [SMS Implementation](./sms-implementation.md)
- [SMS Best Practices](./sms-best-practices.md)
- [Netfun Authentication Methods](./netfun-authentication-methods.md)
- [SMS Provider Architecture](./sms-provider-architecture.md)
- [SMS Implementation](./sms-implementation.md)
- [SMS Best Practices](./sms-best-practices.md)
- [Netfun Authentication Methods](./netfun-authentication-methods.md)
- [SMS Provider Architecture](../../sms-provider-architecture.md)
- [SMS Implementation](../../sms-implementation.md)
- [SMS Best Practices](../../sms-best-practices.md)
- [Netfun Authentication Methods](../../netfun-authentication-methods.md)
---

## sms-provider-configuration-best-practices

*Consolidated from: `sms-provider-configuration-best-practices.md`*


## Struttura Corretta della Configurazione

, il file di configurazione SMS (`config/sms.php`) deve seguire una struttura precisa che separa chiaramente le configurazioni generiche dalle configurazioni specifiche dei provider.

### Configurazione Corretta

```php
<?php

return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'netfun'),
    
    // Configurazioni generiche applicabili a tutti i driver
    'from' => env('SMS_FROM'),
    'timeout' => (int) env('SMS_TIMEOUT', 30),
    'debug' => (bool) env('SMS_DEBUG', false),
    
    // Configurazione per retry e circuit breaker
    'retry' => [
        'attempts' => (int) env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => (int) env('SMS_RETRY_DELAY', 60),
    ],
    
    // Configurazione per rate limiting
    'rate_limit' => [
        'enabled' => (bool) env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => (int) env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => (int) env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],
    
    // Configurazioni specifiche per driver
    'drivers' => [
        'netfun' => [
            // Solo parametri specifici per Netfun
            'username' => env('NETFUN_USERNAME'),
            'password' => env('NETFUN_PASSWORD'),
            'sender' => env('NETFUN_SENDER'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
        
        'twilio' => [
            // Solo parametri specifici per Twilio
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
        
        // Altri provider...
    ],
];
```

## Principi Fondamentali

### 1. Separazione delle Responsabilità

- **Configurazione Provider-Specifica** (sezione `drivers`):
  - SOLO credenziali e parametri di connessione essenziali (username, password, api_key, token, endpoint)
  - MAI includere retry, rate limiting, circuit breaker, timeout, debug flags

- **Configurazione Generica** (sezioni separate):
  - Sezione `retry` per tentativi di ripetizione 
  - Sezione `rate_limit` per limitazione delle richieste
  - Sezione `timeout` per timeout globale
  - Sezione `debug` per flag di debug

### 2. Nessun Valore Predefinito per Parametri Critici

Per parametri critici come `sender`, non utilizzare valori predefiniti:

```php
// ❌ ERRATO
'sender' => env('NETFUN_SENDER', 'App'),
'sender' => env('NETFUN_SENDER', 'Quaeris'),

// ✅ CORRETTO
'sender' => env('NETFUN_SENDER'),
```

### 3. Accesso alla Configurazione

Nel codice, recuperare sempre le configurazioni dal file `config/sms.php` e MAI da `config('services')`:

```php
// ✅ CORRETTO
$token = config('sms.drivers.netfun.username');
$endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

// ❌ ERRATO
$token = config('services.netfun.token');
```

## Errori Comuni da Evitare

1. **Duplicazione della Configurazione**: Non duplicare configurazioni generiche nelle sezioni dei provider
2. **Valori Predefiniti Inappropriati**: Non utilizzare valori predefiniti per parametri critici come `sender`
3. **Configurazione in File Errati**: Non inserire configurazioni SMS in `config/services.php`
4. **Endpoint Errati**: Utilizzare sempre gli endpoint corretti e verificati per ogni provider

## Provider SMS Supportati

| Provider | Endpoint Verificato | Metodo Autenticazione |
|----------|---------------------|------------------------|
| Netfun | `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json` | username/password |
| Twilio | `https://api.twilio.com/2010-04-01/Accounts/{account_sid}/Messages.json` | account_sid/auth_token |
| Vonage | `https://rest.nexmo.com/sms/json` | api_key/api_secret |
| SMSHosting | `https://api.smshosting.it/rest/api/sms/send` | token |
| Telcob | `https://api.telcob.com/sms/v1/send` | api_key |

## Documentazione Correlata

- [SMS Provider Architecture](./SMS_PROVIDER_ARCHITECTURE.md)
- [SMS Implementation](./SMS_IMPLEMENTATION.md)
- [SMS Best Practices](./SMS_BEST_PRACTICES.md)
- [Netfun Authentication Methods](./NETFUN_AUTHENTICATION_METHODS.md)
- [SMS Provider Architecture](../../sms_provider_architecture.md)
- [SMS Implementation](../../sms_implementation.md)
- [SMS Best Practices](../../sms_best_practices.md)
- [Netfun Authentication Methods](../../netfun_authentication_methods.md)

---

## sms-provider-configuration

*Consolidated from: `sms-provider-configuration.md`*


## Regola Fondamentale

, tutte le configurazioni relative ai provider SMS **DEVONO** essere gestite esclusivamente attraverso il file `config/sms.php` e non tramite il file `config/services.php`.

## Struttura Corretta

```php
// Struttura CORRETTA in config/sms.php
return [
    // Configurazioni di base (applicate a tutti i provider)
    'from' => env('SMS_FROM', ''),
    'from' => env('SMS_FROM', '<nome progetto>'),
    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],

    // Configurazione specifiche dei provider
    'drivers' => [
        'netfun' => [
            'api_key' => env('NETFUN_API_KEY'),
            'sender' => env('NETFUN_SENDER', ''),
            'sender' => env('NETFUN_SENDER', '<nome progetto>'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
        ],
        // Altri provider...
    ],
];
```

## Implementazione Corretta nelle Action

Ecco come recuperare correttamente le configurazioni nelle classi Action:

```php
// ✅ CORRETTO
public function __construct()
{
    // Recupera configurazione specifica per il provider
    $config = config('sms.drivers.netfun');
    if (!is_array($config)) {
        throw new Exception('Configurazione Netfun non trovata in sms.php');
    }

    $this->token = $config['api_key'] ?? null;
    if (!is_string($this->token)) {
        throw new Exception('API Key Netfun non configurata in sms.php');
    }

    // Parametri generici a livello di root
    $this->defaultSender = config('sms.from');
    $this->timeout = config('sms.timeout', 30);
}
```

## Errori Comuni da Evitare

1. **MAI utilizzare `config('services.{provider}')` per accedere alle configurazioni SMS**:
   - ❌ ERRATO: `$token = config('services.netfun.token');`
   - ✅ CORRETTO: `$token = config('sms.drivers.netfun.api_key');`

2. **MAI duplicare configurazioni generiche nei singoli provider**:
   - ❌ ERRATO: Impostare timeout/retry in ogni provider
   - ✅ CORRETTO: Definire timeout/retry a livello di root in config/sms.php

3. **MAI assumere valori predefiniti hardcoded** che non siano documentati:
   - ❌ ERRATO: Usare URL o valori senza documentarli
   - ✅ CORRETTO: Utilizzare sempre env() con valori predefiniti documentati

## Motivazione

1. **Separazione delle Responsabilità**:
   - `services.php` è riservato ai servizi di terze parti generali
   - `sms.php` è dedicato specificatamente alle configurazioni SMS

2. **Manutenibilità**:
   - Centralizzare le configurazioni in un unico file facilita la manutenzione
   - Evita confusione su dove cercare le configurazioni

3. **Coerenza e Standardizzazione**:
   - Tutti i provider SMS seguono lo stesso pattern di configurazione
   - Facilita l'aggiunta di nuovi provider mantenendo lo stesso standard

## Riferimenti nei File di Ambiente

Quando configuri il file `.env`, utilizza questi nomi di variabili:

```

# Configurazione generale SMS
SMS_FROM=
SMS_FROM=<nome progetto>
SMS_RETRY_ATTEMPTS=3
SMS_RETRY_DELAY=60

# Netfun
NETFUN_API_KEY=your_api_key_here
NETFUN_SENDER=
NETFUN_SENDER=<nome progetto>
NETFUN_API_URL=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# Twilio
TWILIO_ACCOUNT_SID=your_account_sid_here
TWILIO_AUTH_TOKEN=your_auth_token_here
```
# Configurazione Corretta dei Provider SMS

## Regola Fondamentale

, tutte le configurazioni relative ai provider SMS **DEVONO** essere gestite esclusivamente attraverso il file `config/sms.php` e non tramite il file `config/services.php`.

## Struttura Corretta

```php
// Struttura CORRETTA in config/sms.php
return [
    // Configurazioni di base (applicate a tutti i provider)
    'from' => env('SMS_FROM', '<nome progetto>'),
    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),

    // Configurazione specifiche dei provider
    'drivers' => [
        'netfun' => [
            'api_key' => env('NETFUN_API_KEY'),
            'sender' => env('NETFUN_SENDER', '<nome progetto>'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
        // Altri provider...
];
```

## Implementazione Corretta nelle Action

Ecco come recuperare correttamente le configurazioni nelle classi Action:

```php
// ✅ CORRETTO
public function __construct()
{
    // Recupera configurazione specifica per il provider
    $config = config('sms.drivers.netfun');
    if (!is_array($config)) {
        throw new Exception('Configurazione Netfun non trovata in sms.php');
    }

    $this->token = $config['api_key'] ?? null;
    if (!is_string($this->token)) {
        throw new Exception('API Key Netfun non configurata in sms.php');
    }

    // Parametri generici a livello di root
    $this->defaultSender = config('sms.from');
    $this->timeout = config('sms.timeout', 30);
}
```

## Errori Comuni da Evitare

1. **MAI utilizzare `config('services.{provider}')` per accedere alle configurazioni SMS**:
   - ❌ ERRATO: `$token = config('services.netfun.token');`
   - ✅ CORRETTO: `$token = config('sms.drivers.netfun.api_key');`

2. **MAI duplicare configurazioni generiche nei singoli provider**:
   - ❌ ERRATO: Impostare timeout/retry in ogni provider
   - ✅ CORRETTO: Definire timeout/retry a livello di root in config/sms.php

3. **MAI assumere valori predefiniti hardcoded** che non siano documentati:
   - ❌ ERRATO: Usare URL o valori senza documentarli
   - ✅ CORRETTO: Utilizzare sempre env() con valori predefiniti documentati

## Motivazione

1. **Separazione delle Responsabilità**:
   - `services.php` è riservato ai servizi di terze parti generali
   - `sms.php` è dedicato specificatamente alle configurazioni SMS

2. **Manutenibilità**:
   - Centralizzare le configurazioni in un unico file facilita la manutenzione
   - Evita confusione su dove cercare le configurazioni

3. **Coerenza e Standardizzazione**:
   - Tutti i provider SMS seguono lo stesso pattern di configurazione
   - Facilita l'aggiunta di nuovi provider mantenendo lo stesso standard

## Riferimenti nei File di Ambiente

Quando configuri il file `.env`, utilizza questi nomi di variabili:

```

# Configurazione generale SMS
SMS_FROM=<nome progetto>
SMS_RETRY_ATTEMPTS=3
SMS_RETRY_DELAY=60

# Netfun
NETFUN_API_KEY=your_api_key_here
NETFUN_SENDER=<nome progetto>
NETFUN_API_URL=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# Twilio
TWILIO_ACCOUNT_SID=your_account_sid_here
TWILIO_AUTH_TOKEN=your_auth_token_here
```

---

## sms-troubleshooting-1

*Consolidated from: `sms-troubleshooting.md`*


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

- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Queue](https://laravel.com/docs/queues)
- [Laravel Logging](https://laravel.com/docs/logging)

- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Logging](https://laravel.com/docs/logging)- [Laravel Notifications](https://laravel.com/project_docs/notifications)

- [Laravel Notifications](https://laravel.com/project_docs/notifications)

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

---

## sms-troubleshooting-2

*Consolidated from: `sms-troubleshooting.md`*

title: "Troubleshooting SMS"
type: concept
tags: [sms, troubleshooting]
created: 2026-07-14
updated: 2026-07-14
qmd: "sms-troubleshooting-2 troubleshooting sms"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./00-index-documentation.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion-completamento-assoluto.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
---

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

---

## sms-troubleshooting

*Consolidated from: `sms-troubleshooting.md`*


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
    "timestamp": "[DATE] 10:00:00",
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
- [Laravel Logging](https://laravel.com/docs/logging)- [Laravel Notifications](https://laravel.com/project_docs/notifications)
- [Laravel Queue](https://laravel.com/project_docs/queues)
- [Laravel Logging](https://laravel.com/project_docs/logging)
- [Laravel Logging](https://laravel.com/docs/logging)

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

---

## sms

*Consolidated from: `sms.md`*


---

## sms_action_factory_analysis

*Consolidated from: `sms_action_factory_analysis.md`*


## Contesto Attuale
```php
$action = match ($driver) {
    'netfun' => app(SendNetfunSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'vonage' => app(SendVonageSMSAction::class),
    default => throw new \Exception("Driver SMS non supportato: {$driver}")
};
```

## Proposta di Modifica
```php
$actionClass = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($driver) . "SMSAction";
$action = app($actionClass);
```

## Vantaggi (40%)

### 1. Manutenibilità (15%)
- **Pro**: Riduce la duplicazione del codice
- **Pro**: Aggiungere un nuovo driver richiede solo la creazione della classe corrispondente
- **Pro**: Non richiede modifiche al factory quando si aggiunge un nuovo driver

### 2. Flessibilità (10%)
- **Pro**: Supporto automatico per nuovi driver senza modifiche al factory
- **Pro**: Facilita l'implementazione di driver dinamici
- **Pro**: Permette l'integrazione di driver di terze parti

### 3. Coerenza (10%)
- **Pro**: Forza una convenzione di naming standard
- **Pro**: Riduce la possibilità di errori di digitazione
- **Pro**: Mantiene una struttura coerente tra driver

### 4. Testabilità (5%)
- **Pro**: Semplifica i test unitari del factory
- **Pro**: Riduce il numero di casi da testare nel factory

## Svantaggi (60%)

### 1. Sicurezza (20%)
- **Contro**: Possibilità di injection di classi non autorizzate
- **Contro**: Nessun controllo esplicito sui driver supportati
- **Contro**: Rischio di caricamento di classi malevole

### 2. Robustezza (15%)
- **Contro**: Nessuna validazione del driver prima dell'istanziazione
- **Contro**: Errori più difficili da debuggare
- **Contro**: Possibili errori runtime non catturati

### 3. Manutenibilità (10%)
- **Contro**: Difficile tracciare quali driver sono effettivamente supportati
- **Contro**: Nessuna documentazione implicita dei driver supportati
- **Contro**: Più difficile da capire per nuovi sviluppatori

### 4. Performance (5%)
- **Contro**: Overhead di reflection per il caricamento dinamico
- **Contro**: Possibili problemi di caching

### 5. Flessibilità (10%)
- **Contro**: Forza una convenzione di naming rigida
- **Contro**: Difficile supportare driver con naming non standard
- **Contro**: Limitazioni nella struttura dei namespace

## Soluzione Ibrida Proposta
```php
private const SUPPORTED_DRIVERS = [
    'netfun',
    'twilio',
    'vonage'
];

public function make(string $driver): SmsActionInterface
{
    if (!in_array($driver, self::SUPPORTED_DRIVERS)) {
        throw new \Exception("Driver SMS non supportato: {$driver}");
    }

    $actionClass = "Modules\\Notify\\Actions\\SMS\\Send" . ucfirst($driver) . "SMSAction";
    
    if (!class_exists($actionClass)) {
        throw new \Exception("Classe action non trovata per il driver: {$driver}");
    }

    $action = app($actionClass);
    
    if (!$action instanceof SmsActionInterface) {
        throw new \Exception("La classe {$actionClass} non implementa SmsActionInterface");
    }

    return $action;
}
```

## Vantaggi della Soluzione Ibrida
1. Mantiene la flessibilità della formula
2. Aggiunge controlli di sicurezza
3. Documenta i driver supportati
4. Valida l'implementazione dell'interfaccia
5. Fornisce messaggi di errore chiari

## Conclusione
La soluzione ibrida offre il miglior compromesso tra:
- Flessibilità nella gestione dei driver
- Sicurezza e validazione
- Manutenibilità e documentazione
- Robustezza e gestione degli errori

Si consiglia di implementare la soluzione ibrida per ottenere i vantaggi di entrambi gli approcci mantenendo un alto livello di sicurezza e manutenibilità. 

---

## sms_action_factory_resolution

*Consolidated from: `sms_action_factory_resolution.md`*


## Contesto

Nel factory `SmsActionFactory`, invece di usare un `match` esplicito per risolvere la classe action in base al driver, si può calcolare dinamicamente il nome della classe action tramite una formula.

---

## 1. Esempio di match esplicito

```php
$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

---

## 2. Esempio di risoluzione dinamica tramite formula

```php
$driverStudly = Str::studly($driver); // es: smsfactor -> Smsfactor
$class = "Modules\\Notify\\Actions\\SMS\\Send{$driverStudly}SMSAction";
if (!class_exists($class)) {
    throw new Exception("Action class non trovata per driver: {$driver}");
}
$action = app($class);
```

---

## 3. Vantaggi della risoluzione dinamica
- **Scalabilità**: aggiungere un nuovo driver non richiede modifiche al factory, basta rispettare la convenzione di naming.
- **DRY**: elimina la duplicazione di codice e la necessità di aggiornare il match ad ogni nuovo driver.
- **Manutenzione**: meno punti di rottura, meno rischio di dimenticare un driver.
- **Coerenza**: forza l'adozione di una naming convention chiara e uniforme.

**Percentuale vantaggi:** 80%

---

## 4. Svantaggi della risoluzione dinamica
- **Errori silenziosi**: se il nome della classe non rispetta la convenzione, l'errore viene fuori solo a runtime.
- **Refactoring rischioso**: rinominare una classe senza aggiornare la formula può rompere il sistema.
- **Meno esplicito**: la lista dei driver supportati non è visibile a colpo d'occhio nel codice.
- **IDE e static analysis**: meno supporto per refactoring automatici e suggerimenti.

**Percentuale svantaggi:** 20%

---

## 5. Best practice consigliata
- Usare la risoluzione dinamica **solo se** la naming convention è rigorosamente rispettata e documentata.
- Aggiungere test automatici che verifichino la presenza della classe action per ogni driver configurato.
- Documentare chiaramente la formula e la convenzione di naming.
- In caso di driver "speciali" o legacy, prevedere un fallback o una mappa custom.

---

## 6. Formula consigliata

```php
$driverStudly = Str::studly($driver); // es: smsfactor -> Smsfactor
$class = "Modules\\Notify\\Actions\\SMS\\Send{$driverStudly}SMSAction";
if (!class_exists($class)) {
    throw new Exception("Action class non trovata per driver: {$driver}");
}
return app($class);
```

---

## 7. Conclusione

La risoluzione dinamica tramite formula è **più scalabile e manutenibile** rispetto al match esplicito, ma richiede disciplina nella naming convention e test automatici di coerenza. In progetti modulari e in crescita è la scelta preferibile, purché ben documentata e sorvegliata. 

---

## sms_actions

*Consolidated from: `sms_actions.md`*


## Interfaccia

Tutte le azioni di invio SMS devono implementare l'interfaccia `SmsActionInterface`:

```php
namespace Modules\Notify\Contracts\SMS;

interface SmsActionInterface
{
    /**
     * Esegue l'invio dell'SMS
     *
     * @param SmsData $smsData I dati del messaggio SMS
     * @return array Risultato dell'operazione
     * @throws \Exception In caso di errore durante l'invio
     */
    public function execute(SmsData $smsData): array;
}
```

## Struttura

Le azioni SMS sono organizzate secondo questa struttura:

1. **Contratti**: Le interfacce sono definite in `app/Contracts/SMS/`
2. **Implementazioni**: Le azioni concrete sono in `app/Actions/SMS/`
3. **Regole**:
   - Ogni azione deve implementare `SmsActionInterface`
   - Il metodo `execute()` deve accettare solo `SmsData`
   - Deve restituire un array con i dettagli dell'operazione
   - Deve gestire e loggare gli errori appropriatamente

## Provider Supportati

- Netfun
- Altri provider da aggiungere...

## Esempio di Utilizzo

```php
$smsData = new SmsData(
    to: '+393331234567',
    body: 'Il tuo codice OTP è: 123456',
    from: '<nome progetto>'
    from: 'SaluteOra'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

## Best Practices

1. **Validazione**:
   - Validare sempre i dati in ingresso
   - Verificare il formato del numero di telefono
   - Controllare la lunghezza del messaggio

2. **Gestione Errori**:
   - Usare try/catch per gestire le eccezioni
   - Loggare gli errori con dettagli
   - Implementare retry per fallimenti temporanei

3. **Performance**:
   - Utilizzare le code per l'invio
   - Implementare rate limiting
   - Monitorare l'uso dell'API

4. **Sicurezza**:
   - Validare l'input degli utenti
   - Sanitizzare i messaggi
   - Proteggere le chiavi API

---

## sms_best_practices

*Consolidated from: `sms_best_practices.md`*


## 1. Gestione dei Template

### Struttura Template
```php
// Esempio di template ben strutturato
{
    "name": "welcome",
    "content": "Benvenuto {{name}}! Il tuo codice di verifica è {{code}}.",
    "variables": ["name", "code"],
    "max_length": 160
}
```

### Best Practices
- Mantenere template brevi e concisi
- Evitare caratteri speciali
- Utilizzare variabili standardizzate
- Documentare ogni template
- Testare il rendering

## 2. Validazione

### Numeri di Telefono
```php
// Esempio di validazione
public function validatePhoneNumber($number)
{
    return preg_match('/^\+[1-9]\d{1,14}$/', $number);
}
```

### Best Practices
- Verificare formato internazionale
- Validare prima dell'invio
- Gestire errori di formato
- Loggare tentativi non validi
- Implementare blacklist

## 3. Gestione degli Errori

### Retry Mechanism
```php
// Esempio di retry
public function sendWithRetry($number, $message, $attempts = 3)
{
    for ($i = 0; $i < $attempts; $i++) {
        try {
            return $this->send($number, $message);
        } catch (Exception $e) {
            if ($i === $attempts - 1) {
                throw $e;
            }
            sleep(1);
        }
    }
}
```

### Best Practices
- Implementare retry automatico
- Loggare tutti gli errori
- Notificare errori critici
- Monitorare tasso di errore
- Implementare fallback

## 4. Performance

### Queue System
```php
// Esempio di job in coda
class SendSmsJob implements ShouldQueue
{
    public function handle()
    {
        // Logica di invio
    }
}
```

### Best Practices
- Utilizzare code per invii massivi
- Implementare rate limiting
- Ottimizzare batch size
- Monitorare performance
- Implementare caching

## 5. Sicurezza

### API Key Management
```php
// Esempio di gestione sicura
protected function getApiKey()
{
    return config('sms.drivers.smsfactor.api_key');
}
```

### Best Practices
- Proteggere API keys
- Implementare rate limiting
- Validare input
- Loggare accessi
- Implementare audit trail

## 6. Monitoraggio

### Logging Structure
```php
// Esempio di logging
Log::info('SMS Sent', [
    'recipient' => $number,
    'template' => $template,
    'status' => $status,
    'provider' => $provider
]);
```

### Best Practices
- Loggare tutte le operazioni
- Monitorare metriche chiave
- Implementare alerting
- Generare report
- Analizzare trend

## 7. Testing

### Unit Tests
```php
// Esempio di test
public function test_sms_sending()
{
    $result = $this->smsService->send(
        '+393331234567',
        'Test message'
    );
    $this->assertTrue($result);
}
```

### Best Practices
- Testare tutti i casi d'uso
- Implementare mock
- Testare errori
- Validare template
- Testare performance

## 8. Manutenzione

### Backup Strategy
```php
// Esempio di backup
public function backupTemplates()
{
    $templates = SmsTemplate::all();
    Storage::put(
        'backups/sms-templates-' . date('Y-m-d') . '.json',
        $templates->toJson()
    );
}
```

### Best Practices
- Backup regolare
- Versioning template
- Documentazione aggiornata
- Monitoraggio versione
- Piano rollback

## 9. Compliance

### GDPR e Privacy
```php
// Esempio di gestione consenso
public function hasConsent($user)
{
    return $user->sms_consent && $user->sms_consent_date;
}
```

### Best Practices
- Rispettare GDPR
- Gestire consensi
- Documentare policy
- Implementare opt-out
- Audit regolare

## 10. Ottimizzazione

### Costi e Risorse
```php
// Esempio di ottimizzazione
public function optimizeBatch($messages)
{
    return array_chunk($messages, 100);
}
```

### Best Practices
- Ottimizzare costi
- Monitorare utilizzo
- Implementare caching
- Ottimizzare batch
- Analizzare ROI

## 11. Documentazione

### Template Documentation
```php
/**
 * @param string $name Nome del template
 * @param array $variables Variabili richieste
 * @return string Template renderizzato
 */
public function renderTemplate($name, $variables)
{
    // Implementazione
}
```

### Best Practices
- Documentare tutto
- Mantenere aggiornato
- Includere esempi
- Documentare errori
- Aggiornare changelog

## 12. Supporto

### Error Handling
```php
// Esempio di gestione errori
try {
    $this->sendSms($number, $message);
} catch (SmsException $e) {
    Log::error('SMS Error', [
        'error' => $e->getMessage(),
        'number' => $number
    ]);
    // Notifica supporto
}
```

### Best Practices
- Implementare supporto
- Documentare procedure
- Mantenere SLA
- Monitorare ticket
- Analizzare feedback 

---

## sms_channel_action_resolution

*Consolidated from: `sms_channel_action_resolution.md`*


## Contesto

Attualmente la logica di risoluzione dell'action SMS in base al driver configurato è posizionata nel canale custom `SmsChannel`:

```php
$driver = Config::get('sms.default', 'smsfactor');
$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

È stato chiesto se questa logica non sarebbe meglio spostarla all'interno del DTO `SmsData`.

---

## Analisi delle due soluzioni

### 1. Logica nel Canale (`SmsChannel`)

**Vantaggi:**
- **Responsabilità chiara** (Single Responsibility): il canale si occupa di orchestrare l'invio, non il DTO.
- **Separation of Concerns**: il DTO resta un puro contenitore di dati, senza logica applicativa.
- **Testabilità**: più facile testare la logica di risoluzione e mocking delle action.
- **Estendibilità**: aggiungere nuovi driver o cambiare la logica di risoluzione non impatta la struttura dei dati.
- **Aderenza alle best practice Laravel**: i canali sono pensati per orchestrare, i DTO per trasportare dati.

**Svantaggi:**
- La logica di risoluzione è duplicabile se usata in altri punti (ma si può estrarre in un service/factory).

**Percentuali:**
- **Vantaggi:** 85%
- **Svantaggi:** 15%

---

### 2. Logica nel DTO (`SmsData`)

**Vantaggi:**
- **Comodità**: si può richiamare direttamente dal DTO, minor codice in alcuni casi.
- **Incapsulamento**: tutto ciò che riguarda l'SMS sembra essere nel DTO.

**Svantaggi:**
- **Violazione SRP**: il DTO non dovrebbe conoscere la logica di invio, solo trasportare dati.
- **Difficoltà di test**: il DTO diventa difficile da testare e mockare.
- **Rigidità**: se la logica cambia (es. fallback, multi-driver, regole di routing), il DTO va modificato e rischia di diventare un oggetto "Dio".
- **Contrario alle convenzioni Laravel e DDD**: i Data Object non dovrebbero contenere logica di orchestrazione.
- **Rischio di accoppiamento**: il DTO diventa dipendente da tutto il sistema di invio.

**Percentuali:**
- **Vantaggi:** 20%
- **Svantaggi:** 80%

---

## Conclusione

**La logica di risoluzione dell'action SMS va mantenuta nel canale (`SmsChannel`) o, meglio ancora, estratta in una factory/service dedicato.**

- Il DTO (`SmsData`) deve restare un puro contenitore di dati.
- Il canale si occupa di orchestrare e risolvere l'action corretta.
- Per evitare duplicazione, si può creare una `SmsActionFactory` che centralizza la logica di risoluzione.

**Best practice:**
- DTO = solo dati
- Channel = orchestrazione
- Factory/Service = risoluzione dinamica

---

**Percentuali finali:**
- Logica nel canale/factory: **85% pro, 15% contro**
- Logica nel DTO: **20% pro, 80% contro**

**Motivazione:** Separation of Concerns, testabilità, estendibilità, aderenza alle best practice Laravel e DDD. 

---

## sms_config_structure

*Consolidated from: `sms_config_structure.md`*

# Struttura della Configurazione SMS
## Introduzione

Questo documento definisce la struttura corretta del file di configurazione SMS (`config/sms.php`) nel modulo Notify, con particolare attenzione alla gestione delle configurazioni generiche vs specifiche per provider.

## Struttura Generale

Il file `config/sms.php` è organizzato in sezioni distinte:

```php
return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'default_provider'),

    
    // Configurazione dei driver/provider
    'drivers' => [
        // Configurazioni specifiche per provider...
    ],

    
    // Configurazioni generiche per tutti i provider
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'logging' => [...],
    'validation' => [...],
];
```

## Configurazioni Generiche vs Specifiche

### 1. Configurazioni Generiche

Le configurazioni generiche si applicano a **tutti** i provider SMS e sono definite a livello di root nel file di configurazione:

```php
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],
```

### 2. Configurazioni Specifiche per Provider

Le configurazioni specifiche per provider sono definite all'interno della sezione `drivers` e contengono **solo** i parametri specifici per quel provider:

```php
'drivers' => [
    'netfun' => [
        // Credenziali e parametri di connessione
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', '<nome progetto>'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),

        'sender' => env('NETFUN_SENDER', 'SaluteOra'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        
        // Configurazioni avanzate specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],

    
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'from' => env('TWILIO_FROM'),
    ],

    
    // Altri provider...
],
```

## Regola Fondamentale: Evitare Duplicazioni

**IMPORTANTE**: Evitare di duplicare le configurazioni generiche all'interno delle configurazioni specifiche per provider. Ad esempio:

❌ **ERRATO**:
```php
'drivers' => [
    'netfun' => [
        // ...
        'max_retries' => env('NETFUN_MAX_RETRIES', 3),      // Duplica 'retry.attempts'
        'retry_delay' => env('NETFUN_RETRY_DELAY', 1),      // Duplica 'retry.delay'
        'rate_limit' => env('NETFUN_RATE_LIMIT', 100),      // Duplica 'rate_limit.max_attempts'
        'rate_limit_window' => env('NETFUN_RATE_LIMIT_WINDOW', 60), // Duplica 'rate_limit.decay_minutes'
        // ...
    ],
],
```

✅ **CORRETTO**:
```php
// Configurazioni generiche a livello di root
'retry' => [
    'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
    'delay' => env('SMS_RETRY_DELAY', 60),
],

'rate_limit' => [
    'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
    'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
    'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
],

// Solo configurazioni specifiche per provider nella sezione 'drivers'
'drivers' => [
    'netfun' => [
        'username' => env('NETFUN_USERNAME'),
        'password' => env('NETFUN_PASSWORD'),
        'sender' => env('NETFUN_SENDER', '<nome progetto>'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),

        'sender' => env('NETFUN_SENDER', 'SaluteOra'),
        'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        
        // Solo configurazioni veramente specifiche per Netfun
        'circuit_breaker' => [
            'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
            'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
        ],
    ],
],
```

## Gestione Precedenze

Quando sia le configurazioni generiche che quelle specifiche per provider sono presenti:

1. Le configurazioni specifiche per provider hanno **precedenza** sulle configurazioni generiche
2. Il codice che utilizza queste configurazioni deve implementare questa logica di precedenza

Esempio di implementazione della logica di precedenza:

```php
// In una classe che gestisce l'invio SMS
$retryAttempts = $config['drivers'][$driver]['max_retries'] ?? $config['retry']['attempts'];
$retryDelay = $config['drivers'][$driver]['retry_delay'] ?? $config['retry']['delay'];
```

## Checklist di Verifica

- [ ] Configurazioni generiche (retry, rate_limit, ecc.) definite a livello di root
- [ ] Configurazioni specifiche per provider definite solo nella sezione `drivers`
- [ ] Nessuna duplicazione tra configurazioni generiche e specifiche
- [ ] Logica di precedenza implementata nel codice che utilizza queste configurazioni

## Collegamenti

- [Configurazione Netfun](./NETFUN_CONFIG_REQUIREMENTS.md)
- [Configurazione Netfun](../../netfun_config_requirements.md)
- [Provider SMS Supportati](./notifications/SMS_PROVIDER_CONFIGURATION.md)

---

*Ultimo aggiornamento: 2025-05-12*

---

## sms_driver_enum_translations

*Consolidated from: `sms_driver_enum_translations.md`*


## Panoramica

Il `SmsDriverEnum` utilizza il `TransTrait` per gestire automaticamente le traduzioni dei driver SMS supportati. Questo permette di avere etichette, colori, icone e descrizioni localizzate per ogni provider SMS.

## Struttura Enum

```php
enum SmsDriverEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    
    case SMSFACTOR = 'smsfactor';
    case TWILIO = 'twilio';
    case NEXMO = 'nexmo';
    case PLIVO = 'plivo';
    case GAMMU = 'gammu';
    case NETFUN = 'netfun';
    case AGILETELECOM = 'agiletelecom';
}
```

## Metodi di Traduzione

L'enum implementa i seguenti metodi che utilizzano il `TransTrait`:

```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value . '.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value . '.description');
}
```

## File di Traduzione

Le traduzioni sono gestite tramite il file `sms_driver_enum.php` in ogni lingua:

### Struttura File
```
laravel/Modules/Notify/lang/
├── it/sms_driver_enum.php
├── en/sms_driver_enum.php
└── de/sms_driver_enum.php
```

### Formato Traduzioni

Ogni driver ha la seguente struttura:

```php
'smsfactor' => [
    'label' => 'SMSFactor',
    'color' => 'primary',
    'icon' => 'heroicon-o-device-phone-mobile',
    'description' => 'Provider SMS francese con API REST e supporto per messaggi bulk',
],
```

## Driver Supportati

### 1. SMSFactor
- **Label**: SMSFactor
- **Color**: primary
- **Icon**: heroicon-o-device-phone-mobile
- **Description**: Provider SMS francese con API REST e supporto per messaggi bulk

### 2. Twilio
- **Label**: Twilio
- **Color**: success
- **Icon**: heroicon-o-chat-bubble-left-right
- **Description**: Piattaforma cloud per comunicazioni con API robuste e documentazione completa

### 3. Nexmo (Vonage)
- **Label**: Nexmo (Vonage)
- **Color**: warning
- **Icon**: heroicon-o-globe-alt
- **Description**: Provider globale per SMS e comunicazioni con copertura internazionale

### 4. Plivo
- **Label**: Plivo
- **Color**: info
- **Icon**: heroicon-o-phone
- **Description**: Piattaforma per comunicazioni vocali e SMS con API semplici

### 5. Gammu
- **Label**: Gammu
- **Color**: secondary
- **Icon**: heroicon-o-cpu-chip
- **Description**: Libreria open source per gestione modem GSM e invio SMS

### 6. Netfun
- **Label**: Netfun
- **Color**: danger
- **Icon**: heroicon-o-bolt
- **Description**: Provider italiano per SMS con supporto per messaggi promozionali e transazionali

### 7. Agile Telecom
- **Label**: Agile Telecom
- **Color**: gray
- **Icon**: heroicon-o-truck
- **Description**: Provider italiano per servizi di telecomunicazioni e SMS

## Utilizzo in Filament

L'enum può essere utilizzato direttamente nei componenti Filament:

```php
use Modules\Notify\Enums\SmsDriverEnum;

// In un form
Select::make('driver')
    ->options(SmsDriverEnum::class)
    ->required();

// In una tabella
TextColumn::make('driver')
    ->formatStateUsing(fn (SmsDriverEnum $state) => $state->getLabel())
    ->color(fn (SmsDriverEnum $state) => $state->getColor())
    ->icon(fn (SmsDriverEnum $state) => $state->getIcon());
```

## Chiavi di Traduzione

Il `TransTrait` genera automaticamente le seguenti chiavi:

- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.label`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.color`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.icon`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.description`

## Aggiunta Nuovi Driver

Per aggiungere un nuovo driver:

1. **Aggiungere il case nell'enum**:
```php
case NUOVO_DRIVER = 'nuovo_driver';
```

2. **Aggiungere le traduzioni** in tutti i file di lingua:
```php
'nuovo_driver' => [
    'label' => 'Nuovo Driver',
    'color' => 'primary',
    'icon' => 'heroicon-o-star',
    'description' => 'Descrizione del nuovo driver',
],
```

3. **Aggiornare la configurazione** in `config/sms.php` se necessario

## Verifica Traduzioni

Per verificare che tutte le traduzioni siano presenti:

```bash

# Verifica sintassi PHP
php -l laravel/Modules/Notify/lang/it/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/en/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/de/sms_driver_enum.php
```

## Collegamenti

- [SmsDriverEnum](../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../config/sms.php)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [SmsDriverEnum](../../../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../../../config/sms.php)
- [Documentazione Traduzioni](../../../../Lang/docs)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)

---

## sms_driver_selection_analysis

*Consolidated from: `sms_driver_selection_analysis.md`*


## Contesto Attuale
Attualmente, la logica di selezione del driver SMS è implementata nel canale di notifica:

```php
$driver = Config::get('sms.default', 'smsfactor');

$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

## Proposta di Modifica
Spostare questa logica all'interno di `SmsData`:

```php
class SmsData extends Data
{
    public function getAction(): SendSmsActionInterface
    {
        $driver = Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

## Analisi dei Vantaggi (60%)

### 1. Incapsulamento (25%)
- La logica di selezione del driver è strettamente correlata ai dati SMS
- Riduce l'accoppiamento tra il canale e i dettagli di implementazione
- Migliora la coesione del codice

### 2. Riutilizzabilità (15%)
- La logica può essere riutilizzata in altri contesti oltre al canale
- Facilita l'implementazione di nuovi punti di invio SMS
- Riduce la duplicazione del codice

### 3. Manutenibilità (10%)
- Centralizza la logica di selezione del driver
- Semplifica le modifiche future alla logica di selezione
- Riduce il rischio di inconsistenze

### 4. Testabilità (10%)
- Facilita il testing isolato della logica di selezione
- Permette di mockare più facilmente l'azione corretta
- Migliora la copertura dei test

## Analisi degli Svantaggi (40%)

### 1. Violazione del Principio di Responsabilità Singola (20%)
- `SmsData` dovrebbe rappresentare solo i dati
- Aggiunge una responsabilità non correlata alla rappresentazione dei dati
- Potrebbe violare il principio di separazione delle preoccupazioni

### 2. Complessità Aggiuntiva (10%)
- Aumenta la complessità della classe `SmsData`
- Potrebbe rendere il codice meno intuitivo
- Richiede una documentazione più dettagliata

### 3. Dipendenze (5%)
- Introduce dipendenze aggiuntive in `SmsData`
- Potrebbe complicare l'inizializzazione dell'oggetto
- Aumenta il rischio di problemi di circolarità

### 4. Flessibilità (5%)
- Potrebbe limitare la flessibilità nella gestione dei driver
- Rende più difficile l'implementazione di logiche di selezione personalizzate
- Potrebbe complicare l'aggiunta di nuovi driver

## Raccomandazione

Basandosi sull'analisi, la raccomandazione è di **NON** spostare la logica di selezione del driver in `SmsData` per i seguenti motivi:

1. La violazione del principio di responsabilità singola è un problema significativo
2. I vantaggi in termini di incapsulamento non giustificano la complessità aggiuntiva
3. La logica di selezione del driver è più appropriata in un servizio dedicato

### Alternativa Proposta

Creare un servizio dedicato per la gestione dei driver:

```php
class SmsDriverService
{
    public function getAction(string $driver = null): SendSmsActionInterface
    {
        $driver = $driver ?? Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

Questa soluzione:
- Mantiene la separazione delle responsabilità
- Centralizza la logica di selezione
- È più facile da testare e mantenere
- Non viola i principi SOLID 

---

## sms_driver_selection_specific_analysis

*Consolidated from: `sms_driver_selection_specific_analysis.md`*


## Contesto Specifico
```php
if (! $smsData instanceof SmsData) {
    throw new Exception('toSms method must return an instance of SmsData');
}

$driver = Config::get('sms.default', 'smsfactor');

$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

## Analisi dei Vantaggi (45%)

### 1. Validazione Integrata (20%)
- La validazione del tipo di dato è strettamente correlata alla classe `SmsData`
- Riduce la duplicazione del codice di validazione
- Centralizza la logica di validazione

### 2. Coerenza dei Dati (15%)
- Garantisce che i dati siano sempre validi prima dell'invio
- Riduce il rischio di errori runtime
- Migliora la robustezza del codice

### 3. Manutenibilità (10%)
- Semplifica la gestione delle modifiche alla validazione
- Centralizza la logica di selezione del driver
- Riduce la complessità del canale di notifica

## Analisi degli Svantaggi (55%)

### 1. Violazione del Principio di Responsabilità Singola (25%)
- `SmsData` dovrebbe occuparsi solo della rappresentazione dei dati
- La validazione e selezione del driver sono responsabilità separate
- Aumenta l'accoppiamento tra dati e logica di business

### 2. Complessità Aggiuntiva (15%)
- Aumenta la complessità della classe `SmsData`
- Rende il codice meno intuitivo
- Richiede una documentazione più dettagliata

### 3. Testabilità (10%)
- Rende più difficile il testing isolato
- Complica il mocking delle dipendenze
- Aumenta la complessità dei test unitari

### 4. Flessibilità (5%)
- Limita la possibilità di personalizzare la validazione
- Rende più difficile l'estensione della logica
- Complica l'aggiunta di nuovi driver

## Raccomandazione Finale

Basandosi sull'analisi specifica, la raccomandazione è di **NON** spostare la logica in `SmsData` per i seguenti motivi:

1. La violazione del principio di responsabilità singola è particolarmente critica in questo caso
2. Gli svantaggi superano i vantaggi (55% vs 45%)
3. La complessità aggiuntiva non è giustificata dai benefici

### Soluzione Proposta

Creare un servizio dedicato che gestisca sia la validazione che la selezione del driver:

```php
class SmsService
{
    public function validateAndGetAction($smsData): SendSmsActionInterface
    {
        if (! $smsData instanceof SmsData) {
            throw new Exception('toSms method must return an instance of SmsData');
        }

        $driver = Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

Questa soluzione:
- Mantiene la separazione delle responsabilità
- Centralizza sia la validazione che la selezione del driver
- È più facile da testare e mantenere
- Non viola i principi SOLID
- Mantiene `SmsData` focalizzato sulla sua responsabilità primaria 

---

## sms_factor_data_implementation

*Consolidated from: `sms_factor_data_implementation.md`*


## Overview

This document summarizes the implementation of the `SmsFactorData` class and the refactoring of `SendSmsFactorSMSAction` to follow the same pattern as `AgiletelecomData`.

## Changes Made

### 1. Created SmsFactorData Class

**File**: `/Modules/Notify/app/Datas/SMS/SmsFactorData.php`

- **Purpose**: Centralized configuration management for SMSFactor SMS provider
- **Pattern**: Follows the same structure as `AgiletelecomData`
- **Features**:
  - Singleton pattern implementation
  - Configuration loading from `config('sms.drivers.smsfactor')`
  - Authentication header generation
  - Helper methods for common operations

**Key Properties**:
- `$token`: SMSFactor API token
- `$base_url`: API endpoint URL (default: https://api.smsfactor.com)
- `$auth_type`: Authentication type (default: 'bearer')
- `$timeout`: HTTP request timeout (default: 30 seconds)

**Key Methods**:
- `make()`: Singleton factory method
- `getAuthHeaders()`: Returns Bearer authentication headers
- `getBaseUrl()`: Returns configured base URL
- `getTimeout()`: Returns configured timeout

### 2. Refactored SendSmsFactorSMSAction

**File**: `/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`

**Changes**:
- Replaced manual configuration handling with `SmsFactorData` usage
- Removed redundant properties (`$token`, `$baseUrl`, `$timeout`)
- Simplified constructor logic
- Updated `execute()` method to use data class methods

**Before**:
```php
private string $token;
private string $baseUrl;
private int $timeout;

public function __construct()
{
    $config = config('sms.drivers.smsfactor');
    $this->token = $config['token'] ?? null;
    $this->baseUrl = $config['base_url'] ?? 'https://api.smsfactor.com';
    $this->timeout = (int) config('sms.timeout', 30);
}
```

**After**:
```php
private SmsFactorData $smsFactorData;

public function __construct()
{
    $this->smsFactorData = SmsFactorData::make();
    
    if (!$this->smsFactorData->token) {
        throw new Exception('Token SMSFactor non configurato in sms.php');
    }
}
```

### 3. Updated Documentation

**Files Created/Updated**:
- `/Modules/Notify/project_docs/sms/drivers/smsfactor/data-class.md`: Comprehensive documentation for `SmsFactorData`
- `/Modules/Notify/project_docs/sms_implementation.md`: Updated to include data class information

**Documentation Includes**:
- Complete class structure and properties
- Method descriptions and usage examples
- Configuration requirements
- Environment variable setup
- Usage patterns and best practices
- Migration guide from direct configuration access

## Benefits of This Implementation

### 1. Consistency
- Follows the same pattern as `AgiletelecomData`
- Standardized approach across SMS providers
- Consistent method naming and structure

### 2. Type Safety
- Leverages Spatie Laravel Data for type safety
- Explicit property types and method signatures
- Better IDE support and autocompletion

### 3. Centralized Configuration
- Single point of configuration management
- Singleton pattern prevents multiple configuration loads
- Easy to extend with additional properties

### 4. Maintainability
- Cleaner action classes with reduced complexity
- Separation of concerns between configuration and business logic
- Easier testing with mockable data objects

### 5. Reusability
- Data class can be used by other SMS-related classes
- Helper methods reduce code duplication
- Standardized authentication header generation

## Configuration Requirements

### Environment Variables
```env
SMSFACTOR_TOKEN=your_smsfactor_api_token
SMSFACTOR_BASE_URL=https://api.smsfactor.com
```

### SMS Configuration
```php
// config/sms.php
'drivers' => [
    'smsfactor' => [
        'token' => env('SMSFACTOR_TOKEN'),
        'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
    ],
],
```

## Usage Example

```php
use Modules\Notify\Datas\SMS\SmsFactorData;
use Modules\Notify\Actions\SMS\SendSmsFactorSMSAction;

// Get configuration data
$smsFactorData = SmsFactorData::make();

// Use in action
$action = new SendSmsFactorSMSAction();
$result = $action->execute($smsData);

// Direct usage of data class
$headers = $smsFactorData->getAuthHeaders();
$baseUrl = $smsFactorData->getBaseUrl();
```

## Testing Considerations

The new implementation makes testing easier by allowing mock data objects:

```php
// Create test data
$testData = SmsFactorData::from([
    'token' => 'test_token',
    'base_url' => 'https://test.smsfactor.com',
    'timeout' => 10
]);

// Use in tests
$headers = $testData->getAuthHeaders();
$this->assertEquals('Bearer test_token', $headers['Authorization']);
```

## Future Enhancements

1. **Additional Providers**: The same pattern can be applied to other SMS providers
2. **Configuration Validation**: Add validation rules to the data class
3. **Caching**: Implement configuration caching for better performance
4. **Monitoring**: Add logging and monitoring capabilities to the data class

## Related Files

- `/Modules/Notify/app/Datas/SMS/AgiletelecomData.php`: Similar implementation for Agiletelecom
- `/Modules/Notify/app/Actions/SMS/SendSmsFactorSMSAction.php`: Refactored action class
- `/Modules/Notify/config/sms.php`: SMS configuration file
- `/Modules/Notify/project_docs/sms_implementation.md`: General SMS implementation documentation

## Conclusion

The implementation of `SmsFactorData` and the refactoring of `SendSmsFactorSMSAction` successfully follows the established pattern and provides a more maintainable, type-safe, and consistent approach to SMS provider configuration management. This change aligns with the project's architecture principles and makes the codebase more robust and easier to extend.

---

## sms_global_vs_specific_params

*Consolidated from: `sms_global_vs_specific_params.md`*


## Introduzione

Questo documento chiarisce la distinzione fondamentale tra parametri a livello di root e specifici per provider nella configurazione SMS del modulo Notify. Una corretta comprensione di questa distinzione è essenziale per evitare duplicazioni e inconsistenze nella configurazione.

## Struttura della Configurazione

La configurazione SMS segue una struttura gerarchica con due livelli principali:

1. **Livello Root**: Parametri comuni che si applicano a tutti i provider SMS
2. **Livello Provider**: Parametri che sono specifici per un determinato provider

```php
return [
    // Parametri a livello di root
    'default' => env('SMS_DRIVER', 'default_provider'),
    'from' => env('SMS_FROM'),
    'debug' => env('SMS_DEBUG', false),
    'queue' => env('SMS_QUEUE', 'default'),
    'retry' => [...],
    'rate_limit' => [...],
    'circuit_breaker' => [...],
    
    // Parametri specifici per provider (nella sezione 'drivers')
    'drivers' => [
        'provider1' => [
            // Solo parametri specifici per questo provider
        ],
        'provider2' => [
            // Solo parametri specifici per questo provider
        ],
    ],
];
```

## Parametri a Livello di Root

I parametri a livello di root sono definiti direttamente nel file di configurazione e si applicano a tutti i provider SMS. Questi parametri **NON devono essere duplicati** nella configurazione specifica di ciascun provider.

### Esempi di Parametri a Livello di Root

| Parametro | Descrizione | Variabile d'Ambiente |
|-----------|-------------|----------------------|
| `from` | Mittente predefinito per tutti i messaggi | `SMS_FROM` |
| `debug` | Modalità debug per tutti i provider | `SMS_DEBUG` |
| `queue` | Coda per l'invio asincrono | `SMS_QUEUE` |
| `retry.attempts` | Numero di tentativi di invio | `SMS_RETRY_ATTEMPTS` |
| `retry.delay` | Ritardo tra i tentativi (secondi) | `SMS_RETRY_DELAY` |
| `rate_limit.enabled` | Abilitazione del rate limiting | `SMS_RATE_LIMIT_ENABLED` |
| `rate_limit.max_attempts` | Numero massimo di tentativi | `SMS_RATE_LIMIT_MAX_ATTEMPTS` |
| `rate_limit.decay_minutes` | Finestra temporale per il rate limiting | `SMS_RATE_LIMIT_DECAY_MINUTES` |
| `circuit_breaker.enabled` | Abilitazione del circuit breaker | `SMS_CIRCUIT_BREAKER_ENABLED` |
| `circuit_breaker.threshold` | Soglia di errori per il circuit breaker | `SMS_CIRCUIT_BREAKER_THRESHOLD` |
| `circuit_breaker.timeout` | Timeout del circuit breaker (secondi) | `SMS_CIRCUIT_BREAKER_TIMEOUT` |

## Parametri Specifici per Provider

I parametri specifici per provider sono definiti all'interno della sezione `drivers` e si applicano solo al provider specifico. Questi parametri **NON devono duplicare** i parametri globali.

### Esempi di Parametri Specifici per Provider

#### Twilio

```php
'twilio' => [
    'account_sid' => env('TWILIO_ACCOUNT_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
],
```

#### Netfun

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    'callback_url' => env('NETFUN_CALLBACK_URL'),
    'circuit_breaker' => [  // Solo se necessario sovrascrivere il comportamento globale
        'threshold' => env('NETFUN_CIRCUIT_BREAKER_THRESHOLD', 5),
        'timeout' => env('NETFUN_CIRCUIT_BREAKER_TIMEOUT', 60),
    ],
],
```

## Errori Comuni da Evitare

### 1. Duplicazione di Parametri a Livello di Root

❌ **Errato**:
```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    'from' => env('NETFUN_FROM'),  // ERRORE: duplica il parametro 'from' a livello di root
    'debug' => env('NETFUN_DEBUG', false),  // ERRORE: duplica il parametro 'debug' a livello di root
],
```

✅ **Corretto**:
```php
// A livello di root
'from' => env('SMS_FROM'),
'debug' => env('SMS_DEBUG', false),

// Nella sezione 'drivers'
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
    // Nessuna duplicazione di parametri a livello di root
],
```

### 2. Nomenclatura Inconsistente

❌ **Errato**:
```php
// Nomi diversi per lo stesso concetto
'twilio' => [
    'from' => env('TWILIO_FROM'),
],
'netfun' => [
    'sender' => env('NETFUN_SENDER'),  // ERRORE: usa 'sender' invece di 'from'
],
```

✅ **Corretto**:
```php
// A livello globale
'from' => env('SMS_FROM'),

// Nessuna duplicazione nella sezione 'drivers'
```

### 3. Parametri Specifici a Livello Globale

❌ **Errato**:
```php
// A livello globale
'netfun_token' => env('NETFUN_TOKEN'),  // ERRORE: parametro specifico a livello globale
```

✅ **Corretto**:
```php
// Nella sezione 'drivers'
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

## Implementazione della Precedenza

Quando sia i parametri a livello di root che quelli specifici per provider sono presenti, i parametri specifici hanno precedenza. Questo comportamento deve essere implementato nel codice che utilizza queste configurazioni:

```php
// In una classe che gestisce l'invio SMS
$config = config('sms');
$driver = $config['default'];

// Implementazione della precedenza
$debug = $config['drivers'][$driver]['debug'] ?? $config['debug'];
```

## Checklist di Verifica

Prima di modificare la configurazione SMS, verificare che:

- [ ] I parametri comuni siano definiti a livello di root
- [ ] I parametri specifici per provider siano definiti solo nella sezione `drivers`
- [ ] Non ci siano duplicazioni tra parametri a livello di root e parametri specifici per provider
- [ ] La nomenclatura sia coerente tra i diversi provider
- [ ] I nomi dei parametri seguano le convenzioni standard

## Riferimenti

- [Struttura Standardizzata della Configurazione SMS](./STANDARDIZED_SMS_CONFIG_STRUCTURE.md)
- [Configurazione Netfun](./NETFUN_CONFIG_REQUIREMENTS.md)
- [Struttura Standardizzata della Configurazione SMS](../../standardized_sms_config_structure.md)
- [Configurazione Netfun](../../netfun_config_requirements.md)
- [Laravel Configuration Best Practices](https://laravel.com/docs/configuration)

---

*Ultimo aggiornamento: 2025-05-12*

---

## sms_implementation

*Consolidated from: `sms_implementation.md`*


## Panoramica
Questo documento descrive l'implementazione del sistema di invio SMS nel modulo Notify, utilizzando il pacchetto `gr8shivam/laravel-sms-api` come driver principale **e** il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione delle azioni asincrone e sincrone.

## Architettura Data-Driven

Il sistema SMS utilizza classi Data di Spatie per gestire la configurazione dei provider in modo centralizzato e tipizzato:

- **SmsFactorData**: Gestisce configurazione e autenticazione per SMSFactor
- **AgiletelecomData**: Gestisce configurazione e autenticazione per Agiletelecom

Queste classi implementano il pattern singleton e forniscono metodi helper per l'autenticazione e la configurazione.

## Architettura

### 1. Driver Supportati
- **SMSFactor** (Driver principale)
- **Twilio** (Alternativa)
- **Nexmo/Vonage** (Alternativa)
- **Plivo** (Alternativa)
- **Gammu** (Per server GSM)

### 2. Configurazione
```php
// config/sms.php
return [
    'default' => env('SMS_DRIVER', 'smsfactor'),
    
    'drivers' => [
        'smsfactor' => [
            'token' => env('SMSFACTOR_TOKEN'),
            'base_url' => env('SMSFACTOR_BASE_URL', 'https://api.smsfactor.com'),
        ],
        'agiletelecom' => [
            'username' => env('AGILETELECOM_USERNAME'),
            'password' => env('AGILETELECOM_PASSWORD'),
            'sender' => env('AGILETELECOM_SENDER'),
            'endpoint' => env('AGILETELECOM_ENDPOINT'),
            'auth_type' => env('AGILETELECOM_AUTH_TYPE', 'basic'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],
        // Altri driver...
    ]
];
```

### 3. Classi Data per Provider

#### SmsFactorData
```php
use Modules\Notify\Datas\SMS\SmsFactorData;

// Utilizzo singleton
$smsFactorData = SmsFactorData::make();

// Metodi helper
$headers = $smsFactorData->getAuthHeaders();
$baseUrl = $smsFactorData->getBaseUrl();
$timeout = $smsFactorData->getTimeout();
```

#### AgiletelecomData
```php
use Modules\Notify\Datas\SMS\AgiletelecomData;

// Utilizzo singleton
$agiletelecomData = AgiletelecomData::make();

// Metodi helper
$headers = $agiletelecomData->getAuthHeaders();
```

### 3. Struttura del Database
```sql
CREATE TABLE sms_templates (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    content text NOT NULL,
    variables json,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE sms_logs (
    id bigint unsigned NOT NULL AUTO_INCREMENT,
    template_id bigint unsigned NOT NULL,
    recipient varchar(255) NOT NULL,
    content text NOT NULL,
    status varchar(50) NOT NULL,
    error_message text,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (template_id) REFERENCES sms_templates(id)
);
```

## Implementazione

### 1. Service Provider
```php
namespace Modules\Notify\Providers;

use Illuminate\Support\ServiceProvider;
use Gr8Shivam\SmsApi\SmsApiServiceProvider;

class NotifyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(SmsApiServiceProvider::class);
    }
}
```

### 2. Notification Channel
```php
namespace Modules\Notify\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Gr8Shivam\SmsApi\SmsApi;

class SmsChannel
{
    protected $sms;

    public function __construct(SmsApi $sms)
    {
        $this->sms = $sms;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
        
        return $this->sms->send(
            $notifiable->phone_number,
            $message
        );
    }
}
```

### 3. Template System

> **Nota:** La logica di rendering dei template può essere gestita tramite una action queueable, non tramite un service custom.

Esempio di Action per invio SMS:

```php
namespace Modules\Notify\Actions;

use Spatie\QueueableAction\QueueableAction;
use Gr8Shivam\SmsApi\SmsApi;

class SendSmsAction
{
    use QueueableAction;

    public function execute(string $to, string $template, array $variables = [])
    {
        // Recupera il template dal database
        $smsTemplate = SmsTemplate::where('name', $template)->firstOrFail();
        $content = $smsTemplate->content;
        foreach ($variables as $key => $value) {
            $content = str_replace("{{$key}}", $value, $content);
        }
        // Invia SMS
        app(SmsApi::class)->send($to, $content);
        // Log, gestione errori, ecc.
    }
}
```

#### Esecuzione Sincrona
```php
app(SendSmsAction::class)->execute('+393331234567', 'welcome', ['name' => 'Mario']);
```

#### Esecuzione Asincrona (in coda)
```php
app(SendSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'welcome', ['name' => 'Mario']);
```

### 4. Queueable Actions

Per la gestione di azioni asincrone e sincrone, utilizziamo il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action):

- Permette di scrivere azioni riutilizzabili, testabili e iniettate via costruttore
- Supporta esecuzione immediata o in coda (`onQueue()`)
- Supporta chaining, middleware, backoff, tagging per Horizon

#### Esempio di Action con Middleware e Tag
```php
class SendSmsAction
{
    use QueueableAction;

    public function middleware()
    {
        return [new RateLimited()];
    }

    public function tags()
    {
        return ['sms', 'notify'];
    }

    public function execute(string $to, string $template, array $variables = [])
    {
        // ... come sopra
    }
}
```

#### Testing
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendSmsAction::class)->onQueue()->execute('+393331234567', 'welcome', ['name' => 'Mario']);
QueueableActionFake::assertPushed(SendSmsAction::class);
```

#### Chaining
```php
use Spatie\QueueableAction\ActionJob;

app(SendSmsAction::class)
    ->onQueue()
    ->execute($to, $template, $vars)
    ->chain([
        new ActionJob(AnotherAction::class, [$to, $template, $vars]),
    ]);
```

#### Riferimenti
- [spatie/laravel-queueable-action - GitHub](https://github.com/spatie/laravel-queueable-action)
- [Blog post: Queueable Actions](https://stitcher.io/blog/laravel-queueable-actions)

## Best Practices

- Utilizzare sempre le Actions per la business logic riutilizzabile
- Usare la coda per invii massivi o lenti
- Testare le Actions con Queue::fake e QueueableActionFake
- Gestire errori e retry tramite le features del pacchetto
- Documentare ogni Action

## Testing

### 1. Unit Tests
```php
namespace Modules\Notify\Tests\Unit;

use Tests\TestCase;
use Modules\Notify\Services\SmsService;

class SmsServiceTest extends TestCase
{
    public function test_sms_sending()
    {
        $service = new SmsService();
        $result = $service->send('+1234567890', 'Test message');
        $this->assertTrue($result);
    }
}
```

### 2. Integration Tests
```php
namespace Modules\Notify\Tests\Feature;

use Tests\TestCase;
use Modules\Notify\Models\SmsTemplate;

class SmsIntegrationTest extends TestCase
{
    public function test_template_rendering()
    {
        $template = SmsTemplate::create([
            'name' => 'Test',
            'content' => 'Hello {{name}}!'
        ]);
        
        $result = $template->render(['name' => 'John']);
        $this->assertEquals('Hello John!', $result);
    }
}
```

## Monitoraggio e Logging

### 1. Log Structure
```json
{
    "timestamp": "2024-03-20 10:00:00",
    "template_id": 1,
    "recipient": "+1234567890",
    "content": "Test message",
    "status": "sent",
    "provider": "smsfactor",
    "response": {
        "message_id": "123456",
        "status": "success"
    }
}
```

### 2. Metrics
- Tasso di consegna
- Tempo di consegna
- Errori per provider
- Costi per provider

## Deployment

### 1. Requisiti
- PHP 8.1+
- Laravel 10+
- Estensione cURL
- Configurazione SSL

### 2. Variabili d'Ambiente
```env
SMS_DRIVER=smsfactor
SMSFACTOR_API_KEY=your_api_key
SMSFACTOR_SENDER=YourApp
```

## Manutenzione

### 1. Backup
- Backup giornaliero dei template
- Backup dei log
- Backup delle configurazioni

### 2. Aggiornamenti
- Monitoraggio delle versioni
- Test di compatibilità
- Piano di rollback

## Troubleshooting

### 1. Errori Comuni
- Invalid phone number
- API rate limit
- Network issues
- Template rendering errors

### 2. Soluzioni
- Validazione numeri
- Implementazione retry
- Timeout handling
- Error logging

## Riferimenti
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Documentazione SMSFactor](https://www.smsfactor.com)
- [Documentazione Twilio](https://www.twilio.com/docs)
- [Documentazione Nexmo](https://developer.nexmo.com)
- [Documentazione Plivo](https://www.plivo.com/docs) 

---

## sms_netfun_channel

*Consolidated from: `sms_netfun_channel.md`*


## Introduzione
Questa guida spiega come integrare il provider Netfun come canale custom per l'invio di SMS in Laravel, seguendo le best practice del framework e sfruttando il pacchetto [`spatie/laravel-queueable-action`](https://github.com/spatie/laravel-queueable-action) per la gestione asincrona.

> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](./NETFUN_CONFIG_REQUIREMENTS.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.
> **IMPORTANTE**: Prima di procedere, assicurati che la [configurazione richiesta per Netfun](../../netfun_config_requirements.md) sia stata completata correttamente nel file `config/sms.php` del modulo Notify.

---

## 1. Creazione del Channel Netfun

### 1.1. Struttura del Channel
Crea il file `app/Notifications/Channels/NetfunSmsChannel.php`:

```php
namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class NetfunSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toNetfunSms($notifiable);
        $to = $notifiable->routeNotificationFor('netfun_sms', $notification);

        // Validazione numero
        if (!self::isValidNumber($to)) {
            \Log::warning('Numero non valido per Netfun SMS', ['to' => $to]);
            return false;
        }

        // Parametri Netfun
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json';

        $payload = [
            'apiKey' => $apiKey,
            'messages' => [
                [
                    'recipient' => $to,
                    'text' => $message,
                    'sender' => $sender,
                ]
            ]
        ];

        $response = Http::post($endpoint, $payload);

        // Logging e gestione errori avanzata
        if (!$response->successful() || data_get($response->json(), 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            // Possibile fallback: invio con altro provider
            // dispatch(new FallbackSmsJob(...));
            return false;
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $response->json(),
        ]);
        return $response->json();
    }

    public static function isValidNumber($number): bool
    {
        // Esempio: formato internazionale obbligatorio
        return preg_match('/^\+[1-9]\d{7,15}$/', $number);
    }
}
```

#### Invio Batch Multiplo
Per inviare più SMS in un'unica chiamata:

```php
$recipients = ['+393331234567', '+393331234568'];
$messages = array_map(fn($to) => [
    'recipient' => $to,
    'text' => 'Messaggio di test',
    'sender' => $sender,
], $recipients);

$payload = [
    'apiKey' => $apiKey,
    'messages' => $messages,
];
$response = Http::post($endpoint, $payload);
```

### 1.2. Configurazione

**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](./NETFUN_AUTHENTICATION_METHODS.md).
**IMPORTANTE**: Il modulo Notify attualmente utilizza l'autenticazione username/password per Netfun, non l'autenticazione API key descritta qui. Per dettagli sui metodi di autenticazione supportati, consultare la [documentazione sui metodi di autenticazione Netfun](../../netfun_authentication_methods.md).

Configurazione con API key in `config/sms.php` (documentata ma non implementata nel modulo):

```php
'netfun' => [
    'api_key' => env('NETFUN_API_KEY'),
    'sender' => env('NETFUN_SENDER'),
    'endpoint' => env('NETFUN_ENDPOINT', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
],
```

Configurazione attuale con username/password nel modulo Notify:

```php
'netfun' => [
    'username' => env('NETFUN_USERNAME'),
    'password' => env('NETFUN_PASSWORD'),
    'sender' => env('NETFUN_SENDER', '<nome progetto>'),
    'sender' => env('NETFUN_SENDER', 'SaluteOra'),
    'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
    // Parametri avanzati...
],
```

Variabili d'ambiente nel `.env` (per la configurazione attuale):
```
NETFUN_USERNAME=your_username
NETFUN_PASSWORD=your_password
NETFUN_SENDER=YourSender
```

---

## 2. Creazione della Queueable Action (Spatie)

Crea la action in `app/Actions/SendNetfunSmsAction.php`:

```php
namespace App\Actions;

use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Http;

class SendNetfunSmsAction
{
    use QueueableAction;

    public function execute($to, $message)
    {
        $apiKey = config('sms.drivers.netfun.api_key');
        $sender = config('sms.drivers.netfun.sender');
        $endpoint = config('sms.drivers.netfun.endpoint', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

        // Supporto batch: $to può essere stringa o array
        $recipients = is_array($to) ? $to : [$to];
        $messages = array_map(fn($num) => [
            'recipient' => $num,
            'text' => $message,
            'sender' => $sender,
        ], $recipients);

        $payload = [
            'apiKey' => $apiKey,
            'messages' => $messages,
        ];

        $response = Http::post($endpoint, $payload);
        $json = $response->json();

        if (!$response->successful() || data_get($json, 'status') !== 'OK') {
            \Log::error('Netfun SMS invio fallito', [
                'to' => $to,
                'message' => $message,
                'payload' => $payload,
                'response' => $response->body(),
            ]);
            throw new \Exception('Invio SMS Netfun fallito: ' . data_get($json, 'error', 'Errore generico'));
        }
        \Log::info('Netfun SMS inviato', [
            'to' => $to,
            'message' => $message,
            'response' => $json,
        ]);
        return $json;
    }
}
```

#### Esempio invio batch:
```php
app(SendNetfunSmsAction::class)->execute(['+393331234567', '+393331234568'], 'Messaggio multiplo');
```

### Esecuzione Sincrona
```php
app(SendNetfunSmsAction::class)->execute('+393331234567', 'Messaggio di test');
```

### Esecuzione Asincrona (in coda)
```php
app(SendNetfunSmsAction::class)
    ->onQueue('sms')
    ->execute('+393331234567', 'Messaggio di test');
```

---

## 3. Utilizzo nelle Notification Laravel

### 3.1. Definizione della Notification
Crea la notification in `app/Notifications/OrderShipped.php`:

```php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Actions\SendNetfunSmsAction;

class OrderShipped extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['netfun_sms'];
    }

    public function toNetfunSms($notifiable)
    {
        $message = "Ciao {$notifiable->name}, il tuo ordine è stato spedito!";
        // Esecuzione asincrona
        app(SendNetfunSmsAction::class)
            ->onQueue('sms')
            ->execute($notifiable->phone_number, $message);
        return $message;
    }
}
```

### 3.2. Invio della Notification
```php
$user->notify(new OrderShipped());
```

---

## 4. Dettagli Endpoint e Risposta

### 4.1. Payload di Richiesta (singolo e batch)
```json
{
  "apiKey": "<API_KEY>",
  "messages": [
    {
      "recipient": "+393331234567",
      "text": "Messaggio di test",
      "sender": "YourSender"
    },
    {
      "recipient": "+393331234568",
      "text": "Messaggio di test",
      "sender": "YourSender"
    }
  ]
}
```

### 4.2. Risposta API
Esempio di risposta positiva:
```json
{
  "status": "OK",
  "batchId": "1234567890",
  "messages": [
    {
      "recipient": "+393331234567",
      "status": "QUEUED",
      "messageId": "abcdef123456"
    },
    {
      "recipient": "+393331234568",
      "status": "QUEUED",
      "messageId": "abcdef123457"
    }
  ]
}
```

In caso di errore:
```json
{
  "status": "ERROR",
  "error": "Invalid API key"
}
```

#### Parsing della risposta
```php
$json = $response->json();
if (data_get($json, 'status') === 'OK') {
    foreach ($json['messages'] as $msg) {
        // $msg['recipient'], $msg['status'], $msg['messageId']
    }
}
```

---

## 5. Testing

### 5.1. Testare la Action
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;
use Illuminate\Support\Facades\Queue;

Queue::fake();
app(SendNetfunSmsAction::class)->onQueue()->execute('+393331234567', 'Test SMS');
QueueableActionFake::assertPushed(SendNetfunSmsAction::class);
```

### 5.2. Testare la Notification
```php
Notification::fake();
$user->notify(new OrderShipped());
Notification::assertSentTo($user, OrderShipped::class);
```

---

## 6. Best Practices Avanzate
- Validare sempre i numeri (formato internazionale, blacklist, opt-out)
- Loggare sia successi che errori, includendo payload e risposta
- Usare la coda per evitare blocchi e gestire retry automatici
- Implementare fallback su provider secondari in caso di errore
- Gestire rate limiting e throttling
- Documentare payload, risposta e casi d'uso
- Monitorare batchId e messageId per tracciamento
- Gestire la privacy (GDPR): loggare solo dati necessari, anonimizzare dove possibile
- Aggiornare la documentazione ad ogni modifica

---

## 7. Troubleshooting
- **Invalid API key**: controlla la chiave e i permessi
- **Numero non valido**: verifica il formato e la presenza in blacklist
- **Status diverso da OK**: logga la risposta, valuta retry o fallback
- **Timeout o errori di rete**: implementa retry/backoff, monitora la connettività
- **Messaggi non consegnati**: controlla lo status di ogni messaggio nella risposta

---

## 8. Compliance e Sicurezza
- Conserva i log in modo sicuro e conforme a GDPR
- Non loggare dati sensibili inutilmente
- Proteggi le API key tramite variabili d'ambiente
- Aggiorna regolarmente le dipendenze
- Implementa audit trail per le operazioni critiche

---

## 9. Riferimenti
- [Netfun SMS API](https://www.netfunitalia.it/)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Laravel Notifications](https://laravel.com/docs/notifications) 

---

## 10. Utilizzo di DTOs con Spatie Laravel Data

Per standardizzare e validare i dati degli SMS, utilizziamo i Data Object di [`spatie/laravel-data`](https://github.com/spatie/laravel-data) nella cartella `app/Datas`.

### 10.1. Esempio di DTO per SMS

Il file `app/Datas/SmsData.php`:

```php
namespace Modules\Notify\Datas;

use Spatie\LaravelData\Data;

class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
}
```

### 10.2. Utilizzo in Action/Channel

```php
use Modules\Notify\Datas\SmsData;

// Creazione DTO
$smsData = new SmsData(
    from: config('sms.drivers.netfun.sender'),
    to: '+393331234567',
    body: 'Messaggio di test'
);

// Accesso ai dati
$payload = [
    'apiKey' => config('sms.drivers.netfun.api_key'),
    'messages' => [[
        'recipient' => $smsData->to,
        'text' => $smsData->body,
        'sender' => $smsData->from,
    ]],
];
```

### 10.3. Best Practices
- Usare sempre DTO per validare e tipizzare i dati in ingresso
- Utilizzare metodi statici/factory per conversioni da array/request
- Validare i dati con regole custom (es. formato numero, lunghezza mittente)
- Documentare ogni DTO e aggiornarlo in caso di modifiche API

---
--- 

# Canale SMS Netfun

Questo documento descrive come utilizzare il canale SMS Netfun nel modulo Notify.

## Configurazione

### 1. Configurazione del Provider

Aggiungi la seguente configurazione nel file `config/services.php`:

```php
'netfun' => [
    'token' => env('NETFUN_TOKEN'),
],
```

### 2. Variabili d'Ambiente

Aggiungi la seguente variabile nel tuo file `.env`:

```env
NETFUN_TOKEN=your_api_token_here
```

## Utilizzo

### Invio SMS Base

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$result = $action->execute($smsData);
```

### Invio SMS in Coda

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

$smsData = new SmsData(
    to: '+393331234567',
    from: 'YourSender',
    body: 'Il tuo messaggio'
);

$action = new SendNetfunSMSAction();
$action->onQueue('sms')->execute($smsData);
```

## Gestione degli Errori

L'azione gestisce automaticamente gli errori HTTP e lancia un'eccezione con dettagli appropriati. È consigliabile utilizzare un try-catch per gestire questi errori:

```php
try {
    $result = $action->execute($smsData);
} catch (Exception $e) {
    Log::error('Errore invio SMS: ' . $e->getMessage());
    // Gestisci l'errore appropriatamente
}
```

## Note Importanti

1. L'azione implementa l'interfaccia `SmsActionInterface` per garantire la consistenza con altri provider SMS.
2. I numeri di telefono vengono automaticamente normalizzati per assicurare il formato corretto.
3. L'invio è asincrono per default (`async: true`).
4. Il supporto UTF-8 è abilitato per default per gestire caratteri speciali.

## Best Practices

1. **Validazione**: Assicurati di validare i numeri di telefono prima dell'invio.
2. **Logging**: Implementa un logging appropriato per tracciare gli invii e gli errori.
3. **Rate Limiting**: Considera l'implementazione di rate limiting per evitare sovraccarichi.
4. **Retry**: Implementa una logica di retry per gestire fallimenti temporanei.

## Testing

```php
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Actions\SMS\SendNetfunSMSAction;

class NetfunSMSTest extends TestCase
{
    public function test_can_send_sms()
    {
        $smsData = new SmsData(
            to: '+393331234567',
            from: 'TestSender',
            body: 'Test message'
        );

        $action = new SendNetfunSMSAction();
        $result = $action->execute($smsData);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('status_code', $result);
        $this->assertArrayHasKey('status_txt', $result);
    }
}
```

---
--- 

---

## sms_provider_configuration

*Consolidated from: `sms_provider_configuration.md`*

# Configurazione Corretta dei Provider SMS
## Regola Fondamentale

, tutte le configurazioni relative ai provider SMS **DEVONO** essere gestite esclusivamente attraverso il file `config/sms.php` e non tramite il file `config/services.php`.

## Struttura Corretta

```php
// Struttura CORRETTA in config/sms.php
return [
    // Configurazioni di base (applicate a tutti i provider)
    'from' => env('SMS_FROM', '<nome progetto>'),
    'from' => env('SMS_FROM', 'SaluteOra'),
    'retry' => [
        'attempts' => env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => env('SMS_RETRY_DELAY', 60),
    ],
    'rate_limit' => [
        'enabled' => env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],

    
    // Configurazione specifiche dei provider
    'drivers' => [
        'netfun' => [
            'api_key' => env('NETFUN_API_KEY'),
            'sender' => env('NETFUN_SENDER', '<nome progetto>'),
            'sender' => env('NETFUN_SENDER', 'SaluteOra'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],
        'twilio' => [
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
        ],
        // Altri provider...
    ],
];
```

## Implementazione Corretta nelle Action

Ecco come recuperare correttamente le configurazioni nelle classi Action:

```php
// ✅ CORRETTO
public function __construct()
{
    // Recupera configurazione specifica per il provider
    $config = config('sms.drivers.netfun');
    if (!is_array($config)) {
        throw new Exception('Configurazione Netfun non trovata in sms.php');
    }

    $this->token = $config['api_key'] ?? null;
    if (!is_string($this->token)) {
        throw new Exception('API Key Netfun non configurata in sms.php');
    }

    
    // Parametri generici a livello di root
    $this->defaultSender = config('sms.from');
    $this->timeout = config('sms.timeout', 30);
}
```

## Errori Comuni da Evitare

1. **MAI utilizzare `config('services.{provider}')` per accedere alle configurazioni SMS**:
   - ❌ ERRATO: `$token = config('services.netfun.token');`
   - ✅ CORRETTO: `$token = config('sms.drivers.netfun.api_key');`

2. **MAI duplicare configurazioni generiche nei singoli provider**:
   - ❌ ERRATO: Impostare timeout/retry in ogni provider
   - ✅ CORRETTO: Definire timeout/retry a livello di root in config/sms.php

3. **MAI assumere valori predefiniti hardcoded** che non siano documentati:
   - ❌ ERRATO: Usare URL o valori senza documentarli
   - ✅ CORRETTO: Utilizzare sempre env() con valori predefiniti documentati

## Motivazione

1. **Separazione delle Responsabilità**:
   - `services.php` è riservato ai servizi di terze parti generali
   - `sms.php` è dedicato specificatamente alle configurazioni SMS

2. **Manutenibilità**:
   - Centralizzare le configurazioni in un unico file facilita la manutenzione
   - Evita confusione su dove cercare le configurazioni

3. **Coerenza e Standardizzazione**:
   - Tutti i provider SMS seguono lo stesso pattern di configurazione
   - Facilita l'aggiunta di nuovi provider mantenendo lo stesso standard

## Riferimenti nei File di Ambiente

Quando configuri il file `.env`, utilizza questi nomi di variabili:

```

# Configurazione generale SMS
SMS_FROM=<nome progetto>
SMS_FROM=SaluteOra
SMS_RETRY_ATTEMPTS=3
SMS_RETRY_DELAY=60

# Netfun
NETFUN_API_KEY=your_api_key_here
NETFUN_SENDER=<nome progetto>
NETFUN_SENDER=SaluteOra
NETFUN_API_URL=https://v2.smsviainternet.it/api/rest/v1/sms-batch.json

# Twilio
TWILIO_ACCOUNT_SID=your_account_sid_here
TWILIO_AUTH_TOKEN=your_auth_token_here
```

---

## sms_provider_configuration_best_practices

*Consolidated from: `sms_provider_configuration_best_practices.md`*


## Struttura Corretta della Configurazione

, il file di configurazione SMS (`config/sms.php`) deve seguire una struttura precisa che separa chiaramente le configurazioni generiche dalle configurazioni specifiche dei provider.

### Configurazione Corretta

```php
<?php

return [
    // Driver predefinito
    'default' => env('SMS_DRIVER', 'netfun'),

    
    // Configurazioni generiche applicabili a tutti i driver
    'from' => env('SMS_FROM'),
    'timeout' => (int) env('SMS_TIMEOUT', 30),
    'debug' => (bool) env('SMS_DEBUG', false),

    
    // Configurazione per retry e circuit breaker
    'retry' => [
        'attempts' => (int) env('SMS_RETRY_ATTEMPTS', 3),
        'delay' => (int) env('SMS_RETRY_DELAY', 60),
    ],

    
    // Configurazione per rate limiting
    'rate_limit' => [
        'enabled' => (bool) env('SMS_RATE_LIMIT_ENABLED', true),
        'max_attempts' => (int) env('SMS_RATE_LIMIT_MAX_ATTEMPTS', 60),
        'decay_minutes' => (int) env('SMS_RATE_LIMIT_DECAY_MINUTES', 1),
    ],

    
    // Configurazioni specifiche per driver
    'drivers' => [
        'netfun' => [
            // Solo parametri specifici per Netfun
            'username' => env('NETFUN_USERNAME'),
            'password' => env('NETFUN_PASSWORD'),
            'sender' => env('NETFUN_SENDER'),
            'api_url' => env('NETFUN_API_URL', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json'),
        ],

        
        'twilio' => [
            // Solo parametri specifici per Twilio
            'account_sid' => env('TWILIO_ACCOUNT_SID'),
            'auth_token' => env('TWILIO_AUTH_TOKEN'),
            'from' => env('TWILIO_FROM'),
        ],

        
        // Altri provider...
    ],
];
```

## Principi Fondamentali

### 1. Separazione delle Responsabilità

- **Configurazione Provider-Specifica** (sezione `drivers`):
  - SOLO credenziali e parametri di connessione essenziali (username, password, api_key, token, endpoint)
  - MAI includere retry, rate limiting, circuit breaker, timeout, debug flags

- **Configurazione Generica** (sezioni separate):
  - Sezione `retry` per tentativi di ripetizione
  - Sezione `retry` per tentativi di ripetizione 
  - Sezione `rate_limit` per limitazione delle richieste
  - Sezione `timeout` per timeout globale
  - Sezione `debug` per flag di debug

### 2. Nessun Valore Predefinito per Parametri Critici

Per parametri critici come `sender`, non utilizzare valori predefiniti:

```php
// ❌ ERRATO
'sender' => env('NETFUN_SENDER', '<nome progetto>'),
'sender' => env('NETFUN_SENDER', 'SaluteOra'),

// ✅ CORRETTO
'sender' => env('NETFUN_SENDER'),
```

### 3. Accesso alla Configurazione

Nel codice, recuperare sempre le configurazioni dal file `config/sms.php` e MAI da `config('services')`:

```php
// ✅ CORRETTO
$token = config('sms.drivers.netfun.username');
$endpoint = config('sms.drivers.netfun.api_url', 'https://v2.smsviainternet.it/api/rest/v1/sms-batch.json');

// ❌ ERRATO
$token = config('services.netfun.token');
```

## Errori Comuni da Evitare

1. **Duplicazione della Configurazione**: Non duplicare configurazioni generiche nelle sezioni dei provider
2. **Valori Predefiniti Inappropriati**: Non utilizzare valori predefiniti per parametri critici come `sender`
3. **Configurazione in File Errati**: Non inserire configurazioni SMS in `config/services.php`
4. **Endpoint Errati**: Utilizzare sempre gli endpoint corretti e verificati per ogni provider

## Provider SMS Supportati

| Provider | Endpoint Verificato | Metodo Autenticazione |
|----------|---------------------|------------------------|
| Netfun | `https://v2.smsviainternet.it/api/rest/v1/sms-batch.json` | username/password |
| Twilio | `https://api.twilio.com/2010-04-01/Accounts/{account_sid}/Messages.json` | account_sid/auth_token |
| Vonage | `https://rest.nexmo.com/sms/json` | api_key/api_secret |
| SMSHosting | `https://api.smshosting.it/rest/api/sms/send` | token |
| Telcob | `https://api.telcob.com/sms/v1/send` | api_key |

## Documentazione Correlata

- [SMS Provider Architecture](./SMS_PROVIDER_ARCHITECTURE.md)
- [SMS Implementation](./SMS_IMPLEMENTATION.md)
- [SMS Best Practices](./SMS_BEST_PRACTICES.md)
- [Netfun Authentication Methods](./NETFUN_AUTHENTICATION_METHODS.md)
- [SMS Provider Architecture](../../sms_provider_architecture.md)
- [SMS Implementation](../../sms_implementation.md)
- [SMS Best Practices](../../sms_best_practices.md)
- [Netfun Authentication Methods](../../netfun_authentication_methods.md)

---

## sms_troubleshooting

*Consolidated from: `sms_troubleshooting.md`*


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

---

## smsriver-enum-translations

*Consolidated from: `smsriver-enum-translations.md`*


## Panoramica

Il `SmsDriverEnum` utilizza il `TransTrait` per gestire automaticamente le traduzioni dei driver SMS supportati. Questo permette di avere etichette, colori, icone e descrizioni localizzate per ogni provider SMS.

## Struttura Enum

```php
enum SmsDriverEnum: string implements HasLabel, HasIcon, HasColor
{
    use TransTrait;
    
    case SMSFACTOR = 'smsfactor';
    case TWILIO = 'twilio';
    case NEXMO = 'nexmo';
    case PLIVO = 'plivo';
    case GAMMU = 'gammu';
    case NETFUN = 'netfun';
    case AGILETELECOM = 'agiletelecom';
}
```

## Metodi di Traduzione

L'enum implementa i seguenti metodi che utilizzano il `TransTrait`:

```php
public function getLabel(): string
{
    return $this->transClass(self::class, $this->value . '.label');
}

public function getColor(): string
{
    return $this->transClass(self::class, $this->value . '.color');
}

public function getIcon(): string
{
    return $this->transClass(self::class, $this->value . '.icon');
}

public function getDescription(): string
{
    return $this->transClass(self::class, $this->value . '.description');
}
```

## File di Traduzione

Le traduzioni sono gestite tramite il file `sms_driver_enum.php` in ogni lingua:

### Struttura File
```
laravel/Modules/Notify/lang/
├── it/sms_driver_enum.php
├── en/sms_driver_enum.php
└── de/sms_driver_enum.php
```

### Formato Traduzioni

Ogni driver ha la seguente struttura:

```php
'smsfactor' => [
    'label' => 'SMSFactor',
    'color' => 'primary',
    'icon' => 'heroicon-o-device-phone-mobile',
    'description' => 'Provider SMS francese con API REST e supporto per messaggi bulk',
],
```

## Driver Supportati

### 1. SMSFactor
- **Label**: SMSFactor
- **Color**: primary
- **Icon**: heroicon-o-device-phone-mobile
- **Description**: Provider SMS francese con API REST e supporto per messaggi bulk

### 2. Twilio
- **Label**: Twilio
- **Color**: success
- **Icon**: heroicon-o-chat-bubble-left-right
- **Description**: Piattaforma cloud per comunicazioni con API robuste e documentazione completa

### 3. Nexmo (Vonage)
- **Label**: Nexmo (Vonage)
- **Color**: warning
- **Icon**: heroicon-o-globe-alt
- **Description**: Provider globale per SMS e comunicazioni con copertura internazionale

### 4. Plivo
- **Label**: Plivo
- **Color**: info
- **Icon**: heroicon-o-phone
- **Description**: Piattaforma per comunicazioni vocali e SMS con API semplici

### 5. Gammu
- **Label**: Gammu
- **Color**: secondary
- **Icon**: heroicon-o-cpu-chip
- **Description**: Libreria open source per gestione modem GSM e invio SMS

### 6. Netfun
- **Label**: Netfun
- **Color**: danger
- **Icon**: heroicon-o-bolt
- **Description**: Provider italiano per SMS con supporto per messaggi promozionali e transazionali

### 7. Agile Telecom
- **Label**: Agile Telecom
- **Color**: gray
- **Icon**: heroicon-o-truck
- **Description**: Provider italiano per servizi di telecomunicazioni e SMS

## Utilizzo in Filament

L'enum può essere utilizzato direttamente nei componenti Filament:

```php
use Modules\Notify\Enums\SmsDriverEnum;

// In un form
Select::make('driver')
    ->options(SmsDriverEnum::class)
    ->required();

// In una tabella
TextColumn::make('driver')
    ->formatStateUsing(fn (SmsDriverEnum $state) => $state->getLabel())
    ->color(fn (SmsDriverEnum $state) => $state->getColor())
    ->icon(fn (SmsDriverEnum $state) => $state->getIcon());
```

## Chiavi di Traduzione

Il `TransTrait` genera automaticamente le seguenti chiavi:

- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.label`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.color`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.icon`
- `Modules\Notify\Enums\SmsDriverEnum::smsfactor.description`

## Aggiunta Nuovi Driver

Per aggiungere un nuovo driver:

1. **Aggiungere il case nell'enum**:
```php
case NUOVO_DRIVER = 'nuovo_driver';
```

2. **Aggiungere le traduzioni** in tutti i file di lingua:
```php
'nuovo_driver' => [
    'label' => 'Nuovo Driver',
    'color' => 'primary',
    'icon' => 'heroicon-o-star',
    'description' => 'Descrizione del nuovo driver',
],
```

3. **Aggiornare la configurazione** in `config/sms.php` se necessario

## Verifica Traduzioni

Per verificare che tutte le traduzioni siano presenti:

```bash

# Verifica sintassi PHP
php -l laravel/Modules/Notify/lang/it/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/en/sms_driver_enum.php
php -l laravel/Modules/Notify/lang/de/sms_driver_enum.php
```

## Collegamenti

- [SmsDriverEnum](../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../config/sms.php)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)
- [SmsDriverEnum](../../../app/Enums/SmsDriverEnum.php)
- [TransTrait](../../Xot/app/Traits/TransTrait.php)
- [Configurazione SMS](../../../config/sms.php)
- [Documentazione Traduzioni](../../../../Lang/docs)- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../../../Lang/docs)

---

## smsriver-selection-specific

*Consolidated from: `smsriver-selection-specific.md`*


## Contesto Specifico
```php
if (! $smsData instanceof SmsData) {
    throw new Exception('toSms method must return an instance of SmsData');
}

$driver = Config::get('sms.default', 'smsfactor');

$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

## Analisi dei Vantaggi (45%)

### 1. Validazione Integrata (20%)
- La validazione del tipo di dato è strettamente correlata alla classe `SmsData`
- Riduce la duplicazione del codice di validazione
- Centralizza la logica di validazione

### 2. Coerenza dei Dati (15%)
- Garantisce che i dati siano sempre validi prima dell'invio
- Riduce il rischio di errori runtime
- Migliora la robustezza del codice

### 3. Manutenibilità (10%)
- Semplifica la gestione delle modifiche alla validazione
- Centralizza la logica di selezione del driver
- Riduce la complessità del canale di notifica

## Analisi degli Svantaggi (55%)

### 1. Violazione del Principio di Responsabilità Singola (25%)
- `SmsData` dovrebbe occuparsi solo della rappresentazione dei dati
- La validazione e selezione del driver sono responsabilità separate
- Aumenta l'accoppiamento tra dati e logica di business

### 2. Complessità Aggiuntiva (15%)
- Aumenta la complessità della classe `SmsData`
- Rende il codice meno intuitivo
- Richiede una documentazione più dettagliata

### 3. Testabilità (10%)
- Rende più difficile il testing isolato
- Complica il mocking delle dipendenze
- Aumenta la complessità dei test unitari

### 4. Flessibilità (5%)
- Limita la possibilità di personalizzare la validazione
- Rende più difficile l'estensione della logica
- Complica l'aggiunta di nuovi driver

## Raccomandazione Finale

Basandosi sull'analisi specifica, la raccomandazione è di **NON** spostare la logica in `SmsData` per i seguenti motivi:

1. La violazione del principio di responsabilità singola è particolarmente critica in questo caso
2. Gli svantaggi superano i vantaggi (55% vs 45%)
3. La complessità aggiuntiva non è giustificata dai benefici

### Soluzione Proposta

Creare un servizio dedicato che gestisca sia la validazione che la selezione del driver:

```php
class SmsService
{
    public function validateAndGetAction($smsData): SendSmsActionInterface
    {
        if (! $smsData instanceof SmsData) {
            throw new Exception('toSms method must return an instance of SmsData');
        }

        $driver = Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

Questa soluzione:
- Mantiene la separazione delle responsabilità
- Centralizza sia la validazione che la selezione del driver
- È più facile da testare e mantenere
- Non viola i principi SOLID
- Mantiene `SmsData` focalizzato sulla sua responsabilità primaria 

---

## smsriver-selection

*Consolidated from: `smsriver-selection.md`*


## Contesto Attuale
Attualmente, la logica di selezione del driver SMS è implementata nel canale di notifica:

```php
$driver = Config::get('sms.default', 'smsfactor');

$action = match ($driver) {
    'smsfactor' => app(SendSmsFactorSMSAction::class),
    'twilio' => app(SendTwilioSMSAction::class),
    'nexmo' => app(SendNexmoSMSAction::class),
    'plivo' => app(SendPlivoSMSAction::class),
    'gammu' => app(SendGammuSMSAction::class),
    'netfun' => app(SendNetfunSMSAction::class),
    default => throw new Exception("Unsupported SMS driver: {$driver}"),
};
```

## Proposta di Modifica
Spostare questa logica all'interno di `SmsData`:

```php
class SmsData extends Data
{
    public function getAction(): SendSmsActionInterface
    {
        $driver = Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

## Analisi dei Vantaggi (60%)

### 1. Incapsulamento (25%)
- La logica di selezione del driver è strettamente correlata ai dati SMS
- Riduce l'accoppiamento tra il canale e i dettagli di implementazione
- Migliora la coesione del codice

### 2. Riutilizzabilità (15%)
- La logica può essere riutilizzata in altri contesti oltre al canale
- Facilita l'implementazione di nuovi punti di invio SMS
- Riduce la duplicazione del codice

### 3. Manutenibilità (10%)
- Centralizza la logica di selezione del driver
- Semplifica le modifiche future alla logica di selezione
- Riduce il rischio di inconsistenze

### 4. Testabilità (10%)
- Facilita il testing isolato della logica di selezione
- Permette di mockare più facilmente l'azione corretta
- Migliora la copertura dei test

## Analisi degli Svantaggi (40%)

### 1. Violazione del Principio di Responsabilità Singola (20%)
- `SmsData` dovrebbe rappresentare solo i dati
- Aggiunge una responsabilità non correlata alla rappresentazione dei dati
- Potrebbe violare il principio di separazione delle preoccupazioni

### 2. Complessità Aggiuntiva (10%)
- Aumenta la complessità della classe `SmsData`
- Potrebbe rendere il codice meno intuitivo
- Richiede una documentazione più dettagliata

### 3. Dipendenze (5%)
- Introduce dipendenze aggiuntive in `SmsData`
- Potrebbe complicare l'inizializzazione dell'oggetto
- Aumenta il rischio di problemi di circolarità

### 4. Flessibilità (5%)
- Potrebbe limitare la flessibilità nella gestione dei driver
- Rende più difficile l'implementazione di logiche di selezione personalizzate
- Potrebbe complicare l'aggiunta di nuovi driver

## Raccomandazione

Basandosi sull'analisi, la raccomandazione è di **NON** spostare la logica di selezione del driver in `SmsData` per i seguenti motivi:

1. La violazione del principio di responsabilità singola è un problema significativo
2. I vantaggi in termini di incapsulamento non giustificano la complessità aggiuntiva
3. La logica di selezione del driver è più appropriata in un servizio dedicato

### Alternativa Proposta

Creare un servizio dedicato per la gestione dei driver:

```php
class SmsDriverService
{
    public function getAction(string $driver = null): SendSmsActionInterface
    {
        $driver = $driver ?? Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}
```

Questa soluzione:
- Mantiene la separazione delle responsabilità
- Centralizza la logica di selezione
- È più facile da testare e mantenere
- Non viola i principi SOLID 

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04