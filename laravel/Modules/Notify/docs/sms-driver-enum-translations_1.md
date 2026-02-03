<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f3927d7 (.)
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> 4f3927d7 (.)
=======
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 2a97406c (.)
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
=======
=======
>>>>>>> 36321fcb (.)
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 731b801a8 (.)
=======
=======
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> c31e900eb (.)
=======
=======
>>>>>>> 36ac4fc1 (.)
>>>>>>> fea359347 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> 4f3927d7 (.)
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 207ac35e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
<<<<<<< HEAD
>>>>>>> 9777d1b3 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 8e5817bc (.)
=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 51182e3c (rebase 210)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> f81a620f (.)
=======
>>>>>>> 06e3078e (.)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 06e3078e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 9777d1b3 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 75179b85 (.)
<<<<<<< HEAD
>>>>>>> 1487fe812 (.)
=======
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
<<<<<<< HEAD
>>>>>>> 10292b60a (.)
=======
=======
>>>>>>> 207ac35e (.)
<<<<<<< HEAD
>>>>>>> bf5d31b0f (.)
=======
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 9777d1b3 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> f963d2c0 (.)
<<<<<<< HEAD
>>>>>>> 12a7e2462 (.)
=======
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
<<<<<<< HEAD
>>>>>>> 510809c6f (.)
=======
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
>>>>>>> b207a9b1a (.)

---

=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 207ac35e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
<<<<<<< HEAD
>>>>>>> 9777d1b3 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
<<<<<<< HEAD
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 8e5817bc (.)
=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 51182e3c (rebase 210)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> f81a620f (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 8e5817bc (.)
=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 51182e3c (rebase 210)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> f81a620f (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 8e5817bc (.)
=======
>>>>>>> e0d9c9be (.)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> e0d9c9be (.)
=======
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 06e3078e (.)
=======
>>>>>>> 011072e4 (.)
=======
>>>>>>> 9d67cabd (.)
=======
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> e0d9c9be (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 207ac35e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 9777d1b3 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 75179b85 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 9777d1b3 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 161887a2 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> ee18dd92 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8dc1f2ed6 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d3a8af4d5 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
>>>>>>> e7a9a2bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9d67cabd (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> ba564870 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 66453ace (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2e9bd58c3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5fe4f466 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 503981fd (.)
=======
>>>>>>> 8e5817bc (.)
<<<<<<< HEAD
=======
>>>>>>> e0d9c9be (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 7a2f131f (.)
=======
>>>>>>> 51182e3c (rebase 210)
=======
>>>>>>> cb85c538 (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 1c0eb9c7 (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
=======
>>>>>>> 460b8f5b (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 4d253d2c (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
=======
>>>>>>> 1375c94d (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 52cd5f85 (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 030c9674 (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 77edd94a (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> eea68ec9 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 59916c8f (.)
=======
>>>>>>> f81a620f (.)
=======
>>>>>>> 06e3078e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 70e8274e (.)
=======
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 161887a2 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> ba564870 (.)
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4d2eb53e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
=======
>>>>>>> 6b6b9e41 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 503981fd (.)
=======
>>>>>>> 8e5817bc (.)
=======
>>>>>>> e0d9c9be (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 7a2f131f (.)
=======
>>>>>>> 51182e3c (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> cb85c538 (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 1c0eb9c7 (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 460b8f5b (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 4d253d2c (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1375c94d (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 52cd5f85 (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
=======
>>>>>>> 030c9674 (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 77edd94a (.)
=======
>>>>>>> eea68ec9 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 59916c8f (.)
=======
>>>>>>> f81a620f (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 06e3078e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 70e8274e (.)
=======
>>>>>>> de02998b (.)
=======
>>>>>>> 011072e4 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 161887a2 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
>>>>>>> 9d67cabd (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> ba564870 (.)
=======
>>>>>>> 9cdf6146 (.)
=======
>>>>>>> 80f054e0 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
>>>>>>> 4d2eb53e (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6b6b9e41 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
>>>>>>> 5fe4f466 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 503981fd (.)
=======
>>>>>>> 8e5817bc (.)
=======
>>>>>>> e0d9c9be (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 7a2f131f (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
=======
>>>>>>> 9d67cabd (.)
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 138485550 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
=======
>>>>>>> 9cdf6146 (.)
>>>>>>> c22b35d1e (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
=======
>>>>>>> 4d2eb53e (.)
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 138fcd4b0 (.)
=======
=======
>>>>>>> 6b6b9e41 (.)
>>>>>>> be45a0b8d (.)
=======
>>>>>>> db0bc148f (.)
=======
=======
>>>>>>> 5fe4f466 (.)
>>>>>>> 49639b815 (.)
=======
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 13655a7ed (.)
=======
=======
>>>>>>> cb85c538 (rebase 210)
>>>>>>> e0836b102 (.)
=======
>>>>>>> 903e3e2cd (.)
=======
=======
>>>>>>> 460b8f5b (rebase 210)
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 5d49e093a (.)
=======
=======
>>>>>>> 1375c94d (rebase 210)
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 17f6b8617 (.)
=======
=======
>>>>>>> 030c9674 (rebase 210)
>>>>>>> db6bec044 (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
=======
>>>>>>> eea68ec9 (.)
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> e95dfc210 (.)
=======
=======
>>>>>>> 06e3078e (.)
>>>>>>> ec24613a1 (.)

---

=======
>>>>>>> 5fd545e4 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 23f115647 (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 998e6866b (.)
=======
>>>>>>> 23f115647 (.)

---

>>>>>>> 2a97406c (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 4f042b88 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 36321fcb (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 712617d3 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3e757cee2 (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 3e757cee2 (.)

---

>>>>>>> fdb24863 (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 54220b28 (rebase 210)
=======
=======
>>>>>>> 9fe1b60e (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

<<<<<<< HEAD
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> cd5474106 (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> cd5474106 (.)

---

>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 8c8937e7 (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 26d39e2eb (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)

---

>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> fd1fcc4c (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 763771402 (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 763771402 (.)

---

>>>>>>> 4f3927d7 (.)
<<<<<<< HEAD
=======
=======
>>>>>>> 2fc60436 (.)
=======
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> ee18dd92 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 66453ace (.)
=======
>>>>>>> 5fd545e4 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 2a97406c (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> a115e2aad (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 36136dcfa (.)
=======
>>>>>>> a115e2aad (.)

---

>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 36321fcb (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 712617d3 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 54220b28 (rebase 210)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9fe1b60e (rebase 210)
=======
>>>>>>> 8a8a8e2f (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

<<<<<<< HEAD
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> eb62d6cf (rebase 210)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 01750b107 (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)

---

>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 36ac4fc1 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2dab69c8a (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 2dab69c8a (.)

---

>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 4f3927d7 (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2fc60436 (.)
=======
>>>>>>> ce89c8bb (.)
<<<<<<< HEAD
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> 82ae73be (.)
=======
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

<<<<<<< HEAD
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> ee18dd92 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 66453ace (.)
=======
>>>>>>> 5fd545e4 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 2a97406c (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 4f042b88 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9cb55171f (.)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 9cb55171f (.)

---

>>>>>>> 36321fcb (.)
<<<<<<< HEAD
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

<<<<<<< HEAD
>>>>>>> 712617d3 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 301ad8b44 (.)
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
=======
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 36321fcb (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
<<<<<<< HEAD
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
>>>>>>> d284d65 (.)

---

>>>>>>> 712617d3 (.)
>>>>>>> 731b801a8 (.)
=======
>>>>>>> b85076e48 (.)
=======
=======
=======
>>>>>>> 9fe1b60e (rebase 210)
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> ce1853afd (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 4e2ebfb (.)

---

<<<<<<< HEAD
>>>>>>> 4fc21b78 (rebase 210)
<<<<<<< HEAD
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> c31e900eb (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
=======
=======
>>>>>>> 2fc60436 (.)
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
=======
- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> b19cd40 (.)
=======
- [Documentazione Traduzioni](../../Lang/docs/)
- [Documentazione Traduzioni](../../Lang/project_docs/)
- [Documentazione Traduzioni](../../Lang/docs/)- [Documentazione Traduzioni](../../Lang/project_docs/)
>>>>>>> 4e2ebfb (.)

---

<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
