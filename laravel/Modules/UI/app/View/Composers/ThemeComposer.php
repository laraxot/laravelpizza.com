<?php

declare(strict_types=1);

namespace Modules\UI\View\Composers;

use Exception;
use Illuminate\View\View;

final class ThemeComposer
{
    public function metatags(): View
    {
        /**
         * @phpstan-var view-string
         */
        $view = 'ui::metatags';

        return view($view);
    }

    public function metatag(string $index): string|bool|null
    {
        // $ris = self::__getStatic($index);
        // echo '<br/>['.$index.']['.$ris.']';
        // if ('' === $ris || null === $ris) {
        $value = config('metatag.'.$index);

        return is_string($value) || is_bool($value) ? $value : null;
    }

    public function showScripts(): string
    {
        return '';
    }

    public function flag(string $lang): View
    {
        $view = "ui::svg.flags.{$lang}";
        if (! view()->exists($view)) {
            throw new Exception('view not exits ['.$view.']');
        }

        return view($view);
    }
}
