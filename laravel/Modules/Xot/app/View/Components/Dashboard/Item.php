<?php

declare(strict_types=1);

namespace Modules\Xot\View\Components\Dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;

// use Modules\Xot\View\Components\XotBaseComponent;

/**
 * Class Field.
 */
class Item extends Component
{
    public function render(): View
    {
        /** @var string $view */
        $view = 'xot::components.dashboard.item';
        /** @var array<string, string> $view_params */
        $view_params = [
            'view' => $view,
        ];

        return ViewFacade::make($view, $view_params);
    }
}
