<?php

declare(strict_types=1);

use Modules\Ptv\Models\Profile;
use Modules\Ptv\Models\Scheda;
use Modules\Ptv\Models\StabiDirigente;
use PHPUnit\Framework\Assert;

test('ptv business tests reference existing domain models', function (): void {
    Assert::assertTrue(class_exists(Profile::class));
    Assert::assertTrue(class_exists(Scheda::class));
    Assert::assertTrue(class_exists(StabiDirigente::class));
});

test('profile keeps core employee attributes on the ptv model', function (): void {
    $profile = new Profile([
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'ente' => 1,
        'matr' => 12345,
        'user_id' => 123,
    ]);

    Assert::assertSame('Mario', $profile->first_name);
    Assert::assertSame('Rossi', $profile->last_name);
    Assert::assertSame(1, $profile->ente);
    Assert::assertSame(12345, $profile->matr);
    Assert::assertSame('123', $profile->user_id);
});
