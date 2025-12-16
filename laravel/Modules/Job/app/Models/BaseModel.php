<?php

declare(strict_types=1);

namespace Modules\Job\Models;

use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class BaseModel.
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 */
abstract class BaseModel extends XotBaseModel
{
    /** @var string */
    protected $connection = 'job';

    /*
    public function __construct(array $attributes = [])
    {
        if (isset($this->prefix)) {
            $this->table = $this->prefix.$this->table;
        }

        parent::__construct($attributes);
    }
    */
    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
