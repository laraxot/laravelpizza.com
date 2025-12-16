<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Feature;

use Modules\Gdpr\Models\Profile;
use Modules\Gdpr\Models\Treatment;

it('verifica che le classi corrette siano istanziabili', function (): void {
    expect(new Treatment)->toBeInstanceOf(Treatment::class);
    expect(new Profile)->toBeInstanceOf(Profile::class);
});

it('verifica che le proprietà delle classi siano accessibili', function (): void {
    $treatment = new Treatment;
    $profile = new Profile;

    // Verifica che le proprietà fillable siano definite
    expect($treatment->getFillable())->toBeArray();
    expect($profile->getFillable())->toBeArray();

    // Verifica che la connessione al database sia definita correttamente
    expect($profile->getConnectionName())->toBe('gdpr');
});
