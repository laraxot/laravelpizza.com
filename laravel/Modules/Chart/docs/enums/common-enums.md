# Enum Comuni nel Sistema <nome progetto>

## Panoramica

Gli enum sono una caratteristica introdotta in PHP 8.1 che permette di definire un tipo che può assumere solo un insieme limitato di valori predefiniti. Nel sistema <nome progetto>, utilizziamo gli enum per rappresentare concetti comuni e riutilizzabili in tutto il sistema.

Questo documento descrive gli enum comuni disponibili nel modulo `Xot`, che possono essere utilizzati in qualsiasi altro modulo del sistema.

## DayOfWeek

L'enum `DayOfWeek` rappresenta i giorni della settimana ed è disponibile in `\Modules\Xot\Enums\DayOfWeek`.

### Definizione

```php
namespace Modules\Xot\Enums;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Enum per la gestione dei giorni della settimana.
 *
 * Questo enum fornisce funzionalità per:
 * - Rappresentare i giorni della settimana
 * - Ottenere etichette localizzate
 * - Gestire giorni lavorativi e weekend
 * - Calcolare giorni successivi
 */
enum DayOfWeek: int
{
    case MONDAY = 1;
    case TUESDAY = 2;
    case WEDNESDAY = 3;
    case THURSDAY = 4;
    case FRIDAY = 5;
    case SATURDAY = 6;
    case SUNDAY = 7;

    /**
     * Restituisce l'etichetta localizzata per questo giorno della settimana.
     */
    public function label(): string
    {
        return Carbon::create()->startOfWeek()->addDays($this->value - 1)->locale('it')->isoFormat('dddd');
    }

    /**
     * Restituisce l'etichetta abbreviata per questo giorno della settimana.
     */
    public function shortLabel(): string
    {
        return Carbon::create()->startOfWeek()->addDays($this->value - 1)->locale('it')->isoFormat('ddd');
    }

    /**
     * Converte tutti i casi dell'enum in un array associativo per l'uso nei componenti select.
     *
     * @return array<int, string>
     */
    public static function toArray(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($day) => [
            $day->value => $day->label()
        ])->toArray();
    }

    /**
     * Restituisce una collezione dei giorni lavorativi (lunedì-venerdì).
     *
     * @return Collection<self>
     */
    public static function workingDays(): Collection
    {
        return collect(self::cases())->filter(fn ($day) => $day->value <= 5);
    }

    /**
     * Restituisce una collezione dei giorni del weekend (sabato-domenica).
     *
     * @return Collection<self>
     */
    public static function weekendDays(): Collection
    {
        return collect(self::cases())->filter(fn ($day) => $day->value > 5);
    }

    /**
     * Determina se questo giorno è un giorno del weekend.
     */
    public function isWeekend(): bool
    {
        return $this->value > 5;
    }

    /**
     * Ottiene il giorno successivo della settimana.
     */
    public function next(): self
    {
        return match($this) {
            self::MONDAY => self::TUESDAY,
            self::TUESDAY => self::WEDNESDAY,
            self::WEDNESDAY => self::THURSDAY,
            self::THURSDAY => self::FRIDAY,
            self::FRIDAY => self::SATURDAY,
            self::SATURDAY => self::SUNDAY,
            self::SUNDAY => self::MONDAY,
        };
    }
}
```

### Utilizzo

L'enum `DayOfWeek` può essere utilizzato in diversi contesti:

#### 1. In Componenti Filament

```php
use Modules\Xot\Enums\DayOfWeek;

// In un form Filament
Forms\Components\Select::make('day')
    ->options(DayOfWeek::toArray())
    ->enum(DayOfWeek::class)
    ->required()
```

#### 2. In Modelli Eloquent

```php
use Modules\Xot\Enums\DayOfWeek;

// In un modello Eloquent con Laravel 12.x
protected function casts(): array
{
    return [
        'day_of_week' => DayOfWeek::class,
    ];
}
```

#### 3. In Metodi e Funzioni

```php
use Modules\Xot\Enums\DayOfWeek;

// Verificare se un giorno è nel weekend
if ($dayOfWeek->isWeekend()) {
    // Logica per i giorni del weekend
}

// Ottenere il giorno successivo
$nextDay = $dayOfWeek->next();

// Ottenere l'etichetta localizzata
$label = $dayOfWeek->label();

// Ottenere l'etichetta abbreviata
$shortLabel = $dayOfWeek->shortLabel();

// Ottenere tutti i giorni lavorativi
$workingDays = DayOfWeek::workingDays();

// Ottenere tutti i giorni del weekend
$weekendDays = DayOfWeek::weekendDays();
```

### Vantaggi

L'utilizzo dell'enum `DayOfWeek` offre numerosi vantaggi:

1. **Type Safety**: Il campo accetta solo valori dell'enum DayOfWeek
2. **Autocompletamento**: L'IDE suggerisce i valori validi
3. **Validazione**: Laravel valida automaticamente che il valore sia uno dei casi dell'enum
4. **Localizzazione**: Le etichette sono tradotte tramite il metodo label()
5. **Manutenibilità**: Centralizzazione della logica relativa ai giorni della settimana
6. **Riusabilità**: L'enum può essere utilizzato in qualsiasi modulo del sistema

## Altri Enum Comuni

Oltre a `DayOfWeek`, il modulo `Xot` fornisce altri enum comuni:

- `\Modules\Xot\Enums\MonthOfYear`: Rappresenta i mesi dell'anno
- `\Modules\Xot\Enums\TimeUnit`: Rappresenta le unità di tempo (secondi, minuti, ore, giorni, settimane, mesi, anni)
- `\Modules\Xot\Enums\Status`: Rappresenta gli stati comuni (attivo, inattivo, in attesa, ecc.)

## Conclusione

Gli enum comuni nel modulo `Xot` forniscono un modo standardizzato e type-safe per rappresentare concetti comuni in tutto il sistema <nome progetto>. Utilizzare questi enum invece di implementazioni personalizzate in ogni modulo garantisce coerenza, riusabilità e manutenibilità del codice.

## Riferimenti

- [Documentazione PHP sugli Enum](https://www.php.net/manual/en/language.enumerations.php)
- [Documentazione Laravel sui Cast di Enum](https://laravel.com/docs/12.x/eloquent-mutators#enum-casting)
- [Best Practices per gli Enum in PHP](../best-practices/php-enums.md)
