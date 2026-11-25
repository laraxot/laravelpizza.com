<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Modules\Xot\Contracts\ExtraContract;

/**
 * Minimal ExtraContract stub for HasExtraTrait tests.
 *
 * @property Collection<string, mixed> $extra_attributes
 */
class HasExtraMockExtra extends Model implements ExtraContract
{
    protected $table = 'has_extra_mock_extras';

    /** @var list<string> */
    protected $fillable = ['extra_attributes'];

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function withAttributes(array $attributes): self
    {
        $extra = new self;
        $extra->extra_attributes = collect($attributes);

        return $extra;
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
