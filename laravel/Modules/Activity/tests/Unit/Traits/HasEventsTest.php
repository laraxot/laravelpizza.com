<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Modules\Activity\Traits\HasEvents;

uses(TestCase::class);

function makeHasEventsDummyModel(): Model
{
    return new class extends Model {
        use HasEvents;

        protected $table = 'activity_dummy_models';

        public $timestamps = false;
    };
}

test('stored events relation is configured as morphMany', function () {
    $model = makeHasEventsDummyModel();
    $relation = $model->storedEvents();

    expect($relation)->toBeInstanceOf(MorphMany::class)
        ->and($relation->getRelated()::class)->toBe(StoredEvent::class);
});

test('snapshots relation is configured as morphMany', function () {
    $model = makeHasEventsDummyModel();
    $relation = $model->snapshots();

    expect($relation)->toBeInstanceOf(MorphMany::class)
        ->and($relation->getRelated()::class)->toBe(Snapshot::class);
});
