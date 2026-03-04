<?php

declare(strict_types=1);

namespace Modules\UI\View\Components\Page;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Component;
use Modules\Xot\Actions\GetViewAction;

final class WithSidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $tpl = '',
    ) {}

    public function render(): Renderable
    {
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute($this->tpl);

        $view_params = [];

        return view($view, $view_params);
    }
}
