<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('SKIP dynamic /it/auth/password/{token}', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->markTestSkipped('Dynamic token route requires fixture.');
});
