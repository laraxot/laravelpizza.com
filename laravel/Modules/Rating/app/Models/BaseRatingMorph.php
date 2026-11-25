<?php

declare(strict_types=1);

namespace Modules\Rating\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Modules\Rating\Models\RatingMorph.
 *
 * @property int $id
 * @property bool $is_winner
 * @property string|null $post_type
 * @property int|null $post_id
 * @property string|null $related_type
 * @property int|null $related_id
 * @property Rating|null $rating
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $auth_user_id
 *
 * @method static Builder|RatingMorph newModelQuery()
 * @method static Builder|RatingMorph newQuery()
 * @method static Builder|RatingMorph query()
 * @method static Builder|RatingMorph whereAuthUserId($value)
 * @method static Builder|RatingMorph whereCreatedAt($value)
 * @method static Builder|RatingMorph whereCreatedBy($value)
 * @method static Builder|RatingMorph whereDeletedBy($value)
 * @method static Builder|RatingMorph whereId($value)
 * @method static Builder|RatingMorph wherePostId($value)
 * @method static Builder|RatingMorph wherePostType($value)
 * @method static Builder|RatingMorph whereRating($value)
 * @method static Builder|RatingMorph whereRelatedId($value)
 * @method static Builder|RatingMorph whereRelatedType($value)
 * @method static Builder|RatingMorph whereUpdatedAt($value)
 * @method static Builder|RatingMorph whereUpdatedBy($value)
 *
 * @property string|null $user_id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property int $rating_id
 * @property int|null $value
 * @property string|null $note
 * @property string|null $deleted_at
 *
 * @method static Builder|RatingMorph whereDeletedAt($value)
 * @method static Builder|RatingMorph whereIsWinner($value)
 * @method static Builder|RatingMorph whereModelId($value)
 * @method static Builder|RatingMorph whereModelType($value)
 * @method static Builder|RatingMorph whereNote($value)
 * @method static Builder|RatingMorph whereRatingId($value)
 * @method static Builder|RatingMorph whereUserId($value)
 * @method static Builder|RatingMorph whereValue($value)
 *
 * @property Model|Eloquent $model
 * @property Model|null $profile
 * @property UserContract|null $user
 * @property string $reward
 *
 * @method static Builder|RatingMorph whereReward($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string $sum_credit_yes
 * @property string $sum_credit_no
 * @property int $count_credit_yes
 * @property int $count_credit_no
 * @property string $percentage
 *
 * @method static Builder<static>|RatingMorph whereCountCreditNo($value)
 * @method static Builder<static>|RatingMorph whereCountCreditYes($value)
 * @method static Builder<static>|RatingMorph whereHasYesNo($value)
 * @method static Builder<static>|RatingMorph wherePercentage($value)
 * @method static Builder<static>|RatingMorph whereSumCreditNo($value)
 * @method static Builder<static>|RatingMorph whereSumCreditYes($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin Eloquent
 */
abstract class BaseRatingMorph extends BaseMorphPivot
{
    // Laravel auto-pluralizes 'RatingMorph' → 'rating_morphs', but the migration creates 'rating_morph'
    protected $table = 'rating_morph';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'model_id', 'model_type',
        'rating_id',
        'user_id',
        'note',
        'value',
        'is_winner',
        'reward',
    ];
    // -------- RELATIONSHIP -----------

    /**
     * Il criterio sta nella tabella `ratings` dello stesso modulo (e connection) del pivot:
     * `Modules\{Modulo}\Models\Rating` se esiste, altrimenti quello del modulo Rating. Prima
     * puntava sempre a Rating\Models\Rating (connection `rating`): per Progressioni, IR, ICL, Ptv
     * leggeva i criteri di un altro database.
     *
     * @return BelongsTo<BaseRating, $this>
     */
    public function rating(): BelongsTo
    {
        return $this->belongsTo(static::getRatingClass(), 'rating_id');
    }

    /**
     * @return class-string<BaseRating>
     */
    public static function getRatingClass(): string
    {
        $module = Str::before(Str::after(static::class, 'Modules\\'), '\\');
        $class = 'Modules\\'.$module.'\\Models\\Rating';

        return class_exists($class) && is_subclass_of($class, BaseRating::class) ? $class : Rating::class;
    }

    /**
     * @return BelongsTo<Model&UserContract, $this>
     */
    public function user(): BelongsTo
    {
        $user_class = XotData::make()->getUserClass();

        return $this->belongsTo($user_class, 'user_id');
    }

    /**
     * @return BelongsTo<Model&ProfileContract, $this>
     */
    public function profile(): BelongsTo
    {
        $profile_class = XotData::make()->getProfileClass();

        return $this->belongsTo($profile_class, 'user_id', 'user_id');
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function model(): MorphTo
    {
        return $this->morphTo('model');
    }
}
