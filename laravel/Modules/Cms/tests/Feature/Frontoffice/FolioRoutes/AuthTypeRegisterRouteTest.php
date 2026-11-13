<?php

declare(strict_types=1);

uses(\Modules\Cms\Tests\TestCase::class);

it('SKIP dynamic /it/auth/{type}/register', function (): void {
    $this->markTestSkipped('Dynamic type route requires fixture.');
});
