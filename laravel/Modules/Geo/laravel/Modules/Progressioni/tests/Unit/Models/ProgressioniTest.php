<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Progressioni\Models\CriteriOption;
use Modules\Progressioni\Models\Progressioni;
use Modules\Ptv\Models\Contracts\SchedaContract;

test('progressioni model extends correct base model', function () {
    $model = new Progressioni;
    expect($model)->toBeInstanceOf(Progressioni::class);
    // Verify it implements the SchedaContract interface
    expect($model)->toBeInstanceOf(SchedaContract::class);
});

test('progressioni has correct table name', function () {
    $model = new Progressioni;
    expect($model->getTable())->toBe('progressioni');
});

test('progressioni has correct fillable attributes', function () {
    $model = new Progressioni;
    $fillable = $model->getFillable();

    // Check a subset of expected fillable attributes
    expect($fillable)->toContain('stabi');
    expect($fillable)->toContain('anno');
    expect($fillable)->toContain('cognome');
    expect($fillable)->toContain('nome');
    expect($fillable)->toContain('ha_diritto');
    expect($fillable)->toContain('motivo');
});

test('progressioni has correct attribute casts', function () {
    $model = new Progressioni;
    $casts = $model->getCasts();

    // Check expected casts
    expect($casts)->toHaveKey('created_at');
    expect($casts)->toHaveKey('updated_at');
    expect($casts)->toHaveKey('data_assunzione');
    expect($casts['data_assunzione'])->toBe('datetime');

    // Check boolean casts
    expect($casts)->toHaveKey('has_assenze_lunghe');
    expect($casts['has_assenze_lunghe'])->toBe('boolean');
});

test('progressioni has valutazione relationship', function () {
    $model = Mockery::mock(Progressioni::class)->makePartial();

    // Mock the valutazione relationship
    $mockRelation = Mockery::mock(BelongsTo::class);
    $model->shouldReceive('belongsTo')->andReturn($mockRelation);

    $relation = $model->valutazione();
    expect($relation)->toBe($mockRelation);
});

test('progressioni has criteriOption relationship', function () {
    $model = Mockery::mock(Progressioni::class)->makePartial();

    // Mock the criteriOption relationship
    $mockRelation = Mockery::mock(BelongsToMany::class);
    $model->shouldReceive('belongsToMany')
        ->with(CriteriOption::class, 'progressioni_criteri_option', 'progressioni_id', 'criteri_option_id')
        ->andReturn($mockRelation);

    $relation = $model->criteriOption();
    expect($relation)->toBe($mockRelation);
});

test('getFullNameAttribute returns concatenated name', function () {
    $model = new Progressioni;
    $model->nome = 'Mario';
    $model->cognome = 'Rossi';

    expect($model->full_name)->toBe('Mario Rossi');
});

test('getFullNameAttribute handles null values', function () {
    $model = new Progressioni;
    $model->nome = null;
    $model->cognome = 'Rossi';

    expect($model->full_name)->toBe(' Rossi');

    $model->nome = 'Mario';
    $model->cognome = null;

    expect($model->full_name)->toBe('Mario ');
});

test('getHasAssenzeAttribute calculates absence status correctly', function () {
    $model = new Progressioni;

    // Test case: No absences
    $model->gg_assenza = 0;
    expect($model->has_assenze)->toBeFalse();

    // Test case: With absences
    $model->gg_assenza = 10;
    expect($model->has_assenze)->toBeTrue();
});

test('getHasAssenzeLungheAttribute calculates long absence status correctly', function () {
    $model = new Progressioni;

    // Test case: No long absences
    $model->gg_assenza = 30; // Below threshold
    expect($model->has_assenze_lunghe)->toBeFalse();

    // Test case: With long absences
    $model->gg_assenza = 61; // Above threshold
    expect($model->has_assenze_lunghe)->toBeTrue();
});

test('getAnzianitaAttribute calculates seniority correctly', function () {
    $model = new Progressioni;
    $model->data_assunzione = now()->subYears(5)->format('Y-m-d');
    $model->anno = now()->year;

    // This is an incomplete test as it needs actual calculation logic verification
    $this->markTestIncomplete(
        'This test needs actual calculation logic verification based on business rules'
    );
});

test('scopeFilterByAnno applies year filter correctly', function () {
    // Mock the query builder
    $builder = Mockery::mock('Illuminate\Database\Eloquent\Builder');
    $builder->shouldReceive('where')
        ->with('anno', 2023)
        ->once()
        ->andReturnSelf();

    // Call the scope method
    Progressioni::filterByAnno($builder, 2023);

    // The assertion is implicit in the mock expectations
});

test('scopeFilterByStabi applies stabi filter correctly', function () {
    // Mock the query builder
    $builder = Mockery::mock('Illuminate\Database\Eloquent\Builder');
    $builder->shouldReceive('where')
        ->with('stabi', 101)
        ->once()
        ->andReturnSelf();

    // Call the scope method
    Progressioni::filterByStabi($builder, 101);

    // The assertion is implicit in the mock expectations
});

test('isEligible returns correct status', function () {
    $model = new Progressioni;

    // Test case: Eligible
    $model->ha_diritto = 1;
    expect($model->isEligible())->toBeTrue();

    // Test case: Not eligible
    $model->ha_diritto = 0;
    expect($model->isEligible())->toBeFalse();

    // Test case: Null (undetermined)
    $model->ha_diritto = null;
    expect($model->isEligible())->toBeNull();
});

test('getBusinessStateText returns correct status text', function () {
    $model = new Progressioni;

    // Test case: Eligible
    $model->ha_diritto = 1;
    expect($model->getBusinessStateText())->toEqual('Idoneo');

    // Test case: Not eligible
    $model->ha_diritto = 0;
    expect($model->getBusinessStateText())->toEqual('Non idoneo');

    // Test case: Null (undetermined)
    $model->ha_diritto = null;
    expect($model->getBusinessStateText())->toEqual('Da verificare');
});

// Integration tests that would require database setup
test('refreshHaDiritto updates eligible status', function () {
    $this->markTestIncomplete(
        'This test requires integration testing with database'
    );
});

test('attachCriteriOption adds exclusion criteria correctly', function () {
    $this->markTestIncomplete(
        'This test requires integration testing with database'
    );
});

test('detachCriteriOption removes exclusion criteria correctly', function () {
    $this->markTestIncomplete(
        'This test requires integration testing with database'
    );
});

// Clean up after tests
afterEach(function () {
    if (class_exists('Mockery')) {
        Mockery::close();
    }
});
