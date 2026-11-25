<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

/**
 * Enum fixture per RadioBadge::getIconForOption — ramo Htmlable / no __toString.
 */
enum UiCoverageHtmlIconEnum: string implements HasColor, HasIcon
{
    case HtmlStringIcon = 'html_string';
    case HtmlableOnly = 'htmlable_only';

    public function getColor(): string
    {
        return 'gray';
    }

    public function getIcon(): Htmlable
    {
        return match ($this) {
            self::HtmlStringIcon => new HtmlString('<i>x</i>'),
            self::HtmlableOnly => new class implements Htmlable
            {
                public function toHtml(): string
                {
                    return 'x';
                }
            },
        };
    }
}
