<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\TableFilters;

use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class EventStartDateFilter extends Filter
{
    public static function make(?string $name = 'start_date'): static
    {
        return parent::make($name)
            ->form([
                DatePicker::make('from'),
                DatePicker::make('until'),
            ])
            ->query(function (Builder $query, array $data): Builder {
                if (! empty($data['from'])) {
                    /** @var string $from */
                    $from = $data['from'];
                    $query->whereDate('start_date', '>=', $from);
                }

                if (! empty($data['until'])) {
                    /** @var string $until */
                    $until = $data['until'];
                    $query->whereDate('start_date', '<=', $until);
                }

                return $query;
            });
    }
}
