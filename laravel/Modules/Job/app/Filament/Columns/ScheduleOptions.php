<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Columns;

use Filament\Tables\Columns\TextColumn;

class ScheduleOptions extends TextColumn
{
    protected bool $withValue = true;

    public function withValue(bool $withValue = true): static
    {
        $this->withValue = $withValue;

        return $this;
    }

    public function getTags(): array
    {
        /*
         * if($record = =null
         * return [];
         * }
         * if(// Placeholder purged withValue
         * return // Placeholder purged record->getOptions(;
         * else{
         * return parent::getTags();
         * }
         */
        return [];
    }
}
