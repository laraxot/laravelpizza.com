<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Spatie\QueueableAction\QueueableAction;

class ViewCopyAction
{
    use QueueableAction;

    public function execute(string $from, string $to): void
    {
        $from_path = app(ViewPathAction::class)->execute($from);
        $to_path = app(ViewPathAction::class)->execute($to);
        app(CopyAction::class)->execute($from_path, $to_path);
    }
}
