<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

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
        $view = 'components.input';
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
