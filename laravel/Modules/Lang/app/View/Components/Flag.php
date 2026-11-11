<?php

declare(strict_types=1);

namespace Modules\Lang\View\Components;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use Modules\Xot\Actions\GetViewAction;

/**
 * Render a flag icon for a locale.
 */
class Flag extends Component
{
    public function __construct(
        public string $name,
    ) {}

    public function render(): Renderable
    {
        $view = app(GetViewAction::class)->execute();

        $viewParams = [
            'view' => $view,
            'name' => $this->name,
        ];

        return view()->make($view, $viewParams);
    }
}
