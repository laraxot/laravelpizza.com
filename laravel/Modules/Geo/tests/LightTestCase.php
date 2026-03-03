<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Lightweight application test case for facade/container tests that do not need DB transactions.
 */
abstract class LightTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);

        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);
    }
}
