<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Traits\HasSchemalessAttributes;

class SchemalessTestModel extends XotBaseModel
{
    use HasSchemalessAttributes;

    public $extra_attributes;

    public bool $saved = false;

    public function save(array $options = [])
    {
        $this->saved = true;

        return true;
    }
}
