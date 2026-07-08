<?php

declare(strict_types=1);

use Modules\Ptv\Models\Profile;
use PHPUnit\Framework\Assert;

/**
 * @param array{first_name?: string|null, last_name?: string|null, ente?: int|null, matr?: int|null, user_id?: int|string|null} $attributes
 */
function makePtvProfileForTest(array $attributes = []): Profile
{
    return new Profile(array_merge([
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'ente' => 1,
        'matr' => 12345,
        'user_id' => 'user-123',
    ], $attributes));
}

describe('Profile model', function (): void {
    it('uses the ptv connection', function (): void {
        Assert::assertSame('ptv', makePtvProfileForTest()->getConnectionName());
    });

    it('exposes the fillable employee attributes', function (): void {
        Assert::assertSame(
            ['first_name', 'last_name', 'ente', 'matr', 'user_id'],
            makePtvProfileForTest()->getFillable(),
        );
    });

    it('keeps core employee data on the model', function (): void {
        $profile = makePtvProfileForTest([
            'first_name' => 'Giuseppe',
            'last_name' => 'Verdi',
            'ente' => 2,
            'matr' => 67890,
            'user_id' => 456,
        ]);

        Assert::assertSame('Giuseppe', $profile->first_name);
        Assert::assertSame('Verdi', $profile->last_name);
        Assert::assertSame(2, $profile->ente);
        Assert::assertSame(67890, $profile->matr);
        Assert::assertSame('456', $profile->user_id);
    });
});
