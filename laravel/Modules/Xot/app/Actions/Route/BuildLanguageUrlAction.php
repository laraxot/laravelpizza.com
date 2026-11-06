<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Route;

use Spatie\QueueableAction\QueueableAction;

class BuildLanguageUrlAction
{
    use QueueableAction;

    public function execute(): string
    {
        return '?';
    }
}
