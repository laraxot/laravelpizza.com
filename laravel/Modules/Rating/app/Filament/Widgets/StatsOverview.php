<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Rating\Actions\HasRating\GetCountByModelRatingIdAction;
use Modules\Rating\Actions\HasRating\GetSumByModelRatingIdAction;
use Modules\Rating\Models\Contracts\HasRatingContract;
use Modules\Rating\Models\Rating;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget as BaseWidget;
use Webmozart\Assert\Assert;

/**
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
        $ratings = $this->record->ratings()->wherePivot('user_id', null)->get();
        Assert::isInstanceOf($ratings, Collection::class);
        Assert::allIsInstanceOf($ratings, Rating::class);
        foreach ($ratings as $rating) {
            $sum = app(GetSumByModelRatingIdAction::class)->execute($this->record, SafeStringCastAction::cast($rating->id));
            $count = app(GetCountByModelRatingIdAction::class)->execute($this->record, SafeStringCastAction::cast($rating->id));
            $stats[] = Stat::make(SafeStringCastAction::cast($rating->title), $sum)->descriptionIcon('heroicon-o-circle-stack')->description('volume');
            $stats[] = Stat::make(SafeStringCastAction::cast($rating->title), $count)->descriptionIcon('heroicon-o-users')->description('players')->color('success');
        }

        $sum = app(GetSumByModelRatingIdAction::class)->execute($this->record);
        $count = app(GetCountByModelRatingIdAction::class)->execute($this->record);
        $stats[] = Stat::make('Tot Volume', $sum)->descriptionIcon('heroicon-o-circle-stack')->description('volume');
        $stats[] = Stat::make('Tot Player', $count)->descriptionIcon('heroicon-o-users')->description('players')->color('success');

        return $stats;
    }
}
