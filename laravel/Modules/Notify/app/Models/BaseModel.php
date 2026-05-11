<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Factory\GetFactoryAction;
use Modules\Xot\Traits\Updater;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends Model implements HasMedia
{
    // use Searchable;
    use HasFactory;
    use InteractsWithMedia;
    use Updater;

    public $incrementing = true;

    public $timestamps = true;

    protected $perPage = 30;

    protected $connection = 'notify';

    /** @var list<string> */
    protected $appends = [];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    /** @var list<string> */
    protected $hidden = [
        // 'password'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return app(GetFactoryAction::class)->execute(static::class);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'published_at' => 'datetime',
            'verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
