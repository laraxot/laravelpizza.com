<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

enum UiCoverageBadgeEnum: string implements HasColor, HasIcon
{
    case Plain = 'plain';
    case NullColor = 'null_color';
    case ArrayColor = 'array_color';
    case EmptyColor = 'empty_color';
    case HtmlIcon = 'html_icon';
    case NullIcon = 'null_icon';
    case HtmlableIcon = 'htmlable_icon';
    case BareHtmlableIcon = 'bare_htmlable_icon';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Plain => 'emerald',
            self::NullColor => null,
            self::ArrayColor => ['', 'indigo'],
            self::EmptyColor => '',
            self::HtmlIcon, self::NullIcon, self::HtmlableIcon, self::BareHtmlableIcon => 'gray',
        };
    }

    public function getIcon(): string|Htmlable|null
    {
        return match ($this) {
            self::HtmlIcon => '<svg></svg>',
            self::NullIcon => null,
            self::HtmlableIcon => new HtmlString('<i>x</i>'),
            self::BareHtmlableIcon => new class implements Htmlable
            {
                public function toHtml(): string
                {
                    return 'x';
                }
            },
            default => 'heroicon-o-star',
        };
    }
}
