<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Tables\Columns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Rating\Filament\Forms\Components\RatingsSection;
use Modules\Rating\Filament\Tables\Filters\HasRatingValuesFilter;
use Modules\Xot\Filament\Tables\Columns\XotBaseTextColumn;

/**
 * Lo stato della valutazione di un record, in una cella sola.
 *
 * Non «quanti criteri esistono» — ci sono sempre, si creano quando il record viene
 * preparato — ma **se qualcuno li ha compilati**. Su un'installazione reale: 171 righe
 * pivot su 180 hanno `value` NULL, e i record valutati sono 147 su 7.955.
 *
 * Specchio di {@see RatingsSection}. Il
 * criterio di «valutata» sta qui, in {@see self::isRated()}: Section e filtro lo
 * chiedono a questa classe invece di ricalcolarlo.
 *
 * Tre scelte, ognuna con un dato dietro:
 *
 * 1. Si aggrega su `ratingMorphs()` (le righe pivot), non su `ratings()`: `value` sta
 *    sul pivot — `sum('ratings', 'value')` è `Unknown column 'ratings.value'` — e
 *    `ratings()` vede solo `getMorphClass()`, mentre `model_type` esiste in due forme.
 * 2. Il conteggio è **distinto per criterio**: 18 coppie duplicate, fino a 15 copie.
 *    `SUM` non ne soffre (le copie sono NULL), `COUNT(*)` sì: direbbe «45 criteri»
 *    dove sono 9, con il totale giusto accanto.
 * 3. Gli aggregati stanno in query: nessuna query per riga.
 *
 * @see laravel/Modules/Rating/docs/stories/ratings-column-section-filter.story.md
 */
class RatingsColumn extends XotBaseTextColumn
{
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'ratings')
            ->counts(['ratingMorphs as rating_morphs_count' => static fn (Builder $query): Builder => $query->select(DB::raw('count(distinct rating_id)'))])
            ->sum('ratingMorphs', 'value')
            ->state(static fn (Model $record): string => static::describe($record))
            ->badge()
            ->color(static fn (Model $record): string => static::isRated($record) ? 'success' : 'gray')
            ->sortable(['rating_morphs_sum_value']);
    }

    /**
     * Totale nullo o zero = nessuno ha ancora messo un voto. Stesso criterio del filtro
     * {@see HasRatingValuesFilter}, così lista
     * filtrata e colonna non si contraddicono.
     */
    public static function isRated(Model $record): bool
    {
        $sum = $record->getAttribute('rating_morphs_sum_value');

        return is_numeric($sum) && (float) $sum !== 0.0;
    }

    public static function describe(Model $record): string
    {
        $count = $record->getAttribute('rating_morphs_count');
        $criteria = is_numeric($count) ? (int) $count : 0;

        if (! static::isRated($record)) {
            return trans('rating::ratings.state.not_rated', ['count' => $criteria]);
        }

        $sum = $record->getAttribute('rating_morphs_sum_value');

        return trans('rating::ratings.state.rated', [
            'count' => $criteria,
            'total' => is_numeric($sum) ? (string) (0 + $sum) : '0',
        ]);
    }
}
