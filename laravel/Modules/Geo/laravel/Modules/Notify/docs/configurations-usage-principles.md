# Principi di Utilizzo delle Configurazioni 

## Regola Fondamentale

, tutte le opzioni configurabili **DEVONO** essere definite nei file di configurazione e **MAI** hardcoded direttamente nel codice.

## Convenzioni per i Driver e le Opzioni

### 1. Utilizzo di Configurazioni vs Hardcoding

#### ❌ ERRATO: Hardcoding nei Form

```php
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

#### ✅ CORRETTO: Utilizzo del File di Configurazione

```php
Forms\Components\Select::make('driver')
    ->options(collect(config('sms.drivers'))->mapWithKeys(fn ($config, $driver) => 
        [$driver => Str::studly($driver)]
    )->toArray())
```

### 2. Utilizzo di Enum quando Appropriato

#### ✅ CORRETTO: Definizione e Utilizzo di Enum

```php
// Definizione Enum
enum SmsDriverEnum: string
{
    case SMSFactor = 'smsfactor';
    case Twilio = 'twilio';
    case Nexmo = 'nexmo';
    case Plivo = 'plivo';
    case Gammu = 'gammu';
    case Netfun = 'netfun';
    
    public static function toArray(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $case) => 
            [$case->value => $case->name]
        )->toArray();
    }
}

// Utilizzo nell'applicazione
Forms\Components\Select::make('driver')
    ->options(SmsDriverEnum::toArray())
```

## Benefici dell'Utilizzo delle Configurazioni

1. **Centralizzazione**: Tutte le opzioni configurabili sono definite in un unico luogo
2. **Manutenibilità**: Aggiungere, rimuovere o modificare opzioni richiede cambiamenti in un solo punto
3. **Testabilità**: Facilita i test modificando le configurazioni in ambiente di test
4. **Flessibilità**: Consente di modificare comportamenti senza modificare il codice

## Principi per i Template Blade e le Form Actions

### Regola Fondamentale

Nei template Blade, le azioni dei form **DEVONO** essere richiamate dai metodi PHP definiti nelle classi, e non hardcoded direttamente nei template.

#### ❌ ERRATO: Hardcoding di azioni nei template

```blade
<x-slot name="footer">
    <div class="flex items-center justify-end gap-x-3">
        <x-filament::button wire:click="sendSMS" type="submit" color="primary">
            Invia SMS
        </x-filament::button>
    </div>
</x-slot>
```

#### ✅ CORRETTO: Utilizzo delle azioni definite nella classe

```blade
<x-slot name="footer">
    <div class="flex items-center justify-between gap-x-3">
        <div>
            <x-filament::loading-indicator wire:loading wire:target="sendSMS" />
        </div>
        <div>
            <x-filament-panels::form.actions :actions="$this->getSmsFormActions()" />
        </div>
    </div>
</x-slot>
```

## Riferimenti

- [Laravel Configuration](https://laravel.com/docs/configuration)
- [PHP 8.1 Enums](https://www.php.net/manual/en/language.enumerations.php)
- [Filament Forms Actions](https://filamentphp.com/docs/forms/actions)
