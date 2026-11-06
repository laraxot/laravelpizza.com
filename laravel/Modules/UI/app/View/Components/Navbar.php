<?php

declare(strict_types=1);

namespace Modules\UI\View\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use Modules\Xot\Actions\GetViewAction;

/**
 * Navbar component.
 */
final class Navbar extends Component
{
    public function __construct() {}

    public function render(): Renderable
    {
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute();
        $viewParams = [];

        return view($view, $viewParams);
    }
}
