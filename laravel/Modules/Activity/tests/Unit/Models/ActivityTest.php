<?php

declare(strict_types=1);

use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('activity model can be created', function () {
    $activity = ActivityFactory::new()->make();

    Assert::assertInstanceOf(Activity::class, $activity);
});

test('activity model can be saved and retrieved', function () {
    $activity = ActivityFactory::new()->createOne([
        'description' => 'Test action',
        'event' => 'test_event',
    ]);

    $retrieved = Activity::find($activity->id);

    Assert::assertInstanceOf(Activity::class, $retrieved);
    Assert::assertSame('Test action', $retrieved->description);
    Assert::assertSame('test_event', $retrieved->event);
});

test('activity model has expected attributes', function () {
    $activity = ActivityFactory::new()->make();

    // Testiamo solo alcuni attributi per verificare che il modello funzioni
    // Siccome non possiamo usare toHaveProperty direttamente su Eloquent models, usiamo isset
    Assert::assertTrue(isset($activity->description));
    Assert::assertTrue(isset($activity->event));
});
