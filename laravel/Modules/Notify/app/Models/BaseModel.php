<?php

declare(strict_types=1);

namespace Modules\Notify\Models;

use Modules\Xot\Models\XotBaseModel;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel implements HasMedia
{
    use InteractsWithMedia;

    public $incrementing = true;

    public $timestamps = true;

<<<<<<< HEAD
    protected $perPage = 30;

=======
>>>>>>> 40b96bcd6 (.)
    protected $connection = 'notify';

    /** @var list<string> */
    protected $appends = [];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    /** @var list<string> */
<<<<<<< HEAD
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
=======
    protected $hidden = [];
>>>>>>> 40b96bcd6 (.)

    /** @return array<string, string> */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'published_at' => 'datetime',
        ]);
    }
}
