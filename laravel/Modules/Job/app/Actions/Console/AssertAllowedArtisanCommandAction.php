<?php

declare(strict_types=1);

namespace Modules\Job\Actions\Console;

use InvalidArgumentException;
use Spatie\QueueableAction\QueueableAction;

/**
<<<<<<< .merge_file_e1I6su
<<<<<<< .merge_file_DtZA7L
<<<<<<< .merge_file_g6KxPb
<<<<<<< .merge_file_Nt8NZQ
 * @see docs/contracts/assert-allowed-artisan-command-action.md
=======
 * Rifiuta ogni comando Artisan che non sia identico a una voce dell'allowlist.
>>>>>>> .merge_file_y4u5FG
=======
 * Rifiuta ogni comando Artisan che non sia identico a una voce dell'allowlist.
>>>>>>> .merge_file_by6nnk
=======
 * Rifiuta ogni comando Artisan che non sia identico a una voce dell'allowlist.
>>>>>>> .merge_file_a7eanX
=======
 * Rifiuta ogni comando Artisan che non sia identico a una voce dell'allowlist.
>>>>>>> .merge_file_jpMAPT
 *
 * @contract docs/contracts/assert-allowed-artisan-command-action.md
 */
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
