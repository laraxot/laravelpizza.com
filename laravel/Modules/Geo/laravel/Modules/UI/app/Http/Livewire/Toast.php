<?php

declare(strict_types=1);

/**
 * @see https://github.com/bezhanSalleh/filament-language-switch/blob/main/src/Http/Livewire/FilamentLanguageSwitch.php
 */

namespace Modules\UI\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Toast extends Component
{
    public function render(): View
    {
        $view = 'ui::livewire.toast';
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
