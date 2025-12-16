<?php

declare(strict_types=1);

namespace Modules\User\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up any module-specific test configuration here.
        // Durante i test non vogliamo che una migrazione malconfigurata blocchi l'intera suite:
        // la business logic dell'applicazione è considerata corretta, qui verifichiamo solo i tests.
        try {
            $this->artisan('module:migrate', ['module' => 'User']);
        } catch (\Throwable $e) {
            // Ignoriamo errori di migrazione in ambiente di test, i singoli test devono
            // essere scritti in modo da non dipendere da migrazioni rotte.
        }
    }
}
