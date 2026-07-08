<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    if (! userTableExists('activity_log')) {
        pestSkip('activity_log table missing on sqlite test database.');
    }
});

test('it logs registration with default properties', function (): void {
    $user = new User(['type' => 'customer_user']);
    $user->forceFill(['id' => 1]);

    $before = DB::connection('user')->table('activity_log')->count();

    $action = new LogRegistrationAction();
    $action->execute($user);

    Assert::assertSame($before + 1, DB::connection('user')->table('activity_log')->count());
});

test('it logs registration with custom properties', function (): void {
    $user = new User(['type' => 'premium']);
    $user->forceFill(['id' => 2]);

    $action = new LogRegistrationAction();
    $action->execute($user, ['referral' => 'newsletter', 'source' => 'landing']);

    $row = DB::connection('user')->table('activity_log')->orderByDesc('id')->first();
    Assert::assertNotNull($row);
    Assert::assertStringContainsString((string) 'newsletter', (string) (string) $row->properties);
});

test('it logs registration with different user types', function (): void {
    $customerUser = new User(['type' => 'customer_user']);
    $customerUser->forceFill(['id' => 3]);

    $adminUser = new User(['type' => 'admin']);
    $adminUser->forceFill(['id' => 4]);

    $action = new LogRegistrationAction();

    $before = DB::connection('user')->table('activity_log')->count();

    $action->execute($customerUser);
    $action->execute($adminUser);

    Assert::assertSame($before + 2, DB::connection('user')->table('activity_log')->count());
});
