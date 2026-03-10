<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\Notify\Tests\Unit\Models\Policies;

=======
>>>>>>> 8e583cd (.)
use Modules\Notify\Models\Policies\MailTemplatePolicy;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

test('mail template policy denies view any', function () {
    $policy = new MailTemplatePolicy();
    $user = \Mockery::mock(UserContract::class);

    expect($policy->viewAny($user))->toBeFalse();
});
