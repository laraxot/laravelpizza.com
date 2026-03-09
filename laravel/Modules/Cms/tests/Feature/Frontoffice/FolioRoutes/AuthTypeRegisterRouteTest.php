<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('SKIP dynamic /it/auth/{type}/register', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->markTestSkipped('Dynamic type route requires fixture.');
});
