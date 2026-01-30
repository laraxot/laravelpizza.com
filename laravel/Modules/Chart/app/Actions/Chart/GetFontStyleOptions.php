<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\Chart;

use Spatie\QueueableAction\QueueableAction;

class GetFontStyleOptions
{
    use QueueableAction;

    /**
     * Get font style options for charts.
     *
     * @return array<int, string>
     */
    public function execute(): array
    {
        return [
            9001 => 'FS_NORMAL',
            9002 => 'FS_BOLD',
            9003 => 'FS_ITALIC',
            // 9004 => 'FS_BOLDIT',
            9004 => 'FS_BOLDITALIC',
        ];
    }
}
