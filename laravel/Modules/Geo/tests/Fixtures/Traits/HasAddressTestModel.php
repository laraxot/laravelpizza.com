<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\HasAddress;

/**
 * Modello di test per il trait HasAddress (solo fixture — i test Pest stanno in HasAddressTest.php).
 */
final class HasAddressTestModel extends BaseModel
{
    /** @use HasAddress<HasAddressTestModel> */
    use HasAddress;

    /** @var list<string> */
    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function (): void {
            if (! app()->environment('testing')) {
                throw new \Exception('HasAddressTestModel should only be used in tests.');
            }
        });
    }
}
