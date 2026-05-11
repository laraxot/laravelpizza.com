<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\HasAddress;

/**
 * Modello di test per il trait HasAddress.
 */
class HasAddressTest extends BaseModel
{
    use HasAddress;

    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    /**
     * Override connection for testing - use default connection.
     */
    protected $connection;

    /**
     * Bootstrap this model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function () {
            if (! app()->environment('testing')) {
                throw new \Exception('TestModel should only be used in tests.');
            }
        });
    }
}
