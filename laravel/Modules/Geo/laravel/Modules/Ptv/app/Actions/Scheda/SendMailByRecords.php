<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class SendMailByRecords
{
    use QueueableAction;

    /**
     * Undocumented function.
     *
     * @param  Collection<int, SchedaContract>  $records
     */
    public function execute(Collection $records): void
    {
        /*
        $records=$records->filters(function($record){
            return $record->ratings->sum('pivot.value') > 0;
        });
        dddx($records);
        */
        foreach ($records as $record) {
            app(SendMailByRecord::class)->execute($record);
        }
    }
}
