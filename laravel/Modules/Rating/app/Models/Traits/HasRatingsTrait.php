<?php

declare(strict_types=1);

namespace Modules\Rating\Models\Traits;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Rating\Models\BaseRating;
use Modules\Rating\Models\Rating;

/**
 * Trait HasRatingsTrait.
 *
 * @see Modules/Rating/docs/schemaless-attributes.md
 */
/** @phpstan-ignore trait.unused (Trade-off: usato da moduli esterni; PHPStan sul solo modulo Rating non vede i consumer.) */
trait HasRatingsTrait
{
    /**
     * @return class-string<BaseRating>
     */
    public function getRatingClass(): string
    {
        $ratingClass = (string) Str::of(static::class)
            ->before('\Models\\')
            ->append('\Models\Rating');

        if (is_a($ratingClass, BaseRating::class, true)) {
            return $ratingClass;
        }

        return Rating::class;
    }

    /**
     * Get ratings for this model.
     *
     * @return MorphToMany<Rating, static>
     */
    public function ratings(): MorphToMany
    {
        /** @var MorphToMany<Rating, static> $result */
        $result = $this->morphToMany(Rating::class, 'model', 'ratings', 'rating_morph');

        return $result;
    }

    /**
     * Get rating objectives with aggregated data.
     *
     * @return HasMany<BaseRating, static>
     */
    public function ratingObjectives(): HasMany
    {
        $relatedClass = $this->getRatingClass();
        $userId = (int) Auth::id();

        /** @var HasMany<BaseRating, static> $result */
        $result = $this->hasMany($relatedClass, 'related_type', 'post_type')
            ->selectRaw(
                'ratings.*,
                count(value) as rating_count,
                avg(value) as rating_avg,
                sum(if(user_id = ?, value, 0)) AS rating_my',
                [$userId]
            )->leftJoin(
                'rating_morph',
                function (\Illuminate\Database\Query\JoinClause $join): void {
                    $join->on('rating_morph.rating_id', 'ratings.id')
                        ->whereColumn('rating_morph.post_type', 'ratings.related_type')
                        ->where('rating_morph.post_id', $this->id);
                }
            )->groupBy('ratings.id')
            ->with('post');

        return $result;
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeWithRating(Builder $query): Builder
    {
        return $query->leftJoin(
            'rating_morph',
            function (\Illuminate\Database\Query\JoinClause $join): void {
                $join->on('rating_morph.post_type', '=', 'ratings.related_type');
            }
        );
    }

    /**
     * Get my ratings for this model.
     *
     * @return MorphToMany<Rating, static>
     */
    public function myRatings(): MorphToMany
    {
        /** @var MorphToMany<Rating, static> $result */
        $result = $this->morphToMany(Rating::class, 'model', 'ratings', 'rating_morph')
            ->wherePivot('user_id', (string) Auth::id());

        return $result;
    }

    // ----- mutators -----
    /**
     * @return Collection<int|string, mixed>
     */
    public function getMyRatingAttribute(): Collection
    {
        $myRatings = $this->myRatings;

        return $myRatings->pluck('pivot.rating', 'post_id');
    }

    /**
     * ----.
     */
    public function getRatingsAvgAttribute(?float $value): ?float
    {
        if (null !== $value) {
            return $value;
        }
        $value = $this->ratings->avg('pivot.rating');
        if (null !== $value) {
            // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
            if (null !== $this->getKey()) {
                $this->update(['ratings_avg' => $value]);
            }
        }

        return $value;
    }

    public function getRatingsCountAttribute(?int $value): ?int
    {
        if (null !== $value) {
            return $value;
        }
        $value = $this->ratings->count();
        $this->ratings_count = $value;

        // Guard: modello deve avere PK per salvare
        if (null == $this->getKey()) {
            return $value;
        }

        // ✅ Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['ratings_count' => $value]);

        return $value;
    }

    /**
     * Get ratings filtered by extra_attributes.
     *
     * @param array<string, mixed> $filters
     *
     * @return Collection<int, Rating>
     */
    public function getRatingsWhere(array $filters): Collection
    {
        $query = $this->ratings();

        foreach ($filters as $key => $filterValue) {
            $query->where("extra_attributes->{$key}", $filterValue);
        }

        /** @var Collection<int, Rating> $result */
        $result = $query->get();

        return $result;
    }

    /**
     * @param array<string, mixed> $where
     *
     * @return Collection<int, mixed>
     */
    public function syncRatingsWhere(array $where): Collection
    {
        $ratingClass = $this->getRatingClass();
        $ratings = $ratingClass::query()
            ->withExtraAttributes($where)
            ->get();

        $rating_ids = $ratings->modelKeys();
        $this->ratings()->sync($rating_ids);

        /** @var Collection<int, mixed> $result */
        $result = $this->ratings;

        return $result;
    }

    // */
    /*
        public function setMyRatingAttribute($value){
        dddx($value);
        }
    */
    // ------ functions ------
    /**
     * @throws FileNotFoundException
     * @throws \ReflectionException
     */
    public function ratingAvgHtml(): string
    {
        $pivot_avg = $this->ratings_avg;
        $pivot_cout = $this->ratings_count;

        $msg = '<div class="rateit" data-rateit-value="'.$pivot_avg.'" data-rateit-ispreset="true" data-rateit-readonly="true"></div>';
        $msg .= '('.$pivot_avg.') '.$pivot_cout.' Votes ';

        $rating_url = '#';
        $title = 'Vota '.(isset($this->title) ? (string) $this->title : '');

        $btn = '<button type="button" class="btn btn-red btn-danger" data-toggle="modal" data-target="#vueModal" data-title="'.$title.'" data-href="'.$rating_url.'">
        <span class="font-white"><i class="fa fa-star"></i> Vota ! </span>
        </button>';

        $btn_iframe = '<button type="button" class="btn btn-red btn-danger" data-toggle="modal" data-target="#vueIframeModal" data-title="'.$title.'" data-href="'.$rating_url.'">
        <span class="font-white"><i class="fa fa-star"></i> Vota ! </span>
        </button>';

        return $msg.$btn.$btn_iframe;
    }

    /**
     * @return array<string, string>
     */
    public function getRatingsRules(string $prefix, string $postfix): array
    {
        $rows = $this->ratings;
        $rules = $rows->mapWithKeys(function ($row) {
            $ruleValue = $row->rule instanceof \BackedEnum ? (string) $row->rule->value : (string) $row->rule;

            return [$row->id => $ruleValue];
        })->toArray();

        $rules = Arr::prependKeysWith($rules, $prefix);
        $res = [];
        foreach ($rules as $key => $ruleValue) {
            $keyWithPostfix = $key.$postfix;
            $ruleStr = (string) $ruleValue;

            // ✅ Se la regola è numeric o integer, aggiungi nullable se non presente
            if (Str::contains($ruleStr, ['numeric', 'integer']) && ! Str::contains($ruleStr, 'nullable')) {
                $ruleStr = 'nullable|'.$ruleStr;
            }

            $res[$keyWithPostfix] = $ruleStr;
        }

        return $res;
    }

    /**
     * @return array<string, string>
     */
    public function getRatingsValidationAttributes(string $prefix, string $postfix): array
    {
        $rows = $this->ratings;
        $res = [];
        foreach ($rows as $row) {
            $keyWithPostfix = $prefix.$row->id.$postfix;
            $res[$keyWithPostfix] = (string) $row->title;
        }

        return $res;
    }
}
