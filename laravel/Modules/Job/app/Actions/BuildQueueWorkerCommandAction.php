<?php

declare(strict_types=1);

namespace Modules\Job\Actions;

use Modules\Job\Datas\JobConfigData;
use Spatie\QueueableAction\QueueableAction;

/**
 * Riga di shell con cui `worker:check` avvia `queue:work`. Solo interi: nulla di scelto da un
 * utente arriva alla shell se non come numero.
 *
<<<<<<< .merge_file_yO5Bmd
<<<<<<< .merge_file_7NWcRd
<<<<<<< .merge_file_XCPojt
 * @see docs/contracts/build-queue-worker-command-action.md
 *
=======
>>>>>>> .merge_file_9IQ6Sj
=======
>>>>>>> .merge_file_GDQ8yU
=======
>>>>>>> .merge_file_oYWlzT
 * @contract docs/contracts/build-queue-worker-command-action.md
 */
class BuildQueueWorkerCommandAction
{
    use QueueableAction;

    public function execute(): string
    {
        $config = JobConfigData::make();

        return ' /usr/local/bin/php '.base_path().'/artisan queue:work'
            .' --timeout='.$config->timeout_seconds
            .' --sleep='.$config->sleep_seconds
            .' --tries='.$config->max_attempts
            .' > /dev/null & echo $!';
    }
}
