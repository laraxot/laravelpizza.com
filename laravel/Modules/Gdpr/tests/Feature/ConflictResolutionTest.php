<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

uses(TestCase::class);

use Modules\Gdpr\Models\Profile;
use Modules\Gdpr\Models\Treatment;
use Modules\Gdpr\Tests\TestCase;

uses(TestCase::class);

it('verifica che le classi corrette siano istanziabili', function (): void {
    expect(new Treatment())->toBeInstanceOf(Treatment::class);
    expect(new Profile())->toBeInstanceOf(Profile::class);
});

it('verifica che le proprietà delle classi siano accessibili', function (): void {
    $treatment = new Treatment();
    $profile = new Profile();

    expect($treatment->getFillable())->toBeArray();
    expect($profile->getFillable())->toBeArray();

    expect($profile->getConnectionName())->toBe('gdpr');
});
