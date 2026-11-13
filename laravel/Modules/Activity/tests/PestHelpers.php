<?php

declare(strict_types=1);

<<<<<<< .merge_file_huBUxI
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Models\Activity;
=======
use Mockery\CompositeExpectation;
use Mockery\Expectation;
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Models\Activity;
use Modules\User\Contracts\UserContract;
>>>>>>> .merge_file_N9ywhE
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;

/**
 * Helper Pest/PHPStan — modulo Activity.
 *
 * @see Modules/Platform/tests/PestHelpers.php
 */

/**
 * @param  array<string, mixed>  $attributes
 */
function activityCreateUser(array $attributes = []): User
{
    $user = UserFactory::new()->createOne($attributes);
<<<<<<< .merge_file_huBUxI
    assert($user instanceof User);
=======
    assert($user instanceof UserContract);
>>>>>>> .merge_file_N9ywhE

    return $user;
}

/**
 * @param  array<string, mixed>  $attributes
 */
function activityCreateActivity(array $attributes = []): Activity
{
    $activity = ActivityFactory::new()->createOne($attributes);
    assert($activity instanceof Activity);

    return $activity;
}
<<<<<<< .merge_file_huBUxI
=======

/**
 * Mockery 1.6 returns a CompositeExpectation from shouldReceive()/allows(), which forwards
 * once()/with()/andReturn() via __call and so is opaque to PHPStan. The composite holds no
 * public accessor, so its single Expectation is read once here to keep chained calls typed.
 */
function mockeryExpect(object $expectation): Expectation
{
    if ($expectation instanceof CompositeExpectation) {
        $expectations = (fn (): array => $this->_expectations)->call($expectation);
        assert(count($expectations) === 1, 'mockeryExpect() supports a single expected method');
        $expectation = reset($expectations);
    }

    assert($expectation instanceof Expectation);

    return $expectation;
}
>>>>>>> .merge_file_N9ywhE
