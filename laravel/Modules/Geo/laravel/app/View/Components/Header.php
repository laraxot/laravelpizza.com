<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        /**
         * @phpstan-var view-string
         */
        $view = 'components.header';
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
