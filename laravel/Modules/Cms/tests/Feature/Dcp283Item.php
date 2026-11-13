<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Dcp283Item extends Model
{
    public $timestamps = false;

    protected $connection = 'dcp283';

    protected $table = 'dcp283_items';

    protected $guarded = [];

    #[\Override]
    protected static function booted(): void
    {
        self::addGlobalScope('dcp283-visible', static function (Builder $query): void {
            $query->where('visible', true);
        });
    }
}
