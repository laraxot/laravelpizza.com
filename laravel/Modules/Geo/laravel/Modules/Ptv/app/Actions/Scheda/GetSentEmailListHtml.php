<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class GetSentEmailListHtml
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(SchedaContract $record): string
    {
        $html = '';

        $myLogsRelation = $record->myLogs();
        if ($myLogsRelation instanceof Relation) {
            $logsQuery = $myLogsRelation->where('act', 'sendMail');
            if ($logsQuery instanceof Builder) {
                $logs = $logsQuery->get();
                if ($logs instanceof Collection) {
                    foreach ($logs as $row) {
                        if ($row instanceof Model && isset($row->updated_at)) {
                            $updatedAt = $row->updated_at;
                            $updatedAtStr = is_string($updatedAt) ? $updatedAt : (is_object($updatedAt) && method_exists($updatedAt, '__toString') ? (string) $updatedAt : '');
                            if ($updatedAtStr !== '') {
                                $html .= '<br/>'.$updatedAtStr;
                            }
                        }
                    }
                }
            }
        }

        return $html;
    }
}
