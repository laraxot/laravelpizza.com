<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\User\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

// use Datomatic\LaravelEnumHelper\LaravelEnumHelper;

enum UserType: string implements HasColor, HasIcon, HasLabel
{
    // //use LaravelEnumHelper;

    case MasterAdmin = 'master_admin';
    case BoUser = 'backoffice_user';
    case CustomerUser = 'customer_user';
    case System = 'system';
    case Technician = 'technician';

    private const API = 'api';

    private const WEB = 'web';

    public function getDefaultGuard(): string
    {
        return match ($this) {
            self::MasterAdmin, self::System, self::CustomerUser, self::BoUser => self::WEB,
            self::Technician => self::API,
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::MasterAdmin => 'master_admin',
            self::BoUser => 'backoffice_user',
            self::CustomerUser => 'customer_user',
            self::System => 'system',
            self::Technician => 'technician',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::MasterAdmin => 'success',
            self::BoUser => 'warning',
            self::CustomerUser => 'gray',
            self::System => 'blue',
            self::Technician => 'green',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::MasterAdmin => 'heroicon-m-pencil',
            self::BoUser => 'heroicon-m-pencil',
            self::CustomerUser => 'heroicon-m-pencil',
            self::System => 'heroicon-m-pencil',
            self::Technician => 'heroicon-m-pencil',
        };
    }
}
