<?php

declare(strict_types=1);

namespace Modules\UI\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\UI\Database\Factories\FieldOptionFactory;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\BaseModel;

/**
 * FieldOption model for UI module.
 * FormBuilder module not available - extending from XotBaseModel instead.
 */
/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static FieldOptionFactory factory($count = null, $state = [])
 * @method static Builder<static>|FieldOption newModelQuery()
 * @method static Builder<static>|FieldOption newQuery()
 * @method static Builder<static>|FieldOption query()
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class FieldOption extends BaseModel
{
    protected $table = 'field_options';

    /** @var list<string> */
    protected $fillable = [
        'field_id',
        'label',
        'value',
        'order',
    ];
}
