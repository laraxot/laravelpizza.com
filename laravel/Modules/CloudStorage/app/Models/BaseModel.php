<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Models;

use Modules\Xot\Models\XotBaseModel;

/**
 * Base Model for CloudStorage module.
 *
 * Extends XotBaseModel which provides all standard properties and casts.
 *
 * @see \Modules\Xot\Models\XotBaseModel
 */
abstract class BaseModel extends XotBaseModel
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'cloudstorage';
}
