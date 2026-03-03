<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests;

use Modules\Meetup\Providers\MeetupServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Meetup module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 */
abstract class TestCase extends XotBaseTestCase
{
    /** @var array<int, string> */
    protected $connectionsToTransact = [
        'mysql',
        'user',
    ];

    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            MeetupServiceProvider::class,
        ];
    }
}
