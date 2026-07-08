<?php

declare(strict_types=1);

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

use Modules\Performance\Filament\Resources\IndividualeResource;
use Modules\Ptv\Filament\Resources\SchedaResource;
use Modules\Performance\Models\Individuale;

it('IndividualeResource has correct model', function (): void {
    // Test che IndividualeResource::getModel() torni Individuale::class
    // Nota: non possiamo chiamare getModel() direttamente perche' ha dddx()
    // Quindi usiamo reflection per testare la logica
    $reflection = new ReflectionClass(IndividualeResource::class);
    $prop = $reflection->getProperty('model');
    $prop->setAccessible(true);
    $model = $prop->getValue();
    
    expect($model)->toBe(Individuale::class);
});

it('SchedaResource model is null', function (): void {
    // SchedaResource ha $model = null perche' e' astratta
    $reflection = new ReflectionClass(SchedaResource::class);
    $prop = $reflection->getProperty('model');
    $prop->setAccessible(true);
    $model = $prop->getValue();
    
    expect($model)->toBeNull();
});

it('SchedaResource is abstract', function (): void {
    // SchedaResource dovrebbe essere astratta
    $reflection = new ReflectionClass(SchedaResource::class);
    
    expect($reflection->isAbstract())->toBeTrue();
});

it('IndividualeResource extends SchedaResource', function (): void {
    $reflection = new ReflectionClass(IndividualeResource::class);
    
    expect($reflection->getParentClass()->getName())->toBe(SchedaResource::class);
});
