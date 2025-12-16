<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

final class GetViewThemeByViewAction
{
    use QueueableAction;

    public function execute(string $view = ''): string
    {
        $tmp = Str::after($view, '::');

        $view1 = inAdmin() ? 'adm_theme' : 'pub_theme';
        $view1 .= '::'.$tmp;

        // if ('' != $view) {
        //     $view1 .= '.'.$view;
        // }
        if (view()->exists($view1)) {
            return $view1;
        }

        return $view;
    }
}
