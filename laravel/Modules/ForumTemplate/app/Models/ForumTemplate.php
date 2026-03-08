<?php

namespace Modules\ForumTemplate\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\App\Models\User;

class ForumTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'content',
        'author_id',
        'forum_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function forum()
    {
        return $this->belongsTo(\Modules\Cms\App\Models\Forum::class, 'forum_id');
    }
}