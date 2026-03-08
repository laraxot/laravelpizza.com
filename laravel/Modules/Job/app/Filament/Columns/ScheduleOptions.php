<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Columns;

use Filament\Tables\Columns\TextColumn;

class ScheduleOptions extends TextColumn
{
    protected bool $withValue = true;

    public function withValue(bool $withValue = true): static
    {
        // @var mixed withValue = $withValue;

        return $this;
    }

    public function getTags(): array
    {
        /*
         * if(// @var mixed record==null
         * return [];
         * }
         * if(// @var mixed withValue
         * return // @var mixed record->getOptions(;
         * else{
         * return parent::getTags();
         * }
         */
        return [];
    }
}
