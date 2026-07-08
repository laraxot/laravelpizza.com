<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Feature;

use Modules\Rating\Models\Rating;
use Modules\Rating\Tests\TestCase;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Rating\Tests\TestCase $this */
    skip('Rating HTTP API routes are not registered in this install (Folio/Actions architecture).');
});

describe('Rating Api', function (): void {
    test('can list ratings', function (): void {
        /* @var \Modules\Rating\Tests\TestCase $this */
        Rating::create([
            'name' => 'Test Rating 1',
        ]);

        Rating::create([
            'name' => 'Test Rating 2',
        ]);

        $response = getJson('/api/ratings');

        Assert::assertSame(200, $response->status());
        $response->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    });

    test('can create rating', function (): void {
        $data = [
            'name' => 'New Rating',
            'color' => '#00FF00',
        ];

        $response = postJson('/api/ratings', $data);

        Assert::assertSame(201, $response->status());
        $response->assertJson([
            'data' => [
                'name' => 'New Rating',
            ],
        ]);
    });

    test('can update rating', function (): void {
        $rating = Rating::create([
            'name' => 'Test Rating',
        ]);

        $data = [
            'name' => 'Updated Rating',
        ];

        $response = putJson("/api/ratings/{$rating->id}", $data);

        Assert::assertSame(200, $response->status());
        $response->assertJson([
            'data' => [
                'name' => 'Updated Rating',
            ],
        ]);
    });

    test('can delete rating', function (): void {
        $rating = Rating::create([
            'name' => 'Test Rating',
        ]);

        $response = deleteJson("/api/ratings/{$rating->id}");

        Assert::assertSame(204, $response->status());
        /* @var TestCase $this */
        $this->assertDatabaseMissingRow('ratings', ['id' => $rating->id]);
    });

    test('can rate model', function (): void {
        $rating = Rating::create([
            'name' => 'Test Rating',
        ]);

        $data = [
            'model_type' => 'test_model',
            'model_id' => 1,
            'value' => 4.5,
            'note' => 'Great!',
        ];

        $response = postJson("/api/ratings/{$rating->id}/rate", $data);

        Assert::assertSame(201, $response->status());
        $response->assertJson([
            'data' => [
                'rating_id' => $rating->id,
                'value' => 4.5,
                'note' => 'Great!',
            ],
        ]);
    });
});
