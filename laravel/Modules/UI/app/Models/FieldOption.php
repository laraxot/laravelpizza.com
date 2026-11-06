<?php

declare(strict_types=1);

namespace Modules\UI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\BaseModel;

/**
 * FieldOption model for UI module.
 *
 * FormBuilder module not available - extending from XotBaseModel instead.
 *
 * @method static \Modules\UI\Database\Factories\FieldOptionFactory factory($count = null, $state = [])
 * @method static Builder<static>|FieldOption newModelQuery()
 * @method static Builder<static>|FieldOption newQuery()
 * @method static Builder<static>|FieldOption query()
 *
 * @property int $id
 * @property string|null $field_id
 * @property string|null $label
 * @property string|null $value
 * @property int $order
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static>|FieldOption whereCreatedAt($value)
 * @method static Builder<static>|FieldOption whereCreatedBy($value)
 * @method static Builder<static>|FieldOption whereDeletedAt($value)
 * @method static Builder<static>|FieldOption whereDeletedBy($value)
 * @method static Builder<static>|FieldOption whereFieldId($value)
 * @method static Builder<static>|FieldOption whereId($value)
 * @method static Builder<static>|FieldOption whereLabel($value)
 * @method static Builder<static>|FieldOption whereOrder($value)
 * @method static Builder<static>|FieldOption whereUpdatedAt($value)
 * @method static Builder<static>|FieldOption whereUpdatedBy($value)
 * @method static Builder<static>|FieldOption whereValue($value)
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
