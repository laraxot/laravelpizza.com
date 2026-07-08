<?php

/**
 * The `Blocks` component is responsible for rendering a set of blocks on a view.
 *
 * It takes an optional array of `$blocks` and an optional `$model` parameter. The `$tpl` parameter
 * specifies the template to use for rendering the blocks.
 *
 * The `render()` method retrieves the appropriate view based on the `$tpl` parameter, and then
 * passes the `$view`, `$blocks`, and `$model` parameters to the view for rendering.
 */

declare(strict_types=1);

namespace Modules\UI\View\Components\Render;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use Modules\Xot\Actions\GetViewAction;

final class Blocks extends Component
{
    /**
     * @param array<int|string, mixed> $blocks
     */
    public function __construct(
        public string $view,
        public array $blocks = [],
        public ?Model $model = null,
    ) {
    }

    public function render(): View
    {
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute($this->view);
        $view_params = [
            'view' => $view,
            'blocks' => $this->blocks,
            'model' => $this->model,
        ];

        return view($view, $view_params);
    }
}
