<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Cms\Actions\View\GetCmsViewAction;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): Factory|View
    {
        $view = app(GetCmsViewAction::class)->execute('pub_theme::components.layouts.app');

        return view($view);
    }
}
