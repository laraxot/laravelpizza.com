<?php

declare(strict_types=1);

use Modules\Gdpr\Models\Profile;
use Modules\Gdpr\Models\Treatment;
use PHPUnit\Framework\Assert;

it('verifica che le classi corrette siano istanziabili', function (): void {
    $treatment = new Treatment();
    $profile = new Profile();
    Assert::assertSame('treatments', $treatment->getTable());
    Assert::assertSame('profiles', $profile->getTable());
});

it('verifica che le proprietà delle classi siano accessibili', function (): void {
    $treatment = new Treatment();
    $profile = new Profile();

    Assert::assertIsArray($treatment->getFillable());
    Assert::assertIsArray($profile->getFillable());
    Assert::assertSame('gdpr', $profile->getConnectionName());
});
