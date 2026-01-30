<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;

pest()->extend(TestCase::class)
    ->in(__DIR__.'/Feature', __DIR__.'/Unit');
