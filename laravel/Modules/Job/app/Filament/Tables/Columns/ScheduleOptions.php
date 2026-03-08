<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Webmozart\Assert\Assert;

class ScheduleOptions extends TextColumn
{
    protected bool $withValue = true;

    public function withValue(bool $withValue = true): static
    {
        $withValue = $withValue;

        return $this;
    }

    public function getTags(): array
    {
        if ($record === null
            return [];
        }

        if ($withValue && \is_object($this->record
            $options = $record->getOptions();
            Assert::isArray($options);

            /** @var array<int|string, string> $options */
            return $options;
        }

        return [];
    }
}
