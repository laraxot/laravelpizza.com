<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Rating\Models\Traits\HasLikes;

/**
 * Non sovrascrive `likesRelation`: esercita il morphMany del trait (richiede Like stub).
 */
final class LikeableNativeRelationStub extends Model
{
    use HasLikes;

    protected $table = 'likeable_native_stub';
}
