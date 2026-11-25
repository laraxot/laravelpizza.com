<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Modules\Rating\Models\AbstractRatingsHost;
use Modules\Rating\Models\BaseRating;
use Modules\Rating\Models\Rating;

/**
 * Host di test (richiesto da XotBaseModel::getClassName()).
 * Caricato solo dai Unit test via require_once.
 */
class RatingsHostStub extends AbstractRatingsHost
{
    protected $table = 'ratings_host_stub';

    /** @var list<string> */
    protected $fillable = ['title', 'ratings_avg', 'ratings_count', 'post_type'];

    /** @var MorphToMany<Rating, $this, MorphPivot, 'pivot'>|null */
    public ?MorphToMany $forcedMorph = null;

    /**
     * Relazione forzata dai test: `ratingMorphs()` la legge come
     * `HasMany<MorphPivot, ...>`, `hasMany(Rating::class)`/`ratingObjectives()`
     * come `HasMany<Rating, ...>` (es. mock Mockery nei test).
     *
     * @var HasMany<MorphPivot, static>|HasMany<Rating, static>|null
     */
    public ?HasMany $forcedHasMany = null;

    /**
     * Stessa firma di `RelationX::morphToManyX()`: il pivot lo deduce il parent per convenzione
     * (`guessMorphPivot`), `$pivotClass` esplicito ha priorità.
     *
     * @template TRelatedModel of Model
     * @template TPivot of MorphPivot
     *
     * @param  class-string<TRelatedModel>  $related
     * @param  class-string<TPivot>|null  $pivotClass
     * @return MorphToMany<TRelatedModel, $this, ($pivotClass is null ? MorphPivot : TPivot), 'pivot'>
     */
    public function morphToManyX(
        string $related,
        string $name,
        ?string $_table = null,
        ?string $foreignPivotKey = null,
        ?string $relatedPivotKey = null,
        ?string $parentKey = null,
        ?string $relatedKey = null,
        ?string $relation = null,
        bool $inverse = false,
        ?string $pivotClass = null,
    ): MorphToMany {
        if ($this->forcedMorph instanceof MorphToMany) {
            /** @var MorphToMany<TRelatedModel, $this, ($pivotClass is null ? MorphPivot : TPivot), 'pivot'> $forcedMorph */
            $forcedMorph = $this->forcedMorph;

            return $forcedMorph;
        }

        return parent::morphToManyX(
            $related,
            $name,
            $_table,
            $foreignPivotKey,
            $relatedPivotKey,
            $parentKey,
            $relatedKey,
            $relation,
            $inverse,
            $pivotClass,
        );
    }

    /**
     * Bypassa `Rating::getClassName()` (risoluzione via `debug_backtrace`, verificata
     * fragile/ambientale su questa macchina — vedi nota nel test) quando il test forza
     * esplicitamente la relazione, stesso pattern di `morphToManyX()` sopra.
     *
     * @return MorphToMany<BaseRating, static, MorphPivot, 'pivot'>
     */
    public function ratings(): MorphToMany
    {
        if ($this->forcedMorph instanceof MorphToMany) {
            /** @var MorphToMany<BaseRating, static, MorphPivot, 'pivot'> $forcedMorph */
            $forcedMorph = $this->forcedMorph;

            return $forcedMorph;
        }

        return parent::ratings();
    }

    /**
     * Evita Rating::getClassName()/guessMorphPivot nei unit (backtrace fragile).
     *
     * @return HasMany<MorphPivot, static>
     */
    public function ratingMorphs(): HasMany
    {
        if ($this->forcedHasMany instanceof HasMany) {
            /** @var HasMany<MorphPivot, static> $forcedHasMany */
            $forcedHasMany = $this->forcedHasMany;

            return $forcedHasMany;
        }

        return parent::ratingMorphs();
    }

    /**
     * @template TRelatedModel of Model
     *
     * @param  class-string<TRelatedModel>  $related
     * @return HasMany<TRelatedModel, $this>
     */
    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        if ($this->forcedHasMany instanceof HasMany) {
            /** @var HasMany<TRelatedModel, $this> $forcedHasMany */
            $forcedHasMany = $this->forcedHasMany;

            return $forcedHasMany;
        }

        return parent::hasMany($related, $foreignKey, $localKey);
    }
}
