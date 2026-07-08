<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;

class ShowMailSendedAt
{
    use QueueableAction;

    /**
     * Get the formatted mail sent dates for a given model.
     *
     * @return string HTML formatted string containing mail sent dates
     */
    public function execute(SchedaContract $model): string
    {
        $dates = $model->myLogs()->where('act', 'sendMail')->pluck('created_at');
        $html = '';
        foreach ($dates as $date) {
            if (! $date instanceof Carbon) {
                continue;
            }
            $html .= $date->format('d/m/Y H:i:s').'<br/>';
        }

        return $html;
    }
}
