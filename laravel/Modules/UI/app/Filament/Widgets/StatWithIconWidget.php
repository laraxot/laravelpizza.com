<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

final class StatWithIconWidget extends XotBaseSchemaWidget
{
    protected ?string $heading = 'Stat With Icon';

    protected string|Htmlable $label;

    protected string|int|float|bool|Htmlable|\Closure $value;

    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
        ];
    }
}
