<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Infolists\Components;

use Filament\Infolists\Components\Entry;

class SectionPreview extends Entry
{
    protected string $view = 'cms::filament.infolists.components.section-preview';

    public static function make(?string $name = null): static
    {
        return parent::make($name);
    }
}
