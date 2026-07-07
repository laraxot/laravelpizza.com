<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;

class ProbeBadAttachments extends Model
{
    protected $guarded = [];

    public static function getAttachments(): string
    {
        return 'invalid';
    }
}
