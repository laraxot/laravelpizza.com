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
