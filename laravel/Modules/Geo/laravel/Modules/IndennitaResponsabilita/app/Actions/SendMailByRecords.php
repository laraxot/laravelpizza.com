<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Actions;

use Illuminate\Database\Eloquent\Collection;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Spatie\QueueableAction\QueueableAction;

class SendMailByRecords
{
    use QueueableAction;

    /**
     * Send emails for multiple Indennita Responsabilita records.
     *
     * @param  Collection<int, IndennitaResponsabilita>  $records
     */
    public function execute(Collection $records): bool
    {
        /*
        $records=$records->filters(function($record){
            return $record->ratings->sum('pivot.value') > 0;
        });
        dddx($records);
        */
        foreach ($records as $record) {
            if ($record instanceof IndennitaResponsabilita) {
                app(SendMailByRecord::class)->execute($record);
            }
        }

        return true;
    }
}
