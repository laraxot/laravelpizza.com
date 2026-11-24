<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Models\Traits\HasXotFactory;
use PHPUnit\Framework\Assert;
use Spatie\EventSourcing\Snapshots\EloquentSnapshot as SpatieSnapshot;

