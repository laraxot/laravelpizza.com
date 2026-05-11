<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\Traits\HasAddress;

/**
 * Modello di test per il trait HasAddress.
 */
class TestModel extends Model
{
    use HasAddress;

    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    /**
     * Bootstrap this model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function (): void {
            if (! app()->environment('testing')) {
                throw new \Exception('TestModel should only be used in tests.');
            }
        });
    }
}
