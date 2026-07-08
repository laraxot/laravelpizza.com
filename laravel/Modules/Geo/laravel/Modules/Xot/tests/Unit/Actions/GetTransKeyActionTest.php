<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\GetTransKeyAction;
use PHPUnit\Framework\Assert;

it('generates translation keys correctly', function (): void {
    $action = app(GetTransKeyAction::class);

    // Test with Action suffix
    $key = $action->execute('Modules\Activity\Actions\LogActivityAction');
    Assert::assertSame('activity::log_activity', $key);
    // Test with RelationManager
    $key = $action->execute('Modules\User\Filament\Resources\UserResource\RelationManagers\ProfilesRelationManager');
    Assert::assertSame('user::profile', $key);
});
