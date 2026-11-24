<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Filament\Filter;

use Filament\Tables\Filters\SelectFilter;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/get-year-filter.md
<<<<<<< .merge_file_uaDtTN
 *
=======
>>>>>>> .merge_file_LqIoKT
 * @contract docs/contracts/get-year-filter.md
 */
class GetYearFilter
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(string $fieldName, int $from, int $to): SelectFilter
    {
        $opts = [];
        for ($curr = $from; $curr <= $to; $curr++) {
            $currStr = (string) $curr;
            $opts[$currStr] = $currStr;
        }

        return SelectFilter::make($fieldName)->options($opts);
    }
}
