<?php
declare(strict_types=1);

namespace Modules\UI\Enums;

enum UiGroupColumnTypeEnum: string
{
    case TEXT = 'text';
    case NUMBER = 'number';
    case BOOLEAN = 'boolean';
    case DATE = 'date';

    public function getLabel(): string
    {
        return match ($this) {
            self::TEXT => 'Text',
            self::NUMBER => 'Number',
            self::BOOLEAN => 'Boolean',
            self::DATE => 'Date',
        };
    }
}
