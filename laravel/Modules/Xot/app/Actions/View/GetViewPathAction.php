<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\View;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

class GetViewPathAction
{
    use QueueableAction;

    /**
     * ---.
     */
    public function execute(string $view): string
    {
        $ns = Str::before($view, '::');
        $relative_path = str_replace('.', '/', Str::after($view, '::'));
        $pack_dir = app(GetViewNameSpacePathAction::class)->execute($ns);
        $view_dir = $pack_dir.'/'.$relative_path;

        $res = str_replace('/', \DIRECTORY_SEPARATOR, $view_dir);
        $res .= '.blade.php';

        return $res;
    }
}
