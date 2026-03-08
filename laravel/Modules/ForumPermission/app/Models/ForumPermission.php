<?php

namespace Modules\ForumPermission\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\App\Models\User;

class ForumPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'forum_id',
        'role_id',
        'can_create_post',
        'can_edit_post',
        'can_delete_post',
        'can_create_thread',
        'can_edit_thread',
        'can_delete_thread',
        'can_reply',
        'can_edit_reply',
        'can_delete_reply',
        'can_moderate',
    ];

    protected $casts = [
        'can_create_post' => 'boolean',
        'can_edit_post' => 'boolean',
        'can_delete_post' => 'boolean',
        'can_create_thread' => 'boolean',
        'can_edit_thread' => 'boolean',
        'can_delete_thread' => 'boolean',
        'can_reply' => 'boolean',
        'can_edit_reply' => 'boolean',
        'can_delete_reply' => 'boolean',
        'can_moderate' => 'boolean',
    ];

    public function forum()
    {
        return $this->belongsTo(\Modules\Cms\App\Models\Forum::class, 'forum_id');
    }

    public function role()
    {
        return $this->belongsTo(\Modules\User\App\Models\Role::class, 'role_id');
    }
}