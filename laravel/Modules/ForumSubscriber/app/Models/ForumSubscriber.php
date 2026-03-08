<?php

namespace Modules\ForumSubscriber\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ForumSubscriber\Database\Factories\ForumSubscriberFactory;

class ForumSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'forum_id',
        'subscription_type',
        'created_at',
    ];

    protected static function newFactory()
    {
        return ForumSubscriberFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\App\Models\User::class);
    }

    public function forum()
    {
        return $this->belongsTo(\Modules\Cms\App\Models\Forum::class);
    }
}