<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Console;

use InvalidArgumentException;
use Spatie\QueueableAction\QueueableAction;

final class AssertAllowedArtisanCommandAction
{
    use QueueableAction;

    /**
     * @param  list<string>  $allowed
     */
    public function execute(string $command, array $allowed): void
    {
        if (! in_array($command, $allowed, true)) {
            throw new InvalidArgumentException(sprintf('Artisan command [%s] is not allowed.', $command));
        }
    }
}
