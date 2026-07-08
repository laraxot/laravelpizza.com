<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Ptv\Models\Profile;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

uses(
    TestCase::class,
    DatabaseTransactions::class,
    WithFaker::class,
)->in('Feature', 'Unit');

uses()->group('ptv')->in('Feature', 'Unit');

expect()->extend('toBeProfile', fn () => $this->toBeInstanceOf(Profile::class));

expect()->extend('toHaveProperty', function (string $property): void {
    /** @var object|null $value */
    $value = $this->value;
    Assert::assertNotNull($value);
    Assert::assertObjectHasProperty($property, $value);
});

/**
 * @param array{first_name?: string|null, last_name?: string|null, ente?: int|null, matr?: int|null, user_id?: int|string|null} $attributes
 */
function createProfile(array $attributes = []): Profile
{
    return new Profile($attributes);
}

/**
 * @param array{first_name?: string|null, last_name?: string|null, ente?: int|null, matr?: int|null, user_id?: int|string|null} $attributes
 */
function makeProfile(array $attributes = []): Profile
{
    return new Profile($attributes);
}
