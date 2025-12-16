<?php

declare(strict_types=1);

namespace Modules\Cms\Http\Volt;

use Livewire\Volt\Component;

class CounterComponent extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        ++$this->count;
    }

    public function decrement(): void
    {
        --$this->count;
    }
}
