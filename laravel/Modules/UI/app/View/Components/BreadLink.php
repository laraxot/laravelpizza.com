<?php

declare(strict_types=1);

namespace Modules\UI\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class BreadLink extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct() {}

    public function render(): View
    {
        /** @var view-string $view */
        $view = 'ui::components.bread-link';

        return view($view);
    }
}
