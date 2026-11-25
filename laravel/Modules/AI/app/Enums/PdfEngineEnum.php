<?php

declare(strict_types=1);

namespace Modules\Xot\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

enum PdfEngineEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case SPIPU = 'spipu';
    case SPATIE = 'spatie';
}
