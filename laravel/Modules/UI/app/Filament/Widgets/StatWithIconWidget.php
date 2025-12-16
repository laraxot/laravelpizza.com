<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

final class StatWithIconWidget extends XotBaseWidget
{
    protected ?string $heading = 'Stat With Icon';

    protected string|Htmlable $label;

    /**
     * @var scalar|Htmlable|\Closure
     */
    protected $value;

    public function getFormSchema(): array
    {
        return [];
    }

    protected function getData(): array
    {
        dddx($this->label);

        return [];
    }
}
