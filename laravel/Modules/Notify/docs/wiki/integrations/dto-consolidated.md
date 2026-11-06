---
qmd: "dto consolidated"
issues: []
discussions: []
title: "dto: Consolidated Documentation"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
updated: 2026-08-24
status: draft
---

# dto: Consolidated Documentation

Consolidated from **11** individual files.

## Table of Contents

- [---](#dto-structure-conventions-1)
- [Convenzioni per la Struttura dei DTO nel Modulo Notify](#dto-structure-conventions)
- [---](#dto-structure-rules-1)
- [Regole per la Struttura dei DTO](#dto-structure-rules)
- [Regole per la Struttura dei DTO](#dto-structure)
- [---](#dto-vs-factory-analysis-1)
- [Analisi: Logica di Selezione del Driver nel DTO vs Factory vs Canale](#dto-vs-factory-analysis)
- [Analisi: Logica di Selezione del Driver nel DTO vs Factory vs Canale](#dto-vs-factory)
- [Convenzioni per la Struttura dei DTO nel Modulo Notify](#dto_structure_conventions)
- [Regole per la Struttura dei DTO](#dto_structure_rules)
- [Analisi: Logica di Selezione del Driver nel DTO vs Factory vs Canale](#dto_vs_factory_analysis)

---

## dto-structure-conventions-1

*Consolidated from: `dto-structure-conventions.md`*

title: "Convenzioni per la Struttura dei DTO nel Modulo Notify"
type: concept
tags: [dto, structure, conventions]
created: 2026-07-14
updated: 2026-07-14
qmd: "dto-structure-conventions-1 convenzioni per la struttura dei dto nel modulo notify"
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

# Convenzioni per la Struttura dei DTO nel Modulo Notify

## Introduzione

Questo documento definisce le convenzioni per la struttura e l'organizzazione dei Data Transfer Objects (DTO) nel modulo Notify. Seguire queste convenzioni è essenziale per mantenere coerenza e prevenire errori.

## Struttura delle Directory

### Directory Principale per i DTO

I DTO nel modulo Notify devono essere collocati nella directory:

```
/Modules/Notify/app/Datas/
```

**IMPORTANTE**: Non utilizzare le directory `/app/Data/` o `/app/DTOs/` per i nuovi DTO.

### Organizzazione dei File

I DTO devono essere posizionati direttamente nella directory `Datas/` e non in sottodirectory, a meno che non sia assolutamente necessario per ragioni di organizzazione.

✅ **Corretto**:
```
/Modules/Notify/app/Datas/NetfunSmsData.php
/Modules/Notify/app/Datas/NetfunSmsRequestData.php
/Modules/Notify/app/Datas/NetfunSmsResponseData.php
```

❌ **Errato**:
```
/Modules/Notify/app/Data/NetfunSmsData.php
/Modules/Notify/app/DTOs/NetfunSmsData.php
/Modules/Notify/app/Datas/SMS/NetfunSmsData.php
```

## Convenzioni di Nomenclatura

### Naming dei File

I file DTO devono seguire la convenzione di nomenclatura PascalCase con il suffisso `Data`:

✅ **Corretto**:
```
NetfunSmsData.php
EmailData.php
NotificationData.php
```

❌ **Errato**:
```
netfun_sms_data.php
NetfunSMS.php
Netfun.php
```

### Namespace

Il namespace dei DTO deve essere:

```php
namespace Modules\Notify\Datas;
```

**IMPORTANTE**: Non utilizzare namespace come `Modules\Notify\Data` o `Modules\Notify\DTOs`.

## Implementazione dei DTO

### Proprietà Readonly

Utilizzare sempre proprietà readonly per i DTO in PHP 8.2+:

```php
readonly class NetfunSmsData
{
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        // ...
    ) {}
}
```

### Tipi Rigorosi

Specificare sempre i tipi per tutte le proprietà e utilizzare tipi nullable quando appropriato:

```php
public string $recipient,       // Obbligatorio
public ?string $sender = null,  // Opzionale
```

### Documentazione

Ogni DTO deve includere PHPDoc completo:

```php
/**
 * DTO per i dati di richiesta SMS Netfun
 */
readonly class NetfunSmsRequestData
{
    /**
     * @param string $recipient Numero di telefono del destinatario
     * @param string $message Testo del messaggio
     * @param string|null $sender Mittente (opzionale)
     */
    public function __construct(
        // ...
    ) {}
}
```

## Esempi di DTO Corretti

### NetfunSmsData

```php
<?php

namespace Modules\Notify\Datas;

/**
 * DTO per i dati SMS Netfun
 */
readonly class NetfunSmsData
{
    /**
     * @param string $recipient Numero di telefono del destinatario
     * @param string $message Testo del messaggio
     * @param string|null $sender Mittente (opzionale)
     * @param string|null $reference Riferimento univoco (opzionale)
     * @param string|null $scheduledDate Data pianificata di invio (opzionale)
     */
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        public ?string $reference = null,
        public ?string $scheduledDate = null,
    ) {}
}
```

## Checklist di Verifica

Prima di creare un nuovo DTO, verificare che:

- [ ] Il file sia posizionato nella directory corretta (`/Modules/Notify/app/Datas/`)
- [ ] Il nome del file segua la convenzione PascalCase con suffisso `Data`
- [ ] Il namespace sia corretto (`Modules\Notify\Datas`)
- [ ] Le proprietà siano readonly e tipizzate correttamente
- [ ] La documentazione PHPDoc sia completa e accurata

## Riferimenti

- [PHP 8.2 Readonly Properties](https://www.php.net/manual/en/language.oop5.properties.php#language.oop5.properties.readonly-properties)
- [Laravel Data Transfer Objects Best Practices](https://laravel.com/docs/10.x/eloquent-serialization#data-transfer-objects)

---

*Ultimo aggiornamento: 2025-05-12*
*Ultimo aggiornamento: 2025-05-12*
---

## dto-structure-conventions

*Consolidated from: `dto-structure-conventions.md`*


## Introduzione

Questo documento definisce le convenzioni per la struttura e l'organizzazione dei Data Transfer Objects (DTO) nel modulo Notify. Seguire queste convenzioni è essenziale per mantenere coerenza e prevenire errori.

## Struttura delle Directory

### Directory Principale per i DTO

I DTO nel modulo Notify devono essere collocati nella directory:

```
/Modules/Notify/app/Datas/
```

**IMPORTANTE**: Non utilizzare le directory `/app/Data/` o `/app/DTOs/` per i nuovi DTO.

### Organizzazione dei File

I DTO devono essere posizionati direttamente nella directory `Datas/` e non in sottodirectory, a meno che non sia assolutamente necessario per ragioni di organizzazione.

✅ **Corretto**:
```
/Modules/Notify/app/Datas/NetfunSmsData.php
/Modules/Notify/app/Datas/NetfunSmsRequestData.php
/Modules/Notify/app/Datas/NetfunSmsResponseData.php
```

❌ **Errato**:
```
/Modules/Notify/app/Data/NetfunSmsData.php
/Modules/Notify/app/DTOs/NetfunSmsData.php
/Modules/Notify/app/Datas/SMS/NetfunSmsData.php
```

## Convenzioni di Nomenclatura

### Naming dei File

I file DTO devono seguire la convenzione di nomenclatura PascalCase con il suffisso `Data`:

✅ **Corretto**:
```
NetfunSmsData.php
EmailData.php
NotificationData.php
```

❌ **Errato**:
```
netfun_sms_data.php
NetfunSMS.php
Netfun.php
```

### Namespace

Il namespace dei DTO deve essere:

```php
namespace Modules\Notify\Datas;
```

**IMPORTANTE**: Non utilizzare namespace come `Modules\Notify\Data` o `Modules\Notify\DTOs`.

## Implementazione dei DTO

### Proprietà Readonly

Utilizzare sempre proprietà readonly per i DTO in PHP 8.2+:

```php
readonly class NetfunSmsData
{
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        // ...
    ) {}
}
```

### Tipi Rigorosi

Specificare sempre i tipi per tutte le proprietà e utilizzare tipi nullable quando appropriato:

```php
public string $recipient,       // Obbligatorio
public ?string $sender = null,  // Opzionale
```

### Documentazione

Ogni DTO deve includere PHPDoc completo:

```php
/**
 * DTO per i dati di richiesta SMS Netfun
 */
readonly class NetfunSmsRequestData
{
    /**
     * @param string $recipient Numero di telefono del destinatario
     * @param string $message Testo del messaggio
     * @param string|null $sender Mittente (opzionale)
     */
    public function __construct(
        // ...
    ) {}
}
```

## Esempi di DTO Corretti

### NetfunSmsData

```php
<?php

namespace Modules\Notify\Datas;

/**
 * DTO per i dati SMS Netfun
 */
readonly class NetfunSmsData
{
    /**
     * @param string $recipient Numero di telefono del destinatario
     * @param string $message Testo del messaggio
     * @param string|null $sender Mittente (opzionale)
     * @param string|null $reference Riferimento univoco (opzionale)
     * @param string|null $scheduledDate Data pianificata di invio (opzionale)
     */
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        public ?string $reference = null,
        public ?string $scheduledDate = null,
    ) {}
}
```

## Checklist di Verifica

Prima di creare un nuovo DTO, verificare che:

- [ ] Il file sia posizionato nella directory corretta (`/Modules/Notify/app/Datas/`)
- [ ] Il nome del file segua la convenzione PascalCase con suffisso `Data`
- [ ] Il namespace sia corretto (`Modules\Notify\Datas`)
- [ ] Le proprietà siano readonly e tipizzate correttamente
- [ ] La documentazione PHPDoc sia completa e accurata

## Riferimenti

- [PHP 8.2 Readonly Properties](https://www.php.net/manual/en/language.oop5.properties.php#language.oop5.properties.readonly-properties)
- [Laravel Data Transfer Objects Best Practices](https://laravel.com/docs/10.x/eloquent-serialization#data-transfer-objects)

---

*Ultimo aggiornamento: [DATE]*

---

## dto-structure-rules-1

*Consolidated from: `dto-structure-rules.md`*

title: "Regole per la Struttura dei DTO"
type: rule
tags: [dto, structure, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "dto-structure-rules-1 regole per la struttura dei dto"
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

# Regole per la Struttura dei DTO

## Directory e Namespace

1. **Directory**
   - Usare SEMPRE `app/Datas` (plurale)
   - NON usare mai `Data` (singolare)
   - NON usare mai `DTOs`
   - Mantenere la directory minuscola

2. **Namespace**
   - Usare `Modules\Notify\Datas`
   - NON usare `App\Datas`
   - NON usare `Modules\Notify\App\Datas`
   - Mantenere coerenza con la struttura delle directory

## Naming e Struttura

1. **Naming dei File**
   - Usare il suffisso `Data` per i DTO
   - Esempio: `NetfunSmsRequestData.php`
   - NON usare `DTO` o altri suffissi

2. **Naming delle Classi**
   - Coincidere con il nome del file
   - Usare PascalCase
   - Esempio: `class NetfunSmsRequestData`

3. **Struttura delle Classi**
   - Estendere `Spatie\LaravelData\Data`
   - Usare type hints per tutte le proprietà
   - Usare constructor property promotion
   - Documentare con PHPDoc

## Best Practices

1. **Tipizzazione**
   - Usare type hints per tutte le proprietà
   - Usare tipi nullable quando appropriato
   - Documentare i tipi con PHPDoc

2. **Validazione**
   - Implementare regole di validazione
   - Usare spatie/laravel-data per la validazione
   - Validare i dati in ingresso

3. **Documentazione**
   - Documentare ogni DTO
   - Documentare le proprietà
   - Documentare i metodi
   - Mantenere la documentazione aggiornata

## Checklist di Verifica

1. **Directory**
   - [ ] La directory è `app/Datas` (plurale)
   - [ ] La directory è minuscola
   - [ ] Non ci sono directory `Data` o `DTOs`

2. **Namespace**
   - [ ] Il namespace è `Modules\Notify\Datas`
   - [ ] Non ci sono namespace errati

3. **Naming**
   - [ ] Il file usa il suffisso `Data`
   - [ ] La classe usa PascalCase
   - [ ] Il nome della classe coincide con il file

4. **Struttura**
   - [ ] La classe estende `Spatie\LaravelData\Data`
   - [ ] Usa type hints
   - [ ] Usa constructor property promotion
   - [ ] Ha PHPDoc

5. **Validazione**
   - [ ] Implementa regole di validazione
   - [ ] Usa spatie/laravel-data
   - [ ] Valida i dati in ingresso

## Esempi di Errori Comuni

1. **Directory Errate**
   ```php
   // ERRATO
   app/Data/NetfunSmsRequestData.php
   app/DTOs/NetfunSmsRequestData.php
   
   // CORRETTO
   app/Datas/NetfunSmsRequestData.php
   ```

2. **Namespace Errati**
   ```php
   // ERRATO
   namespace App\Datas;
   namespace Modules\Notify\App\Datas;
   
   // CORRETTO
   namespace Modules\Notify\Datas;
   ```

3. **Naming Errato**
   ```php
   // ERRATO
   class NetfunSmsRequestDTO
   class NetfunSmsRequest
   
   // CORRETTO
   class NetfunSmsRequestData
   ```

## Riferimenti

- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [spatie/laravel-data](https://github.com/spatie/laravel-data)
- [Laravel Best Practices](https://laravel.com/docs/best-practices) 

---

## dto-structure-rules

*Consolidated from: `dto-structure-rules.md`*


## Directory e Namespace

1. **Directory**
   - Usare SEMPRE `app/Datas` (plurale)
   - NON usare mai `Data` (singolare)
   - NON usare mai `DTOs`
   - Mantenere la directory minuscola

2. **Namespace**
   - Usare `Modules\Notify\Datas`
   - NON usare `App\Datas`
   - NON usare `Modules\Notify\App\Datas`
   - Mantenere coerenza con la struttura delle directory

## Naming e Struttura

1. **Naming dei File**
   - Usare il suffisso `Data` per i DTO
   - Esempio: `NetfunSmsRequestData.php`
   - NON usare `DTO` o altri suffissi

2. **Naming delle Classi**
   - Coincidere con il nome del file
   - Usare PascalCase
   - Esempio: `class NetfunSmsRequestData`

3. **Struttura delle Classi**
   - Estendere `Spatie\LaravelData\Data`
   - Usare type hints per tutte le proprietà
   - Usare constructor property promotion
   - Documentare con PHPDoc

## Best Practices

1. **Tipizzazione**
   - Usare type hints per tutte le proprietà
   - Usare tipi nullable quando appropriato
   - Documentare i tipi con PHPDoc

2. **Validazione**
   - Implementare regole di validazione
   - Usare spatie/laravel-data per la validazione
   - Validare i dati in ingresso

3. **Documentazione**
   - Documentare ogni DTO
   - Documentare le proprietà
   - Documentare i metodi
   - Mantenere la documentazione aggiornata

## Checklist di Verifica

1. **Directory**
   - [ ] La directory è `app/Datas` (plurale)
   - [ ] La directory è minuscola
   - [ ] Non ci sono directory `Data` o `DTOs`

2. **Namespace**
   - [ ] Il namespace è `Modules\Notify\Datas`
   - [ ] Non ci sono namespace errati

3. **Naming**
   - [ ] Il file usa il suffisso `Data`
   - [ ] La classe usa PascalCase
   - [ ] Il nome della classe coincide con il file

4. **Struttura**
   - [ ] La classe estende `Spatie\LaravelData\Data`
   - [ ] Usa type hints
   - [ ] Usa constructor property promotion
   - [ ] Ha PHPDoc

5. **Validazione**
   - [ ] Implementa regole di validazione
   - [ ] Usa spatie/laravel-data
   - [ ] Valida i dati in ingresso

## Esempi di Errori Comuni

1. **Directory Errate**
   ```php
   // ERRATO
   app/Data/NetfunSmsRequestData.php
   app/DTOs/NetfunSmsRequestData.php
   
   // CORRETTO
   app/Datas/NetfunSmsRequestData.php
   ```

2. **Namespace Errati**
   ```php
   // ERRATO
   namespace App\Datas;
   namespace Modules\Notify\App\Datas;
   
   // CORRETTO
   namespace Modules\Notify\Datas;
   ```

3. **Naming Errato**
   ```php
   // ERRATO
   class NetfunSmsRequestDTO
   class NetfunSmsRequest
   
   // CORRETTO
   class NetfunSmsRequestData
   ```

## Riferimenti

- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [spatie/laravel-data](https://github.com/spatie/laravel-data)
- [Laravel Best Practices](https://laravel.com/docs/best-practices) 

---

## dto-structure

*Consolidated from: `dto-structure.md`*


## Directory e Namespace

1. **Directory**
   - Usare SEMPRE `app/Datas` (plurale)
   - NON usare mai `Data` (singolare)
   - NON usare mai `DTOs`
   - Mantenere la directory minuscola

2. **Namespace**
   - Usare `Modules\Notify\Datas`
   - NON usare `App\Datas`
   - NON usare `Modules\Notify\App\Datas`
   - Mantenere coerenza con la struttura delle directory

## Naming e Struttura

1. **Naming dei File**
   - Usare il suffisso `Data` per i DTO
   - Esempio: `NetfunSmsRequestData.php`
   - NON usare `DTO` o altri suffissi

2. **Naming delle Classi**
   - Coincidere con il nome del file
   - Usare PascalCase
   - Esempio: `class NetfunSmsRequestData`

3. **Struttura delle Classi**
   - Estendere `Spatie\LaravelData\Data`
   - Usare type hints per tutte le proprietà
   - Usare constructor property promotion
   - Documentare con PHPDoc

## Best Practices

1. **Tipizzazione**
   - Usare type hints per tutte le proprietà
   - Usare tipi nullable quando appropriato
   - Documentare i tipi con PHPDoc

2. **Validazione**
   - Implementare regole di validazione
   - Usare spatie/laravel-data per la validazione
   - Validare i dati in ingresso

3. **Documentazione**
   - Documentare ogni DTO
   - Documentare le proprietà
   - Documentare i metodi
   - Mantenere la documentazione aggiornata

## Checklist di Verifica

1. **Directory**
   - [ ] La directory è `app/Datas` (plurale)
   - [ ] La directory è minuscola
   - [ ] Non ci sono directory `Data` o `DTOs`

2. **Namespace**
   - [ ] Il namespace è `Modules\Notify\Datas`
   - [ ] Non ci sono namespace errati

3. **Naming**
   - [ ] Il file usa il suffisso `Data`
   - [ ] La classe usa PascalCase
   - [ ] Il nome della classe coincide con il file

4. **Struttura**
   - [ ] La classe estende `Spatie\LaravelData\Data`
   - [ ] Usa type hints
   - [ ] Usa constructor property promotion
   - [ ] Ha PHPDoc

5. **Validazione**
   - [ ] Implementa regole di validazione
   - [ ] Usa spatie/laravel-data
   - [ ] Valida i dati in ingresso

## Esempi di Errori Comuni

1. **Directory Errate**
   ```php
   // ERRATO
   app/Data/NetfunSmsRequestData.php
   app/DTOs/NetfunSmsRequestData.php
   
   // CORRETTO
   app/Datas/NetfunSmsRequestData.php
   ```

2. **Namespace Errati**
   ```php
   // ERRATO
   namespace App\Datas;
   namespace Modules\Notify\App\Datas;
   
   // CORRETTO
   namespace Modules\Notify\Datas;
   ```

3. **Naming Errato**
   ```php
   // ERRATO
   class NetfunSmsRequestDTO
   class NetfunSmsRequest
   
   // CORRETTO
   class NetfunSmsRequestData
   ```

## Riferimenti

- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [spatie/laravel-data](https://github.com/spatie/laravel-data)
- [Laravel Best Practices](https://laravel.com/docs/best-practices) 

---

## dto-vs-factory-analysis-1

*Consolidated from: `dto-vs-factory-analysis.md`*

title: "Analisi: Logica di Selezione del Driver nel DTO vs Factory vs Canale"
type: concept
tags: [dto, factory, analysis]
created: 2026-07-14
updated: 2026-07-14
qmd: "dto-vs-factory-analysis-1 analisi: logica di selezione del driver nel dto vs factory vs canale"
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

# Analisi: Logica di Selezione del Driver nel DTO vs Factory vs Canale

Questo documento analizza in dettaglio i vantaggi e gli svantaggi di posizionare la logica di selezione del driver SMS all'interno del DTO `SmsData`, confrontando questo approccio con il pattern Factory implementato e con l'approccio originale (nel canale).

## Opzione 1: Logica nel DTO (SmsData)

```php
// In SmsData.php
class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
    
    public function getAction(): SmsActionInterface
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

// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    $action = $smsData->getAction();
    return $action->execute($smsData);
}
```

### Vantaggi (40%)

1. **Incapsulamento (15%)**: Il DTO incapsula non solo i dati ma anche la logica per ottenere l'azione appropriata, seguendo il principio di information hiding.

2. **Riutilizzabilità diretta (15%)**: Ovunque si utilizzi un'istanza di `SmsData`, è possibile ottenere direttamente l'azione corrispondente senza dipendenze aggiuntive:
   ```php
   $smsData = new SmsData(...);
   $result = $smsData->getAction()->execute($smsData);
   ```

3. **Semplificazione del canale (5%)**: Il canale diventa più semplice e focalizzato solo sulla gestione della notifica, con meno responsabilità.

4. **Riduzione delle dipendenze esplicite (5%)**: Non è necessario iniettare dipendenze aggiuntive nel canale o in altri componenti che utilizzano `SmsData`.

### Svantaggi (60%)

1. **Violazione del principio di Responsabilità Singola (25%)**: Il DTO assume due responsabilità distinte:
   - Contenere i dati del messaggio SMS
   - Selezionare l'implementazione dell'azione appropriata
   
   Questo viola il principio SRP, che stabilisce che una classe dovrebbe avere una sola ragione per cambiare.

2. **Accoppiamento con la configurazione del sistema (15%)**: Il DTO dipende direttamente dalla configurazione dell'applicazione (`Config::get()`), rendendo più difficile il suo utilizzo in contesti diversi (ad esempio, test unitari o ambienti isolati).

3. **Difficoltà di override del driver (10%)**: Diventa complesso sovrascrivere il driver predefinito in contesti specifici, poiché la logica è incapsulata nel DTO.

4. **Incoerenza con il pattern DTO (10%)**: I DTO sono generalmente strutture passive che contengono solo dati, non logica di business. Questo approccio viola questa convenzione.

## Opzione 2: Pattern Factory (Implementato)

```php
// In SmsActionFactory.php
class SmsActionFactory
{
    public function create(?string $driver = null): SmsActionInterface
    {
        $driver = $driver ?? Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            // altri driver...
        };
    }
}

// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    $action = $this->factory->create();
    return $action->execute($smsData);
}
```

### Vantaggi (75%)

1. **Separazione delle responsabilità (25%)**: Ogni componente ha una responsabilità chiara:
   - DTO: Contenere i dati
   - Factory: Creare le azioni
   - Canale: Gestire le notifiche
   - Azione: Implementare la logica di invio

2. **Riutilizzabilità con flessibilità (20%)**: La factory può essere iniettata e utilizzata ovunque, con la possibilità di override del driver:
   ```php
   $action = $factory->create('twilio'); // Usa specificamente Twilio
   ```

3. **Testabilità (15%)**: Facilità nei test unitari grazie alla possibilità di mockare la factory:
   ```php
   $factoryMock->shouldReceive('create')->andReturn($actionMock);
   ```

4. **Estensibilità (10%)**: Nuovi driver possono essere aggiunti modificando solo la factory, senza impattare i DTO o i canali.

5. **Coerenza con i pattern di design (5%)**: Segue il pattern Factory, ampiamente riconosciuto e utilizzato.

### Svantaggi (25%)

1. **Complessità aggiuntiva (15%)**: Introduce una classe aggiuntiva nel sistema (la factory).

2. **Overhead di dependency injection (5%)**: Richiede l'iniezione della factory nei componenti che la utilizzano.

3. **Indirezione (5%)**: Aggiunge un livello di indirezione che potrebbe rendere il flusso di esecuzione meno immediato da seguire.

## Opzione 3: Logica nel Canale (Originale)

```php
// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    
    $driver = Config::get('sms.default', 'smsfactor');
    
    $action = match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
    
    return $action->execute($smsData);
}
```

### Vantaggi (55%)

1. **Semplicità (20%)**: Approccio diretto senza classi aggiuntive.

2. **Coerenza con Laravel (15%)**: Questo approccio è simile a come Laravel gestisce i driver in componenti come Mail, Queue, ecc.

3. **Centralizzazione della logica di routing (10%)**: Tutta la logica di routing è in un unico posto, rendendo più facile la comprensione del flusso.

4. **Minore overhead iniziale (10%)**: Non richiede la creazione di classi factory aggiuntive.

### Svantaggi (45%)

1. **Accoppiamento tra canale e azioni (15%)**: Il canale deve conoscere tutte le implementazioni concrete delle azioni.

2. **Duplicazione della logica (15%)**: Se la stessa logica di selezione è necessaria altrove, dovrà essere duplicata.

3. **Difficoltà nei test (10%)**: Testare il canale richiede di mockare tutte le dipendenze delle azioni.

4. **Responsabilità mista (5%)**: Il canale ha la responsabilità sia di gestire la notifica che di selezionare l'implementazione appropriata.

## Confronto Percentuale Complessivo

| Aspetto | DTO | Factory | Canale |
|---------|-----|---------|--------|
| **Vantaggi** | 40% | 75% | 55% |
| **Svantaggi** | 60% | 25% | 45% |
| **Bilancio** | -20% | +50% | +10% |

## Conclusione

Basandoci sull'analisi percentuale:

1. **Pattern Factory (Implementato)**: Offre il miglior equilibrio con un bilancio positivo del 50%, grazie alla chiara separazione delle responsabilità, riutilizzabilità e testabilità.

2. **Logica nel Canale (Originale)**: Ha un bilancio positivo del 10%, offrendo semplicità e coerenza con Laravel, ma con limitazioni in termini di riutilizzabilità e accoppiamento.

3. **Logica nel DTO**: Ha un bilancio negativo del 20%, principalmente a causa della violazione del principio di Responsabilità Singola e dell'accoppiamento con la configurazione.

**Raccomandazione finale**: Il pattern Factory implementato rappresenta la soluzione migliore, offrendo un equilibrio ottimale tra separazione delle responsabilità, riutilizzabilità, testabilità ed estensibilità, con svantaggi minimi in termini di complessità aggiuntiva.

---

## dto-vs-factory-analysis

*Consolidated from: `dto-vs-factory-analysis.md`*


Questo documento analizza in dettaglio i vantaggi e gli svantaggi di posizionare la logica di selezione del driver SMS all'interno del DTO `SmsData`, confrontando questo approccio con il pattern Factory implementato e con l'approccio originale (nel canale).

## Opzione 1: Logica nel DTO (SmsData)

```php
// In SmsData.php
class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
    
    public function getAction(): SmsActionInterface
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

// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    $action = $smsData->getAction();
    return $action->execute($smsData);
}
```

### Vantaggi (40%)

1. **Incapsulamento (15%)**: Il DTO incapsula non solo i dati ma anche la logica per ottenere l'azione appropriata, seguendo il principio di information hiding.

2. **Riutilizzabilità diretta (15%)**: Ovunque si utilizzi un'istanza di `SmsData`, è possibile ottenere direttamente l'azione corrispondente senza dipendenze aggiuntive:
   ```php
   $smsData = new SmsData(...);
   $result = $smsData->getAction()->execute($smsData);
   ```

3. **Semplificazione del canale (5%)**: Il canale diventa più semplice e focalizzato solo sulla gestione della notifica, con meno responsabilità.

4. **Riduzione delle dipendenze esplicite (5%)**: Non è necessario iniettare dipendenze aggiuntive nel canale o in altri componenti che utilizzano `SmsData`.

### Svantaggi (60%)

1. **Violazione del principio di Responsabilità Singola (25%)**: Il DTO assume due responsabilità distinte:
   - Contenere i dati del messaggio SMS
   - Selezionare l'implementazione dell'azione appropriata
   
   Questo viola il principio SRP, che stabilisce che una classe dovrebbe avere una sola ragione per cambiare.

2. **Accoppiamento con la configurazione del sistema (15%)**: Il DTO dipende direttamente dalla configurazione dell'applicazione (`Config::get()`), rendendo più difficile il suo utilizzo in contesti diversi (ad esempio, test unitari o ambienti isolati).

3. **Difficoltà di override del driver (10%)**: Diventa complesso sovrascrivere il driver predefinito in contesti specifici, poiché la logica è incapsulata nel DTO.

4. **Incoerenza con il pattern DTO (10%)**: I DTO sono generalmente strutture passive che contengono solo dati, non logica di business. Questo approccio viola questa convenzione.

## Opzione 2: Pattern Factory (Implementato)

```php
// In SmsActionFactory.php
class SmsActionFactory
{
    public function create(?string $driver = null): SmsActionInterface
    {
        $driver = $driver ?? Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            // altri driver...
        };
    }
}

// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    $action = $this->factory->create();
    return $action->execute($smsData);
}
```

### Vantaggi (75%)

1. **Separazione delle responsabilità (25%)**: Ogni componente ha una responsabilità chiara:
   - DTO: Contenere i dati
   - Factory: Creare le azioni
   - Canale: Gestire le notifiche
   - Azione: Implementare la logica di invio

2. **Riutilizzabilità con flessibilità (20%)**: La factory può essere iniettata e utilizzata ovunque, con la possibilità di override del driver:
   ```php
   $action = $factory->create('twilio'); // Usa specificamente Twilio
   ```

3. **Testabilità (15%)**: Facilità nei test unitari grazie alla possibilità di mockare la factory:
   ```php
   $factoryMock->shouldReceive('create')->andReturn($actionMock);
   ```

4. **Estensibilità (10%)**: Nuovi driver possono essere aggiunti modificando solo la factory, senza impattare i DTO o i canali.

5. **Coerenza con i pattern di design (5%)**: Segue il pattern Factory, ampiamente riconosciuto e utilizzato.

### Svantaggi (25%)

1. **Complessità aggiuntiva (15%)**: Introduce una classe aggiuntiva nel sistema (la factory).

2. **Overhead di dependency injection (5%)**: Richiede l'iniezione della factory nei componenti che la utilizzano.

3. **Indirezione (5%)**: Aggiunge un livello di indirezione che potrebbe rendere il flusso di esecuzione meno immediato da seguire.

## Opzione 3: Logica nel Canale (Originale)

```php
// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    
    $driver = Config::get('sms.default', 'smsfactor');
    
    $action = match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
    
    return $action->execute($smsData);
}
```

### Vantaggi (55%)

1. **Semplicità (20%)**: Approccio diretto senza classi aggiuntive.

2. **Coerenza con Laravel (15%)**: Questo approccio è simile a come Laravel gestisce i driver in componenti come Mail, Queue, ecc.

3. **Centralizzazione della logica di routing (10%)**: Tutta la logica di routing è in un unico posto, rendendo più facile la comprensione del flusso.

4. **Minore overhead iniziale (10%)**: Non richiede la creazione di classi factory aggiuntive.

### Svantaggi (45%)

1. **Accoppiamento tra canale e azioni (15%)**: Il canale deve conoscere tutte le implementazioni concrete delle azioni.

2. **Duplicazione della logica (15%)**: Se la stessa logica di selezione è necessaria altrove, dovrà essere duplicata.

3. **Difficoltà nei test (10%)**: Testare il canale richiede di mockare tutte le dipendenze delle azioni.

4. **Responsabilità mista (5%)**: Il canale ha la responsabilità sia di gestire la notifica che di selezionare l'implementazione appropriata.

## Confronto Percentuale Complessivo

| Aspetto | DTO | Factory | Canale |
|---------|-----|---------|--------|
| **Vantaggi** | 40% | 75% | 55% |
| **Svantaggi** | 60% | 25% | 45% |
| **Bilancio** | -20% | +50% | +10% |

## Conclusione

Basandoci sull'analisi percentuale:

1. **Pattern Factory (Implementato)**: Offre il miglior equilibrio con un bilancio positivo del 50%, grazie alla chiara separazione delle responsabilità, riutilizzabilità e testabilità.

2. **Logica nel Canale (Originale)**: Ha un bilancio positivo del 10%, offrendo semplicità e coerenza con Laravel, ma con limitazioni in termini di riutilizzabilità e accoppiamento.

3. **Logica nel DTO**: Ha un bilancio negativo del 20%, principalmente a causa della violazione del principio di Responsabilità Singola e dell'accoppiamento con la configurazione.

**Raccomandazione finale**: Il pattern Factory implementato rappresenta la soluzione migliore, offrendo un equilibrio ottimale tra separazione delle responsabilità, riutilizzabilità, testabilità ed estensibilità, con svantaggi minimi in termini di complessità aggiuntiva.

---

## dto-vs-factory

*Consolidated from: `dto-vs-factory.md`*


Questo documento analizza in dettaglio i vantaggi e gli svantaggi di posizionare la logica di selezione del driver SMS all'interno del DTO `SmsData`, confrontando questo approccio con il pattern Factory implementato e con l'approccio originale (nel canale).

## Opzione 1: Logica nel DTO (SmsData)

```php
// In SmsData.php
class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
    
    public function getAction(): SmsActionInterface
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

// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    $action = $smsData->getAction();
    return $action->execute($smsData);
}
```

### Vantaggi (40%)

1. **Incapsulamento (15%)**: Il DTO incapsula non solo i dati ma anche la logica per ottenere l'azione appropriata, seguendo il principio di information hiding.

2. **Riutilizzabilità diretta (15%)**: Ovunque si utilizzi un'istanza di `SmsData`, è possibile ottenere direttamente l'azione corrispondente senza dipendenze aggiuntive:
   ```php
   $smsData = new SmsData(...);
   $result = $smsData->getAction()->execute($smsData);
   ```

3. **Semplificazione del canale (5%)**: Il canale diventa più semplice e focalizzato solo sulla gestione della notifica, con meno responsabilità.

4. **Riduzione delle dipendenze esplicite (5%)**: Non è necessario iniettare dipendenze aggiuntive nel canale o in altri componenti che utilizzano `SmsData`.

### Svantaggi (60%)

1. **Violazione del principio di Responsabilità Singola (25%)**: Il DTO assume due responsabilità distinte:
   - Contenere i dati del messaggio SMS
   - Selezionare l'implementazione dell'azione appropriata
   
   Questo viola il principio SRP, che stabilisce che una classe dovrebbe avere una sola ragione per cambiare.

2. **Accoppiamento con la configurazione del sistema (15%)**: Il DTO dipende direttamente dalla configurazione dell'applicazione (`Config::get()`), rendendo più difficile il suo utilizzo in contesti diversi (ad esempio, test unitari o ambienti isolati).

3. **Difficoltà di override del driver (10%)**: Diventa complesso sovrascrivere il driver predefinito in contesti specifici, poiché la logica è incapsulata nel DTO.

4. **Incoerenza con il pattern DTO (10%)**: I DTO sono generalmente strutture passive che contengono solo dati, non logica di business. Questo approccio viola questa convenzione.

## Opzione 2: Pattern Factory (Implementato)

```php
// In SmsActionFactory.php
class SmsActionFactory
{
    public function create(?string $driver = null): SmsActionInterface
    {
        $driver = $driver ?? Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            // altri driver...
        };
    }
}

// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    $action = $this->factory->create();
    return $action->execute($smsData);
}
```

### Vantaggi (75%)

1. **Separazione delle responsabilità (25%)**: Ogni componente ha una responsabilità chiara:
   - DTO: Contenere i dati
   - Factory: Creare le azioni
   - Canale: Gestire le notifiche
   - Azione: Implementare la logica di invio

2. **Riutilizzabilità con flessibilità (20%)**: La factory può essere iniettata e utilizzata ovunque, con la possibilità di override del driver:
   ```php
   $action = $factory->create('twilio'); // Usa specificamente Twilio
   ```

3. **Testabilità (15%)**: Facilità nei test unitari grazie alla possibilità di mockare la factory:
   ```php
   $factoryMock->shouldReceive('create')->andReturn($actionMock);
   ```

4. **Estensibilità (10%)**: Nuovi driver possono essere aggiunti modificando solo la factory, senza impattare i DTO o i canali.

5. **Coerenza con i pattern di design (5%)**: Segue il pattern Factory, ampiamente riconosciuto e utilizzato.

### Svantaggi (25%)

1. **Complessità aggiuntiva (15%)**: Introduce una classe aggiuntiva nel sistema (la factory).

2. **Overhead di dependency injection (5%)**: Richiede l'iniezione della factory nei componenti che la utilizzano.

3. **Indirezione (5%)**: Aggiunge un livello di indirezione che potrebbe rendere il flusso di esecuzione meno immediato da seguire.

## Opzione 3: Logica nel Canale (Originale)

```php
// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    
    $driver = Config::get('sms.default', 'smsfactor');
    
    $action = match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
    
    return $action->execute($smsData);
}
```

### Vantaggi (55%)

1. **Semplicità (20%)**: Approccio diretto senza classi aggiuntive.

2. **Coerenza con Laravel (15%)**: Questo approccio è simile a come Laravel gestisce i driver in componenti come Mail, Queue, ecc.

3. **Centralizzazione della logica di routing (10%)**: Tutta la logica di routing è in un unico posto, rendendo più facile la comprensione del flusso.

4. **Minore overhead iniziale (10%)**: Non richiede la creazione di classi factory aggiuntive.

### Svantaggi (45%)

1. **Accoppiamento tra canale e azioni (15%)**: Il canale deve conoscere tutte le implementazioni concrete delle azioni.

2. **Duplicazione della logica (15%)**: Se la stessa logica di selezione è necessaria altrove, dovrà essere duplicata.

3. **Difficoltà nei test (10%)**: Testare il canale richiede di mockare tutte le dipendenze delle azioni.

4. **Responsabilità mista (5%)**: Il canale ha la responsabilità sia di gestire la notifica che di selezionare l'implementazione appropriata.

## Confronto Percentuale Complessivo

| Aspetto | DTO | Factory | Canale |
|---------|-----|---------|--------|
| **Vantaggi** | 40% | 75% | 55% |
| **Svantaggi** | 60% | 25% | 45% |
| **Bilancio** | -20% | +50% | +10% |

## Conclusione

Basandoci sull'analisi percentuale:

1. **Pattern Factory (Implementato)**: Offre il miglior equilibrio con un bilancio positivo del 50%, grazie alla chiara separazione delle responsabilità, riutilizzabilità e testabilità.

2. **Logica nel Canale (Originale)**: Ha un bilancio positivo del 10%, offrendo semplicità e coerenza con Laravel, ma con limitazioni in termini di riutilizzabilità e accoppiamento.

3. **Logica nel DTO**: Ha un bilancio negativo del 20%, principalmente a causa della violazione del principio di Responsabilità Singola e dell'accoppiamento con la configurazione.

**Raccomandazione finale**: Il pattern Factory implementato rappresenta la soluzione migliore, offrendo un equilibrio ottimale tra separazione delle responsabilità, riutilizzabilità, testabilità ed estensibilità, con svantaggi minimi in termini di complessità aggiuntiva.

---

## dto_structure_conventions

*Consolidated from: `dto_structure_conventions.md`*


## Introduzione

Questo documento definisce le convenzioni per la struttura e l'organizzazione dei Data Transfer Objects (DTO) nel modulo Notify. Seguire queste convenzioni è essenziale per mantenere coerenza e prevenire errori.

## Struttura delle Directory

### Directory Principale per i DTO

I DTO nel modulo Notify devono essere collocati nella directory:

```
/Modules/Notify/app/Datas/
```

**IMPORTANTE**: Non utilizzare le directory `/app/Data/` o `/app/DTOs/` per i nuovi DTO.

### Organizzazione dei File

I DTO devono essere posizionati direttamente nella directory `Datas/` e non in sottodirectory, a meno che non sia assolutamente necessario per ragioni di organizzazione.

✅ **Corretto**:
```
/Modules/Notify/app/Datas/NetfunSmsData.php
/Modules/Notify/app/Datas/NetfunSmsRequestData.php
/Modules/Notify/app/Datas/NetfunSmsResponseData.php
```

❌ **Errato**:
```
/Modules/Notify/app/Data/NetfunSmsData.php
/Modules/Notify/app/DTOs/NetfunSmsData.php
/Modules/Notify/app/Datas/SMS/NetfunSmsData.php
```

## Convenzioni di Nomenclatura

### Naming dei File

I file DTO devono seguire la convenzione di nomenclatura PascalCase con il suffisso `Data`:

✅ **Corretto**:
```
NetfunSmsData.php
EmailData.php
NotificationData.php
```

❌ **Errato**:
```
netfun_sms_data.php
NetfunSMS.php
Netfun.php
```

### Namespace

Il namespace dei DTO deve essere:

```php
namespace Modules\Notify\Datas;
```

**IMPORTANTE**: Non utilizzare namespace come `Modules\Notify\Data` o `Modules\Notify\DTOs`.

## Implementazione dei DTO

### Proprietà Readonly

Utilizzare sempre proprietà readonly per i DTO in PHP 8.2+:

```php
readonly class NetfunSmsData
{
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        // ...
    ) {}
}
```

### Tipi Rigorosi

Specificare sempre i tipi per tutte le proprietà e utilizzare tipi nullable quando appropriato:

```php
public string $recipient,       // Obbligatorio
public ?string $sender = null,  // Opzionale
```

### Documentazione

Ogni DTO deve includere PHPDoc completo:

```php
/**
 * DTO per i dati di richiesta SMS Netfun
 */
readonly class NetfunSmsRequestData
{
    /**
     * @param string $recipient Numero di telefono del destinatario
     * @param string $message Testo del messaggio
     * @param string|null $sender Mittente (opzionale)
     */
    public function __construct(
        // ...
    ) {}
}
```

## Esempi di DTO Corretti

### NetfunSmsData

```php
<?php

namespace Modules\Notify\Datas;

/**
 * DTO per i dati SMS Netfun
 */
readonly class NetfunSmsData
{
    /**
     * @param string $recipient Numero di telefono del destinatario
     * @param string $message Testo del messaggio
     * @param string|null $sender Mittente (opzionale)
     * @param string|null $reference Riferimento univoco (opzionale)
     * @param string|null $scheduledDate Data pianificata di invio (opzionale)
     */
    public function __construct(
        public string $recipient,
        public string $message,
        public ?string $sender = null,
        public ?string $reference = null,
        public ?string $scheduledDate = null,
    ) {}
}
```

## Checklist di Verifica

Prima di creare un nuovo DTO, verificare che:

- [ ] Il file sia posizionato nella directory corretta (`/Modules/Notify/app/Datas/`)
- [ ] Il nome del file segua la convenzione PascalCase con suffisso `Data`
- [ ] Il namespace sia corretto (`Modules\Notify\Datas`)
- [ ] Le proprietà siano readonly e tipizzate correttamente
- [ ] La documentazione PHPDoc sia completa e accurata

## Riferimenti

- [PHP 8.2 Readonly Properties](https://www.php.net/manual/en/language.oop5.properties.php#language.oop5.properties.readonly-properties)
- [Laravel Data Transfer Objects Best Practices](https://laravel.com/docs/10.x/eloquent-serialization#data-transfer-objects)

---

*Ultimo aggiornamento: 2025-05-12*

---

## dto_structure_rules

*Consolidated from: `dto_structure_rules.md`*


## Directory e Namespace

1. **Directory**
   - Usare SEMPRE `app/Datas` (plurale)
   - NON usare mai `Data` (singolare)
   - NON usare mai `DTOs`
   - Mantenere la directory minuscola

2. **Namespace**
   - Usare `Modules\Notify\Datas`
   - NON usare `App\Datas`
   - NON usare `Modules\Notify\App\Datas`
   - Mantenere coerenza con la struttura delle directory

## Naming e Struttura

1. **Naming dei File**
   - Usare il suffisso `Data` per i DTO
   - Esempio: `NetfunSmsRequestData.php`
   - NON usare `DTO` o altri suffissi

2. **Naming delle Classi**
   - Coincidere con il nome del file
   - Usare PascalCase
   - Esempio: `class NetfunSmsRequestData`

3. **Struttura delle Classi**
   - Estendere `Spatie\LaravelData\Data`
   - Usare type hints per tutte le proprietà
   - Usare constructor property promotion
   - Documentare con PHPDoc

## Best Practices

1. **Tipizzazione**
   - Usare type hints per tutte le proprietà
   - Usare tipi nullable quando appropriato
   - Documentare i tipi con PHPDoc

2. **Validazione**
   - Implementare regole di validazione
   - Usare spatie/laravel-data per la validazione
   - Validare i dati in ingresso

3. **Documentazione**
   - Documentare ogni DTO
   - Documentare le proprietà
   - Documentare i metodi
   - Mantenere la documentazione aggiornata

## Checklist di Verifica

1. **Directory**
   - [ ] La directory è `app/Datas` (plurale)
   - [ ] La directory è minuscola
   - [ ] Non ci sono directory `Data` o `DTOs`

2. **Namespace**
   - [ ] Il namespace è `Modules\Notify\Datas`
   - [ ] Non ci sono namespace errati

3. **Naming**
   - [ ] Il file usa il suffisso `Data`
   - [ ] La classe usa PascalCase
   - [ ] Il nome della classe coincide con il file

4. **Struttura**
   - [ ] La classe estende `Spatie\LaravelData\Data`
   - [ ] Usa type hints
   - [ ] Usa constructor property promotion
   - [ ] Ha PHPDoc

5. **Validazione**
   - [ ] Implementa regole di validazione
   - [ ] Usa spatie/laravel-data
   - [ ] Valida i dati in ingresso

## Esempi di Errori Comuni

1. **Directory Errate**
   ```php
   // ERRATO
   app/Data/NetfunSmsRequestData.php
   app/DTOs/NetfunSmsRequestData.php
   
   // CORRETTO
   app/Datas/NetfunSmsRequestData.php
   ```

2. **Namespace Errati**
   ```php
   // ERRATO
   namespace App\Datas;
   namespace Modules\Notify\App\Datas;
   
   // CORRETTO
   namespace Modules\Notify\Datas;
   ```

3. **Naming Errato**
   ```php
   // ERRATO
   class NetfunSmsRequestDTO
   class NetfunSmsRequest
   
   // CORRETTO
   class NetfunSmsRequestData
   ```

## Riferimenti

- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [spatie/laravel-data](https://github.com/spatie/laravel-data)
- [Laravel Best Practices](https://laravel.com/docs/best-practices) 

---

## dto_vs_factory_analysis

*Consolidated from: `dto_vs_factory_analysis.md`*


Questo documento analizza in dettaglio i vantaggi e gli svantaggi di posizionare la logica di selezione del driver SMS all'interno del DTO `SmsData`, confrontando questo approccio con il pattern Factory implementato e con l'approccio originale (nel canale).

## Opzione 1: Logica nel DTO (SmsData)

```php
// In SmsData.php
class SmsData extends Data
{
    public string $from;
    public string $to;
    public string $body;
    
    public function getAction(): SmsActionInterface
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

// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    $action = $smsData->getAction();
    return $action->execute($smsData);
}
```

### Vantaggi (40%)

1. **Incapsulamento (15%)**: Il DTO incapsula non solo i dati ma anche la logica per ottenere l'azione appropriata, seguendo il principio di information hiding.

2. **Riutilizzabilità diretta (15%)**: Ovunque si utilizzi un'istanza di `SmsData`, è possibile ottenere direttamente l'azione corrispondente senza dipendenze aggiuntive:
   ```php
   $smsData = new SmsData(...);
   $result = $smsData->getAction()->execute($smsData);
   ```

3. **Semplificazione del canale (5%)**: Il canale diventa più semplice e focalizzato solo sulla gestione della notifica, con meno responsabilità.

4. **Riduzione delle dipendenze esplicite (5%)**: Non è necessario iniettare dipendenze aggiuntive nel canale o in altri componenti che utilizzano `SmsData`.

### Svantaggi (60%)

1. **Violazione del principio di Responsabilità Singola (25%)**: Il DTO assume due responsabilità distinte:
   - Contenere i dati del messaggio SMS
   - Selezionare l'implementazione dell'azione appropriata
   
   Questo viola il principio SRP, che stabilisce che una classe dovrebbe avere una sola ragione per cambiare.

2. **Accoppiamento con la configurazione del sistema (15%)**: Il DTO dipende direttamente dalla configurazione dell'applicazione (`Config::get()`), rendendo più difficile il suo utilizzo in contesti diversi (ad esempio, test unitari o ambienti isolati).

3. **Difficoltà di override del driver (10%)**: Diventa complesso sovrascrivere il driver predefinito in contesti specifici, poiché la logica è incapsulata nel DTO.

4. **Incoerenza con il pattern DTO (10%)**: I DTO sono generalmente strutture passive che contengono solo dati, non logica di business. Questo approccio viola questa convenzione.

## Opzione 2: Pattern Factory (Implementato)

```php
// In SmsActionFactory.php
class SmsActionFactory
{
    public function create(?string $driver = null): SmsActionInterface
    {
        $driver = $driver ?? Config::get('sms.default', 'smsfactor');
        
        return match ($driver) {
            'smsfactor' => app(SendSmsFactorSMSAction::class),
            'twilio' => app(SendTwilioSMSAction::class),
            // altri driver...
        };
    }
}

// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    $action = $this->factory->create();
    return $action->execute($smsData);
}
```

### Vantaggi (75%)

1. **Separazione delle responsabilità (25%)**: Ogni componente ha una responsabilità chiara:
   - DTO: Contenere i dati
   - Factory: Creare le azioni
   - Canale: Gestire le notifiche
   - Azione: Implementare la logica di invio

2. **Riutilizzabilità con flessibilità (20%)**: La factory può essere iniettata e utilizzata ovunque, con la possibilità di override del driver:
   ```php
   $action = $factory->create('twilio'); // Usa specificamente Twilio
   ```

3. **Testabilità (15%)**: Facilità nei test unitari grazie alla possibilità di mockare la factory:
   ```php
   $factoryMock->shouldReceive('create')->andReturn($actionMock);
   ```

4. **Estensibilità (10%)**: Nuovi driver possono essere aggiunti modificando solo la factory, senza impattare i DTO o i canali.

5. **Coerenza con i pattern di design (5%)**: Segue il pattern Factory, ampiamente riconosciuto e utilizzato.

### Svantaggi (25%)

1. **Complessità aggiuntiva (15%)**: Introduce una classe aggiuntiva nel sistema (la factory).

2. **Overhead di dependency injection (5%)**: Richiede l'iniezione della factory nei componenti che la utilizzano.

3. **Indirezione (5%)**: Aggiunge un livello di indirezione che potrebbe rendere il flusso di esecuzione meno immediato da seguire.

## Opzione 3: Logica nel Canale (Originale)

```php
// In SmsChannel.php
public function send($notifiable, Notification $notification)
{
    $smsData = $notification->toSms($notifiable);
    
    $driver = Config::get('sms.default', 'smsfactor');
    
    $action = match ($driver) {
        'smsfactor' => app(SendSmsFactorSMSAction::class),
        'twilio' => app(SendTwilioSMSAction::class),
        // altri driver...
    };
    
    return $action->execute($smsData);
}
```

### Vantaggi (55%)

1. **Semplicità (20%)**: Approccio diretto senza classi aggiuntive.

2. **Coerenza con Laravel (15%)**: Questo approccio è simile a come Laravel gestisce i driver in componenti come Mail, Queue, ecc.

3. **Centralizzazione della logica di routing (10%)**: Tutta la logica di routing è in un unico posto, rendendo più facile la comprensione del flusso.

4. **Minore overhead iniziale (10%)**: Non richiede la creazione di classi factory aggiuntive.

### Svantaggi (45%)

1. **Accoppiamento tra canale e azioni (15%)**: Il canale deve conoscere tutte le implementazioni concrete delle azioni.

2. **Duplicazione della logica (15%)**: Se la stessa logica di selezione è necessaria altrove, dovrà essere duplicata.

3. **Difficoltà nei test (10%)**: Testare il canale richiede di mockare tutte le dipendenze delle azioni.

4. **Responsabilità mista (5%)**: Il canale ha la responsabilità sia di gestire la notifica che di selezionare l'implementazione appropriata.

## Confronto Percentuale Complessivo

| Aspetto | DTO | Factory | Canale |
|---------|-----|---------|--------|
| **Vantaggi** | 40% | 75% | 55% |
| **Svantaggi** | 60% | 25% | 45% |
| **Bilancio** | -20% | +50% | +10% |

## Conclusione

Basandoci sull'analisi percentuale:

1. **Pattern Factory (Implementato)**: Offre il miglior equilibrio con un bilancio positivo del 50%, grazie alla chiara separazione delle responsabilità, riutilizzabilità e testabilità.

2. **Logica nel Canale (Originale)**: Ha un bilancio positivo del 10%, offrendo semplicità e coerenza con Laravel, ma con limitazioni in termini di riutilizzabilità e accoppiamento.

3. **Logica nel DTO**: Ha un bilancio negativo del 20%, principalmente a causa della violazione del principio di Responsabilità Singola e dell'accoppiamento con la configurazione.

**Raccomandazione finale**: Il pattern Factory implementato rappresenta la soluzione migliore, offrendo un equilibrio ottimale tra separazione delle responsabilità, riutilizzabilità, testabilità ed estensibilità, con svantaggi minimi in termini di complessità aggiuntiva.

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04
