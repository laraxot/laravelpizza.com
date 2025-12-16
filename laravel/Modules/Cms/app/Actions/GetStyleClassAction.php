<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Support\Str;
use Modules\Xot\Actions\GetViewAction;
use Spatie\QueueableAction\QueueableAction;

final class GetStyleClassAction
{
    use QueueableAction;

    public function execute(string $tpl = ''): string
    {
        $config_key = inAdmin() ? 'adm_theme' : 'pub_theme';
        // $config_key .= '::styles.button.action.class';
        $view = app(GetViewAction::class)->execute($tpl);
        $config_key .= '::'.Str::after($view, '::components.').'.class';

        $class = config($config_key);
        if (! is_string($class)) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }

        return $class;
    }
}
