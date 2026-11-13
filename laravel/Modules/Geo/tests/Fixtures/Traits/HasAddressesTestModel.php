<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Traits\HasAddresses;

/**
 * Model fixture for the HasAddresses contract.
 */
final class HasAddressesTestModel extends BaseModel
{
    use HasAddresses;

    protected $table = 'test_models';

    public $timestamps = false;
}
