<?php

declare(strict_types=1);

namespace Modules\Geo\View\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;

class FormSearchAddressCategories extends Component
{
    /**
     * Undocumented function.
     */
    public function render(): Renderable
    {
        /**
         * @phpstan-var view-string
         */
        $view = 'geo::components.form_search_address_categories';
        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
