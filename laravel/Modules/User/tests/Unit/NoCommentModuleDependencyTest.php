<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Modules\User\Tests\TestCase;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;

uses(TestCase::class);

test('base user model does not use comment traits', function (): void {
    $baseUserPath = dirname(__DIR__, 2).'/app/Models/BaseUser.php';
    $contents = file_get_contents($baseUserPath);

    expect($contents)
        ->not()->toContain('HasCommentatorRelations')
        ->not()->toContain('CanComment')
        ->not()->toContain('InteractsWithComments');
});

test('user composer does not reference the comment module', function (): void {
    $composerPath = dirname(__DIR__, 2).'/composer.json';
    $contents = file_get_contents($composerPath);

    expect($contents)->not()->toContain('"../Comment"');
});

test('user app code does not import the comment module', function (): void {
    $appPath = dirname(__DIR__, 2).'/app';
    $files = Finder::create()->in($appPath)->files()->name('*.php');

    foreach ($files as $file) {
        expect(file_get_contents($file->getPathname()))->not()->toContain('Modules\\Comment\\');
    }
});
