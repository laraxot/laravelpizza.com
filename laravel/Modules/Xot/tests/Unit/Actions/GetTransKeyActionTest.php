<?php

declare(strict_types=1);
use Modules\Xot\Actions\GetTransKeyAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('generates translation keys correctly', function (): void {
    $action = app(GetTransKeyAction::class);

    // Test with Action suffix
    $key = $action->execute('Modules\Activity\Actions\LogActivityAction');
    Assert::assertSame('activity::log_activity', $key);
    // Test with RelationManager
    $key = $action->execute('Modules\User\Filament\Resources\UserResource\RelationManagers\ProfilesRelationManager');
    Assert::assertSame('user::profile', $key);
});
