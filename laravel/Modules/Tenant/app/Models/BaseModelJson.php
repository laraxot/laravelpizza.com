<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Tenant\Models\Traits\SushiToJson;

/**
 * Class BaseModelJson.
 *
 * @property array<string, mixed> $form
 * @property array<string, mixed> $schema
 */
abstract class BaseModelJson extends BaseModel implements HasSushiToJson
{
    use SushiToJson;
}
