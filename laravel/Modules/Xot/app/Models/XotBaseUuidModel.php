<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

/**
 * Class XotBaseUuidModel.
 *
 * Base class for models using UUIDs.
 */
abstract class XotBaseUuidModel extends XotBaseModel
{
    public $incrementing = false;

    /** @var bool */
    public $timestamps = true;

    /** @var int */
    protected $perPage = 30;

    protected $keyType = 'string';

    /** @var list<string> */
    protected $fillable = [
        'id',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}
