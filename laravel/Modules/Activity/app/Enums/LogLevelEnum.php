<?php

declare(strict_types=1);

namespace Modules\Activity\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Livelli Monolog con cui Laravel scrive i log (`[data] ambiente.LIVELLO: messaggio`), dal piu' grave al meno grave.
 *
 * Il valore e' il nome del livello come compare nel file di log, in maiuscolo. L'ordine dei case e' quello
 * mostrato nel filtro della pagina Log. Sostituisce la costante `BuildLogViewerStateAction::LEVELS` e la mappa
 * dei colori che stava nella vista.
 *
 * Etichetta e colore: Modules/Activity/lang/{locale}/log_level_enum.php.
 */
enum LogLevelEnum: string implements HasColor, HasLabel
{
    use EnumTrait;

    case EMERGENCY = 'EMERGENCY';
    case ALERT = 'ALERT';
    case CRITICAL = 'CRITICAL';
    case ERROR = 'ERROR';
    case WARNING = 'WARNING';
    case NOTICE = 'NOTICE';
    case INFO = 'INFO';
    case DEBUG = 'DEBUG';
}
