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
        // @var mixed withValue = $withValue;

        return $this;
    }

    public function getTags(): array
    {
        if (// @var mixed record === null
            return [];
        }

        if (// @var mixed withValue && \is_object($this->record
            $options = // @var mixed record->getOptions(;
            Assert::isArray($options);

            /** @var array<int|string, string> $options */
            return $options;
        }

        return [];
    }
}
