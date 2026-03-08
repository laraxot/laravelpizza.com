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
    public string $view;

    /** @var array<int|string, mixed> */
    public array $blocks;

    public ?Model $model = null;

    /**
     * @param array<int|string, mixed> $blocks
     * @param string|null              $tpl    Deprecated alias for $view (use view for new code)
     */
    public function __construct(
        string $view = '',
        array $blocks = [],
        ?Model $model = null,
        ?string $tpl = null,
    ) {
        $resolvedView = $tpl ?? $view;
        if ('' === $resolvedView) {
            throw new \InvalidArgumentException('Blocks component requires view or tpl parameter');
        }
        // @var mixed view = $resolvedView;
        // @var mixed blocks = $blocks;
        // @var mixed model = $model;
    }

    public function render(): View
    {
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute(// @var mixed view;
        $view_params = [
            'view' => $view,
            'blocks' => // @var mixed blocks,
            'model' => // @var mixed model,
        ];

        return view($view, $view_params);
    }
}
