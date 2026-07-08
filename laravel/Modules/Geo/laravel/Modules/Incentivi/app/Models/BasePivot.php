<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// //use Laravel\Scout\Searchable;
use Modules\Xot\Traits\Updater;

/**
 * Class BasePivot.
 */
abstract class BasePivot extends Pivot
{
    use Updater;

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
<<<<<<< HEAD:laravel/Modules/Incentivi/app/Models/BasePivot.php
     * @see https://laravel-news.com/6-eloquent-secrets
     *
     * @var bool
=======
     * @see  https://laravel-news.com/6-eloquent-secrets
>>>>>>> 74bf6abe2 (.):app/Models/BasePivot.php
     */
    public static $snakeAttributes = true;

    public $incrementing = true;

    protected $perPage = 30;

    // use Searchable;

<<<<<<< HEAD:laravel/Modules/Incentivi/app/Models/BasePivot.php
    /** @var string */
    protected $connection = 'incentivi';
=======
    protected $connection = 'geo';
>>>>>>> 74bf6abe2 (.):app/Models/BasePivot.php

    /** @var list<string> */
    protected $appends = [];

    /** @return array<string, string> */
    public function casts(): array
    {
        return [
            'id' => 'string', // must be string else primary key of related model will be typed as int
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',

            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }

    /**
     * Undocumented variable.
     */
    protected $primaryKey = 'id';
}
