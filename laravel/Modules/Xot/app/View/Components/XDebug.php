<?php

declare(strict_types=1);

namespace Modules\Xot\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;
use Modules\Xot\Actions\GetViewAction;
use RuntimeException;
use function Safe\ob_end_clean;
use function Safe\ob_start;

// use Modules\Xot\View\Components\XotBaseComponent;

/**
 * .
 */
class XDebug extends Component
{
    public function __construct(
        // public Post $article,
        // public bool $showAuthor = false,
        public string $tpl = 'v1',
    ) {
    }

    public function render(): View
    {
        /** @var string $view */
        $view = app(GetViewAction::class)->execute($this->tpl);

        if (! ViewFacade::exists($view)) {
            throw new RuntimeException("View [{$view}] does not exist.");
        }

        /** @var view-string $view */

        /** @var array<string, string> $view_params */
        $view_params = [
            'html' => $this->debugStack(),
        ];

        return view($view, $view_params);
    }

    public function debugStack(): string
    {
        if (! \extension_loaded('xdebug')) {
            throw new RuntimeException('XDebug must be installed to use this function');
        }

        ob_start();

        echo 'Hello ';

        // xdebug_set_filter(
        //     XDEBUG_FILTER_TRACING,
        //     XDEBUG_PATH_EXCLUDE,
        //     [LARAVEL_DIR.'/vendor/']
        //     // [__DIR__.'/../../vendor/']
        // );

        // xdebug_print_function_stack();

        $out1 = ob_get_contents();
        ob_end_clean();

        return \is_string($out1) ? $out1 : ((string) $out1);
    }
}
