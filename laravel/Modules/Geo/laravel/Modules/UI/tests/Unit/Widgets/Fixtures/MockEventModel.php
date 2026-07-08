<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Widgets\Fixtures;

use Illuminate\Database\Eloquent\Model;

class MockEventModel extends Model
{
    protected $fillable = ['title', 'start', 'end', 'color'];

    public function getTable(): string
    {
        return 'mock_events';
    }
}
