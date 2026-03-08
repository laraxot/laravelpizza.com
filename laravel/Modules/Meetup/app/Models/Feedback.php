<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Models\User;

/**
 * @property int $id
 * @property int $user_id
 * @property int $event_id
 * @property int $rating
 * @property string|null $comment
 * @property User|null $user
 * @property Event|null $event
 */
class Feedback extends BaseModel
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'event_id',
        'rating',
        'comment',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
