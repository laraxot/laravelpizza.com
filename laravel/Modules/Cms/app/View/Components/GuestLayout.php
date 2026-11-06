<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;
use Modules\Cms\Actions\View\GetCmsViewAction;

class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View|Htmlable|\Closure|string
    {
        $view = app(GetCmsViewAction::class)->execute('pub_theme::components.layouts.guest');

        return ViewFacade::make($view);
    }
}
