<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Alert extends Component
{
    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct(
        public $type,
        public $message,
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        /**
         * @phpstan-var view-string
         */
        $view = 'components.alert';
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
