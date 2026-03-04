<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Xot\Contracts\ExtraContract;

class ExtraModelTest extends Model implements ExtraContract
{
    protected $table = 'test_extras';

    protected $fillable = ['model_id', 'model_type', 'extra_attributes'];

    protected function casts(): array
    {
        return [
            'extra_attributes' => 'collection',
        ];
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
