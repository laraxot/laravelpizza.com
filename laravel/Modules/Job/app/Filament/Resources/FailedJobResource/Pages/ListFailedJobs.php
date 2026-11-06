<?php

declare(strict_types=1);
/**
 * @see https://gitlab.com/amvisor/filament-failed-jobs/-/blob/master/src/resources/FailedJobsResource/Pages/ListFailedJobs.php?ref_type=heads
 */

namespace Modules\Job\Filament\Resources\FailedJobResource\Pages;

use Modules\Job\Filament\Resources\FailedJobResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Colonne e azioni di tabella stanno in `FailedJobsTable`: la List page non le dichiara.
 */
class ListFailedJobs extends XotBaseListRecords
{
    protected static string $resource = FailedJobResource::class;
}
