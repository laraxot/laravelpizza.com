<?php

declare(strict_types=1);

namespace Modules\Cms\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        /*
         * $view = 'pub_theme';
         * if (inAdmin()) {
         * $view = 'adm_theme';
         * }
         *
         * $view .= '::components.app-layout';
         */
        /** @var view-string $view */
        $view = 'pub_theme::layouts.app';
        $view_params = [];

        return view($view, $view_params);
    }
}
