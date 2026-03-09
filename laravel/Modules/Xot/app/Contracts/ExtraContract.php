<?php

/**
 * @see https://github.com/buyersclub/laravel-eloquent-model-interface/blob/master/src/EloquentModelInterface.php
 */

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\SchemalessAttributes\SchemalessAttributes;

/**
 * Modules\Xot\Contracts\ExtraContract.
 *
 * @property SchemalessAttributes $extra_attributes
 *
 * @method static Builder|ExtraContract newModelQuery()
 * @method static Builder|ExtraContract newQuery()
 * @method static Builder|ExtraContract query()
 * @method static Builder|ExtraContract withExtraAttributes()
 *
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder|ExtraContract whereCreatedAt($value)
 * @method static Builder|ExtraContract whereCreatedBy($value)
 * @method static Builder|ExtraContract whereDeletedAt($value)
 * @method static Builder|ExtraContract whereDeletedBy($value)
 * @method static Builder|ExtraContract whereExtraAttributes($value)
 * @method static Builder|ExtraContract whereId($value)
 * @method static Builder|ExtraContract whereModelId($value)
 * @method static Builder|ExtraContract whereModelType($value)
 * @method static Builder|ExtraContract whereUpdatedAt($value)
 * @method static Builder|ExtraContract whereUpdatedBy($value)
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface ExtraContract {}
