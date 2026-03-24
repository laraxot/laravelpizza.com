<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Modules\Xot\Models\XotBaseModel;

/**
 * Base Model for Activity module.
 *
 * Extends XotBaseModel which provides:
 * - Standard properties (snakeAttributes, incrementing, timestamps, perPage, etc.)
 * - HasXotFactory trait
 * - Updater trait
 * - Standard casts (published_at, timestamps, audit fields)
 *
 * @see \Modules\Xot\Models\XotBaseModel
 */
abstract class BaseModel extends XotBaseModel
{
    /**
     * The connection name for the model.
     *
     * This is the ONLY property specific to Activity module.
     *
     * @var string
     */
    protected $connection = 'activity';

    /**
     * Get the attributes that should be cast.
     *
     * Extends parent casts with Activity-specific fields.
     * Common casts (id, uuid, published_at, created_at, updated_at, deleted_at, etc.)
     * are inherited from XotBaseModel.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            // Module-specific casts only
        ]);
    }
}
