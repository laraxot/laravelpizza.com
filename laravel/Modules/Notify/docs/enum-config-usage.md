# Utilizzo di Enum e Config 

Questo documento definisce le best practices per l'utilizzo di Enum e file di configurazione nel sistema SaluteOra, con particolare attenzione alla gestione delle opzioni nei componenti Filament.

## Problema: Hardcoding delle Opzioni

L'hardcoding delle opzioni direttamente nei componenti Filament presenta diversi problemi:

```php
// ❌ APPROCCIO ERRATO: Hardcoding delle opzioni
Forms\Components\Select::make('driver')
    ->options([
        'smsfactor' => 'SMSFactor',
        'twilio' => 'Twilio',
        'nexmo' => 'Nexmo',
        'plivo' => 'Plivo',
        'gammu' => 'Gammu',
        'netfun' => 'Netfun',
    ])
```

### Problemi dell'Hardcoding

1. **Scarsa Manutenibilità**: Modificare le opzioni richiede la modifica del codice in più punti
2. **Duplicazione del Codice**: Le stesse opzioni potrebbero essere ripetute in più componenti
3. **Incoerenza**: Rischio di incoerenza tra diverse parti dell'applicazione
4. **Difficoltà di Testing**: Più difficile testare il codice con valori hardcoded
5. **Flessibilità Limitata**: Difficile aggiungere o rimuovere opzioni dinamicamente

## Soluzioni Migliori

### 1. Utilizzo di Enum (PHP 8.1+)

```php
// ✅ APPROCCIO CORRETTO: Utilizzo di Enum
use Modules\Notify\Enums\SmsDriverEnum;

Forms\Components\Select::make('driver')
    ->options(SmsDriverEnum::options())
```

Con l'implementazione dell'Enum:

```php
enum SmsDriverEnum: string
{
    case SMSFACTOR = 'smsfactor';
    case TWILIO = 'twilio';
    case NEXMO = 'nexmo';
    case PLIVO = 'plivo';
    case GAMMU = 'gammu';
    case NETFUN = 'netfun';
    
    public static function options(): array
    {
        return [
            self::SMSFACTOR->value => 'SMSFactor',
            self::TWILIO->value => 'Twilio',
            self::NEXMO->value => 'Nexmo',
            self::PLIVO->value => 'Plivo',
            self::GAMMU->value => 'Gammu',
            self::NETFUN->value => 'Netfun',
        ];
    }
    
    public static function labels(): array
    {
        return [
            self::SMSFACTOR->value => __('notify::sms.drivers.smsfactor'),
            self::TWILIO->value => __('notify::sms.drivers.twilio'),
            self::NEXMO->value => __('notify::sms.drivers.nexmo'),
            self::PLIVO->value => __('notify::sms.drivers.plivo'),
            self::GAMMU->value => __('notify::sms.drivers.gammu'),
            self::NETFUN->value => __('notify::sms.drivers.netfun'),
        ];
    }
}
```

### 2. Utilizzo dei File di Configurazione

```php
// ✅ APPROCCIO CORRETTO: Utilizzo di Config
Forms\Components\Select::make('driver')
    ->options(config('sms.drivers'))
```

Con la configurazione in `config/sms.php`:

```php
return [
    'drivers' => [
        'smsfactor' => 'SMSFactor',
        'twilio' => 'Twilio',
        'nexmo' => 'Nexmo',
        'plivo' => 'Plivo',
        'gammu' => 'Gammu',
        'netfun' => 'Netfun',
    ],
    // Altre configurazioni...
];
```

## Vantaggi delle Soluzioni Proposte

### Vantaggi degli Enum

1. **Type Safety**: Controllo dei tipi a livello di compilazione
2. **Autocompletamento**: Supporto IDE per l'autocompletamento
3. **Refactoring Facilitato**: Facile rinominare o modificare i valori
4. **Documentazione Incorporata**: Gli enum sono autodocumentanti
5. **Centralizzazione**: Un unico punto di definizione dei valori possibili

### Vantaggi dei File di Configurazione

1. **Configurabilità**: Facile modificare i valori senza toccare il codice
2. **Ambiente-Specifico**: Possibilità di avere configurazioni diverse per ambienti diversi
3. **Centralizzazione**: Un unico punto di definizione dei valori
4. **Separazione delle Responsabilità**: Separazione tra codice e configurazione
5. **Facilità di Testing**: Più facile mockare i valori di configurazione nei test

## Quando Usare Enum vs Config

### Usa Enum Quando:

- I valori sono fortemente tipizzati e non cambiano frequentemente
- Hai bisogno di metodi helper associati ai valori
- Vuoi sfruttare il controllo dei tipi e l'autocompletamento
- I valori sono utilizzati in più parti del codice

### Usa Config Quando:

- I valori possono cambiare tra ambienti diversi
- Vuoi permettere personalizzazioni senza modificare il codice
- I valori sono specifici dell'applicazione e non del dominio
- Hai bisogno di valori diversi in produzione, staging, test, ecc.

## Implementazione 

Per standardizzare l'approccio , si raccomanda di:

1. **Creare Enum** per tutti i tipi di dati enumerabili del dominio
2. **Utilizzare Config** per valori configurabili specifici dell'applicazione
3. **Evitare Hardcoding** di array di opzioni nei componenti Filament
4. **Centralizzare** la definizione di opzioni comuni

## Conclusione

L'utilizzo di Enum e file di configurazione migliora significativamente la manutenibilità, la flessibilità e la coerenza del codice. Adottare queste pratiche in tutto il sistema SaluteOra garantirà un codice più robusto e facile da mantenere.
