<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use ValueError;

/**
 * Model di fixture: attributesToArray lancia ValueError (catturato da SafeArrayByModelCastAction).
 */
final class BrokenAttributesModelForSafeArrayCast extends Model
{
    public $incrementing = false;

    protected $table = 'broken_attrs_safe_array';

    /**
     * @return array<string, mixed>
     */
    public function attributesToArray(): array
    {
        throw new ValueError('Mock error');
    }

    /**
     * @return array<string, mixed>
     */
    public function getAttributes(): array
    {
        return ['name' => 'Fallback'];
    }

    public function getAttribute($key): mixed
    {
        return $key === 'name' ? 'Fallback' : null;
    }
}
