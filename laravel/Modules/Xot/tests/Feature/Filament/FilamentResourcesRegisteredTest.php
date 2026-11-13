<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

test('le risorse filament sono registrate correttamente', function (): void {
    $resources = Filament::getResources();

    expect($resources)->not->toBeEmpty();
});
