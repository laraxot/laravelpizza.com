# EnumTrait Pattern - Standard Architetturale per Enums

## Scopo
`EnumTrait` è il trait standard di Laraxot per tutti gli enum PHP backed che necessitano di integrazione con Filament UI. Centralizza etichette, colori, icone e descrizioni tramite file di traduzione, eliminando la necessità di implementazioni manuali nelle singole classi enum.

## Regola Architetturale

> **REGOLA**: Tutti gli enum che implementano `HasColor`, `HasLabel`, `HasIcon` o `HasDescription` **DEVONO** usare `EnumTrait` anziché implementare manualmente i metodi `getLabel()`, `getColor()`, `getIcon()`, `getDescription()`.

## Come Funziona

### 1. Classe Enum (Minimalista)
```php
<?php
declare(strict_types=1);

namespace Modules\NomeModulo\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum MioEnum: string implements HasColor, HasLabel
{
    use EnumTrait;

    case CASO_UNO = 'valore_uno';
    case CASO_DUE = 'valore_due';
}
```

### 2. File di Traduzione
Creare `Modules/NomeModulo/lang/{locale}/mio_enum.php`:
```php
<?php
declare(strict_types=1);

return [
    'valore_uno' => [
        'label' => 'Etichetta Caso Uno',
        'color' => 'primary',
        'icon' => 'heroicon-o-star',         // opzionale
        'description' => 'Descrizione...',    // opzionale
    ],
    'valore_due' => [
        'label' => 'Etichetta Caso Due',
        'color' => 'success',
    ],
];
```

## Convenzione di Naming
- La chiave del file di traduzione è lo `snake_case` del nome della classe enum.
- Le chiavi interne corrispondono ai `value` dei casi enum.
- Ogni caso **deve** avere almeno `label` e `color`.

## Enums Conformi nel Progetto

| Modulo | Enum | File Traduzione |
|--------|------|-----------------|
| Xot | `DayOfWeek` | `xot/lang/it/day_of_week.php` |
| Xot | `GenderEnum` | `xot/lang/it/gender_enum.php` |
| Xot | `PdfEngineEnum` | `xot/lang/it/pdf_engine_enum.php` |
| Xot | `YesNoEnum` | `xot/lang/it/yes_no_enum.php` |
| Meetup | `EventStatus` | `meetup/lang/it/event_status.php` |
| Meetup | `EventAttendanceMode` | `meetup/lang/it/event_attendance_mode.php` |
| Meetup | `RepeatFrequency` | `meetup/lang/it/repeat_frequency.php` |

## Metodi Ereditati da EnumTrait

| Metodo | Interfaccia | Fonte |
|--------|-------------|-------|
| `getLabel(): string` | `HasLabel` | `{value}.label` nel file di traduzione |
| `getColor(): string` | `HasColor` | `{value}.color` nel file di traduzione |
| `getIcon(): string` | `HasIcon` | `{value}.icon` nel file di traduzione |
| `getDescription(): string` | `HasDescription` | `{value}.description` nel file di traduzione |
| `getFormSchema(): array` | - | Genera campi TextInput per ogni caso |
| `columns(Blueprint, ?Migration)` | - | Aggiunge colonne al database |

## Anti-Pattern (❌ NON FARE)
```php
// ❌ SBAGLIATO: Implementazione manuale
enum MioEnum: string implements HasLabel
{
    case A = 'a';

    public function getLabel(): string
    {
        return match ($this) {
            self::A => 'Etichetta A',
        };
    }
}
```

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*
