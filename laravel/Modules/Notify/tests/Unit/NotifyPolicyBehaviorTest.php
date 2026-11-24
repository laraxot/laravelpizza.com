<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Mockery;
use Modules\Notify\Models\Policies\ContactPolicy;
use Modules\Notify\Models\Policies\MailTemplatePolicy;
use Modules\Notify\Models\Policies\NotificationPolicy;
use Modules\Notify\Models\Policies\NotificationTemplatePolicy;
use Modules\Notify\Tests\Fixtures\NotifyPolicyBehaviorConcretePolicy;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
/**
 * @param  list<string>  $roles
 * @return Mockery\MockInterface&UserContract
 */
function notifyBehaviorUser(array $roles = []): UserContract
{
    /** @var Mockery\MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    TestCase::mockExpectation($user, 'hasRole')
        ->andReturnUsing(static function (array|string $richiesti) use ($roles): bool {
            /** @var list<string> $normalizzati */
            $normalizzati = is_array($richiesti) ? $richiesti : [$richiesti];

            return array_intersect($normalizzati, $roles) !== [];
        });
    TestCase::mockExpectation($user, 'hasPermissionTo')->andReturn(false);

    return $user;
}

afterEach(function (): void {
    Mockery::close();
});

test('NotifyBasePolicy before: super-admin bypass, altri passano a viewAny false', function (): void {
    $policy = new NotifyPolicyBehaviorConcretePolicy;
    $super = notifyBehaviorUser(['super-admin']);
    Assert::assertTrue($policy->before($super, 'viewAny'));

    $normal = notifyBehaviorUser();
    Assert::assertNull($policy->before($normal, 'viewAny'));
    Assert::assertFalse($policy->viewAny($normal));
});

test('policy Notify vuote ereditano before super-admin da XotBasePolicy', function (): void {
    foreach ([
        new ContactPolicy,
        new NotificationPolicy,
        new MailTemplatePolicy,
        new NotificationTemplatePolicy] as $policy) {
        Assert::assertTrue($policy->before(notifyBehaviorUser(['super-admin']), 'viewAny'));
        Assert::assertNull($policy->before(notifyBehaviorUser(), 'viewAny'));
    }
});
