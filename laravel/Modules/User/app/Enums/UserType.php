<?php

declare(strict_types=1);
/**
 * ---.
 */

namespace Modules\User\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

// use Datomatic\LaravelEnumHelper\LaravelEnumHelper;

enum UserType: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    // //use LaravelEnumHelper;

    case MasterAdmin = 'master_admin';
    case BoUser = 'backoffice_user';
    case CustomerUser = 'customer_user';
    case System = 'system';
    case Technician = 'technician';

    /**
     * Nome del guard (config/auth.php) con cui questo tipo di utente si autentica.
     */
    public function getDefaultGuard(): string
    {
        return match ($this) {
            self::MasterAdmin, self::System, self::CustomerUser, self::BoUser => 'web',
            self::Technician => 'api',
        };
    }
}
