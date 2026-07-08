<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Rating\Models\Rating;
use Modules\Rating\Models\RatingMorph as PtvRatingMorphModel;
use Modules\User\Models\User;

/**
 * Modules\IndennitaResponsabilita\Models\RatingMorph
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $value
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $model_type
 * @property int|null $model_id
 * @property int|null $rating_id
 * @property-read Rating|null $rating
 * @method static Builder|RatingMorph newModelQuery()
 * @method static Builder|RatingMorph newQuery()
 * @method static Builder|RatingMorph query()
 * @method static Builder|RatingMorph whereCreatedAt($value)
 * @method static Builder|RatingMorph whereCreatedBy($value)
 * @method static Builder|RatingMorph whereId($value)
 * @method static Builder|RatingMorph whereModelId($value)
 * @method static Builder|RatingMorph whereModelType($value)
 * @method static Builder|RatingMorph whereNote($value)
 * @method static Builder|RatingMorph whereRatingId($value)
 * @method static Builder|RatingMorph whereUpdatedAt($value)
 * @method static Builder|RatingMorph whereUpdatedBy($value)
 * @method static Builder|RatingMorph whereUserId($value)
 * @method static Builder|RatingMorph whereValue($value)
 * @property int $is_winner
 * @property string $reward
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Profile|null $creator
 * @property-read Model|\Eloquent|null $model
 * @property-read Profile|null $profile
 * @property-read Profile|null $updater
 * @property-read User|null $user
 * @method static Builder<static>|RatingMorph whereDeletedAt($value)
 * @method static Builder<static>|RatingMorph whereDeletedBy($value)
 * @method static Builder<static>|RatingMorph whereIsWinner($value)
 * @method static Builder<static>|RatingMorph whereReward($value)
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class RatingMorph extends PtvRatingMorphModel
{
    protected $connection = 'indennita_responsabilita'; // this will use the specified database connection

    // -------------------------------------------------
}
