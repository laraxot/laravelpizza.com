<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Database\Factories\PulseEntryFactory;

/**
 * @property string $id
 * @property int $timestamp
 * @property string $type
 * @property string $key
 * @property string|null $key_hash
 * @property int|null $value
 *
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 *
 * @method static PulseEntryFactory factory($count = null, $state = [])
 * @method static Builder<static>|PulseEntry newModelQuery()
 * @method static Builder<static>|PulseEntry newQuery()
 * @method static Builder<static>|PulseEntry query()
 * @method static Builder<static>|PulseEntry whereId($value)
 * @method static Builder<static>|PulseEntry whereKey($value)
 * @method static Builder<static>|PulseEntry whereKeyHash($value)
 * @method static Builder<static>|PulseEntry whereTimestamp($value)
 * @method static Builder<static>|PulseEntry whereType($value)
 * @method static Builder<static>|PulseEntry whereValue($value)
 *
 * @property-read ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class PulseEntry extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'type',
        'key',
        'value',
    ];
}
