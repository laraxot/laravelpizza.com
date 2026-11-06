<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Modules\Cms\Actions\Head\CollapsePathSegmentsAction;
use PHPUnit\Framework\Assert;

test('a path is reduced to the form the router serves', function (string $path, string $expected): void {
    Assert::assertSame($expected, (new CollapsePathSegmentsAction())->execute($path), $path);
})->with([
    'already clean' => ['it/faq', 'it/faq'],
    'leading and trailing slashes' => ['/it/faq/', 'it/faq'],
    'double slashes' => ['/it//faq', 'it/faq'],
    'dot segments' => ['/it/./faq', 'it/faq'],
    'parent segment' => ['/it/blog/../faq', 'it/faq'],
    'parent above the root is ignored' => ['/../it', 'it'],
    'only the root' => ['/', ''],
    'empty' => ['', ''],
    'dots inside a name are kept' => ['/it/file.name/.hidden', 'it/file.name/.hidden'],
]);

test('segments come back as a list in path order', function (): void {
    Assert::assertSame(['it', 'auth', 'login'], (new CollapsePathSegmentsAction())->segments('/it/./x/../auth//login/'));
});
