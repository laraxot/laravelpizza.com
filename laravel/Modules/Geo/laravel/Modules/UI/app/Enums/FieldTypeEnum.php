<?php

declare(strict_types=1);

/**
 * @see https://filamentphp.com/docs/3.x/forms/fields/types
 * @see https://github.com/Valourite/form-builder/blob/v1.x/src/Filament/Enums/FieldType.php
 */

namespace Modules\UI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Defines the different types of appointments in the system.
 *
 * @method static self        fromName(string $name)
 * @method static self        fromValue(string $value)
 * @method static self        tryFromName(string $name)
 * @method static self        tryFromValue(string $value)
 * @method static array<self> cases()
 */
enum FieldTypeEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case TEXT = 'text';
    // case NUMBER   = 'number';
    case EMAIL = 'email';
    // case PASSWORD = 'password';
    case TEXTAREA = 'textarea';
    case SELECT = 'select';
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
    case DATE = 'date';
    case TIME = 'time';
    case DATETIME = 'datetime';
}
