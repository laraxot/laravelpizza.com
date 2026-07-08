<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Ptv\Models\BaseScheda;
use Modules\Sigma\Models\BaseModel;
use Modules\Sigma\Models\Contracts\DateRangeFieldsContract;
use Modules\Sigma\Models\Contracts\EnteMatrFieldsContract;

/**
 * Helper HasMany/HasOne ente+matr per modelli che implementano {@see EnteMatrFieldsContract}.
 *
 * Usato da Sigma {@see BaseModel} e da {@see BaseScheda}
 * (schede Ptv/Progressioni che compongono trait Sigma con @phpstan-require-implements).
 */
trait HasEnteMatrRelationHelpers
{
    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TModel>  $related
     * @return HasMany<TModel, $this>
     */
    protected function hasManyByEnteMatr(
        string $related,
        string $relatedMatrColumn = 'matr',
        string $relatedEnteColumn = 'ente',
    ): HasMany {
        $matrField = $this->matrField();
        $enteField = $this->enteField();

        /** @var HasMany<TModel, $this> $relation */
        $relation = $this->hasMany($related, $relatedMatrColumn, $matrField)
            ->where($relatedEnteColumn, $this->{$enteField});

        return $this->applyRelatedActiveAnnFilter($relation, $related);
    }

    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  HasMany<TModel, $this>  $relation
     * @param  class-string<TModel>  $related
     * @return HasMany<TModel, $this>
     */
    protected function applyRelatedActiveAnnFilter(HasMany $relation, string $related): HasMany
    {
        if (! is_a($related, DateRangeFieldsContract::class, true)) {
            return $relation;
        }

        /** @var DateRangeFieldsContract&Model $instance */
        $instance = new $related;

        return $relation->where($instance->annFieldName(), '');
    }

    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TModel>  $related
     * @return HasOne<TModel, $this>
     */
    protected function hasOneByEnteMatr(
        string $related,
        string $relatedMatrColumn = 'matr',
        string $relatedEnteColumn = 'ente',
    ): HasOne {
        $matrField = $this->matrField();
        $enteField = $this->enteField();

        /** @var HasOne<TModel, $this> $relation */
        $relation = $this->hasOne($related, $relatedMatrColumn, $matrField)
            ->where($relatedEnteColumn, $this->{$enteField});

        return $relation;
    }
}
