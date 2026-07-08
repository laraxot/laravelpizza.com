<?php

declare(strict_types=1);

namespace Modules\Progressioni\Actions;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\Progressioni\Models\MyLog;
use Modules\Progressioni\Models\Progressioni;
use Modules\Progressioni\Models\Scheda;
use Spatie\QueueableAction\QueueableAction;

class ShowMailSendedAt
{
    use QueueableAction;

    public function execute(Scheda|Progressioni $model): string
    {
        $timestamps = array_merge(
            $this->collectSendMailTimestamps(Scheda::firstWhere(['id' => $model->getKey()])),
            $this->collectSendMailTimestamps(Progressioni::firstWhere(['id' => $model->getKey()]))
        );

        if ($timestamps === []) {
            return '';
        }

        return '<br/>'.implode('<br/>', $timestamps);
    }

    /**
     * @return list<string>
     */
    private function collectSendMailTimestamps(Scheda|Progressioni|null $scheda): array
    {
        if ($scheda === null) {
            return [];
        }

        /** @var Collection<int, MyLog> $logs */
        $logs = $scheda->myLogs()
            ->where('act', 'sendMail')
            ->get();

        $timestamps = [];
        foreach ($logs as $log) {
            $value = $log->updated_at;

            if ($value instanceof CarbonInterface) {
                $timestamps[] = $value->toDateTimeString();
            } elseif (is_string($value) && $value !== '') {
                $timestamps[] = $value;
            }
        }

        return $timestamps;
    }
}
