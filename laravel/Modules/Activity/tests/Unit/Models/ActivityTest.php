<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Models\Activity;

test('activity model can be created', function () {
    $activity = Activity::factory()->make();

    expect($activity)->toBeInstanceOf(Activity::class);
});

test('activity model can be saved and retrieved', function () {
    // dd(DB::connection('activity')->getDatabaseName());
    $activity = Activity::factory()->create([
        'description' => 'Test action',
        'event' => 'test_event',
    ]);

    $retrieved = Activity::find($activity->id);

    expect($retrieved)->toBeInstanceOf(Activity::class)
        ->and($retrieved->description)->toBe('Test action')
        ->and($retrieved->event)->toBe('test_event');
});

test('activity model has expected attributes', function () {
    $activity = Activity::factory()->make();

    // Testiamo solo alcuni attributi per verificare che il modello funzioni
    // Siccome non possiamo usare toHaveProperty direttamente su Eloquent models, usiamo isset
    expect(isset($activity->description))->toBeTrue()
        ->and(isset($activity->event))->toBeTrue();
});
