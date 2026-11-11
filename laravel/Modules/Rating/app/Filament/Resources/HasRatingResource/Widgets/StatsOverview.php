<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\HasRatingResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Rating\Actions\HasRating\GetCountByModelRatingIdAction;
use Modules\Rating\Actions\HasRating\GetSumByModelRatingIdAction;
use Modules\Rating\Models\Contracts\HasRatingContract;
use Modules\Rating\Models\Rating;
use Webmozart\Assert\Assert;

/**
 * Undocumented class.
 *
 * @property (Model&HasRatingContract)|null $record
 */
class StatsOverview extends BaseWidget
{
    public (Model&HasRatingContract)|null $record = null;

    protected function getStats(): array
    {
        $stats = [];
        if ($this->record === null) {
            return $stats;
        }
        // Assert::isInstanceOf($record=$this->record,HasRatingContract::class);
        $ratings = $this->record->ratings()->wherePivot('user_id', null)->get();
        Assert::isInstanceOf($ratings, Collection::class);
        Assert::allIsInstanceOf($ratings, Rating::class);
        foreach ($ratings as $rating) {
            $sum = app(GetSumByModelRatingIdAction::class)->execute($this->record, (string) $rating->id);
            $count = app(GetCountByModelRatingIdAction::class)->execute($this->record, (string) $rating->id);
            $stats[] = Stat::make((string) $rating->title, $sum)->descriptionIcon('predict-bottlecap')->description('volume');
            $stats[] = Stat::make((string) $rating->title, $count)->descriptionIcon('heroicon-o-users')->description('players')->color('success');
        }

        $sum = app(GetSumByModelRatingIdAction::class)->execute($this->record);
        $count = app(GetCountByModelRatingIdAction::class)->execute($this->record);
        $stats[] = Stat::make('Tot Volume', $sum)->descriptionIcon('predict-bottlecap')->description('volume');
        $stats[] = Stat::make('Tot Player', $count)->descriptionIcon('heroicon-o-users')->description('players')->color('success');

        return $stats;
    }
}
