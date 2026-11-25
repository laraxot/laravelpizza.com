<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Stub di test: `HasLikes` referenzia `Modules\Rating\Models\Like`, assente nel tree app.
 * Caricato solo dai test Unit (require_once) per esercitare `likesRelation()` / boot.
 *
 * @see Traits\HasLikes
 */
class Like extends Model
{
    protected $table = 'likes';

    public $timestamps = false;

    /** @var list<string> */
    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];
}
