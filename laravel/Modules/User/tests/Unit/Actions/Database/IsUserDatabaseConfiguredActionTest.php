<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Modules\User\Actions\Database\IsUserDatabaseConfiguredAction;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('the user database is configured when the connection has a database name', function (): void {
    Config::set('database.connections.user.database', 'predict_user');

    Assert::assertTrue(app(IsUserDatabaseConfiguredAction::class)->execute());
});

test('the user database is not configured when the database name is missing or blank', function (?string $database): void {
    Config::set('database.connections.user.database', $database);

    Assert::assertFalse(app(IsUserDatabaseConfiguredAction::class)->execute());
})->with([
    'missing' => [null],
    'empty' => [''],
    'blank' => ['   '],
]);
