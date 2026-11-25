<?php

declare(strict_types=1);

namespace Modules\Rating\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Like model for polymorphic likes/favorites.
 *
 * @property int|string $id
 * @property int|string $user_id
 * @property int|string $likeable_id
 * @property string $likeable_type
 */
class Like extends BaseModel
{
    /** @var string */
    protected $table = 'likes';

    /** @var list<string> */
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
    ];

    /**
     * @return MorphTo<Model, $this>
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
