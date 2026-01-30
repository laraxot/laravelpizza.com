# Regole per l'Implementazione degli Enum in <nome progetto>

## Panoramica

Gli enum in PHP 8.1+ sono utilizzati in <nome progetto> per rappresentare insiemi fissi di valori, come giorni della settimana, stati, tipi, ecc. Questo documento definisce le regole e le best practices per l'implementazione degli enum nel progetto, con particolare attenzione all'integrazione con Filament.

## Regole Fondamentali

### 1. Implementazione delle Interfacce Filament

Tutti gli enum utilizzati nei componenti Filament **DEVONO** implementare le seguenti interfacce:

- `Filament\Support\Contracts\HasLabel` - Per etichette localizzate
- `Filament\Support\Contracts\HasColor` - Per colori semantici
- `Filament\Support\Contracts\HasIcon` - Per icone rappresentative
- `Filament\Support\Contracts\HasDescription` - Per descrizioni dettagliate (quando applicabile)

### 2. Localizzazione

- Le etichette, le descrizioni e altri testi **DEVONO** essere localizzati utilizzando il sistema di traduzione di Laravel
- **NON** utilizzare stringhe hardcoded
- Utilizzare `app()->getLocale()` per determinare la lingua corrente quando necessario

### 3. Struttura dei File di Traduzione

Le traduzioni per gli enum devono seguire questa struttura:

```php
// resources/lang/it/module-name.php
return [
    'enums' => [
        'day_of_week' => [
            'monday' => [
                'label' => 'Lunedì',
                'description' => 'Primo giorno della settimana lavorativa',
            ],
            // altri giorni...
        ],
        // altri enum...
    ],
];
```

## Esempio di Implementazione Corretta

```php
<?php

namespace Modules\Xot\App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum DayOfWeek: int implements HasLabel, HasColor, HasIcon, HasDescription
{
    case MONDAY = 1;
    case TUESDAY = 2;
    case WEDNESDAY = 3;
    case THURSDAY = 4;
    case FRIDAY = 5;
    case SATURDAY = 6;
    case SUNDAY = 7;

    /**
     * Get the label for the enum value.
     */
    public function getLabel(): ?string
    {
        return match($this) {
            self::MONDAY => __('patient::common.days.monday'),
            self::TUESDAY => __('patient::common.days.tuesday'),
            self::WEDNESDAY => __('patient::common.days.wednesday'),
            self::THURSDAY => __('patient::common.days.thursday'),
            self::FRIDAY => __('patient::common.days.friday'),
            self::SATURDAY => __('patient::common.days.saturday'),
            self::SUNDAY => __('patient::common.days.sunday'),
        };
    }

    /**
     * Get the color for the enum value.
     */
    public function getColor(): ?string
    {
        return match($this) {
            self::MONDAY, self::TUESDAY, self::WEDNESDAY, self::THURSDAY, self::FRIDAY => 'primary',
            self::SATURDAY, self::SUNDAY => 'danger',
        };
    }

    /**
     * Get the icon for the enum value.
     */
    public function getIcon(): ?string
    {
        return match($this) {
            self::MONDAY => 'heroicon-o-calendar-days',
            self::TUESDAY => 'heroicon-o-calendar-days',
            self::WEDNESDAY => 'heroicon-o-calendar-days',
            self::THURSDAY => 'heroicon-o-calendar-days',
            self::FRIDAY => 'heroicon-o-calendar-days',
            self::SATURDAY => 'heroicon-o-calendar',
            self::SUNDAY => 'heroicon-o-calendar',
        };
    }

    /**
     * Get the description for the enum value.
     */
    public function getDescription(): ?string
    {
        return match($this) {
            self::MONDAY => __('patient::common.days.description.monday'),
            self::TUESDAY => __('patient::common.days.description.tuesday'),
            self::WEDNESDAY => __('patient::common.days.description.wednesday'),
            self::THURSDAY => __('patient::common.days.description.thursday'),
            self::FRIDAY => __('patient::common.days.description.friday'),
            self::SATURDAY => __('patient::common.days.description.saturday'),
            self::SUNDAY => __('patient::common.days.description.sunday'),
        };
    }

    /**
     * Check if the day is a weekend day.
     */
    public function isWeekend(): bool
    {
        return in_array($this, [self::SATURDAY, self::SUNDAY]);
    }

    /**
     * Get all days as an array of options.
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $day) => [$day->value => $day->getLabel()])
            ->toArray();
    }
}
```

## Utilizzo in Filament

### Select

```php
use Modules\Xot\App\Enums\DayOfWeek;
use Filament\Forms\Components\Select;

Select::make('day_of_week')
    ->options(DayOfWeek::class)
    ->enum(DayOfWeek::class)
    ->required();
```

### Radio

```php
use Modules\Xot\App\Enums\DayOfWeek;
use Filament\Forms\Components\Radio;

Radio::make('day_of_week')
    ->options(DayOfWeek::class)
    ->inline();
```

### Badge

```php
use Modules\Xot\App\Enums\DayOfWeek;
use Filament\Tables\Columns\BadgeColumn;

BadgeColumn::make('day_of_week')
    ->enum(DayOfWeek::class);
```

## Metodi Utili da Implementare

### Metodi Statici

```php
/**
 * Get all weekdays.
 */
public static function weekdays(): array
{
    return [
        self::MONDAY,
        self::TUESDAY,
        self::WEDNESDAY,
        self::THURSDAY,
        self::FRIDAY,
    ];
}

/**
 * Get weekend days.
 */
public static function weekend(): array
{
    return [
        self::SATURDAY,
        self::SUNDAY,
    ];
}

/**
 * Get the enum from a Carbon instance.
 */
public static function fromCarbon(\Carbon\Carbon $date): self
{
    return match($date->dayOfWeekIso) {
        1 => self::MONDAY,
        2 => self::TUESDAY,
        3 => self::WEDNESDAY,
        4 => self::THURSDAY,
        5 => self::FRIDAY,
        6 => self::SATURDAY,
        7 => self::SUNDAY,
    };
}
```

## Vantaggi dell'Implementazione Corretta

1. **Type Safety**: Gli enum garantiscono che solo valori validi possano essere utilizzati
2. **Autocompletamento**: Gli IDE possono fornire suggerimenti per i valori enum
3. **Integrazione con Filament**: I componenti Filament possono utilizzare automaticamente le etichette, i colori e le icone
4. **Localizzazione**: Le etichette e le descrizioni possono essere facilmente tradotte
5. **Manutenibilità**: Centralizza la logica relativa a un insieme di valori

## Note Importanti

1. **Evitare array hardcoded**: Utilizzare sempre enum per rappresentare insiemi fissi di valori
2. **Implementare tutte le interfacce**: Anche se alcune potrebbero sembrare non necessarie, implementarle tutte garantisce compatibilità futura
3. **Utilizzare il tipo corretto**: Preferire enum tipizzati (`enum Name: int` o `enum Name: string`) rispetto a enum non tipizzati
4. **Documentare**: Aggiungere docblock a tutti i metodi per migliorare la comprensione del codice

## Collegamenti Bidirezionali

- [XotBaseResource](/var/www/html/<nome progetto>/laravel/Modules/Xot/docs/XotBaseResource.md)
- [FILAMENT-BEST-PRACTICES](/var/www/html/<nome progetto>/laravel/Modules/Xot/docs/FILAMENT-BEST-PRACTICES.md)
- [DayOfWeek Enum](/var/www/html/<nome progetto>/laravel/Modules/Xot/app/Enums/DayOfWeek.php)
