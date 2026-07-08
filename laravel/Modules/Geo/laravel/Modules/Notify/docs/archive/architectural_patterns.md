# Pattern Architetturali per le Notifiche

Questo documento analizza i pattern architetturali utilizzati nel sistema di notifiche di SaluteOra, con particolare attenzione alla selezione del driver e alla gestione delle dipendenze.

## Confronto tra Pattern Architetturali

### Pattern Attuale: Selezione del Driver nel Canale

```php
// In SmsChannel.php
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

### Pattern Alternativo: Selezione del Driver nel DTO

```php
// In SmsData.php
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

// In SmsChannel.php
$action = $smsData->getAction();
```

## Analisi dei Vantaggi e Svantaggi

### Pattern Attuale: Selezione del Driver nel Canale

#### Vantaggi (60%)

1. **Separazione delle Responsabilità (25%)**: Il DTO `SmsData` si occupa solo di contenere i dati, mentre il canale gestisce la logica di routing. Questo rispetta il principio di Responsabilità Singola (SRP).
2. **Flessibilità nel Canale (15%)**: Il canale può implementare logiche aggiuntive per la selezione del driver, come la selezione basata su attributi del notifiable o su condizioni dinamiche.
3. **Coerenza con il Framework Laravel (10%)**: Questo approccio è coerente con il modo in cui Laravel gestisce i driver nei suoi componenti nativi (mail, queue, cache, ecc.).
4. **Centralizzazione della Logica di Routing (10%)**: Tutta la logica di routing è centralizzata nel canale, rendendo più facile la comprensione del flusso di esecuzione.

#### Svantaggi (40%)

1. **Accoppiamento tra Canale e Azioni (20%)**: Il canale deve conoscere tutte le implementazioni concrete delle azioni, creando un accoppiamento stretto.
2. **Duplicazione della Logica (15%)**: Se la stessa logica di selezione del driver è necessaria altrove, dovrà essere duplicata.
3. **Difficoltà nei Test (5%)**: Testare il canale richiede di mockare tutte le dipendenze delle azioni.

### Pattern Alternativo: Selezione del Driver nel DTO

#### Vantaggi (45%)

1. **Incapsulamento (20%)**: Il DTO incapsula non solo i dati ma anche la logica per ottenere l'azione appropriata.
2. **Riutilizzabilità (15%)**: La logica di selezione del driver può essere riutilizzata ovunque sia disponibile un'istanza di `SmsData`.
3. **Semplificazione del Canale (10%)**: Il canale diventa più semplice e focalizzato solo sulla gestione della notifica.

#### Svantaggi (55%)

1. **Violazione di SRP (25%)**: Il DTO assume due responsabilità: contenere i dati e selezionare l'azione. Questo viola il principio di Responsabilità Singola.
2. **Accoppiamento del DTO con la Configurazione (15%)**: Il DTO dipende dalla configurazione del sistema, rendendo più difficile il suo utilizzo in contesti diversi.
3. **Difficoltà di Estensione (10%)**: Diventa più complesso estendere o modificare la logica di selezione del driver senza modificare il DTO.
4. **Incoerenza con il Pattern DTO (5%)**: I DTO sono generalmente strutture passive che contengono solo dati, non logica di business.

## Pattern Consigliato: Factory Separato

Un terzo pattern, che potrebbe offrire il miglior equilibrio, è l'utilizzo di un Factory separato:

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
            'nexmo' => app(SendNexmoSMSAction::class),
            'plivo' => app(SendPlivoSMSAction::class),
            'gammu' => app(SendGammuSMSAction::class),
            'netfun' => app(SendNetfunSMSAction::class),
            default => throw new Exception("Unsupported SMS driver: {$driver}"),
        };
    }
}

// In SmsChannel.php
public function __construct(private SmsActionFactory $factory) {}

public function send($notifiable, Notification $notification)
{
    // ...
    $action = $this->factory->create();
    // ...
}
```

### Vantaggi del Pattern Factory (80%)

1. **Separazione delle Responsabilità (25%)**: Ogni componente ha una responsabilità chiara: il DTO contiene i dati, il factory crea le azioni, il canale gestisce le notifiche.
2. **Riutilizzabilità (20%)**: Il factory può essere iniettato e utilizzato ovunque sia necessario creare un'azione SMS.
3. **Facilità di Test (15%)**: Ogni componente può essere testato isolatamente, con mock semplici.
4. **Flessibilità (10%)**: Il factory può accettare un driver specifico, permettendo override dinamici.
5. **Estensibilità (10%)**: Nuovi driver possono essere aggiunti modificando solo il factory.

### Svantaggi del Pattern Factory (20%)

1. **Complessità Aggiuntiva (15%)**: Introduce una classe aggiuntiva nel sistema.
2. **Overhead di Dependency Injection (5%)**: Richiede l'iniezione del factory nei componenti che lo utilizzano.

## Conclusione

Basandoci sull'analisi dei vantaggi e degli svantaggi:

1. **Pattern Attuale (Selezione nel Canale)**: 60% vantaggi, 40% svantaggi
2. **Pattern Alternativo (Selezione nel DTO)**: 45% vantaggi, 55% svantaggi
3. **Pattern Factory**: 80% vantaggi, 20% svantaggi

Il **Pattern Factory** offre il miglior equilibrio tra separazione delle responsabilità, riutilizzabilità e testabilità. Tuttavia, il **Pattern Attuale** è comunque una soluzione valida, specialmente per progetti di dimensioni ridotte o quando la coerenza con il framework è prioritaria.

Il **Pattern Alternativo** (selezione nel DTO) è sconsigliato in quanto viola il principio di Responsabilità Singola e crea un accoppiamento non necessario tra il DTO e la configurazione del sistema.
