<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View|Htmlable|\Closure|string
    {
        /** @var view-string $view */
        $view = 'pub_theme::components.layouts.guest';

        return ViewFacade::make($view);
    }
}
