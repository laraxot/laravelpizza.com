<?php

declare(strict_types=1);

namespace Modules\Ptv\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Livewire\Wireable;
use Modules\Xot\Traits\EnumTrait;
use Spatie\LaravelData\Concerns\WireableData;

enum WorkerType: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;
    // , Wireable
    use WireableData;

    case Dip = 'dip';
    case Regionale = 'regionale';
    case Po = 'po';
    case Dirigente = 'dirigente';
    // case IndividualeRegionale = 'individuale_regionale';
}
