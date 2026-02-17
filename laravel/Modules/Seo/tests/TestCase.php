<?php

declare(strict_types=1);

namespace Modules\Seo\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Seo module.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected $connectionsToTransact = [
        'mysql',
        'seo',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'Seo']);

        // Ensure Seo config is loaded/set if needed for tests
        // config(['seo.default_title' => 'Test Site']);
    }
}
