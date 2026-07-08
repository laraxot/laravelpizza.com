<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Modules\Xot\Traits\Updater;

abstract class BaseMorphPivot extends MorphPivot
{
    use Updater;

    protected $connection = 'ptv'; // this will use the specified database connection

    protected $appends = [];

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'id',
        'post_id', 'post_type',
        'related_type',
        'user_id',
        'note',
    ];

    public function casts(): array
    {
        return [
            'created_at' => 'datetime', 'updated_at' => 'datetime', 'deleted_at' => 'datetime',
        ];
    }
}
