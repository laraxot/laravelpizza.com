<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;

class GetFontFamilyOptions
{
    use QueueableAction;

    /**
     * Get font family options for charts.
     *
     * @return array<int, string>
     */
    public function execute(): array
    {
        return [
            10 => 'FF_COURIER',
            11 => 'FF_VERDANA',
            12 => 'FF_TIMES',
            14 => 'FF_COMIC',
            15 => 'FF_ARIAL',
            16 => 'FF_GEORGIA',
            17 => 'FF_TREBUCHE',
            // 18 => 'FF_COLIBRI',
        ];
    }
}
